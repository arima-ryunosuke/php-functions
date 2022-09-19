<?php

interface Psr16CacheInterface extends \Psr\SimpleCache\CacheInterface
{
    public function clean();

    public function keys(?string $pattern = null);

    public function fetch($key, $provider, $ttl = null);

    public function fetchMultiple($providers, $ttl = null);
}
