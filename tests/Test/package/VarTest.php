<?php
namespace ryunosuke\Test\package;

class VarTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_stringify()
    {
        $this->assertEquals('null', stringify(null));
        $this->assertEquals('false', stringify(false));
        $this->assertEquals('true', stringify(true));
        $this->assertEquals('123', stringify(123));
        $this->assertEquals('123.456', stringify(123.456));
        $this->assertEquals('hoge', stringify('hoge'));
        $this->assertEquals('Resource id #1', stringify(STDIN));
        $this->assertEquals('[\'array\']', stringify(['array']));
        $this->assertEquals('stdClass', stringify(new \stdClass()));
        $this->assertEquals('hoge', stringify(new \Concrete('hoge')));
        $this->assertEquals('C:11:"ArrayObject":36:{x:i:0;a:1:{i:0;s:4:"hoge";};m:a:0:{}}', stringify(new \ArrayObject(['hoge'])));
        $this->assertEquals('JsonObject:["hoge"]', stringify(new \JsonObject(['hoge'])));
    }

    function test_is_primitive()
    {
        $this->assertTrue(is_primitive(null));
        $this->assertTrue(is_primitive(false));
        $this->assertTrue(is_primitive(true));
        $this->assertTrue(is_primitive(123));
        $this->assertTrue(is_primitive(123.456));
        $this->assertTrue(is_primitive('hoge'));
        $this->assertTrue(is_primitive(STDIN));

        $this->assertFalse(is_primitive(['array']));
        $this->assertFalse(is_primitive(new \stdClass()));
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
            'object'      => new \DateTime(),
        ];
        $a1 = var_export($value, true);
        $a2 = var_export2($value, true);
        $this->assertEquals(eval("return $a1;"), eval("return $a2;"));

        $this->expectOutputRegex('#hoge#');
        var_export2('hoge');
    }

    function test_hashvar()
    {
        $hoge = 1;
        $fuga = 2;
        $piyo = 3;
        $this->assertEquals(compact('hoge'), hashvar($hoge));
        $this->assertEquals(compact('piyo', 'fuga'), hashvar($piyo, $fuga));

        // 同一行で2回呼んでも引数の数が異なれば区別できる
        $this->assertEquals([compact('hoge'), compact('piyo', 'fuga')], [hashvar($hoge), hashvar($piyo, $fuga)]);

        // 引数の数が同じでも行が異なれば区別できる
        $this->assertEquals([compact('hoge'), compact('fuga')], [
            hashvar($hoge),
            hashvar($fuga),
        ]);

        // 即値は使用できない
        $this->assertException(new \UnexpectedValueException('variable'), function () {
            $hoge = 1;
            hashvar($hoge, 1);
        });

        // 同一行に同じ引数2つだと区別出来ない
        $this->assertException(new \UnexpectedValueException('ambiguous'), function () {
            $hoge = 1;
            $fuga = 2;
            [hashvar($hoge), hashvar($fuga)];
        });
    }
}
