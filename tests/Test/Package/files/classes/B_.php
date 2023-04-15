<?php

/** @noinspection PhpUndefinedClassInspection */

class B extends \ryunosuke\Test\Package\files\classes\B_
{
    function f()
    {
        $result = parent::f();
        array_pop($result);
        $result[] = 'this is exB';
        return $result;
    }
}
