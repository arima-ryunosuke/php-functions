<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ReflectionType の型配列を返す
 *
 * ReflectionType のインターフェース・仕様がコロコロ変わってついていけないので関数化した。
 *
 * ReflectionType に準ずるインスタンスを渡すと取り得る候補を配列ライクなオブジェクトで返す。
 * 引数は配列で複数与えても良い。よしなに扱って複数型として返す。
 * また「Type が一意に導出できる Reflection」を渡しても良い（ReflectionProperty など）。
 * null を与えた場合はエラーにはならず、スルーされる（getType は null を返し得るので利便性のため）。
 *
 * 単純に ReflectionType の配列ライクなオブジェクトを返すが、そのオブジェクトは `__toString` が実装されており、文字列化するとパイプ区切りの型文字列を返す。
 * これは 8.0 における ReflectionUnionType の `__toString` を模倣したものである。
 * 互換性のある型があった場合、上位の型に内包されて型文字列としては出現しない。
 *
 * Countable も実装されているが、その結果は「内部 Type の数」ではなく、論理的に「取り得る型の数」を返す。
 * 例えば `?int` は型としては1つだが、実際は int, null の2つを取り得るため、 count は 2 を返す。
 * 端的に言えば「`__toString` のパイプ区切りの型の数」を返す。
 *
 * あとは便利メソッドとして下記が生えている。
 *
 * - jsonSerialize: JsonSerializable 実装
 * - getTypes: 取り得る型をすべて返す（ReflectionUnionType 互換）
 * - getName: ReflectionUnionType 非互換 toString な型宣言文字列を返す
 * - allows: その値を取りうるか判定して返す
 *
 * ReflectionUnionType とは完全互換ではないので、php8.0が完全に使える環境であれば素直に ReflectionUnionType を使ったほうが良い。
 * （「常に（型分岐せずに）複数形で扱える」程度のメリットしかない。allows は惜しいが）。
 *
 * ちなみに型の変遷は下記の通り。
 *
 * - php7.1: ReflectionType::__toString が非推奨になった
 * - php7.1: ReflectionNamedType が追加され、各種 getType でそれを返すようになった
 * - php8.0: ReflectionType::__toString が非推奨ではなくなった
 * - php8.0: ReflectionUnionType が追加され、複合の場合は getType でそれを返すようになった
 *
 * Example:
 * ```php
 * $object = new class {
 *     function method(object $o):?string {}
 * };
 * $method = new \ReflectionMethod($object, 'method');
 * $types = reflect_types($method->getParameters()[0]->getType());
 * // 文字列化すると型宣言文字列を返すし、配列アクセスや count, iterable でそれぞれの型が得られる
 * that((string) $types)->is('object');
 * that($types[0])->isInstanceOf(\ReflectionType::class);
 * that(iterator_to_array($types))->eachIsInstanceOf(\ReflectionType::class);
 * that(count($types))->is(1);
 * // 返り値でも同じ（null 許容なので null が付くし count も 2 になる）
 * $types = reflect_types($method->getReturnType());
 * that((string) $types)->is('string|null');
 * that(count($types))->is(2);
 * ```
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param \ReflectionFunctionAbstract|\ReflectionType|\ReflectionType[]|null $reflection_type getType 等で得られるインスタンス
 * @return \ReflectionAnyType|object
 */
function reflect_types($reflection_type = null)
{
    if (!is_array($reflection_type)) {
        $reflection_type = [$reflection_type];
    }

    foreach ($reflection_type as $n => $rtype) {
        if ($rtype instanceof \ReflectionProperty) {
            $reflection_type[$n] = $rtype->getType();
        }
        if ($rtype instanceof \ReflectionFunctionAbstract) {
            $reflection_type[$n] = $rtype->getReturnType();
        }
        if ($rtype instanceof \ReflectionParameter) {
            $reflection_type[$n] = $rtype->getType();
        }
    }

    return new class(...$reflection_type)
        extends \stdClass
        implements \IteratorAggregate, \ArrayAccess, \Countable, \JsonSerializable {

        private const PSEUDO = [
            'mixed'    => [],
            'static'   => ['object', 'mixed'],
            'self'     => ['static', 'object', 'mixed'],
            'parent'   => ['static', 'object', 'mixed'],
            'callable' => ['mixed'],
            'iterable' => ['mixed'],
            'object'   => ['mixed'],
            'array'    => ['iterable', 'mixed'],
            'string'   => ['mixed'],
            'int'      => ['mixed'],
            'float'    => ['mixed'],
            'bool'     => ['mixed'],
            'false'    => ['bool', 'mixed'],
            'null'     => ['mixed'],
            'void'     => [],
        ];

        public function __construct(?\ReflectionType ...$reflection_types)
        {
            $types = [];
            foreach ($reflection_types as $type) {
                if ($type === null) {
                    continue;
                }

                /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
                $types = array_merge($types, $type instanceof \ReflectionUnionType ? $type->getTypes() : [$type]);
            }

            // 配列キャストで配列を得たいので下手にフィールドを宣言せず直に生やす
            foreach ($types as $n => $type) {
                $this->$n = $type;
            }
        }

        public function __toString()
        {
            return implode('|', $this->toStrings(true, true));
        }

        public function getIterator(): \Traversable
        {
            // yield from $this->getTypes();
            return new \ArrayIterator($this->getTypes());
        }

        public function offsetExists($offset): bool
        {
            return isset($this->$offset);
        }

        /** @noinspection PhpLanguageLevelInspection */
        #[\ReturnTypeWillChange]
        public function offsetGet($offset)
        {
            return $this->$offset;
        }

        public function offsetSet($offset, $value): void
        {
            // for debug
            if (is_string($value)) {
                $value = new class ($value, self::PSEUDO) extends \ReflectionNamedType {
                    private $typename;
                    private $nullable;
                    private $builtins;

                    public function __construct($typename, $builtins)
                    {
                        $this->typename = ltrim($typename, '?');
                        $this->nullable = $typename[0] === '?';
                        $this->builtins = $builtins;
                    }

                    public function getName(): string { return $this->typename; }

                    public function allowsNull(): bool { return $this->nullable; }

                    public function isBuiltin(): bool { return isset($this->builtins[$this->typename]); }

                    public function __toString(): string { return $this->getName(); }
                };
            }

            assert($value instanceof \ReflectionType);
            if ($offset === null) {
                $offset = max(array_keys($this->getTypes()) ?: [-1]) + 1;
            }
            $this->$offset = $value;
        }

        public function offsetUnset($offset): void
        {
            unset($this->$offset);
        }

        public function count(): int
        {
            return count($this->toStrings(true, false));
        }

        public function jsonSerialize(): array
        {
            return $this->toStrings(true, true);
        }

        public function getName()
        {
            $types = array_flip($this->toStrings(true, true));
            $nullable = false;
            if (isset($types['null']) && count($types) === 2) {
                unset($types['null']);
                $nullable = true;
            }

            $result = [];
            foreach ($types as $type => $dummy) {
                $result[] = (isset(self::PSEUDO[$type]) ? '' : '\\') . $type;
            }
            return ($nullable ? '?' : '') . implode('|', $result);
        }

        public function getTypes()
        {
            return (array) $this;
        }

        public function allows($type, $strict = false)
        {
            $types = array_flip($this->toStrings(false, false));

            if (isset($types['mixed'])) {
                return true;
            }

            foreach ($types as $allow => $dummy) {
                if (function_exists($f = "is_$allow") && $f($type)) {
                    return true;
                }
                if (is_a($type, $allow, true)) {
                    return true;
                }
            }

            if (!$strict) {
                if (is_int($type) || is_float($type) || is_bool($type)) {
                    if (isset($types['int']) || isset($types['float']) || isset($types['bool']) || isset($types['string'])) {
                        return true;
                    }
                }
                if (is_string($type) || (is_object($type) && method_exists($type, '__toString'))) {
                    if (isset($types['string'])) {
                        return true;
                    }
                    if ((isset($types['int']) || isset($types['float'])) && is_numeric("$type")) {
                        return true;
                    }
                }
            }
            return false;
        }

        private function toStrings($ignore_compatible = true, $sort = true)
        {
            $types = [];
            foreach ($this->getTypes() as $type) {
                // ドキュメント上は「ReflectionNamedType を返す可能性があります」とのことなので getName 前提はダメ
                // かといって文字列化前提だと 7.1 以降で deprecated が出てしまう
                // つまり愚直に分岐するか @ で抑制するくらいしか多バージョン対応する術がない（7.1 の deprecated を解除して欲しい…）
                $types[$type instanceof \ReflectionNamedType ? $type->getName() : (string) $type] = true;

                if ($type->allowsNull()) {
                    $types['null'] = true;
                }
            }

            if ($ignore_compatible) {
                $types = array_filter($types, function ($type) use ($types) {
                    // いくつか互換のある内包疑似型が存在する（iterable は array を内包するし、 bool は false を内包する）
                    foreach (self::PSEUDO[$type] ?? [] as $parent) {
                        if (isset($types[$parent])) {
                            return false;
                        }
                    }
                    // さらに object 疑似型は全てのクラス名を内包する
                    if (isset($types['object']) && !isset(self::PSEUDO[$type])) {
                        return false;
                    }
                    return true;
                }, ARRAY_FILTER_USE_KEY);
            }

            if ($sort) {
                static $orders = null;
                $orders ??= array_flip(array_keys(self::PSEUDO));
                uksort($types, function ($a, $b) use ($orders) {
                    $issetA = isset($orders[$a]);
                    $issetB = isset($orders[$b]);
                    switch (true) {
                        case $issetA && $issetB:   // 共に疑似型
                            return $orders[$a] - $orders[$b];
                        case !$issetA && !$issetB: // 共にクラス名
                            return strcasecmp($a, $b);
                        case !$issetA && $issetB:  // A だけがクラス名
                            return -1;
                        case $issetA && !$issetB:  // B だけがクラス名
                            return +1;
                    }
                });
            }
            return array_keys($types);
        }
    };
}
