<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/path_resolve.php';
// @codeCoverageIgnoreEnd

/**
 * パスを相対パスに変換して正規化する
 *
 * $from から $to への相対パスを返す。
 *
 * Example:
 * ```php
 * $DS = DIRECTORY_SEPARATOR;
 * that(path_relative('/a/b/c/X', '/a/b/c/d/X'))->isSame("..{$DS}d{$DS}X");
 * that(path_relative('/a/b/c/d/X', '/a/b/c/X'))->isSame("..{$DS}..{$DS}X");
 * that(path_relative('/a/b/c/X', '/a/b/c/X'))->isSame("");
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $from 元パス
 * @param string $to 対象パス
 * @return string 相対パス
 */
function path_relative($from, $to)
{
    $DS = DIRECTORY_SEPARATOR;

    $fa = array_filter(explode($DS, path_resolve($from) ?? $from), 'strlen');
    $ta = array_filter(explode($DS, path_resolve($to) ?? $to), 'strlen');

    $compare = fn($a, $b) => $DS === '\\' ? strcasecmp($a, $b) : strcmp($a, $b);
    $ca = array_udiff_assoc($fa, $ta, $compare);
    $da = array_udiff_assoc($ta, $fa, $compare);

    return str_repeat("..$DS", count($ca)) . implode($DS, $da);
}
