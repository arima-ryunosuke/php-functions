<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObject4
{
    /** @see \gmmktime() */
    public self $gmmktime;
    public function gmmktime(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function gmmktime(?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }

    /** @see \strftime() */
    public self $strftime;
    public function strftime(string $format, ?int $timestamp = null): self { }
    public function strftime(?int $timestamp = null): self { }

    /** @see \hash_init() */
    public self $hash_init;
    public function hash_init(string $algo, int $flags = 0, string $key = ""): self { }
    public function hash_init(int $flags = 0, string $key = ""): self { }

    /** @see \header_register_callback() */
    public self $header_register_callback;
    public function header_register_callback(callable $callback): self { }
    public function header_register_callback(): self { }

    /** @see \output_add_rewrite_var() */
    public self $output_add_rewrite_var;
    public function output_add_rewrite_var(string $name, string $value): self { }
    public function output_add_rewrite_var(string $value): self { }

    /** @see \pos() */
    public self $pos;
    public function pos(object|array $array): self { }
    public function pos(): self { }

    /** @see \compact() */
    public self $compact;
    public function compact($var_name, ...$var_names): self { }
    public function compact(...$var_names): self { }

    /** @see \array_keys() */
    public self $array_keys;
    public function array_keys(array $array, mixed $filter_value, bool $strict = false): self { }
    public function array_keys(mixed $filter_value, bool $strict = false): self { }

    /** @see \array_keys() */
    public self $keys;
    public function keys(array $array, mixed $filter_value, bool $strict = false): self { }
    public function keys(mixed $filter_value, bool $strict = false): self { }

    /** @see \key_exists() */
    public self $key_exists;
    public function key_exists($key, array $array): self { }
    public function key_exists(array $array): self { }

    /** @see \array_chunk() */
    public self $array_chunk;
    public function array_chunk(array $array, int $length, bool $preserve_keys = false): self { }
    public function array_chunk(int $length, bool $preserve_keys = false): self { }

    /** @see \array_chunk() */
    public self $chunk;
    public function chunk(array $array, int $length, bool $preserve_keys = false): self { }
    public function chunk(int $length, bool $preserve_keys = false): self { }

    /** @see \getenv() */
    public self $getenv;
    public function getenv(?string $name = null, bool $local_only = false): self { }
    public function getenv(bool $local_only = false): self { }

    /** @see \getprotobyname() */
    public self $getprotobyname;
    public function getprotobyname(string $protocol): self { }
    public function getprotobyname(): self { }

    /** @see \parse_ini_file() */
    public self $parse_ini_file;
    public function parse_ini_file(string $filename, bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_file(bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }

    /** @see \gethostbyaddr() */
    public self $gethostbyaddr;
    public function gethostbyaddr(string $ip): self { }
    public function gethostbyaddr(): self { }

    /** @see \hrtime() */
    public self $hrtime;
    public function hrtime(bool $as_number = false): self { }
    public function hrtime(): self { }

    /** @see \html_entity_decode() */
    public self $html_entity_decode;
    public function html_entity_decode(string $string, int $flags = ENT_COMPAT, ?string $encoding = null): self { }
    public function html_entity_decode(int $flags = ENT_COMPAT, ?string $encoding = null): self { }

    /** @see \hex2bin() */
    public self $hex2bin;
    public function hex2bin(string $string): self { }
    public function hex2bin(): self { }

    /** @see \str_replace() */
    public self $str_replace;
    public function str_replace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function str_replace(array|string $replace, array|string $subject, &$count = null): self { }

    /** @see \str_replace() */
    public self $replace;
    public function replace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function replace(array|string $replace, array|string $subject, &$count = null): self { }

    /** @see \closedir() */
    public self $closedir;
    public function closedir($dir_handle = null): self { }
    public function closedir(): self { }

    /** @see \glob() */
    public self $glob;
    public function glob(string $pattern, int $flags = 0): self { }
    public function glob(int $flags = 0): self { }

    /** @see \system() */
    public self $system;
    public function system(string $command, &$result_code = null): self { }
    public function system(&$result_code = null): self { }

    /** @see \fpassthru() */
    public self $fpassthru;
    public function fpassthru($stream): self { }
    public function fpassthru(): self { }

    /** @see \ftruncate() */
    public self $ftruncate;
    public function ftruncate($stream, int $size): self { }
    public function ftruncate(int $size): self { }

    /** @see \fputs() */
    public self $fputs;
    public function fputs($stream, string $data, ?int $length = null): self { }
    public function fputs(string $data, ?int $length = null): self { }

    /** @see \sprintf() */
    public self $sprintf;
    public function sprintf(string $format, mixed ...$values): self { }
    public function sprintf(mixed ...$values): self { }

    /** @see \getimagesizefromstring() */
    public self $getimagesizefromstring;
    public function getimagesizefromstring(string $string, &$image_info = null): self { }
    public function getimagesizefromstring(&$image_info = null): self { }

    /** @see \mail() */
    public self $mail;
    public function mail(string $to, string $subject, string $message, array|string $additional_headers = [], string $additional_params = ""): self { }
    public function mail(string $subject, string $message, array|string $additional_headers = [], string $additional_params = ""): self { }

    /** @see \is_infinite() */
    public self $is_infinite;
    public function is_infinite(float $num): self { }
    public function is_infinite(): self { }

    /** @see \hexdec() */
    public self $hexdec;
    public function hexdec(string $hex_string): self { }
    public function hexdec(): self { }

    /** @see \number_format() */
    public self $number_format;
    public function number_format(float $num, int $decimals = 0, ?string $decimal_separator = ".", ?string $thousands_separator = ","): self { }
    public function number_format(int $decimals = 0, ?string $decimal_separator = ".", ?string $thousands_separator = ","): self { }

    /** @see \gettimeofday() */
    public self $gettimeofday;
    public function gettimeofday(bool $as_float = false): self { }
    public function gettimeofday(): self { }

    /** @see \random_bytes() */
    public self $random_bytes;
    public function random_bytes(int $length): self { }
    public function random_bytes(): self { }

    /** @see \set_file_buffer() */
    public self $set_file_buffer;
    public function set_file_buffer($stream, int $size): self { }
    public function set_file_buffer(int $size): self { }

    /** @see \is_null() */
    public self $is_null;
    public function is_null(mixed $value): self { }
    public function is_null(): self { }

    /** @see \is_iterable() */
    public self $is_iterable;
    public function is_iterable(mixed $value): self { }
    public function is_iterable(): self { }

    /** @see \is_countable() */
    public self $is_countable;
    public function is_countable(mixed $value): self { }
    public function is_countable(): self { }

    /** @see \urlencode() */
    public self $urlencode;
    public function urlencode(string $string): self { }
    public function urlencode(): self { }

    /** @see \convert_uudecode() */
    public self $convert_uudecode;
    public function convert_uudecode(string $string): self { }
    public function convert_uudecode(): self { }

    /** @see \mb_detect_order() */
    public self $mb_detect_order;
    public function mb_detect_order(array|string|null $encoding = null): self { }
    public function mb_detect_order(): self { }

    /** @see \mb_strlen() */
    public self $mb_strlen;
    public function mb_strlen(string $string, ?string $encoding = null): self { }
    public function mb_strlen(?string $encoding = null): self { }

    /** @see \mb_convert_encoding() */
    public self $mb_convert_encoding;
    public function mb_convert_encoding(array|string $string, string $to_encoding, array|string|null $from_encoding = null): self { }
    public function mb_convert_encoding(string $to_encoding, array|string|null $from_encoding = null): self { }

    /** @see \mb_detect_encoding() */
    public self $mb_detect_encoding;
    public function mb_detect_encoding(string $string, array|string|null $encodings = null, bool $strict = false): self { }
    public function mb_detect_encoding(array|string|null $encodings = null, bool $strict = false): self { }

    /** @see \mb_convert_kana() */
    public self $mb_convert_kana;
    public function mb_convert_kana(string $string, string $mode = "KV", ?string $encoding = null): self { }
    public function mb_convert_kana(string $mode = "KV", ?string $encoding = null): self { }

    /** @see \array_count() */
    public self $array_count;
    public function array_count(iterable $array, callable $callback, $recursive = false): self { }
    public function array_count(callable $callback, $recursive = false): self { }

    /** @see \array_count() */
    public self $count;
    public function count(iterable $array, callable $callback, $recursive = false): self { }
    public function count(callable $callback, $recursive = false): self { }

    /** @see \array_flatten() */
    public self $array_flatten;
    public function array_flatten(iterable $array, $delimiter = null): self { }
    public function array_flatten($delimiter = null): self { }

    /** @see \array_flatten() */
    public self $flatten;
    public function flatten(iterable $array, $delimiter = null): self { }
    public function flatten($delimiter = null): self { }

    /** @see \array_lmap() */
    public self $array_lmap;
    public function array_lmap(iterable $array, callable $callback, ...$variadic): self { }
    public function array_lmap(callable $callback, ...$variadic): self { }

    /** @see \array_lmap() */
    public self $lmap;
    public function lmap(iterable $array, callable $callback, ...$variadic): self { }
    public function lmap(callable $callback, ...$variadic): self { }

    /** @see \array_unset() */
    public self $array_unset;
    public function array_unset(iterable &$array, $key, $default = null): self { }
    public function array_unset($key, $default = null): self { }

    /** @see \array_unset() */
    public self $unset;
    public function unset(iterable &$array, $key, $default = null): self { }
    public function unset($key, $default = null): self { }

    /** @see \array_zip() */
    public self $array_zip;
    public function array_zip(iterable ...$arrays): self { }
    public function array_zip(): self { }

    /** @see \array_zip() */
    public self $zip;
    public function zip(iterable ...$arrays): self { }
    public function zip(): self { }

    /** @see \first_key() */
    public self $first_key;
    public function first_key(iterable $array, $default = null): self { }
    public function first_key($default = null): self { }

    /** @see \auto_loader() */
    public self $auto_loader;
    public function auto_loader($startdir = null): self { }
    public function auto_loader(): self { }

    /** @see \get_class_constants() */
    public self $get_class_constants;
    public function get_class_constants($class, $filter = null): self { }
    public function get_class_constants($filter = null): self { }

    /** @see \stdclass() */
    public self $stdclass;
    public function stdclass(iterable $fields = []): self { }
    public function stdclass(): self { }

    /** @see \ini_import() */
    public self $ini_import;
    public function ini_import($inistring, $options = []): self { }
    public function ini_import($options = []): self { }

    /** @see \add_error_handler() */
    public self $add_error_handler;
    public function add_error_handler($handler, $error_types = 32767): self { }
    public function add_error_handler($error_types = 32767): self { }

    /** @see \stacktrace() */
    public self $stacktrace;
    public function stacktrace($traces = null, $option = []): self { }
    public function stacktrace($option = []): self { }

    /** @see \dir_diff() */
    public self $dir_diff;
    public function dir_diff($path1, $path2, $options = []): self { }
    public function dir_diff($path2, $options = []): self { }

    /** @see \strmode2oct() */
    public self $strmode2oct;
    public function strmode2oct($perms): self { }
    public function strmode2oct(): self { }

    /** @see \func_wiring() */
    public self $func_wiring;
    public function func_wiring(callable $callable, $dependency): self { }
    public function func_wiring($dependency): self { }

    /** @see \not_func() */
    public self $not_func;
    public function not_func(callable $callable): self { }
    public function not_func(): self { }

    /** @see \getenvs() */
    public self $getenvs;
    public function getenvs($env_vars): self { }
    public function getenvs(): self { }

    /** @see \iterator_combine() */
    public self $iterator_combine;
    public function iterator_combine($keys, $values): self { }
    public function iterator_combine($values): self { }

    /** @see \iterator_join() */
    public self $iterator_join;
    public function iterator_join(iterable $iterables, $preserve_keys = true): self { }
    public function iterator_join($preserve_keys = true): self { }

    /** @see \strip_php() */
    public self $strip_php;
    public function strip_php($phtml, $option = [], &$mapping = []): self { }
    public function strip_php($option = [], &$mapping = []): self { }

    /** @see \probability() */
    public self $probability;
    public function probability($probability, $divisor = 100): self { }
    public function probability($divisor = 100): self { }

    /** @see \random_string() */
    public self $random_string;
    public function random_string($length = 8, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }
    public function random_string($charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }

    /** @see \parameter_default() */
    public self $parameter_default;
    public function parameter_default(callable $callable, $arguments = []): self { }
    public function parameter_default($arguments = []): self { }

    /** @see \reflect_callable() */
    public self $reflect_callable;
    public function reflect_callable(callable $callable): self { }
    public function reflect_callable(): self { }

    /** @see \memory_path() */
    public self $memory_path;
    public function memory_path($path = ""): self { }
    public function memory_path(): self { }

    /** @see \mb_monospace() */
    public self $mb_monospace;
    public function mb_monospace($string, $codepoints = []): self { }
    public function mb_monospace($codepoints = []): self { }

    /** @see \mb_str_pad() */
    public self $mb_str_pad;
    public function mb_str_pad($string, $width, $pad_string = " ", $pad_type = STR_PAD_RIGHT): self { }
    public function mb_str_pad($width, $pad_string = " ", $pad_type = STR_PAD_RIGHT): self { }

    /** @see \str_chunk() */
    public self $str_chunk;
    public function str_chunk($string, ...$chunks): self { }
    public function str_chunk(...$chunks): self { }

    /** @see \str_chunk() */
    public self $chunk;
    public function chunk($string, ...$chunks): self { }
    public function chunk(...$chunks): self { }

    /** @see \str_guess() */
    public self $str_guess;
    public function str_guess($string, $candidates, &$percent = null): self { }
    public function str_guess($candidates, &$percent = null): self { }

    /** @see \str_guess() */
    public self $guess;
    public function guess($string, $candidates, &$percent = null): self { }
    public function guess($candidates, &$percent = null): self { }

    /** @see \str_putcsv() */
    public self $str_putcsv;
    public function str_putcsv(iterable $array, $delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }
    public function str_putcsv($delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }

    /** @see \str_putcsv() */
    public self $putcsv;
    public function putcsv(iterable $array, $delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }
    public function putcsv($delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }

    /** @see \strpos_array() */
    public self $strpos_array;
    public function strpos_array($haystack, $needles, $offset = 0): self { }
    public function strpos_array($needles, $offset = 0): self { }

    /** @see \timer() */
    public self $timer;
    public function timer(callable $callable, $count = 1): self { }
    public function timer($count = 1): self { }

    /** @see \decrypt() */
    public self $decrypt;
    public function decrypt($cipherdata, $password, $ciphers = "aes-256-cbc", $tag = ""): self { }
    public function decrypt($password, $ciphers = "aes-256-cbc", $tag = ""): self { }

    /** @see \hashvar() */
    public self $hashvar;
    public function hashvar(...$vars): self { }
    public function hashvar(): self { }

}
