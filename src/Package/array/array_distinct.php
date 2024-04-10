<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../reflection/parameter_length.php';
require_once __DIR__ . '/../var/arrayval.php';
require_once __DIR__ . '/../var/varcmp.php';
// @codeCoverageIgnoreEnd

/**
 * 比較関数が渡せる array_unique
 *
 * array_unique は微妙に癖があるのでシンプルに使いやすくしたもの。
 *
 * - SORT_STRING|SORT_FLAG_CASE のような指定が使える（大文字小文字を無視した重複除去）
 *   - 厳密に言えば array_unique も指定すれば動く（が、ドキュメントに記載がない）
 * - 配列を渡すと下記の動作になる
 *   - 数値キーは配列アクセス
 *   - 文字キーはメソッドコール（値は引数）
 * - もちろん（$a, $b を受け取る）クロージャも渡せる
 * - 引数1つのクロージャを渡すとシュワルツ的動作になる（Example 参照）
 *
 * Example:
 * ```php
 * // シンプルな重複除去
 * that(array_distinct([1, 2, 3, '3']))->isSame([1, 2, 3]);
 * // 大文字小文字を無視した重複除去
 * that(array_distinct(['a', 'b', 'A', 'B'], SORT_STRING|SORT_FLAG_CASE))->isSame(['a', 'b']);
 *
 * $v1 = new \ArrayObject(['id' => '1', 'group' => 'aaa']);
 * $v2 = new \ArrayObject(['id' => '2', 'group' => 'bbb', 'dummy' => 123]);
 * $v3 = new \ArrayObject(['id' => '3', 'group' => 'aaa', 'dummy' => 456]);
 * $v4 = new \ArrayObject(['id' => '4', 'group' => 'bbb', 'dummy' => 789]);
 * // クロージャを指定して重複除去
 * that(array_distinct([$v1, $v2, $v3, $v4], fn($a, $b) => $a['group'] <=> $b['group']))->isSame([$v1, $v2]);
 * // 単純な配列アクセスなら文字列や配列でよい（上記と同じ結果になる）
 * that(array_distinct([$v1, $v2, $v3, $v4], 'group'))->isSame([$v1, $v2]);
 * // 文字キーの配列はメソッドコールになる（ArrayObject::count で重複検出）
 * that(array_distinct([$v1, $v2, $v3, $v4], ['count' => []]))->isSame([$v1, $v2]);
 * // 上記2つは混在できる（group キー + count メソッドで重複検出。端的に言えば "aaa+2", "bbb+3", "aaa+3", "bbb+3" で除去）
 * that(array_distinct([$v1, $v2, $v3, $v4], ['group', 'count' => []]))->isSame([$v1, $v2, 2 => $v3]);
 * // 引数1つのクロージャ
 * that(array_distinct([$v1, $v2, $v3, $v4], fn($ao) => $ao['group']))->isSame([$v1, $v2]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable|int|string|null $comparator 比較関数
 * @return array 重複が除去された配列
 */
function array_distinct($array, $comparator = null)
{
    // 配列化と個数チェック（1以下は重複のしようがないので不要）
    $array = arrayval($array, false);
    if (count($array) <= 1) {
        return $array;
    }

    // 省略時は宇宙船
    if ($comparator === null) {
        $comparator = static fn($a, $b) => $a <=> $b;
    }
    // 数字が来たら varcmp とする
    elseif (is_int($comparator)) {
        $comparator = static fn($a, $b) => varcmp($a, $b, $comparator);
    }
    // 文字列・配列が来たらキーアクセス/メソッドコールとする
    elseif (is_string($comparator) || is_array($comparator)) {
        $comparator = static function ($a, $b) use ($comparator) {
            foreach (arrayize($comparator) as $method => $args) {
                if (is_int($method)) {
                    $delta = $a[$args] <=> $b[$args];
                }
                else {
                    $args = arrayize($args);
                    $delta = $a->$method(...$args) <=> $b->$method(...$args);
                }
                if ($delta !== 0) {
                    return $delta;
                }
            }
            return 0;
        };
    }
    // 引数1つのコールバックはシュワルツ関数とみなす
    elseif (is_callable($comparator) && parameter_length($comparator) === 1) {
        return array_intersect_key($array, array_unique(array_map($comparator, $array)));
    }

    // 2重ループで探すよりは1度ソートしてしまったほうがマシ…だと思う（php の実装もそうだし）
    $backup = $array;
    uasort($array, $comparator);
    $keys = array_keys($array);

    // できるだけ元の順番は維持したいので、詰めて返すのではなくキーを導出して共通項を返す（ただし、この仕様は変えるかもしれない）
    $current = $keys[0];
    $keepkeys = [$current => null];
    for ($i = 1, $l = count($keys); $i < $l; $i++) {
        if ($comparator($array[$current], $array[$keys[$i]]) !== 0) {
            $current = $keys[$i];
            $keepkeys[$current] = null;
        }
    }
    return array_intersect_key($backup, $keepkeys);
}
