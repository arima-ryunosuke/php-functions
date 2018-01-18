<?php

namespace ryunosuke\Functions;

use Psr\SimpleCache\CacheInterface;

/**
 * 雑なキャッシュ
 */
class Cacher
{
    /** @var CacheInterface キャッシュオブジェクト */
    private static $cache;

    /**
     * グローバルに使用するキャッシュオブジェクトを設定する
     *
     * @param CacheInterface $cache キャッシュオブジェクト
     * @return CacheInterface 設定前のオブジェクト
     */
    public static function initialize(CacheInterface $cache = null)
    {
        if (func_num_args() === 0) {
            if (self::$cache === null) {
                self::$cache = new FileCache(null);
            }
            return null;
        }

        $current = self::$cache;
        self::$cache = $cache;
        return $current;
    }

    /**
     * キーがあるか返す
     *
     * @param string $namespace 名前空間
     * @param string $key キー
     * @return bool
     */
    public static function has($namespace, $key)
    {
        self::initialize();
        return self::$cache->has($namespace . '@' . $key);
    }

    /**
     * デフォルト値付き値取得
     *
     * @param string $namespace 名前空間
     * @param string $key キー
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed
     */
    public static function get($namespace, $key, $default = null)
    {
        self::initialize();
        return self::$cache->get($namespace . '@' . $key, $default);
    }

    /**
     * 値をセット
     *
     * @param string $namespace 名前空間
     * @param string $key キー
     * @param mixed $value セットする値
     * @return void
     */
    public static function set($namespace, $key, $value)
    {
        self::initialize();
        self::$cache->set($namespace . '@' . $key, $value);
    }

    /**
     * コールバック付き値取得
     *
     * @param string $namespace 名前空間
     * @param string $key キー
     * @param callable $provider 無かった場合に値を返すクロージャ
     * @return mixed
     */
    public static function put($namespace, $key, $provider)
    {
        self::initialize();
        if (!self::has($namespace, $key)) {
            self::set($namespace, $key, $provider());
        }
        return self::get($namespace, $key);
    }

    /**
     * キャッシュをクリア
     *
     * @return bool
     */
    public static function clear()
    {
        self::initialize();
        return self::$cache->clear();
    }
}
