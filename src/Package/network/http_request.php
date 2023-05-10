<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_flatten.php';
require_once __DIR__ . '/../array/array_kvmap.php';
require_once __DIR__ . '/../array/array_sprintf.php';
require_once __DIR__ . '/../dataformat/json_export.php';
require_once __DIR__ . '/../dataformat/json_import.php';
require_once __DIR__ . '/../filesystem/file_set_contents.php';
require_once __DIR__ . '/../strings/split_noempty.php';
require_once __DIR__ . '/../strings/str_array.php';
require_once __DIR__ . '/../strings/str_chunk.php';
// @codeCoverageIgnoreEnd

/**
 * curl のラッパー関数
 *
 * curl は高機能だけど、低レベルで設定が細かすぎる上に似たようなものが大量にあるので素で書くのが割とつらい。
 * のでデフォルトをスタンダードな設定に寄せつつ、多少便利になるようにラップしている。
 * まぁ現在では guzzle みたいなクライアントも整ってるし、使い捨てスクリプトでサクッとリクエストを投げたい時用。
 *
 * 生 curl との差異は下記。
 *
 * - `CURLOPT_HTTPHEADER` は連想配列指定が可能
 * - `CURLOPT_POSTFIELDS` は連想配列・多次元配列指定が可能
 * - 単一ファイル指定は単一アップロードになる
 *
 * さらに独自のオプションとして下記がある。
 *
 * - `raw` (bool): curl インスタンスと変換クロージャを返すだけになる
 *     - ただし、ほぼデバッグや内部用なので指定することはほぼ無いはず
 * - `nobody` (bool): ヘッダーの受信が完了したらただちに処理を返す
 *     - ボディは空文字になる（CURLOPT_NOBODY とは全く性質が異なるので注意）
 * - `throw` (bool): ステータスコードが 400 以上のときに例外を投げる
 *     - `CURLOPT_FAILONERROR` は原則使わないほうがいいと思う
 * - `retry` (float[]|callable): エラーが出た場合にリトライする
 *     - 配列で指定した回数・秒数のリトライを行う（[1, 2, 3] で、1秒後、2秒後、3秒後になる）
 *     - callable を指定するとその callable が false を返すまでリトライする（引数として curl_info が渡ってきて待機秒数を返す）
 * - `atfile` (bool): キーに @ があるフィールドをファイルアップロードとみなす
 *     - 悪しき `CURLOPT_SAFE_UPLOAD` の代替。ただし値ではなくキーで判別する
 *     - 値が配列のフィールドのキーに @ をつけると連番要素のみアップロードになる
 * - `cachedir` (string): GET のときにクライアントキャッシュや 304 キャッシュが効くようになる
 *     - Cache-Control の private, public は見ないので一応注意
 * - `parser` (array): Content-Type に基づいて body をパースする
 *     - 今のところ application/json のみ
 *
 * また、頻出するオプションは下記の定数のエイリアスがあり、単純に読み替えられる。
 *
 * - `url`: `CURLOPT_URL`
 * - `method`: `CURLOPT_CUSTOMREQUEST`
 * - `cookie`: `CURLOPT_COOKIE`
 * - `header`: `CURLOPT_HTTPHEADER`
 * - `body`: `CURLOPT_POSTFIELDS`
 * - `cookie_file`: `CURLOPT_COOKIEJAR`, `CURLOPT_COOKIEFILE`
 *
 * Example:
 * ```php
 * $response = http_request([
 *     'url'    => TESTWEBSERVER . '/post?name=value',
 *     'method' => 'POST',
 *     'body'   => ['k1' => 'v1', 'k2' => 'v2'],
 * ]);
 * that($response['args'])->is([
 *     'name' => 'value',
 * ]);
 * that($response['form'])->is([
 *     'k1' => 'v1',
 *     'k2' => 'v2',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 *
 * @param array $options curl_setopt_array に渡される
 * @param array $response_header レスポンスヘッダが連想配列で格納される
 * @param array $info curl_getinfo が格納される
 * @return mixed レスポンスボディ
 */
function http_request($options = [], &$response_header = [], &$info = [])
{
    $options += [
        // curl options
        CURLOPT_CUSTOMREQUEST  => 'GET', // リクエストメソッド
        CURLINFO_HEADER_OUT    => true,  // リクエストヘッダを含める
        CURLOPT_HTTPHEADER     => [],    // リクエストヘッダ
        CURLOPT_COOKIE         => null,  // リクエストクッキー
        CURLOPT_POSTFIELDS     => null,  // リクエストボディ
        CURLOPT_NOBODY         => false, // HEAD 用
        CURLOPT_ENCODING       => "",    // Accept-Encoding 兼自動展開
        CURLOPT_FOLLOWLOCATION => true,  // リダイレクトをたどる
        CURLOPT_MAXREDIRS      => 16,    // リダイレクトをたどる回数
        CURLOPT_RETURNTRANSFER => true,  // 戻り値として返す
        CURLOPT_HEADER         => true,  // レスポンスヘッダを含める
        CURLOPT_CONNECTTIMEOUT => 60,    // timeout on connect
        CURLOPT_TIMEOUT        => 60,    // timeout on response

        // alias option
        'url'                  => null,
        'method'               => null,
        'cookie'               => null,
        'header'               => null,
        'body'                 => null,
        'cookie_file'          => null,

        // custom options
        'raw'                  => false,
        'nobody'               => false,
        'throw'                => true,
        'retry'                => [],
        'atfile'               => true,
        'cachedir'             => null,
        'parser'               => [
            'application/json' => [
                'request'  => fn($contents) => json_export($contents),
                'response' => fn($contents) => json_import($contents),
            ],
        ],
    ];

    // 利便性用の定数エイリアス
    $options[CURLOPT_URL] = $options['url'] ?? $options[CURLOPT_URL];
    $options[CURLOPT_CUSTOMREQUEST] = $options['method'] ?? $options[CURLOPT_CUSTOMREQUEST];
    $options[CURLOPT_COOKIE] = $options['cookie'] ?? $options[CURLOPT_COOKIE];
    $options[CURLOPT_HTTPHEADER] = $options['header'] ?? $options[CURLOPT_HTTPHEADER];
    $options[CURLOPT_POSTFIELDS] = $options['body'] ?? $options[CURLOPT_POSTFIELDS];
    if (isset($options['cookie_file'])) {
        $options[CURLOPT_COOKIEJAR] = $options['cookie_file'];
        $options[CURLOPT_COOKIEFILE] = $options['cookie_file'];
    }
    if ($options['nobody']) {
        $headers = '';
        $options[CURLOPT_HEADERFUNCTION] = function ($curl, $header) use (&$headers) {
            if (trim($header) === '') {
                return -1;
            }
            $headers .= $header;
            return strlen($header);
        };
    }

    // ヘッダは後段の判定に頻出するので正規化して取得しておく
    $request_header = array_kvmap($options[CURLOPT_HTTPHEADER], function ($k, $v) {
        if (is_int($k)) {
            [$k, $v] = explode(':', $v, 2);
        }
        return [strtolower(trim($k)) => trim($v)];
    });

    // request body 変換
    $content_type = split_noempty(';', $request_header['content-type'] ?? '');
    if ($convert = ($options['parser'][strtolower($content_type[0] ?? '')]['request'] ?? null)) {
        $options[CURLOPT_POSTFIELDS] = $convert($options[CURLOPT_POSTFIELDS], ...$content_type);
    }

    // response クロージャ
    $response_parse = function ($response, $info) use ($options) {
        [$head, $body] = str_chunk($response, $info['header_size']);

        $head = str_array($head, ':', true);
        $info['no_request'] = false;
        $info['response_size'] = strlen($response);
        $info['content_type'] = $info['content_type'] ?? null;
        $info['cache_control'] = $head['Cache-Control'] ?? null;
        $info['last_modified'] = $head['Last-Modified'] ?? null;
        $info['etag'] = $head['ETag'] ?? null;
        if (isset($info['request_header']) && is_string($info['request_header'])) {
            $info['request_header'] = str_array($info['request_header'], ':', true);
        }

        if (!($options[CURLOPT_NOBODY] ?? false) && !$options['nobody']) {
            $content_type = split_noempty(';', $info['content_type'] ?? '');
            if ($convert = ($options['parser'][strtolower($content_type[0] ?? '')]['response'] ?? null)) {
                $body = $convert($body, ...$content_type);
            }
        }

        return [$info, $head, $body];
    };

    // キャッシュのキー
    $filekey = null;
    if ($options[CURLOPT_CUSTOMREQUEST] === 'GET' && isset($options['cachedir'])) {
        [$url, $query] = explode('?', $options[CURLOPT_URL]) + [1 => ''];
        $filekey = $options['cachedir'] . DIRECTORY_SEPARATOR . urlencode($url) . sha1($query);
    }

    // http cache
    if (isset($filekey)) {
        if (file_exists($filekey)) {
            $fp = fopen($filekey, 'r');
            try {
                $info = json_decode(fgets($fp), true);
                if (stripos($info['cache_control'] ?? '', 'no-cache') === false && preg_match('#max-age=(\\d+)#i', $info['cache_control'] ?? '', $matches)) {
                    clearstatcache(true, $filekey);
                    if (time() - filemtime($filekey) < $matches[1]) {
                        $info['no_request'] = true;
                        $response = stream_get_contents($fp);
                        [, $response_header, $body] = $response_parse($response, $info);
                        return $body;
                    }
                }

                if ($info['last_modified']) {
                    $options[CURLOPT_HTTPHEADER]['if-modified-since'] = $info['last_modified'];
                }
                if ($info['etag']) {
                    $options[CURLOPT_HTTPHEADER]['if-none-match'] = $info['etag'];
                }
            }
            finally {
                fclose($fp);
            }
        }
    }

    // http cache クロージャ
    $cache = function ($response, $info) use ($filekey, $response_parse) {
        if (isset($filekey)) {
            if ($info['http_code'] === 200 && stripos($info['cache_control'] ?? '', 'no-store') === false) {
                file_set_contents($filekey, json_encode($info, JSON_UNESCAPED_SLASHES) . "\n" . $response);
            }
            if ($info['http_code'] === 304 && file_exists($filekey)) {
                touch($filekey);
                [$info2, $response] = explode("\n", file_get_contents($filekey), 2);
                return $response_parse($response, json_decode($info2, true))[2];
            }
        }
    };

    // CURLOPT_POSTFIELDS は配列を渡せば万事 OK ・・・と思いきや多次元には対応していないのでフラットにする
    if (is_array($options[CURLOPT_POSTFIELDS])) {
        // の、前に @ 付きキーを CURLFile に変換
        if ($options['atfile']) {
            $options[CURLOPT_POSTFIELDS] = array_kvmap($options[CURLOPT_POSTFIELDS], function ($k, $v, $callback) {
                $atfile = ($k[0] ?? null) === '@';
                if ($atfile) {
                    $k = substr($k, 1);
                    if (is_array($v)) {
                        $v = array_kvmap($v, fn($k, $v) => [is_int($k) ? "@$k" : $k => $v]);
                    }
                    else {
                        $v = new \CURLFile($v);
                    }
                }
                if (is_array($v)) {
                    $v = array_kvmap($v, $callback);
                }
                return [$k => $v];
            });
        }
        // CURLFile が含まれているかもしれないので http_build_query は使えない
        $options[CURLOPT_POSTFIELDS] = array_flatten($options[CURLOPT_POSTFIELDS], fn($keys) => array_shift($keys) . ($keys ? '[' . implode('][', $keys) . ']' : ''));
    }

    // 単一ファイルは単一アップロードとする
    if ($options[CURLOPT_POSTFIELDS] instanceof \CURLFile) {
        $file = $options[CURLOPT_POSTFIELDS];
        unset($options[CURLOPT_POSTFIELDS]);
        if (!isset($request_header['content-type'])) {
            $options[CURLOPT_HTTPHEADER]['content-type'] = $file->getMimeType() ?: mime_content_type($file->getFilename());
        }
        $options[CURLOPT_INFILE] = fopen($file->getFilename(), 'r');
        $options[CURLOPT_INFILESIZE] = filesize($file->getFilename());
        $options[CURLOPT_PUT] = true;
    }

    // CURLOPT_HTTPHEADER は素の配列しか受け入れてくれないので連想配列を k: v 形式に変換
    $options[CURLOPT_HTTPHEADER] = array_sprintf($options[CURLOPT_HTTPHEADER], fn($v, $k) => is_int($k) ? $v : "$k: $v");

    // 同上： CURLOPT_COOKIE
    if ($options[CURLOPT_COOKIE] && is_array($options[CURLOPT_COOKIE])) {
        $options[CURLOPT_COOKIE] = array_sprintf($options[CURLOPT_COOKIE], fn($v, $k) => is_int($k) ? $v : rawurlencode($k) . "=" . rawurlencode($v), '; ');
    }

    assert(is_callable($options['retry']) || is_array($options['retry']));
    $retry = is_callable($options['retry']) ? $options['retry'] : function ($info) use ($options) {
        // リトライを費やしたなら打ち切り
        $time = $options['retry'][$info['retry']] ?? null;
        if ($time === null) {
            return false;
        }
        // curl レイヤでは一部の curl_errno のみ
        if (in_array($info['errno'], [CURLE_OPERATION_TIMEOUTED, CURLE_GOT_NOTHING, CURLE_SEND_ERROR, CURLE_RECV_ERROR])) {
            return $time;
        }
        // 結果が返ってきてるなら打ち切り…としたいところだが、一部のコードはリトライ対象とする。ちょっと思うところがあるのでメモを下記に記す
        // 429 は微妙。いわゆるレート制限が多いだろうので、リトライしてもどうせコケる
        // 502 はもっと微妙。でも「たまたま具合の悪い ap サーバに到達してしまった」ならリトライの価値はある
        // 503 は本来あるべきリトライだろうけど、過負荷でリトライしても…という思いもある
        if ($info['errno'] === CURLE_OK && in_array($info['http_code'], [429, 502, 503])) {
            return $time;
        }

        return false;
    };

    $responser = function ($response, $info) use ($response_parse, $cache) {
        [$info, $head, $body] = $response_parse($response, $info);
        return [$cache($response, $info) ?? $body, $head, $info];
    };

    $ch = curl_init();
    curl_setopt_array($ch, array_filter($options, 'is_int', ARRAY_FILTER_USE_KEY));
    if ($options['raw']) {
        return [$ch, $responser, $retry];
    }

    try {
        $retry_count = 0;
        do {
            $headers = '';
            $response = curl_exec($ch);
            if ($options['nobody']) {
                $response = $headers;
            }
            $info = curl_getinfo($ch);
            $info['retry'] = $retry_count++;
            $info['errno'] = curl_errno($ch);
            $time = $retry($info, $response);
            usleep($time * 1000 * 1000);
        } while ($time);

        if (!($info['errno'] === CURLE_OK || ($options['nobody'] && $info['errno'] === CURLE_WRITE_ERROR))) {
            throw new \RuntimeException(curl_error($ch), curl_errno($ch));
        }
    }
    finally {
        curl_close($ch);
    }

    if ($options['throw'] && $info['http_code'] >= 400) {
        throw new \UnexpectedValueException("status is {$info['http_code']}.");
    }

    [$body, $response_header, $info] = $responser($response, $info);
    return $body;
}
