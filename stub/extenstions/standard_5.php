<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait standard_5
{
    /** @see \number_format() */
    public self $number_format;
    public function number_format(float $num, int $decimals = 0, ?string $decimal_separator = ".", ?string $thousands_separator = ","): self { }
    public function number_format0(int $decimals = 0, ?string $decimal_separator = ".", ?string $thousands_separator = ","): self { }
    public function number_format1(float $num, ?string $decimal_separator = ".", ?string $thousands_separator = ","): self { }
    public function number_format2(float $num, int $decimals = 0, ?string $thousands_separator = ","): self { }
    public function number_format3(float $num, int $decimals = 0, ?string $decimal_separator = "."): self { }

    /** @see \octdec() */
    public self $octdec;
    public function octdec(string $octal_string): self { }
    public function octdec0(): self { }

    /** @see \opendir() */
    public self $opendir;
    public function opendir(string $directory, $context = null): self { }
    public function opendir0($context = null): self { }
    public function opendir1(string $directory): self { }

    /** @see \openlog() */
    public function openlog(string $prefix, int $flags, int $facility): self { }
    public function openlog0(int $flags, int $facility): self { }
    public function openlog1(string $prefix, int $facility): self { }
    public function openlog2(string $prefix, int $flags): self { }

    /** @see \ord() */
    public self $ord;
    public function ord(string $character): self { }
    public function ord0(): self { }

    /** @see \output_add_rewrite_var() */
    public function output_add_rewrite_var(string $name, string $value): self { }
    public function output_add_rewrite_var0(string $value): self { }
    public function output_add_rewrite_var1(string $name): self { }

    /** @see \pack() */
    public self $pack;
    public function pack(string $format, mixed ...$values): self { }
    public function pack0(mixed ...$values): self { }
    public function pack1(string $format): self { }

    /** @see \parse_ini_file() */
    public self $parse_ini_file;
    public function parse_ini_file(string $filename, bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_file0(bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_file1(string $filename, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_file2(string $filename, bool $process_sections = false): self { }

    /** @see \parse_ini_string() */
    public self $parse_ini_string;
    public function parse_ini_string(string $ini_string, bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_string0(bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_string1(string $ini_string, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_string2(string $ini_string, bool $process_sections = false): self { }

    /** @see \parse_str() */
    public function parse_str(string $string, &$result): self { }
    public function parse_str0(&$result): self { }
    public function parse_str1(string $string): self { }

    /** @see \parse_url() */
    public self $parse_url;
    public function parse_url(string $url, int $component = -1): self { }
    public function parse_url0(int $component = -1): self { }
    public function parse_url1(string $url): self { }

    /** @see \passthru() */
    public self $passthru;
    public function passthru(string $command, &$result_code = null): self { }
    public function passthru0(&$result_code = null): self { }
    public function passthru1(string $command): self { }

    /** @see \password_get_info() */
    public self $password_get_info;
    public function password_get_info(string $hash): self { }
    public function password_get_info0(): self { }

    /** @see \password_hash() */
    public function password_hash(string $password, string|int|null $algo, array $options = []): self { }
    public function password_hash0(string|int|null $algo, array $options = []): self { }
    public function password_hash1(string $password, array $options = []): self { }
    public function password_hash2(string $password, string|int|null $algo): self { }

    /** @see \password_needs_rehash() */
    public function password_needs_rehash(string $hash, string|int|null $algo, array $options = []): self { }
    public function password_needs_rehash0(string|int|null $algo, array $options = []): self { }
    public function password_needs_rehash1(string $hash, array $options = []): self { }
    public function password_needs_rehash2(string $hash, string|int|null $algo): self { }

    /** @see \password_verify() */
    public function password_verify(string $password, string $hash): self { }
    public function password_verify0(string $hash): self { }
    public function password_verify1(string $password): self { }

    /** @see \pathinfo() */
    public self $pathinfo;
    public function pathinfo(string $path, int $flags = PATHINFO_ALL): self { }
    public function pathinfo0(int $flags = PATHINFO_ALL): self { }
    public function pathinfo1(string $path): self { }

    /** @see \pclose() */
    public self $pclose;
    public function pclose($handle): self { }
    public function pclose0(): self { }

    /** @see \pfsockopen() */
    public self $pfsockopen;
    public function pfsockopen(string $hostname, int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function pfsockopen0(int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function pfsockopen1(string $hostname, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function pfsockopen2(string $hostname, int $port = -1, &$error_message = null, ?float $timeout = null): self { }
    public function pfsockopen3(string $hostname, int $port = -1, &$error_code = null, ?float $timeout = null): self { }
    public function pfsockopen4(string $hostname, int $port = -1, &$error_code = null, &$error_message = null): self { }

    /** @see \php_strip_whitespace() */
    public self $php_strip_whitespace;
    public function php_strip_whitespace(string $filename): self { }
    public function php_strip_whitespace0(): self { }

    /** @see \php_uname() */
    public function php_uname(string $mode = "a"): self { }
    public function php_uname0(): self { }

    /** @see \phpcredits() */
    public function phpcredits(int $flags = CREDITS_ALL): self { }
    public function phpcredits0(): self { }

    /** @see \phpinfo() */
    public function phpinfo(int $flags = INFO_ALL): self { }
    public function phpinfo0(): self { }

    /** @see \phpversion() */
    public function phpversion(?string $extension = null): self { }
    public function phpversion0(): self { }

    /** @see \popen() */
    public function popen(string $command, string $mode): self { }
    public function popen0(string $mode): self { }
    public function popen1(string $command): self { }

    /** @see \pos() */
    public self $pos;
    public function pos(object|array $array): self { }
    public function pos0(): self { }

    /** @see \pow() */
    public function pow(mixed $num, mixed $exponent): self { }
    public function pow0(mixed $exponent): self { }
    public function pow1(mixed $num): self { }

    /** @see \print_r() */
    public self $print_r;
    public function print_r(mixed $value, bool $return = false): self { }
    public function print_r0(bool $return = false): self { }
    public function print_r1(mixed $value): self { }

    /** @see \printf() */
    public self $printf;
    public function printf(string $format, mixed ...$values): self { }
    public function printf0(mixed ...$values): self { }
    public function printf1(string $format): self { }

    /** @see \putenv() */
    public self $putenv;
    public function putenv(string $assignment): self { }
    public function putenv0(): self { }

    /** @see \quoted_printable_decode() */
    public self $quoted_printable_decode;
    public function quoted_printable_decode(string $string): self { }
    public function quoted_printable_decode0(): self { }

    /** @see \quoted_printable_encode() */
    public self $quoted_printable_encode;
    public function quoted_printable_encode(string $string): self { }
    public function quoted_printable_encode0(): self { }

    /** @see \quotemeta() */
    public self $quotemeta;
    public function quotemeta(string $string): self { }
    public function quotemeta0(): self { }

    /** @see \rad2deg() */
    public self $rad2deg;
    public function rad2deg(float $num): self { }
    public function rad2deg0(): self { }

    /** @see \rand() */
    public function rand(int $min, int $max): self { }
    public function rand0(int $max): self { }
    public function rand1(int $min): self { }

    /** @see \random_bytes() */
    public self $random_bytes;
    public function random_bytes(int $length): self { }
    public function random_bytes0(): self { }

    /** @see \random_int() */
    public function random_int(int $min, int $max): self { }
    public function random_int0(int $max): self { }
    public function random_int1(int $min): self { }

    /** @see \range() */
    public function range($start, $end, int|float $step = 1): self { }
    public function range0($end, int|float $step = 1): self { }
    public function range1($start, int|float $step = 1): self { }
    public function range2($start, $end): self { }

    /** @see \rawurldecode() */
    public self $rawurldecode;
    public function rawurldecode(string $string): self { }
    public function rawurldecode0(): self { }

    /** @see \rawurlencode() */
    public self $rawurlencode;
    public function rawurlencode(string $string): self { }
    public function rawurlencode0(): self { }

    /** @see \readdir() */
    public function readdir($dir_handle = null): self { }
    public function readdir0(): self { }

    /** @see \readfile() */
    public self $readfile;
    public function readfile(string $filename, bool $use_include_path = false, $context = null): self { }
    public function readfile0(bool $use_include_path = false, $context = null): self { }
    public function readfile1(string $filename, $context = null): self { }
    public function readfile2(string $filename, bool $use_include_path = false): self { }

    /** @see \readlink() */
    public self $readlink;
    public function readlink(string $path): self { }
    public function readlink0(): self { }

    /** @see \realpath() */
    public self $realpath;
    public function realpath(string $path): self { }
    public function realpath0(): self { }

    /** @see \register_shutdown_function() */
    public self $register_shutdown_function;
    public function register_shutdown_function(callable $callback, mixed ...$args): self { }
    public function register_shutdown_function0(mixed ...$args): self { }
    public function register_shutdown_function1(callable $callback): self { }
    public function register_shutdown_functionP(callable $callback, mixed ...$args): self { }
    public function register_shutdown_function0P(mixed ...$args): self { }
    public function register_shutdown_function1P(callable $callback): self { }
    public function register_shutdown_functionE(callable $callback, mixed ...$args): self { }
    public function register_shutdown_function0E(mixed ...$args): self { }
    public function register_shutdown_function1E(callable $callback): self { }

    /** @see \register_tick_function() */
    public self $register_tick_function;
    public function register_tick_function(callable $callback, mixed ...$args): self { }
    public function register_tick_function0(mixed ...$args): self { }
    public function register_tick_function1(callable $callback): self { }
    public function register_tick_functionP(callable $callback, mixed ...$args): self { }
    public function register_tick_function0P(mixed ...$args): self { }
    public function register_tick_function1P(callable $callback): self { }
    public function register_tick_functionE(callable $callback, mixed ...$args): self { }
    public function register_tick_function0E(mixed ...$args): self { }
    public function register_tick_function1E(callable $callback): self { }

    /** @see \rename() */
    public function rename(string $from, string $to, $context = null): self { }
    public function rename0(string $to, $context = null): self { }
    public function rename1(string $from, $context = null): self { }
    public function rename2(string $from, string $to): self { }

    /** @see \rewind() */
    public self $rewind;
    public function rewind($stream): self { }
    public function rewind0(): self { }

    /** @see \rewinddir() */
    public function rewinddir($dir_handle = null): self { }
    public function rewinddir0(): self { }

    /** @see \rmdir() */
    public self $rmdir;
    public function rmdir(string $directory, $context = null): self { }
    public function rmdir0($context = null): self { }
    public function rmdir1(string $directory): self { }

    /** @see \round() */
    public self $round;
    public function round(int|float $num, int $precision = 0, int $mode = PHP_ROUND_HALF_UP): self { }
    public function round0(int $precision = 0, int $mode = PHP_ROUND_HALF_UP): self { }
    public function round1(int|float $num, int $mode = PHP_ROUND_HALF_UP): self { }
    public function round2(int|float $num, int $precision = 0): self { }

    /** @see \rsort() */
    public self $rsort;
    public function rsort(array &$array, int $flags = SORT_REGULAR): self { }
    public function rsort0(int $flags = SORT_REGULAR): self { }
    public function rsort1(array &$array): self { }

    /** @see \rtrim() */
    public self $rtrim;
    public function rtrim(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function rtrim0(string $characters = " \n\r\t\v\000"): self { }
    public function rtrim1(string $string): self { }

    /** @see \scandir() */
    public self $scandir;
    public function scandir(string $directory, int $sorting_order = SCANDIR_SORT_ASCENDING, $context = null): self { }
    public function scandir0(int $sorting_order = SCANDIR_SORT_ASCENDING, $context = null): self { }
    public function scandir1(string $directory, $context = null): self { }
    public function scandir2(string $directory, int $sorting_order = SCANDIR_SORT_ASCENDING): self { }

    /** @see \serialize() */
    public self $serialize;
    public function serialize(mixed $value): self { }
    public function serialize0(): self { }

    /** @see \set_file_buffer() */
    public function set_file_buffer($stream, int $size): self { }
    public function set_file_buffer0(int $size): self { }
    public function set_file_buffer1($stream): self { }

    /** @see \set_include_path() */
    public self $set_include_path;
    public function set_include_path(string $include_path): self { }
    public function set_include_path0(): self { }

    /** @see \set_time_limit() */
    public self $set_time_limit;
    public function set_time_limit(int $seconds): self { }
    public function set_time_limit0(): self { }

    /** @see \setcookie() */
    public self $setcookie;
    public function setcookie(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setcookie0(string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setcookie1(string $name, array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setcookie2(string $name, string $value = "", string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setcookie3(string $name, string $value = "", array|int $expires_or_options = 0, string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setcookie4(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", bool $secure = false, bool $httponly = false): self { }
    public function setcookie5(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $httponly = false): self { }
    public function setcookie6(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false): self { }

    /** @see \setlocale() */
    public function setlocale(int $category, $locales, ...$rest): self { }
    public function setlocale0($locales, ...$rest): self { }
    public function setlocale1(int $category, ...$rest): self { }
    public function setlocale2(int $category, $locales): self { }

    /** @see \setrawcookie() */
    public self $setrawcookie;
    public function setrawcookie(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setrawcookie0(string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setrawcookie1(string $name, array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setrawcookie2(string $name, string $value = "", string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setrawcookie3(string $name, string $value = "", array|int $expires_or_options = 0, string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setrawcookie4(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", bool $secure = false, bool $httponly = false): self { }
    public function setrawcookie5(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $httponly = false): self { }
    public function setrawcookie6(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false): self { }

    /** @see \settype() */
    public function settype(mixed &$var, string $type): self { }
    public function settype0(string $type): self { }
    public function settype1(mixed &$var): self { }

    /** @see \sha1() */
    public self $sha1;
    public function sha1(string $string, bool $binary = false): self { }
    public function sha10(bool $binary = false): self { }
    public function sha11(string $string): self { }

    /** @see \sha1_file() */
    public self $sha1_file;
    public function sha1_file(string $filename, bool $binary = false): self { }
    public function sha1_file0(bool $binary = false): self { }
    public function sha1_file1(string $filename): self { }

}
