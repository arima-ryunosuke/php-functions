<?php
// @formatter:off

/**
 * stub for cacheobject
 *
 * @noinspection PhpIncompatibleReturnTypeInspection
 *
 * @used-by \cacheobject()
 * @used-by \ryunosuke\Functions\cacheobject()
 * @used-by \ryunosuke\Functions\Package\cacheobject()
 */
class Cacheobject implements Psr\SimpleCache\CacheInterface
{


    public function clean() { }
    public function keys($pattern = null): iterable { }
    public function fetch($key, $provider, $ttl = null): mixed { }
    public function fetchMultiple($providers, $ttl = null): iterable { }
    public function get($key, $default = null): mixed { }
    public function set($key, $value, $ttl = null): bool { }
    public function delete($key): bool { }
    public function provide($provider, ...$args): mixed { }
    public function clear(): bool { }
    public function getMultiple($keys, $default = null): iterable { }
    public function setMultiple($values, $ttl = null): bool { }
    public function deleteMultiple($keys): bool { }
    public function has($key): bool { }
}
