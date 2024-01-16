<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\array_add;
use function ryunosuke\Functions\Package\array_aggregate;
use function ryunosuke\Functions\Package\array_all;
use function ryunosuke\Functions\Package\array_any;
use function ryunosuke\Functions\Package\array_append;
use function ryunosuke\Functions\Package\array_assort;
use function ryunosuke\Functions\Package\array_columns;
use function ryunosuke\Functions\Package\array_convert;
use function ryunosuke\Functions\Package\array_count;
use function ryunosuke\Functions\Package\array_cross;
use function ryunosuke\Functions\Package\array_depth;
use function ryunosuke\Functions\Package\array_difference;
use function ryunosuke\Functions\Package\array_distinct;
use function ryunosuke\Functions\Package\array_dive;
use function ryunosuke\Functions\Package\array_each;
use function ryunosuke\Functions\Package\array_explode;
use function ryunosuke\Functions\Package\array_extend;
use function ryunosuke\Functions\Package\array_fill_callback;
use function ryunosuke\Functions\Package\array_fill_gap;
use function ryunosuke\Functions\Package\array_filter_key;
use function ryunosuke\Functions\Package\array_filter_map;
use function ryunosuke\Functions\Package\array_filters;
use function ryunosuke\Functions\Package\array_find;
use function ryunosuke\Functions\Package\array_find_last;
use function ryunosuke\Functions\Package\array_find_recursive;
use function ryunosuke\Functions\Package\array_flatten;
use function ryunosuke\Functions\Package\array_get;
use function ryunosuke\Functions\Package\array_grep_key;
use function ryunosuke\Functions\Package\array_group;
use function ryunosuke\Functions\Package\array_implode;
use function ryunosuke\Functions\Package\array_insert;
use function ryunosuke\Functions\Package\array_keys_exist;
use function ryunosuke\Functions\Package\array_kmap;
use function ryunosuke\Functions\Package\array_kvmap;
use function ryunosuke\Functions\Package\array_lmap;
use function ryunosuke\Functions\Package\array_lookup;
use function ryunosuke\Functions\Package\array_map_filter;
use function ryunosuke\Functions\Package\array_map_key;
use function ryunosuke\Functions\Package\array_map_method;
use function ryunosuke\Functions\Package\array_map_recursive;
use function ryunosuke\Functions\Package\array_maps;
use function ryunosuke\Functions\Package\array_merge2;
use function ryunosuke\Functions\Package\array_mix;
use function ryunosuke\Functions\Package\array_nest;
use function ryunosuke\Functions\Package\array_nmap;
use function ryunosuke\Functions\Package\array_of;
use function ryunosuke\Functions\Package\array_order;
use function ryunosuke\Functions\Package\array_pickup;
use function ryunosuke\Functions\Package\array_pos;
use function ryunosuke\Functions\Package\array_pos_key;
use function ryunosuke\Functions\Package\array_prepend;
use function ryunosuke\Functions\Package\array_put;
use function ryunosuke\Functions\Package\array_random;
use function ryunosuke\Functions\Package\array_range;
use function ryunosuke\Functions\Package\array_rank;
use function ryunosuke\Functions\Package\array_rekey;
use function ryunosuke\Functions\Package\array_remove;
use function ryunosuke\Functions\Package\array_revise;
use function ryunosuke\Functions\Package\array_rmap;
use function ryunosuke\Functions\Package\array_schema;
use function ryunosuke\Functions\Package\array_select;
use function ryunosuke\Functions\Package\array_set;
use function ryunosuke\Functions\Package\array_shrink_key;
use function ryunosuke\Functions\Package\array_shuffle;
use function ryunosuke\Functions\Package\array_sprintf;
use function ryunosuke\Functions\Package\array_strpad;
use function ryunosuke\Functions\Package\array_uncolumns;
use function ryunosuke\Functions\Package\array_unset;
use function ryunosuke\Functions\Package\array_where;
use function ryunosuke\Functions\Package\array_zip;
use function ryunosuke\Functions\Package\arrayize;
use function ryunosuke\Functions\Package\arrays;
use function ryunosuke\Functions\Package\attr_get;
use function ryunosuke\Functions\Package\first_key;
use function ryunosuke\Functions\Package\first_keyvalue;
use function ryunosuke\Functions\Package\first_value;
use function ryunosuke\Functions\Package\groupsort;
use function ryunosuke\Functions\Package\in_array_and;
use function ryunosuke\Functions\Package\in_array_or;
use function ryunosuke\Functions\Package\is_hasharray;
use function ryunosuke\Functions\Package\is_indexarray;
use function ryunosuke\Functions\Package\kvsort;
use function ryunosuke\Functions\Package\last_key;
use function ryunosuke\Functions\Package\last_keyvalue;
use function ryunosuke\Functions\Package\last_value;
use function ryunosuke\Functions\Package\lbind;
use function ryunosuke\Functions\Package\next_key;
use function ryunosuke\Functions\Package\not_func;
use function ryunosuke\Functions\Package\prev_key;
use function ryunosuke\Functions\Package\stdclass;

class arrayTest extends AbstractTestCase
{
    function test_array_add()
    {
        that(array_add(['a', 'b', 'c'], ['d']))->is(['a', 'b', 'c']);
        that(array_add(['a', 'b', 'c'], [3 => 'd']))->is(['a', 'b', 'c', 'd']);
        that(array_add(['a', 'b', 'c'], [3 => 'd'], [4 => 'e']))->is(['a', 'b', 'c', 'd', 'e']);
    }

    function test_array_aggregate()
    {
        that(array_aggregate([1, 2, 3, 4, 5], [
            'min' => fn($v) => min($v),
            'max' => fn($v) => max($v),
        ]))->isSame([
            'min' => 1,
            'max' => 5,
        ]);

        $row1 = ['id' => 1, 'group' => 'A', 'class' => 'H', 'score' => 2];
        $row2 = ['id' => 2, 'group' => 'B', 'class' => 'H', 'score' => 4];
        $row3 = ['id' => 3, 'group' => 'A', 'class' => 'L', 'score' => 3];
        $row4 = ['id' => 4, 'group' => 'A', 'class' => 'H', 'score' => 2];
        $array = [$row1, $row2, $row3, $row4];

        that(array_aggregate($array, [
            'ids'    => fn($rows) => array_column($rows, 'id'),
            'scores' => fn($rows) => array_sum(array_column($rows, 'score')),
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

        that(array_aggregate($array, [
            'scores' => fn($rows, $current) => array_column($rows, 'score'),
            'count'  => fn($rows, $current) => count($current['scores']),
            'sum'    => fn($rows, $current) => array_sum($current['scores']),
            'avg'    => fn($rows, $current) => $current['sum'] / $current['count'],
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

        that(array_aggregate($array, [
            'ids'    => fn($rows) => array_column($rows, 'id'),
            'scores' => fn($rows) => array_sum(array_column($rows, 'score')),
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

        that(array_aggregate($array, [
            'ids'    => fn($rows) => array_column($rows, 'id'),
            'scores' => fn($rows) => array_sum(array_column($rows, 'score')),
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

        that(array_aggregate($array, [
            'ids'    => fn($rows) => array_column($rows, 'id'),
            'scores' => fn($rows) => array_sum(array_column($rows, 'score')),
        ], fn($row) => $row['group'] . '/' . $row['class']))->is([
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

        that(array_aggregate($array, fn($rows) => array_sum(array_column($rows, 'score')), fn($row) => $row['group'] . '/' . $row['class']))->is([
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

        that(array_all([], null))->isTrue();
        that(array_all([], null, false))->isFalse();

        that(array_all([true, true]))->isTrue();
        that(array_all([true, false]))->isFalse();
        that(array_all([false, false]))->isFalse();

        that(array_all($array, fn($v) => $v['id']))->isTrue();
        that(array_all($array, fn($v) => $v['flag']))->isFalse();
        that(array_all($array, fn($v) => $v['name']))->isFalse();
        that(array_all($array, fn($v, $k) => $k && $v['flag']))->isFalse();
    }

    function test_array_any()
    {
        $array = [
            0 => ['id' => 1, 'name' => '', 'flag' => false],
            1 => ['id' => 2, 'name' => '', 'flag' => true],
            2 => ['id' => 3, 'name' => '', 'flag' => false],
        ];

        that(array_any([], null))->isFalse();
        that(array_any([], null, true))->isTrue();

        that(array_any([true, true]))->isTrue();
        that(array_any([true, false]))->isTrue();
        that(array_any([false, false]))->isFalse();

        that(array_any($array, fn($v) => $v['id']))->isTrue();
        that(array_any($array, fn($v) => $v['flag']))->isTrue();
        that(array_any($array, fn($v) => $v['name']))->isFalse();
        that(array_any($array, fn($v, $k) => $k && $v['flag']))->isTrue();
    }

    function test_array_append()
    {
        that(array_append(['a', 'b', 'c'], 'X'))->isSame(['a', 'b', 'c', 'X']);
        that(array_append(['a', 'b', 'c'], 'X', 9))->isSame(['a', 'b', 'c', 9 => 'X']);
        that(array_append(['a', 'b', 'c'], 'X', 'key'))->isSame(['a', 'b', 'c', 'key' => 'X']);

        that(array_append(['a' => 'A', 'b' => 'B', 'c'], 'X'))->isSame(['a' => 'A', 'b' => 'B', 'c', 'X']);
        that(array_append(['a' => 'A', 'b' => 'B', 'c'], 'X', 9))->isSame(['a' => 'A', 'b' => 'B', 'c', 9 => 'X']);
        that(array_append(['a' => 'A', 'b' => 'B', 'c'], 'X', 'key'))->isSame(['a' => 'A', 'b' => 'B', 'c', 'key' => 'X']);
        that(array_append(['a' => 'A', 'b' => 'B', 'c'], 'X', 'a'))->isSame(['b' => 'B', 'c', 'a' => 'X']);
    }

    function test_array_assort()
    {
        // 普通に使う
        that(array_assort(['a', 'bb', 'ccc'], [
            'none'  => fn($v) => strlen($v) === 0,
            'char1' => fn($v) => strlen($v) === 1,
            'char2' => fn($v) => strlen($v) === 2,
            'char3' => fn($v) => strlen($v) === 3,
        ]))->is([
            'none'  => [],
            'char1' => [0 => 'a'],
            'char2' => [1 => 'bb'],
            'char3' => [2 => 'ccc'],
        ]);

        // 複数条件にマッチ
        that(array_assort(['a', 'bb', 'ccc'], [
            'rule1' => fn() => true,
            'rule2' => fn() => true,
        ]))->is([
            'rule1' => ['a', 'bb', 'ccc'],
            'rule2' => ['a', 'bb', 'ccc'],
        ]);
    }

    function test_array_columns()
    {
        $array = [
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
        ];

        that(array_columns($array))->is([
            'id'   => [1, 2, 3],
            'name' => ['A', 'B', 'C'],
        ]);

        that(array_columns($array, 'name', 'id'))->is([
            'name' => [1 => 'A', 2 => 'B', 3 => 'C'],
        ]);

        that(self::resolveFunction('array_columns'))([])->wasThrown('InvalidArgumentException');
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
        that(array_convert($array, function ($k, &$v) {
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
        that(array_convert($array, fn($k, $v) => in_array($k, ['k21', 'k222']) ? false : null))->is([
            'k1' => 'v1',
            'k2' => [
                'k22' => [
                    'k221' => 'v221',
                ],
            ],
        ]);

        // キー 'k21', 'k221', 'k222' を取り除く
        that(array_convert($array, fn($k, $v) => in_array($k, ['k21', 'k221', 'k222']) ? false : null))->is([
            'k1' => 'v1',
            'k2' => [
                'k22' => [],
            ],
        ]);

        // キー 'k22' を取り除く
        that(array_convert($array, fn($k, $v) => in_array($k, ['k22']) ? false : null, true))->is([
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
            ],
        ]);

        // キー 'k22' に要素を生やす
        that(array_convert($array, function ($k, &$v) {
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
        that(array_convert($array, function ($k, &$v) {
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
        array_convert($array, function ($k, $v, $history) {
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

    function test_array_convert_array()
    {
        $array = [
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
                'k22' => 123,
            ],
        ];
        that(array_convert($array, fn($k, $v) => $k === 'k22' ? [1, 2, 3] : null))->is([
            'k1' => 'v1',
            'k2' => [
                'k21' => 'v21',
                1,
                2,
                3,
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
        that(array_convert($array, fn($k) => $k === 'k1' ? true : null))->is([
            'k2' => [
                'v21',
                'k22' => ['v221', 'v222'],
            ],
            9    => 'v2',
            10   => 'v1',
        ]);

        // 値 v221 を数値連番にする
        that(array_convert($array, fn($k, $v) => $v === 'v221' ? true : null))->is([
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
        that(array_convert($array, fn($k, $v) => true, true))->is([
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

    function test_array_count()
    {
        $array = ['a', 'b', 'c'];

        // 普通に使う分には count(array_filter()) と同じ
        $eq_b = fn($v) => $v === 'b';
        that(array_count($array, $eq_b))->is(count(array_filter($array, $eq_b)));

        $row1 = ['id' => 1, 'group' => 'A', 'flag' => false];
        $row2 = ['id' => 2, 'group' => 'B', 'flag' => true];
        $row3 = ['id' => 3, 'group' => 'B', 'flag' => false];
        $array = [
            'k1' => $row1,
            'k2' => $row2,
            3    => $row3,
        ];

        // flag をカウント
        that(array_count($array, array_of('flag')))->is(1);
        that(array_count($array, not_func(array_of('flag'))))->is(2);

        // group: 'B' をカウント。ただし、数値キーの場合のみ
        that(array_count($array, fn($v, $k) => is_int($k) && $v['group'] === 'B'))->is(1);

        // group: 'A', 'B' をそれぞれカウント
        that(array_count($array, [
            'A' => fn($v) => $v['group'] === 'A',
            'B' => fn($v) => $v['group'] === 'B',
        ]))->is([
            'A' => 1,
            'B' => 2,
        ]);

        // 再帰
        $array = [
            ['1', '2', '3'],
            ['a', 'b', 'c'],
            ['X', 'Y', 'Z'],
            [[[['a', 'M', 'Z']]]],
        ];
        $islower = fn($v) => !is_array($v) && ctype_lower($v);
        $isupper = fn($v) => !is_array($v) && ctype_upper($v);
        $isarray = fn($v) => is_array($v);
        that(array_count($array, $islower, true))->is(4);
        that(array_count($array, $isupper, true))->is(5);
        that(array_count($array, $isarray, true))->is(7);
        that(array_count($array, [
            'lower' => $islower,
            'upper' => $isupper,
            'array' => $isarray,
        ], true))->is([
            'lower' => 4,
            'upper' => 5,
            'array' => 7,
        ]);
    }

    function test_array_cross()
    {
        that(array_cross())->isSame([]);
        that(array_cross([]))->isSame([]);
        that(array_cross([], []))->isSame([]);

        that(array_cross([1, 2]))->isSame([[1], [2]]);
        that(array_cross([1, 2], [3, 4]))->isSame([[1, 3], [1, 4], [2, 3], [2, 4]]);
        that(array_cross([1, 2], [3, 4], [5, 6]))->isSame([[1, 3, 5], [1, 3, 6], [1, 4, 5], [1, 4, 6], [2, 3, 5], [2, 3, 6], [2, 4, 5], [2, 4, 6]]);

        that(array_cross(['a' => 'A', 'b' => 'B']))->isSame([['a' => 'A'], ['b' => 'B']]);
        that(array_cross(['a' => 'A', 'b' => 'B'], ['c' => 'C', 'd' => 'D']))->isSame([['a' => 'A', 'c' => 'C'], ['a' => 'A', 'd' => 'D'], ['b' => 'B', 'c' => 'C'], ['b' => 'B', 'd' => 'D']]);

        that(array_cross(['A', 'b' => 'B'], ['c' => 'C', 'D']))->isSame([['A', 'c' => 'C'], ['A', 'D'], ['b' => 'B', 'c' => 'C'], ['b' => 'B', 'D']]);

        that(self::resolveFunction('array_cross'))(['a' => 'A', 'B'], ['C', 'a' => 'D'])->wasThrown('duplicated key');
    }

    function test_array_depth()
    {
        // シンプル
        that(array_depth([]))->is(1);
        that(array_depth(['X']))->is(1);
        that(array_depth([['X']]))->is(2);
        that(array_depth([[['X']]]))->is(3);

        // 最大が得られるか？
        that(array_depth(['X', 'y' => ['Y']]))->is(2);
        that(array_depth(['x' => ['X'], 'Y']))->is(2);
        that(array_depth(['x' => ['X'], 'y' => ['Y'], 'z' => ['z' => ['Z']]]))->is(3);

        // $max_depth 指定
        that(array_depth([[[[['X']]]]], 1))->is(1);
        that(array_depth([[[[['X']]]]], 2))->is(2);
        that(array_depth([[[[['X']]]]], 3))->is(3);
        that(array_depth([[[[['X']]]]], 4))->is(4);
        that(array_depth([[[[['X']]]]], 5))->is(5);
        that(array_depth([[[[['X']]]]], 6))->is(5);
        that(array_depth([
            ['X'],
            [['X']],
            [[['X']]],
            [[[['X']]]],
            [[[[['X']]]]],
            [[[[[['X']]]]]],
        ], 3))->is(3);
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
        that(array_difference($a1, $a2))->is([
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

    function test_array_distinct()
    {
        // シンプルなもの
        that(array_distinct([]))->isSame([]);
        that(array_distinct([1]))->isSame([1]);
        that(array_distinct([1, '2', 2, 3, '3']))->isSame([1, '2', 3 => 3]);
        that(array_distinct([1, 2, 2, 3, 3, 3], SORT_NUMERIC))->isSame([1, 2, 3 => 3]);
        that(array_distinct(['a', 'A'], SORT_STRING))->isSame(['a', 'A']);
        that(array_distinct(['a', 'A'], SORT_STRING | SORT_FLAG_CASE))->isSame(['a']);

        // クロージャを与える
        that(array_distinct([1, 2, -2, 3, -3], fn($a, $b) => abs($a) <=> abs($b)))->is([1, 2, 3 => 3]);

        // 配列の配列
        /** @noinspection PhpUnusedLocalVariableInspection */
        $rows = [
            11 => $r1 = ['id' => 1, 'group1' => 'groupA', 'group2' => 'groupA'],
            12 => $r2 = ['id' => 2, 'group1' => 'groupB', 'group2' => 'groupB'],
            13 => $r3 = ['id' => 3, 'group1' => 'groupA', 'group2' => 'groupB'],
            14 => $r4 = ['id' => 4, 'group1' => 'groupA', 'group2' => 'groupB'],
        ];
        that(array_distinct($rows, 'group1'))->is([
            11 => $r1,
            12 => $r2,
        ]);
        that(array_distinct($rows, ['group1', 'group2']))->is([
            11 => $r1,
            12 => $r2,
            13 => $r3,
        ]);

        /** @noinspection PhpUnusedLocalVariableInspection */
        $objects = [
            11 => $e1 = new \Exception('a', 1),
            12 => $e2 = new \Exception('b', 2),
            13 => $e3 = new \Exception('b', 3),
            14 => $e4 = new \Exception('b', 3),
        ];
        that(array_distinct($objects, ['getMessage' => []]))->is([
            11 => $e1,
            12 => $e2,
        ]);
        that(array_distinct($objects, ['getMessage' => [], 'getCode' => []]))->is([
            11 => $e1,
            12 => $e2,
            13 => $e3,
        ]);
    }

    function test_array_dive()
    {
        $array = ['a' => ['b' => ['c' => 'vvv']]];
        that(array_dive($array, 'a.b.c'))->is('vvv');
        that(array_dive($array, 'a.b.x', 9))->is(9);
        that(array_dive($array, ['a', 'b', 'c']))->is('vvv');
        that(array_dive($array, 'a.b.c.x'))->isNull();

        // Arrayable でも動作する
        $ao = new \Arrayable(['a' => ['b' => ['c' => 'vvv']]]);
        that(array_dive($ao, 'a.b.c'))->is('vvv');
        that(array_dive($ao, 'a.b.x', 9))->is(9);
        that(array_dive($ao, ['a', 'b', 'c']))->is('vvv');
    }

    function test_array_each()
    {
        that(array_each([1, 2, 3, 4, 5], function (&$carry, $v) { $carry .= $v; }, ''))->isSame('12345');
        that(array_each([1, 2, 3, 4, 5], function (&$carry, $v) { $carry[$v] = $v * $v; }, []))->isSame([
            1 => 1,
            2 => 4,
            3 => 9,
            4 => 16,
            5 => 25,
        ]);
        $receiver = [];
        that(array_each([1, 2, 3, 4, 5], function (&$carry, $v, $k, $n) use (&$receiver) {
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
        that(array_each([$ex_a, $ex_b, $ex_c], function (&$carry, \Exception $ex) {
            $carry[$ex->getMessage()] = $ex;
        }))->isSame(['a' => $ex_a, 'b' => $ex_b, 'c' => $ex_c]);

        // 推奨しないが見た目が気に入っている使い方
        that(array_each([1, 2, 3], function (&$carry = 'start', $v = null) { $carry .= $v; }))->isSame('start123');
        that(array_each([], function (&$carry = 'start', $v = null) { $carry .= $v; }))->isSame('start');
        that(array_each([], function (&$carry, $v) { $carry .= $v; }))->isSame(null);
    }

    function test_array_explode()
    {
        that(array_explode([], '|'))->is([[]]);
        that(array_explode(['a', '|', 'b', 'c'], '|'))->is([['a'], [2 => 'b', 3 => 'c']]);
        that(array_explode(['|', 'a', '|', '|'], '|'))->is([[], [1 => 'a'], [], []]);

        that(array_explode([null, null, null, null], null, 3))->is([[], [], [2 => null, 3 => null]]);

        that(array_explode(['a', '|', 'b', '|', 'c'], '|', 0))->is([['a', '|', 'b', '|', 'c']]);
        that(array_explode(['a', '|', 'b', '|', 'c'], '|', 1))->is([['a', '|', 'b', '|', 'c']]);
        that(array_explode(['a', '|', 'b', '|', 'c'], '|', 2))->is([['a'], [2 => 'b', 3 => '|', 4 => 'c']]);
        that(array_explode(['a', '|', 'b', '|', 'c'], '|', 3))->is([['a'], [2 => 'b'], [4 => 'c']]);
        that(array_explode(['a', '|', 'b', '|', 'c'], '|', 4))->is([['a'], [2 => 'b'], [4 => 'c']]);

        that(array_explode(['a', null, 'b', null, 'c'], null, 1))->is([
            [
                0 => 'a',
                1 => null,
                2 => 'b',
                3 => null,
                4 => 'c',
            ],
        ]);
        that(array_explode(['a', null, 'b', null, 'c'], null, 2))->is([
            [0 => 'a'],
            [
                2 => 'b',
                3 => null,
                4 => 'c',
            ],
        ]);
        that(array_explode(['a', null, 'b', null, 'c'], null, 3))->is([
            [0 => 'a'],
            [2 => 'b'],
            [
                4 => 'c',
            ],
        ]);
        that(array_explode(['a', null, 'b', null, 'c'], null, 4))->is([
            [0 => 'a'],
            [2 => 'b'],
            [
                4 => 'c',
            ],
        ]);

        that(array_explode(['a', null, 'b', null, 'c'], null, -1))->is([
            [
                0 => 'a',
                1 => null,
                2 => 'b',
                3 => null,
                4 => 'c',
            ],
        ]);
        that(array_explode(['a', null, 'b', null, 'c'], null, -2))->is([
            [
                0 => 'a',
                1 => null,
                2 => 'b',
            ],
            [
                4 => 'c',
            ],
        ]);
        that(array_explode(['a', null, 'b', null, 'c'], null, -3))->is([
            [0 => 'a'],
            [2 => 'b'],
            [
                4 => 'c',
            ],
        ]);
        that(array_explode(['a', null, 'b', null, 'c'], null, -4))->is([
            [0 => 'a'],
            [2 => 'b'],
            [
                4 => 'c',
            ],
        ]);

        /** @noinspection PhpUnusedLocalVariableInspection */
        $rows = [
            1 => $r1 = ['id' => 1, 'name' => 'A'],
            2 => $r2 = ['id' => 2, 'name' => 'B'],
            3 => $r3 = ['id' => 3, 'name' => 'C'],
            4 => $r4 = ['id' => 4, 'name' => 'D'],
        ];
        that(array_explode($rows, fn($v, $k) => $k === 3 && $v['name'] === 'C'))->is([[1 => $r1, 2 => $r2], [4 => $r4]]);
    }

    function test_array_extend()
    {
        $default = [
            'k1'     => 1,
            'k2'     => 2,
            'k3'     => [3],
            'list'   => ['a', 'b', 'c'],
            'hash'   => ['a' => 'A', 'b' => 'B', 'c' => 'C'],
            'array'  => ['a' => 'A', 'a', 'b', 'b' => 'B',],
            'yield'  => function () { yield 123; },
            'yields' => [function () { yield 123; }],
        ];

        that(array_extend($default))->is([
            'k1'     => 1,
            'k2'     => 2,
            'k3'     => [3],
            'list'   => ['a', 'b', 'c'],
            'hash'   => ['a' => 'A', 'b' => 'B', 'c' => 'C'],
            'array'  => ['a' => 'A', 'a', 'b', 'b' => 'B',],
            'yield'  => 123,
            'yields' => [function () { yield 123; }],
        ]);

        that(array_extend(false, $default, [
            'ignore' => 'X',
            'k2'     => [2],
            'k3'     => 9,
            'list'   => ['x', 'y', 'z'],
            'hash'   => ['x' => 'X', 'y' => 'Y', 'z' => 'Z'],
            'array'  => ['x' => 'X', 'x', 'y', 'Y' => 'Y',],
            'yield'  => function () { yield 456; },
            'yields' => [456],
        ]))->is([
            'k1'     => 1,
            'k2'     => [2],
            'k3'     => 9,
            'list'   => ['x', 'y', 'z'],
            'hash'   => ['x' => 'X', 'y' => 'Y', 'z' => 'Z'],
            'array'  => ['x' => 'X', 'x', 'y', 'Y' => 'Y',],
            'yield'  => 456,
            'yields' => [456],
        ]);

        that(array_extend(true, $default, [
            'ignore' => 'X',
            'k2'     => [2],
            'k3'     => 8,
            'list'   => ['x', 'y', 'z'],
            'hash'   => function ($value) {
                return $value + ['x' => 'X', 'y' => 'Y', 'z' => 'Z'];
            },
            'array'  => ['x' => 'X', 'x', 'y', 'Y' => 'Y',],
            'yield'  => function () { yield $this->fail("shouldn't be called"); },
            'yields' => [function () { yield 456; }],
        ], [
            'yield'  => function () { yield 789; },
            'yields' => [function () { yield 789; }],
        ], function ($value) {
            yield 'k2' => 3;
            yield 'k3' => 9;
        }))->is([
            'k1'     => 1,
            'k2'     => [2, 3],
            'k3'     => [3, 8, 9],
            'list'   => ['a', 'b', 'c', 'x', 'y', 'z'],
            'hash'   => ['a' => 'A', 'b' => 'B', 'c' => 'C', 'x' => 'X', 'y' => 'Y', 'z' => 'Z'],
            'array'  => ['a' => 'A', 'x', 'y', 'b' => 'B',],
            'yield'  => 789,
            'yields' => [123, 456, 789],
        ]);

        that(self::resolveFunction('array_extend'))(true)->wasThrown('target is empry');
        that(self::resolveFunction('array_extend'))([], '')->wasThrown('target is not array');
    }

    function test_array_fill_callback()
    {
        that(array_fill_callback(['a', 'b', 'c'], 'strtoupper'))->isSame(array_combine($keys = ['a', 'b', 'c'], array_map('strtoupper', $keys)));
    }

    function test_array_fill_gap()
    {
        that(array_fill_gap(['a', 'b', 'c'], 'd', 'e'))->isSame(['a', 'b', 'c', 'd', 'e']);
        that(array_fill_gap(['a', 'b', 3 => 'd'], 'c', 'e'))->isSame(['a', 'b', 'c', 'd', 'e']);
        that(array_fill_gap([1 => 'b', 3 => 'd'], 'a', 'c', 'e'))->isSame(['a', 'b', 'c', 'd', 'e']);
        that(array_fill_gap([], 'a', 'b', 'c', 'd', 'e'))->isSame(['a', 'b', 'c', 'd', 'e']);
        that(array_fill_gap(['a', 'b', 'c', 'd', 'e']))->isSame(['a', 'b', 'c', 'd', 'e']);
        that(array_fill_gap(['a', 'x' => 'Noise', 'b', 'y' => 'Noise', 3 => 'd', 'z' => 'Noise'], 'c', 'e'))->isSame(['a', 'x' => 'Noise', 'b', 'y' => 'Noise', 'c', 'd', 'z' => 'Noise', 'e']);
        that(array_fill_gap(['a', 4 => 'e'], 'b', 'c'))->isSame(['a', 'b', 'c', 4 => 'e']);
        that(array_fill_gap(array_fill_gap(['a', 4 => 'e'], 'b', 'c'), 'd'))->isSame(['a', 'b', 'c', 'd', 'e']);
    }

    function test_array_filter_key()
    {
        that(array_filter_key(['a' => 'A', 'b' => 'B', 'X'], fn($v) => ctype_alpha("$v")))->is(['a' => 'A', 'b' => 'B']);
        that(array_filter_key(['a', 'b', 'c'], fn($k, $v) => $k === 1))->is([1 => 'b']);
        that(array_filter_key(['a', 'b', 'c'], fn($k, $v) => $v === "b"))->is([1 => 'b']);
        that(array_filter_key(['a', 'b', 'c'], fn($k, $v) => $v !== "b"))->is(['a', 2 => 'c']);
    }

    function test_array_filter_map()
    {
        // 値を2乗して奇数だけを取り出す
        that(array_filter_map([1, 2, 3, 4, 5], function (&$v) {
            $v = $v ** 2;
            return $v % 2 === 1;
        }))->is([0 => 1, 2 => 9, 4 => 25]);

        // 値が奇数だったら2乗して返す
        that(array_filter_map([1, 2, 3, 4, 5], function (&$v) {
            if ($v % 2 === 0) {
                return false;
            }
            $v = $v ** 2;
        }))->is([0 => 1, 2 => 9, 4 => 25]);

        // prefix とキーを付与して返す。ただし null は除外する
        that(array_filter_map([null, 'hoge', 'fuga', null, 'piyo'], fn(&$v, $k) => $v !== null ? $v = "prefix-$k:$v" : false))->is([1 => 'prefix-1:hoge', 2 => 'prefix-2:fuga', 4 => 'prefix-4:piyo']);
    }

    function test_array_filters()
    {
        function is_not_null(...$args)
        {
            foreach ($args as $arg) {
                if ($arg === null) {
                    return false;
                }
            }
            return true;
        }

        // 'C' は ctype_lower, 'f' => 'f' は is_int, 'x' は ctype_xdigit で除去され、 'a', 'b' が残る
        that(array_filters(['a', 'b', 'C', 'f' => 'f', 'x'], fn($v, $k) => is_int($k), 'ctype_lower', 'ctype_xdigit'))->is(['a', 'b']);

        // 可変引数モード
        that(array_filters([[null], [1, null], [1, 2]], '...' . __NAMESPACE__ . "\\is_not_null"))->isSame([2 => [1, 2]]);

        // メソッドモード
        $ex0 = new \Exception('msg0', 0);
        $ex1 = new \Exception('', 1);
        $ex2 = new \Exception('msg2', 2);
        that(array_filters([$ex0, $ex1, $ex2], '@getCode'))->isSame([1 => $ex1, 2 => $ex2]);
        that(array_filters([$ex0, $ex1, $ex2], '@getCode', '@getMessage'))->is([2 => $ex2]);

        $obj0 = new \Concrete(null);
        $obj1 = new \Concrete('');
        $obj2 = new \Concrete('hoge');
        that(array_filters([$obj0, $obj1, $obj2], ['getName' => ['p-']]))->isSame([1 => $obj1, 2 => $obj2]);
        that(array_filters(new \ArrayObject([$obj0, $obj1, $obj2]), ['getName' => ['p-']]))->isSame([1 => $obj1, 2 => $obj2]);
    }

    function test_array_find()
    {
        that(array_find(['a', 'b', '9'], 'ctype_digit'))->is(2);
        that(array_find(['a' => 'A', 'b' => 'B'], fn($v) => $v === 'B'))->is('b');
        that(array_find(['9', 'b', 'c'], 'ctype_digit'))->isSame(0);
        that(array_find(['a', 'b', 'c'], fn($v) => null))->isSame(false);

        that(array_find(['a', 'b', '9'], fn($v) => ctype_digit($v) ? false : strtoupper($v), false))->is('A');
        that(array_find(['9', 'b', 'c'], fn($v) => ctype_digit($v) ? false : strtoupper($v), false))->is('B');
        that(array_find([1, 2, 3, 4, -5, -6], fn($v) => $v < 0 ? abs($v) : false, false))->is(5);
    }

    function test_array_find_last()
    {
        that(array_find_last(['a', '8', '9'], 'ctype_digit'))->is(2);

        that(array_find_last(new \ArrayIterator(['a', '8', '9']), 'ctype_digit'))->is(2);
        that(array_find_last(new \ArrayIterator(['a' => 'A', 'b1' => 'B', 'b2' => 'B']), fn($v) => $v === 'B'))->is('b2');
        that(array_find_last(new \ArrayIterator(['8', '9', 'c']), 'ctype_digit'))->isSame(1);
        that(array_find_last(new \ArrayIterator(['a', 'b', 'c']), fn($v) => null))->isSame(false);

        that(array_find_last(new \ArrayIterator(['a', 'b', '9']), fn($v) => ctype_digit($v) ? false : strtoupper($v), false))->is('B');
        that(array_find_last(new \ArrayIterator(['9', 'b', 'c']), fn($v) => ctype_digit($v) ? false : strtoupper($v), false))->is('C');
        that(array_find_last(new \ArrayIterator([1, 2, 3, 4, -5, -6]), fn($v) => $v < 0 ? abs($v) : false, false))->is(6);
    }

    function test_array_find_recursive()
    {
        $abc = [
            'a' => [
                'b' => [
                    'c' => [1, 2, 3],
                ],
            ],
        ];
        $xyz = [
            'x' => [
                'y' => [
                    'z' => [1, 2, 3],
                ],
            ],
        ];
        $abc['xyz'] = &$xyz;
        $xyz['abc'] = &$abc;

        $array = [
            'abc' => $abc,
            'xyz' => $xyz,
        ];
        that(array_find_recursive($array, fn($v) => $v === 2, false))->is(true);
        that(array_find_recursive($array, fn($v) => $v === 2, true))->is(['abc', 'a', 'b', 'c', 1]);
        that(array_find_recursive($array, fn($v) => $v === [1, 2, 3], true))->is(['abc', 'a', 'b', 'c']);
        that(array_find_recursive($array, fn($v) => $v === [1, 2, 9], true))->is(false);
        that(array_find_recursive($array, fn($v) => $v === $xyz, true))->is(['abc', 'xyz']);

        $array = [
            'xyz' => $xyz,
            'abc' => $abc,
        ];
        that(array_find_recursive($array, fn($v) => $v === 2, false))->is(true);
        that(array_find_recursive($array, fn($v) => $v === 2, true))->is(['xyz', 'x', 'y', 'z', 1]);
        that(array_find_recursive($array, fn($v) => $v === [1, 2, 3], true))->is(['xyz', 'x', 'y', 'z']);
        that(array_find_recursive($array, fn($v) => $v === [1, 2, 9], true))->is(false);
        that(array_find_recursive($array, fn($v) => $v === $abc, true))->is(['xyz', 'abc']);
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
        that(array_flatten($array))->isSame([
            'v1',
            'v21',
            123,
            1,
            2,
            3,
            $o,
        ]);

        // 区切り文字指定
        that(array_flatten($array, '.'))->isSame([
            'k1'       => 'v1',
            'k2.k21'   => 'v21',
            'k2.k22'   => 123,
            'k2.k23.0' => 1,
            'k2.k23.1' => 2,
            'k2.k23.2' => 3,
            'o'        => $o,
        ]);

        // クロージャ指定
        that(array_flatten($array, fn($keys) => implode('.', $keys)))->isSame([
            'k1'       => 'v1',
            'k2.k21'   => 'v21',
            'k2.k22'   => 123,
            'k2.k23.0' => 1,
            'k2.k23.1' => 2,
            'k2.k23.2' => 3,
            'o'        => $o,
        ]);
        that(array_flatten($array, fn($keys) => array_shift($keys) . ($keys ? '[' . implode('][', $keys) . ']' : '')))->isSame([
            'k1'         => 'v1',
            'k2[k21]'    => 'v21',
            'k2[k22]'    => 123,
            'k2[k23][0]' => 1,
            'k2[k23][1]' => 2,
            'k2[k23][2]' => 3,
            'o'          => $o,
        ]);

        // Generator
        that(array_flatten((function () {
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

    function test_array_get()
    {
        that(array_get(['a', 'b', 'c'], 1))->is('b');
        that(array_get(['a', 'b', 'c'], 9, 999))->is(999);

        that(array_get(['a', 'b', 'c'], [0, 2]))->is([0 => 'a', 2 => 'c']);
        that(array_get(['a', 'b', 'c'], [0, 9]))->is([0 => 'a']);
        that(array_get(['a', 'b', 'c'], [9]))->is([]);
        that(array_get(['a', 'b', 'c'], [9], null))->is(null);

        // 配列を与えたときの順番は指定したものを優先
        that(array_get(['a', 'b', 'c'], [2, 1, 0]))->is([2 => 'c', 1 => 'b', 0 => 'a']);

        // Arrayable でも動作する
        $ao = new \Arrayable(['a', 'b', 'c']);
        that(array_get($ao, 1))->is('b');
        that(array_get($ao, [2, 1, 0]))->is([2 => 'c', 1 => 'b', 0 => 'a']);

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
        that(array_get($array, fn($v, $k) => !is_int($k), []))->is([
            'key1' => 'value1',
            'key2' => 'value2',
        ]);

        // キーが数値のものを抽出
        that(array_get($array, fn($v, $k) => is_int($k), []))->is([
            0   => 'first',
            1   => 'second',
            2   => 'third',
            99  => 99,
            100 => 100,
            101 => 101,
        ]);

        // 単値モード
        that(array_get($array, fn($v, $k) => is_int($k)))->is('first');

        // 値がオブジェクトのものを抽出（そんなものはない）
        that(array_get($array, fn($v, $k) => is_object($v)))->is(null);
    }

    function test_array_grep_key()
    {
        that(array_grep_key(['a', 'b', 'c'], '#\d#'))->is(['a', 'b', 'c']);
        that(array_grep_key(['hoge' => 'HOGE', 'fuga' => 'FUGA'], '#^h#'))->is(['hoge' => 'HOGE']);
        that(array_grep_key(['hoge' => 'HOGE', 'fuga' => 'FUGA'], '#^h#', true))->is(['fuga' => 'FUGA']);
    }

    function test_array_group()
    {
        that(array_group([1, 2, 3, 4, 5]))->is([
            1 => [1],
            2 => [2],
            3 => [3],
            4 => [4],
            5 => [5],
        ]);

        that(array_group([1, 2, 3, 4, 5], fn($v) => $v % 2))->is([
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

        that(array_group($array, 'group'))->is(['A' => ['k1' => $row1, 0 => $row3], 'B' => ['k2' => $row2]]);
        that(array_group($array, 'group', true))->is(['A' => ['k1' => $row1, 3 => $row3], 'B' => ['k2' => $row2]]);

        that(array_group([$row1, $row2, $row3], ['group', 'id']))->is([
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

    function test_array_implode()
    {
        that(array_implode(['a', 'b', 'c'], ','))->is(['a', ',', 'b', ',', 'c']);
        that(array_implode(',', 'a', 'b', 'c'))->is(['a', ',', 'b', ',', 'c']);
        that(array_implode(['a' => 'A', 'b' => 'B', 'c' => 'C'], ','))->is(['a' => 'A', ',', 'b' => 'B', ',', 'c' => 'C']);
        that(array_implode([1 => 'a', 0 => 'b', 2 => 'c'], ','))->is(['a', ',', 'b', ',', 'c']);
    }

    function test_array_insert()
    {
        // 第3引数を省略すると最後に挿入される
        that(array_insert([1, 2, 3], 'x'))->is([1, 2, 3, 'x']);

        // 第3引数を指定するとその位置に挿入される
        that(array_insert([1, 2, 3], 'x', 1))->is([1, 'x', 2, 3]);

        // 配列を指定するとその位置にマージされる
        that(array_insert([1, 2, 3], ['x1', 'x2'], 1))->is([1, 'x1', 'x2', 2, 3]);

        // 負数を指定すると後ろから数えて挿入される
        that(array_insert([1, 2, 3], ['x1', 'x2'], -1))->is([1, 2, 'x1', 'x2', 3]);

        // 連想配列もOK
        that(array_insert(['x' => 'X', 'y' => 'Y', 'z' => 'Z'], ['x1', 'n' => 'x2'], 1))->is(['x' => 'X', 'x1', 'n' => 'x2', 'y' => 'Y', 'z' => 'Z']);
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
            ],
        ];
        // すべて含む
        that(array_keys_exist(['a', 'b', 'c'], $array))->isTrue();
        // 単一文字指定で含む
        that(array_keys_exist('a', $array))->isTrue();
        // 1つ含まない
        that(array_keys_exist(['a', 'b', 'n'], $array))->isFalse();
        // 単一文字指定で含まない
        that(array_keys_exist('X', $array))->isFalse();
        // 空は例外
        that(self::resolveFunction('array_keys_exist'))([], $array)->wasThrown('empty');

        // ネスト調査
        that(array_keys_exist([
            'x' => ['x1', 'x2', 'y'],
        ], $array))->isTrue();
        that(array_keys_exist([
            'x' => [
                'x1',
                'x2',
                'y' => [
                    'y1',
                    'y2',
                ],
            ],
        ], $array))->isTrue();
        that(array_keys_exist([
            'nx' => ['x1', 'x2', 'y'],
        ], $array))->isFalse();
        that(array_keys_exist([
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
        that(array_keys_exist('null', $array))->isTrue();
        that(array_keys_exist(['x' => ['y']], $array))->isTrue();
        that(array_keys_exist(['x' => ['y']], $array))->isTrue();
        that(array_keys_exist(['nx'], $array))->isFalse();
        that(array_keys_exist(['nx' => ['y']], $array))->isFalse();
    }

    function test_array_kmap()
    {
        $array = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ];
        that(array_kmap($array, fn($v, $k, $n) => "$n:$k-$v"))->is([
            'k1' => '0:k1-v1',
            'k2' => '1:k2-v2',
            'k3' => '2:k3-v3',
        ]);
    }

    function test_array_kvmap()
    {
        that(array_kvmap(['a' => 'A', 'b' => 'B', 'c' => 'C'], function ($k, $v) {
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

        that(array_kvmap(['a', 'b', 'c'], function ($k, $v) {
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

        that(array_kvmap([
            'x' => [
                'X',
                'y' => [
                    'Y',
                    'z' => ['Z'],
                ],
            ],
        ], function ($k, $v, $callback) {
            return ["_$k" => is_array($v) ? array_kvmap($v, $callback) : "prefix-$v"];
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

    function test_array_lmap()
    {
        // 最左に適用される
        that(array_lmap([1, 2], self::resolveFunction('strcat'), 'a-', '-z'))->is(['1a--z', '2a--z']);
    }

    function test_array_lookup()
    {
        $arrays = [
            11 => ['id' => 1, 'name' => 'name1'],
            12 => ['id' => 2, 'name' => 'name2'],
            13 => ['id' => 3, 'name' => 'name3'],
        ];

        // 第3引数を与えれば array_column と全く同じ
        that(array_lookup($arrays, 'name', 'id'))->isSame(array_column($arrays, 'name', 'id'));
        that(array_lookup($arrays, null, 'id'))->isSame(array_column($arrays, null, 'id'));
        // 与えなければキーが保存される array_column のような動作になる
        that(array_lookup($arrays, 'name'))->isSame([11 => 'name1', 12 => 'name2', 13 => 'name3']);
        that(array_lookup($arrays, null))->isSame($arrays);
        // オブジェクトもOK
        $objects = array_map(fn($v) => stdclass($v), $arrays);
        that(array_lookup($objects, 'name'))->isSame([11 => 'name1', 12 => 'name2', 13 => 'name3']);
        // クロージャもOK
        that(array_lookup($objects, 'name', fn($v, $k) => "$k-{$v->name}"))->isSame(["11-name1" => 'name1', "12-name2" => 'name2', "13-name3" => 'name3']);
    }

    function test_array_map_filter()
    {
        // strict:false なので 0 が除外される
        that(array_map_filter([1, 2, 3, 4, 5], fn($v) => $v - 3, false))->is([-2, -1, '3' => 1, 2]);

        // strict:true なので全て返ってくる
        that(array_map_filter([1, 2, 3, 4, 5], fn($v) => $v - 3, true))->is([-2, -1, 0, 1, 2]);

        // strict:true は null がフィルタされる
        that(array_map_filter([1, 2, 3, 4, 5], fn($v) => $v === 3 ? null : $v - 3, true))->is([-2, -1, '3' => 1, 2]);
    }

    function test_array_map_key()
    {
        that(array_map_key([' a ' => 'A', ' b ' => 'B'], 'trim'))->is(['a' => 'A', 'b' => 'B']);
        that(array_map_key(['a' => 'A', 'b' => 'B'], 'strtoupper'))->is(['A' => 'A', 'B' => 'B']);
        that(array_map_key(['a' => 'A', 'b' => 'B'], fn($k) => $k === 'b' ? null : strtoupper($k)))->is(['A' => 'A']);
        that(array_map_key(['a' => 'A', 'b' => 'B'], fn($k, $v) => $v === 'B' ? null : strtoupper($k)))->is(['A' => 'A']);
    }

    function test_array_map_method()
    {
        $o1 = new \Concrete('a');
        $o2 = new \Concrete('b');
        $o3 = new \Concrete('c');

        // きちんと呼ばれるし引数も渡る
        that(array_map_method([$o1, $o2, $o3], 'getName'))->is(['a', 'b', 'c']);
        that(array_map_method([$o1, $o2, $o3], 'getName', ['_', true]))->is(['_A', '_B', '_C']);

        // $ignore=true すると filter される
        that(array_map_method([$o1, null, 123], 'getName', [], true))->is(['a']);

        // $ignore=null するとそのまま返す
        that(array_map_method([$o1, null, 123], 'getName', [], null))->is(['a', null, 123]);

        // iterable
        that(array_map_method(new \ArrayObject([$o1, null, 123]), 'getName', [], null))->is(['a', null, 123]);
    }

    function test_array_map_recursive()
    {
        that(array_map_recursive([
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

        that(array_map_recursive([
            'k' => 'v',
            'c' => new \ArrayObject([
                'k1' => 'v1',
                'k2' => 'v2',
            ]),
        ], 'gettype', false))->isSame([
            'k' => 'string',
            'c' => 'object',
        ]);

        that(array_map_recursive([
            'k' => 'v',
            'c' => [
                'k1' => 'v1',
                'k2' => 'v2',
            ],
        ], fn($v) => is_array($v) ? (object) $v : strtoupper($v), true, true))->is((object) [
            'k' => 'V',
            'c' => (object) [
                'k1' => 'V1',
                'k2' => 'V2',
            ],
        ]);

        $array = [
            'scalar' => 123,
            'list'   => [1, 2, 3],
            'hash'   => ['a' => 'A'],
            'nest'   => [
                'scalar' => 456,
                'list'   => [4, 5, 6],
                'hash'   => ['b' => 'B'],
                'xyz'    => ['x', 'y', 'z'],
            ],
        ];
        $all = [];
        that(array_map_recursive($array, function ($v) use (&$all) {
            $all[] = $v;
            return $v;
        }, true, true))->isSame($array);
        // 実行結果より呼び出し順のほうが大事
        that($all)->isSame([
            // scalar
            123,
            // list[0,1,2]
            1,
            2,
            3,
            // list
            [1, 2, 3],
            // hash[a]
            'A',
            // hash
            ['a' => 'A'],
            // nest.scalar
            456,
            // nest.list[0,1,2]
            4,
            5,
            6,
            // nest.list
            [4, 5, 6],
            // nest.hash[b]
            'B',
            // nest.hash
            ['b' => 'B'],
            // nest.xyz[0,1,2]
            'x',
            'y',
            'z',
            // nest.xyz
            ['x', 'y', 'z'],
            // nest
            [
                'scalar' => 456,
                'list'   => [4, 5, 6],
                'hash'   => ['b' => 'B'],
                'xyz'    => ['x', 'y', 'z'],
            ],
            // self
            $array,
        ]);
    }

    function test_array_maps()
    {
        that(array_maps(['a', 'b', 'c'], 'strtoupper', lbind(self::resolveFunction('strcat'), '_')))->is(['_A00', '_B11', '_C22']);
        that(array_maps(['a', 'b', 'c'], 'strtoupper', lbind(self::resolveFunction('strcat'), '_', '-')))->is(['_-A00', '_-B11', '_-C22']);

        that(array_maps(['a' => 'A', 'b' => 'B'], self::resolveFunction('strcat'), self::resolveFunction('strcat')))->is(['a' => 'Aa0a0', 'b' => 'Bb1b1']);

        // 可変引数モード
        that(array_maps([[1, 3], [1, 5, 2]], '...range'))->isSame([[1, 2, 3], [1, 3, 5]]);

        // メソッドモード
        $ex = new \Exception('msg1', 1, new \Exception('msg2', 2, new \Exception('msg3', 3)));
        that(array_maps([$ex, $ex, $ex], '@getMessage'))->is(['msg1', 'msg1', 'msg1']);
        that(array_maps([$ex, $ex, $ex], '@getPrevious', '@getCode'))->is([2, 2, 2]);
        that(array_maps([$ex, $ex, $ex], '@getPrevious', '@getPrevious', '@getCode'))->is([3, 3, 3]);

        $objs = [new \Concrete('a'), new \Concrete('b'), new \Concrete('c')];
        that(array_maps($objs, ['getName' => ['p-', true]]))->is(['P-A', 'P-B', 'P-C']);

        $objs = new \ArrayObject([new \Concrete('a'), new \Concrete('b'), new \Concrete('c')]);
        that(array_maps($objs, ['getName' => ['p-', true]]))->is(['P-A', 'P-B', 'P-C']);
    }

    function test_array_merge2()
    {
        that(array_merge2())->is([]);
        that(array_merge2(['a' => 'A', 2 => 2, 1 => 1, 0 => 0]))->is([0, 1, 2, 'a' => 'A']);
        that(array_merge2(...[
            [
                -1  => -1,
                1   => 1,
                4   => 4,
                8   => 8,
                'a' => 'A',
            ],
            [
                0   => 0,
                'b' => 'B',
                3   => 3,
            ],
            [
                -2  => -2,
                5   => 5,
                'a' => 'X',
                2   => 2,
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
        that(array_mix())->is([]);
        that(array_mix([], []))->is([]);
        that(array_mix([], [], [null]))->is([null]);
        that(array_mix([1, 3, 5], [2, 4, 6]))->is([1, 2, 3, 4, 5, 6]);
        that(array_mix([1, 3, 5], [2, 4, 6, 7]))->is([1, 2, 3, 4, 5, 6, 7]);
        that(array_mix([1, 3, 5, 7], [2, 4, 6]))->is([1, 2, 3, 4, 5, 6, 7]);
        that(array_mix([1], [2, 4], [3, 5, 6]))->is([1, 2, 3, 4, 5, 6]);
        that(array_mix(['a' => 'A', 'c' => 'C'], ['b' => 'b']))->is(['a' => 'A', 'b' => 'b', 'c' => 'C']);
        that(array_mix(['a' => 'A'], ['b' => 'b', 'c' => 'C']))->is(['a' => 'A', 'b' => 'b', 'c' => 'C']);
        that(array_mix(['a' => 'A', 'X', 'Z'], ['a' => '!', 'Y']))->is(['a' => '!', 'X', 'Y', 'Z']);
    }

    function test_array_nest()
    {
        that(array_nest([
            'k1.k2' => 'v1',
            'k1'    => 'v2',
        ]))->is([
            'k1' => 'v2',
        ]);
        that(array_nest([
            'k1'    => ['v1'],
            'k1.k2' => 'v2',
        ]))->is([
            'k1' => [
                0    => 'v1',
                'k2' => 'v2',
            ],
        ]);
        that(array_nest([
            'k1.0'  => 'v1',
            'k1.k2' => 'v2',
        ]))->is([
            'k1' => [
                0    => 'v1',
                'k2' => 'v2',
            ],
        ]);
        that(self::resolveFunction('array_nest'))([
            'k1'    => 'v1',
            'k1.k2' => 'v2',
        ])->wasThrown('already exists');
    }

    function test_array_nmap()
    {
        // それぞれ N 番目に適用される
        that(array_nmap([1, 2], self::resolveFunction('strcat'), 0, 'a-', '-z'))->is(['1a--z', '2a--z']);
        that(array_nmap([1, 2], self::resolveFunction('strcat'), 1, 'a-', '-z'))->is(['a-1-z', 'a-2-z']);
        that(array_nmap([1, 2], self::resolveFunction('strcat'), 2, 'a-', '-z'))->is(['a--z1', 'a--z2']);

        /// $n に配列を渡すとキー・値の両方が渡ってくる
        // キーを1番目、値を2番目に渡す
        that(array_nmap(['k' => 'v'], self::resolveFunction('strcat'), [1 => 2], ' a ', ' b ', ' c '))->is(['k' => ' a k b v c ']);
        // キーを2番目、値を1番目に渡す
        that(array_nmap(['k' => 'v'], self::resolveFunction('strcat'), [2 => 1], ' a ', ' b ', ' c '))->is(['k' => ' a v b k c ']);
        // キーを1番目、値を1番目に渡す（キーが優先される）
        that(array_nmap(['k' => 'v'], self::resolveFunction('strcat'), [1 => 1], ' a ', ' b ', ' c '))->is(['k' => ' a kv b  c ']);

        that(self::resolveFunction('array_nmap'))([], self::resolveFunction('strcat'), [])->wasThrown('empty');
        that(self::resolveFunction('array_nmap'))([], self::resolveFunction('strcat'), [1 => -1])->wasThrown('positive');
        that(self::resolveFunction('array_nmap'))([], self::resolveFunction('strcat'), [-1 => 1])->wasThrown('positive');
    }

    function test_array_of()
    {
        $hoge_of = array_of('hoge');
        that($hoge_of(['hoge' => 'HOGE']))->is('HOGE');
        that($hoge_of(['fuga' => 'FUGA']))->is(null);

        $hoge_of = array_of('hoge', 'HOGE');
        that($hoge_of(['fuga' => 'FUGA']))->is('HOGE');

        that(array_of([0, 2])(['a', 'b', 'c']))->is([0 => 'a', 2 => 'c']);
        that(array_of([0, 9])(['a', 'b', 'c']))->is([0 => 'a']);
        that(array_of([9])(['a', 'b', 'c']))->is([]);
        that(array_of([9], null)(['a', 'b', 'c']))->is(null);
    }

    function test_array_order()
    {
        that(array_order([2, 4, 5, 1, 8, 6, 9, 3, 7], true))->is([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        that(array_order(['b', 'd', 'g', 'a', 'f', 'e', 'c'], false))->is(['g', 'f', 'e', 'd', 'c', 'b', 'a']);
        that(array_order(['b', 'c', 'z', 'b', 'a', 'c', 'a'], ['a', 'b', 'c']))->is(['a', 'a', 'b', 'b', 'c', 'c', 'z']);
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

        that(array_order($data, [
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
        that(array_order($data, [
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
        that(array_order($data, [
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
        that(array_order($data, [
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
        that(array_order($data, [
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

        that(array_order($data, [
            // 6は0とみなす
            'integer' => fn($v) => $v === 6 ? 0 : $v,
            // "aa"は"zz"とみなす
            'string'  => fn($v) => $v === 'aa' ? 'zz' : $v,
        ], true))->isSame([
            3 => ['string' => 'bb', 'integer' => 6],
            5 => ['string' => 'cc', 'integer' => 6],
            1 => ['string' => 'cc', 'integer' => 1],
            6 => ['string' => 'cc', 'integer' => 2],
            4 => ['string' => 'dd', 'integer' => 2],
            2 => ['string' => 'aa', 'integer' => 2],
            0 => ['string' => 'aa', 'integer' => 7],
        ]);

        that(array_order($data, [
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

        that(array_order($data, [
            'string' => fn($a, $b) => strcmp($a, $b),
            'array'  => fn($a, $b) => array_sum($b) - array_sum($a),
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
        that(array_order($data, $cb))->isSame([
            '11',
            '22',
            '33',
            '111',
            '222',
            '333',
        ]);

        // returnType が string なら文字的にソートされる
        $cb = eval('return function ($v): string { return $v; };');
        that(array_order($data, $cb))->isSame([
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
        that(array_order([], [[]]))->is([]);
        that(array_order([1], [[]]))->is([1]);

        that(self::resolveFunction('array_order'))([['a' => 1], ['a' => 2]], ['x' => true])->wasThrown(new \InvalidArgumentException('x is undefined'));

        that(self::resolveFunction('array_order'))([['a' => 1], ['a' => 2]], ['a' => new \stdClass()])->wasThrown(new \DomainException('$order is invalid'));
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

        that(array_order($data, true, true))->isSame([
            'c' => '011',
            'b' => '1',
            'e' => '1',
            'g' => '1',
            'f' => '11',
            'a' => '111',
            'd' => '111',
        ]);

        that(array_order($data, -SORT_NATURAL, true))->isSame([
            'a' => '111',
            'd' => '111',
            'c' => '011',
            'f' => '11',
            'b' => '1',
            'e' => '1',
            'g' => '1',
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
        that(array_order($data, [
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
        that(array_order($data, [
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

        that(array_order($data, true, true))->isSame([
            2 => '011',
            1 => '1',
            4 => '1',
            6 => '1',
            5 => '11',
            0 => '111',
            3 => '111',
        ]);

        that(array_order($data, -SORT_NATURAL, true))->isSame([
            0 => '111',
            3 => '111',
            2 => '011',
            5 => '11',
            1 => '1',
            4 => '1',
            6 => '1',
        ]);
    }

    function test_array_order_misc()
    {
        // 1000 rows, 26 cols, 5 order is in 1 seconds
        $data = array_fill(0, 999, array_fill_keys(range('a', 'z'), 1));
        that(self::resolveFunction('array_order'))->fn($data, [
            'a' => true,
            'b' => false,
            'c' => [1, 2, 3],
            'd' => fn($v) => "$v",
            'e' => fn($a, $b) => strcmp($a, $b),
        ])->inTime(1.0);
    }

    function test_array_pickup()
    {
        that(array_pickup(['a' => 'A', 'b' => ['b' => 'B']], ['a']))->isSame(['a' => 'A']);
        that(array_pickup(['a' => 'A', 'b' => ['b' => 'B']], ['b']))->isSame(['b' => ['b' => 'B']]);

        that(array_pickup(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['a', 'c']))->isSame(['a' => 'A', 'c' => 'C']);
        that(array_pickup(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['c', 'a']))->isSame(['c' => 'C', 'a' => 'A']);

        that(array_pickup(stdclass(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['a', 'c']))->isSame(['a' => 'A', 'c' => 'C']);
        that(array_pickup(stdclass(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['c', 'a']))->isSame(['c' => 'C', 'a' => 'A']);

        that(array_pickup(['a' => 'A', 'b' => ['b' => 'B']], ['a' => 'AAA']))->isSame(['AAA' => 'A']);
        that(array_pickup(['a' => 'A', 'b' => ['b' => 'B']], ['b' => 'BBB']))->isSame(['BBB' => ['b' => 'B']]);

        that(array_pickup(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['c' => fn($k, $v) => "$k-$v"]))->isSame(['c-C' => 'C']);
    }

    function test_array_pos()
    {
        // 1 番目の要素を返す
        that(array_pos(['x', 'y', 'z'], 1, false))->is('y');
        // 負数は後ろから返す
        that(array_pos(['x', 'y', 'z'], -1, false))->is('z');

        // 上記の is_key:true 版（キーを返す）
        that(array_pos(['x', 'y', 'z'], 1, true))->is(1);
        that(array_pos(['x', 'y', 'z'], -1, true))->is(2);

        // 範囲外は例外が飛ぶ
        that(self::resolveFunction('array_pos'))(['x', 'y', 'z'], 9, true)->wasThrown('OutOfBoundsException');
    }

    function test_array_pos_key()
    {
        that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'c'))->is(2);
        that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x', -1))->is(-1);
        that(self::resolveFunction('array_pos_key'))(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x')->wasThrown('OutOfBoundsException');
    }

    function test_array_prepend()
    {
        that(array_prepend(['a', 'b', 'c'], 'X'))->isSame(['X', 'a', 'b', 'c']);
        that(array_prepend(['a', 'b', 'c'], 'X', 9))->isSame([9 => 'X', 0 => 'a', 1 => 'b', 2 => 'c']);
        that(array_prepend(['a', 'b', 'c'], 'X', 'key'))->isSame(['key' => 'X', 'a', 'b', 'c']);

        that(array_prepend(['a' => 'A', 'b' => 'B', 'c'], 'X'))->isSame(['X', 'a' => 'A', 'b' => 'B', 'c']);
        that(array_prepend(['a' => 'A', 'b' => 'B', 'c'], 'X', 9))->isSame([9 => 'X', 'a' => 'A', 'b' => 'B', 0 => 'c']);
        that(array_prepend(['a' => 'A', 'b' => 'B', 'c'], 'X', 'key'))->isSame(['key' => 'X', 'a' => 'A', 'b' => 'B', 'c']);
        that(array_prepend(['a' => 'A', 'b' => 'B', 'c'], 'X', 'a'))->isSame(['a' => 'X', 'b' => 'B', 'c']);
    }

    function test_array_put()
    {
        // single
        $array = ['a' => 'A', 'B'];
        that(array_put($array, 'Z'))->is(1);
        that($array)->is(['a' => 'A', 'B', 'Z']);
        that(array_put($array, 'Z', 123))->is(2);
        that($array)->is(['a' => 'A', 'B', 'Z', 'Z']);
        that(array_put($array, 'Z', 'z'))->is('z');
        that($array)->is(['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z']);
        that(array_put($array, 'X', 'a'))->is('a');
        that($array)->is(['a' => 'X', 'B', 'Z', 'Z', 'z' => 'Z']);

        // condition
        $array = ['a' => 'A', 'B'];
        that(array_put($array, 'Z', null, fn($v, $k, $array) => !in_array($v, $array)))->is(1);
        that($array)->is(['a' => 'A', 'B', 'Z']);
        that(array_put($array, 'Z', null, fn($v, $k, $array) => !in_array($v, $array)))->is(false);
        that($array)->is(['a' => 'A', 'B', 'Z']);

        // array
        $array = ['a' => 'A', 'b' => ['B']];
        that(array_put($array, 'X', ['x']))->is('x');
        that($array)->is(['a' => 'A', 'b' => ['B'], 'x' => 'X']);
        that(array_put($array, 'X', ['y', 'z']))->is('z');
        that($array)->is(['a' => 'A', 'b' => ['B'], 'x' => 'X', 'y' => ['z' => 'X']]);
        that(array_put($array, 'W', ['b']))->is('b');
        that($array)->is(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X']]);
        that(array_put($array, 'Y2', ['y', null]))->is(0);
        that($array)->is(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X', 'Y2']]);
        that(self::resolveFunction('array_put'))($array, 'X', ['a', 'b', 'c'])->wasThrown('is not array');
    }

    function test_array_random()
    {
        srand(123);
        mt_srand(123);
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(array_random($array, null))->is('B');
        that(array_random($array, 0))->is([]);
        that(array_random($array, 1))->is(['B']);
        that(array_random($array, 2))->is(['B', 'C']);
        that(array_random($array, 3))->is(['A', 'B', 'C']);
        that(array_random($array, 2, true))->is(['b' => 'B', 'c' => 'C']);
        that(array_random($array, -9, true))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);
        that(array_random($array, -9, false))->is(['A', 'B', 'C']);

        that(array_random([], 0))->is([]);
        that(array_random([], -3))->is([]);

        that(self::resolveFunction('array_random'))($array, 4)->wasThrown('number of elements');
        that(self::resolveFunction('array_random'))([], +1)->wasThrown('number of elements');
    }

    function test_array_range()
    {
        // 数値モード
        that(array_range(1, 3))->isSame([1, 2, 3]);
        that(array_range(1, 3, 2))->isSame([1, 3]);
        that(array_range(1, 3, 3))->isSame([1]);
        that(array_range(1, 3, -1))->isSame([]);
        that(array_range(1.0, 3.0))->isSame([1.0, 2.0, 3.0]);
        that(array_range(1.0, 3.0, 2.0))->isSame([1.0, 3.0]);
        that(array_range(1.0, 3.0, 3.0))->isSame([1.0]);
        that(array_range(1.0, 3.0, -1.0))->isSame([]);

        that(array_range(3, 1))->isSame([3, 2, 1]);
        that(array_range(3, 1, -2))->isSame([3, 1]);
        that(array_range(3, 1, -3))->isSame([3]);
        that(array_range(3, 1, 1))->isSame([]);
        that(array_range(3.0, 1.0))->isSame([3.0, 2.0, 1.0]);
        that(array_range(3.0, 1.0, -2.0))->isSame([3.0, 1.0]);
        that(array_range(3.0, 1.0, -3.0))->isSame([3.0]);
        that(array_range(3.0, 1.0, 1.0))->isSame([]);

        // 文字列モード
        that(array_range('a', 'c'))->isSame(['a', 'b', 'c']);
        that(array_range('a', 'c', 2))->isSame(['a', 'c']);
        that(array_range('a', 'c', 3))->isSame(['a']);
        that(array_range('Y', 'b', 1))->isSame(['Y', 'Z']);
        that(array_range('y', 'B', 1))->isSame([]);
        that(array_range('A', 'ZZ', 1))->count(26 * 26 + 26);
        that(array_range('a', 'zz', 1))->count(26 * 26 + 26);

        that(array_range('c', 'a'))->isSame(['c', 'b', 'a']);
        that(array_range('c', 'a', -2))->isSame(['c', 'a']);
        that(array_range('c', 'a', -3))->isSame(['c']);
        that(array_range('b', 'Y', -1))->isSame(['Z', 'Y']);
        that(array_range('B', 'y', -1))->isSame([]);
        that(array_range('ZZ', 'A', -1))->count(26 * 26 + 26);
        that(array_range('zz', 'a', -1))->count(26 * 26 + 26);

        // 日時モード
        that(array_range('2014/12/24', '2014/12/26', '1day', ['format' => 'Y/m/d H:i:s.v']))->is([
            '2014/12/24 00:00:00.000',
            '2014/12/25 00:00:00.000',
            '2014/12/26 00:00:00.000',
        ]);
        that(array_range('2014/12/24', '2014/12/26', 'P2D', ['format' => 'Y/m/d H:i:s.v']))->is([
            '2014/12/24 00:00:00.000',
            '2014/12/26 00:00:00.000',
        ]);
        that(array_range('2014/12/24', '2014/12/26', 'P3D', ['format' => 'Y/m/d H:i:s.v']))->is([
            '2014/12/24 00:00:00.000',
        ]);
        that(array_range('2014/12/24', '2014/12/26', 'P-1D', ['format' => 'Y/m/d H:i:s.v']))->is([]);
        that(array_range('2014/12/24 00:00:00.2', '2014/12/24 00:00:10.2', 'PT1.5S', ['format' => 'Y/m/d H:i:s.v']))->is([
            '2014/12/24 00:00:00.200',
            '2014/12/24 00:00:01.700',
            '2014/12/24 00:00:03.200',
            '2014/12/24 00:00:04.700',
            '2014/12/24 00:00:06.200',
            '2014/12/24 00:00:07.700',
            '2014/12/24 00:00:09.200',
        ]);

        that(array_range('2014/12/26', '2014/12/24', '-1day', ['format' => 'Y/m/d H:i:s.v']))->is([
            '2014/12/26 00:00:00.000',
            '2014/12/25 00:00:00.000',
            '2014/12/24 00:00:00.000',
        ]);
        that(array_range('2014/12/26', '2014/12/24', 'P-2D', ['format' => 'Y/m/d H:i:s.v']))->is([
            '2014/12/26 00:00:00.000',
            '2014/12/24 00:00:00.000',
        ]);
        that(array_range('2014/12/26', '2014/12/24', 'P-3D', ['format' => 'Y/m/d H:i:s.v']))->is([
            '2014/12/26 00:00:00.000',
        ]);
        that(array_range('2014/12/26', '2014/12/24', 'P1D', ['format' => 'Y/m/d H:i:s.v']))->is([]);
        that(array_range('2014/12/24 00:00:10.2', '2014/12/24 00:00:00.2', 'PT-1.5S', ['format' => 'Y/m/d H:i:s.v']))->is([
            '2014/12/24 00:00:10.200',
            '2014/12/24 00:00:08.700',
            '2014/12/24 00:00:07.200',
            '2014/12/24 00:00:05.700',
            '2014/12/24 00:00:04.200',
            '2014/12/24 00:00:02.700',
            '2014/12/24 00:00:01.200',
        ]);
        that(array_range(new \DateTime('2014-12-24'), '2014-12-26', '1day', ['format' => 'auto']))->is([
            '2014-12-24',
            '2014-12-25',
            '2014-12-26',
        ]);
        that(array_range('2014-12-24', new \DateTime('2014-12-26'), '1day', ['format' => 'auto']))->is([
            '2014-12-24',
            '2014-12-25',
            '2014-12-26',
        ]);

        // 例外
        that(self::resolveFunction('array_range'))('1', '3', 0)->wasThrown("step is empty(0)");
        that(self::resolveFunction('array_range'))('a', 'c', 0)->wasThrown("step is empty(0)");
        that(self::resolveFunction('array_range'))('2014/12/24', '2014/12/27', 'P0Y')->wasThrown("step is empty(+P00-00-00T00:00:00.000000)");
        that(self::resolveFunction('array_range'))('', '', '')->wasThrown("failed to detect mode");
        that(self::resolveFunction('array_range'))(new \DateTime('2014-12-24'), new \DateTime('2014-12-26'), '1day', ['format' => 'auto'])->wasThrown("failed to auto detect");
    }

    function test_array_rank()
    {
        that(array_rank([], 0))->isSame([]);
        that(array_rank([1, 1, 1, 1, 1], 1))->isSame([1, 1, 1, 1, 1]);

        that(array_rank([1, 2, 3, 4, 5], 3))->isSame([1, 2, 3]);
        that(array_rank([1, 2, 3, 3, 5], 3))->isSame([1, 2, 3, 3]);

        that(array_rank([1, 2, 3, 4, 5], -3))->isSame([4 => 5, 3 => 4, 2 => 3]);
        that(array_rank([1, 3, 3, 4, 5], -3))->isSame([4 => 5, 3 => 4, 1 => 3, 2 => 3]);

        that(array_rank([1.1, 2.2, 3.3, 3.3, 5.5], 3))->isSame([1.1, 2.2, 3.3, 3.3]);
        that(array_rank([1.1, 3.3, 3.3, 4.4, 5.5], -3))->isSame([4 => 5.5, 3 => 4.4, 1 => 3.3, 2 => 3.3]);

        that(array_rank(['10000', '2000', '300', '40', '5'], 3))->isSame(['10000', '2000', '300']);
        that(array_rank(['10000', '2000', '300', '40', '5'], -3))->isSame([4 => '5', 3 => '40', 2 => '300']);

        $row1 = ['id' => 1, 'name' => 'A', 'score' => 10];
        $row2 = ['id' => 2, 'name' => 'B', 'score' => 20];
        $row3 = ['id' => 3, 'name' => 'B', 'score' => 30];
        $array = [
            'id1' => $row1,
            'id2' => $row2,
            'id3' => $row3,
        ];
        that(array_rank($array, 2, fn($row) => $row['score']))->isSame(['id1' => $row1, 'id2' => $row2]);
        that(array_rank($array, -2, fn($row) => $row['score']))->isSame(['id3' => $row3, 'id2' => $row2]);
    }

    function test_array_rekey()
    {
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(array_rekey($array, ['a' => 'x', 'c' => 'z']))->is(['x' => 'A', 'b' => 'B', 'z' => 'C']);
        that(array_rekey($array, ['c' => 'z', 'a' => 'x']))->is(['x' => 'A', 'b' => 'B', 'z' => 'C']);
        that(array_rekey($array, ['x' => 'X', 'y' => 'Y', 'z' => 'Z']))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);
        that(array_rekey($array, ['a' => 'c', 'c' => 'a']))->is(['c' => 'A', 'b' => 'B', 'a' => 'C']);
        that(array_rekey($array, ['c' => 'a', 'a' => 'c']))->is(['c' => 'A', 'b' => 'B', 'a' => 'C']);
        that(array_rekey($array, ['b' => null]))->is(['a' => 'A', 'c' => 'C']);
        that(array_rekey($array, ['a' => null, 'b' => null, 'c' => null]))->is([]);
        that(array_rekey($array, 'strtoupper'))->is(['A' => 'A', 'B' => 'B', 'C' => 'C']);
        that(array_rekey($array, function ($k, $v, $n, $array) {
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

    function test_array_remove()
    {
        that(array_remove(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'b'))->isSame(['a' => 'A', 'c' => 'C']);
        that(array_remove(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x'))->isSame(['a' => 'A', 'b' => 'B', 'c' => 'C']);

        that(array_remove(['a' => 'A', 'b' => ['b' => 'B']], ['b']))->isSame(['a' => 'A']);
        that(array_remove(['a' => 'A', 'b' => ['b' => 'B']], ['a']))->isSame(['b' => ['b' => 'B']]);

        that(array_remove(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['a', 'c']))->isSame(['b' => 'B']);
        that(array_remove(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['c', 'a']))->isSame(['b' => 'B']);

        that(array_remove(new \ArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['a', 'c']))->is(new \ArrayObject(['b' => 'B']));
        that(array_remove(new \ArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['c', 'a']))->is(new \ArrayObject(['b' => 'B']));
    }

    function test_array_revise()
    {
        that(array_revise([
            'id'      => 123,
            'name'    => 'hoge',
            'age'     => 18,
            'delete'  => '',
            'options' => 'a,b,c',
        ], [
            'name'    => 'ignored',
            'append'  => 'newkey',
            'null'    => fn() => null,
            'age'     => fn($age) => $age + 1,
            'options' => fn($options) => explode(',', $options),
            'delete'  => null,
        ]))->isSame([
            'id'      => 123,
            'name'    => 'hoge',
            'age'     => 19,
            'options' => ["a", "b", "c"],
            'append'  => 'newkey',
            'null'    => null,
        ]);
    }

    function test_array_rmap()
    {
        // 最右に適用される
        that(array_rmap([1, 2], self::resolveFunction('strcat'), 'a-', '-z'))->is(['a--z1', 'a--z2']);
    }

    function test_array_schema_misc()
    {
        that(array_schema([
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
            ],
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
            ],
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
            ],
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
            ],
        ]);

        $schema = [
            'type'   => 'list@hash',
            'max'    => 1,
            '@#name' => [
                'type' => 'string',
                'max'  => 2,
            ],
        ];
        that(array_schema($schema, [['name' => 'XY']]))->isSame([['name' => 'XY']]);
        that(self::resolveFunction('array_schema'))($schema, [
            ['name' => 'X'],
        ], [
            ['name' => 'Y'],
        ])->wasThrown("must be count <= 1");
        that(self::resolveFunction('array_schema'))($schema, [
            ['name' => 'XYZ'],
        ])->wasThrown("must be strlen <= 2");
    }

    function test_array_schema_ng()
    {
        that(self::resolveFunction('array_schema'))(['type' => 'number', 'filter' => FILTER_VALIDATE_INT], 'hoge')->wasThrown('hoge must be filter_var int([])');
        that(self::resolveFunction('array_schema'))(['type' => 'int|string'], true)->wasThrown('true must be int or string');
        that(self::resolveFunction('array_schema'))(['type' => ['int', 'string']], true)->wasThrown('true must be int or string');

        that(self::resolveFunction('array_schema'))(['type' => 'string'], 123)->wasThrown("123 must be string");
        that(self::resolveFunction('array_schema'))(['type' => 'number'], "123")->wasThrown("123 must be number");
        that(self::resolveFunction('array_schema'))(['type' => 'numeric'], "12..45")->wasThrown("12..45 must be numeric");
        that(self::resolveFunction('array_schema'))(['type' => 'list'], "hoge")->wasThrown("hoge must be list");
        that(self::resolveFunction('array_schema'))(['type' => \ArrayObject::class], "hoge")->wasThrown("hoge must be ArrayObject");

        that(self::resolveFunction('array_schema'))(['type' => 'int', 'min' => 1], 0)->wasThrown("0 must be >= 1");
        that(self::resolveFunction('array_schema'))(['type' => 'int', 'max' => 1], 3)->wasThrown("3 must be <= 1");
        that(self::resolveFunction('array_schema'))(['type' => 'string', 'min' => 1], '')->wasThrown("must be strlen >= 1");
        that(self::resolveFunction('array_schema'))(['type' => 'string', 'max' => 1], 'abc')->wasThrown("abc must be strlen <= 1");
        that(self::resolveFunction('array_schema'))(['type' => 'list', 'min' => 1], [])->wasThrown("[] must be count >= 1");
        that(self::resolveFunction('array_schema'))(['type' => 'list', 'max' => 1], [1, 2, 3])->wasThrown("[1, 2, 3] must be count <= 1");

        that(self::resolveFunction('array_schema'))(['type' => 'float', 'precision' => 3], 1.2345)->wasThrown("1.2345 must be precision 3");

        that(self::resolveFunction('array_schema'))(['type' => 'int', 'enum' => [1, 2, 3]], 4)->wasThrown("4 must be any of [1,2,3]");

        that(self::resolveFunction('array_schema'))(['type' => 'string', 'match' => '#[1-9]#'], 'abc')->wasThrown("must be match #[1-9]#");
        that(self::resolveFunction('array_schema'))(['type' => 'string', 'unmatch' => '#[1-9]#'], '123')->wasThrown("must be unmatch #[1-9]#");

        that(self::resolveFunction('array_schema'))(['type' => 'string', 'include' => 'X'], 'abc')->wasThrown("abc must be include X");
        that(self::resolveFunction('array_schema'))(['type' => 'list', 'include' => 'X'], [1, 2, 3])->wasThrown("[1, 2, 3] must be include X");

        that(self::resolveFunction('array_schema'))(['type' => 'string', 'exclude' => 'X'], 'X')->wasThrown("X must be exclude X");
        that(self::resolveFunction('array_schema'))(['type' => 'list', 'exclude' => 'X'], [1, 'X', 3])->wasThrown("[1, \"X\", 3] must be exclude X");

        that(self::resolveFunction('array_schema'))(['type' => 'hash', '#key' => []], ['key' => 'val'])->wasThrown('not have type key');
        that(self::resolveFunction('array_schema'))(['type' => 'number'])->wasThrown('has no value');
    }

    function test_array_schema_ok()
    {
        that(array_schema(['type' => 'number', 'filter' => FILTER_VALIDATE_INT], 123))->isSame(123);
        that(array_schema(['type' => 'number', 'default' => 123]))->isSame(123);

        that(array_schema(['type' => \ArrayAccess::class], new \ArrayObject()))->isInstanceOf(\ArrayObject::class);
        that(array_schema(['type' => 'int|string'], 123))->isSame(123);
        that(array_schema(['type' => ['int', 'string']], '123'))->isSame('123');

        that(array_schema(['type' => 'number'], 123.45))->isSame(123.45);
        that(array_schema(['type' => 'int', 'closure' => fn($v) => $v * 10], 123))->isSame(1230);
        that(array_schema(['type' => 'list', 'unique' => null], [1, 1, 2, 2, 3, 3]))->isSame([1, 2, 3]);
        that(array_schema(['type' => 'int', 'min' => 1], 1))->isSame(1);
        that(array_schema(['type' => 'int', 'max' => 9], 5))->isSame(5);
        that(array_schema(['type' => 'string', 'min' => 1], 'X'))->isSame('X');
        that(array_schema(['type' => 'string', 'max' => 9], 'X'))->isSame('X');
        that(array_schema(['type' => 'list', 'min' => 1], ['X']))->isSame(['X']);
        that(array_schema(['type' => 'list', 'max' => 9], ['X']))->isSame(['X']);
        that(array_schema(['type' => 'float', 'precision' => 3], 1.234))->isSame(1.234);
        that(array_schema(['type' => 'int', 'enum' => [1, 2, 3]], 2))->isSame(2);
        that(array_schema(['type' => 'string', 'match' => '#[1-9]#'], '123'))->isSame('123');
        that(array_schema(['type' => 'string', 'unmatch' => '#[1-9]#'], 'abc'))->isSame('abc');
        that(array_schema(['type' => 'string', 'include' => 'b'], 'abc'))->isSame('abc');
        that(array_schema(['type' => 'string', 'exclude' => 'X'], 'abc'))->isSame('abc');
        that(array_schema(['type' => 'list', 'include' => 'b'], ['a', 'b']))->isSame(['a', 'b']);
        that(array_schema(['type' => 'list', 'exclude' => 'X'], ['a', 'b']))->isSame(['a', 'b']);
    }

    function test_array_select()
    {
        $arrays = [
            11 => ['id' => 1, 'name' => 'name1'],
            12 => (object) ['id' => 2, 'name' => 'name2'],
            13 => new \ArrayObject(['id' => 3, 'name' => 'name3']),
        ];

        that(array_select($arrays, 'name', null))->isSame(array_lookup($arrays, 'name', null));

        that(array_select($arrays, fn($row) => [
            'hoge' => attr_get('id', $row),
            'fuga' => attr_get('name', $row),
            'piyo' => 123,
        ]))->isSame([
            11 => ['hoge' => 1, 'fuga' => 'name1', 'piyo' => 123],
            12 => ['hoge' => 2, 'fuga' => 'name2', 'piyo' => 123],
            13 => ['hoge' => 3, 'fuga' => 'name3', 'piyo' => 123],
        ]);
        that(array_select($arrays, [
            'name' => fn($name) => strtoupper($name),
        ], null))->isSame([
            ['name' => 'NAME1'],
            ['name' => 'NAME2'],
            ['name' => 'NAME3'],
        ]);
        that(array_select($arrays, [
            'id' => fn($id, $row) => attr_get('id', $row) * 10,
        ], 'id'))->isSame([
            10 => ['id' => 10],
            20 => ['id' => 20],
            30 => ['id' => 30],
        ]);
        that(array_select($arrays, [
            'id10' => fn($id, $row) => attr_get('id', $row) * 10,
        ], 'id'))->isSame([
            1 => ['id10' => 10],
            2 => ['id10' => 20],
            3 => ['id10' => 30],
        ]);
        that(array_select($arrays, [
            'id'     => fn($id, $row) => attr_get('id', $row) * 10,
            'name',
            'idname' => fn($val, $row) => attr_get('id', $row) . ':' . attr_get('name', $row),
        ]))->isSame([
            11 => ['id' => 10, 'name' => 'name1', 'idname' => '1:name1'],
            12 => ['id' => 20, 'name' => 'name2', 'idname' => '2:name2'],
            13 => ['id' => 30, 'name' => 'name3', 'idname' => '3:name3'],
        ]);

        that(self::resolveFunction('array_select'))($arrays, [
            'undefined',
        ])->wasThrown('is not exists');

        that(self::resolveFunction('array_select'))($arrays, [
            'name',
        ], 'undefined')->wasThrown('is not exists');
    }

    function test_array_set()
    {
        // single
        $array = ['a' => 'A', 'B'];
        that(array_set($array, 'Z'))->is(1);
        that($array)->is(['a' => 'A', 'B', 'Z']);
        that(array_set($array, 'Z', 'z'))->is('z');
        that($array)->is(['a' => 'A', 'B', 'Z', 'z' => 'Z']);
        that(array_set($array, 'X', 'a'))->is('a');
        that($array)->is(['a' => 'X', 'B', 'Z', 'z' => 'Z']);
        that(array_set($array, 'Z', null, false))->is(null);
        that($array)->is(['a' => 'X', 'B', 'Z', 'z' => 'Z', 'Z']);

        // array
        $array = ['a' => 'A', 'b' => ['B']];
        that(array_set($array, 'X', ['x']))->is('x');
        that($array)->is(['a' => 'A', 'b' => ['B'], 'x' => 'X']);
        that(array_set($array, 'X', ['y', 'z']))->is('z');
        that($array)->is(['a' => 'A', 'b' => ['B'], 'x' => 'X', 'y' => ['z' => 'X']]);
        that(array_set($array, 'W', ['b']))->is('b');
        that($array)->is(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X']]);
        that(array_set($array, 'Y2', ['y', null]))->is(0);
        that($array)->is(['a' => 'A', 'b' => 'W', 'x' => 'X', 'y' => ['z' => 'X', 'Y2']]);
        that(self::resolveFunction('array_set'))($array, 'X', ['a', 'b', 'c'])->wasThrown('is not array');
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
        that(array_shrink_key($array, $array1, $array2, $array3))->isSame(['a' => 'A3', 'b' => 'B3', 'c' => 'C3']);

        // オブジェクトも渡せる
        $object = stdclass($array);
        $object1 = stdclass($array1);
        $object2 = stdclass($array2);
        $object3 = stdclass($array3);
        that(array_shrink_key($object, $object1, $object2, $object3))->isSame(['a' => 'A3', 'b' => 'B3', 'c' => 'C3']);
    }

    function test_array_shuffle()
    {
        srand(123);
        mt_srand(123);
        that(array_shuffle(['a' => 'A', 'b' => 'B', 'c' => 'C']))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);
        that(array_shuffle(['a' => 'A', 'b' => 'B', 'c' => 'C']))->isNotSame(['a' => 'A', 'b' => 'B', 'c' => 'C']);
    }

    function test_array_sprintf()
    {
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        that(array_sprintf($array, '%s:%s'))->is(['A:a', 'B:b', 'C:c']);
        that(array_sprintf($array, '%s:%s', ','))->is('A:a,B:b,C:c');

        that(array_sprintf($array, fn($v) => "v-$v"))->is(['v-A', 'v-B', 'v-C']);
        that(array_sprintf($array, fn($v) => "v-$v", ','))->is('v-A,v-B,v-C');

        that(array_sprintf($array, fn($v, $k) => "kv-$k$v"))->is(['kv-aA', 'kv-bB', 'kv-cC']);
        that(array_sprintf($array, fn($v, $k) => "kv-$k$v", ','))->is('kv-aA,kv-bB,kv-cC');

        that(array_sprintf([
            'str:%s,int:%d' => ['sss', '3.14'],
            'single:%s'     => 'str',
        ], null, '|'))->is('str:sss,int:3|single:str');
    }

    function test_array_strpad()
    {
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

        // prefix key
        that(array_strpad($array, 'K'))->is(['Ka' => 'A', 'Kb' => 'B', 'Kc' => 'C']);
        // prefix val
        that(array_strpad($array, '', 'V'))->is(['a' => 'VA', 'b' => 'VB', 'c' => 'VC']);
        // prefix key-val
        that(array_strpad($array, 'K', 'V'))->is(['Ka' => 'VA', 'Kb' => 'VB', 'Kc' => 'VC']);

        // suffix key
        that(array_strpad($array, ['K']))->is(['aK' => 'A', 'bK' => 'B', 'cK' => 'C']);
        // suffix val
        that(array_strpad($array, '', ['V']))->is(['a' => 'AV', 'b' => 'BV', 'c' => 'CV']);
        // suffix key-val
        that(array_strpad($array, ['K'], ['V']))->is(['aK' => 'AV', 'bK' => 'BV', 'cK' => 'CV']);

        // prefix suffix key
        that(array_strpad($array, ['K', 'K']))->is(['KaK' => 'A', 'KbK' => 'B', 'KcK' => 'C']);
        // prefix suffix val
        that(array_strpad($array, '', ['V', 'V']))->is(['a' => 'VAV', 'b' => 'VBV', 'c' => 'VCV']);
        // prefix suffix key-val
        that(array_strpad($array, ['K', 'K'], ['V', 'V']))->is(['KaK' => 'VAV', 'KbK' => 'VBV', 'KcK' => 'VCV']);
        // prefix key, suffix val
        that(array_strpad($array, 'K', ['V']))->is(['Ka' => 'AV', 'Kb' => 'BV', 'Kc' => 'CV']);

        // value not string
        that(array_strpad(['x' => [1, 2, 3]], 'K'))->is(['Kx' => [1, 2, 3]]);
    }

    function test_array_uncolumns()
    {
        // 普通の配列
        that(array_uncolumns([
            'id'   => [1, 2, 3],
            'name' => ['A', 'B', 'C'],
        ]))->is([
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
        ]);

        // キーも活きる
        that(array_uncolumns([
            'id'   => ['x' => 1, 'y' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'z' => 'C'],
        ]))->is([
            'x' => ['id' => 1, 'name' => 'A'],
            'y' => ['id' => 2, 'name' => 'B'],
            'z' => ['id' => 3, 'name' => 'C'],
        ]);

        // バラバラな配列を与えるとバラバラになる
        that(array_uncolumns([
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
        that(array_uncolumns([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ], null))->is([
            'x'  => ['id' => 1, 'name' => 'A'],
            'ya' => ['id' => 2, 'name' => null],
            'z'  => ['id' => 3, 'name' => null],
        ]);

        // [デフォルト] を与えるとその値で compat される
        that(array_uncolumns([
            'id'   => ['x' => 1, 'ya' => 2, 'z' => 3],
            'name' => ['x' => 'A', 'y' => 'B', 'az' => 'C'],
        ], ['x' => null, 'y' => null, 'zzz' => 999]))->is([
            'x'   => ['id' => 1, 'name' => 'A'],
            'y'   => ['id' => null, 'name' => 'B'],
            'zzz' => ['id' => 999, 'name' => 999],
        ]);
    }

    function test_array_unset()
    {
        // single
        $array = ['a' => 'A', 'b' => 'B'];
        that(array_unset($array, 'a'))->is('A');
        that($array)->is(['b' => 'B']);
        that(array_unset($array, 'x', 'X'))->is('X');
        that($array)->is(['b' => 'B']);

        // array
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(array_unset($array, ['x'], 'X'))->is('X');
        that(array_unset($array, ['x'], ['X']))->is(['X']);
        that(array_unset($array, ['a', 'b', 'x']))->is(['A', 'B']);
        that($array)->is(['c' => 'C']);

        // array with key
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(array_unset($array, ['b', 'a']))->isSame(['B', 'A']);
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(array_unset($array, [1 => 'a', 0 => 'b']))->isSame([1 => 'A', 0 => 'B']);
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(array_unset($array, ['XXX']))->isSame([]);

        // Arrayable でも動作する
        $ao = new \Arrayable(['a', 'b', 'c']);
        that(array_unset($ao, 1))->is('b');
        that(array_unset($ao, [2, 1, 0]))->is([0 => 'c', 2 => 'a']);

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
        that(array_unset($array, fn($v, $k) => !is_int($k)))->is([
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
        that(array_unset($array, fn($v, $k) => intval($v) >= 100))->is([
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
        that(array_unset($array, fn($v, $k) => $v === 'second'))->is([
            1 => 'second',
        ]);
        that($array)->is([
            'first',
            2  => 'third',
            99 => 99,
        ]);

        // さらに値がオブジェクトのものを抽出（そんなものはない）
        that(array_unset($array, fn($v, $k) => is_object($v)))->is(null);
        that($array)->is([
            'first',
            2  => 'third',
            99 => 99,
        ]);

        // さらにキー数値のものを抽出（全て）
        that(array_unset($array, fn($v, $k) => is_int($k)))->is([
            'first',
            2  => 'third',
            99 => 99,
        ]);
        that($array)->is([]);
    }

    function test_array_where()
    {
        $array = [
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ];

        // 省略すればそのまま
        that(array_where($array))->is($array);

        // シンプルクロージャフィルタ（key === 0 || p を含む）
        that(array_where($array, fn($row, $key) => $key === 0 || strpos($row['name'], 'p') !== false))->is([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);

        // flag 値で true フィルタ
        that(array_where($array, 'flag'))->is([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
        ]);

        // name 値でクロージャフィルタ（'o' を含む）
        that(array_where($array, 'name', fn($name) => strpos($name, 'o') !== false))->is([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);

        // id, name 値でクロージャフィルタ（id === 3 && 'o' を含む）
        that(array_where($array, ['id', 'name'], fn($id_name) => $id_name['id'] === 3 && strpos($id_name['name'], 'o') !== false))->is([
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);

        // キーでクロージャフィルタ（key === 2）
        that(array_where($array, null, fn($name, $key) => $key === 2))->is([
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);

        // 連想配列
        that(array_where($array, ['flag' => 1], false))->is([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
        ]);
        that(array_where($array, ['id' => [2, 3]], false))->is([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
            2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
        ]);
        that(array_where($array, ['flag' => true], true))->is([
            1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
        ]);
        that(array_where($array, ['name' => 'hoge', 'flag' => false]))->is([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
        ]);
        that(array_where($array, ['flag' => 1], true))->is([]);
        that(array_where($array, ['name' => fn($name) => $name === 'hoge', 'flag' => fn($flag) => !$flag]))->is([
            0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
        ]);

        // 例外
        that(self::resolveFunction('array_where'))($array, ['flag' => 1], fn() => null)->wasThrown('must be bool');
    }

    function test_array_zip()
    {
        that(array_zip([1, 2, 3]))->is([[1], [2], [3]]);
        that(array_zip([[1], [2], [3]]))->is([[[1]], [[2]], [[3]]]);
        that(array_zip([1, 2, 3], ['hoge', 'fuga', 'piyo']))->is([[1, 'hoge'], [2, 'fuga'], [3, 'piyo']]);
        that(array_zip(
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

        that(self::resolveFunction('array_zip'))()->wasThrown('$arrays is empty');
    }

    function test_arrayize()
    {
        that(arrayize(1, 2, 3))->isSame([1, 2, 3]);
        that(arrayize([1], 2, 3))->isSame([1, 2, 3]);
        that(arrayize(['a' => 1], 2, 3))->isSame(['a' => 1, 2, 3]);
        that(arrayize([1 => 1], [2 => 2], [3 => 3]))->isSame([1 => 1, 2 => 2, 3 => 3]);
        that(arrayize([1 => 1], ['b' => 2], [3 => 3]))->isSame([1 => 1, 'b' => 2, 3 => 3]);
    }

    function test_arrays()
    {
        that(iterator_to_array(arrays(['a' => 'A', 'b' => 'B', 'c' => 'C'])))->is([['a', 'A'], ['b', 'B'], ['c', 'C']]);
    }

    function test_first_key()
    {
        that(first_key(['a', 'b', 'c']))->is(0);
        that(first_key(['a', 'b', 'c'], 'def'))->is(0);
        that(first_key([], 'def'))->is('def');
        that(first_key([]))->is(null);
    }

    function test_first_keyvalue()
    {
        that(first_keyvalue(['a', 'b', 'c']))->is([0, 'a']);
        that(first_keyvalue(['a', 'b', 'c'], 'def'))->is([0, 'a']);
        that(first_keyvalue([], 'def'))->is('def');
        that(first_keyvalue([]))->is(null);

        that(first_keyvalue(new \ArrayObject([1, 2, 3])))->is([0, 1]);
        that(first_keyvalue(new \ArrayObject([])))->is(null);
    }

    function test_first_value()
    {
        that(first_value(['a', 'b', 'c']))->is('a');
        that(first_value(['a', 'b', 'c'], 'def'))->is('a');
        that(first_value([], 'def'))->is('def');
        that(first_value([]))->is(null);
    }

    function test_groupsort()
    {
        $array = [
            ['id' => 1, 'group' => 'A', 'name' => 'q'],
            ['id' => 2, 'group' => 'A', 'name' => 'a'],
            ['id' => 3, 'group' => 'A', 'name' => 'z'],
            ['id' => 4, 'group' => null, 'name' => 'noise'],
            ['id' => 5, 'group' => 'B', 'name' => 'w'],
            ['id' => 6, 'group' => 'B', 'name' => 's'],
            ['id' => 7, 'group' => 'B', 'name' => 'x'],
            ['id' => 8, 'group' => 'C', 'name' => 'e'],
            ['id' => 9, 'group' => 'C', 'name' => 'd'],
            ['id' => 10, 'group' => null, 'name' => 'noise'],
            ['id' => 11, 'group' => 'C', 'name' => 'c'],
        ];
        $sorted = groupsort($array, fn($v, $k) => $v['group'], fn($a, $b) => $a['name'] <=> $b['name']);
        that($sorted)->is([
            1  => ["id" => 2, "group" => "A", "name" => "a"],
            0  => ["id" => 1, "group" => "A", "name" => "q"],
            2  => ["id" => 3, "group" => "A", "name" => "z"],
            3  => ["id" => 4, "group" => null, "name" => "noise"],
            5  => ["id" => 6, "group" => "B", "name" => "s"],
            4  => ["id" => 5, "group" => "B", "name" => "w"],
            6  => ["id" => 7, "group" => "B", "name" => "x"],
            10 => ["id" => 11, "group" => "C", "name" => "c"],
            8  => ["id" => 9, "group" => "C", "name" => "d"],
            7  => ["id" => 8, "group" => "C", "name" => "e"],
            9  => ["id" => 10, "group" => null, "name" => "noise"],
        ]);
    }

    function test_in_array_and()
    {
        that(in_array_and([], []))->isFalse();
        that(in_array_and(['a'], []))->isFalse();

        that(in_array_and(['a'], ['a', 'b', 'c']))->isTrue();
        that(in_array_and(['a', 'b'], ['a', 'b', 'c']))->isTrue();
        that(in_array_and(['a', 'b', 'c'], ['a', 'b', 'c']))->isTrue();
        that(in_array_and(['a', 'b', 'c', 'z'], ['a', 'b', 'c']))->isFalse();
        that(in_array_and(['z'], ['a', 'b', 'c']))->isFalse();

        that(in_array_and(['1', 2], [1, 2, 3], false))->isTrue();
        that(in_array_and(['1', 2], [1, 2, 3], true))->isFalse();
        that(in_array_and(['1', '2'], [1, 2, 3], true))->isFalse();
    }

    function test_in_array_or()
    {
        that(in_array_or([], []))->isFalse();
        that(in_array_or(['a'], []))->isFalse();

        that(in_array_or(['a'], ['a', 'b', 'c']))->isTrue();
        that(in_array_or(['a', 'b'], ['a', 'b', 'c']))->isTrue();
        that(in_array_or(['a', 'b', 'c'], ['a', 'b', 'c']))->isTrue();
        that(in_array_or(['a', 'b', 'c', 'z'], ['a', 'b', 'c']))->isTrue();
        that(in_array_or(['z'], ['a', 'b', 'c']))->isFalse();

        that(in_array_or(['1', 2], [1, 2, 3], false))->isTrue();
        that(in_array_or(['1', 2], [1, 2, 3], true))->isTrue();
        that(in_array_or(['1', '2'], [1, 2, 3], true))->isFalse();
    }

    function test_is_hasharray()
    {
        that(is_hasharray([]))->isFalse();
        that(is_hasharray([1]))->isFalse();
        that(is_hasharray([0 => 1]))->isFalse();
        that(is_hasharray([1 => 1]))->isTrue();
    }

    function test_is_indexarray()
    {
        that(is_indexarray([]))->isTrue();
        that(is_indexarray([1]))->isTrue();
        that(is_indexarray([0 => 1]))->isTrue();
        that(is_indexarray([1 => 1]))->isTrue();
        that(is_indexarray(['1' => 1]))->isTrue();
        that(is_indexarray(['key' => 1]))->isFalse();
    }

    function test_kvsort()
    {
        $array = array_pad([], 32, 'a');
        $shuffled = array_shuffle($array);

        // 安定ソートである
        that(kvsort($shuffled))->isSame($shuffled);

        // キーでソートできる
        that(kvsort($shuffled, fn($av, $bv, $ak, $bk) => ($ak <=> $bk)))->isSame($array);

        // 負数定数でリバースソートになる
        that(kvsort([1, 2, 3, 4, 5], -SORT_NUMERIC))->isSame(array_reverse([1, 2, 3, 4, 5], true));
        that(kvsort([0.1, 0.2, 0.3], -SORT_NUMERIC))->isSame(array_reverse([0.1, 0.2, 0.3], true));
        that(kvsort(['a', 'b', 'c'], -SORT_STRING))->isSame(array_reverse(['a', 'b', 'c'], true));

        // シュワルツ変換でソート可能
        that(kvsort(['a', 'b', 'c'], null, fn($v) => sha1($v)))->isSame([2 => 'c', 0 => 'a', 1 => 'b']);
        that(kvsort(['a', 'b', 'c'], SORT_DESC, fn($v) => sha1($v)))->isSame([1 => 'b', 0 => 'a', 2 => 'c']);
        that(kvsort(['a', 'b', 'c'], null, [
            'dummy' => fn($v) => 1,
            'sha1'  => fn($v) => sha1($v),
        ]))->isSame([2 => 'c', 0 => 'a', 1 => 'b']);

        // 配列じゃなくても Traversable ならソート可能
        that(kvsort((function () {
            yield 2;
            yield 1;
            yield 3;
        })()))->isSame([1 => 1, 0 => 2, 2 => 3]);

        // 上記は挙動のテストであってソートのテストを行っていないのでテスト
        $array = array_combine(range('a', 'z'), range('a', 'z'));
        that(kvsort(array_shuffle($array), fn($a, $b) => strcmp($a, $b)))->isSame($array);
    }

    function test_last_key()
    {
        that(last_key(['a', 'b', 'c']))->is(2);
        that(last_key(['a', 'b', 'c'], 'def'))->is(2);
        that(last_key([], 'def'))->is('def');
        that(last_key([]))->is(null);
    }

    function test_last_keyvalue()
    {
        that(last_keyvalue(['a', 'b', 'c']))->is([2, 'c']);
        that(last_keyvalue(['a', 'b', 'c'], 'def'))->is([2, 'c']);
        that(last_keyvalue([], 'def'))->is('def');
        that(last_keyvalue([]))->is(null);

        that(last_keyvalue(new \ArrayObject([1, 2, 3])))->is([2, 3]);
        that(last_keyvalue(new \ArrayObject([])))->is(null);
        that(last_keyvalue(new \stdClass()))->is(null);
    }

    function test_last_value()
    {
        that(last_value(['a', 'b', 'c']))->is('c');
        that(last_value(['a', 'b', 'c'], 'def'))->is('c');
        that(last_value([], 'def'))->is('def');
        that(last_value([]))->is(null);
    }

    function test_next_key()
    {
        // 数値キーのみ
        $array = ['a', 'b', 'c'];
        that(next_key($array))->isSame(3);
        that(next_key($array, 1))->isSame(2);
        that(next_key($array, 2))->isSame(null);
        that(next_key($array, 'xxx'))->isSame(false);
        // 文字キーのみ
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(next_key($array))->isSame(0);
        that(next_key($array, 'a'))->isSame('b');
        that(next_key($array, 'c'))->isSame(null);
        that(next_key($array, 'xxx'))->isSame(false);
        // 混在キー
        $array = ['a', 'b' => 'B', 'c'];
        that(next_key($array))->isSame(2);
        that(next_key($array, 'b'))->isSame(1);
        that(next_key($array, 1))->isSame(null);
        that(next_key($array, 'xxx'))->isSame(false);
        // 負数キー
        $array = [-4 => 'a', -3 => 'b', -2 => 'c'];
        that(next_key($array))->isSame(0);
        that(next_key($array, -3))->isSame(-2);
        that(next_key($array, -2))->isSame(null);
        that(next_key($array, 'xxx'))->isSame(false);
        // めっちゃバラバラキー
        $array = [-4 => 1, 3 => 2, 1 => 3, 2 => 4, -3 => 5, 'x' => 6];
        that(next_key($array))->isSame(4);
        that(next_key($array, 2))->isSame(-3);
        that(next_key($array, 'x'))->isSame(null);
        that(next_key($array, 'xxx'))->isSame(false);
    }

    function test_prev_key()
    {
        // 数値キーのみ
        $array = ['a', 'b', 'c'];
        that(prev_key($array, 1))->isSame(0);
        that(prev_key($array, 0))->isSame(null);
        that(prev_key($array, 'xxx'))->isSame(false);
        // 文字キーのみ
        $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(prev_key($array, 'b'))->isSame('a');
        that(prev_key($array, 'a'))->isSame(null);
        that(prev_key($array, 'xxx'))->isSame(false);
        // 混在キー
        $array = ['a', 'b' => 'B', 'c'];
        that(prev_key($array, 'b'))->isSame(0);
        that(prev_key($array, 0))->isSame(null);
        that(prev_key($array, 'xxx'))->isSame(false);
        // 負数キー
        $array = [-4 => 'a', -3 => 'b', -2 => 'c'];
        that(prev_key($array, -3))->isSame(-4);
        that(prev_key($array, -4))->isSame(null);
        that(prev_key($array, 'xxx'))->isSame(false);
        // めっちゃバラバラキー
        $array = [-4 => 1, 3 => 2, 1 => 3, 2 => 4, -3 => 5, 'x' => 6];
        that(prev_key($array, 2))->isSame(1);
        that(prev_key($array, -4))->isSame(null);
        that(prev_key($array, 'xxx'))->isSame(false);
    }
}
