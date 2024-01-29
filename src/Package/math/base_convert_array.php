<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列を対象とした base_convert
 *
 * 配列の各要素を数値の桁とみなして基数を変換する。
 *
 * Example:
 * ```php
 * // 123(10進)を7B(16進)に変換
 * that(base_convert_array([1, 2, 3], 10, 16))->isSame([7, 11]);
 * // つまりこういうこと（10 * 10^2 + 20 * 10^1 + 30 * 10^0 => 4 * 16^2 + 12 * 16^1 + 14 * 16^0）
 * that(base_convert_array([10, 20, 30], 10, 16))->isSame([4, 12, 14]);
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @copyright 2011 Anthony Ferrara
 * @copyright 2016-2021 Mika Tuupola
 * @see https://github.com/tuupola/base62/blob/2.x/LICENSE
 *
 * @param array $array 対象配列
 * @param int $from_base 変換元基数
 * @param int $to_base 変換先基数
 * @return array 基数変換後の配列
 */
function base_convert_array($array, $from_base, $to_base)
{
    assert($from_base > 0);
    assert($to_base > 0);

    // 隠し第4引数が false の場合は gmp を使わない（ロジックのテスト用なので実運用で渡してはならない）
    if (extension_loaded('gmp') && !(func_num_args() === 4 && func_get_arg(3) === false)) {
        $array = array_values(array_reverse($array));
        $bigint = array_reduce(array_keys($array), fn($carry, $i) => $carry + $array[$i] * gmp_pow($from_base, $i), 0);
        $result = [];
        while (gmp_cmp($bigint, 0)) {
            [$bigint, $result[]] = gmp_div_qr($bigint, $to_base);
        }
        return array_reverse(array_map(fn($v) => gmp_intval($v), $result));
    }

    $result = [];
    while ($array) {
        $remainder = 0;
        $quotients = [];
        foreach ($array as $v) {
            $accumulator = $v + $remainder * $from_base;
            $remainder = $accumulator % $to_base;
            $quotient = ($accumulator - ($accumulator % $to_base)) / $to_base;

            if ($quotient || count($quotients)) {
                $quotients[] = $quotient;
            }
        }
        $result[] = $remainder;
        $array = $quotients;
    }
    return array_reverse($result);
}
