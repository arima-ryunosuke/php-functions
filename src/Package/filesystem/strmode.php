<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 8進数値を ls -l 準拠なパーミッション文字列に変換する
 *
 * 000_0000 のような6桁を想定しているが、 0000 のような3桁でも受け入れる。
 * その場合、ファイル種別のプレフィックスは付与されず、 "rwxrwxrwx" のような9文字を返す。
 *
 * Example:
 * ```php
 * // 通常ファイル 0700
 * that(strmode(010_0700))->is('-rwx------');
 * // ディレクトリ 0770
 * that(strmode(004_0770))->is('drwxrwx---');
 * // ファイル種別はなくても良い
 * that(strmode(0770))->is('rwxrwx---');
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param int $octet 8進数
 * @return string パーミッション文字列（ls -l 準拠）
 */
function strmode($octet)
{
    if (!ctype_digit("$octet")) {
        throw new \InvalidArgumentException("\$octet must be int ($octet given)");
    }
    $octet = (int) $octet;

    $map = [
        000_0000 => '',
        001_0000 => 'p',
        002_0000 => 'c',
        004_0000 => 'd',
        006_0000 => 'b',
        010_0000 => '-',
        012_0000 => 'l',
        014_0000 => 's',
    ];

    $result = '';

    $type = $octet & 077_0000;
    if (!isset($map[$type])) {
        throw new \InvalidArgumentException("unknown type " . decoct($type));
    }
    $result .= $map[$type];

    // user
    $result .= (($octet & 0400) ? 'r' : '-');
    $result .= (($octet & 0200) ? 'w' : '-');
    $result .= (($octet & 0100) ? (($octet & 0_4000) ? 's' : 'x') : (($octet & 0_4000) ? 'S' : '-'));

    // group
    $result .= (($octet & 0040) ? 'r' : '-');
    $result .= (($octet & 0020) ? 'w' : '-');
    $result .= (($octet & 0010) ? (($octet & 0_2000) ? 's' : 'x') : (($octet & 0_2000) ? 'S' : '-'));

    // other
    $result .= (($octet & 0004) ? 'r' : '-');
    $result .= (($octet & 0002) ? 'w' : '-');
    $result .= (($octet & 0001) ? (($octet & 0_1000) ? 't' : 'x') : (($octet & 0_1000) ? 'T' : '-'));

    return $result;
}
