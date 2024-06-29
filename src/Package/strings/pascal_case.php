<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * PascalCase に変換する
 *
 * Example:
 * ```php
 * that(pascal_case('this_is_a_pen'))->isSame('ThisIsAPen');
 * that(pascal_case('this_is-a-pen', '-_'))->isSame('ThisIsAPen');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $delimiter デリミタ（複数可）
 * @return string 変換した文字列
 */
function pascal_case(?string $string, ?string $delimiter = '_')
{
    $replacemap = array_combine(str_split($delimiter), array_pad([], strlen($delimiter), ' '));
    return strtr(ucwords(strtr($string, $replacemap)), [' ' => '']);
}
