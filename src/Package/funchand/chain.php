<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_eval.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
require_once __DIR__ . '/../utility/function_configure.php';
require_once __DIR__ . '/../utility/function_resolve.php';
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * 関数をメソッドチェーンできるオブジェクトを返す
 *
 * ChainObject という関数をチェーンできるオブジェクトを返す。
 * ChainObject は大抵のグローバル関数がアノテーションされており、コード補完することが出来る（利便性のためであり、IDE がエラーなどを出しても呼び出し自体は可能）。
 * 呼び出しは「第1引数に現在の値が適用」されて実行される（下記の func[X] コールで任意の位置に適用されることもできる）。
 *
 * 下記の特殊ルールにより、特殊な呼び出し方ができる。
 *
 * - nullsafe 設定にすると「値が null の場合は呼び出し自体を行わない」という動作になり null をそのまま返す
 * - array_XXX, str_XXX は省略して XXX で呼び出せる
 *   - 省略した結果、他の関数と被る場合は可能な限り型で一致する呼び出しを行う
 * - func(..., _, ...) で _ で「値があたる位置」を明示できる
 *   - `str_replace('from', 'to', _)` のように呼び出せる
 * - func[1] で「引数1（0 ベースなので要は2番目）に適用して func を呼び出す」ことができる
 *   - func[2], func[3] 等も呼び出し可能
 * - func['E'] で eval される文字列のクロージャを呼べる
 *   - 引数名は `$1`, `$2` のような文字列で指定できる
 *   - `$X` が無いときに限り 最左に `$1` が自動付与される
 * - 引数が1つの呼び出しは () を省略できる
 *
 * この特殊ルールは普通に使う分にはそこまで気にしなくて良い。
 * map や filter を駆使しようとすると必要になるが、イテレーション目的ではなく文字列のチェインなどが目的であればほぼ使うことはない。
 *
 * 上記を含むメソッド呼び出しはすべて自分自身を返すので、最終結果を得たい場合は `invoke` を実行する必要がある。
 * ただし、 IteratorAggregate が実装されているので、配列の場合に限り foreach で直接回すことができる。
 * その他、 Stringable や Countable, JsonSerializable など「値が必要になりそうなインターフェース」が実装されている。
 *
 * 用途は配列のイテレーションを想定しているが、あくまで「チェイン可能にする」が目的なので、ソースが文字列だろうとオブジェクトだろうと何でも呼び出しが可能。
 * ただし、遅延評価も最適化も何もしていないので、 chain するだけでも動作は相当遅くなることに注意。
 *
 * Example:
 * ```php
 * # 1～9 のうち「5以下を抽出」して「値を2倍」して「合計」を出すシチュエーション
 * $n1_9 = range(1, 9);
 * // 素の php で処理したもの。パッと見で何してるか分からないし、処理の順番が思考と逆なので混乱する
 * that(array_sum(array_map(fn($v) => $v * 2, array_filter($n1_9, fn($v) => $v <= 5))))->isSame(30);
 * // chain でクロージャを渡したもの。処理の順番が思考どおりだが、 fn() が微妙にうざい（array_ は省略できるので filter, map, sum のような呼び出しができている）
 * that(chain($n1_9)->filter(fn($v) => $v <= 5)->maps(fn($v) => $v * 2)->sum()())->isSame(30);
 * // func['E'] を介したもの。かなり直感的だが eval なので少し不安
 * that(chain($n1_9)->filter['E']('<= 5')->maps['E']('* 2')->sum()())->isSame(30);
 *
 * # "hello   world" を「" " で分解」して「空文字を除去」してそれぞれに「ucfirst」して「"/" で結合」して「rot13」して「md5」して「大文字化」するシチュエーション
 * $string = 'hello   world';
 * // 素の php で処理したもの。もはやなにがなんだか分からない
 * that(strtoupper(md5(str_rot13(implode('/', array_map('ucfirst', array_filter(explode(' ', $string))))))))->isSame('10AF4DAF67D0D666FCEA0A8C6EF57EE7');
 * // chain だとかなりそれっぽくできる。 explode/implode の第1引数は区切り文字なので func[1] 構文を使用している。また、 rot13 以降は引数がないので () を省略している
 * that(chain($string)->explode[1](' ')->filter()->maps('ucfirst')->implode[1]('/')->rot13->md5->strtoupper()())->isSame('10AF4DAF67D0D666FCEA0A8C6EF57EE7');
 *
 *  # よくある DB レコードをあれこれするシチュエーション
 * $rows = [
 *     ['id' => 1, 'name' => 'hoge', 'sex' => 'F', 'age' => 17, 'salary' => 230000],
 *     ['id' => 3, 'name' => 'fuga', 'sex' => 'M', 'age' => 43, 'salary' => 480000],
 *     ['id' => 7, 'name' => 'piyo', 'sex' => 'M', 'age' => 21, 'salary' => 270000],
 *     ['id' => 9, 'name' => 'hage', 'sex' => 'F', 'age' => 30, 'salary' => 320000],
 * ];
 * // e.g. 男性の平均給料
 * that(chain($rows)->where['E']('sex', '=== "M"')->column('salary')->mean()())->isSame(375000);
 * // e.g. 女性の平均年齢
 * that(chain($rows)->where['E']('sex', '=== "F"')->column('age')->mean()())->isSame(23.5);
 * // e.g. 30歳以上の平均給料
 * that(chain($rows)->where['E']('age', '>= 30')->column('salary')->mean()())->isSame(400000);
 * // e.g. 20～30歳の平均給料
 * that(chain($rows)->where['E']('age', '>= 20')->where['E']('age', '<= 30')->column('salary')->mean()())->isSame(295000);
 * // e.g. 男性の最小年齢
 * that(chain($rows)->where['E']('sex', '=== "M"')->column('age')->min()())->isSame(21);
 * // e.g. 女性の最大給料
 * that(chain($rows)->where['E']('sex', '=== "F"')->column('salary')->max()())->isSame(320000);
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param mixed $source 元データ
 * @return \ChainObject
 */
function chain($source = null)
{
    if (function_configure('chain.version') === 2) {
        $chain_object = new class($source) implements \Countable, \ArrayAccess, \IteratorAggregate, \JsonSerializable {
            public static  $__CLASS__;
            private static $metadata = [];

            private $data;
            private $callback;

            public function __construct($source)
            {
                $this->data = $source;
            }

            public function __get($name)
            {
                $this->data = $this();

                $this->callback = $this->_resolve($name, $this->data);
                return $this;
            }

            public function __call($name, $arguments)
            {
                return $this->$name[0](...$arguments);
            }

            public function __invoke()
            {
                return $this[0]()->data;
            }

            public function __toString()
            {
                return (string) $this();
            }

            public function getIterator(): \Traversable
            {
                yield from $this();
            }

            public function count(): int
            {
                return count($this());
            }

            public function jsonSerialize(): mixed
            {
                return $this();
            }

            public function offsetGet($offset): callable
            {
                return function (...$arguments) use ($offset) {
                    if ($this->callback !== null) {
                        // E モード
                        if ($offset === 'E') {
                            $offset = 0;
                            $expr = array_pop($arguments);
                            $expr = preg_match('#\$\d+#u', $expr) ? $expr : '$1 ' . $expr;
                            $arguments[] = func_eval($expr, '_');
                        }

                        $this->data = $this->_apply($this->callback, $arguments, [$offset => $this->data]);
                        $this->callback = null;
                    }
                    return $this;
                };
            }

            public function apply($callback, ...$args)
            {
                $this->data = $callback($this->data, ...$args);
                return $this;
            }

            // @codeCoverageIgnoreStart

            public function offsetExists($offset): bool { throw new \LogicException(__METHOD__ . ' is not supported'); }

            public function offsetSet($offset, $value): void { throw new \LogicException(__METHOD__ . ' is not supported'); }

            public function offsetUnset($offset): void { throw new \LogicException(__METHOD__ . ' is not supported'); }

            // @codeCoverageIgnoreEnd

            private static function _resolve($name, $data)
            {
                $isiterable = is_iterable($data);
                $isstringable = is_stringable($data);
                if (false
                    || ($fname = function_resolve($name))
                    || ($isiterable && $fname = function_resolve("array_$name"))
                    || ($isstringable && $fname = function_resolve("str_$name"))
                ) {
                    return $fname;
                }

                throw new \BadFunctionCallException("function '$name' is not defined");
            }

            private static function _apply($callback, $arguments, $injections)
            {
                // 必要なメタデータを採取してキャッシュしておく
                $metadata = self::$metadata[$callback] ??= (function ($callback) {
                    $reffunc = reflect_callable($callback);
                    $parameters = $reffunc->getParameters();
                    $metadata = [
                        // 可変長パラメータを無限に返す generator（適切に break しないと無限ループしてしまうので 999 個までとしてある）
                        'parameters' => function () use ($parameters) {
                            foreach ($parameters as $parameter) {
                                if ($parameter->isVariadic()) {
                                    for ($i = 0; 999; $i++) {
                                        yield $parameter->getPosition() + $i => $parameter;
                                    }
                                    throw new \ArgumentCountError("parameter length is too long(>=$i)"); // @codeCoverageIgnore
                                }
                                yield $parameter->getPosition() => $parameter;
                            }
                        },
                        'variadic'   => $reffunc->isVariadic(),
                        'nullable'   => [],
                        'positions'  => [],
                        'names'      => [],
                    ];
                    foreach ($parameters as $parameter) {
                        $type = $parameter->getType();
                        $metadata['nullable'][$parameter->getPosition()] = $type ? $type->allowsNull() : null;
                        $metadata['positions'][$parameter->getPosition()] = $parameter->getName();
                        $metadata['names'][$parameter->getName()] = $parameter->getPosition();
                    }
                    return $metadata;
                })($callback);

                foreach ($injections as $position => $injection) {
                    // 可変じゃないのに位置引数 or 名前引数が存在しないチェック
                    if (false
                        || is_int($position) && !isset($metadata['positions'][$position]) && !$metadata['variadic']
                        || is_string($position) && !isset($metadata['names'][$position])
                    ) {
                        throw new \InvalidArgumentException("$callback(\$$position) does not exist");
                    }

                    // null セーフモード
                    if ($injection === null && function_configure('chain.nullsafe') && !($metadata['nullable'][$position] ?? false)) {
                        return null;
                    }
                }

                // プレースホルダモード
                if (($placeholder = function_configure('placeholder')) && $placeholders = array_keys($arguments, constant($placeholder), true)) {
                    $arguments = array_replace($arguments, array_fill_keys($placeholders, reset($injections)));
                    $injections = [];
                }

                $icount = count($injections);
                $realargs = [];
                foreach ($metadata['parameters']() as $pos => $parameter) {
                    $pos -= $icount - count($injections);
                    $nam = $parameter->getName();
                    $variadic = $parameter->isVariadic();

                    if (!$injections && !$arguments) {
                        break;
                    }
                    // inject argument
                    elseif (array_key_exists($i = $pos, $injections) || array_key_exists($i = $nam, $injections)) {
                        $realargs = array_merge($realargs, $variadic && is_array($injections[$i]) ? $injections[$i] : [$injections[$i]]);
                        unset($injections[$i]);
                    }
                    // named or positional argument
                    elseif (array_key_exists($i = $pos, $arguments) || array_key_exists($i = $nam, $arguments)) {
                        $realargs = array_merge($realargs, $variadic && is_array($arguments[$i]) ? $arguments[$i] : [$arguments[$i]]);
                        unset($arguments[$i]);
                    }
                }
                return $callback(...$realargs);
            }
        };
        $chain_object::$__CLASS__ = __CLASS__;
        return $chain_object;
    }
}
