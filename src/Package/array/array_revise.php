<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 配列要素の追加・変更・削除を行う
 *
 * $map の当該キー要素が・・・
 *
 * - クロージャの場合: キーの有無に関わらずコールされる
 * - null の場合: キーが削除される
 * - それ以外の場合: キーが追加される（存在しない場合のみ）
 *
 * という処理を行う。
 *
 * Example:
 * ```php
 * that(array_revise([
 *     'id'      => 123,
 *     'name'    => 'hoge',
 *     'age'     => 18,
 *     'delete'  => '',
 * ], [
 *     'name'    => 'ignored',            // 存在するのでスルーされる
 *     'append'  => 'newkey',             // 存在しないので追加される
 *     'age'     => fn($age) => $age + 1, // クロージャは現在の値を引数にしてコールされる
 *     'delete'  => null,                 // null は削除される
 *     'null'    => fn() => null,         // 削除の目印として null を使っているので null を追加したい場合はクロージャで包む必要がある
 * ]))->isSame([
 *     'id'      => 123,
 *     'name'    => 'hoge',
 *     'age'     => 19,
 *     'append'  => 'newkey',
 *     'null'    => null,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array
 * @param array ...$maps
 * @return array 変更された新しい配列
 */
function array_revise($array, ...$maps)
{
    $result = arrayval($array, false);
    foreach ($maps as $map) {
        foreach ($map as $k => $v) {
            if ($v instanceof \Closure) {
                $result[$k] = $v($result[$k] ?? null, $result);
            }
            elseif ($v === null) {
                unset($result[$k]);
            }
            elseif (!array_key_exists($k, $result)) {
                $result[$k] = $v;
            }
        }
    }
    return $result;
}
