<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_indexarray.php';
// @codeCoverageIgnoreEnd

/**
 * 独自拡張した array_replace_recursive
 *
 * 下記の点で array_replace_recursive と異なる。
 *
 * - 元配列のキーのみでフィルタされる
 * - 対象配列にクロージャを渡すと現在の状態を引数にしてコールバックされる
 * - 値に Generator や Generator 関数を渡すと最後にまとめて値化される
 *     - つまり、上書きされた値は実質的にコールされない
 * - recursive かどうかは 最初の引数で分岐する（jQuery の extend と同じ）
 * - recursive の場合、元配列の値が配列の場合のみ対象となる。配列でない場合は単純に上書きされる
 *     - 次の値が非配列の場合、末尾に追加される
 *     - 次の値がクロージャの場合、元の値を引数にしてコールバックされる
 *     - 次の値が配列の場合
 *         - 元配列が数値配列なら完全にマージされる
 *         - 元配列が連想配列なら再帰される
 *
 * この仕様上、Generator を値とする配列を対象にすることはできないが、そのような状況は稀だろう。
 * その代わり、使われるかどうか分からない状態でもとりあえず Generator にしておけば無駄な処理を省くことができる。
 *
 * Example:
 * ```php
 * # $deep ではない単純呼び出し
 * that(array_extend([
 *     'overwrite' => 'hoge',            // 後段で指定されているので上書きされる
 *     'through'   => 'fuga',            // 後段で指定されていないので生き残る
 *     'array'     => ['a', 'b', 'c'],   // $deep ではないし後段で指定されているので完全に上書きされる
 *     'yield1'    => fn() => yield 123, // 後段で指定されているのでコールすらされない
 *     'yield2'    => fn() => yield 456, // 後段で指定されていないのでコールされる
 * ], [
 *     'ignore'    => null,              // 元配列に存在しないのでスルーされる
 *     'overwrite' => 'HOGE',
 *     'array'     => ['x', 'y', 'z'],
 *     'yield1'    => fn() => yield 234,
 * ]))->is([
 *     'overwrite' => 'HOGE',
 *     'through'   => 'fuga',
 *     'array'     => ['x', 'y', 'z'],
 *     'yield1'    => 234,
 *     'yield2'    => 456,
 * ]);
 * # $deep の場合のマージ呼び出し
 * that(array_extend(true, [
 *     'array'    => ['hoge'],            // 後段がスカラーなので末尾に追加される
 *     'callback' => ['fuga'],            // 後段がクロージャなのでコールバックされる
 *     'list'     => ['a', 'b', 'c'],     // 数値配列なのでマージされる
 *     'hash'     => ['a' => null],       // 連想配列なので再帰される
 *     'yield'    => [fn() => yield 123], // generator は解決される
 * ], [
 *     'array'    => 'HOGE',
 *     'callback' => fn($v) => $v + [1 => 'FUGA'],
 *     'list'     => ['x', 'y', 'z'],
 *     'hash'     => ['a' => ['x' => ['y' => ['z' => 'xyz']]]],
 *     'yield'    => [fn() => yield 456],
 * ]))->is([
 *     'array'    => ['hoge', 'HOGE'],
 *     'callback' => ['fuga', 'FUGA'],
 *     'list'     => ['a', 'b', 'c', 'x', 'y', 'z'],
 *     'hash'     => ['a' => ['x' => ['y' => ['z' => 'xyz']]]],
 *     'yield'    => [123, 456],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array|bool $default 基準となる配列
 * @param iterable|\Closure ...$arrays マージする配列
 * @return array 新しい配列
 */
function array_extend($default = [], ...$arrays)
{
    $deep = false;
    if (is_bool($default)) {
        if (!$arrays) {
            throw new \InvalidArgumentException('target is empry');
        }
        $deep = $default;
        $default = array_shift($arrays);
    }

    $result = $default;

    foreach ($arrays as $array) {
        if ($array instanceof \Closure) {
            $array = $array($result);
        }
        if (!is_iterable($array)) {
            throw new \InvalidArgumentException('target is not array');
        }

        foreach ($array as $k => $v) {
            if (!array_key_exists($k, $result)) {
                continue;
            }
            $current = $result[$k];
            if ($deep && is_array($current)) {
                if (is_array($v)) {
                    if (is_indexarray($current)) {
                        $v = array_merge($current, $v);
                        $current = array_fill_keys(array_keys($v), null);
                    }
                    $v = array_extend($deep, $current, $v);
                }
                elseif ($v instanceof \Closure) {
                    $v = $v($current);
                }
                else {
                    $current[] = $v;
                    $v = $current;
                }
            }
            $result[$k] = $v;
        }
    }

    foreach ($result as $k => $v) {
        if ($v instanceof \Closure && (new \ReflectionFunction($v))->isGenerator()) {
            $v = $v();
        }
        if ($v instanceof \Generator) {
            $result[$k] = is_array($default[$k]) ? iterator_to_array($v) : $v->current();
        }
    }

    return $result;
}
