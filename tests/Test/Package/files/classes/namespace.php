<?php

namespace ryunosuke\Functions\Package;

class Caller
{
    function arrayize(...$args)
    {
        return arrayize(IS_OWNSELF, $args);
    }
}
