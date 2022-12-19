<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectC
{
    /** @see \checkdate() */
    public self $checkdate;
    public function checkdate(int $month, int $day, int $year): self { }
    public function checkdate(int $day, int $year): self { }

    /** @see \count() */
    public self $count;
    public function count(\Countable|array $value, int $mode = COUNT_NORMAL): self { }
    public function count(int $mode = COUNT_NORMAL): self { }

    /** @see \current() */
    public self $current;
    public function current(object|array $array): self { }
    public function current(): self { }

    /** @see \compact() */
    public self $compact;
    public function compact($var_name, ...$var_names): self { }
    public function compact(...$var_names): self { }

    /** @see \constant() */
    public self $constant;
    public function constant(string $name): self { }
    public function constant(): self { }

    /** @see \call_user_func() */
    public self $call_user_func;
    public function call_user_func(callable $callback, mixed ...$args): self { }
    public function call_user_func(mixed ...$args): self { }

    /** @see \call_user_func_array() */
    public self $call_user_func_array;
    public function call_user_func_array(callable $callback, array $args): self { }
    public function call_user_func_array(array $args): self { }

    /** @see \crc32() */
    public self $crc32;
    public function crc32(string $string): self { }
    public function crc32(): self { }

    /** @see \crypt() */
    public self $crypt;
    public function crypt(string $string, string $salt): self { }
    public function crypt(string $salt): self { }

    /** @see \checkdnsrr() */
    public self $checkdnsrr;
    public function checkdnsrr(string $hostname, string $type = "MX"): self { }
    public function checkdnsrr(string $type = "MX"): self { }

    /** @see \chop() */
    public self $chop;
    public function chop(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function chop(string $characters = " \n\r\t\v\000"): self { }

    /** @see \chunk_split() */
    public self $chunk_split;
    public function chunk_split(string $string, int $length = 76, string $separator = "\r\n"): self { }
    public function chunk_split(int $length = 76, string $separator = "\r\n"): self { }

    /** @see \chr() */
    public self $chr;
    public function chr(int $codepoint): self { }
    public function chr(): self { }

    /** @see \count_chars() */
    public self $count_chars;
    public function count_chars(string $string, int $mode = 0): self { }
    public function count_chars(int $mode = 0): self { }

    /** @see \closedir() */
    public self $closedir;
    public function closedir($dir_handle = null): self { }
    public function closedir(): self { }

    /** @see \chdir() */
    public self $chdir;
    public function chdir(string $directory): self { }
    public function chdir(): self { }

    /** @see \copy() */
    public self $copy;
    public function copy(string $from, string $to, $context = null): self { }
    public function copy(string $to, $context = null): self { }

    /** @see \chown() */
    public self $chown;
    public function chown(string $filename, string|int $user): self { }
    public function chown(string|int $user): self { }

    /** @see \chgrp() */
    public self $chgrp;
    public function chgrp(string $filename, string|int $group): self { }
    public function chgrp(string|int $group): self { }

    /** @see \chmod() */
    public self $chmod;
    public function chmod(string $filename, int $permissions): self { }
    public function chmod(int $permissions): self { }

    /** @see \clearstatcache() */
    public self $clearstatcache;
    public function clearstatcache(bool $clear_realpath_cache = false, string $filename = ""): self { }
    public function clearstatcache(string $filename = ""): self { }

    /** @see \ceil() */
    public self $ceil;
    public function ceil(int|float $num): self { }
    public function ceil(): self { }

    /** @see \cos() */
    public self $cos;
    public function cos(float $num): self { }
    public function cos(): self { }

    /** @see \cosh() */
    public self $cosh;
    public function cosh(float $num): self { }
    public function cosh(): self { }

    /** @see \convert_uuencode() */
    public self $convert_uuencode;
    public function convert_uuencode(string $string): self { }
    public function convert_uuencode(): self { }

    /** @see \convert_uudecode() */
    public self $convert_uudecode;
    public function convert_uudecode(string $string): self { }
    public function convert_uudecode(): self { }

    /** @see \cli_set_process_title() */
    public self $cli_set_process_title;
    public function cli_set_process_title(string $title): self { }
    public function cli_set_process_title(): self { }

    /** @see \class_uses_all() */
    public self $class_uses_all;
    public function class_uses_all($class, $autoload = true): self { }
    public function class_uses_all($autoload = true): self { }

    /** @see \class_loader() */
    public self $class_loader;
    public function class_loader($startdir = null): self { }
    public function class_loader(): self { }

    /** @see \class_aliases() */
    public self $class_aliases;
    public function class_aliases($aliases): self { }
    public function class_aliases(): self { }

    /** @see \class_namespace() */
    public self $class_namespace;
    public function class_namespace($class): self { }
    public function class_namespace(): self { }

    /** @see \class_shorten() */
    public self $class_shorten;
    public function class_shorten($class): self { }
    public function class_shorten(): self { }

    /** @see \class_replace() */
    public self $class_replace;
    public function class_replace($class, $register): self { }
    public function class_replace($register): self { }

    /** @see \class_extends() */
    public self $class_extends;
    public function class_extends($object, $methods, $fields = [], $implements = []): self { }
    public function class_extends($methods, $fields = [], $implements = []): self { }

    /** @see \const_exists() */
    public self $const_exists;
    public function const_exists($classname, $constname = ""): self { }
    public function const_exists($constname = ""): self { }

    /** @see \cp_rf() */
    public self $cp_rf;
    public function cp_rf($src, $dst): self { }
    public function cp_rf($dst): self { }

    /** @see \callable_code() */
    public self $callable_code;
    public function callable_code(callable $callable): self { }
    public function callable_code(): self { }

    /** @see \call_safely() */
    public self $call_safely;
    public function call_safely(callable $callback, ...$variadic): self { }
    public function call_safely(...$variadic): self { }

    /** @see \clamp() */
    public self $clamp;
    public function clamp($value, $min, $max, $circulative = false): self { }
    public function clamp($min, $max, $circulative = false): self { }

    /** @see \calculate_formula() */
    public self $calculate_formula;
    public function calculate_formula($formula): self { }
    public function calculate_formula(): self { }

    /** @see \cidr_parse() */
    public self $cidr_parse;
    public function cidr_parse($cidr): self { }
    public function cidr_parse(): self { }

    /** @see \cidr2ip() */
    public self $cidr2ip;
    public function cidr2ip($cidr): self { }
    public function cidr2ip(): self { }

    /** @see \concat() */
    public self $concat;
    public function concat(...$variadic): self { }
    public function concat(): self { }

    /** @see \camel_case() */
    public self $camel_case;
    public function camel_case($string, $delimiter = "_"): self { }
    public function camel_case($delimiter = "_"): self { }

    /** @see \chain_case() */
    public self $chain_case;
    public function chain_case($string, $delimiter = "-"): self { }
    public function chain_case($delimiter = "-"): self { }

    /** @see \css_selector() */
    public self $css_selector;
    public function css_selector($selector): self { }
    public function css_selector(): self { }

    /** @see \csv_export() */
    public self $csv_export;
    public function csv_export(iterable $csvarrays, $options = []): self { }
    public function csv_export($options = []): self { }

    /** @see \csv_import() */
    public self $csv_import;
    public function csv_import($csvstring, $options = []): self { }
    public function csv_import($options = []): self { }

    /** @see \chain() */
    public self $chain;
    public function chain($source = null): self { }
    public function chain(): self { }

    /** @see \call_if() */
    public self $call_if;
    public function call_if($condition, callable $callable, ...$arguments): self { }
    public function call_if(callable $callable, ...$arguments): self { }

    /** @see \cacheobject() */
    public self $cacheobject;
    public function cacheobject($directory, $clean_probability = 0): self { }
    public function cacheobject($clean_probability = 0): self { }

    /** @see \cachedir() */
    public self $cachedir;
    public function cachedir($dirname = null): self { }
    public function cachedir(): self { }

    /** @see \cache() */
    public self $cache;
    public function cache($key, $provider, $namespace = null): self { }
    public function cache($provider, $namespace = null): self { }

    /** @see \cache_fetch() */
    public self $cache_fetch;
    public function cache_fetch($cacher, $key, $provider, $ttl = null): self { }
    public function cache_fetch($key, $provider, $ttl = null): self { }

    /** @see \cipher_metadata() */
    public self $cipher_metadata;
    public function cipher_metadata($cipher): self { }
    public function cipher_metadata(): self { }

    /** @see \console_log() */
    public self $console_log;
    public function console_log(...$values): self { }
    public function console_log(): self { }

}
