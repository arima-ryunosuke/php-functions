<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/mb_pad_width.php';
// @codeCoverageIgnoreEnd

/**
 * マルチバイト版 str_pad
 *
 * @see mb_pad_width()
 * @deprecated 標準関数と重複
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\strings
 */
function mb_str_pad(?string $string, $width, $pad_string = " ", $pad_type = STR_PAD_RIGHT)
{
    trigger_error(__FUNCTION__ . ' is deprecated. use mb_pad_width', E_USER_DEPRECATED);
    return mb_pad_width($string, $width, $pad_string, $pad_type);
}
