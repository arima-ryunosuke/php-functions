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
     * @param int $arity 引数の数
     * @return \Closure $callable を実行するクロージャ
     */
    public static function delegate($invoker, $callable, $arity = null)
    {
        // 「delegate 経由で作成されたクロージャ」であることをマーキングするための use 変数
        $__rfunc_delegate_marker = true;

        if ($arity === null) {
            $arity = (parameter_length)($callable, true, true);
        }

        if (is_infinite($arity)) {
            return eval('return function (...$_) use ($__rfunc_delegate_marker, $invoker, $callable) {
                return $invoker($callable, func_get_args());
            };');
        }

        $arity = abs($arity);
        switch ($arity) {
            case 0:
                return function () use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 1:
                return function ($_1) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 2:
                return function ($_1, $_2) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 3:
                return function ($_1, $_2, $_3) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 4:
                return function ($_1, $_2, $_3, $_4) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 5:
                return function ($_1, $_2, $_3, $_4, $_5) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            default:
                $argstring = (array_rmap)(range(1, $arity), strcat, '$_');
                return eval('return function (' . implode(', ', $argstring) . ') use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };');
        }
    }

    /**
     * $callable の指定位置に引数を束縛したクロージャを返す
     *
     * Example:
     * ```php
     * $bind = nbind('sprintf', 2, 'X');
     * assertSame($bind('%s%s%s', 'N', 'N'), 'NXN');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param int $n 挿入する引数位置
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    public static function nbind($callable, $n, ...$variadic)
    {
        return (delegate)(function ($callable, $args) use ($variadic, $n) {
            return $callable(...(array_insert)($args, $variadic, $n));
        }, $callable, (parameter_length)($callable, true) - count($variadic));
    }

    /**
     * $callable の最左に引数を束縛した callable を返す
     *
     * Example:
     * ```php
     * $bind = lbind('sprintf', '%s%s');
     * assertSame($bind('N', 'M'), 'NM');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
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
     * assertSame($bind('%s%s', 'N'), 'NX');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    public static function rbind($callable, ...$variadic)
    {
        return (nbind)(...(array_insert)(func_get_args(), null, 1));
    }

    /**
     * 合成関数を返す
     *
     * 基本的には callable を可変引数で呼び出せばそれらの合成関数を返す。
     * ただし $arrayalbe=true のときは若干挙動が異なり、連鎖のときに「前の返り値を**配列として**次の引数へ渡す」動作になる。
     * つまり、前の関数が `[1, 2, 3]` を返せば次の関数へは `f(1, 2, 3)` が渡る（ただしただの配列の場合のみ。連想配列は単値で渡る）。
     * $arrayalbe=false のときは渡る引数は常に単値（単値というか素直に渡すだけ）。
     * 上の例で言えば、前の関数が `[1, 2, 3]` を返せば次の関数へは `f($array=[1, 2, 3])` が渡る。
     *
     * $arrayalbe=true の方が利便性は高い。が、「本当にただの配列を渡したいとき」が判断できないので誤動作の原因にもなる。
     * e.g. `[1, 2, 3]` を配列として渡したいが $arrayalbe=true だと3つの引数として渡ってしまう
     *
     * いずれにせよ $arrayalbe は必須ではなく、第1引数が bool ならオプションだと判断し、そうでないなら true とみなす。
     *
     * Example:
     * ```php
     * $add5 = function ($v) { return $v + 5; };            // 来た値を +5 するクロージャ
     * $mul3 = function ($v) { return $v * 3; };            // 来た値を *3 するクロージャ
     * $split = function ($v) { return str_split($v); };    // 文字列的に桁分割するクロージャ
     * $union = function ($v) { return $v[0] + $v[1]; };    // 来た配列を足すクロージャ
     * $composite = composite(false, $add5, $mul3, $split, $union);// 上記を合成したクロージャ
     * // false を渡すと配列を考慮しない（つまり、単一の引数しか受け取れず、単一の返り値しか返せない）
     * // 7 + 5 -> 12 |> 12 * 3 -> 36 |> 36 -> [3, 6] |> 3 + 6 |> 9
     * assertSame($composite(7), 9);
     *
     * $upper = function ($s) { return [$s, strtoupper($s)]; };   // 来た値と大文字化したものを配列で返すクロージャ
     * $prefix = function ($s, $S) { return 'pre-' . $s . $S; };  // 来た値を結合して'pre-'を付けるクロージャ
     * $hash = function ($sS) { return ['sS' => $sS]; };          // 来た値を連想配列にするクロージャ
     * $key = function ($sSsS) { return strrev(reset($sSsS));};   // 来た配列の値をstrrevして返すクロージャ
     * $composite = composite(true, $upper, $prefix, $hash, $key);// 上記を合成したクロージャ
     * // true を渡すとただの配列は引数として、連想配列は単値として渡ってくる
     * // ['hoge', 'HOGE'] |> 'pre-hogeHOGE' |> ['sS' => 'pre-hogeHOGE'] |> 'EGOHegoh-erp'
     * assertSame($composite('hoge'), 'EGOHegoh-erp');
     * ```
     *
     * @param bool $arrayalbe 呼び出しチェーンを配列として扱うか
     * @param callable[] $variadic 合成する関数（可変引数）
     * @return \Closure 合成関数
     */
    public static function composite($arrayalbe = true, ...$variadic)
    {
        $callables = func_get_args();

        // モード引数が来てるなら捨てる
        if (!is_callable($arrayalbe)) {
            array_shift($callables);
        }
        // 来てないなら前方省略なのでデフォルト値を代入
        else {
            $arrayalbe = true;
        }

        if (empty($callables)) {
            throw new \InvalidArgumentException('too few arguments.');
        }

        $first = array_shift($callables);
        return (delegate)(function ($first, $args) use ($callables, $arrayalbe) {
            $result = $first(...$args);
            foreach ($callables as $callable) {
                // 「配列モードでただの配列」でないなら配列化
                if (!($arrayalbe && is_array($result) && !(is_hasharray)($result))) {
                    $result = [$result];
                }
                $result = $callable(...$result);
            }
            return $result;
        }, $first);
    }

    /**
     * $n 番目の引数（0 ベース）をそのまま返すクロージャを返す
     *
     * Example:
     * ```php
     * $arg0 = return_arg(0);
     * assertSame($arg0('hoge'), 'hoge');
     * $arg1 = return_arg(1);
     * assertSame($arg1('dummy', 'hoge'), 'hoge');
     * ```
     *
     * @param int $n $n 番目の引数
     * @return \Closure $n 番目の引数をそのまま返すクロージャ
     */
    public static function return_arg($n)
    {
        static $cache = [];
        if (!isset($cache[$n])) {
            $cache[$n] = function () use ($n) {
                return func_get_arg($n);
            };
        }
        return $cache[$n];
    }

    /**
     * 演算子のクロージャを返す
     *
     * 関数ベースなので `??` のような言語組み込みの特殊な演算子は若干希望通りにならない（Notice が出る）。
     *
     * Example:
     * ```php
     * $not = ope_func('!');    // 否定演算子クロージャ
     * assertSame(false, $not(true));
     *
     * $minus1 = ope_func('-', 1); // 負数演算子クロージャ（"-" 演算子は1項2項があるので明示する必要がある）
     * $minus2 = ope_func('-', 2); // 減算演算子クロージャ（"-" 演算子は1項2項があるので明示する必要がある）
     * assertSame(-2, $minus1(2));
     * assertSame(3 - 2, $minus2(3, 2));
     *
     * $cond2 = ope_func('?:', 2); // 条件演算子クロージャ（"?:" 演算子は2項3項があるので明示する必要がある）
     * $cond3 = ope_func('?:', 3); // 条件演算子クロージャ（"?:" 演算子は2項3項があるので明示する必要がある）
     * assertSame('OK' ?: 'NG', $cond2('OK', 'NG'));
     * assertSame(false ? 'OK' : 'NG', $cond3(false, 'OK', 'NG'));
     * ```
     *
     * @param string $operator 演算子
     * @param int $n 何項演算子か明示する引数
     * @return \Closure 演算子のクロージャ
     */
    public static function ope_func($operator, $n = null)
    {
        static $operators = null;
        $operators = $operators ?: [
            1 => [
                ''   => function ($v1) { return $v1; }, // こんな演算子はないが、「if ($value) {}」として使えることがある
                '!'  => function ($v1) { return !$v1; },
                '+'  => function ($v1) { return +$v1; },
                '-'  => function ($v1) { return -$v1; },
                '~'  => function ($v1) { return ~$v1; },
                '++' => function ($v1) { return ++$v1; },
                '--' => function ($v1) { return --$v1; },
            ],
            2 => [
                '?:'         => function ($v1, $v2) { return $v1 ?: $v2; },
                '??'         => function ($v1, $v2) { return $v1 ?? $v2; },
                '=='         => function ($v1, $v2) { return $v1 == $v2; },
                '==='        => function ($v1, $v2) { return $v1 === $v2; },
                '!='         => function ($v1, $v2) { return $v1 != $v2; },
                '<>'         => function ($v1, $v2) { return $v1 <> $v2; },
                '!=='        => function ($v1, $v2) { return $v1 !== $v2; },
                '<'          => function ($v1, $v2) { return $v1 < $v2; },
                '<='         => function ($v1, $v2) { return $v1 <= $v2; },
                '>'          => function ($v1, $v2) { return $v1 > $v2; },
                '>='         => function ($v1, $v2) { return $v1 >= $v2; },
                '<=>'        => function ($v1, $v2) { return $v1 <=> $v2; },
                '.'          => function ($v1, $v2) { return $v1 . $v2; },
                '+'          => function ($v1, $v2) { return $v1 + $v2; },
                '-'          => function ($v1, $v2) { return $v1 - $v2; },
                '*'          => function ($v1, $v2) { return $v1 * $v2; },
                '/'          => function ($v1, $v2) { return $v1 / $v2; },
                '%'          => function ($v1, $v2) { return $v1 % $v2; },
                '**'         => function ($v1, $v2) { return $v1 ** $v2; },
                '^'          => function ($v1, $v2) { return $v1 ^ $v2; },
                '&'          => function ($v1, $v2) { return $v1 & $v2; },
                '|'          => function ($v1, $v2) { return $v1 | $v2; },
                '<<'         => function ($v1, $v2) { return $v1 << $v2; },
                '>>'         => function ($v1, $v2) { return $v1 >> $v2; },
                '&&'         => function ($v1, $v2) { return $v1 && $v2; },
                '||'         => function ($v1, $v2) { return $v1 || $v2; },
                'or'         => function ($v1, $v2) { return $v1 or $v2; },
                'and'        => function ($v1, $v2) { return $v1 and $v2; },
                'xor'        => function ($v1, $v2) { return $v1 xor $v2; },
                'instanceof' => function ($v1, $v2) { return $v1 instanceof $v2; },
            ],
            3 => [
                '?:' => function ($v1, $v2, $v3) { return $v1 ? $v2 : $v3; },
            ],
        ];

        $operator = trim($operator);
        foreach ($operators as $kou => $ops) {
            if (($n === null || $n == $kou) && isset($ops[$operator])) {
                return $ops[$operator];
            }
        }

        throw new \InvalidArgumentException("$operator is not defined Operator.");
    }

    /**
     * 返り値の真偽値を逆転した新しいクロージャを返す
     *
     * Example:
     * ```php
     * $not_strlen = not_func('strlen');
     * assertFalse($not_strlen('hoge'));
     * assertTrue($not_strlen(''));
     * ```
     *
     * @param callable $callable 対象 callable
     * @return \Closure 新しいクロージャ
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
     * assertSame($evalfunc(1, 2, 3), 6);
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
     * assertInstanceof(\ReflectionFunction::class, reflect_callable('sprintf'));
     * assertInstanceof(\ReflectionMethod::class, reflect_callable('\Closure::bind'));
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
            list($class, $method) = explode('::', $call_name, 2);
            // for タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
            if (strpos($method, 'parent::') === 0) {
                list(, $method) = explode('::', $method);
                return (new \ReflectionClass($class))->getParentClass()->getMethod($method);
            }
            return new \ReflectionMethod($class, $method);
        }
    }

    /**
     * callable を Closure に変換する
     *
     * php7.1 の fromCallable みたいなもの。
     *
     * Example:
     * ```php
     * $sprintf = closurize('sprintf');
     * assertInstanceof(\Closure::class, $sprintf);
     * assertSame($sprintf('%s %s', 'hello', 'world'), 'hello world');
     * ```
     *
     * @param callable $callable 変換する callable
     * @return \Closure 変換したクロージャ
     */
    public static function closurize($callable)
    {
        if ($callable instanceof \Closure) {
            return $callable;
        }

        $ref = (reflect_callable)($callable);
        if ($ref instanceof \ReflectionMethod) {
            // for タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
            if (is_object($callable)) {
                return $ref->getClosure($callable);
            }
            if (is_array($callable)) {
                return $ref->getClosure($callable[0]);
            }
        }
        return $ref->getClosure();
    }

    /**
     * callable のコードブロックを返す
     *
     * 返り値は2値の配列。0番目の要素が定義部、1番目の要素が処理部を表す。
     *
     * Example:
     * ```php
     * list($meta, $body) = callable_code(function(...$args){return true;});
     * assertSame($meta, 'function(...$args)');
     * assertSame($body, '{return true;}');
     * ```
     *
     * @param callable $callable コードを取得する callable
     * @return array ['定義部分', '{処理コード}']
     */
    public static function callable_code($callable)
    {
        /** @var \ReflectionFunctionAbstract $ref */
        $ref = (reflect_callable)($callable);
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
     *     assertSame($ex->getMessage(), 'Undefined variable: v');
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
     * assertSame(ob_capture(function(){echo 123;}), '123');
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
     * assertTrue(is_bindable_closure(function(){}));
     * assertFalse(is_bindable_closure(static function(){}));
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
     * assertSame(count($counter), 1);
     * assertSame($counter->count(), 0);
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
     * callable の引数の数を返す
     *
     * クロージャはキャッシュされない。毎回リフレクションを生成し、引数の数を調べてそれを返す。
     * （クロージャには一意性がないので key-value なキャッシュが適用できない）。
     * ので、ループ内で使ったりすると目に見えてパフォーマンスが低下するので注意。
     *
     * Example:
     * ```php
     * // trim の引数は2つ
     * assertSame(parameter_length('trim'), 2);
     * // trim の必須引数は1つ
     * assertSame(parameter_length('trim', true), 1);
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
     * もちろん可変引数は未対応。
     *
     * $callback に null を与えると例外的に「第1引数を返すクロージャ」を返す。
     *
     * php の標準関数は定義数より多い引数を投げるとエラーを出すのでそれを抑制したい場合に使う。
     *
     * Example:
     * ```php
     * // strlen に2つの引数を渡してもエラーにならない
     * $strlen = func_user_func_array('strlen');
     * assertSame($strlen('abc', null), 3);
     * ```
     *
     * @param callable $callback 呼び出すクロージャ
     * @return \Closure 引数ぴったりで呼び出すクロージャ
     */
    public static function func_user_func_array($callback)
    {
        // null は第1引数を返す特殊仕様
        if ($callback === null) {
            return function ($v) { return $v; };
        }
        // クロージャはユーザ定義しかありえないので調べる必要がない
        if ($callback instanceof \Closure) {
            // が、組み込みをバイパスする delegate はクロージャなのでそれだけは除外
            $uses = (reflect_callable)($callback)->getStaticVariables();
            if (!isset($uses['__rfunc_delegate_marker'])) {
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
     * assertSame($hoge($object, 1, 2, 3), '1,2,3');
     *
     * // デフォルト値付きで hoge を呼び出すクロージャ
     * $hoge789 = func_method('hoge', 7, 8, 9);
     * // ↑を使用して $object の hoge を呼び出す（引数指定してるので結果は同じ）
     * assertSame($hoge789($object, 1, 2, 3), '1,2,3');
     * // 同上（一部デフォルト値）
     * assertSame($hoge789($object, 1, 2), '1,2,9');
     * // 同上（全部デフォルト値）
     * assertSame($hoge789($object), '7,8,9');
     * ```
     *
     * @param string $methodname メソッド名
     * @param array $defaultargs メソッドのデフォルト引数
     * @return \Closure メソッドを呼び出すクロージャ
     */
    public static function func_method($methodname, ...$defaultargs)
    {
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
     * assertSame(trim_alias(' abc '), 'abc');
     * ```
     *
     * @param callable $original 元となる関数
     * @param string $alias 関数のエイリアス名
     * @param string|bool $cachedir キャッシュパス。未指定/falseだとキャッシュされない。true だと一時ディレクトリに書き出す
     */
    public static function function_alias($original, $alias, $cachedir = false)
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
        $cachedir = (ifelse)($cachedir, true, sys_get_temp_dir());
        $cachefile = $cachedir ? $cachedir . '/' . rawurlencode($calllname . '-' . $alias) . '.php' : null;
        if ($cachefile && file_exists($cachefile)) {
            require $cachefile;
            return;
        }

        // 仮引数と実引数の構築
        $params = [];
        $args = [];
        foreach ($ref->getParameters() as $param) {
            $default = '';
            if ($param->isOptional()) {
                // 組み込み関数のデフォルト値を取得することは出来ない（isDefaultValueAvailable も false を返す）
                if ($param->isDefaultValueAvailable()) {
                    $defval = var_export($param->getDefaultValue(), true);
                }
                // 「オプショナルだけどデフォルト値がないって有り得るのか？」と思ったが、上記の通り組み込み関数だと普通に有り得るようだ
                // notice が出るので記述せざるを得ないがその値を得る術がない。が、どうせ与えられないので null でいい
                else {
                    $defval = 'null';
                }
                $default = ' = ' . $defval;
            }
            $varname = ($param->isPassedByReference() ? '&' : '') . '$' . $param->getName();
            $params[] = $varname . $default;
            $args[] = $varname;
        }

        $parts = explode('\\', ltrim($alias, '\\'));
        $reference = $ref->returnsReference() ? '&' : '';
        $funcname = $reference . array_pop($parts);
        $namespace = implode('\\', $parts);

        $params = implode(', ', $params);
        $args = implode(', ', $args);

        $code = <<<CODE
namespace $namespace {
    function $funcname($params) {
        \$return = $reference \\$calllname(...array_slice([$args] + func_get_args(), 0, func_num_args()));
        return \$return;
    }
}
CODE;

        eval($code);
        if ($cachefile) {
            file_put_contents($cachefile, "<?php\n" . $code);
        }
    }
}
