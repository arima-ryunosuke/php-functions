<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\generator_apply;
use function ryunosuke\Functions\Package\iterator_chunk;
use function ryunosuke\Functions\Package\iterator_combine;
use function ryunosuke\Functions\Package\iterator_join;
use function ryunosuke\Functions\Package\iterator_map;
use function ryunosuke\Functions\Package\iterator_maps;
use function ryunosuke\Functions\Package\iterator_split;

class iteratorTest extends AbstractTestCase
{
    function test_generator_apply()
    {
        $g = (function () {
            yield 1;
            yield 2;
            yield 3;
            yield 4;
            yield 5;
            yield 6;
            yield 7;
            yield 8;
            yield 9;
            return 99;
        })();

        $return = generator_apply($g, function ($v) {
            return $v % 2 == 0 ? $v : null;
        }, $receiver, $count);

        that($return)->isSame(99);
        that($receiver)->isSame([2, 4, 6, 8]);
        that($count)->isSame(9);

        $return = generator_apply($g, fn($v) => $v % 2 == 0 ? $v : null, $receiver, $count);

        that($return)->isSame(99);
        that($receiver)->isSame(null);
        that($count)->isSame(null);
    }

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

    function test_iterator_chunk_SplFileObject()
    {
        $tmp = new \SplTempFileObject();
        $tmp->fwrite("a\nb\nc\nd\n");
        $tmp->rewind();

        $expected = [
            ["a\n", "b\n", "c\n"],
            ["d\n"],
        ];

        $chunks = iterator_chunk($tmp, 3);
        foreach ($chunks as $n => $lines) {
            that(iterator_to_array($lines))->is($expected[$n]);
            that($lines->getReturn())->is(count($expected[$n]));
        }
        that($chunks->getReturn())->is(4);
    }

    function test_iterator_combine()
    {
        // 配列から key => value なイテレータを作る
        $it = iterator_combine(['a', 'b', 'c'], [1, 2, 3]);
        that(iterator_to_array($it))->isSame(['a' => 1, 'b' => 2, 'c' => 3]);

        // generator から key => value な generator を作る
        $it = iterator_combine((fn() => yield from ['a', 'b', 'c'])(), (fn() => yield from [1, 2, 3])());
        that(iterator_to_array($it))->isSame(['a' => 1, 'b' => 2, 'c' => 3]);

        // 数が一致しなければ例外
        $this->expectException(\ValueError::class);
        iterator_to_array(iterator_combine([1, 2], [3, 4, 5]));
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

        that(iterator_to_array(iterator_join((function () { yield from []; })())))->is([]);
    }

    function test_iterator_map()
    {
        // いわゆる zip 操作
        $it = iterator_map(null, (function () {
            yield 1;
            yield 2;
            yield 3;
        })(), (function () {
            yield 7;
            yield 8;
            yield 9;
        })());
        that(iterator_to_array($it))->isSame([[1, 7], [2, 8], [3, 9]]);

        // キーも渡ってくる
        $it = iterator_map(fn($v1, $v2, $k1, $k2) => "$k1:$v1, $k2:$v2", (function () {
            yield 'a' => 1;
            yield 'b' => 2;
            yield 'c' => 3;
        })(), (function () {
            yield 'g' => 7;
            yield 'h' => 8;
            yield 'i' => 9;
        })());
        that(iterator_to_array($it))->isSame(["a:1, g:7", "b:2, h:8", "c:3, i:9"]);

        // 不一致
        $it = iterator_map(fn($v1, $v2, $k1, $k2) => [$v1, $k1, $v2, $k2], (function () {
            yield 'a' => 1;
            yield 'b' => 2;
            yield 'c' => 3;
        })(), (function () {
            yield 'g' => 7;
            yield 'h' => 8;
        })());
        that(iterator_to_array($it))->isSame([
            [1, "a", 7, "g"],
            [2, "b", 8, "h"],
            [3, "c", null, null],
        ]);
    }

    function test_iterator_maps()
    {
        // Generator の値を2乗してから3を足す
        $it = iterator_maps((function () {
            yield 1;
            yield 2;
            yield 3;
        })(), fn($v) => $v ** 2, fn($v) => $v + 3);
        that(iterator_to_array($it))->isSame([4, 7, 12]);
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

        that(iterator_to_array(iterator_join(iterator_split((function () { yield from []; })(), [1]))))->is([]);
    }
}
