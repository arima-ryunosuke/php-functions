<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/mkdir_p.php';
// @codeCoverageIgnoreEnd

/**
 * ディレクトリのコピー
 *
 * $dst に / を付けると「$dst に自身をコピー」する。付けないと「$dst に中身をコピー」するという動作になる。
 *
 * ディレクトリではなくファイルを与えても動作する（copy とほぼ同じ動作になるが、対象にディレクトリを指定できる点が異なる）。
 *
 * Example:
 * ```php
 * // /tmp/src/hoge.txt, /tmp/src/dir/fuga.txt を作っておく
 * $tmp = sys_get_temp_dir();
 * file_set_contents("$tmp/src/hoge.txt", 'hoge');
 * file_set_contents("$tmp/src/dir/fuga.txt", 'fuga');
 *
 * // "/" を付けないと中身コピー
 * cp_rf("$tmp/src", "$tmp/dst1");
 * that("$tmp/dst1/hoge.txt")->fileEquals('hoge');
 * that("$tmp/dst1/dir/fuga.txt")->fileEquals('fuga');
 * // "/" を付けると自身コピー
 * cp_rf("$tmp/src", "$tmp/dst2/");
 * that("$tmp/dst2/src/hoge.txt")->fileEquals('hoge');
 * that("$tmp/dst2/src/dir/fuga.txt")->fileEquals('fuga');
 *
 * // $src はファイルでもいい（$dst に "/" を付けるとそのディレクトリにコピーする）
 * cp_rf("$tmp/src/hoge.txt", "$tmp/dst3/");
 * that("$tmp/dst3/hoge.txt")->fileEquals('hoge');
 * // $dst に "/" を付けないとそのパスとしてコピー（copy と完全に同じ）
 * cp_rf("$tmp/src/hoge.txt", "$tmp/dst4");
 * that("$tmp/dst4")->fileEquals('hoge');
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $src コピー元パス
 * @param string $dst コピー先パス。末尾/でディレクトリであることを明示できる
 * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
 */
function cp_rf($src, $dst)
{
    $dss = '/' . (DIRECTORY_SEPARATOR === '\\' ? '\\\\' : '');
    $dirmode = preg_match("#[$dss]$#u", $dst);

    // ディレクトリでないなら copy へ移譲
    if (!is_dir($src)) {
        if ($dirmode) {
            mkdir_p($dst);
            return copy($src, $dst . basename($src));
        }
        else {
            mkdir_p(dirname($dst));
            return copy($src, $dst);
        }
    }

    if ($dirmode) {
        return cp_rf($src, $dst . basename($src));
    }

    mkdir_p($dst);

    $rdi = new \FilesystemIterator($src, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_PATHNAME);

    foreach ($rdi as $file) {
        if (is_dir($file)) {
            cp_rf($file, "$dst/" . basename($file));
        }
        else {
            copy($file, "$dst/" . basename($file));
        }
    }
    return file_exists($dst);
}
