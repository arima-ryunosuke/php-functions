<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 10進数小数文字列を返す
 *
 * 指数表記や誤差などは除去してできるだけ「一般人の感覚」に近い文字列を返す。
 * $precision で精度も指定できるがまぁ渡すことはあまりないだろう。
 *
 * Example:
 * ```php
 * // 右0詰めは行われない（%F だと詰められる）
 * that(decimalstr(1.234))->isSame('1.234');
 * // .0 は失われない（%H だと失われる）
 * that(decimalstr(3.0))->isSame('3.0');
 * // 指数表記にならない（%F は指数表記になる）
 * that(decimalstr(1000000.0))->isSame('1000000.0');
 * that(decimalstr(0.000001))->isSame('0.000001');
 * // -INF は -INF になる（%H,%F だとなぜか INF になる）
 * that(decimalstr(-INF))->isSame('-INF');
 * // デフォルトの精度は16
 * that(decimalstr(M_PI))->isSame('3.141592653589793');
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 */
function decimalstr(float $number, int $precision = 16): string
{
    // -INF が INF になる不具合？ があるっぽいので特別扱いしておく（これらだけ E 以外の文字が出現するので特別扱いは別におかしくない）
    if (is_infinite($number) || is_nan($number)) {
        return (string) $number;
    }

    $string = sprintf("%.{$precision}H", $number);

    // %H は 1.0 などが 1 になるので付け足す
    if (!str_contains($string, '.')) {
        return "$string.0";
    }

    // 指数記法が出現したら %F で戻す
    if (str_contains($string, 'E')) {
        $string = rtrim(sprintf("%.{$precision}F", $number), '0');
        if ($string[-1] === '.') {
            $string .= '0';
        }
    }

    return $string;
}
