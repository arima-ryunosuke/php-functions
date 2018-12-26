<?php

namespace ryunosuke\Test\Package;

class SyntaxTest extends \ryunosuke\Test\AbstractTestCase
{
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

    function test_return()
    {
        $o = new \stdClass();
        $o->hoge = 123;
        $this->assertSame($o, (returns)($o));

        // ユースケースとしては例えば clone してチェーンしたいことがある
        // 下記は出来ない
        /*
        (clone $o)->hoge;
        */
        $this->assertEquals(123, (returns)(clone $o)->hoge);
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
        /** @var \ChainObject $co */

        // funcO
        $co = (chain)([1, 2, 3, 4, 5]);
        $this->assertEquals([-1, -2, -3, -4, -5], (clone $co)->mapP(['-'])());
        $this->assertEquals([0, 5, 5, 5, 5], (clone $co)->mapP(['-' => 1])->mapP(['?:' => [5, 0]])());
        $this->assertEquals([2 => 8, 9, 10], (clone $co)->filterP(['>=' => 3])->mapP(['+' => 5])());

        // funcE
        $co = (chain)([1, 2, 3, 4, 5]);
        $this->assertEquals([2 => 6, 8, 10], (clone $co)->mapE('*2')->filterE('>5')());
        $this->assertEquals('1,4,9,16,25', (clone $co)->mapE('$_ * $_')->vsprintf1('%d,%d,%d,%d,%d')());

        // apply
        $co = (chain)('a12345z');
        $this->assertEquals('12,345.000', $co->apply('ltrim', 'a')->apply('rtrim', 'z')->apply('number_format', 3)());
        $this->assertEquals('12,345.000', (string) $co);

        // iterator
        $co = (chain)(['a' => 'A', 'b' => 'B', 'c' => 'C']);
        $this->assertEquals(['a' => 'A', 'b' => 'B', 'c' => 'C'], iterator_to_array($co));

        // string
        $co = (chain)('hello');
        $this->assertEquals('H,e,l,l,o', $co->ucfirst->str_split->implode1(',')());
        $this->assertEquals('H,e,l,l,o', (string) $co);

        // exception
        $this->assertException('is not defined', [(chain)(null), 'undefined_function']);

        // use case
        $co = (chain)([
            ['id' => 1, 'name' => 'hoge', 'sex' => 'F', 'age' => 17, 'salary' => 230000],
            ['id' => 3, 'name' => 'fuga', 'sex' => 'M', 'age' => 43, 'salary' => 480000],
            ['id' => 7, 'name' => 'piyo', 'sex' => 'M', 'age' => 21, 'salary' => 270000],
            ['id' => 9, 'name' => 'hage', 'sex' => 'F', 'age' => 30, 'salary' => 320000],
        ]);

        // e.g. 男性の平均給料
        $this->assertEquals(375000, (clone $co)->whereP('sex', ['===' => 'M'])->column('salary')->mean()());

        // e.g. 女性の平均年齢
        $this->assertEquals(23.5, (clone $co)->whereE('sex', '=== "F"')->column('age')->mean()());

        // e.g. 30歳以上の平均給料
        $this->assertEquals(400000, (clone $co)->whereP('age', ['>=' => 30])->column('salary')->mean()());

        // e.g. 20～30歳の平均給料
        $this->assertEquals(295000, (clone $co)->whereP('age', ['>=' => 20])->whereE('age', '<= 30')->column('salary')->mean()());

        // e.g. 男性の最小年齢
        $this->assertEquals(21, (clone $co)->whereP('sex', ['===' => 'M'])->column('age')->min()());

        // e.g. 女性の最大給料
        $this->assertEquals(320000, (clone $co)->whereE('sex', '=== "F"')->column('salary')->max()());

        // e.g. 30歳以上の id => name
        $this->assertEquals([
            3 => 'fuga',
            9 => 'hage',
        ], (clone $co)->whereP('age', ['>=' => 30])->column('name', 'id')());
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

    function test_ifelse()
    {
        // ユースケースとしては例えば null と 0/false を区別したいことがある
        // 下記は出来ない
        /*
        // $minute が偽なら 59 としたいが $minute は false かも知れない
        $minute = $minute ?? 59;
        // これでもいいが、$minute が変数ではなく何かの戻り値だったら？ しかもそれが激重で何回も呼びたくない場合は一時変数を作らざるをえない
        $minute = $minute === null ? 59: $minute;
        // 三項演算子で行けるような気もするが今度は緩すぎるので 0 も 59 になってしまう
        $minute = $minute ?: 59;
        */

        // 上で挙げたユースケース
        $minute = 13;
        $this->assertEquals(13, (ifelse)($minute, false, 59));
        $minute = false;
        $this->assertEquals(59, (ifelse)($minute, false, 59));

        // 'hoge' === 'hoge' なので 'OK' を返す
        $this->assertEquals('OK', (ifelse)('hoge', 'hoge', 'OK', 'NG'));
        // 'hoge' !== 'fuga' なので 'NG' を返す
        $this->assertEquals('NG', (ifelse)('hoge', 'fuga', 'OK', 'NG'));
        // 第4引数を省略すると第1引数を表す
        $this->assertEquals('hoge', (ifelse)('hoge', 'fuga', 'OK'));
        // callable を与えるとその結果で判定する
        $this->assertEquals('OK', (ifelse)('hoge', 'is_string', 'OK'));
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
