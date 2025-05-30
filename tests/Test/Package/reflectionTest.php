<?php

namespace ryunosuke\Test\Package;

use Concrete;
use Traitable;
use function ryunosuke\Functions\Package\callable_code;
use function ryunosuke\Functions\Package\function_doccomments;
use function ryunosuke\Functions\Package\function_export_false2null;
use function ryunosuke\Functions\Package\function_parameter;
use function ryunosuke\Functions\Package\parameter_default;
use function ryunosuke\Functions\Package\parameter_length;
use function ryunosuke\Functions\Package\parameter_wiring;
use function ryunosuke\Functions\Package\reflect_callable;
use function ryunosuke\Functions\Package\reflect_type_resolve;
use function ryunosuke\Functions\Package\reflect_types;

class reflectionTest extends AbstractTestCase
{
    function test_callable_code()
    {
        function hoge_callable_code()
        {
            return true;
        }

        $code = callable_code(__NAMESPACE__ . "\\hoge_callable_code");
        that($code)->is([
            'function hoge_callable_code()',
            '{
            return true;
        }',
        ]);

        $code = callable_code([$this, 'createResult']);
        that($code)->is([
            'function createResult(): TestResult',
            '{
        return new TestResult;
    }',
        ]);

        $code = callable_code(new \ReflectionFunction(__NAMESPACE__ . "\\hoge_callable_code"));
        that($code)->is([
            'function hoge_callable_code()',
            '{
            return true;
        }',
        ]);

        $usevar = null;
        $code = callable_code(function ($arg1 = "{\n}") use ($usevar): \Closure {
            if (true) {
                return function () use ($usevar) {
                    return $usevar;
                };
            }
        });
        that($code)->is([
            'function ($arg1 = "{\n}") use ($usevar): \Closure',
            '{
            if (true) {
                return function () use ($usevar) {
                    return $usevar;
                };
            }
        }',
        ]);

        $code = callable_code(function ($a, $b) {
            $x = fn() => $a + $b;
            return $x();
        });
        that($code)->is([
            'function ($a, $b)',
            '{
            $x = fn() => $a + $b;
            return $x();
        }',
        ]);

        $code = callable_code(fn($a, $b) => $a + $b);
        that($code)->is([
            'fn($a, $b)',
            '$a + $b',
        ]);

        $code = callable_code(fn($a, $b) => min($a, $b));
        that($code)->is([
            'fn($a, $b)',
            'min($a, $b)',
        ]);

        $code = callable_code(fn($a, $b) => [[$a + $b]]);
        that($code)->is([
            'fn($a, $b)',
            '[[$a + $b]]',
        ]);

        $code = callable_code(fn() => [#[A] fn() => []]);
        that($code)->is([
            'fn()',
            '[#[A] fn() => []]',
        ]);

        $fn = fn($a, $b) => [fn() => [$a + $b]];
        $code = callable_code($fn);
        that($code)->is([
            'fn($a, $b)',
            '[fn() => [$a + $b]]',
        ]);

        $fn = fn($a, $b) => fn($a) => fn() => [$a, $b];
        $code = callable_code($fn);
        that($code)->is([
            'fn($a, $b)',
            'fn($a) => fn() => [$a, $b]',
        ]);

        $fn = fn($a, $b) => new class ( $a, $b ) { public function __construct($a, $b) { } };
        $code = callable_code($fn);
        that($code)->is([
            'fn($a, $b)',
            'new class ( $a, $b ) { public function __construct($a, $b) { } }',
        ]);

        ?><?php $fn = fn($a, $b) => [$a,  $b] ?><?php
        $code = callable_code($fn);
        that($code)->is([
            'fn($a, $b)',
            '[$a,  $b]',
        ]);

        $code = callable_code($fn, true);
        that($code[0])->isArray();
        that($code[1])->isArray();
    }

    function test_function_doccomments()
    {
        that(function_doccomments(function ($none): ?int { }))->is([]);
        that(function_doccomments(function ($none) /** no return type */ { }))->is([-1 => "/** no return type */"]);

        that(function_doccomments(/** 本体 */ function (
            /** 型無し */
            $notype,
            /** 型有り */
            ?int $typed,
            /** 属性付き */
            #[\Attr(1, 2, c: 3)] int $attred,
            // doccomment 無し
            $none,
            /** 参照 */
            &$ref,
            /** 可変 */
            ...$args
        ): /** 返り値 */ ?int {
        }))->is([
            "" => "/** 本体 */",
            0  => "/** 型無し */",
            1  => "/** 型有り */",
            2  => "/** 属性付き */",
            4  => "/** 参照 */",
            5  => "/** 可変 */",
            -1 => "/** 返り値 */",
        ]);
    }

    function test_function_export_false2null()
    {
        $exported = function_export_false2null('Exported', true);

        that($exported)->contains('namespace Exported');
        that($exported)->contains('strpos');
        that($exported)->notContains('in_array');

        $exported = function_export_false2null('Exported', false);

        that($exported)->contains('namespace Exported');
        that($exported)->contains('strpos');
        that($exported)->contains('in_array');

        // include してエラーにならないことと代表（strpos）で null が返ることが確認できればそれでよい

        $file = self::$TMPDIR . '/nully.php';
        file_put_contents($file, $exported);
        include $file;

        $funcname = '\\Exported\\strpos';
        that($funcname('hoge', 'notfound'))->isNull();
    }

    function test_function_parameter()
    {
        // reflection
        $params = function_parameter(reflect_callable(function ($a, &$b, $c = 123, &$d = 456, ...$x) { }));
        that($params)->isSame([
            '$a'  => '$a',
            '&$b' => '&$b',
            '$c'  => '$c = 123',
            '&$d' => '&$d = 456',
            '$x'  => '...$x',
        ]);

        // callable
        $params = function_parameter(function ($a, &$b, $c = 123, &$d = 456, ...$x) { });
        that($params)->isSame([
            '$a'  => '$a',
            '&$b' => '&$b',
            '$c'  => '$c = 123',
            '&$d' => '&$d = 456',
            '$x'  => '...$x',
        ]);

        // reference variadic
        $params = function_parameter(function (&...$args) { });
        that($params)->isSame([
            '&$args' => '&...$args',
        ]);

        // type hint
        $params = function_parameter(function (string $a, int $b, ?reflectionTest $c) { });
        that($params)->isSame([
            '$a' => 'string $a',
            '$b' => 'int $b',
            '$c' => '?\\' . __CLASS__ . ' $c',
        ]);

        // ns\const
        $params = function_parameter(function ($a = PHP_SAPI) { });
        that($params)->isSame([
            '$a' => '$a = "cli"',
        ]);
        $params = function_parameter(function ($a = \PHP_SAPI) { });
        that($params)->isSame([
            '$a' => '$a = PHP_SAPI',
        ]);
        $params = function_parameter(function ($a = \ArrayObject::ARRAY_AS_PROPS) { });
        that($params)->isSame([
            '$a' => '$a = \\ArrayObject::ARRAY_AS_PROPS',
        ]);

        // internal
        $params = function_parameter('strpos');
        that($params)->isSame([
            '$haystack' => 'string $haystack',
            '$needle'   => 'string $needle',
            '$offset'   => 'int $offset = 0',
        ]);
        $params = function_parameter('stream_filter_append');
        that($params)->isSame([
            '$stream'      => '$stream',
            '$filter_name' => 'string $filter_name',
            '$mode'        => 'int $mode = 0',
            '$params'      => 'mixed $params = null',
        ]);
    }

    function test_parameter_default()
    {
        $f = function ($a, $b = 'b') { };
        that(parameter_default($f))->isSame([1 => 'b']);
        that(parameter_default($f, ['A', 'B']))->isSame(['A', 'B']);
        that(parameter_default($f, [-1 => 'B']))->isSame([1 => 'B']);
        that(parameter_default($f, [-2 => 'A', -1 => 'B']))->isSame(['A', 'B']);

        $f = function ($a, ...$x) { };
        that(parameter_default($f))->isSame([]);
        that(parameter_default($f, [1 => 'x']))->isSame([1 => 'x']);
        that(parameter_default($f, [1 => 'x', 2 => 'y']))->isSame([1 => 'x', 2 => 'y']);
        that(parameter_default($f, [1 => 'x', 3 => 'z']))->isSame([1 => 'x', 3 => 'z']);
        that(parameter_default($f, ['a', -9 => 'x', -8 => 'y']))->isSame(['a', -7 => 'x', -6 => 'y']);
    }

    function test_parameter_length()
    {
        // タイプ 0: クロージャ
        that(parameter_length(function ($a, $b = null) { }))->is(2);
        that(parameter_length(function ($a, $b = null) { }, true))->is(1);
        // クロージャの呼び出し名が特殊なので変なキャッシュされていないか担保するために異なる引数でもう一回テスト
        that(parameter_length(function ($a, $b, $c = null) { }))->is(3);
        that(parameter_length(function ($a, $b, $c = null) { }, true))->is(2);

        // タイプ 1: 単純なコールバック
        that(parameter_length('trim'))->is(2);
        that(parameter_length('trim', true))->is(1);

        // タイプ 2: 静的クラスメソッドのコール
        that(parameter_length(['Concrete', 'staticMethod']))->is(1);
        that(parameter_length(['Concrete', 'staticMethod'], true))->is(0);

        // タイプ 3: オブジェクトメソッドのコール
        that(parameter_length([new \Concrete(''), 'instanceMethod']))->is(1);
        that(parameter_length([new \Concrete(''), 'instanceMethod'], true))->is(0);

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        that(parameter_length('Concrete::staticMethod'))->is(1);
        that(parameter_length('Concrete::staticMethod', true))->is(0);

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)（php8.2 で非推奨になったので@を付けている）
        @that(parameter_length(['Concrete', 'parent::staticMethod']))->is(1);
        @that(parameter_length(['Concrete', 'parent::staticMethod'], true))->is(0);

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        that(parameter_length(new \Concrete('')))->is(1);
        that(parameter_length(new \Concrete(''), true))->is(0);

        // 可変引数
        that(parameter_length(function (...$x) { }, false, true))->is(INF);
    }

    function test_parameter_wiring()
    {
        $closure = function (\ArrayObject $ao, \Throwable $t, $array, $method, $closure, $none, $default1, $default2 = 'default2', ...$misc) { return get_defined_vars(); };

        $params = parameter_wiring($closure, $that = [
            \ArrayObject::class      => $ao = new \ArrayObject([1, 2, 3]),
            \Exception::class        => new \Exception('hoge'),
            \RuntimeException::class => new \RuntimeException('hoge'),
            '$array'                 => fn(\ArrayObject $ao) => (array) $ao,
            '$method'                => \Closure::fromCallable([$ao, 'getArrayCopy']),
            '$closure'               => fn() => (array) $this,
            6                        => 'default1',
            '$misc'                  => ['x', 'y', 'z'],
        ]);
        that($params)->isSame([
            0  => $ao,
            // 1  => null, ambiguous
            2  => [1, 2, 3],
            3  => [1, 2, 3],
            4  => $that,
            // 5  => undefined,
            6  => 'default1',
            7  => 'default2',
            8  => 'x',
            9  => 'y',
            10 => 'z',
        ]);

        $params = parameter_wiring($closure, [
            '$ao' => $ao = new \ArrayObject([1, 2, 3]),
        ]);
        that($params)->isSame([
            0 => $ao,
            7 => 'default2',
        ]);
    }

    function test_reflect_callable()
    {
        // タイプ 0: クロージャ
        that(reflect_callable(fn() => null))->isInstanceOf('\ReflectionFunction');

        // タイプ 1: 単純なコールバック
        that(reflect_callable('strlen'))->isInstanceOf('\ReflectionFunction');

        // タイプ 2: 静的クラスメソッドのコール
        that(reflect_callable(['Concrete', 'staticMethod']))->isInstanceOf('\ReflectionMethod');

        // タイプ 3: オブジェクトメソッドのコール
        that(reflect_callable([new \Concrete(''), 'instanceMethod']))->isInstanceOf('\ReflectionMethod');

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        that(reflect_callable('Concrete::staticMethod'))->isInstanceOf('\ReflectionMethod');

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        that(reflect_callable(['Concrete', 'parent::staticMethod']))->isInstanceOf('\ReflectionMethod');

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        that(reflect_callable(new \Concrete('')))->isInstanceOf('\ReflectionMethod');

        // タイプ X: メソッドスコープ
        that(reflect_callable(['PrivateClass', 'privateMethod']))->isInstanceOf('\ReflectionMethod');

        // isAnonymous
        that(reflect_callable(fn() => null))->isAnonymous()->isTrue();
        that(reflect_callable('strlen'))->isAnonymous()->isFalse();
        that(reflect_callable(['Concrete', 'staticMethod']))->isAnonymous()->isFalse();
        that(reflect_callable(\Closure::fromCallable(fn() => null)))->isAnonymous()->isTrue();
        that(reflect_callable(\Closure::fromCallable('strlen')))->isAnonymous()->isFalse();
        that(reflect_callable(\Closure::fromCallable(['Concrete', 'staticMethod'])))->isAnonymous()->isFalse();

        // そんなものは存在しない
        that(self::resolveFunction('reflect_callable'))('hogefuga')->wasThrown('does not exist');

        // そもそも形式がおかしい
        that(self::resolveFunction('reflect_callable'))([])->wasThrown('is not callable');
    }

    function test_reflect_callable_instance()
    {
        $reffunc = reflect_callable('nullsafe_int_func');
        that($reffunc->getDeclaration())->is('function nullsafe_int_func(int $x, int $y, ?int $z = null)');
        that($reffunc->getCode())->contains('return $x - $y + ($z ?? 100);');
        that($reffunc(4, 1))->is(103);
        that($reffunc(y: 1, x: 4))->is(103);
        that($reffunc->getClosure()(y: 1, x: 4))->is(103);

        $reffunc = reflect_callable(function ($x) use (&$use): int { return $x + $use++; });
        that($reffunc->getDeclaration())->is('function ($x) use (&$use): int');
        that($reffunc->getCode())->contains('return $x + $use++;');
        that($reffunc->getUsedVariables())->is(['use' => $use]);
        that($reffunc->isStatic())->is(false);
        that($reffunc->isArrow())->is(false);
        that($reffunc->call($this, 1))->is(1);
        that($reffunc(1))->is(2);
        that($reffunc(x: 1))->is(3);
        that($reffunc->getClosure()(x: 1))->is(4);

        $reffunc = reflect_callable(static function ($x) use (&$use): int { return $x + $use++; });
        that($reffunc->getDeclaration())->is('function ($x) use (&$use): int');
        that($reffunc->getCode())->contains('return $x + $use++;');
        that($reffunc->getUsedVariables())->is(['use' => $use]);
        that($reffunc->isStatic())->is(true);
        that($reffunc->isArrow())->is(false);
        that($reffunc(1))->is(5);
        that($reffunc(x: 1))->is(6);
        that($reffunc->getClosure()(x: 1))->is(7);

        $reffunc = reflect_callable(fn() => null);
        that($reffunc->isArrow())->is(true);
        $reffunc = reflect_callable(static fn() => null);
        that($reffunc->isArrow())->is(true);
        $reffunc = reflect_callable(#[Attr] fn() => null);
        that($reffunc->isArrow())->is(true);
        $reffunc = reflect_callable(#[Attr] static fn() => null);
        that($reffunc->isArrow())->is(true);

        $reffunc = reflect_callable([new Concrete('hoge'), 'getName']);
        that($reffunc->getDeclaration())->is('function getName($prefix = \'\', $upper = false)');
        that($reffunc->getCode())->contains('return $name;');
        that($reffunc->call(new Concrete('fuga')))->is('fuga');
        that($reffunc('p-'))->is('p-hoge');
        that($reffunc(upper: true))->is('HOGE');
        that($reffunc->getClosure()(upper: true))->is('HOGE');

        $reffunc = reflect_callable([new Concrete('hoge'), 'staticMethod']);
        that($reffunc->getDeclaration())->is('function staticMethod($a = null)');
        that($reffunc->getCode())->contains('return __METHOD__;');
        that($reffunc->call(new Concrete('fuga')))->is('Concrete::staticMethod');
        that($reffunc(a: 1))->is('Concrete::staticMethod');
        that($reffunc->getClosure()(a: 1))->is('Concrete::staticMethod');

        $reffunc = reflect_callable([new Concrete('hoge'), 'hogera']);
        that($reffunc->getDeclaration())->is('function __call($name, $arguments)');
        that($reffunc->getCode())->contains('return $name;');
        that($reffunc->call(new Concrete('fuga')))->is('hogera');
        that($reffunc())->is('hogera');
        that($reffunc->getClosure()())->is('hogera');

        $reffunc = reflect_callable([Concrete::class, 'hogera']);
        that($reffunc->getDeclaration())->is('function __callStatic($name, $arguments)');
        that($reffunc->getCode())->contains('return $name;');
        that($reffunc->call(new Concrete('fuga')))->is('hogera');
        that($reffunc())->is('hogera');
        that($reffunc->getClosure()())->is('hogera');

        $object = new class { use Traitable; };
        that(reflect_callable([$object, 'traitMethod'])->getTraitMethod())->isInstanceOf(\ReflectionMethod::class);
        that(reflect_callable([$object, 'traitMethod'])->getTraitMethod())()->is(Traitable::class);

        $object = new class {
            use Traitable {
                traitMethod as aliasMethod;
            }
        };
        that(reflect_callable([$object, 'traitMethod'])->getTraitMethod())->isInstanceOf(\ReflectionMethod::class);
        that(reflect_callable([$object, 'aliasMethod'])->getTraitMethod())->isInstanceOf(\ReflectionMethod::class);
        that(reflect_callable([$object, 'traitMethod'])->getTraitMethod())()->is(Traitable::class);
        that(reflect_callable([$object, 'aliasMethod'])->getTraitMethod())()->wasThrown('object is not an instance of the class');

        $object = new class {
            use Traitable;

            function traitMethod() { }
        };
        that(reflect_callable([$object, 'traitMethod'])->getTraitMethod())->is(null);

        $object = new class {
            use Traitable {
                traitMethod as aliasMethod;
            }

            function aliasMethod() { }
        };
        that(reflect_callable([$object, 'traitMethod'])->getTraitMethod())->isInstanceOf(\ReflectionMethod::class);
        that(reflect_callable([$object, 'traitMethod'])->getTraitMethod())()->is(Traitable::class);
        that(reflect_callable([$object, 'aliasMethod'])->getTraitMethod())->is(null);
    }

    function test_reflect_type_resolve()
    {
        that(reflect_type_resolve(''))->isSame('');
        that(reflect_type_resolve(null))->isSame(null);

        // シンプル
        that(reflect_type_resolve('stdClass'))->is('\\stdClass');
        that(reflect_type_resolve('?stdClass'))->is('?\\stdClass');
        that(reflect_type_resolve('?\\stdClass'))->is('?\\stdClass');

        // union
        that(reflect_type_resolve('stdClass|int'))->is('\\stdClass|int');
        that(reflect_type_resolve('\\stdClass|int'))->is('\\stdClass|int');

        // intersect
        that(reflect_type_resolve('Countable&Traversable'))->is('\\Countable&\\Traversable');

        // DNF
        that(reflect_type_resolve('(Countable&Traversable)|object'))->is('(\\Countable&\\Traversable)|object');
    }

    function test_reflect_types()
    {
        $object = new class() {
            function m(?string $s, array $a, ?\ArrayObject $ao, $o, $n): void { }
        };
        $refmethod = new \ReflectionMethod($object, 'm');

        $types = reflect_types([
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

        $types = reflect_types($refmethod->getParameters()[0]);
        that($types)->count(2);
        that($types[0])->isInstanceOf(\ReflectionType::class);
        that($types->getName())->is('?string');
        that($types->__toString())->is('string|null');

        $types = reflect_types($refmethod->getParameters()[1]);
        that($types)->count(1);
        that($types[0])->isInstanceOf(\ReflectionType::class);
        that($types->getName())->is('array');
        that($types->__toString())->is('array');

        $types = reflect_types($refmethod->getParameters()[2]->getType());
        that($types)->count(2);
        that($types->getName())->is('?\\ArrayObject');
        that($types->__toString())->is('ArrayObject|null');

        $types = reflect_types($refmethod->getParameters()[3]->getType());
        that($types)->count(0);
        that($types->getName())->is('');
        that($types->__toString())->is('');

        $types = reflect_types($refmethod);
        that($types)->count(1);
        that($types[0])->isInstanceOf(\ReflectionType::class);
        that($types->getName())->is('void');
        that($types->__toString())->is('void');
        that(json_encode($types))->is(json_encode(['void']));

        $types = reflect_types();
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

        $types = reflect_types();

        $types[0] = '?string';
        that($types->allows(null))->isTrue();
        that($types->allows("hoge"))->isTrue();
        that($types->allows(new \Exception()))->isTrue();
        that($types->allows(new \ArrayObject()))->isFalse();

        $types[0] = 'mixed';
        that($types->allows(STDOUT))->isTrue();

        $types = reflect_types();
        that(isset($types[0]))->isFalse();
        $types[] = 'mixed';
        $types[] = 'object';
        that($types[0])->is('mixed');
        that($types[1])->is('object');
        unset($types[0]);
        that(isset($types[0]))->isFalse();
    }
}
