<?php

namespace ryunosuke\Test\Package\files\errorfunc;

class TraceTarget
{
    public static function run(...$args)
    {
        $self = new self($args);
        $self->initialize("before");
        return $self;
    }

    public function __construct($args)
    {
    }

    public function initialize($timing)
    {
    }
}
