<?php

namespace ryunosuke\Test\Package;

use stdClass;
use function ryunosuke\Functions\Package\auto_loader;
use function ryunosuke\Functions\Package\class_aliases;
use function ryunosuke\Functions\Package\class_extends;
use function ryunosuke\Functions\Package\class_loader;
use function ryunosuke\Functions\Package\class_namespace;
use function ryunosuke\Functions\Package\class_replace;
use function ryunosuke\Functions\Package\class_shorten;
use function ryunosuke\Functions\Package\class_uses_all;
use function ryunosuke\Functions\Package\const_exists;
use function ryunosuke\Functions\Package\detect_namespace;
use function ryunosuke\Functions\Package\get_class_constants;
use function ryunosuke\Functions\Package\get_object_properties;
use function ryunosuke\Functions\Package\object_dive;
use function ryunosuke\Functions\Package\optional;
use function ryunosuke\Functions\Package\phpval;
use function ryunosuke\Functions\Package\register_autoload_function;
use function ryunosuke\Functions\Package\rm_rf;
use function ryunosuke\Functions\Package\stdclass;
use function ryunosuke\Functions\Package\type_exists;
use function ryunosuke\Functions\Package\var_export2;
use const ryunosuke\Functions\Package\IS_OWNSELF;
use const ryunosuke\Functions\Package\IS_PRIVATE;
use const ryunosuke\Functions\Package\IS_PROTECTED;
use const ryunosuke\Functions\Package\IS_PUBLIC;

class classobjTest extends AbstractTestCase
{
    function test_auto_loader()
    {
        that(auto_loader())->fileExists();
        that(self::resolveFunction('auto_loader'))('/notfounddir')->wasThrown('not found');
    }

    function test_class_aliases()
    {
        that(class_aliases([
            'Alias\\Alias1' => files\classes\Alias1::class,
        ]))->is([
            'Alias\\Alias1' => files\classes\Alias1::class,
        ]);
        that(class_exists('Alias\\Alias1', false))->isFalse();
        that(class_exists('Alias\\Alias1', true))->isTrue();

        that(class_aliases([
            'Alias\\Alias2' => files\classes\Alias2::class,
        ]))->is([
            'Alias\\Alias1' => files\classes\Alias1::class,
            'Alias\\Alias2' => files\classes\Alias2::class,
        ]);
        that(class_exists('Alias\\Alias2', false))->isFalse();
        that(class_exists('Alias\\Alias2', true))->isTrue();
    }

    function test_class_extends()
    {
        rm_rf(self::$TMPDIR . __FUNCTION__, false);
        require_once __DIR__ . '/files/classes/extends.php';
        $original = new \ryunosuke\Test\Package\files\classes\ClassExtends();
        /** @var \ryunosuke\Test\Package\files\classes\ClassExtends $object */
        $object = class_extends($original, [
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
        ], [\ryunosuke\Test\Package\files\classes\Methods::class]);

        that($object)->isInstanceOf(\ryunosuke\Test\Package\files\classes\Methods::class);
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
        that($result['this'])->isInstanceOf(\ryunosuke\Test\Package\files\classes\ClassExtends::class);
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
            'self'   => 'ryunosuke\Test\Package\files\classes\ClassExtends',
            'method' => 'static:foo',
            'arg'    => 123,
        ]);

        $original::$staticfield = 'bar';
        that($object::staticMethod())->is('static:bar');
        /** @noinspection PhpUndefinedMethodInspection */
        that($object::staticHoge(123))->is([
            'self'   => 'ryunosuke\Test\Package\files\classes\ClassExtends',
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
        $e = class_extends(new \Exception('message', 123), [
            'codemessage' => function () {
                /** @noinspection PhpUndefinedFieldInspection */
                return $this->code . ':' . $this->message;
            },
        ]);
        /** @noinspection PhpUndefinedMethodInspection */
        that($e->codemessage())->is('123:message');
    }

    function test_class_loader()
    {
        that(class_loader())->isObject();
        that(self::resolveFunction('class_loader'))('/notfounddir')->wasThrown('not found');
    }

    function test_class_namespace()
    {
        that(class_namespace(new \stdClass()))->is('');
        that(class_namespace('\PHPUnit_Framework_TestCase'))->is('');
        // php の名前空間・クラス名は \\ 無しに統一されていたはず
        that(class_namespace('vendor\\namespace\\ClassName'))->is('vendor\\namespace');
        that(class_namespace('\\vendor\\namespace\\ClassName'))->is('vendor\\namespace');
    }

    function test_class_replace()
    {
        that(self::resolveFunction('class_replace'))(__CLASS__, function () { })->wasThrown('already declared');
        that(self::resolveFunction('class_replace'))('\\ryunosuke\\Test\\package\\files\\classes\\A', function () { require_once __DIR__ . '/files/classes/_.php'; })->wasThrown('multi classes');

        class_replace('\\ryunosuke\\Test\\package\\files\\classes\\A', function () {
            require_once __DIR__ . '/files/classes/A_.php';
        });

        class_replace('\\ryunosuke\\Test\\package\\files\\classes\\B', function () {
            require_once __DIR__ . '/files/classes/B_.php';
            return new \B();
        });

        class_replace('\\ryunosuke\\Test\\package\\files\\classes\\C1', [
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

        that((new \ryunosuke\Test\package\files\classes\B())->f())->is([
            'this is exA',
            'this is exB',
        ]);

        /** @var \Traitable $classC */
        $classC = new \ryunosuke\Test\package\files\classes\C1();
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

        $classD = new \ryunosuke\Test\package\files\classes\D1();
        that($classD->f())->is([
            'this is exA',
            'this is exB',
            'this is C',
            'this is D',
        ]);
        /** @noinspection PhpUndefinedMethodInspection */
        that($classD->newMethod())->is('this is D1');

        class_replace('\\ryunosuke\\Test\\package\\files\\classes\\C2', new class() extends \ryunosuke\Test\package\files\classes\B {
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
        $classC = new \ryunosuke\Test\package\files\classes\C2();
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

        $classD = new \ryunosuke\Test\package\files\classes\D2();
        that($classD->f())->is([
            'this is exA',
            'this is exB',
            'this is C',
            'this is D',
        ]);
        /** @noinspection PhpUndefinedMethodInspection */
        that($classD->newMethod())->is('this is D2');
    }

    function test_class_shorten()
    {
        that(class_shorten(new \stdClass()))->is('stdClass');
        that(class_shorten('\PHPUnit_Framework_TestCase'))->is('PHPUnit_Framework_TestCase');
        that(class_shorten('vendor\\namespace\\ClassName'))->is('ClassName');
        that(class_shorten('\\vendor\\namespace\\ClassName'))->is('ClassName');
    }

    function test_class_uses_all()
    {
        /** @noinspection PhpUndefinedClassInspection */
        {
            eval('trait T1{}');
            eval('trait T2{use T1;}');
            eval('trait T3{use T2;}');
        }
        that(class_uses_all(new class {
            use /** @noinspection PhpUndefinedClassInspection */ \T1;
        }))->is(['T1']);
        that(class_uses_all(new class {
            use /** @noinspection PhpUndefinedClassInspection */ \T2;
        }))->is(['T2', 'T1']);
        that(class_uses_all(new class {
            use /** @noinspection PhpUndefinedClassInspection */ \T3;
        }))->is(['T3', 'T2', 'T1']);
        that(class_uses_all(get_class(new class {
            use /** @noinspection PhpUndefinedClassInspection */ \T1;
            use /** @noinspection PhpUndefinedClassInspection */ \T2;
            use /** @noinspection PhpUndefinedClassInspection */ \T3;
        })))->is(['T1', 'T2', 'T3']);

        that(class_uses_all(new stdClass()))->is([]);
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
        that(const_exists($class, "PRIVATE_CONST"))->isTrue();
        that(const_exists($class, "PROTECTED_CONST"))->isTrue();
        that(const_exists($class, "PUBLIC_CONST"))->isTrue();

        // クラス定数（1引数）
        that(const_exists("$class::PRIVATE_CONST"))->isTrue();
        that(const_exists("$class::PROTECTED_CONST"))->isTrue();
        that(const_exists("$class::PUBLIC_CONST"))->isTrue();

        // マジック定数
        that(const_exists("$class::class"))->isTrue();
        that(const_exists($class, "class"))->isTrue();
        that(const_exists("$class::CLASS"))->isTrue();
        that(const_exists($class, "CLASS"))->isTrue();

        // グローバル定数
        define('hogera\\PI', M_PI);
        that(const_exists("PHP_VERSION"))->isTrue();
        that(const_exists('hogera\\PI'))->isTrue();

        // 非存在
        that(const_exists("UNDEFINED"))->isFalse();
        that(const_exists($class, "UNDEFINED"))->isFalse();
        that(const_exists("$class::UNDEFINED"))->isFalse();
        that(const_exists("UNDEFINED", "UNDEFINED"))->isFalse();
        that(const_exists("UNDEFINED::UNDEFINED"))->isFalse();
    }

    function test_detect_namespace()
    {
        that(detect_namespace(__DIR__))->is('ryunosuke\\Test\\Package');
        that(detect_namespace(__DIR__ . '/files/classes'))->is('ryunosuke\\Test\\Package\\files\\classes');
        that(detect_namespace(__DIR__ . '/files/classes/NS'))->is('ryunosuke\\Test\\Package\\files\\classes\\NS');
        that(detect_namespace(__DIR__ . '/files/classes/NS/Valid'))->is('A\\B\\C');
        that(detect_namespace(__DIR__ . '/files/classes/NS/Valid/Hoge.php'))->is('A\\B\\C\\Hoge');
        that(detect_namespace(__DIR__ . '/../../../src/Package'))->is('ryunosuke\\Functions\\Package');
        that(self::resolveFunction('detect_namespace'))('/a/b/c/d/e/f/g/h/i/j/k/l/m/n')->wasThrown('can not detect namespace');
    }

    function test_get_class_constants()
    {
        $concrete = new class('hoge') extends \Concrete {
            private const /** @noinspection PhpUnusedPrivateFieldInspection */ PPP = 0;
            protected const                                                    PP  = 1;
            public const                                                       P   = 2;
        };

        that(get_class_constants($concrete))->is([
            'PROTECTED_CONST' => null,
            'PUBLIC_CONST'    => null,
            'PPP'             => 0,
            'PP'              => 1,
            'P'               => 2,
        ]);

        that(get_class_constants($concrete, IS_OWNSELF | IS_PUBLIC | IS_PROTECTED | IS_PRIVATE))->is([
            'PPP' => 0,
            'PP'  => 1,
            'P'   => 2,
        ]);

        that(get_class_constants($concrete, IS_OWNSELF | IS_PUBLIC | IS_PROTECTED))->is([
            'PP' => 1,
            'P'  => 2,
        ]);

        that(get_class_constants($concrete, IS_OWNSELF | IS_PUBLIC))->is([
            'P' => 2,
        ]);

        that(get_class_constants($concrete, IS_PUBLIC))->is([
            'P'            => 2,
            'PUBLIC_CONST' => null,
        ]);
    }

    function test_get_object_properties()
    {
        $concrete = new \Concrete('name');
        $concrete->value = 'value';
        $concrete->oreore = 'oreore';
        $private = [];
        that(get_object_properties($concrete, $private))->is([
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
        that((phpval(var_export2($object, true)))->get())->isSame(999);

        // DateTime や ArrayObject はかなり特殊で、プロパティが標準の手段では取れない
        that(get_object_properties(new \Datetime('2014/12/24 12:34:56', new \DateTimeZone('Asia/Tokyo'))))->isSame([
            'date'          => '2014-12-24 12:34:56.000000',
            'timezone_type' => 3,
            'timezone'      => 'Asia/Tokyo',
        ]);
        that(get_object_properties(new \ArrayObject(['a' => 'A', 'b' => 'B'])))->isSame([
            'a' => 'A',
            'b' => 'B',
        ]);

        // 無名クラス命名規則が違うので別途やる
        that(get_object_properties(new class {
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
        that(get_object_properties(fn() => $a + $b))->is([
            'this' => $this,
            'a'    => 123,
            'b'    => 456,
        ]);
        that(get_object_properties(static fn() => $a + $b))->is([
            'this' => null,
            'a'    => 123,
            'b'    => 456,
        ]);
    }

    function test_object_dive()
    {
        $class = stdclass([
            'a' => stdclass([
                'b' => stdclass([
                    'c' => 'abc',
                ]),
            ]),
        ]);
        that(object_dive($class, 'a.b.c'))->is('abc');
        that(object_dive($class, 'a.b.c.x', 'none'))->is('none');
        that(object_dive($class, 'a.b.X', 'none'))->is('none');
    }

    function test_optional()
    {
        $o = new \Concrete('hoge');
        $o->hoge = 'hoge';
        $o->value = 'hoge';

        // method
        that(optional($o)->getName())->isSame('hoge');
        // property
        that(optional($o)->value)->isSame('hoge');
        // __isset
        that(isset(optional($o)->hoge))->isSame(true);
        // __get
        that(optional($o)->hoge)->isSame('hoge');
        // __call
        that(optional($o)->hoge())->isSame('hoge');
        // __invoke
        that(optional($o)())->isSame('Concrete::__invoke');
        // __toString
        that((string) optional($o))->isSame('hoge');
        // offsetExists
        that(empty(optional($o)['hoge']))->isSame(false);
        // offsetGet
        that(optional($o)['hoge'])->isSame('hoge');
        // iterator
        that(iterator_to_array(optional($o)))->isNotEmpty();
        // count
        that(count(optional($o)))->is(4);
        // json
        that(json_encode(optional($o)))->is("\"hoge\"");

        $o = null;

        // method
        that(optional($o)->getName())->isSame(null);
        // property
        that(optional($o)->value)->isSame(null);
        // __isset
        that(isset(optional($o)->hoge))->isSame(false);
        // __get
        that(optional($o)->hoge)->isSame(null);
        // __call
        that(optional($o)->hoge())->isSame(null);
        // __invoke
        that(optional($o)())->isSame(null);
        // __toString
        that((string) optional($o))->isSame('');
        // offsetExists
        that(empty(optional($o)['hoge']))->isSame(true);
        // offsetGet
        that(optional($o)['hoge'])->isSame(null);
        // iterator
        that(iterator_to_array(optional($o)))->isEmpty();
        // count
        that(count(optional($o)))->is(0);
        // json
        that(json_encode(optional($o)))->is("{}");

        // 型指定
        that(optional(new \ArrayObject([1]))->count())->is(1);
        that(optional(new \ArrayObject([1]), 'stdClass')->count())->is(0);

        // 例外
        that(optional(null))->try('__set', 'hoge', 'value')->wasThrown('called NullObject#');
        that(optional(null))->try('__unset', 'hoge')->wasThrown('called NullObject#');
        that(optional(null))->try('offsetSet', 'hoge', 'value')->wasThrown('called NullObject#');
        that(optional(null))->try('offsetUnset', 'hoge')->wasThrown('called NullObject#');
    }

    function test_register_autoload_function()
    {
        that(class_exists(\PHPUnit\Util\TestDox\TestDoxPrinter::class, false))->isFalse();
        that(class_exists(\PHPUnit\Util\TestDox\CliTestDoxPrinter::class, false))->isFalse();
        that(class_exists(\PHPUnit\Util\TestDox\XmlResultPrinter::class, false))->isFalse();

        register_autoload_function(
        // 読み込み前に static フィールド名を書き換える
            function ($classname, $filename, $contents) {
                if ($classname === files\classes\InitializedClass::class) {
                    // この中でオートロードしても問題ないことを担保（php-parser とかで書き換える事が多いので）
                    class_exists(\PHPUnit\Util\TestDox\TestDoxPrinter::class);
                    class_exists(\PHPUnit\Util\TestDox\CliTestDoxPrinter::class);
                    class_exists(\PHPUnit\Util\TestDox\XmlResultPrinter::class);
                    return strtr($contents ?? file_get_contents($filename), ['$initialized' => '$initialized2']);
                }
            },
            null
        );
        // 多重登録も可能
        register_autoload_function(
        // 読み込み前に static フィールド名を書き換える
            function ($classname, $filename, $contents) {
                if ($classname === files\classes\InitializedClass::class) {
                    return strtr($contents ?? file_get_contents($filename), ['$initialized2' => '$initialized3']);
                }
            },
            // 読み込み後に __initialize を呼ぶ
            function ($classname) {
                if (method_exists($classname, '__initialize')) {
                    $classname::__initialize();
                }
            }
        );

        /** @noinspection PhpUndefinedFieldInspection */
        // フィールド名は変わっているし、初期化もされている
        that(files\classes\InitializedClass::$initialized3)->isTrue();
    }

    /** @noinspection PhpUnusedPrivateFieldInspection */

    function test_stdclass()
    {
        $fields = ['a', 'b'];
        $stdclass = stdclass($fields);
        that($stdclass)->isInstanceOf(stdClass::class);
        that($stdclass)->{0}->is('a');
        that($stdclass)->{1}->is('b');
    }

    function test_type_exists()
    {
        that(type_exists(\Exception::class))->isTrue();
        that(type_exists(\Throwable::class))->isTrue();
        that(type_exists(\Traitable::class))->isTrue();

        spl_autoload_register(function ($class) {
            if (strpos($class, __NAMESPACE__) === 0) {
                require_once __DIR__ . '/files/classes/Type.php';
            }
        });

        that(type_exists(files\classes\Type::class, false))->isFalse();
        that(type_exists(files\classes\Typable::class, false))->isFalse();
        that(type_exists(files\classes\TypeTrait::class, false))->isFalse();

        that(type_exists(files\classes\Type::class, true))->isTrue();
        that(type_exists(files\classes\Typable::class, true))->isTrue();
        that(type_exists(files\classes\TypeTrait::class, true))->isTrue();
    }
}
