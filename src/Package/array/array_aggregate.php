<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_of.php';
require_once __DIR__ . '/../funchand/func_user_func_array.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 配列をコールバックの返り値で集計する
 *
 * $columns で集計列を指定する。
 * 単一の callable を渡すと結果も単一になる。
 * 複数の callable 連想配列を渡すと [キー => 集系列] の連想配列になる。
 * いずれにせよ引数としてそのグループの配列が渡ってくるので返り値がその列の値になる。
 * 第2引数には「今までの結果が詰まった配列」が渡ってくる（count, avg, sum など何度もでてくる集計で便利）。
 *
 * $key で集約列を指定する。
 * 指定しなければ引数の配列そのままで集計される。
 * 複数要素の配列を与えるとその数分潜って集計される。
 * クロージャを与えると返り値がキーになる。
 *
 * Example:
 * ```php
 * // 単純な配列の集計
 * that(array_aggregate([1, 2, 3], [
 *     'min' => fn($elems) => min($elems),
 *     'max' => fn($elems) => max($elems),
 *     'avg' => fn($elems) => array_sum($elems) / count($elems),
 * ]))->isSame([
 *     'min' => 1, // 最小値
 *     'max' => 3, // 最大値
 *     'avg' => 2, // 平均値
 * ]);
 *
 * $row1 = ['user_id' => 'hoge', 'group' => 'A', 'score' => 4];
 * $row2 = ['user_id' => 'fuga', 'group' => 'B', 'score' => 6];
 * $row3 = ['user_id' => 'fuga', 'group' => 'A', 'score' => 5];
 * $row4 = ['user_id' => 'hoge', 'group' => 'A', 'score' => 8];
 *
 * // user_id, group ごとの score を集計して階層配列で返す（第2引数 $current を利用している）
 * that(array_aggregate([$row1, $row2, $row3, $row4], [
 *     'scores' => fn($rows) => array_column($rows, 'score'),
 *     'score'  => fn($rows, $current) => array_sum($current['scores']),
 * ], ['user_id', 'group']))->isSame([
 *     'hoge' => [
 *         'A' => [
 *             'scores' => [4, 8],
 *             'score'  => 12,
 *         ],
 *     ],
 *     'fuga' => [
 *         'B' => [
 *             'scores' => [6],
 *             'score'  => 6,
 *         ],
 *         'A' => [
 *             'scores' => [5],
 *             'score'  => 5,
 *         ],
 *     ],
 * ]);
 *
 * // user_id ごとの score を集計して単一列で返す（キーのクロージャも利用している）
 * that(array_aggregate([$row1, $row2, $row3, $row4],
 *     fn($rows) => array_sum(array_column($rows, 'score')),
 *     fn($row) => strtoupper($row['user_id'])))->isSame([
 *     'HOGE' => 12,
 *     'FUGA' => 11,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable|callable[] $columns 集計関数
 * @param string|array|null $key 集約列。クロージャを与えると返り値がキーになる
 * @return array 集約配列
 */
function array_aggregate($array, $columns, $key = null)
{
    if ($key === null) {
        $nest_level = 0;
    }
    elseif ($key instanceof \Closure) {
        $nest_level = 1;
    }
    elseif (is_string($key)) {
        $nest_level = 1;
        $key = array_of($key);
    }
    else {
        $nest_level = count($key);
        $key = array_of($key);
    }

    if ($key === null) {
        $group = arrayval($array);
    }
    else {
        $group = [];
        $n = 0;
        foreach ($array as $k => $v) {
            $vv = $key($v, $k, $n++);

            if (is_array($vv)) {
                $tmp = &$group;
                foreach ($vv as $vvv) {
                    $tmp = &$tmp[$vvv];
                }
                $tmp[] = $v;
                unset($tmp);
            }
            else {
                $group[$vv][$k] = $v;
            }
        }
    }

    if (!is_callable($columns)) {
        $columns = array_map(fn(...$args) => func_user_func_array(...$args), $columns);
    }

    $dive = function ($array, $level) use (&$dive, $columns) {
        $result = [];
        if ($level === 0) {
            if (is_callable($columns)) {
                return $columns($array);
            }
            foreach ($columns as $name => $column) {
                $result[$name] = $column($array, $result);
            }
        }
        else {
            foreach ($array as $k => $v) {
                $result[$k] = $dive($v, $level - 1);
            }
        }
        return $result;
    };
    return $dive($group, $nest_level);
}
