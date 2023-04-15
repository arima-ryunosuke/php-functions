<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ディレクトリの最終更新日時を返す
 *
 * 「ディレクトリの最終更新日時」とは filemtime で得られる結果ではなく、「配下のファイル群で最も新しい日時」を表す。
 * ディレクトリの mtime も検出に含まれるので、ファイルを削除した場合も検知できる。
 *
 * ファイル名を与えると例外を投げる。
 * 空ディレクトリの場合は自身の mtime を返す。
 *
 * Example:
 * ```php
 * $dirname = sys_get_temp_dir() . '/mtime';
 * rm_rf($dirname);
 * mkdir($dirname);
 *
 * // この時点では現在日時（単純に自身の更新日時）
 * that(dirmtime($dirname))->isBetween(time() - 2, time());
 * // ファイルを作って更新するとその時刻
 * touch("$dirname/tmp", time() + 10);
 * that(dirmtime($dirname))->isSame(time() + 10);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $dirname ディレクトリ名
 * @param bool $recursive 再帰フラグ
 * @return int 最終更新日時
 */
function dirmtime($dirname, $recursive = true)
{
    if (!is_dir($dirname)) {
        throw new \InvalidArgumentException("'$dirname' is not directory.");
    }

    $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
    $dirtime = filemtime($dirname);
    foreach ($rdi as $path) {
        /** @var \SplFileInfo $path */
        $mtime = $path->getMTime();
        if ($path->isDir() && $recursive) {
            $mtime = max($mtime, dirmtime($path->getPathname(), $recursive));
        }
        if ($dirtime < $mtime) {
            $dirtime = $mtime;
        }
    }
    return $dirtime;
}
