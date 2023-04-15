<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列を交互に追加する
 *
 * 引数の配列を横断的に追加して返す。
 * 数値キーは振り直される。文字キーはそのまま追加される（同じキーは後方上書き）。
 *
 * 配列の長さが異なる場合、短い方に対しては何もしない。そのまま追加される。
 *
 * Example:
 * ```php
 * // 奇数配列と偶数配列をミックスして自然数配列を生成
 * that(array_mix([1, 3, 5], [2, 4, 6]))->isSame([1, 2, 3, 4, 5, 6]);
 * // 長さが異なる場合はそのまま追加される（短い方の足りない分は無視される）
 * that(array_mix([1], [2, 3, 4]))->isSame([1, 2, 3, 4]);
 * that(array_mix([1, 3, 4], [2]))->isSame([1, 2, 3, 4]);
 * // 可変引数なので3配列以上も可
 * that(array_mix([1], [2, 4], [3, 5, 6]))->isSame([1, 2, 3, 4, 5, 6]);
 * that(array_mix([1, 4, 6], [2, 5], [3]))->isSame([1, 2, 3, 4, 5, 6]);
 * // 文字キーは維持される
 * that(array_mix(['a' => 'A', 1, 3], ['b' => 'B', 2]))->isSame(['a' => 'A', 'b' => 'B', 1, 2, 3]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array ...$variadic 対象配列（可変引数）
 * @return array 引数配列が交互に追加された配列
 */
function array_mix(...$variadic)
{
    assert(count(array_filter($variadic, fn($v) => !is_array($v))) === 0);

    if (!$variadic) {
        return [];
    }

    $keyses = array_map('array_keys', $variadic);
    $limit = max(array_map('count', $keyses));

    $result = [];
    for ($i = 0; $i < $limit; $i++) {
        foreach ($keyses as $n => $keys) {
            if (isset($keys[$i])) {
                $key = $keys[$i];
                $val = $variadic[$n][$key];
                if (is_int($key)) {
                    $result[] = $val;
                }
                else {
                    $result[$key] = $val;
                }
            }
        }
    }
    return $result;
}
