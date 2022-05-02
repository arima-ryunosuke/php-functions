<?php

namespace ryunosuke\Test;

use ryunosuke\Functions\Transporter;

class TransporterTest extends \ryunosuke\Test\AbstractTestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_importAsGlobal()
    {
        if (getenv('TEST_TARGET') === 'global') {
            return;
        }

        // この時点では undefined
        that(function_exists("arrayize"))->isFalse();
        that(function_exists("strcat"))->isFalse();

        @Transporter::importAsGlobal(['arrayize']);

        // arrayize だけ undefined なはず
        that(function_exists("arrayize"))->isFalse();
        that(function_exists("strcat"))->isTrue();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_importAsGlobal_override()
    {
        if (getenv('TEST_TARGET') === 'global') {
            return;
        }

        // arraize を独自定義
        eval("function arrayize() { return 'this is arrayize'; }");

        @Transporter::importAsGlobal();

        // 独自定義が使われるはず
        that(\arrayize())->isEqual('this is arrayize');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_importAsNamespace()
    {
        if (getenv('TEST_TARGET') === 'namespace') {
            return;
        }

        // この時点では undefined
        that(function_exists("ryunosuke\\Functions\\arrayize"))->isFalse();
        that(function_exists("ryunosuke\\Functions\\strcat"))->isFalse();

        Transporter::importAsNamespace(['arrayize']);

        // arrayize だけ undefined なはず
        that(function_exists("ryunosuke\\Functions\\arrayize"))->isFalse();
        that(function_exists("ryunosuke\\Functions\\strcat"))->isTrue();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_importAsClass()
    {
        if (getenv('TEST_TARGET') === 'global') {
            return;
        }

        // この時点では undefined
        that(defined("ryunosuke\\Functions\\Package\\arrayize"))->isFalse();

        Transporter::importAsClass();

        // 定義されたはず
        that(defined("ryunosuke\\Functions\\Package\\arrayize"))->isTrue();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_exportAll()
    {
        if (getenv('TEST_TARGET') === 'namespace') {
            return;
        }

        $dir = (cachedir)() . '/' . __FUNCTION__;
        (rm_rf)($dir);
        (mkdir_p)($dir);

        // この時点では noexists
        that("$dir/global.php")->fileNotExists();
        that("$dir/namespace.php")->fileNotExists();
        that("$dir/package.php")->fileNotExists();

        Transporter::exportAll($dir);

        // 配置されてるはず
        that("$dir/global.php")->fileExists();
        that("$dir/namespace.php")->fileExists();
        that("$dir/package.php")->fileExists();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_exportNamespace()
    {
        if (getenv('TEST_TARGET') === 'namespace') {
            return;
        }

        // 内部テストのためにちょっと小細工する
        file_put_contents(__DIR__ . '/../../src/Package/Dummy.php', <<<DUMMY
        <?php
        namespace ryunosuke\Functions\Package;
        class DUMMY
        {
            const simple_array = [1, 2, 3];
        }
        DUMMY
        );

        unlink(__DIR__ . '/../../src/Package/Dummy.php');

        that(Transporter::exportNamespace('test\hoge'))
            ->stringContains('namespace test\hoge;')
            ->stringContains('define("test\\\\hoge\\\\arrayize"')
            ->stringContains('function arrayize');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_exportNamespace_func()
    {
        if (getenv('TEST_TARGET') === 'namespace') {
            return;
        }

        that(Transporter::exportNamespace('test\hoge', false, [
            'callable_code',
        ]))
            ->stringContains('callable_code')    // 自分自身が含まれている
            ->stringContains('TOKEN_NAME')       // 依存している定数が含まれている
            ->stringContains('reflect_callable') // 依存している関数が含まれている
        ;
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_exportNamespace_entry()
    {
        if (getenv('TEST_TARGET') === 'namespace') {
            return;
        }

        that(Transporter::exportNamespace('test\hoge', false, __DIR__ . '/Transporter/'))
            ->stringContains('parse_uri')    // file1 が含まれている
            ->stringContains('sql_format')   // file2 が含まれている
            ->stringContains('KEYWORDS')     // file2 に依存している定数が含まれている
            ->stringContains('preg_capture') // file1 に依存している関数が含まれている
            ->stringContains('throws')       // file2 に依存している関数が含まれている
        ;

        that(Transporter::exportNamespace('test\hoge', false, __DIR__ . '/Transporter/parse_uri.php'))
            ->stringContains('parse_uri')     // file1 が含まれている
            ->stringNotContains('sql_format') // file2 は含まれていない
            ->stringNotContains('KEYWORDS')   // file2 に依存している定数が含まれていない
            ->stringContains('preg_capture')  // file1 に依存している関数が含まれている
            ->stringNotContains('throws')     // file2 に依存している関数が含まれている
        ;
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_exportNamespace_text()
    {
        if (getenv('TEST_TARGET') === 'namespace') {
            return;
        }

        that(Transporter::exportNamespace('test\hoge', false, 'arrayize callable_code'))
            ->stringContains('arrayize')         // 指定したものが含まれている
            ->stringContains('callable_code')    // 指定したものが含まれている
            ->stringContains('TOKEN_NAME')       // 依存している定数が含まれている
            ->stringContains('reflect_callable') // 依存している関数が含まれている
        ;
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_exportClass()
    {
        if (getenv('TEST_TARGET') !== 'package') {
            return;
        }

        that(Transporter::exportClass('ns\Utils'))
            ->stringContains('const JP_ERA')                    // 定数が含まれている
            ->stringContains('const arrayize')                  // メソッド定数が含まれている
            ->stringContains('["\\\\ns\\\\Utils", "arrayize"]') // メソッド定数の値が含まれている
            ->stringContains('public static function arrayize') // メソッド定義が含まれている
        ;
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_exportClass_func()
    {
        if (getenv('TEST_TARGET') !== 'package') {
            return;
        }

        that(Transporter::exportClass('ns\Utils', ['callable_code']))
            ->stringContains('const TOKEN_NAME')                 // 依存している定数が含まれている
            ->stringContains('const parse_php')                  // 依存しているメソッド定数が含まれている
            ->stringContains('["\\\\ns\\\\Utils", "parse_php"]') // 依存しているメソッド定数の値が含まれている
            ->stringContains('public static function parse_php') // 依存しているメソッド定義が含まれている
        ;
    }

    function test_parseSymbol()
    {
        $refmethod = new \ReflectionMethod(Transporter::class, 'parseSymbol');
        $refmethod->setAccessible(true);

        that($refmethod->invoke(null, true))
            ->arrayHasKey('constant')
            ->arrayHasKey('function')
            ->arrayHasKey('phpblock');
    }

    function test_exportVar()
    {
        $refmethod = new \ReflectionMethod(Transporter::class, 'exportVar');
        $refmethod->setAccessible(true);

        that($refmethod->invoke(null, 123))->is('123');
        that($refmethod->invoke(null, 'hoge'))->is('"hoge"');
        that($refmethod->invoke(null, ['a']))->is('["a"]');
        that($refmethod->invoke(null, [['a']]))->is('[
    ["a"],
]');
        that($refmethod->invoke(null, ['a' => 'A']))->is('[
    "a" => "A",
]');
    }
}
