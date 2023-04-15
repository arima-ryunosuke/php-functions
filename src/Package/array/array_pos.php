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
 * @param array $array 対象配列
 * @param int $position 取得する位置
 * @param bool $return_key true にすると値ではなくキーを返す
 * @return mixed 指定位置の値
 */
function array_pos($array, $position, $return_key = false)
{
    $position = (int) $position;
    $keys = array_keys($array);

    if ($position < 0) {
        $position = abs($position + 1);
        $keys = array_reverse($keys);
    }

    $count = count($keys);
    for ($i = 0; $i < $count; $i++) {
        if ($i === $position) {
            $key = $keys[$i];
            if ($return_key) {
                return $key;
            }
            return $array[$key];
        }
    }

    throw new \OutOfBoundsException("$position is not found.");
}
