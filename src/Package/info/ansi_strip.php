<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ANSI エスケープ文字を取り除く
 *
 * Example:
 * ```php
 * $ansi_string = ansi_colorize('hoge', 'bold red');
 * // エスケープ文字も含めて 19 文字
 * that(strlen($ansi_string))->isSame(19);
 * // ansi_strip すると本来の hoge がえられる
 * that(ansi_strip($ansi_string))->isSame('hoge');
 * ```
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param string $string 対象文字列
 * @return string ANSI エスケープ文字が取り除かれた文字
 */
function ansi_strip($string)
{
    return preg_replace('#\\e\\[.+?(;.+?)*(?<!;)[a-z]#ui', '', $string);
}
