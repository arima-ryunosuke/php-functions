<?php

namespace ryunosuke\Test\Package\files\enums;

use ryunosuke\polyfill\enum\traits\Compatible;
use ryunosuke\polyfill\enum\traits\Initializable;

if (version_compare(PHP_VERSION, '8.1') >= 0) {
    eval(<<<'PHP'
        namespace ryunosuke\Test\Package\files\enums;
        enum IntEnum: int
        {
            case Case1 = 1;
            
            public static function __callStatic(string $name, mixed $arguments): mixed
            {
                return constant("self::$name");
            }
        }
        PHP);
}
else {
    /**
     * @method static self Case1()
     */
    final class IntEnum extends \ryunosuke\polyfill\enum\IntBackedEnum
    {
        use Compatible;
        use Initializable;

        const Case1 = 1;
    }
}
