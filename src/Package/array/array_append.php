<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の末尾に要素を追加する
 *
 * array_push のキーが指定できる参照渡しでない版と言える。
 * キー指定でかつそのキーが存在するとき、値を変えつつ末尾に移動する動作となる。
 *
 * Example:
 * ```php
 * // キー未指定は言語機構を利用して末尾に追加される
 * that(array_append([1, 2, 3], 99))->is([1, 2, 3, 99]);
 * // キーを指定すればそのキーで生える
 * that(array_append([1, 2, 3], 99, 'newkey'))->is([1, 2, 3, 'newkey' => 99]);
 * // 存在する場合は値が変わって末尾に移動する
 * that(array_append([1, 2, 3], 99, 1))->is([0 => 1, 2 => 3, 1 => 99]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @return array 要素が追加された配列
 */
function array_append($array, $value, $key = null)
{
    if ($key === null) {
        $array[] = $value;
    }
    else {
        unset($array[$key]);
        $array[$key] = $value;
    }
    return $array;
}
