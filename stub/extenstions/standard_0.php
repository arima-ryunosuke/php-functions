<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait standard_0
{
    /** @see \abs() */
    public self $abs;
    public function abs(int|float $num): self { }
    public function abs0(): self { }

    /** @see \acos() */
    public self $acos;
    public function acos(float $num): self { }
    public function acos0(): self { }

    /** @see \acosh() */
    public self $acosh;
    public function acosh(float $num): self { }
    public function acosh0(): self { }

    /** @see \addcslashes() */
    public function addcslashes(string $string, string $characters): self { }
    public function addcslashes0(string $characters): self { }
    public function addcslashes1(string $string): self { }

    /** @see \addslashes() */
    public self $addslashes;
    public function addslashes(string $string): self { }
    public function addslashes0(): self { }

    /** @see \array_change_key_case() */
    public self $array_change_key_case;
    public function array_change_key_case(array $array, int $case = CASE_LOWER): self { }
    public function array_change_key_case0(int $case = CASE_LOWER): self { }
    public function array_change_key_case1(array $array): self { }

    /** @see \array_change_key_case() */
    public self $change_key_case;
    public function change_key_case(array $array, int $case = CASE_LOWER): self { }
    public function change_key_case0(int $case = CASE_LOWER): self { }
    public function change_key_case1(array $array): self { }

    /** @see \array_chunk() */
    public function array_chunk(array $array, int $length, bool $preserve_keys = false): self { }
    public function array_chunk0(int $length, bool $preserve_keys = false): self { }
    public function array_chunk1(array $array, bool $preserve_keys = false): self { }
    public function array_chunk2(array $array, int $length): self { }

    /** @see \array_chunk() */
    public function chunk(array $array, int $length, bool $preserve_keys = false): self { }
    public function chunk0(int $length, bool $preserve_keys = false): self { }
    public function chunk1(array $array, bool $preserve_keys = false): self { }
    public function chunk2(array $array, int $length): self { }

    /** @see \array_column() */
    public function array_column(array $array, string|int|null $column_key, string|int|null $index_key = null): self { }
    public function array_column0(string|int|null $column_key, string|int|null $index_key = null): self { }
    public function array_column1(array $array, string|int|null $index_key = null): self { }
    public function array_column2(array $array, string|int|null $column_key): self { }

    /** @see \array_column() */
    public function column(array $array, string|int|null $column_key, string|int|null $index_key = null): self { }
    public function column0(string|int|null $column_key, string|int|null $index_key = null): self { }
    public function column1(array $array, string|int|null $index_key = null): self { }
    public function column2(array $array, string|int|null $column_key): self { }

    /** @see \array_combine() */
    public function array_combine(array $keys, array $values): self { }
    public function array_combine0(array $values): self { }
    public function array_combine1(array $keys): self { }

    /** @see \array_combine() */
    public function combine(array $keys, array $values): self { }
    public function combine0(array $values): self { }
    public function combine1(array $keys): self { }

    /** @see \array_count_values() */
    public self $array_count_values;
    public function array_count_values(array $array): self { }
    public function array_count_values0(): self { }

    /** @see \array_count_values() */
    public self $count_values;
    public function count_values(array $array): self { }
    public function count_values0(): self { }

    /** @see \array_diff() */
    public self $array_diff;
    public function array_diff(array $array, array ...$arrays): self { }
    public function array_diff0(array ...$arrays): self { }
    public function array_diff1(array $array): self { }

    /** @see \array_diff() */
    public self $diff;
    public function diff(array $array, array ...$arrays): self { }
    public function diff0(array ...$arrays): self { }
    public function diff1(array $array): self { }

    /** @see \array_diff_assoc() */
    public self $array_diff_assoc;
    public function array_diff_assoc(array $array, array ...$arrays): self { }
    public function array_diff_assoc0(array ...$arrays): self { }
    public function array_diff_assoc1(array $array): self { }

    /** @see \array_diff_assoc() */
    public self $diff_assoc;
    public function diff_assoc(array $array, array ...$arrays): self { }
    public function diff_assoc0(array ...$arrays): self { }
    public function diff_assoc1(array $array): self { }

    /** @see \array_diff_key() */
    public self $array_diff_key;
    public function array_diff_key(array $array, array ...$arrays): self { }
    public function array_diff_key0(array ...$arrays): self { }
    public function array_diff_key1(array $array): self { }

    /** @see \array_diff_key() */
    public self $diff_key;
    public function diff_key(array $array, array ...$arrays): self { }
    public function diff_key0(array ...$arrays): self { }
    public function diff_key1(array $array): self { }

    /** @see \array_diff_uassoc() */
    public self $array_diff_uassoc;
    public function array_diff_uassoc(array $array, ...$rest): self { }
    public function array_diff_uassoc0(...$rest): self { }
    public function array_diff_uassoc1(array $array): self { }

    /** @see \array_diff_uassoc() */
    public self $diff_uassoc;
    public function diff_uassoc(array $array, ...$rest): self { }
    public function diff_uassoc0(...$rest): self { }
    public function diff_uassoc1(array $array): self { }

    /** @see \array_diff_ukey() */
    public self $array_diff_ukey;
    public function array_diff_ukey(array $array, ...$rest): self { }
    public function array_diff_ukey0(...$rest): self { }
    public function array_diff_ukey1(array $array): self { }

    /** @see \array_diff_ukey() */
    public self $diff_ukey;
    public function diff_ukey(array $array, ...$rest): self { }
    public function diff_ukey0(...$rest): self { }
    public function diff_ukey1(array $array): self { }

    /** @see \array_fill() */
    public function array_fill(int $start_index, int $count, mixed $value): self { }
    public function array_fill0(int $count, mixed $value): self { }
    public function array_fill1(int $start_index, mixed $value): self { }
    public function array_fill2(int $start_index, int $count): self { }

    /** @see \array_fill() */
    public function fill(int $start_index, int $count, mixed $value): self { }
    public function fill0(int $count, mixed $value): self { }
    public function fill1(int $start_index, mixed $value): self { }
    public function fill2(int $start_index, int $count): self { }

    /** @see \array_fill_keys() */
    public function array_fill_keys(array $keys, mixed $value): self { }
    public function array_fill_keys0(mixed $value): self { }
    public function array_fill_keys1(array $keys): self { }

    /** @see \array_fill_keys() */
    public function fill_keys(array $keys, mixed $value): self { }
    public function fill_keys0(mixed $value): self { }
    public function fill_keys1(array $keys): self { }

    /** @see \array_filter() */
    public self $array_filter;
    public function array_filter(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function array_filter0(?callable $callback = null, int $mode = 0): self { }
    public function array_filter1(array $array, int $mode = 0): self { }
    public function array_filter2(array $array, ?callable $callback = null): self { }
    public function array_filterP(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function array_filter0P(?callable $callback = null, int $mode = 0): self { }
    public function array_filter1P(array $array, int $mode = 0): self { }
    public function array_filter2P(array $array, ?callable $callback = null): self { }
    public function array_filterE(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function array_filter0E(?callable $callback = null, int $mode = 0): self { }
    public function array_filter1E(array $array, int $mode = 0): self { }
    public function array_filter2E(array $array, ?callable $callback = null): self { }

    /** @see \array_filter() */
    public self $filter;
    public function filter(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function filter0(?callable $callback = null, int $mode = 0): self { }
    public function filter1(array $array, int $mode = 0): self { }
    public function filter2(array $array, ?callable $callback = null): self { }
    public function filterP(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function filter0P(?callable $callback = null, int $mode = 0): self { }
    public function filter1P(array $array, int $mode = 0): self { }
    public function filter2P(array $array, ?callable $callback = null): self { }
    public function filterE(array $array, ?callable $callback = null, int $mode = 0): self { }
    public function filter0E(?callable $callback = null, int $mode = 0): self { }
    public function filter1E(array $array, int $mode = 0): self { }
    public function filter2E(array $array, ?callable $callback = null): self { }

    /** @see \array_flip() */
    public self $array_flip;
    public function array_flip(array $array): self { }
    public function array_flip0(): self { }

    /** @see \array_flip() */
    public self $flip;
    public function flip(array $array): self { }
    public function flip0(): self { }

    /** @see \array_intersect() */
    public self $array_intersect;
    public function array_intersect(array $array, array ...$arrays): self { }
    public function array_intersect0(array ...$arrays): self { }
    public function array_intersect1(array $array): self { }

    /** @see \array_intersect() */
    public self $intersect;
    public function intersect(array $array, array ...$arrays): self { }
    public function intersect0(array ...$arrays): self { }
    public function intersect1(array $array): self { }

    /** @see \array_intersect_assoc() */
    public self $array_intersect_assoc;
    public function array_intersect_assoc(array $array, array ...$arrays): self { }
    public function array_intersect_assoc0(array ...$arrays): self { }
    public function array_intersect_assoc1(array $array): self { }

    /** @see \array_intersect_assoc() */
    public self $intersect_assoc;
    public function intersect_assoc(array $array, array ...$arrays): self { }
    public function intersect_assoc0(array ...$arrays): self { }
    public function intersect_assoc1(array $array): self { }

    /** @see \array_intersect_key() */
    public self $array_intersect_key;
    public function array_intersect_key(array $array, array ...$arrays): self { }
    public function array_intersect_key0(array ...$arrays): self { }
    public function array_intersect_key1(array $array): self { }

    /** @see \array_intersect_key() */
    public self $intersect_key;
    public function intersect_key(array $array, array ...$arrays): self { }
    public function intersect_key0(array ...$arrays): self { }
    public function intersect_key1(array $array): self { }

    /** @see \array_intersect_uassoc() */
    public self $array_intersect_uassoc;
    public function array_intersect_uassoc(array $array, ...$rest): self { }
    public function array_intersect_uassoc0(...$rest): self { }
    public function array_intersect_uassoc1(array $array): self { }

    /** @see \array_intersect_uassoc() */
    public self $intersect_uassoc;
    public function intersect_uassoc(array $array, ...$rest): self { }
    public function intersect_uassoc0(...$rest): self { }
    public function intersect_uassoc1(array $array): self { }

    /** @see \array_intersect_ukey() */
    public self $array_intersect_ukey;
    public function array_intersect_ukey(array $array, ...$rest): self { }
    public function array_intersect_ukey0(...$rest): self { }
    public function array_intersect_ukey1(array $array): self { }

    /** @see \array_intersect_ukey() */
    public self $intersect_ukey;
    public function intersect_ukey(array $array, ...$rest): self { }
    public function intersect_ukey0(...$rest): self { }
    public function intersect_ukey1(array $array): self { }

    /** @see \array_key_exists() */
    public function array_key_exists($key, array $array): self { }
    public function array_key_exists0(array $array): self { }
    public function array_key_exists1($key): self { }

    /** @see \array_key_exists() */
    public function key_exists($key, array $array): self { }
    public function key_exists0(array $array): self { }
    public function key_exists1($key): self { }

    /** @see \array_key_first() */
    public self $array_key_first;
    public function array_key_first(array $array): self { }
    public function array_key_first0(): self { }

    /** @see \array_key_first() */
    public self $key_first;
    public function key_first(array $array): self { }
    public function key_first0(): self { }

    /** @see \array_key_last() */
    public self $array_key_last;
    public function array_key_last(array $array): self { }
    public function array_key_last0(): self { }

    /** @see \array_key_last() */
    public self $key_last;
    public function key_last(array $array): self { }
    public function key_last0(): self { }

    /** @see \array_keys() */
    public self $array_keys;
    public function array_keys(array $array, mixed $filter_value, bool $strict = false): self { }
    public function array_keys0(mixed $filter_value, bool $strict = false): self { }
    public function array_keys1(array $array, bool $strict = false): self { }
    public function array_keys2(array $array, mixed $filter_value): self { }

    /** @see \array_keys() */
    public self $keys;
    public function keys(array $array, mixed $filter_value, bool $strict = false): self { }
    public function keys0(mixed $filter_value, bool $strict = false): self { }
    public function keys1(array $array, bool $strict = false): self { }
    public function keys2(array $array, mixed $filter_value): self { }

    /** @see \array_map() */
    public function array_map(?callable $callback, array $array, array ...$arrays): self { }
    public function array_map0(array $array, array ...$arrays): self { }
    public function array_map1(?callable $callback, array ...$arrays): self { }
    public function array_map2(?callable $callback, array $array): self { }
    public function array_mapP(?callable $callback, array $array, array ...$arrays): self { }
    public function array_map0P(array $array, array ...$arrays): self { }
    public function array_map1P(?callable $callback, array ...$arrays): self { }
    public function array_map2P(?callable $callback, array $array): self { }
    public function array_mapE(?callable $callback, array $array, array ...$arrays): self { }
    public function array_map0E(array $array, array ...$arrays): self { }
    public function array_map1E(?callable $callback, array ...$arrays): self { }
    public function array_map2E(?callable $callback, array $array): self { }

    /** @see \array_map() */
    public function map(?callable $callback, array $array, array ...$arrays): self { }
    public function map0(array $array, array ...$arrays): self { }
    public function map1(?callable $callback, array ...$arrays): self { }
    public function map2(?callable $callback, array $array): self { }
    public function mapP(?callable $callback, array $array, array ...$arrays): self { }
    public function map0P(array $array, array ...$arrays): self { }
    public function map1P(?callable $callback, array ...$arrays): self { }
    public function map2P(?callable $callback, array $array): self { }
    public function mapE(?callable $callback, array $array, array ...$arrays): self { }
    public function map0E(array $array, array ...$arrays): self { }
    public function map1E(?callable $callback, array ...$arrays): self { }
    public function map2E(?callable $callback, array $array): self { }

    /** @see \array_merge() */
    public function array_merge(array ...$arrays): self { }
    public function array_merge0(): self { }

    /** @see \array_merge() */
    public function merge(array ...$arrays): self { }
    public function merge0(): self { }

    /** @see \array_merge_recursive() */
    public function array_merge_recursive(array ...$arrays): self { }
    public function array_merge_recursive0(): self { }

    /** @see \array_merge_recursive() */
    public function merge_recursive(array ...$arrays): self { }
    public function merge_recursive0(): self { }

    /** @see \array_pad() */
    public function array_pad(array $array, int $length, mixed $value): self { }
    public function array_pad0(int $length, mixed $value): self { }
    public function array_pad1(array $array, mixed $value): self { }
    public function array_pad2(array $array, int $length): self { }

    /** @see \array_pad() */
    public function pad(array $array, int $length, mixed $value): self { }
    public function pad0(int $length, mixed $value): self { }
    public function pad1(array $array, mixed $value): self { }
    public function pad2(array $array, int $length): self { }

    /** @see \array_product() */
    public self $array_product;
    public function array_product(array $array): self { }
    public function array_product0(): self { }

    /** @see \array_product() */
    public self $product;
    public function product(array $array): self { }
    public function product0(): self { }

    /** @see \array_push() */
    public self $array_push;
    public function array_push(array &$array, mixed ...$values): self { }
    public function array_push0(mixed ...$values): self { }
    public function array_push1(array &$array): self { }

    /** @see \array_push() */
    public self $push;
    public function push(array &$array, mixed ...$values): self { }
    public function push0(mixed ...$values): self { }
    public function push1(array &$array): self { }

    /** @see \array_rand() */
    public self $array_rand;
    public function array_rand(array $array, int $num = 1): self { }
    public function array_rand0(int $num = 1): self { }
    public function array_rand1(array $array): self { }

}
