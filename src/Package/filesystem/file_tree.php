<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/file_matcher.php';
require_once __DIR__ . '/../filesystem/path_normalize.php';
// @codeCoverageIgnoreEnd

/**
 * ディレクトリ階層をツリー構造で返す
 *
 * Example:
 * ```php
 * // 適当にファイルを用意
 * $DS = DIRECTORY_SEPARATOR;
 * $tmp = sys_get_temp_dir() . "{$DS}file_tree";
 * rm_rf($tmp, false);
 * file_set_contents("$tmp/a.txt", 'a');
 * file_set_contents("$tmp/dir/b.txt", 'b');
 * file_set_contents("$tmp/dir/dir/c.txt", 'c');
 * // ファイルツリーが取得できる
 * that(file_tree($tmp))->is([
 *     'file_tree' => [
 *         'a.txt' => "$tmp{$DS}a.txt",
 *         'dir'   => [
 *             'b.txt' => "$tmp{$DS}dir{$DS}b.txt",
 *             'dir'   => [
 *                 'c.txt' => "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
 *             ],
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $dirname 調べるディレクトリ名
 * @param array $filter_condition フィルタ条件
 * @return ?array ツリー構造の配列
 */
function file_tree($dirname, $filter_condition = [])
{
    $dirname = path_normalize($dirname);
    if (!file_exists($dirname)) {
        return null;
    }

    $filter_condition += [
        '!type' => 'dir',
    ];
    $match = file_matcher($filter_condition);

    $basedir = basename($dirname);

    $result = [$basedir => []];
    $items = iterator_to_array(new \FilesystemIterator($dirname, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_FILEINFO));
    usort($items, function (\SplFileInfo $a, \SplFileInfo $b) {
        if ($a->isDir() xor $b->isDir()) {
            return $a->isDir() - $b->isDir();
        }
        return strcmp($a->getPathname(), $b->getPathname());
    });
    foreach ($items as $item) {
        if ($item->isDir()) {
            $result[$basedir] += file_tree($item->getPathname(), $filter_condition);
        }
        else {
            if ($match($item)) {
                $result[$basedir][$item->getBasename()] = $item->getPathname();
            }
        }
    }
    return $result;
}
