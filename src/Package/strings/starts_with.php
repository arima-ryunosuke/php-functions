<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/str_equals.php';
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * 指定文字列で始まるか調べる
 *
 * $with に配列を渡すといずれかで始まるときに true を返す。
 *
 * Example:
 * ```php
 * that(starts_with('abcdef', 'abc'))->isTrue();
 * that(starts_with('abcdef', 'ABC', true))->isTrue();
 * that(starts_with('abcdef', 'xyz'))->isFalse();
 * that(starts_with('abcdef', ['a', 'b', 'c']))->isTrue();
 * that(starts_with('abcdef', ['x', 'y', 'z']))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 探される文字列
 * @param string|string[] $with 探す文字列
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @return bool 指定文字列で始まるなら true を返す
 */
function starts_with($string, $with, $case_insensitivity = false)
{
    assert(is_stringable($string));

    foreach ((array) $with as $w) {
        assert(strlen($w));

        if (str_equals(substr($string, 0, strlen($w)), $w, $case_insensitivity)) {
            return true;
        }
    }
    return false;
}
