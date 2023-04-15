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
 * ```
 *
 * @package ryunosuke\Functions\Package\iterator
 *
 * @param iterable $iterator イテレータ
 * @param int $length チャンクサイズ
 * @param bool $preserve_keys キーの保存フラグ
 * @return \Generator[]|\Generator チャンク化された Generator
 */
function iterator_chunk($iterator, $length, $preserve_keys = false)
{
    if ($length <= 0) {
        throw new \InvalidArgumentException("\$length must be > 0 ($length)");
    }

    // Generator は Iterator であるが Iterator は Generator ではないので変換する
    if (is_iterable($iterator)) {
        $iterator = (function () use ($iterator) { yield from $iterator; })();
    }

    $total = 0;
    while ($iterator->valid()) {
        yield $g = (function () use ($iterator, $length, $preserve_keys) {
            for ($count = 0; $count < $length && $iterator->valid(); $count++, $iterator->next()) {
                if ($preserve_keys) {
                    yield $iterator->key() => $iterator->current();
                }
                else {
                    yield $iterator->current();
                }
            }
            return $count;
        })();

        // 回しきらないと無限ループする
        while ($g->valid()) {
            $g->next();
        }
        $total += $g->getReturn();
    }

    return $total;
}
