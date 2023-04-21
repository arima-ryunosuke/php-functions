<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\iterator_chunk;
use function ryunosuke\Functions\Package\iterator_join;

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
}
