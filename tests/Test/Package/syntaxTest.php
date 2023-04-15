<?php

namespace ryunosuke\Test\Package;

use stdClass;
use function ryunosuke\Functions\Package\blank_if;
use function ryunosuke\Functions\Package\call_if;
use function ryunosuke\Functions\Package\rm_rf;
use function ryunosuke\Functions\Package\switchs;
use function ryunosuke\Functions\Package\throw_if;
use function ryunosuke\Functions\Package\throws;
use function ryunosuke\Functions\Package\try_catch;
use function ryunosuke\Functions\Package\try_catch_finally;
use function ryunosuke\Functions\Package\try_finally;
use function ryunosuke\Functions\Package\try_null;
use function ryunosuke\Functions\Package\try_return;

class syntaxTest extends AbstractTestCase
{
    function test_blank_if()
    {
        $stdclass = new stdClass();
        $countableF = new \ArrayObject([]);
        $stringableF = new \SplFileInfo('');
        $countableT = new \ArrayObject(['hoge']);
        $stringableT = new \SplFileInfo('hoge');

        that(blank_if(null) ?? 'default')->isSame('default');
        that(blank_if(false) ?? 'default')->isSame('default');
        that(blank_if('') ?? 'default')->isSame('default');
        that(blank_if([]) ?? 'default')->isSame('default');
        that(blank_if($countableF) ?? 'default')->isSame('default');
        that(blank_if($stringableF) ?? 'default')->isSame('default');
        that(blank_if(0) ?? 'default')->isSame(0);
        that(blank_if(0.0) ?? 'default')->isSame(0.0);
        that(blank_if('0') ?? 'default')->isSame('0');
        that(blank_if('X') ?? 'default')->isSame('X');
        that(blank_if($stdclass) ?? 'default')->isSame($stdclass);
        that(blank_if($countableT) ?? 'default')->isSame($countableT);
        that(blank_if($stringableT) ?? 'default')->isSame($stringableT);

        that(blank_if(null, 'default'))->isSame('default');
        that(blank_if(false, 'default'))->isSame('default');
        that(blank_if('', 'default'))->isSame('default');
        that(blank_if([], 'default'))->isSame('default');
        that(blank_if($countableF, 'default'))->isSame('default');
        that(blank_if($stringableF, 'default'))->isSame('default');
        that(blank_if(0, 'default'))->isSame(0);
        that(blank_if(0.0, 'default'))->isSame(0.0);
        that(blank_if('0', 'default'))->isSame('0');
        that(blank_if('X', 'default'))->isSame('X');
        that(blank_if($stdclass, 'default'))->isSame($stdclass);
        that(blank_if($countableT, 'default'))->isSame($countableT);
        that(blank_if($stringableT, 'default'))->isSame($stringableT);
    }

    function test_call_if()
    {
        $receiver = [];
        $callback = function ($name) use (&$receiver) {
            $receiver[$name] = ($receiver[$name] ?? 0) + 1;
            return $name;
        };

        that(call_if(true, $callback, 'true'))->is('true');
        that(call_if(false, $callback, 'false'))->is(null);

        that(call_if(fn() => true, $callback, 'closure_true'))->is('closure_true');
        that(call_if(fn() => false, $callback, 'closure_false'))->is(null);

        for ($i = 0; $i < 5; $i++) {
            call_if(-2, $callback, 'number:-2');
            call_if(-1, $callback, 'number:-1');
            call_if(0, $callback, 'number: 0');
            call_if(+1, $callback, 'number:+1');
            call_if(+2, $callback, 'number:+2');
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
            2 => fn() => 'value is 2',
        ];
        that(switchs(1, $cases, 'undefined'))->is('value is 1');
        that(switchs(2, $cases, 'undefined'))->is('value is 2');
        that(switchs(3, $cases, 'undefined'))->is('undefined');
        that(self::resolveFunction('switchs'))(9, $cases)->wasThrown('is not defined in');
    }

    function test_throw_if()
    {
        throw_if(false, new \Exception('message', 123));
        that(self::resolveFunction('throw_if'))(true, new \Exception('message', 123))->wasThrown(new \Exception('message', 123));
        that(self::resolveFunction('throw_if'))(true, \Exception::class, 'message', 123)->wasThrown(new \Exception('message', 123));
    }

    function test_throws()
    {
        // ユースケースとしては例えば or throw がしたいことがある
        // 下記は出来ない
        /*
        @mkdir(__DIR__) or throw new \Exception('mkdir fail');
        */

        that(function () {
            @mkdir(__DIR__) or throws(new \Exception('mkdir fail'));
        })()->wasThrown(new \Exception('mkdir fail'));
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
            try_catch($try, function ($ex) { throw new \Exception('hoge', 0, $ex); });
        })()->wasThrown(new \Exception('hoge'));

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

        that(try_catch($try))->isInstanceOf(\RuntimeException::class);
    }

    function test_try_catch_finally()
    {
        $workingdir = sys_get_temp_dir() . '/rf-working';
        rm_rf($workingdir);

        try_catch_finally(function () use ($workingdir) {
            // try 句でディレクトリを作る
            mkdir($workingdir, 0777, true);
        }, function () {
            // catch 句ではなにもしない
        }, function () use ($workingdir) {
            // finally 句でディレクトリを消す
            rm_rf($workingdir);
        });
        // finally が仕事をしてディレクトリが消えているはず
        that($workingdir)->fileNotExists();

        try {
            try_catch_finally(function () use ($workingdir) {
                // try 句でディレクトリを作って例外を投げる
                mkdir($workingdir, 0777, true);
                throw new \Exception();
            }, function ($ex) {
                // catch 句で投げ直す
                throw $ex;
            }, function () use ($workingdir) {
                // finally 句でディレクトリを消す
                rm_rf($workingdir);
            });
        }
        catch (\Exception $ex) {
            // dummy
        }
        // finally が仕事をしてディレクトリが消えているはず
        that($workingdir)->fileNotExists();
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
        that(try_finally($try1, $finally, 'hoge'))->is('HOGE');
        that($finally_count)->is(1);

        // 例外が投げられるが $finally は呼ばれている
        try {
            try_finally($try2, $finally);
        }
        catch (\Exception $ex) {
            // 握りつぶし
        }
        that($finally_count)->is(2);
    }

    function test_try_null()
    {
        $try = function ($x) {
            if ($x) {
                return $x;
            }
            throw new \Exception();
        };
        that(try_null($try, 0))->is(null);
        that(try_null($try, 1))->is(1);
        that(try_null($try, 2))->is(2);
    }

    function test_try_return()
    {
        $try = function ($x) {
            if ($x) {
                return $x;
            }
            throw new \Exception();
        };
        that(try_return($try, 0))->isInstanceOf(\Exception::class);
        that(try_return($try, 1))->is(1);
        that(try_return($try, 2))->is(2);
    }
}
