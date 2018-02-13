<?php

namespace ryunosuke\Test\Package;

use ryunosuke\Functions\Package\Vars;

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
        ];
        $this->expectOutputRegex('#<pre class=\'var_html\'>#');
        $var_html($value);
    }

    function test_hashvar()
    {
        $hoge = 1;
        $fuga = 2;
        $piyo = 3;
        $this->assertEquals(compact('hoge'), Vars::hashvar($hoge));
        $this->assertEquals(compact('piyo', 'fuga'), Vars::hashvar($piyo, $fuga));

        // 同一行で2回呼んでも引数の数が異なれば区別できる
        $this->assertEquals([compact('hoge'), compact('piyo', 'fuga')], [Vars::hashvar($hoge), Vars::hashvar($piyo, $fuga)]);

        // 引数の数が同じでも行が異なれば区別できる
        $this->assertEquals([compact('hoge'), compact('fuga')], [
            Vars::hashvar($hoge),
            Vars::hashvar($fuga),
        ]);

        // 即値は使用できない
        $this->assertException(new \UnexpectedValueException('variable'), function () {
            $hoge = 1;
            Vars::hashvar($hoge, 1);
        });

        // 同一行に同じ引数2つだと区別出来ない
        $this->assertException(new \UnexpectedValueException('ambiguous'), function () {
            $hoge = 1;
            $fuga = 2;
            [Vars::hashvar($hoge), Vars::hashvar($fuga)];
        });
    }

    function test_hashvar_global()
    {
        if (function_exists('hashvar')) {
            $hoge = 1;
            $fuga = 2;
            $piyo = 3;
            $this->assertEquals(compact('hoge'), hashvar($hoge));
            $this->assertEquals(compact('piyo', 'fuga'), hashvar($piyo, $fuga));
        }
        else {
            function hashvar()
            {
            }
        }
    }
}