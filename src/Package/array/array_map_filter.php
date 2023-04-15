<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * array_map + array_filter する
 *
 * コールバックを適用して、結果が true 相当の要素のみ取り出す。
 * $strict に true を与えると「null でない」要素のみ返される。
 *
 * $callback が要求するならキーも渡ってくる。
 *
 * Example:
 * ```php
 * that(array_map_filter([' a ', ' b ', ''], 'trim'))->isSame(['a', 'b']);
 * that(array_map_filter([' a ', ' b ', ''], 'trim', true))->isSame(['a', 'b', '']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @param bool $strict 厳密比較フラグ。 true だと null のみが偽とみなされる
 * @return array $callback が真を返した新しい配列
 */
function array_map_filter($array, $callback, $strict = false)
{
    $callback = func_user_func_array($callback);
    $result = [];
    $n = 0;
    foreach ($array as $k => $v) {
        $vv = $callback($v, $k, $n++);
        if (($strict && $vv !== null) || (!$strict && $vv)) {
            $result[$k] = $vv;
        }
    }
    return $result;
}
