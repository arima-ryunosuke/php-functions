<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * マルチバイト対応 trim
 *
 * Example:
 * ```php
 * that(mb_trim(' 　 あああ　 　'))->isSame('あああ');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @return string trim した文字列
 */
function mb_trim(?string $string)
{
    return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $string);
}
