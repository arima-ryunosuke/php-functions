<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の各要素の間に要素を差し込む
 *
 * 歴史的な理由はないが、引数をどちらの順番でも受けつけることが可能。
 * ただし、$glue を先に渡すパターンの場合は配列指定が可変引数渡しになる。
 *
 * 文字キーは保存されるが数値キーは再割り振りされる。
 *
 * Example:
 * ```php
 * // (配列, 要素) の呼び出し
 * that(array_implode(['a', 'b', 'c'], 'X'))->isSame(['a', 'X', 'b', 'X', 'c']);
 * // (要素, ...配列) の呼び出し
 * that(array_implode('X', 'a', 'b', 'c'))->isSame(['a', 'X', 'b', 'X', 'c']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable|string $array 対象配列
 * @param string $glue 差し込む要素
 * @return array 差し込まれた配列
 */
function array_implode($array, $glue)
{
    // 第1引数が回せない場合は引数を入れ替えて可変引数パターン
    if (!is_array($array) && !$array instanceof \Traversable) {
        return array_implode(array_slice(func_get_args(), 1), $array);
    }

    $result = [];
    foreach ($array as $k => $v) {
        if (is_int($k)) {
            $result[] = $v;
        }
        else {
            $result[$k] = $v;
        }
        $result[] = $glue;
    }
    array_pop($result);
    return $result;
}
