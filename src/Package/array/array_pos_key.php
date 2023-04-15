<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の指定キーの位置を返す
 *
 * Example:
 * ```php
 * that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'c'))->isSame(2);
 * that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x', -1))->isSame(-1);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param string|int $key 取得する位置
 * @param mixed $default 見つからなかったときのデフォルト値。指定しないと例外
 * @return mixed 指定キーの位置
 */
function array_pos_key($array, $key, $default = null)
{
    // very slow
    // return array_flip(array_keys($array))[$key];

    $n = 0;
    foreach ($array as $k => $v) {
        if ($k === $key) {
            return $n;
        }
        $n++;
    }

    if (func_num_args() === 2) {
        throw new \OutOfBoundsException("$key is not found.");
    }
    return $default;
}
