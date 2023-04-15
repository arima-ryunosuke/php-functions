<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * キーをマップして変換する
 *
 * $callback が null を返すとその要素は取り除かれる。
 *
 * Example:
 * ```php
 * that(array_map_key(['a' => 'A', 'b' => 'B'], 'strtoupper'))->isSame(['A' => 'A', 'B' => 'B']);
 * that(array_map_key(['a' => 'A', 'b' => 'B'], function () { }))->isSame([]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @return array キーが変換された新しい配列
 */
function array_map_key($array, $callback)
{
    $callback = func_user_func_array($callback);
    $result = [];
    $n = 0;
    foreach ($array as $k => $v) {
        $k2 = $callback($k, $v, $n++);
        if ($k2 !== null) {
            $result[$k2] = $v;
        }
    }
    return $result;
}
