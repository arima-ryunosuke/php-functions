<?php

namespace ryunosuke\Test\Package;

class ClassobjTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_stdclass()
    {
        $fields = ['a', 'b'];
        $stdclass = (stdclass)($fields);
        $this->assertInstanceOf('stdClass', $stdclass);
        // $this->assertEquals($fields, get_object_vars((stdclass))); php7 から OK になっている？
        $this->assertTrue(property_exists($stdclass, '0'));
        $this->assertEquals('a', $stdclass->{'0'});

        // キャストでもいいが、こういうことはできん
        $stdclass = (object) $fields;
        $this->assertInstanceOf('stdClass', $stdclass);
        // $this->assertEquals([], get_object_vars((stdclass))); php7 から OK になっている？
        // $this->assertFalse(property_exists((stdclass), '0')); php7.2 から OK になっている？
    }

    function test_detect_namespace()
    {
        $this->assertEquals('ryunosuke\\Test\\Package', (detect_namespace)(__DIR__));
        $this->assertEquals('ryunosuke\\Test\\Package\\Classobj', (detect_namespace)(__DIR__ . '/Classobj'));
        $this->assertEquals('ryunosuke\\Test\\Package\\Classobj\\NS', (detect_namespace)(__DIR__ . '/Classobj/NS'));
        $this->assertEquals('A\\B\\C', (detect_namespace)(__DIR__ . '/Classobj/NS/Valid'));
        $this->assertEquals('A\\B\\C\\Hoge', (detect_namespace)(__DIR__ . '/Classobj/NS/Valid/Hoge.php'));
        $this->assertEquals('ryunosuke\\Functions\\Package', (detect_namespace)(__DIR__ . '/../../../src/Package'));
        $this->assertException('can not detect namespace', detect_namespace, '/a/b/c/d/e/f/g/h/i/j/k/l/m/n');
    }

    function test_class_loader()
    {
        $this->assertException('not found', function () {
            (class_loader)(sys_get_temp_dir());
        });
    }

    function test_class_namespace()
    {
        $this->assertEquals('', (class_namespace)(new \stdClass()));
        $this->assertEquals('', (class_namespace)('\PHPUnit_Framework_TestCase'));
        // php の名前空間・クラス名は \\ 無しに統一されていたはず
        $this->assertEquals('vendor\\namespace', (class_namespace)('vendor\\namespace\\ClassName'));
        $this->assertEquals('vendor\\namespace', (class_namespace)('\\vendor\\namespace\\ClassName'));
    }

    function test_class_shorten()
    {
        $this->assertEquals('stdClass', (class_shorten)(new \stdClass()));
        $this->assertEquals('PHPUnit_Framework_TestCase', (class_shorten)('\PHPUnit_Framework_TestCase'));
        $this->assertEquals('ClassName', (class_shorten)('vendor\\namespace\\ClassName'));
        $this->assertEquals('ClassName', (class_shorten)('\\vendor\\namespace\\ClassName'));
    }

    function test_class_replace()
    {
        $this->assertException('already declared', function () {
            (class_replace)(__CLASS__, function () { });
        });
        $this->assertException('multi classes', function () {
            (class_replace)('\\ryunosuke\\Test\\package\\Classobj\\A', function () {
                require_once __DIR__ . '/Classobj/_.php';
            });
        });

        (class_replace)('\\ryunosuke\\Test\\package\\Classobj\\A', function () {
            require_once __DIR__ . '/Classobj/A_.php';
        });

        (class_replace)('\\ryunosuke\\Test\\package\\Classobj\\B', function () {
            require_once __DIR__ . '/Classobj/B_.php';
            /** @noinspection PhpUndefinedClassInspection */
            return new \B();
        });

        (class_replace)('\\ryunosuke\\Test\\package\\Classobj\\C', function () {
            return [
                'newMethod' => function () {
                    return 'this is ' . (new \ReflectionClass($this))->getShortName();
                },
                'f'         => function () {
                    return parent::f();
                },
            ];
        });

        $this->assertEquals([
            'this is exA',
            'this is exB',
        ], (new \ryunosuke\Test\package\Classobj\B())->f());

        $classC = new \ryunosuke\Test\package\Classobj\C();
        $this->assertEquals([
            'this is exA',
            'this is exB',
            'this is C',
        ], $classC->f());
        $this->assertEquals('this is C__', $classC->newMethod());

        $classD = new \ryunosuke\Test\package\Classobj\D();
        $this->assertEquals([
            'this is exA',
            'this is exB',
            'this is C',
            'this is D',
        ], $classD->f());
        $this->assertEquals('this is D', $classD->newMethod());
    }

    function test_object_dive()
    {
        $class = (stdclass)([
            'a' => (stdclass)([
                'b' => (stdclass)([
                    'c' => 'abc',
                ])
            ])
        ]);
        $this->assertEquals('abc', (object_dive)($class, 'a.b.c'));
        $this->assertEquals('none', (object_dive)($class, 'a.b.c.x', 'none'));
        $this->assertEquals('none', (object_dive)($class, 'a.b.X', 'none'));
    }

    function test_get_object_properties()
    {
        $concrete = new \Concrete('name');
        $concrete->value = 'value';
        /** @noinspection PhpUndefinedFieldInspection */
        $concrete->oreore = 'oreore';
        $this->assertEquals([
            'value'  => 'value',
            'name'   => 'name',
            'oreore' => 'oreore',
        ], (get_object_properties)($concrete));
    }
}
