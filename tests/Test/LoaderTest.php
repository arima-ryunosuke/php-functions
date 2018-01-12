<?php
namespace ryunosuke\Test;

use ryunosuke\Functions\FileCache;
use ryunosuke\Functions\Loader;

class LoaderTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_exclude()
    {
        $NS = 'hoge\\fuga\\piyo';

        // 一時名前空間にエクスポートしておく
        Loader::exportToNamespace(sys_get_temp_dir(), $NS);

        // この時点では undefined
        $this->assertFalse(function_exists("$NS\\arrayize"));
        $this->assertFalse(function_exists("$NS\\arrayizestrcat"));

        // 一時名前空間からインポート
        Loader::importAsNamespace(sys_get_temp_dir(), ['arrayize']);

        // arrayize だけ undefined なはず
        $this->assertFalse(function_exists("$NS\\arrayize"));
        $this->assertTrue(function_exists("$NS\\strcat"));
    }
}
