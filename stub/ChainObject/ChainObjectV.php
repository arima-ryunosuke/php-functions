<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectV
{
    /** @see \vprintf() */
    public self $vprintf;
    public function vprintf(string $format, array $values): self { }
    public function vprintf(array $values): self { }

    /** @see \vsprintf() */
    public self $vsprintf;
    public function vsprintf(string $format, array $values): self { }
    public function vsprintf(array $values): self { }

    /** @see \vfprintf() */
    public self $vfprintf;
    public function vfprintf($stream, string $format, array $values): self { }
    public function vfprintf(string $format, array $values): self { }

    /** @see \var_dump() */
    public self $var_dump;
    public function var_dump(mixed ...$values): self { }
    public function var_dump(): self { }

    /** @see \var_export() */
    public self $var_export;
    public function var_export(mixed $value, bool $return = false): self { }
    public function var_export(bool $return = false): self { }

    /** @see \version_compare() */
    public self $version_compare;
    public function version_compare(string $version1, string $version2, ?string $operator = null): self { }
    public function version_compare(string $version2, ?string $operator = null): self { }

    /** @see \var_hash() */
    public self $var_hash;
    public function var_hash($var, $algos = ["md5", "sha1"], $base64 = true): self { }
    public function var_hash($algos = ["md5", "sha1"], $base64 = true): self { }

    /** @see \varcmp() */
    public self $varcmp;
    public function varcmp($a, $b, $mode = null, $precision = null): self { }
    public function varcmp($b, $mode = null, $precision = null): self { }

    /** @see \var_type() */
    public self $var_type;
    public function var_type($var, $valid_name = false): self { }
    public function var_type($valid_name = false): self { }

    /** @see \var_apply() */
    public self $var_apply;
    public function var_apply($var, callable $callback, ...$args): self { }
    public function var_apply(callable $callback, ...$args): self { }

    /** @see \var_applys() */
    public self $var_applys;
    public function var_applys($var, callable $callback, ...$args): self { }
    public function var_applys(callable $callback, ...$args): self { }

    /** @see \var_stream() */
    public self $var_stream;
    public function var_stream(&$var, $initial = ""): self { }
    public function var_stream($initial = ""): self { }

    /** @see \var_export2() */
    public self $var_export2;
    public function var_export2($value, $return = false): self { }
    public function var_export2($return = false): self { }

    /** @see \var_export3() */
    public self $var_export3;
    public function var_export3($value, $return = false): self { }
    public function var_export3($return = false): self { }

    /** @see \var_html() */
    public self $var_html;
    public function var_html($value): self { }
    public function var_html(): self { }

    /** @see \var_pretty() */
    public self $var_pretty;
    public function var_pretty($value, $options = []): self { }
    public function var_pretty($options = []): self { }

}
