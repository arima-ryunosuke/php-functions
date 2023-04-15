<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * 配列をコールバックに従ってカウントする
 *
 * コールバックが true 相当を返した要素をカウントして返す。
 * 普通に使う分には `count(array_filter($array, $callback))` とほとんど同じだが、下記の点が微妙に異なる。
 *
 * - $callback が要求するならキーも渡ってくる
 * - $callback には配列が渡せる。配列を渡した場合は件数を配列で返す（Example 参照）
 *
 * $recursive に true を渡すと再帰的に動作する。
 * 末端・配列を問わずに呼び出されるので場合によっては is_array などの判定が必要になる。
 *
 * Example:
 * ```php
 * $array = ['hoge', 'fuga', 'piyo'];
 * // 'o' を含むものの数（2個）
 * that(array_count($array, fn($s) => strpos($s, 'o') !== false))->isSame(2);
 * // 'a' と 'o' を含むものをそれぞれ（1個と2個）
 * that(array_count($array, [
 *     'a' => fn($s) => strpos($s, 'a') !== false,
 *     'o' => fn($s) => strpos($s, 'o') !== false,
 * ]))->isSame([
 *     'a' => 1,
 *     'o' => 2,
 * ]);
 *
 * // 再帰版
 * $array = [
 *     ['1', '2', '3'],
 *     ['a', 'b', 'c'],
 *     ['X', 'Y', 'Z'],
 *     [[[['a', 'M', 'Z']]]],
 * ];
 * that(array_count($array, [
 *     'lower' => fn($v) => !is_array($v) && ctype_lower($v),
 *     'upper' => fn($v) => !is_array($v) && ctype_upper($v),
 *     'array' => fn($v) => is_array($v),
 * ], true))->is([
 *     'lower' => 4, // 小文字の数
 *     'upper' => 5, // 大文字の数
 *     'array' => 7, // 配列の数
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback カウントルール。配列も渡せる
 * @param bool $recursive 再帰フラグ
 * @return int|array 条件一致した件数
 */
function array_count($array, $callback, $recursive = false)
{
    // 配列が来た場合はまるで動作が異なる（再帰でもいいがそれだと旨味がない。複数欲しいなら呼び出し元で複数回呼べば良い。ワンループに閉じ込めるからこそメリットがある））
    if (is_array($callback) && !is_callable($callback)) {
        $result = array_fill_keys(array_keys($callback), 0);
        foreach ($callback as $name => $rule) {
            $rule = func_user_func_array($rule);
            $n = 0;
            foreach ($array as $k => $v) {
                if ($rule($v, $k, $n++)) {
                    $result[$name]++;
                }
                if ($recursive && is_iterable($v)) {
                    $result[$name] += array_count($v, $rule, $recursive);
                }
            }
        }
        return $result;
    }

    $callback = func_user_func_array($callback);
    $result = 0;
    $n = 0;
    foreach ($array as $k => $v) {
        if ($callback($v, $k, $n++)) {
            $result++;
        }
        if ($recursive && is_iterable($v)) {
            $result += array_count($v, $callback, $recursive);
        }
    }
    return $result;
}
