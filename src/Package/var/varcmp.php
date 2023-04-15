<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * php7 の `<=>` の関数版
 *
 * 引数で大文字小文字とか自然順とか型モードとかが指定できる。
 * さらに追加で SORT_STRICT という厳密比較フラグを渡すことができる。
 *
 * Example:
 * ```php
 * // 'a' と 'z' なら 'z' の方が大きい
 * that(varcmp('z', 'a') > 0)->isTrue();
 * that(varcmp('a', 'z') < 0)->isTrue();
 * that(varcmp('a', 'a') === 0)->isTrue();
 *
 * // 'a' と 'Z' なら 'a' の方が大きい…が SORT_FLAG_CASE なので 'Z' のほうが大きい
 * that(varcmp('Z', 'a', SORT_FLAG_CASE) > 0)->isTrue();
 * that(varcmp('a', 'Z', SORT_FLAG_CASE) < 0)->isTrue();
 * that(varcmp('a', 'A', SORT_FLAG_CASE) === 0)->isTrue();
 *
 * // '2' と '12' なら '2' の方が大きい…が SORT_NATURAL なので '12' のほうが大きい
 * that(varcmp('12', '2', SORT_NATURAL) > 0)->isTrue();
 * that(varcmp('2', '12', SORT_NATURAL) < 0)->isTrue();
 *
 * // SORT_STRICT 定数が使える（下記はすべて宇宙船演算子を使うと 0 になる）
 * that(varcmp(['a' => 'A', 'b' => 'B'], ['b' => 'B', 'a' => 'A'], SORT_STRICT) < 0)->isTrue();
 * that(varcmp((object) ['a'], (object) ['a'], SORT_STRICT) < 0)->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $a 比較する値1
 * @param mixed $b 比較する値2
 * @param ?int $mode 比較モード（SORT_XXX）。省略すると型でよしなに選択
 * @param ?int $precision 小数比較の際の誤差桁
 * @return int 等しいなら 0、 $a のほうが大きいなら > 0、 $bのほうが大きいなら < 0
 */
function varcmp($a, $b, $mode = null, $precision = null)
{
    // 負数は逆順とみなす
    $reverse = 1;
    if ($mode < 0) {
        $reverse = -1;
        $mode = -$mode;
    }

    // null が来たらよしなにする（なるべく型に寄せるが SORT_REGULAR はキモいので避ける）
    if ($mode === null || $mode === SORT_FLAG_CASE) {
        if ((is_int($a) || is_float($a)) && (is_int($b) || is_float($b))) {
            $mode = SORT_NUMERIC;
        }
        elseif (is_string($a) && is_string($b)) {
            $mode = SORT_STRING | $mode; // SORT_FLAG_CASE が単品で来てるかもしれないので混ぜる
        }
    }

    $flag_case = $mode & SORT_FLAG_CASE;
    $mode = $mode & ~SORT_FLAG_CASE;

    if ($mode === SORT_NUMERIC) {
        $delta = $a - $b;
        if ($precision > 0 && abs($delta) < pow(10, -$precision)) {
            return 0;
        }
        return $reverse * (0 < $delta ? 1 : ($delta < 0 ? -1 : 0));
    }
    if ($mode === SORT_STRING) {
        if ($flag_case) {
            return $reverse * strcasecmp($a, $b);
        }
        return $reverse * strcmp($a, $b);
    }
    if ($mode === SORT_NATURAL) {
        if ($flag_case) {
            return $reverse * strnatcasecmp($a, $b);
        }
        return $reverse * strnatcmp($a, $b);
    }
    if ($mode === SORT_STRICT) {
        return $reverse * ($a === $b ? 0 : ($a > $b ? 1 : -1));
    }

    // for SORT_REGULAR
    return $reverse * ($a == $b ? 0 : ($a > $b ? 1 : -1));
}
