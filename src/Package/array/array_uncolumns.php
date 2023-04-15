<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/first_value.php';
// @codeCoverageIgnoreEnd

/**
 * array_columns のほぼ逆で [キー => [要素]] 配列から連想配列の配列を生成する
 *
 * $template を指定すると「それに含まれる配列かつ値がデフォルト」になる（要するに $default みたいなもの）。
 * キーがバラバラな配列を指定する場合は指定したほうが良い。が、null を指定すると最初の要素が使われるので大抵の場合は null で良い。
 *
 * Example:
 * ```php
 * that(array_uncolumns([
 *     'id'   => [1, 2],
 *     'name' => ['A', 'B'],
 * ]))->isSame([
 *     ['id' => 1, 'name' => 'A'],
 *     ['id' => 2, 'name' => 'B'],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param ?array $template 抽出要素とそのデフォルト値
 * @return array 新しい配列
 */
function array_uncolumns($array, $template = null)
{
    // 指定されていないなら生のまま
    if (func_num_args() === 1) {
        $template = false;
    }
    // null なら最初の要素のキー・null
    if ($template === null) {
        $template = array_fill_keys(array_keys(first_value($array)), null);
    }

    $result = [];
    foreach ($array as $key => $vals) {
        if ($template !== false) {
            $vals = array_intersect_key($vals + $template, $template);
        }
        foreach ($vals as $n => $val) {
            $result[$n][$key] = $val;
        }
    }
    return $result;
}
