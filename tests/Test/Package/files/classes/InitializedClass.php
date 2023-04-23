<?php

namespace ryunosuke\Test\Package\files\classes;

class InitializedClass
{
    public static $initialized = false;

    public static function __initialize()
    {
        self::$initialized = true;
    }
}
