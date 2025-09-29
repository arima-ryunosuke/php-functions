<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 整数を除算した配列を返す
 *
 * 割り切れるときは array_pad([], $divisor, $int/$divisor) と同じ。
 * 割り切れないときは余剰を各要素に分配する。
 * $length が正の場合は左から埋められる。負の場合は右から埋められる。
 *
 * Example:
 * ```php
 * // 13を3つに分割（余りを左に分配）
 * that(int_divide(13, 3))->isSame([5, 4, 4]);
 * // 13を3つに分割（余りを右に分配）
 * that(int_divide(13, -3))->isSame([4, 4, 5]);
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 */
function int_divide(int $int, int $divisor): array
{
    $minus = $divisor < 0;
    $divisor = abs($divisor);

    $div = intdiv($int, $divisor);
    $mod = abs((int) ($int % $divisor));

    $result = array_pad([], $divisor, $div);

    for ($i = 0; $i < $mod; $i++) {
        $n = $i;
        if ($minus) {
            $n = $divisor - $i - 1;
        }

        if ($int > 0) {
            $result[$n]++;
        }
        else {
            $result[$n]--;
        }
    }

    return $result;
}
