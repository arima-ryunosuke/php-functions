<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * 文字列を区切り文字で区切って配列に変換する
 *
 * 典型的には http ヘッダとか sar の結果とかを配列にする。
 *
 * Example:
 * ```php
 * // http response header  を ":" 区切りで連想配列にする
 * that(str_array("
 * HTTP/1.1 200 OK
 * Content-Type: text/html; charset=utf-8
 * Connection: Keep-Alive
 * ", ':', true))->isSame([
 *     'HTTP/1.1 200 OK',
 *     'Content-Type' => 'text/html; charset=utf-8',
 *     'Connection'   => 'Keep-Alive',
 * ]);
 *
 * // sar の結果を " " 区切りで連想配列の配列にする
 * that(str_array("
 * 13:00:01        CPU     %user     %nice   %system   %iowait    %steal     %idle
 * 13:10:01        all      0.99      0.10      0.71      0.00      0.00     98.19
 * 13:20:01        all      0.60      0.10      0.56      0.00      0.00     98.74
 * ", ' ', false))->isSame([
 *     1 => [
 *         '13:00:01' => '13:10:01',
 *         'CPU'      => 'all',
 *         '%user'    => '0.99',
 *         '%nice'    => '0.10',
 *         '%system'  => '0.71',
 *         '%iowait'  => '0.00',
 *         '%steal'   => '0.00',
 *         '%idle'    => '98.19',
 *     ],
 *     2 => [
 *         '13:00:01' => '13:20:01',
 *         'CPU'      => 'all',
 *         '%user'    => '0.60',
 *         '%nice'    => '0.10',
 *         '%system'  => '0.56',
 *         '%iowait'  => '0.00',
 *         '%steal'   => '0.00',
 *         '%idle'    => '98.74',
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string|array $string 対象文字列。配列を与えても動作する
 * @param string $delimiter 区切り文字
 * @param bool $hashmode 連想配列モードか
 * @return array 配列
 */
function str_array($string, ?string $delimiter, $hashmode)
{
    $array = $string;
    if (is_stringable($string)) {
        $array = preg_split('#\R#u', $string, -1, PREG_SPLIT_NO_EMPTY);
    }
    $delimiter = preg_quote($delimiter, '#');

    $result = [];
    if ($hashmode) {
        foreach ($array as $n => $line) {
            $parts = preg_split("#$delimiter#u", $line, 2, PREG_SPLIT_NO_EMPTY);
            $key = isset($parts[1]) ? array_shift($parts) : $n;
            $result[trim($key)] = trim($parts[0]);
        }
    }
    else {
        foreach ($array as $n => $line) {
            $parts = preg_split("#$delimiter#u", $line, -1, PREG_SPLIT_NO_EMPTY);
            if (!isset($keys)) {
                $keys = $parts;
                continue;
            }
            $result[$n] = count($keys) === count($parts) ? array_combine($keys, $parts) : null;
        }
    }
    return $result;
}
