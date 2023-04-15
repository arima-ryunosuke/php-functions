<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_insert.php';
require_once __DIR__ . '/../array/array_nmap.php';
// @codeCoverageIgnoreEnd

/**
 * 要素値を $callback の最右に適用して array_map する
 *
 * Example:
 * ```php
 * $sprintf = fn() => vsprintf('%s%s', func_get_args());
 * that(array_rmap(['a', 'b'], $sprintf, 'prefix-'))->isSame(['prefix-a', 'prefix-b']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @param mixed ...$variadic $callback に渡され、改変される引数（可変引数）
 * @return array 評価クロージャを通した新しい配列
 */
function array_rmap($array, $callback, ...$variadic)
{
    return array_nmap(...array_insert(func_get_args(), func_num_args() - 2, 2));
}
