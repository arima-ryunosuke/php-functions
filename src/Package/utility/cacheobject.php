<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_each.php';
require_once __DIR__ . '/../filesystem/file_list.php';
require_once __DIR__ . '/../filesystem/file_set_contents.php';
require_once __DIR__ . '/../filesystem/path_is_absolute.php';
require_once __DIR__ . '/../utility/function_configure.php';
require_once __DIR__ . '/../utility/function_resolve.php';
require_once __DIR__ . '/../var/is_exportable.php';
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * psr-16 を実装したキャッシュオブジェクトを返す
 *
 * このオブジェクトはあくまで「他のパッケージに依存したくない」場合のデフォルト実装としての使用を想定している。
 *
 * - キャッシュはファイルシステムに保存される
 * - キャッシュキーの . はディレクトリ区切りとして使用される
 * - TTL を指定しなかったときのデフォルト値は約100年（実質無期限だろう）
 * - psr-16 にはない getOrSet(fetch) が生えている（利便性が非常に高く使用頻度が多いため）
 *
 * 性質上、参照されない期限切れキャッシュが溜まり続けるが $clean_probability を渡すと一定確率で削除される。
 * さらに $clean_execution_time を指定すると削除の実行時間が制限される。
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
 * @param ?string $directory キャッシュ保存ディレクトリ
 * @param float $clean_probability 不要キャッシュの削除確率
 * @param ?float $clean_execution_time 不要キャッシュの最大実行時間
 * @return \Cacheobject psr-16 実装オブジェクト
 */
function cacheobject($directory = null, $clean_probability = 0, $clean_execution_time = null)
{
    static $cacheobjects = [];

    $cachedir = function_configure('cachedir');

    // 相対パスは cachedir からの相対とする
    if ($directory !== null && !path_is_absolute($directory)) {
        $directory = $cachedir . DIRECTORY_SEPARATOR . strtr($directory, ['\\' => '%']);
    }
    $directory ??= $cachedir;

    $cacheobject = $cacheobjects[$directory] ??= (function ($directory) {
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
                return $this->directory . DIRECTORY_SEPARATOR . strtr(rawurlencode($key), ['.' => DIRECTORY_SEPARATOR]) . ".php-cache";
            }

            private function _getCacheFilenames(): array
            {
                return file_list($this->directory, [
                    '!type'     => ['dir', 'link'],
                    'extension' => ['php-cache'],
                ]) ?? [];
            }

            private function _getMetadata(string $filename): ?array
            {
                $fp = @fopen($filename, "r");
                if ($fp === false) {
                    return null;
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
                $files = $this->_getCacheFilenames();

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

            public function clean($max_execution_time = null)
            {
                $files = file_list($this->directory, [
                    '!type' => 'link',
                ]);

                set_error_handler(fn() => true);
                try {
                    $end = microtime(true) + ($max_execution_time ?? 0);
                    foreach ($files as $file) {
                        if ($max_execution_time !== null && microtime(true) >= $end) {
                            break; // @codeCoverageIgnore
                        }
                        if (is_file($file)) {
                            $meta = $this->_getMetadata($file);
                            if (isset($meta['expire']) && $meta['expire'] < time()) {
                                unset($this->entries[$meta['key']]);
                                unlink($file);
                            }
                        }
                        elseif (is_dir($file)) {
                            rmdir($file);
                        }
                    }
                }
                finally {
                    restore_error_handler();
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

                if (!isset($this->entries[$key])) {
                    error_clear_last();
                    $this->entries[$key] = @include $this->_getFilename($key);
                    if (error_get_last() !== null) {
                        $this->entries[$key] = [0, null];
                    }
                }
                $entry = $this->entries[$key];
                if ($entry[0] < time()) {
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
                // var_export3 はあらゆる出力を可能にしているので **読み込み時** のオーバーヘッドがでかく、もし var_export が使えるならその方が格段に速い
                // しかし要素を再帰的に全舐め（is_exportable）しないと「var_export できるか？」は分からないというジレンマがある
                // このコンテキストは「キャッシュ」なので書き込み時のオーバーヘッドよりも読み込み時のオーバーヘッドを優先して判定を行っている
                // ただし、 var_export3 は非常に依存がでかいので明示指定時のみ
                $var_export3 = function_resolve('var_export3');
                if ($var_export3 === null || is_exportable($this->entries[$key])) {
                    $code = var_export($this->entries[$key], true);
                }
                else {
                    $code = $var_export3($this->entries[$key], true);
                }
                return !!file_set_contents($this->_getFilename($key), "<?php # $meta\nreturn $code;\n");
            }

            public function delete($key)
            {
                $this->_validateKey($key);

                unset($this->entries[$key]);
                return @unlink($this->_getFilename($key));
            }

            public function provide($provider, ...$args)
            {
                $provider_hash = (string) new \ReflectionFunction($provider);
                $cacheid = "autoprovide." . hash('fnv164', $provider_hash);
                $key = $provider_hash . '@' . serialize($args);

                $cache = $this->get($cacheid) ?? [];
                if (!array_key_exists($key, $cache)) {
                    $result = $provider(...$args);
                    if ($result === null) {
                        return null;
                    }
                    $cache[$key] = $result;
                    $this->set($cacheid, $cache);
                }
                return $cache[$key];
            }

            public function hash($key, $provider, $ttl = null)
            {
                $now = time();
                $key = is_stringable($key) ? "$key" : json_encode($key);
                $cacheid = "hash." . hash('fnv164', $key);
                $ttl = $ttl === null ? null : $this->_normalizeTtl($ttl);

                $cache = $this->get($cacheid) ?? [];

                // ttl チェック
                if (isset($cache[$key][2]) && ($cache[$key][1] + $cache[$key][2]) <= $now) {
                    // アイテム自体の ttl を max($ttls) にしているため、原則として↑の $this->>get の時点でフィルタされてこのコードは通らない
                    // ここを通るのはハッシュが衝突してそれぞれの ttl がバラバラの場合のみ
                    // レアすぎてテストできないので ignore する（A(ttl:100) と B(ttl:50) が衝突してその間（75）で B を取得したときに通ることになる）
                    unset($cache[$key]); // @codeCoverageIgnore
                }
                // getter モード
                if ($provider === null && $ttl === null) {
                    return $cache[$key][0] ?? null;
                }
                // ttl 0 は psr16 と同様に削除モード
                if ($ttl !== null && $ttl <= 0) {
                    $result = isset($cache[$key]);
                    unset($cache[$key]);
                    $ttls = array_filter(array_column($cache, 2), fn($v) => $v !== null);
                    $this->set($cacheid, $cache, $ttls ? max($ttls) : null);
                    return $result;
                }

                if (!array_key_exists($key, $cache)) {
                    $cache[$key] = [$provider(), $now, $ttl];
                    $ttls = array_filter(array_column($cache, 2), fn($v) => $v !== null);
                    $this->set($cacheid, $cache, $ttls ? max($ttls) : null);
                }
                return $cache[$key][0];
            }

            public function clear()
            {
                $this->entries = [];

                $files = $this->_getCacheFilenames();
                return count($files) === count(array_filter(array_map('unlink', $files)));
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

        return !interface_exists(\Psr\SimpleCache\CacheInterface::class) ? $cacheobject : new class($cacheobject) implements \Psr\SimpleCache\CacheInterface {
            public function __construct(private $cacheobject) { }

            // @formatter:off
            public function clean($max_execution_time = null)                { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function keys($pattern = null): iterable                  { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function fetch($key, $provider, $ttl = null): mixed       { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function fetchMultiple($providers, $ttl = null): iterable { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function get($key, $default = null): mixed                { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function set($key, $value, $ttl = null): bool             { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function delete($key): bool                               { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function provide($provider, ...$args): mixed              { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function hash($key, $provider, $ttl = null): mixed        { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function clear(): bool                                    { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function getMultiple($keys, $default = null): iterable    { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function setMultiple($values, $ttl = null): bool          { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function deleteMultiple($keys): bool                      { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function has($key): bool                                  { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            // @formatter:on
        };
    })($directory);

    static $cleaned = [];
    if ($clean_probability !== 0 && !($cleaned[$directory] ?? false)) {
        $cleaned[$directory] = true;
        if ($clean_probability * 100 >= rand(1, 100)) {
            $cacheobject->clean($clean_execution_time);
        }
    }

    /** @noinspection PhpIncompatibleReturnTypeInspection */
    return $cacheobject;
}
