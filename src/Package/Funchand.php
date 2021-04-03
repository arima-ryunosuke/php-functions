<?php

namespace ryunosuke\Functions\Package;

/**
 * callable 関連のユーティリティ
 */
class Funchand
{
    /**
     * 指定 callable を指定クロージャで実行するクロージャを返す
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @param \Closure $invoker クロージャを実行するためのクロージャ（実処理）
     * @param callable $callable 最終的に実行したいクロージャ
     * @param ?int $arity 引数の数
     * @return callable $callable を実行するクロージャ
     */
    public static function delegate($invoker, $callable, $arity = null)
    {
        $arity = $arity ?? (parameter_length)($callable, true, true);

        if ((reflect_callable)($callable)->isInternal()) {
            static $cache = [];
            $cache[$arity] = $cache[$arity] ?? (evaluate)('return new class()
            {
                private $invoker, $callable;

                public function spawn($invoker, $callable)
                {
                    $that = clone($this);
                    $that->invoker = $invoker;
                    $that->callable = $callable;
                    return $that;
                }

                public function __invoke(' . implode(',', is_infinite($arity)
                        ? ['...$_']
                        : array_map(function ($v) { return '$_' . $v; }, array_keys(array_fill(1, $arity, null)))
                    ) . ')
                {
                    return ($this->invoker)($this->callable, func_get_args());
                }
            };');
            return $cache[$arity]->spawn($invoker, $callable);
        }

        switch (true) {
            case $arity === 0:
                return function () use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 1:
                return function ($_1) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 2:
                return function ($_1, $_2) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 3:
                return function ($_1, $_2, $_3) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 4:
                return function ($_1, $_2, $_3, $_4) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 5:
                return function ($_1, $_2, $_3, $_4, $_5) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case is_infinite($arity):
                return function (...$_) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            default:
                $args = implode(',', array_map(function ($v) { return '$_' . $v; }, array_keys(array_fill(1, $arity, null))));
                $stmt = 'return function (' . $args . ') use ($invoker, $callable) { return $invoker($callable, func_get_args()); };';
                return eval($stmt);
        }
    }

    /**
     * $callable の引数を指定配列で束縛したクロージャを返す
     *
     * Example:
     * ```php
     * $bind = abind('sprintf', [1 => 'a', 3 => 'c']);
     * that($bind('%s%s%s', 'b'))->isSame('abc');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param array $default_args 本来の引数
     * @return callable 束縛したクロージャ
     */
    public static function abind($callable, $default_args)
    {
        return (delegate)(function ($callable, $args) use ($default_args) {
            return $callable(...(array_fill_gap)($default_args, ...$args));
        }, $callable, (parameter_length)($callable, true, true) - count($default_args));
    }

    /**
     * $callable の指定位置に引数を束縛したクロージャを返す
     *
     * Example:
     * ```php
     * $bind = nbind('sprintf', 2, 'X');
     * that($bind('%s%s%s', 'N', 'N'))->isSame('NXN');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param int $n 挿入する引数位置
     * @param mixed $variadic 本来の引数（可変引数）
     * @return callable 束縛したクロージャ
     */
    public static function nbind($callable, $n, ...$variadic)
    {
        return (delegate)(function ($callable, $args) use ($variadic, $n) {
            return $callable(...(array_insert)($args, $variadic, $n));
        }, $callable, (parameter_length)($callable, true, true) - count($variadic));
    }

    /**
     * $callable の最左に引数を束縛した callable を返す
     *
     * Example:
     * ```php
     * $bind = lbind('sprintf', '%s%s');
     * that($bind('N', 'M'))->isSame('NM');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return callable 束縛したクロージャ
     */
    public static function lbind($callable, ...$variadic)
    {
        return (nbind)(...(array_insert)(func_get_args(), 0, 1));
    }

    /**
     * $callable の最右に引数を束縛した callable を返す
     *
     * Example:
     * ```php
     * $bind = rbind('sprintf', 'X');
     * that($bind('%s%s', 'N'))->isSame('NX');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return callable 束縛したクロージャ
     */
    public static function rbind($callable, ...$variadic)
    {
        return (nbind)(...(array_insert)(func_get_args(), null, 1));
    }

    /**
     * 演算子のクロージャを返す
     *
     * 関数ベースなので `??` のような言語組み込みの特殊な演算子は若干希望通りにならない（Notice が出る）。
     * 2つ目以降の引数でオペランドを指定できる。
     *
     * Example:
     * ```php
     * $not = ope_func('!');    // 否定演算子クロージャ
     * that(false)->isSame($not(true));
     *
     * $minus = ope_func('-'); // マイナス演算子クロージャ
     * that($minus(2))->isSame(-2);       // 引数1つで呼ぶと1項演算子
     * that($minus(3, 2))->isSame(3 - 2); // 引数2つで呼ぶと2項演算子
     *
     * $cond = ope_func('?:'); // 条件演算子クロージャ
     * that($cond('OK', 'NG'))->isSame('OK' ?: 'NG');               // 引数2つで呼ぶと2項演算子
     * that($cond(false, 'OK', 'NG'))->isSame(false ? 'OK' : 'NG'); // 引数3つで呼ぶと3項演算子
     *
     * $gt5 = ope_func('<=', 5); // 5以下を判定するクロージャ
     * that(array_filter([1, 2, 3, 4, 5, 6, 7, 8, 9], $gt5))->isSame([1, 2, 3, 4, 5]);
     * ```
     *
     * @param string $operator 演算子
     * @param mixed $operands 右オペランド
     * @return \Closure 演算子のクロージャ
     */
    public static function ope_func($operator, ...$operands)
    {
        static $operators = null;
        $operators = $operators ?: [
            ''           => static function ($v1) { return $v1; }, // こんな演算子はないが、「if ($value) {}」として使えることがある
            '!'          => static function ($v1) { return !$v1; },
            '+'          => static function ($v1, $v2 = null) { return func_num_args() === 1 ? (+$v1) : ($v1 + $v2); },
            '-'          => static function ($v1, $v2 = null) { return func_num_args() === 1 ? (-$v1) : ($v1 - $v2); },
            '~'          => static function ($v1) { return ~$v1; },
            '++'         => static function (&$v1) { return ++$v1; },
            '--'         => static function (&$v1) { return --$v1; },
            '?:'         => static function ($v1, $v2, $v3 = null) { return func_num_args() === 2 ? ($v1 ?: $v2) : ($v1 ? $v2 : $v3); },
            '??'         => static function ($v1, $v2) { return $v1 ?? $v2; },
            '=='         => static function ($v1, $v2) { return $v1 == $v2; },
            '==='        => static function ($v1, $v2) { return $v1 === $v2; },
            '!='         => static function ($v1, $v2) { return $v1 != $v2; },
            '<>'         => static function ($v1, $v2) { return $v1 <> $v2; },
            '!=='        => static function ($v1, $v2) { return $v1 !== $v2; },
            '<'          => static function ($v1, $v2) { return $v1 < $v2; },
            '<='         => static function ($v1, $v2) { return $v1 <= $v2; },
            '>'          => static function ($v1, $v2) { return $v1 > $v2; },
            '>='         => static function ($v1, $v2) { return $v1 >= $v2; },
            '<=>'        => static function ($v1, $v2) { return $v1 <=> $v2; },
            '.'          => static function ($v1, $v2) { return $v1 . $v2; },
            '*'          => static function ($v1, $v2) { return $v1 * $v2; },
            '/'          => static function ($v1, $v2) { return $v1 / $v2; },
            '%'          => static function ($v1, $v2) { return $v1 % $v2; },
            '**'         => static function ($v1, $v2) { return $v1 ** $v2; },
            '^'          => static function ($v1, $v2) { return $v1 ^ $v2; },
            '&'          => static function ($v1, $v2) { return $v1 & $v2; },
            '|'          => static function ($v1, $v2) { return $v1 | $v2; },
            '<<'         => static function ($v1, $v2) { return $v1 << $v2; },
            '>>'         => static function ($v1, $v2) { return $v1 >> $v2; },
            '&&'         => static function ($v1, $v2) { return $v1 && $v2; },
            '||'         => static function ($v1, $v2) { return $v1 || $v2; },
            'or'         => static function ($v1, $v2) { return $v1 or $v2; },
            'and'        => static function ($v1, $v2) { return $v1 and $v2; },
            'xor'        => static function ($v1, $v2) { return $v1 xor $v2; },
            'instanceof' => static function ($v1, $v2) { return $v1 instanceof $v2; },
        ];

        $opefunc = $operators[trim($operator)] ?? (throws)(new \InvalidArgumentException("$operator is not defined Operator."));

        if ($operands) {
            return static function ($v1) use ($opefunc, $operands) {
                return $opefunc($v1, ...$operands);
            };
        }

        return $opefunc;
    }

    /**
     * 返り値の真偽値を逆転した新しいクロージャを返す
     *
     * Example:
     * ```php
     * $not_strlen = not_func('strlen');
     * that($not_strlen('hoge'))->isFalse();
     * that($not_strlen(''))->isTrue();
     * ```
     *
     * @param callable $callable 対象 callable
     * @return callable 新しいクロージャ
     */
    public static function not_func($callable)
    {
        return (delegate)(function ($callable, $args) {
            return !$callable(...$args);
        }, $callable);
    }

    /**
     * 指定コードで eval するクロージャを返す
     *
     * create_function のクロージャ版みたいなもの。
     * 参照渡しは未対応。
     *
     * Example:
     * ```php
     * $evalfunc = eval_func('$a + $b + $c', 'a', 'b', 'c');
     * that($evalfunc(1, 2, 3))->isSame(6);
     * ```
     *
     * @param string $expression eval コード
     * @param mixed $variadic 引数名（可変引数）
     * @return \Closure 新しいクロージャ
     */
    public static function eval_func($expression, ...$variadic)
    {
        static $cache = [];
        $args = (array_sprintf)($variadic, '$%s', ',');
        $declare = "return function($args) { return $expression; };";
        if (!isset($cache[$declare])) {
            $cache[$declare] = eval($declare);
        }
        return $cache[$declare];
    }

    /**
     * callable から ReflectionFunctionAbstract を生成する
     *
     * Example:
     * ```php
     * that(reflect_callable('sprintf'))->isInstanceOf(\ReflectionFunction::class);
     * that(reflect_callable('\Closure::bind'))->isInstanceOf(\ReflectionMethod::class);
     * ```
     *
     * @param callable $callable 対象 callable
     * @return \ReflectionFunction|\ReflectionMethod リフレクションインスタンス
     */
    public static function reflect_callable($callable)
    {
        // callable チェック兼 $call_name 取得
        if (!is_callable($callable, true, $call_name)) {
            throw new \InvalidArgumentException("'$call_name' is not callable");
        }

        if ($callable instanceof \Closure || strpos($call_name, '::') === false) {
            return new \ReflectionFunction($callable);
        }
        else {
            [$class, $method] = explode('::', $call_name, 2);
            // for タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
            if (strpos($method, 'parent::') === 0) {
                [, $method] = explode('::', $method);
                return (new \ReflectionClass($class))->getParentClass()->getMethod($method);
            }
            return new \ReflectionMethod($class, $method);
        }
    }

    /**
     * callable のコードブロックを返す
     *
     * 返り値は2値の配列。0番目の要素が定義部、1番目の要素が処理部を表す。
     *
     * Example:
     * ```php
     * list($meta, $body) = callable_code(function(...$args){return true;});
     * that($meta)->isSame('function(...$args)');
     * that($body)->isSame('{return true;}');
     *
     * // ReflectionFunctionAbstract を渡しても動作する
     * list($meta, $body) = callable_code(new \ReflectionFunction(function(...$args){return true;}));
     * that($meta)->isSame('function(...$args)');
     * that($body)->isSame('{return true;}');
     * ```
     *
     * @param callable|\ReflectionFunctionAbstract $callable コードを取得する callable
     * @return array ['定義部分', '{処理コード}']
     */
    public static function callable_code($callable)
    {
        $ref = $callable instanceof \ReflectionFunctionAbstract ? $callable : (reflect_callable)($callable);
        $contents = file($ref->getFileName());
        $start = $ref->getStartLine();
        $end = $ref->getEndLine();
        $codeblock = implode('', array_slice($contents, $start - 1, $end - $start + 1));

        $meta = (parse_php)("<?php $codeblock", [
            'begin' => T_FUNCTION,
            'end'   => '{',
        ]);
        array_pop($meta);

        $body = (parse_php)("<?php $codeblock", [
            'begin'  => '{',
            'end'    => '}',
            'offset' => count($meta),
        ]);

        return [trim(implode('', array_column($meta, 1))), trim(implode('', array_column($body, 1)))];
    }

    /**
     * エラーを例外に変換するブロックでコールバックを実行する
     *
     * Example:
     * ```php
     * try {
     *     call_safely(function(){return $v;});
     * }
     * catch (\Exception $ex) {
     *     that($ex->getMessage())->isSame('Undefined variable: v');
     * }
     * ```
     *
     * @param callable $callback 実行するコールバック
     * @param mixed $variadic $callback に渡される引数（可変引数）
     * @return mixed $callback の返り値
     */
    public static function call_safely($callback, ...$variadic)
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (error_reporting() === 0) {
                return false;
            }
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            return $callback(...$variadic);
        }
        finally {
            restore_error_handler();
        }
    }

    /**
     * ob_start ～ ob_get_clean のブロックでコールバックを実行する
     *
     * Example:
     * ```php
     * // コールバック内のテキストが得られる
     * that(ob_capture(function(){echo 123;}))->isSame('123');
     * // こういう事もできる
     * that(ob_capture(function () {
     * ?>
     * bare string1
     * bare string2
     * <?php
     * }))->isSame("bare string1\nbare string2\n");
     * ```
     *
     * @param callable $callback 実行するコールバック
     * @param mixed $variadic $callback に渡される引数（可変引数）
     * @return string オフスリーンバッファの文字列
     */
    public static function ob_capture($callback, ...$variadic)
    {
        ob_start();
        try {
            $callback(...$variadic);
            return ob_get_contents();
        }
        finally {
            ob_end_clean();
        }
    }

    /**
     * $this を bind 可能なクロージャか調べる
     *
     * Example:
     * ```php
     * that(is_bindable_closure(function(){}))->isTrue();
     * that(is_bindable_closure(static function(){}))->isFalse();
     * ```
     *
     * @param \Closure $closure 調べるクロージャ
     * @return bool $this を bind 可能なクロージャなら true
     */
    public static function is_bindable_closure(\Closure $closure)
    {
        return !!@$closure->bindTo(new \stdClass());
    }

    /**
     * Countable#count, Serializable#serialize などの「ネイティブ由来かメソッド由来か」を判定して返す
     *
     * Countable#count, Serializable#serialize のように「インターフェースのメソッド名」と「ネイティブ関数名」が一致している必要がある。
     *
     * Example:
     * ```php
     * class CountClass implements \Countable
     * {
     *     public function count() {
     *         // count 経由なら 1 を、メソッド経由なら 0 を返す
     *         return (int) by_builtin($this, 'count');
     *     }
     * }
     * $counter = new CountClass();
     * that(count($counter))->isSame(1);
     * that($counter->count())->isSame(0);
     * ```
     *
     * のように判定できる。
     *
     * @param object|string $class
     * @param string $function
     * @return bool ネイティブなら true
     */
    public static function by_builtin($class, $function)
    {
        $class = is_object($class) ? get_class($class) : $class;

        // 特殊な方法でコールされる名前達(コールスタックの大文字小文字は正規化されるので気にする必要はない)
        $invoker = [
            'call_user_func'       => true,
            'call_user_func_array' => true,
            'invoke'               => true,
            'invokeArgs'           => true,
        ];

        $traces = array_reverse(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3));
        foreach ($traces as $trace) {
            if (isset($trace['class'], $trace['function']) && $trace['class'] === $class && $trace['function'] === $function) {
                // for $object->func()
                if (isset($trace['file'], $trace['line'])) {
                    return false;
                }
                // for call_user_func([$object, 'func']), (new ReflectionMethod($object, 'func'))->invoke($object)
                elseif (isset($last) && isset($last['function']) && isset($invoker[$last['function']])) {
                    return false;
                }
                // for func($object)
                elseif (isset($last) && isset($last['function']) && $last['function'] === $function) {
                    return true;
                }
            }
            $last = $trace;
        }
        throw new \RuntimeException('failed to search backtrace.');
    }

    /**
     * callable を名前付き引数で呼べるようにしたクロージャを返す
     *
     * callable のデフォルト引数は適用されるが、それ以外にも $default でデフォルト値を与えることができる（部分適用のようなものだと思えば良い）。
     * 最終的な優先順位は下記。上に行くほど優先。
     *
     * 1. 呼び出し時の引数
     * 2. この関数の $default 引数
     * 3. callable のデフォルト引数
     *
     * 引数は n 番目でも引数名でもどちらでも良い。
     * n 番目の場合は引数名に依存しないが、順番に依存してしまう。
     * 引数名の場合は順番に依存しないが、引数名に依存してしまう。
     *
     * 可変引数の場合は 1 と 2 がマージされる。
     * 必須引数が渡されていない or 定義されていない引数が渡された場合は例外を投げる。
     *
     * Example:
     * ```php
     * // ベースとなる関数（引数をそのまま連想配列で返す）
     * $f = function ($x, $a = 1, $b = 2, ...$other){return get_defined_vars();};
     *
     * // x に 'X', a に 9 を与えて名前付きで呼べるクロージャ
     * $f1 = namedcallize($f, [
     *     'x' => 'X',
     *     'a' => 9,
     * ]);
     * // 引数無しで呼ぶと↑で与えた引数が使用される（b は渡されていないのでデフォルト引数の 2 が使用される）
     * that($f1())->isSame([
     *     'x'     => 'X',
     *     'a'     => 9,
     *     'b'     => 2,
     *     'other' => [],
     * ]);
     * // 引数付きで呼ぶとそれが優先される
     * that($f1([
     *     'x'     => 'XXX',
     *     'a'     => 99,
     *     'b'     => 999,
     *     'other' => [1, 2, 3],
     * ]))->isSame([
     *     'x'     => 'XXX',
     *     'a'     => 99,
     *     'b'     => 999,
     *     'other' => [1, 2, 3],
     * ]);
     * // 引数名ではなく、 n 番目指定でも同じ
     * that($f1([
     *     'x' => 'XXX',
     *     1   => 99,
     *     2   => 999,
     *     3   => [1, 2, 3],
     * ]))->isSame([
     *     'x'     => 'XXX',
     *     'a'     => 99,
     *     'b'     => 999,
     *     'other' => [1, 2, 3],
     * ]);
     *
     * // x に 'X', other に [1, 2, 3] を与えて名前付きで呼べるクロージャ
     * $f2 = namedcallize($f, [
     *     'x'     => 'X',
     *     'other' => [1, 2, 3],
     * ]);
     * // other は可変引数なのでマージされる
     * that($f2(['other' => [4, 5, 6]]))->isSame([
     *     'x'     => 'X',
     *     'a'     => 1,
     *     'b'     => 2,
     *     'other' => [1, 2, 3, 4, 5, 6],
     * ]);
     * ```
     *
     * @param callable $callable
     * @param array $defaults デフォルト引数
     * @return \Closure 名前付き引数で呼べるようにしたクロージャ
     */
    public static function namedcallize($callable, $defaults = [])
    {
        // @formatter:off
        static $dummy_arg;
        $dummy_arg = $dummy_arg ?? new class{};
        $dummy_class = get_class($dummy_arg);
        // @formatter:on

        /** @var \ReflectionParameter[] $refparams */
        $refparams = (reflect_callable)($callable)->getParameters();

        $defargs = [];
        $argnames = [];
        $variadicname = null;
        foreach ($refparams as $n => $param) {
            $pname = $param->getName();

            $argnames[$n] = $pname;

            // 可変引数は貯めておく
            if ($param->isVariadic()) {
                $variadicname = $pname;
            }

            // ユーザ指定は最優先
            if (array_key_exists($pname, $defaults)) {
                $defargs[$pname] = $defaults[$pname];
            }
            elseif (array_key_exists($n, $defaults)) {
                $defargs[$pname] = $defaults[$n];
            }
            // デフォルト引数があるならそれを
            elseif ($param->isDefaultValueAvailable()) {
                $defargs[$pname] = $param->getDefaultValue();
            }
            // それ以外なら「指定されていない」ことを表すダミー引数を入れておく（あとでチェックに使う）
            else {
                $defargs[$pname] = $param->isVariadic() ? [] : $dummy_arg;
            }
        }

        return function ($params = []) use ($callable, $defargs, $argnames, $variadicname, $dummy_class) {
            $params = (array_map_key)($params, function ($k) use ($argnames) { return is_int($k) ? $argnames[$k] : $k; });
            $params = array_replace($defargs, $params);

            // 勝手に突っ込んだ $dummy_class がいるのはおかしい。指定されていないと思われる
            if ($dummyargs = array_filter($params, function ($v) use ($dummy_class) { return $v instanceof $dummy_class; })) {
                throw new \InvalidArgumentException('missing required arguments(' . implode(', ', array_keys($dummyargs)) . ').');
            }
            // diff って余りが出るのはおかしい。余計なものがあると思われる
            if ($diffargs = array_diff_key($params, $defargs)) {
                throw new \InvalidArgumentException('specified undefined arguments(' . implode(', ', array_keys($diffargs)) . ').');
            }

            // 可変引数はマージする
            if ($variadicname) {
                $params = array_merge($params, $defargs[$variadicname], $params[$variadicname]);
                unset($params[$variadicname]);
            }

            return $callable(...array_values($params));
        };
    }

    /**
     * callable の引数の数を返す
     *
     * クロージャはキャッシュされない。毎回リフレクションを生成し、引数の数を調べてそれを返す。
     * （クロージャには一意性がないので key-value なキャッシュが適用できない）。
     * ので、ループ内で使ったりすると目に見えてパフォーマンスが低下するので注意。
     *
     * Example:
     * ```php
     * // trim の引数は2つ
     * that(parameter_length('trim'))->isSame(2);
     * // trim の必須引数は1つ
     * that(parameter_length('trim', true))->isSame(1);
     * ```
     *
     * @param callable $callable 対象 callable
     * @param bool $require_only true を渡すと必須パラメータの数を返す
     * @param bool $thought_variadic 可変引数を考慮するか。 true を渡すと可変引数の場合に無限長を返す
     * @return int 引数の数
     */
    public static function parameter_length($callable, $require_only = false, $thought_variadic = false)
    {
        // クロージャの $call_name には一意性がないのでキャッシュできない（spl_object_hash でもいいが、かなり重複するので完全ではない）
        if ($callable instanceof \Closure) {
            /** @var \ReflectionFunctionAbstract $ref */
            $ref = (reflect_callable)($callable);
            if ($thought_variadic && $ref->isVariadic()) {
                return INF;
            }
            elseif ($require_only) {
                return $ref->getNumberOfRequiredParameters();
            }
            else {
                return $ref->getNumberOfParameters();
            }
        }

        // $call_name 取得
        is_callable($callable, false, $call_name);

        $cache = (cache)($call_name, function () use ($callable) {
            /** @var \ReflectionFunctionAbstract $ref */
            $ref = (reflect_callable)($callable);
            return [
                '00' => $ref->getNumberOfParameters(),
                '01' => $ref->isVariadic() ? INF : $ref->getNumberOfParameters(),
                '10' => $ref->getNumberOfRequiredParameters(),
                '11' => $ref->isVariadic() ? INF : $ref->getNumberOfRequiredParameters(),
            ];
        }, __FUNCTION__);
        return $cache[(int) $require_only . (int) $thought_variadic];
    }

    /**
     * callable のデフォルト引数を返す
     *
     * オプションで指定もできる。
     * 負数を指定した場合「最後の引数から数えた位置」になる。
     *
     * 内部関数には使用できない（リフレクションが対応していない）。
     *
     * Example:
     * ```php
     * $f = function ($a, $b = 'b') {};
     * // デフォルト引数である b を返す
     * that(parameter_default($f))->isSame([1 => 'b']);
     * // 引数で与えるとそれが優先される
     * that(parameter_default($f, ['A', 'B']))->isSame(['A', 'B']);
     * ```
     *
     * @param callable $callable 対象 callable
     * @param iterable|array $arguments デフォルト引数
     * @return array デフォルト引数
     */
    public static function parameter_default(callable $callable, $arguments = [])
    {
        static $cache = [];

        // $call_name でキャッシュ。しかしクロージャはすべて「Closure::__invoke」になるのでキャッシュできない
        is_callable($callable, true, $call_name);
        if (!isset($cache[$call_name]) || $callable instanceof \Closure) {
            /** @var \ReflectionFunctionAbstract $refunc */
            $refunc = (reflect_callable)($callable);
            assert($refunc->isUserDefined(), 'no support internal callable.');
            $cache[$call_name] = [
                'length'  => $refunc->getNumberOfParameters(),
                'default' => [],
            ];
            foreach ($refunc->getParameters() as $n => $param) {
                if ($param->isDefaultValueAvailable()) {
                    $cache[$call_name]['default'][$n] = $param->getDefaultValue();
                }
            }
        }

        // 指定されていないならそのまま返せば良い（高速化）
        if (is_array($arguments) && !$arguments) {
            return $cache[$call_name]['default'];
        }

        $args2 = [];
        foreach ($arguments as $n => $arg) {
            if ($n < 0) {
                $n += $cache[$call_name]['length'];
            }
            $args2[$n] = $arg;
        }

        return (array_merge2)($cache[$call_name]['default'], $args2);
    }

    /**
     * callable の引数の型情報に基づいてワイヤリングした引数配列を返す
     *
     * ワイヤリングは下記のルールに基づいて行われる。
     *
     * - 引数の型とキーが完全一致
     * - 引数の型とキーが継承・実装関係
     *   - 複数一致した場合は解決されない
     * - 引数名とキーが完全一致
     *   - 可変引数は追加
     * - 引数のデフォルト値
     * - 得られた値がクロージャの場合は再帰的に解決
     *   - $this は $dependency になるが FromCallable 経由の場合は元のまま
     *
     * Example:
     * ```php
     * $closure = function (\ArrayObject $ao, \Throwable $t, $array, $none, $default1, $default2 = 'default2', ...$misc) { return get_defined_vars(); };
     * $params = (parameter_wiring)($closure, [
     *     \ArrayObject::class      => $ao = new \ArrayObject([1, 2, 3]),
     *     \RuntimeException::class => $t = new \RuntimeException('hoge'),
     *     '$array'                 => function (\ArrayObject $ao) { return (array) $ao; },
     *     4                        => 'default1',
     *     '$misc'                  => ['x', 'y', 'z'],
     * ]);
     * that($params)->isSame([
     *     0 => $ao,        // 0番目はクラス名が完全一致
     *     1 => $t,         // 1番目はインターフェース実装
     *     2 => [1, 2, 3],  // 2番目はクロージャをコール
     *                      // 3番目は解決されない
     *     4 => 'default1', // 4番目は順番指定のデフォルト値
     *     5 => 'default2', // 5番目は引数定義のデフォルト値
     *     6 => 'x',        // 可変引数なのでフラットに展開
     *     7 => 'y',
     *     8 => 'z',
     * ]);
     * ```
     *
     * @param callable $callable 対象 callable
     * @param array|\ArrayAccess $dependency 引数候補配列
     * @return array 引数配列
     */
    public static function parameter_wiring($callable, $dependency)
    {
        /** @var \ReflectionFunctionAbstract $ref */
        $ref = (reflect_callable)($callable);
        $result = [];

        foreach ($ref->getParameters() as $n => $parameter) {
            if (isset($dependency[$n])) {
                $result[$n] = $dependency[$n];
            }
            elseif (isset($dependency[$pname = '$' . $parameter->getName()])) {
                if ($parameter->isVariadic()) {
                    foreach (array_values((arrayize)($dependency[$pname])) as $i => $v) {
                        $result[$n + $i] = $v;
                    }
                }
                else {
                    $result[$n] = $dependency[$pname];
                }
            }
            elseif (($type = $parameter->getType()) && $type instanceof \ReflectionNamedType) {
                if (isset($dependency[$type->getName()])) {
                    $result[$n] = $dependency[$type->getName()];
                }
                else {
                    foreach ($dependency as $key => $value) {
                        if (is_subclass_of(ltrim($key, '\\'), $type->getName(), true)) {
                            if (array_key_exists($n, $result)) {
                                unset($result[$n]);
                                break;
                            }
                            $result[$n] = $value;
                        }
                    }
                }
            }
            elseif ($parameter->isDefaultValueAvailable()) {
                $result[$n] = $parameter->getDefaultValue();
            }
        }

        // $this bind するのでオブジェクト化しておく
        if (!is_object($dependency)) {
            $dependency = new \ArrayObject($dependency);
        }

        // recurse for closure
        return array_map(function ($arg) use ($dependency) {
            if ($arg instanceof \Closure) {
                if ((new \ReflectionFunction($arg))->getShortName() === '{closure}') {
                    $arg = $arg->bindTo($dependency);
                }
                return $arg(...(parameter_wiring)($arg, $dependency));
            }
            return $arg;
        }, $result);
    }

    /**
     * 関数の名前空間部分を除いた短い名前を取得する
     *
     * @param string $function 短くする関数名
     * @return string 短い関数名
     */
    public static function function_shorten($function)
    {
        $parts = explode('\\', $function);
        return array_pop($parts);
    }

    /**
     * パラメータ定義数に応じて呼び出し引数を可変にしてコールする
     *
     * デフォルト引数はカウントされない。必須パラメータの数で呼び出す。
     *
     * $callback に null を与えると例外的に「第1引数を返すクロージャ」を返す。
     *
     * php の標準関数は定義数より多い引数を投げるとエラーを出すのでそれを抑制したい場合に使う。
     *
     * Example:
     * ```php
     * // strlen に2つの引数を渡してもエラーにならない
     * $strlen = func_user_func_array('strlen');
     * that($strlen('abc', null))->isSame(3);
     * ```
     *
     * @param callable $callback 呼び出すクロージャ
     * @return callable 引数ぴったりで呼び出すクロージャ
     */
    public static function func_user_func_array($callback)
    {
        // null は第1引数を返す特殊仕様
        if ($callback === null) {
            return function ($v) { return $v; };
        }
        // クロージャはユーザ定義しかありえないので調べる必要がない
        if ($callback instanceof \Closure) {
            // と思ったが、\Closure::fromCallable で作成されたクロージャは内部属性が伝播されるようなので除外
            if ((reflect_callable)($callback)->isUserDefined()) {
                return $callback;
            }
        }

        // 上記以外は「引数ぴったりで削ぎ落としてコールするクロージャ」を返す
        $plength = (parameter_length)($callback, true, true);
        return (delegate)(function ($callback, $args) use ($plength) {
            if (is_infinite($plength)) {
                return $callback(...$args);
            }
            return $callback(...array_slice($args, 0, $plength));
        }, $callback, $plength);
    }

    /**
     * 引数の型情報に基づいてワイヤリングしたクロージャを返す
     *
     * $dependency に数値キーの配列を混ぜるとデフォルト値として使用される。
     * 得られたクロージャの呼び出し時に引数を与える事ができる。
     *
     * parameter_wiring も参照。
     *
     * Example:
     * ```php
     * $closure = function ($a, $b) { return func_get_args(); };
     * $new_closure = func_wiring($closure, [
     *     '$a' => 'a',
     *     '$b' => 'b',
     *     1    => 'B',
     * ]);
     * that($new_closure())->isSame(['a', 'B']);    // 同時指定の場合は数値キー優先
     * that($new_closure('A'))->isSame(['A', 'B']); // 呼び出し時の引数優先
     * ```
     *
     * @param callable $callable 対象 callable
     * @param array|\ArrayAccess $dependency 引数候補配列
     * @return \Closure 引数を確定したクロージャ
     */
    public static function func_wiring($callable, $dependency)
    {
        $params = (parameter_wiring)($callable, $dependency);
        return function (...$args) use ($callable, $params) {
            return $callable(...$args + $params);
        };
    }

    /**
     * 指定クラスのコンストラクタを呼び出すクロージャを返す
     *
     * この関数を呼ぶとコンストラクタのクロージャを返す。
     *
     * オプションでデフォルト引数を設定できる（Example を参照）。
     *
     * Example:
     * ```php
     * // Exception のコンストラクタを呼ぶクロージャ
     * $newException = func_new(\Exception::class, 'hoge');
     * // デフォルト引数を使用して Exception を作成
     * that($newException()->getMessage())->isSame('hoge');
     * // 引数を指定して Exception を作成
     * that($newException('fuga')->getMessage())->isSame('fuga');
     * ```
     *
     * @param string $classname クラス名
     * @param array $defaultargs コンストラクタのデフォルト引数
     * @return \Closure コンストラクタを呼び出すクロージャ
     */
    public static function func_new($classname, ...$defaultargs)
    {
        return function (...$args) use ($classname, $defaultargs) {
            return new $classname(...$args + $defaultargs);
        };
    }

    /**
     * 指定メソッドを呼び出すクロージャを返す
     *
     * この関数を呼ぶとメソッドのクロージャを返す。
     * そのクロージャにオブジェクトを与えて呼び出すとそれはメソッド呼び出しとなる。
     *
     * オプションでデフォルト引数を設定できる（Example を参照）。
     *
     * Example:
     * ```php
     * // 与えられた引数を結合して返すメソッド hoge を持つクラス
     * $object = new class()
     * {
     *     function hoge(...$args) { return implode(',', $args); }
     * };
     * // hoge を呼び出すクロージャ
     * $hoge = func_method('hoge');
     * // ↑を使用して $object の hoge を呼び出す
     * that($hoge($object, 1, 2, 3))->isSame('1,2,3');
     *
     * // デフォルト値付きで hoge を呼び出すクロージャ
     * $hoge789 = func_method('hoge', 7, 8, 9);
     * // ↑を使用して $object の hoge を呼び出す（引数指定してるので結果は同じ）
     * that($hoge789($object, 1, 2, 3))->isSame('1,2,3');
     * // 同上（一部デフォルト値）
     * that($hoge789($object, 1, 2))->isSame('1,2,9');
     * // 同上（全部デフォルト値）
     * that($hoge789($object))->isSame('7,8,9');
     * ```
     *
     * @param string $methodname メソッド名
     * @param array $defaultargs メソッドのデフォルト引数
     * @return \Closure メソッドを呼び出すクロージャ
     */
    public static function func_method($methodname, ...$defaultargs)
    {
        if ($methodname === '__construct') {
            return function ($object, ...$args) use ($defaultargs) {
                return new $object(...$args + $defaultargs);
            };
        }
        return function ($object, ...$args) use ($methodname, $defaultargs) {
            return ([$object, $methodname])(...$args + $defaultargs);
        };
    }

    /**
     * 関数のエイリアスを作成する
     *
     * 単に移譲するだけではなく、参照渡し・参照返しも模倣される。
     * その代わり、単純なエイリアスではなく別定義で吐き出すので「エイリアス」ではなく「処理が同じな別関数」と思ったほうがよい。
     *
     * 静的であればクラスメソッドも呼べる。
     *
     * Example:
     * ```php
     * // trim のエイリアス
     * function_alias('trim', 'trim_alias');
     * that(trim_alias(' abc '))->isSame('abc');
     * ```
     *
     * @param callable $original 元となる関数
     * @param string $alias 関数のエイリアス名
     */
    public static function function_alias($original, $alias)
    {
        // クロージャとか __invoke とかは無理なので例外を投げる
        if (is_object($original)) {
            throw new \InvalidArgumentException('$original must not be object.');
        }
        // callname の取得と非静的のチェック
        is_callable($original, true, $calllname);
        $calllname = ltrim($calllname, '\\');
        $ref = (reflect_callable)($original);
        if ($ref instanceof \ReflectionMethod && !$ref->isStatic()) {
            throw new \InvalidArgumentException("$calllname is non-static method.");
        }
        // エイリアスが既に存在している
        if (function_exists($alias)) {
            throw new \InvalidArgumentException("$alias is already declared.");
        }

        // キャッシュ指定有りなら読み込むだけで eval しない
        $cachefile = (cachedir)() . '/' . rawurlencode(__FUNCTION__ . '-' . $calllname . '-' . $alias) . '.php';
        if (!file_exists($cachefile)) {
            $parts = explode('\\', ltrim($alias, '\\'));
            $reference = $ref->returnsReference() ? '&' : '';
            $funcname = $reference . array_pop($parts);
            $namespace = implode('\\', $parts);

            $params = (function_parameter)($ref);
            $prms = implode(', ', array_values($params));
            $args = implode(', ', array_keys($params));
            if ($ref->isInternal()) {
                $args = "array_slice([$args] + func_get_args(), 0, func_num_args())";
            }
            else {
                $args = "[$args]";
            }

            $code = <<<CODE
namespace $namespace {
    function $funcname($prms) {
        \$return = $reference \\$calllname(...$args);
        return \$return;
    }
}
CODE;
            file_put_contents($cachefile, "<?php\n" . $code);
        }
        require_once $cachefile;
    }

    /**
     * 関数/メソッドの引数定義を取得する
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @param \ReflectionFunctionAbstract|callable $eitherReffuncOrCallable 関数/メソッドリフレクション or callable
     * @return array [引数名 => 引数宣言] の配列
     */
    public static function function_parameter($eitherReffuncOrCallable)
    {
        $reffunc = $eitherReffuncOrCallable instanceof \ReflectionFunctionAbstract
            ? $eitherReffuncOrCallable
            : (reflect_callable)($eitherReffuncOrCallable);

        $result = [];
        foreach ($reffunc->getParameters() as $parameter) {
            $declare = '';

            if ($parameter->hasType()) {
                /** @var \ReflectionNamedType $type */
                $type = $parameter->getType();
                $declare .= ($type->allowsNull() ? '?' : '') . ($type->isBuiltin() ? '' : '\\') . $type->getName() . ' ';
            }

            $declare .= ($parameter->isPassedByReference() ? '&' : '') . '$' . $parameter->getName();

            if ($parameter->isVariadic()) {
                $declare = '...' . $declare;
            }
            elseif ($parameter->isOptional()) {
                // 組み込み関数のデフォルト値を取得することは出来ない（isDefaultValueAvailable も false を返す）
                if ($parameter->isDefaultValueAvailable()) {
                    // 修飾なしでデフォルト定数が使われているとその名前空間で解決してしまうので場合分けが必要
                    if ($parameter->isDefaultValueConstant() && strpos($parameter->getDefaultValueConstantName(), '\\') === false) {
                        $defval = $parameter->getDefaultValueConstantName();
                    }
                    else {
                        $defval = (var_export2)($parameter->getDefaultValue(), true);
                    }
                }
                // 「オプショナルだけどデフォルト値がないって有り得るのか？」と思ったが、上記の通り組み込み関数だと普通に有り得るようだ
                // notice が出るので記述せざるを得ないがその値を得る術がない。が、どうせ与えられないので null でいい
                else {
                    $defval = 'null';
                }
                $declare .= ' = ' . $defval;
            }

            $name = ($parameter->isPassedByReference() ? '&' : '') . '$' . $parameter->getName();
            $result[$name] = $declare;
        }

        return $result;
    }
}
