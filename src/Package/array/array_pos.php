<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列・連想配列を問わず「N番目(0ベース)」の要素を返す
 *
 * 負数を与えると逆から N 番目となる。
 *
 * Example:
 * ```php
 * that(array_pos([1, 2, 3], 1))->isSame(2);
 * that(array_pos([1, 2, 3], -1))->isSame(3);
 * that(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1))->isSame('B');
 * that(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1, true))->isSame('b');
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable&\Countable $array 対象配列
 * @param int $position 取得する位置
 * @param bool $return_key true にすると値ではなくキーを返す
 * @return mixed 指定位置の値
 */
function array_pos($array, int $position, $return_key = false)
{
    $target = $position >= 0 ? $position : count($array) + $position;

    $i = 0;
    foreach ($array as $k => $v) {
        if ($i++ === $target) {
            if ($return_key) {
                return $k;
            }
            return $v;
        }
    }

    throw new \OutOfBoundsException("$position is not found.");
}
