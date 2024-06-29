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
 * that(snake_case('URLEncode', '-'))->isSame('u-r-l-encode');     // デフォルトでは略語も分割される
 * that(snake_case('URLEncode', '-', true))->isSame('url-encode'); // 第3引数 true で略語は維持される
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $delimiter デリミタ
 * @param bool $keep_abbr すべて大文字の単語を1単語として扱うか
 * @return string 変換した文字列
 */
function snake_case(?string $string, ?string $delimiter = '_', $keep_abbr = false)
{
    $pattern = $keep_abbr ? '/[A-Z]([A-Z](?![a-z]))*/' : '/[A-Z]/';
    return ltrim(strtolower(preg_replace($pattern, $delimiter . '\0', $string)), $delimiter);
}
