<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * キーを指定してそれらを除いた配列にする
 *
 * `array_diff_key($array, array_flip($keys))` とほぼ同義。
 * 違いは Traversable を渡せること。
 *
 * array_pickup の逆とも言える。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * // a と c を伏せる（b を残す）
 * that(array_remove($array, ['a', 'c']))->isSame(['b' => 'B']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array|\Traversable $array 対象配列
 * @param array|int|string $keys 伏せるキー
 * @return array 新しい配列
 */
function array_remove($array, $keys)
{
    foreach (arrayval($keys, false) as $k) {
        unset($array[$k]);
    }
    return $array;
}
