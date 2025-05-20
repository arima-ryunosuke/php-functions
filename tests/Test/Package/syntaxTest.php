<?php

namespace ryunosuke\Test\Package;

use stdClass;
use function ryunosuke\Functions\Package\blank_coalesce;
use function ryunosuke\Functions\Package\blank_if;
use function ryunosuke\Functions\Package\cast;
use function ryunosuke\Functions\Package\instance_of;
use function ryunosuke\Functions\Package\rm_rf;
use function ryunosuke\Functions\Package\try_catch;
use function ryunosuke\Functions\Package\try_catch_finally;
use function ryunosuke\Functions\Package\try_close;
use function ryunosuke\Functions\Package\try_finally;
use function ryunosuke\Functions\Package\try_null;
use function ryunosuke\Functions\Package\try_return;

class syntaxTest extends AbstractTestCase
{
    function test_blank_coalesce()
    {
        $countableF = new \ArrayObject([]);
        $stringableF = new \SplFileInfo('');
        $countableT = new \ArrayObject(['hoge']);
        $stringableT = new \SplFileInfo('hoge');

        that(blank_coalesce('', null, false, [], $countableF, $stringableF))->isSame(null);
        that(blank_coalesce('', null, false, [], true))->isSame(true);
        that(blank_coalesce('', null, false, [], 0))->isSame(0);
        that(blank_coalesce('', null, false, [], 's'))->isSame('s');
        that(blank_coalesce('', null, false, [], [0]))->isSame([0]);
        that(blank_coalesce('', null, false, $countableF, $countableT))->isSame($countableT);
        that(blank_coalesce('', null, false, $stringableF, $stringableT))->isSame($stringableT);
    }

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

    function test_cast()
    {
        that(cast(0, 'bool'))->isSame(false);
        that(cast(1, 'bool'))->isSame(true);
        that(cast("0", 'bool'))->isSame(false);
        that(cast("1", 'bool'))->isSame(true);
        that(cast([], 'bool', 'errored'))->isSame('errored');

        that(cast(1, 'int'))->isSame(1);
        that(cast(1, 'string'))->isSame("1");
        that(cast(1, 'int|string'))->isSame(1);
        that(cast("1", 'int|string'))->isSame("1");
        that(cast([], 'int|string', 'errored'))->isSame('errored');

        that(cast([], 'array|int'))->isSame([]);
        that(cast(1, 'array|int'))->isSame(1);
        that(cast("s", 'array|int', 'errored'))->isSame('errored');

        that(cast([], 'iterable'))->isSame([]);
        that(cast($ao = new \ArrayObject(), 'iterable'))->isSame($ao);
        that(cast('hoge', 'iterable', 'errored'))->isSame('errored');

        that(cast("s", 'Stringable'))->isSame("s");
        that(cast($ex = new \Exception(), 'Stringable'))->isSame($ex);
        that(cast([], 'Stringable', 'errored'))->isSame('errored');

        that(cast($ao = new \ArrayObject(), 'ArrayAccess&\\Countable'))->isSame($ao);
        that(cast([], 'array|(ArrayAccess&Countable)'))->isSame([]);
        that(cast([], 'ArrayAccess&Countable', 'errored'))->isSame('errored');

        that(self::resolveFunction('cast'))(null, 'invalid $type')->wasThrown('illegal type');
        that(self::resolveFunction('cast'))("hoge", 'iterable&countable')->wasThrown('must be of type');
        that(self::resolveFunction('cast'))("hoge", 'int')->wasThrown('must be of type');
    }

    function test_instance_of()
    {
        $ex = new \RuntimeException();
        that(instance_of($ex, \LogicException::class))->isSame(null);
        that(instance_of($ex, \Throwable::class))->isSame($ex);
        that(instance_of($ex, \Exception::class))->isSame($ex);
        that(instance_of($ex, \RuntimeException::class))->isSame($ex);
        that(instance_of($ex, new \RuntimeException()))->isSame($ex);

        // スカラー系
        that(instance_of(null, stdClass::class))->isSame(null);
        that(instance_of(true, stdClass::class))->isSame(null);
        that(instance_of(0, stdClass::class))->isSame(null);
        that(instance_of('string', stdClass::class))->isSame(null);
        that(instance_of([], stdClass::class))->isSame(null);
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
        $workingdir = self::$TMPDIR . '/rf-working';
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
        catch (\Exception) {
            // dummy
        }
        // finally が仕事をしてディレクトリが消えているはず
        that($workingdir)->fileNotExists();
    }

    function test_try_close()
    {
        // 通常
        that(try_close(function ($r1, $r2) {
            that($r1)->isResource();
            that($r2)->isResource();
            return [$r1, $r2];
        }, $r1 = tmpfile(), $r2 = tmpfile()))->isSame([$r1, $r2]);
        that(gettype($r1))->contains('closed');
        that(gettype($r2))->contains('closed');

        // リソースだけど stream じゃない（これは php8.0 で実行するとコケる）
        that(try_close(function ($r) {
            return $r;
        }, $r = curl_init()))->isSame($r);
        that(gettype($r1))->contains('closed');
        that(gettype($r2))->contains('closed');

        // 配列
        $actual = try_close(function ($r1, $r2, $r3, $r4) {
            that($r1)->isResource();
            that($r2)->isResource();
            that($r3)->isResource();
            that($r4)->isResource();
            return [
                basename(stream_get_meta_data($r1)['uri']),
                basename(stream_get_meta_data($r2)['uri']),
                basename(stream_get_meta_data($r3)['uri']),
                basename(stream_get_meta_data($r4)['uri']),
            ];
        },
            [tempnam(sys_get_temp_dir(), 't1'), 'w'],
            [
                tempnam(sys_get_temp_dir(), 't2') => 'w',
                tempnam(sys_get_temp_dir(), 't3') => 'w',
            ],
            [tempnam(sys_get_temp_dir(), 't4'), 'w'],
        );
        that($actual[0])->stringStartsWith('t1');
        that($actual[1])->stringStartsWith('t2');
        that($actual[2])->stringStartsWith('t3');
        that($actual[3])->stringStartsWith('t4');

        // 例外
        that(self::resolveFunction('try_close'))(function ($r1, $r2) {
            throw new \RuntimeException('failed try');
        }, $r1 = tmpfile(), $r2 = tmpfile())->wasThrown('failed try');
        that(gettype($r1))->contains('closed');
        that(gettype($r2))->contains('closed');

        $r = new class() {
            static $closed;
            public $name;

            function clone($name)
            {
                self::$closed = [];
                $that = clone $this;
                $that->name = $name;
                return $that;
            }

            function free()
            {
                self::$closed[] = $this->name;
                if ($this->name === 'r3') {
                    throw new \RuntimeException('failed close');
                }
            }

            protected function close()
            {
                throw new \DomainException('never called');
            }
        };

        // 逆順で close
        that(try_close(function ($r1, $r2) {
            that($r1)->isObject();
            that($r2)->isObject();
            return [$r1, $r2];
        }, $r1 = $r->clone('r1'), $r2 = $r->clone('r2')))->isSame([$r1, $r2]);
        that($r::$closed)->isSame(['r2', 'r1']);

        // close で例外
        that(self::resolveFunction('try_close'))(function ($r1, $r2) {
            throw new \RuntimeException('failed try');
        }, $r->clone('r3'), $r->clone('r4'))->wasThrown('failed');
        that($r::$closed)->isSame(['r4', 'r3']);
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
        catch (\Exception) {
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
