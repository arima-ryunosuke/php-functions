<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * snake_case に変換する
 *
 * Example:
 * ```php
 * that(snake_case('ThisIsAPen'))->isSame('this_is_a_pen');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $delimiter デリミタ
 * @return string 変換した文字列
 */
function snake_case($string, $delimiter = '_')
{
    return ltrim(strtolower(preg_replace('/[A-Z]/', $delimiter . '\0', $string)), $delimiter);
}
