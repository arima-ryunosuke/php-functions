<?php
namespace ryunosuke\Test\package;

class FunchandTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_nbind()
    {
        $arrayize_2X = nbind(arrayize, 2, 'X');
        $this->assertEquals([1, 2, 'X', 3, 4], $arrayize_2X(1, 2, 3, 4));

        $arrayize_3XY = nbind(arrayize, 3, 'X', 'Y');
        $this->assertEquals([1, 2, 3, 'X', 'Y', 4], $arrayize_3XY(1, 2, 3, 4));
    }

    function test_nbind_arity()
    {
        // 引数を7個要求するクロージャ
        $func7 = function ($_0, $_1, $_2, $_3, $_4, $_5, $_6) { return func_get_args(); };
        $func6 = nbind($func7, 6, 'g');// 引数を6個要求するクロージャ
        $func5 = nbind($func6, 5, 'f');// 引数を5個要求するクロージャ
        $func4 = nbind($func5, 4, 'e');// 引数を4個要求するクロージャ
        $func3 = nbind($func4, 3, 'd');// 引数を3個要求するクロージャ
        $func2 = nbind($func3, 2, 'c');// 引数を2個要求するクロージャ
        $func1 = nbind($func2, 1, 'b');// 引数を1個要求するクロージャ
        $func0 = nbind($func1, 0, 'a');// 引数を0個要求するクロージャ

        $this->assertEquals(0, parameter_length($func0));
        $this->assertEquals(1, parameter_length($func1));
        $this->assertEquals(2, parameter_length($func2));
        $this->assertEquals(3, parameter_length($func3));
        $this->assertEquals(4, parameter_length($func4));
        $this->assertEquals(5, parameter_length($func5));
        $this->assertEquals(6, parameter_length($func6));
        $this->assertEquals(7, parameter_length($func7));

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
        $arrayize_lX = lbind(arrayize, 'X');
        $this->assertEquals(['X', 1, 2, 3, 4], $arrayize_lX(1, 2, 3, 4));

        $arrayize_lXY = lbind(arrayize, 'X', 'Y');
        $this->assertEquals(['X', 'Y', 1, 2, 3, 4], $arrayize_lXY(1, 2, 3, 4));
    }

    function test_rbind()
    {
        $arrayize_rX = rbind(arrayize, 'X');
        $this->assertEquals([1, 2, 3, 4, 'X'], $arrayize_rX(1, 2, 3, 4));

        $arrayize_rXY = rbind(arrayize, 'X', 'Y');
        $this->assertEquals([1, 2, 3, 4, 'X', 'Y'], $arrayize_rXY(1, 2, 3, 4));
    }

    function test_return_arg()
    {
        $return1 = return_arg(1);
        $this->assertEquals(2, $return1(1, 2, 3));
    }

    function test_not_func()
    {
        $not_strlen = not_func('strlen');
        $this->assertFalse($not_strlen('hoge'));
        $this->assertTrue($not_strlen(''));

        $this->assertEquals(1, parameter_length(not_func('strlen')));
    }

    function test_eval_func()
    {
        $this->assertEquals(4, call_user_func(eval_func('4')));
        $this->assertEquals(7, call_user_func(eval_func('$a + $b', 'a', 'b'), 3, 4));

        $this->assertEquals(0, parameter_length(eval_func('$v')));
        $this->assertEquals(1, parameter_length(eval_func('$v', 'a')));
        $this->assertEquals(2, parameter_length(eval_func('$v', 'a', 'b')));
    }

    function test_reflect_callable()
    {
        // タイプ 0: クロージャ
        $this->assertInstanceOf('\ReflectionFunction', reflect_callable(function () { }));

        // タイプ 1: 単純なコールバック
        $this->assertInstanceOf('\ReflectionFunction', reflect_callable('strlen'));

        // タイプ 2: 静的クラスメソッドのコール
        $this->assertInstanceOf('\ReflectionMethod', reflect_callable(['Concrete', 'staticMethod']));

        // タイプ 3: オブジェクトメソッドのコール
        $this->assertInstanceOf('\ReflectionMethod', reflect_callable([new \Concrete(''), 'instanceMethod']));

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        $this->assertInstanceOf('\ReflectionMethod', reflect_callable('Concrete::staticMethod'));

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        $this->assertInstanceOf('\ReflectionMethod', reflect_callable(['Concrete', 'parent::staticMethod']));

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        $this->assertInstanceOf('\ReflectionMethod', reflect_callable(new \Concrete('')));

        // タイプ X: メソッドスコープ
        $this->assertInstanceOf('\ReflectionMethod', reflect_callable(['PrivateClass', 'privateMethod']));

        // そんなものは存在しない
        $this->assertException('does not exist', function () {
            reflect_callable('hogefuga');
        });

        // そもそも形式がおかしい
        $this->assertException('is not callable', function () {
            reflect_callable([]);
        });
    }

    function test_closurize()
    {
        // タイプ 0: クロージャ
        $this->assertEquals('aaa', call_user_func(closurize(function ($v) { return $v; }), 'aaa'));

        // タイプ 1: 単純なコールバック
        $this->assertEquals(3, call_user_func(closurize('strlen'), 'aaa'));

        // タイプ 2: 静的クラスメソッドのコール
        $this->assertEquals('Concrete::staticMethod', call_user_func(closurize(['Concrete', 'staticMethod'])));

        // タイプ 3: オブジェクトメソッドのコール
        $this->assertEquals('Concrete::instanceMethod', call_user_func(closurize([new \Concrete(''), 'instanceMethod'])));

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        $this->assertEquals('Concrete::staticMethod', call_user_func(closurize('Concrete::staticMethod')));

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        $this->assertEquals('AbstractConcrete::staticMethod', call_user_func(closurize(['Concrete', 'parent::staticMethod'])));

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        $this->assertEquals('Concrete::__invoke', call_user_func(closurize(new \Concrete('hoge'))));
    }

    function test_call_safely()
    {
        $h = function () { };
        set_error_handler($h);

        // 正常なら返り値を返す
        $this->assertEquals(999, call_safely(function ($v) { return $v; }, 999));

        // エラーが出たら例外を投げる
        $this->assertException('Undefined variable', function () {
            call_safely(function () {
                /** @noinspection PhpUndefinedVariableInspection */
                return $v;
            });
        });

        // @で抑制した場合は例外は飛ばない
        $this->assertSame(null, call_safely(function () {
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
        $this->assertEquals('hoge', ob_capture(function ($v) {
            echo $v;
        }, 'hoge'));
        // ob レベルは変わらない
        $this->assertEquals($current, ob_get_level());

        // 処理中に飛んだ例外が飛ぶ
        $this->assertException('inob', function () {
            ob_capture(function ($v) {
                throw new \Exception('inob');
            }, 'hoge');
        });
        // ob レベルは変わらない
        $this->assertEquals($current, ob_get_level());
    }

    function test_parameter_length()
    {
        // タイプ 0: クロージャ
        $this->assertEquals(2, parameter_length(function ($a, $b = null) { }));
        $this->assertEquals(1, parameter_length(function ($a, $b = null) { }, true));
        // クロージャの呼び出し名が特殊なので変なキャッシュされていないか担保するために異なる引数でもう一回テスト
        $this->assertEquals(3, parameter_length(function ($a, $b, $c = null) { }));
        $this->assertEquals(2, parameter_length(function ($a, $b, $c = null) { }, true));

        // タイプ 1: 単純なコールバック
        $this->assertEquals(2, parameter_length('trim'));
        $this->assertEquals(1, parameter_length('trim', true));

        // タイプ 2: 静的クラスメソッドのコール
        $this->assertEquals(1, parameter_length(['Concrete', 'staticMethod']));
        $this->assertEquals(0, parameter_length(['Concrete', 'staticMethod'], true));

        // タイプ 3: オブジェクトメソッドのコール
        $this->assertEquals(1, parameter_length([new \Concrete(''), 'instanceMethod']));
        $this->assertEquals(0, parameter_length([new \Concrete(''), 'instanceMethod'], true));

        // タイプ 4: 静的クラスメソッドのコール (PHP 5.2.3 以降)
        $this->assertEquals(1, parameter_length('Concrete::staticMethod'));
        $this->assertEquals(0, parameter_length('Concrete::staticMethod', true));

        // タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        $this->assertEquals(1, parameter_length(['Concrete', 'parent::staticMethod']));
        $this->assertEquals(0, parameter_length(['Concrete', 'parent::staticMethod'], true));

        // タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
        $this->assertEquals(1, parameter_length(new \Concrete('')));
        $this->assertEquals(0, parameter_length(new \Concrete(''), true));
    }

    function test_func_user_func_array()
    {
        // null
        $null = func_user_func_array(null);
        $this->assertEquals('abc', $null('abc'));

        // 標準関数
        $strlen = func_user_func_array('strlen');
        $this->assertEquals(3, $strlen('abc', null, 'dummy'));

        // 自前関数兼デフォルト引数
        $pascal_case = func_user_func_array(pascal_case);
        $this->assertEquals('ThisIsAPen', $pascal_case('this_is_a_pen'));
        // 第2引数を与えても意味を為さない
        $this->assertEquals('ThisIsAPen', $pascal_case('this_is_a_pen', '-'));
    }
}
