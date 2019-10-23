<?php

namespace ryunosuke\Test\Package;

use stdClass;

class SyntaxTest extends AbstractTestCase
{
    function test_evaluate()
    {
        $tmpdir = self::TMPDIR . getenv('TEST_TARGET');
        (rm_rf)($tmpdir, false);
        $this->assertEquals(1, (evaluate)('return $x * $x;', ['x' => 1]));
        $this->assertEquals(4, (evaluate)('return $x * $x;', ['x' => 2]));
        $this->assertEquals(9, (evaluate)('return $x * $x;', ['x' => 3]));
        // 短すぎするのでキャッシュはされない
        $this->assertCount(0, glob("$tmpdir/*.php"));

        $this->assertIsObject((evaluate)('
return new class($x)
{
    private $var1;
    private $var2;

    public function method1($arg)
    {
        if ($arg) {
            return true;
        }
        return $arg;
    }

    public function method2($arg)
    {
        if (!$arg) {
            return true;
        }
        return $arg;
    }
};
', ['x' => 3]));
        // ある程度長ければキャッシュされる
        $this->assertCount(1, glob("$tmpdir/*.php"));

        $this->assertException(new \ParseError(<<<ERR
on line 14
ERR
        ), evaluate, '
return new class()
{
    private $var1;
    private $var2;

    public function method1($arg)
    {
        if ($arg) {
            return true;
        }
        return $arg;
    }
syntax error
    public function method2($arg)
    {
        if (!$arg) {
            return true;
        }
        return $arg;
    }
};
');

        $this->assertException(new \ParseError(<<<ERR
>>> syntax error
ERR
        ), evaluate, 'syntax error');

        $this->assertException(new \ParseError(<<<ERR
// 01
>>> syntax error // 02
// 03
// 04
// 05
// 06
// 07
ERR
        ), evaluate, <<<PHP
// 01
syntax error // 02
// 03
// 04
// 05
// 06
// 07
// 08
// 09
// 10
// 11
// 12
// 13
PHP
        );

        $this->assertException(new \ParseError(<<<ERR
// 07
// 08
// 09
// 10
// 11
>>> syntax error // 12
// 13
ERR
        ), evaluate, <<<PHP
// 01
// 02
// 03
// 04
// 05
// 06
// 07
// 08
// 09
// 10
// 11
syntax error // 12
// 13
PHP
        );

        $this->assertException(new \ParseError(<<<ERR
// 02
// 03
// 04
// 05
// 06
>>> syntax error // 07
// 08
// 09
// 10
// 11
// 12
ERR
        ), evaluate, <<<PHP
// 01
// 02
// 03
// 04
// 05
// 06
syntax error // 07
// 08
// 09
// 10
// 11
// 12
// 13
PHP
        );
    }

    function test_parse_php()
    {
        $code = 'a(123);';
        $tokens = (parse_php)($code, 2);
        $this->assertEquals([
            [T_OPEN_TAG, '<?php ', 1, 'T_OPEN_TAG'],
            [T_STRING, 'a', 1, 'T_STRING'],
            [null, '(', 0],
            [T_LNUMBER, '123', 1, 'T_LNUMBER'],
            [null, ')', 0],
            [null, ';', 0],
        ], $tokens);

        $code = 'function(...$args)use($usevar){if(false)return function(){};}';
        $tokens = (parse_php)($code, [
            'begin' => T_FUNCTION,
            'end'   => '{',
        ]);
        $this->assertEquals('function(...$args)use($usevar){', implode('', array_column($tokens, 1)));
        $tokens = (parse_php)($code, [
            'begin'  => '{',
            'end'    => '}',
            'offset' => count($tokens),
        ]);
        $this->assertEquals('{if(false)return function(){};}', implode('', array_column($tokens, 1)));

        $code = 'namespace hoge\\fuga\\piyo;class C {function m(){if(false)return function(){};}}';
        $tokens = (parse_php)($code, [
            'begin' => T_NAMESPACE,
            'end'   => ';',
        ]);
        $this->assertEquals('namespace hoge\fuga\piyo;', implode('', array_column($tokens, 1)));
        $tokens = (parse_php)($code, [
            'begin' => T_CLASS,
            'end'   => '}',
        ]);
        $this->assertEquals('class C {function m(){if(false)return function(){};}}', implode('', array_column($tokens, 1)));
    }

    function test_optional()
    {
        $o = new \Concrete('hoge');
        $o->hoge = 'hoge';
        $o->value = 'hoge';

        // method
        $this->assertSame('hoge', (optional)($o)->getName());
        // property
        $this->assertSame('hoge', (optional)($o)->value);
        // __isset
        $this->assertSame(true, isset((optional)($o)->hoge));
        // __get
        $this->assertSame('hoge', (optional)($o)->hoge);
        // __call
        $this->assertSame('hoge', (optional)($o)->hoge());
        // __invoke
        $this->assertSame('Concrete::__invoke', (optional)($o)());
        // __toString
        $this->assertSame('hoge', (string) (optional)($o));
        // offsetExists
        $this->assertSame(false, empty((optional)($o)['hoge']));
        // offsetGet
        $this->assertSame('hoge', (optional)($o)['hoge']);
        // iterator
        $this->assertNotEmpty(iterator_to_array((optional)($o)));

        $o = null;

        // method
        $this->assertSame(null, (optional)($o)->getName());
        // property
        $this->assertSame(null, (optional)($o)->value);
        // __isset
        $this->assertSame(false, isset((optional)($o)->hoge));
        // __get
        $this->assertSame(null, (optional)($o)->hoge);
        // __call
        $this->assertSame(null, (optional)($o)->hoge());
        // __invoke
        $this->assertSame(null, (optional)($o)());
        // __toString
        $this->assertSame('', (string) (optional)($o));
        // offsetExists
        $this->assertSame(true, empty((optional)($o)['hoge']));
        // offsetGet
        $this->assertSame(null, (optional)($o)['hoge']);
        // iterator
        $this->assertEmpty(iterator_to_array((optional)($o)));

        // 型指定
        $this->assertEquals(1, (optional)(new \ArrayObject([1]))->count());
        $this->assertNull((optional)(new \ArrayObject([1]), 'stdClass')->count());
    }

    function test_chain()
    {
        // (chain)呼び出しだとコード補完が効かないのでラップする
        $chain = function (...$v) {
            /** @var \ChainObject $co */
            $co = (chain)(...$v);
            return $co;
        };

        // funcO
        $array = [1, 2, 3, 4, 5];
        $this->assertEquals([-1, -2, -3, -4, -5], $chain($array)->mapP(['-'])());
        $this->assertEquals([0, 5, 5, 5, 5], $chain($array)->mapP(['-' => 1])->mapP(['?:' => [5, 0]])());
        $this->assertEquals([2 => 8, 9, 10], $chain($array)->filterP(['>=' => 3])->mapP(['+' => 5])());

        // funcE
        $array = [1, 2, 3, 4, 5];
        $this->assertEquals([2 => 6, 8, 10], $chain($array)->mapE('*2')->filterE('>5')());
        $this->assertEquals('1,4,9,16,25', $chain($array)->mapE('$_ * $_')->vsprintf1('%d,%d,%d,%d,%d')());

        // apply
        $string = 'a12345z';
        $this->assertEquals('12,345.000', $chain($string)->apply('ltrim', 'a')->apply('rtrim', 'z')->apply('number_format', 3)());
        $this->assertEquals($string, (string) $chain($string));

        // iterator
        $hash = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        $this->assertEquals(['a' => 'A', 'b' => 'B', 'c' => 'C'], iterator_to_array($chain($hash)));

        // string
        $string = 'hello';
        $this->assertEquals('H,e,l,l,o', $chain($string)->ucfirst->str_split->implode1(',')());
        $this->assertEquals($string, (string) $chain($string));

        // internal
        $list = '1,2,3,4,5';
        $this->assertEquals([6, 8, 10], $chain($list)->multiexplode1(',')->filter_keyP(['>=' => 2])->mapsE('*2')->values()());

        // exception
        $this->assertException('is not defined', [$chain(null), 'undefined_function']);

        // use case
        $rows = [
            ['id' => 1, 'name' => 'hoge', 'sex' => 'F', 'age' => 17, 'salary' => 230000],
            ['id' => 3, 'name' => 'fuga', 'sex' => 'M', 'age' => 43, 'salary' => 480000],
            ['id' => 7, 'name' => 'piyo', 'sex' => 'M', 'age' => 21, 'salary' => 270000],
            ['id' => 9, 'name' => 'hage', 'sex' => 'F', 'age' => 30, 'salary' => 320000],
        ];

        // e.g. 男性の平均給料
        $this->assertEquals(375000, $chain($rows)->whereP('sex', ['===' => 'M'])->column('salary')->mean()());
        $this->assertEquals(375000, $chain()->whereP('sex', ['===' => 'M'])->column('salary')->mean()($rows));

        // e.g. 女性の平均年齢
        $this->assertEquals(23.5, $chain($rows)->whereE('sex', '=== "F"')->column('age')->mean()());
        $this->assertEquals(23.5, $chain()->whereE('sex', '=== "F"')->column('age')->mean()($rows));

        // e.g. 30歳以上の平均給料
        $this->assertEquals(400000, $chain($rows)->whereP('age', ['>=' => 30])->column('salary')->mean()());
        $this->assertEquals(400000, $chain()->whereP('age', ['>=' => 30])->column('salary')->mean()($rows));

        // e.g. 20～30歳の平均給料
        $this->assertEquals(295000, $chain($rows)->whereP('age', ['>=' => 20])->whereE('age', '<= 30')->column('salary')->mean()());
        $this->assertEquals(295000, $chain()->whereP('age', ['>=' => 20])->whereE('age', '<= 30')->column('salary')->mean()($rows));

        // e.g. 男性の最小年齢
        $this->assertEquals(21, $chain($rows)->whereP('sex', ['===' => 'M'])->column('age')->min()());
        $this->assertEquals(21, $chain()->whereP('sex', ['===' => 'M'])->column('age')->min()($rows));

        // e.g. 女性の最大給料
        $this->assertEquals(320000, $chain($rows)->whereE('sex', '=== "F"')->column('salary')->max()());
        $this->assertEquals(320000, $chain()->whereE('sex', '=== "F"')->column('salary')->max()($rows));

        // e.g. 30歳以上の id => name
        $this->assertEquals([
            3 => 'fuga',
            9 => 'hage',
        ], $chain($rows)->whereP('age', ['>=' => 30])->column('name', 'id')());
        $this->assertEquals([
            3 => 'fuga',
            9 => 'hage',
        ], $chain()->whereP('age', ['>=' => 30])->column('name', 'id')($rows));

        // 引数遅延モード
        $chainer = $chain()->sha1->md5()->substr(0, 3)->apply('ltrim', 'abcdef');
        $this->assertEquals('69', $chainer('hello'));
        $this->assertEquals('880', $chainer('world'));
        $this->assertEquals(['69', '880'], $chainer('hello', 'world'));

        $this->assertException('nonempty stack and no parameter given', $chain());
        $this->assertException('empty stack and parameter given > 0', $chain('hoge'), null);
    }

    function test_throws()
    {
        // ユースケースとしては例えば or throw がしたいことがある
        // 下記は出来ない
        /*
        @mkdir(__DIR__) or throw new \Exception('mkdir fail');
        */
        $this->assertException(new \Exception('mkdir fail'), function () {
            @mkdir(__DIR__) or (throws)(new \Exception('mkdir fail'));
        });
    }

    function test_throw_if()
    {
        (throw_if)(false, new \Exception('message', 123));
        $this->assertException(new \Exception('message', 123), throw_if, true, new \Exception('message', 123));
        $this->assertException(new \Exception('message', 123), throw_if, true, \Exception::class, 'message', 123);
    }

    function test_blank_if()
    {
        $stdclass = new stdClass();
        $countableF = new \ArrayObject([]);
        $stringableF = new \SplFileInfo('');
        $countableT = new \ArrayObject(['hoge']);
        $stringableT = new \SplFileInfo('hoge');

        $this->assertSame('default', (blank_if)(null) ?? 'default');
        $this->assertSame('default', (blank_if)(false) ?? 'default');
        $this->assertSame('default', (blank_if)('') ?? 'default');
        $this->assertSame('default', (blank_if)([]) ?? 'default');
        $this->assertSame('default', (blank_if)($countableF) ?? 'default');
        $this->assertSame('default', (blank_if)($stringableF) ?? 'default');
        $this->assertSame(0, (blank_if)(0) ?? 'default');
        $this->assertSame(0.0, (blank_if)(0.0) ?? 'default');
        $this->assertSame('0', (blank_if)('0') ?? 'default');
        $this->assertSame('X', (blank_if)('X') ?? 'default');
        $this->assertSame($stdclass, (blank_if)($stdclass) ?? 'default');
        $this->assertSame($countableT, (blank_if)($countableT) ?? 'default');
        $this->assertSame($stringableT, (blank_if)($stringableT) ?? 'default');

        $this->assertSame('default', (blank_if)(null, 'default'));
        $this->assertSame('default', (blank_if)(false, 'default'));
        $this->assertSame('default', (blank_if)('', 'default'));
        $this->assertSame('default', (blank_if)([], 'default'));
        $this->assertSame('default', (blank_if)($countableF, 'default'));
        $this->assertSame('default', (blank_if)($stringableF, 'default'));
        $this->assertSame(0, (blank_if)(0, 'default'));
        $this->assertSame(0.0, (blank_if)(0.0, 'default'));
        $this->assertSame('0', (blank_if)('0', 'default'));
        $this->assertSame('X', (blank_if)('X', 'default'));
        $this->assertSame($stdclass, (blank_if)($stdclass, 'default'));
        $this->assertSame($countableT, (blank_if)($countableT, 'default'));
        $this->assertSame($stringableT, (blank_if)($stringableT, 'default'));
    }

    function test_call_if()
    {
        $receiver = [];
        $callback = function ($name) use (&$receiver) {
            $receiver[$name] = ($receiver[$name] ?? 0) + 1;
            return $name;
        };

        $this->assertEquals('true', (call_if)(true, $callback, 'true'));
        $this->assertEquals(null, (call_if)(false, $callback, 'false'));

        $this->assertEquals('closure_true', (call_if)(function () { return true; }, $callback, 'closure_true'));
        $this->assertEquals(null, (call_if)(function () { return false; }, $callback, 'closure_false'));

        for ($i = 0; $i < 5; $i++) {
            (call_if)(-2, $callback, 'number:-2');
            (call_if)(-1, $callback, 'number:-1');
            (call_if)(0, $callback, 'number: 0');
            (call_if)(+1, $callback, 'number:+1');
            (call_if)(+2, $callback, 'number:+2');
        }

        $this->assertEquals([
            'true'         => 1,
            'closure_true' => 1,
            'number:-2'    => 3,
            'number:-1'    => 4,
            'number: 0'    => 5,
            'number:+1'    => 1,
            'number:+2'    => 1,
        ], $receiver);
    }

    function test_switchs()
    {
        $cases = [
            1 => 'value is 1',
            2 => function () { return 'value is 2'; },
        ];
        $this->assertEquals('value is 1', (switchs)(1, $cases, 'undefined'));
        $this->assertEquals('value is 2', (switchs)(2, $cases, 'undefined'));
        $this->assertEquals('undefined', (switchs)(3, $cases, 'undefined'));
        $this->assertException('is not defined in', switchs, 9, $cases);
    }

    function test_try_null()
    {
        $try = function ($x) {
            if ($x) {
                return $x;
            }
            throw new \Exception();
        };
        $this->assertEquals(null, (try_null)($try, 0));
        $this->assertEquals(1, (try_null)($try, 1));
        $this->assertEquals(2, (try_null)($try, 2));
    }

    function test_try_catch()
    {
        $try = function () {
            throw new \RuntimeException();
        };

        // ユースケースとしては例えば単純にラップして再送したいことがある
        // 下記は出来ない…こともないが若干冗長
        /*
        try {
            $try();
        }
        catch (\Exception $ex) {
            throw new \Exception('hoge', 0, $ex);
        }
        */

        $this->assertException(new \Exception('hoge'), function () use ($try) {
            (try_catch)($try, function ($ex) { throw new \Exception('hoge', 0, $ex); });
        });

        // あるいは throw しないで単純に返り値として欲しいことがある
        // 下記は出来ない…こともないが若干冗長
        /*
        try {
            $try();
        }
        catch (\Exception $ex) {
            return $ex;
        }
        */

        $this->assertInstanceOf('\RuntimeException', (try_catch)($try));
    }

    function test_try_finally()
    {
        $try1 = function ($v) {
            return strtoupper($v);
        };
        $try2 = function () {
            throw new \RuntimeException();
        };
        $finally_count = 0;
        $finally = function () use (&$finally_count) {
            $finally_count++;
        };

        // ユースケースとしては例えば投げっぱなしだが finally だけはしたいことがある
        // 下記は出来ない…こともないが若干冗長
        /*
        try {
            $return = $try();
            $finally();
            return $return;
        }
        catch (\Exception $ex) {
            $finally();
            throw $ex;
        }
        php5.6 ならこうも書けるがやはり長い（特に縦に）
        try {
            return $try();
        }
        finally {
            $finally();
        }
        */

        // 引数は渡るし返り値は正しいし $finally も呼ばれている
        $this->assertEquals('HOGE', (try_finally)($try1, $finally, 'hoge'));
        $this->assertEquals(1, $finally_count);

        // 例外が投げられるが $finally は呼ばれている
        try {
            (try_finally)($try2, $finally);
        }
        catch (\Exception $ex) {
            // 握りつぶし
        };
        $this->assertEquals(2, $finally_count);
    }

    function test_try_catch_finally()
    {
        $workingdir = sys_get_temp_dir() . '/rf-working';
        (rm_rf)($workingdir);

        (try_catch_finally)(function () use ($workingdir) {
            // try 句でディレクトリを作る
            mkdir($workingdir, 0777, true);
        }, function () {
            // catch 句ではなにもしない
        }, function () use ($workingdir) {
            // finally 句でディレクトリを消す
            (rm_rf)($workingdir);
        });
        // finally が仕事をしてディレクトリが消えているはず
        $this->assertFalse(file_exists($workingdir));

        try {
            (try_catch_finally)(function () use ($workingdir) {
                // try 句でディレクトリを作って例外を投げる
                mkdir($workingdir, 0777, true);
                throw new \Exception();
            }, function ($ex) {
                // catch 句で投げ直す
                throw $ex;
            }, function () use ($workingdir) {
                // finally 句でディレクトリを消す
                (rm_rf)($workingdir);
            });
        }
        catch (\Exception $ex) {
            // dummy
        }
        // finally が仕事をしてディレクトリが消えているはず
        $this->assertFalse(file_exists($workingdir));
    }
}
