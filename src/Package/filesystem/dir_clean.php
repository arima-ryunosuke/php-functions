<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/fnmatch_or.php';
// @codeCoverageIgnoreEnd

/**
 * 指定条件のファイル・ディレクトリを再帰的に消す
 *
 * tmpwatch みたいなもので、キャッシュなどのゴミ掃除に使う想定。
 *
 * Example:
 * ```php
 * // 1時間以上アクセスのないファイルを消す
 * dir_clean(sys_get_temp_dir() . '/cache',
 *     atime: 3600,
 * );
 * // 1時間以上更新されていないファイルを消す
 * dir_clean(sys_get_temp_dir() . '/cache',
 *     mtime: 3600,
 * );
 * // 2時間以上アクセスのない かつ 1時間以上更新されていないファイルを消す（両指定は AND）
 * dir_clean(sys_get_temp_dir() . '/cache',
 *     atime: 7200,
 *     mtime: 3600,
 * );
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 */
function dir_clean(
    /** 対象ディレクトリ */ string $directory,
    /** 対象アクセス日時秒数 */ int $atime = 0,
    /** 対象更新日時秒数 */ int $mtime = 0,
    /** 除外パターン */ string|array $excludePattern = [],
): /** 消したエントリ配列 */ array
{
    if (!is_dir($directory)) {
        return [];
    }

    $rdi = new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_SELF | \FilesystemIterator::UNIX_PATHS);
    $iterator = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

    $now = time();
    $result = [];

    /** @var \RecursiveDirectoryIterator $it */
    foreach ($iterator as $it) {
        $fullpath = $it->getPathname();

        if ($excludePattern && fnmatch_or($excludePattern, $fullpath)) {
            continue;
        }

        if ($it->isDir()) {
            // 中身があるとか権限があるとか判定するより「やってみてダメだったら」の方が手っ取り早い
            if (@rmdir($fullpath)) {
                $result[] = $fullpath;
            }
        }
        else {
            if (($now - $atime) < $it->getATime()) {
                continue;
            }
            if (($now - $mtime) < $it->getMTime()) {
                continue;
            }

            // 別にアトミックではないので存在しないこともある
            if (@unlink($fullpath)) {
                $result[] = $fullpath;
            }
        }
    }

    return $result;
}
