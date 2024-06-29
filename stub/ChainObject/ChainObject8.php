<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject8
{
    /** @see date_timezone_get() */
    public self $date_timezone_get;
    public function date_timezone_get(\DateTimeInterface $object): self { }
    public function date_timezone_get(): self { }

    /** @see date_default_timezone_set() */
    public self $date_default_timezone_set;
    public function date_default_timezone_set(string $timezoneId): self { }
    public function date_default_timezone_set(): self { }

    /** @see hash() */
    public self $hash;
    public function hash(string $algo, string $data, bool $binary = false): self { }
    public function hash(string $data, bool $binary = false): self { }

    /** @see hash_update() */
    public self $hash_update;
    public function hash_update(\HashContext $context, string $data): self { }
    public function hash_update(string $data): self { }

    /** @see hash_pbkdf2() */
    public self $hash_pbkdf2;
    public function hash_pbkdf2(string $algo, string $password, string $salt, int $iterations, int $length = 0, bool $binary = false): self { }
    public function hash_pbkdf2(string $password, string $salt, int $iterations, int $length = 0, bool $binary = false): self { }

    /** @see array_search() */
    public self $array_search;
    public function array_search(mixed $needle, array $haystack, bool $strict = false): self { }
    public function array_search(array $haystack, bool $strict = false): self { }

    /** @see array_search() */
    public self $search;
    public function search(mixed $needle, array $haystack, bool $strict = false): self { }
    public function search(array $haystack, bool $strict = false): self { }

    /** @see array_splice() */
    public self $array_splice;
    public function array_splice(array &$array, int $offset, ?int $length = null, mixed $replacement = []): self { }
    public function array_splice(int $offset, ?int $length = null, mixed $replacement = []): self { }

    /** @see array_splice() */
    public self $splice;
    public function splice(array &$array, int $offset, ?int $length = null, mixed $replacement = []): self { }
    public function splice(int $offset, ?int $length = null, mixed $replacement = []): self { }

    /** @see array_column() */
    public self $array_column;
    public function array_column(array $array, string|int|null $column_key, string|int|null $index_key = null): self { }
    public function array_column(string|int|null $column_key, string|int|null $index_key = null): self { }

    /** @see array_column() */
    public self $column;
    public function column(array $array, string|int|null $column_key, string|int|null $index_key = null): self { }
    public function column(string|int|null $column_key, string|int|null $index_key = null): self { }

    /** @see array_diff_ukey() */
    public self $array_diff_ukey;
    public function array_diff_ukey(array $array, ...$rest): self { }
    public function array_diff_ukey(...$rest): self { }

    /** @see array_diff_ukey() */
    public self $diff_ukey;
    public function diff_ukey(array $array, ...$rest): self { }
    public function diff_ukey(...$rest): self { }

    /** @see array_filter() */
    public self $array_filter;
    public function array_filter(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function array_filter(?callable $callback = null, int $mode = 0): self { }

    /** @see array_filter() */
    public self $filter;
    public function filter(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function filter(?callable $callback = null, int $mode = 0): self { }

    /** @see ip2long() */
    public self $ip2long;
    public function ip2long(string $ip): self { }
    public function ip2long(): self { }

    /** @see ini_restore() */
    public self $ini_restore;
    public function ini_restore(string $option): self { }
    public function ini_restore(): self { }

    /** @see getservbyname() */
    public self $getservbyname;
    public function getservbyname(string $service, string $protocol): self { }
    public function getservbyname(string $protocol): self { }

    /** @see unregister_tick_function() */
    public self $unregister_tick_function;
    public function unregister_tick_function(callable $callback): self { }
    public function unregister_tick_function(): self { }

    /** @see sha1_file() */
    public self $sha1_file;
    public function sha1_file(string $filename, bool $binary = false): self { }
    public function sha1_file(bool $binary = false): self { }

    /** @see setcookie() */
    public self $setcookie;
    public function setcookie(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setcookie(string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }

    /** @see htmlspecialchars_decode() */
    public self $htmlspecialchars_decode;
    public function htmlspecialchars_decode(string $string, int $flags = ENT_COMPAT): self { }
    public function htmlspecialchars_decode(int $flags = ENT_COMPAT): self { }

    /** @see assert() */
    public self $assert;
    public function assert(mixed $assertion, \Throwable|string|null $description = null): self { }
    public function assert(\Throwable|string|null $description = null): self { }

    /** @see assert_options() */
    public self $assert_options;
    public function assert_options(int $option, mixed $value = null): self { }
    public function assert_options(mixed $value = null): self { }

    /** @see trim() */
    public self $trim;
    public function trim(string $string, string $characters = <<<TEXT
 
	\0
TEXT): self { }
    public function trim(string $characters = <<<TEXT
 
	\0
TEXT): self { }

    /** @see explode() */
    public self $explode;
    public function explode(string $separator, string $string, int $limit = PHP_INT_MAX): self { }
    public function explode(string $string, int $limit = PHP_INT_MAX): self { }

    /** @see strtok() */
    public self $strtok;
    public function strtok(string $string, ?string $token = null): self { }
    public function strtok(?string $token = null): self { }

    /** @see stripslashes() */
    public self $stripslashes;
    public function stripslashes(string $string): self { }
    public function stripslashes(): self { }

    /** @see str_word_count() */
    public self $str_word_count;
    public function str_word_count(string $string, int $format = 0, ?string $characters = null): self { }
    public function str_word_count(int $format = 0, ?string $characters = null): self { }

    /** @see str_word_count() */
    public self $word_count;
    public function word_count(string $string, int $format = 0, ?string $characters = null): self { }
    public function word_count(int $format = 0, ?string $characters = null): self { }

    /** @see readdir() */
    public self $readdir;
    public function readdir($dir_handle = null): self { }
    public function readdir(): self { }

    /** @see get_meta_tags() */
    public self $get_meta_tags;
    public function get_meta_tags(string $filename, bool $use_include_path = false): self { }
    public function get_meta_tags(bool $use_include_path = false): self { }

    /** @see copy() */
    public self $copy;
    public function copy(string $from, string $to, $context = null): self { }
    public function copy(string $to, $context = null): self { }

    /** @see fputcsv() */
    public self $fputcsv;
    public function fputcsv($stream, array $fields, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fputcsv(array $fields, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }

    /** @see fileatime() */
    public self $fileatime;
    public function fileatime(string $filename): self { }
    public function fileatime(): self { }

    /** @see fileperms() */
    public self $fileperms;
    public function fileperms(string $filename): self { }
    public function fileperms(): self { }

    /** @see is_dir() */
    public self $is_dir;
    public function is_dir(string $filename): self { }
    public function is_dir(): self { }

    /** @see disk_free_space() */
    public self $disk_free_space;
    public function disk_free_space(string $directory): self { }
    public function disk_free_space(): self { }

    /** @see fprintf() */
    public self $fprintf;
    public function fprintf($stream, string $format, mixed ...$values): self { }
    public function fprintf(string $format, mixed ...$values): self { }

    /** @see linkinfo() */
    public self $linkinfo;
    public function linkinfo(string $path): self { }
    public function linkinfo(): self { }

    /** @see asin() */
    public self $asin;
    public function asin(float $num): self { }
    public function asin(): self { }

    /** @see pow() */
    public self $pow;
    public function pow(mixed $num, mixed $exponent): self { }
    public function pow(mixed $exponent): self { }

    /** @see bindec() */
    public self $bindec;
    public function bindec(string $binary_string): self { }
    public function bindec(): self { }

    /** @see octdec() */
    public self $octdec;
    public function octdec(string $octal_string): self { }
    public function octdec(): self { }

    /** @see password_verify() */
    public self $password_verify;
    public function password_verify(string $password, string $hash): self { }
    public function password_verify(string $hash): self { }

    /** @see random_int() */
    public self $random_int;
    public function random_int(int $min, int $max): self { }
    public function random_int(int $max): self { }

    /** @see var_dump() */
    public self $var_dump;
    public function var_dump(mixed ...$values): self { }
    public function var_dump(): self { }

    /** @see var_export() */
    public self $var_export;
    public function var_export(mixed $value, bool $return = false): self { }
    public function var_export(bool $return = false): self { }

    /** @see unserialize() */
    public self $unserialize;
    public function unserialize(string $data, array $options = []): self { }
    public function unserialize(array $options = []): self { }

    /** @see mb_strstr() */
    public self $mb_strstr;
    public function mb_strstr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strstr(string $needle, bool $before_needle = false, ?string $encoding = null): self { }

    /** @see mb_convert_case() */
    public self $mb_convert_case;
    public function mb_convert_case(string $string, int $mode, ?string $encoding = null): self { }
    public function mb_convert_case(int $mode, ?string $encoding = null): self { }

    /** @see mb_scrub() */
    public self $mb_scrub;
    public function mb_scrub(string $string, ?string $encoding = null): self { }
    public function mb_scrub(?string $encoding = null): self { }

    /** @see mb_split() */
    public self $mb_split;
    public function mb_split(string $pattern, string $string, int $limit = -1): self { }
    public function mb_split(string $string, int $limit = -1): self { }

    /** @see array_insert() */
    public self $array_insert;
    public function array_insert(iterable $array, $value, $position = null): self { }
    public function array_insert($value, $position = null): self { }

    /** @see array_insert() */
    public self $insert;
    public function insert(iterable $array, $value, $position = null): self { }
    public function insert($value, $position = null): self { }

    /** @see array_limit() */
    public self $array_limit;
    public function array_limit(iterable $array, $limit, $offset = null, $preserve_keys = null): self { }
    public function array_limit($limit, $offset = null, $preserve_keys = null): self { }

    /** @see array_limit() */
    public self $limit;
    public function limit(iterable $array, $limit, $offset = null, $preserve_keys = null): self { }
    public function limit($limit, $offset = null, $preserve_keys = null): self { }

    /** @see groupsort() */
    public self $groupsort;
    public function groupsort(iterable $array, $grouper, $comparator): self { }
    public function groupsort($grouper, $comparator): self { }

    /** @see kvsort() */
    public self $kvsort;
    public function kvsort(iterable $array, $comparator = null, $schwartzians = []): self { }
    public function kvsort($comparator = null, $schwartzians = []): self { }

    /** @see csv_import() */
    public self $csv_import;
    public function csv_import($csvstring, $options = []): self { }
    public function csv_import($options = []): self { }

    /** @see date_fromto() */
    public self $date_fromto;
    public function date_fromto($format, $datetimestring): self { }
    public function date_fromto($datetimestring): self { }

    /** @see date_match() */
    public self $date_match;
    public function date_match($datetime, $cronlike): self { }
    public function date_match($cronlike): self { }

    /** @see backtrace() */
    public self $backtrace;
    public function backtrace($flags = DEBUG_BACKTRACE_PROVIDE_OBJECT, $options = []): self { }
    public function backtrace($options = []): self { }

    /** @see cp_rf() */
    public self $cp_rf;
    public function cp_rf($src, $dst): self { }
    public function cp_rf($dst): self { }

    /** @see file_set_tree() */
    public self $file_set_tree;
    public function file_set_tree($contents_tree, $umask = null): self { }
    public function file_set_tree($umask = null): self { }

    /** @see finalize() */
    public self $finalize;
    public function finalize(callable $finalizer): self { }
    public function finalize(): self { }

    /** @see evaluate() */
    public self $evaluate;
    public function evaluate($phpcode, $contextvars = [], $cachesize = 256): self { }
    public function evaluate($contextvars = [], $cachesize = 256): self { }

    /** @see cidr2ip() */
    public self $cidr2ip;
    public function cidr2ip($cidr): self { }
    public function cidr2ip(): self { }

    /** @see incidr() */
    public self $incidr;
    public function incidr($ipaddr, $cidr): self { }
    public function incidr($cidr): self { }

    /** @see glob2regex() */
    public self $glob2regex;
    public function glob2regex($pattern, $flags = 0): self { }
    public function glob2regex($flags = 0): self { }

    /** @see unique_string() */
    public self $unique_string;
    public function unique_string($source, $initial = null, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }
    public function unique_string($initial = null, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }

    /** @see callable_code() */
    public self $callable_code;
    public function callable_code(callable $callable): self { }
    public function callable_code(): self { }

    /** @see memory_stream() */
    public self $memory_stream;
    public function memory_stream($path = ""): self { }
    public function memory_stream(): self { }

    /** @see profiler() */
    public self $profiler;
    public function profiler($options = []): self { }
    public function profiler(): self { }

    /** @see camel_case() */
    public self $camel_case;
    public function camel_case(?string $string, ?string $delimiter = "_"): self { }
    public function camel_case(?string $delimiter = "_"): self { }

    /** @see mb_ellipsis() */
    public self $mb_ellipsis;
    public function mb_ellipsis(?string $string, $width, $trimmarker = "...", $pos = null): self { }
    public function mb_ellipsis($width, $trimmarker = "...", $pos = null): self { }

    /** @see starts_with() */
    public self $starts_with;
    public function starts_with(?string $string, $with, $case_insensitivity = false): self { }
    public function starts_with($with, $case_insensitivity = false): self { }

    /** @see str_embed() */
    public self $str_embed;
    public function str_embed(?string $string, $replacemap, $enclosure = "'\"", $escape = "\\", &$replaced = null): self { }
    public function str_embed($replacemap, $enclosure = "'\"", $escape = "\\", &$replaced = null): self { }

    /** @see str_embed() */
    public self $embed;
    public function embed(?string $string, $replacemap, $enclosure = "'\"", $escape = "\\", &$replaced = null): self { }
    public function embed($replacemap, $enclosure = "'\"", $escape = "\\", &$replaced = null): self { }

    /** @see strpos_closest() */
    public self $strpos_closest;
    public function strpos_closest(string $haystack, string $needle, ?int $offset = null, int $nth = 1): self { }
    public function strpos_closest(string $needle, ?int $offset = null, int $nth = 1): self { }

    /** @see strtr_escaped() */
    public self $strtr_escaped;
    public function strtr_escaped(?string $string, $replace_pairs, $escape = "\\"): self { }
    public function strtr_escaped($replace_pairs, $escape = "\\"): self { }

    /** @see base64url_encode() */
    public self $base64url_encode;
    public function base64url_encode($string): self { }
    public function base64url_encode(): self { }

    /** @see dataurl_encode() */
    public self $dataurl_encode;
    public function dataurl_encode($data, $metadata = []): self { }
    public function dataurl_encode($metadata = []): self { }

    /** @see uri_parse() */
    public self $uri_parse;
    public function uri_parse($uri, $default = []): self { }
    public function uri_parse($default = []): self { }

    /** @see cacheobject() */
    public self $cacheobject;
    public function cacheobject($directory, $clean_probability = 0): self { }
    public function cacheobject($clean_probability = 0): self { }

    /** @see number_serial() */
    public self $number_serial;
    public function number_serial($numbers, $step = 1, $separator = null, $doSort = true): self { }
    public function number_serial($step = 1, $separator = null, $doSort = true): self { }

    /** @see is_empty() */
    public self $is_empty;
    public function is_empty($var, $empty_stdClass = false): self { }
    public function is_empty($empty_stdClass = false): self { }

}
