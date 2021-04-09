<?php

namespace ryunosuke\Test\Package;

class AbstractTestCase extends \ryunosuke\Test\AbstractTestCase
{
    protected static $TMPDIR;

    protected function setUp(): void
    {
        parent::setUp();

        self::$TMPDIR = sys_get_temp_dir() . '/';

        (cachedir)(self::$TMPDIR . getenv('TEST_TARGET'));
        (cache)('dummy', function () { });
        (cache)(null, null);
    }
}
