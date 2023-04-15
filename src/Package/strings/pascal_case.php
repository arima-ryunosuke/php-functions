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
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $delimiter デリミタ
 * @return string 変換した文字列
 */
function pascal_case($string, $delimiter = '_')
{
    return strtr(ucwords(strtr($string, [$delimiter => ' '])), [' ' => '']);
}
