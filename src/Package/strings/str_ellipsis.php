<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/mb_substr_replace.php';
// @codeCoverageIgnoreEnd

/**
 * 文字列を指定数に丸める
 *
 * mb_strimwidth と似ているが、省略文字の差し込み位置を $pos で指定できる。
 * $pos は負数が指定できる。負数の場合後ろから数えられる。
 * 省略した場合は真ん中となる。
 *
 * Example:
 * ```php
 * // 8文字に丸める（$pos 省略なので真ん中が省略される）
 * that(str_ellipsis('1234567890', 8, '...'))->isSame('12...890');
 * // 8文字に丸める（$pos=1 なので1文字目から省略される）
 * that(str_ellipsis('1234567890', 8, '...', 1))->isSame('1...7890');
 * // 8文字に丸める（$pos=-1 なので後ろから1文字目から省略される）
 * that(str_ellipsis('1234567890', 8, '...', -1))->isSame('1234...0');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param int $width 丸める幅
 * @param string $trimmarker 省略文字列
 * @param int|null $pos 省略記号の差し込み位置
 * @return string 丸められた文字列
 */
function str_ellipsis(?string $string, $width, $trimmarker = '...', $pos = null)
{
    $strlen = mb_strlen($string);
    if ($strlen <= $width) {
        return $string;
    }

    $markerlen = mb_strlen($trimmarker);
    if ($markerlen >= $width) {
        return $trimmarker;
    }

    $length = $width - $markerlen;
    $pos ??= (int) ($length / 2);
    if ($pos < 0) {
        $pos += $length;
    }
    $pos = max(0, min($pos, $length));

    return mb_substr_replace($string, $trimmarker, $pos, $strlen - $length);
}
