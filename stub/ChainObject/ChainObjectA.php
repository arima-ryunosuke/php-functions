<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectA
{
    /** @see \array_push() */
    public self $array_push;
    public function array_push(array &$array, mixed ...$values): self { }
    public function array_push(mixed ...$values): self { }

    /** @see \array_push() */
    public self $push;
    public function push(array &$array, mixed ...$values): self { }
    public function push(mixed ...$values): self { }

    /** @see \asort() */
    public self $asort;
    public function asort(array &$array, int $flags = SORT_REGULAR): self { }
    public function asort(int $flags = SORT_REGULAR): self { }

    /** @see \arsort() */
    public self $arsort;
    public function arsort(array &$array, int $flags = SORT_REGULAR): self { }
    public function arsort(int $flags = SORT_REGULAR): self { }

    /** @see \array_walk() */
    public self $array_walk;
    public function array_walk(object|array &$array, callable $callback, mixed $arg): self { }
    public function array_walk(callable $callback, mixed $arg): self { }

    /** @see \array_walk() */
    public self $walk;
    public function walk(object|array &$array, callable $callback, mixed $arg): self { }
    public function walk(callable $callback, mixed $arg): self { }

    /** @see \array_walk_recursive() */
    public self $array_walk_recursive;
    public function array_walk_recursive(object|array &$array, callable $callback, mixed $arg): self { }
    public function array_walk_recursive(callable $callback, mixed $arg): self { }

    /** @see \array_walk_recursive() */
    public self $walk_recursive;
    public function walk_recursive(object|array &$array, callable $callback, mixed $arg): self { }
    public function walk_recursive(callable $callback, mixed $arg): self { }

    /** @see \array_search() */
    public self $array_search;
    public function array_search(mixed $needle, array $haystack, bool $strict = false): self { }
    public function array_search(array $haystack, bool $strict = false): self { }

    /** @see \array_search() */
    public self $search;
    public function search(mixed $needle, array $haystack, bool $strict = false): self { }
    public function search(array $haystack, bool $strict = false): self { }

    /** @see \array_fill() */
    public self $array_fill;
    public function array_fill(int $start_index, int $count, mixed $value): self { }
    public function array_fill(int $count, mixed $value): self { }

    /** @see \array_fill() */
    public self $fill;
    public function fill(int $start_index, int $count, mixed $value): self { }
    public function fill(int $count, mixed $value): self { }

    /** @see \array_fill_keys() */
    public self $array_fill_keys;
    public function array_fill_keys(array $keys, mixed $value): self { }
    public function array_fill_keys(mixed $value): self { }

    /** @see \array_fill_keys() */
    public self $fill_keys;
    public function fill_keys(array $keys, mixed $value): self { }
    public function fill_keys(mixed $value): self { }

    /** @see \array_unshift() */
    public self $array_unshift;
    public function array_unshift(array &$array, mixed ...$values): self { }
    public function array_unshift(mixed ...$values): self { }

    /** @see \array_unshift() */
    public self $unshift;
    public function unshift(array &$array, mixed ...$values): self { }
    public function unshift(mixed ...$values): self { }

    /** @see \array_splice() */
    public self $array_splice;
    public function array_splice(array &$array, int $offset, ?int $length = null, mixed $replacement = []): self { }
    public function array_splice(int $offset, ?int $length = null, mixed $replacement = []): self { }

    /** @see \array_splice() */
    public self $splice;
    public function splice(array &$array, int $offset, ?int $length = null, mixed $replacement = []): self { }
    public function splice(int $offset, ?int $length = null, mixed $replacement = []): self { }

    /** @see \array_slice() */
    public self $array_slice;
    public function array_slice(array $array, int $offset, ?int $length = null, bool $preserve_keys = false): self { }
    public function array_slice(int $offset, ?int $length = null, bool $preserve_keys = false): self { }

    /** @see \array_slice() */
    public self $slice;
    public function slice(array $array, int $offset, ?int $length = null, bool $preserve_keys = false): self { }
    public function slice(int $offset, ?int $length = null, bool $preserve_keys = false): self { }

    /** @see \array_merge() */
    public self $array_merge;
    public function array_merge(array ...$arrays): self { }
    public function array_merge(): self { }

    /** @see \array_merge() */
    public self $merge;
    public function merge(array ...$arrays): self { }
    public function merge(): self { }

    /** @see \array_merge_recursive() */
    public self $array_merge_recursive;
    public function array_merge_recursive(array ...$arrays): self { }
    public function array_merge_recursive(): self { }

    /** @see \array_merge_recursive() */
    public self $merge_recursive;
    public function merge_recursive(array ...$arrays): self { }
    public function merge_recursive(): self { }

    /** @see \array_replace() */
    public self $array_replace;
    public function array_replace(array ...$replacements): self { }
    public function array_replace(): self { }

    /** @see \array_replace() */
    public self $replace;
    public function replace(array ...$replacements): self { }
    public function replace(): self { }

    /** @see \array_replace_recursive() */
    public self $array_replace_recursive;
    public function array_replace_recursive(array ...$replacements): self { }
    public function array_replace_recursive(): self { }

    /** @see \array_replace_recursive() */
    public self $replace_recursive;
    public function replace_recursive(array ...$replacements): self { }
    public function replace_recursive(): self { }

    /** @see \array_keys() */
    public self $array_keys;
    public function array_keys(array $array, mixed $filter_value, bool $strict = false): self { }
    public function array_keys(mixed $filter_value, bool $strict = false): self { }

    /** @see \array_keys() */
    public self $keys;
    public function keys(array $array, mixed $filter_value, bool $strict = false): self { }
    public function keys(mixed $filter_value, bool $strict = false): self { }

    /** @see \array_key_first() */
    public self $array_key_first;
    public function array_key_first(array $array): self { }
    public function array_key_first(): self { }

    /** @see \array_key_first() */
    public self $key_first;
    public function key_first(array $array): self { }
    public function key_first(): self { }

    /** @see \array_key_last() */
    public self $array_key_last;
    public function array_key_last(array $array): self { }
    public function array_key_last(): self { }

    /** @see \array_key_last() */
    public self $key_last;
    public function key_last(array $array): self { }
    public function key_last(): self { }

    /** @see \array_values() */
    public self $array_values;
    public function array_values(array $array): self { }
    public function array_values(): self { }

    /** @see \array_values() */
    public self $values;
    public function values(array $array): self { }
    public function values(): self { }

    /** @see \array_count_values() */
    public self $array_count_values;
    public function array_count_values(array $array): self { }
    public function array_count_values(): self { }

    /** @see \array_count_values() */
    public self $count_values;
    public function count_values(array $array): self { }
    public function count_values(): self { }

    /** @see \array_column() */
    public self $array_column;
    public function array_column(array $array, string|int|null $column_key, string|int|null $index_key = null): self { }
    public function array_column(string|int|null $column_key, string|int|null $index_key = null): self { }

    /** @see \array_column() */
    public self $column;
    public function column(array $array, string|int|null $column_key, string|int|null $index_key = null): self { }
    public function column(string|int|null $column_key, string|int|null $index_key = null): self { }

    /** @see \array_reverse() */
    public self $array_reverse;
    public function array_reverse(array $array, bool $preserve_keys = false): self { }
    public function array_reverse(bool $preserve_keys = false): self { }

    /** @see \array_reverse() */
    public self $reverse;
    public function reverse(array $array, bool $preserve_keys = false): self { }
    public function reverse(bool $preserve_keys = false): self { }

    /** @see \array_pad() */
    public self $array_pad;
    public function array_pad(array $array, int $length, mixed $value): self { }
    public function array_pad(int $length, mixed $value): self { }

    /** @see \array_pad() */
    public self $pad;
    public function pad(array $array, int $length, mixed $value): self { }
    public function pad(int $length, mixed $value): self { }

    /** @see \array_flip() */
    public self $array_flip;
    public function array_flip(array $array): self { }
    public function array_flip(): self { }

    /** @see \array_flip() */
    public self $flip;
    public function flip(array $array): self { }
    public function flip(): self { }

    /** @see \array_change_key_case() */
    public self $array_change_key_case;
    public function array_change_key_case(array $array, int $case = CASE_LOWER): self { }
    public function array_change_key_case(int $case = CASE_LOWER): self { }

    /** @see \array_change_key_case() */
    public self $change_key_case;
    public function change_key_case(array $array, int $case = CASE_LOWER): self { }
    public function change_key_case(int $case = CASE_LOWER): self { }

    /** @see \array_unique() */
    public self $array_unique;
    public function array_unique(array $array, int $flags = SORT_STRING): self { }
    public function array_unique(int $flags = SORT_STRING): self { }

    /** @see \array_unique() */
    public self $unique;
    public function unique(array $array, int $flags = SORT_STRING): self { }
    public function unique(int $flags = SORT_STRING): self { }

    /** @see \array_intersect_key() */
    public self $array_intersect_key;
    public function array_intersect_key(array ...$arrays): self { }
    public function array_intersect_key(): self { }

    /** @see \array_intersect_key() */
    public self $intersect_key;
    public function intersect_key(array ...$arrays): self { }
    public function intersect_key(): self { }

    /** @see \array_intersect_ukey() */
    public self $array_intersect_ukey;
    public function array_intersect_ukey(array $array, ...$rest): self { }
    public function array_intersect_ukey(...$rest): self { }

    /** @see \array_intersect_ukey() */
    public self $intersect_ukey;
    public function intersect_ukey(array $array, ...$rest): self { }
    public function intersect_ukey(...$rest): self { }

    /** @see \array_intersect() */
    public self $array_intersect;
    public function array_intersect(array ...$arrays): self { }
    public function array_intersect(): self { }

    /** @see \array_intersect() */
    public self $intersect;
    public function intersect(array ...$arrays): self { }
    public function intersect(): self { }

    /** @see \array_uintersect() */
    public self $array_uintersect;
    public function array_uintersect(array $array, ...$rest): self { }
    public function array_uintersect(...$rest): self { }

    /** @see \array_uintersect() */
    public self $uintersect;
    public function uintersect(array $array, ...$rest): self { }
    public function uintersect(...$rest): self { }

    /** @see \array_intersect_assoc() */
    public self $array_intersect_assoc;
    public function array_intersect_assoc(array ...$arrays): self { }
    public function array_intersect_assoc(): self { }

    /** @see \array_intersect_assoc() */
    public self $intersect_assoc;
    public function intersect_assoc(array ...$arrays): self { }
    public function intersect_assoc(): self { }

    /** @see \array_uintersect_assoc() */
    public self $array_uintersect_assoc;
    public function array_uintersect_assoc(array $array, ...$rest): self { }
    public function array_uintersect_assoc(...$rest): self { }

    /** @see \array_uintersect_assoc() */
    public self $uintersect_assoc;
    public function uintersect_assoc(array $array, ...$rest): self { }
    public function uintersect_assoc(...$rest): self { }

    /** @see \array_intersect_uassoc() */
    public self $array_intersect_uassoc;
    public function array_intersect_uassoc(array $array, ...$rest): self { }
    public function array_intersect_uassoc(...$rest): self { }

    /** @see \array_intersect_uassoc() */
    public self $intersect_uassoc;
    public function intersect_uassoc(array $array, ...$rest): self { }
    public function intersect_uassoc(...$rest): self { }

    /** @see \array_uintersect_uassoc() */
    public self $array_uintersect_uassoc;
    public function array_uintersect_uassoc(array $array, ...$rest): self { }
    public function array_uintersect_uassoc(...$rest): self { }

    /** @see \array_uintersect_uassoc() */
    public self $uintersect_uassoc;
    public function uintersect_uassoc(array $array, ...$rest): self { }
    public function uintersect_uassoc(...$rest): self { }

    /** @see \array_diff_key() */
    public self $array_diff_key;
    public function array_diff_key(array ...$arrays): self { }
    public function array_diff_key(): self { }

    /** @see \array_diff_key() */
    public self $diff_key;
    public function diff_key(array ...$arrays): self { }
    public function diff_key(): self { }

    /** @see \array_diff_ukey() */
    public self $array_diff_ukey;
    public function array_diff_ukey(array $array, ...$rest): self { }
    public function array_diff_ukey(...$rest): self { }

    /** @see \array_diff_ukey() */
    public self $diff_ukey;
    public function diff_ukey(array $array, ...$rest): self { }
    public function diff_ukey(...$rest): self { }

    /** @see \array_diff() */
    public self $array_diff;
    public function array_diff(array ...$arrays): self { }
    public function array_diff(): self { }

    /** @see \array_diff() */
    public self $diff;
    public function diff(array ...$arrays): self { }
    public function diff(): self { }

    /** @see \array_udiff() */
    public self $array_udiff;
    public function array_udiff(array $array, ...$rest): self { }
    public function array_udiff(...$rest): self { }

    /** @see \array_udiff() */
    public self $udiff;
    public function udiff(array $array, ...$rest): self { }
    public function udiff(...$rest): self { }

    /** @see \array_diff_assoc() */
    public self $array_diff_assoc;
    public function array_diff_assoc(array ...$arrays): self { }
    public function array_diff_assoc(): self { }

    /** @see \array_diff_assoc() */
    public self $diff_assoc;
    public function diff_assoc(array ...$arrays): self { }
    public function diff_assoc(): self { }

    /** @see \array_diff_uassoc() */
    public self $array_diff_uassoc;
    public function array_diff_uassoc(array $array, ...$rest): self { }
    public function array_diff_uassoc(...$rest): self { }

    /** @see \array_diff_uassoc() */
    public self $diff_uassoc;
    public function diff_uassoc(array $array, ...$rest): self { }
    public function diff_uassoc(...$rest): self { }

    /** @see \array_udiff_assoc() */
    public self $array_udiff_assoc;
    public function array_udiff_assoc(array $array, ...$rest): self { }
    public function array_udiff_assoc(...$rest): self { }

    /** @see \array_udiff_assoc() */
    public self $udiff_assoc;
    public function udiff_assoc(array $array, ...$rest): self { }
    public function udiff_assoc(...$rest): self { }

    /** @see \array_udiff_uassoc() */
    public self $array_udiff_uassoc;
    public function array_udiff_uassoc(array $array, ...$rest): self { }
    public function array_udiff_uassoc(...$rest): self { }

    /** @see \array_udiff_uassoc() */
    public self $udiff_uassoc;
    public function udiff_uassoc(array $array, ...$rest): self { }
    public function udiff_uassoc(...$rest): self { }

    /** @see \array_rand() */
    public self $array_rand;
    public function array_rand(array $array, int $num = 1): self { }
    public function array_rand(int $num = 1): self { }

    /** @see \array_rand() */
    public self $rand;
    public function rand(array $array, int $num = 1): self { }
    public function rand(int $num = 1): self { }

    /** @see \array_sum() */
    public self $array_sum;
    public function array_sum(array $array): self { }
    public function array_sum(): self { }

    /** @see \array_sum() */
    public self $sum;
    public function sum(array $array): self { }
    public function sum(): self { }

    /** @see \array_product() */
    public self $array_product;
    public function array_product(array $array): self { }
    public function array_product(): self { }

    /** @see \array_product() */
    public self $product;
    public function product(array $array): self { }
    public function product(): self { }

    /** @see \array_reduce() */
    public self $array_reduce;
    public function array_reduce(array $array, callable $callback, mixed $initial = null): self { }
    public function array_reduce(callable $callback, mixed $initial = null): self { }

    /** @see \array_reduce() */
    public self $reduce;
    public function reduce(array $array, callable $callback, mixed $initial = null): self { }
    public function reduce(callable $callback, mixed $initial = null): self { }

    /** @see \array_filter() */
    public self $array_filter;
    public function array_filter(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function array_filter(?callable $callback = null, int $mode = 0): self { }

    /** @see \array_filter() */
    public self $filter;
    public function filter(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function filter(?callable $callback = null, int $mode = 0): self { }

    /** @see \array_map() */
    public self $array_map;
    public function array_map(?callable $callback, array $array, array ...$arrays): self { }
    public function array_map(array $array, array ...$arrays): self { }

    /** @see \array_map() */
    public self $map;
    public function map(?callable $callback, array $array, array ...$arrays): self { }
    public function map(array $array, array ...$arrays): self { }

    /** @see \array_key_exists() */
    public self $array_key_exists;
    public function array_key_exists($key, array $array): self { }
    public function array_key_exists(array $array): self { }

    /** @see \array_key_exists() */
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

    /** @see \array_combine() */
    public self $array_combine;
    public function array_combine(array $keys, array $values): self { }
    public function array_combine(array $values): self { }

    /** @see \array_combine() */
    public self $combine;
    public function combine(array $keys, array $values): self { }
    public function combine(array $values): self { }

    /** @see \assert() */
    public self $assert;
    public function assert(mixed $assertion, \Throwable|string|null $description = null): self { }
    public function assert(\Throwable|string|null $description = null): self { }

    /** @see \assert_options() */
    public self $assert_options;
    public function assert_options(int $option, mixed $value): self { }
    public function assert_options(mixed $value): self { }

    /** @see \addcslashes() */
    public self $addcslashes;
    public function addcslashes(string $string, string $characters): self { }
    public function addcslashes(string $characters): self { }

    /** @see \addslashes() */
    public self $addslashes;
    public function addslashes(string $string): self { }
    public function addslashes(): self { }

    /** @see \abs() */
    public self $abs;
    public function abs(int|float $num): self { }
    public function abs(): self { }

    /** @see \asin() */
    public self $asin;
    public function asin(float $num): self { }
    public function asin(): self { }

    /** @see \acos() */
    public self $acos;
    public function acos(float $num): self { }
    public function acos(): self { }

    /** @see \atan() */
    public self $atan;
    public function atan(float $num): self { }
    public function atan(): self { }

    /** @see \atanh() */
    public self $atanh;
    public function atanh(float $num): self { }
    public function atanh(): self { }

    /** @see \atan2() */
    public self $atan2;
    public function atan2(float $y, float $x): self { }
    public function atan2(float $x): self { }

    /** @see \asinh() */
    public self $asinh;
    public function asinh(float $num): self { }
    public function asinh(): self { }

    /** @see \acosh() */
    public self $acosh;
    public function acosh(float $num): self { }
    public function acosh(): self { }

    /** @see \arrays() */
    public self $arrays;
    public function arrays(iterable $array): self { }
    public function arrays(): self { }

    /** @see \arrayize() */
    public self $arrayize;
    public function arrayize(...$variadic): self { }
    public function arrayize(): self { }

    /** @see \array_add() */
    public self $array_add;
    public function array_add(...$variadic): self { }
    public function array_add(): self { }

    /** @see \array_add() */
    public self $add;
    public function add(...$variadic): self { }
    public function add(): self { }

    /** @see \array_append() */
    public self $array_append;
    public function array_append(iterable $array, $value, $key = null): self { }
    public function array_append($value, $key = null): self { }

    /** @see \array_append() */
    public self $append;
    public function append(iterable $array, $value, $key = null): self { }
    public function append($value, $key = null): self { }

    /** @see \array_prepend() */
    public self $array_prepend;
    public function array_prepend(iterable $array, $value, $key = null): self { }
    public function array_prepend($value, $key = null): self { }

    /** @see \array_prepend() */
    public self $prepend;
    public function prepend(iterable $array, $value, $key = null): self { }
    public function prepend($value, $key = null): self { }

    /** @see \array_merge2() */
    public self $array_merge2;
    public function array_merge2(iterable ...$arrays): self { }
    public function array_merge2(): self { }

    /** @see \array_merge2() */
    public self $merge2;
    public function merge2(iterable ...$arrays): self { }
    public function merge2(): self { }

    /** @see \array_mix() */
    public self $array_mix;
    public function array_mix(...$variadic): self { }
    public function array_mix(): self { }

    /** @see \array_mix() */
    public self $mix;
    public function mix(...$variadic): self { }
    public function mix(): self { }

    /** @see \array_zip() */
    public self $array_zip;
    public function array_zip(iterable ...$arrays): self { }
    public function array_zip(): self { }

    /** @see \array_zip() */
    public self $zip;
    public function zip(iterable ...$arrays): self { }
    public function zip(): self { }

    /** @see \array_cross() */
    public self $array_cross;
    public function array_cross(iterable ...$arrays): self { }
    public function array_cross(): self { }

    /** @see \array_cross() */
    public self $cross;
    public function cross(iterable ...$arrays): self { }
    public function cross(): self { }

    /** @see \array_implode() */
    public self $array_implode;
    public function array_implode(iterable $array, $glue): self { }
    public function array_implode($glue): self { }

    /** @see \array_implode() */
    public self $implode;
    public function implode(iterable $array, $glue): self { }
    public function implode($glue): self { }

    /** @see \array_explode() */
    public self $array_explode;
    public function array_explode(iterable $array, $condition, $limit = PHP_INT_MAX): self { }
    public function array_explode($condition, $limit = PHP_INT_MAX): self { }

    /** @see \array_explode() */
    public self $explode;
    public function explode(iterable $array, $condition, $limit = PHP_INT_MAX): self { }
    public function explode($condition, $limit = PHP_INT_MAX): self { }

    /** @see \array_sprintf() */
    public self $array_sprintf;
    public function array_sprintf(iterable $array, $format = null, $glue = null): self { }
    public function array_sprintf($format = null, $glue = null): self { }

    /** @see \array_sprintf() */
    public self $sprintf;
    public function sprintf(iterable $array, $format = null, $glue = null): self { }
    public function sprintf($format = null, $glue = null): self { }

    /** @see \array_strpad() */
    public self $array_strpad;
    public function array_strpad(iterable $array, $key_prefix, $val_prefix = ""): self { }
    public function array_strpad($key_prefix, $val_prefix = ""): self { }

    /** @see \array_strpad() */
    public self $strpad;
    public function strpad(iterable $array, $key_prefix, $val_prefix = ""): self { }
    public function strpad($key_prefix, $val_prefix = ""): self { }

    /** @see \array_pos() */
    public self $array_pos;
    public function array_pos(iterable $array, $position, $return_key = false): self { }
    public function array_pos($position, $return_key = false): self { }

    /** @see \array_pos() */
    public self $pos;
    public function pos(iterable $array, $position, $return_key = false): self { }
    public function pos($position, $return_key = false): self { }

    /** @see \array_pos_key() */
    public self $array_pos_key;
    public function array_pos_key(iterable $array, $key, $default = null): self { }
    public function array_pos_key($key, $default = null): self { }

    /** @see \array_pos_key() */
    public self $pos_key;
    public function pos_key(iterable $array, $key, $default = null): self { }
    public function pos_key($key, $default = null): self { }

    /** @see \array_of() */
    public self $array_of;
    public function array_of($key, $default = null): self { }
    public function array_of($default = null): self { }

    /** @see \array_of() */
    public self $of;
    public function of($key, $default = null): self { }
    public function of($default = null): self { }

    /** @see \array_get() */
    public self $array_get;
    public function array_get(iterable $array, $key, $default = null): self { }
    public function array_get($key, $default = null): self { }

    /** @see \array_get() */
    public self $get;
    public function get(iterable $array, $key, $default = null): self { }
    public function get($key, $default = null): self { }

    /** @see \array_set() */
    public self $array_set;
    public function array_set(iterable &$array, $value, $key = null, $require_return = true): self { }
    public function array_set($value, $key = null, $require_return = true): self { }

    /** @see \array_set() */
    public self $set;
    public function set(iterable &$array, $value, $key = null, $require_return = true): self { }
    public function set($value, $key = null, $require_return = true): self { }

    /** @see \array_put() */
    public self $array_put;
    public function array_put(iterable &$array, $value, $key = null, $condition = null): self { }
    public function array_put($value, $key = null, $condition = null): self { }

    /** @see \array_put() */
    public self $put;
    public function put(iterable &$array, $value, $key = null, $condition = null): self { }
    public function put($value, $key = null, $condition = null): self { }

    /** @see \array_unset() */
    public self $array_unset;
    public function array_unset(iterable &$array, $key, $default = null): self { }
    public function array_unset($key, $default = null): self { }

    /** @see \array_unset() */
    public self $unset;
    public function unset(iterable &$array, $key, $default = null): self { }
    public function unset($key, $default = null): self { }

    /** @see \array_dive() */
    public self $array_dive;
    public function array_dive(iterable $array, $path, $default = null, $delimiter = "."): self { }
    public function array_dive($path, $default = null, $delimiter = "."): self { }

    /** @see \array_dive() */
    public self $dive;
    public function dive(iterable $array, $path, $default = null, $delimiter = "."): self { }
    public function dive($path, $default = null, $delimiter = "."): self { }

    /** @see \array_keys_exist() */
    public self $array_keys_exist;
    public function array_keys_exist($keys, iterable $array): self { }
    public function array_keys_exist(iterable $array): self { }

    /** @see \array_keys_exist() */
    public self $keys_exist;
    public function keys_exist($keys, iterable $array): self { }
    public function keys_exist(iterable $array): self { }

    /** @see \array_find() */
    public self $array_find;
    public function array_find(iterable $array, callable $callback, $is_key = true): self { }
    public function array_find(callable $callback, $is_key = true): self { }

    /** @see \array_find() */
    public self $find;
    public function find(iterable $array, callable $callback, $is_key = true): self { }
    public function find(callable $callback, $is_key = true): self { }

    /** @see \array_find_last() */
    public self $array_find_last;
    public function array_find_last(iterable $array, callable $callback, $is_key = true): self { }
    public function array_find_last(callable $callback, $is_key = true): self { }

    /** @see \array_find_last() */
    public self $find_last;
    public function find_last(iterable $array, callable $callback, $is_key = true): self { }
    public function find_last(callable $callback, $is_key = true): self { }

    /** @see \array_find_recursive() */
    public self $array_find_recursive;
    public function array_find_recursive(iterable $array, callable $callback, $is_key = true): self { }
    public function array_find_recursive(callable $callback, $is_key = true): self { }

    /** @see \array_find_recursive() */
    public self $find_recursive;
    public function find_recursive(iterable $array, callable $callback, $is_key = true): self { }
    public function find_recursive(callable $callback, $is_key = true): self { }

    /** @see \array_rekey() */
    public self $array_rekey;
    public function array_rekey(iterable $array, $keymap): self { }
    public function array_rekey($keymap): self { }

    /** @see \array_rekey() */
    public self $rekey;
    public function rekey(iterable $array, $keymap): self { }
    public function rekey($keymap): self { }

    /** @see \array_grep_key() */
    public self $array_grep_key;
    public function array_grep_key(iterable $array, $regex, $not = false): self { }
    public function array_grep_key($regex, $not = false): self { }

    /** @see \array_grep_key() */
    public self $grep_key;
    public function grep_key(iterable $array, $regex, $not = false): self { }
    public function grep_key($regex, $not = false): self { }

    /** @see \array_map_recursive() */
    public self $array_map_recursive;
    public function array_map_recursive(iterable $array, callable $callback, iterable $iterable = true, iterable $apply_array = false): self { }
    public function array_map_recursive(callable $callback, iterable $iterable = true, iterable $apply_array = false): self { }

    /** @see \array_map_recursive() */
    public self $map_recursive;
    public function map_recursive(iterable $array, callable $callback, iterable $iterable = true, iterable $apply_array = false): self { }
    public function map_recursive(callable $callback, iterable $iterable = true, iterable $apply_array = false): self { }

    /** @see \array_map_key() */
    public self $array_map_key;
    public function array_map_key(iterable $array, callable $callback): self { }
    public function array_map_key(callable $callback): self { }

    /** @see \array_map_key() */
    public self $map_key;
    public function map_key(iterable $array, callable $callback): self { }
    public function map_key(callable $callback): self { }

    /** @see \array_filter_key() */
    public self $array_filter_key;
    public function array_filter_key(iterable $array, callable $callback): self { }
    public function array_filter_key(callable $callback): self { }

    /** @see \array_filter_key() */
    public self $filter_key;
    public function filter_key(iterable $array, callable $callback): self { }
    public function filter_key(callable $callback): self { }

    /** @see \array_where() */
    public self $array_where;
    public function array_where(iterable $array, $column = null, callable $callback = null): self { }
    public function array_where($column = null, callable $callback = null): self { }

    /** @see \array_where() */
    public self $where;
    public function where(iterable $array, $column = null, callable $callback = null): self { }
    public function where($column = null, callable $callback = null): self { }

    /** @see \array_map_filter() */
    public self $array_map_filter;
    public function array_map_filter(iterable $array, callable $callback, $strict = false): self { }
    public function array_map_filter(callable $callback, $strict = false): self { }

    /** @see \array_map_filter() */
    public self $map_filter;
    public function map_filter(iterable $array, callable $callback, $strict = false): self { }
    public function map_filter(callable $callback, $strict = false): self { }

    /** @see \array_filter_map() */
    public self $array_filter_map;
    public function array_filter_map(iterable $array, callable $callback): self { }
    public function array_filter_map(callable $callback): self { }

    /** @see \array_filter_map() */
    public self $filter_map;
    public function filter_map(iterable $array, callable $callback): self { }
    public function filter_map(callable $callback): self { }

    /** @see \array_map_method() */
    public self $array_map_method;
    public function array_map_method(iterable $array, $method, $args = [], $ignore = false): self { }
    public function array_map_method($method, $args = [], $ignore = false): self { }

    /** @see \array_map_method() */
    public self $map_method;
    public function map_method(iterable $array, $method, $args = [], $ignore = false): self { }
    public function map_method($method, $args = [], $ignore = false): self { }

    /** @see \array_maps() */
    public self $array_maps;
    public function array_maps(iterable $array, callable ...$callbacks): self { }
    public function array_maps(callable ...$callbacks): self { }

    /** @see \array_maps() */
    public self $maps;
    public function maps(iterable $array, callable ...$callbacks): self { }
    public function maps(callable ...$callbacks): self { }

    /** @see \array_filters() */
    public self $array_filters;
    public function array_filters(iterable $array, callable ...$callbacks): self { }
    public function array_filters(callable ...$callbacks): self { }

    /** @see \array_filters() */
    public self $filters;
    public function filters(iterable $array, callable ...$callbacks): self { }
    public function filters(callable ...$callbacks): self { }

    /** @see \array_kvmap() */
    public self $array_kvmap;
    public function array_kvmap(iterable $array, callable $callback): self { }
    public function array_kvmap(callable $callback): self { }

    /** @see \array_kvmap() */
    public self $kvmap;
    public function kvmap(iterable $array, callable $callback): self { }
    public function kvmap(callable $callback): self { }

    /** @see \array_kmap() */
    public self $array_kmap;
    public function array_kmap(iterable $array, callable $callback): self { }
    public function array_kmap(callable $callback): self { }

    /** @see \array_kmap() */
    public self $kmap;
    public function kmap(iterable $array, callable $callback): self { }
    public function kmap(callable $callback): self { }

    /** @see \array_nmap() */
    public self $array_nmap;
    public function array_nmap(iterable $array, callable $callback, $n, ...$variadic): self { }
    public function array_nmap(callable $callback, $n, ...$variadic): self { }

    /** @see \array_nmap() */
    public self $nmap;
    public function nmap(iterable $array, callable $callback, $n, ...$variadic): self { }
    public function nmap(callable $callback, $n, ...$variadic): self { }

    /** @see \array_lmap() */
    public self $array_lmap;
    public function array_lmap(iterable $array, callable $callback, ...$variadic): self { }
    public function array_lmap(callable $callback, ...$variadic): self { }

    /** @see \array_lmap() */
    public self $lmap;
    public function lmap(iterable $array, callable $callback, ...$variadic): self { }
    public function lmap(callable $callback, ...$variadic): self { }

    /** @see \array_rmap() */
    public self $array_rmap;
    public function array_rmap(iterable $array, callable $callback, ...$variadic): self { }
    public function array_rmap(callable $callback, ...$variadic): self { }

    /** @see \array_rmap() */
    public self $rmap;
    public function rmap(iterable $array, callable $callback, ...$variadic): self { }
    public function rmap(callable $callback, ...$variadic): self { }

    /** @see \array_each() */
    public self $array_each;
    public function array_each(iterable $array, callable $callback, $default = null): self { }
    public function array_each(callable $callback, $default = null): self { }

    /** @see \array_each() */
    public self $each;
    public function each(iterable $array, callable $callback, $default = null): self { }
    public function each(callable $callback, $default = null): self { }

    /** @see \array_depth() */
    public self $array_depth;
    public function array_depth(iterable $array, $max_depth = null): self { }
    public function array_depth($max_depth = null): self { }

    /** @see \array_depth() */
    public self $depth;
    public function depth(iterable $array, $max_depth = null): self { }
    public function depth($max_depth = null): self { }

    /** @see \array_insert() */
    public self $array_insert;
    public function array_insert(iterable $array, $value, $position = null): self { }
    public function array_insert($value, $position = null): self { }

    /** @see \array_insert() */
    public self $insert;
    public function insert(iterable $array, $value, $position = null): self { }
    public function insert($value, $position = null): self { }

    /** @see \array_assort() */
    public self $array_assort;
    public function array_assort(iterable $array, $rules): self { }
    public function array_assort($rules): self { }

    /** @see \array_assort() */
    public self $assort;
    public function assort(iterable $array, $rules): self { }
    public function assort($rules): self { }

    /** @see \array_rank() */
    public self $array_rank;
    public function array_rank(iterable $array, $length, $rankfunction = null): self { }
    public function array_rank($length, $rankfunction = null): self { }

    /** @see \array_rank() */
    public self $rank;
    public function rank(iterable $array, $length, $rankfunction = null): self { }
    public function rank($length, $rankfunction = null): self { }

    /** @see \array_count() */
    public self $array_count;
    public function array_count(iterable $array, callable $callback, $recursive = false): self { }
    public function array_count(callable $callback, $recursive = false): self { }

    /** @see \array_count() */
    public self $count;
    public function count(iterable $array, callable $callback, $recursive = false): self { }
    public function count(callable $callback, $recursive = false): self { }

    /** @see \array_group() */
    public self $array_group;
    public function array_group(iterable $array, callable $callback = null, $preserve_keys = false): self { }
    public function array_group(callable $callback = null, $preserve_keys = false): self { }

    /** @see \array_group() */
    public self $group;
    public function group(iterable $array, callable $callback = null, $preserve_keys = false): self { }
    public function group(callable $callback = null, $preserve_keys = false): self { }

    /** @see \array_aggregate() */
    public self $array_aggregate;
    public function array_aggregate(iterable $array, $columns, $key = null): self { }
    public function array_aggregate($columns, $key = null): self { }

    /** @see \array_aggregate() */
    public self $aggregate;
    public function aggregate(iterable $array, $columns, $key = null): self { }
    public function aggregate($columns, $key = null): self { }

    /** @see \array_all() */
    public self $array_all;
    public function array_all(iterable $array, callable $callback = null, $default = true): self { }
    public function array_all(callable $callback = null, $default = true): self { }

    /** @see \array_all() */
    public self $all;
    public function all(iterable $array, callable $callback = null, $default = true): self { }
    public function all(callable $callback = null, $default = true): self { }

    /** @see \array_any() */
    public self $array_any;
    public function array_any(iterable $array, callable $callback = null, $default = false): self { }
    public function array_any(callable $callback = null, $default = false): self { }

    /** @see \array_any() */
    public self $any;
    public function any(iterable $array, callable $callback = null, $default = false): self { }
    public function any(callable $callback = null, $default = false): self { }

    /** @see \array_distinct() */
    public self $array_distinct;
    public function array_distinct(iterable $array, $comparator = null): self { }
    public function array_distinct($comparator = null): self { }

    /** @see \array_distinct() */
    public self $distinct;
    public function distinct(iterable $array, $comparator = null): self { }
    public function distinct($comparator = null): self { }

    /** @see \array_order() */
    public self $array_order;
    public function array_order(array $array, $orders, $preserve_keys = false): self { }
    public function array_order($orders, $preserve_keys = false): self { }

    /** @see \array_order() */
    public self $order;
    public function order(array $array, $orders, $preserve_keys = false): self { }
    public function order($orders, $preserve_keys = false): self { }

    /** @see \array_shuffle() */
    public self $array_shuffle;
    public function array_shuffle(iterable $array): self { }
    public function array_shuffle(): self { }

    /** @see \array_shuffle() */
    public self $shuffle;
    public function shuffle(iterable $array): self { }
    public function shuffle(): self { }

    /** @see \array_random() */
    public self $array_random;
    public function array_random(iterable $array, $count = null, $preserve_keys = false): self { }
    public function array_random($count = null, $preserve_keys = false): self { }

    /** @see \array_random() */
    public self $random;
    public function random(iterable $array, $count = null, $preserve_keys = false): self { }
    public function random($count = null, $preserve_keys = false): self { }

    /** @see \array_shrink_key() */
    public self $array_shrink_key;
    public function array_shrink_key(...$variadic): self { }
    public function array_shrink_key(): self { }

    /** @see \array_shrink_key() */
    public self $shrink_key;
    public function shrink_key(...$variadic): self { }
    public function shrink_key(): self { }

    /** @see \array_revise() */
    public self $array_revise;
    public function array_revise(iterable $array, ...$maps): self { }
    public function array_revise(...$maps): self { }

    /** @see \array_revise() */
    public self $revise;
    public function revise(iterable $array, ...$maps): self { }
    public function revise(...$maps): self { }

    /** @see \array_extend() */
    public self $array_extend;
    public function array_extend($default = [], iterable ...$arrays): self { }
    public function array_extend(iterable ...$arrays): self { }

    /** @see \array_extend() */
    public self $extend;
    public function extend($default = [], iterable ...$arrays): self { }
    public function extend(iterable ...$arrays): self { }

    /** @see \array_fill_gap() */
    public self $array_fill_gap;
    public function array_fill_gap(iterable $array, ...$values): self { }
    public function array_fill_gap(...$values): self { }

    /** @see \array_fill_gap() */
    public self $fill_gap;
    public function fill_gap(iterable $array, ...$values): self { }
    public function fill_gap(...$values): self { }

    /** @see \array_fill_callback() */
    public self $array_fill_callback;
    public function array_fill_callback($keys, callable $callback): self { }
    public function array_fill_callback(callable $callback): self { }

    /** @see \array_fill_callback() */
    public self $fill_callback;
    public function fill_callback($keys, callable $callback): self { }
    public function fill_callback(callable $callback): self { }

    /** @see \array_pickup() */
    public self $array_pickup;
    public function array_pickup(iterable $array, $keys): self { }
    public function array_pickup($keys): self { }

    /** @see \array_pickup() */
    public self $pickup;
    public function pickup(iterable $array, $keys): self { }
    public function pickup($keys): self { }

    /** @see \array_remove() */
    public self $array_remove;
    public function array_remove(iterable $array, $keys): self { }
    public function array_remove($keys): self { }

    /** @see \array_remove() */
    public self $remove;
    public function remove(iterable $array, $keys): self { }
    public function remove($keys): self { }

    /** @see \array_lookup() */
    public self $array_lookup;
    public function array_lookup(iterable $array, $column_key = null, $index_key = null): self { }
    public function array_lookup($column_key = null, $index_key = null): self { }

    /** @see \array_lookup() */
    public self $lookup;
    public function lookup(iterable $array, $column_key = null, $index_key = null): self { }
    public function lookup($column_key = null, $index_key = null): self { }

    /** @see \array_select() */
    public self $array_select;
    public function array_select(iterable $array, $columns, $index = null): self { }
    public function array_select($columns, $index = null): self { }

    /** @see \array_select() */
    public self $select;
    public function select(iterable $array, $columns, $index = null): self { }
    public function select($columns, $index = null): self { }

    /** @see \array_columns() */
    public self $array_columns;
    public function array_columns(iterable $array, $column_keys = null, $index_key = null): self { }
    public function array_columns($column_keys = null, $index_key = null): self { }

    /** @see \array_columns() */
    public self $columns;
    public function columns(iterable $array, $column_keys = null, $index_key = null): self { }
    public function columns($column_keys = null, $index_key = null): self { }

    /** @see \array_uncolumns() */
    public self $array_uncolumns;
    public function array_uncolumns(iterable $array, $template = null): self { }
    public function array_uncolumns($template = null): self { }

    /** @see \array_uncolumns() */
    public self $uncolumns;
    public function uncolumns(iterable $array, $template = null): self { }
    public function uncolumns($template = null): self { }

    /** @see \array_convert() */
    public self $array_convert;
    public function array_convert(iterable $array, callable $callback, iterable $apply_array = false): self { }
    public function array_convert(callable $callback, iterable $apply_array = false): self { }

    /** @see \array_convert() */
    public self $convert;
    public function convert(iterable $array, callable $callback, iterable $apply_array = false): self { }
    public function convert(callable $callback, iterable $apply_array = false): self { }

    /** @see \array_flatten() */
    public self $array_flatten;
    public function array_flatten(iterable $array, $delimiter = null): self { }
    public function array_flatten($delimiter = null): self { }

    /** @see \array_flatten() */
    public self $flatten;
    public function flatten(iterable $array, $delimiter = null): self { }
    public function flatten($delimiter = null): self { }

    /** @see \array_nest() */
    public self $array_nest;
    public function array_nest(iterable $array, $delimiter = "."): self { }
    public function array_nest($delimiter = "."): self { }

    /** @see \array_nest() */
    public self $nest;
    public function nest(iterable $array, $delimiter = "."): self { }
    public function nest($delimiter = "."): self { }

    /** @see \array_difference() */
    public self $array_difference;
    public function array_difference(iterable $array1, iterable $array2, $delimiter = "."): self { }
    public function array_difference(iterable $array2, $delimiter = "."): self { }

    /** @see \array_difference() */
    public self $difference;
    public function difference(iterable $array1, iterable $array2, $delimiter = "."): self { }
    public function difference(iterable $array2, $delimiter = "."): self { }

    /** @see \array_schema() */
    public self $array_schema;
    public function array_schema($schema, iterable ...$arrays): self { }
    public function array_schema(iterable ...$arrays): self { }

    /** @see \array_schema() */
    public self $schema;
    public function schema($schema, iterable ...$arrays): self { }
    public function schema(iterable ...$arrays): self { }

    /** @see \auto_loader() */
    public self $auto_loader;
    public function auto_loader($startdir = null): self { }
    public function auto_loader(): self { }

    /** @see \abind() */
    public self $abind;
    public function abind(callable $callable, $default_args): self { }
    public function abind($default_args): self { }

    /** @see \average() */
    public self $average;
    public function average(...$variadic): self { }
    public function average(): self { }

    /** @see \ansi_colorize() */
    public self $ansi_colorize;
    public function ansi_colorize($string, $color): self { }
    public function ansi_colorize($color): self { }

    /** @see \ansi_strip() */
    public self $ansi_strip;
    public function ansi_strip($string): self { }
    public function ansi_strip(): self { }

    /** @see \arguments() */
    public self $arguments;
    public function arguments($rule, $argv = null): self { }
    public function arguments($argv = null): self { }

    /** @see \add_error_handler() */
    public self $add_error_handler;
    public function add_error_handler($handler, $error_types = 32767): self { }
    public function add_error_handler($error_types = 32767): self { }

    /** @see \arrayval() */
    public self $arrayval;
    public function arrayval($var, $recursive = true): self { }
    public function arrayval($recursive = true): self { }

    /** @see \arrayable_key_exists() */
    public self $arrayable_key_exists;
    public function arrayable_key_exists($key, iterable $arrayable): self { }
    public function arrayable_key_exists(iterable $arrayable): self { }

    /** @see \attr_exists() */
    public self $attr_exists;
    public function attr_exists($key, $value): self { }
    public function attr_exists($value): self { }

    /** @see \attr_get() */
    public self $attr_get;
    public function attr_get($key, $value, $default = null): self { }
    public function attr_get($value, $default = null): self { }

}
