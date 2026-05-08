<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/splitwords.php';
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
    return implode('', array_map('ucfirst', splitwords($string ?? '', false, true, $delimiter ?? '_')));
}
