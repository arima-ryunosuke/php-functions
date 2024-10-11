<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/type_exists.php';
require_once __DIR__ . '/../reflection/reflect_type_resolve.php';
require_once __DIR__ . '/../strings/str_quote.php';
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * 値の型を取得する
 *
 * get_debug_type を少しだけ特殊化したもの。
 * 「デバッグ用の型」ではなく「コード化したときに埋め込みやすい型」が主目的。
 *
 * - object の場合は必ず \ が付く
 * - resource の場合はカッコ書き無しで 'resource'
 *
 * 無名クラスの場合は extends, implements の優先順位でその名前を使う。
 * 継承も実装もされていない場合は標準の get_class の結果を返す。
 *
 * phpdoc に true を渡すと array-shape 記法も有効になり下記のようになる。
 *
 * - 連想配列は想起した通り
 * - 連番配列は中身の和集合を取る
 *     - 中身がさらに配列なら再帰的に処理する
 *         - 有り無し混在は null 扱いになる
 * - 無名クラスは親クラス＋インターフェースを取る
 *     - 完全無名クラスは object になる
 *
 * phpdoc:true の場合の結果は互換性を考慮しない。
 *
 * Example:
 * ```php
 * // プリミティブ型は get_debug_type と同義
 * that(var_type(false))->isSame('bool');
 * that(var_type(123))->isSame('int');
 * that(var_type(3.14))->isSame('float');
 * that(var_type([1, 2, 3]))->isSame('array');
 * // リソースはなんでも resource
 * that(var_type(STDOUT))->isSame('resource');
 * // オブジェクトは型名を返す
 * that(var_type(new \stdClass))->isSame('\\stdClass');
 * that(var_type(new \Exception()))->isSame('\\Exception');
 * // 無名クラスは継承元の型名を返す（インターフェース実装だけのときはインターフェース名）
 * that(var_type(new class extends \Exception{}))->isSame('\\Exception');
 * that(var_type(new class implements \JsonSerializable{
 *     public function jsonSerialize(): string { return ''; }
 * }))->isSame('\\JsonSerializable');
 *
 * // phpdoc 形式
 * that(var_type([
 *     'scalar'    => 123,
 *     'lish-hash' => [
 *         ['id' => 1, 'name' => 'a'],
 *         ['id' => 2, 'name' => 'b'],
 *     ],
 *     'nest'      => [
 *         'a' => [
 *             'b' => [
 *                 'c' => ['a', 'b', 'c'],
 *             ],
 *         ],
 *     ],
 * ], ['phpdoc' => true, 'format' => 9]))->is(<<<ARRAYSHAPE
 * array{
 *   "lish-hash": array<array{
 *     id: int,
 *     name: string
 *   }>,
 *   nest: array{
 *     a: array{
 *       b: array{
 *         c: array<string>
 *       }
 *     }
 *   },
 *   scalar: int
 * }
 * ARRAYSHAPE);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 */
function var_type(
    /** 型を取得する値 */ mixed $var,
    /** オプション配列 */ array $options = [],
): /** 型名 */ string
{
    $options['phpdoc'] ??= false;                             // phpdoc 形式で書き出すか
    $options['format'] ??= 1;                                 // フォーマットレベル（0:no space, 1:separator only, ...9:pretty）
    $options['is_list'] ??= fn($k, $v, $array) => is_int($k); // 連番配列の判定処理（例えば UUID などを連番として扱いたいことがある）
    $options['is_object'] ??= function ($var) {               // object-shape 記法にするオブジェクトの判定処理
        if (is_object($var)) {
            if ($var instanceof \stdClass) {
                return true;
            }
            /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
            if (count((new \ReflectionClass($var))->getAttributes(\AllowDynamicProperties::class))) {
                return true;
            }
        }
        return false;
    };

    $options['nest'] = 0;

    if (is_array($var) || $options['is_object']($var)) {
        if ($options['phpdoc']) {
            $shape = new class($var, $options) {
                private string $shape;
                private array  $type     = [];
                private array  $list     = [];
                private array  $hash     = [];
                private array  $object   = [];
                private bool   $optional = false;
                private array  $options;

                private string $result;

                public function __construct($var, $options)
                {
                    $this->shape = is_object($var) ? 'object' : 'array';
                    $this->options = $options;

                    if (is_array($var) || $this->options['is_object']($var)) {
                        foreach ($var as $k => $v) {
                            if ($this->options['is_list']($k, $v, $var)) {
                                $new = new self($v, $this->options);
                                foreach ($this->list as $n => $old) {
                                    /** @var self $old */
                                    if (type_exists($newtype = (string) $new) && type_exists($oldtype = (string) $old)) {
                                        if (is_subclass_of($newtype, $oldtype)) {
                                            $this->list[$n] = $new;
                                            continue 2;
                                        }
                                        if (is_subclass_of($oldtype, $newtype)) {
                                            continue 2;
                                        }
                                    }

                                    if ($new->list xor $old->list) {
                                        if ($new->list && !$old->list) {
                                            $this->list[$n] = $new;
                                            continue 2;
                                        }
                                        if (!$new->list && $old->list) {
                                            continue 2;
                                        }
                                    }

                                    $flag = false;
                                    foreach (['hash', 'object'] as $property) {
                                        if ($new->$property && $old->$property) {
                                            $flag = true;
                                            $diffs = array_diff_key($new->$property, $old->$property) + array_diff_key($old->$property, $new->$property);

                                            foreach ($diffs as $diff) {
                                                /** @var self $diff */
                                                unset($diff->result);
                                                $diff->optional = true;
                                            }
                                            $old->$property += $diffs;

                                            foreach ($old->$property as $name => $diff) {
                                                unset($diff->result);
                                                $diff->type = array_merge($diff->type, $new->$property[$name]?->type ?? []);
                                                $diff->list = array_merge($diff->list, $new->$property[$name]?->list ?? []);
                                                $diff->hash = array_merge($diff->hash, $new->$property[$name]?->hash ?? []);
                                                $diff->object = array_merge($diff->object, $new->$property[$name]?->object ?? []);
                                            }
                                        }
                                    }
                                    if ($flag) {
                                        continue 2;
                                    }
                                }
                                $this->list[] = $new;
                            }
                            else {
                                $new = new self($v, ['nest' => $this->options['nest'] + 1] + $this->options);
                                if (is_object($var)) {
                                    $type = var_type($var, ['is_object' => fn() => false] + $this->options);
                                    if ($type !== 'object') {
                                        $this->type[] = $type;
                                    }
                                    $this->object[$k] = $new;
                                }
                                else {
                                    $this->hash[$k] = $new;
                                }
                            }
                        }
                    }
                    else {
                        $this->type[] = var_type($var, $this->options);
                    }
                }

                public function __toString(): string
                {
                    return $this->result ??= (function () {
                        $result = [];
                        if ($t = array_filter(array_map('strval', $this->type), 'strlen')) {
                            sort($t);
                            $result[] = $t ? implode('|', array_unique($t)) : "";
                        }
                        if ($t = array_filter(array_map('strval', $this->list), 'strlen')) {
                            sort($t);
                            $result[] = $t ? "array<" . implode('|', array_unique($t)) . ">" : "";
                        }
                        foreach (['hash', 'object'] as $property) {
                            if ($t = array_filter(array_map('strval', $this->$property), 'strlen')) {
                                $space = $this->options['format'] > 0 ? " " : "";
                                $break = $this->options['format'] > 1 ? "\n" : "";
                                $delim = $this->options['format'] > 1 ? $break : $space;
                                $indent = $this->options['format'] > 1 ? "  " : "";
                                $indent0 = $this->options['format'] > 1 ? str_repeat($indent, $this->options['nest'] + 0) : "";
                                $indent1 = $this->options['format'] > 1 ? str_repeat($indent, $this->options['nest'] + 1) : "";

                                ksort($t);
                                $keyvalues = array_map(function ($v, $k) use ($property, $indent1, $space) {
                                    if (!preg_match('#^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$#u', $k)) {
                                        $k = str_quote($k);
                                    }
                                    if ($this->$property[$k]->optional ?? false) {
                                        $k = "$k?";
                                    }
                                    return "{$indent1}$k:{$space}$v";
                                }, $t, array_keys($t));
                                $result[] = $t ? "{$this->shape}{{$break}" . implode(",{$delim}", $keyvalues) . "{$break}{$indent0}}" : "";
                            }
                        }
                        $result = array_filter($result, 'strlen');
                        return $result ? implode('|', $result) : $this->shape;
                    })();
                }

                /** @codeCoverageIgnore */
                public function __debugInfo(): ?array
                {
                    return [
                        'type'     => $this->type,
                        'list'     => $this->list,
                        'hash'     => $this->hash,
                        'object'   => $this->object,
                        'optional' => $this->optional,
                    ];
                }
            };
            //var_pretty($shape);
            return (string) $shape;
        }
    }
    if (is_object($var)) {
        if ($options['phpdoc']) {
            // クロージャだけはどうせ情報量がゼロなので特別扱いにする
            if ($var instanceof \Closure) {
                $space = $options['format'] > 0 ? " " : "";

                $ref = new \ReflectionFunction($var);
                $args = array_map(fn($p) => ($p->getType() ?? "mixed") . ($p->isVariadic() ? '...' : ''), $ref->getParameters());
                $return = ($ref->getReturnType() ?? 'mixed');
                $return = is_string($return) || $return instanceof \ReflectionNamedType ? $return : "($return)";
                return "\\Closure(" . implode(",$space", $args) . "):$space" . reflect_type_resolve($return);
            }

            $types = [];
            $ref = new \ReflectionObject($var);
            if ($ref->isAnonymous()) {
                $ifs = [];
                if ($pc = $ref->getParentClass()) {
                    $types[] = $pc->name;
                    $ifs = $pc->getInterfaceNames();
                }
                $types = array_merge($types, array_diff($ref->getInterfaceNames(), $ifs));
            }
            else {
                $types[] = get_class($var);
            }
            if (!$types) {
                return 'object';
            }
            return implode('|', array_map(fn($v) => "\\" . ltrim($v, '\\'), $types));
        }
        $ref = new \ReflectionObject($var);
        if ($ref->isAnonymous()) {
            if ($pc = $ref->getParentClass()) {
                return '\\' . $pc->name;
            }
            if ($is = $ref->getInterfaceNames()) {
                return '\\' . reset($is);
            }
        }
        return '\\' . get_class($var);
    }
    if (is_resourcable($var)) {
        return 'resource';
    }

    return get_debug_type($var);
}
