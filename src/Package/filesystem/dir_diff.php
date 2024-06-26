<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/file_equals.php';
require_once __DIR__ . '/../filesystem/file_list.php';
// @codeCoverageIgnoreEnd

/**
 * ファイルツリーを比較して配列で返す
 *
 * ファイル名をキーとし、
 * - $path1 にしかないファイルは true
 * - $path2 にしかないファイルは false
 * - 両方にあり、内容が異なる場合はなんらかの文字列（comparator オプション）
 * - 両方にあり、内容が同じ場合は結果に含まれない
 *
 * comparator オプションは両方に存在した場合にコールされるので差分を返したり更新日時を返したリできる。
 * comparator が null を返した場合、その要素は内容が同じとみなされ、結果配列に含まれなくなる。
 *
 * Example:
 * ```php
 * // 適当にファイルツリーを用意
 * $dir1 = sys_get_temp_dir() . '/diff1';
 * $dir2 = sys_get_temp_dir() . '/diff2';
 * file_set_tree([
 *     $dir1 => [
 *         'file1.txt' => 'file1',
 *         'file2.txt' => 'file2',
 *         'sub1' => [
 *             'file.txt' => 'sub1file',
 *         ],
 *         'sub2' => [],
 *     ],
 *     $dir2 => [
 *         'file1.txt' => 'file1',
 *         'file2.txt' => 'FILE2',
 *         'sub1' => [],
 *         'sub2' => [
 *             'file.txt' => 'sub2file',
 *         ],
 *     ],
 * ]);
 * // dir_diff すると下記のような差分が得られる
 * $DS = DIRECTORY_SEPARATOR;
 * that(dir_diff($dir1, $dir2))->is([
 *     // "file1.txt" => "",         // 差分がないので含まれない
 *     "file2.txt" => "",            // 両方に存在して差分あり
 *     "sub1{$DS}file.txt" => true,  // dir1 にのみ存在する
 *     "sub2{$DS}file.txt" => false, // dir2 にのみ存在する
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $path1 パス1
 * @param string $path2 パス2
 * @param array $options オプション
 * @return array 比較配列
 */
function dir_diff($path1, $path2, $options = [])
{
    $DS = DIRECTORY_SEPARATOR;

    $options += [
        'unixpath'       => false,
        'case-sensitive' => $DS === '/',
    ];
    $filter_condition = ['relative' => true, '!type' => null] + $options;

    $differ = $options['differ'] ?? fn($file1, $file2) => file_equals($file1, $file2) ? null : "";

    $list1 = file_list($path1, $filter_condition);
    if ($list1 === null) {
        throw new \UnexpectedValueException("$path1 does not exists");
    }
    $list2 = file_list($path2, $filter_condition);
    if ($list2 === null) {
        $list2 = [];
    }

    if ($options['unixpath']) {
        $DS = '/';
        $list1 = array_map(fn($file) => strtr($file, [DIRECTORY_SEPARATOR => $DS]), $list1);
        $list2 = array_map(fn($file) => strtr($file, [DIRECTORY_SEPARATOR => $DS]), $list2);
    }

    $files1 = array_combine($list1, $list1);
    $files2 = array_combine($list2, $list2);

    if (!$options['case-sensitive']) {
        $files1 = array_change_key_case($files1, CASE_UPPER);
        $files2 = array_change_key_case($files2, CASE_UPPER);
    }

    $diff1 = array_diff_key($files1, $files2);
    $diff2 = array_diff_key($files2, $files1);
    $commons = array_intersect_key($files1, $files2);

    $result = [];
    $result += array_fill_keys($diff1, true);
    $result += array_fill_keys($diff2, false);

    foreach ($commons as $key => $name) {
        $file1 = $path1 . $DS . $files1[$key];
        $file2 = $path2 . $DS . $files2[$key];

        if (!(is_dir($file1) && is_dir($file2)) && ($diff = $differ($file1, $file2)) !== null) {
            $result[$name] = $diff;
        }
    }

    ksort($result);
    return $result;
}
