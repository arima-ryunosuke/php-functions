<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/pascal_case.php';
// @codeCoverageIgnoreEnd

/**
 * camelCase に変換する
 *
 * Example:
 * ```php
 * that(camel_case('this_is_a_pen'))->isSame('thisIsAPen');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $delimiter デリミタ
 * @return string 変換した文字列
 */
function camel_case($string, $delimiter = '_')
{
    return lcfirst(pascal_case($string, $delimiter));
}
