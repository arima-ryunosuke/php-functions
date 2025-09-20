<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject6
{
    /** @see mktime() */
    public self $mktime;
    public function mktime(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function mktime(?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }

    /** @see localtime() */
    public self $localtime;
    public function localtime(?int $timestamp = null, bool $associative = false): self { }
    public function localtime(bool $associative = false): self { }

    /** @see date_parse_from_format() */
    public self $date_parse_from_format;
    public function date_parse_from_format(string $format, string $datetime): self { }
    public function date_parse_from_format(string $datetime): self { }

    /** @see date_modify() */
    public self $date_modify;
    public function date_modify(\DateTime $object, string $modifier): self { }
    public function date_modify(string $modifier): self { }

    /** @see preg_replace() */
    public self $preg_replace;
    public function preg_replace(array|string $pattern, array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_replace(array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }

    /** @see preg_replace_callback_array() */
    public self $preg_replace_callback_array;
    public function preg_replace_callback_array(array $pattern, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback_array(array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }

    /** @see hash_hmac() */
    public self $hash_hmac;
    public function hash_hmac(string $algo, string $data, string $key, bool $binary = false): self { }
    public function hash_hmac(string $data, string $key, bool $binary = false): self { }

    /** @see hash_copy() */
    public self $hash_copy;
    public function hash_copy(\HashContext $context): self { }
    public function hash_copy(): self { }

    /** @see count() */
    public self $count;
    public function count(\Countable|array $value, int $mode = COUNT_NORMAL): self { }
    public function count(int $mode = COUNT_NORMAL): self { }

    /** @see rsort() */
    public self $rsort;
    public function rsort(array &$array, int $flags = SORT_REGULAR): self { }
    public function rsort(int $flags = SORT_REGULAR): self { }

    /** @see min() */
    public self $min;
    public function min(mixed ...$values): self { }
    public function min(): self { }

    /** @see array_walk_recursive() */
    public self $array_walk_recursive;
    public function array_walk_recursive(object|array &$array, callable $callback, mixed $arg = null): self { }
    public function array_walk_recursive(callable $callback, mixed $arg = null): self { }

    /** @see array_walk_recursive() */
    public self $walk_recursive;
    public function walk_recursive(object|array &$array, callable $callback, mixed $arg = null): self { }
    public function walk_recursive(callable $callback, mixed $arg = null): self { }

    /** @see array_fill_keys() */
    public self $array_fill_keys;
    public function array_fill_keys(array $keys, mixed $value): self { }
    public function array_fill_keys(mixed $value): self { }

    /** @see array_fill_keys() */
    public self $fill_keys;
    public function fill_keys(array $keys, mixed $value): self { }
    public function fill_keys(mixed $value): self { }

    /** @see array_slice() */
    public self $array_slice;
    public function array_slice(array $array, int $offset, ?int $length = null, bool $preserve_keys = false): self { }
    public function array_slice(int $offset, ?int $length = null, bool $preserve_keys = false): self { }

    /** @see array_slice() */
    public self $slice;
    public function slice(array $array, int $offset, ?int $length = null, bool $preserve_keys = false): self { }
    public function slice(int $offset, ?int $length = null, bool $preserve_keys = false): self { }

    /** @see array_key_last() */
    public self $array_key_last;
    public function array_key_last(array $array): self { }
    public function array_key_last(): self { }

    /** @see array_key_last() */
    public self $key_last;
    public function key_last(array $array): self { }
    public function key_last(): self { }

    /** @see array_values() */
    public self $array_values;
    public function array_values(array $array): self { }
    public function array_values(): self { }

    /** @see array_values() */
    public self $values;
    public function values(array $array): self { }
    public function values(): self { }

    /** @see array_pad() */
    public self $array_pad;
    public function array_pad(array $array, int $length, mixed $value): self { }
    public function array_pad(int $length, mixed $value): self { }

    /** @see array_pad() */
    public self $pad;
    public function pad(array $array, int $length, mixed $value): self { }
    public function pad(int $length, mixed $value): self { }

    /** @see array_uintersect() */
    public self $array_uintersect;
    public function array_uintersect(array $array, ...$rest): self { }
    public function array_uintersect(...$rest): self { }

    /** @see array_uintersect() */
    public self $uintersect;
    public function uintersect(array $array, ...$rest): self { }
    public function uintersect(...$rest): self { }

    /** @see array_udiff() */
    public self $array_udiff;
    public function array_udiff(array $array, ...$rest): self { }
    public function array_udiff(...$rest): self { }

    /** @see array_udiff() */
    public self $udiff;
    public function udiff(array $array, ...$rest): self { }
    public function udiff(...$rest): self { }

    /** @see sha1() */
    public self $sha1;
    public function sha1(string $string, bool $binary = false): self { }
    public function sha1(bool $binary = false): self { }

    /** @see metaphone() */
    public self $metaphone;
    public function metaphone(string $string, int $max_phonemes = 0): self { }
    public function metaphone(int $max_phonemes = 0): self { }

    /** @see htmlspecialchars() */
    public self $htmlspecialchars;
    public function htmlspecialchars(string $string, int $flags = 11, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlspecialchars(int $flags = 11, ?string $encoding = null, bool $double_encode = true): self { }

    /** @see get_html_translation_table() */
    public self $get_html_translation_table;
    public function get_html_translation_table(int $table = HTML_SPECIALCHARS, int $flags = 11, string $encoding = "UTF-8"): self { }
    public function get_html_translation_table(int $flags = 11, string $encoding = "UTF-8"): self { }

    /** @see strcspn() */
    public self $strcspn;
    public function strcspn(string $string, string $characters, int $offset = 0, ?int $length = null): self { }
    public function strcspn(string $characters, int $offset = 0, ?int $length = null): self { }

    /** @see stripos() */
    public self $stripos;
    public function stripos(string $haystack, string $needle, int $offset = 0): self { }
    public function stripos(string $needle, int $offset = 0): self { }

    /** @see str_ends_with() */
    public self $str_ends_with;
    public function str_ends_with(string $haystack, string $needle): self { }
    public function str_ends_with(string $needle): self { }

    /** @see str_ends_with() */
    public self $ends_with;
    public function ends_with(string $haystack, string $needle): self { }
    public function ends_with(string $needle): self { }

    /** @see chunk_split() */
    public self $chunk_split;
    public function chunk_split(string $string, int $length = 76, string $separator = "\r\n"): self { }
    public function chunk_split(int $length = 76, string $separator = "\r\n"): self { }

    /** @see quotemeta() */
    public self $quotemeta;
    public function quotemeta(string $string): self { }
    public function quotemeta(): self { }

    /** @see strtr() */
    public self $strtr;
    public function strtr(string $string, array|string $from, ?string $to = null): self { }
    public function strtr(array|string $from, ?string $to = null): self { }

    /** @see stripcslashes() */
    public self $stripcslashes;
    public function stripcslashes(string $string): self { }
    public function stripcslashes(): self { }

    /** @see hebrev() */
    public self $hebrev;
    public function hebrev(string $string, int $max_chars_per_line = 0): self { }
    public function hebrev(int $max_chars_per_line = 0): self { }

    /** @see str_repeat() */
    public self $str_repeat;
    public function str_repeat(string $string, int $times): self { }
    public function str_repeat(int $times): self { }

    /** @see str_repeat() */
    public self $repeat;
    public function repeat(string $string, int $times): self { }
    public function repeat(int $times): self { }

    /** @see sscanf() */
    public self $sscanf;
    public function sscanf(string $string, string $format, mixed &...$vars): self { }
    public function sscanf(string $format, mixed &...$vars): self { }

    /** @see strpbrk() */
    public self $strpbrk;
    public function strpbrk(string $string, string $characters): self { }
    public function strpbrk(string $characters): self { }

    /** @see rewind() */
    public self $rewind;
    public function rewind($stream): self { }
    public function rewind(): self { }

    /** @see ftell() */
    public self $ftell;
    public function ftell($stream): self { }
    public function ftell(): self { }

    /** @see fwrite() */
    public self $fwrite;
    public function fwrite($stream, string $data, ?int $length = null): self { }
    public function fwrite(string $data, ?int $length = null): self { }

    /** @see fgetcsv() */
    public self $fgetcsv;
    public function fgetcsv($stream, ?int $length = null, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fgetcsv(?int $length = null, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }

    /** @see is_link() */
    public self $is_link;
    public function is_link(string $filename): self { }
    public function is_link(): self { }

    /** @see fsockopen() */
    public self $fsockopen;
    public function fsockopen(string $hostname, int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function fsockopen(int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }

    /** @see pfsockopen() */
    public self $pfsockopen;
    public function pfsockopen(string $hostname, int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function pfsockopen(int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }

    /** @see image_type_to_mime_type() */
    public self $image_type_to_mime_type;
    public function image_type_to_mime_type(int $image_type): self { }
    public function image_type_to_mime_type(): self { }

    /** @see php_uname() */
    public self $php_uname;
    public function php_uname(string $mode = "a"): self { }
    public function php_uname(): self { }

    /** @see cosh() */
    public self $cosh;
    public function cosh(float $num): self { }
    public function cosh(): self { }

    /** @see asinh() */
    public self $asinh;
    public function asinh(float $num): self { }
    public function asinh(): self { }

    /** @see intdiv() */
    public self $intdiv;
    public function intdiv(int $num1, int $num2): self { }
    public function intdiv(int $num2): self { }

    /** @see exp() */
    public self $exp;
    public function exp(float $num): self { }
    public function exp(): self { }

    /** @see dechex() */
    public self $dechex;
    public function dechex(int $num): self { }
    public function dechex(): self { }

    /** @see microtime() */
    public self $microtime;
    public function microtime(bool $as_float = false): self { }
    public function microtime(): self { }

    /** @see is_resource() */
    public self $is_resource;
    public function is_resource(mixed $value): self { }
    public function is_resource(): self { }

    /** @see is_bool() */
    public self $is_bool;
    public function is_bool(mixed $value): self { }
    public function is_bool(): self { }

    /** @see rawurldecode() */
    public self $rawurldecode;
    public function rawurldecode(string $string): self { }
    public function rawurldecode(): self { }

    /** @see get_headers() */
    public self $get_headers;
    public function get_headers(string $url, bool $associative = false, $context = null): self { }
    public function get_headers(bool $associative = false, $context = null): self { }

    /** @see memory_get_usage() */
    public self $memory_get_usage;
    public function memory_get_usage(bool $real_usage = false): self { }
    public function memory_get_usage(): self { }

    /** @see version_compare() */
    public self $version_compare;
    public function version_compare(string $version1, string $version2, ?string $operator = null): self { }
    public function version_compare(string $version2, ?string $operator = null): self { }

    /** @see mb_preferred_mime_name() */
    public self $mb_preferred_mime_name;
    public function mb_preferred_mime_name(string $encoding): self { }
    public function mb_preferred_mime_name(): self { }

    /** @see mb_parse_str() */
    public self $mb_parse_str;
    public function mb_parse_str(string $string, &$result): self { }
    public function mb_parse_str(&$result): self { }

    /** @see mb_strrpos() */
    public self $mb_strrpos;
    public function mb_strrpos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strrpos(string $needle, int $offset = 0, ?string $encoding = null): self { }

    /** @see mb_stristr() */
    public self $mb_stristr;
    public function mb_stristr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_stristr(string $needle, bool $before_needle = false, ?string $encoding = null): self { }

    /** @see mb_send_mail() */
    public self $mb_send_mail;
    public function mb_send_mail(string $to, string $subject, string $message, array|string $additional_headers = [], ?string $additional_params = null): self { }
    public function mb_send_mail(string $subject, string $message, array|string $additional_headers = [], ?string $additional_params = null): self { }

    /** @see mb_chr() */
    public self $mb_chr;
    public function mb_chr(int $codepoint, ?string $encoding = null): self { }
    public function mb_chr(?string $encoding = null): self { }

    /** @see mb_ereg_replace_callback() */
    public self $mb_ereg_replace_callback;
    public function mb_ereg_replace_callback(string $pattern, callable $callback, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback(callable $callback, string $string, ?string $options = null): self { }

    /** @see cli_set_process_title() */
    public self $cli_set_process_title;
    public function cli_set_process_title(string $title): self { }
    public function cli_set_process_title(): self { }

    /** @see array_cross() */
    public self $array_cross;
    public function array_cross(iterable ...$arrays): self { }
    public function array_cross(): self { }

    /** @see array_cross() */
    public self $cross;
    public function cross(iterable ...$arrays): self { }
    public function cross(): self { }

    /** @see array_divide() */
    public self $array_divide;
    public function array_divide(iterable $array, int $divisor, bool $preserve_keys = false): self { }
    public function array_divide(int $divisor, bool $preserve_keys = false): self { }

    /** @see array_divide() */
    public self $divide;
    public function divide(iterable $array, int $divisor, bool $preserve_keys = false): self { }
    public function divide(int $divisor, bool $preserve_keys = false): self { }

    /** @see array_filters() */
    public self $array_filters;
    public function array_filters(iterable $array, callable ...$callbacks): self { }
    public function array_filters(callable ...$callbacks): self { }

    /** @see array_filters() */
    public self $filters;
    public function filters(iterable $array, callable ...$callbacks): self { }
    public function filters(callable ...$callbacks): self { }

    /** @see array_grep_key() */
    public self $array_grep_key;
    public function array_grep_key(iterable $array, $regex, $not = false): self { }
    public function array_grep_key($regex, $not = false): self { }

    /** @see array_grep_key() */
    public self $grep_key;
    public function grep_key(iterable $array, $regex, $not = false): self { }
    public function grep_key($regex, $not = false): self { }

    /** @see array_map_filter() */
    public self $array_map_filter;
    public function array_map_filter(iterable $array, callable $callback, $strict = false): self { }
    public function array_map_filter(callable $callback, $strict = false): self { }

    /** @see array_map_filter() */
    public self $map_filter;
    public function map_filter(iterable $array, callable $callback, $strict = false): self { }
    public function map_filter(callable $callback, $strict = false): self { }

    /** @see array_map_recursive() */
    public self $array_map_recursive;
    public function array_map_recursive(iterable $array, callable $callback, iterable $iterable = true, iterable $apply_array = false): self { }
    public function array_map_recursive(callable $callback, iterable $iterable = true, iterable $apply_array = false): self { }

    /** @see array_map_recursive() */
    public self $map_recursive;
    public function map_recursive(iterable $array, callable $callback, iterable $iterable = true, iterable $apply_array = false): self { }
    public function map_recursive(callable $callback, iterable $iterable = true, iterable $apply_array = false): self { }

    /** @see array_of() */
    public self $array_of;
    public function array_of($key, $default = null): self { }
    public function array_of($default = null): self { }

    /** @see array_of() */
    public self $of;
    public function of($key, $default = null): self { }
    public function of($default = null): self { }

    /** @see array_or() */
    public self $array_or;
    public function array_or(iterable $array, callable $callback = null, $default = false): self { }
    public function array_or(callable $callback = null, $default = false): self { }

    /** @see array_or() */
    public self $or;
    public function or(iterable $array, callable $callback = null, $default = false): self { }
    public function or(callable $callback = null, $default = false): self { }

    /** @see array_pos_key() */
    public self $array_pos_key;
    public function array_pos_key(iterable $array, $key, $default = null): self { }
    public function array_pos_key($key, $default = null): self { }

    /** @see array_pos_key() */
    public self $pos_key;
    public function pos_key(iterable $array, $key, $default = null): self { }
    public function pos_key($key, $default = null): self { }

    /** @see array_shrink_key() */
    public self $array_shrink_key;
    public function array_shrink_key(...$variadic): self { }
    public function array_shrink_key(): self { }

    /** @see array_shrink_key() */
    public self $shrink_key;
    public function shrink_key(...$variadic): self { }
    public function shrink_key(): self { }

    /** @see array_sprintf() */
    public self $array_sprintf;
    public function array_sprintf(iterable $array, $format = null, $glue = null): self { }
    public function array_sprintf($format = null, $glue = null): self { }

    /** @see array_sprintf() */
    public self $sprintf;
    public function sprintf(iterable $array, $format = null, $glue = null): self { }
    public function sprintf($format = null, $glue = null): self { }

    /** @see array_where() */
    public self $array_where;
    public function array_where(iterable $array, $column = null, callable $callback = null): self { }
    public function array_where($column = null, callable $callback = null): self { }

    /** @see array_where() */
    public self $where;
    public function where(iterable $array, $column = null, callable $callback = null): self { }
    public function where($column = null, callable $callback = null): self { }

    /** @see in_array_and() */
    public self $in_array_and;
    public function in_array_and($needle, $haystack, $strict = false): self { }
    public function in_array_and($haystack, $strict = false): self { }

    /** @see is_hasharray() */
    public self $is_hasharray;
    public function is_hasharray(array $array): self { }
    public function is_hasharray(): self { }

    /** @see class_map() */
    public self $class_map;
    public function class_map(?object $loader = null, ?string $basePath = null, bool $cache = true): self { }
    public function class_map(?string $basePath = null, bool $cache = true): self { }

    /** @see object_properties() */
    public self $object_properties;
    public function object_properties($object, &$privates = []): self { }
    public function object_properties(&$privates = []): self { }

    /** @see csv_export() */
    public self $csv_export;
    public function csv_export(iterable $csvarrays, $options = []): self { }
    public function csv_export($options = []): self { }

    /** @see html_strip() */
    public self $html_strip;
    public function html_strip($html, $options = []): self { }
    public function html_strip($options = []): self { }

    /** @see html_tag() */
    public self $html_tag;
    public function html_tag($selector): self { }
    public function html_tag(): self { }

    /** @see json_export() */
    public self $json_export;
    public function json_export($value, $options = []): self { }
    public function json_export($options = []): self { }

    /** @see markdown_table() */
    public self $markdown_table;
    public function markdown_table(iterable $array, $option = []): self { }
    public function markdown_table($option = []): self { }

    /** @see date_interval_second() */
    public self $date_interval_second;
    public function date_interval_second($interval, $basetime = 0): self { }
    public function date_interval_second($basetime = 0): self { }

    /** @see dirmtime() */
    public self $dirmtime;
    public function dirmtime($dirname, $recursive = true): self { }
    public function dirmtime($recursive = true): self { }

    /** @see file_suffix() */
    public self $file_suffix;
    public function file_suffix($filename, $suffix): self { }
    public function file_suffix($suffix): self { }

    /** @see by_builtin() */
    public self $by_builtin;
    public function by_builtin($class, $function): self { }
    public function by_builtin($function): self { }

    /** @see http_benchmark() */
    public self $http_benchmark;
    public function http_benchmark(array|string $urls, int $requests = 10, int $concurrency = 3, $output = null): self { }
    public function http_benchmark(int $requests = 10, int $concurrency = 3, $output = null): self { }

    /** @see http_requests() */
    public self $http_requests;
    public function http_requests($urls, $single_options = [], $multi_options = [], &$infos = []): self { }
    public function http_requests($single_options = [], $multi_options = [], &$infos = []): self { }

    /** @see ip_info() */
    public self $ip_info;
    public function ip_info($ipaddr, $options = []): self { }
    public function ip_info($options = []): self { }

    /** @see ip_normalize() */
    public self $ip_normalize;
    public function ip_normalize(string $ipaddr): self { }
    public function ip_normalize(): self { }

    /** @see preg_matches() */
    public self $preg_matches;
    public function preg_matches($pattern, $subject, $flags = 0, $offset = 0): self { }
    public function preg_matches($subject, $flags = 0, $offset = 0): self { }

    /** @see reflect_type_resolve() */
    public self $reflect_type_resolve;
    public function reflect_type_resolve(?string $type): self { }
    public function reflect_type_resolve(): self { }

    /** @see stream_describe() */
    public self $stream_describe;
    public function stream_describe($stream = null): self { }
    public function stream_describe(): self { }

    /** @see chain_case() */
    public self $chain_case;
    public function chain_case(?string $string, ?string $delimiter = "-"): self { }
    public function chain_case(?string $delimiter = "-"): self { }

    /** @see mb_ereg_split() */
    public self $mb_ereg_split;
    public function mb_ereg_split(?string $pattern, ?string $subject, $limit = -1, $flags = 0): self { }
    public function mb_ereg_split(?string $subject, $limit = -1, $flags = 0): self { }

    /** @see mb_substr_replace() */
    public self $mb_substr_replace;
    public function mb_substr_replace(?string $string, ?string $replacement, $start, $length = null): self { }
    public function mb_substr_replace(?string $replacement, $start, $length = null): self { }

    /** @see mb_wordwrap() */
    public self $mb_wordwrap;
    public function mb_wordwrap(?string $string, $width, $break = "\n"): self { }
    public function mb_wordwrap($width, $break = "\n"): self { }

    /** @see multiexplode() */
    public self $multiexplode;
    public function multiexplode($delimiter, ?string $string, $limit = PHP_INT_MAX): self { }
    public function multiexplode(?string $string, $limit = PHP_INT_MAX): self { }

    /** @see str_array() */
    public self $str_array;
    public function str_array($string, ?string $delimiter, $hashmode, $strict = true): self { }
    public function str_array(?string $delimiter, $hashmode, $strict = true): self { }

    /** @see str_array() */
    public self $array;
    public function array($string, ?string $delimiter, $hashmode, $strict = true): self { }
    public function array(?string $delimiter, $hashmode, $strict = true): self { }

    /** @see str_between() */
    public self $str_between;
    public function str_between(?string $string, ?string $from, ?string $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_between(?string $from, ?string $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }

    /** @see str_between() */
    public self $between;
    public function between(?string $string, ?string $from, ?string $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function between(?string $from, ?string $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }

    /** @see strcat() */
    public self $strcat;
    public function strcat(?string ...$variadic): self { }
    public function strcat(): self { }

    /** @see try_return() */
    public self $try_return;
    public function try_return($try, ...$variadic): self { }
    public function try_return(...$variadic): self { }

    /** @see base62_encode() */
    public self $base62_encode;
    public function base62_encode($string): self { }
    public function base62_encode(): self { }

    /** @see query_build() */
    public self $query_build;
    public function query_build($data, $numeric_prefix = null, $arg_separator = null, $encoding_type = PHP_QUERY_RFC1738, $brackets = null): self { }
    public function query_build($numeric_prefix = null, $arg_separator = null, $encoding_type = PHP_QUERY_RFC1738, $brackets = null): self { }

    /** @see arrayval() */
    public self $arrayval;
    public function arrayval($var, $recursive = true): self { }
    public function arrayval($recursive = true): self { }

    /** @see var_export3() */
    public self $var_export3;
    public function var_export3($value, $return = false): self { }
    public function var_export3($return = false): self { }

    /** @see var_hash() */
    public self $var_hash;
    public function var_hash($var, $algos = ["md5", "sha1"], $base64 = true): self { }
    public function var_hash($algos = ["md5", "sha1"], $base64 = true): self { }

}
