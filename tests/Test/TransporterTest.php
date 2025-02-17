<?php

namespace ryunosuke\Test;

use ryunosuke\Functions\Transporter;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class TransporterTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_exportGlobal()
    {
        that(Transporter::exportGlobal('arrayize sql_format'))
            ->stringContains('arrayize')       // 指定したものが含まれている
            ->stringContains('sql_format')     // 指定したものが含まれている
            ->stringNotContains('date_format') // 依存していない関数が含まれていない
        ;
    }

    function test_exportNamespace()
    {
        that(Transporter::exportNamespace('test\hoge', 'sql_format'))
            ->stringContains('namespace test\hoge;')
            ->stringContains('sql_format')                // 指定したものが含まれている
            ->stringNotContains('date_format')            // 依存していない関数が含まれていない
        ;
    }

    function test_exportDirectory()
    {
        that(Transporter::exportNamespace('', __DIR__ . '/Transporter/'))
            ->stringContains('uri_parse')      // file1 が含まれている
            ->stringContains('sql_format')     // file2 が含まれている
            ->stringContains('preg_capture')   // file1 に依存している関数が含まれている
            ->stringContains('unique_string')  // file2 に依存している関数が含まれている
            ->stringNotContains('date_format') // 依存していない関数が含まれていない
        ;
    }

    function test_exportClass()
    {
        that(Transporter::exportClass('name\\space\\ClassName', ['date_convert']))
            ->stringContains('public const JP_ERA')                    // 定数が含まれている
            ->stringContains('static function date_convert')           // 自身が含まれている
            ->stringContains('static function date_timestamp')         // 依存している関数が含まれている
            ->stringContains('static function array_find')             // 依存が依存している関数が含まれている
            ->stringContains('name\\space\\ClassName::date_timestamp') // self::で修飾されている
            ->stringNotContains('uri_parse')                           // 依存していない関数が含まれていない
        ;
    }

    function test_export_ignore_var_export3()
    {
        that(Transporter::exportGlobal('cacheobject'))
            ->stringNotContains('function var_export3') // var_export3 はでかいので cacheobject の依存に含めていない
        ;
        that(Transporter::exportGlobal('var_export3'))
            ->stringContains('function var_export3') // 明示指定すれば含まれる
        ;
    }

    function test_getAllConstant()
    {
        that(Transporter::class)::getAllConstant(true)
            ->arrayHasKey('IS_OWNSELF')
            ->arrayHasKey('SORT_STRICT');
    }

    function test_getAllFunction()
    {
        that(Transporter::class)::getAllFunction(true)
            ->eachArrayHasKey('directory')
            ->eachArrayHasKey('codeblock');
    }

    function test_detectDependent()
    {
        that(Transporter::class)::detectDependent(null)
            ->eachArrayHasKey('constant')
            ->eachArrayHasKey('function');

        that(Transporter::class)::detectDependent('SORT_STRICT, varcmp')->is([
            'constant' => [
                'SORT_STRICT' => true,
            ],
            'function' => [
                'varcmp' => true,
            ],
        ]);

        that(Transporter::class)::detectDependent('\\subpackage\\SORT_STRICT, \\subpackage\\varcmp')->is([
            'constant' => [
                'SORT_STRICT' => true,
            ],
            'function' => [
                'varcmp' => true,
            ],
        ]);
    }
}
