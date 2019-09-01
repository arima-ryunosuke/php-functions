<?php

namespace ryunosuke\Test\Package;

class ClassobjTest extends AbstractTestCase
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
            return new \B();
        });

        (class_replace)('\\ryunosuke\\Test\\package\\Classobj\\C', [
            [\Traitable::class],
            'newMethod' => function () {
                return 'this is ' . (new \ReflectionClass($this))->getShortName();
            },
            'f'         => function () {
                /** @noinspection PhpUndefinedMethodInspection */
                return parent::f();
            },
            'g'         => function () {
                /** @noinspection PhpUndefinedMethodInspection */
                return parent::g(...func_get_args());
            },
        ]);

        $this->assertEquals([
            'this is exA',
            'this is exB',
        ], (new \ryunosuke\Test\package\Classobj\B())->f());

        /** @var \Traitable $classC */
        $classC = new \ryunosuke\Test\package\Classobj\C();
        $this->assertEquals('Traitable', $classC->publicField);
        $this->assertEquals('Traitable', $classC->traitMethod());
        /** @noinspection PhpUndefinedMethodInspection */
        {
            $this->assertEquals([
                'this is exA',
                'this is exB',
                'this is C',
            ], $classC->f());
            $this->assertEquals(['string', true, new \ArrayObject([3])], $classC->g('string', true, new \ArrayObject([3])));
            $this->assertEquals('this is C__', $classC->newMethod());
        }

        $classD = new \ryunosuke\Test\package\Classobj\D();
        $this->assertEquals([
            'this is exA',
            'this is exB',
            'this is C',
            'this is D',
        ], $classD->f());
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertEquals('this is D', $classD->newMethod());
    }

    function test_class_extends()
    {
        (rm_rf)(self::TMPDIR . getenv('TEST_TARGET'), false);
        require_once __DIR__ . '/Classobj/extends.php';
        $original = new \ryunosuke\Test\Package\Classobj\ClassExtends();
        /** @var \ryunosuke\Test\Package\Classobj\ClassExtends $object */
        $object = (class_extends)($original, [
            'hoge'            => function ($arg) {
                /** @noinspection PhpUndefinedMethodInspection */
                return [
                    'this'   => $this,
                    'method' => $this->privateMethod(),
                    'arg'    => $arg,
                ];
            },
            'staticHoge'      => static function ($arg) {
                /** @noinspection PhpUndefinedMethodInspection */
                return [
                    'self'   => get_called_class(),
                    'method' => self::staticMethod(),
                    'arg'    => $arg,
                ];
            },
            'overrideMethod1' => function (string $oreorearg) {
                return 'A-' . parent::{__FUNCTION__}($oreorearg) . '-Z';
            },
            'overrideMethod2' => function () {
                return parent::{__FUNCTION__}(...func_get_args()) . $this->{'overrideMethod1'}('++');
            },
        ], [
            'fuga' => 'dummy',
        ]);

        $this->assertEquals('dummy', $object->fuga);
        $object->fuga = 'dummy2';
        $this->assertEquals('dummy2', $object->fuga);
        /** @noinspection PhpUndefinedFieldInspection */
        {
            $object->piyo = 'dummy3';
            $this->assertEquals('dummy3', $object->piyo);
            $this->assertEquals('dummy3', $original->piyo);
            $original->piyo = 'dummy4';
            $this->assertEquals('dummy4', $object->piyo);
            $this->assertEquals('dummy4', $original->piyo);
        }

        $object->setFields('a', 'b', 'c', 'd');
        $result = $object->hoge(9);
        $this->assertInstanceOf(\ryunosuke\Test\Package\Classobj\ClassExtends::class, $result['this']);
        $this->assertEquals('private:a', $result['method']);
        $this->assertEquals(9, $result['arg']);

        $object->setFields('A1', 'B', 'C', 'D');
        $this->assertEquals('public:A1', $original->publicMethod());
        $original->setFields('A2', 'B', 'C', 'D');
        $this->assertEquals('public:A2', $object->publicMethod());

        $object::$staticfield = 'foo';
        $this->assertEquals('static:foo', $object::staticMethod());
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertEquals([
            'self'   => 'ryunosuke\Test\Package\Classobj\ClassExtends',
            'method' => 'static:foo',
            'arg'    => 123,
        ], $object::staticHoge(123));

        $original::$staticfield = 'bar';
        $this->assertEquals('static:bar', $object::staticMethod());
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertEquals([
            'self'   => 'ryunosuke\Test\Package\Classobj\ClassExtends',
            'method' => 'static:bar',
            'arg'    => 123,
        ], $object::staticHoge(123));

        $this->assertEquals('A-overrideMethod1:XX-Z', $object->overrideMethod1('XX'));
        $this->assertEquals('overrideMethod2:--A-overrideMethod1:++-Z', $object->overrideMethod2('--'));

        // internal
        $e = (class_extends)(new \Exception('message', 123), [
            'codemessage' => function () {
                /** @noinspection PhpUndefinedFieldInspection */
                return $this->code . ':' . $this->message;
            },
        ]);
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertEquals('123:message', $e->codemessage());
    }

    function test_const_exists()
    {
        $class = get_class(new class
        {
            private const   /** @noinspection PhpUnusedPrivateFieldInspection */
                            PRIVATE_CONST   = null;
            protected const PROTECTED_CONST = null;
            public const    PUBLIC_CONST    = null;
        });

        // クラス定数（2引数）
        $this->assertTrue((const_exists)($class, "PRIVATE_CONST"));
        $this->assertTrue((const_exists)($class, "PROTECTED_CONST"));
        $this->assertTrue((const_exists)($class, "PUBLIC_CONST"));
        $this->assertFalse((const_exists)($class, "UNDEFINED"));

        // クラス定数（1引数）
        $this->assertTrue((const_exists)("$class::PRIVATE_CONST"));
        $this->assertTrue((const_exists)("$class::PROTECTED_CONST"));
        $this->assertTrue((const_exists)("$class::PUBLIC_CONST"));
        $this->assertFalse((const_exists)("$class::UNDEFINED"));

        // グローバル定数
        $this->assertTrue((const_exists)("PHP_VERSION"));
        $this->assertFalse((const_exists)("UNDEFINED"));
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

        // 標準の var_export が親優先になっているのを変更しているテスト
        $object = new \Nest3();
        $object->set(999);

        // 復元したのに 999 になっていない（どうも同じキーの配列で __set_state されている模様）
        $this->assertSame(1, (eval('return ' . var_export($object, true) . ';'))->get());

        // get_object_properties はそのようなことにはならない
        $this->assertSame(999, (eval('return ' . (var_export2)($object, true) . ';'))->get());
    }
}
