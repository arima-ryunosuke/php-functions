<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/kvsort.php';
// @codeCoverageIgnoreEnd

/**
 * 配列を部分的にソートする
 *
 * $grouper でグルーピングされた部分配列を $comparator でソートし、元の位置に埋め込む。
 * 元の配列の並び順は可能な限り維持される。
 *
 * $grouper はグループを決定づける何かを返す。
 * 一意であれば何でも良いが、内部的に配列のキーに格納されるため、文字列であることが望ましい。
 *
 * Example:
 * ```php
 * // 下記のような配列を元の順番を保ちつつ各々の group で部分的にソートする
 * $array = [
 *     ['id' => 1, 'group' => 'A', 'name' => 'q'],
 *     ['id' => 2, 'group' => 'A', 'name' => 'a'],
 *     ['id' => 3, 'group' => 'A', 'name' => 'z'],
 *     ['id' => 4, 'group' => null, 'name' => 'noise'],
 *     ['id' => 5, 'group' => 'B', 'name' => 'w'],
 *     ['id' => 6, 'group' => 'B', 'name' => 's'],
 *     ['id' => 7, 'group' => 'B', 'name' => 'x'],
 *     ['id' => 8, 'group' => 'C', 'name' => 'e'],
 *     ['id' => 9, 'group' => 'C', 'name' => 'd'],
 *     ['id' => 10, 'group' => null, 'name' => 'noise'],
 *     ['id' => 11, 'group' => 'C', 'name' => 'c'],
 * ];
 * that(groupsort($array, fn($v, $k) => $v['group'], fn($a, $b) => $a['name'] <=> $b['name']))->is([
 *     1  => ["id" => 2, "group" => "A", "name" => "a"],
 *     0  => ["id" => 1, "group" => "A", "name" => "q"],
 *     2  => ["id" => 3, "group" => "A", "name" => "z"],
 *     3  => ["id" => 4, "group" => null, "name" => "noise"],
 *     5  => ["id" => 6, "group" => "B", "name" => "s"],
 *     4  => ["id" => 5, "group" => "B", "name" => "w"],
 *     6  => ["id" => 7, "group" => "B", "name" => "x"],
 *     10 => ["id" => 11, "group" => "C", "name" => "c"],
 *     8  => ["id" => 9, "group" => "C", "name" => "d"],
 *     7  => ["id" => 8, "group" => "C", "name" => "e"],
 *     9  => ["id" => 10, "group" => null, "name" => "noise"],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $grouper グループ導出関数
 * @param callable $comparator 部分配列の比較関数
 * @return array 部分ソートされた配列
 */
function groupsort($array, $grouper, $comparator)
{
    $tmp = [];
    $mapper = [];
    $placeholders = [];

    $n = 0;
    foreach ($array as $k => $v) {
        $group = $grouper($v, $k, $n++);
        if ($group !== null) {
            if (!isset($placeholders[$group])) {
                $placeholders[$group] = new \stdClass();
                $oid = spl_object_id($placeholders[$group]);
                $mapper[$oid] = $placeholders[$group];
                $tmp[$oid] = $placeholders[$group];
            }
            $placeholders[$group]->$k = $v;
        }
        else {
            $tmp[$k] = $v;
        }
    }

    $result = [];

    foreach ($tmp as $k => $v) {
        if ($v instanceof \stdClass && isset($mapper[spl_object_id($v)])) {
            $result += kvsort((array) $v, $comparator);
        }
        else {
            $result[$k] = $v;
        }
    }

    return $result;
}
