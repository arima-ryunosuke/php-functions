<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の+演算子の関数版
 *
 * Example:
 * ```php
 * // ただの加算の関数版なので同じキーは上書きされない
 * that(array_add(['a', 'b', 'c'], ['X']))->isSame(['a', 'b', 'c']);
 * // 異なるキーは生える
 * that(array_add(['a', 'b', 'c'], ['x' => 'X']))->isSame(['a', 'b', 'c', 'x' => 'X']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array ...$variadic 足す配列（可変引数）
 * @return array 足された配列
 */
function array_add(...$variadic)
{
    $array = [];
    foreach ($variadic as $arg) {
        $array += $arg;
    }
    return $array;
}
