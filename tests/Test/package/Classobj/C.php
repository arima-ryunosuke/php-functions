<?php
namespace ryunosuke\Test\package\Classobj;

class C extends B
{
    function f()
    {
        return array_merge(parent::f(), ['this is C']);
    }
}
