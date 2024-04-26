<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * キーと値のイテレータから キー => 値 なイテレータを作る
 *
 * 要するに array_combine のイテレータ版。
 * 数が一致しないと array_combine と同様例外を投げるが、呼び出し時点では投げられず、ループ後に呼ばれることに注意。
 *
 * Example:
 * ```php
 * // 配列から key => value なイテレータを作る
 * $it = iterator_combine(['a', 'b', 'c'], [1, 2, 3]);
 * that(iterator_to_array($it))->isSame(['a' => 1, 'b' => 2, 'c' => 3]);
 * ```
 *
 * @package ryunosuke\Functions\Package\iterator
 *
 * @param iterable $keys キー
 * @param iterable $values 値
 * @return \Iterator $key => $value なイテレータ
 */
function iterator_combine($keys, $values)
{
    /** @var \Iterator $itK */
    /** @var \Iterator $itV */
    $itK = is_array($keys) ? (fn() => yield from $keys)() : $keys;
    $itV = is_array($values) ? (fn() => yield from $values)() : $values;

    $multi = new \MultipleIterator(\MultipleIterator::MIT_KEYS_NUMERIC | \MultipleIterator::MIT_NEED_ALL);
    $multi->attachIterator($itK);
    $multi->attachIterator($itV);

    foreach ($multi as $it) {
        yield $it[0] => $it[1];
    }

    // どちらかが回し切れていない≒数が一致していない
    if ($itK->valid() || $itV->valid()) {
        throw new \ValueError("Both parameters should have an equal number of iterators");
    }
}
