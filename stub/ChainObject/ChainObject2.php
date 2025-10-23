<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject2
{
    /** @see date_isodate_set() */
    public self $date_isodate_set;
    public function date_isodate_set(\DateTime $object, int $year, int $week, int $dayOfWeek = 1): self { }
    public function date_isodate_set(int $year, int $week, int $dayOfWeek = 1): self { }

    /** @see date_timestamp_set() */
    public self $date_timestamp_set;
    public function date_timestamp_set(\DateTime $object, int $timestamp): self { }
    public function date_timestamp_set(int $timestamp): self { }

    /** @see sort() */
    public self $sort;
    public function sort(array &$array, int $flags = SORT_REGULAR): self { }
    public function sort(int $flags = SORT_REGULAR): self { }

    /** @see array_walk() */
    public self $array_walk;
    public function array_walk(object|array &$array, callable $callback, mixed $arg = null): self { }
    public function array_walk(callable $callback, mixed $arg = null): self { }

    /** @see array_walk() */
    public self $walk;
    public function walk(object|array &$array, callable $callback, mixed $arg = null): self { }
    public function walk(callable $callback, mixed $arg = null): self { }

    /** @see in_array() */
    public self $in_array;
    public function in_array(mixed $needle, array $haystack, bool $strict = false): self { }
    public function in_array(array $haystack, bool $strict = false): self { }

    /** @see extract() */
    public self $extract;
    public function extract(array &$array, int $flags = EXTR_OVERWRITE, string $prefix = ""): self { }
    public function extract(int $flags = EXTR_OVERWRITE, string $prefix = ""): self { }

    /** @see array_key_first() */
    public self $array_key_first;
    public function array_key_first(array $array): self { }
    public function array_key_first(): self { }

    /** @see array_key_first() */
    public self $key_first;
    public function key_first(array $array): self { }
    public function key_first(): self { }

    /** @see array_intersect_ukey() */
    public self $array_intersect_ukey;
    public function array_intersect_ukey(array $array, ...$rest): self { }
    public function array_intersect_ukey(...$rest): self { }

    /** @see array_intersect_ukey() */
    public self $intersect_ukey;
    public function intersect_ukey(array $array, ...$rest): self { }
    public function intersect_ukey(...$rest): self { }

    /** @see array_intersect_assoc() */
    public self $array_intersect_assoc;
    public function array_intersect_assoc(array ...$arrays): self { }
    public function array_intersect_assoc(): self { }

    /** @see array_intersect_assoc() */
    public self $intersect_assoc;
    public function intersect_assoc(array ...$arrays): self { }
    public function intersect_assoc(): self { }

    /** @see array_diff() */
    public self $array_diff;
    public function array_diff(array ...$arrays): self { }
    public function array_diff(): self { }

    /** @see array_diff() */
    public self $diff;
    public function diff(array ...$arrays): self { }
    public function diff(): self { }

    /** @see array_product() */
    public self $array_product;
    public function array_product(array $array): self { }
    public function array_product(): self { }

    /** @see array_product() */
    public self $product;
    public function product(array $array): self { }
    public function product(): self { }

    /** @see array_key_exists() */
    public self $array_key_exists;
    public function array_key_exists($key, array $array): self { }
    public function array_key_exists(array $array): self { }

    /** @see array_key_exists() */
    public self $key_exists;
    public function key_exists($key, array $array): self { }
    public function key_exists(array $array): self { }

    /** @see base64_decode() */
    public self $base64_decode;
    public function base64_decode(string $string, bool $strict = false): self { }
    public function base64_decode(bool $strict = false): self { }

    /** @see long2ip() */
    public self $long2ip;
    public function long2ip(int $ip): self { }
    public function long2ip(): self { }

    /** @see time_sleep_until() */
    public self $time_sleep_until;
    public function time_sleep_until(float $timestamp): self { }
    public function time_sleep_until(): self { }

    /** @see register_shutdown_function() */
    public self $register_shutdown_function;
    public function register_shutdown_function(callable $callback, mixed ...$args): self { }
    public function register_shutdown_function(mixed ...$args): self { }

    /** @see php_strip_whitespace() */
    public self $php_strip_whitespace;
    public function php_strip_whitespace(string $filename): self { }
    public function php_strip_whitespace(): self { }

    /** @see ini_get_all() */
    public self $ini_get_all;
    public function ini_get_all(?string $extension = null, bool $details = true): self { }
    public function ini_get_all(bool $details = true): self { }

    /** @see ini_alter() */
    public self $ini_alter;
    public function ini_alter(string $option, string|int|float|bool|null $value): self { }
    public function ini_alter(string|int|float|bool|null $value): self { }

    /** @see is_uploaded_file() */
    public self $is_uploaded_file;
    public function is_uploaded_file(string $filename): self { }
    public function is_uploaded_file(): self { }

    /** @see gethostbyname() */
    public self $gethostbyname;
    public function gethostbyname(string $hostname): self { }
    public function gethostbyname(): self { }

    /** @see checkdnsrr() */
    public self $checkdnsrr;
    public function checkdnsrr(string $hostname, string $type = "MX"): self { }
    public function checkdnsrr(string $type = "MX"): self { }

    /** @see dns_get_mx() */
    public self $dns_get_mx;
    public function dns_get_mx(string $hostname, &$hosts, &$weights = null): self { }
    public function dns_get_mx(&$hosts, &$weights = null): self { }

    /** @see ftok() */
    public self $ftok;
    public function ftok(string $filename, string $project_id): self { }
    public function ftok(string $project_id): self { }

    /** @see htmlentities() */
    public self $htmlentities;
    public function htmlentities(string $string, int $flags = 11, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlentities(int $flags = 11, ?string $encoding = null, bool $double_encode = true): self { }

    /** @see strpos() */
    public self $strpos;
    public function strpos(string $haystack, string $needle, int $offset = 0): self { }
    public function strpos(string $needle, int $offset = 0): self { }

    /** @see exec() */
    public self $exec;
    public function exec(string $command, &$output = null, &$result_code = null): self { }
    public function exec(&$output = null, &$result_code = null): self { }

    /** @see escapeshellcmd() */
    public self $escapeshellcmd;
    public function escapeshellcmd(string $command): self { }
    public function escapeshellcmd(): self { }

    /** @see umask() */
    public self $umask;
    public function umask(?int $mask = null): self { }
    public function umask(): self { }

    /** @see fgets() */
    public self $fgets;
    public function fgets($stream, ?int $length = null): self { }
    public function fgets(?int $length = null): self { }

    /** @see fread() */
    public self $fread;
    public function fread($stream, int $length): self { }
    public function fread(int $length): self { }

    /** @see fopen() */
    public self $fopen;
    public function fopen(string $filename, string $mode, bool $use_include_path = false, $context = null): self { }
    public function fopen(string $mode, bool $use_include_path = false, $context = null): self { }

    /** @see fscanf() */
    public self $fscanf;
    public function fscanf($stream, string $format, mixed &...$vars): self { }
    public function fscanf(string $format, mixed &...$vars): self { }

    /** @see fseek() */
    public self $fseek;
    public function fseek($stream, int $offset, int $whence = SEEK_SET): self { }
    public function fseek(int $offset, int $whence = SEEK_SET): self { }

    /** @see fileinode() */
    public self $fileinode;
    public function fileinode(string $filename): self { }
    public function fileinode(): self { }

    /** @see vprintf() */
    public self $vprintf;
    public function vprintf(string $format, array $values): self { }
    public function vprintf(array $values): self { }

    /** @see vsprintf() */
    public self $vsprintf;
    public function vsprintf(string $format, array $values): self { }
    public function vsprintf(array $values): self { }

    /** @see readlink() */
    public self $readlink;
    public function readlink(string $path): self { }
    public function readlink(): self { }

    /** @see link() */
    public self $link;
    public function link(string $target, string $link): self { }
    public function link(string $link): self { }

    /** @see tanh() */
    public self $tanh;
    public function tanh(float $num): self { }
    public function tanh(): self { }

    /** @see expm1() */
    public self $expm1;
    public function expm1(float $num): self { }
    public function expm1(): self { }

    /** @see deg2rad() */
    public self $deg2rad;
    public function deg2rad(float $num): self { }
    public function deg2rad(): self { }

    /** @see fmod() */
    public self $fmod;
    public function fmod(float $num1, float $num2): self { }
    public function fmod(float $num2): self { }

    /** @see password_hash() */
    public self $password_hash;
    public function password_hash(string $password, string|int|null $algo, array $options = []): self { }
    public function password_hash(string|int|null $algo, array $options = []): self { }

    /** @see quoted_printable_encode() */
    public self $quoted_printable_encode;
    public function quoted_printable_encode(string $string): self { }
    public function quoted_printable_encode(): self { }

    /** @see strval() */
    public self $strval;
    public function strval(mixed $value): self { }
    public function strval(): self { }

    /** @see memory_get_peak_usage() */
    public self $memory_get_peak_usage;
    public function memory_get_peak_usage(bool $real_usage = false): self { }
    public function memory_get_peak_usage(): self { }

    /** @see mb_http_input() */
    public self $mb_http_input;
    public function mb_http_input(?string $type = null): self { }
    public function mb_http_input(): self { }

    /** @see mb_convert_variables() */
    public self $mb_convert_variables;
    public function mb_convert_variables(string $to_encoding, array|string $from_encoding, mixed &$var, mixed &...$vars): self { }
    public function mb_convert_variables(array|string $from_encoding, mixed &$var, mixed &...$vars): self { }

    /** @see mb_ereg() */
    public self $mb_ereg;
    public function mb_ereg(string $pattern, string $string, &$matches = null): self { }
    public function mb_ereg(string $string, &$matches = null): self { }

    /** @see ReflectionClassConstant_isEnumCase() */
    public self $reflectionclassconstant_isenumcase;
    public function reflectionclassconstant_isenumcase(\ReflectionClassConstant $that): self { }
    public function reflectionclassconstant_isenumcase(): self { }

    /** @see array_any() */
    public self $array_any;
    public function array_any(iterable $array, callable $callback = null, $default = false): self { }
    public function array_any(callable $callback = null, $default = false): self { }

    /** @see array_any() */
    public self $any;
    public function any(iterable $array, callable $callback = null, $default = false): self { }
    public function any(callable $callback = null, $default = false): self { }

    /** @see array_depth() */
    public self $array_depth;
    public function array_depth(iterable $array, $max_depth = null): self { }
    public function array_depth($max_depth = null): self { }

    /** @see array_depth() */
    public self $depth;
    public function depth(iterable $array, $max_depth = null): self { }
    public function depth($max_depth = null): self { }

    /** @see array_filter_recursive() */
    public self $array_filter_recursive;
    public function array_filter_recursive(iterable $array, callable $callback, bool $unset_empty = true): self { }
    public function array_filter_recursive(callable $callback, bool $unset_empty = true): self { }

    /** @see array_filter_recursive() */
    public self $filter_recursive;
    public function filter_recursive(iterable $array, callable $callback, bool $unset_empty = true): self { }
    public function filter_recursive(callable $callback, bool $unset_empty = true): self { }

    /** @see array_shuffle() */
    public self $array_shuffle;
    public function array_shuffle(iterable $array): self { }
    public function array_shuffle(): self { }

    /** @see array_shuffle() */
    public self $shuffle;
    public function shuffle(iterable $array): self { }
    public function shuffle(): self { }

    /** @see array_strpad() */
    public self $array_strpad;
    public function array_strpad(iterable $array, $key_prefix, $val_prefix = ""): self { }
    public function array_strpad($key_prefix, $val_prefix = ""): self { }

    /** @see array_strpad() */
    public self $strpad;
    public function strpad(iterable $array, $key_prefix, $val_prefix = ""): self { }
    public function strpad($key_prefix, $val_prefix = ""): self { }

    /** @see arrayize() */
    public self $arrayize;
    public function arrayize(...$variadic): self { }
    public function arrayize(): self { }

    /** @see first_value() */
    public self $first_value;
    public function first_value(iterable $array, $default = null): self { }
    public function first_value($default = null): self { }

    /** @see sql_export() */
    public self $sql_export;
    public function sql_export(iterable $sqlarrays, $options = []): self { }
    public function sql_export($options = []): self { }

    /** @see html_attr() */
    public self $html_attr;
    public function html_attr(iterable $array, $options = []): self { }
    public function html_attr($options = []): self { }

    /** @see ltsv_import() */
    public self $ltsv_import;
    public function ltsv_import($ltsvstring, $options = []): self { }
    public function ltsv_import($options = []): self { }

    /** @see markdown_list() */
    public self $markdown_list;
    public function markdown_list(iterable $array, $option = []): self { }
    public function markdown_list($option = []): self { }

    /** @see xmlss_export() */
    public self $xmlss_export;
    public function xmlss_export(iterable $xmlssarrays, array $options = []): self { }
    public function xmlss_export(array $options = []): self { }

    /** @see process_closure() */
    public self $process_closure;
    public function process_closure($closure, $args = [], $throw = true, $autoload = null, $workdir = null, $env = null, $options = null): self { }
    public function process_closure($args = [], $throw = true, $autoload = null, $workdir = null, $env = null, $options = null): self { }

    /** @see path_resolve() */
    public self $path_resolve;
    public function path_resolve(...$paths): self { }
    public function path_resolve(): self { }

    /** @see rm_rf() */
    public self $rm_rf;
    public function rm_rf($dirname, $self = true): self { }
    public function rm_rf($self = true): self { }

    /** @see strmode() */
    public self $strmode;
    public function strmode($octet): self { }
    public function strmode(): self { }

    /** @see tmpname() */
    public self $tmpname;
    public function tmpname($prefix = "rft", $dir = null): self { }
    public function tmpname($dir = null): self { }

    /** @see func_user_func_array() */
    public self $func_user_func_array;
    public function func_user_func_array(callable $callback): self { }
    public function func_user_func_array(): self { }

    /** @see sys_get_memory() */
    public self $sys_get_memory;
    public function sys_get_memory(int $cacheSecond = 0): self { }
    public function sys_get_memory(): self { }

    /** @see php_highlight() */
    public self $php_highlight;
    public function php_highlight($phpcode, $options = []): self { }
    public function php_highlight($options = []): self { }

    /** @see php_opcode() */
    public self $php_opcode;
    public function php_opcode($phpcode, $level = 131072): self { }
    public function php_opcode($level = 131072): self { }

    /** @see sleetflake() */
    public self $sleetflake;
    public function sleetflake(int $sequence_bit = 7, int $ipaddress_bit = 16, ?int $base_timestamp = null, ?float $timestamp = null, ?string $lockfile = null): self { }
    public function sleetflake(int $ipaddress_bit = 16, ?int $base_timestamp = null, ?float $timestamp = null, ?string $lockfile = null): self { }

    /** @see fcgi_request() */
    public self $fcgi_request;
    public function fcgi_request(string $url, array $params = [], \Traversable|array|string $stdin = "", array $options = []): self { }
    public function fcgi_request(array $params = [], \Traversable|array|string $stdin = "", array $options = []): self { }

    /** @see http_delete() */
    public self $http_delete;
    public function http_delete($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_delete($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see opcache_reload() */
    public self $opcache_reload;
    public function opcache_reload(array $includePatterns = [], array $excludePatterns = [], bool $reset = false, ?bool $ignoreErrors = null, ?string $cachefile = null): self { }
    public function opcache_reload(array $excludePatterns = [], bool $reset = false, ?bool $ignoreErrors = null, ?string $cachefile = null): self { }

    /** @see ob_include() */
    public self $ob_include;
    public function ob_include($include_file, iterable $array = []): self { }
    public function ob_include(iterable $array = []): self { }

    /** @see random_normal() */
    public self $random_normal;
    public function random_normal($average = 0.0, $std_deviation = 1.0): self { }
    public function random_normal($std_deviation = 1.0): self { }

    /** @see parameter_wiring() */
    public self $parameter_wiring;
    public function parameter_wiring(callable $callable, $dependency): self { }
    public function parameter_wiring($dependency): self { }

    /** @see var_stream() */
    public self $var_stream;
    public function var_stream(&$var, $initial = ""): self { }
    public function var_stream($initial = ""): self { }

    /** @see include_string() */
    public self $include_string;
    public function include_string(?string $template, iterable $array = []): self { }
    public function include_string(iterable $array = []): self { }

    /** @see split_noempty() */
    public self $split_noempty;
    public function split_noempty(?string $delimiter, ?string $string, $trimchars = true): self { }
    public function split_noempty(?string $string, $trimchars = true): self { }

    /** @see str_chop() */
    public self $str_chop;
    public function str_chop(?string $string, ?string $prefix = "", ?string $suffix = "", $case_insensitivity = false): self { }
    public function str_chop(?string $prefix = "", ?string $suffix = "", $case_insensitivity = false): self { }

    /** @see str_chop() */
    public self $chop;
    public function chop(?string $string, ?string $prefix = "", ?string $suffix = "", $case_insensitivity = false): self { }
    public function chop(?string $prefix = "", ?string $suffix = "", $case_insensitivity = false): self { }

    /** @see str_ellipsis() */
    public self $str_ellipsis;
    public function str_ellipsis(?string $string, $width, $trimmarker = "...", $pos = null): self { }
    public function str_ellipsis($width, $trimmarker = "...", $pos = null): self { }

    /** @see str_ellipsis() */
    public self $ellipsis;
    public function ellipsis(?string $string, $width, $trimmarker = "...", $pos = null): self { }
    public function ellipsis($width, $trimmarker = "...", $pos = null): self { }

    /** @see str_rchop() */
    public self $str_rchop;
    public function str_rchop(?string $string, ?string $suffix, $case_insensitivity = false): self { }
    public function str_rchop(?string $suffix, $case_insensitivity = false): self { }

    /** @see str_rchop() */
    public self $rchop;
    public function rchop(?string $string, ?string $suffix, $case_insensitivity = false): self { }
    public function rchop(?string $suffix, $case_insensitivity = false): self { }

    /** @see str_submap() */
    public self $str_submap;
    public function str_submap(?string $subject, $replaces, $case_insensitivity = false): self { }
    public function str_submap($replaces, $case_insensitivity = false): self { }

    /** @see str_submap() */
    public self $submap;
    public function submap(?string $subject, $replaces, $case_insensitivity = false): self { }
    public function submap($replaces, $case_insensitivity = false): self { }

    /** @see blank_if() */
    public self $blank_if;
    public function blank_if($var, $default = null): self { }
    public function blank_if($default = null): self { }

    /** @see try_null() */
    public self $try_null;
    public function try_null($try, ...$variadic): self { }
    public function try_null(...$variadic): self { }

    /** @see built_in_server() */
    public self $built_in_server;
    public function built_in_server($document_root, $router = null, $options = []): self { }
    public function built_in_server($router = null, $options = []): self { }

    /** @see is_primitive() */
    public self $is_primitive;
    public function is_primitive($var): self { }
    public function is_primitive(): self { }

    /** @see numval() */
    public self $numval;
    public function numval($var, $base = 10): self { }
    public function numval($base = 10): self { }

    /** @see var_applys() */
    public self $var_applys;
    public function var_applys($var, callable $callback, ...$args): self { }
    public function var_applys(callable $callback, ...$args): self { }

    /** @see var_pretty() */
    public self $var_pretty;
    public function var_pretty($value, $options = []): self { }
    public function var_pretty($options = []): self { }

}
