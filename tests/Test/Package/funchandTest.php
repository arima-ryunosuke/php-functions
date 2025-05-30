<?php

namespace ryunosuke\Test\Package;

use ryunosuke\Functions\Utility;
use function ryunosuke\Functions\Package\chain;
use function ryunosuke\Functions\Package\func_eval;
use function ryunosuke\Functions\Package\func_method;
use function ryunosuke\Functions\Package\func_new;
use function ryunosuke\Functions\Package\func_operator;
use function ryunosuke\Functions\Package\func_user_func_array;
use function ryunosuke\Functions\Package\func_wiring;
use function ryunosuke\Functions\Package\function_alias;
use function ryunosuke\Functions\Package\function_configure;
use function ryunosuke\Functions\Package\function_shorten;
use function ryunosuke\Functions\Package\is_bindable_closure;
use function ryunosuke\Functions\Package\is_callback;
use function ryunosuke\Functions\Package\parameter_length;

class funchandTest extends AbstractTestCase
{
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

        that((fn() => count($object))())->is(1);
        that((fn() => $object->count())())->is(0);

        that(self::resolveFunction('by_builtin'))('', '')->wasThrown('backtrace');
    }

    function test_chain()
    {
        $restorer = $this->restorer(fn($v) => function_configure(['chain.version' => $v]), [2], [1]);

        // (chain)呼び出しだとコード補完が効かないのでラップする
        $chain = function (...$v) {
            /** @var \ChainObject $co */
            $co = chain(...$v);
            return $co;
        };

        // maps/filter/funcE
        $array = [1, 2, 3, 4, 5];
        that($chain($array)->maps['E']('-$1')())->is([-1, -2, -3, -4, -5]);
        that($chain($array)->maps['E']('$1 - 1')->maps['E']('$1 ? 5 : 0')())->is([0, 5, 5, 5, 5]);
        that($chain($array)->filter['E']('$1 >= 3')->maps['E']('$1 + 5')())->is([2 => 8, 9, 10]);
        that($chain($array)->maps['E']('*2')->filter['E']('>5')())->is([2 => 6, 8, 10]);
        that($chain($array)->maps['E']('$1 * $2')->vsprintf[1]('%d,%d,%d,%d,%d')())->is('0,2,6,12,20');

        // maps/filter/funcEval
        $array = [1, 2, 3, 4, 5];
        that($chain($array)->maps['-$1']())->is([-1, -2, -3, -4, -5]);
        that($chain($array)->maps['$1 - 1']->maps['$1 ? 5 : 0']())->is([0, 5, 5, 5, 5]);
        that($chain($array)->filter['$1 >= 3']->maps['$1 + 5']())->is([2 => 8, 9, 10]);
        that($chain($array)->filter['$1 >= 3'](ARRAY_FILTER_USE_KEY)())->is([3 => 4, 4 => 5]);
        that($chain($array)->maps['*2']->filter['>5']())->is([2 => 6, 8, 10]);
        that($chain($array)->maps['$1 * $2']->vsprintf[1]('%d,%d,%d,%d,%d')())->is('0,2,6,12,20');

        // apply
        $string = 'a12345z';
        that($chain($string)
            ->apply(fn($v) => ltrim($v, 'a'))
            ->apply(fn($v) => rtrim($v, 'z'))
            ->apply(fn($v) => number_format($v, 3))
        )()->is('12,345.000');

        // iterator
        $hash = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(iterator_to_array($chain($hash)))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);

        // string
        $string = 'hello';
        that($chain($string)->ucfirst->str_split->implode[1](',')())->is('H,e,l,l,o');
        that((string) $chain($string))->is($string);

        // internal
        $list = '1,2,3,4,5';
        that($chain($list)->multiexplode[1](',')->filters(fn($v, $k) => $k >= 2)->maps(fn($v) => $v * 2)->values()())->is([6, 8, 10]);

        // exception
        that($chain(null))->try('undefined_function')->wasThrown('is not defined');

        // use case
        $rows = [
            ['id' => 1, 'name' => 'hoge', 'sex' => 'F', 'age' => 17, 'salary' => 230000],
            ['id' => 3, 'name' => 'fuga', 'sex' => 'M', 'age' => 43, 'salary' => 480000],
            ['id' => 7, 'name' => 'piyo', 'sex' => 'M', 'age' => 21, 'salary' => 270000],
            ['id' => 9, 'name' => 'hage', 'sex' => 'F', 'age' => 30, 'salary' => 320000],
        ];

        // misc
        $hoge = $chain(['hoge', 'fuga', 1])->filter(fn($v) => is_string($v));
        that(count($hoge))->is(2);
        that(json_encode($hoge))->is('["hoge","fuga"]');

        // e.g. 男性の平均給料
        that($chain($rows)->where('sex', fn($v) => $v === 'M')->column('salary')->mean()())->is(375000);

        // e.g. 女性の平均年齢
        that($chain($rows)->where('sex', fn($v) => $v === 'F')->column('age')->mean()())->is(23.5);

        // e.g. 30歳以上の平均給料
        that($chain($rows)->where('age', fn($v) => $v >= 30)->column('salary')->mean()())->is(400000);

        // e.g. 20～30歳の平均給料
        that($chain($rows)->where['$1["age"] >= 20']->where['$1["age"] <= 30']->column('salary')->mean()())->is(295000);

        // e.g. 男性の最小年齢
        that($chain($rows)->where('sex', fn($v) => $v === 'M')->column('age')->min()())->is(21);

        // e.g. 女性の最大給料
        that($chain($rows)->where('sex', fn($v) => $v === 'F')->column('salary')->max()())->is(320000);

        // e.g. 30歳以上の id => name
        that($chain($rows)->where('age', fn($v) => $v >= 30)->column('name', 'id')())->is([
            3 => 'fuga',
            9 => 'hage',
        ]);

        // exportClass で動くことを担保
        that(Utility::chain($rows)->where['$1["age"] >= 20']->where['$1["age"] <= 30']->column('salary')->mean()())->is(295000);

        // 位置指定とか名前付き引数とか
        that($chain('abcdef')->str_replace[2](replace: 'XYZ', search: 'abc')())->is('XYZdef');
        that($chain('abcdef')->str_replace['subject'](replace: 'XYZ', search: 'abc')())->is('XYZdef');
        that($chain([1, 2, 3])->implode[1](',')())->is('1,2,3');
        that($chain([1, 2, 3])->implode['array'](',')())->is('1,2,3');
        that($chain([1, 2, 3])->implode(separator: ',')())->is('1,2,3');

        $backup = function_configure([
            'chain.nullsafe' => true,
            'placeholder'    => '_',
        ]);
        $placeholder = constant(function_configure('placeholder'));
        /** @noinspection PhpUndefinedMethodInspection */
        {
            that($chain(6)->nullsafe_int_func(3)())->is(103);
            that($chain(3)->nullsafe_int_func[1](6)())->is(103);
            that($chain(null)->nullsafe_int_func(6)())->isNull();
            that($chain(null)->nullsafe_int_func[1](3)())->isNull();
            that($chain(null)->nullsafe_int_func['y'](3)())->isNull();
            that($chain(null)->nullsafe_int_func[2](3, 4)())->is(99);
            that($chain(null)->nullsafe_int_func['z'](3, 4)())->is(99);

            that($chain('A')->concat_abc_z('B', 'C')())->is("ABC()");
            that($chain('A')->concat_abc_z[0]('B', 'C')())->is("ABC()");
            that($chain('B')->concat_abc_z[1]('A', 'C')())->is("ABC()");
            that($chain('C')->concat_abc_z[2]('A', 'B')())->is("ABC()");
            that($chain('Z')->concat_abc_z[2]('A', 'B', 'C')())->is("ABZ(C)");
            that($chain('Z')->concat_abc_z[3]('A', 'B', 'C')())->is("ABC(Z)");
            that($chain('Z')->concat_abc_z[9]('A', 'B', 'C', 'D')())->is("ABC(D,Z)");
            that($chain(['X', 'Y', 'Z'])->concat_abc_z[9]('A', 'B', 'C')())->is("ABC(X,Y,Z)");
            that($chain('A')->concat_abc_z['a']('B', 'C')())->is("ABC()");
            that($chain('B')->concat_abc_z['b']('A', 'C')())->is("ABC()");
            that($chain('C')->concat_abc_z['c']('A', 'B')())->is("ABC()");
            that($chain('Z')->concat_abc_z['z']('A', 'B', 'C')())->is("ABC(Z)");
            that($chain(['X', 'Y', 'Z'])->concat_abc_z['z']('A', 'B', 'C')())->is("ABC(X,Y,Z)");
            that($chain(null)->concat_abc_z[0]('B', 'C')())->isNull();
            that($chain(null)->concat_abc_z[1]('A', 'C')())->isNull();
            that($chain(null)->concat_abc_z[2]('A', 'B')())->isNull();
            that($chain(null)->concat_abc_z['a']('B', 'C')())->isNull();
            that($chain(null)->concat_abc_z['b']('A', 'C')())->isNull();
            that($chain(null)->concat_abc_z['c']('A', 'B')())->isNull();

            that($chain(''))->nullsafe_int_func[999]('A', 'B', 'C')->isThrowable('does not exist');
        }

        that($chain('abc')->replace($placeholder, 'XYZ', 'abcdef')())->is('XYZdef');
        that($chain('XYZ')->replace('abc', $placeholder, 'abcdef')())->is('XYZdef');
        that($chain('abcdef')->replace('abc', 'XYZ', $placeholder)())->is('XYZdef');
        function_configure($backup);

        unset($restorer);
    }

    function test_func_eval()
    {
        that(func_eval('4')())->is(4);
        that(func_eval('$a + $b', 'a', 'b')(3, 4))->is(7);
        that(func_eval('$1 + $2')(3, 4))->is(7);

        $a1 = func_eval('$a', 'a');
        $a2 = func_eval('$a', 'a');
        $x = func_eval('$x', 'x');
        that($a1 === $a2)->isTrue();
        that($a1 !== $x)->isTrue();
        that($a2 !== $x)->isTrue();

        that(parameter_length(func_eval('$v')))->is(0);
        that(parameter_length(func_eval('$v', 'a')))->is(1);
        that(parameter_length(func_eval('$v', 'a', 'b')))->is(2);
    }

    function test_func_method()
    {
        $object = new class() {
            static function fuga(...$args) { return implode(',', $args); }

            function hoge(...$args) { return implode(',', $args); }
        };

        $hoge = func_method('hoge');
        that($hoge($object, 'x', 'y', 'z'))->is('x,y,z');

        $hoge = func_method('hoge', 'X', 'Y', 'Z');
        that($hoge($object))->is('X,Y,Z');
        that($hoge($object, 'x'))->is('x,Y,Z');
        that($hoge($object, 'x', 'y', 'z'))->is('x,y,z');

        $fuga = func_method('fuga');
        that($fuga(get_class($object), 'x', 'y', 'z'))->is('x,y,z');

        // __construct モード
        $exnames = [
            \Exception::class,
            \InvalidArgumentException::class,
            \UnexpectedValueException::class,
        ];
        /** @var \Exception[] $exs */
        $exs = array_map(func_method('__construct', 'hoge'), $exnames);
        that($exs[0]->getMessage())->is('hoge');
        that($exs[1]->getMessage())->is('hoge');
        that($exs[2]->getMessage())->is('hoge');

        // array_maps とか array_map_method とかの模倣
        $exs = [
            new \Exception('hoge'),
            new \Exception('fuga'),
            new \Exception('piyo'),
        ];
        that(array_map(func_method('getMessage'), $exs))->is(['hoge', 'fuga', 'piyo']);
    }

    function test_func_new()
    {
        $newException = func_new(\Exception::class, 'hoge');
        /** @var \Exception $ex */
        $ex = $newException();
        that($ex->getMessage())->is('hoge');
        $ex = $newException('fuga');
        that($ex->getMessage())->is('fuga');
    }

    function test_func_operator()
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
            'new'        => [], // 文字列化できないので個別にテストする
            'clone'      => [], // 文字列化できないので個別にテストする
        ];
        $ve = fn($v) => var_export($v, true);
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
                that(func_operator($op)(...$args))->as("$expression is failed.")->isSame(eval($expression));
            }
        }

        // 一部 eval ではテスト出来ないので個別でテスト
        $x = 99;
        that(func_operator('++')($x))->isSame(100);
        that($x)->isSame(100);
        that(func_operator('--')($x))->isSame(99);
        that($x)->isSame(99);
        that(func_operator('instanceof')(new \stdClass(), \stdClass::class))->isTrue();
        that(func_operator('instanceof')(new \stdClass(), \Exception::class))->isFalse();
        $object = func_operator('new')(\Concrete::class, 'name');
        that($object->getName())->is('name');
        $object2 = func_operator('clone')($object);
        that($object2->getName())->is('name');
        that($object2)->isNotSame($object);

        $p = [1, 1, 2, 4, 5, 6, 1, 3, 8, 4];
        that(array_filter($p, func_operator('==', 5)))->isSame([4 => 5]);

        // 例外系
        that(self::resolveFunction('func_operator'))('hogera')->wasThrown('is not defined');
    }

    function test_func_user_func_array()
    {
        // null
        $null = func_user_func_array(null);
        that($null('abc'))->is('abc');

        // 標準関数
        $strlen = func_user_func_array('strlen');
        that($strlen('abc', null, 'dummy'))->is(3);

        // 可変引数
        $variadic = fn(...$v) => $v;
        $vcall = func_user_func_array($variadic);
        that($vcall('abc', null, 'dummy'))->is(['abc', null, 'dummy']);

        // 自前関数兼デフォルト引数
        $pascal_case = func_user_func_array(self::resolveFunction('pascal_case'));
        that($pascal_case('this_is_a_pen'))->is('ThisIsAPen');
        // 第2引数を与えても意味を為さない
        that($pascal_case('this_is_a_pen', '-'))->is('ThisIsAPen');
    }

    function test_func_wiring()
    {
        $closure = fn($a, $b, \Exception $c = null) => func_get_args();
        $new_closure = func_wiring($closure, [
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

    function test_function_alias()
    {
        require_once __DIR__ . '/files/function/function_alias.php';
        /** @noinspection PhpUndefinedFunctionInspection */
        {
            // シンプル：組み込み関数
            function_alias('strtoupper', 'strtoupper2');
            that(strtoupper2('aaa'))->is('AAA');
            // シンプル：ユーザー定義関数（グローバル）
            function_alias('_strtoupper', 'strtoupper3');
            that(strtoupper3('aaa'))->is('AAA');
            // シンプル：ユーザー定義関数（名前空間）
            function_alias('FA\\_strtoupper', 'strtoupper4');
            that(strtoupper4('aaa'))->is('AAA');

            // 参照渡し：組み込み関数
            function_alias('sort', 'sort2');
            $array = [3, 2, 11];
            that(sort2($array))->isTrue();
            that($array)->is([2, 3, 11]);
            that(sort2($array, SORT_STRING))->isTrue();
            that($array)->is([11, 2, 3]);
            // 参照渡し：ユーザー定義関数（グローバル）
            function_alias('_sort', 'sort3');
            $array = [3, 2, 11];
            that(sort3($array))->isTrue();
            that($array)->is([2, 3, 11]);
            that(sort3($array, SORT_STRING))->isTrue();
            that($array)->is([11, 2, 3]);
            // 参照渡し：ユーザー定義関数（名前空間）
            function_alias('FA\\_sort', 'sort4');
            $array = [3, 2, 11];
            that(sort4($array))->isTrue();
            that($array)->is([2, 3, 11]);
            that(sort4($array, SORT_STRING))->isTrue();
            that($array)->is([11, 2, 3]);

            // リファレンス返し
            function_alias('_ref', '_ref3');
            $vals = &_ref3();
            $vals[] = 'add';
            that(_ref3())->is(['add']);

            // デフォルト引数：組み込み関数
            function_alias('trim', 'trim2');
            that(trim2(' aXa '))->is('aXa');
            that(trim2('aXa', 'a'))->is('X');
            // デフォルト引数：ユーザー定義関数（グローバル）
            function_alias('_trim', 'trim3');
            that(trim3(' aXa '))->is('aXa');
            that(trim3('aXa', 'a'))->is('X');
            // デフォルト引数：ユーザー定義関数（名前空間）
            function_alias('FA\\_trim', 'trim4');
            that(trim4(' aXa '))->is('aXa');
            that(trim4('aXa', 'a'))->is('X');

            // 静的メソッド
            function_alias('\Concrete::staticMethod', 'staticMethod2');
            that(staticMethod2())->is('Concrete::staticMethod');

            // 名前空間への吐き出し：ユーザー定義関数（グローバル）
            function_alias('_trim', 'O\\trim3');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            that(\O\trim3(' aXa '))->is('aXa');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            that(\O\trim3('aXa', 'a'))->is('X');
            // 名前空間への吐き出し：ユーザー定義関数（名前空間）
            function_alias('FA\\_trim', 'O\\trim4');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            that(\O\trim4(' aXa '))->is('aXa');
            /** @noinspection PhpUndefinedNamespaceInspection */
            /** @noinspection PhpUndefinedFunctionInspection */
            that(\O\trim4('aXa', 'a'))->is('X');
        }

        // 例外
        that(self::resolveFunction('function_alias'))(function () { }, 'xx')->wasThrown('must not be object');
        that(self::resolveFunction('function_alias'))('x', 'xx')->wasThrown('does not exist');
        that(self::resolveFunction('function_alias'))([new \Concrete('u'), 'getName'], 'xx')->wasThrown('non-static method');
        that(self::resolveFunction('function_alias'))('implode', 'implode')->wasThrown('already declared');
    }

    function test_function_shorten()
    {
        require_once __DIR__ . '/files/function/function_shorten.php';
        that(function_shorten('FS\\hoge'))->is('hoge');
        that(function_shorten('strlen'))->is('strlen');
    }

    function test_is_bindable_closure()
    {
        function _global_nostatic_closure() { return fn() => get_class($this); }

        function _global_static_closure() { return static fn() => get_class($this); }

        $class = new class {
            public function _nostatic_nostatic_closure() { return fn() => get_class($this); }

            public function _nostatic_static_closure() { return static fn() => get_class($this); }

            public static function _static_nostatic_closure() { return fn() => get_class($this); }

            public static function _static_static_closure() { return static fn() => get_class($this); }
        };

        that(is_bindable_closure(_global_nostatic_closure()))->isTrue();
        that(is_bindable_closure(_global_static_closure()))->isFalse();
        that(is_bindable_closure($class->_nostatic_nostatic_closure()))->isTrue();
        that(is_bindable_closure($class->_nostatic_static_closure()))->isFalse();
        that(is_bindable_closure($class->_static_nostatic_closure()))->isTrue();
        that(is_bindable_closure($class->_static_static_closure()))->isFalse();

        // true のやつらは実際に bind してみる
        $dummy = new \stdClass();
        that(\Closure::bind(_global_nostatic_closure(), $dummy)())->is('stdClass');
        that(\Closure::bind($class->_nostatic_nostatic_closure(), $dummy)())->is('stdClass');
        that(\Closure::bind($class->_static_nostatic_closure(), $dummy)())->is('stdClass');
    }

    function test_is_callback()
    {
        that(is_callback('strtoupper'))->isFalse();
        that(is_callback('my_function_name'))->isFalse();

        that(is_callback(__METHOD__))->isTrue();
        that(is_callback([__CLASS__, __FUNCTION__]))->isTrue();
        that(is_callback([__CLASS__, __METHOD__]))->isTrue();
        that(is_callback([$this, __FUNCTION__]))->isTrue();
        that(is_callback([$this, __METHOD__]))->isTrue();
        that(is_callback([$this, __METHOD__, 'dummy']))->isFalse();

        that(is_callback(new class { }))->isFalse();
        that(is_callback(new class { function __invoke() { } }))->isTrue();
        that(is_callback(fn($v) => strtoupper($v)))->isTrue();
    }
}
