<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_keys_exist.php';
// @codeCoverageIgnoreEnd

/**
 * デフォルト値付きの配列値取得
 *
 * 存在しない場合は $default を返す。
 *
 * $key に配列を与えるとそれらの値の配列を返す（lookup 的な動作）。
 * その場合、$default が活きるのは「全て無かった場合」となる。
 *
 * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
 *
 * 同様に、$key にクロージャを与えると、その返り値が true 相当のものを返す。
 * その際、 $default が配列なら一致するものを配列で返し、配列でないなら単値で返す。
 *
 * Example:
 * ```php
 * // 単純取得
 * that(array_get(['a', 'b', 'c'], 1))->isSame('b');
 * // 単純デフォルト
 * that(array_get(['a', 'b', 'c'], 9, 999))->isSame(999);
 * // 配列取得
 * that(array_get(['a', 'b', 'c'], [0, 2]))->isSame([0 => 'a', 2 => 'c']);
 * // 配列部分取得
 * that(array_get(['a', 'b', 'c'], [0, 9]))->isSame([0 => 'a']);
 * // 配列デフォルト（null ではなく [] を返す）
 * that(array_get(['a', 'b', 'c'], [9]))->isSame([]);
 * // クロージャ指定＆単値（コールバックが true を返す最初の要素）
 * that(array_get(['a', 'b', 'c'], fn($v) => in_array($v, ['b', 'c'])))->isSame('b');
 * // クロージャ指定＆配列（コールバックが true を返すもの）
 * that(array_get(['a', 'b', 'c'], fn($v) => in_array($v, ['b', 'c']), []))->isSame([1 => 'b', 2 => 'c']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array|\ArrayAccess $array 配列
 * @param string|int|array|\Closure $key 取得したいキー。配列を与えると全て返す。クロージャの場合は true 相当を返す
 * @param mixed $default 無かった場合のデフォルト値
 * @return mixed 指定したキーの値
 */
function array_get($array, $key, $default = null)
{
    if (is_array($key)) {
        $result = [];
        foreach ($key as $k) {
            if (array_keys_exist($k, $array)) {
                $result[$k] = $array[$k];
            }
        }
        if (!$result) {
            // 明示的に与えられていないなら [] を使用する
            if (func_num_args() === 2) {
                $default = [];
            }
            return $default;
        }
        return $result;
    }

    if ($key instanceof \Closure) {
        $result = [];
        $n = 0;
        foreach ($array as $k => $v) {
            if ($key($v, $k, $n++)) {
                if (func_num_args() === 2) {
                    return $v;
                }
                $result[$k] = $v;
            }
        }
        if (!$result) {
            return $default;
        }
        return $result;
    }

    if (array_keys_exist($key, $array)) {
        return $array[$key];
    }
    return $default;
}
