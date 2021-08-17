<?php

namespace ryunosuke\Test\Package\Classobj;

class D1 extends C1
{
    function f()
    {
        return array_merge(parent::f(), ['this is D']);
    }
}
