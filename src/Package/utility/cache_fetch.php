<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * psr-16 cache で「無かったらコールバックを実行して set」する
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param \Psr\SimpleCache\CacheInterface $cacher キャッシュオブジェクト
 * @param string $key キャッシュキー
 * @param callable $provider データプロバイダ
 * @param ?int $ttl キャッシュ時間
 * @return mixed キャッシュデータ
 */
function cache_fetch($cacher, $key, $provider, $ttl = null)
{
    $data = $cacher->get($key);
    if ($data === null) {
        $data = $provider();
        $cacher->set($key, $data, $ttl);
    }
    return $data;
}
