<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * url safe な base64_encode
 *
 * れっきとした RFC があるのかは分からないが '+' => '-', '/' => '_' がデファクトだと思うのでそのようにしてある。
 * パディングの = も外す。
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param string $string 変換元文字列
 * @return string base64url 文字列
 */
function base64url_encode($string)
{
    return rtrim(strtr(base64_encode($string), ['+' => '-', '/' => '_']), '=');
}
