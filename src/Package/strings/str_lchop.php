<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/str_chop.php';
// @codeCoverageIgnoreEnd

/**
 * 先頭の指定文字列を削ぎ落とす
 *
 * Example:
 * ```php
 * // 文字列からパス文字列を削ぎ落とす
 * $PATH = '/path/to/something';
 * that(str_lchop("$PATH/hoge.php", "$PATH/"))->isSame('hoge.php');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $prefix 削ぎ落とす先頭文字列
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @return string 削ぎ落とした文字列
 */
function str_lchop(?string $string, ?string $prefix, $case_insensitivity = false)
{
    return str_chop($string, $prefix, '', $case_insensitivity);
}
