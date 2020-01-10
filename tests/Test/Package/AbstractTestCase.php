<?php

namespace ryunosuke\Test\Package;

class AbstractTestCase extends \ryunosuke\Test\AbstractTestCase
{
    const TMPDIR = __DIR__ . '/../../temporary/';

    protected function setUp(): void
    {
        parent::setUp();

        (cachedir)(self::TMPDIR . getenv('TEST_TARGET'));
        (cache)('dummy', function () { });
        (cache)(null, null);
    }
}
