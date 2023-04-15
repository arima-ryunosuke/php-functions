<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ファイルの拡張子を変更する。引数を省略すると拡張子を返す
 *
 * pathinfo に準拠。例えば「filename.hoge.fuga」のような形式は「fuga」が変換対象になる。
 *
 * Example:
 * ```php
 * that(file_extension('filename.ext'))->isSame('ext');
 * that(file_extension('filename.ext', 'txt'))->isSame('filename.txt');
 * that(file_extension('filename.ext', ''))->isSame('filename');
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $filename 調べるファイル名
 * @param string $extension 拡張子。nullや空文字なら拡張子削除
 * @return string 拡張子変換後のファイル名 or 拡張子
 */
function file_extension($filename, $extension = '')
{
    $pathinfo = pathinfo($filename);

    if (func_num_args() === 1) {
        return isset($pathinfo['extension']) ? $pathinfo['extension'] : null;
    }

    if (strlen($extension)) {
        $extension = '.' . ltrim($extension, '.');
    }
    $basename = $pathinfo['filename'] . $extension;

    if ($pathinfo['dirname'] === '.') {
        return $basename;
    }

    return $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $basename;
}
