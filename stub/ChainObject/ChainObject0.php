<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject0
{
    /** @see date_parse() */
    public self $date_parse;
    public function date_parse(string $datetime): self { }
    public function date_parse(): self { }

    /** @see date_timezone_set() */
    public self $date_timezone_set;
    public function date_timezone_set(\DateTime $object, \DateTimeZone $timezone): self { }
    public function date_timezone_set(\DateTimeZone $timezone): self { }

    /** @see date_offset_get() */
    public self $date_offset_get;
    public function date_offset_get(\DateTimeInterface $object): self { }
    public function date_offset_get(): self { }

    /** @see preg_grep() */
    public self $preg_grep;
    public function preg_grep(string $pattern, array $array, int $flags = 0): self { }
    public function preg_grep(array $array, int $flags = 0): self { }

    /** @see hash_update_stream() */
    public self $hash_update_stream;
    public function hash_update_stream(\HashContext $context, $stream, int $length = -1): self { }
    public function hash_update_stream($stream, int $length = -1): self { }

    /** @see uasort() */
    public self $uasort;
    public function uasort(array &$array, callable $callback): self { }
    public function uasort(callable $callback): self { }

    /** @see uksort() */
    public self $uksort;
    public function uksort(array &$array, callable $callback): self { }
    public function uksort(callable $callback): self { }

    /** @see key() */
    public self $key;
    public function key(object|array $array): self { }
    public function key(): self { }

    /** @see array_merge_recursive() */
    public self $array_merge_recursive;
    public function array_merge_recursive(array ...$arrays): self { }
    public function array_merge_recursive(): self { }

    /** @see array_merge_recursive() */
    public self $merge_recursive;
    public function merge_recursive(array ...$arrays): self { }
    public function merge_recursive(): self { }

    /** @see array_reverse() */
    public self $array_reverse;
    public function array_reverse(array $array, bool $preserve_keys = false): self { }
    public function array_reverse(bool $preserve_keys = false): self { }

    /** @see array_reverse() */
    public self $reverse;
    public function reverse(array $array, bool $preserve_keys = false): self { }
    public function reverse(bool $preserve_keys = false): self { }

    /** @see array_udiff_uassoc() */
    public self $array_udiff_uassoc;
    public function array_udiff_uassoc(array $array, ...$rest): self { }
    public function array_udiff_uassoc(...$rest): self { }

    /** @see array_udiff_uassoc() */
    public self $udiff_uassoc;
    public function udiff_uassoc(array $array, ...$rest): self { }
    public function udiff_uassoc(...$rest): self { }

    /** @see time_nanosleep() */
    public self $time_nanosleep;
    public function time_nanosleep(int $seconds, int $nanoseconds): self { }
    public function time_nanosleep(int $nanoseconds): self { }

    /** @see highlight_file() */
    public self $highlight_file;
    public function highlight_file(string $filename, bool $return = false): self { }
    public function highlight_file(bool $return = false): self { }

    /** @see show_source() */
    public self $show_source;
    public function show_source(string $filename, bool $return = false): self { }
    public function show_source(bool $return = false): self { }

    /** @see ini_get() */
    public self $ini_get;
    public function ini_get(string $option): self { }
    public function ini_get(): self { }

    /** @see ignore_user_abort() */
    public self $ignore_user_abort;
    public function ignore_user_abort(?bool $enable = null): self { }
    public function ignore_user_abort(): self { }

    /** @see get_browser() */
    public self $get_browser;
    public function get_browser(?string $user_agent = null, bool $return_array = false): self { }
    public function get_browser(bool $return_array = false): self { }

    /** @see getmxrr() */
    public self $getmxrr;
    public function getmxrr(string $hostname, &$hosts, &$weights = null): self { }
    public function getmxrr(&$hosts, &$weights = null): self { }

    /** @see bin2hex() */
    public self $bin2hex;
    public function bin2hex(string $string): self { }
    public function bin2hex(): self { }

    /** @see strrpos() */
    public self $strrpos;
    public function strrpos(string $haystack, string $needle, int $offset = 0): self { }
    public function strrpos(string $needle, int $offset = 0): self { }

    /** @see substr_replace() */
    public self $substr_replace;
    public function substr_replace(array|string $string, array|string $replace, array|int $offset, array|int|null $length = null): self { }
    public function substr_replace(array|string $replace, array|int $offset, array|int|null $length = null): self { }

    /** @see ucfirst() */
    public self $ucfirst;
    public function ucfirst(string $string): self { }
    public function ucfirst(): self { }

    /** @see str_getcsv() */
    public self $str_getcsv;
    public function str_getcsv(string $string, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function str_getcsv(string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }

    /** @see str_getcsv() */
    public self $getcsv;
    public function getcsv(string $string, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function getcsv(string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }

    /** @see substr_count() */
    public self $substr_count;
    public function substr_count(string $haystack, string $needle, int $offset = 0, ?int $length = null): self { }
    public function substr_count(string $needle, int $offset = 0, ?int $length = null): self { }

    /** @see rewinddir() */
    public self $rewinddir;
    public function rewinddir($dir_handle = null): self { }
    public function rewinddir(): self { }

    /** @see file() */
    public self $file;
    public function file(string $filename, int $flags = 0, $context = null): self { }
    public function file(int $flags = 0, $context = null): self { }

    /** @see file_get_contents() */
    public self $file_get_contents;
    public function file_get_contents(string $filename, bool $use_include_path = false, $context = null, int $offset = 0, ?int $length = null): self { }
    public function file_get_contents(bool $use_include_path = false, $context = null, int $offset = 0, ?int $length = null): self { }

    /** @see file_put_contents() */
    public self $file_put_contents;
    public function file_put_contents(string $filename, mixed $data, int $flags = 0, $context = null): self { }
    public function file_put_contents(mixed $data, int $flags = 0, $context = null): self { }

    /** @see disk_total_space() */
    public self $disk_total_space;
    public function disk_total_space(string $directory): self { }
    public function disk_total_space(): self { }

    /** @see log() */
    public self $log;
    public function log(float $num, float $base = M_E): self { }
    public function log(float $base = M_E): self { }

    /** @see hypot() */
    public self $hypot;
    public function hypot(float $x, float $y): self { }
    public function hypot(float $y): self { }

    /** @see pack() */
    public self $pack;
    public function pack(string $format, mixed ...$values): self { }
    public function pack(mixed ...$values): self { }

    /** @see srand() */
    public self $srand;
    public function srand(int $seed = 0, int $mode = MT_RAND_MT19937): self { }
    public function srand(int $mode = MT_RAND_MT19937): self { }

    /** @see gettype() */
    public self $gettype;
    public function gettype(mixed $value): self { }
    public function gettype(): self { }

    /** @see is_array() */
    public self $is_array;
    public function is_array(mixed $value): self { }
    public function is_array(): self { }

    /** @see parse_url() */
    public self $parse_url;
    public function parse_url(string $url, int $component = -1): self { }
    public function parse_url(int $component = -1): self { }

    /** @see convert_uuencode() */
    public self $convert_uuencode;
    public function convert_uuencode(string $string): self { }
    public function convert_uuencode(): self { }

    /** @see mb_stripos() */
    public self $mb_stripos;
    public function mb_stripos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_stripos(string $needle, int $offset = 0, ?string $encoding = null): self { }

    /** @see mb_ord() */
    public self $mb_ord;
    public function mb_ord(string $string, ?string $encoding = null): self { }
    public function mb_ord(?string $encoding = null): self { }

    /** @see array_assort() */
    public self $array_assort;
    public function array_assort(iterable $array, $rules): self { }
    public function array_assort($rules): self { }

    /** @see array_assort() */
    public self $assort;
    public function assort(iterable $array, $rules): self { }
    public function assort($rules): self { }

    /** @see array_convert() */
    public self $array_convert;
    public function array_convert(iterable $array, callable $callback, iterable $apply_array = false): self { }
    public function array_convert(callable $callback, iterable $apply_array = false): self { }

    /** @see array_convert() */
    public self $convert;
    public function convert(iterable $array, callable $callback, iterable $apply_array = false): self { }
    public function convert(callable $callback, iterable $apply_array = false): self { }

    /** @see array_fill_callback() */
    public self $array_fill_callback;
    public function array_fill_callback($keys, callable $callback): self { }
    public function array_fill_callback(callable $callback): self { }

    /** @see array_fill_callback() */
    public self $fill_callback;
    public function fill_callback($keys, callable $callback): self { }
    public function fill_callback(callable $callback): self { }

    /** @see array_implode() */
    public self $array_implode;
    public function array_implode(iterable $array, $glue): self { }
    public function array_implode($glue): self { }

    /** @see array_implode() */
    public self $implode;
    public function implode(iterable $array, $glue): self { }
    public function implode($glue): self { }

    /** @see array_maps() */
    public self $array_maps;
    public function array_maps(iterable $array, callable ...$callbacks): self { }
    public function array_maps(callable ...$callbacks): self { }

    /** @see array_maps() */
    public self $maps;
    public function maps(iterable $array, callable ...$callbacks): self { }
    public function maps(callable ...$callbacks): self { }

    /** @see array_nest() */
    public self $array_nest;
    public function array_nest(iterable $array, $delimiter = "."): self { }
    public function array_nest($delimiter = "."): self { }

    /** @see array_nest() */
    public self $nest;
    public function nest(iterable $array, $delimiter = "."): self { }
    public function nest($delimiter = "."): self { }

    /** @see array_order() */
    public self $array_order;
    public function array_order(array $array, $orders, $preserve_keys = false): self { }
    public function array_order($orders, $preserve_keys = false): self { }

    /** @see array_order() */
    public self $order;
    public function order(array $array, $orders, $preserve_keys = false): self { }
    public function order($orders, $preserve_keys = false): self { }

    /** @see array_rank() */
    public self $array_rank;
    public function array_rank(iterable $array, $length, $rankfunction = null): self { }
    public function array_rank($length, $rankfunction = null): self { }

    /** @see array_rank() */
    public self $rank;
    public function rank(iterable $array, $length, $rankfunction = null): self { }
    public function rank($length, $rankfunction = null): self { }

    /** @see array_rekey() */
    public self $array_rekey;
    public function array_rekey(iterable $array, $keymap): self { }
    public function array_rekey($keymap): self { }

    /** @see array_rekey() */
    public self $rekey;
    public function rekey(iterable $array, $keymap): self { }
    public function rekey($keymap): self { }

    /** @see array_set() */
    public self $array_set;
    public function array_set(iterable &$array, $value, $key = null, $condition = null): self { }
    public function array_set($value, $key = null, $condition = null): self { }

    /** @see array_set() */
    public self $set;
    public function set(iterable &$array, $value, $key = null, $condition = null): self { }
    public function set($value, $key = null, $condition = null): self { }

    /** @see array_uncolumns() */
    public self $array_uncolumns;
    public function array_uncolumns(iterable $array, $template = null): self { }
    public function array_uncolumns($template = null): self { }

    /** @see array_uncolumns() */
    public self $uncolumns;
    public function uncolumns(iterable $array, $template = null): self { }
    public function uncolumns($template = null): self { }

    /** @see in_array_or() */
    public self $in_array_or;
    public function in_array_or($needle, $haystack, $strict = false): self { }
    public function in_array_or($haystack, $strict = false): self { }

    /** @see object_dive() */
    public self $object_dive;
    public function object_dive($object, $path, $default = null, $delimiter = "."): self { }
    public function object_dive($path, $default = null, $delimiter = "."): self { }

    /** @see object_storage() */
    public self $object_storage;
    public function object_storage($namespace = "global"): self { }
    public function object_storage(): self { }

    /** @see json_import() */
    public self $json_import;
    public function json_import($value, $options = []): self { }
    public function json_import($options = []): self { }

    /** @see date_interval() */
    public self $date_interval;
    public function date_interval($interval): self { }
    public function date_interval(): self { }

    /** @see date_timestamp() */
    public self $date_timestamp;
    public function date_timestamp($datetimedata, $baseTimestamp = null): self { }
    public function date_timestamp($baseTimestamp = null): self { }

    /** @see set_trace_logger() */
    public self $set_trace_logger;
    public function set_trace_logger($logger, string $target): self { }
    public function set_trace_logger(string $target): self { }

    /** @see process() */
    public self $process;
    public function process($command, $args = [], $stdin = "", &$stdout = "", &$stderr = "", $cwd = null, ?array $env = null, $options = null): self { }
    public function process($args = [], $stdin = "", &$stdout = "", &$stderr = "", $cwd = null, ?array $env = null, $options = null): self { }

    /** @see file_list() */
    public self $file_list;
    public function file_list($dirname, $filter_condition = []): self { }
    public function file_list($filter_condition = []): self { }

    /** @see file_matcher() */
    public self $file_matcher;
    public function file_matcher(array $filter_condition): self { }
    public function file_matcher(): self { }

    /** @see mkdir_p() */
    public self $mkdir_p;
    public function mkdir_p($dirname, $umask = 2): self { }
    public function mkdir_p($umask = 2): self { }

    /** @see path_parse() */
    public self $path_parse;
    public function path_parse($path): self { }
    public function path_parse(): self { }

    /** @see func_eval() */
    public self $func_eval;
    public function func_eval($expression, ...$variadic): self { }
    public function func_eval(...$variadic): self { }

    /** @see func_new() */
    public self $func_new;
    public function func_new($classname, ...$defaultargs): self { }
    public function func_new(...$defaultargs): self { }

    /** @see get_modified_files() */
    public self $get_modified_files;
    public function get_modified_files($target_pattern = "*.php", $ignore_pattern = "*.phtml"): self { }
    public function get_modified_files($ignore_pattern = "*.phtml"): self { }

    /** @see base_convert_array() */
    public self $base_convert_array;
    public function base_convert_array(iterable $array, $from_base, $to_base): self { }
    public function base_convert_array($from_base, $to_base): self { }

    /** @see http_request() */
    public self $http_request;
    public function http_request($options = [], &$response_header = [], &$info = []): self { }
    public function http_request(&$response_header = [], &$info = []): self { }

    /** @see ends_with() */
    public self $ends_with;
    public function ends_with(?string $string, $with, $case_insensitivity = false): self { }
    public function ends_with($with, $case_insensitivity = false): self { }

    /** @see mb_compatible_encoding() */
    public self $mb_compatible_encoding;
    public function mb_compatible_encoding(?string $from, ?string $to): self { }
    public function mb_compatible_encoding(?string $to): self { }

    /** @see str_anyof() */
    public self $str_anyof;
    public function str_anyof(?string $needle, $haystack, $case_insensitivity = false): self { }
    public function str_anyof($haystack, $case_insensitivity = false): self { }

    /** @see str_anyof() */
    public self $anyof;
    public function anyof(?string $needle, $haystack, $case_insensitivity = false): self { }
    public function anyof($haystack, $case_insensitivity = false): self { }

    /** @see str_diff() */
    public self $str_diff;
    public function str_diff($xstring, $ystring, $options = []): self { }
    public function str_diff($ystring, $options = []): self { }

    /** @see str_diff() */
    public self $diff;
    public function diff($xstring, $ystring, $options = []): self { }
    public function diff($ystring, $options = []): self { }

    /** @see strposr() */
    public self $strposr;
    public function strposr(string $haystack, string $needle, ?int $offset = null): self { }
    public function strposr(string $needle, ?int $offset = null): self { }

    /** @see strrstr() */
    public self $strrstr;
    public function strrstr(?string $haystack, ?string $needle, $after_needle = true): self { }
    public function strrstr(?string $needle, $after_needle = true): self { }

    /** @see try_catch_finally() */
    public self $try_catch_finally;
    public function try_catch_finally($try, $catch = null, $finally = null, ...$variadic): self { }
    public function try_catch_finally($catch = null, $finally = null, ...$variadic): self { }

    /** @see try_close() */
    public self $try_close;
    public function try_close(callable $callback, ...$resources): self { }
    public function try_close(...$resources): self { }

    /** @see base62_decode() */
    public self $base62_decode;
    public function base62_decode($string): self { }
    public function base62_decode(): self { }

    /** @see base64url_decode() */
    public self $base64url_decode;
    public function base64url_decode($string): self { }
    public function base64url_decode(): self { }

    /** @see query_parse() */
    public self $query_parse;
    public function query_parse($query, $arg_separator = null, $encoding_type = null): self { }
    public function query_parse($arg_separator = null, $encoding_type = null): self { }

    /** @see cache_fetch() */
    public self $cache_fetch;
    public function cache_fetch($cacher, $key, $provider, $ttl = null): self { }
    public function cache_fetch($key, $provider, $ttl = null): self { }

    /** @see cipher_metadata() */
    public self $cipher_metadata;
    public function cipher_metadata($cipher): self { }
    public function cipher_metadata(): self { }

    /** @see is_typeof() */
    public self $is_typeof;
    public function is_typeof($var, string $typestring, $context = null): self { }
    public function is_typeof(string $typestring, $context = null): self { }

    /** @see numberify() */
    public self $numberify;
    public function numberify($var, $decimal = false): self { }
    public function numberify($decimal = false): self { }

    /** @see si_unprefix() */
    public self $si_unprefix;
    public function si_unprefix($var, $unit = 1000): self { }
    public function si_unprefix($unit = 1000): self { }

    /** @see var_html() */
    public self $var_html;
    public function var_html($value): self { }
    public function var_html(): self { }

}
