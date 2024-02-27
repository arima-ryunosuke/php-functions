<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * 値が複合型でないか検査する
 *
 * 「複合型」とはオブジェクトと配列のこと。
 * つまり
 *
 * - is_scalar($var) || is_null($var) || is_resource($var)
 *
 * と同義（!is_array($var) && !is_object($var) とも言える）。
 *
 * Example:
 * ```php
 * that(is_primitive(null))->isTrue();
 * that(is_primitive(false))->isTrue();
 * that(is_primitive(123))->isTrue();
 * that(is_primitive(STDIN))->isTrue();
 * that(is_primitive(new \stdClass))->isFalse();
 * that(is_primitive(['array']))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 調べる値
 * @return bool 複合型なら false
 */
function is_primitive($var)
{
    return is_scalar($var) || is_null($var) || is_resourcable($var);
}
