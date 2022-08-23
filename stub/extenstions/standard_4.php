<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait standard_4
{
    /** @see \ini_get_all() */
    public function ini_get_all(?string $extension = null, bool $details = true): self { }
    public function ini_get_all0(bool $details = true): self { }
    public function ini_get_all1(?string $extension = null): self { }

    /** @see \ini_restore() */
    public self $ini_restore;
    public function ini_restore(string $option): self { }
    public function ini_restore0(): self { }

    /** @see \ini_set() */
    public function ini_set(string $option, string $value): self { }
    public function ini_set0(string $value): self { }
    public function ini_set1(string $option): self { }

    /** @see \intdiv() */
    public function intdiv(int $num1, int $num2): self { }
    public function intdiv0(int $num2): self { }
    public function intdiv1(int $num1): self { }

    /** @see \intval() */
    public self $intval;
    public function intval(mixed $value, int $base = 10): self { }
    public function intval0(int $base = 10): self { }
    public function intval1(mixed $value): self { }

    /** @see \ip2long() */
    public self $ip2long;
    public function ip2long(string $ip): self { }
    public function ip2long0(): self { }

    /** @see \iptcembed() */
    public function iptcembed(string $iptc_data, string $filename, int $spool = 0): self { }
    public function iptcembed0(string $filename, int $spool = 0): self { }
    public function iptcembed1(string $iptc_data, int $spool = 0): self { }
    public function iptcembed2(string $iptc_data, string $filename): self { }

    /** @see \iptcparse() */
    public self $iptcparse;
    public function iptcparse(string $iptc_block): self { }
    public function iptcparse0(): self { }

    /** @see \is_array() */
    public self $is_array;
    public function is_array(mixed $value): self { }
    public function is_array0(): self { }

    /** @see \is_bool() */
    public self $is_bool;
    public function is_bool(mixed $value): self { }
    public function is_bool0(): self { }

    /** @see \is_callable() */
    public self $is_callable;
    public function is_callable(mixed $value, bool $syntax_only = false, &$callable_name = null): self { }
    public function is_callable0(bool $syntax_only = false, &$callable_name = null): self { }
    public function is_callable1(mixed $value, &$callable_name = null): self { }
    public function is_callable2(mixed $value, bool $syntax_only = false): self { }
    public function is_callableP(mixed $value, bool $syntax_only = false, &$callable_name = null): self { }
    public function is_callable0P(bool $syntax_only = false, &$callable_name = null): self { }
    public function is_callable1P(mixed $value, &$callable_name = null): self { }
    public function is_callable2P(mixed $value, bool $syntax_only = false): self { }
    public function is_callableE(mixed $value, bool $syntax_only = false, &$callable_name = null): self { }
    public function is_callable0E(bool $syntax_only = false, &$callable_name = null): self { }
    public function is_callable1E(mixed $value, &$callable_name = null): self { }
    public function is_callable2E(mixed $value, bool $syntax_only = false): self { }

    /** @see \is_countable() */
    public self $is_countable;
    public function is_countable(mixed $value): self { }
    public function is_countable0(): self { }

    /** @see \is_dir() */
    public self $is_dir;
    public function is_dir(string $filename): self { }
    public function is_dir0(): self { }

    /** @see \is_double() */
    public self $is_double;
    public function is_double(mixed $value): self { }
    public function is_double0(): self { }

    /** @see \is_executable() */
    public self $is_executable;
    public function is_executable(string $filename): self { }
    public function is_executable0(): self { }

    /** @see \is_file() */
    public self $is_file;
    public function is_file(string $filename): self { }
    public function is_file0(): self { }

    /** @see \is_finite() */
    public self $is_finite;
    public function is_finite(float $num): self { }
    public function is_finite0(): self { }

    /** @see \is_float() */
    public self $is_float;
    public function is_float(mixed $value): self { }
    public function is_float0(): self { }

    /** @see \is_infinite() */
    public self $is_infinite;
    public function is_infinite(float $num): self { }
    public function is_infinite0(): self { }

    /** @see \is_int() */
    public self $is_int;
    public function is_int(mixed $value): self { }
    public function is_int0(): self { }

    /** @see \is_integer() */
    public self $is_integer;
    public function is_integer(mixed $value): self { }
    public function is_integer0(): self { }

    /** @see \is_iterable() */
    public self $is_iterable;
    public function is_iterable(mixed $value): self { }
    public function is_iterable0(): self { }

    /** @see \is_link() */
    public self $is_link;
    public function is_link(string $filename): self { }
    public function is_link0(): self { }

    /** @see \is_long() */
    public self $is_long;
    public function is_long(mixed $value): self { }
    public function is_long0(): self { }

    /** @see \is_nan() */
    public self $is_nan;
    public function is_nan(float $num): self { }
    public function is_nan0(): self { }

    /** @see \is_null() */
    public self $is_null;
    public function is_null(mixed $value): self { }
    public function is_null0(): self { }

    /** @see \is_numeric() */
    public self $is_numeric;
    public function is_numeric(mixed $value): self { }
    public function is_numeric0(): self { }

    /** @see \is_object() */
    public self $is_object;
    public function is_object(mixed $value): self { }
    public function is_object0(): self { }

    /** @see \is_readable() */
    public self $is_readable;
    public function is_readable(string $filename): self { }
    public function is_readable0(): self { }

    /** @see \is_resource() */
    public self $is_resource;
    public function is_resource(mixed $value): self { }
    public function is_resource0(): self { }

    /** @see \is_scalar() */
    public self $is_scalar;
    public function is_scalar(mixed $value): self { }
    public function is_scalar0(): self { }

    /** @see \is_string() */
    public self $is_string;
    public function is_string(mixed $value): self { }
    public function is_string0(): self { }

    /** @see \is_uploaded_file() */
    public self $is_uploaded_file;
    public function is_uploaded_file(string $filename): self { }
    public function is_uploaded_file0(): self { }

    /** @see \is_writable() */
    public self $is_writable;
    public function is_writable(string $filename): self { }
    public function is_writable0(): self { }

    /** @see \is_writeable() */
    public self $is_writeable;
    public function is_writeable(string $filename): self { }
    public function is_writeable0(): self { }

    /** @see \join() */
    public self $join;
    public function join(array|string $separator, ?array $array = null): self { }
    public function join0(?array $array = null): self { }
    public function join1(array|string $separator): self { }

    /** @see \key() */
    public self $key;
    public function key(object|array $array): self { }
    public function key0(): self { }

    /** @see \key_exists() */
    public function key_exists($key, array $array): self { }
    public function key_exists0(array $array): self { }
    public function key_exists1($key): self { }

    /** @see \krsort() */
    public self $krsort;
    public function krsort(array &$array, int $flags = SORT_REGULAR): self { }
    public function krsort0(int $flags = SORT_REGULAR): self { }
    public function krsort1(array &$array): self { }

    /** @see \ksort() */
    public self $ksort;
    public function ksort(array &$array, int $flags = SORT_REGULAR): self { }
    public function ksort0(int $flags = SORT_REGULAR): self { }
    public function ksort1(array &$array): self { }

    /** @see \lcfirst() */
    public self $lcfirst;
    public function lcfirst(string $string): self { }
    public function lcfirst0(): self { }

    /** @see \levenshtein() */
    public function levenshtein(string $string1, string $string2, int $insertion_cost = 1, int $replacement_cost = 1, int $deletion_cost = 1): self { }
    public function levenshtein0(string $string2, int $insertion_cost = 1, int $replacement_cost = 1, int $deletion_cost = 1): self { }
    public function levenshtein1(string $string1, int $insertion_cost = 1, int $replacement_cost = 1, int $deletion_cost = 1): self { }
    public function levenshtein2(string $string1, string $string2, int $replacement_cost = 1, int $deletion_cost = 1): self { }
    public function levenshtein3(string $string1, string $string2, int $insertion_cost = 1, int $deletion_cost = 1): self { }
    public function levenshtein4(string $string1, string $string2, int $insertion_cost = 1, int $replacement_cost = 1): self { }

    /** @see \link() */
    public function link(string $target, string $link): self { }
    public function link0(string $link): self { }
    public function link1(string $target): self { }

    /** @see \linkinfo() */
    public self $linkinfo;
    public function linkinfo(string $path): self { }
    public function linkinfo0(): self { }

    /** @see \log() */
    public self $log;
    public function log(float $num, float $base = M_E): self { }
    public function log0(float $base = M_E): self { }
    public function log1(float $num): self { }

    /** @see \log10() */
    public self $log10;
    public function log10(float $num): self { }
    public function log100(): self { }

    /** @see \log1p() */
    public self $log1p;
    public function log1p(float $num): self { }
    public function log1p0(): self { }

    /** @see \long2ip() */
    public self $long2ip;
    public function long2ip(int $ip): self { }
    public function long2ip0(): self { }

    /** @see \lstat() */
    public self $lstat;
    public function lstat(string $filename): self { }
    public function lstat0(): self { }

    /** @see \ltrim() */
    public self $ltrim;
    public function ltrim(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function ltrim0(string $characters = " \n\r\t\v\000"): self { }
    public function ltrim1(string $string): self { }

    /** @see \mail() */
    public function mail(string $to, string $subject, string $message, array|string $additional_headers = [], string $additional_params = ""): self { }
    public function mail0(string $subject, string $message, array|string $additional_headers = [], string $additional_params = ""): self { }
    public function mail1(string $to, string $message, array|string $additional_headers = [], string $additional_params = ""): self { }
    public function mail2(string $to, string $subject, array|string $additional_headers = [], string $additional_params = ""): self { }
    public function mail3(string $to, string $subject, string $message, string $additional_params = ""): self { }
    public function mail4(string $to, string $subject, string $message, array|string $additional_headers = []): self { }

    /** @see \max() */
    public self $max;
    public function max(mixed $value, mixed ...$values): self { }
    public function max0(mixed ...$values): self { }
    public function max1(mixed $value): self { }

    /** @see \md5() */
    public self $md5;
    public function md5(string $string, bool $binary = false): self { }
    public function md50(bool $binary = false): self { }
    public function md51(string $string): self { }

    /** @see \md5_file() */
    public self $md5_file;
    public function md5_file(string $filename, bool $binary = false): self { }
    public function md5_file0(bool $binary = false): self { }
    public function md5_file1(string $filename): self { }

    /** @see \memory_get_peak_usage() */
    public function memory_get_peak_usage(bool $real_usage = false): self { }
    public function memory_get_peak_usage0(): self { }

    /** @see \memory_get_usage() */
    public function memory_get_usage(bool $real_usage = false): self { }
    public function memory_get_usage0(): self { }

    /** @see \metaphone() */
    public self $metaphone;
    public function metaphone(string $string, int $max_phonemes = 0): self { }
    public function metaphone0(int $max_phonemes = 0): self { }
    public function metaphone1(string $string): self { }

    /** @see \microtime() */
    public function microtime(bool $as_float = false): self { }
    public function microtime0(): self { }

    /** @see \min() */
    public self $min;
    public function min(mixed $value, mixed ...$values): self { }
    public function min0(mixed ...$values): self { }
    public function min1(mixed $value): self { }

    /** @see \mkdir() */
    public self $mkdir;
    public function mkdir(string $directory, int $permissions = 511, bool $recursive = false, $context = null): self { }
    public function mkdir0(int $permissions = 511, bool $recursive = false, $context = null): self { }
    public function mkdir1(string $directory, bool $recursive = false, $context = null): self { }
    public function mkdir2(string $directory, int $permissions = 511, $context = null): self { }
    public function mkdir3(string $directory, int $permissions = 511, bool $recursive = false): self { }

    /** @see \move_uploaded_file() */
    public function move_uploaded_file(string $from, string $to): self { }
    public function move_uploaded_file0(string $to): self { }
    public function move_uploaded_file1(string $from): self { }

    /** @see \mt_rand() */
    public function mt_rand(int $min, int $max): self { }
    public function mt_rand0(int $max): self { }
    public function mt_rand1(int $min): self { }

    /** @see \mt_srand() */
    public function mt_srand(int $seed = 0, int $mode = MT_RAND_MT19937): self { }
    public function mt_srand0(int $mode = MT_RAND_MT19937): self { }
    public function mt_srand1(int $seed = 0): self { }

    /** @see \nl2br() */
    public self $nl2br;
    public function nl2br(string $string, bool $use_xhtml = true): self { }
    public function nl2br0(bool $use_xhtml = true): self { }
    public function nl2br1(string $string): self { }

}
