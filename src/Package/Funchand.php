<?php

namespace ryunosuke\Functions\Package;

class Funchand
{
    /**
     * 指定 callable を指定クロージャで実行するクロージャを返す
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @package Callable
     *
     * @param \Closure $invoker クロージャを実行するためのクロージャ（実処理）
     * @param callable $callable 最終的に実行したいクロージャ
     * @param int $arity 引数の数
     * @return \Closure $callable を実行するクロージャ
     */
    public static function delegate($invoker, $callable, $arity = null)
    {
        if ($arity === null) {
            $arity = call_user_func(parameter_length, $callable, true);
        }
        $arity = $arity < 0 ? 0 : $arity;

        switch ($arity) {
            case 0:
                return function () use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 1:
                return function ($_1) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 2:
                return function ($_1, $_2) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 3:
                return function ($_1, $_2, $_3) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 4:
                return function ($_1, $_2, $_3, $_4) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 5:
                return function ($_1, $_2, $_3, $_4, $_5) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            default:
                $argstring = call_user_func(array_rmap, range(1, $arity), strcat, '$_');
                return eval('return function (' . implode(', ', $argstring) . ') use ($invoker, $callable) {
                return $invoker($callable, func_get_args());
            };');
        }
    }

    /** @noinspection PhpDocSignatureInspection */
    /**
     * $callable の指定位置に引数を束縛したクロージャを返す
     *
     * Example:
     * <code>
     * $bind = nbind('sprintf', 2, 'X');
     * assert($bind('%s%s%s', 'N', 'N') === 'NXN');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @param int $n 挿入する引数位置
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    public static function nbind($callable, $n)
    {
        $binded = array_slice(func_get_args(), 2);
        return call_user_func(delegate, function ($callable, $args) use ($binded, $n) {
            return call_user_func_array($callable, call_user_func(array_insert, $args, $binded, $n));
        }, $callable, call_user_func(parameter_length, $callable, true) - count($binded));
    }

    /** @noinspection PhpDocSignatureInspection */
    /**
     * $callable の最左に引数を束縛した callable を返す
     *
     * Example:
     * <code>
     * $bind = lbind('sprintf', '%s%s');
     * assert($bind('N', 'M') === 'NM');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    public static function lbind($callable)
    {
        return call_user_func_array(nbind, call_user_func(array_insert, func_get_args(), 0, 1));
    }

    /** @noinspection PhpDocSignatureInspection */
    /**
     * $callable の最右に引数を束縛した callable を返す
     *
     * Example:
     * <code>
     * $bind = rbind('sprintf', 'X');
     * assert($bind('%s%s', 'N') === 'NX');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    public static function rbind($callable)
    {
        return call_user_func_array(nbind, call_user_func(array_insert, func_get_args(), null, 1));
    }

    /** @noinspection PhpDocSignatureInspection */
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
     * <code>
     * $add5 = function ($v) { return $v + 5; };            // 来た値を +5 するクロージャ
     * $mul3 = function ($v) { return $v * 3; };            // 来た値を *3 するクロージャ
     * $split = function ($v) { return str_split($v); };    // 文字列的に桁分割するクロージャ
     * $union = function ($v) { return $v[0] + $v[1]; };    // 来た配列を足すクロージャ
     * $composite = composite(false, $add5, $mul3, $split, $union);// 上記を合成したクロージャ
     * // false を渡すと配列を考慮しない（つまり、単一の引数しか受け取れず、単一の返り値しか返せない）
     * // 7 + 5 -> 12 |> 12 * 3 -> 36 |> 36 -> [3, 6] |> 3 + 6 |> 9
     * assert($composite(7) === 9);
     *
     * $upper = function ($s) { return [$s, strtoupper($s)]; };   // 来た値と大文字化したものを配列で返すクロージャ
     * $prefix = function ($s, $S) { return 'pre-' . $s . $S; };  // 来た値を結合して'pre-'を付けるクロージャ
     * $hash = function ($sS) { return ['sS' => $sS]; };          // 来た値を連想配列にするクロージャ
     * $key = function ($sSsS) { return strrev(reset($sSsS));};   // 来た配列の値をstrrevして返すクロージャ
     * $composite = composite(true, $upper, $prefix, $hash, $key);// 上記を合成したクロージャ
     * // true を渡すとただの配列は引数として、連想配列は単値として渡ってくる
     * // ['hoge', 'HOGE'] |> 'pre-hogeHOGE' |> ['sS' => 'pre-hogeHOGE'] |> 'EGOHegoh-erp'
     * assert($composite('hoge') === 'EGOHegoh-erp');
     * </code>
     *
     * @package Callable
     *
     * @param bool $arrayalbe 呼び出しチェーンを配列として扱うか
     * @param callable[] $variadic 合成する関数（可変引数）
     * @return \Closure 合成関数
     */
    public static function composite($arrayalbe = true)
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
        return call_user_func(delegate, function ($first, $args) use ($callables, $arrayalbe) {
            $result = call_user_func_array($first, $args);
            foreach ($callables as $callable) {
                // 「配列モードでただの配列」でないなら配列化
                if (!($arrayalbe && is_array($result) && !call_user_func(is_hasharray, $result))) {
                    $result = [$result];
                }
                $result = call_user_func_array($callable, $result);
            }
            return $result;
        }, $first);
    }

    /**
     * $n 番目の引数（0 ベース）をそのまま返すクロージャを返す
     *
     * Example:
     * <code>
     * $arg0 = return_arg(0);
     * assert($arg0('hoge')          === 'hoge');
     * $arg1 = return_arg(1);
     * assert($arg1('dummy', 'hoge') === 'hoge');
     * </code>
     *
     * @package Callable
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
     * 返り値の真偽値を逆転した新しいクロージャを返す
     *
     * Example:
     * <code>
     * $not_strlen = not_func('strlen');
     * assert($not_strlen('hoge') === false);
     * assert($not_strlen('')     === true);
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @return \Closure 新しいクロージャ
     */
    public static function not_func($callable)
    {
        return call_user_func(delegate, function ($callable, $args) {
            return !call_user_func_array($callable, $args);
        }, $callable);
    }

    /** @noinspection PhpDocSignatureInspection */
    /**
     * 指定コードで eval するクロージャを返す
     *
     * create_function のクロージャ版みたいなもの。
     * 参照渡しは未対応。
     *
     * Example:
     * <code>
     * $evalfunc = eval_func('$a + $b + $c', 'a', 'b', 'c');
     * assert($evalfunc(1, 2, 3) === 6);
     * </code>
     *
     * @package Callable
     *
     * @param string $expression eval コード
     * @param mixed $variadic 引数名（可変引数）
     * @return \Closure 新しいクロージャ
     */
    public static function eval_func($expression)
    {
        $eargs = array_slice(func_get_args(), 1);
        return call_user_func(delegate, function ($expression, $args) use ($eargs) {
            return call_user_func(function () {
                extract(func_get_arg(1));
                return eval("return " . func_get_arg(0) . ";");
            }, $expression, array_combine($eargs, $args));
        }, $expression, count($eargs));
    }

    /**
     * callable から ReflectionFunctionAbstract を生成する
     *
     * Example:
     * <code>
     * assert(reflect_callable('sprintf')        instanceof \ReflectionFunction);
     * assert(reflect_callable('\Closure::bind') instanceof \ReflectionMethod);
     * </code>
     *
     * @package Callable
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
     * <code>
     * $sprintf = closurize('sprintf');
     * assert($sprintf                            instanceof \Closure);
     * assert($sprintf('%s %s', 'hello', 'world') ===        'hello world');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 変換する callable
     * @return \Closure 変換したクロージャ
     */
    public static function closurize($callable)
    {
        if ($callable instanceof \Closure) {
            return $callable;
        }

        $ref = call_user_func(reflect_callable, $callable);
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

    /** @noinspection PhpDocSignatureInspection */
    /**
     * エラーを例外に変換するブロックでコールバックを実行する
     *
     * Example:
     * <code>
     * try {
     *     call_safely(function(){return $v;});
     * }
     * catch (\Exception $ex) {
     *     assert($ex->getMessage() === 'Undefined variable: v');
     * }
     * </code>
     *
     * @package Callable
     *
     * @param callable $callback 実行するコールバック
     * @param mixed $variadic $callback に渡される引数（可変引数）
     * @return mixed $callback の返り値
     */
    public static function call_safely($callback)
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (error_reporting() === 0) {
                return false;
            }
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            $return = call_user_func_array($callback, array_slice(func_get_args(), 1));
            restore_error_handler();
            return $return;
        }
        catch (\Exception $ex) {
            restore_error_handler();
            throw $ex;
        }
    }

    /** @noinspection PhpDocSignatureInspection */
    /**
     * ob_start ～ ob_get_clean のブロックでコールバックを実行する
     *
     * Example:
     * <code>
     * assert(ob_capture(function(){echo 123;}) === '123');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callback 実行するコールバック
     * @param mixed $variadic $callback に渡される引数（可変引数）
     * @return string オフスリーンバッファの文字列
     */
    public static function ob_capture($callback)
    {
        ob_start();
        try {
            call_user_func_array($callback, array_slice(func_get_args(), 1));
            return ob_get_clean();
        }
        catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }
    }

    /**
     * callable の引数の数を返す
     *
     * クロージャはキャッシュされない。毎回リフレクションを生成し、引数の数を調べてそれを返す。
     * （クロージャには一意性がないので key-value なキャッシュが適用できない）。
     * ので、ループ内で使ったりすると目に見えてパフォーマンスが低下するので注意。
     *
     * Example:
     * <code>
     * // trim の引数は2つ
     * assert(parameter_length('trim')       === 2);
     * // trim の必須引数は1つ
     * assert(parameter_length('trim', true) === 1);
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @param bool $require_only true を渡すと必須パラメータの数を返す
     * @return int 引数の数
     */
    public static function parameter_length($callable, $require_only = false)
    {
        // クロージャの $call_name には一意性がないのでキャッシュできない（spl_object_hash でもいいが、かなり重複するので完全ではない）
        if ($callable instanceof \Closure) {
            $ref = call_user_func(reflect_callable, $callable);
            return $require_only ? $ref->getNumberOfRequiredParameters() : $ref->getNumberOfParameters();
        }

        // $call_name 取得
        is_callable($callable, false, $call_name);

        $cache = call_user_func(cache, $call_name, function () use ($callable) {
            $ref = call_user_func(reflect_callable, $callable);
            return [
                false => $ref->getNumberOfParameters(),
                true  => $ref->getNumberOfRequiredParameters(),
            ];
        }, __FUNCTION__);
        return $cache[$require_only];
    }

    /**
     * 関数の名前空間部分を除いた短い名前を取得する
     *
     * @package Callable
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
     * <code>
     * // strlen に2つの引数を渡してもエラーにならない
     * $strlen = func_user_func_array('strlen');
     * assert($strlen('abc', null)       === 3);
     * </code>
     *
     * @package Callable
     *
     * @param callable $callback 呼び出すクロージャ
     * @return \Closure 引数ぴったりで呼び出すクロージャ
     */
    public static function func_user_func_array($callback)
    {
        if ($callback === null) {
            return function ($v) { return $v; };
        }
        $plength = call_user_func(parameter_length, $callback, true);
        return call_user_func(delegate, function ($callback, $args) use ($plength) {
            return call_user_func_array($callback, array_slice($args, 0, $plength));
        }, $callback, $plength);
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
     * <code>
     * // trim のエイリアス
     * function_alias('trim', 'trim_alias');
     * assert(trim_alias(' abc ') === 'abc');
     * </code>
     *
     * @package Callable
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
        $ref = call_user_func(reflect_callable, $original);
        if ($ref instanceof \ReflectionMethod && !$ref->isStatic()) {
            throw new \InvalidArgumentException("$calllname is non-static method.");
        }
        // エイリアスが既に存在している
        if (function_exists($alias)) {
            throw new \InvalidArgumentException("$alias is already declared.");
        }

        // キャッシュ指定有りなら読み込むだけで eval しない
        $cachedir = call_user_func(ifelse, $cachedir, true, sys_get_temp_dir());
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
