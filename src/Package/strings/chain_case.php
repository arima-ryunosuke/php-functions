<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/snake_case.php';
// @codeCoverageIgnoreEnd

/**
 * chain-case に変換する
 *
 * Example:
 * ```php
 * that(chain_case('ThisIsAPen'))->isSame('this-is-a-pen');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $delimiter デリミタ
 * @return string 変換した文字列
 */
function chain_case($string, $delimiter = '-')
{
    return snake_case($string, $delimiter);
}
