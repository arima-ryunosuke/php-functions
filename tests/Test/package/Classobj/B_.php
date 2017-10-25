<?php

/** @noinspection PhpUndefinedClassInspection */
class B extends \ryunosuke\Test\package\Classobj\B_
{
    function f()
    {
        $result = parent::f();
        array_pop($result);
        $result[] = 'this is exB';
        return $result;
    }
}
