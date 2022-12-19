<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectR
{
    /** @see \rsort() */
    public self $rsort;
    public function rsort(array &$array, int $flags = SORT_REGULAR): self { }
    public function rsort(int $flags = SORT_REGULAR): self { }

    /** @see \range() */
    public self $range;
    public function range($start, $end, int|float $step = 1): self { }
    public function range($end, int|float $step = 1): self { }

    /** @see \register_shutdown_function() */
    public self $register_shutdown_function;
    public function register_shutdown_function(callable $callback, mixed ...$args): self { }
    public function register_shutdown_function(mixed ...$args): self { }

    /** @see \register_tick_function() */
    public self $register_tick_function;
    public function register_tick_function(callable $callback, mixed ...$args): self { }
    public function register_tick_function(mixed ...$args): self { }

    /** @see \rtrim() */
    public self $rtrim;
    public function rtrim(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function rtrim(string $characters = " \n\r\t\v\000"): self { }

    /** @see \rewinddir() */
    public self $rewinddir;
    public function rewinddir($dir_handle = null): self { }
    public function rewinddir(): self { }

    /** @see \readdir() */
    public self $readdir;
    public function readdir($dir_handle = null): self { }
    public function readdir(): self { }

    /** @see \readfile() */
    public self $readfile;
    public function readfile(string $filename, bool $use_include_path = false, $context = null): self { }
    public function readfile(bool $use_include_path = false, $context = null): self { }

    /** @see \rewind() */
    public self $rewind;
    public function rewind($stream): self { }
    public function rewind(): self { }

    /** @see \rmdir() */
    public self $rmdir;
    public function rmdir(string $directory, $context = null): self { }
    public function rmdir($context = null): self { }

    /** @see \rename() */
    public self $rename;
    public function rename(string $from, string $to, $context = null): self { }
    public function rename(string $to, $context = null): self { }

    /** @see \realpath() */
    public self $realpath;
    public function realpath(string $path): self { }
    public function realpath(): self { }

    /** @see \readlink() */
    public self $readlink;
    public function readlink(string $path): self { }
    public function readlink(): self { }

    /** @see \round() */
    public self $round;
    public function round(int|float $num, int $precision = 0, int $mode = PHP_ROUND_HALF_UP): self { }
    public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP): self { }

    /** @see \rad2deg() */
    public self $rad2deg;
    public function rad2deg(float $num): self { }
    public function rad2deg(): self { }

    /** @see \rand() */
    public self $rand;
    public function rand(int $min, int $max): self { }
    public function rand(int $max): self { }

    /** @see \random_bytes() */
    public self $random_bytes;
    public function random_bytes(int $length): self { }
    public function random_bytes(): self { }

    /** @see \random_int() */
    public self $random_int;
    public function random_int(int $min, int $max): self { }
    public function random_int(int $max): self { }

    /** @see \rawurlencode() */
    public self $rawurlencode;
    public function rawurlencode(string $string): self { }
    public function rawurlencode(): self { }

    /** @see \rawurldecode() */
    public self $rawurldecode;
    public function rawurldecode(string $string): self { }
    public function rawurldecode(): self { }

    /** @see \reflect_types() */
    public self $reflect_types;
    public function reflect_types($reflection_type = null): self { }
    public function reflect_types(): self { }

    /** @see \rm_rf() */
    public self $rm_rf;
    public function rm_rf($dirname, $self = true): self { }
    public function rm_rf($self = true): self { }

    /** @see \rbind() */
    public self $rbind;
    public function rbind(callable $callable, ...$variadic): self { }
    public function rbind(...$variadic): self { }

    /** @see \reflect_callable() */
    public self $reflect_callable;
    public function reflect_callable(callable $callable): self { }
    public function reflect_callable(): self { }

    /** @see \random_at() */
    public self $random_at;
    public function random_at(...$args): self { }
    public function random_at(): self { }

    /** @see \random_string() */
    public self $random_string;
    public function random_string($length = 8, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }
    public function random_string($charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }

    /** @see \render_template() */
    public self $render_template;
    public function render_template($template, $vars): self { }
    public function render_template($vars): self { }

    /** @see \render_string() */
    public self $render_string;
    public function render_string($template, iterable $array): self { }
    public function render_string(iterable $array): self { }

    /** @see \render_file() */
    public self $render_file;
    public function render_file($template_file, iterable $array): self { }
    public function render_file(iterable $array): self { }

    /** @see \resolve_symbol() */
    public self $resolve_symbol;
    public function resolve_symbol(string $shortname, $nsfiles, $targets = ["const", "function", "alias"]): self { }
    public function resolve_symbol($nsfiles, $targets = ["const", "function", "alias"]): self { }

}
