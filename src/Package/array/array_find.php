<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_find_first.php';
// @codeCoverageIgnoreEnd

/**
 * array_search のクロージャ版のようなもの
 *
 * @see array_find_first()
 * @deprecated 標準関数と重複
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\array
 */
function array_find($array, $callback, $is_key = true)
{
    trigger_error(__FUNCTION__ . ' is deprecated. use array_find_first or 8.4 builtin', E_USER_DEPRECATED);
    return array_find_first($array, $callback, $is_key);
}
