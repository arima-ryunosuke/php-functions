<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject9
{
    /** @see \strtotime() */
    public self $strtotime;
    public function strtotime(string $datetime, ?int $baseTimestamp = null): self { }
    public function strtotime(?int $baseTimestamp = null): self { }

    /** @see \date_create_from_format() */
    public self $date_create_from_format;
    public function date_create_from_format(string $format, string $datetime, ?\DateTimeZone $timezone = null): self { }
    public function date_create_from_format(string $datetime, ?\DateTimeZone $timezone = null): self { }

    /** @see \date_create_immutable_from_format() */
    public self $date_create_immutable_from_format;
    public function date_create_immutable_from_format(string $format, string $datetime, ?\DateTimeZone $timezone = null): self { }
    public function date_create_immutable_from_format(string $datetime, ?\DateTimeZone $timezone = null): self { }

    /** @see \date_sunrise() */
    public self $date_sunrise;
    public function date_sunrise(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunrise(int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }

    /** @see \date_sun_info() */
    public self $date_sun_info;
    public function date_sun_info(int $timestamp, float $latitude, float $longitude): self { }
    public function date_sun_info(float $latitude, float $longitude): self { }

    /** @see \ksort() */
    public self $ksort;
    public function ksort(array &$array, int $flags = SORT_REGULAR): self { }
    public function ksort(int $flags = SORT_REGULAR): self { }

    /** @see \sizeof() */
    public self $sizeof;
    public function sizeof(\Countable|array $value, int $mode = COUNT_NORMAL): self { }
    public function sizeof(int $mode = COUNT_NORMAL): self { }

    /** @see \array_merge() */
    public self $array_merge;
    public function array_merge(array ...$arrays): self { }
    public function array_merge(): self { }

    /** @see \array_merge() */
    public self $merge;
    public function merge(array ...$arrays): self { }
    public function merge(): self { }

    /** @see \array_intersect_uassoc() */
    public self $array_intersect_uassoc;
    public function array_intersect_uassoc(array $array, ...$rest): self { }
    public function array_intersect_uassoc(...$rest): self { }

    /** @see \array_intersect_uassoc() */
    public self $intersect_uassoc;
    public function intersect_uassoc(array $array, ...$rest): self { }
    public function intersect_uassoc(...$rest): self { }

    /** @see \array_diff_assoc() */
    public self $array_diff_assoc;
    public function array_diff_assoc(array ...$arrays): self { }
    public function array_diff_assoc(): self { }

    /** @see \array_diff_assoc() */
    public self $diff_assoc;
    public function diff_assoc(array ...$arrays): self { }
    public function diff_assoc(): self { }

    /** @see \array_diff_uassoc() */
    public self $array_diff_uassoc;
    public function array_diff_uassoc(array $array, ...$rest): self { }
    public function array_diff_uassoc(...$rest): self { }

    /** @see \array_diff_uassoc() */
    public self $diff_uassoc;
    public function diff_uassoc(array $array, ...$rest): self { }
    public function diff_uassoc(...$rest): self { }

    /** @see \array_rand() */
    public self $array_rand;
    public function array_rand(array $array, int $num = 1): self { }
    public function array_rand(int $num = 1): self { }

    /** @see \array_rand() */
    public self $rand;
    public function rand(array $array, int $num = 1): self { }
    public function rand(int $num = 1): self { }

    /** @see \base64_encode() */
    public self $base64_encode;
    public function base64_encode(string $string): self { }
    public function base64_encode(): self { }

    /** @see \get_cfg_var() */
    public self $get_cfg_var;
    public function get_cfg_var(string $option): self { }
    public function get_cfg_var(): self { }

    /** @see \ini_set() */
    public self $ini_set;
    public function ini_set(string $option, string $value): self { }
    public function ini_set(string $value): self { }

    /** @see \getservbyport() */
    public self $getservbyport;
    public function getservbyport(int $port, string $protocol): self { }
    public function getservbyport(string $protocol): self { }

    /** @see \parse_ini_string() */
    public self $parse_ini_string;
    public function parse_ini_string(string $ini_string, bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_string(bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }

    /** @see \gethostbynamel() */
    public self $gethostbynamel;
    public function gethostbynamel(string $hostname): self { }
    public function gethostbynamel(): self { }

    /** @see \dns_check_record() */
    public self $dns_check_record;
    public function dns_check_record(string $hostname, string $type = "MX"): self { }
    public function dns_check_record(string $type = "MX"): self { }

    /** @see \syslog() */
    public self $syslog;
    public function syslog(int $priority, string $message): self { }
    public function syslog(string $message): self { }

    /** @see \inet_ntop() */
    public self $inet_ntop;
    public function inet_ntop(string $ip): self { }
    public function inet_ntop(): self { }

    /** @see \header() */
    public self $header;
    public function header(string $header, bool $replace = true, int $response_code = 0): self { }
    public function header(bool $replace = true, int $response_code = 0): self { }

    /** @see \header_remove() */
    public self $header_remove;
    public function header_remove(?string $name = null): self { }
    public function header_remove(): self { }

    /** @see \strtolower() */
    public self $strtolower;
    public function strtolower(string $string): self { }
    public function strtolower(): self { }

    /** @see \basename() */
    public self $basename;
    public function basename(string $path, string $suffix = ""): self { }
    public function basename(string $suffix = ""): self { }

    /** @see \dirname() */
    public self $dirname;
    public function dirname(string $path, int $levels = 1): self { }
    public function dirname(int $levels = 1): self { }

    /** @see \pathinfo() */
    public self $pathinfo;
    public function pathinfo(string $path, int $flags = PATHINFO_ALL): self { }
    public function pathinfo(int $flags = PATHINFO_ALL): self { }

    /** @see \str_contains() */
    public self $str_contains;
    public function str_contains(string $haystack, string $needle): self { }
    public function str_contains(string $needle): self { }

    /** @see \str_contains() */
    public self $contains;
    public function contains(string $haystack, string $needle): self { }
    public function contains(string $needle): self { }

    /** @see \str_starts_with() */
    public self $str_starts_with;
    public function str_starts_with(string $haystack, string $needle): self { }
    public function str_starts_with(string $needle): self { }

    /** @see \str_starts_with() */
    public self $starts_with;
    public function starts_with(string $haystack, string $needle): self { }
    public function starts_with(string $needle): self { }

    /** @see \ord() */
    public self $ord;
    public function ord(string $character): self { }
    public function ord(): self { }

    /** @see \chr() */
    public self $chr;
    public function chr(int $codepoint): self { }
    public function chr(): self { }

    /** @see \addcslashes() */
    public self $addcslashes;
    public function addcslashes(string $string, string $characters): self { }
    public function addcslashes(string $characters): self { }

    /** @see \addslashes() */
    public self $addslashes;
    public function addslashes(string $string): self { }
    public function addslashes(): self { }

    /** @see \strnatcasecmp() */
    public self $strnatcasecmp;
    public function strnatcasecmp(string $string1, string $string2): self { }
    public function strnatcasecmp(string $string2): self { }

    /** @see \str_split() */
    public self $str_split;
    public function str_split(string $string, int $length = 1): self { }
    public function str_split(int $length = 1): self { }

    /** @see \str_split() */
    public self $split;
    public function split(string $string, int $length = 1): self { }
    public function split(int $length = 1): self { }

    /** @see \utf8_encode() */
    public self $utf8_encode;
    public function utf8_encode(string $string): self { }
    public function utf8_encode(): self { }

    /** @see \passthru() */
    public self $passthru;
    public function passthru(string $command, &$result_code = null): self { }
    public function passthru(&$result_code = null): self { }

    /** @see \rmdir() */
    public self $rmdir;
    public function rmdir(string $directory, $context = null): self { }
    public function rmdir($context = null): self { }

    /** @see \feof() */
    public self $feof;
    public function feof($stream): self { }
    public function feof(): self { }

    /** @see \fgetc() */
    public self $fgetc;
    public function fgetc($stream): self { }
    public function fgetc(): self { }

    /** @see \mkdir() */
    public self $mkdir;
    public function mkdir(string $directory, int $permissions = 511, bool $recursive = false, $context = null): self { }
    public function mkdir(int $permissions = 511, bool $recursive = false, $context = null): self { }

    /** @see \filectime() */
    public self $filectime;
    public function filectime(string $filename): self { }
    public function filectime(): self { }

    /** @see \is_writable() */
    public self $is_writable;
    public function is_writable(string $filename): self { }
    public function is_writable(): self { }

    /** @see \stat() */
    public self $stat;
    public function stat(string $filename): self { }
    public function stat(): self { }

    /** @see \vfprintf() */
    public self $vfprintf;
    public function vfprintf($stream, string $format, array $values): self { }
    public function vfprintf(string $format, array $values): self { }

    /** @see \phpinfo() */
    public self $phpinfo;
    public function phpinfo(int $flags = INFO_ALL): self { }
    public function phpinfo(): self { }

    /** @see \symlink() */
    public self $symlink;
    public function symlink(string $target, string $link): self { }
    public function symlink(string $link): self { }

    /** @see \abs() */
    public self $abs;
    public function abs(int|float $num): self { }
    public function abs(): self { }

    /** @see \atan() */
    public self $atan;
    public function atan(float $num): self { }
    public function atan(): self { }

    /** @see \rad2deg() */
    public self $rad2deg;
    public function rad2deg(float $num): self { }
    public function rad2deg(): self { }

    /** @see \decbin() */
    public self $decbin;
    public function decbin(int $num): self { }
    public function decbin(): self { }

    /** @see \is_object() */
    public self $is_object;
    public function is_object(mixed $value): self { }
    public function is_object(): self { }

    /** @see \mb_strpos() */
    public self $mb_strpos;
    public function mb_strpos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strpos(string $needle, int $offset = 0, ?string $encoding = null): self { }

    /** @see \mb_strimwidth() */
    public self $mb_strimwidth;
    public function mb_strimwidth(string $string, int $start, int $width, string $trim_marker = "", ?string $encoding = null): self { }
    public function mb_strimwidth(int $start, int $width, string $trim_marker = "", ?string $encoding = null): self { }

    /** @see \mb_encode_mimeheader() */
    public self $mb_encode_mimeheader;
    public function mb_encode_mimeheader(string $string, ?string $charset = null, ?string $transfer_encoding = null, string $newline = "\r\n", int $indent = 0): self { }
    public function mb_encode_mimeheader(?string $charset = null, ?string $transfer_encoding = null, string $newline = "\r\n", int $indent = 0): self { }

    /** @see \mb_get_info() */
    public self $mb_get_info;
    public function mb_get_info(string $type = "all"): self { }
    public function mb_get_info(): self { }

    /** @see \mb_ereg_search_init() */
    public self $mb_ereg_search_init;
    public function mb_ereg_search_init(string $string, ?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_init(?string $pattern = null, ?string $options = null): self { }

    /** @see \array_aggregate() */
    public self $array_aggregate;
    public function array_aggregate(iterable $array, $columns, $key = null): self { }
    public function array_aggregate($columns, $key = null): self { }

    /** @see \array_aggregate() */
    public self $aggregate;
    public function aggregate(iterable $array, $columns, $key = null): self { }
    public function aggregate($columns, $key = null): self { }

    /** @see \array_all() */
    public self $array_all;
    public function array_all(iterable $array, callable $callback = null, $default = true): self { }
    public function array_all(callable $callback = null, $default = true): self { }

    /** @see \array_all() */
    public self $all;
    public function all(iterable $array, callable $callback = null, $default = true): self { }
    public function all(callable $callback = null, $default = true): self { }

    /** @see \array_find_last() */
    public self $array_find_last;
    public function array_find_last(iterable $array, callable $callback, $is_key = true): self { }
    public function array_find_last(callable $callback, $is_key = true): self { }

    /** @see \array_find_last() */
    public self $find_last;
    public function find_last(iterable $array, callable $callback, $is_key = true): self { }
    public function find_last(callable $callback, $is_key = true): self { }

    /** @see \array_find_recursive() */
    public self $array_find_recursive;
    public function array_find_recursive(iterable $array, callable $callback, $is_key = true): self { }
    public function array_find_recursive(callable $callback, $is_key = true): self { }

    /** @see \array_find_recursive() */
    public self $find_recursive;
    public function find_recursive(iterable $array, callable $callback, $is_key = true): self { }
    public function find_recursive(callable $callback, $is_key = true): self { }

    /** @see \array_merge2() */
    public self $array_merge2;
    public function array_merge2(iterable ...$arrays): self { }
    public function array_merge2(): self { }

    /** @see \array_merge2() */
    public self $merge2;
    public function merge2(iterable ...$arrays): self { }
    public function merge2(): self { }

    /** @see \array_pickup() */
    public self $array_pickup;
    public function array_pickup(iterable $array, $keys): self { }
    public function array_pickup($keys): self { }

    /** @see \array_pickup() */
    public self $pickup;
    public function pickup(iterable $array, $keys): self { }
    public function pickup($keys): self { }

    /** @see \array_random() */
    public self $array_random;
    public function array_random(iterable $array, $count = null, $preserve_keys = false): self { }
    public function array_random($count = null, $preserve_keys = false): self { }

    /** @see \array_random() */
    public self $random;
    public function random(iterable $array, $count = null, $preserve_keys = false): self { }
    public function random($count = null, $preserve_keys = false): self { }

    /** @see \array_remove() */
    public self $array_remove;
    public function array_remove(iterable $array, $keys): self { }
    public function array_remove($keys): self { }

    /** @see \array_remove() */
    public self $remove;
    public function remove(iterable $array, $keys): self { }
    public function remove($keys): self { }

    /** @see \array_select() */
    public self $array_select;
    public function array_select(iterable $array, $columns, $index = null): self { }
    public function array_select($columns, $index = null): self { }

    /** @see \array_select() */
    public self $select;
    public function select(iterable $array, $columns, $index = null): self { }
    public function select($columns, $index = null): self { }

    /** @see \first_keyvalue() */
    public self $first_keyvalue;
    public function first_keyvalue(iterable $array, $default = null): self { }
    public function first_keyvalue($default = null): self { }

    /** @see \last_key() */
    public self $last_key;
    public function last_key(iterable $array, $default = null): self { }
    public function last_key($default = null): self { }

    /** @see \class_loader() */
    public self $class_loader;
    public function class_loader($startdir = null): self { }
    public function class_loader(): self { }

    /** @see \class_uses_all() */
    public self $class_uses_all;
    public function class_uses_all($class, $autoload = true): self { }
    public function class_uses_all($autoload = true): self { }

    /** @see \const_exists() */
    public self $const_exists;
    public function const_exists($classname, $constname = ""): self { }
    public function const_exists($constname = ""): self { }

    /** @see \ini_export() */
    public self $ini_export;
    public function ini_export(iterable $iniarray, $options = []): self { }
    public function ini_export($options = []): self { }

    /** @see \paml_import() */
    public self $paml_import;
    public function paml_import($pamlstring, $options = []): self { }
    public function paml_import($options = []): self { }

    /** @see \file_equals() */
    public self $file_equals;
    public function file_equals($file1, $file2, $chunk_size = null): self { }
    public function file_equals($file2, $chunk_size = null): self { }

    /** @see \file_pos() */
    public self $file_pos;
    public function file_pos($filename, $needle, $start = 0, $end = null, $chunksize = null): self { }
    public function file_pos($needle, $start = 0, $end = null, $chunksize = null): self { }

    /** @see \file_tree() */
    public self $file_tree;
    public function file_tree($dirname, $filter_condition = []): self { }
    public function file_tree($filter_condition = []): self { }

    /** @see \fnmatch_and() */
    public self $fnmatch_and;
    public function fnmatch_and($patterns, $string, $flags = 0): self { }
    public function fnmatch_and($string, $flags = 0): self { }

    /** @see \path_is_absolute() */
    public self $path_is_absolute;
    public function path_is_absolute($path): self { }
    public function path_is_absolute(): self { }

    /** @see \function_alias() */
    public self $function_alias;
    public function function_alias($original, $alias): self { }
    public function function_alias($alias): self { }

    /** @see \arguments() */
    public self $arguments;
    public function arguments($rule, $argv = null): self { }
    public function arguments($argv = null): self { }

    /** @see \is_ansi() */
    public self $is_ansi;
    public function is_ansi($stream): self { }
    public function is_ansi(): self { }

    /** @see \setenvs() */
    public self $setenvs;
    public function setenvs($env_vars): self { }
    public function setenvs(): self { }

    /** @see \decimal() */
    public self $decimal;
    public function decimal($value, $precision = 0, $mode = 0): self { }
    public function decimal($precision = 0, $mode = 0): self { }

    /** @see \sum() */
    public self $sum;
    public function sum(...$variadic): self { }
    public function sum(): self { }

    /** @see \console_log() */
    public self $console_log;
    public function console_log(...$values): self { }
    public function console_log(): self { }

    /** @see \getipaddress() */
    public self $getipaddress;
    public function getipaddress($target = null): self { }
    public function getipaddress(): self { }

    /** @see \http_get() */
    public self $http_get;
    public function http_get($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_get($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see \mb_trim() */
    public self $mb_trim;
    public function mb_trim($string): self { }
    public function mb_trim(): self { }

    /** @see \render_string() */
    public self $render_string;
    public function render_string($template, iterable $array): self { }
    public function render_string(iterable $array): self { }

    /** @see \str_common_prefix() */
    public self $str_common_prefix;
    public function str_common_prefix(...$strings): self { }
    public function str_common_prefix(): self { }

    /** @see \str_common_prefix() */
    public self $common_prefix;
    public function common_prefix(...$strings): self { }
    public function common_prefix(): self { }

    /** @see \str_equals() */
    public self $str_equals;
    public function str_equals($str1, $str2, $case_insensitivity = false): self { }
    public function str_equals($str2, $case_insensitivity = false): self { }

    /** @see \str_equals() */
    public self $equals;
    public function equals($str1, $str2, $case_insensitivity = false): self { }
    public function equals($str2, $case_insensitivity = false): self { }

    /** @see \str_patch() */
    public self $str_patch;
    public function str_patch($string, $patch, $options = []): self { }
    public function str_patch($patch, $options = []): self { }

    /** @see \str_patch() */
    public self $patch;
    public function patch($string, $patch, $options = []): self { }
    public function patch($patch, $options = []): self { }

    /** @see \call_if() */
    public self $call_if;
    public function call_if($condition, callable $callable, ...$arguments): self { }
    public function call_if(callable $callable, ...$arguments): self { }

    /** @see \try_catch() */
    public self $try_catch;
    public function try_catch($try, $catch = null, ...$variadic): self { }
    public function try_catch($catch = null, ...$variadic): self { }

    /** @see \build_uri() */
    public self $build_uri;
    public function build_uri($parts, $options = []): self { }
    public function build_uri($options = []): self { }

}
