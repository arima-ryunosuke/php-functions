<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectB
{
    /** @see \base64_encode() */
    public self $base64_encode;
    public function base64_encode(string $string): self { }
    public function base64_encode(): self { }

    /** @see \base64_decode() */
    public self $base64_decode;
    public function base64_decode(string $string, bool $strict = false): self { }
    public function base64_decode(bool $strict = false): self { }

    /** @see \bin2hex() */
    public self $bin2hex;
    public function bin2hex(string $string): self { }
    public function bin2hex(): self { }

    /** @see \basename() */
    public self $basename;
    public function basename(string $path, string $suffix = ""): self { }
    public function basename(string $suffix = ""): self { }

    /** @see \bindec() */
    public self $bindec;
    public function bindec(string $binary_string): self { }
    public function bindec(): self { }

    /** @see \base_convert() */
    public self $base_convert;
    public function base_convert(string $num, int $from_base, int $to_base): self { }
    public function base_convert(int $from_base, int $to_base): self { }

    /** @see \boolval() */
    public self $boolval;
    public function boolval(mixed $value): self { }
    public function boolval(): self { }

    /** @see \by_builtin() */
    public self $by_builtin;
    public function by_builtin($class, $function): self { }
    public function by_builtin($function): self { }

    /** @see \build_uri() */
    public self $build_uri;
    public function build_uri($parts): self { }
    public function build_uri(): self { }

    /** @see \build_query() */
    public self $build_query;
    public function build_query($data, $numeric_prefix = null, $arg_separator = null, $encoding_type = PHP_QUERY_RFC1738): self { }
    public function build_query($numeric_prefix = null, $arg_separator = null, $encoding_type = PHP_QUERY_RFC1738): self { }

    /** @see \blank_if() */
    public self $blank_if;
    public function blank_if($var, $default = null): self { }
    public function blank_if($default = null): self { }

    /** @see \backtrace() */
    public self $backtrace;
    public function backtrace($flags = DEBUG_BACKTRACE_PROVIDE_OBJECT, $options = []): self { }
    public function backtrace($options = []): self { }

    /** @see \benchmark() */
    public self $benchmark;
    public function benchmark($suite, $args = [], $millisec = 1000, $output = true): self { }
    public function benchmark($args = [], $millisec = 1000, $output = true): self { }

}
