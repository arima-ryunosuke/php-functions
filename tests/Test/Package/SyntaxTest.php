<?php

namespace ryunosuke\Test\Package;

use stdClass;

class SyntaxTest extends AbstractTestCase
{
    function test_evaluate()
    {
        $tmpdir = self::TMPDIR . getenv('TEST_TARGET');
        (rm_rf)($tmpdir, false);
        that((evaluate)('return $x * $x;', ['x' => 1]))->is(1);
        that((evaluate)('return $x * $x;', ['x' => 2]))->is(4);
        that((evaluate)('return $x * $x;', ['x' => 3]))->is(9);
        // 短すぎするのでキャッシュはされない
        that(glob("$tmpdir/*.php"))->count(0);

        that((evaluate)('
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
', ['x' => 3]))->isObject();
        // ある程度長ければキャッシュされる
        that(glob("$tmpdir/*.php"))->count(1);

        that([
            evaluate,
            '
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
'
        ])->throws(new \ParseError(<<<ERR
on line 14
ERR
        ));

        that([evaluate, 'syntax error'])->throws(new \ParseError(<<<ERR
>>> syntax error
ERR
        ));

        that([
            evaluate,
            <<<PHP
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
        ])->throws(new \ParseError(<<<ERR
// 01
>>> syntax error // 02
// 03
// 04
// 05
// 06
// 07
ERR
        ));

        that([
            evaluate,
            <<<PHP
// 07
// 08
// 09
// 10
// 11
>>> syntax error // 12
// 13
PHP
        ])->throws(new \ParseError(<<<ERR
>>> syntax error
ERR
        ));

        that([
            evaluate,
            <<<PHP
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
        ])->throws(new \ParseError(<<<ERR
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
        ));
    }

    function test_parse_php()
    {
        $code = 'a(123);';
        $tokens = (parse_php)($code, 2);
        that($tokens)->is([
            [T_OPEN_TAG, '<?php ', 1, 'T_OPEN_TAG'],
            [T_STRING, 'a', 1, 'T_STRING'],
            [null, '(', 0],
            [T_LNUMBER, '123', 1, 'T_LNUMBER'],
            [null, ')', 0],
            [null, ';', 0],
        ]);

        $code = 'function(...$args)use($usevar){if(false)return function(){};}';
        $tokens = (parse_php)($code, [
            'begin' => T_FUNCTION,
            'end'   => '{',
        ]);
        that(implode('', array_column($tokens, 1)))->is('function(...$args)use($usevar){');
        $tokens = (parse_php)($code, [
            'begin'  => '{',
            'end'    => '}',
            'offset' => count($tokens),
        ]);
        that(implode('', array_column($tokens, 1)))->is('{if(false)return function(){};}');

        $code = 'namespace hoge\\fuga\\piyo;class C {function m(){if(false)return function(){};}}';
        $tokens = (parse_php)($code, [
            'begin' => T_NAMESPACE,
            'end'   => ';',
        ]);
        that(implode('', array_column($tokens, 1)))->is('namespace hoge\fuga\piyo;');
        $tokens = (parse_php)($code, [
            'begin' => T_CLASS,
            'end'   => '}',
        ]);
        that(implode('', array_column($tokens, 1)))->is('class C {function m(){if(false)return function(){};}}');
    }

    function test_indent_php()
    {
        $phpcode = '
// this is line comment1
// this is line comment1
echo 123;
# this is line comment2
echo 123;
/* this is block comment1 */
echo 123;
/*
 * this is block comment2
 */
echo 123;
/** this is doccomment1 */
/**
 * this is doccomment2
 */
echo 123;
// this is multiline
$multiline = "
1
2
3
";

// empty line below and above

if (true) {
    echo 123; // this is trailing comment
    if (true) {
        /* this is starting comment */echo 123;
    }
}
';
        $phpcode = (indent_php)($phpcode, [
            'indent'    => 4,
            'trimempty' => false,
        ]);

        that($phpcode)->is('
    // this is line comment1
    // this is line comment1
    echo 123;
    # this is line comment2
    echo 123;
    /* this is block comment1 */
    echo 123;
    /*
     * this is block comment2
     */
    echo 123;
    /** this is doccomment1 */
    /**
     * this is doccomment2
     */
    echo 123;
    // this is multiline
    $multiline = "
1
2
3
";
    
    // empty line below and above
    
    if (true) {
        echo 123; // this is trailing comment
        if (true) {
            /* this is starting comment */echo 123;
        }
    }
    ');

        $phpcode = (indent_php)($phpcode, "\t\t");

        that($phpcode)->is('
		// this is line comment1
		// this is line comment1
		echo 123;
		# this is line comment2
		echo 123;
		/* this is block comment1 */
		echo 123;
		/*
		 * this is block comment2
		 */
		echo 123;
		/** this is doccomment1 */
		/**
		 * this is doccomment2
		 */
		echo 123;
		// this is multiline
		$multiline = "
1
2
3
";

		// empty line below and above

		if (true) {
		    echo 123; // this is trailing comment
		    if (true) {
		        /* this is starting comment */echo 123;
		    }
		}
		');

        $phpcode = (indent_php)($phpcode, [
            'indent'    => "",
            'trimempty' => false,
        ]);

        that($phpcode)->is('
// this is line comment1
// this is line comment1
echo 123;
# this is line comment2
echo 123;
/* this is block comment1 */
echo 123;
/*
 * this is block comment2
 */
echo 123;
/** this is doccomment1 */
/**
 * this is doccomment2
 */
echo 123;
// this is multiline
$multiline = "
1
2
3
";

// empty line below and above

if (true) {
    echo 123; // this is trailing comment
    if (true) {
        /* this is starting comment */echo 123;
    }
}
');
    }

    function test_indent_php_heredoc()
    {
        that((indent_php)('
$heredoc = <<<HERE
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
HERE;
', [
            'indent'  => '    ',
            'heredoc' => false,
        ]))->is('
    $heredoc = <<<HERE
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
HERE;
    ');
        $phpcode = '
$nowdoc = <<<\'HERE\'
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
HERE;
$heredoc1 = <<<HERE
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
    HERE;
$heredoc2 = <<<HERE
$colA
        {$colB},
        ${colB}

    HERE;
';

        $phpcode = (indent_php)($phpcode, [
            'indent'  => "    ",
            'heredoc' => true,
        ]);

        that($phpcode)->is('
    $nowdoc = <<<\'HERE\'
        SELECT
            $colA
            {$colB},
            ${colB}
        FROM
            table_name
        WHERE 1
            AND cd = ${substr($id, 2)}
            AND id = ${"id$i"}
    HERE;
    $heredoc1 = <<<HERE
        SELECT
            $colA
            {$colB},
            ${colB}
        FROM
            table_name
        WHERE 1
            AND cd = ${substr($id, 2)}
            AND id = ${"id$i"}
        HERE;
    $heredoc2 = <<<HERE
    $colA
            {$colB},
            ${colB}
    
        HERE;
    ');

        $phpcode = (indent_php)($phpcode, [
            'indent'  => "",
            'heredoc' => true,
        ]);

        that($phpcode)->is('
$nowdoc = <<<\'HERE\'
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
HERE;
$heredoc1 = <<<HERE
    SELECT
        $colA
        {$colB},
        ${colB}
    FROM
        table_name
    WHERE 1
        AND cd = ${substr($id, 2)}
        AND id = ${"id$i"}
    HERE;
$heredoc2 = <<<HERE
$colA
        {$colB},
        ${colB}

    HERE;
');
    }

    function test_highlight_php()
    {
        $phpcode = '<?php
// this is comment
$var1 = "this is var";
$var2 = "this is embed $var1";
$var3 = function () { return \ArrayObject::class; };
';
        that((highlight_php)($phpcode, ['context' => 'plain']))->is($phpcode);
        that((highlight_php)($phpcode, ['context' => 'cli']))->stringContains('[34;3m');
        that((highlight_php)($phpcode, ['context' => 'html']))->stringContains('<span style');
        that((highlight_php)($phpcode))->stringContains('function');

        that([highlight_php, $phpcode, ['context' => 'hoge']])->throws('is not supported');
    }

    function test_optional()
    {
        $o = new \Concrete('hoge');
        $o->hoge = 'hoge';
        $o->value = 'hoge';

        // method
        that((optional)($o)->getName())->isSame('hoge');
        // property
        that((optional)($o)->value)->isSame('hoge');
        // __isset
        that(isset((optional)($o)->hoge))->isSame(true);
        // __get
        that((optional)($o)->hoge)->isSame('hoge');
        // __call
        that((optional)($o)->hoge())->isSame('hoge');
        // __invoke
        that((optional)($o)())->isSame('Concrete::__invoke');
        // __toString
        that((string) (optional)($o))->isSame('hoge');
        // offsetExists
        that(empty((optional)($o)['hoge']))->isSame(false);
        // offsetGet
        that((optional)($o)['hoge'])->isSame('hoge');
        // iterator
        that((optional)($o))->isNotEmpty();

        $o = null;

        // method
        that((optional)($o)->getName())->isSame(null);
        // property
        that((optional)($o)->value)->isSame(null);
        // __isset
        that(isset((optional)($o)->hoge))->isSame(false);
        // __get
        that((optional)($o)->hoge)->isSame(null);
        // __call
        that((optional)($o)->hoge())->isSame(null);
        // __invoke
        that((optional)($o)())->isSame(null);
        // __toString
        that((string) (optional)($o))->isSame('');
        // offsetExists
        that(empty((optional)($o)['hoge']))->isSame(true);
        // offsetGet
        that((optional)($o)['hoge'])->isSame(null);
        // iterator
        that(iterator_to_array((optional)($o)))->isEmpty();

        // 型指定
        that((optional)(new \ArrayObject([1]))->count())->is(1);
        that((optional)(new \ArrayObject([1]), 'stdClass')->count())->isNull();
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
        that($chain($array)->mapP(['-'])())->is([-1, -2, -3, -4, -5]);
        that($chain($array)->mapP(['-' => 1])->mapP(['?:' => [5, 0]])())->is([0, 5, 5, 5, 5]);
        that($chain($array)->filterP(['>=' => 3])->mapP(['+' => 5])())->is([2 => 8, 9, 10]);

        // funcE
        $array = [1, 2, 3, 4, 5];
        that($chain($array)->mapE('*2')->filterE('>5')())->is([2 => 6, 8, 10]);
        that($chain($array)->mapE('$_ * $_')->vsprintf1('%d,%d,%d,%d,%d')())->is('1,4,9,16,25');

        // apply
        $string = 'a12345z';
        that($chain($string)->apply('ltrim', 'a')->apply('rtrim', 'z')->apply('number_format', 3)())->is('12,345.000');
        that((string) $chain($string))->is($string);

        // iterator
        $hash = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        that(iterator_to_array($chain($hash)))->is(['a' => 'A', 'b' => 'B', 'c' => 'C']);

        // string
        $string = 'hello';
        that($chain($string)->ucfirst->str_split->implode1(',')())->is('H,e,l,l,o');
        that((string) $chain($string))->is($string);

        // internal
        $list = '1,2,3,4,5';
        that($chain($list)->multiexplode1(',')->filter_keyP(['>=' => 2])->mapsE('*2')->values()())->is([6, 8, 10]);

        // exception
        that([[$chain(null), 'undefined_function']])->throws('is not defined');

        // use case
        $rows = [
            ['id' => 1, 'name' => 'hoge', 'sex' => 'F', 'age' => 17, 'salary' => 230000],
            ['id' => 3, 'name' => 'fuga', 'sex' => 'M', 'age' => 43, 'salary' => 480000],
            ['id' => 7, 'name' => 'piyo', 'sex' => 'M', 'age' => 21, 'salary' => 270000],
            ['id' => 9, 'name' => 'hage', 'sex' => 'F', 'age' => 30, 'salary' => 320000],
        ];

        // e.g. 男性の平均給料
        that($chain($rows)->whereP('sex', ['===' => 'M'])->column('salary')->mean()())->is(375000);
        that($chain()->whereP('sex', ['===' => 'M'])->column('salary')->mean()($rows))->is(375000);

        // e.g. 女性の平均年齢
        that($chain($rows)->whereE('sex', '=== "F"')->column('age')->mean()())->is(23.5);
        that($chain()->whereE('sex', '=== "F"')->column('age')->mean()($rows))->is(23.5);

        // e.g. 30歳以上の平均給料
        that($chain($rows)->whereP('age', ['>=' => 30])->column('salary')->mean()())->is(400000);
        that($chain()->whereP('age', ['>=' => 30])->column('salary')->mean()($rows))->is(400000);

        // e.g. 20～30歳の平均給料
        that($chain($rows)->whereP('age', ['>=' => 20])->whereE('age', '<= 30')->column('salary')->mean()())->is(295000);
        that($chain()->whereP('age', ['>=' => 20])->whereE('age', '<= 30')->column('salary')->mean()($rows))->is(295000);

        // e.g. 男性の最小年齢
        that($chain($rows)->whereP('sex', ['===' => 'M'])->column('age')->min()())->is(21);
        that($chain()->whereP('sex', ['===' => 'M'])->column('age')->min()($rows))->is(21);

        // e.g. 女性の最大給料
        that($chain($rows)->whereE('sex', '=== "F"')->column('salary')->max()())->is(320000);
        that($chain()->whereE('sex', '=== "F"')->column('salary')->max()($rows))->is(320000);

        // e.g. 30歳以上の id => name
        that($chain($rows)->whereP('age', ['>=' => 30])->column('name', 'id')())->is([
            3 => 'fuga',
            9 => 'hage',
        ]);
        that($chain()->whereP('age', ['>=' => 30])->column('name', 'id')($rows))->is([
            3 => 'fuga',
            9 => 'hage',
        ]);

        // 引数遅延モード
        $chainer = $chain()->sha1->md5()->substr(0, 3)->apply('ltrim', 'abcdef');
        that($chainer('hello'))->is('69');
        that($chainer('world'))->is('880');
        that($chainer('hello', 'world'))->is(['69', '880']);

        that([$chain()])->throws('nonempty stack and no parameter given');
        that([$chain('hoge'), null])->throws('empty stack and parameter given > 0');
    }

    function test_throws()
    {
        // ユースケースとしては例えば or throw がしたいことがある
        // 下記は出来ない
        /*
        @mkdir(__DIR__) or throw new \Exception('mkdir fail');
        */

        that(function () {
            @mkdir(__DIR__) or (throws)(new \Exception('mkdir fail'));
        })->throws(new \Exception('mkdir fail'));
    }

    function test_throw_if()
    {
        (throw_if)(false, new \Exception('message', 123));
        that([throw_if, true, new \Exception('message', 123)])->throws(new \Exception('message', 123));
        that([throw_if, true, \Exception::class, 'message', 123])->throws(new \Exception('message', 123));
    }

    function test_blank_if()
    {
        $stdclass = new stdClass();
        $countableF = new \ArrayObject([]);
        $stringableF = new \SplFileInfo('');
        $countableT = new \ArrayObject(['hoge']);
        $stringableT = new \SplFileInfo('hoge');

        that((blank_if)(null) ?? 'default')->isSame('default');
        that((blank_if)(false) ?? 'default')->isSame('default');
        that((blank_if)('') ?? 'default')->isSame('default');
        that((blank_if)([]) ?? 'default')->isSame('default');
        that((blank_if)($countableF) ?? 'default')->isSame('default');
        that((blank_if)($stringableF) ?? 'default')->isSame('default');
        that((blank_if)(0) ?? 'default')->isSame(0);
        that((blank_if)(0.0) ?? 'default')->isSame(0.0);
        that((blank_if)('0') ?? 'default')->isSame('0');
        that((blank_if)('X') ?? 'default')->isSame('X');
        that((blank_if)($stdclass) ?? 'default')->isSame($stdclass);
        that((blank_if)($countableT) ?? 'default')->isSame($countableT);
        that((blank_if)($stringableT) ?? 'default')->isSame($stringableT);

        that((blank_if)(null, 'default'))->isSame('default');
        that((blank_if)(false, 'default'))->isSame('default');
        that((blank_if)('', 'default'))->isSame('default');
        that((blank_if)([], 'default'))->isSame('default');
        that((blank_if)($countableF, 'default'))->isSame('default');
        that((blank_if)($stringableF, 'default'))->isSame('default');
        that((blank_if)(0, 'default'))->isSame(0);
        that((blank_if)(0.0, 'default'))->isSame(0.0);
        that((blank_if)('0', 'default'))->isSame('0');
        that((blank_if)('X', 'default'))->isSame('X');
        that((blank_if)($stdclass, 'default'))->isSame($stdclass);
        that((blank_if)($countableT, 'default'))->isSame($countableT);
        that((blank_if)($stringableT, 'default'))->isSame($stringableT);
    }

    function test_call_if()
    {
        $receiver = [];
        $callback = function ($name) use (&$receiver) {
            $receiver[$name] = ($receiver[$name] ?? 0) + 1;
            return $name;
        };

        that((call_if)(true, $callback, 'true'))->is('true');
        that((call_if)(false, $callback, 'false'))->is(null);

        that((call_if)(function () { return true; }, $callback, 'closure_true'))->is('closure_true');
        that((call_if)(function () { return false; }, $callback, 'closure_false'))->is(null);

        for ($i = 0; $i < 5; $i++) {
            (call_if)(-2, $callback, 'number:-2');
            (call_if)(-1, $callback, 'number:-1');
            (call_if)(0, $callback, 'number: 0');
            (call_if)(+1, $callback, 'number:+1');
            (call_if)(+2, $callback, 'number:+2');
        }

        that($receiver)->is([
            'true'         => 1,
            'closure_true' => 1,
            'number:-2'    => 3,
            'number:-1'    => 4,
            'number: 0'    => 5,
            'number:+1'    => 1,
            'number:+2'    => 1,
        ]);
    }

    function test_switchs()
    {
        $cases = [
            1 => 'value is 1',
            2 => function () { return 'value is 2'; },
        ];
        that((switchs)(1, $cases, 'undefined'))->is('value is 1');
        that((switchs)(2, $cases, 'undefined'))->is('value is 2');
        that((switchs)(3, $cases, 'undefined'))->is('undefined');
        that([switchs, 9, $cases])->throws('is not defined in');
    }

    function test_try_null()
    {
        $try = function ($x) {
            if ($x) {
                return $x;
            }
            throw new \Exception();
        };
        that((try_null)($try, 0))->is(null);
        that((try_null)($try, 1))->is(1);
        that((try_null)($try, 2))->is(2);
    }

    function test_try_return()
    {
        $try = function ($x) {
            if ($x) {
                return $x;
            }
            throw new \Exception();
        };
        that((try_return)($try, 0))->isInstanceOf(\Exception::class);
        that((try_return)($try, 1))->is(1);
        that((try_return)($try, 2))->is(2);
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

        that(function () use ($try) {
            (try_catch)($try, function ($ex) { throw new \Exception('hoge', 0, $ex); });
        })->throws(new \Exception('hoge'));

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

        that((try_catch)($try))->isInstanceOf(\RuntimeException::class);
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
        that((try_finally)($try1, $finally, 'hoge'))->is('HOGE');
        that($finally_count)->is(1);

        // 例外が投げられるが $finally は呼ばれている
        try {
            (try_finally)($try2, $finally);
        }
        catch (\Exception $ex) {
            // 握りつぶし
        };
        that($finally_count)->is(2);
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
        that($workingdir)->notFileExists();

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
        that($workingdir)->notFileExists();
    }
}
