<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\iterator_chunk;
use function ryunosuke\Functions\Package\iterator_join;
use function ryunosuke\Functions\Package\iterator_split;

class iteratorTest extends AbstractTestCase
{
    function test_iterator_chunk()
    {
        $data = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
            'd' => 'D',
            'e' => 'E',
            'f' => 'F',
            'g' => 'G',
            'h' => 'H',
            'i' => 'I',
            'j' => 'J',
            'k' => 'K',
        ];

        $generatorF = function () use ($data) { yield from $data; };

        $gens = iterator_chunk($generatorF(), 3, false);
        foreach ($gens as $gen) {
            that($gen)->isInstanceOf(\Generator::class);
        }

        $gens = iterator_chunk($generatorF(), 3, false);
        $expected = array_chunk($data, 3, false);
        foreach ($gens as $n => $gen) {
            that(iterator_to_array($gen))->is($expected[$n]);
            that($gen->getReturn())->is(count($expected[$n]));
        }
        that($gens->getReturn())->is(count($data));

        $kvs = [];
        $double = 0;
        $gens = iterator_chunk($generatorF(), function ($v, $k, $n, $chunk) use (&$kvs, &$double) {
            $kvs[$k] = $v;
            if ($n < 2 ** $double) {
                return true;
            }
            $double++;
            return false;
        }, true);
        $expected = [
            [
                'a' => 'A',
            ],
            [
                'b' => 'B',
                'c' => 'C',
            ],
            [
                'd' => 'D',
                'e' => 'E',
                'f' => 'F',
                'g' => 'G',
            ],
            [
                'h' => 'H',
                'i' => 'I',
                'j' => 'J',
                'k' => 'K',
            ],
        ];
        foreach ($gens as $n => $gen) {
            that(iterator_to_array($gen))->is($expected[$n]);
            that($gen->getReturn())->is(count($expected[$n]));
        }
        that($gens->getReturn())->is(count($data));
        that($kvs)->is($data);

        $gens = iterator_chunk($generatorF(), 4, true);
        $expected = array_chunk($data, 4, true);
        foreach ($gens as $n => $gen) {
            that(iterator_to_array($gen))->is($expected[$n]);
            that($gen->getReturn())->is(count($expected[$n]));
        }
        that($gens->getReturn())->is(count($data));

        $gens = iterator_chunk(new \ArrayObject($data), 4, true);
        $expected = array_chunk($data, 4, true);
        foreach ($gens as $n => $gen) {
            that(iterator_to_array($gen))->is($expected[$n]);
            that($gen->getReturn())->is(count($expected[$n]));
        }
        that($gens->getReturn())->is(count($data));

        $gens = iterator_chunk($data, 0);
        that($gens)->send(null)->wasThrown('$length must be');
    }

    function test_iterator_join()
    {
        that(iterator_to_array(iterator_join([
            ['A'],
            new \ArrayIterator(['B']),
            (fn() => yield 'C')(),
        ], false)))->is(['A', 'B', 'C']);

        that(iterator_to_array(iterator_join([
            ['A'],
            new \ArrayIterator(['B']),
            (fn() => yield 'C')(),
        ], true)))->is(['C']);

        that(iterator_to_array(iterator_join([
            ['a' => 'A'],
            new \ArrayIterator(['b' => 'B']),
            (fn() => yield 'c' => 'C')(),
        ], false)))->is(['A', 'B', 'C']);

        that(iterator_to_array(iterator_join([
            ['a' => 'A'],
            new \ArrayIterator(['b' => 'B']),
            (fn() => yield 'c' => 'C')(),
        ], true)))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);
    }

    function test_iterator_split()
    {
        $its = iterator_split((function () {
            yield 'A';
            yield 'B';
            yield 'C';
            yield 'D';
        })(), [1, 2]);
        that($its[0])->is(['A']);
        that($its[1])->is(['B', 'C']);
        that($its[2])->isInstanceOf(\Iterator::class);
        that(iterator_to_array($its[2]))->is([3 => 'D']);

        $its = iterator_split((function () {
            yield 'A';
            yield 'B';
            yield 'C';
            yield 'D';
        })(), ['one' => 1, 'two' => 2], true);
        that($its['one'])->is(['A']);
        that($its['two'])->is([1 => 'B', 2 => 'C']);
        that($its[0])->isInstanceOf(\Iterator::class);
        that(iterator_to_array($its[0]))->is([3 => 'D']);

        // NoRewind の件（php のバージョンで yield from や foreach で rewind されるかどうかが異なる？）
        that(iterator_to_array(iterator_join(iterator_split((function () {
            yield 'A';
            yield 'B';
            yield 'C';
            yield 'D';
        })(), [1, 2], false))))->is(['B', 'C', 3 => 'D']);

        that(iterator_to_array(iterator_join(iterator_split((function () {
            yield 'a' => 'A';
            yield 'b' => 'B';
            yield 'c' => 'C';
            yield 'd' => 'D';
        })(), [1, 2], false), false)))->is(['A', 'B', 'C', 'D']);

        that(iterator_to_array(iterator_join(iterator_split((function () {
            yield 'a' => 'A';
            yield 'b' => 'B';
            yield 'c' => 'C';
            yield 'd' => 'D';
        })(), [1, 2], true))))->is(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']);

        that(iterator_to_array(iterator_join(iterator_split((function () {
            yield 'A';
            yield 'B';
            yield 'C';
            yield 'D';
        })(), [1, 2], true))))->is(['A', 'B', 'C', 'D']);
    }
}
