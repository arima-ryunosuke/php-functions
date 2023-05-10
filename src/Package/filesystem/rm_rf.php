<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 中身があっても消せる rmdir
 *
 * Example:
 * ```php
 * mkdir(sys_get_temp_dir() . '/new/make/dir', 0777, true);
 * rm_rf(sys_get_temp_dir() . '/new');
 * that(file_exists(sys_get_temp_dir() . '/new'))->isSame(false);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $dirname 削除するディレクトリ名。glob パターンが使える
 * @param bool $self 自分自身も含めるか。false を与えると中身だけを消す
 * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
 */
function rm_rf($dirname, $self = true)
{
    $main = static function ($dirname, $self) {
        if (!file_exists($dirname)) {
            return false;
        }

        $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
        $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($rii as $it) {
            if ($it->isFile() || $it->isLink()) {
                unlink($it->getPathname());
            }
            else {
                rmdir($it->getPathname());
            }
        }

        return !$self || rmdir($dirname);
    };

    if (is_file($dirname) || is_link($dirname)) {
        return unlink($dirname);
    }
    // ↓で glob してるので、ディレクトリ判定しないとリモートファイルに対応できない
    if (is_dir($dirname)) {
        return $main($dirname, $self);
    }

    $result = true;
    $targets = glob($dirname, GLOB_BRACE | GLOB_NOCHECK | ($self ? 0 : GLOB_ONLYDIR));
    foreach ($targets as $target) {
        $result = $main($target, $self) && $result;
    }
    return $result;
}
