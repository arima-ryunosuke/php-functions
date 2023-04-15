<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/str_chop.php';
// @codeCoverageIgnoreEnd

/**
 * 末尾の指定文字列を削ぎ落とす
 *
 * Example:
 * ```php
 * // 文字列から .php を削ぎ落とす
 * $PATH = '/path/to/something';
 * that(str_rchop("$PATH/hoge.php", ".php"))->isSame("$PATH/hoge");
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $suffix 削ぎ落とす末尾文字列
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @return string 削ぎ落とした文字列
 */
function str_rchop($string, $suffix, $case_insensitivity = false)
{
    return str_chop($string, '', $suffix, $case_insensitivity);
}
