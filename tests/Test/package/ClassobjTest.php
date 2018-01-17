<?php
namespace ryunosuke\Test\package;

class ClassobjTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_stdclass()
    {
        $fields = ['a', 'b'];
        $stdclass = stdclass($fields);
        $this->assertInstanceOf('stdClass', $stdclass);
        // $this->assertEquals($fields, get_object_vars($stdclass)); php7 から OK になっている？
        $this->assertTrue(property_exists($stdclass, '0'));
        $this->assertEquals('a', $stdclass->{'0'});

        // キャストでもいいが、こういうことはできん
        $stdclass = (object) $fields;
        $this->assertInstanceOf('stdClass', $stdclass);
        // $this->assertEquals([], get_object_vars($stdclass)); php7 から OK になっている？
        $this->assertFalse(property_exists($stdclass, '0'));
    }

    function test_class_loader()
    {
        $this->assertException('not found', function () {
            class_loader(sys_get_temp_dir());
        });
    }

    function test_class_namespace()
    {
        $this->assertEquals('', class_namespace(new \stdClass()));
        $this->assertEquals('', class_namespace('\PHPUnit_Framework_TestCase'));
        // php の名前空間・クラス名は \\ 無しに統一されていたはず
        $this->assertEquals('vendor\\namespace', class_namespace('vendor\\namespace\\ClassName'));
        $this->assertEquals('vendor\\namespace', class_namespace('\\vendor\\namespace\\ClassName'));
    }

    function test_class_shorten()
    {
        $this->assertEquals('stdClass', class_shorten(new \stdClass()));
        $this->assertEquals('PHPUnit_Framework_TestCase', class_shorten('\PHPUnit_Framework_TestCase'));
        $this->assertEquals('ClassName', class_shorten('vendor\\namespace\\ClassName'));
        $this->assertEquals('ClassName', class_shorten('\\vendor\\namespace\\ClassName'));
    }

    function test_class_replace()
    {
        $this->assertException('already declared', function () {
            class_replace(__CLASS__, function () { });
        });
        $this->assertException('multi classes', function () {
            class_replace('\\ryunosuke\\Test\\package\\Classobj\\A', function () {
                require_once __DIR__ . '/Classobj/_.php';
            });
        });

        class_replace('\\ryunosuke\\Test\\package\\Classobj\\A', function () {
            require_once __DIR__ . '/Classobj/A_.php';
        });

        class_replace('\\ryunosuke\\Test\\package\\Classobj\\B', function () {
            require_once __DIR__ . '/Classobj/B_.php';
            /** @noinspection PhpUndefinedClassInspection */
            return new \B();
        });

        $this->assertEquals([
            'this is exA',
            'this is exB',
        ], (new \ryunosuke\Test\package\Classobj\B())->f());

        $this->assertEquals([
            'this is exA',
            'this is exB',
            'this is C',
        ], (new \ryunosuke\Test\package\Classobj\C())->f());
    }

    function test_has_class_methods()
    {
        $this->assertTrue(has_class_methods('Exception', 'getMessage'));
        $this->assertTrue(has_class_methods('Exception', 'getmessage'));
        $this->assertFalse(has_class_methods('Exception', 'undefined'));
    }
}
