<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の指定キーの位置を返す
 *
 * $key に配列を与えるとその全ての位置を返す。
 *
 * Example:
 * ```php
 * that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'c'))->isSame(2);
 * that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x', -1))->isSame(-1);
 *  that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['a', 'c']))->isSame(['a' => 0, 'c' => 2]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param string|int|array $key 取得したい位置のキー
 * @param mixed $default 見つからなかったときのデフォルト値。指定しないと例外。$key が配列の場合は見つからなかったキー全てに代入される
 * @return int|int[] 指定キーの位置
 */
function array_pos_key($array, $key, $default = null)
{
    // very slow
    // return array_flip(array_keys($array))[$key];

    $is_array = is_array($key);
    $key = array_flip((array) $key);

    $result = [];
    $n = 0;
    foreach ($array as $k => $v) {
        if (isset($key[$k])) {
            if (!$is_array) {
                return $n;
            }
            else {
                $result[$k] = $n;
            }
        }
        $n++;
    }

    if (func_num_args() === 2) {
        if (count($result) !== count($key)) {
            throw new \OutOfBoundsException(implode(',', $key) . " is not found.");
        }
    }

    if ($is_array) {
        return $result + array_fill_keys(array_keys($key), $default);
    }

    return $default;
}
