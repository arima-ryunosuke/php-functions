<?php

namespace ryunosuke\Functions;

use Psr\SimpleCache\CacheInterface;

/**
 * 雑なファイルキャッシュ
 */
class FileCache implements CacheInterface
{
    /** @var string キャッシュディレクトリ */
    private $cachedir;

    /** @var array 内部キャッシュ */
    private $cache;

    /** @var array 変更感知配列 */
    private $changed;

    public function __construct($cachedir)
    {
        $this->cachedir = $cachedir;
        $this->cache = [];
        $this->changed = [];
    }

    public function __destruct()
    {
        // キャッシュディレクトリなしならインメモリ（リクエストをまたがない）
        if ($this->cachedir !== null) {
            // 変更されているもののみ保存
            foreach ($this->changed as $namespace => $dummy) {
                $filepath = $this->cachedir . '/' . basename($namespace);
                $content = "<?php\nreturn " . var_export($this->cache[$namespace], true) . ";\n";

                $temppath = tempnam(sys_get_temp_dir(), 'cache');
                if (file_put_contents($temppath, $content) !== false) {
                    if (!@rename($temppath, $filepath)) {
                        @unlink($temppath);
                    }
                }
            }
        }
    }

    public function has($key)
    {
        // ファイルから読み込む必要があるので get しておく
        $this->get($key);

        list($namespace, $key) = explode('@', $key, 2);
        return array_key_exists($key, $this->cache[$namespace]);
    }

    public function get($key, $default = null)
    {
        list($namespace, $key) = explode('@', $key, 2);

        // 名前空間自体がないなら作る or 読む
        if (!isset($this->cache[$namespace])) {
            $nsarray = [];
            $cachpath = $this->cachedir . '/' . basename($namespace);
            if (file_exists($cachpath)) {
                $nsarray = require $cachpath;
            }
            $this->cache[$namespace] = $nsarray;
        }

        // あるならそれを、ないならデフォを返す
        return array_key_exists($key, $this->cache[$namespace]) ? $this->cache[$namespace][$key] : $default;
    }

    public function set($key, $value, $ttl = null)
    {
        list($namespace, $key) = explode('@', $key, 2);

        // 変更履歴がなくて・・・
        if (!isset($this->changed[$namespace])) {
            // 新しい値が来たら変更フラグを立てる
            if (!isset($this->cache[$namespace][$key]) || $this->cache[$namespace][$key] !== $value) {
                $this->changed[$namespace] = true;
            }
        }

        // 値をセット
        $this->cache[$namespace][$key] = $value;
    }

    public function clear()
    {
        // インメモリ情報をクリアして・・・
        $this->cache = [];
        $this->changed = [];

        // ファイルも消す
        if ($this->cachedir !== null) {
            foreach (glob($this->cachedir . '/*') as $file) {
                unlink($file);
            }
        }
    }

    public function delete($key) { /* not use */ }

    public function getMultiple($keys, $default = null) { /* not use */ }

    public function setMultiple($values, $ttl = null) { /* not use */ }

    public function deleteMultiple($keys) { /* not use */ }
}
