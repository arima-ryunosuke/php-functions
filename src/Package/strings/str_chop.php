<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 先頭・末尾の指定文字列を削ぎ落とす
 *
 * Example:
 * ```php
 * // 文字列からパス文字列と拡張子を削ぎ落とす
 * $PATH = '/path/to/something';
 * that(str_chop("$PATH/hoge.php", "$PATH/", '.php'))->isSame('hoge');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $prefix 削ぎ落とす先頭文字列
 * @param string $suffix 削ぎ落とす末尾文字列
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @return string 削ぎ落とした文字列
 */
function str_chop(?string $string, ?string $prefix = '', ?string $suffix = '', $case_insensitivity = false)
{
    $pattern = [];
    if (strlen($prefix)) {
        $pattern[] = '(\A' . preg_quote($prefix, '#') . ')';
    }
    if (strlen($suffix)) {
        $pattern[] = '(' . preg_quote($suffix, '#') . '\z)';
    }
    $flag = 'u' . ($case_insensitivity ? 'i' : '');
    return preg_replace('#' . implode('|', $pattern) . '#' . $flag, '', $string);
}
