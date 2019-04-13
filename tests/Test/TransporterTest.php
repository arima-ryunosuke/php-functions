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

        $contents = Transporter::exportNamespace('test\hoge');

        unlink(__DIR__ . '/../../src/Package/Dummy.php');

        $this->assertContains('namespace test\hoge;', $contents);
        $this->assertContains('const arrayize = ', $contents);
        $this->assertContains('function arrayize', $contents);
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

        $contents = Transporter::exportNamespace('test\hoge', false, [
            'callable_code',
        ]);

        $this->assertContains('callable_code', $contents);    // 自分自身が含まれている
        $this->assertContains('const TOKEN_NAME', $contents); // 依存している定数が含まれている
        $this->assertContains('reflect_callable', $contents); // 依存している関数が含まれている
    }

    function test_parseSymbol()
    {
        $refmethod = new \ReflectionMethod(Transporter::class, 'parseSymbol');
        $refmethod->setAccessible(true);

        $symbols = $refmethod->invoke(null, true);
        $this->assertEquals([
            'constant',
            'function',
            'phpblock',
        ], array_keys($symbols));
    }

    function test_exportVar()
    {
        $refmethod = new \ReflectionMethod(Transporter::class, 'exportVar');
        $refmethod->setAccessible(true);

        $this->assertEquals('123', $refmethod->invoke(null, 123));
        $this->assertEquals('"hoge"', $refmethod->invoke(null, 'hoge'));
        $this->assertEquals('["a"]', $refmethod->invoke(null, ['a']));
        $this->assertEquals('[
    ["a"],
]', $refmethod->invoke(null, [['a']]));
        $this->assertEquals('[
    "a" => "A",
]', $refmethod->invoke(null, ['a' => 'A']));
    }
}
