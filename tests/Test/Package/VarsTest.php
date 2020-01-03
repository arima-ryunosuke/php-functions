<?php

namespace ryunosuke\Test\Package;

use ryunosuke\Functions\Package\Vars;
use stdClass;

class VarsTest extends AbstractTestCase
{
    function test_stringify()
    {
        that((stringify)(null))->is('null');
        that((stringify)(false))->is('false');
        that((stringify)(true))->is('true');
        that((stringify)(123))->is('123');
        that((stringify)(123.456))->is('123.456');
        that((stringify)('hoge'))->is('hoge');
        that((stringify)(STDIN))->is('Resource id #1');
        that((stringify)(['array']))->is('["array"]');
        that((stringify)(new \stdClass()))->is('stdClass');
        that((stringify)(new \Concrete('hoge')))->is('hoge');
        that((stringify)(new \SerialObject('hoge')))->is('C:12:"SerialObject":11:{s:4:"hoge";}');
        that((stringify)(new \JsonObject(['hoge'])))->is('JsonObject:["hoge"]');
    }

    function test_numberize()
    {
        that((numberify)(null))->isSame(0);
        that((numberify)(false))->isSame(0);
        that((numberify)(true))->isSame(1);
        that((numberify)(null, true))->isSame(0.0);
        that((numberify)(false, true))->isSame(0.0);
        that((numberify)(true, true))->isSame(1.0);
        that((numberify)([1, 2, 3]))->isSame(3);
        that((numberify)([1, 2, 3], true))->isSame(3.0);
        that((numberify)(STDIN))->isSame((int) STDIN);
        that((numberify)(new \Concrete('a12s3b')))->isSame(123);

        that((numberify)(123))->isSame(123);
        that((numberify)(12.3))->isSame(12);

        that((numberify)(123, true))->isSame(123.0);
        that((numberify)(12.3, true))->isSame(12.3);

        that((numberify)('aaa123bbb'))->isSame(123);
        that((numberify)('a1b2c3'))->isSame(123);
        that((numberify)('-a1b2c3'))->isSame(-123);

        that((numberify)('aaa12.3bbb'))->isSame(12);
        that((numberify)('a1b2.c3'))->isSame(12);
        that((numberify)('-a1b2c.3'))->isSame(-12);

        that((numberify)('aaa12.3bbb', true))->isSame(12.3);
        that((numberify)('a1b2.c3', true))->isSame(12.3);
        that((numberify)('-a1b2c.3', true))->isSame(-12.3);

        that([numberify, 'aaa'])->throws('is not numeric');
        that([numberify, 'a.a'])->throws('is not numeric');
        that([numberify, '1.2.3', true])->throws('is not numeric');
    }

    function test_numval()
    {
        that((numval)(3))->isSame(3);
        that((numval)(3.14))->isSame(3.14);
        that((numval)('3'))->isSame(3);
        that((numval)('3.14'))->isSame(3.14);
        that((numval)('3.'))->isSame(3.0);
        that((numval)('.3'))->isSame(0.3);
        that((numval)(new \Concrete('3.14')))->isSame(3.14);
        that((numval)([]))->isSame(0);
        that((numval)([1, 2]))->isSame(1);

        that((numval)(30, 8))->isSame(30);
        that((numval)(30.0, 8))->isSame(30.0);
        that((numval)("30", 8))->isSame(24);
        that((numval)("30", 16))->isSame(48);
    }

    function test_arrayval()
    {
        that((arrayval)('str'))->is(['str']);
        that((arrayval)(['array']))->is(['array']);
        that(array_map((arrayval), [1, 'str', ['array']]))->is([
            [1],
            ['str'],
            ['array'],
        ]);

        $ao = new \ArrayObject([1, 2, 3]);
        that((arrayval)([
            'k'  => 'v',
            'ao' => $ao,
        ]))->isSame([
            'k'  => 'v',
            'ao' => [1, 2, 3],
        ]);
        that((arrayval)([
            'k'  => 'v',
            'ao' => $ao,
        ], false))->isSame([
            'k'  => 'v',
            'ao' => $ao,
        ]);

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

        that((arrayval)($stdclass, true))->isSame([
            'key'   => 'inner-scalar1',
            'inner' => [
                'inner-scalar2',
                [
                    'lastleaf'
                ]
            ]
        ]);

        that((arrayval)($stdclass, false))->isSame([
            'key'   => 'inner-scalar1',
            'inner' => $inner
        ]);
    }

    function test_arrayable_key_exists()
    {
        $array = [
            'ok'    => 'OK',
            'null'  => null,
            'false' => false,
        ];
        that((arrayable_key_exists)('ok', $array))->isTrue();
        that((arrayable_key_exists)('null', $array))->isTrue();
        that((arrayable_key_exists)('false', $array))->isTrue();
        that((arrayable_key_exists)('notfound', $array))->isFalse();

        $object = new class implements \ArrayAccess
        {
            private $holder = [
                'ok'    => 'OK',
                'null'  => null,
                'false' => false,
            ];

            public function offsetExists($offset)
            {
                return isset($this->holder[$offset]);
            }

            public function offsetGet($offset)
            {
                if ($offset === 'ex') {
                    throw new \OutOfBoundsException();
                }
                return $this->holder[$offset];
            }

            public function offsetSet($offset, $value) { }

            public function offsetUnset($offset) { }
        };
        that((arrayable_key_exists)('ok', $object))->isTrue();
        that((arrayable_key_exists)('null', $object))->isTrue();
        that((arrayable_key_exists)('false', $object))->isTrue();
        that((arrayable_key_exists)('notfound', $object))->isFalse();
        that((arrayable_key_exists)('ex', $object))->isFalse();

        that([arrayable_key_exists, null, new \stdClass()])->throws('must be array or ArrayAccess');
    }

    function test_si_prefix()
    {
        foreach (Vars::SI_UNITS as $exp => $units) {
            $unit = $units[0] ?? ' ';
            that((si_prefix)(+pow(1000, $exp)))
                ->stringContains('1.000')
                ->stringEndsWith($unit);

            that((si_prefix)(-pow(1000, $exp)))
                ->stringContains('-1.000')
                ->stringEndsWith($unit);

            that((si_prefix)(+pow(2, $exp * 10), 1024))
                ->stringContains('1.000')
                ->stringEndsWith($unit);

            that((si_prefix)(-pow(2, $exp * 10), 1024))
                ->stringContains('-1.000')
                ->stringEndsWith($unit);
        }

        that((si_prefix)("0.0"))->is('0.000 ');
        that((si_prefix)("0"))->is('0.000 ');
        that((si_prefix)(0))->is('0.000 ');
        that((si_prefix)(0.0))->is('0.000 ');
        that((si_prefix)(999))->is('999.000 ');
        that((si_prefix)(1000))->is('1.000 k');
        that((si_prefix)(1001))->is('1.001 k');
        that((si_prefix)(1023, 1024))->is('1023.000 ');
        that((si_prefix)(1024, 1024))->is('1.000 k');
        that((si_prefix)(1025, 1024))->is('1.001 k');
        that((si_prefix)(0, 1000, null))->is([0, '']);
        that((si_prefix)(12345, 1000, null))->is([12.345, 'k']);
        that((si_prefix)(12345, 1000, function ($v, $u) {
            return number_format($v, 2) . $u;
        }))->is('12.35k');

        that([si_prefix, pow(10, 30)])->throws('too large or small');
    }

    function test_si_unprefix()
    {
        foreach (Vars::SI_UNITS as $exp => $units) {
            foreach ($units as $unit) {
                that((si_unprefix)("1$unit"))->is(+pow(1000, $exp));
                that((si_unprefix)("-1$unit"))->is(-pow(1000, $exp));

                that((si_unprefix)("1$unit", 1024))->is(+pow(2, $exp * 10));
                that((si_unprefix)("-1$unit", 1024))->is(-pow(2, $exp * 10));
            }
        }

        that((si_unprefix)("0.0"))->is(0);
        that((si_unprefix)("0"))->is(0);
        that((si_unprefix)(0))->is(0);
        that((si_unprefix)(0.0))->is(0);
        that((si_unprefix)('999'))->is(999);
        that((si_unprefix)('1k'))->is(1000);
        that((si_unprefix)('1023', 1024))->is(1023);
        that((si_unprefix)('1k', 1024))->is(1024);
        that((si_unprefix)('1K', 1024))->is(1024);
    }

    function test_is_empty()
    {
        $stdclass = new \stdClass();
        $arrayo1 = new \ArrayObject([1]);
        $arrayo2 = new \ArrayObject([]);
        // この辺は empty と全く同じ（true）
        that((is_empty)(null))->isSame(empty(null));
        that((is_empty)(false))->isSame(empty(false));
        that((is_empty)(0))->isSame(empty(0));
        that((is_empty)(0.0))->isSame(empty(0.0));
        that((is_empty)(''))->isSame(empty(''));
        that((is_empty)([]))->isSame(empty([]));
        // この辺は empty と全く同じ（false）
        that((is_empty)($stdclass))->isSame(empty($stdclass));
        that((is_empty)($arrayo1))->isSame(empty($arrayo1));
        that((is_empty)(true))->isSame(empty(true));
        that((is_empty)(1))->isSame(empty(1));
        that((is_empty)(1.0))->isSame(empty(1.0));
        that((is_empty)('0.0'))->isSame(empty('0.0'));
        that((is_empty)('00'))->isSame(empty('00'));
        that((is_empty)([1]))->isSame(empty([1]));
        // この辺は差異がある
        that((is_empty)('0'))->isNotSame(empty('0'));
        that((is_empty)($arrayo2))->isNotSame(empty($arrayo2));

        /// stdClass だけは引数で分岐できる
        $stdclass = new \stdClass();
        $stdClassEx = new class extends stdClass
        {
        };

        // 空 stdClass は空
        that((is_empty)($stdclass, true))->isTrue();
        // 空でなければ空ではない
        $stdclass->hoge = 123;
        that((is_empty)($stdclass, true))->isFalse();
        // 継承していれば空でも空ではない
        that((is_empty)($stdClassEx, true))->isFalse();
        // 自明だが継承して空でなければ空ではない
        $stdClassEx->hoge = 123;
        that((is_empty)($stdClassEx, true))->isFalse();

    }

    function test_is_primitive()
    {
        that((is_primitive)(null))->isTrue();
        that((is_primitive)(false))->isTrue();
        that((is_primitive)(true))->isTrue();
        that((is_primitive)(123))->isTrue();
        that((is_primitive)(123.456))->isTrue();
        that((is_primitive)('hoge'))->isTrue();
        that((is_primitive)(STDIN))->isTrue();

        that((is_primitive)(['array']))->isFalse();
        that((is_primitive)(new \stdClass()))->isFalse();
    }

    function test_is_recursive()
    {
        that((is_recursive)(null))->isFalse();
        that((is_recursive)(false))->isFalse();
        that((is_recursive)(true))->isFalse();
        that((is_recursive)(123))->isFalse();
        that((is_recursive)(123.456))->isFalse();
        that((is_recursive)('hoge'))->isFalse();
        that((is_recursive)(STDIN))->isFalse();
        that((is_recursive)(['hoge']))->isFalse();
        that((is_recursive)((object) ['hoge' => 'hoge']))->isFalse();

        $rarray = [];
        $rarray = ['rec' => &$rarray];
        that((is_recursive)($rarray))->isTrue();

        $rnestarray = [];
        $rnestarray = [
            'parent' => [
                'child' => [
                    'grand' => &$rnestarray
                ]
            ]
        ];
        that((is_recursive)($rnestarray))->isTrue();

        $robject = new \stdClass();
        $robject->rec = $robject;
        that((is_recursive)($robject))->isTrue();

        $rnestobject = new \stdClass();
        $rnestobject->parent = new \stdClass();
        $rnestobject->parent->child = new \stdClass();
        $rnestobject->parent->child->grand = $rnestobject;
        that((is_recursive)($rnestobject))->isTrue();
    }

    function test_is_stringable()
    {
        that((is_stringable)(null))->isTrue();
        that((is_stringable)(false))->isTrue();
        that((is_stringable)(true))->isTrue();
        that((is_stringable)(123))->isTrue();
        that((is_stringable)(123.456))->isTrue();
        that((is_stringable)('hoge'))->isTrue();
        that((is_stringable)(STDIN))->isTrue();
        that((is_stringable)(['array']))->isFalse();
        that((is_stringable)(new \stdClass()))->isFalse();
        that((is_stringable)(new \Concrete('hoge')))->isTrue();
    }

    function test_is_arrayable()
    {
        that((is_arrayable)([]))->isTrue();
        that((is_arrayable)(new \ArrayObject()))->isTrue();

        that((is_arrayable)(1))->isFalse();
        that((is_arrayable)(new \stdClass()))->isFalse();
    }

    function test_is_countable()
    {
        that((is_countable)([1, 2, 3]))->isTrue();
        that((is_countable)(new \ArrayObject()))->isTrue();

        that((is_countable)((function () { yield 1; })()))->isFalse();
        that((is_countable)(1))->isFalse();
        that((is_countable)(new \stdClass()))->isFalse();
    }

    function test_varcmp()
    {
        // strict
        that((varcmp)(['b' => 'B', 'a' => 'A'], ['a' => 'A', 'b' => 'B'], \ryunosuke\Functions\Package\Vars::SORT_STRICT))->lessThan(0); // 推移律が成り立ってない
        that((varcmp)(['a' => 'A', 'b' => 'B'], ['b' => 'B', 'a' => 'A'], \ryunosuke\Functions\Package\Vars::SORT_STRICT))->lessThan(0);
        that((varcmp)(['a' => 'A', 'b' => 'B'], ['a' => 'A', 'b' => 'B'], \ryunosuke\Functions\Package\Vars::SORT_STRICT))->is(0);

        // regular int
        that((varcmp)(1, 0))->greaterThan(0);
        that((varcmp)(0, 1))->lessThan(0);
        that((varcmp)(0, 0))->is(0);
        that((varcmp)(1, 1))->is(0);

        // regular float
        that((varcmp)(1.1, 1))->greaterThan(0);
        that((varcmp)(1, 1.1))->lessThan(0);
        that((varcmp)(1.1, 1.1))->is(0);

        // regular string
        that((varcmp)('1.1', '1'))->greaterThan(0);
        that((varcmp)('1', '1.1'))->lessThan(0);
        that((varcmp)('1.1', '1.1'))->is(0);

        // string int
        that((varcmp)('1', '0', SORT_NUMERIC))->greaterThan(0);
        that((varcmp)('0', '1', SORT_NUMERIC))->lessThan(0);
        that((varcmp)('0', '0', SORT_NUMERIC))->is(0);
        that((varcmp)('1', '1', SORT_NUMERIC))->is(0);

        // string float
        that((varcmp)('1.1', '1', SORT_NUMERIC))->greaterThan(0);
        that((varcmp)('1', '1.1', SORT_NUMERIC))->lessThan(0);
        that((varcmp)('1.1', '1.1', SORT_NUMERIC))->is(0);

        // string
        that((varcmp)('a', 'A', SORT_STRING))->greaterThan(0);
        that((varcmp)('A', 'a', SORT_STRING))->lessThan(0);
        that((varcmp)('abc', 'abc', SORT_STRING))->is(0);

        // string(icase)
        that((varcmp)('A2', 'a1', SORT_STRING | SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)('a1', 'A2', SORT_STRING | SORT_FLAG_CASE))->lessThan(0);
        that((varcmp)('ABC', 'abc', SORT_STRING | SORT_FLAG_CASE))->is(0);

        // string natural
        that((varcmp)('12', '2', SORT_NATURAL))->greaterThan(0);
        that((varcmp)('2', '12', SORT_NATURAL))->lessThan(0);
        that((varcmp)('0', '0', SORT_NATURAL))->is(0);

        // string natural(icase)
        that((varcmp)('a12', 'A2', SORT_NATURAL | SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)('A2', 'a12', SORT_NATURAL | SORT_FLAG_CASE))->lessThan(0);
        that((varcmp)('ABC', 'abc', SORT_NATURAL | SORT_FLAG_CASE))->is(0);

        // string(SORT_FLAG_CASE only)
        that((varcmp)('A2', 'a1', SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)('a1', 'A2', SORT_FLAG_CASE))->lessThan(0);
        that((varcmp)('ABC', 'abc', SORT_FLAG_CASE))->is(0);

        // string(transitive )
        $a = '1f1';
        $b = '1E1';
        $c = '9';
        that((varcmp)($a, $b, SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)($c, $a, SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)($c, $b, SORT_FLAG_CASE))->greaterThan(0);

        // array
        $a = [1, 2, 3, 9];
        $b = [1, 2, 3, 0];
        $x = [1, 2, 3, 9];
        that((varcmp)($a, $b))->greaterThan(0);
        that((varcmp)($b, $a))->lessThan(0);
        that((varcmp)($a, $x))->is(0);

        // object
        $a = (stdclass)(['a' => 1, 'b' => 2, 'c' => 3, 'x' => 9]);
        $b = (stdclass)(['a' => 1, 'b' => 2, 'c' => 3, 'x' => 0]);
        $x = (stdclass)(['a' => 1, 'b' => 2, 'c' => 3, 'x' => 9]);
        that((varcmp)($a, $b))->greaterThan(0);
        that((varcmp)($b, $a))->lessThan(0);
        that((varcmp)($a, $x))->is(0);

        // DateTime
        $a = new \DateTime('2011/12/23 12:34:56');
        $b = new \DateTime('2010/12/23 12:34:56');
        $x = new \DateTime('2011/12/23 12:34:56');
        that((varcmp)($a, $b))->greaterThan(0);
        that((varcmp)($b, $a))->lessThan(0);
        that((varcmp)($a, $x))->is(0);
    }

    function test_var_type()
    {
        that((var_type)(null))->is('NULL');
        that((var_type)(false))->is('boolean');
        that((var_type)(true))->is('boolean');
        that((var_type)(123))->is('integer');
        that((var_type)(123.456))->is('double');
        that((var_type)('hoge'))->is('string');
        that((var_type)(STDIN))->is('resource');
        that((var_type)(['array']))->is('array');
        that((var_type)(new \stdClass()))->is('\\' . \stdClass::class);
        that((var_type)(new \Concrete('hoge')))->is('\\' . \Concrete::class);

        that((var_type)(new class extends \stdClass implements \JsonSerializable
        {
            public function jsonSerialize() { return ''; }
        }))->is('\stdClass');
        that((var_type)(new class implements \JsonSerializable
        {
            public function jsonSerialize() { return ''; }
        }))->is('\JsonSerializable');
        that((var_type)(new class extends \stdClass
        {
        }))->is('\stdClass');
        that((var_type)(new class
        {
        }))->stringContains('anonymous');
    }

    function test_var_type_valid()
    {
        that((var_type)(null, true))->is('null');
        that((var_type)(true, true))->is('bool');
        that((var_type)(123, true))->is('int');
        that((var_type)(123.456, true))->is('float');
        that((var_type)('hoge', true))->is('string');
        that((var_type)(STDIN, true))->is('resource');
        that((var_type)(['array'], true))->is('array');
    }

    function test_var_apply()
    {
        // 単値であればそのまま適用される
        that((var_apply)('123', numval))->isSame(123);
        that((var_apply)('123', numval, 8))->isSame(83);
        // 配列なら中身に適用される
        that((var_apply)(['123', '456'], numval))->isSame([123, 456]);
        that((var_apply)(['123', '456'], numval, 8))->isSame([83, 302]);
        // 再帰で処理される
        that((var_apply)(['123', '456', 'a' => ['789']], numval))->isSame([123, 456, 'a' => [789]]);
        // よくあるやつ
        that((var_apply)(['<x>', ['<y>']], 'htmlspecialchars', ENT_QUOTES, 'utf-8'))->isSame(['&lt;x&gt;', ['&lt;y&gt;']]);
    }

    function test_var_applys()
    {
        $upper = function ($array) { return array_map('strtoupper', $array); };
        that((var_applys)('a', $upper))->isSame('A');
        that((var_applys)(['a', 'b'], $upper))->isSame(['A', 'B']);
    }

    function test_var_export2()
    {
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
            'object'      => new \Concrete('hoge'),
        ];
        $a1 = var_export($value, true);
        $a2 = (var_export2)($value, true);
        that(eval("return $a2;"))->is(eval("return $a1;"));

        that((var_export2)([
            "'\0\""  => 123,
            '$var'   => '$var',
            '${var}' => '${var}',
            '{$var}' => '{$var}',
            "\n"     => "\n",
            "\\"     => "\\",
            '"'      => '"',
            'key'    => 456,
            'null'   => null,
            'nulls'  => [null],
        ], true))->isSame(<<<'EXPECTED'
[
    "'\000\"" => 123,
    "\$var"   => "\$var",
    "\${var}" => "\${var}",
    "{\$var}" => "{\$var}",
    "
"       => "
",
    "\\"      => "\\",
    "\""      => "\"",
    "key"     => 456,
    "null"    => null,
    "nulls"   => [null],
]
EXPECTED
        );

        $this->expectOutputRegex('#hoge#');
        (var_export2)('hoge');
    }

    function test_var_export2_private()
    {
        $concrete = new \Concrete('hoge');

        that((var_export2)($concrete, true))->is(<<<'VAR'
Concrete::__set_state([
    "value" => null,
    "name"  => "hoge",
])
VAR
        );

        $concrete->external = 'aaa';
        that((var_export2)($concrete, true))->is(<<<'VAR'
Concrete::__set_state([
    "value"    => null,
    "name"     => "hoge",
    "external" => "aaa",
])
VAR
        );
    }

    function test_var_export2_recursive()
    {
        $rarray = [];
        $rarray['parent']['child']['grand'] = &$rarray;
        that((var_export2)($rarray, true))->is(<<<'VAR'
[
    "parent" => [
        "child" => [
            "grand" => "*RECURSION*",
        ],
    ],
]
VAR
        );

        $robject = new \stdClass();
        $robject->parent = new \stdClass();
        $robject->parent->child = new \stdClass();
        $robject->parent->child->grand = $robject;
        that((var_export2)($robject, true))->is(<<<'VAR'
stdClass::__set_state([
    "parent" => stdClass::__set_state([
        "child" => stdClass::__set_state([
            "grand" => "*RECURSION*",
        ]),
    ]),
])
VAR
        );

    }

    function test_var_html()
    {
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
        (var_html)($value);
    }

    function test_var_pretty()
    {
        that([var_pretty, null, 'hoge'])->throws('is not supported');

        $recur = ['a' => 'A'];
        $recur['r'] = &$recur;
        $closure = function () use ($recur) { return $recur; };
        $value = [
            (stdclass)([
                'A' => (stdclass)([
                    'X' => new \stdClass(),
                ]),
            ]),
            'E' => new \Concrete('hoge'),
            'A' => ["str", 1, 2, 3, true, null],
            'H' => ['a' => 'A', 'b' => 'B'],
            'C' => $closure,
            'R' => STDOUT,
        ];

        that((var_pretty)($value, 'plain', true))
            ->stringContains("  0: stdClass#")
            ->stringContains("      X: stdClass#")
            ->stringContains("  E: Concrete#")
            ->stringContains("  A: ['str', 1, 2, 3, true, null]")
            ->stringContains("ryunosuke\\Test\\Package\\VarsTest#")
            ->stringContains("    recur: {")
            ->stringContains("      r: '*RECURSION*'")
            ->stringContains("  R: Resource id #2 of type (stream)");

        that((var_pretty)($value, 'cli', true))->stringContains("\033");
        that((var_pretty)($value, 'html', true))->stringContains("<span");

        $this->expectOutputRegex('#Concrete#');
        (var_pretty)($value);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_console_log()
    {
        $this->expectOutputRegex('#aaa#');
        (console_log)('aaa');
        echo 'aaa';
        ob_end_flush();
    }

    function test_console_log_ex()
    {
        $this->expectExceptionMessage('header is already sent');
        (console_log)('aaa');
    }

    function test_hashvar()
    {
        $hoge = 1;
        $fuga = 2;
        $piyo = 3;
        that((hashvar)($hoge))->is(compact('hoge'));
        that((hashvar)($piyo, $fuga))->is(compact('piyo', 'fuga'));

        // 同一行で2回呼んでも引数の数が異なれば区別できる
        that([(hashvar)($hoge), (hashvar)($piyo, $fuga)])->is([compact('hoge'), compact('piyo', 'fuga')]);

        // 引数の数が同じでも行が異なれば区別できる
        that([
            (hashvar)($hoge),
            (hashvar)($fuga),
        ])->is([compact('hoge'), compact('fuga')]);

        // 即値は使用できない
        that(function () {
            $hoge = 1;
            (hashvar)($hoge, 1);
        })->throws(new \UnexpectedValueException('variable'));

        // 同一行に同じ引数2つだと区別出来ない
        that(function () {
            $hoge = 1;
            $fuga = 2;
            [(hashvar)($hoge), (hashvar)($fuga)];
        })->throws(new \UnexpectedValueException('ambiguous'));
    }
}
