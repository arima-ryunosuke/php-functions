<?php

/**
 * chain 関数のためのクラススタブ
 */
class ChainObject implements \IteratorAggregate
{
    // {annotation}
    use date_0;
    use pcre_0;
    use hash_0;
    use standard_0;
    use standard_1;
    use standard_2;
    use standard_3;
    use standard_4;
    use standard_5;
    use standard_6;
    use standard_7;
    use mbstring_0;
    use user_0;
    use user_1;
    use user_2;
    use user_3;
    use user_4;
    use user_5;
    use user_6;
    // {/annotation}

    public function __invoke(...$source) { }

    public function __toString(): string { return ''; }

    public function __get($name): self { return $this; }

    public function __call($name, $arguments): self { return $this; }

    public function apply($callback, ...$args): self { return $this; }

    public function getIterator(): \Traversable { return $this; }
}
