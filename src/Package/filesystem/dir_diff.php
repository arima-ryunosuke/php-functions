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
 * - $path1 にしかないファイルは false
 * - $path2 にしかないファイルは true
 * - 両方にあり、内容が異なる場合はなんらかの文字列（comparator オプション）
 * - 両方にあり、内容が同じ場合は結果に含まれない
 *
 * comparator オプションは両方に存在した場合にコールされるので差分を返したり更新日時を返したリできる。
 * comparator が null を返した場合、その要素は内容が同じとみなされ、結果配列に含まれなくなる。
 *
 * Example:
 * ```php
 * // すべてにマッチするので true
 * that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaXbbbX'))->isTrue();
 * // aaa にはマッチするが bbb にはマッチしないので false
 * that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaX'))->isFalse();
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
        'case-sensitive' => $DS === '/',
    ];
    $filter_condition = ['relative' => true, '!type' => null] + $options;

    $chunksize = $options['chunksize'] ?? null;
    $differ = $options['differ'] ?? fn($file1, $file2) => '';

    $list1 = file_list($path1, $filter_condition);
    if ($list1 === false) {
        throw new \UnexpectedValueException("$path1 does not exists");
    }
    $list2 = file_list($path2, $filter_condition);
    if ($list2 === false) {
        $list2 = [];
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
        $file1 = "$path1{$DS}" . $files1[$key];
        $file2 = "$path2{$DS}" . $files2[$key];

        if (!(is_dir($file1) && is_dir($file2)) && !file_equals($file1, $file2, $chunksize)) {
            $diff = $differ($file1, $file2);
            if ($diff !== null) {
                $result[$name] = $diff;
            }
        }
    }

    ksort($result);
    return $result;
}
