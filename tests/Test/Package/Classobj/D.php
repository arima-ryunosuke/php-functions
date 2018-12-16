<?php

namespace ryunosuke\Test\Package\Classobj;

class D extends C
{
    function f()
    {
        return array_merge(parent::f(), ['this is D']);
    }
}
