<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 複数の iterator を一括して回せる iterator を返す。
 *
 * 要するにほぼ AppendIterator のラッパーだが、$iterable には配列も渡すことができるし、キーも振り直すことができる。
 *
 * Example:
 * ```php
 * $iterator = iterator_join([
 *     ['A'],                     // ただの配列
 *     new \ArrayIterator(['B']), // Iterator
 *     (fn() => yield 'C')(),     // Generator
 * ], false);
 * // 上記を回すと 1 ループで全要素を回せる
 * that(iterator_to_array($iterator))->is(['A', 'B', 'C']);
 * ```
 *
 * @package ryunosuke\Functions\Package\iterator
 *
 * @param iterable $iterables 結合する iterable
 * @return \Iterator 一括で回せる iterator
 */
function iterator_join($iterables, $preserve_keys = true)
{
    $iterator = new \AppendIterator();
    foreach ($iterables as $iterable) {
        $iterator->append(is_array($iterable) ? (fn() => yield from $iterable)() : $iterable);
    }

    $n = 0;
    foreach ($iterator as $k => $it) {
        if ($preserve_keys) {
            yield $k => $it;
        }
        else {
            yield $n++ => $it;
        }
    }
    return $iterator;
}
