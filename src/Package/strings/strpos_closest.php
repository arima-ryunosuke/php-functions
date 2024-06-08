<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/strposr.php';
// @codeCoverageIgnoreEnd

/**
 * 指定位置から左右どちらかの探索を行う
 *
 * 一つ前/後の指定文字の位置を返す
 * 端的に言えば strpo/strposr の自動使い分け＋範囲外でもエラーにならない版。
 *
 * $nth は負数で左探索、正数で右探索だが、スキップ数も兼ねる。
 *
 * Example:
 * ```php
 * //        +0123456789A1234567
 * //        -7654321A9876543210
 * $string = 'hello hello hello';
 *
 * // 0文字目から右探索すれば0文字目が引っかかる
 * that(strpos_closest($string, 'hello', 0, +1))->isSame(0);
 * // ↑のスキップ（2つ目）版
 * that(strpos_closest($string, 'hello', 0, +2))->isSame(6);
 * // 5文字目から右探索すれば6文字目が引っかかる
 * that(strpos_closest($string, 'hello', 5, +1))->isSame(6);
 * // ↑のスキップ（2つ目）版
 * that(strpos_closest($string, 'hello', 5, +2))->isSame(12);
 * // 8文字目から右探索すれば12文字目が引っかかる（2個目の hello の途中なので3個目の hello から引っかかる）
 * that(strpos_closest($string, 'hello', 8, +1))->isSame(12);
 * // ↑のスキップ（2つ目）版
 * that(strpos_closest($string, 'hello', 8, +2))->isSame(null);
 *
 * // 0文字目から左探索しても見つからない
 * that(strpos_closest($string, 'hello', 0, -1))->isSame(null);
 * // 5文字目から左探索すれば0文字目が引っかかる
 * that(strpos_closest($string, 'hello', 5, -1))->isSame(0);
 * // 8文字目から左探索すれば0文字目が引っかかる（2個目の hello の途中なので1個目の hello から引っかかる）
 * that(strpos_closest($string, 'hello', 8, -1))->isSame(0);
 * // 11文字目から左探索すれば6文字目が引っかかる
 * that(strpos_closest($string, 'hello', 11, -1))->isSame(6);
 * // ↑のスキップ（2つ目）版
 * that(strpos_closest($string, 'hello', 11, -2))->isSame(0);
 *
 * // 範囲外でもエラーにならない
 * that(strpos_closest($string, 'hello', -999, +1))->isSame(0);  // 「数直線のはるか左方から探索を始めて 0 文字目で見つかった」のようなイメージ
 * that(strpos_closest($string, 'hello', +999, -1))->isSame(12); // 「数直線のはるか右方から探索を始めて 12 文字目で見つかった」のようなイメージ
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $haystack 対象文字列
 * @param string $needle 位置を取得したい文字列
 * @param ?int $offset 開始位置。 null を渡すと $nth の方向に応じて自動で定まる
 * @param int $nth 左右指定兼スキップ数（正数で右探索、負数で左探索）
 * @return ?int 見つかった位置
 */
function strpos_closest(string $haystack, string $needle, ?int $offset = null, int $nth = 1): ?int
{
    assert($nth !== 0);

    $reverse = $nth < 0;
    $nth = abs($nth);

    $offset ??= $reverse ? strlen($haystack) : 0;

    for ($i = 0; $i < $nth; $i++) {
        if ($i > 0) {
            $offset++;
        }

        if ($offset < -strlen($haystack)) {
            $offset = -strlen($haystack);
        }
        if ($offset > strlen($haystack)) {
            $offset = strlen($haystack);
        }

        if ($reverse) {
            $offset = strposr($haystack, $needle, $offset);
        }
        else {
            $offset = strpos($haystack, $needle, $offset);
        }

        if ($offset === false) {
            return null;
        }
    }
    return $offset;
}
