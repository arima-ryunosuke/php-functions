<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectK
{
    /** @see \krsort() */
    public self $krsort;
    public function krsort(array &$array, int $flags = SORT_REGULAR): self { }
    public function krsort(int $flags = SORT_REGULAR): self { }

    /** @see \ksort() */
    public self $ksort;
    public function ksort(array &$array, int $flags = SORT_REGULAR): self { }
    public function ksort(int $flags = SORT_REGULAR): self { }

    /** @see \key() */
    public self $key;
    public function key(object|array $array): self { }
    public function key(): self { }

    /** @see \key_exists() */
    public self $key_exists;
    public function key_exists($key, array $array): self { }
    public function key_exists(array $array): self { }

    /** @see \kvsort() */
    public self $kvsort;
    public function kvsort(iterable $array, $comparator = null): self { }
    public function kvsort($comparator = null): self { }

    /** @see \kvsprintf() */
    public self $kvsprintf;
    public function kvsprintf($format, array $array): self { }
    public function kvsprintf(array $array): self { }

}
