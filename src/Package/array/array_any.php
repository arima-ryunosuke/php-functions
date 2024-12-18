<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_or.php';
// @codeCoverageIgnoreEnd

/**
 * 全要素が false になるなら false を返す（1つでも true なら true を返す）
 *
 * @see array_or()
 * @deprecated 標準関数と重複
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\array
 */
function array_any($array, $callback = null, $default = false)
{
    trigger_error(__FUNCTION__ . ' is deprecated. use array_or or 8.4 builtin', E_USER_DEPRECATED);
    return array_or($array, $callback, $default);
}
