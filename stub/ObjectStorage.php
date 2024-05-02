<?php
// @formatter:off

/**
 * stub for object_storage
 *
 *
 *
 * @used-by \object_storage()
 * @used-by \ryunosuke\Functions\object_storage()
 * @used-by \ryunosuke\Functions\Package\object_storage()
 */
class ObjectStorage implements Countable, ArrayAccess, IteratorAggregate, Traversable
{


    public function has($objectOrResource): bool { }
    public function get($objectOrResource, $default = null): mixed { }
    public function set($objectOrResource, $data): self { }
    public function clear(): bool { }
    public function offsetExists($offset): bool { }
    public function offsetGet($offset): mixed { }
    public function offsetSet($offset, $value): void { }
    public function offsetUnset($offset): void { }
    public function count(): int { }
    public function getIterator(): Generator { }
}
