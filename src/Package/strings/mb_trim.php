<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * マルチバイト対応 trim
 *
 * @see https://github.com/symfony/polyfill-php84/
 * @deprecated 標準関数と重複
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\strings
 */
function mb_trim(?string $string)
{
    trigger_error(__FUNCTION__ . ' is deprecated. use symfony/polyfill or 8.4 builtin', E_USER_DEPRECATED);
    return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $string);
}
