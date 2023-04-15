<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../syntax/blank_if.php';
require_once __DIR__ . '/../var/stringify.php';
// @codeCoverageIgnoreEnd

/**
 * エラー出力する
 *
 * 第1引数 $message はそれらしく文字列化されて出力される。基本的にはあらゆる型を与えて良い。
 *
 * 第2引数 $destination で出力対象を指定する。省略すると error_log 設定に従う。
 * 文字列を与えるとファイル名とみなし、ファイルに追記される。
 * ファイルを開くが、**ファイルは閉じない**。閉じ処理は php の終了処理に身を任せる。
 * したがって閉じる必要がある場合はファイルポインタを渡す必要がある。
 *
 * @package ryunosuke\Functions\Package\errorfunc
 *
 * @param string|mixed $message 出力メッセージ
 * @param resource|string|mixed $destination 出力先
 * @return int 書き込んだバイト数
 */
function error($message, $destination = null)
{
    static $persistences = [];

    $time = date('d-M-Y H:i:s e');
    $content = stringify($message);
    $location = '';
    if (!($message instanceof \Exception || $message instanceof \Throwable)) {
        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
            if (isset($trace['file'], $trace['line'])) {
                $location = " in {$trace['file']} on line {$trace['line']}";
                break;
            }
        }
    }
    $line = "[$time] PHP Log:  $content$location\n";

    if ($destination === null) {
        $destination = blank_if(ini_get('error_log'), 'php://stderr');
    }

    if ($destination === 'syslog') {
        syslog(LOG_INFO, $message);
        return strlen($line);
    }

    if (is_resource($destination)) {
        $fp = $destination;
    }
    elseif (is_string($destination)) {
        if (!isset($persistences[$destination])) {
            $persistences[$destination] = fopen($destination, 'a');
        }
        $fp = $persistences[$destination];
    }

    if (empty($fp)) {
        throw new \InvalidArgumentException('$destination must be resource or string.');
    }

    flock($fp, LOCK_EX);
    fwrite($fp, $line);
    flock($fp, LOCK_UN);

    return strlen($line);
}
