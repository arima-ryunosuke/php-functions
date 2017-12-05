<?php

namespace ryunosuke\Functions;

/**
 * 何もしない Null Object
 *
 * setter 系は明らかな誤りなので DomainException を投げる
 */
class NullObject implements \ArrayAccess, \IteratorAggregate
{
    public function __isset($name)
    {
        return false;
    }

    public function __get($name)
    {
        return null;
    }

    public function __set($name, $value)
    {
        throw new \DomainException('called NullObject#' . __FUNCTION__);
    }

    public function __unset($name)
    {
        throw new \DomainException('called NullObject#' . __FUNCTION__);
    }

    public function __call($name, $arguments)
    {
        return null;
    }

    public function __invoke()
    {
        return null;
    }

    public function __toString()
    {
        return '';
    }

    public function offsetExists($offset)
    {
        return false;
    }

    public function offsetGet($offset)
    {
        return null;
    }

    public function offsetSet($offset, $value)
    {
        throw new \DomainException('called NullObject#' . __FUNCTION__);
    }

    public function offsetUnset($offset)
    {
        throw new \DomainException('called NullObject#' . __FUNCTION__);
    }

    public function getIterator()
    {
        return new \ArrayIterator([]);
    }
}
