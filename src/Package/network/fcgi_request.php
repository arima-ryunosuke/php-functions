<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_find_recursive.php';
require_once __DIR__ . '/../array/array_sprintf.php';
require_once __DIR__ . '/../errorfunc/set_error_exception_handler.php';
require_once __DIR__ . '/../url/formdata_build.php';
require_once __DIR__ . '/../url/uri_parse.php';
// @codeCoverageIgnoreEnd

/**
 * FastCGI リクエストを行う
 *
 * ※ 完全に特定用途向けで普通の使い方は想定していない
 *
 * できるだけ http に似せたかったので $url からある程度 $params を推測して自動設定する。
 * - TCP: tcp://localhost:9000/path/to/script?a=A
 * - UDS: unix://run%2Fphp-fpm%2Fwww.sock/path/to/script?a=A
 *   - とても気持ち悪いので UDS ファイルは $options で渡すこともできる
 *   - unix:///path/to/script?a=A ($options:['udsFile' => '/run/php-fpm/www.sock'])
 * 上記で SCRIPT_FILENAME, QUERY_STRING が設定される。
 * $stdin を指定すると REQUEST_METHOD, CONTENT_LENGTH 等も設定される。
 * $stdin は配列を渡すとよしなに扱われる。
 *
 * $params の自動設定は明示指定を決して上書きしない。
 * ただし null だけは上書きするので自動設定の明示に使える。
 *
 * 「任意のホスト（http ではないのでドメイン（≒Host ヘッダ））」に「ドキュメントルートと無関係」に「fpm のコンテキストで実行」できることがほぼ唯一のメリット。
 * 要するに cli から fpm の opcache を温めたいような限定的なケースでしか使わないし使うべきでない。
 *
 * @package ryunosuke\Functions\Package\network
 */
function fcgi_request(
    /** URL */ string $url,
    /** FCGI パラメータ */ array $params = [],
    /** FCGI ボディ */ iterable|string $stdin = '',
    /** その他のオプション */ array $options = [],
): /** FCGI レスポンス */ array
{
    $options += [
        'keepAlive'      => false, // デストラクタで閉じてるので実質的に意味なし
        'connectTimeout' => 10.0,
        'socketTimeout'  => 60.0,
        'udsFile'        => '/run/php-fpm/www.sock',
        'fpmConf'        => '/etc/php-fpm.d/www.conf',
        'debug'          => false, // デバッグ用に Client そのものを返す
    ];

    $parts = uri_parse($url, [
        'host' => null,
        'port' => null,
    ]);

    // scheme が無い場合は fpm の conf ファイルから推測する
    if ($parts['scheme'] === '' && is_readable($options['fpmConf'])) {
        if (strlen($listen = parse_ini_file($options['fpmConf'])['listen'] ?? '')) {
            // UDS モード（本来なら stat で is_socket みたいにした方がいいけどそこまで厳密には不要だろう）
            if (is_readable($listen)) {
                $parts['scheme'] = 'unix';
                $parts['host'] ??= $listen;
            }
            // TCP モード
            else {
                [$host, $port] = array_pad(explode(':', $listen), -2, null);
                $parts['scheme'] = 'tcp';
                $parts['host'] ??= ($host === '0.0.0.0' ? null : $host) ?? '127.0.0.1';
                $parts['port'] ??= $port;
            }
        }
    }
    // unix domain socket はホスト名部分をソケットファイル名とみなす（要 urldecode）
    elseif ($parts['scheme'] === 'unix') {
        $parts['host'] = strlen($parts['host'] ?? '') ? '/' . rawurldecode($parts['host']) : $options['udsFile'];
    }

    // path は実行スクリプトとみなす
    if (strlen($parts['path'])) {
        $params['SCRIPT_FILENAME'] ??= $parts['path'];
    }
    // query はそのままクエリストリングとして使える
    if ($parts['query']) {
        $params['QUERY_STRING'] ??= http_build_query($parts['query']);
    }

    // リクエスト本文が配列ならよしなにする
    if (is_iterable($stdin)) {
        if (is_array($stdin)) {
            if (($params['CONTENT_TYPE'] ?? '') === 'multipart/form-data' || array_find_recursive($stdin, fn($v) => $v instanceof \SplFileInfo)) {
                $stdin = formdata_build($stdin, $boundary);
                $params['CONTENT_TYPE'] ??= "multipart/form-data; boundary=$boundary";
            }
            else {
                $stdin = http_build_query($stdin);
                $params['CONTENT_TYPE'] ??= "application/x-www-form-urlencoded";
            }
        }
        else {
            $stdin = formdata_build($stdin, $boundary);
            $params['CONTENT_TYPE'] ??= "multipart/form-data; boundary=$boundary";
        }
    }
    // $stdin が来てるならある程度決め打ちできる
    if ($stdin || strlen($stdin)) {
        $params['REQUEST_METHOD'] ??= 'POST';
        if (is_string($stdin)) {
            $params['CONTENT_LENGTH'] ??= strlen($stdin);
        }
        if ($stdin instanceof \Countable) {
            $params['CONTENT_LENGTH'] ??= count($stdin);
        }
    }

    // 完全なるデフォルト値で埋めて null フィルタ
    $params['REQUEST_METHOD'] ??= 'GET';
    $params['QUERY_STRING'] ??= '';
    $params['GATEWAY_INTERFACE'] ??= 'CGI/1.1';
    $params = array_filter($params, fn($v) => $v !== null);

    $client = new class("{$parts['scheme']}://{$parts['host']}" . ($parts['port'] ? ":{$parts['port']}" : ''), $options['connectTimeout'], $options['socketTimeout']) {
        const FCGI_VERSION_1 = 1;

        const FCGI_HEADER_LEN = 8;
        const FCGI_KEEP_CONN  = 1;

        const FCGI_BEGIN_REQUEST = 1;
        const FCGI_ABORT_REQUEST = 2;
        const FCGI_END_REQUEST   = 3;
        const FCGI_PARAMS        = 4;
        const FCGI_STDIN         = 5;
        const FCGI_STDOUT        = 6;
        const FCGI_STDERR        = 7;
        const FCGI_DATA          = 8;

        const FCGI_RESPONDER  = 1;
        const FCGI_AUTHORIZER = 2;
        const FCGI_FILTER     = 3;

        const FCGI_REQUEST_COMPLETE = 0;
        const FCGI_CANT_MPX_CONN    = 1;
        const FCGI_OVERLOADED       = 2;
        const FCGI_UNKNOWN_ROLE     = 3;

        const BEGIN_REQUEST_FORMAT = [
            'role'      => 'n',
            'flags'     => 'c',
            'reserved0' => 'c',
            'reserved1' => 'c',
            'reserved2' => 'c',
            'reserved3' => 'c',
            'reserved4' => 'c',
        ];

        const END_REQUEST_FORMAT = [
            'appStatus'      => 'N',
            'protocolStatus' => 'c',
            'reserved0'      => 'c',
            'reserved1'      => 'c',
            'reserved2'      => 'c',
        ];

        const RECORD_FORMAT = [
            'version'       => 'c',
            'type'          => 'c',
            'requestId'     => 'n',
            'contentLength' => 'n',
            'paddingLength' => 'c',
            'reserved'      => 'c',
        ];

        private $socket;

        public function __construct(
            private string $address,
            private float $connectTimeout,
            private float $socketTimeout,
        ) {
        }

        public function open()
        {
            $this->socket = stream_socket_client($this->address, $errno, $errstr, $this->connectTimeout);
            stream_set_timeout($this->socket, (int) $this->socketTimeout, fmod($this->socketTimeout, 1) * 1000 * 1000);
        }

        public function close()
        {
            if ($this->socket) {
                fclose($this->socket);
                unset($this->socket);
            }
        }

        private function split(string|iterable $content, int $chunk): \Generator
        {
            if (is_string($content)) {
                if (!strlen($content)) {
                    yield '';
                    return;
                }
                // str_split だと配列化されて瞬間的にメモリ使用量が倍増するので素朴に yield する
                // yield from str_split($content, $chunk) ?: [""];
                for ($offset = 0; $offset < strlen($content); $offset += $chunk) {
                    yield substr($content, $offset, $chunk);
                }
            }
            else {
                $empty = true;
                $buffer = '';
                foreach ($content as $part) {
                    $empty = false;
                    $buffer .= $part;
                    if (strlen($buffer) >= $chunk) {
                        yield substr($buffer, 0, $chunk);
                        $buffer = substr($buffer, $chunk);
                    }
                }
                if ($empty || strlen($buffer)) {
                    yield $buffer;
                }
            }
        }

        private function write(int $type, string|iterable $content, int $requestId = 1)
        {
            // https://fastcgi-archives.github.io/FastCGI_Specification.html#S3.3
            foreach ($this->split($content, 0xFFFF) as $chunk) {
                $fcgi_header = pack(implode('', self::RECORD_FORMAT), self::FCGI_VERSION_1, $type, $requestId, strlen($chunk), ...[0, 0]) . $chunk;
                fwrite($this->socket, $fcgi_header) === strlen($fcgi_header) or throw new \RuntimeException('failed to fwrite');
            }

            fflush($this->socket);
        }

        private function read()
        {
            // https://fastcgi-archives.github.io/FastCGI_Specification.html#S3.3
            strlen($fcgi_header = fread($this->socket, self::FCGI_HEADER_LEN)) === self::FCGI_HEADER_LEN or throw new \RuntimeException('failed to fread');
            $record = unpack(array_sprintf(self::RECORD_FORMAT, '%s%s', '/'), $fcgi_header);

            $record['content'] = stream_get_contents($this->socket, $record['contentLength']);

            stream_get_contents($this->socket, $record['paddingLength']);
            return $record;
        }

        public function beginRequest(int $flags)
        {
            // https://fastcgi-archives.github.io/FastCGI_Specification.html#S5.1
            $fcgi_begin_request_body = pack(implode('', self::BEGIN_REQUEST_FORMAT), self::FCGI_RESPONDER, $flags, ...[0, 0, 0, 0, 0]);
            $this->write(self::FCGI_BEGIN_REQUEST, $fcgi_begin_request_body);
        }

        public function writeParams(array $params)
        {
            // https://fastcgi-archives.github.io/FastCGI_Specification.html#S3.4
            if ($params) {
                $this->write(self::FCGI_PARAMS, array_sprintf($params, function ($v, $k) {
                    $kpacket = pack(strlen($k) < 128 ? 'c' : 'N', strlen($k) | 0x80000000);
                    $vpacket = pack(strlen($v) < 128 ? 'c' : 'N', strlen($v) | 0x80000000);
                    return $kpacket . $vpacket . $k . $v;
                }, ''));
            }
            $this->write(self::FCGI_PARAMS, '');
        }

        public function writeStdin(string|iterable $stdin)
        {
            // https://fastcgi-archives.github.io/FastCGI_Specification.html#S5.3
            if ($stdin || strlen($stdin)) {
                $this->write(self::FCGI_STDIN, $stdin);
            }
            $this->write(self::FCGI_STDIN, '');
        }

        public function endRequest()
        {
            $response = [
                'appStatus' => null,
                'stdout'    => '',
                'stderr'    => '',
            ];
            while ($record = $this->read()) {
                switch ($record['type']) {
                    case self::FCGI_STDOUT:
                        $response['stdout'] .= $record['content'];
                        break;
                    // @codeCoverageIgnoreStart
                    case self::FCGI_STDERR:
                        $response['stderr'] .= $record['content'];
                        break;
                    // @codeCoverageIgnoreEnd
                    case self::FCGI_END_REQUEST:
                        $status = unpack(array_sprintf(self::END_REQUEST_FORMAT, '%s%s', '/'), $record['content']);
                        if ($status['protocolStatus'] !== self::FCGI_REQUEST_COMPLETE) {
                            throw new \RuntimeException('protocolStatus was returned other than REQUEST_COMPLETE'); // @codeCoverageIgnore
                        }
                        $response['appStatus'] = $status['appStatus'];
                        break 2;
                }
            }
            return $response;
        }
    };

    if ($options['debug']) {
        return [
            'client' => $client,
            'params' => $params,
            'stdin'  => $stdin,
        ];
    }

    $restore = set_error_exception_handler();
    try {
        $client->open();
        $client->beginRequest($options['keepAlive'] ? $client::FCGI_KEEP_CONN : 0);
        $client->writeParams($params);
        $client->writeStdin($stdin);
        return $client->endRequest();
    }
    finally {
        $restore();
        $client->close();
    }
}
