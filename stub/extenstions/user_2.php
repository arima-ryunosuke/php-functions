<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait user_2
{
    /** @see \array_strpad() */
    public function strpad($array, $key_prefix, $val_prefix = ""): self { }
    public function strpad0($key_prefix, $val_prefix = ""): self { }
    public function strpad1($array, $val_prefix = ""): self { }
    public function strpad2($array, $key_prefix): self { }

    /** @see \array_uncolumns() */
    public self $array_uncolumns;
    public function array_uncolumns($array, $template = null): self { }
    public function array_uncolumns0($template = null): self { }
    public function array_uncolumns1($array): self { }

    /** @see \array_uncolumns() */
    public self $uncolumns;
    public function uncolumns($array, $template = null): self { }
    public function uncolumns0($template = null): self { }
    public function uncolumns1($array): self { }

    /** @see \array_unset() */
    public function array_unset(&$array, $key, $default = null): self { }
    public function array_unset0($key, $default = null): self { }
    public function array_unset1(&$array, $default = null): self { }
    public function array_unset2(&$array, $key): self { }

    /** @see \array_unset() */
    public function unset(&$array, $key, $default = null): self { }
    public function unset0($key, $default = null): self { }
    public function unset1(&$array, $default = null): self { }
    public function unset2(&$array, $key): self { }

    /** @see \array_where() */
    public self $array_where;
    public function array_where($array, $column = null, $callback = null): self { }
    public function array_where0($column = null, $callback = null): self { }
    public function array_where1($array, $callback = null): self { }
    public function array_where2($array, $column = null): self { }
    public function array_whereP($array, $column = null, $callback = null): self { }
    public function array_where0P($column = null, $callback = null): self { }
    public function array_where1P($array, $callback = null): self { }
    public function array_where2P($array, $column = null): self { }
    public function array_whereE($array, $column = null, $callback = null): self { }
    public function array_where0E($column = null, $callback = null): self { }
    public function array_where1E($array, $callback = null): self { }
    public function array_where2E($array, $column = null): self { }

    /** @see \array_where() */
    public self $where;
    public function where($array, $column = null, $callback = null): self { }
    public function where0($column = null, $callback = null): self { }
    public function where1($array, $callback = null): self { }
    public function where2($array, $column = null): self { }
    public function whereP($array, $column = null, $callback = null): self { }
    public function where0P($column = null, $callback = null): self { }
    public function where1P($array, $callback = null): self { }
    public function where2P($array, $column = null): self { }
    public function whereE($array, $column = null, $callback = null): self { }
    public function where0E($column = null, $callback = null): self { }
    public function where1E($array, $callback = null): self { }
    public function where2E($array, $column = null): self { }

    /** @see \array_zip() */
    public function array_zip(...$arrays): self { }
    public function array_zip0(): self { }

    /** @see \array_zip() */
    public function zip(...$arrays): self { }
    public function zip0(): self { }

    /** @see \arrayable_key_exists() */
    public function arrayable_key_exists($key, $arrayable): self { }
    public function arrayable_key_exists0($arrayable): self { }
    public function arrayable_key_exists1($key): self { }

    /** @see \arrayize() */
    public function arrayize(...$variadic): self { }
    public function arrayize0(): self { }

    /** @see \arrays() */
    public self $arrays;
    public function arrays($array): self { }
    public function arrays0(): self { }

    /** @see \arrayval() */
    public self $arrayval;
    public function arrayval($var, $recursive = true): self { }
    public function arrayval0($recursive = true): self { }
    public function arrayval1($var): self { }

    /** @see \attr_exists() */
    public function attr_exists($key, $value): self { }
    public function attr_exists0($value): self { }
    public function attr_exists1($key): self { }

    /** @see \attr_get() */
    public function attr_get($key, $value, $default = null): self { }
    public function attr_get0($value, $default = null): self { }
    public function attr_get1($key, $default = null): self { }
    public function attr_get2($key, $value): self { }

    /** @see \auto_loader() */
    public function auto_loader($startdir = null): self { }
    public function auto_loader0(): self { }

    /** @see \average() */
    public function average(...$variadic): self { }
    public function average0(): self { }

    /** @see \backtrace() */
    public function backtrace($flags = DEBUG_BACKTRACE_PROVIDE_OBJECT, $options = []): self { }
    public function backtrace0($options = []): self { }
    public function backtrace1($flags = DEBUG_BACKTRACE_PROVIDE_OBJECT): self { }

    /** @see \benchmark() */
    public self $benchmark;
    public function benchmark($suite, $args = [], $millisec = 1000, $output = true): self { }
    public function benchmark0($args = [], $millisec = 1000, $output = true): self { }
    public function benchmark1($suite, $millisec = 1000, $output = true): self { }
    public function benchmark2($suite, $args = [], $output = true): self { }
    public function benchmark3($suite, $args = [], $millisec = 1000): self { }

    /** @see \blank_if() */
    public self $blank_if;
    public function blank_if($var, $default = null): self { }
    public function blank_if0($default = null): self { }
    public function blank_if1($var): self { }

    /** @see \build_query() */
    public self $build_query;
    public function build_query($data, $numeric_prefix = null, $arg_separator = null, $encoding_type = PHP_QUERY_RFC1738): self { }
    public function build_query0($numeric_prefix = null, $arg_separator = null, $encoding_type = PHP_QUERY_RFC1738): self { }
    public function build_query1($data, $arg_separator = null, $encoding_type = PHP_QUERY_RFC1738): self { }
    public function build_query2($data, $numeric_prefix = null, $encoding_type = PHP_QUERY_RFC1738): self { }
    public function build_query3($data, $numeric_prefix = null, $arg_separator = null): self { }

    /** @see \build_uri() */
    public self $build_uri;
    public function build_uri($parts): self { }
    public function build_uri0(): self { }

    /** @see \by_builtin() */
    public function by_builtin($class, $function): self { }
    public function by_builtin0($function): self { }
    public function by_builtin1($class): self { }

    /** @see \cache() */
    public function cache($key, $provider, $namespace = null): self { }
    public function cache0($provider, $namespace = null): self { }
    public function cache1($key, $namespace = null): self { }
    public function cache2($key, $provider): self { }

    /** @see \cachedir() */
    public function cachedir($dirname = null): self { }
    public function cachedir0(): self { }

    /** @see \cacheobject() */
    public self $cacheobject;
    public function cacheobject($directory): self { }
    public function cacheobject0(): self { }

    /** @see \calculate_formula() */
    public self $calculate_formula;
    public function calculate_formula($formula): self { }
    public function calculate_formula0(): self { }

    /** @see \call_if() */
    public function call_if($condition, $callable, ...$arguments): self { }
    public function call_if0($callable, ...$arguments): self { }
    public function call_if1($condition, ...$arguments): self { }
    public function call_if2($condition, $callable): self { }
    public function call_ifP($condition, $callable, ...$arguments): self { }
    public function call_if0P($callable, ...$arguments): self { }
    public function call_if1P($condition, ...$arguments): self { }
    public function call_if2P($condition, $callable): self { }
    public function call_ifE($condition, $callable, ...$arguments): self { }
    public function call_if0E($callable, ...$arguments): self { }
    public function call_if1E($condition, ...$arguments): self { }
    public function call_if2E($condition, $callable): self { }

    /** @see \call_safely() */
    public self $call_safely;
    public function call_safely($callback, ...$variadic): self { }
    public function call_safely0(...$variadic): self { }
    public function call_safely1($callback): self { }
    public function call_safelyP($callback, ...$variadic): self { }
    public function call_safely0P(...$variadic): self { }
    public function call_safely1P($callback): self { }
    public function call_safelyE($callback, ...$variadic): self { }
    public function call_safely0E(...$variadic): self { }
    public function call_safely1E($callback): self { }

    /** @see \callable_code() */
    public self $callable_code;
    public function callable_code($callable): self { }
    public function callable_code0(): self { }
    public function callable_codeP($callable): self { }
    public function callable_code0P(): self { }
    public function callable_codeE($callable): self { }
    public function callable_code0E(): self { }

    /** @see \camel_case() */
    public self $camel_case;
    public function camel_case($string, $delimiter = "_"): self { }
    public function camel_case0($delimiter = "_"): self { }
    public function camel_case1($string): self { }

    /** @see \chain() */
    public function chain($source = null): self { }
    public function chain0(): self { }

    /** @see \chain_case() */
    public self $chain_case;
    public function chain_case($string, $delimiter = "-"): self { }
    public function chain_case0($delimiter = "-"): self { }
    public function chain_case1($string): self { }

    /** @see \cipher_metadata() */
    public self $cipher_metadata;
    public function cipher_metadata($cipher): self { }
    public function cipher_metadata0(): self { }

    /** @see \clamp() */
    public function clamp($value, $min, $max, $circulative = false): self { }
    public function clamp0($min, $max, $circulative = false): self { }
    public function clamp1($value, $max, $circulative = false): self { }
    public function clamp2($value, $min, $circulative = false): self { }
    public function clamp3($value, $min, $max): self { }

    /** @see \class_aliases() */
    public self $class_aliases;
    public function class_aliases($aliases): self { }
    public function class_aliases0(): self { }

    /** @see \class_extends() */
    public function class_extends($object, $methods, $fields = [], $implements = []): self { }
    public function class_extends0($methods, $fields = [], $implements = []): self { }
    public function class_extends1($object, $fields = [], $implements = []): self { }
    public function class_extends2($object, $methods, $implements = []): self { }
    public function class_extends3($object, $methods, $fields = []): self { }

    /** @see \class_loader() */
    public function class_loader($startdir = null): self { }
    public function class_loader0(): self { }

    /** @see \class_namespace() */
    public self $class_namespace;
    public function class_namespace($class): self { }
    public function class_namespace0(): self { }

    /** @see \class_replace() */
    public function class_replace($class, $register): self { }
    public function class_replace0($register): self { }
    public function class_replace1($class): self { }

    /** @see \class_shorten() */
    public self $class_shorten;
    public function class_shorten($class): self { }
    public function class_shorten0(): self { }

    /** @see \class_uses_all() */
    public self $class_uses_all;
    public function class_uses_all($class, $autoload = true): self { }
    public function class_uses_all0($autoload = true): self { }
    public function class_uses_all1($class): self { }

    /** @see \concat() */
    public function concat(...$variadic): self { }
    public function concat0(): self { }

    /** @see \console_log() */
    public function console_log(...$values): self { }
    public function console_log0(): self { }

    /** @see \const_exists() */
    public self $const_exists;
    public function const_exists($classname, $constname = ""): self { }
    public function const_exists0($constname = ""): self { }
    public function const_exists1($classname): self { }

    /** @see \cp_rf() */
    public function cp_rf($src, $dst): self { }
    public function cp_rf0($dst): self { }
    public function cp_rf1($src): self { }

    /** @see \css_selector() */
    public self $css_selector;
    public function css_selector($selector): self { }
    public function css_selector0(): self { }

    /** @see \csv_export() */
    public self $csv_export;
    public function csv_export($csvarrays, $options = []): self { }
    public function csv_export0($options = []): self { }
    public function csv_export1($csvarrays): self { }

    /** @see \csv_import() */
    public self $csv_import;
    public function csv_import($csvstring, $options = []): self { }
    public function csv_import0($options = []): self { }
    public function csv_import1($csvstring): self { }

    /** @see \damerau_levenshtein() */
    public function damerau_levenshtein($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1): self { }
    public function damerau_levenshtein0($s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1): self { }
    public function damerau_levenshtein1($s1, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1): self { }
    public function damerau_levenshtein2($s1, $s2, $cost_rep = 1, $cost_del = 1, $cost_swp = 1): self { }
    public function damerau_levenshtein3($s1, $s2, $cost_ins = 1, $cost_del = 1, $cost_swp = 1): self { }
    public function damerau_levenshtein4($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_swp = 1): self { }
    public function damerau_levenshtein5($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1): self { }

    /** @see \date_alter() */
    public function date_alter($datetime, $excluded_dates, $follow_count, $format = "Y-m-d"): self { }
    public function date_alter0($excluded_dates, $follow_count, $format = "Y-m-d"): self { }
    public function date_alter1($datetime, $follow_count, $format = "Y-m-d"): self { }
    public function date_alter2($datetime, $excluded_dates, $format = "Y-m-d"): self { }
    public function date_alter3($datetime, $excluded_dates, $follow_count): self { }

    /** @see \date_convert() */
    public self $date_convert;
    public function date_convert($format, $datetimedata = null): self { }
    public function date_convert0($datetimedata = null): self { }
    public function date_convert1($format): self { }

    /** @see \date_fromto() */
    public function date_fromto($format, $datetimestring): self { }
    public function date_fromto0($datetimestring): self { }
    public function date_fromto1($format): self { }

    /** @see \date_interval() */
    public self $date_interval;
    public function date_interval($sec, $format = null, $limit_type = "y"): self { }
    public function date_interval0($format = null, $limit_type = "y"): self { }
    public function date_interval1($sec, $limit_type = "y"): self { }
    public function date_interval2($sec, $format = null): self { }

    /** @see \date_timestamp() */
    public self $date_timestamp;
    public function date_timestamp($datetimedata, $baseTimestamp = null): self { }
    public function date_timestamp0($baseTimestamp = null): self { }
    public function date_timestamp1($datetimedata): self { }

    /** @see \decimal() */
    public self $decimal;
    public function decimal($value, $precision = 0, $mode = 0): self { }
    public function decimal0($precision = 0, $mode = 0): self { }
    public function decimal1($value, $mode = 0): self { }
    public function decimal2($value, $precision = 0): self { }

    /** @see \decrypt() */
    public function decrypt($cipherdata, $password, $ciphers = "aes-256-cbc", $tag = ""): self { }
    public function decrypt0($password, $ciphers = "aes-256-cbc", $tag = ""): self { }
    public function decrypt1($cipherdata, $ciphers = "aes-256-cbc", $tag = ""): self { }
    public function decrypt2($cipherdata, $password, $tag = ""): self { }
    public function decrypt3($cipherdata, $password, $ciphers = "aes-256-cbc"): self { }

    /** @see \delegate() */
    public function delegate($invoker, $callable, $arity = null): self { }
    public function delegate0($callable, $arity = null): self { }
    public function delegate1($invoker, $arity = null): self { }
    public function delegate2($invoker, $callable): self { }
    public function delegateP($invoker, $callable, $arity = null): self { }
    public function delegate0P($callable, $arity = null): self { }
    public function delegate1P($invoker, $arity = null): self { }
    public function delegate2P($invoker, $callable): self { }
    public function delegateE($invoker, $callable, $arity = null): self { }
    public function delegate0E($callable, $arity = null): self { }
    public function delegate1E($invoker, $arity = null): self { }
    public function delegate2E($invoker, $callable): self { }

    /** @see \detect_namespace() */
    public self $detect_namespace;
    public function detect_namespace($location): self { }
    public function detect_namespace0(): self { }

    /** @see \dirmtime() */
    public self $dirmtime;
    public function dirmtime($dirname, $recursive = true): self { }
    public function dirmtime0($recursive = true): self { }
    public function dirmtime1($dirname): self { }

    /** @see \dirname_r() */
    public function dirname_r($path, $callback): self { }
    public function dirname_r0($callback): self { }
    public function dirname_r1($path): self { }
    public function dirname_rP($path, $callback): self { }
    public function dirname_r0P($callback): self { }
    public function dirname_r1P($path): self { }
    public function dirname_rE($path, $callback): self { }
    public function dirname_r0E($callback): self { }
    public function dirname_r1E($path): self { }

    /** @see \encrypt() */
    public function encrypt($plaindata, $password, $cipher = "aes-256-gcm", &$tag = ""): self { }
    public function encrypt0($password, $cipher = "aes-256-gcm", &$tag = ""): self { }
    public function encrypt1($plaindata, $cipher = "aes-256-gcm", &$tag = ""): self { }
    public function encrypt2($plaindata, $password, &$tag = ""): self { }
    public function encrypt3($plaindata, $password, $cipher = "aes-256-gcm"): self { }

    /** @see \ends_with() */
    public function ends_with($string, $with, $case_insensitivity = false): self { }
    public function ends_with0($with, $case_insensitivity = false): self { }
    public function ends_with1($string, $case_insensitivity = false): self { }
    public function ends_with2($string, $with): self { }

    /** @see \error() */
    public self $error;
    public function error($message, $destination = null): self { }
    public function error0($destination = null): self { }
    public function error1($message): self { }

}
