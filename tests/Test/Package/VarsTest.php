<?php

namespace ryunosuke\Test\Package;

class VarsTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_stringify()
    {
        $stringify = stringify;
        $this->assertEquals('null', $stringify(null));
        $this->assertEquals('false', $stringify(false));
        $this->assertEquals('true', $stringify(true));
        $this->assertEquals('123', $stringify(123));
        $this->assertEquals('123.456', $stringify(123.456));
        $this->assertEquals('hoge', $stringify('hoge'));
        $this->assertEquals('Resource id #1', $stringify(STDIN));
        $this->assertEquals('[\'array\']', $stringify(['array']));
        $this->assertEquals('stdClass', $stringify(new \stdClass()));
        $this->assertEquals('hoge', $stringify(new \Concrete('hoge')));
        $this->assertEquals('C:11:"ArrayObject":36:{x:i:0;a:1:{i:0;s:4:"hoge";};m:a:0:{}}', $stringify(new \ArrayObject(['hoge'])));
        $this->assertEquals('JsonObject:["hoge"]', $stringify(new \JsonObject(['hoge'])));
    }

    function test_numberize()
    {
        $numberify = numberify;
        $this->assertSame(0, $numberify(null));
        $this->assertSame(0, $numberify(false));
        $this->assertSame(1, $numberify(true));
        $this->assertSame(0.0, $numberify(null, true));
        $this->assertSame(0.0, $numberify(false, true));
        $this->assertSame(1.0, $numberify(true, true));
        $this->assertSame(3, $numberify([1, 2, 3]));
        $this->assertSame(3.0, $numberify([1, 2, 3], true));
        $this->assertSame((int) STDIN, $numberify(STDIN));
        $this->assertSame(123, $numberify(new \Concrete('a12s3b')));

        $this->assertSame(123, $numberify(123));
        $this->assertSame(12, $numberify(12.3));

        $this->assertSame(123.0, $numberify(123, true));
        $this->assertSame(12.3, $numberify(12.3, true));

        $this->assertSame(123, $numberify('aaa123bbb'));
        $this->assertSame(123, $numberify('a1b2c3'));
        $this->assertSame(-123, $numberify('-a1b2c3'));

        $this->assertSame(12, $numberify('aaa12.3bbb'));
        $this->assertSame(12, $numberify('a1b2.c3'));
        $this->assertSame(-12, $numberify('-a1b2c.3'));

        $this->assertSame(12.3, $numberify('aaa12.3bbb', true));
        $this->assertSame(12.3, $numberify('a1b2.c3', true));
        $this->assertSame(-12.3, $numberify('-a1b2c.3', true));

        $this->assertException('is not numeric', $numberify, 'aaa');
        $this->assertException('is not numeric', $numberify, 'a.a');
        $this->assertException('is not numeric', $numberify, '1.2.3', true);
    }

    function test_numval()
    {
        $numval = numval;
        $this->assertSame(3, $numval(3));
        $this->assertSame(3.14, $numval(3.14));
        $this->assertSame(3, $numval('3'));
        $this->assertSame(3.14, $numval('3.14'));
        $this->assertSame(3.0, $numval('3.'));
        $this->assertSame(0.3, $numval('.3'));
        $this->assertSame(3.14, $numval(new \Concrete('3.14')));
        $this->assertSame(0, $numval([]));
        $this->assertSame(1, $numval([1, 2]));

        $this->assertSame(30, $numval(30, 8));
        $this->assertSame(30.0, $numval(30.0, 8));
        $this->assertSame(24, $numval("30", 8));
        $this->assertSame(48, $numval("30", 16));
    }

    function test_arrayval()
    {
        $arrayval = arrayval;
        $this->assertEquals(['str'], $arrayval('str'));
        $this->assertEquals(['array'], $arrayval(['array']));
        $this->assertEquals(array_map($arrayval, [1, 'str', ['array']]), [
            [1],
            ['str'],
            ['array'],
        ]);

        $ao = new \ArrayObject([1, 2, 3]);
        $this->assertSame([
            'k'  => 'v',
            'ao' => [1, 2, 3],
        ], $arrayval([
            'k'  => 'v',
            'ao' => $ao,
        ]));
        $this->assertSame([
            'k'  => 'v',
            'ao' => $ao,
        ], $arrayval([
            'k'  => 'v',
            'ao' => $ao,
        ], false));

        $inner = (stdclass)([
            'inner-scalar2',
            (stdclass)([
                'lastleaf',
            ]),
        ]);
        $stdclass = (stdclass)([
            'key'   => 'inner-scalar1',
            'inner' => $inner
        ]);

        $this->assertSame([
            'key'   => 'inner-scalar1',
            'inner' => [
                'inner-scalar2',
                [
                    'lastleaf'
                ]
            ]
        ], $arrayval($stdclass, true));

        $this->assertSame([
            'key'   => 'inner-scalar1',
            'inner' => $inner
        ], $arrayval($stdclass, false));
    }

    function test_si_prefix()
    {
        $si_prefix = si_prefix;
        $units = [
            -24 => 'y', // ヨクト
            -21 => 'z', // ゼプト
            -18 => 'a', // アト
            -15 => 'f', // フェムト
            -12 => 'p', // ピコ
            -9  => 'n', // ナノ
            -6  => 'µ', // マイクロ
            -3  => 'm', // ミリ
            0   => ' ',  //
            3   => 'k', // キロ
            6   => 'M', // メガ
            9   => 'G', // ギガ
            12  => 'T', // テラ
            15  => 'P', // ペタ
            18  => 'E', // エクサ
            21  => 'Z', // ゼタ
            24  => 'Y', // ヨタ
        ];
        foreach ($units as $exp => $unit) {
            $plus = $si_prefix(pow(10, $exp));
            $this->assertContains('1.000', $plus, "10^$exp");
            $this->assertStringEndsWith($unit, $plus, "10^$exp");

            $minus = $si_prefix(-pow(10, $exp));
            $this->assertContains('-1.000', $minus, "10^$exp");
            $this->assertStringEndsWith($unit, $minus, "10^$exp");
        }

        $this->assertEquals('0.000 ', $si_prefix("0.0"));
        $this->assertEquals('0.000 ', $si_prefix("0"));
        $this->assertEquals('0.000 ', $si_prefix(0));
        $this->assertEquals('0.000 ', $si_prefix(0.0));
        $this->assertEquals('999.000 ', $si_prefix(999));
        $this->assertEquals('1.000 k', $si_prefix(1000));
        $this->assertEquals('1.001 k', $si_prefix(1001));
        $this->assertEquals([0, ''], $si_prefix(0, null));
        $this->assertEquals([12.345, 'k'], $si_prefix(12345, null));

        $this->assertException('too large or small', $si_prefix, pow(10, 30));
    }

    function test_is_empty()
    {
        $is_empty = is_empty;
        $stdclass = new \stdClass();
        $xmlelem1 = new \SimpleXMLElement('<foo>1</foo>');
        $xmlelem2 = new \SimpleXMLElement('<foo></foo>');
        // この辺は empty と全く同じ（true）
        $this->assertSame(empty(null), $is_empty(null));
        $this->assertSame(empty(false), $is_empty(false));
        $this->assertSame(empty(0), $is_empty(0));
        $this->assertSame(empty(0.0), $is_empty(0.0));
        $this->assertSame(empty(''), $is_empty(''));
        $this->assertSame(empty([]), $is_empty([]));
        // この辺は empty と全く同じ（false）
        $this->assertSame(empty($stdclass), $is_empty($stdclass));
        $this->assertSame(empty($xmlelem1), $is_empty($xmlelem1));
        $this->assertSame(empty(true), $is_empty(true));
        $this->assertSame(empty(1), $is_empty(1));
        $this->assertSame(empty(1.0), $is_empty(1.0));
        $this->assertSame(empty('0.0'), $is_empty('0.0'));
        $this->assertSame(empty('00'), $is_empty('00'));
        $this->assertSame(empty([1]), $is_empty([1]));
        // この辺は差異がある
        $this->assertNotSame(empty('0'), $is_empty('0'));
        $this->assertNotSame(empty($xmlelem2), $is_empty($xmlelem2));
    }

    function test_is_primitive()
    {
        $is_primitive = is_primitive;
        $this->assertTrue($is_primitive(null));
        $this->assertTrue($is_primitive(false));
        $this->assertTrue($is_primitive(true));
        $this->assertTrue($is_primitive(123));
        $this->assertTrue($is_primitive(123.456));
        $this->assertTrue($is_primitive('hoge'));
        $this->assertTrue($is_primitive(STDIN));

        $this->assertFalse($is_primitive(['array']));
        $this->assertFalse($is_primitive(new \stdClass()));
    }

    function test_is_recursive()
    {
        $is_recursive = is_recursive;
        $this->assertFalse($is_recursive(null));
        $this->assertFalse($is_recursive(false));
        $this->assertFalse($is_recursive(true));
        $this->assertFalse($is_recursive(123));
        $this->assertFalse($is_recursive(123.456));
        $this->assertFalse($is_recursive('hoge'));
        $this->assertFalse($is_recursive(STDIN));
        $this->assertFalse($is_recursive(['hoge']));
        $this->assertFalse($is_recursive((object) ['hoge' => 'hoge']));

        $rarray = [];
        $rarray = ['rec' => &$rarray];
        $this->assertTrue($is_recursive($rarray));

        $rnestarray = [];
        $rnestarray = [
            'parent' => [
                'child' => [
                    'grand' => &$rnestarray
                ]
            ]
        ];
        $this->assertTrue($is_recursive($rnestarray));

        $robject = new \stdClass();
        $robject->rec = $robject;
        $this->assertTrue($is_recursive($robject));

        $rnestobject = new \stdClass();
        $rnestobject->parent = new \stdClass();
        $rnestobject->parent->child = new \stdClass();
        $rnestobject->parent->child->grand = $rnestobject;
        $this->assertTrue($is_recursive($rnestobject));
    }

    function test_is_stringable()
    {
        $is_stringable = is_stringable;
        $this->assertTrue($is_stringable(null));
        $this->assertTrue($is_stringable(false));
        $this->assertTrue($is_stringable(true));
        $this->assertTrue($is_stringable(123));
        $this->assertTrue($is_stringable(123.456));
        $this->assertTrue($is_stringable('hoge'));
        $this->assertTrue($is_stringable(STDIN));
        $this->assertFalse($is_stringable(['array']));
        $this->assertFalse($is_stringable(new \stdClass()));
        $this->assertTrue($is_stringable(new \Concrete('hoge')));
    }

    function test_is_arrayable()
    {
        $is_arrayable = is_arrayable;
        $this->assertTrue($is_arrayable([]));
        $this->assertTrue($is_arrayable(new \ArrayObject()));

        $this->assertFalse($is_arrayable(1));
        $this->assertFalse($is_arrayable(new \stdClass()));
    }

    function test_is_iterable()
    {
        $is_iterable = is_iterable;
        $this->assertTrue($is_iterable([1, 2, 3]));
        $this->assertTrue($is_iterable(new \ArrayIterator([1, 2, 3])));
        $this->assertTrue($is_iterable((function () { yield 1; })()));

        $this->assertFalse($is_iterable(1));
        $this->assertFalse($is_iterable(new \stdClass()));
    }

    function test_is_countable()
    {
        $is_countable = is_countable;
        $this->assertTrue($is_countable([1, 2, 3]));
        $this->assertTrue($is_countable(new \ArrayObject()));

        $this->assertFalse($is_countable((function () { yield 1; })()));
        $this->assertFalse($is_countable(1));
        $this->assertFalse($is_countable(new \stdClass()));
    }

    function test_varcmp()
    {
        $varcmp = varcmp;
        // regular int
        $this->assertGreaterThan(0, $varcmp(1, 0));
        $this->assertLessThan(0, $varcmp(0, 1));
        $this->assertEquals(0, $varcmp(0, 0));
        $this->assertEquals(0, $varcmp(1, 1));

        // regular float
        $this->assertGreaterThan(0, $varcmp(1.1, 1));
        $this->assertLessThan(0, $varcmp(1, 1.1));
        $this->assertEquals(0, $varcmp(1.1, 1.1));

        // regular string
        $this->assertGreaterThan(0, $varcmp('1.1', '1'));
        $this->assertLessThan(0, $varcmp('1', '1.1'));
        $this->assertEquals(0, $varcmp('1.1', '1.1'));

        // string int
        $this->assertGreaterThan(0, $varcmp('1', '0', SORT_NUMERIC));
        $this->assertLessThan(0, $varcmp('0', '1', SORT_NUMERIC));
        $this->assertEquals(0, $varcmp('0', '0', SORT_NUMERIC));
        $this->assertEquals(0, $varcmp('1', '1', SORT_NUMERIC));

        // string float
        $this->assertGreaterThan(0, $varcmp('1.1', '1', SORT_NUMERIC));
        $this->assertLessThan(0, $varcmp('1', '1.1', SORT_NUMERIC));
        $this->assertEquals(0, $varcmp('1.1', '1.1', SORT_NUMERIC));

        // string
        $this->assertGreaterThan(0, $varcmp('a', 'A', SORT_STRING));
        $this->assertLessThan(0, $varcmp('A', 'a', SORT_STRING));
        $this->assertEquals(0, $varcmp('abc', 'abc', SORT_STRING));

        // string(icase)
        $this->assertGreaterThan(0, $varcmp('A2', 'a1', SORT_STRING | SORT_FLAG_CASE));
        $this->assertLessThan(0, $varcmp('a1', 'A2', SORT_STRING | SORT_FLAG_CASE));
        $this->assertEquals(0, $varcmp('ABC', 'abc', SORT_STRING | SORT_FLAG_CASE));

        // string natural
        $this->assertGreaterThan(0, $varcmp('12', '2', SORT_NATURAL));
        $this->assertLessThan(0, $varcmp('2', '12', SORT_NATURAL));
        $this->assertEquals(0, $varcmp('0', '0', SORT_NATURAL));

        // string natural(icase)
        $this->assertGreaterThan(0, $varcmp('a12', 'A2', SORT_NATURAL | SORT_FLAG_CASE));
        $this->assertLessThan(0, $varcmp('A2', 'a12', SORT_NATURAL | SORT_FLAG_CASE));
        $this->assertEquals(0, $varcmp('ABC', 'abc', SORT_NATURAL | SORT_FLAG_CASE));

        // string(SORT_FLAG_CASE only)
        $this->assertGreaterThan(0, $varcmp('A2', 'a1', SORT_FLAG_CASE));
        $this->assertLessThan(0, $varcmp('a1', 'A2', SORT_FLAG_CASE));
        $this->assertEquals(0, $varcmp('ABC', 'abc', SORT_FLAG_CASE));

        // string(transitive )
        $a = '1f1';
        $b = '1E1';
        $c = '9';
        $this->assertGreaterThan(0, $varcmp($a, $b, SORT_FLAG_CASE));
        $this->assertGreaterThan(0, $varcmp($c, $a, SORT_FLAG_CASE));
        $this->assertGreaterThan(0, $varcmp($c, $b, SORT_FLAG_CASE));

        // array
        $a = [1, 2, 3, 9];
        $b = [1, 2, 3, 0];
        $x = [1, 2, 3, 9];
        $this->assertGreaterThan(0, $varcmp($a, $b));
        $this->assertLessThan(0, $varcmp($b, $a));
        $this->assertEquals(0, $varcmp($a, $x));

        // object
        $a = (stdclass)(['a' => 1, 'b' => 2, 'c' => 3, 'x' => 9]);
        $b = (stdclass)(['a' => 1, 'b' => 2, 'c' => 3, 'x' => 0]);
        $x = (stdclass)(['a' => 1, 'b' => 2, 'c' => 3, 'x' => 9]);
        $this->assertGreaterThan(0, $varcmp($a, $b));
        $this->assertLessThan(0, $varcmp($b, $a));
        $this->assertEquals(0, $varcmp($a, $x));

        // DateTime
        $a = new \DateTime('2011/12/23 12:34:56');
        $b = new \DateTime('2010/12/23 12:34:56');
        $x = new \DateTime('2011/12/23 12:34:56');
        $this->assertGreaterThan(0, $varcmp($a, $b));
        $this->assertLessThan(0, $varcmp($b, $a));
        $this->assertEquals(0, $varcmp($a, $x));
    }

    function test_var_type()
    {
        $var_type = var_type;
        $this->assertEquals('NULL', $var_type(null));
        $this->assertEquals('boolean', $var_type(false));
        $this->assertEquals('boolean', $var_type(true));
        $this->assertEquals('integer', $var_type(123));
        $this->assertEquals('double', $var_type(123.456));
        $this->assertEquals('string', $var_type('hoge'));
        $this->assertEquals('resource', $var_type(STDIN));
        $this->assertEquals('array', $var_type(['array']));
        $this->assertEquals('\\' . \stdClass::class, $var_type(new \stdClass()));
        $this->assertEquals('\\' . \Concrete::class, $var_type(new \Concrete('hoge')));
    }

    function test_var_apply()
    {
        $var_apply = var_apply;
        // 単値であればそのまま適用される
        $this->assertSame(123, $var_apply('123', numval));
        $this->assertSame(83, $var_apply('123', numval, 8));
        // 配列なら中身に適用される
        $this->assertSame([123, 456], $var_apply(['123', '456'], numval));
        $this->assertSame([83, 302], $var_apply(['123', '456'], numval, 8));
        // 再帰で処理される
        $this->assertSame([123, 456, 'a' => [789]], $var_apply(['123', '456', 'a' => ['789']], numval));
        // よくあるやつ
        $this->assertSame(['&lt;x&gt;', ['&lt;y&gt;']], $var_apply(['<x>', ['<y>']], 'htmlspecialchars', ENT_QUOTES, 'utf-8'));
    }

    function test_var_applys()
    {
        $var_applys = var_applys;
        $upper = function ($array) { return array_map('strtoupper', $array); };
        $this->assertSame($var_applys('a', $upper), 'A');
        $this->assertSame($var_applys(['a', 'b'], $upper), ['A', 'B']);
    }

    function test_var_export2()
    {
        $var_export2 = var_export2;
        $value = [
            'array'       => [1, 2, 3,],
            'hash'        => [
                'a' => 'A',
                'b' => 'B',
            ],
            'empty'       => [],
            'emptyempty'  => [[]],
            'emptyempty1' => [[[1]]],
            'nest'        => [
                'hash'  => [
                    'a'    => 'A',
                    'b'    => 'B',
                    'hash' => [
                        'x' => 'X',
                    ],
                ],
                'array' => [
                    [1, 2, 3, ['X']]
                ],
            ],
            'null'        => null,
            'int'         => 123,
            'string'      => 'ABC',
            'object'      => new \DateTime(),
        ];
        $a1 = var_export($value, true);
        $a2 = $var_export2($value, true);
        $this->assertEquals(eval("return $a1;"), eval("return $a2;"));

        $this->assertSame(<<<'EXPECTED'
[
    '\'' . "\0" . '\'' => 123,
    'key'              => 456,
    'null'             => null,
    'nulls'            => [null],
]
EXPECTED
            , $var_export2([
                "'\0'"  => 123,
                'key'   => 456,
                'null'  => null,
                'nulls' => [null],
            ], true));

        $this->expectOutputRegex('#hoge#');
        $var_export2('hoge');
    }

    function test_var_export2_private()
    {
        $var_export2 = var_export2;
        $concrete = new \Concrete('hoge');

        $this->assertEquals(<<<'VAR'
Concrete::__set_state([
    'value' => null,
    'name'  => 'hoge',
])
VAR
            , $var_export2($concrete, true));

        $concrete->external = 'aaa';
        $this->assertEquals(<<<'VAR'
Concrete::__set_state([
    'value'    => null,
    'name'     => 'hoge',
    'external' => 'aaa',
])
VAR
            , $var_export2($concrete, true));
    }

    function test_var_export2_recursive()
    {
        $var_export2 = var_export2;
        $rarray = [];
        $rarray['parent']['child']['grand'] = &$rarray;
        $this->assertEquals(<<<'VAR'
[
    'parent' => [
        'child' => [
            'grand' => '*RECURSION*',
        ],
    ],
]
VAR
            , $var_export2($rarray, true));

        $robject = new \stdClass();
        $robject->parent = new \stdClass();
        $robject->parent->child = new \stdClass();
        $robject->parent->child->grand = $robject;
        $this->assertEquals(<<<'VAR'
stdClass::__set_state([
    'parent' => stdClass::__set_state([
        'child' => stdClass::__set_state([
            'grand' => '*RECURSION*',
        ]),
    ]),
])
VAR
            , $var_export2($robject, true));

    }

    function test_var_html()
    {
        $var_html = var_html;
        $value = [
            'array'       => [1, 2, 3,],
            'hash'        => [
                'a' => 'A',
                'b' => 'B',
            ],
            'empty'       => [],
            'emptyempty'  => [[]],
            'emptyempty1' => [[[1]]],
            'nest'        => [
                'hash'  => [
                    'a'    => 'A',
                    'b'    => 'B',
                    'hash' => [
                        'x' => 'X',
                    ],
                ],
                'array' => [
                    [1, 2, 3, ['X']]
                ],
            ],
            'null'        => null,
            'int'         => 123,
            'string'      => 'ABC',
            'object'      => new \DateTime(),
            'resource'    => STDOUT,
        ];
        $this->expectOutputRegex('#<pre class=\'var_html\'>#');
        $var_html($value);
    }

    function test_hashvar()
    {
        $hoge = 1;
        $fuga = 2;
        $piyo = 3;
        $this->assertEquals(compact('hoge'), (hashvar)($hoge));
        $this->assertEquals(compact('piyo', 'fuga'), (hashvar)($piyo, $fuga));

        // 同一行で2回呼んでも引数の数が異なれば区別できる
        $this->assertEquals([compact('hoge'), compact('piyo', 'fuga')], [(hashvar)($hoge), (hashvar)($piyo, $fuga)]);

        // 引数の数が同じでも行が異なれば区別できる
        $this->assertEquals([compact('hoge'), compact('fuga')], [
            (hashvar)($hoge),
            (hashvar)($fuga),
        ]);

        // 即値は使用できない
        $this->assertException(new \UnexpectedValueException('variable'), function () {
            $hoge = 1;
            (hashvar)($hoge, 1);
        });

        // 同一行に同じ引数2つだと区別出来ない
        $this->assertException(new \UnexpectedValueException('ambiguous'), function () {
            $hoge = 1;
            $fuga = 2;
            [(hashvar)($hoge), (hashvar)($fuga)];
        });
    }
}
