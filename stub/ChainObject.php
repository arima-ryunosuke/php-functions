<?php

/**
 * chain 関数のためのクラススタブ
 */
class ChainObject implements \Countable, \ArrayAccess, \IteratorAggregate, \JsonSerializable
{
    // {annotation}
    use ChainObject0;
    use ChainObject1;
    use ChainObject2;
    use ChainObject3;
    use ChainObject4;
    use ChainObject5;
    use ChainObject6;
    use ChainObject7;
    use ChainObject8;
    use ChainObject9;
    // {/annotation}

    public function __invoke(): mixed { }

    public function __toString(): string { return ''; }

    public function __get($name): self { return $this; }

    public function __call($name, $arguments): self { return $this; }

    public function apply($callback, ...$args): self { return $this; }

    public function getIterator(): \Traversable { return $this; }

    public function offsetExists($offset): bool { }

    public function offsetGet($offset): mixed { }

    public function offsetSet($offset, $value): void { }

    public function offsetUnset($offset): void { }

    public function count(): int { }

    public function jsonSerialize(): mixed { }
}
