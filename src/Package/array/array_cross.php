<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の直積を返す
 *
 * 文字キーは保存されるが数値キーは再割り振りされる。
 * ただし、文字キーが重複すると例外を投げる。
 *
 * Example:
 * ```php
 * // 普通の直積
 * that(array_cross(
 *     [1, 2],
 *     [3, 4]
 * ))->isSame([[1, 3], [1, 4], [2, 3], [2, 4]]);
 * // キーが維持される
 * that(array_cross(
 *     ['a' => 1, 2],
 *     ['b' => 3, 4]
 * ))->isSame([['a' => 1, 'b' => 3], ['a' => 1, 4], [2, 'b' => 3], [2, 4]]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array ...$arrays 対象配列（可変引数）
 * @return array 各配列値の直積
 */
function array_cross(...$arrays)
{
    if (!$arrays) {
        return [];
    }

    $result = [[]];
    foreach ($arrays as $array) {
        $tmp = [];
        foreach ($result as $x) {
            foreach ($array as $k => $v) {
                if (is_string($k) && array_key_exists($k, $x)) {
                    throw new \InvalidArgumentException("duplicated key '$k'.");
                }
                $tmp[] = array_merge($x, [$k => $v]);
            }
        }
        $result = $tmp;
    }
    return $result;
}
