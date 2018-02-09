<?php

namespace ryunosuke\Test;

use ryunosuke\Functions\Transporter;

class TransporterTest extends \ryunosuke\Test\AbstractTestCase
{
    /**
     * @runInSeparateProcess
     */
    function test_exclude()
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
}
