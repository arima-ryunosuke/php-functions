<?php
// @formatter:off

/**
 * stub for cacheobject
 *
 *
 *
 * @used-by \cacheobject()
 * @used-by \ryunosuke\Functions\cacheobject()
 * @used-by \ryunosuke\Functions\Package\cacheobject()
 */
class Cacheobject
{


    public function __debugInfo() { }
    public function keys(?string $pattern = null) { }
    public function clean() { }
    public function fetch($key, $provider, $ttl = null) { }
    public function fetchMultiple($providers, $ttl = null) { }
    public function get($key, $default = null) { }
    public function set($key, $value, $ttl = null) { }
    public function delete($key) { }
    public function clear() { }
    public function getMultiple($keys, $default = null) { }
    public function setMultiple($values, $ttl = null) { }
    public function deleteMultiple($keys) { }
    public function has($key) { }
}
