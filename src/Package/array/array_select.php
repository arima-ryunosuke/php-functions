<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_lookup.php';
require_once __DIR__ . '/../funchand/func_user_func_array.php';
require_once __DIR__ . '/../var/attr_exists.php';
require_once __DIR__ . '/../var/attr_get.php';
// @codeCoverageIgnoreEnd

/**
 * 指定キーの要素で抽出する
 *
 * $columns に単純な値を渡すとそのキーの値を選択する。
 * キー付きで値を渡すと読み替えて選択する。
 * キー付きでクロージャを渡すと `(キーの値, 行自体, 現在行のキー)` を引数としてコールバックして選択する。
 * 単一のクロージャを渡すと `(行自体, 現在行のキー)` を引数としてコールバックして選択する（array_map とほぼ同じ）。
 *
 * Example:
 * ```php
 * $array = [
 *     11 => ['id' => 1, 'name' => 'name1'],
 *     12 => ['id' => 2, 'name' => 'name2'],
 *     13 => ['id' => 3, 'name' => 'name3'],
 * ];
 *
 * that(array_select($array, [
 *     'id',              // id を単純取得
 *     'alias' => 'name', // name を alias として取得
 * ]))->isSame([
 *     11 => ['id' => 1, 'alias' => 'name1'],
 *     12 => ['id' => 2, 'alias' => 'name2'],
 *     13 => ['id' => 3, 'alias' => 'name3'],
 * ]);
 *
 * that(array_select($array, [
 *     // id の 10 倍を取得
 *     'id'     => fn($id) => $id * 10,
 *     // id と name の結合を取得
 *     'idname' => fn($null, $row, $index) => $row['id'] . $row['name'],
 * ]))->isSame([
 *     11 => ['id' => 10, 'idname' => '1name1'],
 *     12 => ['id' => 20, 'idname' => '2name2'],
 *     13 => ['id' => 30, 'idname' => '3name3'],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string|iterable|\Closure $columns 抽出項目
 * @param int|string|null $index キーとなるキー
 * @return array 新しい配列
 */
function array_select($array, $columns, $index = null)
{
    if (!is_iterable($columns) && !$columns instanceof \Closure) {
        return array_lookup(...func_get_args());
    }

    if ($columns instanceof \Closure) {
        $callbacks = $columns;
    }
    else {
        $callbacks = [];
        foreach ($columns as $alias => $column) {
            if ($column instanceof \Closure) {
                $callbacks[$alias] = func_user_func_array($column);
            }
        }
    }

    $argcount = func_num_args();
    $result = [];
    $n = 0;
    foreach ($array as $k => $v) {
        if ($callbacks instanceof \Closure) {
            $row = $callbacks($v, $k, $n++);
        }
        else {
            $row = [];
            foreach ($columns as $alias => $column) {
                if (is_int($alias)) {
                    $alias = $column;
                }

                if (isset($callbacks[$alias])) {
                    $row[$alias] = $callbacks[$alias](attr_get($alias, $v, null), $v, $k);
                }
                elseif (attr_exists($column, $v)) {
                    $row[$alias] = attr_get($column, $v);
                }
                else {
                    throw new \InvalidArgumentException("$column is not exists.");
                }
            }
        }

        if ($argcount === 2) {
            $result[$k] = $row;
        }
        elseif ($index === null) {
            $result[] = $row;
        }
        elseif (array_key_exists($index, $row)) {
            $result[$row[$index]] = $row;
        }
        elseif (attr_exists($index, $v)) {
            $result[attr_get($index, $v)] = $row;
        }
        else {
            throw new \InvalidArgumentException("$index is not exists.");
        }
    }
    return $result;
}
