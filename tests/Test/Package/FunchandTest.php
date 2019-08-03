<?php

namespace ryunosuke\Test\Package;

class FunchandTest extends AbstractTestCase
{
    function test_abind()
    {
        $sprintf = (abind)('sprintf', [1 => 'a', 3 => 'c']);
        $this->assertEquals('abcZ', $sprintf('%s%s%s%s', 'b', 'Z'));
    }

    function test_nbind()
    {
        $arrayize_2X = (nbind)(arrayize, 2, 'X');
        $this->assertEquals([1, 2, 'X', 3, 4], $arrayize_2X(1, 2, 3, 4));

        $arrayize_3XY = (nbind)(arrayize, 3, 'X', 'Y');
        $this->assertEquals([1, 2, 3, 'X', 'Y', 4], $arrayize_3XY(1, 2, 3, 4));
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

        $this->assertEquals(0, (parameter_length)($func0));
        $this->assertEquals(1, (parameter_length)($func1));
        $this->assertEquals(2, (parameter_length)($func2));
        $this->assertEquals(3, (parameter_length)($func3));
        $this->assertEquals(4, (parameter_length)($func4));
        $this->assertEquals(5, (parameter_length)($func5));
        $this->assertEquals(6, (parameter_length)($func6));
        $this->assertEquals(7, (parameter_length)($func7));

        $this->assertEquals(['a', 'b', 'c', 'd', 'e', 'f', 'g'], $func0());
        $this->assertEquals(['A', 'b', 'c', 'd', 'e', 'f', 'g'], $func1('A'));
        $this->assertEquals(['A', 'B', 'c', 'd', 'e', 'f', 'g'], $func2('A', 'B'));
        $this->assertEquals(['A', 'B', 'C', 'd', 'e', 'f', 'g'], $func3('A', 'B', 'C'));
        $this->assertEquals(['A', 'B', 'C', 'D', 'e', 'f', 'g'], $func4('A', 'B', 'C', 'D'));
        $this->assertEquals(['A', 'B', 'C', 'D', 'E', 'f', 'g'], $func5('A', 'B', 'C', 'D', 'E'));
        $this->assertEquals(['A', 'B', 'C', 'D', 'E', 'F', 'g'], $func6('A', 'B', 'C', 'D', 'E', 'F'));
        $this->assertEquals(['A', 'B', 'C', 'D', 'E', 'F', 'G'], $func7('A', 'B', 'C', 'D', 'E', 'F', 'G'));
    }

    function test_lbind()
    {
        $arrayize_lX = (lbind)(arrayize, 'X');
        $this->assertEquals(['X', 1, 2, 3, 4], $arrayize_lX(1, 2, 3, 4));

        $arrayize_lXY = (lbind)(arrayize, 'X', 'Y');
        $this->assertEquals(['X', 'Y', 1, 2, 3, 4], $arrayize_lXY(1, 2, 3, 4));
    }

    function test_rbind()
    {
        $arrayize_rX = (rbind)(arrayize, 'X');
        $this->assertEquals([1, 2, 3, 4, 'X'], $arrayize_rX(1, 2, 3, 4));

        $arrayize_rXY = (rbind)(arrayize, 'X', 'Y');
        $this->assertEquals([1, 2, 3, 4, 'X', 'Y'], $arrayize_rXY(1, 2, 3, 4));
    }

    function test_composite()
    {
        // arrayable:false モード
        $add5 = function ($v) { return $v + 5; };
        $mul3 = function ($v) { return $v * 3; };
        $split = function ($v) { return str_split($v); };
        $union = function ($v) { return $v[0] + $v[1]; };
        $compositeF = (composite)(false, $add5, $mul3, $split, $union);
        $this->assertEquals(9, $compositeF(7));
        $this->assertEquals(12, $compositeF(17));

        // arrayable:true モード
        $xy_xyz = function ($x, $y) { return [$x, $y, $x + $y]; }; // ただの配列を返すと次の引数に展開される
        $xyz_X = function ($x, $y, $z) { return $x + $y + $z; };   // 単値を返すとそのまま
        $X_xX = function ($X) { return ['x' => $X]; };             // 連想配列を返してもそのまま
        $xX_Xx = function ($xX) { return array_flip($xX); };       //
        $compositeF = (composite)(true, $xy_xyz, $xyz_X, $X_xX, $xX_Xx);
        $this->assertEquals([20 => 'x'], $compositeF(1, 9));

        // 1 arg
        $trim = (composite)('trim');
        $this->assertEquals('a', $trim(' a '));
        $trim = (composite)(false, 'trim');
        $this->assertEquals('a', $trim(' a '));

        $this->assertException('too few', composite);
        $this->assertException('too few', composite, true);
    }

    function test_composite_variadic()
    {
        $variadic1 = function (...$v) {
            return array_map(function ($v) { return $v + 1; }, $v);
        };
        $variadic2 = function (...$v) {
            return array_map(function ($v) { return $v * 2; }, $v);
        };
        $variadic3 = function (...$v) {
            return array_map(function ($v) { return $v ** 2; }, $v);
        };
        // +1 して *2 して ** 2 して返す可変引数の合成関数
        $compositeF = (composite)(true, $variadic1, $variadic2, $variadic3);
        $this->assertEquals([16, 36, 64, 100, 144], $compositeF(1, 2, 3, 4, 5));
    }

    function test_return_arg()
    {
        $return1 = (return_arg)(1);
        $this->assertEquals(2, $return1(1, 2, 3));
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
                $this->assertSame(eval($expression), (ope_func)($op)(...$args), "$expression is failed.");
            }
        }

        // 一部 eval ではテスト出来ないので個別でテスト
        $x = 99;
        $this->assertSame(100, (ope_func)('++')($x));
        $this->assertSame(100, $x);
        $this->assertSame(99, (ope_func)('--')($x));
        $this->assertSame(99, $x);
        $this->assertTrue((ope_func)('instanceof')(new \stdClass(), \stdClass::class));
        $this->assertFalse((ope_func)('instanceof')(new \stdClass(), \Exception::class));

        // 例外系
        $this->assertException('is not defined', ope_func, 'hogera');
    }

    function test_not_func()
    {
        $not_strlen = (not_func)('strlen');
        $this->assertFalse($not_strlen('hoge'));
        $this->assertTrue($not_strlen(''));

        $this->assertEquals(1, (parameter_length)((not_func)('strlen')));
    }

    function test_eval_func()
    {
        $this->assertEquals(4, (eval_func)('4')());
        $this->assertEquals(7, (eval_func)('$a + $b', 'a', 'b')(3, 4));

        $a1 = (eval_func)('$a', 'a');
        $a2 = (eval_func)('$a', 'a');
        $x = (eval_func)('$x', 'x');
        $this->assertSame($a1, $a2);
        $this->assertNotSame($a1, $x);
        $this->assertNotSame($a2, $x);

        $this->assertEquals(0, (parameter_length)((eval_func)('$v')));
        $this->assertEquals(1, (parameter_length)((eval_func)('$v', 'a')));
        $this->assertEquals(2, (parameter_length)((eval_func)('$v', 'a', 'b')));
    }

    function test_reflect_callable()
    {
        // タイプ 0: クロージャ
        $this->assertInstanceOf('\ReflectionFunction', (reflect_callable)(function () { }));

        // タイプ 1: 単純なコールバック
        $this->assertInstanceOf('\ReflectionFunction', (reflect_callable)('strlen'));

        // タイプ 2: 静的クラスメソッドのコール
        $this->assertInstanceOf('\ReflectionMethod', (reflect_callable)(['Concrete', 'staticMethod']));

        // タイプ 3: オブジェクトメソッドのコール
        $this->assertInstanceOf('\ReflectionMethod', (reflect_callable)([new \Concrete(''), 'instanceMethod']));

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        $this->assertInstanceOf('\ReflectionMethod', (reflect_callable)('Concrete::staticMethod'));

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        $this->assertInstanceOf('\ReflectionMethod', (reflect_callable)(['Concrete', 'parent::staticMethod']));

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        $this->assertInstanceOf('\ReflectionMethod', (reflect_callable)(new \Concrete('')));

        // タイプ X: メソッドスコープ
        $this->assertInstanceOf('\ReflectionMethod', (reflect_callable)(['PrivateClass', 'privateMethod']));

        // そんなものは存在しない
        $this->assertException('does not exist', reflect_callable, 'hogefuga');

        // そもそも形式がおかしい
        $this->assertException('is not callable', reflect_callable, []);
    }

    function test_closurize()
    {
        // タイプ 0: クロージャ
        $this->assertEquals('aaa', (closurize)(function ($v) { return $v; })('aaa'));

        // タイプ 1: 単純なコールバック
        $this->assertEquals(3, (closurize)('strlen')('aaa'));

        // タイプ 2: 静的クラスメソッドのコール
        $this->assertEquals('Concrete::staticMethod', (closurize)(['Concrete', 'staticMethod'])());

        // タイプ 3: オブジェクトメソッドのコール
        $this->assertEquals('Concrete::instanceMethod', (closurize)([new \Concrete(''), 'instanceMethod'])());

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        $this->assertEquals('Concrete::staticMethod', (closurize)('Concrete::staticMethod')());

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        $this->assertEquals('AbstractConcrete::staticMethod', (closurize)(['Concrete', 'parent::staticMethod'])());

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        $this->assertEquals('Concrete::__invoke', (closurize)(new \Concrete('hoge'))());
    }

    function test_callable_code()
    {
        function hoge_callable_code()
        {
            return true;
        }

        $code = (callable_code)(__NAMESPACE__ . "\\hoge_callable_code");
        $this->assertEquals([
            'function hoge_callable_code()',
            '{
            return true;
        }',
        ], $code);

        $code = (callable_code)([$this, 'createResult']);
        $this->assertEquals([
            'function createResult(): TestResult',
            '{
        return new TestResult;
    }',
        ], $code);

        $usevar = null;
        $code = (callable_code)(function ($arg1 = "{\n}") use ($usevar): \Closure {
            if (true) {
                return function () use ($usevar) {

                };
            }
        });
        $this->assertEquals([
            'function ($arg1 = "{\n}") use ($usevar): \Closure',
            '{
            if (true) {
                return function () use ($usevar) {

                };
            }
        }',
        ], $code);
    }

    function test_call_safely()
    {
        $h = function () { };
        set_error_handler($h);

        // 正常なら返り値を返す
        $this->assertEquals(999, (call_safely)(function ($v) { return $v; }, 999));

        // エラーが出たら例外を投げる
        $this->assertException('Undefined variable', call_safely, function () {
            /** @noinspection PhpUndefinedVariableInspection */
            return $v;
        });

        // @で抑制した場合は例外は飛ばない
        $this->assertSame(null, (call_safely)(function () {
            /** @noinspection PhpUndefinedVariableInspection */
            return @$v;
        }));

        // エラーハンドラが戻っている
        $this->assertSame($h, set_error_handler(function () { }));
        restore_error_handler();

        restore_error_handler();
    }

    function test_ob_capture()
    {
        $current = ob_get_level();

        // コールバックの出力が返される
        $this->assertEquals('hoge', (ob_capture)(function ($v) {
            echo $v;
        }, 'hoge'));
        // ob レベルは変わらない
        $this->assertEquals($current, ob_get_level());

        // 処理中に飛んだ例外が飛ぶ
        $this->assertException('inob', ob_capture, function ($v) {
            throw new \Exception('inob');
        }, 'hoge');
        // ob レベルは変わらない
        $this->assertEquals($current, ob_get_level());
    }

    function test_is_bindable_closure()
    {
        function _global_nostatic_closure() { return function () { return get_class($this); }; }

        function _global_static_closure() { return static function () { return get_class($this); }; }

        $class = new class
        {
            public function _nostatic_nostatic_closure() { return function () { return get_class($this); }; }

            public function _nostatic_static_closure() { return static function () { return get_class($this); }; }

            public static function _static_nostatic_closure() { return function () { return get_class($this); }; }

            public static function _static_static_closure() { return static function () { return get_class($this); }; }
        };

        $this->assertTrue((is_bindable_closure)(_global_nostatic_closure()));
        $this->assertFalse((is_bindable_closure)(_global_static_closure()));
        $this->assertTrue((is_bindable_closure)($class->_nostatic_nostatic_closure()));
        $this->assertFalse((is_bindable_closure)($class->_nostatic_static_closure()));
        $this->assertTrue((is_bindable_closure)($class->_static_nostatic_closure()));
        $this->assertFalse((is_bindable_closure)($class->_static_static_closure()));

        // true のやつらは実際に bind してみる
        $dummy = new \stdClass();
        $this->assertEquals('stdClass', \Closure::bind(_global_nostatic_closure(), $dummy)());
        $this->assertEquals('stdClass', \Closure::bind($class->_nostatic_nostatic_closure(), $dummy)());
        $this->assertEquals('stdClass', \Closure::bind($class->_static_nostatic_closure(), $dummy)());
    }

    function test_by_builtin()
    {
        $object = new \BuiltIn();

        $count = 'count';
        $this->assertEquals(1, $count($object));
        $this->assertEquals(0, $object->$count());

        $this->assertEquals(1, count($object));
        $this->assertEquals(0, $object->count());

        $this->assertEquals(1, call_user_func('count', $object));
        $this->assertEquals(0, call_user_func([$object, 'count']));

        $this->assertEquals(1, call_user_func_array('count', [$object]));
        $this->assertEquals(0, call_user_func_array([$object, 'count'], []));

        $this->assertEquals(1, (new \ReflectionFunction('count'))->invoke($object));
        $this->assertEquals(0, (new \ReflectionMethod($object, 'count'))->invoke($object));

        $this->assertEquals(1, (new \ReflectionFunction('count'))->invokeArgs([$object]));
        $this->assertEquals(0, (new \ReflectionMethod($object, 'count'))->invokeArgs($object, []));

        $this->assertEquals(1, (function () use ($object) { return count($object); })());
        $this->assertEquals(0, (function () use ($object) { return $object->count(); })());

        $this->assertException('backtrace', by_builtin, '', '');
    }

    function test_namedcallize()
    {
        $f1 = function ($x, $a = 1) { return get_defined_vars(); };
        $f2 = function ($x, ...$args) { return get_defined_vars(); };

        // 単純呼び出し
        $this->assertEquals([
            'x' => 0,
            'a' => 1,
        ], (namedcallize)($f1)(['x' => 0]));
        $this->assertEquals([
            'x' => 0,
            'a' => 9,
        ], (namedcallize)($f1)(['x' => 0, 'a' => 9]));

        // デフォルト
        $this->assertEquals([
            'x' => 0,
            'a' => 1,
        ], (namedcallize)($f1, [
            'x' => 0,
        ])());
        $this->assertEquals([
            'x' => 9,
            'a' => 8,
        ], (namedcallize)($f1, [
            'x' => 0,
            'a' => 8,
        ])(['x' => 9, 'a' => 8]));
        $this->assertEquals([
            'x' => 9,
            'a' => 8,
        ], (namedcallize)($f1, [
            'x' => 0,
            1   => 8,
        ])(['x' => 9,]));
        $this->assertEquals([
            'x' => 9,
            'a' => 8,
        ], (namedcallize)($f1, [
            'x' => 0,
        ])(['x' => 9, 1 => 8]));

        // 可変引数
        $this->assertEquals([
            'x'    => 0,
            'args' => [1, 2],
        ], (namedcallize)($f2)(['x' => 0, 'args' => [1, 2]]));
        $this->assertEquals([
            'x'    => 0,
            'args' => [1, 2],
        ], (namedcallize)($f2)(['x' => 0, 1 => [1, 2]]));

        // 例外系
        $fx = (namedcallize)($f1);
        $this->assertException('required arguments', $fx, []);
        $this->assertException('undefined arguments', $fx, ['x' => null, 'unknown' => null]);
    }

    function test_parameter_length()
    {
        // タイプ 0: クロージャ
        $this->assertEquals(2, (parameter_length)(function ($a, $b = null) { }));
        $this->assertEquals(1, (parameter_length)(function ($a, $b = null) { }, true));
        // クロージャの呼び出し名が特殊なので変なキャッシュされていないか担保するために異なる引数でもう一回テスト
        $this->assertEquals(3, (parameter_length)(function ($a, $b, $c = null) { }));
        $this->assertEquals(2, (parameter_length)(function ($a, $b, $c = null) { }, true));

        // タイプ 1: 単純なコールバック
        $this->assertEquals(2, (parameter_length)('trim'));
        $this->assertEquals(1, (parameter_length)('trim', true));

        // タイプ 2: 静的クラスメソッドのコール
        $this->assertEquals(1, (parameter_length)(['Concrete', 'staticMethod']));
        $this->assertEquals(0, (parameter_length)(['Concrete', 'staticMethod'], true));

        // タイプ 3: オブジェクトメソッドのコール
        $this->assertEquals(1, (parameter_length)([new \Concrete(''), 'instanceMethod']));
        $this->assertEquals(0, (parameter_length)([new \Concrete(''), 'instanceMethod'], true));

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        $this->assertEquals(1, (parameter_length)('Concrete::staticMethod'));
        $this->assertEquals(0, (parameter_length)('Concrete::staticMethod', true));

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        $this->assertEquals(1, (parameter_length)(['Concrete', 'parent::staticMethod']));
        $this->assertEquals(0, (parameter_length)(['Concrete', 'parent::staticMethod'], true));

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        $this->assertEquals(1, (parameter_length)(new \Concrete('')));
        $this->assertEquals(0, (parameter_length)(new \Concrete(''), true));
    }

    function test_function_shorten()
    {
        require_once __DIR__ . '/Funchand/function_shorten.php';
        $this->assertEquals('hoge', (function_shorten)('FS\\hoge'));
        $this->assertEquals('strlen', (function_shorten)('strlen'));
    }

    function test_func_user_func_array()
    {
        // null
        $null = (func_user_func_array)(null);
        $this->assertEquals('abc', $null('abc'));

        // 標準関数
        $strlen = (func_user_func_array)('strlen');
        $this->assertEquals(3, $strlen('abc', null, 'dummy'));

        // 可変引数
        $variadic = function (...$v) { return $v; };
        $vcall = (func_user_func_array)($variadic);
        $this->assertEquals(['abc', null, 'dummy'], $vcall('abc', null, 'dummy'));

        // 自前関数兼デフォルト引数
        $pascal_case = (func_user_func_array)(pascal_case);
        $this->assertEquals('ThisIsAPen', $pascal_case('this_is_a_pen'));
        // 第2引数を与えても意味を為さない
        $this->assertEquals('ThisIsAPen', $pascal_case('this_is_a_pen', '-'));
    }

    function test_func_new()
    {
        $newException = (func_new)(\Exception::class, 'hoge');
        /** @var \Exception $ex */
        $ex = $newException();
        $this->assertEquals('hoge', $ex->getMessage());
        $ex = $newException('fuga');
        $this->assertEquals('fuga', $ex->getMessage());
    }

    function test_func_method()
    {
        $object = new class()
        {
            static function fuga(...$args) { return implode(',', $args); }

            function hoge(...$args) { return implode(',', $args); }
        };

        $hoge = (func_method)('hoge');
        $this->assertEquals('x,y,z', $hoge($object, 'x', 'y', 'z'));

        $hoge = (func_method)('hoge', 'X', 'Y', 'Z');
        $this->assertEquals('X,Y,Z', $hoge($object));
        $this->assertEquals('x,Y,Z', $hoge($object, 'x'));
        $this->assertEquals('x,y,z', $hoge($object, 'x', 'y', 'z'));

        $fuga = (func_method)('fuga');
        $this->assertEquals('x,y,z', $fuga(get_class($object), 'x', 'y', 'z'));

        // __construct モード
        $exnames = [
            \Exception::class,
            \InvalidArgumentException::class,
            \UnexpectedValueException::class,
        ];
        /** @var \Exception[] $exs */
        $exs = array_map((func_method)('__construct', 'hoge'), $exnames);
        $this->assertEquals('hoge', $exs[0]->getMessage());
        $this->assertEquals('hoge', $exs[1]->getMessage());
        $this->assertEquals('hoge', $exs[2]->getMessage());

        // array_maps とか array_map_method とかの模倣
        $exs = [
            new \Exception('hoge'),
            new \Exception('fuga'),
            new \Exception('piyo'),
        ];
        $this->assertEquals(['hoge', 'fuga', 'piyo'], array_map((func_method)('getMessage'), $exs));
    }

    function test_function_alias()
    {
        require_once __DIR__ . '/Funchand/function_alias.php';
        /** @noinspection PhpUndefinedFunctionInspection */
        {
            // シンプル：組み込み関数
            (function_alias)('strtoupper', 'strtoupper2');
            $this->assertEquals('AAA', strtoupper2('aaa'));
            // シンプル：ユーザー定義関数（グローバル）
            (function_alias)('_strtoupper', 'strtoupper3');
            $this->assertEquals('AAA', strtoupper3('aaa'));
            // シンプル：ユーザー定義関数（名前空間）
            (function_alias)('FA\\_strtoupper', 'strtoupper4');
            $this->assertEquals('AAA', strtoupper4('aaa'));

            // 参照渡し：組み込み関数
            (function_alias)('sort', 'sort2');
            $array = [3, 2, 11];
            $this->assertTrue(sort2($array));
            $this->assertEquals([2, 3, 11], $array);
            $this->assertTrue(sort2($array, SORT_STRING));
            $this->assertEquals([11, 2, 3], $array);
            // 参照渡し：ユーザー定義関数（グローバル）
            (function_alias)('_sort', 'sort3');
            $array = [3, 2, 11];
            $this->assertTrue(sort3($array));
            $this->assertEquals([2, 3, 11], $array);
            $this->assertTrue(sort3($array, SORT_STRING));
            $this->assertEquals([11, 2, 3], $array);
            // 参照渡し：ユーザー定義関数（名前空間）
            (function_alias)('FA\\_sort', 'sort4');
            $array = [3, 2, 11];
            $this->assertTrue(sort4($array));
            $this->assertEquals([2, 3, 11], $array);
            $this->assertTrue(sort4($array, SORT_STRING));
            $this->assertEquals([11, 2, 3], $array);

            // リファレンス返し
            (function_alias)('_ref', '_ref3');
            $vals = &_ref3();
            $vals[] = 'add';
            $this->assertEquals(['add'], _ref3());

            // デフォルト引数：組み込み関数
            (function_alias)('trim', 'trim2');
            $this->assertEquals('aXa', trim2(' aXa '));
            $this->assertEquals('X', trim2('aXa', 'a'));
            // デフォルト引数：ユーザー定義関数（グローバル）
            (function_alias)('_trim', 'trim3');
            $this->assertEquals('aXa', trim3(' aXa '));
            $this->assertEquals('X', trim3('aXa', 'a'));
            // デフォルト引数：ユーザー定義関数（名前空間）
            (function_alias)('FA\\_trim', 'trim4');
            $this->assertEquals('aXa', trim4(' aXa '));
            $this->assertEquals('X', trim4('aXa', 'a'));

            // 静的メソッド
            (function_alias)('\Concrete::staticMethod', 'staticMethod2');
            $this->assertEquals('Concrete::staticMethod', staticMethod2());

            // 名前空間への吐き出し：ユーザー定義関数（グローバル）
            (function_alias)('_trim', 'O\\trim3');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            $this->assertEquals('aXa', \O\trim3(' aXa '));
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            $this->assertEquals('X', \O\trim3('aXa', 'a'));
            // 名前空間への吐き出し：ユーザー定義関数（名前空間）
            (function_alias)('FA\\_trim', 'O\\trim4');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            $this->assertEquals('aXa', \O\trim4(' aXa '));
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            $this->assertEquals('X', \O\trim4('aXa', 'a'));
        }

        // 例外
        $this->assertException('must not be object', function_alias, function () { }, 'xx');
        $this->assertException('does not exist', function_alias, 'x', 'xx');
        $this->assertException('non-static method', function_alias, [new \Concrete('u'), 'getName'], 'xx');
        $this->assertException('already declared', function_alias, 'implode', 'implode');
    }

    function test_function_parameter()
    {
        // reflection
        $params = (function_parameter)((reflect_callable)(function ($a, &$b, $c = 123, &$d = 456, ...$x) { }));
        $this->assertSame([
            '$a'  => '$a',
            '&$b' => '&$b',
            '$c'  => '$c = 123',
            '&$d' => '&$d = 456',
            '$x'  => '...$x',
        ], $params);

        // callable
        $params = (function_parameter)(function ($a, &$b, $c = 123, &$d = 456, ...$x) { });
        $this->assertSame([
            '$a'  => '$a',
            '&$b' => '&$b',
            '$c'  => '$c = 123',
            '&$d' => '&$d = 456',
            '$x'  => '...$x',
        ], $params);

        // type hint
        $params = (function_parameter)(function (string $a, int $b, ?FunchandTest $c) { });
        $this->assertSame([
            '$a' => 'string $a',
            '$b' => 'int $b',
            '$c' => '?\\' . __CLASS__ . ' $c',
        ], $params);

        // ns\const
        $params = (function_parameter)(function ($a = PHP_SAPI) { });
        $this->assertSame([
            '$a' => '$a = "cli"'
        ], $params);
        $params = (function_parameter)(function ($a = \PHP_SAPI) { });
        $this->assertSame([
            '$a' => '$a = PHP_SAPI'
        ], $params);

        // internal
        $params = (function_parameter)('trim');
        $this->assertSame([
            '$str'            => '$str',
            '$character_mask' => '$character_mask = null'
        ], $params);
    }
}
