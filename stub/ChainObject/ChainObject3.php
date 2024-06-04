<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject3
{
    /** @see checkdate() */
    public self $checkdate;
    public function checkdate(int $month, int $day, int $year): self { }
    public function checkdate(int $day, int $year): self { }

    /** @see date_create() */
    public self $date_create;
    public function date_create(string $datetime = "now", ?\DateTimeZone $timezone = null): self { }
    public function date_create(?\DateTimeZone $timezone = null): self { }

    /** @see date_create_immutable() */
    public self $date_create_immutable;
    public function date_create_immutable(string $datetime = "now", ?\DateTimeZone $timezone = null): self { }
    public function date_create_immutable(?\DateTimeZone $timezone = null): self { }

    /** @see date_format() */
    public self $date_format;
    public function date_format(\DateTimeInterface $object, string $format): self { }
    public function date_format(string $format): self { }

    /** @see date_sub() */
    public self $date_sub;
    public function date_sub(\DateTime $object, \DateInterval $interval): self { }
    public function date_sub(\DateInterval $interval): self { }

    /** @see date_interval_format() */
    public self $date_interval_format;
    public function date_interval_format(\DateInterval $object, string $format): self { }
    public function date_interval_format(string $format): self { }

    /** @see preg_match_all() */
    public self $preg_match_all;
    public function preg_match_all(string $pattern, string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match_all(string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }

    /** @see preg_replace_callback() */
    public self $preg_replace_callback;
    public function preg_replace_callback(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback(callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }

    /** @see mhash() */
    public self $mhash;
    public function mhash(int $algo, string $data, ?string $key = null): self { }
    public function mhash(string $data, ?string $key = null): self { }

    /** @see array_push() */
    public self $array_push;
    public function array_push(array &$array, mixed ...$values): self { }
    public function array_push(mixed ...$values): self { }

    /** @see array_push() */
    public self $push;
    public function push(array &$array, mixed ...$values): self { }
    public function push(mixed ...$values): self { }

    /** @see krsort() */
    public self $krsort;
    public function krsort(array &$array, int $flags = SORT_REGULAR): self { }
    public function krsort(int $flags = SORT_REGULAR): self { }

    /** @see asort() */
    public self $asort;
    public function asort(array &$array, int $flags = SORT_REGULAR): self { }
    public function asort(int $flags = SORT_REGULAR): self { }

    /** @see usort() */
    public self $usort;
    public function usort(array &$array, callable $callback): self { }
    public function usort(callable $callback): self { }

    /** @see array_fill() */
    public self $array_fill;
    public function array_fill(int $start_index, int $count, mixed $value): self { }
    public function array_fill(int $count, mixed $value): self { }

    /** @see array_fill() */
    public self $fill;
    public function fill(int $start_index, int $count, mixed $value): self { }
    public function fill(int $count, mixed $value): self { }

    /** @see array_unshift() */
    public self $array_unshift;
    public function array_unshift(array &$array, mixed ...$values): self { }
    public function array_unshift(mixed ...$values): self { }

    /** @see array_unshift() */
    public self $unshift;
    public function unshift(array &$array, mixed ...$values): self { }
    public function unshift(mixed ...$values): self { }

    /** @see array_count_values() */
    public self $array_count_values;
    public function array_count_values(array $array): self { }
    public function array_count_values(): self { }

    /** @see array_count_values() */
    public self $count_values;
    public function count_values(array $array): self { }
    public function count_values(): self { }

    /** @see array_change_key_case() */
    public self $array_change_key_case;
    public function array_change_key_case(array $array, int $case = CASE_LOWER): self { }
    public function array_change_key_case(int $case = CASE_LOWER): self { }

    /** @see array_change_key_case() */
    public self $change_key_case;
    public function change_key_case(array $array, int $case = CASE_LOWER): self { }
    public function change_key_case(int $case = CASE_LOWER): self { }

    /** @see array_unique() */
    public self $array_unique;
    public function array_unique(array $array, int $flags = SORT_STRING): self { }
    public function array_unique(int $flags = SORT_STRING): self { }

    /** @see array_unique() */
    public self $unique;
    public function unique(array $array, int $flags = SORT_STRING): self { }
    public function unique(int $flags = SORT_STRING): self { }

    /** @see array_intersect() */
    public self $array_intersect;
    public function array_intersect(array ...$arrays): self { }
    public function array_intersect(): self { }

    /** @see array_intersect() */
    public self $intersect;
    public function intersect(array ...$arrays): self { }
    public function intersect(): self { }

    /** @see array_uintersect_assoc() */
    public self $array_uintersect_assoc;
    public function array_uintersect_assoc(array $array, ...$rest): self { }
    public function array_uintersect_assoc(...$rest): self { }

    /** @see array_uintersect_assoc() */
    public self $uintersect_assoc;
    public function uintersect_assoc(array $array, ...$rest): self { }
    public function uintersect_assoc(...$rest): self { }

    /** @see error_log() */
    public self $error_log;
    public function error_log(string $message, int $message_type = 0, ?string $destination = null, ?string $additional_headers = null): self { }
    public function error_log(int $message_type = 0, ?string $destination = null, ?string $additional_headers = null): self { }

    /** @see forward_static_call() */
    public self $forward_static_call;
    public function forward_static_call(callable $callback, mixed ...$args): self { }
    public function forward_static_call(mixed ...$args): self { }

    /** @see forward_static_call_array() */
    public self $forward_static_call_array;
    public function forward_static_call_array(callable $callback, array $args): self { }
    public function forward_static_call_array(array $args): self { }

    /** @see print_r() */
    public self $print_r;
    public function print_r(mixed $value, bool $return = false): self { }
    public function print_r(bool $return = false): self { }

    /** @see getprotobynumber() */
    public self $getprotobynumber;
    public function getprotobynumber(int $protocol): self { }
    public function getprotobynumber(): self { }

    /** @see dns_get_record() */
    public self $dns_get_record;
    public function dns_get_record(string $hostname, int $type = DNS_ANY, &$authoritative_name_servers = null, &$additional_records = null, bool $raw = false): self { }
    public function dns_get_record(int $type = DNS_ANY, &$authoritative_name_servers = null, &$additional_records = null, bool $raw = false): self { }

    /** @see md5_file() */
    public self $md5_file;
    public function md5_file(string $filename, bool $binary = false): self { }
    public function md5_file(bool $binary = false): self { }

    /** @see inet_pton() */
    public self $inet_pton;
    public function inet_pton(string $ip): self { }
    public function inet_pton(): self { }

    /** @see http_response_code() */
    public self $http_response_code;
    public function http_response_code(int $response_code = 0): self { }
    public function http_response_code(): self { }

    /** @see strspn() */
    public self $strspn;
    public function strspn(string $string, string $characters, int $offset = 0, ?int $length = null): self { }
    public function strspn(string $characters, int $offset = 0, ?int $length = null): self { }

    /** @see implode() */
    public self $implode;
    public function implode(array|string $separator, ?array $array = null): self { }
    public function implode(?array $array = null): self { }

    /** @see stristr() */
    public self $stristr;
    public function stristr(string $haystack, string $needle, bool $before_needle = false): self { }
    public function stristr(string $needle, bool $before_needle = false): self { }

    /** @see strripos() */
    public self $strripos;
    public function strripos(string $haystack, string $needle, int $offset = 0): self { }
    public function strripos(string $needle, int $offset = 0): self { }

    /** @see similar_text() */
    public self $similar_text;
    public function similar_text(string $string1, string $string2, &$percent = null): self { }
    public function similar_text(string $string2, &$percent = null): self { }

    /** @see strip_tags() */
    public self $strip_tags;
    public function strip_tags(string $string, array|string|null $allowed_tags = null): self { }
    public function strip_tags(array|string|null $allowed_tags = null): self { }

    /** @see setlocale() */
    public self $setlocale;
    public function setlocale(int $category, $locales, ...$rest): self { }
    public function setlocale($locales, ...$rest): self { }

    /** @see parse_str() */
    public self $parse_str;
    public function parse_str(string $string, &$result): self { }
    public function parse_str(&$result): self { }

    /** @see count_chars() */
    public self $count_chars;
    public function count_chars(string $string, int $mode = 0): self { }
    public function count_chars(int $mode = 0): self { }

    /** @see opendir() */
    public self $opendir;
    public function opendir(string $directory, $context = null): self { }
    public function opendir($context = null): self { }

    /** @see escapeshellarg() */
    public self $escapeshellarg;
    public function escapeshellarg(string $arg): self { }
    public function escapeshellarg(): self { }

    /** @see fstat() */
    public self $fstat;
    public function fstat($stream): self { }
    public function fstat(): self { }

    /** @see filegroup() */
    public self $filegroup;
    public function filegroup(string $filename): self { }
    public function filegroup(): self { }

    /** @see filetype() */
    public self $filetype;
    public function filetype(string $filename): self { }
    public function filetype(): self { }

    /** @see chgrp() */
    public self $chgrp;
    public function chgrp(string $filename, string|int $group): self { }
    public function chgrp(string|int $group): self { }

    /** @see diskfreespace() */
    public self $diskfreespace;
    public function diskfreespace(string $directory): self { }
    public function diskfreespace(): self { }

    /** @see phpversion() */
    public self $phpversion;
    public function phpversion(?string $extension = null): self { }
    public function phpversion(): self { }

    /** @see iptcparse() */
    public self $iptcparse;
    public function iptcparse(string $iptc_block): self { }
    public function iptcparse(): self { }

    /** @see acos() */
    public self $acos;
    public function acos(float $num): self { }
    public function acos(): self { }

    /** @see atanh() */
    public self $atanh;
    public function atanh(float $num): self { }
    public function atanh(): self { }

    /** @see log10() */
    public self $log10;
    public function log10(float $num): self { }
    public function log10(): self { }

    /** @see decoct() */
    public self $decoct;
    public function decoct(int $num): self { }
    public function decoct(): self { }

    /** @see base_convert() */
    public self $base_convert;
    public function base_convert(string $num, int $from_base, int $to_base): self { }
    public function base_convert(int $from_base, int $to_base): self { }

    /** @see fdiv() */
    public self $fdiv;
    public function fdiv(float $num1, float $num2): self { }
    public function fdiv(float $num2): self { }

    /** @see password_get_info() */
    public self $password_get_info;
    public function password_get_info(string $hash): self { }
    public function password_get_info(): self { }

    /** @see quoted_printable_decode() */
    public self $quoted_printable_decode;
    public function quoted_printable_decode(string $string): self { }
    public function quoted_printable_decode(): self { }

    /** @see soundex() */
    public self $soundex;
    public function soundex(string $string): self { }
    public function soundex(): self { }

    /** @see doubleval() */
    public self $doubleval;
    public function doubleval(mixed $value): self { }
    public function doubleval(): self { }

    /** @see rawurlencode() */
    public self $rawurlencode;
    public function rawurlencode(string $string): self { }
    public function rawurlencode(): self { }

    /** @see debug_zval_dump() */
    public self $debug_zval_dump;
    public function debug_zval_dump(mixed ...$values): self { }
    public function debug_zval_dump(): self { }

    /** @see mb_internal_encoding() */
    public self $mb_internal_encoding;
    public function mb_internal_encoding(?string $encoding = null): self { }
    public function mb_internal_encoding(): self { }

    /** @see mb_substitute_character() */
    public self $mb_substitute_character;
    public function mb_substitute_character(string|int|null $substitute_character = null): self { }
    public function mb_substitute_character(): self { }

    /** @see mb_strcut() */
    public self $mb_strcut;
    public function mb_strcut(string $string, int $start, ?int $length = null, ?string $encoding = null): self { }
    public function mb_strcut(int $start, ?int $length = null, ?string $encoding = null): self { }

    /** @see mb_strtolower() */
    public self $mb_strtolower;
    public function mb_strtolower(string $string, ?string $encoding = null): self { }
    public function mb_strtolower(?string $encoding = null): self { }

    /** @see mb_decode_mimeheader() */
    public self $mb_decode_mimeheader;
    public function mb_decode_mimeheader(string $string): self { }
    public function mb_decode_mimeheader(): self { }

    /** @see mb_ereg_search_regs() */
    public self $mb_ereg_search_regs;
    public function mb_ereg_search_regs(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_regs(?string $options = null): self { }

    /** @see array_each() */
    public self $array_each;
    public function array_each(iterable $array, callable $callback, $default = null): self { }
    public function array_each(callable $callback, $default = null): self { }

    /** @see array_each() */
    public self $each;
    public function each(iterable $array, callable $callback, $default = null): self { }
    public function each(callable $callback, $default = null): self { }

    /** @see array_extend() */
    public self $array_extend;
    public function array_extend($default = [], iterable ...$arrays): self { }
    public function array_extend(iterable ...$arrays): self { }

    /** @see array_extend() */
    public self $extend;
    public function extend($default = [], iterable ...$arrays): self { }
    public function extend(iterable ...$arrays): self { }

    /** @see array_get() */
    public self $array_get;
    public function array_get(iterable $array, $key, $default = null): self { }
    public function array_get($key, $default = null): self { }

    /** @see array_get() */
    public self $get;
    public function get(iterable $array, $key, $default = null): self { }
    public function get($key, $default = null): self { }

    /** @see array_keys_exist() */
    public self $array_keys_exist;
    public function array_keys_exist($keys, iterable $array): self { }
    public function array_keys_exist(iterable $array): self { }

    /** @see array_keys_exist() */
    public self $keys_exist;
    public function keys_exist($keys, iterable $array): self { }
    public function keys_exist(iterable $array): self { }

    /** @see array_mix() */
    public self $array_mix;
    public function array_mix(...$variadic): self { }
    public function array_mix(): self { }

    /** @see array_mix() */
    public self $mix;
    public function mix(...$variadic): self { }
    public function mix(): self { }

    /** @see array_revise() */
    public self $array_revise;
    public function array_revise(iterable $array, ...$maps): self { }
    public function array_revise(...$maps): self { }

    /** @see array_revise() */
    public self $revise;
    public function revise(iterable $array, ...$maps): self { }
    public function revise(...$maps): self { }

    /** @see arrays() */
    public self $arrays;
    public function arrays(iterable $array): self { }
    public function arrays(): self { }

    /** @see last_keyvalue() */
    public self $last_keyvalue;
    public function last_keyvalue(iterable $array, $default = null): self { }
    public function last_keyvalue($default = null): self { }

    /** @see next_key() */
    public self $next_key;
    public function next_key(iterable $array, $key = null): self { }
    public function next_key($key = null): self { }

    /** @see class_replace() */
    public self $class_replace;
    public function class_replace($class, $register): self { }
    public function class_replace($register): self { }

    /** @see namespace_detect() */
    public self $namespace_detect;
    public function namespace_detect($location): self { }
    public function namespace_detect(): self { }

    /** @see register_autoload_function() */
    public self $register_autoload_function;
    public function register_autoload_function($before = null, $after = null): self { }
    public function register_autoload_function($after = null): self { }

    /** @see sql_bind() */
    public self $sql_bind;
    public function sql_bind($sql, $values, $quote = null): self { }
    public function sql_bind($values, $quote = null): self { }

    /** @see css_selector() */
    public self $css_selector;
    public function css_selector($selector): self { }
    public function css_selector(): self { }

    /** @see ltsv_export() */
    public self $ltsv_export;
    public function ltsv_export(iterable $ltsvarray, $options = []): self { }
    public function ltsv_export($options = []): self { }

    /** @see error() */
    public self $error;
    public function error($message, $destination = null): self { }
    public function error($destination = null): self { }

    /** @see file_get_arrays() */
    public self $file_get_arrays;
    public function file_get_arrays($filename, $options = []): self { }
    public function file_get_arrays($options = []): self { }

    /** @see file_mimetype() */
    public self $file_mimetype;
    public function file_mimetype($filename, $prefer_extension = []): self { }
    public function file_mimetype($prefer_extension = []): self { }

    /** @see file_rewrite_contents() */
    public self $file_rewrite_contents;
    public function file_rewrite_contents($filename, callable $callback, $operation = 0): self { }
    public function file_rewrite_contents(callable $callback, $operation = 0): self { }

    /** @see path_relative() */
    public self $path_relative;
    public function path_relative($from, $to): self { }
    public function path_relative($to): self { }

    /** @see chain() */
    public self $chain;
    public function chain($source = null): self { }
    public function chain(): self { }

    /** @see function_shorten() */
    public self $function_shorten;
    public function function_shorten($function): self { }
    public function function_shorten(): self { }

    /** @see is_bindable_closure() */
    public self $is_bindable_closure;
    public function is_bindable_closure(\Closure $closure): self { }
    public function is_bindable_closure(): self { }

    /** @see get_uploaded_files() */
    public self $get_uploaded_files;
    public function get_uploaded_files($files = null): self { }
    public function get_uploaded_files(): self { }

    /** @see iterator_split() */
    public self $iterator_split;
    public function iterator_split(iterable $iterable, $chunk_sizes, $preserve_keys = false): self { }
    public function iterator_split($chunk_sizes, $preserve_keys = false): self { }

    /** @see calculate_formula() */
    public self $calculate_formula;
    public function calculate_formula($formula): self { }
    public function calculate_formula(): self { }

    /** @see median() */
    public self $median;
    public function median(...$variadic): self { }
    public function median(): self { }

    /** @see annotation_parse() */
    public self $annotation_parse;
    public function annotation_parse($annotation, $schema = [], $nsfiles = []): self { }
    public function annotation_parse($schema = [], $nsfiles = []): self { }

    /** @see namespace_parse() */
    public self $namespace_parse;
    public function namespace_parse($filename, $options = []): self { }
    public function namespace_parse($options = []): self { }

    /** @see cidr_parse() */
    public self $cidr_parse;
    public function cidr_parse($cidr): self { }
    public function cidr_parse(): self { }

    /** @see http_head() */
    public self $http_head;
    public function http_head($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_head($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see http_patch() */
    public self $http_patch;
    public function http_patch($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_patch($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see ping() */
    public self $ping;
    public function ping($host, $port = null, $timeout = 1, &$errstr = ""): self { }
    public function ping($port = null, $timeout = 1, &$errstr = ""): self { }

    /** @see random_at() */
    public self $random_at;
    public function random_at(...$args): self { }
    public function random_at(): self { }

    /** @see namespace_split() */
    public self $namespace_split;
    public function namespace_split($string): self { }
    public function namespace_split(): self { }

    /** @see pascal_case() */
    public self $pascal_case;
    public function pascal_case($string, $delimiter = "_"): self { }
    public function pascal_case($delimiter = "_"): self { }

    /** @see str_control_apply() */
    public self $str_control_apply;
    public function str_control_apply(string $string, string $characters = <<<TEXT
\\b\10\\d\177
TEXT): self { }
    public function str_control_apply(string $characters = <<<TEXT
\\b\10\\d\177
TEXT): self { }

    /** @see str_control_apply() */
    public self $control_apply;
    public function control_apply(string $string, string $characters = <<<TEXT
\\b\10\\d\177
TEXT): self { }
    public function control_apply(string $characters = <<<TEXT
\\b\10\\d\177
TEXT): self { }

    /** @see str_quote() */
    public self $str_quote;
    public function str_quote(string $string, array $options = []): self { }
    public function str_quote(array $options = []): self { }

    /** @see str_quote() */
    public self $quote;
    public function quote(string $string, array $options = []): self { }
    public function quote(array $options = []): self { }

    /** @see instance_of() */
    public self $instance_of;
    public function instance_of($object, $class): self { }
    public function instance_of($class): self { }

    /** @see uri_build() */
    public self $uri_build;
    public function uri_build($parts, $options = []): self { }
    public function uri_build($options = []): self { }

    /** @see function_configure() */
    public self $function_configure;
    public function function_configure($option): self { }
    public function function_configure(): self { }

    /** @see encrypt() */
    public self $encrypt;
    public function encrypt($plaindata, $password, $cipher = null, &$tag = ""): self { }
    public function encrypt($password, $cipher = null, &$tag = ""): self { }

    /** @see is_decimal() */
    public self $is_decimal;
    public function is_decimal($var, $allow_float = true): self { }
    public function is_decimal($allow_float = true): self { }

    /** @see is_stringable() */
    public self $is_stringable;
    public function is_stringable($var): self { }
    public function is_stringable(): self { }

    /** @see si_prefix() */
    public self $si_prefix;
    public function si_prefix($var, $unit = 1000, $format = "%.3f %s"): self { }
    public function si_prefix($unit = 1000, $format = "%.3f %s"): self { }

    /** @see stringify() */
    public self $stringify;
    public function stringify($var): self { }
    public function stringify(): self { }

}
