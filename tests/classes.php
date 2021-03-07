<?php

if (!class_exists(\ReflectionReference::class)) {
    /**
     * php7.4 の ReflectionReference polyfill
     *
     * それっぽく動くようにしてるのでパッケージ化してもいいけど、ほぼテストしていないので据え置き。
     */
    class ReflectionReference
    {
        /** @var array 今まで見つけたすべての参照 */
        private static $allrefs = [];

        /** @var string getId で得られる ID */
        private $id;

        public static function fromArrayElement(array $array, $key): ?self
        {
            // これだと float や stringable でもコケてしまうが元実装では正しいようだ（7.4 時点）
            if (!(is_int($key) || is_string($key))) {
                throw new \TypeError('Key must be array or string'); // array or string?
            }
            // 無い場合は ReflectionException を投げるようだ
            if (!array_key_exists($key, $array)) {
                throw new \ReflectionException('Array key not found');
            }

            // 値を保持しておいて異なる配列変数に値を入れてみる
            $backup = $array[$key];
            $referable = $array;
            $referable[$key] = new \stdClass();

            // なぜか $array[$key] も変わっているならそれは参照である
            if ($array[$key] === $referable[$key]) {
                // 参照は参照でも「新しい参照」と「既存の参照」は区別しなければならない（ID が同じになるため）
                $id = null;
                foreach (self::$allrefs as $oldid => [$oldarray, $oldkey]) {
                    // なぜか貯めておいたこれまでの参照まで変わっているなら「既存の参照」と判断できる
                    if ($oldarray[$oldkey] === $referable[$key]) {
                        $id = $oldid;
                        break;
                    }
                }
                // 見つからなかったら「新しい参照」なのでまるごと保存しておく
                if ($id === null) {
                    $id = count(self::$allrefs);
                    self::$allrefs[$id] = [$array, $key];
                }

                // 値を復元してインスタンスを返す
                $array[$key] = $backup;
                return new self($id);
            }
            return null;
        }

        private function __construct($id)
        {
            // 元実装では20文字のバイナリを返すようなのでできるだけ真似る
            $this->id = sha1((string) $id, true);
        }

        public function __clone()
        {
            // ドキュメントに記載があるわけではないが、リフレクションで調べたところ clone は禁止らしい
            throw new \Error("Trying to clone an uncloneable object of class ReflectionReference");
        }

        public function getId(): string
        {
            return $this->id;
        }
    }
}

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
