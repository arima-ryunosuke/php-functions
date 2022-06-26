<?php

namespace ryunosuke\Test\Package;

use stdClass;

const PI = M_PI;

class ClassobjTest extends AbstractTestCase
{
    function test_stdclass()
    {
        $fields = ['a', 'b'];
        $stdclass = (stdclass)($fields);
        that($stdclass)->isInstanceOf(stdClass::class);
        that($stdclass)->{0}->is('a');
        that($stdclass)->{1}->is('b');
    }

    function test_detect_namespace()
    {
        that((detect_namespace)(__DIR__))->is('ryunosuke\\Test\\Package');
        that((detect_namespace)(__DIR__ . '/Classobj'))->is('ryunosuke\\Test\\Package\\Classobj');
        that((detect_namespace)(__DIR__ . '/Classobj/NS'))->is('ryunosuke\\Test\\Package\\Classobj\\NS');
        that((detect_namespace)(__DIR__ . '/Classobj/NS/Valid'))->is('A\\B\\C');
        that((detect_namespace)(__DIR__ . '/Classobj/NS/Valid/Hoge.php'))->is('A\\B\\C\\Hoge');
        that((detect_namespace)(__DIR__ . '/../../../src/Package'))->is('ryunosuke\\Functions\\Package');
        that(detect_namespace)('/a/b/c/d/e/f/g/h/i/j/k/l/m/n')->wasThrown('can not detect namespace');
    }

    function test_class_uses_all()
    {
        /** @noinspection PhpUndefinedClassInspection */
        {
            eval('trait T1{}');
            eval('trait T2{use T1;}');
            eval('trait T3{use T2;}');
        }
        that((class_uses_all)(new class {
            use /** @noinspection PhpUndefinedClassInspection */ \T1;
        }))->is(['T1']);
        that((class_uses_all)(new class {
            use /** @noinspection PhpUndefinedClassInspection */ \T2;
        }))->is(['T2', 'T1']);
        that((class_uses_all)(new class {
            use /** @noinspection PhpUndefinedClassInspection */ \T3;
        }))->is(['T3', 'T2', 'T1']);
        that((class_uses_all)(get_class(new class {
            use /** @noinspection PhpUndefinedClassInspection */ \T1;
            use /** @noinspection PhpUndefinedClassInspection */ \T2;
            use /** @noinspection PhpUndefinedClassInspection */ \T3;
        })))->is(['T1', 'T2', 'T3']);

        that((class_uses_all)(new stdClass()))->is([]);
    }

    function test_type_exists()
    {
        that((type_exists)(\Exception::class))->isTrue();
        that((type_exists)(\Throwable::class))->isTrue();
        that((type_exists)(\Traitable::class))->isTrue();

        spl_autoload_register(function ($class) {
            if (strpos($class, __NAMESPACE__) === 0) {
                require_once __DIR__ . '/Classobj/Type.php';
            }
        });

        that((type_exists)(Classobj\Type::class, false))->isFalse();
        that((type_exists)(Classobj\Typable::class, false))->isFalse();
        that((type_exists)(Classobj\TypeTrait::class, false))->isFalse();

        that((type_exists)(Classobj\Type::class, true))->isTrue();
        that((type_exists)(Classobj\Typable::class, true))->isTrue();
        that((type_exists)(Classobj\TypeTrait::class, true))->isTrue();
    }

    function test_auto_loader()
    {
        that((auto_loader)())->fileExists();
        that(auto_loader)('/notfounddir')->wasThrown('not found');
    }

    function test_class_loader()
    {
        that((class_loader)())->isObject();
        that(class_loader)('/notfounddir')->wasThrown('not found');
    }

    function test_class_aliases()
    {
        that((class_aliases)([
            'Alias\\Alias1' => Classobj\Alias1::class,
        ]))->is([
            'Alias\\Alias1' => Classobj\Alias1::class,
        ]);
        that(class_exists('Alias\\Alias1', false))->isFalse();
        that(class_exists('Alias\\Alias1', true))->isTrue();

        that((class_aliases)([
            'Alias\\Alias2' => Classobj\Alias2::class,
        ]))->is([
            'Alias\\Alias1' => Classobj\Alias1::class,
            'Alias\\Alias2' => Classobj\Alias2::class,
        ]);
        that(class_exists('Alias\\Alias2', false))->isFalse();
        that(class_exists('Alias\\Alias2', true))->isTrue();
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
        that(class_replace)(__CLASS__, function () { })->wasThrown('already declared');
        that(class_replace)('\\ryunosuke\\Test\\package\\Classobj\\A', function () { require_once __DIR__ . '/Classobj/_.php'; })->wasThrown('multi classes');

        (class_replace)('\\ryunosuke\\Test\\package\\Classobj\\A', function () {
            require_once __DIR__ . '/Classobj/A_.php';
        });

        (class_replace)('\\ryunosuke\\Test\\package\\Classobj\\B', function () {
            require_once __DIR__ . '/Classobj/B_.php';
            return new \B();
        });

        (class_replace)('\\ryunosuke\\Test\\package\\Classobj\\C1', [
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
        $classC = new \ryunosuke\Test\package\Classobj\C1();
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
            that($classC->newMethod())->is('this is C1__');
        }

        $classD = new \ryunosuke\Test\package\Classobj\D1();
        that($classD->f())->is([
            'this is exA',
            'this is exB',
            'this is C',
            'this is D',
        ]);
        /** @noinspection PhpUndefinedMethodInspection */
        that($classD->newMethod())->is('this is D1');

        (class_replace)('\\ryunosuke\\Test\\package\\Classobj\\C2', new class() extends \ryunosuke\Test\package\Classobj\B {
            use \Traitable {
                \Traitable::traitMethod as hge;
            }

            function newMethod()
            {
                return 'this is ' . (new \ReflectionClass($this))->getShortName();
            }

            function f()
            {
                return parent::f();
            }

            function g()
            {
                /** @noinspection PhpUndefinedMethodInspection */
                return parent::g(...func_get_args());
            }
        });

        /** @var \Traitable $classC */
        $classC = new \ryunosuke\Test\package\Classobj\C2();
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
            that($classC->newMethod())->is('this is C2__');
        }

        $classD = new \ryunosuke\Test\package\Classobj\D2();
        that($classD->f())->is([
            'this is exA',
            'this is exB',
            'this is C',
            'this is D',
        ]);
        /** @noinspection PhpUndefinedMethodInspection */
        that($classD->newMethod())->is('this is D2');
    }

    function test_class_extends()
    {
        (rm_rf)(self::$TMPDIR . getenv('TEST_TARGET'), false);
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
            'passByReference' => function (string &$arg1) {
                $arg1 .= '-suffix';
            },
            'overrideMethod1' => function (string $oreorearg) {
                return 'A-' . parent::{__FUNCTION__}($oreorearg) . '-Z';
            },
            'overrideMethod2' => function () {
                return parent::{__FUNCTION__}(...func_get_args()) . $this->{'overrideMethod1'}('++');
            },
        ], [
            'fuga' => 'dummy',
        ], [\ryunosuke\Test\Package\Classobj\Methods::class]);

        that($object)->isInstanceOf(\ryunosuke\Test\Package\Classobj\Methods::class);
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

        $string = 'hoge';
        /** @noinspection PhpUndefinedMethodInspection */
        $object->passByReference($string);
        that($string)->is('hoge-suffix');

        // internal
        $e = (class_extends)(new \Exception('message', 123), [
            'codemessage' => function () {
                /** @noinspection PhpUndefinedFieldInspection */
                return $this->code . ':' . $this->message;
            },
        ]);
        that($e->codemessage())->is('123:message');
    }

    function test_reflect_types()
    {
        $object = new class() {
            function m(?string $s, array $a, ?\ArrayObject $ao, $o, $n): void { }
        };
        $refmethod = new \ReflectionMethod($object, 'm');

        $types = (reflect_types)([
            new class($refmethod->getParameters()[0]->getType()) extends \ReflectionProperty {
                private $type;

                /** @noinspection PhpMissingParentConstructorInspection */
                public function __construct($type) { $this->type = $type; }

                public function getType(): ?\ReflectionType { return $this->type; }
            },
            $refmethod,
            $refmethod->getParameters()[1],
        ]);
        that($types)->count(4);
        that($types[0])->isInstanceOf(\ReflectionType::class);
        that($types->getName())->is('array|string|null|void');
        that($types->__toString())->is('array|string|null|void');

        $types = (reflect_types)($refmethod->getParameters()[0]);
        that($types)->count(2);
        that($types[0])->isInstanceOf(\ReflectionType::class);
        that($types->getName())->is('?string');
        that($types->__toString())->is('string|null');

        $types = (reflect_types)($refmethod->getParameters()[1]);
        that($types)->count(1);
        that($types[0])->isInstanceOf(\ReflectionType::class);
        that($types->getName())->is('array');
        that($types->__toString())->is('array');

        $types = (reflect_types)($refmethod->getParameters()[2]->getType());
        that($types)->count(2);
        that($types->getName())->is('?\\ArrayObject');
        that($types->__toString())->is('ArrayObject|null');

        $types = (reflect_types)($refmethod->getParameters()[3]->getType());
        that($types)->count(0);
        that($types->getName())->is('');
        that($types->__toString())->is('');

        $types = (reflect_types)($refmethod);
        that($types)->count(1);
        that($types[0])->isInstanceOf(\ReflectionType::class);
        that($types->getName())->is('void');
        that($types->__toString())->is('void');
        that(json_encode($types))->is(json_encode(['void']));

        $types = (reflect_types)();
        $types[0] = 'int';
        $types[1] = 'array';
        $types[2] = 'iterable';
        $types[3] = \Throwable::class;
        $types[4] = '?' . \ArrayObject::class;

        that($types)->count(5);
        that($types[0]->isBuiltin())->isTrue();
        that($types->getName())->is('\\ArrayObject|\\Throwable|iterable|int|null');
        that($types->getTypes())->eachIsInstanceOf(\ReflectionType::class);
        that(iterator_to_array($types))->eachIsInstanceOf(\ReflectionType::class);
        that($types->__toString())->is('ArrayObject|Throwable|iterable|int|null');

        $types[5] = 'object';

        that($types)->count(4);
        that($types->__toString())->is('iterable|object|int|null');

        that($types->allows(new \ArrayObject()))->isTrue();
        that($types->allows(new \Exception()))->isTrue();
        that($types->allows(new \ArrayIterator()))->isTrue();
        that($types->allows([]))->isTrue();
        that($types->allows(null))->isTrue();
        that($types->allows(false))->isTrue();
        that($types->allows(123))->isTrue();
        that($types->allows(123.4))->isTrue();
        that($types->allows("123"))->isTrue();
        that($types->allows("123.4"))->isTrue();
        that($types->allows("hoge"))->isFalse();

        $types = (reflect_types)();

        $types[0] = '?string';
        that($types->allows(null))->isTrue();
        that($types->allows("hoge"))->isTrue();
        that($types->allows(new \Exception()))->isTrue();
        that($types->allows(new \ArrayObject()))->isFalse();

        $types[0] = 'mixed';
        that($types->allows(STDOUT))->isTrue();

        $types = (reflect_types)();
        that(isset($types[0]))->isFalse();
        $types[] = 'mixed';
        $types[] = 'object';
        that($types[0])->is('mixed');
        that($types[1])->is('object');
        unset($types[0]);
        that(isset($types[0]))->isFalse();
    }

    function test_const_exists()
    {
        $class = get_class(new class {
            private const   /** @noinspection PhpUnusedPrivateFieldInspection */
                            PRIVATE_CONST   = null;
            protected const PROTECTED_CONST = null;
            public const    PUBLIC_CONST    = null;
        });

        // クラス定数（2引数）
        that((const_exists)($class, "PRIVATE_CONST"))->isTrue();
        that((const_exists)($class, "PROTECTED_CONST"))->isTrue();
        that((const_exists)($class, "PUBLIC_CONST"))->isTrue();

        // クラス定数（1引数）
        that((const_exists)("$class::PRIVATE_CONST"))->isTrue();
        that((const_exists)("$class::PROTECTED_CONST"))->isTrue();
        that((const_exists)("$class::PUBLIC_CONST"))->isTrue();

        // マジック定数
        that((const_exists)("$class::class"))->isTrue();
        that((const_exists)($class, "class"))->isTrue();
        that((const_exists)("$class::CLASS"))->isTrue();
        that((const_exists)($class, "CLASS"))->isTrue();

        // グローバル定数
        that((const_exists)("PHP_VERSION"))->isTrue();
        that((const_exists)('\ryunosuke\Test\Package\PI'))->isTrue();

        // 非存在
        that((const_exists)("UNDEFINED"))->isFalse();
        that((const_exists)($class, "UNDEFINED"))->isFalse();
        that((const_exists)("$class::UNDEFINED"))->isFalse();
        that((const_exists)("UNDEFINED", "UNDEFINED"))->isFalse();
        that((const_exists)("UNDEFINED::UNDEFINED"))->isFalse();
    }

    function test_object_dive()
    {
        $class = (stdclass)([
            'a' => (stdclass)([
                'b' => (stdclass)([
                    'c' => 'abc',
                ]),
            ]),
        ]);
        that((object_dive)($class, 'a.b.c'))->is('abc');
        that((object_dive)($class, 'a.b.c.x', 'none'))->is('none');
        that((object_dive)($class, 'a.b.X', 'none'))->is('none');
    }

    function test_get_class_constants()
    {
        $concrete = new class('hoge') extends \Concrete {
            private const /** @noinspection PhpUnusedPrivateFieldInspection */ PPP = 0;
            protected const                                                    PP  = 1;
            public const                                                       P   = 2;
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

    /** @noinspection PhpUnusedPrivateFieldInspection */
    function test_get_object_properties()
    {
        $concrete = new \Concrete('name');
        $concrete->value = 'value';
        $concrete->oreore = 'oreore';
        $private = [];
        that((get_object_properties)($concrete, $private))->is([
            'privateField'    => 'Concrete',
            'proptectedField' => 3.14,
            'value'           => 'value',
            'name'            => 'name',
            'oreore'          => 'oreore',
        ]);
        that($private)->is([
            'AbstractConcrete' => [
                'privateField' => 'AbstractConcrete',
            ],
        ]);

        // 標準の var_export が親優先になっているのを変更しているテスト
        $object = new \Nest3();
        $object->set(999);

        // 子が優先される
        that(((phpval)((var_export2)($object, true)))->get())->isSame(999);

        // DateTime や ArrayObject はかなり特殊で、プロパティが標準の手段では取れない
        that((get_object_properties)(new \Datetime('2014/12/24 12:34:56', new \DateTimeZone('Asia/Tokyo'))))->isSame([
            'date'          => '2014-12-24 12:34:56.000000',
            'timezone_type' => 3,
            'timezone'      => 'Asia/Tokyo',
        ]);
        that((get_object_properties)(new \ArrayObject(['a' => 'A', 'b' => 'B'])))->isSame([
            'a' => 'A',
            'b' => 'B',
        ]);

        // 無名クラス命名規則が違うので別途やる
        that((get_object_properties)(new class {
            private   $private   = 1;
            protected $protected = 2;
            public    $public    = 3;
        }))->is([
            'private'   => 1,
            'protected' => 2,
            'public'    => 3,
        ]);

        // クロージャは this と use 変数を返す
        $a = 123;
        $b = 456;
        that((get_object_properties)(fn() => $a + $b))->is([
            'this' => $this,
            'a'    => 123,
            'b'    => 456,
        ]);
        that((get_object_properties)(static fn() => $a + $b))->is([
            'this' => null,
            'a'    => 123,
            'b'    => 456,
        ]);
    }
}
