<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/file_set_contents.php';
require_once __DIR__ . '/../filesystem/mkdir_p.php';
require_once __DIR__ . '/../filesystem/path_normalize.php';
// @codeCoverageIgnoreEnd

/**
 * ツリー構造で file_set_contents する
 *
 * 値が配列の場合はディレクトリ、それ以外の場合はファイルとなる。
 * 値がクロージャーの場合はコールされる。
 * 返り値として書き込んだバイト数のフルパス配列を返す。
 *
 * Example:
 * ```php
 * // 一時ディレクトリにツリー構造でファイルを配置する
 * $root = sys_get_temp_dir();
 * file_set_tree([
 *     $root => [
 *         'hoge.txt' => 'HOGE',
 *         'dir1' => [
 *             'fuga.txt' => 'FUGA',
 *             'dir2'     => [
 *                 'piyo.txt' => 'PIYO',
 *             ],
 *         ],
 *     ],
 * ]);
 * that("$root/hoge.txt")->fileEquals('HOGE');
 * that("$root/dir1/fuga.txt")->fileEquals('FUGA');
 * that("$root/dir1/dir2/piyo.txt")->fileEquals('PIYO');
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param array $contents_tree コンテンツツリー
 * @param ?int $umask umask
 * @return array 書き込まれたバイト数配列
 */
function file_set_tree($contents_tree, $umask = null)
{
    // for compatible
    // @codeCoverageIgnoreStart
    if (is_string($contents_tree)) {
        $contents_tree = [$contents_tree => $umask];
        $umask = func_get_args()[2] ?? null;
    }
    // @codeCoverageIgnoreEnd

    $umask ??= umask();

    $main = function ($contents_tree, $parent) use (&$main, $umask) {
        $result = [];
        foreach ($contents_tree as $basename => $entry) {
            $fullpath = isset($parent) ? $parent . DIRECTORY_SEPARATOR . $basename : $basename;
            if ($entry instanceof \Closure) {
                $entry = $entry($fullpath, $parent, $basename);
            }

            if (is_array($entry)) {
                mkdir_p($fullpath, $umask);
                $result += $main($entry, $fullpath);
            }
            else {
                $byte = file_set_contents($fullpath, $entry, $umask);
                $result[path_normalize($fullpath)] = $byte;
            }
        }
        return $result;
    };
    return $main($contents_tree, null);
}
