<?php

namespace ryunosuke\Test\package;

class ArrayTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_arrayize()
    {
        $this->assertEquals([1, 2, 3], arrayize(1, 2, 3));
        $this->assertEquals([1, 2, 3], arrayize([1], 2, 3));
    }

    function test_is_hasharray()
    {
        $this->assertFalse(is_hasharray([]));
        $this->assertFalse(is_hasharray([1]));
        $this->assertFalse(is_hasharray([0 => 1]));
        $this->assertTrue(is_hasharray([1 => 1]));
    }

    function test_first_key()
    {
        $this->assertEquals(0, first_key(['a', 'b', 'c']));
        $this->assertException(new \OutOfBoundsException('empty'), first_key, []);
    }

    function test_first_value()
    {
        $this->assertEquals('a', first_value(['a', 'b', 'c']));
        $this->assertException(new \OutOfBoundsException('empty'), first_value, []);
    }

    function test_first_keyvalue()
    {
        $this->assertEquals([0, 'a'], first_keyvalue(['a', 'b', 'c']));
        $this->assertException(new \OutOfBoundsException('empty'), first_keyvalue, []);
    }

    function test_last_key()
    {
        $this->assertEquals(2, last_key(['a', 'b', 'c']));
        $this->assertException(new \OutOfBoundsException('empty'), last_key, []);
    }

    function test_last_value()
    {
        $this->assertEquals('c', last_value(['a', 'b', 'c']));
        $this->assertException(new \OutOfBoundsException('empty'), last_value, []);
    }

    function test_last_keyvalue()
    {
        $this->assertEquals([2, 'c'], last_keyvalue(['a', 'b', 'c']));
        $this->assertException(new \OutOfBoundsException('empty'), last_keyvalue, []);
    }

    function test_array_get()
    {
        $this->assertEquals('b', array_get(['a', 'b', 'c'], 1));
        $this->assertEquals(999, array_get(['a', 'b', 'c'], 9, 999));
        $this->assertException(new \OutOfBoundsException('undefined'), array_get, [], 'hoge');
    }

    function test_array_pos()
    {
        // 1 番目の要素を返す
        $this->assertEquals('y', array_pos(['x', 'y', 'z'], 1, false));
        // 負数は後ろから返す
        $this->assertEquals('z', array_pos(['x', 'y', 'z'], -1, false));

        // 上記の is_key:true 版（キーを返す）
        $this->assertEquals(1, array_pos(['x', 'y', 'z'], 1, true));
        $this->assertEquals(2, array_pos(['x', 'y', 'z'], -1, true));

        // 範囲外は例外が飛ぶ
        $this->assertException('OutOfBoundsException', array_pos, ['x', 'y', 'z'], 9, true);
    }

    function test_array_unset()
    {
        $array = ['a' => 'A', 'b' => 'B'];
        $this->assertEquals('A', array_unset($array, 'a'));
        $this->assertEquals(['b' => 'B'], $array);
        $this->assertEquals('X', array_unset($array, 'x', 'X'));
        $this->assertEquals(['b' => 'B'], $array);
    }

    function test_array_dive()
    {
        $this->assertEquals('vvv', array_dive(['a' => ['b' => ['c' => 'vvv']]], 'a.b.c'));
        $this->assertEquals(9, array_dive(['a' => ['b' => ['c' => 'vvv']]], 'a.b.x', 9));
        $this->assertException(new \OutOfBoundsException('undefined'), array_dive, [], 'hoge');
    }

    function test_array_exists()
    {
        $this->assertEquals(2, array_exists(['a', 'b', '9'], 'ctype_digit'));
        $this->assertEquals('b', array_exists(['a' => 'A', 'b' => 'B'], function ($v) { return $v === 'B'; }));
        $this->assertSame(0, array_exists(['9', 'b', 'c'], 'ctype_digit'));
        $this->assertSame(false, array_exists(['a', 'b', 'c'], function ($v) { }));
    }

    function test_array_grep_key()
    {
        $this->assertEquals(['a', 'b', 'c'], array_grep_key(['a', 'b', 'c'], '#\d#'));
        $this->assertEquals(['hoge' => 'HOGE'], array_grep_key(['hoge' => 'HOGE', 'fuga' => 'FUGA'], '#^h#'));
        $this->assertEquals(['fuga' => 'FUGA'], array_grep_key(['hoge' => 'HOGE', 'fuga' => 'FUGA'], '#^h#', true));
    }

    function test_array_map_key()
    {
        $this->assertEquals(['A' => 'A', 'B' => 'B'], array_map_key(['a' => 'A', 'b' => 'B'], 'strtoupper'));
        $this->assertEquals(['A' => 'A'], array_map_key(['a' => 'A', 'b' => 'B'], function ($k) { return $k === 'b' ? null : strtoupper($k); }));
    }

    function test_array_filter_not()
    {
        $this->assertEquals([1 => ''], array_filter_not(['a', '', 'c'], 'strlen'));
    }

    function test_array_filter_key()
    {
        $this->assertEquals([1 => 'b'], array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $k === 1; }));
        $this->assertEquals([1 => 'b'], array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $v === "b"; }));
        $this->assertEquals(['a', 2 => 'c'], array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $v !== "b"; }));
    }

    function test_array_filter_eval()
    {
        $this->assertEquals([1 => 'b'], array_filter_eval(['a', 'b', 'c'], '$k === 1'));
        $this->assertEquals([1 => 'b'], array_filter_eval(['a', 'b', 'c'], '$v === "b"'));
        $this->assertEquals(['a', 2 => 'c'], array_filter_eval(['a', 'b', 'c'], '$v !== "b"'));
    }

    function test_array_map_filter()
    {
        // strict:false なので 0 が除外される
        $this->assertEquals([-2, -1, '3' => 1, 2], array_map_filter([1, 2, 3, 4, 5], function ($v) {
            return $v - 3;
        }, false));

        // strict:true なので全て返ってくる
        $this->assertEquals([-2, -1, 0, 1, 2], array_map_filter([1, 2, 3, 4, 5], function ($v) {
            return $v - 3;
        }, true));

        // strict:true は null がフィルタされる
        $this->assertEquals([-2, -1, '3' => 1, 2], array_map_filter([1, 2, 3, 4, 5], function ($v) {
            return $v === 3 ? null : $v - 3;
        }, true));
    }

    function test_array_map_method()
    {
        $o1 = new \Concrete('a');
        $o2 = new \Concrete('b');
        $o3 = new \Concrete('c');

        // きちんと呼ばれるし引数も渡る
        $this->assertEquals(['a', 'b', 'c'], array_map_method([$o1, $o2, $o3], 'getName'));
        $this->assertEquals(['_A', '_B', '_C'], array_map_method([$o1, $o2, $o3], 'getName', ['_', true]));

        // $ignore=true すると filter される
        $this->assertEquals(['a'], array_map_method([$o1, null, 123], 'getName', [], true));

        // $ignore=null するとそのまま返す
        $this->assertEquals(['a', null, 123], array_map_method([$o1, null, 123], 'getName', [], null));

        // $ignore=false でおかしなことすると warning が発生する
        $this->assertException(new \PHPUnit_Framework_Error_Warning('', 0, '', 0), array_map_method, [$o1, null, 123], 'getName');
    }

    function test_array_nmap()
    {
        // それぞれ N 番目に適用される
        $this->assertEquals(['1a--z', '2a--z'], array_nmap([1, 2], strcat, 0, 'a-', '-z'));
        $this->assertEquals(['a-1-z', 'a-2-z'], array_nmap([1, 2], strcat, 1, 'a-', '-z'));
        $this->assertEquals(['a--z1', 'a--z2'], array_nmap([1, 2], strcat, 2, 'a-', '-z'));

        /// $n に配列を渡すとキー・値の両方が渡ってくる
        // キーを1番目、値を2番目に渡す
        $this->assertEquals(['k' => ' a k b v c '], array_nmap(['k' => 'v'], strcat, [1 => 2], ' a ', ' b ', ' c '));
        // キーを2番目、値を1番目に渡す
        $this->assertEquals(['k' => ' a v b k c '], array_nmap(['k' => 'v'], strcat, [2 => 1], ' a ', ' b ', ' c '));
        // キーを1番目、値を1番目に渡す（キーが優先される）
        $this->assertEquals(['k' => ' a kv b  c '], array_nmap(['k' => 'v'], strcat, [1 => 1], ' a ', ' b ', ' c '));

        $this->assertException('empty', function () {
            array_nmap([], strcat, []);
        });
        $this->assertException('positive', function () {
            array_nmap([], strcat, [1 => -1]);
        });
        $this->assertException('positive', function () {
            array_nmap([], strcat, [-1 => 1]);
        });
    }

    function test_array_lmap()
    {
        // 最左に適用される
        $this->assertEquals(['1a--z', '2a--z'], array_lmap([1, 2], strcat, 'a-', '-z'));
    }

    function test_array_rmap()
    {
        // 最右に適用される
        $this->assertEquals(['a--z1', 'a--z2'], array_rmap([1, 2], strcat, 'a-', '-z'));
    }

    function test_array_depth()
    {
        // シンプル
        $this->assertEquals(1, array_depth([]));
        $this->assertEquals(1, array_depth(['X']));
        $this->assertEquals(2, array_depth([['X']]));
        $this->assertEquals(3, array_depth([[['X']]]));

        // 最大が得られるか？
        $this->assertEquals(2, array_depth(['X', 'y' => ['Y']]));
        $this->assertEquals(2, array_depth(['x' => ['X'], 'Y']));
        $this->assertEquals(3, array_depth(['x' => ['X'], 'y' => ['Y'], 'z' => ['z' => ['Z']]]));
    }

    function test_array_insert()
    {
        // 第3引数を省略すると最後に挿入される
        $this->assertEquals([1, 2, 3, 'x'], array_insert([1, 2, 3], 'x'));

        // 第3引数を指定するとその位置に挿入される
        $this->assertEquals([1, 'x', 2, 3], array_insert([1, 2, 3], 'x', 1));

        // 配列を指定するとその位置にマージされる
        $this->assertEquals([1, 'x1', 'x2', 2, 3], array_insert([1, 2, 3], ['x1', 'x2'], 1));

        // 負数を指定すると後ろから数えて挿入される
        $this->assertEquals([1, 2, 'x1', 'x2', 3], array_insert([1, 2, 3], ['x1', 'x2'], -1));

        // 連想配列もOK
        $this->assertEquals(['x' => 'X', 'x1', 'x2', 'y' => 'Y', 'z' => 'Z'], array_insert(['x' => 'X', 'y' => 'Y', 'z' => 'Z'], ['x1', 'x2'], 1));
    }

    function test_array_assort()
    {
        // 普通に使う
        $this->assertEquals([
            'none'  => [],
            'char1' => [0 => 'a'],
            'char2' => [1 => 'bb'],
            'char3' => [2 => 'ccc'],
        ], array_assort(['a', 'bb', 'ccc'], [
            'none'  => function ($v) { return strlen($v) === 0; },
            'char1' => function ($v) { return strlen($v) === 1; },
            'char2' => function ($v) { return strlen($v) === 2; },
            'char3' => function ($v) { return strlen($v) === 3; },
        ]));

        // 複数条件にマッチ
        $this->assertEquals([
            'rule1' => ['a', 'bb', 'ccc'],
            'rule2' => ['a', 'bb', 'ccc'],
        ], array_assort(['a', 'bb', 'ccc'], [
            'rule1' => function () { return true; },
            'rule2' => function () { return true; },
        ]));
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
        ], array_columns($array));

        $this->assertEquals([
            'name' => [1 => 'A', 2 => 'B', 3 => 'C'],
        ], array_columns($array, 'name', 'id'));

        $this->assertException('InvalidArgumentException', array_columns, []);
    }

    function test_array_uncolumns()
    {
        // 普通の配列
        $this->assertEquals([
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
        ], array_uncolumns([
            'id'   => [1, 2, 3],
            'name' => ['A', 'B', 'C'],
        ]));

        // キーも活きる
        $this->assertEquals([
            'x' => ['id' => 1, 'name' => 'A'],
            'y' => ['id' => 2, 'name' => 'B'],
            'z' => ['id' => 3, 'name' => 'C'],
        ], array_uncolumns([
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
        ], array_uncolumns([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ]));

        // null を与えると最初のキーで compat される
        $this->assertEquals([
            'x'  => ['id' => 1, 'name' => 'A'],
            'ya' => ['id' => 2, 'name' => null],
            'z'  => ['id' => 3, 'name' => null],
        ], array_uncolumns([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ], null));

        // [デフォルト] を与えるとその値で compat される
        $this->assertEquals([
            'x'   => ['id' => 1, 'name' => 'A'],
            'y'   => ['id' => null, 'name' => 'B'],
            'zzz' => ['id' => 999, 'name' => 999],
        ], array_uncolumns([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ], ['x' => null, 'y' => null, 'zzz' => 999]));
    }
}
