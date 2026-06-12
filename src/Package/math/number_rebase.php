<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../math/base_convert_array.php';
// @codeCoverageIgnoreEnd

/**
 * 数値の任意基数変換
 *
 * 任意の文字を指定できる基数変換。
 * 10,16,64 等の基数の代わりに使用文字列を渡す。その文字長が基数となる。
 *
 * Example:
 * ```php
 * // XYZ を使用した13進数
 * that(number_rebase('4042', to: '0123456789XYZ', from: BASE10))->isSame('1XYZ');
 * that(number_rebase('1XYZ', to: BASE10, from: '0123456789XYZ'))->isSame('4042');
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 */
function number_rebase(string $number, string $to, string $from): string
{
    $number = trim($number);

    if (!strlen($number)) {
        return '';
    }
    if ($to === $from) {
        return $number;
    }

    $sign = match ($number[0]) {
        '-'     => '-',
        '+'     => '+',
        default => '',
    };
    if ($sign !== '') {
        if (str_contains($to, $sign)) {
            throw new \InvalidArgumentException('$number contains +/- sign, but $to also contains one');
        }
        if (!str_contains($from, $sign)) {
            $number = substr($number, 1);
        }
        if (!strlen($number)) {
            throw new \InvalidArgumentException("\$number is invalid($sign$number)");
        }
    }

    if ($number === '0') {
        return $sign . $number;
    }

    //$to = array_flip(str_split($to));
    $from = array_flip(str_split($from));

    $chars = str_split($number);
    $digits = array_map(fn($v) => $from[$v] ?? throw new \InvalidArgumentException("found unknown char({$v})"), $chars);
    $converted = base_convert_array($digits, count($from), strlen($to));
    return $sign . implode('', array_map(fn($v) => $to[$v], $converted));
}
