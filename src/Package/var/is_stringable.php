<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 変数が文字列化できるか調べる
 *
 * 「配列」「__toString を持たないオブジェクト」が false になる。
 * （厳密に言えば配列は "Array" になるので文字列化できるといえるがここでは考えない）。
 *
 * Example:
 * ```php
 * // こいつらは true
 * that(is_stringable(null))->isTrue();
 * that(is_stringable(true))->isTrue();
 * that(is_stringable(3.14))->isTrue();
 * that(is_stringable(STDOUT))->isTrue();
 * that(is_stringable(new \Exception()))->isTrue();
 * // こいつらは false
 * that(is_stringable(new \ArrayObject()))->isFalse();
 * that(is_stringable([1, 2, 3]))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 調べる値
 * @return bool 文字列化できるなら true
 */
function is_stringable($var)
{
    if (is_array($var)) {
        return false;
    }
    if (is_object($var) && !method_exists($var, '__toString')) {
        return false;
    }
    return true;
}
