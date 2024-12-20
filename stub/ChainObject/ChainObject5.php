<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject5
{
    /** @see date() */
    public self $date;
    public function date(string $format, ?int $timestamp = null): self { }
    public function date(?int $timestamp = null): self { }

    /** @see gmstrftime() */
    public self $gmstrftime;
    public function gmstrftime(string $format, ?int $timestamp = null): self { }
    public function gmstrftime(?int $timestamp = null): self { }

    /** @see date_date_set() */
    public self $date_date_set;
    public function date_date_set(\DateTime $object, int $year, int $month, int $day): self { }
    public function date_date_set(int $year, int $month, int $day): self { }

    /** @see date_interval_create_from_date_string() */
    public self $date_interval_create_from_date_string;
    public function date_interval_create_from_date_string(string $datetime): self { }
    public function date_interval_create_from_date_string(): self { }

    /** @see preg_match() */
    public self $preg_match;
    public function preg_match(string $pattern, string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match(string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }

    /** @see hash_final() */
    public self $hash_final;
    public function hash_final(\HashContext $context, bool $binary = false): self { }
    public function hash_final(bool $binary = false): self { }

    /** @see hash_equals() */
    public self $hash_equals;
    public function hash_equals(string $known_string, string $user_string): self { }
    public function hash_equals(string $user_string): self { }

    /** @see hash_hkdf() */
    public self $hash_hkdf;
    public function hash_hkdf(string $algo, string $key, int $length = 0, string $info = "", string $salt = ""): self { }
    public function hash_hkdf(string $key, int $length = 0, string $info = "", string $salt = ""): self { }

    /** @see mhash_keygen_s2k() */
    public self $mhash_keygen_s2k;
    public function mhash_keygen_s2k(int $algo, string $password, string $salt, int $length): self { }
    public function mhash_keygen_s2k(string $password, string $salt, int $length): self { }

    /** @see range() */
    public self $range;
    public function range($start, $end, int|float $step = 1): self { }
    public function range($end, int|float $step = 1): self { }

    /** @see array_replace() */
    public self $array_replace;
    public function array_replace(array ...$replacements): self { }
    public function array_replace(): self { }

    /** @see array_replace() */
    public self $replace;
    public function replace(array ...$replacements): self { }
    public function replace(): self { }

    /** @see array_uintersect_uassoc() */
    public self $array_uintersect_uassoc;
    public function array_uintersect_uassoc(array $array, ...$rest): self { }
    public function array_uintersect_uassoc(...$rest): self { }

    /** @see array_uintersect_uassoc() */
    public self $uintersect_uassoc;
    public function uintersect_uassoc(array $array, ...$rest): self { }
    public function uintersect_uassoc(...$rest): self { }

    /** @see array_diff_key() */
    public self $array_diff_key;
    public function array_diff_key(array ...$arrays): self { }
    public function array_diff_key(): self { }

    /** @see array_diff_key() */
    public self $diff_key;
    public function diff_key(array ...$arrays): self { }
    public function diff_key(): self { }

    /** @see array_udiff_assoc() */
    public self $array_udiff_assoc;
    public function array_udiff_assoc(array $array, ...$rest): self { }
    public function array_udiff_assoc(...$rest): self { }

    /** @see array_udiff_assoc() */
    public self $udiff_assoc;
    public function udiff_assoc(array $array, ...$rest): self { }
    public function udiff_assoc(...$rest): self { }

    /** @see array_reduce() */
    public self $array_reduce;
    public function array_reduce(array $array, callable $callback, mixed $initial = null): self { }
    public function array_reduce(callable $callback, mixed $initial = null): self { }

    /** @see array_reduce() */
    public self $reduce;
    public function reduce(array $array, callable $callback, mixed $initial = null): self { }
    public function reduce(callable $callback, mixed $initial = null): self { }

    /** @see call_user_func_array() */
    public self $call_user_func_array;
    public function call_user_func_array(callable $callback, array $args): self { }
    public function call_user_func_array(array $args): self { }

    /** @see ini_parse_quantity() */
    public self $ini_parse_quantity;
    public function ini_parse_quantity(string $shorthand): self { }
    public function ini_parse_quantity(): self { }

    /** @see crc32() */
    public self $crc32;
    public function crc32(string $string): self { }
    public function crc32(): self { }

    /** @see openlog() */
    public self $openlog;
    public function openlog(string $prefix, int $flags, int $facility): self { }
    public function openlog(int $flags, int $facility): self { }

    /** @see setrawcookie() */
    public self $setrawcookie;
    public function setrawcookie(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setrawcookie(string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }

    /** @see join() */
    public self $join;
    public function join(array|string $separator, ?array $array = null): self { }
    public function join(?array $array = null): self { }

    /** @see strstr() */
    public self $strstr;
    public function strstr(string $haystack, string $needle, bool $before_needle = false): self { }
    public function strstr(string $needle, bool $before_needle = false): self { }

    /** @see strrchr() */
    public self $strrchr;
    public function strrchr(string $haystack, string $needle): self { }
    public function strrchr(string $needle): self { }

    /** @see ucwords() */
    public self $ucwords;
    public function ucwords(string $string, string $separators = <<<TEXT
 	

TEXT): self { }
    public function ucwords(string $separators = <<<TEXT
 	

TEXT): self { }

    /** @see strrev() */
    public self $strrev;
    public function strrev(string $string): self { }
    public function strrev(): self { }

    /** @see strnatcmp() */
    public self $strnatcmp;
    public function strnatcmp(string $string1, string $string2): self { }
    public function strnatcmp(string $string2): self { }

    /** @see dir() */
    public self $dir;
    public function dir(string $directory, $context = null): self { }
    public function dir($context = null): self { }

    /** @see chdir() */
    public self $chdir;
    public function chdir(string $directory): self { }
    public function chdir(): self { }

    /** @see shell_exec() */
    public self $shell_exec;
    public function shell_exec(string $command): self { }
    public function shell_exec(): self { }

    /** @see flock() */
    public self $flock;
    public function flock($stream, int $operation, &$would_block = null): self { }
    public function flock(int $operation, &$would_block = null): self { }

    /** @see pclose() */
    public self $pclose;
    public function pclose($handle): self { }
    public function pclose(): self { }

    /** @see readfile() */
    public self $readfile;
    public function readfile(string $filename, bool $use_include_path = false, $context = null): self { }
    public function readfile(bool $use_include_path = false, $context = null): self { }

    /** @see rename() */
    public self $rename;
    public function rename(string $from, string $to, $context = null): self { }
    public function rename(string $to, $context = null): self { }

    /** @see unlink() */
    public self $unlink;
    public function unlink(string $filename, $context = null): self { }
    public function unlink($context = null): self { }

    /** @see fnmatch() */
    public self $fnmatch;
    public function fnmatch(string $pattern, string $filename, int $flags = 0): self { }
    public function fnmatch(string $filename, int $flags = 0): self { }

    /** @see fileowner() */
    public self $fileowner;
    public function fileowner(string $filename): self { }
    public function fileowner(): self { }

    /** @see file_exists() */
    public self $file_exists;
    public function file_exists(string $filename): self { }
    public function file_exists(): self { }

    /** @see is_readable() */
    public self $is_readable;
    public function is_readable(string $filename): self { }
    public function is_readable(): self { }

    /** @see lstat() */
    public self $lstat;
    public function lstat(string $filename): self { }
    public function lstat(): self { }

    /** @see chmod() */
    public self $chmod;
    public function chmod(string $filename, int $permissions): self { }
    public function chmod(int $permissions): self { }

    /** @see touch() */
    public self $touch;
    public function touch(string $filename, ?int $mtime = null, ?int $atime = null): self { }
    public function touch(?int $mtime = null, ?int $atime = null): self { }

    /** @see clearstatcache() */
    public self $clearstatcache;
    public function clearstatcache(bool $clear_realpath_cache = false, string $filename = ""): self { }
    public function clearstatcache(string $filename = ""): self { }

    /** @see printf() */
    public self $printf;
    public function printf(string $format, mixed ...$values): self { }
    public function printf(mixed ...$values): self { }

    /** @see http_build_query() */
    public self $http_build_query;
    public function http_build_query(object|array $data, string $numeric_prefix = "", ?string $arg_separator = null, int $encoding_type = PHP_QUERY_RFC1738): self { }
    public function http_build_query(string $numeric_prefix = "", ?string $arg_separator = null, int $encoding_type = PHP_QUERY_RFC1738): self { }

    /** @see getimagesize() */
    public self $getimagesize;
    public function getimagesize(string $filename, &$image_info = null): self { }
    public function getimagesize(&$image_info = null): self { }

    /** @see round() */
    public self $round;
    public function round(int|float $num, int $precision = 0, int $mode = PHP_ROUND_HALF_UP): self { }
    public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP): self { }

    /** @see sin() */
    public self $sin;
    public function sin(float $num): self { }
    public function sin(): self { }

    /** @see acosh() */
    public self $acosh;
    public function acosh(float $num): self { }
    public function acosh(): self { }

    /** @see is_finite() */
    public self $is_finite;
    public function is_finite(float $num): self { }
    public function is_finite(): self { }

    /** @see is_nan() */
    public self $is_nan;
    public function is_nan(float $num): self { }
    public function is_nan(): self { }

    /** @see getrusage() */
    public self $getrusage;
    public function getrusage(int $mode = 0): self { }
    public function getrusage(): self { }

    /** @see floatval() */
    public self $floatval;
    public function floatval(mixed $value): self { }
    public function floatval(): self { }

    /** @see is_float() */
    public self $is_float;
    public function is_float(mixed $value): self { }
    public function is_float(): self { }

    /** @see is_double() */
    public self $is_double;
    public function is_double(mixed $value): self { }
    public function is_double(): self { }

    /** @see is_numeric() */
    public self $is_numeric;
    public function is_numeric(mixed $value): self { }
    public function is_numeric(): self { }

    /** @see serialize() */
    public self $serialize;
    public function serialize(mixed $value): self { }
    public function serialize(): self { }

    /** @see mb_http_output() */
    public self $mb_http_output;
    public function mb_http_output(?string $encoding = null): self { }
    public function mb_http_output(): self { }

    /** @see mb_output_handler() */
    public self $mb_output_handler;
    public function mb_output_handler(string $string, int $status): self { }
    public function mb_output_handler(int $status): self { }

    /** @see mb_substr() */
    public self $mb_substr;
    public function mb_substr(string $string, int $start, ?int $length = null, ?string $encoding = null): self { }
    public function mb_substr(int $start, ?int $length = null, ?string $encoding = null): self { }

    /** @see mb_strtoupper() */
    public self $mb_strtoupper;
    public function mb_strtoupper(string $string, ?string $encoding = null): self { }
    public function mb_strtoupper(?string $encoding = null): self { }

    /** @see mb_decode_numericentity() */
    public self $mb_decode_numericentity;
    public function mb_decode_numericentity(string $string, array $map, ?string $encoding = null): self { }
    public function mb_decode_numericentity(array $map, ?string $encoding = null): self { }

    /** @see mb_eregi_replace() */
    public self $mb_eregi_replace;
    public function mb_eregi_replace(string $pattern, string $replacement, string $string, ?string $options = null): self { }
    public function mb_eregi_replace(string $replacement, string $string, ?string $options = null): self { }

    /** @see mb_ereg_match() */
    public self $mb_ereg_match;
    public function mb_ereg_match(string $pattern, string $string, ?string $options = null): self { }
    public function mb_ereg_match(string $string, ?string $options = null): self { }

    /** @see mb_ereg_search() */
    public self $mb_ereg_search;
    public function mb_ereg_search(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search(?string $options = null): self { }

    /** @see mb_ereg_search_setpos() */
    public self $mb_ereg_search_setpos;
    public function mb_ereg_search_setpos(int $offset): self { }
    public function mb_ereg_search_setpos(): self { }

    /** @see array_append() */
    public self $array_append;
    public function array_append(iterable $array, $value, $key = null): self { }
    public function array_append($value, $key = null): self { }

    /** @see array_append() */
    public self $append;
    public function append(iterable $array, $value, $key = null): self { }
    public function append($value, $key = null): self { }

    /** @see array_fill_gap() */
    public self $array_fill_gap;
    public function array_fill_gap(iterable $array, ...$values): self { }
    public function array_fill_gap(...$values): self { }

    /** @see array_fill_gap() */
    public self $fill_gap;
    public function fill_gap(iterable $array, ...$values): self { }
    public function fill_gap(...$values): self { }

    /** @see array_filter_map() */
    public self $array_filter_map;
    public function array_filter_map(iterable $array, callable $callback): self { }
    public function array_filter_map(callable $callback): self { }

    /** @see array_filter_map() */
    public self $filter_map;
    public function filter_map(iterable $array, callable $callback): self { }
    public function filter_map(callable $callback): self { }

    /** @see array_group() */
    public self $array_group;
    public function array_group(iterable $array, callable $callback = null, $preserve_keys = false): self { }
    public function array_group(callable $callback = null, $preserve_keys = false): self { }

    /** @see array_group() */
    public self $group;
    public function group(iterable $array, callable $callback = null, $preserve_keys = false): self { }
    public function group(callable $callback = null, $preserve_keys = false): self { }

    /** @see array_pos() */
    public self $array_pos;
    public function array_pos(iterable $array, $position, $return_key = false): self { }
    public function array_pos($position, $return_key = false): self { }

    /** @see array_pos() */
    public self $pos;
    public function pos(iterable $array, $position, $return_key = false): self { }
    public function pos($position, $return_key = false): self { }

    /** @see array_prepend() */
    public self $array_prepend;
    public function array_prepend(iterable $array, $value, $key = null): self { }
    public function array_prepend($value, $key = null): self { }

    /** @see array_prepend() */
    public self $prepend;
    public function prepend(iterable $array, $value, $key = null): self { }
    public function prepend($value, $key = null): self { }

    /** @see array_schema() */
    public self $array_schema;
    public function array_schema($schema, iterable ...$arrays): self { }
    public function array_schema(iterable ...$arrays): self { }

    /** @see array_schema() */
    public self $schema;
    public function schema($schema, iterable ...$arrays): self { }
    public function schema(iterable ...$arrays): self { }

    /** @see last_value() */
    public self $last_value;
    public function last_value(iterable $array, $default = null): self { }
    public function last_value($default = null): self { }

    /** @see class_extends() */
    public self $class_extends;
    public function class_extends($object, $methods, $fields = [], $implements = []): self { }
    public function class_extends($methods, $fields = [], $implements = []): self { }

    /** @see object_id() */
    public self $object_id;
    public function object_id($objectOrId): self { }
    public function object_id(): self { }

    /** @see type_exists() */
    public self $type_exists;
    public function type_exists($typename, $autoload = true): self { }
    public function type_exists($autoload = true): self { }

    /** @see sql_quote() */
    public self $sql_quote;
    public function sql_quote($value): self { }
    public function sql_quote(): self { }

    /** @see xmlss_import() */
    public self $xmlss_import;
    public function xmlss_import($xmlssstring, array $options = []): self { }
    public function xmlss_import(array $options = []): self { }

    /** @see date_alter() */
    public self $date_alter;
    public function date_alter($datetime, $excluded_dates, $follow_count, $format = "Y-m-d"): self { }
    public function date_alter($excluded_dates, $follow_count, $format = "Y-m-d"): self { }

    /** @see date_convert() */
    public self $date_convert;
    public function date_convert($format, $datetimedata = null): self { }
    public function date_convert($datetimedata = null): self { }

    /** @see file_rotate() */
    public self $file_rotate;
    public function file_rotate(string $filename, bool $ifempty = false, bool $copytruncate = false, bool $append = false, ?string $olddir = null, ?string $dateformat = null, ?int $rotate = null, ?int $compress = null): self { }
    public function file_rotate(bool $ifempty = false, bool $copytruncate = false, bool $append = false, ?string $olddir = null, ?string $dateformat = null, ?int $rotate = null, ?int $compress = null): self { }

    /** @see file_set_contents() */
    public self $file_set_contents;
    public function file_set_contents($filename, $data, $umask = 2): self { }
    public function file_set_contents($data, $umask = 2): self { }

    /** @see path_normalize() */
    public self $path_normalize;
    public function path_normalize($path): self { }
    public function path_normalize(): self { }

    /** @see ansi_strip() */
    public self $ansi_strip;
    public function ansi_strip($string): self { }
    public function ansi_strip(): self { }

    /** @see ini_sets() */
    public self $ini_sets;
    public function ini_sets($values): self { }
    public function ini_sets(): self { }

    /** @see system_status() */
    public self $system_status;
    public function system_status(string $siunit = "", string $datetime_format = \DateTime::RFC3339): self { }
    public function system_status(string $datetime_format = \DateTime::RFC3339): self { }

    /** @see average() */
    public self $average;
    public function average(...$variadic): self { }
    public function average(): self { }

    /** @see clamp() */
    public self $clamp;
    public function clamp($value, $min, $max, $circulative = false): self { }
    public function clamp($min, $max, $circulative = false): self { }

    /** @see mean() */
    public self $mean;
    public function mean(...$variadic): self { }
    public function mean(): self { }

    /** @see unique_id() */
    public self $unique_id;
    public function unique_id(&$id_info = [], $debug = []): self { }
    public function unique_id($debug = []): self { }

    /** @see http_put() */
    public self $http_put;
    public function http_put($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_put($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see preg_splice() */
    public self $preg_splice;
    public function preg_splice($pattern, $replacement, $subject, &$matches = [], $limit = -1): self { }
    public function preg_splice($replacement, $subject, &$matches = [], $limit = -1): self { }

    /** @see function_parameter() */
    public self $function_parameter;
    public function function_parameter($eitherReffuncOrCallable): self { }
    public function function_parameter(): self { }

    /** @see parameter_length() */
    public self $parameter_length;
    public function parameter_length(callable $callable, $require_only = false, $thought_variadic = false): self { }
    public function parameter_length($require_only = false, $thought_variadic = false): self { }

    /** @see concat() */
    public self $concat;
    public function concat(...$variadic): self { }
    public function concat(): self { }

    /** @see damerau_levenshtein() */
    public self $damerau_levenshtein;
    public function damerau_levenshtein($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1): self { }
    public function damerau_levenshtein($s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1): self { }

    /** @see kvsprintf() */
    public self $kvsprintf;
    public function kvsprintf(?string $format, array $array): self { }
    public function kvsprintf(array $array): self { }

    /** @see mb_pad_width() */
    public self $mb_pad_width;
    public function mb_pad_width(?string $string, $width, $pad_string = " ", $pad_type = STR_PAD_RIGHT): self { }
    public function mb_pad_width($width, $pad_string = " ", $pad_type = STR_PAD_RIGHT): self { }

    /** @see quoteexplode() */
    public self $quoteexplode;
    public function quoteexplode($delimiter, ?string $string, $limit = null, $enclosures = "'\"", $escape = "\\", $options = []): self { }
    public function quoteexplode(?string $string, $limit = null, $enclosures = "'\"", $escape = "\\", $options = []): self { }

    /** @see render_file() */
    public self $render_file;
    public function render_file(?string $template_file, iterable $array): self { }
    public function render_file(iterable $array): self { }

    /** @see render_template() */
    public self $render_template;
    public function render_template(?string $template, $vars, $tag = null): self { }
    public function render_template($vars, $tag = null): self { }

    /** @see str_bytes() */
    public self $str_bytes;
    public function str_bytes(?string $string, $base = 10): self { }
    public function str_bytes($base = 10): self { }

    /** @see str_bytes() */
    public self $bytes;
    public function bytes(?string $string, $base = 10): self { }
    public function bytes($base = 10): self { }

    /** @see str_exists() */
    public self $str_exists;
    public function str_exists(?string $haystack, $needle, $case_insensitivity = false, $and_flag = false): self { }
    public function str_exists($needle, $case_insensitivity = false, $and_flag = false): self { }

    /** @see str_exists() */
    public self $exists;
    public function exists(?string $haystack, $needle, $case_insensitivity = false, $and_flag = false): self { }
    public function exists($needle, $case_insensitivity = false, $and_flag = false): self { }

    /** @see try_finally() */
    public self $try_finally;
    public function try_finally($try, $finally = null, ...$variadic): self { }
    public function try_finally($finally = null, ...$variadic): self { }

    /** @see cache() */
    public self $cache;
    public function cache($key, $provider, $namespace = null): self { }
    public function cache($provider, $namespace = null): self { }

    /** @see arrayable_key_exists() */
    public self $arrayable_key_exists;
    public function arrayable_key_exists($key, iterable $arrayable): self { }
    public function arrayable_key_exists(iterable $arrayable): self { }

    /** @see attr_get() */
    public self $attr_get;
    public function attr_get($key, $value, $default = null): self { }
    public function attr_get($value, $default = null): self { }

    /** @see is_arrayable() */
    public self $is_arrayable;
    public function is_arrayable($var): self { }
    public function is_arrayable(): self { }

    /** @see is_recursive() */
    public self $is_recursive;
    public function is_recursive($var): self { }
    public function is_recursive(): self { }

    /** @see strdec() */
    public self $strdec;
    public function strdec($var): self { }
    public function strdec(): self { }

    /** @see var_apply() */
    public self $var_apply;
    public function var_apply($var, callable $callback, ...$args): self { }
    public function var_apply(callable $callback, ...$args): self { }

    /** @see var_export2() */
    public self $var_export2;
    public function var_export2($value, $options = []): self { }
    public function var_export2($options = []): self { }

}
