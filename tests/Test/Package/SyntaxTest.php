<?php

namespace ryunosuke\Test\Package;

use ryunosuke\Functions\Package\FileSystem;

class SyntaxTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_return()
    {
        $returns = returns;
        $o = new \stdClass();
        $o->hoge = 123;
        $this->assertSame($o, $returns($o));

        // ユースケースとしては例えば clone してチェーンしたいことがある
        // 下記は出来ない
        /*
        (clone $o)->hoge;
        */
        $this->assertEquals(123, $returns(clone $o)->hoge);
    }

    function test_optional()
    {
        $optional = optional;
        $o = new \Concrete('hoge');
        $o->hoge = 'hoge';
        $o->value = 'hoge';

        // method
        $this->assertSame('hoge', $optional($o)->getName());
        // property
        $this->assertSame('hoge', $optional($o)->value);
        // __isset
        $this->assertSame(true, isset($optional($o)->hoge));
        // __get
        $this->assertSame('hoge', $optional($o)->hoge);
        // __call
        $this->assertSame('hoge', $optional($o)->hoge());
        // __invoke
        $this->assertSame('Concrete::__invoke', call_user_func($optional($o)));
        // __toString
        $this->assertSame('hoge', (string) $optional($o));
        // offsetExists
        $this->assertSame(false, empty($optional($o)['hoge']));
        // offsetGet
        $this->assertSame('hoge', $optional($o)['hoge']);
        // iterator
        $this->assertNotEmpty(iterator_to_array($optional($o)));

        $o = null;

        // method
        $this->assertSame(null, $optional($o)->getName());
        // property
        $this->assertSame(null, $optional($o)->value);
        // __isset
        $this->assertSame(false, isset($optional($o)->hoge));
        // __get
        $this->assertSame(null, $optional($o)->hoge);
        // __call
        $this->assertSame(null, $optional($o)->hoge());
        // __invoke
        $this->assertSame(null, call_user_func($optional($o)));
        // __toString
        $this->assertSame('', (string) $optional($o));
        // offsetExists
        $this->assertSame(true, empty($optional($o)['hoge']));
        // offsetGet
        $this->assertSame(null, $optional($o)['hoge']);
        // iterator
        $this->assertEmpty(iterator_to_array($optional($o)));

        // 型指定
        $this->assertEquals(1, $optional(new \ArrayObject([1]))->count());
        $this->assertNull($optional(new \ArrayObject([1]), 'stdClass')->count());
    }

    function test_throws()
    {
        $throws = throws;
        // ユースケースとしては例えば or throw がしたいことがある
        // 下記は出来ない
        /*
        @mkdir(__DIR__) or throw new \Exception('mkdir fail');
        */
        $this->assertException(new \Exception('mkdir fail'), function () use ($throws) {
            @mkdir(__DIR__) or $throws(new \Exception('mkdir fail'));
        });
    }

    function test_ifelse()
    {
        $ifelse = ifelse;
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
        $this->assertEquals(13, $ifelse($minute, false, 59));
        $minute = false;
        $this->assertEquals(59, $ifelse($minute, false, 59));

        // 'hoge' === 'hoge' なので 'OK' を返す
        $this->assertEquals('OK', $ifelse('hoge', 'hoge', 'OK', 'NG'));
        // 'hoge' !== 'fuga' なので 'NG' を返す
        $this->assertEquals('NG', $ifelse('hoge', 'fuga', 'OK', 'NG'));
        // 第4引数を省略すると第1引数を表す
        $this->assertEquals('hoge', $ifelse('hoge', 'fuga', 'OK'));
        // callable を与えるとその結果で判定する
        $this->assertEquals('OK', $ifelse('hoge', 'is_string', 'OK'));
    }

    function test_try_catch()
    {
        $try_catch = try_catch;
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

        $this->assertException(new \Exception('hoge'), function () use ($try, $try_catch) {
            $try_catch($try, function ($ex) { throw new \Exception('hoge', 0, $ex); });
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

        $this->assertInstanceOf('\RuntimeException', $try_catch($try));
    }

    function test_try_catch_finally()
    {
        $try_catch_finally = try_catch_finally;
        $workingdir = sys_get_temp_dir() . '/rf-working';
        FileSystem::rm_rf($workingdir);

        $try_catch_finally(function () use ($workingdir) {
            // try 句でディレクトリを作る
            mkdir($workingdir, 0777, true);
        }, function () {
            // catch 句ではなにもしない
        }, function () use ($workingdir) {
            // finally 句でディレクトリを消す
            FileSystem::rm_rf($workingdir);
        });
        // finally が仕事をしてディレクトリが消えているはず
        $this->assertFalse(file_exists($workingdir));

        try {
            $try_catch_finally(function () use ($workingdir) {
                // try 句でディレクトリを作って例外を投げる
                mkdir($workingdir, 0777, true);
                throw new \Exception();
            }, function ($ex) {
                // catch 句で投げ直す
                throw $ex;
            }, function () use ($workingdir) {
                // finally 句でディレクトリを消す
                FileSystem::rm_rf($workingdir);
            });
        }
        catch (\Exception $ex) {
            // dummy
        }
        // finally が仕事をしてディレクトリが消えているはず
        $this->assertFalse(file_exists($workingdir));
    }
}
