<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../url/base64url_encode.php';
require_once __DIR__ . '/../utility/function_configure.php';
require_once __DIR__ . '/../var/is_exportable.php';
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * キーが json 化されてファイルシステムに永続化される ArrayAccess を返す
 *
 * 非常にシンプルで PSR-16 も実装せず、TTL もクリア手段も（基本的には）存在しない。
 * ArrayAccess なので `$storage['hoge'] ??= something()` として使うのがほぼ唯一の利用法。
 * その仕様・利用上、値として null を使用することはできない（使用した場合の動作は未定義とする）。
 *
 * キーに指定できるのは json_encode 可能なもののみ。
 * 値に指定できるのは var_export 可能なもののみ。
 * 上記以外を与えたときの動作は未定義。
 *
 * 得てして簡単な関数・メソッドのメモ化や内部的なキャッシュに使用する。
 *
 * Example:
 * ```php
 * // ??= を使えば「無かったら値を、有ったらそれを」を単純に実現できる
 * $storage = json_storage();
 * that($storage['key'] ??= (fn() => 123)())->is(123);
 * that($storage['key'] ??= (fn() => 456)())->is(123);
 * // 引数に与えた prefix で別空間になる
 * $storage = json_storage('other');
 * that($storage['key'] ??= (fn() => 789)())->is(789);
 * ```
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param string $directory 永続化ディレクトリ
 * @return \ArrayObject
 */
function json_storage(string $prefix = 'global')
{
    $cachedir = function_configure('cachedir') . '/' . strtr(__FUNCTION__, ['\\' => '%']);
    if (!file_exists($cachedir)) {
        @mkdir($cachedir, 0777, true);
    }

    static $objects = [];
    return $objects[$prefix] ??= new class("$cachedir/" . strtr($prefix, ['\\' => '%', '/' => '-'])) extends \ArrayObject {
        public function __construct(private string $directory)
        {
            parent::__construct();
        }

        public function offsetExists(mixed $key): bool
        {
            return $this->offsetGet($key) !== null;
        }

        public function offsetGet(mixed $key): mixed
        {
            $json = $this->json($key);

            // 有るならそれでよい
            if (parent::offsetExists($json)) {
                return parent::offsetGet($json);
            }

            // 無くてもストレージにある可能性がある
            $filename = $this->filename($json);
            clearstatcache(true, $filename);
            if (file_exists($filename)) {
                [$k, $v] = include $filename;
                // hash 化してるので万が一競合すると異なるデータを返してしまう
                if ($k !== $key) {
                    return null; // @codeCoverageIgnore
                }
                // ストレージに有ったら内部キャッシュしてそれを使う
                parent::offsetSet($json, $v);
                return $v;
            }

            return null;
        }

        public function offsetSet(mixed $key, mixed $value): void
        {
            $json = $this->json($key);

            // 値が変化したらストレージにも保存
            if (!parent::offsetExists($json) || parent::offsetGet($json) !== $value) {
                assert(is_exportable($value));
                $filename = $this->filename($json);
                if ($value === null) {
                    opcache_invalidate($filename, true);
                    @unlink($filename);
                }
                else {
                    file_put_contents($filename, '<?php return ' . var_export([$key, $value], true) . ';', LOCK_EX);
                }
            }

            parent::offsetSet($json, $value);
        }

        public function offsetUnset(mixed $key): void
        {
            $this->offsetSet($key, null);
        }

        private function json(mixed $data): string
        {
            assert((function () use ($data) {
                $tmp = [$data];
                array_walk_recursive($tmp, function ($value) {
                    if (is_resourcable($value)) {
                        throw new \Exception("\$value is resource");
                    }
                    if (is_object($value) && (!$value instanceof \JsonSerializable && get_class($value) !== \stdClass::class)) {
                        throw new \Exception("\$value is not JsonSerializable");
                    }
                });
                return true;
            })());
            return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        }

        private function filename(string $json): string
        {
            $filename = base64url_encode(implode("\n", [
                hash('fnv164', $json, true),
                hash('crc32', $json, true),
            ]));
            return "{$this->directory}-$filename.php-cache";
        }
    };
}
