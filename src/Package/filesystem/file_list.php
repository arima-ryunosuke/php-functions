<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/file_matcher.php';
require_once __DIR__ . '/../filesystem/path_normalize.php';
require_once __DIR__ . '/../strings/multiexplode.php';
require_once __DIR__ . '/../strings/str_exists.php';
// @codeCoverageIgnoreEnd

/**
 * ファイル一覧を配列で返す
 *
 * Example:
 * ```php
 * // 適当にファイルを用意
 * $DS = DIRECTORY_SEPARATOR;
 * $tmp = sys_get_temp_dir() . "{$DS}file_list";
 * rm_rf($tmp, false);
 * file_set_contents("$tmp/a.txt", 'a');
 * file_set_contents("$tmp/dir/b.txt", 'b');
 * file_set_contents("$tmp/dir/dir/c.txt", 'c');
 * // ファイル一覧が取得できる
 * that(file_list($tmp))->equalsCanonicalizing([
 *     "$tmp{$DS}a.txt",
 *     "$tmp{$DS}dir{$DS}b.txt",
 *     "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $dirname 調べるディレクトリ名
 * @param array $filter_condition フィルタ条件
 * @return array|false ファイルの配列
 */
function file_list($dirname, $filter_condition = [])
{
    $filter_condition += [
        'unixpath' => false,
        '!type'    => 'dir',

        'recursive' => true,
        'relative'  => false,
        'nesting'   => false,
    ];

    $dirname = path_normalize($dirname);

    $subpath = '';
    while (!is_dir($dirname) && str_exists(basename($dirname), ['*', '?', '!', '{', '}', '[', ']'])) {
        $subpath = basename($dirname) . (strlen($subpath) ? '/' : '') . $subpath;
        $dirname = dirname($dirname);
    }

    if (strlen($subpath)) {
        if (strlen($filter_condition['subpath'] ?? '')) {
            throw new \InvalidArgumentException("both subpath and subpattern are specified");
        }
        $filter_condition['subpath'] = $subpath;
        $filter_condition['fnmflag'] = FNM_PATHNAME;
        $filter_condition['unixpath'] = true;
    }

    if (!file_exists($dirname) || $dirname === dirname($dirname)) {
        return false;
    }

    $match = file_matcher($filter_condition);

    $DS = DIRECTORY_SEPARATOR;
    $opt = \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_SELF;

    if ($filter_condition['unixpath']) {
        $DS = '/';
        $opt |= \FilesystemIterator::UNIX_PATHS;
    }

    $rdi = new \RecursiveDirectoryIterator($dirname, $opt);

    if ($filter_condition['recursive']) {
        $iterator = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);
    }
    else {
        $iterator = $rdi;
    }

    $result = [];
    foreach ($iterator as $fullpath => $it) {
        if (!$match($it)) {
            continue;
        }

        $path = $filter_condition['relative'] ? $it->getSubPathName() : $fullpath;
        $path = strtr(is_dir($fullpath) ? $path . $DS : $path, [DIRECTORY_SEPARATOR => $DS]);

        if ($filter_condition['nesting']) {
            $tmp = &$result;
            foreach (array_filter(multiexplode(['/', DIRECTORY_SEPARATOR], $it->getSubPath()), 'strlen') as $subdir) {
                $tmp = &$tmp[$subdir];
            }
            if ($it->isDir()) {
                $tmp[$it->getFilename()] = $tmp[$it->getFilename()] ?? [];
            }
            else {
                $tmp[$it->getFilename()] = $path;
            }
        }
        else {
            $result[] = $path;
        }
    }
    return $result;
}
