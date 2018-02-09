<?php

namespace ryunosuke\Test\Package\Classobj;

class B extends A
{
    function f()
    {
        return array_merge(parent::f(), ['this is B']);
    }
}
