<?php

/**
 * reflect_types 関数のためのクラススタブ
 *
 * @mixin \ReflectionType
 * @mixin \ReflectionNamedType
 * @mixin \ReflectionUnionType
 * @mixin \ReflectionIntersectionType
 */
class ReflectionAnyType implements \IteratorAggregate, \ArrayAccess, \Countable, \JsonSerializable
{
    public function offsetExists($offset) { }

    public function offsetGet($offset) { }

    public function offsetSet($offset, $value) { }

    public function offsetUnset($offset) { }

    public function count() { }

    public function getIterator() { }

    public function jsonSerialize() { }

    public function allows($type, $strict = false) { }
}
