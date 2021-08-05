<?php

interface Psr16CacheInterface extends \Psr\SimpleCache\CacheInterface
{
    public function fetch($key, $provider, $ttl = null);

    public function fetchMultiple($providers, $ttl = null);
}
