<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_arithmetic.php';
// @codeCoverageIgnoreEnd

/**
 * 数値比較の関数版
 *
 * $number1 が $number2 より大きければ正数、小さければ負数、等しければ 0 を返す。
 * 要するに $number1 <=> $number2 と同じだが、演算子だと型チェックが効かず、厳密な型で比較したい場合にいちいち is_系を挟まなければならない。
 * しかもその場合は数値的文字列（"3.14" 等）は許容するケースも多く、判定が非常にめんどくさいので関数があった方が便利。
 * この関数は数値演算不可能の場合に TypeError を投げる。
 *
 * Example:
 * ```php
 * that(['hoge'] <=> 0)->gt(0);                       // php はこんなのが平気で許容されるが、多くの場合これはバグだろうのでエラーにしたい
 * //that(numcmp(['hoge'], 0))->gt(0);                // numcmp は TypeError を投げる
 * that(numcmp(1, 0))->gt(0);                         // 結果自体は要するに 1 <=> 0 と同じ
 * that(numcmp(gmp_init("0"), gmp_init("1")))->lt(0); // gmp も対応している
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 */
function numcmp($number1, $number2): int
{
    if (!is_arithmetic($number1)) {
        throw new \TypeError(sprintf('%s(): Argument #1 ($number1) must be of type arithmetic, %s given, called', __FUNCTION__, get_debug_type($number1)));
    }
    if (!is_arithmetic($number2)) {
        throw new \TypeError(sprintf('%s(): Argument #2 ($number2) must be of type arithmetic, %s given, called', __FUNCTION__, get_debug_type($number1)));
    }

    // 数値的オブジェクトを許容するために少し冗長にやらなければならない
    // 例えば === 0 してしまうとオブジェクト全般でおかしくなる
    // 例えば <=> を使うと SimpleXML でおかしくなる
    $diff = $number1 - $number2;
    return $diff > 0 ? 1 : ($diff < 0 ? -1 : 0);
}
