<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 数値を指定桁数に丸める
 *
 * 感覚的には「桁数指定できる ceil/floor」に近い。
 * ただし、正の方向(ceil)、負の方向(floor)以外にも0の方向、無限大の方向も実装されている（さらに四捨五入もできる）。
 *
 * - 0   : 0 に近づく方向： 絶対値が必ず減る
 * - null: 0 から離れる方向： 絶対値が必ず増える
 * - -INF: 負の無限大の方向： 数値として必ず減る
 * - +INF : 正の無限大の方向： 数値として必ず増える
 *
 * のように「持っていきたい方向（の数値）」を指定すれば良い（正負自動だけ null で特殊だが）。
 *
 * Example:
 * ```php
 * that(decimal(-3.14, 1, 0))->isSame(-3.1);    // 0 に近づく方向
 * that(decimal(-3.14, 1, null))->isSame(-3.2); // 0 から離れる方向
 * that(decimal(-3.14, 1, -INF))->isSame(-3.2); // 負の無限大の方向
 * that(decimal(-3.14, 1, +INF))->isSame(-3.1); // 正の無限大の方向
 *
 * that(decimal(3.14, 1, 0))->isSame(3.1);    // 0 に近づく方向
 * that(decimal(3.14, 1, null))->isSame(3.2); // 0 から離れる方向
 * that(decimal(3.14, 1, -INF))->isSame(3.1); // 負の無限大の方向
 * that(decimal(3.14, 1, +INF))->isSame(3.2); // 正の無限大の方向
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @param int|float $value 丸める値
 * @param int $precision 有効桁数
 * @param mixed $mode 丸めモード（0 || null || ±INF || PHP_ROUND_HALF_XXX）
 * @return float 丸めた値
 */
function decimal($value, $precision = 0, $mode = 0)
{
    $precision = (int) $precision;

    if ($precision === 0) {
        if ($mode === 0) {
            return (float) (int) $value;
        }
        if ($mode === INF) {
            return ceil($value);
        }
        if ($mode === -INF) {
            return floor($value);
        }
        if ($mode === null) {
            return $value > 0 ? ceil($value) : floor($value);
        }
        if (in_array($mode, [PHP_ROUND_HALF_UP, PHP_ROUND_HALF_DOWN, PHP_ROUND_HALF_EVEN, PHP_ROUND_HALF_ODD], true)) {
            return round($value, $precision, $mode);
        }
        throw new \InvalidArgumentException('$precision must be either null, 0, INF, -INF');
    }

    if ($precision > 0 && 10 ** PHP_FLOAT_DIG <= abs($value)) {
        trigger_error('it exceeds the valid values', E_USER_WARNING);
    }

    $k = 10 ** $precision;
    return decimal($value * $k, 0, $mode) / $k;
}
