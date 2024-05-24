<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * url safe な base64_decode
 *
 * 対で使うと思うので base64_encode を参照。
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param string $string base64url 文字列
 * @return string 変換元文字列
 */
function base64url_decode($string)
{
    return base64_decode(strtr($string, ['-' => '+', '_' => '/']));
}
