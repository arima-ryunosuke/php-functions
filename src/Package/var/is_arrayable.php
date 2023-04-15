<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 変数が配列アクセス可能か調べる
 *
 * Example:
 * ```php
 * that(is_arrayable([]))->isTrue();
 * that(is_arrayable(new \ArrayObject()))->isTrue();
 * that(is_arrayable(new \stdClass()))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 調べる値
 * @return bool 配列アクセス可能なら true
 */
function is_arrayable($var)
{
    return is_array($var) || $var instanceof \ArrayAccess;
}
