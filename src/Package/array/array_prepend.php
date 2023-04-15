<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の先頭に要素を追加する
 *
 * array_unshift のキーが指定できる参照渡しでない版と言える。
 * 配列の数値キーは振り直される。
 * キー指定でかつそのキーが存在するとき、値を変えつつ先頭に移動する動作となる。
 *
 * Example:
 * ```php
 * // キー未指定は0で挿入される
 * that(array_prepend([1, 2, 3], 99))->is([99, 1, 2, 3]);
 * // キーを指定すればそのキーで生える
 * that(array_prepend([1, 2, 3], 99, 'newkey'))->is(['newkey' => 99, 1, 2, 3]);
 * // 存在する場合は値が変わって先頭に移動する
 * that(array_prepend([1, 2, 3], 99, 1))->is([1 => 99, 0 => 1, 2 => 3]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @return array 要素が追加された配列
 */
function array_prepend($array, $value, $key = null)
{
    if ($key === null) {
        $array = array_merge([$value], $array);
    }
    else {
        $array = [$key => $value] + $array;
    }
    return $array;
}
