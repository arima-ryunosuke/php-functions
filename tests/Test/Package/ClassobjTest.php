<?php

namespace ryunosuke\Test\Package;

use stdClass;

class ClassobjTest extends AbstractTestCase
{
    function test_stdclass()
    {
        $fields = ['a', 'b'];
        that((stdclass)($fields))
            ->isInstanceOf(stdClass::class)
            ->{0}->is('a')
            ->{1}->is('b');
    }

    function test_detect_namespace()
    {
        that((detect_namespace)(__DIR__))->is('ryunosuke\\Test\\Package');
        that((detect_namespace)(__DIR__ . '/Classobj'))->is('ryunosuke\\Test\\Package\\Classobj');
        that((detect_namespace)(__DIR__ . '/Classobj/NS'))->is('ryunosuke\\Test\\Package\\Classobj\\NS');
        that((detect_namespace)(__DIR__ . '/Classobj/NS/Valid'))->is('A\\B\\C');
        that((detect_namespace)(__DIR__ . '/Classobj/NS/Valid/Hoge.php'))->is('A\\B\\C\\Hoge');
        that((detect_namespace)(__DIR__ . '/../../../src/Package'))->is('ryunosuke\\Functions\\Package');
        that([detect_namespace, '/a/b/c/d/e/f/g/h/i/j/k/l/m/n'])->throws('can not detect namespace');
    }

    function test_class_uses_all()
    {
        eval('trait T1{}');
        eval('trait T2{use T1;}');
        eval('trait T3{use T2;}');
        that((class_uses_all)(new class
        {
            use /** @noinspection PhpUndefinedClassInspection */ \T1;
        }))->is(['T1']);
        that((class_uses_all)(new class
        {
            use /** @noinspection PhpUndefinedClassInspection */ \T2;
        }))->is(['T2', 'T1']);
        that((class_uses_all)(new class
        {
            use /** @noinspection PhpUndefinedClassInspection */ \T3;
        }))->is(['T3', 'T2', 'T1']);
        that((class_uses_all)(get_class(new class
        {
            use /** @noinspection PhpUndefinedClassInspection */ \T1;
            use /** @noinspection PhpUndefinedClassInspection */ \T2;
            use /** @noinspection PhpUndefinedClassInspection */ \T3;
        })))->is(['T1', 'T2', 'T3']);

        that((class_uses_all)(new stdClass()))->is([]);
    }

    function test_class_loader()
    {
        that([class_loader, '/notfounddir'])->throws('not found');
    }

    function test_class_namespace()
    {
        that((class_namespace)(new \stdClass()))->is('');
        that((class_namespace)('\PHPUnit_Framework_TestCase'))->is('');
        // php の名前空間・クラス名は \\ 無しに統一されていたはず
        that((class_namespace)('vendor\\namespace\\ClassName'))->is('vendor\\namespace');
        that((class_namespace)('\\vendor\\namespace\\ClassName'))->is('vendor\\namespace');
    }

    function test_class_shorten()
    {
        that((class_shorten)(new \stdClass()))->is('stdClass');
        that((class_shorten)('\PHPUnit_Framework_TestCase'))->is('PHPUnit_Framework_TestCase');
        that((class_shorten)('vendor\\namespace\\ClassName'))->is('ClassName');
        that((class_shorten)('\\vendor\\namespace\\ClassName'))->is('ClassName');
    }

    function test_class_replace()
    {
        that([class_replace, __CLASS__, function () { }])->throws('already declared');
        that([
            class_replace,
            '\\ryunosuke\\Test\\package\\Classobj\\A',
            function () { require_once __DIR__ . '/Classobj/_.php'; }
        ])->throws('multi classes');

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

        that((new \ryunosuke\Test\package\Classobj\B())->f())->is([
            'this is exA',
            'this is exB',
        ]);

        /** @var \Traitable $classC */
        $classC = new \ryunosuke\Test\package\Classobj\C();
        that($classC->publicField)->is('Traitable');
        that($classC->traitMethod())->is('Traitable');
        /** @noinspection PhpUndefinedMethodInspection */
        {
            that($classC->f())->is([
                'this is exA',
                'this is exB',
                'this is C',
            ]);
            that($classC->g('string', true, new \ArrayObject([3])))->is(['string', true, new \ArrayObject([3])]);
            that($classC->newMethod())->is('this is C__');
        }

        $classD = new \ryunosuke\Test\package\Classobj\D();
        that($classD->f())->is([
            'this is exA',
            'this is exB',
            'this is C',
            'this is D',
        ]);
        /** @noinspection PhpUndefinedMethodInspection */
        that($classD->newMethod())->is('this is D');
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

        that($object->fuga)->is('dummy');
        $object->fuga = 'dummy2';
        that($object->fuga)->is('dummy2');
        /** @noinspection PhpUndefinedFieldInspection */
        {
            $object->piyo = 'dummy3';
            that($object->piyo)->is('dummy3');
            that($original->piyo)->is('dummy3');
            $original->piyo = 'dummy4';
            that($object->piyo)->is('dummy4');
            that($original->piyo)->is('dummy4');
        }

        $object->setFields('a', 'b', 'c', 'd');
        $result = $object->hoge(9);
        that($result['this'])->isInstanceOf(\ryunosuke\Test\Package\Classobj\ClassExtends::class);
        that($result['method'])->is('private:a');
        that($result['arg'])->is(9);

        $object->setFields('A1', 'B', 'C', 'D');
        that($original->publicMethod())->is('public:A1');
        $original->setFields('A2', 'B', 'C', 'D');
        that($object->publicMethod())->is('public:A2');

        $object::$staticfield = 'foo';
        that($object::staticMethod())->is('static:foo');
        /** @noinspection PhpUndefinedMethodInspection */
        that($object::staticHoge(123))->is([
            'self'   => 'ryunosuke\Test\Package\Classobj\ClassExtends',
            'method' => 'static:foo',
            'arg'    => 123,
        ]);

        $original::$staticfield = 'bar';
        that($object::staticMethod())->is('static:bar');
        /** @noinspection PhpUndefinedMethodInspection */
        that($object::staticHoge(123))->is([
            'self'   => 'ryunosuke\Test\Package\Classobj\ClassExtends',
            'method' => 'static:bar',
            'arg'    => 123,
        ]);

        that($object->overrideMethod1('XX'))->is('A-overrideMethod1:XX-Z');
        that($object->overrideMethod2('--'))->is('overrideMethod2:--A-overrideMethod1:++-Z');

        // internal
        $e = (class_extends)(new \Exception('message', 123), [
            'codemessage' => function () {
                /** @noinspection PhpUndefinedFieldInspection */
                return $this->code . ':' . $this->message;
            },
        ]);
        /** @noinspection PhpUndefinedMethodInspection */
        that($e->codemessage())->is('123:message');
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
        that((const_exists)($class, "PRIVATE_CONST"))->isTrue();
        that((const_exists)($class, "PROTECTED_CONST"))->isTrue();
        that((const_exists)($class, "PUBLIC_CONST"))->isTrue();
        that((const_exists)($class, "UNDEFINED"))->isFalse();

        // クラス定数（1引数）
        that((const_exists)("$class::PRIVATE_CONST"))->isTrue();
        that((const_exists)("$class::PROTECTED_CONST"))->isTrue();
        that((const_exists)("$class::PUBLIC_CONST"))->isTrue();
        that((const_exists)("$class::UNDEFINED"))->isFalse();

        // グローバル定数
        that((const_exists)("PHP_VERSION"))->isTrue();
        that((const_exists)("UNDEFINED"))->isFalse();
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
        that((object_dive)($class, 'a.b.c'))->is('abc');
        that((object_dive)($class, 'a.b.c.x', 'none'))->is('none');
        that((object_dive)($class, 'a.b.X', 'none'))->is('none');
    }

    function test_get_class_constants()
    {
        $concrete = new class('hoge') extends \Concrete
        {
            private const   PPP = 0;
            protected const PP  = 1;
            public const    P   = 2;

            function dummy() { assert(self::PPP); }
        };

        that((get_class_constants)($concrete))->is([
            'PROTECTED_CONST' => null,
            'PUBLIC_CONST'    => null,
            'PPP'             => 0,
            'PP'              => 1,
            'P'               => 2,
        ]);

        /** @var \ryunosuke\Functions\Package\Classobj $class */
        $class = \ryunosuke\Functions\Package\Classobj::class;

        that((get_class_constants)($concrete, $class::IS_OWNSELF | $class::IS_PUBLIC | $class::IS_PROTECTED | $class::IS_PRIVATE))->is([
            'PPP' => 0,
            'PP'  => 1,
            'P'   => 2,
        ]);

        that((get_class_constants)($concrete, $class::IS_OWNSELF | $class::IS_PUBLIC | $class::IS_PROTECTED))->is([
            'PP' => 1,
            'P'  => 2,
        ]);

        that((get_class_constants)($concrete, $class::IS_OWNSELF | $class::IS_PUBLIC))->is([
            'P' => 2,
        ]);

        that((get_class_constants)($concrete, $class::IS_PUBLIC))->is([
            'P'            => 2,
            'PUBLIC_CONST' => null,
        ]);
    }

    function test_get_object_properties()
    {
        $concrete = new \Concrete('name');
        $concrete->value = 'value';
        /** @noinspection PhpUndefinedFieldInspection */
        $concrete->oreore = 'oreore';
        that((get_object_properties)($concrete))->is([
            'value'  => 'value',
            'name'   => 'name',
            'oreore' => 'oreore',
        ]);

        // 標準の var_export が親優先になっているのを変更しているテスト
        $object = new \Nest3();
        $object->set(999);

        // 復元したのに 999 になっていない（どうも同じキーの配列で __set_state されている模様）
        that((eval('return ' . var_export($object, true) . ';'))->get())->isSame(1);

        // get_object_properties はそのようなことにはならない
        that((eval('return ' . (var_export2)($object, true) . ';'))->get())->isSame(999);
    }
}
