<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * generator を強制的に終了させ最終値を返す
 *
 * おまけとして可変引数で最終値を送り込むことができる。
 *
 * foreach generator を break で抜けるあとに getReturn したい状況が稀によくある。
 * いちいち iterator_count 等はしたくないしそもそも valid 判定したり NoRewindIterator をカマしたりする必要がありややめんどくさい。
 *
 * ただし、この関数は非常に限定的な用途で、ほぼ使うことはない。
 * （当然だが）generator を回しきるとは処理の終着点まで行くことになるため、generator の旨味を完全に捨て去る挙動となる。
 * generator を終了させることで付随する処理も終了するとか、yield 値によって関数が return されるとか、限られたケースでしか有効にはならない。
 *
 * Example:
 * ```php
 * $generator = (function () {
 *     yield 1;
 *     yield 2;
 *     yield 3;
 *     yield 4;
 *     yield 5;
 *     yield 6;
 *     yield 7;
 *     yield 8;
 *     yield 9;
 * })();
 * $generator->next();
 * $generator->next();
 * $generator->next();
 * // まだ途中だが最終値である 9 を返す
 * that(generator_end($generator))->is(9);
 * ```
 *
 * @package ryunosuke\Functions\Package\iterator
 */
function generator_end(
    /** 対象 Generator */ \Generator $generator,
    /** 最終値 */ mixed ...$values,
) {
    foreach ($values as $value) {
        $generator->send($value);
    }

    while ($generator->valid()) {
        $result = $generator->current();
        $generator->next();
    }

    return $result ?? null;
}
