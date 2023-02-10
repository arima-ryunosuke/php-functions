<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectI
{
    /** @see \idate() */
    public self $idate;
    public function idate(string $format, ?int $timestamp = null): self { }
    public function idate(?int $timestamp = null): self { }

    /** @see \in_array() */
    public self $in_array;
    public function in_array(mixed $needle, array $haystack, bool $strict = false): self { }
    public function in_array(array $haystack, bool $strict = false): self { }

    /** @see \ip2long() */
    public self $ip2long;
    public function ip2long(string $ip): self { }
    public function ip2long(): self { }

    /** @see \ini_get() */
    public self $ini_get;
    public function ini_get(string $option): self { }
    public function ini_get(): self { }

    /** @see \ini_get_all() */
    public self $ini_get_all;
    public function ini_get_all(?string $extension = null, bool $details = true): self { }
    public function ini_get_all(bool $details = true): self { }

    /** @see \ini_set() */
    public self $ini_set;
    public function ini_set(string $option, string $value): self { }
    public function ini_set(string $value): self { }

    /** @see \ini_alter() */
    public self $ini_alter;
    public function ini_alter(string $option, string $value): self { }
    public function ini_alter(string $value): self { }

    /** @see \ini_restore() */
    public self $ini_restore;
    public function ini_restore(string $option): self { }
    public function ini_restore(): self { }

    /** @see \ignore_user_abort() */
    public self $ignore_user_abort;
    public function ignore_user_abort(?bool $enable = null): self { }
    public function ignore_user_abort(): self { }

    /** @see \is_uploaded_file() */
    public self $is_uploaded_file;
    public function is_uploaded_file(string $filename): self { }
    public function is_uploaded_file(): self { }

    /** @see \inet_ntop() */
    public self $inet_ntop;
    public function inet_ntop(string $ip): self { }
    public function inet_ntop(): self { }

    /** @see \inet_pton() */
    public self $inet_pton;
    public function inet_pton(string $ip): self { }
    public function inet_pton(): self { }

    /** @see \implode() */
    public self $implode;
    public function implode(array|string $separator, ?array $array = null): self { }
    public function implode(?array $array = null): self { }

    /** @see \is_writable() */
    public self $is_writable;
    public function is_writable(string $filename): self { }
    public function is_writable(): self { }

    /** @see \is_writeable() */
    public self $is_writeable;
    public function is_writeable(string $filename): self { }
    public function is_writeable(): self { }

    /** @see \is_readable() */
    public self $is_readable;
    public function is_readable(string $filename): self { }
    public function is_readable(): self { }

    /** @see \is_executable() */
    public self $is_executable;
    public function is_executable(string $filename): self { }
    public function is_executable(): self { }

    /** @see \is_file() */
    public self $is_file;
    public function is_file(string $filename): self { }
    public function is_file(): self { }

    /** @see \is_dir() */
    public self $is_dir;
    public function is_dir(string $filename): self { }
    public function is_dir(): self { }

    /** @see \is_link() */
    public self $is_link;
    public function is_link(string $filename): self { }
    public function is_link(): self { }

    /** @see \image_type_to_mime_type() */
    public self $image_type_to_mime_type;
    public function image_type_to_mime_type(int $image_type): self { }
    public function image_type_to_mime_type(): self { }

    /** @see \image_type_to_extension() */
    public self $image_type_to_extension;
    public function image_type_to_extension(int $image_type, bool $include_dot = true): self { }
    public function image_type_to_extension(bool $include_dot = true): self { }

    /** @see \iptcembed() */
    public self $iptcembed;
    public function iptcembed(string $iptc_data, string $filename, int $spool = 0): self { }
    public function iptcembed(string $filename, int $spool = 0): self { }

    /** @see \iptcparse() */
    public self $iptcparse;
    public function iptcparse(string $iptc_block): self { }
    public function iptcparse(): self { }

    /** @see \is_finite() */
    public self $is_finite;
    public function is_finite(float $num): self { }
    public function is_finite(): self { }

    /** @see \is_nan() */
    public self $is_nan;
    public function is_nan(float $num): self { }
    public function is_nan(): self { }

    /** @see \intdiv() */
    public self $intdiv;
    public function intdiv(int $num1, int $num2): self { }
    public function intdiv(int $num2): self { }

    /** @see \is_infinite() */
    public self $is_infinite;
    public function is_infinite(float $num): self { }
    public function is_infinite(): self { }

    /** @see \intval() */
    public self $intval;
    public function intval(mixed $value, int $base = 10): self { }
    public function intval(int $base = 10): self { }

    /** @see \is_null() */
    public self $is_null;
    public function is_null(mixed $value): self { }
    public function is_null(): self { }

    /** @see \is_resource() */
    public self $is_resource;
    public function is_resource(mixed $value): self { }
    public function is_resource(): self { }

    /** @see \is_bool() */
    public self $is_bool;
    public function is_bool(mixed $value): self { }
    public function is_bool(): self { }

    /** @see \is_int() */
    public self $is_int;
    public function is_int(mixed $value): self { }
    public function is_int(): self { }

    /** @see \is_integer() */
    public self $is_integer;
    public function is_integer(mixed $value): self { }
    public function is_integer(): self { }

    /** @see \is_long() */
    public self $is_long;
    public function is_long(mixed $value): self { }
    public function is_long(): self { }

    /** @see \is_float() */
    public self $is_float;
    public function is_float(mixed $value): self { }
    public function is_float(): self { }

    /** @see \is_double() */
    public self $is_double;
    public function is_double(mixed $value): self { }
    public function is_double(): self { }

    /** @see \is_numeric() */
    public self $is_numeric;
    public function is_numeric(mixed $value): self { }
    public function is_numeric(): self { }

    /** @see \is_string() */
    public self $is_string;
    public function is_string(mixed $value): self { }
    public function is_string(): self { }

    /** @see \is_array() */
    public self $is_array;
    public function is_array(mixed $value): self { }
    public function is_array(): self { }

    /** @see \is_object() */
    public self $is_object;
    public function is_object(mixed $value): self { }
    public function is_object(): self { }

    /** @see \is_scalar() */
    public self $is_scalar;
    public function is_scalar(mixed $value): self { }
    public function is_scalar(): self { }

    /** @see \is_callable() */
    public self $is_callable;
    public function is_callable(mixed $value, bool $syntax_only = false, callable &$callable_name = null): self { }
    public function is_callable(bool $syntax_only = false, callable &$callable_name = null): self { }

    /** @see \is_iterable() */
    public self $is_iterable;
    public function is_iterable(mixed $value): self { }
    public function is_iterable(): self { }

    /** @see \is_countable() */
    public self $is_countable;
    public function is_countable(mixed $value): self { }
    public function is_countable(): self { }

    /** @see \is_indexarray() */
    public self $is_indexarray;
    public function is_indexarray(iterable $array): self { }
    public function is_indexarray(): self { }

    /** @see \is_hasharray() */
    public self $is_hasharray;
    public function is_hasharray(array $array): self { }
    public function is_hasharray(): self { }

    /** @see \in_array_and() */
    public self $in_array_and;
    public function in_array_and($needle, $haystack, $strict = false): self { }
    public function in_array_and($haystack, $strict = false): self { }

    /** @see \in_array_or() */
    public self $in_array_or;
    public function in_array_or($needle, $haystack, $strict = false): self { }
    public function in_array_or($haystack, $strict = false): self { }

    /** @see \iterator_chunk() */
    public self $iterator_chunk;
    public function iterator_chunk($iterator, $length, $preserve_keys = false): self { }
    public function iterator_chunk($length, $preserve_keys = false): self { }

    /** @see \is_callback() */
    public self $is_callback;
    public function is_callback(callable $callable): self { }
    public function is_callback(): self { }

    /** @see \is_bindable_closure() */
    public self $is_bindable_closure;
    public function is_bindable_closure(\Closure $closure): self { }
    public function is_bindable_closure(): self { }

    /** @see \ip2cidr() */
    public self $ip2cidr;
    public function ip2cidr($fromipaddr, $toipaddr): self { }
    public function ip2cidr($toipaddr): self { }

    /** @see \incidr() */
    public self $incidr;
    public function incidr($ipaddr, $cidr): self { }
    public function incidr($cidr): self { }

    /** @see \ini_export() */
    public self $ini_export;
    public function ini_export(iterable $iniarray, $options = []): self { }
    public function ini_export($options = []): self { }

    /** @see \ini_import() */
    public self $ini_import;
    public function ini_import($inistring, $options = []): self { }
    public function ini_import($options = []): self { }

    /** @see \include_string() */
    public self $include_string;
    public function include_string($template, iterable $array = []): self { }
    public function include_string(iterable $array = []): self { }

    /** @see \indent_php() */
    public self $indent_php;
    public function indent_php($phpcode, $options = []): self { }
    public function indent_php($options = []): self { }

    /** @see \ini_sets() */
    public self $ini_sets;
    public function ini_sets($values): self { }
    public function ini_sets(): self { }

    /** @see \is_ansi() */
    public self $is_ansi;
    public function is_ansi($stream): self { }
    public function is_ansi(): self { }

    /** @see \is_empty() */
    public self $is_empty;
    public function is_empty($var, $empty_stdClass = false): self { }
    public function is_empty($empty_stdClass = false): self { }

    /** @see \is_primitive() */
    public self $is_primitive;
    public function is_primitive($var): self { }
    public function is_primitive(): self { }

    /** @see \is_recursive() */
    public self $is_recursive;
    public function is_recursive($var): self { }
    public function is_recursive(): self { }

    /** @see \is_decimal() */
    public self $is_decimal;
    public function is_decimal($var, $allow_float = true): self { }
    public function is_decimal($allow_float = true): self { }

    /** @see \is_stringable() */
    public self $is_stringable;
    public function is_stringable($var): self { }
    public function is_stringable(): self { }

    /** @see \is_arrayable() */
    public self $is_arrayable;
    public function is_arrayable($var): self { }
    public function is_arrayable(): self { }

}
