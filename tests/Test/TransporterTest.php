<?php

namespace ryunosuke\Test;

use ryunosuke\Functions\Transporter;

class TransporterTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_importAsGlobal()
    {
        if (getenv('TEST_TARGET') === 'global') {
            return self::assertTrue(true);
        }

        // この時点では undefined
        that(function_exists("arrayize"))->isFalse();
        that(function_exists("strcat"))->isFalse();

        Transporter::importAsGlobal(['arrayize']);

        // arrayize だけ undefined なはず
        that(function_exists("arrayize"))->isFalse();
        that(function_exists("strcat"))->isTrue();

        // arraize を独自定義
        eval("function arrayize() { return 'this is global arrayize'; }");

        Transporter::importAsGlobal();

        // 独自定義が使われるはず
        that(\arrayize())->isEqual('this is global arrayize');
    }

    function test_importAsNamespace()
    {
        // この時点では undefined
        that(function_exists("ryunosuke\\Functions\\arrayize"))->isFalse();
        that(function_exists("ryunosuke\\Functions\\strcat"))->isFalse();

        Transporter::importAsNamespace(['arrayize']);

        // arrayize だけ undefined なはず
        that(function_exists("ryunosuke\\Functions\\arrayize"))->isFalse();
        that(function_exists("ryunosuke\\Functions\\strcat"))->isTrue();

        // arraize を独自定義
        eval("namespace ryunosuke\\Functions;function arrayize() { return 'this is namespace arrayize'; }");

        Transporter::importAsNamespace();

        // 独自定義が使われるはず
        that(\ryunosuke\Functions\arrayize())->isEqual('this is namespace arrayize');
    }

    function test_exportGlobal()
    {
        that(Transporter::exportGlobal('arrayize sql_format'))
            ->stringContains('arrayize')       // 指定したものが含まれている
            ->stringContains('sql_format')     // 指定したものが含まれている
            ->stringContains('KEYWORDS')       // 依存している定数が含まれている
            ->stringNotContains('date_format') // 依存していない関数が含まれていない
            ->stringNotContains('JP_ERA')      // 依存していない定数が含まれていない
        ;
    }

    function test_exportNamespace()
    {
        that(Transporter::exportNamespace('test\hoge', 'sql_format'))
            ->stringContains('namespace test\hoge;')
            ->stringContains('sql_format')                // 指定したものが含まれている
            ->stringContains('test\\\\hoge\\\\KEYWORDS')  // 依存している定数が含まれている
            ->stringNotContains('date_format')            // 依存していない関数が含まれていない
            ->stringNotContains('test\\\\hoge\\\\JP_ERA') // 依存していない定数が含まれていない
        ;
    }

    function test_exportPackage()
    {
        that(Transporter::exportPackage(null, __DIR__ . '/Transporter/'))
            ->stringContains('parse_uri')      // file1 が含まれている
            ->stringContains('sql_format')     // file2 が含まれている
            ->stringContains('KEYWORDS')       // file2 に依存している定数が含まれている
            ->stringContains('preg_capture')   // file1 に依存している関数が含まれている
            ->stringContains('throws')         // file2 に依存している関数が含まれている
            ->stringNotContains('date_format') // 依存していない関数が含まれていない
            ->stringNotContains('JP_ERA')      // 依存していない定数が含まれていない
        ;
    }

    function test_parseSymbol()
    {
        that(Transporter::class)::parseSymbol(true)
            ->arrayHasKey('constant')
            ->arrayHasKey('function')
            ->arrayHasKey('callable')
            ->arrayHasKey('phpblock');
    }

    function test_replaceConstant()
    {
        that(Transporter::class)::replaceConstant('[ArrayObject::STD_PROP_LIST, Arrays::arrayize, Arrays::arrayize(1)]')->is('[ArrayObject::STD_PROP_LIST, arrayize, arrayize(1)]');
    }

    function test_exportVar()
    {
        that(Transporter::class)::exportVar(123)->is('123');
        that(Transporter::class)::exportVar('hoge')->is('"hoge"');
        that(Transporter::class)::exportVar(['a'])->is('["a"]');
        that(Transporter::class)::exportVar([['a']])->is('[
    ["a"],
]');
        that(Transporter::class)::exportVar(['a' => 'A'])->is('[
    "a" => "A",
]');
    }
}
