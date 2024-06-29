<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 指定文字列を含むか返す
 *
 * Example:
 * ```php
 * that(str_exists('abc', 'b'))->isTrue();
 * that(str_exists('abc', 'B', true))->isTrue();
 * that(str_exists('abc', ['b', 'x'], false, false))->isTrue();
 * that(str_exists('abc', ['b', 'x'], false, true))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $haystack 対象文字列
 * @param string|array $needle 調べる文字列
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @param bool $and_flag すべて含む場合に true を返すか
 * @return bool $needle を含むなら true
 */
function str_exists(?string $haystack, $needle, $case_insensitivity = false, $and_flag = false)
{
    if (!is_array($needle)) {
        $needle = [$needle];
    }

    $needle = array_map('strval', $needle);

    foreach ($needle as $str) {
        if ($str === '') {
            continue;
        }
        $pos = $case_insensitivity ? stripos($haystack, $str) : strpos($haystack, $str);
        if ($and_flag && $pos === false) {
            return false;
        }
        if (!$and_flag && $pos !== false) {
            return true;
        }
    }
    return !!$and_flag;
}
