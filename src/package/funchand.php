<?php
/**
 * callable に関するユーティリティ
 *
 * @package callable
 */

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
function delegate($invoker, $callable, $arity = null)
{
    if ($arity === null) {
        $arity = parameter_length($callable, true);
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
            $argstring = array_rmap(range(1, $arity), strcat, '$_');
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
 * @param callable $callable 対象 callable
 * @param int $n 挿入する引数位置
 * @param mixed $variadic 本来の引数（可変引数）
 * @return \Closure 束縛したクロージャ
 */
function nbind($callable, $n)
{
    $binded = array_slice(func_get_args(), 2);
    return delegate(function ($callable, $args) use ($binded, $n) {
        return call_user_func_array($callable, array_insert($args, $binded, $n));
    }, $callable, parameter_length($callable, true) - count($binded));
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
 * @param callable $callable 対象 callable
 * @param mixed $variadic 本来の引数（可変引数）
 * @return \Closure 束縛したクロージャ
 */
function lbind($callable)
{
    return call_user_func_array(nbind, array_insert(func_get_args(), 0, 1));
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
 * @param callable $callable 対象 callable
 * @param mixed $variadic 本来の引数（可変引数）
 * @return \Closure 束縛したクロージャ
 */
function rbind($callable)
{
    return call_user_func_array(nbind, array_insert(func_get_args(), null, 1));
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
 * @param int $n $n 番目の引数
 * @return \Closure $n 番目の引数をそのまま返すクロージャ
 */
function return_arg($n)
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
 * @param callable $callable 対象 callable
 * @return \Closure 新しいクロージャ
 */
function not_func($callable)
{
    return delegate(function ($callable, $args) {
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
 * @param string $expression eval コード
 * @param mixed $variadic 引数名（可変引数）
 * @return \Closure 新しいクロージャ
 */
function eval_func($expression)
{
    $eargs = array_slice(func_get_args(), 1);
    return delegate(function ($expression, $args) use ($eargs) {
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
 * @param callable $callable 対象 callable
 * @return \ReflectionFunction|\ReflectionMethod リフレクションインスタンス
 */
function reflect_callable($callable)
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
 * @param callable $callable 変換する callable
 * @return \Closure 変換したクロージャ
 */
function closurize($callable)
{
    if ($callable instanceof \Closure) {
        return $callable;
    }

    $ref = reflect_callable($callable);
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
 * @param callable $callback 実行するコールバック
 * @param mixed $variadic $callback に渡される引数（可変引数）
 * @return mixed $callback の返り値
 */
function call_safely($callback)
{
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
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
 * @param callable $callback 実行するコールバック
 * @param mixed $variadic $callback に渡される引数（可変引数）
 * @return string オフスリーンバッファの文字列
 */
function ob_capture($callback)
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
 * @param callable $callable 対象 callable
 * @param bool $require_only true を渡すと必須パラメータの数を返す
 * @return int 引数の数
 */
function parameter_length($callable, $require_only = false)
{
    // クロージャの $call_name には一意性がないのでキャッシュできない（spl_object_hash でもいいが、かなり重複するので完全ではない）
    if ($callable instanceof \Closure) {
        $ref = reflect_callable($callable);
        return $require_only ? $ref->getNumberOfRequiredParameters() : $ref->getNumberOfParameters();
    }

    // $call_name 取得
    is_callable($callable, false, $call_name);

    $cache = \ryunosuke\Functions\Cacher::put(__FILE__, __FUNCTION__, function ($cache) use ($callable, $call_name) {
        if (!isset($cache[$call_name])) {
            $ref = reflect_callable($callable);
            $cache[$call_name] = [
                false => $ref->getNumberOfParameters(),
                true  => $ref->getNumberOfRequiredParameters(),
            ];
        }
        return $cache;
    });
    return $cache[$call_name][$require_only];
}

/**
 * 関数の名前空間部分を除いた短い名前を取得する
 *
 * @param string $function 短くする関数名
 * @return string 短い関数名
 */
function function_shorten($function)
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
 * @param callable $callback 呼び出すクロージャ
 * @return \Closure 引数ぴったりで呼び出すクロージャ
 */
function func_user_func_array($callback)
{
    if ($callback === null) {
        return function ($v) { return $v; };
    }
    $plength = parameter_length($callback, true);
    return delegate(function ($callback, $args) use ($plength) {
        return call_user_func_array($callback, array_slice($args, 0, $plength));
    }, $callback, $plength);
}
