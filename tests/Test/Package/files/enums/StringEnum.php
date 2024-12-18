<?php

namespace ryunosuke\Test\Package\files\enums;

if (version_compare(PHP_VERSION, '8.1') >= 0) {
    eval(<<<'PHP'
        namespace ryunosuke\Test\Package\files\enums;
        enum StringEnum: string
        {
            case CaseHoge = 'hoge';
            
            public static function __callStatic(string $name, mixed $arguments): mixed
            {
                return constant("self::$name");
            }
        }
        PHP);
}
else {
    /**
     * @method static self CaseHoge()
     */
    final class StringEnum extends \ryunosuke\polyfill\enum\StringBackedEnum
    {
        const CaseHoge = 'hoge';
    }
}
