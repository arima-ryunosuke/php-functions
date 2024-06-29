<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/str_equals.php';
// @codeCoverageIgnoreEnd

/**
 * 指定文字列で終わるか調べる
 *
 * $with に配列を渡すといずれかで終わるときに true を返す。
 *
 * Example:
 * ```php
 * that(ends_with('abcdef', 'def'))->isTrue();
 * that(ends_with('abcdef', 'DEF', true))->isTrue();
 * that(ends_with('abcdef', 'xyz'))->isFalse();
 * that(ends_with('abcdef', ['d', 'e', 'f']))->isTrue();
 * that(ends_with('abcdef', ['x', 'y', 'z']))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 探される文字列
 * @param string|string[] $with 探す文字列
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @return bool 対象文字列で終わるなら true
 */
function ends_with(?string $string, $with, $case_insensitivity = false)
{
    foreach ((array) $with as $w) {
        assert(strlen($w));

        if (str_equals(substr($string, -strlen($w)), $w, $case_insensitivity)) {
            return true;
        }
    }
    return false;
}
