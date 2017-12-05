<?php
namespace ryunosuke\Test\package;

class SyntaxTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_return()
    {
        $o = new \stdClass();
        $o->hoge = 123;
        $this->assertSame($o, returns($o));

        // ユースケースとしては例えば clone してチェーンしたいことがある
        // 下記は出来ない
        /*
        (clone $o)->hoge;
        */
        $this->assertEquals(123, returns(clone $o)->hoge);
    }

    function test_optional()
    {
        $o = new \Concrete('hoge');
        $o->hoge = 'hoge';
        $o->value = 'hoge';

        // method
        $this->assertSame('hoge', optional($o)->getName());
        // property
        $this->assertSame('hoge', optional($o)->value);
        // __isset
        $this->assertSame(true, isset(optional($o)->hoge));
        // __get
        $this->assertSame('hoge', optional($o)->hoge);
        // __call
        $this->assertSame('hoge', optional($o)->hoge());
        // __invoke
        $this->assertSame('Concrete::__invoke', call_user_func(optional($o)));
        // __toString
        $this->assertSame('hoge', (string) optional($o));
        // offsetExists
        $this->assertSame(false, empty(optional($o)['hoge']));
        // offsetGet
        $this->assertSame('hoge', optional($o)['hoge']);
        // iterator
        $this->assertNotEmpty(iterator_to_array(optional($o)));

        $o = null;

        // method
        $this->assertSame(null, optional($o)->getName());
        // property
        $this->assertSame(null, optional($o)->value);
        // __isset
        $this->assertSame(false, isset(optional($o)->hoge));
        // __get
        $this->assertSame(null, optional($o)->hoge);
        // __call
        $this->assertSame(null, optional($o)->hoge());
        // __invoke
        $this->assertSame(null, call_user_func(optional($o)));
        // __toString
        $this->assertSame('', (string) optional($o));
        // offsetExists
        $this->assertSame(true, empty(optional($o)['hoge']));
        // offsetGet
        $this->assertSame(null, optional($o)['hoge']);
        // iterator
        $this->assertEmpty(iterator_to_array(optional($o)));
    }

    function test_throws()
    {
        // ユースケースとしては例えば or throw がしたいことがある
        // 下記は出来ない
        /*
        @mkdir(__DIR__) or throw new \Exception('mkdir fail');
        */
        $this->assertException(new \Exception('mkdir fail'), function () {
            @mkdir(__DIR__) or throws(new \Exception('mkdir fail'));
        });
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
            try_catch($try, function ($ex) { throw new \Exception('hoge', 0, $ex); });
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

        $this->assertInstanceOf('\RuntimeException', try_catch($try));
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
        $this->assertFalse(file_exists($workingdir));

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
        $this->assertFalse(file_exists($workingdir));
    }
}
