<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/splitwords.php';
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
 * @param bool $screaming すべて大文字にするか（SCREAMING_SNAKE_CASE スタイル）
 * @return string 変換した文字列
 */
function snake_case(?string $string, ?string $delimiter = '_', $keep_abbr = false, $screaming = false)
{
    $result = implode($delimiter ?? '_', array_map('strtolower', splitwords($string ?? '', $keep_abbr, false)));
    if ($screaming) {
        $result = strtoupper($result);
    }
    return $result;
}
