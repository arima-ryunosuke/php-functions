<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_maps.php';
require_once __DIR__ . '/../filesystem/path_is_absolute.php';
// @codeCoverageIgnoreEnd

/**
 * ファイルをローテーションする
 *
 * オプションは logrotate に意図的に似せてある。
 * 返り値としてローテーションファイル配列を返す。
 * 基本的に決め打ちな使い方で細かいオプションは実装していない。
 *
 * Example:
 * ```php
 * // 適当にファイルを用意
 * rm_rf(sys_get_temp_dir() . '/rotate');
 * $logfile = sys_get_temp_dir() . '/rotate/log.txt';
 * file_set_contents($logfile, '');
 * // 5回ローテートしてみる
 * foreach (range(1, 5) as $i) {
 *     file_rotate($logfile, ifempty: true, rotate: 4, compress: 2, dateformat: "-$i"); // dateformat は普通は日付書式文字列（↓の確認がしんどくなるのでここでは連番）
 * }
 * // rotate:4 効果で全部で4世代であり、compress:2 効果でうち2世代は圧縮されている
 * $dirname = dirname($logfile);
 * that(glob("$dirname/log-*"))->is([
 *     "$dirname/log-2.txt.gz",
 *     "$dirname/log-3.txt.gz",
 *     "$dirname/log-4.txt",
 *     "$dirname/log-5.txt",
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 */
function file_rotate(
    /** 対象ファイル名 */ string $filename,
    /** 空ファイルでもローテーションするか */ bool $ifempty = false,
    /** 同じファイル（inode）を使い続けるか */ bool $copytruncate = false,
    /** 既存ローテーションファイルに追記するか */ bool $append = false,
    /** ローテーションファイルのディレクトリ */ ?string $olddir = null,
    /** ローテーションファイルのサフィックス */ ?string $dateformat = null,
    /** 保持世代数（null で無世代） */ ?int $rotate = null,
    /** 圧縮世代数（例えば 3 を指定すると3世代目から圧縮される） */ ?int $compress = null,
): /** ローテーションファイル配列 */ ?array
{
    /// 共通処理

    assert(!($copytruncate && $append), 'both $copytruncate and $append are true');
    assert($rotate === null || $rotate >= 0, '$rotate is negative number');
    assert($compress === null || $compress >= 0, '$compress is negative number');

    $filename = realpath($filename);
    $pathinfo = pathinfo($filename);

    if ($filename === false) {
        return null;
    }
    if (!$ifempty && !filesize($filename)) {
        return null;
    }

    /// 世代ディレクトリ検出

    $olddir ??= $pathinfo['dirname'];
    if (!path_is_absolute($olddir)) {
        $olddir = "{$pathinfo['dirname']}/$olddir";
    }
    if (!is_dir($olddir)) {
        @mkdir($olddir, 0777, true);
        if (is_dir($olddir) === false) {
            throw new \RuntimeException("failed to mkdir($olddir)");
        }
    }

    /// ローテーション

    $oldfile = "$olddir/{$pathinfo['filename']}" . date($dateformat ?? '-Y-m-d', time()) . ".{$pathinfo['extension']}";
    if ($copytruncate) {
        if (@copy($filename, $oldfile) === false) {
            throw new \RuntimeException("failed to copy($filename, $oldfile)");
        }

        file_put_contents($filename, "");
    }
    elseif ($append) {
        if (@file_put_contents($oldfile, file_get_contents($filename), FILE_APPEND) === false) {
            throw new \RuntimeException("failed to file_put_contents($oldfile, file_get_contents($filename), FILE_APPEND)");
        }

        file_put_contents($filename, "");
    }
    else {
        if (@rename($filename, $oldfile) === false) {
            throw new \RuntimeException("failed to rename($filename, $oldfile)");
        }

        file_put_contents($filename, "");
        if (($perms = fileperms($oldfile)) !== false) {
            chmod($filename, $perms);
        }
        if (($owner = fileowner($oldfile)) !== false) {
            chown($filename, $owner);
        }
        if (($group = filegroup($oldfile)) !== false) {
            chgrp($filename, $group);
        }
    }

    /// 世代管理

    $oldfiles = glob("$olddir/{$pathinfo['filename']}*");
    $oldfiles = array_maps($oldfiles, 'realpath');
    $oldfiles = array_diff($oldfiles, [$filename]);
    rsort($oldfiles);

    // 古い世代を削除
    if ($rotate !== null) {
        foreach (array_slice($oldfiles, $rotate, null, true) as $n => $file) {
            if (unlink($file) !== false) {
                unset($oldfiles[$n]);
            }
        }
    }

    // 古い世代を圧縮
    if ($compress !== null) {
        foreach (array_slice($oldfiles, $compress, null, true) as $n => $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) !== 'gz') {
                if (file_put_contents("compress.zlib://$file.gz", file_get_contents($file)) !== false && unlink($file) !== false) {
                    $oldfiles[$n] = "$file.gz";
                }
            }
        }
    }

    return $oldfiles;
}
