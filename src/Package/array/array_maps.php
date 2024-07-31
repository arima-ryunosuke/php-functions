<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
require_once __DIR__ . '/../utility/function_configure.php';
require_once __DIR__ . '/../var/arrayval.php';
require_once __DIR__ . '/../var/is_arrayable.php';
// @codeCoverageIgnoreEnd

/**
 * 複数コールバックを指定できる array_map
 *
 * 指定したコールバックで複数回回してマップする。
 * `array_maps($array, $f, $g)` は `array_map($g, array_map($f, $array))` とほぼ等しい。
 * ただし、引数は順番が違う（可変引数のため）し、コールバックが要求するならキーも渡ってくる。
 * さらに文字列関数で "..." から始まっているなら可変引数としてコールする。
 *
 * 少し変わった仕様として、コールバックに [$method => $args] を付けるとそれはメソッド呼び出しになる。
 * つまり各要素 $v に対して `$v->$method(...$args)` がマップ結果になる。
 * さらに引数が不要なら `@method` とするだけで良い。
 *
 * Example:
 * ```php
 * // 値を3乗したあと16進表記にして大文字化する
 * that(array_maps([1, 2, 3, 4, 5], fn($v) => pow($v, 3), 'dechex', 'strtoupper'))->isSame(['1', '8', '1B', '40', '7D']);
 * // キーも渡ってくる
 * that(array_maps(['a' => 'A', 'b' => 'B'], fn($v, $k) => "$k:$v"))->isSame(['a' => 'a:A', 'b' => 'b:B']);
 * // ... で可変引数コール
 * that(array_maps([[1, 3], [1, 5, 2]], '...range'))->isSame([[1, 2, 3], [1, 3, 5]]);
 * // メソッドコールもできる（引数不要なら `@method` でも同じ）
 * that(array_maps([new \Exception('a'), new \Exception('b')], ['getMessage' => []]))->isSame(['a', 'b']);
 * that(array_maps([new \Exception('a'), new \Exception('b')], '@getMessage'))->isSame(['a', 'b']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable ...$callbacks 評価クロージャ配列
 * @return iterable 評価クロージャを通した新しい配列
 */
function array_maps($array, ...$callbacks)
{
    // Iterator だが ArrayAccess ではないオブジェクト（Generator とか）は unset できないので配列として扱わざるを得ない
    if (!(function_configure('array.variant') && is_arrayable($array))) {
        $array = arrayval($array, false);
    }

    foreach ($callbacks as $callback) {
        if (is_string($callback) && $callback[0] === '@') {
            $margs = [];
            $vargs = false;
            $callback = substr($callback, 1);
        }
        elseif (is_array($callback) && count($callback) === 1) {
            $margs = reset($callback);
            $vargs = false;
            $callback = key($callback);
        }
        elseif (is_string($callback) && substr($callback, 0, 3) === '...') {
            $margs = null;
            $vargs = true;
            $callback = substr($callback, 3);
        }
        else {
            $margs = null;
            $vargs = false;
            $callback = func_user_func_array($callback);
        }
        $n = 0;
        foreach (arrayval($array, false) as $k => $v) {
            if (isset($margs)) {
                $array[$k] = ([$v, $callback])(...$margs);
            }
            elseif ($vargs) {
                $array[$k] = $callback(...$v);
            }
            else {
                $array[$k] = $callback($v, $k, $n++);
            }
        }
    }
    return $array;
}
