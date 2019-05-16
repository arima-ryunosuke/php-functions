<?php

namespace ryunosuke\Test\Package;

class ArraysTest extends AbstractTestCase
{
    function test_arrays()
    {
        $this->assertEquals([['a', 'A'], ['b', 'B'], ['c', 'C']], iterator_to_array((arrays)(['a' => 'A', 'b' => 'B', 'c' => 'C'])));
    }

    function test_arrayize()
    {
        $this->assertEquals([1, 2, 3], (arrayize)(1, 2, 3));
        $this->assertEquals([1, 2, 3], (arrayize)([1], 2, 3));
    }

    function test_is_indexarray()
    {
        $this->assertTrue((is_indexarray)([]));
        $this->assertTrue((is_indexarray)([1]));
        $this->assertTrue((is_indexarray)([0 => 1]));
        $this->assertTrue((is_indexarray)([1 => 1]));
        $this->assertTrue((is_indexarray)(['1' => 1]));
        $this->assertFalse((is_indexarray)(['key' => 1]));
    }

    function test_is_hasharray()
    {
        $this->assertFalse((is_hasharray)([]));
        $this->assertFalse((is_hasharray)([1]));
        $this->assertFalse((is_hasharray)([0 => 1]));
        $this->assertTrue((is_hasharray)([1 => 1]));
    }

    function test_first_key()
    {
        $this->assertEquals(0, (first_key)(['a', 'b', 'c']));
        $this->assertEquals(0, (first_key)(['a', 'b', 'c'], 'def'));
        $this->assertEquals('def', (first_key)([], 'def'));
        $this->assertEquals(null, (first_key)([]));
    }

    function test_first_value()
    {
        $this->assertEquals('a', (first_value)(['a', 'b', 'c']));
        $this->assertEquals('a', (first_value)(['a', 'b', 'c'], 'def'));
        $this->assertEquals('def', (first_value)([], 'def'));
        $this->assertEquals(null, (first_value)([]));
    }

    function test_first_keyvalue()
    {
        $this->assertEquals([0, 'a'], (first_keyvalue)(['a', 'b', 'c']));
        $this->assertEquals([0, 'a'], (first_keyvalue)(['a', 'b', 'c'], 'def'));
        $this->assertEquals('def', (first_keyvalue)([], 'def'));
        $this->assertEquals(null, (first_keyvalue)([]));

        $this->assertEquals([0, 1], (first_keyvalue)(new \ArrayObject([1, 2, 3])));
        $this->assertEquals(null, (first_keyvalue)(new \ArrayObject([])));
    }

    function test_last_key()
    {
        $this->assertEquals(2, (last_key)(['a', 'b', 'c']));
        $this->assertEquals(2, (last_key)(['a', 'b', 'c'], 'def'));
        $this->assertEquals('def', (last_key)([], 'def'));
        $this->assertEquals(null, (last_key)([]));
    }

    function test_last_value()
    {
        $this->assertEquals('c', (last_value)(['a', 'b', 'c']));
        $this->assertEquals('c', (last_value)(['a', 'b', 'c'], 'def'));
        $this->assertEquals('def', (last_value)([], 'def'));
        $this->assertEquals(null, (last_value)([]));
    }

    function test_last_keyvalue()
    {
        $this->assertEquals([2, 'c'], (last_keyvalue)(['a', 'b', 'c']));
        $this->assertEquals([2, 'c'], (last_keyvalue)(['a', 'b', 'c'], 'def'));
        $this->assertEquals('def', (last_keyvalue)([], 'def'));
        $this->assertEquals(null, (last_keyvalue)([]));

        $this->assertEquals([2, 3], (last_keyvalue)(new \ArrayObject([1, 2, 3])));
        $this->assertEquals(null, (last_keyvalue)(new \ArrayObject([])));
        $this->assertEquals(null, (last_keyvalue)(new \stdClass()));
    }

    function test_prev_key()
    {
        // 数値キーのみ
        $array = ['a', 'b', 'c'];
        $this->assertSame(0, (prev_key)($array, 1));
        $this->assertSame(null, (prev_key)($array, 0));
        $this->assertSame(false, (prev_key)($array, 'xxx'));
        // 文字キーのみ
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        $this->assertSame('a', (prev_key)($array, 'b'));
        $this->assertSame(null, (prev_key)($array, 'a'));
        $this->assertSame(false, (prev_key)($array, 'xxx'));
        // 混在キー
        $array = ['a', 'b' => 'B', 'c'];
        $this->assertSame(0, (prev_key)($array, 'b'));
        $this->assertSame(null, (prev_key)($array, 0));
        $this->assertSame(false, (prev_key)($array, 'xxx'));
        // 負数キー
        $array = [-4 => 'a', -3 => 'b', -2 => 'c'];
        $this->assertSame(-4, (prev_key)($array, -3));
        $this->assertSame(null, (prev_key)($array, -4));
        $this->assertSame(false, (prev_key)($array, 'xxx'));
        // めっちゃバラバラキー
        $array = [-4 => 1, 3 => 2, 1 => 3, 2 => 4, -3 => 5, 'x' => 6];
        $this->assertSame(1, (prev_key)($array, 2));
        $this->assertSame(null, (prev_key)($array, -4));
        $this->assertSame(false, (prev_key)($array, 'xxx'));
    }

    function test_next_key()
    {
        // 数値キーのみ
        $array = ['a', 'b', 'c'];
        $this->assertSame(3, (next_key)($array));
        $this->assertSame(2, (next_key)($array, 1));
        $this->assertSame(null, (next_key)($array, 2));
        $this->assertSame(false, (next_key)($array, 'xxx'));
        // 文字キーのみ
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        $this->assertSame(0, (next_key)($array));
        $this->assertSame('b', (next_key)($array, 'a'));
        $this->assertSame(null, (next_key)($array, 'c'));
        $this->assertSame(false, (next_key)($array, 'xxx'));
        // 混在キー
        $array = ['a', 'b' => 'B', 'c'];
        $this->assertSame(2, (next_key)($array));
        $this->assertSame(1, (next_key)($array, 'b'));
        $this->assertSame(null, (next_key)($array, 1));
        $this->assertSame(false, (next_key)($array, 'xxx'));
        // 負数キー
        $array = [-4 => 'a', -3 => 'b', -2 => 'c'];
        $this->assertSame(0, (next_key)($array));
        $this->assertSame(-2, (next_key)($array, -3));
        $this->assertSame(null, (next_key)($array, -2));
        $this->assertSame(false, (next_key)($array, 'xxx'));
        // めっちゃバラバラキー
        $array = [-4 => 1, 3 => 2, 1 => 3, 2 => 4, -3 => 5, 'x' => 6];
        $this->assertSame(4, (next_key)($array));
        $this->assertSame(-3, (next_key)($array, 2));
        $this->assertSame(null, (next_key)($array, 'x'));
        $this->assertSame(false, (next_key)($array, 'xxx'));
    }

    function test_in_array_and()
    {
        $this->assertFalse((in_array_and)([], []));
        $this->assertFalse((in_array_and)(['a'], []));

        $this->assertTrue((in_array_and)(['a'], ['a', 'b', 'c']));
        $this->assertTrue((in_array_and)(['a', 'b'], ['a', 'b', 'c']));
        $this->assertTrue((in_array_and)(['a', 'b', 'c'], ['a', 'b', 'c']));
        $this->assertFalse((in_array_and)(['a', 'b', 'c', 'z'], ['a', 'b', 'c']));
        $this->assertFalse((in_array_and)(['z'], ['a', 'b', 'c']));

        $this->assertTrue((in_array_and)(['1', 2], [1, 2, 3], false));
        $this->assertFalse((in_array_and)(['1', 2], [1, 2, 3], true));
        $this->assertFalse((in_array_and)(['1', '2'], [1, 2, 3], true));
    }

    function test_in_array_or()
    {
        $this->assertFalse((in_array_or)([], []));
        $this->assertFalse((in_array_or)(['a'], []));

        $this->assertTrue((in_array_or)(['a'], ['a', 'b', 'c']));
        $this->assertTrue((in_array_or)(['a', 'b'], ['a', 'b', 'c']));
        $this->assertTrue((in_array_or)(['a', 'b', 'c'], ['a', 'b', 'c']));
        $this->assertTrue((in_array_or)(['a', 'b', 'c', 'z'], ['a', 'b', 'c']));
        $this->assertFalse((in_array_or)(['z'], ['a', 'b', 'c']));

        $this->assertTrue((in_array_or)(['1', 2], [1, 2, 3], false));
        $this->assertTrue((in_array_or)(['1', 2], [1, 2, 3], true));
        $this->assertFalse((in_array_or)(['1', '2'], [1, 2, 3], true));
    }

    function test_kvsort()
    {
        $array = array_fill_keys(range('a', 'z'), 9);

        // asort は安定ソートではない
        $native = $array;
        asort($native);
        $this->assertNotSame($array, $native);

        // kvsort は安定ソートである
        $this->assertSame($array, (kvsort)($array));

        // キーでソートできる
        $this->assertSame(array_reverse(array_keys($array)), array_keys((kvsort)($array, function ($av, $bv, $ak, $bk) { return strcmp($bk, $ak); })));

        // 配列じゃなくても Traversable ならソート可能
        $this->assertSame([1 => 1, 0 => 2, 2 => 3], (kvsort)((function () {
            yield 2;
            yield 1;
            yield 3;
        })()));

        // 上記は挙動のテストであってソートのテストを行っていないのでテスト
        $array = array_combine(range('a', 'z'), range('a', 'z'));
        $this->assertSame($array, (kvsort)((array_shuffle)($array), function ($a, $b) { return strcmp($a, $b); }));
    }

    function test_array_add()
    {
        $this->assertEquals(['a', 'b', 'c'], (array_add)(['a', 'b', 'c'], ['d']));
        $this->assertEquals(['a', 'b', 'c', 'd'], (array_add)(['a', 'b', 'c'], [3 => 'd']));
        $this->assertEquals(['a', 'b', 'c', 'd', 'e'], (array_add)(['a', 'b', 'c'], [3 => 'd'], [4 => 'e']));
    }

    function test_array_mix()
    {
        $this->assertEquals([], (array_mix)());
        $this->assertEquals([], (array_mix)([], []));
        $this->assertEquals([null], (array_mix)([], [], [null]));
        $this->assertEquals([1, 2, 3, 4, 5, 6], (array_mix)([1, 3, 5], [2, 4, 6]));
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7], (array_mix)([1, 3, 5], [2, 4, 6, 7]));
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7], (array_mix)([1, 3, 5, 7], [2, 4, 6]));
        $this->assertEquals([1, 2, 3, 4, 5, 6], (array_mix)([1], [2, 4], [3, 5, 6]));
        $this->assertEquals(['a' => 'A', 'b' => 'b', 'c' => 'C'], (array_mix)(['a' => 'A', 'c' => 'C'], ['b' => 'b']));
        $this->assertEquals(['a' => 'A', 'b' => 'b', 'c' => 'C'], (array_mix)(['a' => 'A'], ['b' => 'b', 'c' => 'C']));
        $this->assertEquals(['a' => '!', 'X', 'Y', 'Z'], (array_mix)(['a' => 'A', 'X', 'Z'], ['a' => '!', 'Y']));
    }

    function test_array_zip()
    {
        $this->assertEquals([[1], [2], [3]], (array_zip)([1, 2, 3]));
        $this->assertEquals([[[1]], [[2]], [[3]]], (array_zip)([[1], [2], [3]]));
        $this->assertEquals([[1, 'hoge'], [2, 'fuga'], [3, 'piyo']], (array_zip)([1, 2, 3], ['hoge', 'fuga', 'piyo']));
        $this->assertEquals([
            [
                'a' => 1,
                0   => 'hoge',
                1   => 'foo',
            ],
            [
                0   => 2,
                'b' => 'fuga',
                1   => 'bar',
            ],
            [
                0   => 3,
                1   => 'piyo',
                'c' => 'baz',
            ],
            [
                0   => null,
                1   => null,
                'n' => 'null',
            ],
        ],
            (array_zip)(
                ['a' => 1, 2, 3],
                ['hoge', 'b' => 'fuga', 'piyo'],
                ['foo', 'bar', 'c' => 'baz', 'n' => 'null']
            )
        );

        $this->assertException('$arrays is empty', array_zip);
    }

    function test_array_cross()
    {
        $this->assertSame([], (array_cross)());
        $this->assertSame([], (array_cross)([]));
        $this->assertSame([], (array_cross)([], []));

        $this->assertSame([[1], [2]], (array_cross)([1, 2]));
        $this->assertSame([[1, 3], [1, 4], [2, 3], [2, 4]], (array_cross)([1, 2], [3, 4]));
        $this->assertSame([[1, 3, 5], [1, 3, 6], [1, 4, 5], [1, 4, 6], [2, 3, 5], [2, 3, 6], [2, 4, 5], [2, 4, 6]], (array_cross)([1, 2], [3, 4], [5, 6]));

        $this->assertSame([['a' => 'A'], ['b' => 'B']], (array_cross)(['a' => 'A', 'b' => 'B']));
        $this->assertSame([['a' => 'A', 'c' => 'C'], ['a' => 'A', 'd' => 'D'], ['b' => 'B', 'c' => 'C'], ['b' => 'B', 'd' => 'D']], (array_cross)(['a' => 'A', 'b' => 'B'], ['c' => 'C', 'd' => 'D']));

        $this->assertSame([['A', 'c' => 'C'], ['A', 'D'], ['b' => 'B', 'c' => 'C'], ['b' => 'B', 'D']], (array_cross)(['A', 'b' => 'B'], ['c' => 'C', 'D']));

        $this->assertException('duplicated key', array_cross, ['a' => 'A', 'B'], ['C', 'a' => 'D']);
    }

    function test_array_implode()
    {
        $this->assertEquals(['a', ',', 'b', ',', 'c'], (array_implode)(['a', 'b', 'c'], ','));
        $this->assertEquals(['a', ',', 'b', ',', 'c'], (array_implode)(',', 'a', 'b', 'c'));
        $this->assertEquals(['a' => 'A', ',', 'b' => 'B', ',', 'c' => 'C'], (array_implode)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ','));
        $this->assertEquals(['a', ',', 'b', ',', 'c'], (array_implode)([1 => 'a', 0 => 'b', 2 => 'c'], ','));
    }

    function test_array_sprintf()
    {
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        $this->assertEquals(['A:a', 'B:b', 'C:c'], (array_sprintf)($array, '%s:%s'));
        $this->assertEquals('A:a,B:b,C:c', (array_sprintf)($array, '%s:%s', ','));

        $this->assertEquals(['v-A', 'v-B', 'v-C'], (array_sprintf)($array, function ($v) { return "v-$v"; }));
        $this->assertEquals('v-A,v-B,v-C', (array_sprintf)($array, function ($v) { return "v-$v"; }, ','));

        $this->assertEquals(['kv-aA', 'kv-bB', 'kv-cC'], (array_sprintf)($array, function ($v, $k) { return "kv-$k$v"; }));
        $this->assertEquals('kv-aA,kv-bB,kv-cC', (array_sprintf)($array, function ($v, $k) { return "kv-$k$v"; }, ','));

        $this->assertEquals((array_sprintf)([
            'str:%s,int:%d' => ['sss', '3.14'],
            'single:%s'     => 'str',
        ], null, '|'), 'str:sss,int:3|single:str');
    }

    function test_array_strpad()
    {
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        // prefix key
        $this->assertEquals(['Ka' => 'A', 'Kb' => 'B', 'Kc' => 'C'], (array_strpad)($array, 'K'));
        // prefix val
        $this->assertEquals(['a' => 'VA', 'b' => 'VB', 'c' => 'VC'], (array_strpad)($array, '', 'V'));
        // prefix key-val
        $this->assertEquals(['Ka' => 'VA', 'Kb' => 'VB', 'Kc' => 'VC'], (array_strpad)($array, 'K', 'V'));

        // suffix key
        $this->assertEquals(['aK' => 'A', 'bK' => 'B', 'cK' => 'C'], (array_strpad)($array, ['K']));
        // suffix val
        $this->assertEquals(['a' => 'AV', 'b' => 'BV', 'c' => 'CV'], (array_strpad)($array, '', ['V']));
        // suffix key-val
        $this->assertEquals(['aK' => 'AV', 'bK' => 'BV', 'cK' => 'CV'], (array_strpad)($array, ['K'], ['V']));

        // prefix suffix key
        $this->assertEquals(['KaK' => 'A', 'KbK' => 'B', 'KcK' => 'C'], (array_strpad)($array, ['K', 'K']));
        // prefix suffix val
        $this->assertEquals(['a' => 'VAV', 'b' => 'VBV', 'c' => 'VCV'], (array_strpad)($array, '', ['V', 'V']));
        // prefix suffix key-val
        $this->assertEquals(['KaK' => 'VAV', 'KbK' => 'VBV', 'KcK' => 'VCV'], (array_strpad)($array, ['K', 'K'], ['V', 'V']));
        // prefix key, suffix val
        $this->assertEquals(['Ka' => 'AV', 'Kb' => 'BV', 'Kc' => 'CV'], (array_strpad)($array, 'K', ['V']));

        // value not string
        $this->assertEquals(['Kx' => [1, 2, 3]], (array_strpad)(['x' => [1, 2, 3]], 'K'));
    }

    function test_array_pos()
    {
        // 1 番目の要素を返す
        $this->assertEquals('y', (array_pos)(['x', 'y', 'z'], 1, false));
        // 負数は後ろから返す
        $this->assertEquals('z', (array_pos)(['x', 'y', 'z'], -1, false));

        // 上記の is_key:true 版（キーを返す）
        $this->assertEquals(1, (array_pos)(['x', 'y', 'z'], 1, true));
        $this->assertEquals(2, (array_pos)(['x', 'y', 'z'], -1, true));

        // 範囲外は例外が飛ぶ
        $this->assertException('OutOfBoundsException', array_pos, ['x', 'y', 'z'], 9, true);
    }

    function test_array_pos_key()
    {
        $this->assertEquals((array_pos_key)(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'c'), 2);
        $this->assertEquals((array_pos_key)(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x', -1), -1);
        $this->assertException('OutOfBoundsException', array_pos_key, ['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x');
    }

    function test_array_of()
    {
        $hoge_of = (array_of)('hoge');
        $this->assertEquals('HOGE', $hoge_of(['hoge' => 'HOGE']));
        $this->assertEquals(null, $hoge_of(['fuga' => 'FUGA']));

        $hoge_of = (array_of)('hoge', 'HOGE');
        $this->assertEquals('HOGE', $hoge_of(['fuga' => 'FUGA']));

        $this->assertEquals([0 => 'a', 2 => 'c'], (array_of)([0, 2])(['a', 'b', 'c']));
        $this->assertEquals([0 => 'a'], (array_of)([0, 9])(['a', 'b', 'c']));
        $this->assertEquals([], (array_of)([9])(['a', 'b', 'c']));
        $this->assertEquals(null, (array_of)([9], null)(['a', 'b', 'c']));
    }

    function test_array_get()
    {
        $this->assertEquals('b', (array_get)(['a', 'b', 'c'], 1));
        $this->assertEquals(999, (array_get)(['a', 'b', 'c'], 9, 999));

        $this->assertEquals([0 => 'a', 2 => 'c'], (array_get)(['a', 'b', 'c'], [0, 2]));
        $this->assertEquals([0 => 'a'], (array_get)(['a', 'b', 'c'], [0, 9]));
        $this->assertEquals([], (array_get)(['a', 'b', 'c'], [9]));
        $this->assertEquals(null, (array_get)(['a', 'b', 'c'], [9], null));

        // 配列を与えたときの順番は指定したものを優先
        $this->assertEquals([2 => 'c', 1 => 'b', 0 => 'a'], (array_get)(['a', 'b', 'c'], [2, 1, 0]));

        // Arrayable でも動作する
        $ao = new \Arrayable(['a', 'b', 'c']);
        $this->assertEquals('b', (array_get)($ao, 1));
        $this->assertEquals([2 => 'c', 1 => 'b', 0 => 'a'], (array_get)($ao, [2, 1, 0]));

        $array = [
            'key1' => 'value1',
            'key2' => 'value2',
            'first',
            'second',
            'third',
            99     => 99,
            100    => 100,
            101    => 101,
        ];

        // キーが数値でないものを抽出
        $extract = (array_get)($array, function ($v, $k) { return !is_int($k); }, []);
        $this->assertEquals([
            'key1' => 'value1',
            'key2' => 'value2',
        ], $extract);

        // キーが数値のものを抽出
        $extract = (array_get)($array, function ($v, $k) { return is_int($k); }, []);
        $this->assertEquals([
            0   => 'first',
            1   => 'second',
            2   => 'third',
            99  => 99,
            100 => 100,
            101 => 101,
        ], $extract);

        // 単値モード
        $extract = (array_get)($array, function ($v, $k) { return is_int($k); });
        $this->assertEquals('first', $extract);

        // 値がオブジェクトのものを抽出（そんなものはない）
        $extract = (array_get)($array, function ($v, $k) { return is_object($v); });
        $this->assertEquals(null, $extract);
    }

    function test_array_set()
    {
        // single
        $array = ['a' => 'A', 'B'];
        $this->assertEquals(1, (array_set)($array, 'Z'));
        $this->assertEquals(['a' => 'A', 'B', 'Z'], $array);
        $this->assertEquals('z', (array_set)($array, 'Z', 'z'));
        $this->assertEquals(['a' => 'A', 'B', 'Z', 'z' => 'Z'], $array);
        $this->assertEquals('a', (array_set)($array, 'X', 'a'));
        $this->assertEquals(['a' => 'X', 'B', 'Z', 'z' => 'Z'], $array);
        $this->assertEquals(null, (array_set)($array, 'Z', null, false));
        $this->assertEquals(['a' => 'X', 'B', 'Z', 'z' => 'Z', 'Z'], $array);

        // array
        $array = ['a' => 'A', 'b' => ['B']];
        $this->assertEquals('x', (array_set)($array, 'X', ['x']));
        $this->assertEquals(['a' => 'A', 'b' => ['B'], 'x' => 'X'], $array);
        $this->assertEquals('z', (array_set)($array, 'X', ['y', 'z']));
        $this->assertEquals(['a' => 'A', 'b' => ['B'], 'x' => 'X', 'y' => ['z' => 'X']], $array);
        $this->assertEquals('b', (array_set)($array, 'W', ['b']));
        $this->assertEquals(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X']], $array);
        $this->assertEquals(0, (array_set)($array, 'Y2', ['y', null]));
        $this->assertEquals(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X', 'Y2']], $array);
        $this->assertException('is not array', function () {
            $array = ['a' => ['b' => 's']];
            (array_set)($array, 'X', ['a', 'b', 'c']);
        });
    }

    function test_array_put()
    {
        // single
        $array = ['a' => 'A', 'B'];
        $this->assertEquals(1, (array_put)($array, 'Z'));
        $this->assertEquals(['a' => 'A', 'B', 'Z'], $array);
        $this->assertEquals(2, (array_put)($array, 'Z', 123));
        $this->assertEquals(['a' => 'A', 'B', 'Z', 'Z'], $array);
        $this->assertEquals('z', (array_put)($array, 'Z', 'z'));
        $this->assertEquals(['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z'], $array);
        $this->assertEquals('a', (array_put)($array, 'X', 'a'));
        $this->assertEquals(['a' => 'X', 'B', 'Z', 'Z', 'z' => 'Z'], $array);

        // array
        $array = ['a' => 'A', 'b' => ['B']];
        $this->assertEquals('x', (array_put)($array, 'X', ['x']));
        $this->assertEquals(['a' => 'A', 'b' => ['B'], 'x' => 'X'], $array);
        $this->assertEquals('z', (array_put)($array, 'X', ['y', 'z']));
        $this->assertEquals(['a' => 'A', 'b' => ['B'], 'x' => 'X', 'y' => ['z' => 'X']], $array);
        $this->assertEquals('b', (array_put)($array, 'W', ['b']));
        $this->assertEquals(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X']], $array);
        $this->assertEquals(0, (array_put)($array, 'Y2', ['y', null]));
        $this->assertEquals(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X', 'Y2']], $array);
        $this->assertException('is not array', function () {
            $array = ['a' => ['b' => 's']];
            (array_put)($array, 'X', ['a', 'b', 'c']);
        });
    }

    function test_array_unset()
    {
        // single
        $array = ['a' => 'A', 'b' => 'B'];
        $this->assertEquals('A', (array_unset)($array, 'a'));
        $this->assertEquals(['b' => 'B'], $array);
        $this->assertEquals('X', (array_unset)($array, 'x', 'X'));
        $this->assertEquals(['b' => 'B'], $array);

        // array
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        $this->assertEquals('X', (array_unset)($array, ['x'], 'X'));
        $this->assertEquals(['X'], (array_unset)($array, ['x'], ['X']));
        $this->assertEquals(['A', 'B'], (array_unset)($array, ['a', 'b', 'x']));
        $this->assertEquals(['c' => 'C'], $array);

        // array with key
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        $this->assertSame(['B', 'A'], (array_unset)($array, ['b', 'a']));
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        $this->assertSame([1 => 'A', 0 => 'B'], (array_unset)($array, [1 => 'a', 0 => 'b']));
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        $this->assertSame([], (array_unset)($array, ['XXX']));

        // Arrayable でも動作する
        $ao = new \Arrayable(['a', 'b', 'c']);
        $this->assertEquals('b', (array_unset)($ao, 1));
        $this->assertEquals([0 => 'c', 2 => 'a'], (array_unset)($ao, [2, 1, 0]));

        $array = [
            'key1' => 'value1',
            'key2' => 'value2',
            'first',
            'second',
            'third',
            99     => 99,
            100    => 100,
            101    => 101,
        ];

        // まずキーが数値でないものを抽出
        $extract = (array_unset)($array, function ($v, $k) { return !is_int($k); });
        $this->assertEquals([
            'key1' => 'value1',
            'key2' => 'value2',
        ], $extract);
        $this->assertEquals([
            'first',
            'second',
            'third',
            99  => 99,
            100 => 100,
            101 => 101,
        ], $array);

        // さらに値が100以上のものを抽出
        $extract = (array_unset)($array, function ($v, $k) { return $v >= 100; });
        $this->assertEquals([
            100 => 100,
            101 => 101,
        ], $extract);
        $this->assertEquals([
            'first',
            'second',
            'third',
            99 => 99,
        ], $array);

        // さらに値が "second" のものを抽出
        $extract = (array_unset)($array, function ($v, $k) { return $v === 'second'; });
        $this->assertEquals([
            1 => 'second',
        ], $extract);
        $this->assertEquals([
            'first',
            2  => 'third',
            99 => 99,
        ], $array);

        // さらに値がオブジェクトのものを抽出（そんなものはない）
        $extract = (array_unset)($array, function ($v, $k) { return is_object($v); });
        $this->assertEquals(null, $extract);
        $this->assertEquals([
            'first',
            2  => 'third',
            99 => 99,
        ], $array);

        // さらにキー数値のものを抽出（全て）
        $extract = (array_unset)($array, function ($v, $k) { return is_int($k); });
        $this->assertEquals([
            'first',
            2  => 'third',
            99 => 99,
        ], $extract);
        $this->assertEquals([], $array);
    }

    function test_array_dive()
    {
        $array = ['a' => ['b' => ['c' => 'vvv']]];
        $this->assertEquals('vvv', (array_dive)($array, 'a.b.c'));
        $this->assertEquals(9, (array_dive)($array, 'a.b.x', 9));
        $this->assertEquals('vvv', (array_dive)($array, ['a', 'b', 'c']));
        $this->assertNull((array_dive)($array, 'a.b.c.x'));

        // Arrayable でも動作する
        $ao = new \Arrayable(['a' => ['b' => ['c' => 'vvv']]]);
        $this->assertEquals('vvv', (array_dive)($ao, 'a.b.c'));
        $this->assertEquals(9, (array_dive)($ao, 'a.b.x', 9));
        $this->assertEquals('vvv', (array_dive)($ao, ['a', 'b', 'c']));
    }

    function test_array_keys_exist()
    {
        $array = [
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
            'x' => [
                'x1' => 'X1',
                'x2' => 'X2',
                'y'  => [
                    'y1' => 'Y1',
                    'y2' => 'Y2',
                ],
            ]
        ];
        // すべて含む
        $this->assertTrue((array_keys_exist)(['a', 'b', 'c'], $array));
        // 単一文字指定で含む
        $this->assertTrue((array_keys_exist)('a', $array));
        // 1つ含まない
        $this->assertFalse((array_keys_exist)(['a', 'b', 'n'], $array));
        // 単一文字指定で含まない
        $this->assertFalse((array_keys_exist)('X', $array));
        // 空は例外
        $this->assertException('empty', array_keys_exist, [], $array);

        // ネスト調査
        $this->assertTrue((array_keys_exist)([
            'x' => ['x1', 'x2', 'y'],
        ], $array));
        $this->assertTrue((array_keys_exist)([
            'x' => [
                'x1',
                'x2',
                'y' => [
                    'y1',
                    'y2',
                ],
            ]
        ], $array));
        $this->assertFalse((array_keys_exist)([
            'nx' => ['x1', 'x2', 'y'],
        ], $array));
        $this->assertFalse((array_keys_exist)([
            'x' => [
                'x1',
                'x2',
                'y' => [
                    'y1',
                    'y9',
                ],
            ],
        ], $array));

        // \ArrayAccess
        $array = new \Arrayable([]);
        $array['x'] = ['y' => 'z'];
        $array['null'] = null;
        $this->assertTrue((array_keys_exist)('null', $array));
        $this->assertTrue((array_keys_exist)(['x' => ['y']], $array));
        $this->assertTrue((array_keys_exist)(['x' => ['y']], $array));
        $this->assertFalse((array_keys_exist)(['nx'], $array));
        $this->assertFalse((array_keys_exist)(['nx' => ['y']], $array));
    }

    function test_array_find()
    {
        $this->assertEquals(2, (array_find)(['a', 'b', '9'], 'ctype_digit'));
        $this->assertEquals('b', (array_find)(['a' => 'A', 'b' => 'B'], function ($v) { return $v === 'B'; }));
        $this->assertSame(0, (array_find)(['9', 'b', 'c'], 'ctype_digit'));
        $this->assertSame(false, (array_find)(['a', 'b', 'c'], function ($v) { }));

        $this->assertEquals('A', (array_find)(['a', 'b', '9'], function ($v) {
            return ctype_digit($v) ? false : strtoupper($v);
        }, false));
        $this->assertEquals('B', (array_find)(['9', 'b', 'c'], function ($v) {
            return ctype_digit($v) ? false : strtoupper($v);
        }, false));
        $this->assertEquals(5, (array_find)([1, 2, 3, 4, -5, -6], function ($v) {
            return $v < 0 ? abs($v) : false;
        }, false));
    }

    function test_array_grep_key()
    {
        $this->assertEquals(['a', 'b', 'c'], (array_grep_key)(['a', 'b', 'c'], '#\d#'));
        $this->assertEquals(['hoge' => 'HOGE'], (array_grep_key)(['hoge' => 'HOGE', 'fuga' => 'FUGA'], '#^h#'));
        $this->assertEquals(['fuga' => 'FUGA'], (array_grep_key)(['hoge' => 'HOGE', 'fuga' => 'FUGA'], '#^h#', true));
    }

    function test_array_map_recursive()
    {
        $this->assertSame((array_map_recursive)([
            'k' => 'v',
            'c' => new \ArrayObject([
                'k1' => 'v1',
                'k2' => 'v2',
            ]),
        ], 'strtoupper'), [
            'k' => 'V',
            'c' => [
                'k1' => 'V1',
                'k2' => 'V2',
            ],
        ]);

        $this->assertSame((array_map_recursive)([
            'k' => 'v',
            'c' => new \ArrayObject([
                'k1' => 'v1',
                'k2' => 'v2',
            ]),
        ], 'gettype', false), [
            'k' => 'string',
            'c' => 'object',
        ]);
    }

    function test_array_map_key()
    {
        $this->assertEquals(['A' => 'A', 'B' => 'B'], (array_map_key)(['a' => 'A', 'b' => 'B'], 'strtoupper'));
        $this->assertEquals(['A' => 'A'], (array_map_key)(['a' => 'A', 'b' => 'B'], function ($k) { return $k === 'b' ? null : strtoupper($k); }));
    }

    function test_array_filter_not()
    {
        $this->assertEquals([1 => ''], (array_filter_not)(['a', '', 'c'], 'strlen'));
        $this->assertEquals([1 => ''], (array_filter_not)(new \ArrayObject(['a', '', 'c']), 'strlen'));
    }

    function test_array_filter_key()
    {
        $this->assertEquals([1 => 'b'], (array_filter_key)(['a', 'b', 'c'], function ($k, $v) { return $k === 1; }));
        $this->assertEquals([1 => 'b'], (array_filter_key)(['a', 'b', 'c'], function ($k, $v) { return $v === "b"; }));
        $this->assertEquals(['a', 2 => 'c'], (array_filter_key)(['a', 'b', 'c'], function ($k, $v) { return $v !== "b"; }));
    }

    function test_array_filter_eval()
    {
        $this->assertEquals([1 => 'b'], (array_filter_eval)(['a', 'b', 'c'], '$k === 1'));
        $this->assertEquals([1 => 'b'], (array_filter_eval)(['a', 'b', 'c'], '$v === "b"'));
        $this->assertEquals(['a', 2 => 'c'], (array_filter_eval)(['a', 'b', 'c'], '$v !== "b"'));
    }

    function test_array_where()
    {
        $array = [
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ];

        // 省略すればそのまま
        $this->assertEquals($array, (array_where)($array));

        // flag 値で true フィルタ
        $this->assertEquals([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
        ], (array_where)($array, 'flag'));

        // name 値でクロージャフィルタ（'o' を含む）
        $this->assertEquals([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ], (array_where)($array, 'name', function ($name) {
            return strpos($name, 'o') !== false;
        }));

        // id, name 値でクロージャフィルタ（id === 3 && 'o' を含む）
        $this->assertEquals([
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ], (array_where)($array, ['id', 'name'], function ($id_name) {
            return $id_name['id'] === 3 && strpos($id_name['name'], 'o') !== false;
        }));

        // キーでクロージャフィルタ（key === 2）
        $this->assertEquals([
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ], (array_where)($array, null, function ($name, $key) {
            return $key === 2;
        }));

        // 連想配列
        $this->assertEquals([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
        ], (array_where)($array, ['flag' => 1], false));
        $this->assertEquals([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
        ], (array_where)($array, ['flag' => true], true));
        $this->assertEquals([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
        ], (array_where)($array, ['name' => 'hoge', 'flag' => false]));
        $this->assertEquals([], (array_where)($array, ['flag' => 1], true));
        $this->assertEquals([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
        ], (array_where)($array, ['name' => function ($name) { return $name === 'hoge'; }, 'flag' => function ($flag) { return !$flag; }]));

        // 例外
        $this->assertException('must be bool', array_where, $array, ['flag' => 1], function () { });
    }

    function test_array_map_filter()
    {
        // strict:false なので 0 が除外される
        $this->assertEquals([-2, -1, '3' => 1, 2], (array_map_filter)([1, 2, 3, 4, 5], function ($v) {
            return $v - 3;
        }, false));

        // strict:true なので全て返ってくる
        $this->assertEquals([-2, -1, 0, 1, 2], (array_map_filter)([1, 2, 3, 4, 5], function ($v) {
            return $v - 3;
        }, true));

        // strict:true は null がフィルタされる
        $this->assertEquals([-2, -1, '3' => 1, 2], (array_map_filter)([1, 2, 3, 4, 5], function ($v) {
            return $v === 3 ? null : $v - 3;
        }, true));
    }

    function test_array_map_method()
    {
        $o1 = new \Concrete('a');
        $o2 = new \Concrete('b');
        $o3 = new \Concrete('c');

        // きちんと呼ばれるし引数も渡る
        $this->assertEquals(['a', 'b', 'c'], (array_map_method)([$o1, $o2, $o3], 'getName'));
        $this->assertEquals(['_A', '_B', '_C'], (array_map_method)([$o1, $o2, $o3], 'getName', ['_', true]));

        // $ignore=true すると filter される
        $this->assertEquals(['a'], (array_map_method)([$o1, null, 123], 'getName', [], true));

        // $ignore=null するとそのまま返す
        $this->assertEquals(['a', null, 123], (array_map_method)([$o1, null, 123], 'getName', [], null));

        // iterable
        $this->assertEquals(['a', null, 123], (array_map_method)(new \ArrayObject([$o1, null, 123]), 'getName', [], null));
    }

    function test_array_maps()
    {
        $this->assertEquals(['_A', '_B', '_C'], (array_maps)(['a', 'b', 'c'], 'strtoupper', (lbind)(strcat, '_')));
        // これでも同じ
        $composite = (composite)(false, 'strtoupper', (lbind)(strcat, '_'));
        $this->assertEquals(['_A', '_B', '_C'], (array_maps)(['a', 'b', 'c'], $composite));

        $this->assertEquals(['a' => 'Aaa', 'b' => 'Bbb'], (array_maps)(['a' => 'A', 'b' => 'B'], strcat, strcat));

        // メソッドモード
        $ex = new \Exception('msg1', 1, new \Exception('msg2', 2, new \Exception('msg3', 3)));
        $this->assertEquals(['msg1', 'msg1', 'msg1'], (array_maps)([$ex, $ex, $ex], '@getMessage'));
        $this->assertEquals([2, 2, 2], (array_maps)([$ex, $ex, $ex], '@getPrevious', '@getCode'));
        $this->assertEquals([3, 3, 3], (array_maps)([$ex, $ex, $ex], '@getPrevious', '@getPrevious', '@getCode'));

        $objs = [new \Concrete('a'), new \Concrete('b'), new \Concrete('c')];
        $this->assertEquals(['P-A', 'P-B', 'P-C'], (array_maps)($objs, ['getName' => ['p-', true]]));

        $objs = new \ArrayObject([new \Concrete('a'), new \Concrete('b'), new \Concrete('c')]);
        $this->assertEquals(['P-A', 'P-B', 'P-C'], (array_maps)($objs, ['getName' => ['p-', true]]));
    }

    function test_array_kmap()
    {
        $array = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ];
        $this->assertEquals([
            'k1' => '0:k1-v1',
            'k2' => '1:k2-v2',
            'k3' => '2:k3-v3',
        ], (array_kmap)($array, function ($v, $k, $n) { return "$n:$k-$v"; }));
    }

    function test_array_nmap()
    {
        // それぞれ N 番目に適用される
        $this->assertEquals(['1a--z', '2a--z'], (array_nmap)([1, 2], strcat, 0, 'a-', '-z'));
        $this->assertEquals(['a-1-z', 'a-2-z'], (array_nmap)([1, 2], strcat, 1, 'a-', '-z'));
        $this->assertEquals(['a--z1', 'a--z2'], (array_nmap)([1, 2], strcat, 2, 'a-', '-z'));

        /// $n に配列を渡すとキー・値の両方が渡ってくる
        // キーを1番目、値を2番目に渡す
        $this->assertEquals(['k' => ' a k b v c '], (array_nmap)(['k' => 'v'], strcat, [1 => 2], ' a ', ' b ', ' c '));
        // キーを2番目、値を1番目に渡す
        $this->assertEquals(['k' => ' a v b k c '], (array_nmap)(['k' => 'v'], strcat, [2 => 1], ' a ', ' b ', ' c '));
        // キーを1番目、値を1番目に渡す（キーが優先される）
        $this->assertEquals(['k' => ' a kv b  c '], (array_nmap)(['k' => 'v'], strcat, [1 => 1], ' a ', ' b ', ' c '));

        $this->assertException('empty', array_nmap, [], strcat, []);
        $this->assertException('positive', array_nmap, [], strcat, [1 => -1]);
        $this->assertException('positive', array_nmap, [], strcat, [-1 => 1]);
    }

    function test_array_lmap()
    {
        // 最左に適用される
        $this->assertEquals(['1a--z', '2a--z'], (array_lmap)([1, 2], strcat, 'a-', '-z'));
    }

    function test_array_rmap()
    {
        // 最右に適用される
        $this->assertEquals(['a--z1', 'a--z2'], (array_rmap)([1, 2], strcat, 'a-', '-z'));
    }

    function test_array_each()
    {
        $this->assertSame((array_each)([1, 2, 3, 4, 5], function (&$carry, $v) { $carry .= $v; }, ''), '12345');
        $this->assertSame((array_each)([1, 2, 3, 4, 5], function (&$carry, $v) { $carry[$v] = $v * $v; }, []), [
            1 => 1,
            2 => 4,
            3 => 9,
            4 => 16,
            5 => 25,
        ]);
        $receiver = [];
        $this->assertSame((array_each)([1, 2, 3, 4, 5], function (&$carry, $v, $k, $n) use (&$receiver) {
            $receiver[] = $n;
            if ($k === 3) {
                return false;
            }
            $carry[$v] = $v * $v;
        }, []), [
            1 => 1,
            2 => 4,
            3 => 9,
        ]);
        $this->assertEquals([0, 1, 2, 3], $receiver);

        // こういう使い方（オブジェクトの配列からメソッド由来の連想配列を作成）を想定しているのでテスト
        $ex_a = new \Exception('a');
        $ex_b = new \Exception('b');
        $ex_c = new \Exception('c');
        $this->assertSame(['a' => $ex_a, 'b' => $ex_b, 'c' => $ex_c], (array_each)([$ex_a, $ex_b, $ex_c], function (&$carry, \Exception $ex) {
            $carry[$ex->getMessage()] = $ex;
        }));

        // 推奨しないが見た目が気に入っている使い方
        $this->assertSame('start123', (array_each)([1, 2, 3], function (&$carry = 'start', $v = null) { $carry .= $v; }));
        $this->assertSame('start', (array_each)([], function (&$carry = 'start', $v = null) { $carry .= $v; }));
        $this->assertSame(null, (array_each)([], function (&$carry, $v) { $carry .= $v; }));
    }

    function test_array_depth()
    {
        // シンプル
        $this->assertEquals(1, (array_depth)([]));
        $this->assertEquals(1, (array_depth)(['X']));
        $this->assertEquals(2, (array_depth)([['X']]));
        $this->assertEquals(3, (array_depth)([[['X']]]));

        // 最大が得られるか？
        $this->assertEquals(2, (array_depth)(['X', 'y' => ['Y']]));
        $this->assertEquals(2, (array_depth)(['x' => ['X'], 'Y']));
        $this->assertEquals(3, (array_depth)(['x' => ['X'], 'y' => ['Y'], 'z' => ['z' => ['Z']]]));

        // $max_depth 指定
        $this->assertEquals(1, (array_depth)([[[[['X']]]]], 1));
        $this->assertEquals(2, (array_depth)([[[[['X']]]]], 2));
        $this->assertEquals(3, (array_depth)([[[[['X']]]]], 3));
        $this->assertEquals(4, (array_depth)([[[[['X']]]]], 4));
        $this->assertEquals(5, (array_depth)([[[[['X']]]]], 5));
        $this->assertEquals(5, (array_depth)([[[[['X']]]]], 6));
        $this->assertEquals(3, (array_depth)([
            ['X'],
            [['X']],
            [[['X']]],
            [[[['X']]]],
            [[[[['X']]]]],
            [[[[[['X']]]]]],
        ], 3));
    }

    function test_array_insert()
    {
        // 第3引数を省略すると最後に挿入される
        $this->assertEquals([1, 2, 3, 'x'], (array_insert)([1, 2, 3], 'x'));

        // 第3引数を指定するとその位置に挿入される
        $this->assertEquals([1, 'x', 2, 3], (array_insert)([1, 2, 3], 'x', 1));

        // 配列を指定するとその位置にマージされる
        $this->assertEquals([1, 'x1', 'x2', 2, 3], (array_insert)([1, 2, 3], ['x1', 'x2'], 1));

        // 負数を指定すると後ろから数えて挿入される
        $this->assertEquals([1, 2, 'x1', 'x2', 3], (array_insert)([1, 2, 3], ['x1', 'x2'], -1));

        // 連想配列もOK
        $this->assertEquals(['x' => 'X', 'x1', 'n' => 'x2', 'y' => 'Y', 'z' => 'Z'], (array_insert)(['x' => 'X', 'y' => 'Y', 'z' => 'Z'], ['x1', 'n' => 'x2'], 1));
    }

    function test_array_assort()
    {
        // 普通に使う
        $this->assertEquals([
            'none'  => [],
            'char1' => [0 => 'a'],
            'char2' => [1 => 'bb'],
            'char3' => [2 => 'ccc'],
        ], (array_assort)(['a', 'bb', 'ccc'], [
            'none'  => function ($v) { return strlen($v) === 0; },
            'char1' => function ($v) { return strlen($v) === 1; },
            'char2' => function ($v) { return strlen($v) === 2; },
            'char3' => function ($v) { return strlen($v) === 3; },
        ]));

        // 複数条件にマッチ
        $this->assertEquals([
            'rule1' => ['a', 'bb', 'ccc'],
            'rule2' => ['a', 'bb', 'ccc'],
        ], (array_assort)(['a', 'bb', 'ccc'], [
            'rule1' => function () { return true; },
            'rule2' => function () { return true; },
        ]));
    }

    function test_array_count()
    {
        $array = ['a', 'b', 'c'];

        // 普通に使う分には count(array_filter()) と同じ
        $eq_b = function ($v) { return $v === 'b'; };
        $this->assertEquals(count(array_filter($array, $eq_b)), (array_count)($array, $eq_b));

        $row1 = ['id' => 1, 'group' => 'A', 'flag' => false];
        $row2 = ['id' => 2, 'group' => 'B', 'flag' => true];
        $row3 = ['id' => 3, 'group' => 'B', 'flag' => false];
        $array = [
            'k1' => $row1,
            'k2' => $row2,
            3    => $row3,
        ];

        // flag をカウント
        $this->assertEquals(1, (array_count)($array, (array_of)('flag')));
        $this->assertEquals(2, (array_count)($array, (not_func)((array_of)('flag'))));

        // group: 'B' をカウント。ただし、数値キーの場合のみ
        $this->assertEquals(1, (array_count)($array, function ($v, $k) {
            return is_int($k) && $v['group'] === 'B';
        }));

        // group: 'A', 'B' をそれぞれカウント
        $this->assertEquals([
            'A' => 1,
            'B' => 2,
        ], (array_count)($array, [
            'A' => (composite)((array_of)('group'), (lbind)(str_equals, 'A')),
            'B' => function ($v) { return $v['group'] === 'B'; },
        ]));
    }

    function test_array_group()
    {
        $this->assertEquals([
            1 => [1],
            2 => [2],
            3 => [3],
            4 => [4],
            5 => [5],
        ], (array_group)([1, 2, 3, 4, 5]));

        $this->assertEquals([
            0 => [2, 4],
            1 => [1, 3, 5],
        ], (array_group)([1, 2, 3, 4, 5], function ($v) { return $v % 2; }));

        $row1 = ['id' => 1, 'group' => 'A', 'flag' => false];
        $row2 = ['id' => 2, 'group' => 'B', 'flag' => true];
        $row3 = ['id' => 3, 'group' => 'A', 'flag' => false];
        $array = [
            'k1' => $row1,
            'k2' => $row2,
            3    => $row3,
        ];

        $this->assertEquals(['A' => ['k1' => $row1, 0 => $row3], 'B' => ['k2' => $row2]], (array_group)($array, (array_of)('group')));
        $this->assertEquals(['A' => ['k1' => $row1, 3 => $row3], 'B' => ['k2' => $row2]], (array_group)($array, (array_of)('group'), true));

        $this->assertEquals([
            'A' => [
                1 => [
                    'id'    => 1,
                    'group' => 'A',
                    'flag'  => false,
                ],
                3 => [
                    'id'    => 3,
                    'group' => 'A',
                    'flag'  => false,
                ],
            ],
            'B' => [
                2 => [
                    'id'    => 2,
                    'group' => 'B',
                    'flag'  => true,
                ],
            ],
        ], (array_group)([$row1, $row2, $row3], (array_of)(['group', 'id'])));
    }

    function test_array_all()
    {
        $array = [
            0 => ['id' => 1, 'name' => '', 'flag' => false],
            1 => ['id' => 2, 'name' => '', 'flag' => true],
            2 => ['id' => 3, 'name' => '', 'flag' => false],
        ];

        $this->assertTrue((array_all)([], null));
        $this->assertFalse((array_all)([], null, false));

        $this->assertTrue((array_all)([true, true]));
        $this->assertFalse((array_all)([true, false]));
        $this->assertFalse((array_all)([false, false]));

        $this->assertTrue((array_all)($array, function ($v) { return $v['id']; }));
        $this->assertFalse((array_all)($array, function ($v) { return $v['flag']; }));
        $this->assertFalse((array_all)($array, function ($v) { return $v['name']; }));
        $this->assertFalse((array_all)($array, function ($v, $k) { return $k && $v['flag']; }));
    }

    function test_array_any()
    {
        $array = [
            0 => ['id' => 1, 'name' => '', 'flag' => false],
            1 => ['id' => 2, 'name' => '', 'flag' => true],
            2 => ['id' => 3, 'name' => '', 'flag' => false],
        ];

        $this->assertFalse((array_any)([], null));
        $this->assertTrue((array_any)([], null, true));

        $this->assertTrue((array_any)([true, true]));
        $this->assertTrue((array_any)([true, false]));
        $this->assertFalse((array_any)([false, false]));

        $this->assertTrue((array_any)($array, function ($v) { return $v['id']; }));
        $this->assertTrue((array_any)($array, function ($v) { return $v['flag']; }));
        $this->assertFalse((array_any)($array, function ($v) { return $v['name']; }));
        $this->assertTrue((array_any)($array, function ($v, $k) { return $k && $v['flag']; }));
    }

    function test_array_distinct()
    {
        // シンプルなもの
        $this->assertSame([], (array_distinct)([]));
        $this->assertSame([1], (array_distinct)([1]));
        $this->assertSame([1, '2', 3 => 3], (array_distinct)([1, '2', 2, 3, '3']));
        $this->assertSame([1, 2, 3 => 3], (array_distinct)([1, 2, 2, 3, 3, 3], SORT_NUMERIC));
        $this->assertSame(['a', 'A'], (array_distinct)(['a', 'A'], SORT_STRING));
        $this->assertSame(['a'], (array_distinct)(['a', 'A'], SORT_STRING | SORT_FLAG_CASE));

        // クロージャを与える
        $this->assertEquals([1, 2, 3 => 3], (array_distinct)([1, 2, -2, 3, -3], function ($a, $b) {
            return abs($a) <=> abs($b);
        }));

        // 配列の配列
        $rows = [
            11 => $r1 = ['id' => 1, 'group1' => 'groupA', 'group2' => 'groupA'],
            12 => $r2 = ['id' => 2, 'group1' => 'groupB', 'group2' => 'groupB'],
            13 => $r3 = ['id' => 3, 'group1' => 'groupA', 'group2' => 'groupB'],
            14 => $r4 = ['id' => 4, 'group1' => 'groupA', 'group2' => 'groupB'],
        ];
        $this->assertEquals([
            11 => $r1,
            12 => $r2,
        ], (array_distinct)($rows, 'group1'));
        $this->assertEquals([
            11 => $r1,
            12 => $r2,
            13 => $r3,
        ], (array_distinct)($rows, ['group1', 'group2']));

        $objects = [
            11 => $e1 = new \Exception('a', 1),
            12 => $e2 = new \Exception('b', 2),
            13 => $e3 = new \Exception('b', 3),
            14 => $e4 = new \Exception('b', 3),
        ];
        $this->assertEquals([
            11 => $e1,
            12 => $e2,
        ], (array_distinct)($objects, ['getMessage' => []]));
        $this->assertEquals([
            11 => $e1,
            12 => $e2,
            13 => $e3,
        ], (array_distinct)($objects, ['getMessage' => [], 'getCode' => []]));
    }

    function test_array_order()
    {
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9], (array_order)([2, 4, 5, 1, 8, 6, 9, 3, 7], true));
        $this->assertEquals(['g', 'f', 'e', 'd', 'c', 'b', 'a'], (array_order)(['b', 'd', 'g', 'a', 'f', 'e', 'c'], false));
        $this->assertEquals(['a', 'a', 'b', 'b', 'c', 'c', 'z'], (array_order)(['b', 'c', 'z', 'b', 'a', 'c', 'a'], ['a', 'b', 'c']));
    }

    function test_array_order_list()
    {
        $data = [
            0 => '111',
            1 => '1',
            2 => '011',
            3 => '111',
            4 => '1',
            5 => '11',
            6 => '1',
        ];

        $actual = (array_order)($data, true, true);
        $this->assertSame([
            2 => '011',
            1 => '1',
            4 => '1',
            6 => '1',
            5 => '11',
            0 => '111',
            3 => '111',
        ], $actual);

        $actual = (array_order)($data, -SORT_NATURAL, true);
        $this->assertSame([
            0 => '111',
            3 => '111',
            2 => '011',
            5 => '11',
            1 => '1',
            4 => '1',
            6 => '1',
        ], $actual);
    }

    function test_array_order_hash()
    {
        $data = [
            'a' => '111',
            'b' => '1',
            'c' => '011',
            'd' => '111',
            'e' => '1',
            'f' => '11',
            'g' => '1',
        ];

        $actual = (array_order)($data, true, true);
        $this->assertSame([
            'c' => '011',
            'b' => '1',
            'e' => '1',
            'g' => '1',
            'f' => '11',
            'a' => '111',
            'd' => '111',
        ], $actual);

        $actual = (array_order)($data, -SORT_NATURAL, true);
        $this->assertSame([
            'a' => '111',
            'd' => '111',
            'c' => '011',
            'f' => '11',
            'b' => '1',
            'e' => '1',
            'g' => '1',
        ], $actual);
    }

    function test_array_order_bool()
    {
        $data = [
            0 => ['string' => 'aa', 'integer' => 7],
            1 => ['string' => 'cc', 'integer' => 1],
            2 => ['string' => 'aa', 'integer' => 2],
            3 => ['string' => 'bb', 'integer' => 6],
            4 => ['string' => 'dd', 'integer' => 2],
            5 => ['string' => 'cc', 'integer' => 6],
            6 => ['string' => 'cc', 'integer' => 2],
        ];

        // 文字降順・数値昇順
        $actual = (array_order)($data, [
            'string'  => false,
            'integer' => true,
        ], true);
        $this->assertSame([
            4 => ['string' => 'dd', 'integer' => 2],
            1 => ['string' => 'cc', 'integer' => 1],
            6 => ['string' => 'cc', 'integer' => 2],
            5 => ['string' => 'cc', 'integer' => 6],
            3 => ['string' => 'bb', 'integer' => 6],
            2 => ['string' => 'aa', 'integer' => 2],
            0 => ['string' => 'aa', 'integer' => 7],
        ], $actual);

        // 文字昇順・数値降順
        $actual = (array_order)($data, [
            'string'  => true,
            'integer' => false,
        ], true);
        $this->assertSame([
            0 => ['string' => 'aa', 'integer' => 7],
            2 => ['string' => 'aa', 'integer' => 2],
            3 => ['string' => 'bb', 'integer' => 6],
            5 => ['string' => 'cc', 'integer' => 6],
            6 => ['string' => 'cc', 'integer' => 2],
            1 => ['string' => 'cc', 'integer' => 1],
            4 => ['string' => 'dd', 'integer' => 2],
        ], $actual);

        // 数値降順・文字昇順
        $actual = (array_order)($data, [
            'integer' => false,
            'string'  => true,
        ], true);
        $this->assertSame([
            0 => ['string' => 'aa', 'integer' => 7],
            3 => ['string' => 'bb', 'integer' => 6],
            5 => ['string' => 'cc', 'integer' => 6],
            2 => ['string' => 'aa', 'integer' => 2],
            6 => ['string' => 'cc', 'integer' => 2],
            4 => ['string' => 'dd', 'integer' => 2],
            1 => ['string' => 'cc', 'integer' => 1],
        ], $actual);

        // 数値昇順・文字降順
        $actual = (array_order)($data, [
            'integer' => true,
            'string'  => false,
        ], true);
        $this->assertSame([
            1 => ['string' => 'cc', 'integer' => 1],
            4 => ['string' => 'dd', 'integer' => 2],
            6 => ['string' => 'cc', 'integer' => 2],
            2 => ['string' => 'aa', 'integer' => 2],
            5 => ['string' => 'cc', 'integer' => 6],
            3 => ['string' => 'bb', 'integer' => 6],
            0 => ['string' => 'aa', 'integer' => 7],
        ], $actual);
    }

    function test_array_order_int()
    {
        $data = [
            0 => ['string' => '111', 'integer' => '7a'],
            1 => ['string' => '1', 'integer' => '1g'],
            2 => ['string' => '011', 'integer' => '2w'],
            3 => ['string' => '111', 'integer' => '6u'],
            4 => ['string' => '1', 'integer' => '2r'],
            5 => ['string' => '11', 'integer' => '6t'],
            6 => ['string' => '1', 'integer' => '2i'],
        ];

        // 文字自然降順・数値昇順
        $actual = (array_order)($data, [
            'string'  => SORT_NATURAL,
            'integer' => SORT_NUMERIC,
        ], true);
        $this->assertSame([
            1 => ['string' => '1', 'integer' => '1g'],
            6 => ['string' => '1', 'integer' => '2i'],
            4 => ['string' => '1', 'integer' => '2r'],
            2 => ['string' => '011', 'integer' => '2w'],
            5 => ['string' => '11', 'integer' => '6t'],
            3 => ['string' => '111', 'integer' => '6u'],
            0 => ['string' => '111', 'integer' => '7a'],
        ], $actual);

        // 文字自然昇順・数値降順
        $actual = (array_order)($data, [
            'string'  => -SORT_NATURAL,
            'integer' => -SORT_NUMERIC,
        ], true);
        $this->assertSame([
            0 => ['string' => '111', 'integer' => '7a'],
            3 => ['string' => '111', 'integer' => '6u'],
            5 => ['string' => '11', 'integer' => '6t'],
            2 => ['string' => '011', 'integer' => '2w'],
            6 => ['string' => '1', 'integer' => '2i'],
            4 => ['string' => '1', 'integer' => '2r'],
            1 => ['string' => '1', 'integer' => '1g'],
        ], $actual);
    }

    function test_array_order_array()
    {
        $data = [
            0 => ['string' => 'aa', 'integer' => 7],
            1 => ['string' => 'cc', 'integer' => 1],
            2 => ['string' => 'aa', 'integer' => 2],
            3 => ['string' => 'bb', 'integer' => 6],
            4 => ['string' => 'dd', 'integer' => 2],
            5 => ['string' => 'cc', 'integer' => 6],
            6 => ['string' => 'cc', 'integer' => 2],
        ];

        $actual = (array_order)($data, [
            'string'  => ['bb', 'aa', 'dd', 'cc'],
            'integer' => [2, 6, 7],
        ], true);
        $this->assertSame([
            3 => ['string' => 'bb', 'integer' => 6],
            2 => ['string' => 'aa', 'integer' => 2],
            0 => ['string' => 'aa', 'integer' => 7],
            4 => ['string' => 'dd', 'integer' => 2],
            6 => ['string' => 'cc', 'integer' => 2],
            5 => ['string' => 'cc', 'integer' => 6],
            1 => ['string' => 'cc', 'integer' => 1],
        ], $actual);
    }

    function test_array_order_closure1()
    {
        $data = [
            0 => ['string' => 'aa', 'integer' => 7],
            1 => ['string' => 'cc', 'integer' => 1],
            2 => ['string' => 'aa', 'integer' => 2],
            3 => ['string' => 'bb', 'integer' => 6],
            4 => ['string' => 'dd', 'integer' => 2],
            5 => ['string' => 'cc', 'integer' => 6],
            6 => ['string' => 'cc', 'integer' => 2],
        ];

        $actual = (array_order)($data, [
            'integer' => function ($v) {
                // 6は0とみなす
                return $v === 6 ? 0 : $v;
            },
            'string'  => function ($v) {
                // "aa"は"zz"とみなす
                return $v === 'aa' ? 'zz' : $v;
            },
        ], true);
        $this->assertSame([
            3 => ['string' => 'bb', 'integer' => 6],
            5 => ['string' => 'cc', 'integer' => 6],
            1 => ['string' => 'cc', 'integer' => 1],
            6 => ['string' => 'cc', 'integer' => 2],
            4 => ['string' => 'dd', 'integer' => 2],
            2 => ['string' => 'aa', 'integer' => 2],
            0 => ['string' => 'aa', 'integer' => 7],
        ], $actual);

        $actual = (array_order)($data, [
            'string' => (return_arg)(0),
            ''       => (return_arg)(0),
        ], true);
        $this->assertSame([
            0 => ['string' => 'aa', 'integer' => 7],
            2 => ['string' => 'aa', 'integer' => 2],
            3 => ['string' => 'bb', 'integer' => 6],
            1 => ['string' => 'cc', 'integer' => 1],
            5 => ['string' => 'cc', 'integer' => 6],
            6 => ['string' => 'cc', 'integer' => 2],
            4 => ['string' => 'dd', 'integer' => 2],
        ], $actual);
    }

    function test_array_order_closure2()
    {
        $data = [
            0 => ['string' => 'aa', 'array' => [7, 3]],
            1 => ['string' => 'cc', 'array' => [1, 5]],
            2 => ['string' => 'aa', 'array' => [2, 2]],
            3 => ['string' => 'bb', 'array' => [6, 3]],
            4 => ['string' => 'dd', 'array' => [2, 1]],
            5 => ['string' => 'cc', 'array' => [6, 5]],
            6 => ['string' => 'cc', 'array' => [2, 2]],
        ];

        $actual = (array_order)($data, [
            'string' => function ($a, $b) { return strcmp($a, $b); },
            'array'  => function ($a, $b) { return array_sum($b) - array_sum($a); },
        ], true);
        $this->assertSame([
            0 => ['string' => 'aa', 'array' => [7, 3]],
            2 => ['string' => 'aa', 'array' => [2, 2]],
            3 => ['string' => 'bb', 'array' => [6, 3]],
            5 => ['string' => 'cc', 'array' => [6, 5]],
            1 => ['string' => 'cc', 'array' => [1, 5]],
            6 => ['string' => 'cc', 'array' => [2, 2]],
            4 => ['string' => 'dd', 'array' => [2, 1]],
        ], $actual);
    }

    function test_array_order_closure3()
    {
        $data = [
            '33',
            '111',
            '222',
            '11',
            '333',
            '22',
        ];

        // returnType が int なら数値的にソートされる
        $cb = eval('return function ($v): int { return $v; };');
        $actual = (array_order)($data, $cb);
        $this->assertSame([
            '11',
            '22',
            '33',
            '111',
            '222',
            '333',
        ], $actual);

        // returnType が string なら文字的にソートされる
        $cb = eval('return function ($v): string { return $v; };');
        $actual = (array_order)($data, $cb);
        $this->assertSame([
            '11',
            '111',
            '22',
            '222',
            '33',
            '333',
        ], $actual);
    }

    function test_array_order_ex()
    {
        $this->assertEquals([], (array_order)([], [[]]));
        $this->assertEquals([1], (array_order)([1], [[]]));

        $this->assertException(new \InvalidArgumentException('x is undefined'), array_order, [['a' => 1], ['a' => 2]], ['x' => true]);

        $this->assertException(new \DomainException('$order is invalid'), array_order, [['a' => 1], ['a' => 2]], ['a' => new \stdClass()]);
    }

    function test_array_order_misc()
    {
        // 1000 rows, 26 cols, 5 order is in 1 seconds
        $data = array_fill(0, 999, array_fill_keys(range('a', 'z'), 1));
        $t = microtime(true);
        (array_order)($data, [
            'a' => true,
            'b' => false,
            'c' => [1, 2, 3],
            'd' => function ($v) { return "$v"; },
            'e' => function ($a, $b) { return strcmp($a, $b); },
        ]);
        $t = microtime(true) - $t;
        $this->assertLessThan(1.0, $t, "$t milliseconds is too slow.");
    }

    function test_array_shuffle()
    {
        srand(123);
        mt_srand(123);
        $this->assertEquals(['a' => 'A', 'b' => 'B', 'c' => 'C'], (array_shuffle)(['a' => 'A', 'b' => 'B', 'c' => 'C']));
        $this->assertNotSame(['a' => 'A', 'b' => 'B', 'c' => 'C'], (array_shuffle)(['a' => 'A', 'b' => 'B', 'c' => 'C']));
    }

    function test_array_shrink_key()
    {
        $array = [0 => 'first', 'a' => 'A', 'b' => 'B', 'c' => 'C', 'x' => 'X', 'y' => 'Y', 'z' => 'Z', 99 => 'end'];
        $array1 = [0 => 'first2', 'b' => 'B1', 'a' => 'A1', 'c' => 'C1'];
        $array2 = [1 => 'second', 'b' => 'B2', 'a' => 'A2', 'c' => 'C2', 'x' => 'X2'];
        $array3 = ['b' => 'B3', 'a' => 'A3', 'c' => 'C3', 'y' => 'Y2', 100 => 'end'];

        // array_intersect_key は左方優先だが・・・
        $this->assertSame(['a' => 'A', 'b' => 'B', 'c' => 'C'], array_intersect_key($array, $array1, $array2, $array3));
        // array_shrink_key は右方優先
        $this->assertSame(['a' => 'A3', 'b' => 'B3', 'c' => 'C3'], (array_shrink_key)($array, $array1, $array2, $array3));

        // オブジェクトも渡せる
        $object = (stdclass)($array);
        $object1 = (stdclass)($array1);
        $object2 = (stdclass)($array2);
        $object3 = (stdclass)($array3);
        $this->assertSame(['a' => 'A3', 'b' => 'B3', 'c' => 'C3'], (array_shrink_key)($object, $object1, $object2, $object3));
    }

    function test_array_fill_callback()
    {
        $this->assertSame(array_combine($keys = ['a', 'b', 'c'], array_map('strtoupper', $keys)), (array_fill_callback)(['a', 'b', 'c'], 'strtoupper'));
    }

    function test_array_pickup()
    {
        $this->assertSame(['a' => 'A'], (array_pickup)(['a' => 'A', 'b' => ['b' => 'B']], ['a']));
        $this->assertSame(['b' => ['b' => 'B']], (array_pickup)(['a' => 'A', 'b' => ['b' => 'B']], ['b']));

        $this->assertSame(['a' => 'A', 'c' => 'C'], (array_pickup)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['a', 'c']));
        $this->assertSame(['c' => 'C', 'a' => 'A'], (array_pickup)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['c', 'a']));

        $this->assertSame(['a' => 'A', 'c' => 'C'], (array_pickup)((stdclass)(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['a', 'c']));
        $this->assertSame(['c' => 'C', 'a' => 'A'], (array_pickup)((stdclass)(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['c', 'a']));

        $this->assertSame(['AAA' => 'A'], (array_pickup)(['a' => 'A', 'b' => ['b' => 'B']], ['a' => 'AAA']));
        $this->assertSame(['BBB' => ['b' => 'B']], (array_pickup)(['a' => 'A', 'b' => ['b' => 'B']], ['b' => 'BBB']));
    }

    function test_array_remove()
    {
        $this->assertSame(['a' => 'A', 'c' => 'C'], (array_remove)(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'b'));
        $this->assertSame(['a' => 'A', 'b' => 'B', 'c' => 'C'], (array_remove)(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x'));

        $this->assertSame(['a' => 'A'], (array_remove)(['a' => 'A', 'b' => ['b' => 'B']], ['b']));
        $this->assertSame(['b' => ['b' => 'B']], (array_remove)(['a' => 'A', 'b' => ['b' => 'B']], ['a']));

        $this->assertSame(['b' => 'B'], (array_remove)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['a', 'c']));
        $this->assertSame(['b' => 'B'], (array_remove)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['c', 'a']));

        $this->assertEquals(new \ArrayObject(['b' => 'B']), (array_remove)(new \ArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['a', 'c']));
        $this->assertEquals(new \ArrayObject(['b' => 'B']), (array_remove)(new \ArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['c', 'a']));
    }

    function test_array_lookup()
    {
        $arrays = [
            11 => ['id' => 1, 'name' => 'name1'],
            12 => ['id' => 2, 'name' => 'name2'],
            13 => ['id' => 3, 'name' => 'name3'],
        ];

        $objects = array_map(stdclass, $arrays);

        // 第3引数を与えれば array_column と全く同じ
        $this->assertSame(array_column($arrays, 'name', 'id'), (array_lookup)($arrays, 'name', 'id'));
        // 与えなければキーが保存される array_column のような動作になる
        $this->assertSame([11 => 'name1', 12 => 'name2', 13 => 'name3'], (array_lookup)($arrays, 'name'));
        $this->assertSame(array_combine(array_keys($arrays), array_column($arrays, null)), (array_lookup)($arrays, null));
        // オブジェクトもOK
        $this->assertSame([11 => 'name1', 12 => 'name2', 13 => 'name3'], (array_lookup)($objects, 'name'));
    }

    function test_array_columns()
    {
        $array = [
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
        ];

        $this->assertEquals([
            'id'   => [1, 2, 3],
            'name' => ['A', 'B', 'C'],
        ], (array_columns)($array));

        $this->assertEquals([
            'name' => [1 => 'A', 2 => 'B', 3 => 'C'],
        ], (array_columns)($array, 'name', 'id'));

        $this->assertException('InvalidArgumentException', array_columns, []);
    }

    function test_array_uncolumns()
    {
        // 普通の配列
        $this->assertEquals([
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
        ], (array_uncolumns)([
            'id'   => [1, 2, 3],
            'name' => ['A', 'B', 'C'],
        ]));

        // キーも活きる
        $this->assertEquals([
            'x' => ['id' => 1, 'name' => 'A'],
            'y' => ['id' => 2, 'name' => 'B'],
            'z' => ['id' => 3, 'name' => 'C'],
        ], (array_uncolumns)([
            'id'   => ['x' => 1, 'y' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'z' => 'C'],
        ]));

        // バラバラな配列を与えるとバラバラになる
        $this->assertEquals([
            'x'  => ['id' => 1, 'name' => 'A'],
            'ya' => ['id' => 2],
            'z'  => ['id' => 3],
            'y'  => ['name' => 'B'],
            'az' => ['name' => 'C'],
        ], (array_uncolumns)([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ]));

        // null を与えると最初のキーで compat される
        $this->assertEquals([
            'x'  => ['id' => 1, 'name' => 'A'],
            'ya' => ['id' => 2, 'name' => null],
            'z'  => ['id' => 3, 'name' => null],
        ], (array_uncolumns)([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ], null));

        // [デフォルト] を与えるとその値で compat される
        $this->assertEquals([
            'x'   => ['id' => 1, 'name' => 'A'],
            'y'   => ['id' => null, 'name' => 'B'],
            'zzz' => ['id' => 999, 'name' => 999],
        ], (array_uncolumns)([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ], ['x' => null, 'y' => null, 'zzz' => 999]));
    }

    function test_array_convert()
    {
        $array = [
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
                'k22' => [
                    'k221' => 'v221',
                    'k222' => 'v222',
                ],
            ],
        ];

        // 全要素に 'prefix-' を付与する。キーには '_' をつける
        $this->assertEquals([
            '_k1' => 'prefix-v1',
            '_k2' => [
                '_k21' => 'prefix-v21',
                '_k22' => [
                    '_k221' => 'prefix-v221',
                    '_k222' => 'prefix-v222',
                ],
            ],
        ], (array_convert)($array, function ($k, &$v) {
            if (!is_array($v)) {
                $v = "prefix-$v";
            }
            return "_$k";
        }, true));

        // キー 'k21', 'k222' を取り除く
        $this->assertEquals([
            'k1' => 'v1',
            'k2' => [
                'k22' => [
                    'k221' => 'v221',
                ],
            ],
        ], (array_convert)($array, function ($k, $v) {
            return in_array($k, ['k21', 'k222']) ? false : null;
        }));

        // キー 'k21', 'k221', 'k222' を取り除く
        $this->assertEquals([
            'k1' => 'v1',
            'k2' => [
                'k22' => [],
            ],
        ], (array_convert)($array, function ($k, $v) {
            return in_array($k, ['k21', 'k221', 'k222']) ? false : null;
        }));

        // キー 'k22' を取り除く
        $this->assertEquals([
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
            ],
        ], (array_convert)($array, function ($k, $v) {
            return in_array($k, ['k22']) ? false : null;
        }, true));

        // キー 'k22' に要素を生やす
        $this->assertEquals([
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
                'k22' => [
                    'k221' => 'v221',
                    'k222' => 'v222',
                    'new1' => 'new1val',
                    'new2' => 'new2val',
                ],
            ],
        ], (array_convert)($array, function ($k, &$v) {
            if ($k === 'k22') {
                $v = array_merge($v, ['new1' => 'new1val', 'new2' => 'new2val']);
            }
        }, true));

        // 常に null を返せば実質的に array_walk_recursive と同じ
        $this->assertEquals([
            'k1' => 'prefix-v1',
            'k2' => [
                'k21' => 'prefix-v21',
                'k22' => [
                    'k221' => 'prefix-v221',
                    'k222' => 'prefix-v222',
                ],
            ],
        ], (array_convert)($array, function ($k, &$v) {
            $v = "prefix-$v";
            return null;
        }));
    }

    function test_array_convert_seq()
    {
        $array = [
            'k1' => 'v1',
            'k2' => [
                'v21',
                'k22' => ['v221', 'v222',],
            ],
            9    => 'v2',
        ];

        // キー 'k1' を数値連番にする
        $this->assertEquals([
            'k2' => [
                'v21',
                'k22' => ['v221', 'v222'],
            ],
            9    => 'v2',
            10   => 'v1',
        ], (array_convert)($array, function ($k) {
            if ($k === 'k1') {
                return true;
            }
        }));

        // 値 v221 を数値連番にする
        $this->assertEquals([
            'k1' => 'v1',
            'k2' => [
                'v21',
                'k22' => [1 => 'v222', 2 => 'v221',],
            ],
            9    => 'v2',
        ], (array_convert)($array, function ($k, $v) {
            if ($v === 'v221') {
                return true;
            }
        }));

        // 常に true を返せば実質的に array_values(再帰的) と同じ
        $array = [
            5 => 1,
            8 => 2,
            7 => [
                6 => 11,
                3 => 21,
                4 => 31,
            ],
            9 => 3,
        ];
        $this->assertEquals([
            0 => 1,
            1 => 2,
            2 => [
                0 => 11,
                1 => 21,
                2 => 31,
            ],
            3 => 3,
        ], (array_convert)($array, function ($k, $v) {
            return true;
        }, true));
    }

    function test_array_convert_array()
    {
        $array = [
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
                'k22' => 123,
            ],
        ];
        $this->assertEquals([
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
                1,
                2,
                3,
            ],
        ], (array_convert)($array, function ($k, $v) {
            if ($k === 'k22') {
                return [1, 2, 3];
            }
        }));
    }

    function test_array_convert_arg()
    {
        $array = [
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
                'k22' => [
                    'k221' => 'v221',
                    'k222' => 'v222',
                ],
            ],
        ];
        (array_convert)($array, function ($k, $v, $history) {
            static $n = 0;
            $expected = [
                [],
                ['k2'],
                ['k2', 'k22'],
                ['k2', 'k22'],
            ];
            $this->assertEquals($expected[$n++], $history);
        });
    }

    function test_array_flatten()
    {
        $o = new \stdClass();
        $array = [
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
                'k22' => 123,
                'k23' => [1, 2, 3],
            ],
            'o'  => $o,
        ];

        // 区切り文字指定なし
        $this->assertSame([
            'v1',
            'v21',
            123,
            1,
            2,
            3,
            $o,
        ], (array_flatten)($array));

        // 区切り文字指定
        $this->assertSame([
            'k1'       => 'v1',
            'k2.k21'   => 'v21',
            'k2.k22'   => 123,
            'k2.k23.0' => 1,
            'k2.k23.1' => 2,
            'k2.k23.2' => 3,
            'o'        => $o,
        ], (array_flatten)($array, '.'));
    }

    function test_array_nest()
    {
        $this->assertEquals([
            'k1' => 'v2'
        ], (array_nest)([
                'k1.k2' => 'v1',
                'k1'    => 'v2',
            ])
        );
        $this->assertEquals([
            'k1' => [
                0    => 'v1',
                'k2' => 'v2',
            ]
        ], (array_nest)([
                'k1'    => ['v1'],
                'k1.k2' => 'v2',
            ])
        );
        $this->assertEquals([
            'k1' => [
                0    => 'v1',
                'k2' => 'v2',
            ]
        ], (array_nest)([
                'k1.0'  => 'v1',
                'k1.k2' => 'v2',
            ])
        );
        $this->assertException('already exists', (array_nest), [
            'k1'    => 'v1',
            'k1.k2' => 'v2',
        ]);
    }

    function test_array_difference()
    {
        $a1 = [
            'common'        => [
                'key' => 'nodiff',
            ],
            'diff'          => [
                'common'         => [
                    'key' => 'nodiff',
                ],
                'only1'          => 'hoge',
                'array1scalar2'  => [123, 456],
                'scalar1array2'  => 456789,
                'scalar1scalar2' => 'hoge',
                'array1array2'   => [123, 456],
                'hash1hash2'     => ['a' => 'A', 'b' => 'B'],
            ],
            'mix'           => [
                'first' => 'first',
                1,
                2,
                3,
                'last'  => 'last',
            ],
            'diff1array'    => [
                'hoge' => 'HOGE',
            ],
            'diff1scalar'   => 'hoge',
            'array'         => [[1, 2, 3, 4]],
            'tags'          => [
                ['name' => 'tag1', 'value' => 'val1'],
                ['name' => 'tag2', 'value' => 'val2'],
                ['name' => 'tag3', 'value' => 'val3'],
                ['name' => 'tag4', 'value' => 'val4'],
            ],
            'array1scalar2' => [[1, 2, 3]],
            'array2scalar1' => [123],
        ];
        $a2 = [
            'common'        => [
                'key' => 'nodiff',
            ],
            'diff'          => [
                'common'         => [
                    'key' => 'nodiff',
                ],
                'only2'          => 'fuga',
                'array1scalar2'  => 123456,
                'scalar1array2'  => [456, 789],
                'scalar1scalar2' => 'fuga',
                'array1array2'   => [456, 789],
                'hash1hash2'     => ['b' => 'xB', 'c' => 'C'],
            ],
            'mix'           => [
                'first' => 'FIRST',
                2,
                3,
                4,
                'last'  => 'LAST',
            ],
            'diff2array'    => [
                'fuga' => 'FUGA',
            ],
            'diff2scalar'   => 'fuga',
            'array'         => [[3, 4, 5, 6]],
            'tags'          => [
                ['name' => 'tag2', 'value' => 'val2'],
                ['name' => 'tag3', 'value' => 'X'],
                ['name' => 'tag9', 'value' => 'val9'],
            ],
            'array1scalar2' => [123],
            'array2scalar1' => [[1, 2, 3]],
        ];

        //(var_export2)((array_difference)($a1, $a2));
        $this->assertEquals([
            // common は共通しているので結果に出ない
            // 'common' => [],
            // diff.only1 は 1 にしかないので '-' のみ
            'diff.only1'          => [
                '-' => 'hoge',
            ],

            // diff.array1scalar2 は 1 が配列で 2 がスカラーなので '-' が配列、 '+' が1つ出現する
            'diff.array1scalar2'  => [
                '-' => [123, 456],
                '+' => 123456,
            ],

            // diff.scalar1array2 は 1 がスカラーで 2 が配列なので '-' が1つ '+' が配列で出現する
            'diff.scalar1array2'  => [
                '-' => 456789,
                '+' => [456, 789],
            ],

            // diff.scalar1scalar2 は 1 がスカラーで 2 がスカラーなので '+' '-' が出現する
            'diff.scalar1scalar2' => [
                '-' => 'hoge',
                '+' => 'fuga',
            ],

            // diff.array1array2 は共にただの配列なので '+' '-' がそれぞれ出現する（456 はキーが異なるが出現しない）
            'diff.array1array2'   => [
                '-' => [123],
                '+' => [789],
            ],

            // diff.array1array2 は共に連想配列なので '+' '-' がそれぞれ出現する（b は値が異なるので '+' '-'）
            'diff.hash1hash2.a'   => [
                '-' => 'A',
            ],
            'diff.hash1hash2.b'   => [
                '-' => 'B',
                '+' => 'xB',
            ],
            'diff.hash1hash2.c'   => [
                '+' => 'C',
            ],

            // diff.only2 は 2 にしかないので '+' のみ
            'diff.only2'          => [
                '+' => 'fuga',
            ],

            // 数値キーと文字キーの混在
            'mix'                 => [
                '-' => [1],
                '+' => [4],
            ],
            'mix.first'           => [
                '-' => 'first',
                '+' => 'FIRST',
            ],
            'mix.last'            => [
                '-' => 'last',
                '+' => 'LAST',
            ],

            // diff1array は 1 にしかないので '-' のみ
            'diff1array'          => [
                '-' => ['hoge' => 'HOGE'],
            ],

            // diff1scalar は 1 にしかないので '-' のみ
            'diff1scalar'         => [
                '-' => 'hoge',
            ],

            // diff2array は 2 にしかないので '+' のみ
            'diff2array'          => [
                '+' => ['fuga' => 'FUGA'],
            ],

            // diff2scalar は 2 にしかないので '+' のみ
            'diff2scalar'         => [
                '+' => 'fuga',
            ],

            // 素の配列の配列
            'array'               => [
                '-' => [
                    [1, 2, 3, 4],
                ],
                '+' => [
                    [3, 4, 5, 6],
                ],
            ],

            // 連想配列の配列
            'tags'                => [
                '-' => [
                    [
                        'name'  => 'tag1',
                        'value' => 'val1',
                    ],
                    [
                        'name'  => 'tag3',
                        'value' => 'val3',
                    ],
                    [
                        'name'  => 'tag4',
                        'value' => 'val4',
                    ],
                ],
                '+' => [
                    [
                        'name'  => 'tag3',
                        'value' => 'X',
                    ],
                    [
                        'name'  => 'tag9',
                        'value' => 'val9',
                    ],
                ],
            ],

            // 素の配列とスカラーの混在
            'array1scalar2'       => [
                '-' => [
                    [1, 2, 3],
                ],
                '+' => [123],
            ],
            'array2scalar1'       => [
                '-' => [123],
                '+' => [
                    [1, 2, 3],
                ],
            ],
        ], (array_difference)($a1, $a2));
    }
}
