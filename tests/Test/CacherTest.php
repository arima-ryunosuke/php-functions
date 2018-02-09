<?php

namespace ryunosuke\Test;

use ryunosuke\Functions\Cacher;
use ryunosuke\Functions\FileCache;

class CacherTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_initialize()
    {
        $current = Cacher::initialize();
        Cacher::clear();

        Cacher::initialize(new FileCache(__DIR__ . '/../temporary'));
        Cacher::clear();

        Cacher::initialize($current);
    }
}
