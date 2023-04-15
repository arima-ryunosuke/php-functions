<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * マルチバイト対応 substr_replace
 *
 * 本家は配列を与えたりできるが、ややこしいし使う気がしないので未対応。
 *
 * Example:
 * ```php
 * // 2文字目から5文字を「あいうえお」に置換する
 * that(mb_substr_replace('０１２３４５６７８９', 'あいうえお', 2, 5))->isSame('０１あいうえお７８９');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $replacement 置換文字列
 * @param int $start 開始位置
 * @param ?int $length 置換長
 * @return string 置換した文字列
 */
function mb_substr_replace($string, $replacement, $start, $length = null)
{
    $string = (string) $string;

    $strlen = mb_strlen($string);
    if ($start < 0) {
        $start += $strlen;
    }
    if ($length === null) {
        $length = $strlen;
    }
    if ($length < 0) {
        $length += $strlen - $start;
    }

    return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length);
}
