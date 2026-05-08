<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/snake_case.php';
// @codeCoverageIgnoreEnd

/**
 * Train-Case に変換する
 *
 * Example:
 * ```php
 * that(train_case('ThisIsAPen'))->isSame('This-Is-A-Pen');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $delimiter デリミタ
 * @param bool $keep_abbr すべて大文字の単語を1単語として扱うか
 * @return string 変換した文字列
 */
function train_case(?string $string, ?string $delimiter = '-', $keep_abbr = false)
{
    return ucwords(snake_case($string, $delimiter, $keep_abbr), $delimiter);
}
