<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_and.php';
// @codeCoverageIgnoreEnd

/**
 * 全要素が true になるなら true を返す（1つでも false なら false を返す）
 *
 * @see array_and()
 * @deprecated 標準関数と重複
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\array
 */
function array_all($array, $callback = null, $default = true)
{
    trigger_error(__FUNCTION__ . ' is deprecated. use array_and or 8.4 builtin', E_USER_DEPRECATED);
    return array_and($array, $callback, $default);
}
