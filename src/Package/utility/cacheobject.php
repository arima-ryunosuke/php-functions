<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_each.php';
require_once __DIR__ . '/../filesystem/file_list.php';
require_once __DIR__ . '/../filesystem/file_set_contents.php';
require_once __DIR__ . '/../filesystem/rm_rf.php';
require_once __DIR__ . '/../var/var_export3.php';
// @codeCoverageIgnoreEnd

/**
 * psr-16 を実装したキャッシュオブジェクトを返す
 *
 * このオブジェクトはあくまで「他のパッケージに依存したくない」場合のデフォルト実装としての使用を想定している。
 *
 * - キャッシュはファイルシステムに保存される
 * - キャッシュキーの . はディレクトリ区切りとして使用される
 * - TTL を指定しなかったときのデフォルト値は約100年（実質無期限だろう）
 * - clear するとディレクトリ自体を吹き飛ばすのでそのディレクトリはキャッシュ以外の用途に使用してはならない
 * - psr-16 にはない getOrSet が生えている（利便性が非常に高く使用頻度が多いため）
 *
 * 性質上、参照されない期限切れキャッシュが溜まり続けるが $clean_probability を渡すと一定確率で削除される。
 * $clean_probability は 1 が 100%（必ず削除）、 0 が 0%（削除しない）である。
 * 削除処理は軽くはないため高頻度な実行は避けなければならない。
 * clean メソッドが生えているので明示的に呼ぶことも可能。
 *
 * psr/simple-cache （\Psr\SimpleCache\CacheInterface）が存在するなら implement される。
 * 存在しないなら素の無名クラスで返す。
 * 動作に違いはないが instanceoof や class_implements に違いが出てくるので注意。
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param string $directory キャッシュ保存ディレクトリ
 * @param float $clean_probability 不要キャッシュの削除確率
 * @return \Psr16CacheInterface psr-16 実装オブジェクト
 */
function cacheobject($directory, $clean_probability = 0)
{
    $cacheobject = new class($directory) {
        private $directory;
        private $entries = [];

        public function __construct(string $directory)
        {
            assert(strlen($directory));
            $this->directory = $directory;
        }

        public function __debugInfo()
        {
            $class = self::class;
            $props = (array) $this;

            // 全キャッシュは情報量としてでかすぎるが、何がどこに配置されているかくらいは有ってもいい
            $ekey = "\0$class\0entries";
            assert(array_key_exists($ekey, $props));
            $props[$ekey] = array_reduce(array_keys($props[$ekey]), fn($acc, $k) => $acc + [$k => $this->_getFilename($k)], []);

            return $props;
        }

        private function _exception(string $message = "", int $code = 0, \Throwable $previous = null): \Throwable
        {
            return interface_exists(\Psr\SimpleCache\InvalidArgumentException::class)
                ? new class ( $message, $code, $previous ) extends \InvalidArgumentException implements \Psr\SimpleCache\InvalidArgumentException { }
                : new class ( $message, $code, $previous ) extends \InvalidArgumentException { };
        }

        private function _validateKey(string $key): void
        {
            if ($key === '') {
                throw $this->_exception("\$key is empty string");
            }
            if (strpbrk($key, '{}()/\\@:') !== false) {
                throw $this->_exception("\$key contains reserved character({}()/\\@:)");
            }
        }

        private function _normalizeTtl($ttl): int
        {
            if ($ttl === null) {
                return 60 * 60 * 24 * 365 * 100;
            }
            if (is_int($ttl)) {
                return $ttl;
            }
            if ($ttl instanceof \DateInterval) {
                return (new \DateTime())->setTimestamp(0)->add($ttl)->getTimestamp();
            }
            throw $this->_exception("\$ttl must be null|int|DateInterval(" . gettype($ttl) . ")");
        }

        private function _getFilename(string $key): string
        {
            return $this->directory . DIRECTORY_SEPARATOR . strtr(rawurlencode($key), ['.' => DIRECTORY_SEPARATOR]) . ".php";
        }

        private function _getMetadata(string $filename): ?array
        {
            $fp = fopen($filename, "r");
            if ($fp === false) {
                return null; // @codeCoverageIgnore
            }
            try {
                $first = fgets($fp);
                $meta = @json_decode(substr($first, strpos($first, '#') + 1), true);
                return $meta ?: null;
            }
            finally {
                fclose($fp);
            }
        }

        public function keys(?string $pattern = null)
        {
            $files = file_list($this->directory, [
                '!type' => ['dir', 'link'],
            ]);

            $now = time();
            $result = [];
            foreach ($files as $file) {
                $meta = $this->_getMetadata($file);
                if ($meta && ($pattern === null || fnmatch($pattern, $meta['key']))) {
                    $result[$meta['key']] = [
                        'realpath' => $file,
                        'size'     => filesize($file),
                        'ttl'      => $meta['expire'] - $now,
                    ];
                }
            }
            return $result;
        }

        public function clean()
        {
            $files = file_list($this->directory, [
                '!type' => 'link',
            ]);

            foreach ($files as $file) {
                if (is_file($file)) {
                    $meta = $this->_getMetadata($file);
                    if (isset($meta['expire']) && $meta['expire'] < time()) {
                        @unlink($file);
                    }
                }
                elseif (is_dir($file)) {
                    @rmdir($file);
                }
            }
        }

        public function fetch($key, $provider, $ttl = null)
        {
            $value = $this->get($key);
            if ($value === null) {
                $value = $provider($this);
                $this->set($key, $value, $ttl);
            }
            return $value;
        }

        public function fetchMultiple($providers, $ttl = null)
        {
            $result = $this->getMultiple(array_keys($providers));
            foreach ($providers as $key => $provider) {
                $result[$key] ??= $this->fetch($key, $provider, $ttl);
            }
            return $result;
        }

        public function get($key, $default = null)
        {
            $this->_validateKey($key);

            error_clear_last();
            $entry = $this->entries[$key] ?? @include $this->_getFilename($key);
            if (error_get_last() !== null || $entry[0] < time()) {
                $this->delete($key);
                return $default;
            }

            $this->entries[$key] = $entry;
            return $entry[1];
        }

        public function set($key, $value, $ttl = null)
        {
            $this->_validateKey($key);
            $ttl = $this->_normalizeTtl($ttl);

            if ($ttl <= 0) {
                return $this->delete($key);
            }

            $expire = time() + $ttl;
            $this->entries[$key] = [$expire, $value];
            $meta = json_encode(['key' => $key, 'expire' => $expire]);
            $code = var_export3($this->entries[$key], ['outmode' => 'eval']);
            return !!file_set_contents($this->_getFilename($key), "<?php # $meta\n$code\n");
        }

        public function delete($key)
        {
            $this->_validateKey($key);

            unset($this->entries[$key]);
            return @unlink($this->_getFilename($key));
        }

        public function clear()
        {
            $this->entries = [];
            return rm_rf($this->directory, false);
        }

        public function getMultiple($keys, $default = null)
        {
            return array_each($keys, function (&$result, $v) use ($default) {
                $result[$v] = $this->get($v, $default);
            }, []);
        }

        public function setMultiple($values, $ttl = null)
        {
            return array_each($values, function (&$result, $v, $k) use ($ttl) {
                $result = $this->set($k, $v, $ttl) && $result;
            }, true);
        }

        public function deleteMultiple($keys)
        {
            return array_each($keys, function (&$result, $v) {
                $result = $this->delete($v) && $result;
            }, true);
        }

        public function has($key)
        {
            return $this->get($key) !== null;
        }
    };

    static $cleaned = [];
    if ($clean_probability !== 0 && !($cleaned[$directory] ?? false)) {
        $cleaned[$directory] = true;
        if ($clean_probability * 100 >= rand(1, 100)) {
            $cacheobject->clean();
        }
    }

    /** @noinspection PhpIncompatibleReturnTypeInspection */
    return !interface_exists(\Psr\SimpleCache\CacheInterface::class) ? $cacheobject : new class($cacheobject) implements \Psr\SimpleCache\CacheInterface {
        private $cacheobject;

        public function __construct($cacheobject)
        {
            $this->cacheobject = $cacheobject;
        }

        // @formatter:off
            public function clean()                                { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function keys($pattern = null)                  { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function fetch($key, $provider, $ttl = null)    { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function fetchMultiple($providers, $ttl = null) { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function get($key, $default = null)             { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function set($key, $value, $ttl = null)         { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function delete($key)                           { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function clear()                                { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function getMultiple($keys, $default = null)    { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function setMultiple($values, $ttl = null)      { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function deleteMultiple($keys)                  { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function has($key)                              { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            // @formatter:on
    };
}
