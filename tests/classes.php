<?php

abstract class AbstractConcrete
{
    public static function staticMethod($a = null)
    {
        return __METHOD__;
    }

    public function instanceMethod($a = null)
    {
        return __METHOD__;
    }
}

/**
 * 汎用テスト用クラス
 */
class Concrete extends AbstractConcrete implements \ArrayAccess, IteratorAggregate
{
    public $value;

    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }

    public function __unset($name)
    {
        unset($this->$name);
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __invoke($a = null)
    {
        return __METHOD__;
    }

    public static function staticMethod($a = null)
    {
        return __METHOD__;
    }

    public function instanceMethod($a = null)
    {
        return __METHOD__;
    }

    public function getName($prefix = '', $upper = false)
    {
        $name = $this->name;
        if (strlen($prefix)) {
            $name = $prefix . $name;
        }
        if ($upper) {
            $name = strtoupper($name);
        }
        return $name;
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function __call($name, $arguments)
    {
        return $name;
    }

    public static function __callStatic($name, $arguments)
    {
        return $name;
    }

    public function getIterator()
    {
        return new ArrayIterator(get_object_vars($this));
    }

    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
}

// php 7 の ParseError を模倣したクラス
if (!class_exists('ParseError', false)) {
    class ParseError extends \Exception
    {

    }
}
