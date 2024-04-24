<?php
// @formatter:off

/**
 * stub for reflect_types
 *
 * @mixin \ReflectionType
 * @mixin \ReflectionNamedType
 * @mixin \ReflectionUnionType
 * @mixin \ReflectionIntersectionType
 *
 * @used-by \reflect_types()
 * @used-by \ryunosuke\Functions\reflect_types()
 * @used-by \ryunosuke\Functions\Package\reflect_types()
 */
class ReflectTypes
{


    public function __toString() { }
    public function getIterator() { }
    public function offsetExists($offset) { }
    public function offsetGet($offset) { }
    public function offsetSet($offset, $value) { }
    public function offsetUnset($offset) { }
    public function count() { }
    public function jsonSerialize() { }
    public function getName() { }
    public function getTypes() { }
    public function allows($type, $strict = false) { }
}
