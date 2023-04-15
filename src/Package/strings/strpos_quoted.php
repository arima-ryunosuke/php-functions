<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * クオートを考慮して strpos する
 *
 * Example:
 * ```php
 * // クオート中は除外される
 * that(strpos_quoted('hello "this" is world', 'is'))->isSame(13);
 * // 開始位置やクオート文字は指定できる（5文字目以降の \* に囲まれていない hoge の位置を返す）
 * that(strpos_quoted('1:hoge, 2:*hoge*, 3:hoge', 'hoge', 5, '*'))->isSame(20);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $haystack 対象文字列
 * @param string|iterable $needle 位置を取得したい文字列
 * @param int $offset 開始位置
 * @param string|array $enclosure 囲い文字。この文字中にいる $from, $to 文字は走査外になる
 * @param string $escape エスケープ文字。この文字が前にある $from, $to 文字は走査外になる
 * @param ?string $found $needle の内、見つかった文字列が格納される
 * @return false|int $needle の位置
 */
function strpos_quoted($haystack, $needle, $offset = 0, $enclosure = "'\"", $escape = '\\', &$found = null)
{
    if (is_string($enclosure)) {
        if (strlen($enclosure)) {
            $chars = str_split($enclosure);
            $enclosure = array_combine($chars, $chars);
        }
        else {
            $enclosure = [];
        }
    }
    $needles = arrayval($needle, false);

    $strlen = strlen($haystack);

    if ($offset < 0) {
        $offset += $strlen;
    }

    $found = null;
    $enclosing = [];
    for ($i = $offset; $i < $strlen; $i++) {
        if ($i !== 0 && $haystack[$i - 1] === $escape) {
            continue;
        }
        foreach ($enclosure as $start => $end) {
            if (substr_compare($haystack, $end, $i, strlen($end)) === 0) {
                if ($enclosing && $enclosing[count($enclosing) - 1] === $end) {
                    array_pop($enclosing);
                    $i += strlen($end) - 1;
                    continue 2;
                }
            }
            if (substr_compare($haystack, $start, $i, strlen($start)) === 0) {
                $enclosing[] = $end;
                $i += strlen($start) - 1;
                continue 2;
            }
        }

        if (empty($enclosing)) {
            foreach ($needles as $needle) {
                if (substr_compare($haystack, $needle, $i, strlen($needle)) === 0) {
                    $found = $needle;
                    return $i;
                }
            }
        }
    }
    return false;
}
