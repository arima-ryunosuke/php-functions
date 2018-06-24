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
        $this->assertFalse(function_exists("arrayize"));
        $this->assertFalse(function_exists("strcat"));

        @Transporter::importAsGlobal(['arrayize']);

        // arrayize だけ undefined なはず
        $this->assertFalse(function_exists("arrayize"));
        $this->assertTrue(function_exists("strcat"));
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
        $this->assertEquals('this is arrayize', \arrayize());
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
        $this->assertFalse(function_exists("ryunosuke\\Functions\\arrayize"));
        $this->assertFalse(function_exists("ryunosuke\\Functions\\strcat"));

        Transporter::importAsNamespace(['arrayize']);

        // arrayize だけ undefined なはず
        $this->assertFalse(function_exists("ryunosuke\\Functions\\arrayize"));
        $this->assertTrue(function_exists("ryunosuke\\Functions\\strcat"));
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
        $this->assertFalse(defined("ryunosuke\\Functions\\Package\\arrayize"));

        Transporter::importAsClass();

        // 定義されたはず
        $this->assertTrue(defined("ryunosuke\\Functions\\Package\\arrayize"));
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

        $dir = sys_get_temp_dir() . '/rft';
        (rm_rf)($dir);
        (mkdir_p)($dir);

        // この時点では noexists
        $this->assertFileNotExists("$dir/global.php");
        $this->assertFileNotExists("$dir/namespace.php");
        $this->assertFileNotExists("$dir/package.php");

        Transporter::exportAll($dir);

        // 配置されてるはず
        $this->assertFileExists("$dir/global.php");
        $this->assertFileExists("$dir/namespace.php");
        $this->assertFileExists("$dir/package.php");
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

        $dir = sys_get_temp_dir() . '/rfe';
        (rm_rf)($dir);
        (mkdir_p)($dir);

        $contents = Transporter::exportNamespace('test\hoge');

        $this->assertContains('namespace test\hoge;', $contents);
        $this->assertContains('const arrayize = ', $contents);
        $this->assertContains('function arrayize', $contents);
    }
}
