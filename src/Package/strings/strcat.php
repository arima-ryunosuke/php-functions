<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列結合の関数版
 *
 * Example:
 * ```php
 * that(strcat('a', 'b', 'c'))->isSame('abc');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param mixed ...$variadic 結合する文字列（可変引数）
 * @return string 結合した文字列
 */
function strcat(?string ...$variadic)
{
    return implode('', $variadic);
}
