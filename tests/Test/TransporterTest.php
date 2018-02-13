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
        if (getenv('TEST_TARGET') === 'extern') {
            return;
        }

        // この時点では undefined
        $this->assertFalse(defined("ryunosuke\\Functions\\arrayize"));
        $this->assertFalse(defined("ryunosuke\\Functions\\strcat"));

        Transporter::importAsClass();

        // 定義されてるはず
        $this->assertTrue(defined("ryunosuke\\Functions\\arrayize"));
        $this->assertTrue(defined("ryunosuke\\Functions\\strcat"));
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_exportAll()
    {
        $dir = sys_get_temp_dir() . '/rft';
        call_user_func(rm_rf, $dir);
        call_user_func(mkdir_p, $dir . '/global');
        call_user_func(mkdir_p, $dir . '/namespace');

        // この時点では noexists
        $this->assertFileNotExists("$dir/global/constant.php");
        $this->assertFileNotExists("$dir/namespace/constant.php");
        $this->assertFileNotExists("$dir/constant.php");

        Transporter::exportAll($dir);

        // 配置されてるはず
        $this->assertFileExists("$dir/global/constant.php");
        $this->assertFileExists("$dir/namespace/constant.php");
        $this->assertFileExists("$dir/constant.php");
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_exportFunction()
    {
        $dir = sys_get_temp_dir() . '/rfe';
        call_user_func(rm_rf, $dir);
        call_user_func(mkdir_p, $dir);

        $files = Transporter::exportFunction('test\hoge', true, $dir);

        $this->assertContains('namespace test\hoge;', $files['constant']);
        $this->assertContains('namespace test\hoge;', $files['function']);
    }
}
