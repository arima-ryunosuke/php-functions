<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\cache;
use function ryunosuke\Functions\Package\function_configure;

class AbstractTestCase extends \ryunosuke\Test\AbstractTestCase
{
    protected static $TMPDIR;

    protected function setUp(): void
    {
        parent::setUp();

        self::$TMPDIR = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'rfunc';

        function_configure(['cachedir' => self::$TMPDIR]);
        cache('dummy', function () { });
        cache(null, null);
    }

    /**
     * @template T
     * @param callable $function
     * @return T
     */
    static function resolveFunction($function): callable
    {
        //return $function(...);
        if (function_exists("ryunosuke\\Functions\\Package\\$function")) {
            return "ryunosuke\\Functions\\Package\\$function";
        }
    }
}
