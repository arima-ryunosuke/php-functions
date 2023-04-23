<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ls -l 準拠なパーミッション文字列を8進数値に変換する
 *
 * drwxrwxrwx のような10文字を想定しているが、 rwxrwxrwx のような9文字でも受け入れる。
 *
 * set や sticky は現時点では未対応。
 *
 * Example:
 * ```php
 * // 通常ファイル rwx------
 * that(strmode2oct('-rwx------'))->is(010_0700);
 * // ディレクトリ rwxrwx---
 * that(strmode2oct('drwxrwx---'))->is(004_0770);
 * // 9文字でも良い
 * that(strmode2oct('rwxrwx---'))->is(0770);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $perms パーミッション文字列（ls -l 準拠）
 * @return int 8進数
 */
function strmode2oct($perms)
{
    if (!preg_match('#^(?<type>[pcdb\-ls])?(?<user>[\-r][\-w][\-xsS])(?<group>[\-r][\-w][\-xsS])(?<other>[\-r][\-w][\-xtT])$#', $perms, $matches)) {
        throw new \InvalidArgumentException("$perms is failed to parse. invalid permission");
    }

    $map = [
        'type'  => [
            ''  => 000_0000,
            'p' => 001_0000,
            'c' => 002_0000,
            'd' => 004_0000,
            'b' => 006_0000,
            '-' => 010_0000,
            'l' => 012_0000,
            's' => 014_0000,
        ],
        'user'  => [
            '-' => 000_0000,
            'r' => 000_0400,
            'w' => 000_0200,
            'x' => 000_0100,
            'S' => 000_4000,
            's' => 000_4100,
        ],
        'group' => [
            '-' => 000_0000,
            'r' => 000_0040,
            'w' => 000_0020,
            'x' => 000_0010,
            'S' => 000_2000,
            's' => 000_2010,
        ],
        'other' => [
            '-' => 000_0000,
            'r' => 000_0004,
            'w' => 000_0002,
            'x' => 000_0001,
            'T' => 000_1000,
            't' => 000_1001,
        ],
    ];

    $result = 0;

    foreach (['type', 'user', 'group', 'other'] as $class) {
        foreach (str_split($matches[$class]) as $char) {
            $result += $map[$class][$char];
        }
    }

    return $result;
}
