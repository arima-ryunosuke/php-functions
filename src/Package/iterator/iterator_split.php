<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * iterator から頭何件かを取り出してチャンク化して返す
 *
 * rewind できない iterator から頭1件だけ取り出して rewind して再ループしたい、という状況が稀によくある。
 * この関数と iterator_join と組み合わせればそれが容易に実現できる。
 *
 * $iterable には配列も渡すことができる。
 *
 * Example:
 * ```php
 * $generator = function () {
 *     yield 'a';
 *     yield 'b';
 *     yield 'c';
 *     yield 'd';
 *     yield 'e';
 *     yield 'f';
 *     yield 'g';
 * };
 * // 要素7の Generator から頭1,2件を取り出す
 * [$one, $two, $gen] = iterator_split($generator(), [1, 2]);
 * // 最初の要素は1件
 * that($one)->is(['a']);
 * // 次の要素は2件
 * that($two)->is(['b', 'c']);
 * // かならず最後の要素に元の iterator が来る
 * that($gen)->isInstanceOf(\Iterator::class);
 *
 * // $chunk_sizes の配列のキーは返り値のキーになる
 * ['one' => $one, 'two' => $two, 0 => $gen] = iterator_split($generator(), ['one' => 1, 'two' => 2]);
 * // one は1件
 * that($one)->is(['a']);
 * // two は2件
 * that($two)->is(['b', 'c']);
 * // かならず最後の要素に元の iterator が来る
 * that($gen)->isInstanceOf(\Iterator::class);
 * ```
 *
 * @package ryunosuke\Functions\Package\iterator
 *
 * @param iterable $iterable 対象 iterator
 * @param array $chunk_sizes 各チャンクの数を指定する
 * @param bool $preserve_keys キーを保存するか
 * @return array $chunk_sizes の数+1 の iterable 配列
 */
function iterator_split($iterable, $chunk_sizes, $preserve_keys = false)
{
    $iterable = new \NoRewindIterator(is_array($iterable) ? new \ArrayIterator($iterable) : $iterable);

    $results = [];

    foreach ($chunk_sizes as $name => $chunk_size) {
        $n = 0;
        $result = [];
        foreach ($iterable as $key => $val) {
            if ($preserve_keys) {
                $result[$key] = $val;
            }
            else {
                $result[] = $val;
            }

            if (++$n === (int) $chunk_size) {
                $iterable->next();
                break;
            }
        }
        $results[$name] = $result;
    }

    $results[] = $iterable;

    return $results;
}
