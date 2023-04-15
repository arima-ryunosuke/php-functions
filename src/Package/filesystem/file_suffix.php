<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ファイル名にサフィックスを付与する
 *
 * pathinfoに非準拠。例えば「filename.hoge.fuga」のような形式は「filename」が変換対象になる。
 *
 * Example:
 * ```php
 * that(file_suffix('filename.ext', '-min'))->isSame('filename-min.ext');
 * that(file_suffix('filename.ext1.ext2', '-min'))->isSame('filename-min.ext1.ext2');
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $filename パス・ファイル名
 * @param string $suffix 付与するサフィックス
 * @return string サフィックスが付与されたパス名
 */
function file_suffix($filename, $suffix)
{
    $pathinfo = pathinfo($filename);
    $dirname = $pathinfo['dirname'];

    $exts = [];
    while (isset($pathinfo['extension'])) {
        $exts[] = '.' . $pathinfo['extension'];
        $pathinfo = pathinfo($pathinfo['filename']);
    }

    $basename = $pathinfo['filename'] . $suffix . implode('', array_reverse($exts));

    if ($dirname === '.') {
        return $basename;
    }

    return $dirname . DIRECTORY_SEPARATOR . $basename;
}
