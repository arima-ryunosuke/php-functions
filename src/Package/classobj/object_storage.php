<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/object_id.php';
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * オブジェクトに付加データを付与する
 *
 * 実質的に WeakMap と同じ。
 * ただし php 内部では本来オブジェクトであるべきものもリソースとして扱われる（curl とか）ので統一のためにリソースも扱える。
 *
 * 典型的な利用法として「クロージャに値を持たせたい」がある。
 * クロージャに限らず、大抵の内部オブジェクトは動的プロパティを生やせないので、値の保持がめんどくさい。
 * （spl_object_id は重複するので使えないし、下手に実装すると参照が握られて GC されない羽目になる）。
 *
 * Example:
 * ```php
 * $storage = object_storage('test');
 * $closure = fn() => 123;
 * $resource = tmpfile();
 *
 * // このように set すると・・・
 * $storage->set($closure, 'attached data1');
 * // get で取り出せる
 * that($storage->get($closure))->isSame('attached data1');
 * // リソースも扱える
 * $storage->set($resource, 'attached data2');
 * that($storage->get($resource))->isSame('attached data2');
 *
 * // 名前空間が同じならインスタンスをまたいで取得できる
 * $storage2 = object_storage('test');
 * that($storage2->get($closure))->isSame('attached data1');
 *
 * // オブジェクトが死ぬと同時に消える
 * unset($closure);
 * that($storage2->count())->isSame(1);
 * // リソースの場合は close でも消える
 * fclose($resource);
 * that($storage2->count())->isSame(0);
 * that($storage2->get($resource))->is(null);
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param string $namespace 名前空間
 * @return \ObjectStorage|object ストレージオブジェクト
 */
function object_storage($namespace = 'global')
{
    static $storages = [];
    return $storages[$namespace] ??= new class() implements \Countable, \ArrayAccess, \IteratorAggregate {
        private iterable $objects;
        private iterable $resources;

        public function __construct()
        {
            $this->objects = new \WeakMap();
            $this->resources = [];
        }

        private function typeid($objectOrResource)
        {
            if (is_object($objectOrResource)) {
                return ['objects', $objectOrResource];
            }
            if (is_resourcable($objectOrResource)) {
                return ['resources', (int) $objectOrResource];
            }
            throw new \InvalidArgumentException('supports only object or resource');
        }

        private function gc()
        {
            // WeakMap と言えど循環参照が残っているかもしれないので呼んでおく
            gc_collect_cycles();

            // 参照が切れたり閉じてるリソースを消す
            if ($this->resources) {
                $resources = get_resources();
                foreach ($this->resources as $id => $data) {
                    // 参照が切れてるのは get_resources に現れない、閉じてるのは現れるが gettype しないと判断できない
                    if (!isset($resources[$id]) || strpos(gettype($resources[$id]), 'closed') !== false) {
                        unset($this->resources[$id]);
                    }
                }
            }
        }

        public function has($objectOrResource): bool
        {
            return $this->offsetExists($objectOrResource);
        }

        public function get($objectOrResource, $default = null)
        {
            if ($this->has($objectOrResource)) {
                return $this->offsetGet($objectOrResource);
            }
            return $default;
        }

        public function set($objectOrResource, $data): self
        {
            $this->offsetSet($objectOrResource, $data);
            return $this;
        }

        public function clear(): bool
        {
            // 型が違ったりでめんどくさいので横着している
            $this->__construct();

            gc_collect_cycles();
            return true;
        }

        public function offsetExists($offset): bool
        {
            $this->gc();

            [$type, $id] = $this->typeid($offset);
            return isset($this->$type[$id]);
        }

        public function offsetGet($offset): mixed
        {
            [$type, $id] = $this->typeid($offset);
            return $this->$type[$id];
        }

        public function offsetSet($offset, $value): void
        {
            [$type, $id] = $this->typeid($offset);
            $this->$type[$id] = $value;
        }

        public function offsetUnset($offset): void
        {
            [$type, $id] = $this->typeid($offset);
            unset($this->$type[$id]);
        }

        public function count(): int
        {
            $this->gc();

            return count($this->objects) + count($this->resources);
        }

        public function getIterator(): \Generator
        {
            $this->gc();

            // WeakMap はキーとしてオブジェクトを返すのでそれに合わせる（ID を返されても意味がないし）

            foreach ($this->objects as $id => $data) {
                yield is_int($id) ? object_id($id) : $id => $data;
            }

            $resources = get_resources();
            foreach ($this->resources as $id => $data) {
                yield $resources[$id] => $data;
            }
        }
    };
}
