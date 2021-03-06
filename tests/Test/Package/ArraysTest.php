<?php

namespace ryunosuke\Test\Package;

class ArraysTest extends AbstractTestCase
{
    function test_arrays()
    {
        that(iterator_to_array((arrays)(['a' => 'A', 'b' => 'B', 'c' => 'C'])))->is([['a', 'A'], ['b', 'B'], ['c', 'C']]);
    }

    function test_arrayize()
    {
        that((arrayize)(1, 2, 3))->isSame([1, 2, 3]);
        that((arrayize)([1], 2, 3))->isSame([1, 2, 3]);
        that((arrayize)(['a' => 1], 2, 3))->isSame(['a' => 1, 2, 3]);
        that((arrayize)([1 => 1], [2 => 2], [3 => 3]))->isSame([1 => 1, 2 => 2, 3 => 3]);
        that((arrayize)([1 => 1], ['b' => 2], [3 => 3]))->isSame([1 => 1, 'b' => 2, 3 => 3]);
    }

    function test_is_indexarray()
    {
        that((is_indexarray)([]))->isTrue();
        that((is_indexarray)([1]))->isTrue();
        that((is_indexarray)([0 => 1]))->isTrue();
        that((is_indexarray)([1 => 1]))->isTrue();
        that((is_indexarray)(['1' => 1]))->isTrue();
        that((is_indexarray)(['key' => 1]))->isFalse();
    }

    function test_is_hasharray()
    {
        that((is_hasharray)([]))->isFalse();
        that((is_hasharray)([1]))->isFalse();
        that((is_hasharray)([0 => 1]))->isFalse();
        that((is_hasharray)([1 => 1]))->isTrue();
    }

    function test_first_key()
    {
        that((first_key)(['a', 'b', 'c']))->is(0);
        that((first_key)(['a', 'b', 'c'], 'def'))->is(0);
        that((first_key)([], 'def'))->is('def');
        that((first_key)([]))->is(null);
    }

    function test_first_value()
    {
        that((first_value)(['a', 'b', 'c']))->is('a');
        that((first_value)(['a', 'b', 'c'], 'def'))->is('a');
        that((first_value)([], 'def'))->is('def');
        that((first_value)([]))->is(null);
    }

    function test_first_keyvalue()
    {
        that((first_keyvalue)(['a', 'b', 'c']))->is([0, 'a']);
        that((first_keyvalue)(['a', 'b', 'c'], 'def'))->is([0, 'a']);
        that((first_keyvalue)([], 'def'))->is('def');
        that((first_keyvalue)([]))->is(null);

        that((first_keyvalue)(new \ArrayObject([1, 2, 3])))->is([0, 1]);
        that((first_keyvalue)(new \ArrayObject([])))->is(null);
    }

    function test_last_key()
    {
        that((last_key)(['a', 'b', 'c']))->is(2);
        that((last_key)(['a', 'b', 'c'], 'def'))->is(2);
        that((last_key)([], 'def'))->is('def');
        that((last_key)([]))->is(null);
    }

    function test_last_value()
    {
        that((last_value)(['a', 'b', 'c']))->is('c');
        that((last_value)(['a', 'b', 'c'], 'def'))->is('c');
        that((last_value)([], 'def'))->is('def');
        that((last_value)([]))->is(null);
    }

    function test_last_keyvalue()
    {
        that((last_keyvalue)(['a', 'b', 'c']))->is([2, 'c']);
        that((last_keyvalue)(['a', 'b', 'c'], 'def'))->is([2, 'c']);
        that((last_keyvalue)([], 'def'))->is('def');
        that((last_keyvalue)([]))->is(null);

        that((last_keyvalue)(new \ArrayObject([1, 2, 3])))->is([2, 3]);
        that((last_keyvalue)(new \ArrayObject([])))->is(null);
        that((last_keyvalue)(new \stdClass()))->is(null);
    }

    function test_prev_key()
    {
        // 数値キーのみ
        $array = ['a', 'b', 'c'];
        that((prev_key)($array, 1))->isSame(0);
        that((prev_key)($array, 0))->isSame(null);
        that((prev_key)($array, 'xxx'))->isSame(false);
        // 文字キーのみ
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that((prev_key)($array, 'b'))->isSame('a');
        that((prev_key)($array, 'a'))->isSame(null);
        that((prev_key)($array, 'xxx'))->isSame(false);
        // 混在キー
        $array = ['a', 'b' => 'B', 'c'];
        that((prev_key)($array, 'b'))->isSame(0);
        that((prev_key)($array, 0))->isSame(null);
        that((prev_key)($array, 'xxx'))->isSame(false);
        // 負数キー
        $array = [-4 => 'a', -3 => 'b', -2 => 'c'];
        that((prev_key)($array, -3))->isSame(-4);
        that((prev_key)($array, -4))->isSame(null);
        that((prev_key)($array, 'xxx'))->isSame(false);
        // めっちゃバラバラキー
        $array = [-4 => 1, 3 => 2, 1 => 3, 2 => 4, -3 => 5, 'x' => 6];
        that((prev_key)($array, 2))->isSame(1);
        that((prev_key)($array, -4))->isSame(null);
        that((prev_key)($array, 'xxx'))->isSame(false);
    }

    function test_next_key()
    {
        // 数値キーのみ
        $array = ['a', 'b', 'c'];
        that((next_key)($array))->isSame(3);
        that((next_key)($array, 1))->isSame(2);
        that((next_key)($array, 2))->isSame(null);
        that((next_key)($array, 'xxx'))->isSame(false);
        // 文字キーのみ
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that((next_key)($array))->isSame(0);
        that((next_key)($array, 'a'))->isSame('b');
        that((next_key)($array, 'c'))->isSame(null);
        that((next_key)($array, 'xxx'))->isSame(false);
        // 混在キー
        $array = ['a', 'b' => 'B', 'c'];
        that((next_key)($array))->isSame(2);
        that((next_key)($array, 'b'))->isSame(1);
        that((next_key)($array, 1))->isSame(null);
        that((next_key)($array, 'xxx'))->isSame(false);
        // 負数キー
        $array = [-4 => 'a', -3 => 'b', -2 => 'c'];
        that((next_key)($array))->isSame(0);
        that((next_key)($array, -3))->isSame(-2);
        that((next_key)($array, -2))->isSame(null);
        that((next_key)($array, 'xxx'))->isSame(false);
        // めっちゃバラバラキー
        $array = [-4 => 1, 3 => 2, 1 => 3, 2 => 4, -3 => 5, 'x' => 6];
        that((next_key)($array))->isSame(4);
        that((next_key)($array, 2))->isSame(-3);
        that((next_key)($array, 'x'))->isSame(null);
        that((next_key)($array, 'xxx'))->isSame(false);
    }

    function test_in_array_and()
    {
        that((in_array_and)([], []))->isFalse();
        that((in_array_and)(['a'], []))->isFalse();

        that((in_array_and)(['a'], ['a', 'b', 'c']))->isTrue();
        that((in_array_and)(['a', 'b'], ['a', 'b', 'c']))->isTrue();
        that((in_array_and)(['a', 'b', 'c'], ['a', 'b', 'c']))->isTrue();
        that((in_array_and)(['a', 'b', 'c', 'z'], ['a', 'b', 'c']))->isFalse();
        that((in_array_and)(['z'], ['a', 'b', 'c']))->isFalse();

        that((in_array_and)(['1', 2], [1, 2, 3], false))->isTrue();
        that((in_array_and)(['1', 2], [1, 2, 3], true))->isFalse();
        that((in_array_and)(['1', '2'], [1, 2, 3], true))->isFalse();
    }

    function test_in_array_or()
    {
        that((in_array_or)([], []))->isFalse();
        that((in_array_or)(['a'], []))->isFalse();

        that((in_array_or)(['a'], ['a', 'b', 'c']))->isTrue();
        that((in_array_or)(['a', 'b'], ['a', 'b', 'c']))->isTrue();
        that((in_array_or)(['a', 'b', 'c'], ['a', 'b', 'c']))->isTrue();
        that((in_array_or)(['a', 'b', 'c', 'z'], ['a', 'b', 'c']))->isTrue();
        that((in_array_or)(['z'], ['a', 'b', 'c']))->isFalse();

        that((in_array_or)(['1', 2], [1, 2, 3], false))->isTrue();
        that((in_array_or)(['1', 2], [1, 2, 3], true))->isTrue();
        that((in_array_or)(['1', '2'], [1, 2, 3], true))->isFalse();
    }

    function test_kvsort()
    {
        $array = array_fill_keys(range('a', 'z'), 9);

        // asort は安定ソートではない
        $native = $array;
        asort($native);
        that((kvsort)($array))->isNotSame($native);

        // kvsort は安定ソートである
        that((kvsort)($array))->isSame($array);

        // キーでソートできる
        that(array_keys((kvsort)($array, function ($av, $bv, $ak, $bk) { return strcmp($bk, $ak); })))->isSame(array_reverse(array_keys($array)));

        // 負数定数でリバースソートになる
        that((kvsort)([1, 2, 3, 4, 5], -SORT_NUMERIC))->isSame(array_reverse([1, 2, 3, 4, 5], true));
        that((kvsort)([0.1, 0.2, 0.3], -SORT_NUMERIC))->isSame(array_reverse([0.1, 0.2, 0.3], true));
        that((kvsort)(['a', 'b', 'c'], -SORT_STRING))->isSame(array_reverse(['a', 'b', 'c'], true));

        // 配列じゃなくても Traversable ならソート可能
        that((kvsort)((function () {
            yield 2;
            yield 1;
            yield 3;
        })()))->isSame([1 => 1, 0 => 2, 2 => 3]);

        // 上記は挙動のテストであってソートのテストを行っていないのでテスト
        $array = array_combine(range('a', 'z'), range('a', 'z'));
        that((kvsort)((array_shuffle)($array), function ($a, $b) { return strcmp($a, $b); }))->isSame($array);
    }

    function test_array_add()
    {
        that((array_add)(['a', 'b', 'c'], ['d']))->is(['a', 'b', 'c']);
        that((array_add)(['a', 'b', 'c'], [3 => 'd']))->is(['a', 'b', 'c', 'd']);
        that((array_add)(['a', 'b', 'c'], [3 => 'd'], [4 => 'e']))->is(['a', 'b', 'c', 'd', 'e']);
    }

    function test_array_merge2()
    {
        that((array_merge2)())->is([]);
        that((array_merge2)(['a' => 'A', 2 => 2, 1 => 1, 0 => 0]))->is([0, 1, 2, 'a' => 'A']);
        that((array_merge2)(...[
            [
                -1  => -1,
                1   => 1,
                4   => 4,
                8   => 8,
                'a' => 'A'
            ],
            [
                0   => 0,
                'b' => 'B',
                3   => 3
            ],
            [
                -2  => -2,
                5   => 5,
                'a' => 'X',
                2   => 2
            ],
        ]))->isSame([
            0   => 0,
            1   => 1,
            2   => 2,
            3   => 3,
            4   => 4,
            5   => 5,
            8   => 8,
            -2  => -2,
            'a' => 'X',
            'b' => 'B',
            -1  => -1,
        ]);
    }

    function test_array_mix()
    {
        that((array_mix)())->is([]);
        that((array_mix)([], []))->is([]);
        that((array_mix)([], [], [null]))->is([null]);
        that((array_mix)([1, 3, 5], [2, 4, 6]))->is([1, 2, 3, 4, 5, 6]);
        that((array_mix)([1, 3, 5], [2, 4, 6, 7]))->is([1, 2, 3, 4, 5, 6, 7]);
        that((array_mix)([1, 3, 5, 7], [2, 4, 6]))->is([1, 2, 3, 4, 5, 6, 7]);
        that((array_mix)([1], [2, 4], [3, 5, 6]))->is([1, 2, 3, 4, 5, 6]);
        that((array_mix)(['a' => 'A', 'c' => 'C'], ['b' => 'b']))->is(['a' => 'A', 'b' => 'b', 'c' => 'C']);
        that((array_mix)(['a' => 'A'], ['b' => 'b', 'c' => 'C']))->is(['a' => 'A', 'b' => 'b', 'c' => 'C']);
        that((array_mix)(['a' => 'A', 'X', 'Z'], ['a' => '!', 'Y']))->is(['a' => '!', 'X', 'Y', 'Z']);
    }

    function test_array_zip()
    {
        that((array_zip)([1, 2, 3]))->is([[1], [2], [3]]);
        that((array_zip)([[1], [2], [3]]))->is([[[1]], [[2]], [[3]]]);
        that((array_zip)([1, 2, 3], ['hoge', 'fuga', 'piyo']))->is([[1, 'hoge'], [2, 'fuga'], [3, 'piyo']]);
        that((array_zip)(
            ['a' => 1, 2, 3],
            ['hoge', 'b' => 'fuga', 'piyo'],
            ['foo', 'bar', 'c' => 'baz', 'n' => 'null']
        ))->is([
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
            ]
        );

        that([array_zip])->throws('$arrays is empty');
    }

    function test_array_cross()
    {
        that((array_cross)())->isSame([]);
        that((array_cross)([]))->isSame([]);
        that((array_cross)([], []))->isSame([]);

        that((array_cross)([1, 2]))->isSame([[1], [2]]);
        that((array_cross)([1, 2], [3, 4]))->isSame([[1, 3], [1, 4], [2, 3], [2, 4]]);
        that((array_cross)([1, 2], [3, 4], [5, 6]))->isSame([[1, 3, 5], [1, 3, 6], [1, 4, 5], [1, 4, 6], [2, 3, 5], [2, 3, 6], [2, 4, 5], [2, 4, 6]]);

        that((array_cross)(['a' => 'A', 'b' => 'B']))->isSame([['a' => 'A'], ['b' => 'B']]);
        that((array_cross)(['a' => 'A', 'b' => 'B'], ['c' => 'C', 'd' => 'D']))->isSame([['a' => 'A', 'c' => 'C'], ['a' => 'A', 'd' => 'D'], ['b' => 'B', 'c' => 'C'], ['b' => 'B', 'd' => 'D']]);

        that((array_cross)(['A', 'b' => 'B'], ['c' => 'C', 'D']))->isSame([['A', 'c' => 'C'], ['A', 'D'], ['b' => 'B', 'c' => 'C'], ['b' => 'B', 'D']]);

        that([array_cross, ['a' => 'A', 'B'], ['C', 'a' => 'D']])->throws('duplicated key');
    }

    function test_array_implode()
    {
        that((array_implode)(['a', 'b', 'c'], ','))->is(['a', ',', 'b', ',', 'c']);
        that((array_implode)(',', 'a', 'b', 'c'))->is(['a', ',', 'b', ',', 'c']);
        that((array_implode)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ','))->is(['a' => 'A', ',', 'b' => 'B', ',', 'c' => 'C']);
        that((array_implode)([1 => 'a', 0 => 'b', 2 => 'c'], ','))->is(['a', ',', 'b', ',', 'c']);
    }

    function test_array_explode()
    {
        that((array_explode)([], '|'))->is([[]]);
        that((array_explode)(['a', '|', 'b', 'c'], '|'))->is([['a'], [2 => 'b', 3 => 'c']]);
        that((array_explode)(['|', 'a', '|', '|'], '|'))->is([[], [1 => 'a'], [], []]);

        that((array_explode)([null, null, null, null], null, 3))->is([[], [], [2 => null, 3 => null]]);

        that((array_explode)(['a', '|', 'b', '|', 'c'], '|', 0))->is([['a', '|', 'b', '|', 'c']]);
        that((array_explode)(['a', '|', 'b', '|', 'c'], '|', 1))->is([['a', '|', 'b', '|', 'c']]);
        that((array_explode)(['a', '|', 'b', '|', 'c'], '|', 2))->is([['a'], [2 => 'b', 3 => '|', 4 => 'c']]);
        that((array_explode)(['a', '|', 'b', '|', 'c'], '|', 3))->is([['a'], [2 => 'b'], [4 => 'c']]);
        that((array_explode)(['a', '|', 'b', '|', 'c'], '|', 4))->is([['a'], [2 => 'b'], [4 => 'c']]);

        that((array_explode)(['a', null, 'b', null, 'c'], null, 1))->is([
            [
                0 => 'a',
                1 => null,
                2 => 'b',
                3 => null,
                4 => 'c',
            ],
        ]);
        that((array_explode)(['a', null, 'b', null, 'c'], null, 2))->is([
            [0 => 'a'],
            [
                2 => 'b',
                3 => null,
                4 => 'c',
            ],
        ]);
        that((array_explode)(['a', null, 'b', null, 'c'], null, 3))->is([
            [0 => 'a'],
            [2 => 'b'],
            [
                4 => 'c',
            ],
        ]);
        that((array_explode)(['a', null, 'b', null, 'c'], null, 4))->is([
            [0 => 'a'],
            [2 => 'b'],
            [
                4 => 'c',
            ],
        ]);

        that((array_explode)(['a', null, 'b', null, 'c'], null, -1))->is([
            [
                0 => 'a',
                1 => null,
                2 => 'b',
                3 => null,
                4 => 'c',
            ],
        ]);
        that((array_explode)(['a', null, 'b', null, 'c'], null, -2))->is([
            [
                0 => 'a',
                1 => null,
                2 => 'b',
            ],
            [
                4 => 'c',
            ],
        ]);
        that((array_explode)(['a', null, 'b', null, 'c'], null, -3))->is([
            [0 => 'a'],
            [2 => 'b'],
            [
                4 => 'c',
            ],
        ]);
        that((array_explode)(['a', null, 'b', null, 'c'], null, -4))->is([
            [0 => 'a'],
            [2 => 'b'],
            [
                4 => 'c',
            ],
        ]);

        $rows = [
            1 => $r1 = ['id' => 1, 'name' => 'A'],
            2 => $r2 = ['id' => 2, 'name' => 'B'],
            3 => $r3 = ['id' => 3, 'name' => 'C'],
            4 => $r4 = ['id' => 4, 'name' => 'D'],
        ];
        that((array_explode)($rows, function ($v, $k) {
            return $k === 3 && $v['name'] === 'C';
        }))->is([[1 => $r1, 2 => $r2], [4 => $r4]]);
    }

    function test_array_sprintf()
    {
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        that((array_sprintf)($array, '%s:%s'))->is(['A:a', 'B:b', 'C:c']);
        that((array_sprintf)($array, '%s:%s', ','))->is('A:a,B:b,C:c');

        that((array_sprintf)($array, function ($v) { return "v-$v"; }))->is(['v-A', 'v-B', 'v-C']);
        that((array_sprintf)($array, function ($v) { return "v-$v"; }, ','))->is('v-A,v-B,v-C');

        that((array_sprintf)($array, function ($v, $k) { return "kv-$k$v"; }))->is(['kv-aA', 'kv-bB', 'kv-cC']);
        that((array_sprintf)($array, function ($v, $k) { return "kv-$k$v"; }, ','))->is('kv-aA,kv-bB,kv-cC');

        that((array_sprintf)([
            'str:%s,int:%d' => ['sss', '3.14'],
            'single:%s'     => 'str',
        ], null, '|'))->is('str:sss,int:3|single:str');
    }

    function test_array_strpad()
    {
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        // prefix key
        that((array_strpad)($array, 'K'))->is(['Ka' => 'A', 'Kb' => 'B', 'Kc' => 'C']);
        // prefix val
        that((array_strpad)($array, '', 'V'))->is(['a' => 'VA', 'b' => 'VB', 'c' => 'VC']);
        // prefix key-val
        that((array_strpad)($array, 'K', 'V'))->is(['Ka' => 'VA', 'Kb' => 'VB', 'Kc' => 'VC']);

        // suffix key
        that((array_strpad)($array, ['K']))->is(['aK' => 'A', 'bK' => 'B', 'cK' => 'C']);
        // suffix val
        that((array_strpad)($array, '', ['V']))->is(['a' => 'AV', 'b' => 'BV', 'c' => 'CV']);
        // suffix key-val
        that((array_strpad)($array, ['K'], ['V']))->is(['aK' => 'AV', 'bK' => 'BV', 'cK' => 'CV']);

        // prefix suffix key
        that((array_strpad)($array, ['K', 'K']))->is(['KaK' => 'A', 'KbK' => 'B', 'KcK' => 'C']);
        // prefix suffix val
        that((array_strpad)($array, '', ['V', 'V']))->is(['a' => 'VAV', 'b' => 'VBV', 'c' => 'VCV']);
        // prefix suffix key-val
        that((array_strpad)($array, ['K', 'K'], ['V', 'V']))->is(['KaK' => 'VAV', 'KbK' => 'VBV', 'KcK' => 'VCV']);
        // prefix key, suffix val
        that((array_strpad)($array, 'K', ['V']))->is(['Ka' => 'AV', 'Kb' => 'BV', 'Kc' => 'CV']);

        // value not string
        that((array_strpad)(['x' => [1, 2, 3]], 'K'))->is(['Kx' => [1, 2, 3]]);
    }

    function test_array_pos()
    {
        // 1 番目の要素を返す
        that((array_pos)(['x', 'y', 'z'], 1, false))->is('y');
        // 負数は後ろから返す
        that((array_pos)(['x', 'y', 'z'], -1, false))->is('z');

        // 上記の is_key:true 版（キーを返す）
        that((array_pos)(['x', 'y', 'z'], 1, true))->is(1);
        that((array_pos)(['x', 'y', 'z'], -1, true))->is(2);

        // 範囲外は例外が飛ぶ
        that([array_pos, ['x', 'y', 'z'], 9, true])->throws('OutOfBoundsException');
    }

    function test_array_pos_key()
    {
        that((array_pos_key)(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'c'))->is(2);
        that((array_pos_key)(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x', -1))->is(-1);
        that([array_pos_key, ['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x'])->throws('OutOfBoundsException');
    }

    function test_array_of()
    {
        $hoge_of = (array_of)('hoge');
        that($hoge_of(['hoge' => 'HOGE']))->is('HOGE');
        that($hoge_of(['fuga' => 'FUGA']))->is(null);

        $hoge_of = (array_of)('hoge', 'HOGE');
        that($hoge_of(['fuga' => 'FUGA']))->is('HOGE');

        that((array_of)([0, 2])(['a', 'b', 'c']))->is([0 => 'a', 2 => 'c']);
        that((array_of)([0, 9])(['a', 'b', 'c']))->is([0 => 'a']);
        that((array_of)([9])(['a', 'b', 'c']))->is([]);
        that((array_of)([9], null)(['a', 'b', 'c']))->is(null);
    }

    function test_array_get()
    {
        that((array_get)(['a', 'b', 'c'], 1))->is('b');
        that((array_get)(['a', 'b', 'c'], 9, 999))->is(999);

        that((array_get)(['a', 'b', 'c'], [0, 2]))->is([0 => 'a', 2 => 'c']);
        that((array_get)(['a', 'b', 'c'], [0, 9]))->is([0 => 'a']);
        that((array_get)(['a', 'b', 'c'], [9]))->is([]);
        that((array_get)(['a', 'b', 'c'], [9], null))->is(null);

        // 配列を与えたときの順番は指定したものを優先
        that((array_get)(['a', 'b', 'c'], [2, 1, 0]))->is([2 => 'c', 1 => 'b', 0 => 'a']);

        // Arrayable でも動作する
        $ao = new \Arrayable(['a', 'b', 'c']);
        that((array_get)($ao, 1))->is('b');
        that((array_get)($ao, [2, 1, 0]))->is([2 => 'c', 1 => 'b', 0 => 'a']);

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
        that((array_get)($array, function ($v, $k) { return !is_int($k); }, []))->is([
            'key1' => 'value1',
            'key2' => 'value2',
        ]);

        // キーが数値のものを抽出
        that((array_get)($array, function ($v, $k) { return is_int($k); }, []))->is([
            0   => 'first',
            1   => 'second',
            2   => 'third',
            99  => 99,
            100 => 100,
            101 => 101,
        ]);

        // 単値モード
        that((array_get)($array, function ($v, $k) { return is_int($k); }))->is('first');

        // 値がオブジェクトのものを抽出（そんなものはない）
        that((array_get)($array, function ($v, $k) { return is_object($v); }))->is(null);
    }

    function test_array_set()
    {
        // single
        $array = ['a' => 'A', 'B'];
        that((array_set)($array, 'Z'))->is(1);
        that($array)->is(['a' => 'A', 'B', 'Z']);
        that((array_set)($array, 'Z', 'z'))->is('z');
        that($array)->is(['a' => 'A', 'B', 'Z', 'z' => 'Z']);
        that((array_set)($array, 'X', 'a'))->is('a');
        that($array)->is(['a' => 'X', 'B', 'Z', 'z' => 'Z']);
        that((array_set)($array, 'Z', null, false))->is(null);
        that($array)->is(['a' => 'X', 'B', 'Z', 'z' => 'Z', 'Z']);

        // array
        $array = ['a' => 'A', 'b' => ['B']];
        that((array_set)($array, 'X', ['x']))->is('x');
        that($array)->is(['a' => 'A', 'b' => ['B'], 'x' => 'X']);
        that((array_set)($array, 'X', ['y', 'z']))->is('z');
        that($array)->is(['a' => 'A', 'b' => ['B'], 'x' => 'X', 'y' => ['z' => 'X']]);
        that((array_set)($array, 'W', ['b']))->is('b');
        that($array)->is(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X']]);
        that((array_set)($array, 'Y2', ['y', null]))->is(0);
        that($array)->is(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X', 'Y2']]);
        that(function () {
            $array = ['a' => ['b' => 's']];
            (array_set)($array, 'X', ['a', 'b', 'c']);
        })->throws('is not array');
    }

    function test_array_put()
    {
        // single
        $array = ['a' => 'A', 'B'];
        that((array_put)($array, 'Z'))->is(1);
        that($array)->is(['a' => 'A', 'B', 'Z']);
        that((array_put)($array, 'Z', 123))->is(2);
        that($array)->is(['a' => 'A', 'B', 'Z', 'Z']);
        that((array_put)($array, 'Z', 'z'))->is('z');
        that($array)->is(['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z']);
        that((array_put)($array, 'X', 'a'))->is('a');
        that($array)->is(['a' => 'X', 'B', 'Z', 'Z', 'z' => 'Z']);

        // condition
        $array = ['a' => 'A', 'B'];
        that((array_put)($array, 'Z', null, function ($v, $k, $array) {
            return !in_array($v, $array);
        }))->is(1);
        that($array)->is(['a' => 'A', 'B', 'Z']);
        that((array_put)($array, 'Z', null, function ($v, $k, $array) {
            return !in_array($v, $array);
        }))->is(false);
        that($array)->is(['a' => 'A', 'B', 'Z']);

        // array
        $array = ['a' => 'A', 'b' => ['B']];
        that((array_put)($array, 'X', ['x']))->is('x');
        that($array)->is(['a' => 'A', 'b' => ['B'], 'x' => 'X']);
        that((array_put)($array, 'X', ['y', 'z']))->is('z');
        that($array)->is(['a' => 'A', 'b' => ['B'], 'x' => 'X', 'y' => ['z' => 'X']]);
        that((array_put)($array, 'W', ['b']))->is('b');
        that($array)->is(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X']]);
        that((array_put)($array, 'Y2', ['y', null]))->is(0);
        that($array)->is(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X', 'Y2']]);
        that(function () {
            $array = ['a' => ['b' => 's']];
            (array_put)($array, 'X', ['a', 'b', 'c']);
        })->throws('is not array');
    }

    function test_array_unset()
    {
        // single
        $array = ['a' => 'A', 'b' => 'B'];
        that((array_unset)($array, 'a'))->is('A');
        that($array)->is(['b' => 'B']);
        that((array_unset)($array, 'x', 'X'))->is('X');
        that($array)->is(['b' => 'B']);

        // array
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that((array_unset)($array, ['x'], 'X'))->is('X');
        that((array_unset)($array, ['x'], ['X']))->is(['X']);
        that((array_unset)($array, ['a', 'b', 'x']))->is(['A', 'B']);
        that($array)->is(['c' => 'C']);

        // array with key
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that((array_unset)($array, ['b', 'a']))->isSame(['B', 'A']);
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that((array_unset)($array, [1 => 'a', 0 => 'b']))->isSame([1 => 'A', 0 => 'B']);
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that((array_unset)($array, ['XXX']))->isSame([]);

        // Arrayable でも動作する
        $ao = new \Arrayable(['a', 'b', 'c']);
        that((array_unset)($ao, 1))->is('b');
        that((array_unset)($ao, [2, 1, 0]))->is([0 => 'c', 2 => 'a']);

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
        that((array_unset)($array, function ($v, $k) { return !is_int($k); }))->is([
            'key1' => 'value1',
            'key2' => 'value2',
        ]);
        that($array)->is([
            'first',
            'second',
            'third',
            99  => 99,
            100 => 100,
            101 => 101,
        ]);

        // さらに値が100以上のものを抽出
        that((array_unset)($array, function ($v, $k) { return $v >= 100; }))->is([
            100 => 100,
            101 => 101,
        ]);
        that($array)->is([
            'first',
            'second',
            'third',
            99 => 99,
        ]);

        // さらに値が "second" のものを抽出
        that((array_unset)($array, function ($v, $k) { return $v === 'second'; }))->is([
            1 => 'second',
        ]);
        that($array)->is([
            'first',
            2  => 'third',
            99 => 99,
        ]);

        // さらに値がオブジェクトのものを抽出（そんなものはない）
        that((array_unset)($array, function ($v, $k) { return is_object($v); }))->is(null);
        that($array)->is([
            'first',
            2  => 'third',
            99 => 99,
        ]);

        // さらにキー数値のものを抽出（全て）
        that((array_unset)($array, function ($v, $k) { return is_int($k); }))->is([
            'first',
            2  => 'third',
            99 => 99,
        ]);
        that($array)->is([]);
    }

    function test_array_dive()
    {
        $array = ['a' => ['b' => ['c' => 'vvv']]];
        that((array_dive)($array, 'a.b.c'))->is('vvv');
        that((array_dive)($array, 'a.b.x', 9))->is(9);
        that((array_dive)($array, ['a', 'b', 'c']))->is('vvv');
        that((array_dive)($array, 'a.b.c.x'))->isNull();

        // Arrayable でも動作する
        $ao = new \Arrayable(['a' => ['b' => ['c' => 'vvv']]]);
        that((array_dive)($ao, 'a.b.c'))->is('vvv');
        that((array_dive)($ao, 'a.b.x', 9))->is(9);
        that((array_dive)($ao, ['a', 'b', 'c']))->is('vvv');
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
        that((array_keys_exist)(['a', 'b', 'c'], $array))->isTrue();
        // 単一文字指定で含む
        that((array_keys_exist)('a', $array))->isTrue();
        // 1つ含まない
        that((array_keys_exist)(['a', 'b', 'n'], $array))->isFalse();
        // 単一文字指定で含まない
        that((array_keys_exist)('X', $array))->isFalse();
        // 空は例外
        that([array_keys_exist, [], $array])->throws('empty');

        // ネスト調査
        that((array_keys_exist)([
            'x' => ['x1', 'x2', 'y'],
        ], $array))->isTrue();
        that((array_keys_exist)([
            'x' => [
                'x1',
                'x2',
                'y' => [
                    'y1',
                    'y2',
                ],
            ]
        ], $array))->isTrue();
        that((array_keys_exist)([
            'nx' => ['x1', 'x2', 'y'],
        ], $array))->isFalse();
        that((array_keys_exist)([
            'x' => [
                'x1',
                'x2',
                'y' => [
                    'y1',
                    'y9',
                ],
            ],
        ], $array))->isFalse();

        // \ArrayAccess
        $array = new \Arrayable([]);
        $array['x'] = ['y' => 'z'];
        $array['null'] = null;
        that((array_keys_exist)('null', $array))->isTrue();
        that((array_keys_exist)(['x' => ['y']], $array))->isTrue();
        that((array_keys_exist)(['x' => ['y']], $array))->isTrue();
        that((array_keys_exist)(['nx'], $array))->isFalse();
        that((array_keys_exist)(['nx' => ['y']], $array))->isFalse();
    }

    function test_array_find()
    {
        that((array_find)(['a', 'b', '9'], 'ctype_digit'))->is(2);
        that((array_find)(['a' => 'A', 'b' => 'B'], function ($v) { return $v === 'B'; }))->is('b');
        that((array_find)(['9', 'b', 'c'], 'ctype_digit'))->isSame(0);
        that((array_find)(['a', 'b', 'c'], function ($v) { }))->isSame(false);

        that((array_find)(['a', 'b', '9'], function ($v) {
            return ctype_digit($v) ? false : strtoupper($v);
        }, false))->is('A');
        that((array_find)(['9', 'b', 'c'], function ($v) {
            return ctype_digit($v) ? false : strtoupper($v);
        }, false))->is('B');
        that((array_find)([1, 2, 3, 4, -5, -6], function ($v) {
            return $v < 0 ? abs($v) : false;
        }, false))->is(5);
    }

    function test_array_rekey()
    {
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that((array_rekey)($array, ['a' => 'x', 'c' => 'z']))->is(['x' => 'A', 'b' => 'B', 'z' => 'C']);
        that((array_rekey)($array, ['c' => 'z', 'a' => 'x']))->is(['x' => 'A', 'b' => 'B', 'z' => 'C']);
        that((array_rekey)($array, ['x' => 'X', 'y' => 'Y', 'z' => 'Z']))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);
        that((array_rekey)($array, ['a' => 'c', 'c' => 'a']))->is(['c' => 'A', 'b' => 'B', 'a' => 'C']);
        that((array_rekey)($array, ['c' => 'a', 'a' => 'c']))->is(['c' => 'A', 'b' => 'B', 'a' => 'C']);
        that((array_rekey)($array, ['b' => null]))->is(['a' => 'A', 'c' => 'C']);
        that((array_rekey)($array, ['a' => null, 'b' => null, 'c' => null]))->is([]);
        that((array_rekey)($array, 'strtoupper'))->is(['A' => 'A', 'B' => 'B', 'C' => 'C']);
        that((array_rekey)($array, function ($k, $v, $n, $array) {
            if ($k === 'a') {
                return 'A' . $n;
            }
            if ($k === 'b') {
                return $v . $n;
            }
            if ($k === 'c') {
                return $array['c'] . $n;
            }
        }))->is(['A0' => 'A', 'B1' => 'B', 'C2' => 'C']);
    }

    function test_array_grep_key()
    {
        that((array_grep_key)(['a', 'b', 'c'], '#\d#'))->is(['a', 'b', 'c']);
        that((array_grep_key)(['hoge' => 'HOGE', 'fuga' => 'FUGA'], '#^h#'))->is(['hoge' => 'HOGE']);
        that((array_grep_key)(['hoge' => 'HOGE', 'fuga' => 'FUGA'], '#^h#', true))->is(['fuga' => 'FUGA']);
    }

    function test_array_map_recursive()
    {
        that((array_map_recursive)([
            'k' => 'v',
            'c' => new \ArrayObject([
                'k1' => 'v1',
                'k2' => 'v2',
            ]),
        ], 'strtoupper'))->isSame([
            'k' => 'V',
            'c' => [
                'k1' => 'V1',
                'k2' => 'V2',
            ],
        ]);

        that((array_map_recursive)([
            'k' => 'v',
            'c' => new \ArrayObject([
                'k1' => 'v1',
                'k2' => 'v2',
            ]),
        ], 'gettype', false))->isSame([
            'k' => 'string',
            'c' => 'object',
        ]);
    }

    function test_array_map_key()
    {
        that((array_map_key)([' a ' => 'A', ' b ' => 'B'], 'trim'))->is(['a' => 'A', 'b' => 'B']);
        that((array_map_key)(['a' => 'A', 'b' => 'B'], 'strtoupper'))->is(['A' => 'A', 'B' => 'B']);
        that((array_map_key)(['a' => 'A', 'b' => 'B'], function ($k) {
            return $k === 'b' ? null : strtoupper($k);
        }))->is(['A' => 'A']);
        that((array_map_key)(['a' => 'A', 'b' => 'B'], function ($k, $v) {
            return $v === 'B' ? null : strtoupper($k);
        }))->is(['A' => 'A']);
    }

    function test_array_filter_key()
    {
        that((array_filter_key)(['a' => 'A', 'b' => 'B', 'X'], 'ctype_alpha'))->is(['a' => 'A', 'b' => 'B']);
        that((array_filter_key)(['a', 'b', 'c'], function ($k, $v) { return $k === 1; }))->is([1 => 'b']);
        that((array_filter_key)(['a', 'b', 'c'], function ($k, $v) { return $v === "b"; }))->is([1 => 'b']);
        that((array_filter_key)(['a', 'b', 'c'], function ($k, $v) { return $v !== "b"; }))->is(['a', 2 => 'c']);
    }

    function test_array_where()
    {
        $array = [
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ];

        // 省略すればそのまま
        that((array_where)($array))->is($array);

        // シンプルクロージャフィルタ（key === 0 || p を含む）
        that((array_where)($array, function ($row, $key) {
            return $key === 0 || strpos($row['name'], 'p') !== false;
        }))->is([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);

        // flag 値で true フィルタ
        that((array_where)($array, 'flag'))->is([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
        ]);

        // name 値でクロージャフィルタ（'o' を含む）
        that((array_where)($array, 'name', function ($name) {
            return strpos($name, 'o') !== false;
        }))->is([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);

        // id, name 値でクロージャフィルタ（id === 3 && 'o' を含む）
        that((array_where)($array, ['id', 'name'], function ($id_name) {
            return $id_name['id'] === 3 && strpos($id_name['name'], 'o') !== false;
        }))->is([
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);

        // キーでクロージャフィルタ（key === 2）
        that((array_where)($array, null, function ($name, $key) {
            return $key === 2;
        }))->is([
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);

        // 連想配列
        that((array_where)($array, ['flag' => 1], false))->is([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
        ]);
        that((array_where)($array, ['id' => [2, 3]], false))->is([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);
        that((array_where)($array, ['flag' => true], true))->is([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
        ]);
        that((array_where)($array, ['name' => 'hoge', 'flag' => false]))->is([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
        ]);
        that((array_where)($array, ['flag' => 1], true))->is([]);
        that((array_where)($array, ['name' => function ($name) { return $name === 'hoge'; }, 'flag' => function ($flag) { return !$flag; }]))->is([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
        ]);

        // 例外
        that([array_where, $array, ['flag' => 1], function () { }])->throws('must be bool');
    }

    function test_array_kvmap()
    {
        that((array_kvmap)(['a' => 'A', 'b' => 'B', 'c' => 'C'], function ($k, $v) {
            if ($k === 'a') {
                return null;
            }
            if ($k === 'b') {
                return [];
            }
            if ($k === 'c') {
                return ["{$k}1" => "{$v}1", "{$k}2" => "{$v}2"];
            }
        }))->is([
            'a'  => 'A',
            'c1' => 'C1',
            'c2' => 'C2',
        ]);

        that((array_kvmap)(['a', 'b', 'c'], function ($k, $v) {
            if ($v === 'a') {
                return [];
            }
            if ($v === 'b') {
                return ['B'];
            }
            if ($v === 'c') {
                return 'C';
            }
        }))->is(['B', 'C']);

        that((array_kvmap)([
            'x' => [
                'X',
                'y' => [
                    'Y',
                    'z' => ['Z'],
                ],
            ],
        ], function ($k, $v, $callback) {
            return ["_$k" => is_array($v) ? (array_kvmap)($v, $callback) : "prefix-$v"];
        }))->is([
                "_x" => [
                    "_0" => "prefix-X",
                    "_y" => [
                        "_0" => "prefix-Y",
                        "_z" => [
                            "_0" => "prefix-Z",
                        ],
                    ],
                ],
            ]
        );
    }

    function test_array_map_filter()
    {
        // strict:false なので 0 が除外される
        that((array_map_filter)([1, 2, 3, 4, 5], function ($v) {
            return $v - 3;
        }, false))->is([-2, -1, '3' => 1, 2]);

        // strict:true なので全て返ってくる
        that((array_map_filter)([1, 2, 3, 4, 5], function ($v) {
            return $v - 3;
        }, true))->is([-2, -1, 0, 1, 2]);

        // strict:true は null がフィルタされる
        that((array_map_filter)([1, 2, 3, 4, 5], function ($v) {
            return $v === 3 ? null : $v - 3;
        }, true))->is([-2, -1, '3' => 1, 2]);
    }

    function test_array_map_method()
    {
        $o1 = new \Concrete('a');
        $o2 = new \Concrete('b');
        $o3 = new \Concrete('c');

        // きちんと呼ばれるし引数も渡る
        that((array_map_method)([$o1, $o2, $o3], 'getName'))->is(['a', 'b', 'c']);
        that((array_map_method)([$o1, $o2, $o3], 'getName', ['_', true]))->is(['_A', '_B', '_C']);

        // $ignore=true すると filter される
        that((array_map_method)([$o1, null, 123], 'getName', [], true))->is(['a']);

        // $ignore=null するとそのまま返す
        that((array_map_method)([$o1, null, 123], 'getName', [], null))->is(['a', null, 123]);

        // iterable
        that((array_map_method)(new \ArrayObject([$o1, null, 123]), 'getName', [], null))->is(['a', null, 123]);
    }

    function test_array_maps()
    {
        that((array_maps)(['a', 'b', 'c'], 'strtoupper', (lbind)(strcat, '_')))->is(['_A00', '_B11', '_C22']);
        that((array_maps)(['a', 'b', 'c'], 'strtoupper', (lbind)(strcat, '_', '-')))->is(['_-A00', '_-B11', '_-C22']);

        that((array_maps)(['a' => 'A', 'b' => 'B'], strcat, strcat))->is(['a' => 'Aa0a0', 'b' => 'Bb1b1']);

        // 可変引数モード
        that((array_maps)([[1, 3], [1, 5, 2]], '...range'))->isSame([[1, 2, 3], [1, 3, 5]]);

        // メソッドモード
        $ex = new \Exception('msg1', 1, new \Exception('msg2', 2, new \Exception('msg3', 3)));
        that((array_maps)([$ex, $ex, $ex], '@getMessage'))->is(['msg1', 'msg1', 'msg1']);
        that((array_maps)([$ex, $ex, $ex], '@getPrevious', '@getCode'))->is([2, 2, 2]);
        that((array_maps)([$ex, $ex, $ex], '@getPrevious', '@getPrevious', '@getCode'))->is([3, 3, 3]);

        $objs = [new \Concrete('a'), new \Concrete('b'), new \Concrete('c')];
        that((array_maps)($objs, ['getName' => ['p-', true]]))->is(['P-A', 'P-B', 'P-C']);

        $objs = new \ArrayObject([new \Concrete('a'), new \Concrete('b'), new \Concrete('c')]);
        that((array_maps)($objs, ['getName' => ['p-', true]]))->is(['P-A', 'P-B', 'P-C']);
    }

    function test_array_kmap()
    {
        $array = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ];
        that((array_kmap)($array, function ($v, $k, $n) { return "$n:$k-$v"; }))->is([
            'k1' => '0:k1-v1',
            'k2' => '1:k2-v2',
            'k3' => '2:k3-v3',
        ]);
    }

    function test_array_nmap()
    {
        // それぞれ N 番目に適用される
        that((array_nmap)([1, 2], strcat, 0, 'a-', '-z'))->is(['1a--z', '2a--z']);
        that((array_nmap)([1, 2], strcat, 1, 'a-', '-z'))->is(['a-1-z', 'a-2-z']);
        that((array_nmap)([1, 2], strcat, 2, 'a-', '-z'))->is(['a--z1', 'a--z2']);

        /// $n に配列を渡すとキー・値の両方が渡ってくる
        // キーを1番目、値を2番目に渡す
        that((array_nmap)(['k' => 'v'], strcat, [1 => 2], ' a ', ' b ', ' c '))->is(['k' => ' a k b v c ']);
        // キーを2番目、値を1番目に渡す
        that((array_nmap)(['k' => 'v'], strcat, [2 => 1], ' a ', ' b ', ' c '))->is(['k' => ' a v b k c ']);
        // キーを1番目、値を1番目に渡す（キーが優先される）
        that((array_nmap)(['k' => 'v'], strcat, [1 => 1], ' a ', ' b ', ' c '))->is(['k' => ' a kv b  c ']);

        that([array_nmap, [], strcat, []])->throws('empty');
        that([array_nmap, [], strcat, [1 => -1]])->throws('positive');
        that([array_nmap, [], strcat, [-1 => 1]])->throws('positive');
    }

    function test_array_lmap()
    {
        // 最左に適用される
        that((array_lmap)([1, 2], strcat, 'a-', '-z'))->is(['1a--z', '2a--z']);
    }

    function test_array_rmap()
    {
        // 最右に適用される
        that((array_rmap)([1, 2], strcat, 'a-', '-z'))->is(['a--z1', 'a--z2']);
    }

    function test_array_each()
    {
        that((array_each)([1, 2, 3, 4, 5], function (&$carry, $v) { $carry .= $v; }, ''))->isSame('12345');
        that((array_each)([1, 2, 3, 4, 5], function (&$carry, $v) { $carry[$v] = $v * $v; }, []))->isSame([
            1 => 1,
            2 => 4,
            3 => 9,
            4 => 16,
            5 => 25,
        ]);
        $receiver = [];
        that((array_each)([1, 2, 3, 4, 5], function (&$carry, $v, $k, $n) use (&$receiver) {
            $receiver[] = $n;
            if ($k === 3) {
                return false;
            }
            $carry[$v] = $v * $v;
        }, []))->isSame([
            1 => 1,
            2 => 4,
            3 => 9,
        ]);
        that($receiver)->is([0, 1, 2, 3]);

        // こういう使い方（オブジェクトの配列からメソッド由来の連想配列を作成）を想定しているのでテスト
        $ex_a = new \Exception('a');
        $ex_b = new \Exception('b');
        $ex_c = new \Exception('c');
        that((array_each)([$ex_a, $ex_b, $ex_c], function (&$carry, \Exception $ex) {
            $carry[$ex->getMessage()] = $ex;
        }))->isSame(['a' => $ex_a, 'b' => $ex_b, 'c' => $ex_c]);

        // 推奨しないが見た目が気に入っている使い方
        that((array_each)([1, 2, 3], function (&$carry = 'start', $v = null) { $carry .= $v; }))->isSame('start123');
        that((array_each)([], function (&$carry = 'start', $v = null) { $carry .= $v; }))->isSame('start');
        that((array_each)([], function (&$carry, $v) { $carry .= $v; }))->isSame(null);
    }

    function test_array_depth()
    {
        // シンプル
        that((array_depth)([]))->is(1);
        that((array_depth)(['X']))->is(1);
        that((array_depth)([['X']]))->is(2);
        that((array_depth)([[['X']]]))->is(3);

        // 最大が得られるか？
        that((array_depth)(['X', 'y' => ['Y']]))->is(2);
        that((array_depth)(['x' => ['X'], 'Y']))->is(2);
        that((array_depth)(['x' => ['X'], 'y' => ['Y'], 'z' => ['z' => ['Z']]]))->is(3);

        // $max_depth 指定
        that((array_depth)([[[[['X']]]]], 1))->is(1);
        that((array_depth)([[[[['X']]]]], 2))->is(2);
        that((array_depth)([[[[['X']]]]], 3))->is(3);
        that((array_depth)([[[[['X']]]]], 4))->is(4);
        that((array_depth)([[[[['X']]]]], 5))->is(5);
        that((array_depth)([[[[['X']]]]], 6))->is(5);
        that((array_depth)([
            ['X'],
            [['X']],
            [[['X']]],
            [[[['X']]]],
            [[[[['X']]]]],
            [[[[[['X']]]]]],
        ], 3))->is(3);
    }

    function test_array_insert()
    {
        // 第3引数を省略すると最後に挿入される
        that((array_insert)([1, 2, 3], 'x'))->is([1, 2, 3, 'x']);

        // 第3引数を指定するとその位置に挿入される
        that((array_insert)([1, 2, 3], 'x', 1))->is([1, 'x', 2, 3]);

        // 配列を指定するとその位置にマージされる
        that((array_insert)([1, 2, 3], ['x1', 'x2'], 1))->is([1, 'x1', 'x2', 2, 3]);

        // 負数を指定すると後ろから数えて挿入される
        that((array_insert)([1, 2, 3], ['x1', 'x2'], -1))->is([1, 2, 'x1', 'x2', 3]);

        // 連想配列もOK
        that((array_insert)(['x' => 'X', 'y' => 'Y', 'z' => 'Z'], ['x1', 'n' => 'x2'], 1))->is(['x' => 'X', 'x1', 'n' => 'x2', 'y' => 'Y', 'z' => 'Z']);
    }

    function test_array_assort()
    {
        // 普通に使う
        that((array_assort)(['a', 'bb', 'ccc'], [
            'none'  => function ($v) { return strlen($v) === 0; },
            'char1' => function ($v) { return strlen($v) === 1; },
            'char2' => function ($v) { return strlen($v) === 2; },
            'char3' => function ($v) { return strlen($v) === 3; },
        ]))->is([
            'none'  => [],
            'char1' => [0 => 'a'],
            'char2' => [1 => 'bb'],
            'char3' => [2 => 'ccc'],
        ]);

        // 複数条件にマッチ
        that((array_assort)(['a', 'bb', 'ccc'], [
            'rule1' => function () { return true; },
            'rule2' => function () { return true; },
        ]))->is([
            'rule1' => ['a', 'bb', 'ccc'],
            'rule2' => ['a', 'bb', 'ccc'],
        ]);
    }

    function test_array_count()
    {
        $array = ['a', 'b', 'c'];

        // 普通に使う分には count(array_filter()) と同じ
        $eq_b = function ($v) { return $v === 'b'; };
        that((array_count)($array, $eq_b))->is(count(array_filter($array, $eq_b)));

        $row1 = ['id' => 1, 'group' => 'A', 'flag' => false];
        $row2 = ['id' => 2, 'group' => 'B', 'flag' => true];
        $row3 = ['id' => 3, 'group' => 'B', 'flag' => false];
        $array = [
            'k1' => $row1,
            'k2' => $row2,
            3    => $row3,
        ];

        // flag をカウント
        that((array_count)($array, (array_of)('flag')))->is(1);
        that((array_count)($array, (not_func)((array_of)('flag'))))->is(2);

        // group: 'B' をカウント。ただし、数値キーの場合のみ
        that((array_count)($array, function ($v, $k) {
            return is_int($k) && $v['group'] === 'B';
        }))->is(1);

        // group: 'A', 'B' をそれぞれカウント
        that((array_count)($array, [
            'A' => function ($v) { return $v['group'] === 'A'; },
            'B' => function ($v) { return $v['group'] === 'B'; },
        ]))->is([
            'A' => 1,
            'B' => 2,
        ]);
    }

    function test_array_group()
    {
        that((array_group)([1, 2, 3, 4, 5]))->is([
            1 => [1],
            2 => [2],
            3 => [3],
            4 => [4],
            5 => [5],
        ]);

        that((array_group)([1, 2, 3, 4, 5], function ($v) { return $v % 2; }))->is([
            0 => [2, 4],
            1 => [1, 3, 5],
        ]);

        $row1 = ['id' => 1, 'group' => 'A', 'flag' => false];
        $row2 = ['id' => 2, 'group' => 'B', 'flag' => true];
        $row3 = ['id' => 3, 'group' => 'A', 'flag' => false];
        $array = [
            'k1' => $row1,
            'k2' => $row2,
            3    => $row3,
        ];

        that((array_group)($array, (array_of)('group')))->is(['A' => ['k1' => $row1, 0 => $row3], 'B' => ['k2' => $row2]]);
        that((array_group)($array, (array_of)('group'), true))->is(['A' => ['k1' => $row1, 3 => $row3], 'B' => ['k2' => $row2]]);

        that((array_group)([$row1, $row2, $row3], (array_of)(['group', 'id'])))->is([
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
        ]);
    }

    function test_array_aggregate()
    {
        that((array_aggregate)([1, 2, 3, 4, 5], [
            'min' => function ($v) { return min($v); },
            'max' => function ($v) { return max($v); },
        ]))->isSame([
            'min' => 1,
            'max' => 5,
        ]);

        $row1 = ['id' => 1, 'group' => 'A', 'class' => 'H', 'score' => 2];
        $row2 = ['id' => 2, 'group' => 'B', 'class' => 'H', 'score' => 4];
        $row3 = ['id' => 3, 'group' => 'A', 'class' => 'L', 'score' => 3];
        $row4 = ['id' => 4, 'group' => 'A', 'class' => 'H', 'score' => 2];
        $array = [$row1, $row2, $row3, $row4];

        that((array_aggregate)($array, [
            'ids'    => function ($rows) { return array_column($rows, 'id'); },
            'scores' => function ($rows) { return array_sum(array_column($rows, 'score')); },
        ], 'group'))->is([
            'A' => [
                'ids'    => [1, 3, 4],
                'scores' => 7,
            ],
            'B' => [
                'ids'    => [2],
                'scores' => 4,
            ],
        ]);

        that((array_aggregate)($array, [
            'scores' => function ($rows, $current) { return array_column($rows, 'score'); },
            'count'  => function ($rows, $current) { return count($current['scores']); },
            'sum'    => function ($rows, $current) { return array_sum($current['scores']); },
            'avg'    => function ($rows, $current) { return $current['sum'] / $current['count']; },
        ], 'group'))->is([
            'A' => [
                'scores' => [2, 3, 2],
                'count'  => 3,
                'sum'    => 7,
                'avg'    => 7 / 3,
            ],
            'B' => [
                'scores' => [4],
                'count'  => 1,
                'sum'    => 4,
                'avg'    => 4 / 1,
            ],
        ]);

        that((array_aggregate)($array, [
            'ids'    => function ($rows) { return array_column($rows, 'id'); },
            'scores' => function ($rows) { return array_sum(array_column($rows, 'score')); },
        ], ['group', 'class']))->is([
            'A' => [
                'H' => [
                    'ids'    => [1, 4],
                    'scores' => 4,
                ],
                'L' => [
                    'ids'    => [3],
                    'scores' => 3,
                ],
            ],
            'B' => [
                'H' => [
                    'ids'    => [2],
                    'scores' => 4,
                ],
            ],
        ]);

        that((array_aggregate)($array, [
            'ids'    => function ($rows) { return array_column($rows, 'id'); },
            'scores' => function ($rows) { return array_sum(array_column($rows, 'score')); },
        ], ['group', 'class']))->is([
            'A' => [
                'H' => [
                    'ids'    => [1, 4],
                    'scores' => 4,
                ],
                'L' => [
                    'ids'    => [3],
                    'scores' => 3,
                ],
            ],
            'B' => [
                'H' => [
                    'ids'    => [2],
                    'scores' => 4,
                ],
            ],
        ]);

        that((array_aggregate)($array, [
            'ids'    => function ($rows) { return array_column($rows, 'id'); },
            'scores' => function ($rows) { return array_sum(array_column($rows, 'score')); },
        ], function ($row) { return $row['group'] . '/' . $row['class']; }))->is([
            'A/H' => [
                'ids'    => [1, 4],
                'scores' => 4,
            ],
            'B/H' => [
                'ids'    => [2],
                'scores' => 4,
            ],
            'A/L' => [
                'ids'    => [3],
                'scores' => 3,
            ],
        ]);

        that((array_aggregate)($array, function ($rows) { return array_sum(array_column($rows, 'score')); }, function ($row) { return $row['group'] . '/' . $row['class']; }))->is([
            'A/H' => 4,
            'B/H' => 4,
            'A/L' => 3,
        ]);
    }

    function test_array_all()
    {
        $array = [
            0 => ['id' => 1, 'name' => '', 'flag' => false],
            1 => ['id' => 2, 'name' => '', 'flag' => true],
            2 => ['id' => 3, 'name' => '', 'flag' => false],
        ];

        that((array_all)([], null))->isTrue();
        that((array_all)([], null, false))->isFalse();

        that((array_all)([true, true]))->isTrue();
        that((array_all)([true, false]))->isFalse();
        that((array_all)([false, false]))->isFalse();

        that((array_all)($array, function ($v) { return $v['id']; }))->isTrue();
        that((array_all)($array, function ($v) { return $v['flag']; }))->isFalse();
        that((array_all)($array, function ($v) { return $v['name']; }))->isFalse();
        that((array_all)($array, function ($v, $k) { return $k && $v['flag']; }))->isFalse();
    }

    function test_array_any()
    {
        $array = [
            0 => ['id' => 1, 'name' => '', 'flag' => false],
            1 => ['id' => 2, 'name' => '', 'flag' => true],
            2 => ['id' => 3, 'name' => '', 'flag' => false],
        ];

        that((array_any)([], null))->isFalse();
        that((array_any)([], null, true))->isTrue();

        that((array_any)([true, true]))->isTrue();
        that((array_any)([true, false]))->isTrue();
        that((array_any)([false, false]))->isFalse();

        that((array_any)($array, function ($v) { return $v['id']; }))->isTrue();
        that((array_any)($array, function ($v) { return $v['flag']; }))->isTrue();
        that((array_any)($array, function ($v) { return $v['name']; }))->isFalse();
        that((array_any)($array, function ($v, $k) { return $k && $v['flag']; }))->isTrue();
    }

    function test_array_distinct()
    {
        // シンプルなもの
        that((array_distinct)([]))->isSame([]);
        that((array_distinct)([1]))->isSame([1]);
        that((array_distinct)([1, '2', 2, 3, '3']))->isSame([1, '2', 3 => 3]);
        that((array_distinct)([1, 2, 2, 3, 3, 3], SORT_NUMERIC))->isSame([1, 2, 3 => 3]);
        that((array_distinct)(['a', 'A'], SORT_STRING))->isSame(['a', 'A']);
        that((array_distinct)(['a', 'A'], SORT_STRING | SORT_FLAG_CASE))->isSame(['a']);

        // クロージャを与える
        that((array_distinct)([1, 2, -2, 3, -3], function ($a, $b) {
            return abs($a) <=> abs($b);
        }))->is([1, 2, 3 => 3]);

        // 配列の配列
        $rows = [
            11 => $r1 = ['id' => 1, 'group1' => 'groupA', 'group2' => 'groupA'],
            12 => $r2 = ['id' => 2, 'group1' => 'groupB', 'group2' => 'groupB'],
            13 => $r3 = ['id' => 3, 'group1' => 'groupA', 'group2' => 'groupB'],
            14 => $r4 = ['id' => 4, 'group1' => 'groupA', 'group2' => 'groupB'],
        ];
        that((array_distinct)($rows, 'group1'))->is([
            11 => $r1,
            12 => $r2,
        ]);
        that((array_distinct)($rows, ['group1', 'group2']))->is([
            11 => $r1,
            12 => $r2,
            13 => $r3,
        ]);

        $objects = [
            11 => $e1 = new \Exception('a', 1),
            12 => $e2 = new \Exception('b', 2),
            13 => $e3 = new \Exception('b', 3),
            14 => $e4 = new \Exception('b', 3),
        ];
        that((array_distinct)($objects, ['getMessage' => []]))->is([
            11 => $e1,
            12 => $e2,
        ]);
        that((array_distinct)($objects, ['getMessage' => [], 'getCode' => []]))->is([
            11 => $e1,
            12 => $e2,
            13 => $e3,
        ]);
    }

    function test_array_order()
    {
        that((array_order)([2, 4, 5, 1, 8, 6, 9, 3, 7], true))->is([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        that((array_order)(['b', 'd', 'g', 'a', 'f', 'e', 'c'], false))->is(['g', 'f', 'e', 'd', 'c', 'b', 'a']);
        that((array_order)(['b', 'c', 'z', 'b', 'a', 'c', 'a'], ['a', 'b', 'c']))->is(['a', 'a', 'b', 'b', 'c', 'c', 'z']);
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

        that((array_order)($data, true, true))->isSame([
            2 => '011',
            1 => '1',
            4 => '1',
            6 => '1',
            5 => '11',
            0 => '111',
            3 => '111',
        ]);

        that((array_order)($data, -SORT_NATURAL, true))->isSame([
            0 => '111',
            3 => '111',
            2 => '011',
            5 => '11',
            1 => '1',
            4 => '1',
            6 => '1',
        ]);
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

        that((array_order)($data, true, true))->isSame([
            'c' => '011',
            'b' => '1',
            'e' => '1',
            'g' => '1',
            'f' => '11',
            'a' => '111',
            'd' => '111',
        ]);

        that((array_order)($data, -SORT_NATURAL, true))->isSame([
            'a' => '111',
            'd' => '111',
            'c' => '011',
            'f' => '11',
            'b' => '1',
            'e' => '1',
            'g' => '1',
        ]);
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
        that((array_order)($data, [
            'string'  => false,
            'integer' => true,
        ], true))->isSame([
            4 => ['string' => 'dd', 'integer' => 2],
            1 => ['string' => 'cc', 'integer' => 1],
            6 => ['string' => 'cc', 'integer' => 2],
            5 => ['string' => 'cc', 'integer' => 6],
            3 => ['string' => 'bb', 'integer' => 6],
            2 => ['string' => 'aa', 'integer' => 2],
            0 => ['string' => 'aa', 'integer' => 7],
        ]);

        // 文字昇順・数値降順
        that((array_order)($data, [
            'string'  => true,
            'integer' => false,
        ], true))->isSame([
            0 => ['string' => 'aa', 'integer' => 7],
            2 => ['string' => 'aa', 'integer' => 2],
            3 => ['string' => 'bb', 'integer' => 6],
            5 => ['string' => 'cc', 'integer' => 6],
            6 => ['string' => 'cc', 'integer' => 2],
            1 => ['string' => 'cc', 'integer' => 1],
            4 => ['string' => 'dd', 'integer' => 2],
        ]);

        // 数値降順・文字昇順
        that((array_order)($data, [
            'integer' => false,
            'string'  => true,
        ], true))->isSame([
            0 => ['string' => 'aa', 'integer' => 7],
            3 => ['string' => 'bb', 'integer' => 6],
            5 => ['string' => 'cc', 'integer' => 6],
            2 => ['string' => 'aa', 'integer' => 2],
            6 => ['string' => 'cc', 'integer' => 2],
            4 => ['string' => 'dd', 'integer' => 2],
            1 => ['string' => 'cc', 'integer' => 1],
        ]);

        // 数値昇順・文字降順
        that((array_order)($data, [
            'integer' => true,
            'string'  => false,
        ], true))->isSame([
            1 => ['string' => 'cc', 'integer' => 1],
            4 => ['string' => 'dd', 'integer' => 2],
            6 => ['string' => 'cc', 'integer' => 2],
            2 => ['string' => 'aa', 'integer' => 2],
            5 => ['string' => 'cc', 'integer' => 6],
            3 => ['string' => 'bb', 'integer' => 6],
            0 => ['string' => 'aa', 'integer' => 7],
        ]);
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
        that((array_order)($data, [
            'string'  => SORT_NATURAL,
            'integer' => SORT_NUMERIC,
        ], true))->isSame([
            1 => ['string' => '1', 'integer' => '1g'],
            6 => ['string' => '1', 'integer' => '2i'],
            4 => ['string' => '1', 'integer' => '2r'],
            2 => ['string' => '011', 'integer' => '2w'],
            5 => ['string' => '11', 'integer' => '6t'],
            3 => ['string' => '111', 'integer' => '6u'],
            0 => ['string' => '111', 'integer' => '7a'],
        ]);

        // 文字自然昇順・数値降順
        that((array_order)($data, [
            'string'  => -SORT_NATURAL,
            'integer' => -SORT_NUMERIC,
        ], true))->isSame([
            0 => ['string' => '111', 'integer' => '7a'],
            3 => ['string' => '111', 'integer' => '6u'],
            5 => ['string' => '11', 'integer' => '6t'],
            2 => ['string' => '011', 'integer' => '2w'],
            6 => ['string' => '1', 'integer' => '2i'],
            4 => ['string' => '1', 'integer' => '2r'],
            1 => ['string' => '1', 'integer' => '1g'],
        ]);
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

        that((array_order)($data, [
            'string'  => ['bb', 'aa', 'dd', 'cc'],
            'integer' => [2, 6, 7],
        ], true))->isSame([
            3 => ['string' => 'bb', 'integer' => 6],
            2 => ['string' => 'aa', 'integer' => 2],
            0 => ['string' => 'aa', 'integer' => 7],
            4 => ['string' => 'dd', 'integer' => 2],
            6 => ['string' => 'cc', 'integer' => 2],
            5 => ['string' => 'cc', 'integer' => 6],
            1 => ['string' => 'cc', 'integer' => 1],
        ]);
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

        that((array_order)($data, [
            'integer' => function ($v) {
                // 6は0とみなす
                return $v === 6 ? 0 : $v;
            },
            'string'  => function ($v) {
                // "aa"は"zz"とみなす
                return $v === 'aa' ? 'zz' : $v;
            },
        ], true))->isSame([
            3 => ['string' => 'bb', 'integer' => 6],
            5 => ['string' => 'cc', 'integer' => 6],
            1 => ['string' => 'cc', 'integer' => 1],
            6 => ['string' => 'cc', 'integer' => 2],
            4 => ['string' => 'dd', 'integer' => 2],
            2 => ['string' => 'aa', 'integer' => 2],
            0 => ['string' => 'aa', 'integer' => 7],
        ]);

        that((array_order)($data, [
            'string' => SORT_STRING,
            ''       => SORT_NUMERIC,
        ], true))->isSame([
            0 => ['string' => 'aa', 'integer' => 7],
            2 => ['string' => 'aa', 'integer' => 2],
            3 => ['string' => 'bb', 'integer' => 6],
            1 => ['string' => 'cc', 'integer' => 1],
            5 => ['string' => 'cc', 'integer' => 6],
            6 => ['string' => 'cc', 'integer' => 2],
            4 => ['string' => 'dd', 'integer' => 2],
        ]);
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

        that((array_order)($data, [
            'string' => function ($a, $b) { return strcmp($a, $b); },
            'array'  => function ($a, $b) { return array_sum($b) - array_sum($a); },
        ], true))->isSame([
            0 => ['string' => 'aa', 'array' => [7, 3]],
            2 => ['string' => 'aa', 'array' => [2, 2]],
            3 => ['string' => 'bb', 'array' => [6, 3]],
            5 => ['string' => 'cc', 'array' => [6, 5]],
            1 => ['string' => 'cc', 'array' => [1, 5]],
            6 => ['string' => 'cc', 'array' => [2, 2]],
            4 => ['string' => 'dd', 'array' => [2, 1]],
        ]);
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
        that((array_order)($data, $cb))->isSame([
            '11',
            '22',
            '33',
            '111',
            '222',
            '333',
        ]);

        // returnType が string なら文字的にソートされる
        $cb = eval('return function ($v): string { return $v; };');
        that((array_order)($data, $cb))->isSame([
            '11',
            '111',
            '22',
            '222',
            '33',
            '333',
        ]);
    }

    function test_array_order_ex()
    {
        that((array_order)([], [[]]))->is([]);
        that((array_order)([1], [[]]))->is([1]);

        that([array_order, [['a' => 1], ['a' => 2]], ['x' => true]])->throws(new \InvalidArgumentException('x is undefined'));

        that([array_order, [['a' => 1], ['a' => 2]], ['a' => new \stdClass()]])->throws(new \DomainException('$order is invalid'));
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
        that($t)->as("$t milliseconds is too slow.")->lessThan(1.0);
    }

    function test_array_shuffle()
    {
        srand(123);
        mt_srand(123);
        that((array_shuffle)(['a' => 'A', 'b' => 'B', 'c' => 'C']))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);
        that((array_shuffle)(['a' => 'A', 'b' => 'B', 'c' => 'C']))->isNotSame(['a' => 'A', 'b' => 'B', 'c' => 'C']);
    }

    function test_array_shrink_key()
    {
        $array = [0 => 'first', 'a' => 'A', 'b' => 'B', 'c' => 'C', 'x' => 'X', 'y' => 'Y', 'z' => 'Z', 99 => 'end'];
        $array1 = [0 => 'first2', 'b' => 'B1', 'a' => 'A1', 'c' => 'C1'];
        $array2 = [1 => 'second', 'b' => 'B2', 'a' => 'A2', 'c' => 'C2', 'x' => 'X2'];
        $array3 = ['b' => 'B3', 'a' => 'A3', 'c' => 'C3', 'y' => 'Y2', 100 => 'end'];

        // array_intersect_key は左方優先だが・・・
        that(array_intersect_key($array, $array1, $array2, $array3))->isSame(['a' => 'A', 'b' => 'B', 'c' => 'C']);
        // array_shrink_key は右方優先
        that((array_shrink_key)($array, $array1, $array2, $array3))->isSame(['a' => 'A3', 'b' => 'B3', 'c' => 'C3']);

        // オブジェクトも渡せる
        $object = (stdclass)($array);
        $object1 = (stdclass)($array1);
        $object2 = (stdclass)($array2);
        $object3 = (stdclass)($array3);
        that((array_shrink_key)($object, $object1, $object2, $object3))->isSame(['a' => 'A3', 'b' => 'B3', 'c' => 'C3']);
    }

    function test_array_fill_gap()
    {
        that((array_fill_gap)(['a', 'b', 'c'], 'd', 'e'))->isSame(['a', 'b', 'c', 'd', 'e']);
        that((array_fill_gap)(['a', 'b', 3 => 'd'], 'c', 'e'))->isSame(['a', 'b', 'c', 'd', 'e']);
        that((array_fill_gap)([1 => 'b', 3 => 'd'], 'a', 'c', 'e'))->isSame(['a', 'b', 'c', 'd', 'e']);
        that((array_fill_gap)([], 'a', 'b', 'c', 'd', 'e'))->isSame(['a', 'b', 'c', 'd', 'e']);
        that((array_fill_gap)(['a', 'b', 'c', 'd', 'e']))->isSame(['a', 'b', 'c', 'd', 'e']);
        that((array_fill_gap)(['a', 'x' => 'Noise', 'b', 'y' => 'Noise', 3 => 'd', 'z' => 'Noise'], 'c', 'e'))->isSame(['a', 'x' => 'Noise', 'b', 'y' => 'Noise', 'c', 'd', 'z' => 'Noise', 'e']);
        that((array_fill_gap)(['a', 4 => 'e'], 'b', 'c'))->isSame(['a', 'b', 'c', 4 => 'e']);
        that((array_fill_gap)((array_fill_gap)(['a', 4 => 'e'], 'b', 'c'), 'd'))->isSame(['a', 'b', 'c', 'd', 'e']);
    }

    function test_array_fill_callback()
    {
        that((array_fill_callback)(['a', 'b', 'c'], 'strtoupper'))->isSame(array_combine($keys = ['a', 'b', 'c'], array_map('strtoupper', $keys)));
    }

    function test_array_pickup()
    {
        that((array_pickup)(['a' => 'A', 'b' => ['b' => 'B']], ['a']))->isSame(['a' => 'A']);
        that((array_pickup)(['a' => 'A', 'b' => ['b' => 'B']], ['b']))->isSame(['b' => ['b' => 'B']]);

        that((array_pickup)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['a', 'c']))->isSame(['a' => 'A', 'c' => 'C']);
        that((array_pickup)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['c', 'a']))->isSame(['c' => 'C', 'a' => 'A']);

        that((array_pickup)((stdclass)(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['a', 'c']))->isSame(['a' => 'A', 'c' => 'C']);
        that((array_pickup)((stdclass)(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['c', 'a']))->isSame(['c' => 'C', 'a' => 'A']);

        that((array_pickup)(['a' => 'A', 'b' => ['b' => 'B']], ['a' => 'AAA']))->isSame(['AAA' => 'A']);
        that((array_pickup)(['a' => 'A', 'b' => ['b' => 'B']], ['b' => 'BBB']))->isSame(['BBB' => ['b' => 'B']]);
    }

    function test_array_remove()
    {
        that((array_remove)(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'b'))->isSame(['a' => 'A', 'c' => 'C']);
        that((array_remove)(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x'))->isSame(['a' => 'A', 'b' => 'B', 'c' => 'C']);

        that((array_remove)(['a' => 'A', 'b' => ['b' => 'B']], ['b']))->isSame(['a' => 'A']);
        that((array_remove)(['a' => 'A', 'b' => ['b' => 'B']], ['a']))->isSame(['b' => ['b' => 'B']]);

        that((array_remove)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['a', 'c']))->isSame(['b' => 'B']);
        that((array_remove)(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['c', 'a']))->isSame(['b' => 'B']);

        that((array_remove)(new \ArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['a', 'c']))->is(new \ArrayObject(['b' => 'B']));
        that((array_remove)(new \ArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['c', 'a']))->is(new \ArrayObject(['b' => 'B']));
    }

    function test_array_lookup()
    {
        $arrays = [
            11 => ['id' => 1, 'name' => 'name1'],
            12 => ['id' => 2, 'name' => 'name2'],
            13 => ['id' => 3, 'name' => 'name3'],
        ];

        // 第3引数を与えれば array_column と全く同じ
        that((array_lookup)($arrays, 'name', 'id'))->isSame(array_column($arrays, 'name', 'id'));
        that((array_lookup)($arrays, null, 'id'))->isSame(array_column($arrays, null, 'id'));
        // 与えなければキーが保存される array_column のような動作になる
        that((array_lookup)($arrays, 'name'))->isSame([11 => 'name1', 12 => 'name2', 13 => 'name3']);
        that((array_lookup)($arrays, null))->isSame($arrays);
        // オブジェクトもOK
        $objects = array_map(stdclass, $arrays);
        that((array_lookup)($objects, 'name'))->isSame([11 => 'name1', 12 => 'name2', 13 => 'name3']);
    }

    function test_array_select()
    {
        $arrays = [
            11 => ['id' => 1, 'name' => 'name1'],
            12 => (object) ['id' => 2, 'name' => 'name2'],
            13 => new \ArrayObject(['id' => 3, 'name' => 'name3']),
        ];

        that((array_select)($arrays, 'name', null))->isSame((array_lookup)($arrays, 'name', null));

        that((array_select)($arrays, function ($row) {
            return [
                'hoge' => (attr_get)('id', $row),
                'fuga' => (attr_get)('name', $row),
                'piyo' => 123,
            ];
        }))->isSame([
            11 => ['hoge' => 1, 'fuga' => 'name1', 'piyo' => 123],
            12 => ['hoge' => 2, 'fuga' => 'name2', 'piyo' => 123],
            13 => ['hoge' => 3, 'fuga' => 'name3', 'piyo' => 123],
        ]);
        that((array_select)($arrays, [
            'name' => function ($name) { return strtoupper($name); },
        ], null))->isSame([
            ['name' => 'NAME1'],
            ['name' => 'NAME2'],
            ['name' => 'NAME3'],
        ]);
        that((array_select)($arrays, [
            'id' => function ($id, $row) { return (attr_get)('id', $row) * 10; },
        ], 'id'))->isSame([
            10 => ['id' => 10],
            20 => ['id' => 20],
            30 => ['id' => 30],
        ]);
        that((array_select)($arrays, [
            'id10' => function ($id, $row) { return (attr_get)('id', $row) * 10; },
        ], 'id'))->isSame([
            1 => ['id10' => 10],
            2 => ['id10' => 20],
            3 => ['id10' => 30],
        ]);
        that((array_select)($arrays, [
            'id'     => function ($id, $row) { return (attr_get)('id', $row) * 10; },
            'name',
            'idname' => function ($val, $row) { return (attr_get)('id', $row) . ':' . (attr_get)('name', $row); },
        ]))->isSame([
            11 => ['id' => 10, 'name' => 'name1', 'idname' => '1:name1'],
            12 => ['id' => 20, 'name' => 'name2', 'idname' => '2:name2'],
            13 => ['id' => 30, 'name' => 'name3', 'idname' => '3:name3'],
        ]);

        that([
            array_select,
            $arrays,
            [
                'undefined',
            ]
        ])->throws('is not exists');

        that([
            array_select,
            $arrays,
            [
                'name',
            ],
            'undefined'
        ])->throws('is not exists');
    }

    function test_array_columns()
    {
        $array = [
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
        ];

        that((array_columns)($array))->is([
            'id'   => [1, 2, 3],
            'name' => ['A', 'B', 'C'],
        ]);

        that((array_columns)($array, 'name', 'id'))->is([
            'name' => [1 => 'A', 2 => 'B', 3 => 'C'],
        ]);

        that([array_columns, []])->throws('InvalidArgumentException');
    }

    function test_array_uncolumns()
    {
        // 普通の配列
        that((array_uncolumns)([
            'id'   => [1, 2, 3],
            'name' => ['A', 'B', 'C'],
        ]))->is([
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
        ]);

        // キーも活きる
        that((array_uncolumns)([
            'id'   => ['x' => 1, 'y' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'z' => 'C'],
        ]))->is([
            'x' => ['id' => 1, 'name' => 'A'],
            'y' => ['id' => 2, 'name' => 'B'],
            'z' => ['id' => 3, 'name' => 'C'],
        ]);

        // バラバラな配列を与えるとバラバラになる
        that((array_uncolumns)([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ]))->is([
            'x'  => ['id' => 1, 'name' => 'A'],
            'ya' => ['id' => 2],
            'z'  => ['id' => 3],
            'y'  => ['name' => 'B'],
            'az' => ['name' => 'C'],
        ]);

        // null を与えると最初のキーで compat される
        that((array_uncolumns)([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ], null))->is([
            'x'  => ['id' => 1, 'name' => 'A'],
            'ya' => ['id' => 2, 'name' => null],
            'z'  => ['id' => 3, 'name' => null],
        ]);

        // [デフォルト] を与えるとその値で compat される
        that((array_uncolumns)([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ], ['x' => null, 'y' => null, 'zzz' => 999]))->is([
            'x'   => ['id' => 1, 'name' => 'A'],
            'y'   => ['id' => null, 'name' => 'B'],
            'zzz' => ['id' => 999, 'name' => 999],
        ]);
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
        that((array_convert)($array, function ($k, &$v) {
            if (!is_array($v)) {
                $v = "prefix-$v";
            }
            return "_$k";
        }, true))->is([
            '_k1' => 'prefix-v1',
            '_k2' => [
                '_k21' => 'prefix-v21',
                '_k22' => [
                    '_k221' => 'prefix-v221',
                    '_k222' => 'prefix-v222',
                ],
            ],
        ]);

        // キー 'k21', 'k222' を取り除く
        that((array_convert)($array, function ($k, $v) {
            return in_array($k, ['k21', 'k222']) ? false : null;
        }))->is([
            'k1' => 'v1',
            'k2' => [
                'k22' => [
                    'k221' => 'v221',
                ],
            ],
        ]);

        // キー 'k21', 'k221', 'k222' を取り除く
        that((array_convert)($array, function ($k, $v) {
            return in_array($k, ['k21', 'k221', 'k222']) ? false : null;
        }))->is([
            'k1' => 'v1',
            'k2' => [
                'k22' => [],
            ],
        ]);

        // キー 'k22' を取り除く
        that((array_convert)($array, function ($k, $v) {
            return in_array($k, ['k22']) ? false : null;
        }, true))->is([
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
            ],
        ]);

        // キー 'k22' に要素を生やす
        that((array_convert)($array, function ($k, &$v) {
            if ($k === 'k22') {
                $v = array_merge($v, ['new1' => 'new1val', 'new2' => 'new2val']);
            }
        }, true))->is([
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
        ]);

        // 常に null を返せば実質的に array_walk_recursive と同じ
        that((array_convert)($array, function ($k, &$v) {
            $v = "prefix-$v";
            return null;
        }))->is([
            'k1' => 'prefix-v1',
            'k2' => [
                'k21' => 'prefix-v21',
                'k22' => [
                    'k221' => 'prefix-v221',
                    'k222' => 'prefix-v222',
                ],
            ],
        ]);
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
        that((array_convert)($array, function ($k) {
            if ($k === 'k1') {
                return true;
            }
        }))->is([
            'k2' => [
                'v21',
                'k22' => ['v221', 'v222'],
            ],
            9    => 'v2',
            10   => 'v1',
        ]);

        // 値 v221 を数値連番にする
        that((array_convert)($array, function ($k, $v) {
            if ($v === 'v221') {
                return true;
            }
        }))->is([
            'k1' => 'v1',
            'k2' => [
                'v21',
                'k22' => [1 => 'v222', 2 => 'v221',],
            ],
            9    => 'v2',
        ]);

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
        that((array_convert)($array, function ($k, $v) {
            return true;
        }, true))->is([
            0 => 1,
            1 => 2,
            2 => [
                0 => 11,
                1 => 21,
                2 => 31,
            ],
            3 => 3,
        ]);
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
        that((array_convert)($array, function ($k, $v) {
            if ($k === 'k22') {
                return [1, 2, 3];
            }
        }))->is([
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
                1,
                2,
                3,
            ],
        ]);
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
            that($history)->is($expected[$n++]);
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
        that((array_flatten)($array))->isSame([
            'v1',
            'v21',
            123,
            1,
            2,
            3,
            $o,
        ]);

        // 区切り文字指定
        that((array_flatten)($array, '.'))->isSame([
            'k1'       => 'v1',
            'k2.k21'   => 'v21',
            'k2.k22'   => 123,
            'k2.k23.0' => 1,
            'k2.k23.1' => 2,
            'k2.k23.2' => 3,
            'o'        => $o,
        ]);

        // クロージャ指定
        that((array_flatten)($array, function ($keys) {
            return implode('.', $keys);
        }))->isSame([
            'k1'       => 'v1',
            'k2.k21'   => 'v21',
            'k2.k22'   => 123,
            'k2.k23.0' => 1,
            'k2.k23.1' => 2,
            'k2.k23.2' => 3,
            'o'        => $o,
        ]);
        that((array_flatten)($array, function ($keys) {
            return array_shift($keys) . ($keys ? '[' . implode('][', $keys) . ']' : '');
        }))->isSame([
            'k1'         => 'v1',
            'k2[k21]'    => 'v21',
            'k2[k22]'    => 123,
            'k2[k23][0]' => 1,
            'k2[k23][1]' => 2,
            'k2[k23][2]' => 3,
            'o'          => $o,
        ]);

        // Generator
        that((array_flatten)((function () {
            yield 1 => 1;
            yield (function () {
                yield 10 => 10;
                yield (function () {
                    yield 100 => 100;
                    yield 200 => 200;
                })();
                yield 20 => 20;
            })();
            yield 2 => 2;
        })(), '.'))->isSame([
            '1'        => 1,
            '2.10'     => 10,
            '2.11.100' => 100,
            '2.11.200' => 200,
            '2.20'     => 20,
            '2'        => 2,
        ]);
    }

    function test_array_nest()
    {
        that((array_nest)([
            'k1.k2' => 'v1',
            'k1'    => 'v2',
        ]))->is([
            'k1' => 'v2'
        ]);
        that((array_nest)([
            'k1'    => ['v1'],
            'k1.k2' => 'v2',
        ]))->is([
            'k1' => [
                0    => 'v1',
                'k2' => 'v2',
            ]
        ]);
        that((array_nest)([
            'k1.0'  => 'v1',
            'k1.k2' => 'v2',
        ]))->is([
            'k1' => [
                0    => 'v1',
                'k2' => 'v2',
            ]
        ]);
        that([
            array_nest,
            [
                'k1'    => 'v1',
                'k1.k2' => 'v2',
            ]
        ])->throws('already exists');
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
        that((array_difference)($a1, $a2))->is([
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
        ]);
    }

    function test_array_schema_ok()
    {
        that((array_schema)(['type' => 'number', 'filter' => FILTER_VALIDATE_INT], 123))->isSame(123);
        that((array_schema)(['type' => 'number', 'default' => 123]))->isSame(123);

        that((array_schema)(['type' => \ArrayAccess::class], new \ArrayObject()))->isInstanceOf(\ArrayObject::class);
        that((array_schema)(['type' => 'int|string'], 123))->isSame(123);
        that((array_schema)(['type' => ['int', 'string']], '123'))->isSame('123');

        that((array_schema)(['type' => 'number'], 123.45))->isSame(123.45);
        that((array_schema)(['type' => 'int', 'closure' => function ($v) { return $v * 10; }], 123))->isSame(1230);
        that((array_schema)(['type' => 'list', 'unique' => null], [1, 1, 2, 2, 3, 3]))->isSame([1, 2, 3]);
        that((array_schema)(['type' => 'int', 'min' => 1], 1))->isSame(1);
        that((array_schema)(['type' => 'int', 'max' => 9], 5))->isSame(5);
        that((array_schema)(['type' => 'string', 'min' => 1], 'X'))->isSame('X');
        that((array_schema)(['type' => 'string', 'max' => 9], 'X'))->isSame('X');
        that((array_schema)(['type' => 'list', 'min' => 1], ['X']))->isSame(['X']);
        that((array_schema)(['type' => 'list', 'max' => 9], ['X']))->isSame(['X']);
        that((array_schema)(['type' => 'float', 'precision' => 3], 1.234))->isSame(1.234);
        that((array_schema)(['type' => 'int', 'enum' => [1, 2, 3]], 2))->isSame(2);
        that((array_schema)(['type' => 'string', 'match' => '#[1-9]#'], '123'))->isSame('123');
        that((array_schema)(['type' => 'string', 'unmatch' => '#[1-9]#'], 'abc'))->isSame('abc');
        that((array_schema)(['type' => 'string', 'include' => 'b'], 'abc'))->isSame('abc');
        that((array_schema)(['type' => 'string', 'exclude' => 'X'], 'abc'))->isSame('abc');
        that((array_schema)(['type' => 'list', 'include' => 'b'], ['a', 'b']))->isSame(['a', 'b']);
        that((array_schema)(['type' => 'list', 'exclude' => 'X'], ['a', 'b']))->isSame(['a', 'b']);
    }

    function test_array_schema_ng()
    {
        that([array_schema, ['type' => 'number', 'filter' => FILTER_VALIDATE_INT], 'hoge'])->throws('hoge must be filter_var int([])');
        that([array_schema, ['type' => 'int|string'], true])->throws('true must be int or string');
        that([array_schema, ['type' => ['int', 'string']], true])->throws('true must be int or string');

        that([array_schema, ['type' => 'string'], 123])->throws("123 must be string");
        that([array_schema, ['type' => 'number'], "123"])->throws("123 must be number");
        that([array_schema, ['type' => 'numeric'], "12..45"])->throws("12..45 must be numeric");
        that([array_schema, ['type' => 'list'], "hoge"])->throws("hoge must be list");
        that([array_schema, ['type' => \ArrayObject::class], "hoge"])->throws("hoge must be ArrayObject");

        that([array_schema, ['type' => 'int', 'min' => 1], 0])->throws("0 must be >= 1");
        that([array_schema, ['type' => 'int', 'max' => 1], 3])->throws("3 must be <= 1");
        that([array_schema, ['type' => 'string', 'min' => 1], ''])->throws("must be strlen >= 1");
        that([array_schema, ['type' => 'string', 'max' => 1], 'abc'])->throws("abc must be strlen <= 1");
        that([array_schema, ['type' => 'list', 'min' => 1], []])->throws("[] must be count >= 1");
        that([array_schema, ['type' => 'list', 'max' => 1], [1, 2, 3]])->throws("[1, 2, 3] must be count <= 1");

        that([array_schema, ['type' => 'float', 'precision' => 3], 1.2345])->throws("1.2345 must be precision 3");

        that([array_schema, ['type' => 'int', 'enum' => [1, 2, 3]], 4])->throws("4 must be any of [1,2,3]");

        that([array_schema, ['type' => 'string', 'match' => '#[1-9]#'], 'abc'])->throws("must be match #[1-9]#");
        that([array_schema, ['type' => 'string', 'unmatch' => '#[1-9]#'], '123'])->throws("must be unmatch #[1-9]#");

        that([array_schema, ['type' => 'string', 'include' => 'X'], 'abc'])->throws("abc must be include X");
        that([array_schema, ['type' => 'list', 'include' => 'X'], [1, 2, 3]])->throws("[1, 2, 3] must be include X");

        that([array_schema, ['type' => 'string', 'exclude' => 'X'], 'X'])->throws("X must be exclude X");
        that([array_schema, ['type' => 'list', 'exclude' => 'X'], [1, 'X', 3]])->throws("[1, \"X\", 3] must be exclude X");

        that([array_schema, ['type' => 'hash', '#key' => []], ['key' => 'val']])->throws('not have type key');
        that([array_schema, ['type' => 'number']])->throws('has no value');
    }

    function test_array_schema_misc()
    {
        that((array_schema)([
            'type'     => 'hash',
            '#string'  => 'type:string',
            '#hash'    => [
                'type'    => 'hash',
                '#bucket' => 'type:string',
                '#expire' => 'type:int',
            ],
            '#list'    => 'type:list',
            '#objects' => [
                'type'    => 'list@hash',
                '@#name'  => 'type:string',
                '@#age'   => 'type:int',
                '@#items' => 'type:list@string',
            ],
        ], [
            'string'  => 'abc',
            'hash'    => [
                'bucket' => 'awsbucket',
                'expire' => 60 * 60 * 24,
            ],
            'list'    => [1],
            'objects' => [
                [
                    'name'  => 'hoge',
                    'age'   => 12,
                    'items' => ['x'],
                ],
            ]
        ], [
            'string'  => 'def',
            'hash'    => [
                'bucket' => 'mybucket',
            ],
            'list'    => [2],
            'objects' => [
                [
                    'name'  => 'fuga',
                    'age'   => 18,
                    'items' => ['y'],
                ],
            ]
        ], [
            'string'  => 'xyz',
            'hash'    => [
                'expire' => 60,
            ],
            'list'    => [3],
            'objects' => [
                [
                    'name'  => 'piyo',
                    'age'   => 24,
                    'items' => ['z'],
                ],
            ]
        ]))->isSame([
            'string'  => 'xyz',
            'hash'    => [
                'bucket' => 'mybucket',
                'expire' => 60,
            ],
            'list'    => [1, 2, 3],
            'objects' => [
                [
                    'name'  => 'hoge',
                    'age'   => 12,
                    'items' => ['x'],
                ],
                [
                    'name'  => 'fuga',
                    'age'   => 18,
                    'items' => ['y'],
                ],
                [
                    'name'  => 'piyo',
                    'age'   => 24,
                    'items' => ['z'],
                ],
            ]
        ]);

        $schema = [
            'type'   => 'list@hash',
            'max'    => 1,
            '@#name' => [
                'type' => 'string',
                'max'  => 2,
            ],
        ];
        that((array_schema)($schema, [['name' => 'XY']]))->isSame([['name' => 'XY']]);
        that([
            array_schema,
            $schema,
            [
                ['name' => 'X']
            ],
            [
                ['name' => 'Y']
            ],
        ])->throws("must be count <= 1");
        that([
            array_schema,
            $schema,
            [
                ['name' => 'XYZ']
            ],
        ])->throws("must be strlen <= 2");
    }
}
