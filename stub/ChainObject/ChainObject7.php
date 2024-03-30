<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject7
{
    /** @see idate() */
    public self $idate;
    public function idate(string $format, ?int $timestamp = null): self { }
    public function idate(?int $timestamp = null): self { }

    /** @see getdate() */
    public self $getdate;
    public function getdate(?int $timestamp = null): self { }
    public function getdate(): self { }

    /** @see date_diff() */
    public self $date_diff;
    public function date_diff(\DateTimeInterface $baseObject, \DateTimeInterface $targetObject, bool $absolute = false): self { }
    public function date_diff(\DateTimeInterface $targetObject, bool $absolute = false): self { }

    /** @see date_time_set() */
    public self $date_time_set;
    public function date_time_set(\DateTime $object, int $hour, int $minute, int $second = 0, int $microsecond = 0): self { }
    public function date_time_set(int $hour, int $minute, int $second = 0, int $microsecond = 0): self { }

    /** @see hash_file() */
    public self $hash_file;
    public function hash_file(string $algo, string $filename, bool $binary = false): self { }
    public function hash_file(string $filename, bool $binary = false): self { }

    /** @see hash_hmac_file() */
    public self $hash_hmac_file;
    public function hash_hmac_file(string $algo, string $filename, string $key, bool $binary = false): self { }
    public function hash_hmac_file(string $filename, string $key, bool $binary = false): self { }

    /** @see hash_update_file() */
    public self $hash_update_file;
    public function hash_update_file(\HashContext $context, string $filename, $stream_context = null): self { }
    public function hash_update_file(string $filename, $stream_context = null): self { }

    /** @see mhash_get_block_size() */
    public self $mhash_get_block_size;
    public function mhash_get_block_size(int $algo): self { }
    public function mhash_get_block_size(): self { }

    /** @see mhash_get_hash_name() */
    public self $mhash_get_hash_name;
    public function mhash_get_hash_name(int $algo): self { }
    public function mhash_get_hash_name(): self { }

    /** @see arsort() */
    public self $arsort;
    public function arsort(array &$array, int $flags = SORT_REGULAR): self { }
    public function arsort(int $flags = SORT_REGULAR): self { }

    /** @see current() */
    public self $current;
    public function current(object|array $array): self { }
    public function current(): self { }

    /** @see max() */
    public self $max;
    public function max(mixed ...$values): self { }
    public function max(): self { }

    /** @see array_replace_recursive() */
    public self $array_replace_recursive;
    public function array_replace_recursive(array ...$replacements): self { }
    public function array_replace_recursive(): self { }

    /** @see array_replace_recursive() */
    public self $replace_recursive;
    public function replace_recursive(array ...$replacements): self { }
    public function replace_recursive(): self { }

    /** @see array_sum() */
    public self $array_sum;
    public function array_sum(array $array): self { }
    public function array_sum(): self { }

    /** @see array_sum() */
    public self $sum;
    public function sum(array $array): self { }
    public function sum(): self { }

    /** @see array_map() */
    public self $array_map;
    public function array_map(?callable $callback, array $array, array ...$arrays): self { }
    public function array_map(array $array, array ...$arrays): self { }

    /** @see array_map() */
    public self $map;
    public function map(?callable $callback, array $array, array ...$arrays): self { }
    public function map(array $array, array ...$arrays): self { }

    /** @see array_combine() */
    public self $array_combine;
    public function array_combine(array $keys, array $values): self { }
    public function array_combine(array $values): self { }

    /** @see array_combine() */
    public self $combine;
    public function combine(array $keys, array $values): self { }
    public function combine(array $values): self { }

    /** @see constant() */
    public self $constant;
    public function constant(string $name): self { }
    public function constant(): self { }

    /** @see getopt() */
    public self $getopt;
    public function getopt(string $short_options, array $long_options = [], &$rest_index = null): self { }
    public function getopt(array $long_options = [], &$rest_index = null): self { }

    /** @see call_user_func() */
    public self $call_user_func;
    public function call_user_func(callable $callback, mixed ...$args): self { }
    public function call_user_func(mixed ...$args): self { }

    /** @see crypt() */
    public self $crypt;
    public function crypt(string $string, string $salt): self { }
    public function crypt(string $salt): self { }

    /** @see md5() */
    public self $md5;
    public function md5(string $string, bool $binary = false): self { }
    public function md5(bool $binary = false): self { }

    /** @see strcoll() */
    public self $strcoll;
    public function strcoll(string $string1, string $string2): self { }
    public function strcoll(string $string2): self { }

    /** @see chop() */
    public self $chop;
    public function chop(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function chop(string $characters = " \n\r\t\v\000"): self { }

    /** @see strtoupper() */
    public self $strtoupper;
    public function strtoupper(string $string): self { }
    public function strtoupper(): self { }

    /** @see substr() */
    public self $substr;
    public function substr(string $string, int $offset, ?int $length = null): self { }
    public function substr(int $offset, ?int $length = null): self { }

    /** @see nl2br() */
    public self $nl2br;
    public function nl2br(string $string, bool $use_xhtml = true): self { }
    public function nl2br(bool $use_xhtml = true): self { }

    /** @see str_pad() */
    public self $str_pad;
    public function str_pad(string $string, int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function str_pad(int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }

    /** @see str_pad() */
    public self $pad;
    public function pad(string $string, int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function pad(int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }

    /** @see str_rot13() */
    public self $str_rot13;
    public function str_rot13(string $string): self { }
    public function str_rot13(): self { }

    /** @see str_rot13() */
    public self $rot13;
    public function rot13(string $string): self { }
    public function rot13(): self { }

    /** @see scandir() */
    public self $scandir;
    public function scandir(string $directory, int $sorting_order = SCANDIR_SORT_ASCENDING, $context = null): self { }
    public function scandir(int $sorting_order = SCANDIR_SORT_ASCENDING, $context = null): self { }

    /** @see fflush() */
    public self $fflush;
    public function fflush($stream): self { }
    public function fflush(): self { }

    /** @see filemtime() */
    public self $filemtime;
    public function filemtime(string $filename): self { }
    public function filemtime(): self { }

    /** @see filesize() */
    public self $filesize;
    public function filesize(string $filename): self { }
    public function filesize(): self { }

    /** @see is_writeable() */
    public self $is_writeable;
    public function is_writeable(string $filename): self { }
    public function is_writeable(): self { }

    /** @see chown() */
    public self $chown;
    public function chown(string $filename, string|int $user): self { }
    public function chown(string|int $user): self { }

    /** @see image_type_to_extension() */
    public self $image_type_to_extension;
    public function image_type_to_extension(int $image_type, bool $include_dot = true): self { }
    public function image_type_to_extension(bool $include_dot = true): self { }

    /** @see phpcredits() */
    public self $phpcredits;
    public function phpcredits(int $flags = CREDITS_ALL): self { }
    public function phpcredits(): self { }

    /** @see floor() */
    public self $floor;
    public function floor(int|float $num): self { }
    public function floor(): self { }

    /** @see cos() */
    public self $cos;
    public function cos(float $num): self { }
    public function cos(): self { }

    /** @see atan2() */
    public self $atan2;
    public function atan2(float $y, float $x): self { }
    public function atan2(float $x): self { }

    /** @see sinh() */
    public self $sinh;
    public function sinh(float $num): self { }
    public function sinh(): self { }

    /** @see log1p() */
    public self $log1p;
    public function log1p(float $num): self { }
    public function log1p(): self { }

    /** @see mt_srand() */
    public self $mt_srand;
    public function mt_srand(int $seed = 0, int $mode = MT_RAND_MT19937): self { }
    public function mt_srand(int $mode = MT_RAND_MT19937): self { }

    /** @see is_scalar() */
    public self $is_scalar;
    public function is_scalar(mixed $value): self { }
    public function is_scalar(): self { }

    /** @see mb_strripos() */
    public self $mb_strripos;
    public function mb_strripos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strripos(string $needle, int $offset = 0, ?string $encoding = null): self { }

    /** @see mb_regex_encoding() */
    public self $mb_regex_encoding;
    public function mb_regex_encoding(?string $encoding = null): self { }
    public function mb_regex_encoding(): self { }

    /** @see mb_eregi() */
    public self $mb_eregi;
    public function mb_eregi(string $pattern, string $string, &$matches = null): self { }
    public function mb_eregi(string $string, &$matches = null): self { }

    /** @see mb_ereg_search_pos() */
    public self $mb_ereg_search_pos;
    public function mb_ereg_search_pos(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_pos(?string $options = null): self { }

    /** @see array_columns() */
    public self $array_columns;
    public function array_columns(iterable $array, $column_keys = null, $index_key = null): self { }
    public function array_columns($column_keys = null, $index_key = null): self { }

    /** @see array_columns() */
    public self $columns;
    public function columns(iterable $array, $column_keys = null, $index_key = null): self { }
    public function columns($column_keys = null, $index_key = null): self { }

    /** @see array_difference() */
    public self $array_difference;
    public function array_difference(iterable $array1, iterable $array2, $delimiter = "."): self { }
    public function array_difference(iterable $array2, $delimiter = "."): self { }

    /** @see array_difference() */
    public self $difference;
    public function difference(iterable $array1, iterable $array2, $delimiter = "."): self { }
    public function difference(iterable $array2, $delimiter = "."): self { }

    /** @see array_find() */
    public self $array_find;
    public function array_find(iterable $array, callable $callback, $is_key = true): self { }
    public function array_find(callable $callback, $is_key = true): self { }

    /** @see array_find() */
    public self $find;
    public function find(iterable $array, callable $callback, $is_key = true): self { }
    public function find(callable $callback, $is_key = true): self { }

    /** @see array_lookup() */
    public self $array_lookup;
    public function array_lookup(iterable $array, $column_key = null, $index_key = null): self { }
    public function array_lookup($column_key = null, $index_key = null): self { }

    /** @see array_lookup() */
    public self $lookup;
    public function lookup(iterable $array, $column_key = null, $index_key = null): self { }
    public function lookup($column_key = null, $index_key = null): self { }

    /** @see array_map_key() */
    public self $array_map_key;
    public function array_map_key(iterable $array, callable $callback): self { }
    public function array_map_key(callable $callback): self { }

    /** @see array_map_key() */
    public self $map_key;
    public function map_key(iterable $array, callable $callback): self { }
    public function map_key(callable $callback): self { }

    /** @see array_nmap() */
    public self $array_nmap;
    public function array_nmap(iterable $array, callable $callback, $n, ...$variadic): self { }
    public function array_nmap(callable $callback, $n, ...$variadic): self { }

    /** @see array_nmap() */
    public self $nmap;
    public function nmap(iterable $array, callable $callback, $n, ...$variadic): self { }
    public function nmap(callable $callback, $n, ...$variadic): self { }

    /** @see class_namespace() */
    public self $class_namespace;
    public function class_namespace($class): self { }
    public function class_namespace(): self { }

    /** @see class_shorten() */
    public self $class_shorten;
    public function class_shorten($class): self { }
    public function class_shorten(): self { }

    /** @see get_object_properties() */
    public self $get_object_properties;
    public function get_object_properties($object, &$privates = []): self { }
    public function get_object_properties(&$privates = []): self { }

    /** @see paml_export() */
    public self $paml_export;
    public function paml_export(iterable $pamlarray, $options = []): self { }
    public function paml_export($options = []): self { }

    /** @see date_validate() */
    public self $date_validate;
    public function date_validate($datetime_string, $format = "Y/m/d H:i:s", $overhour = 0): self { }
    public function date_validate($format = "Y/m/d H:i:s", $overhour = 0): self { }

    /** @see process_async() */
    public self $process_async;
    public function process_async($command, $args = [], $stdin = "", &$stdout = "", &$stderr = "", $cwd = null, ?array $env = null, $options = null): self { }
    public function process_async($args = [], $stdin = "", &$stdout = "", &$stderr = "", $cwd = null, ?array $env = null, $options = null): self { }

    /** @see file_extension() */
    public self $file_extension;
    public function file_extension($filename, $extension = ""): self { }
    public function file_extension($extension = ""): self { }

    /** @see rsync() */
    public self $rsync;
    public function rsync($src, $dst, $options = []): self { }
    public function rsync($dst, $options = []): self { }

    /** @see abind() */
    public self $abind;
    public function abind(callable $callable, $default_args): self { }
    public function abind($default_args): self { }

    /** @see delegate() */
    public self $delegate;
    public function delegate($invoker, callable $callable, $arity = null): self { }
    public function delegate(callable $callable, $arity = null): self { }

    /** @see func_method() */
    public self $func_method;
    public function func_method($methodname, ...$defaultargs): self { }
    public function func_method(...$defaultargs): self { }

    /** @see iterator_chunk() */
    public self $iterator_chunk;
    public function iterator_chunk($iterator, $length, $preserve_keys = false): self { }
    public function iterator_chunk($length, $preserve_keys = false): self { }

    /** @see iterator_maps() */
    public self $iterator_maps;
    public function iterator_maps(iterable $iterable, callable ...$callbacks): self { }
    public function iterator_maps(callable ...$callbacks): self { }

    /** @see minimum() */
    public self $minimum;
    public function minimum(...$variadic): self { }
    public function minimum(): self { }

    /** @see highlight_php() */
    public self $highlight_php;
    public function highlight_php($phpcode, $options = []): self { }
    public function highlight_php($options = []): self { }

    /** @see parse_php() */
    public self $parse_php;
    public function parse_php($phpcode, $option = []): self { }
    public function parse_php($option = []): self { }

    /** @see http_post() */
    public self $http_post;
    public function http_post($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_post($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see ob_capture() */
    public self $ob_capture;
    public function ob_capture(callable $callback, ...$variadic): self { }
    public function ob_capture(...$variadic): self { }

    /** @see preg_replaces() */
    public self $preg_replaces;
    public function preg_replaces($pattern, $replacements, $subject, $limit = -1, &$count = null): self { }
    public function preg_replaces($replacements, $subject, $limit = -1, &$count = null): self { }

    /** @see reflect_types() */
    public self $reflect_types;
    public function reflect_types($reflection_type = null): self { }
    public function reflect_types(): self { }

    /** @see strpos_escaped() */
    public self $strpos_escaped;
    public function strpos_escaped($haystack, $needle, $offset = 0, $escape = "\\", &$found = null): self { }
    public function strpos_escaped($needle, $offset = 0, $escape = "\\", &$found = null): self { }

    /** @see strpos_quoted() */
    public self $strpos_quoted;
    public function strpos_quoted($haystack, $needle, $offset = 0, $enclosure = "'\"", $escape = "\\", &$found = null): self { }
    public function strpos_quoted($needle, $offset = 0, $enclosure = "'\"", $escape = "\\", &$found = null): self { }

    /** @see throw_if() */
    public self $throw_if;
    public function throw_if($flag, $ex, ...$ex_args): self { }
    public function throw_if($ex, ...$ex_args): self { }

    /** @see benchmark() */
    public self $benchmark;
    public function benchmark($suite, $args = [], $millisec = 1000, $output = true): self { }
    public function benchmark($args = [], $millisec = 1000, $output = true): self { }

    /** @see flagval() */
    public self $flagval;
    public function flagval($var, $trim = false): self { }
    public function flagval($trim = false): self { }

    /** @see phpval() */
    public self $phpval;
    public function phpval($var, $contextvars = []): self { }
    public function phpval($contextvars = []): self { }

    /** @see var_type() */
    public self $var_type;
    public function var_type($var, $valid_name = false): self { }
    public function var_type($valid_name = false): self { }

}
