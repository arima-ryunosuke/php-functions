<?php

/**
 * cacheobject 関数のためのクラススタブ
 *
 * @used-by \cacheobject()
 * @used-by \ryunosuke\Functions\cacheobject()
 * @used-by \ryunosuke\Functions\Package\cacheobject()
 */
interface Psr16CacheInterface extends \Psr\SimpleCache\CacheInterface
{
    public function clean();

    public function keys(?string $pattern = null);

    public function fetch($key, $provider, $ttl = null);

    public function fetchMultiple($providers, $ttl = null);
}
