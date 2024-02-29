<?php /** @noinspection PhpLanguageLevelInspection */

/**
 * object_storage 関数のためのクラススタブ
 */
class ObjectStorage implements \Countable, \ArrayAccess, \IteratorAggregate
{
    public function has(object|resource $objectOrResource): bool { }

    public function get(object|resource $objectOrResource, mixed $default = null) { }

    public function set(object|resource $objectOrResource, mixed $data): static { }

    public function clear() { }

    /** @param object|resource $offset */
    public function offsetExists($offset): bool { }

    /** @param object|resource $offset */
    public function offsetGet($offset) { }

    /** @param object|resource $offset */
    public function offsetSet($offset, mixed $value) { }

    /** @param object|resource $offset */
    public function offsetUnset($offset) { }

    public function count(): int { }

    /** @return \Generator{object|resource: mixed} */
    public function getIterator(): \Generator { }
}
