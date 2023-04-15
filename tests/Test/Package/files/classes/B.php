<?php

namespace ryunosuke\Test\Package\files\classes;

class B extends A
{
    function f()
    {
        return array_merge(parent::f(), ['this is B']);
    }
}
