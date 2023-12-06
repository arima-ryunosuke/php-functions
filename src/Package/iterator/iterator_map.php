<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * array_map の iterator 版
 *
 * 基本的に array_map と同じ動作にしてあるが、下記の点が異なる。
 *
 * - $callback に null, $iterables に1つだけ渡したときも zip 的動作をする
 *   - array_map は1つの時の一貫性がなく、やや非直感的な動作をする
 * - 値だけではなくキーも渡ってくる
 *   - 例えば $iterables が2つの場合 `($v1, $v2, $k1, $k2)` の4引数が渡ってくる
 *
 * 数が不一致の場合、(v, k) の組が共に null で渡ってくる。
 *
 * Example:
 * ```php
 * // いわゆる zip 操作
 * $it = iterator_map(null, (function () {
 *     yield 1;
 *     yield 2;
 *     yield 3;
 * })(), (function () {
 *     yield 7;
 *     yield 8;
 *     yield 9;
 * })());
 * that(iterator_to_array($it))->isSame([[1, 7], [2, 8], [3, 9]]);
 *
 * // キーも渡ってくる
 * $it = iterator_map(fn($v1, $v2, $k1, $k2) => "$k1:$v1, $k2:$v2", (function () {
 *     yield 'a' => 1;
 *     yield 'b' => 2;
 *     yield 'c' => 3;
 * })(), (function () {
 *     yield 'g' => 7;
 *     yield 'h' => 8;
 *     yield 'i' => 9;
 * })());
 * that(iterator_to_array($it))->isSame(["a:1, g:7", "b:2, h:8", "c:3, i:9"]);
 * ```
 *
 * @package ryunosuke\Functions\Package\iterator
 *
 * @param ?callable $callback コールバック
 * @param iterable ...$iterables iterable
 * @return \Iterator コールバックを適用した iterable
 */
function iterator_map($callback, ...$iterables)
{
    $multi = new \MultipleIterator(\MultipleIterator::MIT_KEYS_NUMERIC | \MultipleIterator::MIT_NEED_ANY);
    foreach ($iterables as $iterable) {
        $multi->attachIterator(is_array($iterable) ? (fn() => yield from $iterable)() : $iterable);
    }

    foreach ($multi as $keys => $values) {
        if ($callback === null) {
            yield $values;
        }
        else {
            yield $callback(...$values, ...$keys);
        }
    }
}
