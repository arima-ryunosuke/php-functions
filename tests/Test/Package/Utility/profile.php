<?php

function A()
{
    $noop = null;
    return $noop;
}

function B()
{
    $noop = null;
    A();
}

function C()
{
    $noop = null;
    A();
    B();
}

function X()
{
    $noop = null;
    A();
    B();
    C();
}

X();
