<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * Damerau–Levenshtein 距離を返す
 *
 * 簡単に言えば「転置（入れ替え）を考慮したレーベンシュタイン」である。
 * 例えば "destroy" と "destory" は 「1挿入1削除=2」であるが、Damerau 版だと「1転置=1」となる。
 *
 * また、マルチバイト（UTF-8 のみ）にも対応している。
 *
 * Example:
 * ```php
 * // destroy と destory は普通にレーベンシュタイン距離を取ると 2 になるが・・・
 * that(levenshtein("destroy", "destory"))->isSame(2);
 * // damerau_levenshtein だと1である
 * that(damerau_levenshtein("destroy", "destory"))->isSame(1);
 * // UTF-8 でも大丈夫
 * that(damerau_levenshtein("あいうえお", "あいえうお"))->isSame(1);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $s1 対象文字列1
 * @param string $s2 対象文字列2
 * @param int $cost_ins 挿入のコスト
 * @param int $cost_rep 置換のコスト
 * @param int $cost_del 削除のコスト
 * @param int $cost_swp 転置のコスト
 * @return int Damerau–Levenshtein 距離
 */
function damerau_levenshtein($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1)
{
    $s1 = is_array($s1) ? $s1 : preg_split('//u', $s1, -1, PREG_SPLIT_NO_EMPTY);
    $s2 = is_array($s2) ? $s2 : preg_split('//u', $s2, -1, PREG_SPLIT_NO_EMPTY);
    $l1 = count($s1);
    $l2 = count($s2);
    if (!$l1) {
        return $l2 * $cost_ins;
    }
    if (!$l2) {
        return $l1 * $cost_del;
    }
    $p1 = array_fill(0, $l2 + 1, 0);
    $p2 = array_fill(0, $l2 + 1, 0);
    for ($i2 = 0; $i2 <= $l2; $i2++) {
        $p1[$i2] = $i2 * $cost_ins;
    }
    for ($i1 = 0; $i1 < $l1; $i1++) {
        $p2[0] = $p1[0] + $cost_del;
        for ($i2 = 0; $i2 < $l2; $i2++) {
            $c0 = $p1[$i2];
            if ($s1[$i1] !== $s2[$i2]) {
                if (
                    $cost_swp && (
                        ($s1[$i1] === ($s2[$i2 - 1] ?? '') && ($s1[$i1 - 1] ?? '') === $s2[$i2]) ||
                        ($s1[$i1] === ($s2[$i2 + 1] ?? '') && ($s1[$i1 + 1] ?? '') === $s2[$i2])
                    )
                ) {
                    $c0 += $cost_swp / 2;
                }
                else {
                    $c0 += $cost_rep;
                }
            }
            $c1 = $p1[$i2 + 1] + $cost_del;
            if ($c1 < $c0) {
                $c0 = $c1;
            }
            $c2 = $p2[$i2] + $cost_ins;
            if ($c2 < $c0) {
                $c0 = $c2;
            }
            $p2[$i2 + 1] = $c0;
        }
        $tmp = $p1;
        $p1 = $p2;
        $p2 = $tmp;
    }
    return (int) $p1[$l2];
}
