<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * イテレータも使える array_chunk
 *
 * Generator を返す Generator を返す。
 * foreach で使う分には普通の配列と遜色なく使うことができる。
 *
 * 大本 Generator は return 値として総数を返す。
 * 各種 Generator は return 値として要素数を返す。
 *
 * Example:
 * ```php
 * // 要素7の Generator を3つに分割
 * $generator = (function () {
 *     yield 'a';
 *     yield 'b';
 *     yield 'c';
 *     yield 'd';
 *     yield 'e';
 *     yield 'f';
 *     yield 'g';
 * })();
 * $generators = iterator_chunk($generator, 3);
 *
 * // 3要素
 * that(iterator_to_array($generators->current()))->is(['a', 'b', 'c']);
 * that($generators->current()->getReturn())->is(3);
 * // 3要素
 * $generators->next();
 * that(iterator_to_array($generators->current()))->is(['d', 'e', 'f']);
 * that($generators->current()->getReturn())->is(3);
 * // 1要素
 * $generators->next();
 * that(iterator_to_array($generators->current()))->is(['g']);
 * that($generators->current()->getReturn())->is(1);
 * // 大本の Generator は総数を返す
 * $generators->next();
 * that($generators->getReturn())->is(7);
 *
 * // ハイフンが来るたびに分割（クロージャ内で next しているため、ハイフン自体は結果に含まれない）
 * $generator = (function () {
 *     yield 'a';
 *     yield 'b';
 *     yield '-';
 *     yield 'c';
 *     yield 'd';
 *     yield 'e';
 *     yield 'f';
 *     yield '-';
 *     yield 'g';
 * })();
 * $generators = iterator_chunk($generator, function ($v, $k, $n, $c, $it) {
 *     if ($v === '-') {
 *         $it->next();
 *         return false;
 *     }
 *     return true;
 * });
 *
 * that(iterator_to_array($generators->current()))->is(['a', 'b']);
 * $generators->next();
 * that(iterator_to_array($generators->current()))->is(['c', 'd', 'e', 'f']);
 * $generators->next();
 * that(iterator_to_array($generators->current()))->is(['g']);
 * ```
 *
 * @package ryunosuke\Functions\Package\iterator
 *
 * @param iterable $iterator イテレータ
 * @param int|\Closure $length チャンクサイズ。クロージャを渡すと毎ループ(値, キー, ステップ, チャンク番号, イテレータ)でコールされて false を返すと1チャンク終了となる
 * @param bool $preserve_keys キーの保存フラグ
 * @return \Generator[]|\Generator チャンク化された Generator
 */
function iterator_chunk($iterator, $length, $preserve_keys = false)
{
    if (!$length instanceof \Closure) {
        if ($length <= 0) {
            throw new \InvalidArgumentException("\$length must be > 0 ($length)");
        }
        $length = fn($v, $k, $n, $chunk, $iterator) => $n < $length;
    }

    // Traversable は Iterator ではないので変換する（例えば ArrayObject は IteratorAggregate であり Iterator ではない）
    if (!$iterator instanceof \Iterator) {
        $iterator = (fn() => yield from $iterator)();
    }

    $chunk = 0;
    $total = 0;
    while ($iterator->valid()) {
        yield $g = (function () use ($iterator, $length, $preserve_keys, $chunk) {
            $n = 0;
            while ($iterator->valid()) {
                $k = $iterator->key();
                $v = $iterator->current();

                if (!$length($v, $k, $n, $chunk, $iterator)) {
                    break;
                }

                if ($preserve_keys) {
                    yield $k => $v;
                }
                else {
                    yield $v;
                }

                $n++;
                $iterator->next();
            }
            return $n;
        })();
        $chunk++;

        // 回しきらないと無限ループする
        while ($g->valid()) {
            $g->next();
        }
        $total += $g->getReturn();
    }

    return $total;
}
