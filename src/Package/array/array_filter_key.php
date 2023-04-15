<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * キーを主軸とした array_filter
 *
 * $callback が要求するなら値も渡ってくる。 php 5.6 の array_filter の ARRAY_FILTER_USE_BOTH と思えばよい。
 * ただし、完全な互換ではなく、引数順は ($k, $v) なので注意。
 *
 * Example:
 * ```php
 * that(array_filter_key(['a', 'b', 'c'], fn($k, $v) => $k !== 1))->isSame([0 => 'a', 2 => 'c']);
 * that(array_filter_key(['a', 'b', 'c'], fn($k, $v) => $v !== 'b'))->isSame([0 => 'a', 2 => 'c']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @return array $callback が true を返した新しい配列
 */
function array_filter_key($array, $callback)
{
    $callback = func_user_func_array($callback);
    $result = [];
    $n = 0;
    foreach ($array as $k => $v) {
        if ($callback($k, $v, $n++)) {
            $result[$k] = $v;
        }
    }
    return $result;
}
