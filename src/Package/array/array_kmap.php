<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * キーも渡ってくる array_map
 *
 * `array_map($callback, $array, array_keys($array))` とほとんど変わりはない。
 * 違いは下記。
 *
 * - 引数の順番が異なる（$array が先）
 * - キーが死なない（array_map は複数配列を与えるとキーが死ぬ）
 * - 配列だけでなく Traversable も受け入れる
 * - callback の第3引数に 0 からの連番が渡ってくる
 *
 * Example:
 * ```php
 * // キー・値をくっつけるシンプルな例
 * that(array_kmap([
 *     'k1' => 'v1',
 *     'k2' => 'v2',
 *     'k3' => 'v3',
 * ], fn($v, $k) => "$k:$v"))->isSame([
 *     'k1' => 'k1:v1',
 *     'k2' => 'k2:v2',
 *     'k3' => 'k3:v3',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @return array $callback を通した新しい配列
 */
function array_kmap($array, $callback)
{
    $callback = func_user_func_array($callback);

    $n = 0;
    $result = [];
    foreach ($array as $k => $v) {
        $result[$k] = $callback($v, $k, $n++);
    }
    return $result;
}
