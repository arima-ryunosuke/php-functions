<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait user_6
{
    /** @see \strrstr() */
    public function strrstr($haystack, $needle, $after_needle = true): self { }
    public function strrstr0($needle, $after_needle = true): self { }
    public function strrstr1($haystack, $after_needle = true): self { }
    public function strrstr2($haystack, $needle): self { }

    /** @see \sum() */
    public function sum(...$variadic): self { }
    public function sum0(): self { }

    /** @see \switchs() */
    public function switchs($value, $cases, $default = null): self { }
    public function switchs0($cases, $default = null): self { }
    public function switchs1($value, $default = null): self { }
    public function switchs2($value, $cases): self { }

    /** @see \throw_if() */
    public function throw_if($flag, $ex, ...$ex_args): self { }
    public function throw_if0($ex, ...$ex_args): self { }
    public function throw_if1($flag, ...$ex_args): self { }
    public function throw_if2($flag, $ex): self { }

    /** @see \throws() */
    public self $throws;
    public function throws($ex): self { }
    public function throws0(): self { }

    /** @see \timer() */
    public self $timer;
    public function timer(callable $callable, $count = 1): self { }
    public function timer0($count = 1): self { }
    public function timer1(callable $callable): self { }
    public function timerP(callable $callable, $count = 1): self { }
    public function timer0P($count = 1): self { }
    public function timer1P(callable $callable): self { }
    public function timerE(callable $callable, $count = 1): self { }
    public function timer0E($count = 1): self { }
    public function timer1E(callable $callable): self { }

    /** @see \tmpname() */
    public function tmpname($prefix = "rft", $dir = null): self { }
    public function tmpname0($dir = null): self { }
    public function tmpname1($prefix = "rft"): self { }

    /** @see \try_catch() */
    public self $try_catch;
    public function try_catch($try, $catch = null, ...$variadic): self { }
    public function try_catch0($catch = null, ...$variadic): self { }
    public function try_catch1($try, ...$variadic): self { }
    public function try_catch2($try, $catch = null): self { }

    /** @see \try_catch_finally() */
    public self $try_catch_finally;
    public function try_catch_finally($try, $catch = null, $finally = null, ...$variadic): self { }
    public function try_catch_finally0($catch = null, $finally = null, ...$variadic): self { }
    public function try_catch_finally1($try, $finally = null, ...$variadic): self { }
    public function try_catch_finally2($try, $catch = null, ...$variadic): self { }
    public function try_catch_finally3($try, $catch = null, $finally = null): self { }

    /** @see \try_finally() */
    public self $try_finally;
    public function try_finally($try, $finally = null, ...$variadic): self { }
    public function try_finally0($finally = null, ...$variadic): self { }
    public function try_finally1($try, ...$variadic): self { }
    public function try_finally2($try, $finally = null): self { }

    /** @see \try_null() */
    public self $try_null;
    public function try_null($try, ...$variadic): self { }
    public function try_null0(...$variadic): self { }
    public function try_null1($try): self { }

    /** @see \try_return() */
    public self $try_return;
    public function try_return($try, ...$variadic): self { }
    public function try_return0(...$variadic): self { }
    public function try_return1($try): self { }

    /** @see \type_exists() */
    public self $type_exists;
    public function type_exists($typename, $autoload = true): self { }
    public function type_exists0($autoload = true): self { }
    public function type_exists1($typename): self { }

    /** @see \unique_string() */
    public self $unique_string;
    public function unique_string($source, $initial = null, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }
    public function unique_string0($initial = null, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }
    public function unique_string1($source, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }
    public function unique_string2($source, $initial = null): self { }

    /** @see \var_apply() */
    public function var_apply($var, $callback, ...$args): self { }
    public function var_apply0($callback, ...$args): self { }
    public function var_apply1($var, ...$args): self { }
    public function var_apply2($var, $callback): self { }
    public function var_applyP($var, $callback, ...$args): self { }
    public function var_apply0P($callback, ...$args): self { }
    public function var_apply1P($var, ...$args): self { }
    public function var_apply2P($var, $callback): self { }
    public function var_applyE($var, $callback, ...$args): self { }
    public function var_apply0E($callback, ...$args): self { }
    public function var_apply1E($var, ...$args): self { }
    public function var_apply2E($var, $callback): self { }

    /** @see \var_applys() */
    public function var_applys($var, $callback, ...$args): self { }
    public function var_applys0($callback, ...$args): self { }
    public function var_applys1($var, ...$args): self { }
    public function var_applys2($var, $callback): self { }
    public function var_applysP($var, $callback, ...$args): self { }
    public function var_applys0P($callback, ...$args): self { }
    public function var_applys1P($var, ...$args): self { }
    public function var_applys2P($var, $callback): self { }
    public function var_applysE($var, $callback, ...$args): self { }
    public function var_applys0E($callback, ...$args): self { }
    public function var_applys1E($var, ...$args): self { }
    public function var_applys2E($var, $callback): self { }

    /** @see \var_export2() */
    public self $var_export2;
    public function var_export2($value, $return = false): self { }
    public function var_export20($return = false): self { }
    public function var_export21($value): self { }

    /** @see \var_export3() */
    public self $var_export3;
    public function var_export3($value, $return = false): self { }
    public function var_export30($return = false): self { }
    public function var_export31($value): self { }

    /** @see \var_hash() */
    public self $var_hash;
    public function var_hash($var, $algos = ["md5", "sha1"], $base64 = true): self { }
    public function var_hash0($algos = ["md5", "sha1"], $base64 = true): self { }
    public function var_hash1($var, $base64 = true): self { }
    public function var_hash2($var, $algos = ["md5", "sha1"]): self { }

    /** @see \var_html() */
    public self $var_html;
    public function var_html($value): self { }
    public function var_html0(): self { }

    /** @see \var_pretty() */
    public self $var_pretty;
    public function var_pretty($value, $options = []): self { }
    public function var_pretty0($options = []): self { }
    public function var_pretty1($value): self { }

    /** @see \var_stream() */
    public self $var_stream;
    public function var_stream(&$var, $initial = ""): self { }
    public function var_stream0($initial = ""): self { }
    public function var_stream1(&$var): self { }

    /** @see \var_type() */
    public self $var_type;
    public function var_type($var, $valid_name = false): self { }
    public function var_type0($valid_name = false): self { }
    public function var_type1($var): self { }

    /** @see \varcmp() */
    public function varcmp($a, $b, $mode = null, $precision = null): self { }
    public function varcmp0($b, $mode = null, $precision = null): self { }
    public function varcmp1($a, $mode = null, $precision = null): self { }
    public function varcmp2($a, $b, $precision = null): self { }
    public function varcmp3($a, $b, $mode = null): self { }

}
