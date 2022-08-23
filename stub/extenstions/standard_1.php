<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait standard_1
{
    /** @see \array_rand() */
    public self $rand;
    public function rand(array $array, int $num = 1): self { }
    public function rand0(int $num = 1): self { }
    public function rand1(array $array): self { }

    /** @see \array_reduce() */
    public function array_reduce(array $array, callable $callback, mixed $initial = null): self { }
    public function array_reduce0(callable $callback, mixed $initial = null): self { }
    public function array_reduce1(array $array, mixed $initial = null): self { }
    public function array_reduce2(array $array, callable $callback): self { }
    public function array_reduceP(array $array, callable $callback, mixed $initial = null): self { }
    public function array_reduce0P(callable $callback, mixed $initial = null): self { }
    public function array_reduce1P(array $array, mixed $initial = null): self { }
    public function array_reduce2P(array $array, callable $callback): self { }
    public function array_reduceE(array $array, callable $callback, mixed $initial = null): self { }
    public function array_reduce0E(callable $callback, mixed $initial = null): self { }
    public function array_reduce1E(array $array, mixed $initial = null): self { }
    public function array_reduce2E(array $array, callable $callback): self { }

    /** @see \array_reduce() */
    public function reduce(array $array, callable $callback, mixed $initial = null): self { }
    public function reduce0(callable $callback, mixed $initial = null): self { }
    public function reduce1(array $array, mixed $initial = null): self { }
    public function reduce2(array $array, callable $callback): self { }
    public function reduceP(array $array, callable $callback, mixed $initial = null): self { }
    public function reduce0P(callable $callback, mixed $initial = null): self { }
    public function reduce1P(array $array, mixed $initial = null): self { }
    public function reduce2P(array $array, callable $callback): self { }
    public function reduceE(array $array, callable $callback, mixed $initial = null): self { }
    public function reduce0E(callable $callback, mixed $initial = null): self { }
    public function reduce1E(array $array, mixed $initial = null): self { }
    public function reduce2E(array $array, callable $callback): self { }

    /** @see \array_replace() */
    public self $array_replace;
    public function array_replace(array $array, array ...$replacements): self { }
    public function array_replace0(array ...$replacements): self { }
    public function array_replace1(array $array): self { }

    /** @see \array_replace() */
    public self $replace;
    public function replace(array $array, array ...$replacements): self { }
    public function replace0(array ...$replacements): self { }
    public function replace1(array $array): self { }

    /** @see \array_replace_recursive() */
    public self $array_replace_recursive;
    public function array_replace_recursive(array $array, array ...$replacements): self { }
    public function array_replace_recursive0(array ...$replacements): self { }
    public function array_replace_recursive1(array $array): self { }

    /** @see \array_replace_recursive() */
    public self $replace_recursive;
    public function replace_recursive(array $array, array ...$replacements): self { }
    public function replace_recursive0(array ...$replacements): self { }
    public function replace_recursive1(array $array): self { }

    /** @see \array_reverse() */
    public self $array_reverse;
    public function array_reverse(array $array, bool $preserve_keys = false): self { }
    public function array_reverse0(bool $preserve_keys = false): self { }
    public function array_reverse1(array $array): self { }

    /** @see \array_reverse() */
    public self $reverse;
    public function reverse(array $array, bool $preserve_keys = false): self { }
    public function reverse0(bool $preserve_keys = false): self { }
    public function reverse1(array $array): self { }

    /** @see \array_search() */
    public function array_search(mixed $needle, array $haystack, bool $strict = false): self { }
    public function array_search0(array $haystack, bool $strict = false): self { }
    public function array_search1(mixed $needle, bool $strict = false): self { }
    public function array_search2(mixed $needle, array $haystack): self { }

    /** @see \array_search() */
    public function search(mixed $needle, array $haystack, bool $strict = false): self { }
    public function search0(array $haystack, bool $strict = false): self { }
    public function search1(mixed $needle, bool $strict = false): self { }
    public function search2(mixed $needle, array $haystack): self { }

    /** @see \array_slice() */
    public function array_slice(array $array, int $offset, ?int $length = null, bool $preserve_keys = false): self { }
    public function array_slice0(int $offset, ?int $length = null, bool $preserve_keys = false): self { }
    public function array_slice1(array $array, ?int $length = null, bool $preserve_keys = false): self { }
    public function array_slice2(array $array, int $offset, bool $preserve_keys = false): self { }
    public function array_slice3(array $array, int $offset, ?int $length = null): self { }

    /** @see \array_slice() */
    public function slice(array $array, int $offset, ?int $length = null, bool $preserve_keys = false): self { }
    public function slice0(int $offset, ?int $length = null, bool $preserve_keys = false): self { }
    public function slice1(array $array, ?int $length = null, bool $preserve_keys = false): self { }
    public function slice2(array $array, int $offset, bool $preserve_keys = false): self { }
    public function slice3(array $array, int $offset, ?int $length = null): self { }

    /** @see \array_splice() */
    public function array_splice(array &$array, int $offset, ?int $length = null, mixed $replacement = []): self { }
    public function array_splice0(int $offset, ?int $length = null, mixed $replacement = []): self { }
    public function array_splice1(array &$array, ?int $length = null, mixed $replacement = []): self { }
    public function array_splice2(array &$array, int $offset, mixed $replacement = []): self { }
    public function array_splice3(array &$array, int $offset, ?int $length = null): self { }

    /** @see \array_splice() */
    public function splice(array &$array, int $offset, ?int $length = null, mixed $replacement = []): self { }
    public function splice0(int $offset, ?int $length = null, mixed $replacement = []): self { }
    public function splice1(array &$array, ?int $length = null, mixed $replacement = []): self { }
    public function splice2(array &$array, int $offset, mixed $replacement = []): self { }
    public function splice3(array &$array, int $offset, ?int $length = null): self { }

    /** @see \array_sum() */
    public self $array_sum;
    public function array_sum(array $array): self { }
    public function array_sum0(): self { }

    /** @see \array_sum() */
    public self $sum;
    public function sum(array $array): self { }
    public function sum0(): self { }

    /** @see \array_udiff() */
    public self $array_udiff;
    public function array_udiff(array $array, ...$rest): self { }
    public function array_udiff0(...$rest): self { }
    public function array_udiff1(array $array): self { }

    /** @see \array_udiff() */
    public self $udiff;
    public function udiff(array $array, ...$rest): self { }
    public function udiff0(...$rest): self { }
    public function udiff1(array $array): self { }

    /** @see \array_udiff_assoc() */
    public self $array_udiff_assoc;
    public function array_udiff_assoc(array $array, ...$rest): self { }
    public function array_udiff_assoc0(...$rest): self { }
    public function array_udiff_assoc1(array $array): self { }

    /** @see \array_udiff_assoc() */
    public self $udiff_assoc;
    public function udiff_assoc(array $array, ...$rest): self { }
    public function udiff_assoc0(...$rest): self { }
    public function udiff_assoc1(array $array): self { }

    /** @see \array_udiff_uassoc() */
    public self $array_udiff_uassoc;
    public function array_udiff_uassoc(array $array, ...$rest): self { }
    public function array_udiff_uassoc0(...$rest): self { }
    public function array_udiff_uassoc1(array $array): self { }

    /** @see \array_udiff_uassoc() */
    public self $udiff_uassoc;
    public function udiff_uassoc(array $array, ...$rest): self { }
    public function udiff_uassoc0(...$rest): self { }
    public function udiff_uassoc1(array $array): self { }

    /** @see \array_uintersect() */
    public self $array_uintersect;
    public function array_uintersect(array $array, ...$rest): self { }
    public function array_uintersect0(...$rest): self { }
    public function array_uintersect1(array $array): self { }

    /** @see \array_uintersect() */
    public self $uintersect;
    public function uintersect(array $array, ...$rest): self { }
    public function uintersect0(...$rest): self { }
    public function uintersect1(array $array): self { }

    /** @see \array_uintersect_assoc() */
    public self $array_uintersect_assoc;
    public function array_uintersect_assoc(array $array, ...$rest): self { }
    public function array_uintersect_assoc0(...$rest): self { }
    public function array_uintersect_assoc1(array $array): self { }

    /** @see \array_uintersect_assoc() */
    public self $uintersect_assoc;
    public function uintersect_assoc(array $array, ...$rest): self { }
    public function uintersect_assoc0(...$rest): self { }
    public function uintersect_assoc1(array $array): self { }

    /** @see \array_uintersect_uassoc() */
    public self $array_uintersect_uassoc;
    public function array_uintersect_uassoc(array $array, ...$rest): self { }
    public function array_uintersect_uassoc0(...$rest): self { }
    public function array_uintersect_uassoc1(array $array): self { }

    /** @see \array_uintersect_uassoc() */
    public self $uintersect_uassoc;
    public function uintersect_uassoc(array $array, ...$rest): self { }
    public function uintersect_uassoc0(...$rest): self { }
    public function uintersect_uassoc1(array $array): self { }

    /** @see \array_unique() */
    public self $array_unique;
    public function array_unique(array $array, int $flags = SORT_STRING): self { }
    public function array_unique0(int $flags = SORT_STRING): self { }
    public function array_unique1(array $array): self { }

    /** @see \array_unique() */
    public self $unique;
    public function unique(array $array, int $flags = SORT_STRING): self { }
    public function unique0(int $flags = SORT_STRING): self { }
    public function unique1(array $array): self { }

    /** @see \array_unshift() */
    public self $array_unshift;
    public function array_unshift(array &$array, mixed ...$values): self { }
    public function array_unshift0(mixed ...$values): self { }
    public function array_unshift1(array &$array): self { }

    /** @see \array_unshift() */
    public self $unshift;
    public function unshift(array &$array, mixed ...$values): self { }
    public function unshift0(mixed ...$values): self { }
    public function unshift1(array &$array): self { }

    /** @see \array_values() */
    public self $array_values;
    public function array_values(array $array): self { }
    public function array_values0(): self { }

    /** @see \array_values() */
    public self $values;
    public function values(array $array): self { }
    public function values0(): self { }

    /** @see \array_walk() */
    public function array_walk(object|array &$array, callable $callback, mixed $arg): self { }
    public function array_walk0(callable $callback, mixed $arg): self { }
    public function array_walk1(object|array &$array, mixed $arg): self { }
    public function array_walk2(object|array &$array, callable $callback): self { }
    public function array_walkP(object|array &$array, callable $callback, mixed $arg): self { }
    public function array_walk0P(callable $callback, mixed $arg): self { }
    public function array_walk1P(object|array &$array, mixed $arg): self { }
    public function array_walk2P(object|array &$array, callable $callback): self { }
    public function array_walkE(object|array &$array, callable $callback, mixed $arg): self { }
    public function array_walk0E(callable $callback, mixed $arg): self { }
    public function array_walk1E(object|array &$array, mixed $arg): self { }
    public function array_walk2E(object|array &$array, callable $callback): self { }

    /** @see \array_walk() */
    public function walk(object|array &$array, callable $callback, mixed $arg): self { }
    public function walk0(callable $callback, mixed $arg): self { }
    public function walk1(object|array &$array, mixed $arg): self { }
    public function walk2(object|array &$array, callable $callback): self { }
    public function walkP(object|array &$array, callable $callback, mixed $arg): self { }
    public function walk0P(callable $callback, mixed $arg): self { }
    public function walk1P(object|array &$array, mixed $arg): self { }
    public function walk2P(object|array &$array, callable $callback): self { }
    public function walkE(object|array &$array, callable $callback, mixed $arg): self { }
    public function walk0E(callable $callback, mixed $arg): self { }
    public function walk1E(object|array &$array, mixed $arg): self { }
    public function walk2E(object|array &$array, callable $callback): self { }

    /** @see \array_walk_recursive() */
    public function array_walk_recursive(object|array &$array, callable $callback, mixed $arg): self { }
    public function array_walk_recursive0(callable $callback, mixed $arg): self { }
    public function array_walk_recursive1(object|array &$array, mixed $arg): self { }
    public function array_walk_recursive2(object|array &$array, callable $callback): self { }
    public function array_walk_recursiveP(object|array &$array, callable $callback, mixed $arg): self { }
    public function array_walk_recursive0P(callable $callback, mixed $arg): self { }
    public function array_walk_recursive1P(object|array &$array, mixed $arg): self { }
    public function array_walk_recursive2P(object|array &$array, callable $callback): self { }
    public function array_walk_recursiveE(object|array &$array, callable $callback, mixed $arg): self { }
    public function array_walk_recursive0E(callable $callback, mixed $arg): self { }
    public function array_walk_recursive1E(object|array &$array, mixed $arg): self { }
    public function array_walk_recursive2E(object|array &$array, callable $callback): self { }

    /** @see \array_walk_recursive() */
    public function walk_recursive(object|array &$array, callable $callback, mixed $arg): self { }
    public function walk_recursive0(callable $callback, mixed $arg): self { }
    public function walk_recursive1(object|array &$array, mixed $arg): self { }
    public function walk_recursive2(object|array &$array, callable $callback): self { }
    public function walk_recursiveP(object|array &$array, callable $callback, mixed $arg): self { }
    public function walk_recursive0P(callable $callback, mixed $arg): self { }
    public function walk_recursive1P(object|array &$array, mixed $arg): self { }
    public function walk_recursive2P(object|array &$array, callable $callback): self { }
    public function walk_recursiveE(object|array &$array, callable $callback, mixed $arg): self { }
    public function walk_recursive0E(callable $callback, mixed $arg): self { }
    public function walk_recursive1E(object|array &$array, mixed $arg): self { }
    public function walk_recursive2E(object|array &$array, callable $callback): self { }

    /** @see \arsort() */
    public self $arsort;
    public function arsort(array &$array, int $flags = SORT_REGULAR): self { }
    public function arsort0(int $flags = SORT_REGULAR): self { }
    public function arsort1(array &$array): self { }

    /** @see \asin() */
    public self $asin;
    public function asin(float $num): self { }
    public function asin0(): self { }

    /** @see \asinh() */
    public self $asinh;
    public function asinh(float $num): self { }
    public function asinh0(): self { }

    /** @see \asort() */
    public self $asort;
    public function asort(array &$array, int $flags = SORT_REGULAR): self { }
    public function asort0(int $flags = SORT_REGULAR): self { }
    public function asort1(array &$array): self { }

    /** @see \assert() */
    public self $assert;
    public function assert(mixed $assertion, \Throwable|string|null $description = null): self { }
    public function assert0(\Throwable|string|null $description = null): self { }
    public function assert1(mixed $assertion): self { }

    /** @see \assert_options() */
    public self $assert_options;
    public function assert_options(int $option, mixed $value): self { }
    public function assert_options0(mixed $value): self { }
    public function assert_options1(int $option): self { }

    /** @see \atan() */
    public self $atan;
    public function atan(float $num): self { }
    public function atan0(): self { }

    /** @see \atan2() */
    public function atan2(float $y, float $x): self { }
    public function atan20(float $x): self { }
    public function atan21(float $y): self { }

    /** @see \atanh() */
    public self $atanh;
    public function atanh(float $num): self { }
    public function atanh0(): self { }

    /** @see \base64_decode() */
    public self $base64_decode;
    public function base64_decode(string $string, bool $strict = false): self { }
    public function base64_decode0(bool $strict = false): self { }
    public function base64_decode1(string $string): self { }

    /** @see \base64_encode() */
    public self $base64_encode;
    public function base64_encode(string $string): self { }
    public function base64_encode0(): self { }

    /** @see \base_convert() */
    public function base_convert(string $num, int $from_base, int $to_base): self { }
    public function base_convert0(int $from_base, int $to_base): self { }
    public function base_convert1(string $num, int $to_base): self { }
    public function base_convert2(string $num, int $from_base): self { }

    /** @see \basename() */
    public self $basename;
    public function basename(string $path, string $suffix = ""): self { }
    public function basename0(string $suffix = ""): self { }
    public function basename1(string $path): self { }

    /** @see \bin2hex() */
    public self $bin2hex;
    public function bin2hex(string $string): self { }
    public function bin2hex0(): self { }

    /** @see \bindec() */
    public self $bindec;
    public function bindec(string $binary_string): self { }
    public function bindec0(): self { }

    /** @see \boolval() */
    public self $boolval;
    public function boolval(mixed $value): self { }
    public function boolval0(): self { }

    /** @see \call_user_func() */
    public self $call_user_func;
    public function call_user_func(callable $callback, mixed ...$args): self { }
    public function call_user_func0(mixed ...$args): self { }
    public function call_user_func1(callable $callback): self { }
    public function call_user_funcP(callable $callback, mixed ...$args): self { }
    public function call_user_func0P(mixed ...$args): self { }
    public function call_user_func1P(callable $callback): self { }
    public function call_user_funcE(callable $callback, mixed ...$args): self { }
    public function call_user_func0E(mixed ...$args): self { }
    public function call_user_func1E(callable $callback): self { }

    /** @see \call_user_func_array() */
    public function call_user_func_array(callable $callback, array $args): self { }
    public function call_user_func_array0(array $args): self { }
    public function call_user_func_array1(callable $callback): self { }
    public function call_user_func_arrayP(callable $callback, array $args): self { }
    public function call_user_func_array0P(array $args): self { }
    public function call_user_func_array1P(callable $callback): self { }
    public function call_user_func_arrayE(callable $callback, array $args): self { }
    public function call_user_func_array0E(array $args): self { }
    public function call_user_func_array1E(callable $callback): self { }

    /** @see \ceil() */
    public self $ceil;
    public function ceil(int|float $num): self { }
    public function ceil0(): self { }

    /** @see \chdir() */
    public self $chdir;
    public function chdir(string $directory): self { }
    public function chdir0(): self { }

    /** @see \checkdnsrr() */
    public self $checkdnsrr;
    public function checkdnsrr(string $hostname, string $type = "MX"): self { }
    public function checkdnsrr0(string $type = "MX"): self { }
    public function checkdnsrr1(string $hostname): self { }

    /** @see \chgrp() */
    public function chgrp(string $filename, string|int $group): self { }
    public function chgrp0(string|int $group): self { }
    public function chgrp1(string $filename): self { }

    /** @see \chmod() */
    public function chmod(string $filename, int $permissions): self { }
    public function chmod0(int $permissions): self { }
    public function chmod1(string $filename): self { }

    /** @see \chop() */
    public self $chop;
    public function chop(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function chop0(string $characters = " \n\r\t\v\000"): self { }
    public function chop1(string $string): self { }

    /** @see \chown() */
    public function chown(string $filename, string|int $user): self { }
    public function chown0(string|int $user): self { }
    public function chown1(string $filename): self { }

}
