<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の隙間を埋める
 *
 * 「隙間」とは数値キーの隙間のこと。文字キーには関与しない。
 * 連番の抜けている箇所に $values の値を順次詰めていく動作となる。
 *
 * 値が足りなくてもエラーにはならない。つまり、この関数を通したとしても隙間が無くなるわけではない。
 * また、隙間を埋めても値が余る場合（隙間より与えられた値が多い場合）は末尾に全て追加される。
 *
 * 負数キーは考慮しない。
 *
 * Example:
 * ```php
 * // ところどころキーが抜け落ちている配列の・・・
 * $array = [
 *     1 => 'b',
 *     2 => 'c',
 *     5 => 'f',
 *     7 => 'h',
 * ];
 * // 抜けているところを可変引数で順次埋める（'i', 'j' は隙間というより末尾追加）
 * that(array_fill_gap($array, 'a', 'd', 'e', 'g', 'i', 'j'))->isSame([
 *     0 => 'a',
 *     1 => 'b',
 *     2 => 'c',
 *     3 => 'd',
 *     4 => 'e',
 *     5 => 'f',
 *     6 => 'g',
 *     7 => 'h',
 *     8 => 'i',
 *     9 => 'j',
 * ]);
 *
 * // 文字キーには関与しないし、値は足りなくても良い
 * $array = [
 *     1   => 'b',
 *     'x' => 'noize',
 *     4   => 'e',
 *     'y' => 'noize',
 *     7   => 'h',
 *     'z' => 'noize',
 * ];
 * // 文字キーはそのまま保持され、値が足りないので 6 キーはない
 * that(array_fill_gap($array, 'a', 'c', 'd', 'f'))->isSame([
 *     0   => 'a',
 *     1   => 'b',
 *     'x' => 'noize',
 *     2   => 'c',
 *     3   => 'd',
 *     4   => 'e',
 *     'y' => 'noize',
 *     5   => 'f',
 *     7   => 'h',
 *     'z' => 'noize',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param mixed ...$values 詰める値（可変引数）
 * @return array 隙間が詰められた配列
 */
function array_fill_gap($array, ...$values)
{
    $n = 0;
    $keys = array_keys($array);

    $result = [];
    for ($i = 0, $l = count($keys); $i < $l; $i++) {
        $key = $keys[$i];
        if (is_string($key)) {
            $result[$key] = $array[$key];
            continue;
        }

        if (array_key_exists($n, $array)) {
            $result[] = $array[$n];
        }
        elseif ($values) {
            $result[] = array_shift($values);
            $i--;
        }
        else {
            $result[$key] = $array[$key];
        }
        $n++;
    }
    if ($values) {
        $result = array_merge($result, $values);
    }
    return $result;
}
