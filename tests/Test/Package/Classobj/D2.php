<?php

namespace ryunosuke\Test\Package\Classobj;

class D2 extends C2
{
    function f()
    {
        return array_merge(parent::f(), ['this is D']);
    }
}
