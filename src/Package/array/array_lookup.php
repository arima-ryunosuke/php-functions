<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_kmap.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * キー保存可能な array_column
 *
 * array_column は キーを保存することが出来ないが、この関数は引数を2つだけ与えるとキーはそのままで array_column 相当の配列を返す。
 * 逆に第3引数にクロージャを与えるとその結果をキーにすることが出来る。
 *
 * Example:
 * ```php
 * $array = [
 *     11 => ['id' => 1, 'name' => 'name1'],
 *     12 => ['id' => 2, 'name' => 'name2'],
 *     13 => ['id' => 3, 'name' => 'name3'],
 * ];
 * // 第3引数を渡せば array_column と全く同じ
 * that(array_lookup($array, 'name', 'id'))->isSame(array_column($array, 'name', 'id'));
 * that(array_lookup($array, 'name', null))->isSame(array_column($array, 'name', null));
 * // 省略すればキーが保存される
 * that(array_lookup($array, 'name'))->isSame([
 *     11 => 'name1',
 *     12 => 'name2',
 *     13 => 'name3',
 * ]);
 * // クロージャを指定すればキーが生成される
 * that(array_lookup($array, 'name', fn($v, $k) => $k * 2))->isSame([
 *     22 => 'name1',
 *     24 => 'name2',
 *     26 => 'name3',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string|null $column_key 値となるキー
 * @param string|\Closure|null $index_key キーとなるキー
 * @return array 新しい配列
 */
function array_lookup($array, $column_key = null, $index_key = null)
{
    $array = arrayval($array, false);

    if ($index_key instanceof \Closure) {
        return array_combine(array_kmap($array, $index_key), array_column($array, $column_key));
    }
    if (func_num_args() === 3) {
        return array_column($array, $column_key, $index_key);
    }
    return array_combine(array_keys($array), array_column($array, $column_key));
}
