<?php

namespace ryunosuke\Functions\Package;

/**
 * 構文関連のユーティリティ
 */
class Syntax
{
    /** parse_php 関数でトークン名変換をするか */
    const TOKEN_NAME = 2;

    /**
     * eval のプロキシ関数
     *
     * 一度ファイルに吐いてから require した方が opcache が効くので抜群に速い。
     * また、素の eval は ParseError が起こったときの表示がわかりにくすぎるので少し見やすくしてある。
     *
     * 関数化してる以上 eval におけるコンテキストの引き継ぎはできない。
     * ただし、引数で変数配列を渡せるようにしてあるので get_defined_vars を併用すれば基本的には同じ（$this はどうしようもない）。
     *
     * 短いステートメントだと opcode が少ないのでファイルを経由せず直接 eval したほうが速いことに留意。
     * 一応引数で指定できるようにはしてある。
     *
     * Example:
     * ```php
     * $a = 1;
     * $b = 2;
     * $phpcode = ';
     * $c = $a + $b;
     * return $c * 3;
     * ';
     * assertSame(evaluate($phpcode, get_defined_vars()), 9);
     * ```
     *
     * @param string $phpcode 実行する php コード
     * @param array $contextvars コンテキスト変数配列
     * @param int $cachesize キャッシュするサイズ
     * @return mixed eval の return 値
     */
    public static function evaluate($phpcode, $contextvars = [], $cachesize = 256)
    {
        $cachefile = null;
        if ($cachesize && strlen($phpcode) >= $cachesize) {
            $cachefile = (cachedir)() . '/' . rawurlencode(__FUNCTION__) . '-' . sha1($phpcode) . '.php';
            if (!file_exists($cachefile)) {
                file_put_contents($cachefile, "<?php $phpcode", LOCK_EX);
            }
        }

        try {
            if ($cachefile) {
                return (static function () {
                    extract(func_get_arg(1));
                    return require func_get_arg(0);
                })($cachefile, $contextvars);
            }
            else {
                return (static function () {
                    extract(func_get_arg(1));
                    return eval(func_get_arg(0));
                })($phpcode, $contextvars);
            }
        }
        catch (\ParseError $ex) {
            $errline = $ex->getLine();
            $errline_1 = $errline - 1;
            $codes = preg_split('#\\R#u', $phpcode);
            $codes[$errline_1] = '>>> ' . $codes[$errline_1];

            $N = 5; // 前後の行数
            $message = $ex->getMessage();
            $message .= "\n" . implode("\n", array_slice($codes, max(0, $errline_1 - $N), $N * 2 + 1));
            if ($cachefile) {
                $message .= "\n in " . realpath($cachefile) . " on line " . $errline . "\n";
            }
            throw new \ParseError($message, $ex->getCode(), $ex);
        }
    }

    /**
     * php のコード断片をパースする
     *
     * 結果配列は token_get_all したものだが、「字句の場合に文字列で返す」仕様は適用されずすべて配列で返す。
     * つまり必ず `[TOKENID, TOKEN, LINE]` で返す。
     *
     * Example:
     * ```php
     * $phpcode = 'namespace Hogera;
     * class Example
     * {
     *     // something
     * }';
     *
     * // namespace ～ ; を取得
     * $part = parse_php($phpcode, [
     *     'begin' => T_NAMESPACE,
     *     'end'   => ';',
     * ]);
     * assertSame(implode('', array_column($part, 1)), 'namespace Hogera;');
     *
     * // class ～ { を取得
     * $part = parse_php($phpcode, [
     *     'begin' => T_CLASS,
     *     'end'   => '{',
     * ]);
     * assertSame(implode('', array_column($part, 1)), "class Example\n{");
     * ```
     *
     * @param string $phpcode パースする php コード
     * @param array|int $option パースオプション
     * @return array トークン配列
     */
    public static function parse_php($phpcode, $option = [])
    {
        if (is_int($option)) {
            $option = ['flags' => $option];
        }

        $default = [
            'begin'      => [],   // 開始トークン
            'end'        => [],   // 終了トークン
            'offset'     => 0,    // 開始トークン位置
            'flags'      => 0,    // token_get_all の $flags. TOKEN_PARSE を与えると ParseError が出ることがあるのでデフォルト 0
            'cache'      => true, // キャッシュするか否か
            'nest_token' => [
                ')' => '(',
                '}' => '{',
                ']' => '[',
            ],
        ];
        $option += $default;

        static $cache = [];
        $tokens = $cache[$phpcode] ?? array_map(function ($token) use ($option) {
                // token_get_all の結果は微妙に扱いづらいので少し調整する（string/array だったり、名前変換の必要があったり）
                if (is_array($token)) {
                    // for debug
                    if ($option['flags'] & TOKEN_NAME) {
                        $token[] = token_name($token[0]);
                    }
                    return $token;
                }
                else {
                    // string -> [TOKEN, CHAR, LINE]
                    return [null, $token, 0];
                }
            }, token_get_all("<?php $phpcode", $option['flags']));
        if ($option['cache']) {
            $cache[$phpcode] = $tokens;
        }

        $begin_tokens = (array) $option['begin'];
        $end_tokens = (array) $option['end'];
        $nest_tokens = $option['nest_token'];

        $result = [];
        $starting = !$begin_tokens;
        $nesting = 0;
        for ($i = $option['offset'], $l = count($tokens); $i < $l; $i++) {
            $token = $tokens[$i];

            foreach ($begin_tokens as $t) {
                if ($t === $token[0] || $t === $token[1]) {
                    $starting = true;
                    break;
                }
            }
            if (!$starting) {
                continue;
            }

            $result[] = $token;

            foreach ($end_tokens as $t) {
                if (isset($nest_tokens[$t])) {
                    $nest_token = $nest_tokens[$t];
                    if ($token[0] === $nest_token || $token[1] === $nest_token) {
                        $nesting++;
                    }
                }
                if ($t === $token[0] || $t === $token[1]) {
                    $nesting--;
                    if ($nesting <= 0) {
                        break 2;
                    }
                    break;
                }
            }
        }
        return $result;
    }

    /**
     * オブジェクトならそれを、オブジェクトでないなら NullObject を返す
     *
     * null を返すかもしれないステートメントを一時変数を介さずワンステートメントで呼ぶことが可能になる。
     *
     * NullObject は 基本的に null を返すが、return type が規約されている場合は null 以外を返すこともある。
     * 取得系呼び出しを想定しているので、設定系呼び出しは行うべきではない。
     * __set のような明らかに設定が意図されているものは例外が飛ぶ。
     *
     * Example:
     * ```php
     * // null を返すかもしれないステートメント
     * $getobject = function () {return null;};
     * // メソッド呼び出しは null を返す
     * assertSame(optional($getobject())->method(), null);
     * // プロパティアクセスは null を返す
     * assertSame(optional($getobject())->property, null);
     * // empty は true を返す
     * assertSame(empty(optional($getobject())->nothing), true);
     * // __isset は false を返す
     * assertSame(isset(optional($getobject())->nothing), false);
     * // __toString は '' を返す
     * assertSame(strval(optional($getobject())), '');
     * // __invoke は null を返す
     * assertSame(call_user_func(optional($getobject())), null);
     * // 配列アクセスは null を返す
     * assertSame($getobject()['hoge'], null);
     * // 空イテレータを返す
     * assertSame(iterator_to_array(optional($getobject())), []);
     *
     * // $expected を与えるとその型以外は NullObject を返す（\ArrayObject はオブジェクトだが stdClass ではない）
     * assertSame(optional(new \ArrayObject([1]), 'stdClass')->count(), null);
     * ```
     *
     * @param object|null $object オブジェクト
     * @param string $expected 期待するクラス名。指定した場合は is_a される
     * @return mixed $object がオブジェクトならそのまま返し、違うなら NullObject を返す
     */
    public static function optional($object, $expected = null)
    {
        if (is_object($object)) {
            if ($expected === null || is_a($object, $expected)) {
                return $object;
            }
        }

        static $nullobject = null;
        if ($nullobject === null) {
            $nullobject = new class implements \ArrayAccess, \IteratorAggregate
            {
                // @formatter:off
                public function __isset($name) { return false; }
                public function __get($name) { return null; }
                public function __set($name, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __unset($name) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __call($name, $arguments) { return null; }
                public function __invoke() { return null; }
                public function __toString() { return ''; }
                public function offsetExists($offset) { return false; }
                public function offsetGet($offset) { return null; }
                public function offsetSet($offset, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function offsetUnset($offset) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function getIterator() { return new \ArrayIterator([]); }
                // @formatter:on
            };
        }
        return $nullobject;
    }

    /**
     * 関数をメソッドチェーンできるオブジェクトを返す
     *
     * ChainObject という関数をチェーンできるオブジェクトを返す。
     * ChainObject は大抵のグローバル関数がアノテーションされており、コード補完することが出来る（利便性のためであり、IDE がエラーなどを出しても呼び出し自体は可能）。
     * 呼び出しは「第1引数に現在の値が適用」されて実行される（下記の func1 コールで任意の位置に適用されることもできる）。
     *
     * 下記の特殊ルールにより、特殊な呼び出し方ができる。
     *
     * - array_XXX, str_XXX は省略して XXX で呼び出せる
     *   - 省略した結果、他の関数と被るようであれば短縮呼び出しは出来ない
     * - funcE で eval される文字列のクロージャを呼べる
     *   - 変数名は `$_` 固定だが、 `$_` が無いときに限り 最左に自動付与される
     * - funcP で配列指定オペレータのクロージャを呼べる
     *   - 複数指定した場合は順次呼ばれる。つまり map はともかく filter 用途では使えない
     * - func1 で「引数1（0 ベースなので要は2番目）に適用して func を呼び出す」ことができる
     *   - func2, func3 等も呼び出し可能
     * - 引数が1つの呼び出しは () を省略できる
     *
     * この特殊ルールは普通に使う分にはそこまで気にしなくて良い。
     * map や filter を駆使しようとすると必要になるが、イテレーション目的ではなく文字列のチェインなどが目的であればほぼ使うことはない。
     *
     * 特殊なメソッドとして下記がある。
     *
     * - apply($callback, ...$cbargs): 任意のコールバックを現在の値に適用する
     *
     * 上記を含むメソッド呼び出しはすべて自分自身を返すので、最終結果を得たい場合は `invoke` を実行する必要がある。
     * ただし、 IteratorAggregate が実装されているので、配列の場合に限り foreach で直接回すことができる。
     * さらに、 __toString も実装されているので、文字列的値の場合に限り自動で文字列化される。
     *
     * 用途は配列のイテレーションを想定しているが、あくまで「チェイン可能にする」が目的なので、ソースが文字列だろうとオブジェクトだろうと何でも呼び出しが可能。
     * ただし、遅延評価も最適化も何もしていないので、 chain するだけでも動作は相当遅くなることに注意。
     *
     * なお、最初の引数を省略するとスタックモードになり、一切の処理が適用されなくなる。
     * その代わり `invoke` で遅延的に値を渡すことができるようになる。
     * 「処理の流れだけ決めておいて後で適用する」イメージ。
     *
     * Example:
     * ```php
     * # 1～9 のうち「5以下を抽出」して「値を2倍」して「合計」を出すシチュエーション
     * $n1_9 = range(1, 9);
     * // 素の php で処理したもの。パッと見で何してるか分からないし、処理の順番が思考と逆なので混乱する
     * assertSame(array_sum(array_map(function ($v) { return $v * 2; }, array_filter($n1_9, function ($v) { return $v <= 5; }))), 30);
     * // chain でクロージャを渡したもの。処理の順番が思考どおりだが、 function(){} が微妙にうざい（array_ は省略できるので filter, map, sum のような呼び出しができている）
     * assertSame(chain($n1_9)->filter(function ($v) { return $v <= 5; })->map(function ($v) { return $v * 2; })->sum()(), 30);
     * // funcP を介して function(){} をなくしたもの。ここまで来ると若干読みやすい
     * assertSame(chain($n1_9)->filterP(['<=' => 5])->mapP(['*' => 2])->sum()(), 30);
     * // funcE を介したもの。かなり直感的だが eval なので少し不安
     * assertSame(chain($n1_9)->filterE('<= 5')->mapE('* 2')->sum()(), 30);
     *
     * # "hello   world" を「" " で分解」して「空文字を除去」してそれぞれに「ucfirst」して「"/" で結合」して「rot13」して「md5」して「大文字化」するシチュエーション
     * $string = 'hello   world';
     * // 素の php で処理したもの。もはやなにがなんだか分からない
     * assertSame(strtoupper(md5(str_rot13(implode('/', array_map('ucfirst', array_filter(explode(' ', $string))))))), '10AF4DAF67D0D666FCEA0A8C6EF57EE7');
     * // chain だとかなりそれっぽくできる。 explode/implode の第1引数は区切り文字なので func1 構文を使用している。また、 rot13 以降は引数がないので () を省略している
     * assertSame(chain($string)->explode1(' ')->filter()->map('ucfirst')->implode1('/')->rot13->md5->strtoupper()(), '10AF4DAF67D0D666FCEA0A8C6EF57EE7');
     *
     *  # よくある DB レコードをあれこれするシチュエーション
     * $rows = [
     *     ['id' => 1, 'name' => 'hoge', 'sex' => 'F', 'age' => 17, 'salary' => 230000],
     *     ['id' => 3, 'name' => 'fuga', 'sex' => 'M', 'age' => 43, 'salary' => 480000],
     *     ['id' => 7, 'name' => 'piyo', 'sex' => 'M', 'age' => 21, 'salary' => 270000],
     *     ['id' => 9, 'name' => 'hage', 'sex' => 'F', 'age' => 30, 'salary' => 320000],
     * ];
     * // e.g. 男性の平均給料
     * assertSame(chain($rows)->whereP('sex', ['===' => 'M'])->column('salary')->mean()(), 375000);
     * // e.g. 女性の平均年齢
     * assertSame(chain($rows)->whereE('sex', '=== "F"')->column('age')->mean()(), 23.5);
     * // e.g. 30歳以上の平均給料
     * assertSame(chain($rows)->whereP('age', ['>=' => 30])->column('salary')->mean()(), 400000);
     * // e.g. 20～30歳の平均給料
     * assertSame(chain($rows)->whereP('age', ['>=' => 20])->whereE('age', '<= 30')->column('salary')->mean()(), 295000);
     * // e.g. 男性の最小年齢
     * assertSame(chain($rows)->whereP('sex', ['===' => 'M'])->column('age')->min()(), 21);
     * // e.g. 女性の最大給料
     * assertSame(chain($rows)->whereE('sex', '=== "F"')->column('salary')->max()(), 320000);
     *
     * # 上記の引数遅延モード（結果は同じなのでいくつかピックアップ）
     * assertSame(chain()->whereP('sex', ['===' => 'M'])->column('salary')->mean()($rows), 375000);
     * assertSame(chain()->whereP('age', ['>=' => 30])->column('salary')->mean()($rows), 400000);
     * assertSame(chain()->whereP('sex', ['===' => 'M'])->column('age')->min()($rows), 21);
     * ```
     *
     * @param mixed $source 元データ
     * @return \ChainObject
     */
    public static function chain($source = null)
    {
        return new class(...func_get_args()) implements \IteratorAggregate
        {
            private $data;
            private $stack;

            public function __construct($source = null)
            {
                if (func_num_args() === 0) {
                    $this->stack = [];
                }
                $this->data = $source;
            }

            public function __invoke(...$source)
            {
                $func_num_args = func_num_args();

                if ($this->stack !== null && $func_num_args === 0) {
                    throw new \InvalidArgumentException('nonempty stack and no parameter given. maybe invalid __invoke args.');
                }
                if ($this->stack === null && $func_num_args > 0) {
                    throw new \UnexpectedValueException('empty stack and parameter given > 0. maybe invalid __invoke args.');
                }

                if ($func_num_args > 0) {
                    $result = [];
                    foreach ($source as $s) {
                        $chain = (chain)($s);
                        foreach ($this->stack as $stack) {
                            $chain->{$stack[0]}(...$stack[1]);
                        }
                        $result[] = $chain();
                    }
                    return $func_num_args === 1 ? reset($result) : $result;
                }
                return $this->data;
            }

            public function __get($name)
            {
                return $this->_apply($name, []);
            }

            public function __call($name, $arguments)
            {
                return $this->_apply($name, $arguments);
            }

            public function __toString()
            {
                return (string) $this->data;
            }

            public function getIterator()
            {
                foreach ($this->data as $k => $v) {
                    yield $k => $v;
                }
            }

            public function apply($callback, ...$args)
            {
                if (is_array($this->stack)) {
                    $this->stack[] = [__FUNCTION__, func_get_args()];
                    return $this;
                }

                $this->data = $callback($this->data, ...$args);
                return $this;
            }

            private function _resolve($name)
            {
                if (false
                    // for global
                    || function_exists($fname = $name)
                    || function_exists($fname = "array_$name")
                    || function_exists($fname = "str_$name")
                    // for package
                    || (defined($cname = $name) && is_callable($fname = constant($cname)))
                    || (defined($cname = "array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = "str_$name") && is_callable($fname = constant($cname)))
                    // for namespace
                    || (defined($cname = __NAMESPACE__ . "\\$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __NAMESPACE__ . "\\array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __NAMESPACE__ . "\\str_$name") && is_callable($fname = constant($cname)))
                    // for class
                    || (defined($cname = __CLASS__ . "::$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __CLASS__ . "::array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __CLASS__ . "::str_$name") && is_callable($fname = constant($cname)))
                ) {
                    /** @noinspection PhpUndefinedVariableInspection */
                    return $fname;
                }
            }

            private function _apply($name, $arguments)
            {
                if (is_array($this->stack)) {
                    $this->stack[] = [$name, $arguments];
                    return $this;
                }

                // 特別扱い1: map は非常によく呼ぶので引数を補正する
                if ($name === 'map') {
                    /** @noinspection PhpUndefinedMethodInspection */
                    return $this->array_map1(...$arguments);
                }

                // 実際の呼び出し1: 存在する関数はそのまま移譲する
                if ($fname = $this->_resolve($name)) {
                    $this->data = $fname($this->data, ...$arguments);
                    return $this;
                }
                // 実際の呼び出し2: 数値で終わる呼び出しは引数埋め込み位置を指定して移譲する
                if (preg_match('#(.+?)(\d+)$#', $name, $match) && $fname = $this->_resolve($match[1])) {
                    $this->data = $fname(...(array_insert)($arguments, [$this->data], $match[2]));
                    return $this;
                }

                // 接尾呼び出し1: E で終わる呼び出しは文字列を eval した callback とする
                if (preg_match('#(.+?)E$#', $name, $match)) {
                    $expr = array_pop($arguments);
                    $expr = strpos($expr, '$_') === false ? '$_ ' . $expr : $expr;
                    $arguments[] = (eval_func)($expr, '_');
                    return $this->{$match[1]}(...$arguments);
                }
                // 接尾呼び出し2: P で終わる呼び出しは演算子を callback とする
                if (preg_match('#(.+?)P$#', $name, $match)) {
                    $ops = array_reverse((array) array_pop($arguments));
                    $arguments[] = function ($v) use ($ops) {
                        foreach ($ops as $ope => $rand) {
                            if (is_int($ope)) {
                                $ope = $rand;
                                $rand = [];
                            }
                            if (!is_array($rand)) {
                                $rand = [$rand];
                            }
                            $v = (ope_func)($ope)($v, ...$rand);
                        }
                        return $v;
                    };
                    return $this->{$match[1]}(...$arguments);
                }

                throw new \BadFunctionCallException("$name is not defined.");
            }
        };
    }

    /**
     * throw の関数版
     *
     * hoge() or throw などしたいことがまれによくあるはず。
     *
     * Example:
     * ```php
     * try {
     *     throws(new \Exception('throws'));
     * }
     * catch (\Exception $ex) {
     *     assertSame($ex->getMessage(), 'throws');
     * }
     * ```
     *
     * @param \Exception $ex 投げる例外
     * @return mixed （`return hoge or throws` のようなコードで警告が出るので抑止用）
     */
    public static function throws($ex)
    {
        throw $ex;
    }

    /**
     * 条件付き throw
     *
     * 第1引数が true 相当のときに例外を投げる。
     *
     * Example:
     * ```php
     * // 投げない
     * throw_if(false, new \Exception());
     * // 投げる
     * try{throw_if(true, new \Exception());}catch(\Exception $ex){}
     * // クラス指定で投げる
     * try{throw_if(true, \Exception::class, 'message', 123);}catch(\Exception $ex){}
     * ```
     *
     * @param bool|mixed $flag true 相当値を与えると例外を投げる
     * @param \Exception|string $ex 投げる例外。クラス名の場合は中で new する
     * @param array $ex_args $ex にクラス名を与えたときの引数（可変引数）
     */
    public static function throw_if($flag, $ex, ...$ex_args)
    {
        if ($flag) {
            if (is_string($ex)) {
                $ex = new $ex(...$ex_args);
            }
            throw $ex;
        }
    }

    /**
     * 値が空なら null を返す
     *
     * `is_empty($value) ? $value : null` とほぼ同じ。
     * 言ってしまえば「falsy な値を null に変換する」とも言える。
     *
     * ここでいう falsy とは php 標準の `empty` ではなく本ライブラリの `is_empty` であることに留意（"0" は空ではない）。
     * さらに利便性のため 0, 0.0 も空ではない判定をする（strpos や array_search などで「0 は意味のある値」という事が多いので）。
     * 乱暴に言えば「仮に文字列化したとき、情報量がゼロ」が falsy になる。
     *
     * - 「 `$var ?: 'default'` で十分なんだけど "0" が…」
     * - 「 `$var ?? 'default'` で十分なんだけど false が…」
     *
     * という状況はまれによくあるはず。
     *
     * ?? との親和性のため null を返す動作がデフォルトだが、そのデフォルト値は引数で渡すこともできる。
     * 用途は Example を参照。
     *
     * Example:
     * ```php
     * // falsy な値は null を返すので null 合体演算子でデフォルト値が得られる
     * assertSame(blank_if(null) ?? 'default', 'default');
     * assertSame(blank_if('')   ?? 'default', 'default');
     * // falsy じゃない値の場合は引数をそのまま返すので null 合体演算子には反応しない
     * assertSame(blank_if(0)   ?? 'default', 0);   // 0 は空ではない
     * assertSame(blank_if('0') ?? 'default', '0'); // "0" は空ではない
     * assertSame(blank_if(1)   ?? 'default', 1);
     * assertSame(blank_if('X') ?? 'default', 'X');
     * // 第2引数で返る値を指定できるので下記も等価となる。ただし、php の仕様上第2引数が必ず評価されるため、関数呼び出しなどだと無駄な処理となる
     * assertSame(blank_if(null, 'default'), 'default');
     * assertSame(blank_if('',   'default'), 'default');
     * assertSame(blank_if(0,    'default'), 0);
     * assertSame(blank_if('0',  'default'), '0');
     * assertSame(blank_if(1,    'default'), 1);
     * assertSame(blank_if('X',  'default'), 'X');
     * // 第2引数の用途は少し短く書けることと演算子の優先順位のつらみの回避程度（`??` は結構優先順位が低い。下記を参照）
     * assertFalse(0 < blank_if(null) ?? 1);  // (0 < null) ?? 1 となるので false
     * assertTrue(0 < blank_if(null, 1));     // 0 < 1 となるので true
     * assertTrue(0 < (blank_if(null) ?? 1)); // ?? で同じことしたいならこのように括弧が必要
     *
     * # ここから下は既存言語機構との比較（愚痴っぽいので読まなくてもよい）
     *
     * // エルビス演算子は "0" にも反応するので正直言って使いづらい（php における falsy の定義は広すぎる）
     * assertSame(null ?: 'default', 'default');
     * assertSame(''   ?: 'default', 'default');
     * assertSame(1    ?: 'default', 1);
     * assertSame('0'  ?: 'default', 'default'); // こいつが反応してしまう
     * assertSame('X'  ?: 'default', 'X');
     * // 逆に null 合体演算子は null にしか反応しないので微妙に使い勝手が悪い（php の標準関数が false を返したりするし）
     * assertSame(null ?? 'default', 'default'); // こいつしか反応しない
     * assertSame(''   ?? 'default', '');
     * assertSame(1    ?? 'default', 1);
     * assertSame('0'  ?? 'default', '0');
     * assertSame('X'  ?? 'default', 'X');
     * // 恣意的な例だが、 substr は false も '0' も返し得るので ?: は使えない。 null を返すこともないので ?? も使えない（エラーも吐かない）
     * assertSame(substr('000', 1, 1) ?: 'default', 'default'); // '0' を返すので 'default' になる
     * assertSame(substr('xxx', 9, 1) ?: 'default', 'default'); // （文字数が足りなくて）false を返すので 'default' になる
     * assertSame(substr('000', 1, 1) ?? 'default', '0');   // substr が null を返すことはないので 'default' になることはない
     * assertSame(substr('xxx', 9, 1) ?? 'default', false); // substr が null を返すことはないので 'default' になることはない
     * // 要するに単に「false が返ってきた場合に 'default' としたい」だけなんだが、下記のようにめんどくさいことをせざるを得ない
     * assertSame(substr('xxx', 9, 1) === false ? 'default' : substr('xxx', 9, 1), 'default'); // 3項演算子で2回呼ぶ
     * assertSame(($tmp = substr('xxx', 9, 1) === false) ? 'default' : $tmp, 'default');       // 一時変数を使用する（あるいは if 文）
     * // このように書きたかった
     * assertSame(blank_if(substr('xxx', 9, 1)) ?? 'default', 'default'); // null 合体演算子版
     * assertSame(blank_if(substr('xxx', 9, 1), 'default'), 'default');   // 第2引数版
     *
     * // 恣意的な例その2。 0 は空ではないので array_search などにも応用できる（見つからない場合に false を返すので ?? はできないし、 false 相当を返し得るので ?: もできない）
     * assertSame(array_search('x', ['a', 'b', 'c']) ?? 'default', false);     // 見つからないので 'default' としたいが false になってしまう
     * assertSame(array_search('a', ['a', 'b', 'c']) ?: 'default', 'default'); // 見つかったのに 0 に反応するので 'default' になってしまう
     * assertSame(blank_if(array_search('x', ['a', 'b', 'c'])) ?? 'default', 'default'); // このように書きたかった
     * assertSame(blank_if(array_search('a', ['a', 'b', 'c'])) ?? 'default', 0);         // このように書きたかった
     * ```
     *
     * @param mixed $var 判定する値
     * @param mixed $default 空だった場合のデフォルト値
     * @return mixed 空なら $default, 空じゃないなら $var をそのまま返す
     */
    public static function blank_if($var, $default = null)
    {
        if (is_object($var)) {
            // 文字列化できるかが優先
            if ((is_stringable)($var)) {
                return strlen($var) ? $var : $default;
            }
            // 次点で countable
            if ((is_countable)($var)) {
                return count($var) ? $var : $default;
            }
            return $var;
        }

        // 0, 0.0, "0" は false
        if ($var === 0 || $var === 0.0 || $var === '0') {
            return $var;
        }

        // 上記以外は empty に任せる
        return empty($var) ? $default : $var;
    }

    /**
     * 条件を満たしたときにコールバックを実行する
     *
     * `if ($condition) $callable(...$arguments);` と（$condition はクロージャを受け入れるけど）ほぼ同じ。
     * ただし、 $condition に数値を与えると「指定回数呼ばれたあとに実行する」という意味になる。
     * 主に「ループ内でデバッグ出力したいけど、毎回だと少しうざい」というデバッグ用途。
     *
     * $condition が正数だと「指定回数呼ばれた次のみ」負数だと「指定回数呼ばれた次以降」実行される。
     * 0 のときは無条件で実行される。
     *
     * Example:
     * ```php
     * $output = [];
     * $debug_print = function ($debug) use (&$output) { $output[] = $debug; };
     * for ($i=0; $i<4; $i++) {
     *     call_if($i == 1, $debug_print, '$i == 1のとき呼ばれた');
     *     call_if(2, $debug_print, '2回呼ばれた');
     *     call_if(-2, $debug_print, '2回以上呼ばれた');
     * }
     * assertSame($output, [
     *     '$i == 1のとき呼ばれた',
     *     '2回呼ばれた',
     *     '2回以上呼ばれた',
     *     '2回以上呼ばれた',
     * ]);
     * ```
     *
     * @param mixed $condition 呼ばれる条件
     * @param callable $callable 呼ばれる処理
     * @param array $arguments $callable の引数（可変引数）
     * @return mixed 呼ばれた場合は $callable の返り値
     */
    public static function call_if($condition, $callable, ...$arguments)
    {
        // 数値の場合はかなり特殊な動きになる
        if (is_int($condition)) {
            static $counts = [];
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            $caller = $trace['file'] . '#' . $trace['line'];
            $counts[$caller] = $counts[$caller] ?? 0;
            if ($condition === 0) {
                $condition = true;
            }
            elseif ($condition > 0) {
                $condition = $condition === $counts[$caller]++;
            }
            else {
                $condition = -$condition <= $counts[$caller]++;
            }
        }
        elseif (is_callable($condition)) {
            $condition = ((func_user_func_array)($condition))();
        }

        if ($condition) {
            return $callable(...$arguments);
        }
        return null;
    }

    /**
     * switch 構文の関数版
     *
     * case にクロージャを与えると実行して返す。
     * つまり、クロージャを返すことは出来ないので注意。
     *
     * $default を与えないとマッチしなかったときに例外を投げる。
     *
     * Example:
     * ```php
     * $cases = [
     *     1 => 'value is 1',
     *     2 => function(){return 'value is 2';},
     * ];
     * assertSame(switchs(1, $cases), 'value is 1');
     * assertSame(switchs(2, $cases), 'value is 2');
     * assertSame(switchs(3, $cases, 'undefined'), 'undefined');
     * ```
     *
     * @param mixed $value 調べる値
     * @param array $cases case 配列
     * @param null $default マッチしなかったときのデフォルト値。指定しないと例外
     * @return mixed
     */
    public static function switchs($value, $cases, $default = null)
    {
        if (!array_key_exists($value, $cases)) {
            if (func_num_args() === 2) {
                throw new \OutOfBoundsException("value $value is not defined in " . json_encode(array_keys($cases)));
            }
            return $default;
        }

        $case = $cases[$value];
        if ($case instanceof \Closure) {
            return $case($value);
        }
        return $case;
    }

    /**
     * 例外を握りつぶす try 構文
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_null($try, 1, 2, 3), [1, 2, 3]);
     * // 例外が飛ぶ場合は null が返ってくる
     * $try = function(){throw new \Exception('tried');};
     * assertSame(try_null($try), null);
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら null
     */
    public static function try_null($try, ...$variadic)
    {
        try {
            return $try(...$variadic);
        }
        catch (\Exception $tried_ex) {
            return null;
        }
    }

    /**
     * try ～ catch 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_catch($try, null, 1, 2, 3), [1, 2, 3]);
     * // 例外が飛ぶ場合は特殊なことをしなければ例外オブジェクトが返ってくる
     * $try = function(){throw new \Exception('tried');};
     * assertSame(try_catch($try)->getMessage(), 'tried');
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    public static function try_catch($try, $catch = null, ...$variadic)
    {
        return (try_catch_finally)($try, $catch, null, ...$variadic);
    }

    /**
     * try ～ finally 構文の関数版
     *
     * 例外は投げっぱなす。例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $finally_count = 0;
     * $finally = function()use(&$finally_count){$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_finally($try, $finally, 1, 2, 3), [1, 2, 3]);
     * assertSame($finally_count, 1); // 呼ばれている
     * // 例外は投げっぱなすが、 $finally は実行される
     * $try = function(){throw new \Exception('tried');};
     * try {try_finally($try, $finally, 1, 2, 3);} catch(\Exception $e){};
     * assertSame($finally_count, 2); // 呼ばれている
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    public static function try_finally($try, $finally = null, ...$variadic)
    {
        return (try_catch_finally)($try, throws, $finally, ...$variadic);
    }

    /**
     * try ～ catch ～ finally 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $finally_count = 0;
     * $finally = function()use(&$finally_count){$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_catch_finally($try, null, $finally, 1, 2, 3), [1, 2, 3]);
     * assertSame($finally_count, 1); // 呼ばれている
     * // 例外を投げるが、 $catch で握りつぶす
     * $try = function(){throw new \Exception('tried');};
     * assertSame(try_catch_finally($try, null, $finally, 1, 2, 3)->getMessage(), 'tried');
     * assertSame($finally_count, 2); // 呼ばれている
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @param callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    public static function try_catch_finally($try, $catch = null, $finally = null, ...$variadic)
    {
        if ($catch === null) {
            $catch = function ($v) { return $v; };
        }

        try {
            return $try(...$variadic);
        }
        catch (\Exception $tried_ex) {
            try {
                return $catch($tried_ex);
            }
            catch (\Exception $catched_ex) {
                throw $catched_ex;
            }
        }
        finally {
            if ($finally !== null) {
                $finally();
            }
        }
    }
}
