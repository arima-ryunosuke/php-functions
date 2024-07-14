<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * シンプルにキャッシュする
 *
 * この関数は get/set/delete を兼ねる。
 * キャッシュがある場合はそれを返し、ない場合は $provider を呼び出してその結果をキャッシュしつつそれを返す。
 *
 * $provider に null を与えるとキャッシュの削除となる。
 *
 * Example:
 * ```php
 * $provider = fn() => rand();
 * // 乱数を返す処理だが、キャッシュされるので同じ値になる
 * $rand1 = cache('rand', $provider);
 * $rand2 = cache('rand', $provider);
 * that($rand1)->isSame($rand2);
 * // $provider に null を与えると削除される
 * cache('rand', null);
 * $rand3 = cache('rand', $provider);
 * that($rand1)->isNotSame($rand3);
 * ```
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param string $key キャッシュのキー
 * @param ?callable $provider キャッシュがない場合にコールされる callable
 * @param ?string $namespace 名前空間
 * @return mixed キャッシュ
 */
function cache($key, $provider, $namespace = null)
{
    static $cacheobject;
    $cacheobject ??= new class(function_configure('cachedir')) {
        const CACHE_EXT = '.php-cache';

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
            // 変更されているもののみ保存
            foreach ($this->changed as $namespace => $dummy) {
                $filepath = $this->cachedir . '/' . rawurlencode($namespace) . self::CACHE_EXT;
                $content = "<?php\nreturn " . var_export($this->cache[$namespace], true) . ";\n";

                $temppath = tempnam(sys_get_temp_dir(), 'cache');
                if (file_put_contents($temppath, $content) !== false) {
                    @chmod($temppath, 0644);
                    if (!@rename($temppath, $filepath)) {
                        @unlink($temppath); // @codeCoverageIgnore
                    }
                }
            }
        }

        public function has($namespace, $key)
        {
            // ファイルから読み込む必要があるので get しておく
            $this->get($namespace, $key);
            return array_key_exists($key, $this->cache[$namespace]);
        }

        public function get($namespace, $key)
        {
            // 名前空間自体がないなら作る or 読む
            if (!isset($this->cache[$namespace])) {
                $nsarray = [];
                $cachpath = $this->cachedir . '/' . rawurlencode($namespace) . self::CACHE_EXT;
                if (file_exists($cachpath)) {
                    $nsarray = require $cachpath;
                }
                $this->cache[$namespace] = $nsarray;
            }

            return $this->cache[$namespace][$key] ?? null;
        }

        public function set($namespace, $key, $value)
        {
            // 新しい値が来たら変更フラグを立てる
            if (!isset($this->cache[$namespace]) || !array_key_exists($key, $this->cache[$namespace]) || $this->cache[$namespace][$key] !== $value) {
                $this->changed[$namespace] = true;
            }

            $this->cache[$namespace][$key] = $value;
        }

        public function delete($namespace, $key)
        {
            $this->changed[$namespace] = true;
            unset($this->cache[$namespace][$key]);
        }

        public function clear()
        {
            // インメモリ情報をクリアして・・・
            $this->cache = [];
            $this->changed = [];

            // ファイルも消す
            foreach (glob($this->cachedir . '/*' . self::CACHE_EXT) as $file) {
                unlink($file);
            }
        }
    };

    // flush (for test)
    if ($key === null) {
        if ($provider === null) {
            $cacheobject->clear();
        }
        $cacheobject = null;
        return;
    }

    $namespace ??= __FILE__;

    $exist = $cacheobject->has($namespace, $key);
    if ($provider === null) {
        $cacheobject->delete($namespace, $key);
        return $exist;
    }
    if (!$exist) {
        $cacheobject->set($namespace, $key, $provider());
    }
    return $cacheobject->get($namespace, $key);
}
