<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 空文字を除外する文字列分割
 *
 * - 空文字を任意の区切り文字で分割しても常に空配列
 * - キーは連番で返す（歯抜けがないただの配列）
 *
 * $triming を指定した場合、結果配列にも影響する。
 * つまり「除外は trim したいが結果配列にはしたくない」はできない。
 *
 * Example:
 * ```php
 * that(split_noempty(',', 'a, b, c'))->isSame(['a', 'b', 'c']);
 * that(split_noempty(',', 'a, , , b, c'))->isSame(['a', 'b', 'c']);
 * that(split_noempty(',', 'a, , , b, c', false))->isSame(['a', ' ', ' ', ' b', ' c']);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $delimiter 区切り文字
 * @param string $string 対象文字
 * @param string|bool $trimchars 指定した文字を trim する。true を指定すると trim する
 * @return array 指定文字で分割して空文字を除いた配列
 */
function split_noempty(?string $delimiter, ?string $string, $trimchars = true)
{
    // trim しないなら preg_split(PREG_SPLIT_NO_EMPTY) で十分
    if (strlen($trimchars) === 0) {
        return preg_split('#' . preg_quote($delimiter, '#') . '#u', $string, -1, PREG_SPLIT_NO_EMPTY);
    }

    // trim するなら preg_split だと無駄にややこしくなるのでベタにやる
    $trim = ($trimchars === true) ? 'trim' : fn($v) => trim($v, $trimchars);
    $parts = explode($delimiter, $string);
    $parts = array_map($trim, $parts);
    $parts = array_filter($parts, 'strlen');
    $parts = array_values($parts);
    return $parts;
}
