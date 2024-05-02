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
class ReflectTypes extends stdClass implements IteratorAggregate, ArrayAccess, Countable, JsonSerializable, Stringable, Traversable
{


    public function __toString(): string { }
    public function getIterator(): Traversable { }
    public function offsetExists($offset): bool { }
    public function offsetGet($offset): mixed { }
    public function offsetSet($offset, $value): void { }
    public function offsetUnset($offset): void { }
    public function count(): int { }
    public function jsonSerialize(): array { }
    public function getName(): string { }
    public function getTypes(): array { }
    public function allows($type, $strict = false): bool { }
}
