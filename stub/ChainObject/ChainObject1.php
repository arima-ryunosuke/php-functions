<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject1
{
    /** @see gmdate() */
    public self $gmdate;
    public function gmdate(string $format, ?int $timestamp = null): self { }
    public function gmdate(?int $timestamp = null): self { }

    /** @see date_add() */
    public self $date_add;
    public function date_add(\DateTime $object, \DateInterval $interval): self { }
    public function date_add(\DateInterval $interval): self { }

    /** @see date_timestamp_get() */
    public self $date_timestamp_get;
    public function date_timestamp_get(\DateTimeInterface $object): self { }
    public function date_timestamp_get(): self { }

    /** @see date_sunset() */
    public self $date_sunset;
    public function date_sunset(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunset(int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }

    /** @see preg_filter() */
    public self $preg_filter;
    public function preg_filter(array|string $pattern, array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_filter(array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }

    /** @see preg_split() */
    public self $preg_split;
    public function preg_split(string $pattern, string $subject, int $limit = -1, int $flags = 0): self { }
    public function preg_split(string $subject, int $limit = -1, int $flags = 0): self { }

    /** @see preg_quote() */
    public self $preg_quote;
    public function preg_quote(string $str, ?string $delimiter = null): self { }
    public function preg_quote(?string $delimiter = null): self { }

    /** @see set_time_limit() */
    public self $set_time_limit;
    public function set_time_limit(int $seconds): self { }
    public function set_time_limit(): self { }

    /** @see array_flip() */
    public self $array_flip;
    public function array_flip(array $array): self { }
    public function array_flip(): self { }

    /** @see array_flip() */
    public self $flip;
    public function flip(array $array): self { }
    public function flip(): self { }

    /** @see array_intersect_key() */
    public self $array_intersect_key;
    public function array_intersect_key(array ...$arrays): self { }
    public function array_intersect_key(): self { }

    /** @see array_intersect_key() */
    public self $intersect_key;
    public function intersect_key(array ...$arrays): self { }
    public function intersect_key(): self { }

    /** @see putenv() */
    public self $putenv;
    public function putenv(string $assignment): self { }
    public function putenv(): self { }

    /** @see sleep() */
    public self $sleep;
    public function sleep(int $seconds): self { }
    public function sleep(): self { }

    /** @see usleep() */
    public self $usleep;
    public function usleep(int $microseconds): self { }
    public function usleep(): self { }

    /** @see highlight_string() */
    public self $highlight_string;
    public function highlight_string(string $string, bool $return = false): self { }
    public function highlight_string(bool $return = false): self { }

    /** @see set_include_path() */
    public self $set_include_path;
    public function set_include_path(string $include_path): self { }
    public function set_include_path(): self { }

    /** @see register_tick_function() */
    public self $register_tick_function;
    public function register_tick_function(callable $callback, mixed ...$args): self { }
    public function register_tick_function(mixed ...$args): self { }

    /** @see move_uploaded_file() */
    public self $move_uploaded_file;
    public function move_uploaded_file(string $from, string $to): self { }
    public function move_uploaded_file(string $to): self { }

    /** @see rtrim() */
    public self $rtrim;
    public function rtrim(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function rtrim(string $characters = " \n\r\t\v\000"): self { }

    /** @see ltrim() */
    public self $ltrim;
    public function ltrim(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function ltrim(string $characters = " \n\r\t\v\000"): self { }

    /** @see wordwrap() */
    public self $wordwrap;
    public function wordwrap(string $string, int $width = 75, string $break = "\n", bool $cut_long_words = false): self { }
    public function wordwrap(int $width = 75, string $break = "\n", bool $cut_long_words = false): self { }

    /** @see strchr() */
    public self $strchr;
    public function strchr(string $haystack, string $needle, bool $before_needle = false): self { }
    public function strchr(string $needle, bool $before_needle = false): self { }

    /** @see lcfirst() */
    public self $lcfirst;
    public function lcfirst(string $string): self { }
    public function lcfirst(): self { }

    /** @see str_ireplace() */
    public self $str_ireplace;
    public function str_ireplace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function str_ireplace(array|string $replace, array|string $subject, &$count = null): self { }

    /** @see str_ireplace() */
    public self $ireplace;
    public function ireplace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function ireplace(array|string $replace, array|string $subject, &$count = null): self { }

    /** @see str_shuffle() */
    public self $str_shuffle;
    public function str_shuffle(string $string): self { }
    public function str_shuffle(): self { }

    /** @see str_shuffle() */
    public self $shuffle;
    public function shuffle(string $string): self { }
    public function shuffle(): self { }

    /** @see substr_compare() */
    public self $substr_compare;
    public function substr_compare(string $haystack, string $needle, int $offset, ?int $length = null, bool $case_insensitive = false): self { }
    public function substr_compare(string $needle, int $offset, ?int $length = null, bool $case_insensitive = false): self { }

    /** @see utf8_decode() */
    public self $utf8_decode;
    public function utf8_decode(string $string): self { }
    public function utf8_decode(): self { }

    /** @see popen() */
    public self $popen;
    public function popen(string $command, string $mode): self { }
    public function popen(string $mode): self { }

    /** @see fclose() */
    public self $fclose;
    public function fclose($stream): self { }
    public function fclose(): self { }

    /** @see tempnam() */
    public self $tempnam;
    public function tempnam(string $directory, string $prefix): self { }
    public function tempnam(string $prefix): self { }

    /** @see realpath() */
    public self $realpath;
    public function realpath(string $path): self { }
    public function realpath(): self { }

    /** @see is_executable() */
    public self $is_executable;
    public function is_executable(string $filename): self { }
    public function is_executable(): self { }

    /** @see is_file() */
    public self $is_file;
    public function is_file(string $filename): self { }
    public function is_file(): self { }

    /** @see iptcembed() */
    public self $iptcembed;
    public function iptcembed(string $iptc_data, string $filename, int $spool = 0): self { }
    public function iptcembed(string $filename, int $spool = 0): self { }

    /** @see levenshtein() */
    public self $levenshtein;
    public function levenshtein(string $string1, string $string2, int $insertion_cost = 1, int $replacement_cost = 1, int $deletion_cost = 1): self { }
    public function levenshtein(string $string2, int $insertion_cost = 1, int $replacement_cost = 1, int $deletion_cost = 1): self { }

    /** @see ceil() */
    public self $ceil;
    public function ceil(int|float $num): self { }
    public function ceil(): self { }

    /** @see tan() */
    public self $tan;
    public function tan(float $num): self { }
    public function tan(): self { }

    /** @see sqrt() */
    public self $sqrt;
    public function sqrt(float $num): self { }
    public function sqrt(): self { }

    /** @see unpack() */
    public self $unpack;
    public function unpack(string $format, string $string, int $offset = 0): self { }
    public function unpack(string $string, int $offset = 0): self { }

    /** @see password_needs_rehash() */
    public self $password_needs_rehash;
    public function password_needs_rehash(string $hash, string|int|null $algo, array $options = []): self { }
    public function password_needs_rehash(string|int|null $algo, array $options = []): self { }

    /** @see get_debug_type() */
    public self $get_debug_type;
    public function get_debug_type(mixed $value): self { }
    public function get_debug_type(): self { }

    /** @see settype() */
    public self $settype;
    public function settype(mixed &$var, string $type): self { }
    public function settype(string $type): self { }

    /** @see intval() */
    public self $intval;
    public function intval(mixed $value, int $base = 10): self { }
    public function intval(int $base = 10): self { }

    /** @see boolval() */
    public self $boolval;
    public function boolval(mixed $value): self { }
    public function boolval(): self { }

    /** @see is_int() */
    public self $is_int;
    public function is_int(mixed $value): self { }
    public function is_int(): self { }

    /** @see is_integer() */
    public self $is_integer;
    public function is_integer(mixed $value): self { }
    public function is_integer(): self { }

    /** @see is_long() */
    public self $is_long;
    public function is_long(mixed $value): self { }
    public function is_long(): self { }

    /** @see is_string() */
    public self $is_string;
    public function is_string(mixed $value): self { }
    public function is_string(): self { }

    /** @see is_callable() */
    public self $is_callable;
    public function is_callable(mixed $value, bool $syntax_only = false, callable &$callable_name = null): self { }
    public function is_callable(bool $syntax_only = false, callable &$callable_name = null): self { }

    /** @see uniqid() */
    public self $uniqid;
    public function uniqid(string $prefix = "", bool $more_entropy = false): self { }
    public function uniqid(bool $more_entropy = false): self { }

    /** @see urldecode() */
    public self $urldecode;
    public function urldecode(string $string): self { }
    public function urldecode(): self { }

    /** @see mb_language() */
    public self $mb_language;
    public function mb_language(?string $language = null): self { }
    public function mb_language(): self { }

    /** @see mb_str_split() */
    public self $mb_str_split;
    public function mb_str_split(string $string, int $length = 1, ?string $encoding = null): self { }
    public function mb_str_split(int $length = 1, ?string $encoding = null): self { }

    /** @see mb_strrchr() */
    public self $mb_strrchr;
    public function mb_strrchr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrchr(string $needle, bool $before_needle = false, ?string $encoding = null): self { }

    /** @see mb_strrichr() */
    public self $mb_strrichr;
    public function mb_strrichr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrichr(string $needle, bool $before_needle = false, ?string $encoding = null): self { }

    /** @see mb_substr_count() */
    public self $mb_substr_count;
    public function mb_substr_count(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_substr_count(string $needle, ?string $encoding = null): self { }

    /** @see mb_strwidth() */
    public self $mb_strwidth;
    public function mb_strwidth(string $string, ?string $encoding = null): self { }
    public function mb_strwidth(?string $encoding = null): self { }

    /** @see mb_encoding_aliases() */
    public self $mb_encoding_aliases;
    public function mb_encoding_aliases(string $encoding): self { }
    public function mb_encoding_aliases(): self { }

    /** @see mb_encode_numericentity() */
    public self $mb_encode_numericentity;
    public function mb_encode_numericentity(string $string, array $map, ?string $encoding = null, bool $hex = false): self { }
    public function mb_encode_numericentity(array $map, ?string $encoding = null, bool $hex = false): self { }

    /** @see mb_check_encoding() */
    public self $mb_check_encoding;
    public function mb_check_encoding(array|string|null $value = null, ?string $encoding = null): self { }
    public function mb_check_encoding(?string $encoding = null): self { }

    /** @see mb_ereg_replace() */
    public self $mb_ereg_replace;
    public function mb_ereg_replace(string $pattern, string $replacement, string $string, ?string $options = null): self { }
    public function mb_ereg_replace(string $replacement, string $string, ?string $options = null): self { }

    /** @see mb_regex_set_options() */
    public self $mb_regex_set_options;
    public function mb_regex_set_options(?string $options = null): self { }
    public function mb_regex_set_options(): self { }

    /** @see dl() */
    public self $dl;
    public function dl(string $extension_filename): self { }
    public function dl(): self { }

    /** @see array_add() */
    public self $array_add;
    public function array_add(...$variadic): self { }
    public function array_add(): self { }

    /** @see array_add() */
    public self $add;
    public function add(...$variadic): self { }
    public function add(): self { }

    /** @see array_distinct() */
    public self $array_distinct;
    public function array_distinct(iterable $array, $comparator = null): self { }
    public function array_distinct($comparator = null): self { }

    /** @see array_distinct() */
    public self $distinct;
    public function distinct(iterable $array, $comparator = null): self { }
    public function distinct($comparator = null): self { }

    /** @see array_dive() */
    public self $array_dive;
    public function array_dive(iterable $array, $path, $default = null, $delimiter = "."): self { }
    public function array_dive($path, $default = null, $delimiter = "."): self { }

    /** @see array_dive() */
    public self $dive;
    public function dive(iterable $array, $path, $default = null, $delimiter = "."): self { }
    public function dive($path, $default = null, $delimiter = "."): self { }

    /** @see array_explode() */
    public self $array_explode;
    public function array_explode(iterable $array, $condition, $limit = PHP_INT_MAX): self { }
    public function array_explode($condition, $limit = PHP_INT_MAX): self { }

    /** @see array_explode() */
    public self $explode;
    public function explode(iterable $array, $condition, $limit = PHP_INT_MAX): self { }
    public function explode($condition, $limit = PHP_INT_MAX): self { }

    /** @see array_kvmap() */
    public self $array_kvmap;
    public function array_kvmap(iterable $array, callable $callback): self { }
    public function array_kvmap(callable $callback): self { }

    /** @see array_kvmap() */
    public self $kvmap;
    public function kvmap(iterable $array, callable $callback): self { }
    public function kvmap(callable $callback): self { }

    /** @see array_range() */
    public self $array_range;
    public function array_range($start, $end, $step = null, $options = []): self { }
    public function array_range($end, $step = null, $options = []): self { }

    /** @see array_range() */
    public self $range;
    public function range($start, $end, $step = null, $options = []): self { }
    public function range($end, $step = null, $options = []): self { }

    /** @see is_indexarray() */
    public self $is_indexarray;
    public function is_indexarray(iterable $array): self { }
    public function is_indexarray(): self { }

    /** @see prev_key() */
    public self $prev_key;
    public function prev_key(iterable $array, $key): self { }
    public function prev_key($key): self { }

    /** @see class_aliases() */
    public self $class_aliases;
    public function class_aliases($aliases): self { }
    public function class_aliases(): self { }

    /** @see sql_format() */
    public self $sql_format;
    public function sql_format($sql, $options = []): self { }
    public function sql_format($options = []): self { }

    /** @see date_interval_string() */
    public self $date_interval_string;
    public function date_interval_string($interval, $format = null, $limit_type = "y"): self { }
    public function date_interval_string($format = null, $limit_type = "y"): self { }

    /** @see date_modulate() */
    public self $date_modulate;
    public function date_modulate($datetimedata, $modify): self { }
    public function date_modulate($modify): self { }

    /** @see now() */
    public self $now;
    public function now($persistence = true): self { }
    public function now(): self { }

    /** @see process_parallel() */
    public self $process_parallel;
    public function process_parallel($tasks, $args = [], $autoload = null, $workdir = null, $env = null, $options = null): self { }
    public function process_parallel($args = [], $autoload = null, $workdir = null, $env = null, $options = null): self { }

    /** @see dirname_r() */
    public self $dirname_r;
    public function dirname_r($path, callable $callback): self { }
    public function dirname_r(callable $callback): self { }

    /** @see file_slice() */
    public self $file_slice;
    public function file_slice($filename, $start_line = 1, $length = null, $flags = 0, $context = null): self { }
    public function file_slice($start_line = 1, $length = null, $flags = 0, $context = null): self { }

    /** @see fnmatch_or() */
    public self $fnmatch_or;
    public function fnmatch_or($patterns, $string, $flags = 0): self { }
    public function fnmatch_or($string, $flags = 0): self { }

    /** @see is_callback() */
    public self $is_callback;
    public function is_callback(callable $callable): self { }
    public function is_callback(): self { }

    /** @see ansi_colorize() */
    public self $ansi_colorize;
    public function ansi_colorize($string, $color): self { }
    public function ansi_colorize($color): self { }

    /** @see sys_set_temp_dir() */
    public self $sys_set_temp_dir;
    public function sys_set_temp_dir($directory, $creates = true, $check_settled = true): self { }
    public function sys_set_temp_dir($creates = true, $check_settled = true): self { }

    /** @see iterator_map() */
    public self $iterator_map;
    public function iterator_map(callable $callback, iterable ...$iterables): self { }
    public function iterator_map(iterable ...$iterables): self { }

    /** @see maximum() */
    public self $maximum;
    public function maximum(...$variadic): self { }
    public function maximum(): self { }

    /** @see mode() */
    public self $mode;
    public function mode(...$variadic): self { }
    public function mode(): self { }

    /** @see ip2cidr() */
    public self $ip2cidr;
    public function ip2cidr($fromipaddr, $toipaddr): self { }
    public function ip2cidr($toipaddr): self { }

    /** @see preg_capture() */
    public self $preg_capture;
    public function preg_capture($pattern, $subject, $default): self { }
    public function preg_capture($subject, $default): self { }

    /** @see random_float() */
    public self $random_float;
    public function random_float($min, $max): self { }
    public function random_float($max): self { }

    /** @see random_range() */
    public self $random_range;
    public function random_range($min, $max, $count = null): self { }
    public function random_range($max, $count = null): self { }

    /** @see ngram() */
    public self $ngram;
    public function ngram($string, $N, $encoding = "UTF-8"): self { }
    public function ngram($N, $encoding = "UTF-8"): self { }

    /** @see snake_case() */
    public self $snake_case;
    public function snake_case($string, $delimiter = "_", $keep_abbr = false): self { }
    public function snake_case($delimiter = "_", $keep_abbr = false): self { }

    /** @see str_lchop() */
    public self $str_lchop;
    public function str_lchop($string, $prefix, $case_insensitivity = false): self { }
    public function str_lchop($prefix, $case_insensitivity = false): self { }

    /** @see str_lchop() */
    public self $lchop;
    public function lchop($string, $prefix, $case_insensitivity = false): self { }
    public function lchop($prefix, $case_insensitivity = false): self { }

    /** @see str_subreplace() */
    public self $str_subreplace;
    public function str_subreplace($subject, $search, $replaces, $case_insensitivity = false): self { }
    public function str_subreplace($search, $replaces, $case_insensitivity = false): self { }

    /** @see str_subreplace() */
    public self $subreplace;
    public function subreplace($subject, $search, $replaces, $case_insensitivity = false): self { }
    public function subreplace($search, $replaces, $case_insensitivity = false): self { }

    /** @see dataurl_decode() */
    public self $dataurl_decode;
    public function dataurl_decode($url, &$metadata = []): self { }
    public function dataurl_decode(&$metadata = []): self { }

    /** @see attr_exists() */
    public self $attr_exists;
    public function attr_exists($key, $value): self { }
    public function attr_exists($value): self { }

    /** @see varcmp() */
    public self $varcmp;
    public function varcmp($a, $b, $mode = null, $precision = null): self { }
    public function varcmp($b, $mode = null, $precision = null): self { }

}
