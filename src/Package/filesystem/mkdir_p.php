<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ディレクトリを再帰的に掘る
 *
 * 既に存在する場合は何もしない（エラーも出さない）。
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $dirname ディレクトリ名
 * @param int $umask ディレクトリを掘る際の umask
 * @return bool 作成したら true
 */
function mkdir_p($dirname, $umask = 0002)
{
    if (func_num_args() === 1) {
        $umask = umask();
    }

    if (file_exists($dirname)) {
        return false;
    }

    return mkdir($dirname, 0777 & (~$umask), true);
}
