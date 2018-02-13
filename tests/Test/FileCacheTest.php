<?php

namespace ryunosuke\Test;

use ryunosuke\Functions\FileCache;

class FileCacheTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_all()
    {
        $cacher = new FileCache(__DIR__ . '/../temporary');
        $cacher->clear();

        // has
        $this->assertFalse($cacher->has('hoge@a1'));

        // default get
        $this->assertEquals('not found1', $cacher->get('hoge@a1', 'not found1'));
        $this->assertEquals('not found2', $cacher->get('hoge@a1', 'not found2'));

        // set and get
        $cacher->set('hoge@a1', 'this value1');
        $cacher->set('hoge@a2', 'this value2');
        $cacher->set('fuga@a1', 'that value1');
        $cacher->set('fuga@a2', 'that value2');
        $this->assertEquals('this value1', $cacher->get('hoge@a1'));
        $this->assertEquals('this value2', $cacher->get('hoge@a2'));
        $this->assertEquals('that value1', $cacher->get('fuga@a1'));
        $this->assertEquals('that value2', $cacher->get('fuga@a2'));

        $cacher = new FileCache(__DIR__ . '/../temporary');
        $this->assertEquals('this value1', $cacher->get('hoge@a1'));
        $this->assertEquals('this value2', $cacher->get('hoge@a2'));
        $this->assertEquals('that value1', $cacher->get('fuga@a1'));
        $this->assertEquals('that value2', $cacher->get('fuga@a2'));

        // has
        $this->assertTrue($cacher->has('hoge@a1'));
        $cacher->clear();
        $this->assertFalse($cacher->has('hoge@a1'));
    }

    function test_cachedir()
    {
        $cacher = new FileCache('/dev/null/:');
        $cacher->clear();
        $cacher->set('hoge@a', 'this value');
        unset($cacher);

        $this->assertFileNotExists('/dev/null/:');
    }
}
