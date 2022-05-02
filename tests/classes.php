<?php

abstract class AbstractConcrete
{
    private $privateField = 'AbstractConcrete';

    protected $proptectedField = 3.14;

    public static function staticMethod($a = null)
    {
        return __METHOD__;
    }

    public function instanceMethod($a = null)
    {
        return __METHOD__;
    }

    public function getPrivate()
    {
        return $this->privateField;
    }
}

/**
 * 汎用テスト用クラス
 */
class Concrete extends AbstractConcrete implements \ArrayAccess, IteratorAggregate
{
    private $privateField = 'Concrete';

    private const   PRIVATE_CONST   = null;
    protected const PROTECTED_CONST = null;
    public const    PUBLIC_CONST    = null;

    private static $staticFiled;

    public $value;

    private $name;

    protected function protectedMethod()
    {
        return __METHOD__;
    }

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

    public function __debugInfo()
    {
        return ['info' => 'this is __debugInfo'] + (array) $this;
    }

    public static function __set_state($an_array)
    {
        $that = new self($an_array['name']);
        $that->value = $an_array['value'];
        return $that;
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

    public function getPrivate()
    {
        return parent::getPrivate() . '/' . $this->privateField;
    }
}

class PrivateClass
{
    private function privateMethod() { }
}

class SerialObject implements \Serializable
{
    private $values;

    public function __construct($values = [])
    {
        $this->values = $values;
    }

    public function serialize()
    {
        return serialize($this->values);
    }

    public function unserialize($serialized)
    {
        $this->values = unserialize($serialized);
    }
}

class JsonObject implements \JsonSerializable
{
    private $values;

    public function __construct($values = [])
    {
        $this->values = $values;
    }

    public function jsonSerialize()
    {
        return $this->values;
    }
}

class Arrayable implements \ArrayAccess
{
    private $array;

    public function __construct($array = [])
    {
        $this->array = $array;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->array);
    }

    public function offsetGet($offset)
    {
        return $this->array[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->array[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }
}

class SerialMethod
{
    private $field = 123;

    public function __serialize(): array
    {
        return ['field' => $this->field, 'dummy' => null];
    }

    public function __unserialize(array $data): void
    {
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
    }
}

class SleepWakeupMethod
{
    private $dsn;
    private $pdo;

    public function __construct($dsn)
    {
        $this->dsn = $dsn;
    }

    public function __sleep()
    {
        return ['dsn'];
    }

    public function __wakeup()
    {
        $this->pdo = new \PDO($this->dsn);
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}

class BuiltIn implements \Countable
{
    public function count()
    {
        return (int) \ryunosuke\Functions\Package\Funchand::by_builtin($this, 'count');
    }
}

class Invoker
{
    public function m($v) { return $v * 2; }

    public static function S($v) { return $v * 3; }

    public function __invoke($v) { return $v * 4; }
}

class Nest1
{
    private $private = 1;

    private $private1 = 1;
}

class Nest2 extends Nest1
{
    private $private = 2;

    private $private2 = 2;
}

class Nest3 extends Nest2
{
    private $private = 3;

    private $private3 = 3;

    public function set($val)
    {
        $this->private = $val;
    }

    public function get()
    {
        return $this->private;
    }

    public static function __set_state($array)
    {
        $obj = new self;
        $obj->private = $array['private'];
        return $obj;
    }
}

trait Traitable
{
    public $publicField = __TRAIT__;

    public function traitMethod()
    {
        return __TRAIT__;
    }
}
