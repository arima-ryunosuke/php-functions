<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 値を一定範囲に収める
 *
 * $circulative に true を渡すと値が循環する。
 * ただし、循環的な型に限る（整数のみ？）。
 *
 * Example:
 * ```php
 * // 5～9 に収める
 * that(clamp(4, 5, 9))->isSame(5); // 4 は [5～9] の範囲外なので 5 に切り上げられる
 * that(clamp(5, 5, 9))->isSame(5); // 範囲内なのでそのまま
 * that(clamp(6, 5, 9))->isSame(6); // 範囲内なのでそのまま
 * that(clamp(7, 5, 9))->isSame(7); // 範囲内なのでそのまま
 * that(clamp(8, 5, 9))->isSame(8); // 範囲内なのでそのまま
 * that(clamp(9, 5, 9))->isSame(9); // 範囲内なのでそのまま
 * that(clamp(10, 5, 9))->isSame(9); // 10 は [5～9] の範囲外なので 9 に切り下げられる
 *
 * // 5～9 に収まるように循環する
 * that(clamp(4, 5, 9, true))->isSame(9); // 4 は [5～9] の範囲外なので循環して 9 になる
 * that(clamp(5, 5, 9, true))->isSame(5); // 範囲内なのでそのまま
 * that(clamp(6, 5, 9, true))->isSame(6); // 範囲内なのでそのまま
 * that(clamp(7, 5, 9, true))->isSame(7); // 範囲内なのでそのまま
 * that(clamp(8, 5, 9, true))->isSame(8); // 範囲内なのでそのまま
 * that(clamp(9, 5, 9, true))->isSame(9); // 範囲内なのでそのまま
 * that(clamp(10, 5, 9, true))->isSame(5); // 10 は [5～9] の範囲外なので循環して 5 になる
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @param int|mixed $value 対象の値
 * @param int|mixed $min 最小値
 * @param int|mixed $max 最大値
 * @param bool $circulative true だと切り詰めるのではなく循環する
 * @return int 一定範囲に収められた値
 */
function clamp($value, $min, $max, $circulative = false)
{
    if (!$circulative) {
        return max($min, min($max, $value));
    }

    if ($value < $min) {
        return $max + ($value - $max) % ($max - $min + 1);
    }
    if ($value > $max) {
        return $min + ($value - $min) % ($max - $min + 1);
    }
    return $value;
}
