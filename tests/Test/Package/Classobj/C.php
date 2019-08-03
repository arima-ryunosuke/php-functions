<?php

namespace ryunosuke\Test\Package\Classobj;

class C extends B
{
    function f()
    {
        return array_merge(parent::f(), ['this is C']);
    }

    function g(string $s, ?bool $b, \ArrayObject $e): ?array
    {
        return func_get_args();
    }
}
