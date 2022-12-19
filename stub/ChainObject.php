<?php

/**
 * chain 関数のためのクラススタブ
 */
class ChainObject implements \Countable, \ArrayAccess, \IteratorAggregate, \JsonSerializable
{
    // {annotation}
    use ChainObjectA;
    use ChainObjectB;
    use ChainObjectC;
    use ChainObjectD;
    use ChainObjectE;
    use ChainObjectF;
    use ChainObjectG;
    use ChainObjectH;
    use ChainObjectI;
    use ChainObjectJ;
    use ChainObjectK;
    use ChainObjectL;
    use ChainObjectM;
    use ChainObjectN;
    use ChainObjectO;
    use ChainObjectP;
    use ChainObjectQ;
    use ChainObjectR;
    use ChainObjectS;
    use ChainObjectT;
    use ChainObjectU;
    use ChainObjectV;
    use ChainObjectW;
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
