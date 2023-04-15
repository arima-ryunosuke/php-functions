<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * メソッドを指定できるようにした array_map
 *
 * 配列内の要素は全て同一（少なくともシグネチャが同じ $method が存在する）オブジェクトでなければならない。
 * スルーする場合は $ignore=true とする。スルーした場合 map ではなく filter される（結果配列に含まれない）。
 * $ignore=null とすると 何もせずそのまま要素を返す。
 *
 * Example:
 * ```php
 * $exa = new \Exception('a');
 * $exb = new \Exception('b');
 * $std = new \stdClass();
 * // getMessage で map される
 * that(array_map_method([$exa, $exb], 'getMessage'))->isSame(['a', 'b']);
 * // getMessage で map されるが、メソッドが存在しない場合は取り除かれる
 * that(array_map_method([$exa, $exb, $std, null], 'getMessage', [], true))->isSame(['a', 'b']);
 * // getMessage で map されるが、メソッドが存在しない場合はそのまま返す
 * that(array_map_method([$exa, $exb, $std, null], 'getMessage', [], null))->isSame(['a', 'b', $std, null]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string $method メソッド
 * @param array $args メソッドに渡る引数
 * @param bool|null $ignore メソッドが存在しない場合にスルーするか。null を渡すと要素そのものを返す
 * @return array $method が true を返した新しい配列
 */
function array_map_method($array, $method, $args = [], $ignore = false)
{
    if ($ignore === true) {
        $array = array_filter(arrayval($array, false), fn($object) => is_callable([$object, $method]));
    }
    return array_map(function ($object) use ($method, $args, $ignore) {
        if ($ignore === null && !is_callable([$object, $method])) {
            return $object;
        }
        return ([$object, $method])(...$args);
    }, arrayval($array, false));
}
