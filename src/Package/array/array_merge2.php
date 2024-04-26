<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列をマージして通常配列＋αで返す
 *
 * キー・値が維持される点で array_merge とは異なる（振り直しをせず数値配列で返す）。
 * きちんと0からの連番で構成される点で配列の加算とは異なる。
 * 要するに「できるだけキーが自然数（の並び）になるように」マージする。
 *
 * 歯抜けはそのまま維持され、文字キーは後ろに追加される（負数キーも同様）。
 *
 * Example:
 * ```php
 * // キーが入り乱れているがよく見ると通し番号が振られている配列をマージ
 * that(array_merge2([4 => 4, 1 => 1], [0 => 0], [5 => 5, 2 => 2, 3 => 3]))->isSame([0, 1, 2, 3, 4, 5]);
 * // 歯抜けの配列をマージ
 * that(array_merge2([4 => 4, 1 => 1], [0 => 0], [5 => 5, 3 => 3]))->isSame([0, 1, 3 => 3, 4 => 4, 5 => 5]);
 * // 負数や文字キーは後ろに追いやられる
 * that(array_merge2(['a' => 'A', 1 => 1], [0 => 0], [-1 => 'X', 2 => 2, 3 => 3]))->isSame([0, 1, 2, 3, -1 => 'X', 'a' => 'A']);
 * // 同じキーは後ろ優先
 * that(array_merge2([0, 'a' => 'A0'], [1, 'a' => 'A1'], [2, 'a' => 'A2']))->isSame([2, 'a' => 'A2']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array ...$arrays マージする配列
 * @return array マージされた配列
 */
function array_merge2(...$arrays)
{
    // array_merge を模倣するため前方優先
    $arrays = array_reverse($arrays);

    // 最大値の導出（負数は考慮せず文字キーとして扱う）
    $max = -1;
    foreach ($arrays as $array) {
        foreach ($array as $k => $v) {
            if (is_int($k) && $k > $max) {
                $max = $k;
            }
        }
    }

    // 最大値までを埋める
    $result = [];
    for ($i = 0; $i <= $max; $i++) {
        foreach ($arrays as $array) {
            if (isset($array[$i]) || array_key_exists($i, $array)) {
                $result[$i] = $array[$i];
                break;
            }
        }
    }

    // 上記は数値キーだけなので負数や文字キーを補完する
    foreach ($arrays as $arg) {
        $result += $arg;
    }

    return $result;
}
