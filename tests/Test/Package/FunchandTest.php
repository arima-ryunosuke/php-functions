<?php

namespace ryunosuke\Test\Package;

class FunchandTest extends AbstractTestCase
{
    function test_abind()
    {
        $sprintf = (abind)('sprintf', [1 => 'a', 3 => 'c']);
        that($sprintf('%s%s%s%s', 'b', 'Z'))->is('abcZ');
    }

    function test_nbind()
    {
        $arrayize_2X = (nbind)(arrayize, 2, 'X');
        that($arrayize_2X(1, 2, 3, 4))->is([1, 2, 'X', 3, 4]);

        $arrayize_3XY = (nbind)(arrayize, 3, 'X', 'Y');
        that($arrayize_3XY(1, 2, 3, 4))->is([1, 2, 3, 'X', 'Y', 4]);
    }

    function test_nbind_arity()
    {
        // 引数を7個要求するクロージャ
        $func7 = function ($_0, $_1, $_2, $_3, $_4, $_5, $_6) { return func_get_args(); };
        $func6 = (nbind)($func7, 6, 'g');// 引数を6個要求するクロージャ
        $func5 = (nbind)($func6, 5, 'f');// 引数を5個要求するクロージャ
        $func4 = (nbind)($func5, 4, 'e');// 引数を4個要求するクロージャ
        $func3 = (nbind)($func4, 3, 'd');// 引数を3個要求するクロージャ
        $func2 = (nbind)($func3, 2, 'c');// 引数を2個要求するクロージャ
        $func1 = (nbind)($func2, 1, 'b');// 引数を1個要求するクロージャ
        $func0 = (nbind)($func1, 0, 'a');// 引数を0個要求するクロージャ

        that((parameter_length)($func0))->is(0);
        that((parameter_length)($func1))->is(1);
        that((parameter_length)($func2))->is(2);
        that((parameter_length)($func3))->is(3);
        that((parameter_length)($func4))->is(4);
        that((parameter_length)($func5))->is(5);
        that((parameter_length)($func6))->is(6);
        that((parameter_length)($func7))->is(7);

        that($func0())->is(['a', 'b', 'c', 'd', 'e', 'f', 'g']);
        that($func1('A'))->is(['A', 'b', 'c', 'd', 'e', 'f', 'g']);
        that($func2('A', 'B'))->is(['A', 'B', 'c', 'd', 'e', 'f', 'g']);
        that($func3('A', 'B', 'C'))->is(['A', 'B', 'C', 'd', 'e', 'f', 'g']);
        that($func4('A', 'B', 'C', 'D'))->is(['A', 'B', 'C', 'D', 'e', 'f', 'g']);
        that($func5('A', 'B', 'C', 'D', 'E'))->is(['A', 'B', 'C', 'D', 'E', 'f', 'g']);
        that($func6('A', 'B', 'C', 'D', 'E', 'F'))->is(['A', 'B', 'C', 'D', 'E', 'F', 'g']);
        that($func7('A', 'B', 'C', 'D', 'E', 'F', 'G'))->is(['A', 'B', 'C', 'D', 'E', 'F', 'G']);
    }

    function test_lbind()
    {
        $arrayize_lX = (lbind)(arrayize, 'X');
        that($arrayize_lX(1, 2, 3, 4))->is(['X', 1, 2, 3, 4]);

        $arrayize_lXY = (lbind)(arrayize, 'X', 'Y');
        that($arrayize_lXY(1, 2, 3, 4))->is(['X', 'Y', 1, 2, 3, 4]);
    }

    function test_rbind()
    {
        $arrayize_rX = (rbind)(arrayize, 'X');
        that($arrayize_rX(1, 2, 3, 4))->is([1, 2, 3, 4, 'X']);

        $arrayize_rXY = (rbind)(arrayize, 'X', 'Y');
        that($arrayize_rXY(1, 2, 3, 4))->is([1, 2, 3, 4, 'X', 'Y']);
    }

    function test_ope_func()
    {
        $operators = [
            ''           => [[true], [false]],
            '!'          => [[true], [false]],
            '+'          => [[-1], [1], [-1, 1]],
            '-'          => [[1], [-1, 1]],
            '~'          => [[-1], [1]],
            '++'         => [], // 直値の++はできないので個別にテストする
            '--'         => [], // 直値の--はできないので個別にテストする
            '?:'         => [[true, 'OK'], [false, 'NG'], [true, 'OK', 'NG'], [false, 'NG', 'OK']],
            '??'         => [[true, 'OK'], [false, 'OK'], [null, 'NG']],
            '=='         => [[1, 1], [1, '1'], [1, 2], [1, '2']],
            '==='        => [[1, 1], [1, '1'], [1, 2], [1, '2']],
            '!='         => [[1, 1], [1, '1'], [1, 2], [1, '2']],
            '<>'         => [[1, 1], [1, '1'], [1, 2], [1, '2']],
            '!=='        => [[1, 1], [1, '1'], [1, 2], [1, '2']],
            '<'          => [[1, 1], [1, 2], [2, 1]],
            '<='         => [[1, 1], [1, 2], [2, 1]],
            '>'          => [[1, 1], [1, 2], [2, 1]],
            '>='         => [[1, 1], [1, 2], [2, 1]],
            '<=>'        => [[1, 1], [1, 2], [2, 1], ['aaa', 'bbb']],
            '.'          => [['aaa', 'bbb']],
            '*'          => [[-1, 1]],
            '/'          => [[-1, 1]],
            '%'          => [[-1, 1]],
            '**'         => [[-1, 1]],
            '^'          => [[-1, 1]],
            '&'          => [[-1, 1]],
            '|'          => [[-1, 1]],
            '<<'         => [[-1, 1]],
            '>>'         => [[-1, 1]],
            '&&'         => [[false, false], [true, false], [false, true], [true, true]],
            '||'         => [[false, false], [true, false], [false, true], [true, true]],
            'or'         => [[false, false], [true, false], [false, true], [true, true]],
            'and'        => [[false, false], [true, false], [false, true], [true, true]],
            'xor'        => [[false, false], [true, false], [false, true], [true, true]],
            'instanceof' => [], // 文字列化できないので個別にテストする
        ];
        $ve = function ($v) { return var_export($v, true); };
        foreach ($operators as $op => $argss) {
            foreach ($argss as $args) {
                $n = count($args);
                $expression = null;
                if ($n == 1) {
                    $expression = "return $op{$ve($args[0])};";
                }
                elseif ($n == 2) {
                    $expression = "return {$ve($args[0])} $op {$ve($args[1])};";
                }
                elseif ($n == 3) {
                    // 3項演算子は定型的に eval 出来ないが1つしかないので直書きする
                    $expression = "return {$ve($args[0])} ? {$ve($args[1])} : {$ve($args[2])};";
                }
                that((ope_func)($op)(...$args))->as("$expression is failed.")->isSame(eval($expression));
            }
        }

        // 一部 eval ではテスト出来ないので個別でテスト
        $x = 99;
        that((ope_func)('++')($x))->isSame(100);
        that($x)->isSame(100);
        that((ope_func)('--')($x))->isSame(99);
        that($x)->isSame(99);
        that((ope_func)('instanceof')(new \stdClass(), \stdClass::class))->isTrue();
        that((ope_func)('instanceof')(new \stdClass(), \Exception::class))->isFalse();

        $p = [1, 1, 2, 4, 5, 6, 1, 3, 8, 4];
        that(array_filter($p, (ope_func)('==', 5)))->isSame([4 => 5]);

        // 例外系
        that([ope_func, 'hogera'])->throws('is not defined');
    }

    function test_not_func()
    {
        $not_strlen = (not_func)('strlen');
        that($not_strlen('hoge'))->isFalse();
        that($not_strlen(''))->isTrue();

        that((parameter_length)((not_func)('strlen')))->is(1);
    }

    function test_eval_func()
    {
        that((eval_func)('4')())->is(4);
        that((eval_func)('$a + $b', 'a', 'b')(3, 4))->is(7);

        $a1 = (eval_func)('$a', 'a');
        $a2 = (eval_func)('$a', 'a');
        $x = (eval_func)('$x', 'x');
        that($a1 === $a2)->isTrue();
        that($a1 !== $x)->isTrue();
        that($a2 !== $x)->isTrue();

        that((parameter_length)((eval_func)('$v')))->is(0);
        that((parameter_length)((eval_func)('$v', 'a')))->is(1);
        that((parameter_length)((eval_func)('$v', 'a', 'b')))->is(2);
    }

    function test_reflect_callable()
    {
        // タイプ 0: クロージャ
        that((reflect_callable)(function () { }))->isInstanceOf('\ReflectionFunction');

        // タイプ 1: 単純なコールバック
        that((reflect_callable)('strlen'))->isInstanceOf('\ReflectionFunction');

        // タイプ 2: 静的クラスメソッドのコール
        that((reflect_callable)(['Concrete', 'staticMethod']))->isInstanceOf('\ReflectionMethod');

        // タイプ 3: オブジェクトメソッドのコール
        that((reflect_callable)([new \Concrete(''), 'instanceMethod']))->isInstanceOf('\ReflectionMethod');

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        that((reflect_callable)('Concrete::staticMethod'))->isInstanceOf('\ReflectionMethod');

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        that((reflect_callable)(['Concrete', 'parent::staticMethod']))->isInstanceOf('\ReflectionMethod');

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        that((reflect_callable)(new \Concrete('')))->isInstanceOf('\ReflectionMethod');

        // タイプ X: メソッドスコープ
        that((reflect_callable)(['PrivateClass', 'privateMethod']))->isInstanceOf('\ReflectionMethod');

        // そんなものは存在しない
        that([reflect_callable, 'hogefuga'])->throws('does not exist');

        // そもそも形式がおかしい
        that([reflect_callable, []])->throws('is not callable');
    }

    function test_callable_code()
    {
        function hoge_callable_code()
        {
            return true;
        }

        $code = (callable_code)(__NAMESPACE__ . "\\hoge_callable_code");
        that($code)->is([
            'function hoge_callable_code()',
            '{
            return true;
        }',
        ]);

        $code = (callable_code)([$this, 'createResult']);
        that($code)->is([
            'function createResult(): TestResult',
            '{
        return new TestResult;
    }',
        ]);

        $code = (callable_code)(new \ReflectionFunction(__NAMESPACE__ . "\\hoge_callable_code"));
        that($code)->is([
            'function hoge_callable_code()',
            '{
            return true;
        }',
        ]);

        $usevar = null;
        $code = (callable_code)(function ($arg1 = "{\n}") use ($usevar): \Closure {
            if (true) {
                return function () use ($usevar) {

                };
            }
        });
        that($code)->is([
            'function ($arg1 = "{\n}") use ($usevar): \Closure',
            '{
            if (true) {
                return function () use ($usevar) {

                };
            }
        }',
        ]);
    }

    function test_call_safely()
    {
        $h = function () { };
        set_error_handler($h);

        // 正常なら返り値を返す
        that((call_safely)(function ($v) { return $v; }, 999))->is(999);

        // エラーが出たら例外を投げる
        that([
            call_safely,
            function () {
                /** @noinspection PhpUndefinedVariableInspection */
                return $v;
            }
        ])->throws('Undefined variable');

        // @で抑制した場合は例外は飛ばない
        that((call_safely)(function () {
            /** @noinspection PhpUndefinedVariableInspection */
            return @$v;
        }))->isSame(null);

        // エラーハンドラが戻っている
        that(set_error_handler(function () { }))->isSame($h);
        restore_error_handler();

        restore_error_handler();
    }

    function test_ob_capture()
    {
        $current = ob_get_level();

        // コールバックの出力が返される
        that((ob_capture)(function ($v) {
            echo $v;
        }, 'hoge'))->is('hoge');
        // ob レベルは変わらない
        that(ob_get_level())->is($current);

        // 処理中に飛んだ例外が飛ぶ
        that([
            ob_capture,
            function ($v) {
                throw new \Exception('inob');
            },
            'hoge'
        ])->throws('inob');
        // ob レベルは変わらない
        that(ob_get_level())->is($current);
    }

    function test_is_bindable_closure()
    {
        function _global_nostatic_closure() { return function () { return get_class($this); }; }

        function _global_static_closure() { return static function () { return get_class($this); }; }

        $class = new class {
            public function _nostatic_nostatic_closure() { return function () { return get_class($this); }; }

            public function _nostatic_static_closure() { return static function () { return get_class($this); }; }

            public static function _static_nostatic_closure() { return function () { return get_class($this); }; }

            public static function _static_static_closure() { return static function () { return get_class($this); }; }
        };

        that((is_bindable_closure)(_global_nostatic_closure()))->isTrue();
        that((is_bindable_closure)(_global_static_closure()))->isFalse();
        that((is_bindable_closure)($class->_nostatic_nostatic_closure()))->isTrue();
        that((is_bindable_closure)($class->_nostatic_static_closure()))->isFalse();
        that((is_bindable_closure)($class->_static_nostatic_closure()))->isTrue();
        that((is_bindable_closure)($class->_static_static_closure()))->isFalse();

        // true のやつらは実際に bind してみる
        $dummy = new \stdClass();
        that(\Closure::bind(_global_nostatic_closure(), $dummy)())->is('stdClass');
        that(\Closure::bind($class->_nostatic_nostatic_closure(), $dummy)())->is('stdClass');
        that(\Closure::bind($class->_static_nostatic_closure(), $dummy)())->is('stdClass');
    }

    function test_by_builtin()
    {
        $object = new \BuiltIn();

        $count = 'count';
        that($count($object))->is(1);
        that($object->$count())->is(0);

        that(count($object))->is(1);
        that($object->count())->is(0);

        that(call_user_func('count', $object))->is(1);
        that(call_user_func([$object, 'count']))->is(0);

        that(call_user_func_array('count', [$object]))->is(1);
        that(call_user_func_array([$object, 'count'], []))->is(0);

        that((new \ReflectionFunction('count'))->invoke($object))->is(1);
        that((new \ReflectionMethod($object, 'count'))->invoke($object))->is(0);

        that((new \ReflectionFunction('count'))->invokeArgs([$object]))->is(1);
        that((new \ReflectionMethod($object, 'count'))->invokeArgs($object, []))->is(0);

        that((function () use ($object) { return count($object); })())->is(1);
        that((function () use ($object) { return $object->count(); })())->is(0);

        that([by_builtin, '', ''])->throws('backtrace');
    }

    function test_namedcallize()
    {
        $f1 = function ($x, $a = 1) { return get_defined_vars(); };
        $f2 = function ($x, ...$args) { return get_defined_vars(); };

        // 単純呼び出し
        that((namedcallize)($f1)(['x' => 0]))->is([
            'x' => 0,
            'a' => 1,
        ]);
        that((namedcallize)($f1)(['x' => 0, 'a' => 9]))->is([
            'x' => 0,
            'a' => 9,
        ]);

        // デフォルト
        that((namedcallize)($f1, [
            'x' => 0,
        ])())->is([
            'x' => 0,
            'a' => 1,
        ]);
        that((namedcallize)($f1, [
            'x' => 0,
            'a' => 8,
        ])(['x' => 9, 'a' => 8]))->is([
            'x' => 9,
            'a' => 8,
        ]);
        that((namedcallize)($f1, [
            'x' => 0,
            1   => 8,
        ])(['x' => 9,]))->is([
            'x' => 9,
            'a' => 8,
        ]);
        that((namedcallize)($f1, [
            'x' => 0,
        ])(['x' => 9, 1 => 8]))->is([
            'x' => 9,
            'a' => 8,
        ]);

        // 可変引数
        that((namedcallize)($f2)(['x' => 0, 'args' => [1, 2]]))->is([
            'x'    => 0,
            'args' => [1, 2],
        ]);
        that((namedcallize)($f2)(['x' => 0, 1 => [1, 2]]))->is([
            'x'    => 0,
            'args' => [1, 2],
        ]);

        // 例外系
        $fx = (namedcallize)($f1);
        that([$fx, []])->throws('required arguments');
        that([$fx, ['x' => null, 'unknown' => null]])->throws('undefined arguments');
    }

    function test_parameter_length()
    {
        // タイプ 0: クロージャ
        that((parameter_length)(function ($a, $b = null) { }))->is(2);
        that((parameter_length)(function ($a, $b = null) { }, true))->is(1);
        // クロージャの呼び出し名が特殊なので変なキャッシュされていないか担保するために異なる引数でもう一回テスト
        that((parameter_length)(function ($a, $b, $c = null) { }))->is(3);
        that((parameter_length)(function ($a, $b, $c = null) { }, true))->is(2);

        // タイプ 1: 単純なコールバック
        that((parameter_length)('trim'))->is(2);
        that((parameter_length)('trim', true))->is(1);

        // タイプ 2: 静的クラスメソッドのコール
        that((parameter_length)(['Concrete', 'staticMethod']))->is(1);
        that((parameter_length)(['Concrete', 'staticMethod'], true))->is(0);

        // タイプ 3: オブジェクトメソッドのコール
        that((parameter_length)([new \Concrete(''), 'instanceMethod']))->is(1);
        that((parameter_length)([new \Concrete(''), 'instanceMethod'], true))->is(0);

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        that((parameter_length)('Concrete::staticMethod'))->is(1);
        that((parameter_length)('Concrete::staticMethod', true))->is(0);

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        that((parameter_length)(['Concrete', 'parent::staticMethod']))->is(1);
        that((parameter_length)(['Concrete', 'parent::staticMethod'], true))->is(0);

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        that((parameter_length)(new \Concrete('')))->is(1);
        that((parameter_length)(new \Concrete(''), true))->is(0);

        // 可変引数
        that((parameter_length)(function (...$x) { }, false, true))->is(INF);
    }

    function test_parameter_default()
    {
        $f = function ($a, $b = 'b') { };
        that((parameter_default)($f))->isSame([1 => 'b']);
        that((parameter_default)($f, ['A', 'B']))->isSame(['A', 'B']);
        that((parameter_default)($f, [-1 => 'B']))->isSame([1 => 'B']);
        that((parameter_default)($f, [-2 => 'A', -1 => 'B']))->isSame(['A', 'B']);

        $f = function ($a, ...$x) { };
        that((parameter_default)($f))->isSame([]);
        that((parameter_default)($f, [1 => 'x']))->isSame([1 => 'x']);
        that((parameter_default)($f, [1 => 'x', 2 => 'y']))->isSame([1 => 'x', 2 => 'y']);
        that((parameter_default)($f, [1 => 'x', 3 => 'z']))->isSame([1 => 'x', 3 => 'z']);
        that((parameter_default)($f, ['a', -9 => 'x', -8 => 'y']))->isSame(['a', -7 => 'x', -6 => 'y']);
    }

    function test_parameter_wiring()
    {
        $closure = function (\ArrayObject $ao, \Throwable $t, $array, $method, $closure, $none, $default1, $default2 = 'default2', ...$misc) { return get_defined_vars(); };

        $params = (parameter_wiring)($closure, $that = [
            \ArrayObject::class      => $ao = new \ArrayObject([1, 2, 3]),
            \RuntimeException::class => $t = new \RuntimeException('hoge'),
            '$array'                 => function (\ArrayObject $ao) { return (array) $ao; },
            '$method'                => \Closure::fromCallable([$ao, 'getArrayCopy']),
            '$closure'               => function () { return (array) $this; },
            6                        => 'default1',
            '$misc'                  => ['x', 'y', 'z'],
        ]);
        that($params)->isSame([
            0  => $ao,
            1  => $t,
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

        $params = (parameter_wiring)($closure, $that = [
            '$ao' => $ao = new \ArrayObject([1, 2, 3]),
        ]);
        that($params)->isSame([
            0  => $ao,
            7  => 'default2',
        ]);
    }

    function test_function_shorten()
    {
        require_once __DIR__ . '/Funchand/function_shorten.php';
        that((function_shorten)('FS\\hoge'))->is('hoge');
        that((function_shorten)('strlen'))->is('strlen');
    }

    function test_func_user_func_array()
    {
        // null
        $null = (func_user_func_array)(null);
        that($null('abc'))->is('abc');

        // 標準関数
        $strlen = (func_user_func_array)('strlen');
        that($strlen('abc', null, 'dummy'))->is(3);

        // 可変引数
        $variadic = function (...$v) { return $v; };
        $vcall = (func_user_func_array)($variadic);
        that($vcall('abc', null, 'dummy'))->is(['abc', null, 'dummy']);

        // 自前関数兼デフォルト引数
        $pascal_case = (func_user_func_array)(pascal_case);
        that($pascal_case('this_is_a_pen'))->is('ThisIsAPen');
        // 第2引数を与えても意味を為さない
        that($pascal_case('this_is_a_pen', '-'))->is('ThisIsAPen');
    }

    function test_func_wiring()
    {
        $closure = function ($a, $b, \Exception $c = null) { return func_get_args(); };
        $new_closure = (func_wiring)($closure, [
            \LogicException::class  => null,
            \DomainException::class => null,
            '$a'                    => 'a',
            '$b'                    => 'b',
            1                       => 'B',
            2                       => $c = new \Exception(),
        ]);
        that($new_closure())->isSame(['a', 'B', $c]);
        that($new_closure('A'))->isSame(['A', 'B', $c]);
    }

    function test_func_new()
    {
        $newException = (func_new)(\Exception::class, 'hoge');
        /** @var \Exception $ex */
        $ex = $newException();
        that($ex->getMessage())->is('hoge');
        $ex = $newException('fuga');
        that($ex->getMessage())->is('fuga');
    }

    function test_func_method()
    {
        $object = new class() {
            static function fuga(...$args) { return implode(',', $args); }

            function hoge(...$args) { return implode(',', $args); }
        };

        $hoge = (func_method)('hoge');
        that($hoge($object, 'x', 'y', 'z'))->is('x,y,z');

        $hoge = (func_method)('hoge', 'X', 'Y', 'Z');
        that($hoge($object))->is('X,Y,Z');
        that($hoge($object, 'x'))->is('x,Y,Z');
        that($hoge($object, 'x', 'y', 'z'))->is('x,y,z');

        $fuga = (func_method)('fuga');
        that($fuga(get_class($object), 'x', 'y', 'z'))->is('x,y,z');

        // __construct モード
        $exnames = [
            \Exception::class,
            \InvalidArgumentException::class,
            \UnexpectedValueException::class,
        ];
        /** @var \Exception[] $exs */
        $exs = array_map((func_method)('__construct', 'hoge'), $exnames);
        that($exs[0]->getMessage())->is('hoge');
        that($exs[1]->getMessage())->is('hoge');
        that($exs[2]->getMessage())->is('hoge');

        // array_maps とか array_map_method とかの模倣
        $exs = [
            new \Exception('hoge'),
            new \Exception('fuga'),
            new \Exception('piyo'),
        ];
        that(array_map((func_method)('getMessage'), $exs))->is(['hoge', 'fuga', 'piyo']);
    }

    function test_function_alias()
    {
        require_once __DIR__ . '/Funchand/function_alias.php';
        /** @noinspection PhpUndefinedFunctionInspection */
        {
            // シンプル：組み込み関数
            (function_alias)('strtoupper', 'strtoupper2');
            that(strtoupper2('aaa'))->is('AAA');
            // シンプル：ユーザー定義関数（グローバル）
            (function_alias)('_strtoupper', 'strtoupper3');
            that(strtoupper3('aaa'))->is('AAA');
            // シンプル：ユーザー定義関数（名前空間）
            (function_alias)('FA\\_strtoupper', 'strtoupper4');
            that(strtoupper4('aaa'))->is('AAA');

            // 参照渡し：組み込み関数
            (function_alias)('sort', 'sort2');
            $array = [3, 2, 11];
            that(sort2($array))->isTrue();
            that($array)->is([2, 3, 11]);
            that(sort2($array, SORT_STRING))->isTrue();
            that($array)->is([11, 2, 3]);
            // 参照渡し：ユーザー定義関数（グローバル）
            (function_alias)('_sort', 'sort3');
            $array = [3, 2, 11];
            that(sort3($array))->isTrue();
            that($array)->is([2, 3, 11]);
            that(sort3($array, SORT_STRING))->isTrue();
            that($array)->is([11, 2, 3]);
            // 参照渡し：ユーザー定義関数（名前空間）
            (function_alias)('FA\\_sort', 'sort4');
            $array = [3, 2, 11];
            that(sort4($array))->isTrue();
            that($array)->is([2, 3, 11]);
            that(sort4($array, SORT_STRING))->isTrue();
            that($array)->is([11, 2, 3]);

            // リファレンス返し
            (function_alias)('_ref', '_ref3');
            $vals = &_ref3();
            $vals[] = 'add';
            that(_ref3())->is(['add']);

            // デフォルト引数：組み込み関数
            (function_alias)('trim', 'trim2');
            that(trim2(' aXa '))->is('aXa');
            that(trim2('aXa', 'a'))->is('X');
            // デフォルト引数：ユーザー定義関数（グローバル）
            (function_alias)('_trim', 'trim3');
            that(trim3(' aXa '))->is('aXa');
            that(trim3('aXa', 'a'))->is('X');
            // デフォルト引数：ユーザー定義関数（名前空間）
            (function_alias)('FA\\_trim', 'trim4');
            that(trim4(' aXa '))->is('aXa');
            that(trim4('aXa', 'a'))->is('X');

            // 静的メソッド
            (function_alias)('\Concrete::staticMethod', 'staticMethod2');
            that(staticMethod2())->is('Concrete::staticMethod');

            // 名前空間への吐き出し：ユーザー定義関数（グローバル）
            (function_alias)('_trim', 'O\\trim3');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            that(\O\trim3(' aXa '))->is('aXa');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            that(\O\trim3('aXa', 'a'))->is('X');
            // 名前空間への吐き出し：ユーザー定義関数（名前空間）
            (function_alias)('FA\\_trim', 'O\\trim4');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            that(\O\trim4(' aXa '))->is('aXa');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            that(\O\trim4('aXa', 'a'))->is('X');
        }

        // 例外
        that([function_alias, function () { }, 'xx'])->throws('must not be object');
        that([function_alias, 'x', 'xx'])->throws('does not exist');
        that([function_alias, [new \Concrete('u'), 'getName'], 'xx'])->throws('non-static method');
        that([function_alias, 'implode', 'implode'])->throws('already declared');
    }

    function test_function_parameter()
    {
        // reflection
        $params = (function_parameter)((reflect_callable)(function ($a, &$b, $c = 123, &$d = 456, ...$x) { }));
        that($params)->isSame([
            '$a'  => '$a',
            '&$b' => '&$b',
            '$c'  => '$c = 123',
            '&$d' => '&$d = 456',
            '$x'  => '...$x',
        ]);

        // callable
        $params = (function_parameter)(function ($a, &$b, $c = 123, &$d = 456, ...$x) { });
        that($params)->isSame([
            '$a'  => '$a',
            '&$b' => '&$b',
            '$c'  => '$c = 123',
            '&$d' => '&$d = 456',
            '$x'  => '...$x',
        ]);

        // type hint
        $params = (function_parameter)(function (string $a, int $b, ?FunchandTest $c) { });
        that($params)->isSame([
            '$a' => 'string $a',
            '$b' => 'int $b',
            '$c' => '?\\' . __CLASS__ . ' $c',
        ]);

        // ns\const
        $params = (function_parameter)(function ($a = PHP_SAPI) { });
        that($params)->isSame([
            '$a' => '$a = "cli"'
        ]);
        $params = (function_parameter)(function ($a = \PHP_SAPI) { });
        that($params)->isSame([
            '$a' => '$a = PHP_SAPI'
        ]);

        // internal
        $params = (function_parameter)('trim');
        that($params)->isSame([
            '$str'            => '$str',
            '$character_mask' => '$character_mask = null'
        ]);
    }
}
