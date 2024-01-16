<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * array_rand の要素版
 *
 * とはいえ多少の差異がある。
 *
 * - 第2引数に null を与えると単一の値として返す
 * - 第2引数に数値を与えると配列で返す（たとえ1でも配列で返す）
 * - 第2引数に 0 を与えてもエラーにはならない（空配列を返す）
 * - 第2引数に負数を与えるとその個数に満たなくても例外にならない
 * - 第3引数に true を与えるとキーを維持して返す
 *
 * Example:
 * ```php
 * mt_srand(4); // テストがコケるので種固定
 * // 配列からランダムに値1件取得（単一で返す）
 * that(array_random(['a' => 'A', 'b' => 'B', 'c' => 'C']))->isSame('B');
 * // 配列からランダムに値2件取得（配列で返す）
 * that(array_random(['a' => 'A', 'b' => 'B', 'c' => 'C'], 2))->isSame(['B', 'C']);
 * // 配列からランダムに値2件取得（キーを維持）
 * that(array_random(['a' => 'A', 'b' => 'B', 'c' => 'C'], 2, true))->isSame(['a' => 'A', 'c' => 'C']);
 * // 配列からランダムに値N件取得（負数指定。配列数を超えた指定は例外になるので負数にする必要がある）
 * that(array_random(['a' => 'A', 'b' => 'B', 'c' => 'C'], -999, true))->isSame(['a' => 'A', 'b' => 'B', 'c' => 'C']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param ?int $count 取り出す個数
 * @return mixed ランダムな要素
 */
function array_random($array, $count = null, $preserve_keys = false)
{
    if ($count === null) {
        return $array[array_rand($array)];
    }

    if (intval($count) === 0) {
        return [];
    }

    if ($count > 0 && count($array) < $count) {
        throw new \InvalidArgumentException('Argument #2 ($count) must be between 1 and the number of elements in argument #1 ($array)');
    }
    if ($count < 0) {
        $count = min(count($array), -$count);
    }

    if (count($array) === 0) {
        return [];
    }

    $result = [];
    foreach ((array) array_rand($array, $count) as $key) {
        if ($preserve_keys) {
            $result[$key] = $array[$key];
        }
        else {
            $result[] = $array[$key];
        }
    }
    return $result;
}
