<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 複数コールバックを指定できる array_filter
 *
 * 指定したコールバックで複数回回してフィルタする。
 * `array_filter($array, $f, $g)` は `array_filter(array_filter($array, $f), $g)` とほぼ等しい。
 * コールバックが要求するならキーも渡ってくる。
 * さらに文字列関数で "..." から始まっているなら可変引数としてコールする。
 *
 * 少し変わった仕様として、コールバックに [$method => $args] を付けるとそれはメソッド呼び出しになる。
 * つまり各要素 $v に対して `$v->$method(...$args)` がフィルタ結果になる。
 * さらに引数が不要なら `@method` とするだけで良い。
 *
 * Example:
 * ```php
 * // 非 null かつ小文字かつ16進数
 * that(array_filters(['abc', 'XYZ', null, 'ABC', 'ff', '3e7'],
 *     fn($v) => $v !== null,
 *     fn($v) => ctype_lower("$v"),
 *     fn($v) => ctype_xdigit("$v"),
 * ))->isSame([0 => 'abc', 4 => 'ff']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable ...$callbacks 評価クロージャ配列
 * @return array 評価クロージャでフィルタした新しい配列
 */
function array_filters($array, ...$callbacks)
{
    $array = arrayval($array, false);
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
        foreach ($array as $k => $v) {
            if (isset($margs)) {
                $flag = ([$v, $callback])(...$margs);
            }
            elseif ($vargs) {
                $flag = $callback(...$v);
            }
            else {
                $flag = $callback($v, $k, $n++);
            }

            if (!$flag) {
                unset($array[$k]);
            }
        }
    }
    return $array;
}
