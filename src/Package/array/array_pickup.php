<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/is_callback.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * キーを指定してそれだけの配列にする
 *
 * `array_intersect_key($array, array_flip($keys))` とほぼ同義。
 * 違いは Traversable を渡せることと、結果配列の順番が $keys に従うこと。
 *
 * $keys に連想配列を渡すとキーを読み替えて動作する（Example を参照）。
 * さらにその時クロージャを渡すと($key, $value)でコールされた結果が新しいキーになる。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * // a と c を取り出す
 * that(array_pickup($array, ['a', 'c']))->isSame(['a' => 'A', 'c' => 'C']);
 * // 順番は $keys 基準になる
 * that(array_pickup($array, ['c', 'a']))->isSame(['c' => 'C', 'a' => 'A']);
 * // 連想配列を渡すと読み替えて返す
 * that(array_pickup($array, ['c' => 'cX', 'a' => 'aX']))->isSame(['cX' => 'C', 'aX' => 'A']);
 * // コールバックを渡せる
 * that(array_pickup($array, ['c' => fn($k, $v) => "$k-$v"]))->isSame(['c-C' => 'C']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable|object $array 対象配列
 * @param array $keys 取り出すキー
 * @return array 新しい配列
 */
function array_pickup($array, $keys)
{
    $array = arrayval($array, false);

    $result = [];
    foreach (arrayval($keys, false) as $k => $key) {
        if (is_int($k)) {
            if (array_key_exists($key, $array)) {
                $result[$key] = $array[$key];
            }
        }
        else {
            if (array_key_exists($k, $array)) {
                if (is_callback($key)) {
                    $key = $key($k, $array[$k]);
                }
                $result[$key] = $array[$k];
            }
        }
    }
    return $result;
}
