<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../errorfunc/set_error_exception_handler.php';
require_once __DIR__ . '/../exec/process.php';
// @codeCoverageIgnoreEnd

/**
 * ネットワーク疎通を返す
 *
 * $port を指定すると TCP/UDP、省略（null）すると ICMP で繋ぐ。
 * が、 ICMP は root ユーザしか実行できないので ping コマンドにフォールバックする。
 * TCP/UDP の分岐はマニュアル通り tcp://, udp:// のようなスキームで行う（スキームがなければ tcp）。
 *
 * udp は結果が不安定なので信頼しないこと（タイムアウトも疎通 OK とみなされる。プロトコルの仕様上どうしようもない）。
 *
 * Example:
 * ```php
 * // 自身へ ICMP ping を打つ（正常終了なら float を返し、失敗なら false を返す）
 * that(ping('127.0.0.1'))->isFloat();
 * // 自身の tcp:1234 が開いているか（開いていれば float を返し、開いていなければ false を返す）
 * that(ping('tcp://127.0.0.1', 1234))->isFalse();
 * that(ping('127.0.0.1', 1234))->isFalse(); // tcp はスキームを省略できる
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 *
 * @param string $host ホスト名（プロトコルも指定できる）
 * @param int|null $port ポート番号。指定しないと ICMP になる
 * @param int $timeout タイムアウト秒
 * @param string $errstr エラー文字列が格納される
 * @return float|bool 成功したときは疎通時間。失敗したときは false
 */
function ping($host, $port = null, $timeout = 1, &$errstr = '')
{
    $errstr = '';

    $parts = parse_url($host);
    if (!isset($parts['scheme'])) {
        if ($port === null) {
            $parts['scheme'] = 'icmp';
        }
        else {
            $parts['scheme'] = 'tcp';
        }
    }
    $protocol = strtolower($parts['scheme']);
    $host = $parts['host'] ?? $parts['path'];

    // icmp で linux かつ非 root は SOCK_RAW が使えないので ping コマンドへフォールバック
    if ($protocol === 'icmp' && DIRECTORY_SEPARATOR === '/' && !is_readable('/root')) {
        // @codeCoverageIgnoreStart
        $stdout = null;
        process('ping', [
            '-c' => 1,
            '-W' => (int) $timeout,
            $host,
        ], null, $stdout, $errstr);
        // min/avg/max/mdev = 0.026/0.026/0.026/0.000
        if (preg_match('#min/avg/max/mdev.*?[0-9.]+/([0-9.]+)/[0-9.]+/[0-9.]+#', $stdout, $m)) {
            return $m[1] / 1000.0;
        }
        return false;
        // @codeCoverageIgnoreEnd
    }

    if ($protocol === 'icmp') {
        $port = 0;
        $socket = socket_create(AF_INET, SOCK_RAW, getprotobyname($protocol));
    }
    elseif ($protocol === 'tcp') {
        $socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname($protocol));
    }
    elseif ($protocol === 'udp') {
        $socket = socket_create(AF_INET, SOCK_DGRAM, getprotobyname($protocol));
    }
    else {
        throw new \InvalidArgumentException("'$protocol' is not supported.");
    }

    $restore = set_error_exception_handler();
    $mtime = microtime(true);
    try {
        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ['sec' => $timeout, 'usec' => 0]);
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => $timeout, 'usec' => 0]);
        if (!socket_connect($socket, $host, $port)) {
            throw new \RuntimeException(); // @codeCoverageIgnore
        }

        // icmp は ping メッセージを送信
        if ($protocol === 'icmp') {
            $message = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
            socket_send($socket, $message, strlen($message), 0);
            socket_read($socket, 255);
        }
        // tcp は接続自体ができれば OK
        if ($protocol === 'tcp') {
            assert(true); // PhpStatementHasEmptyBodyInspection
        }
        // udp は何か送ってみてその挙動で判断（=> catch 節）
        if ($protocol === 'udp') {
            $message = ""; // noop
            socket_send($socket, $message, strlen($message), 0);
            socket_read($socket, 255);
        }
        return microtime(true) - $mtime;
    }
    catch (\Throwable) {
        $errno = socket_last_error($socket);
        // windows では到達できても socket_read がエラーを返すので errno で判断
        // 接続済みの呼び出し先が一定の時間を過ぎても正しく応答しなかったため、接続できませんでした。
        // または接続済みのホストが応答しなかったため、確立された接続は失敗しました。
        if (DIRECTORY_SEPARATOR === '\\' && $errno === 10060 && $protocol === 'udp') {
            return microtime(true) - $mtime;
        }
        $errstr = socket_strerror($errno);
        return false;
    }
    finally {
        $restore();
        socket_close($socket);
    }
}
