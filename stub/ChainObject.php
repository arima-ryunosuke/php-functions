<?php
// @formatter:off

/**
 * chain 関数のためのクラススタブ
 *
 * {annotation}
 * @see abind
 * @method   \ChainObject  abind($default_args)
 * @method   \ChainObject  abind1($callable)
 * @method   \ChainObject  abindP($default_args)
 * @method   \ChainObject  abindP1($callable)
 * @method   \ChainObject  abindE($default_args)
 * @method   \ChainObject  abindE1($callable)
 *
 * @see abs
 * @property \ChainObject $abs
 * @method   \ChainObject  abs()
 *
 * @see acos
 * @property \ChainObject $acos
 * @method   \ChainObject  acos()
 *
 * @see acosh
 * @property \ChainObject $acosh
 * @method   \ChainObject  acosh()
 *
 * @see add_error_handler
 * @property \ChainObject $add_error_handler
 * @method   \ChainObject  add_error_handler($error_types = 32767)
 * @method   \ChainObject  add_error_handler1($handler)
 *
 * @see addcslashes
 * @method   \ChainObject  addcslashes(string $characters)
 * @method   \ChainObject  addcslashes1(string $string)
 *
 * @see addslashes
 * @property \ChainObject $addslashes
 * @method   \ChainObject  addslashes()
 *
 * @see ansi_colorize
 * @method   \ChainObject  ansi_colorize($color)
 * @method   \ChainObject  ansi_colorize1($string)
 *
 * @see arguments
 * @property \ChainObject $arguments
 * @method   \ChainObject  arguments($argv = null)
 * @method   \ChainObject  arguments1($rule)
 *
 * @see array_add
 * @method   \ChainObject  array_add(...$variadic)
 * @method   \ChainObject  array_add1(...$variadic)
 * @method   \ChainObject  array_add2(...$variadic)
 * @method   \ChainObject  array_add3(...$variadic)
 * @method   \ChainObject  array_add4(...$variadic)
 * @method   \ChainObject  array_add5(...$variadic)
 *
 * @see array_add
 * @method   \ChainObject  add(...$variadic)
 * @method   \ChainObject  add1(...$variadic)
 * @method   \ChainObject  add2(...$variadic)
 * @method   \ChainObject  add3(...$variadic)
 * @method   \ChainObject  add4(...$variadic)
 * @method   \ChainObject  add5(...$variadic)
 *
 * @see array_aggregate
 * @method   \ChainObject  array_aggregate($columns, $key = null)
 * @method   \ChainObject  array_aggregate1($array, $key = null)
 * @method   \ChainObject  array_aggregate2($array, $columns)
 *
 * @see array_aggregate
 * @method   \ChainObject  aggregate($columns, $key = null)
 * @method   \ChainObject  aggregate1($array, $key = null)
 * @method   \ChainObject  aggregate2($array, $columns)
 *
 * @see array_all
 * @property \ChainObject $array_all
 * @method   \ChainObject  array_all($callback = null, $default = true)
 * @method   \ChainObject  array_all1($array, $default = true)
 * @method   \ChainObject  array_all2($array, $callback = null)
 * @method   \ChainObject  array_allP($callback = null, $default = true)
 * @method   \ChainObject  array_allP1($array, $default = true)
 * @method   \ChainObject  array_allP2($array, $callback = null)
 * @method   \ChainObject  array_allE($callback = null, $default = true)
 * @method   \ChainObject  array_allE1($array, $default = true)
 * @method   \ChainObject  array_allE2($array, $callback = null)
 *
 * @see array_all
 * @property \ChainObject $all
 * @method   \ChainObject  all($callback = null, $default = true)
 * @method   \ChainObject  all1($array, $default = true)
 * @method   \ChainObject  all2($array, $callback = null)
 * @method   \ChainObject  allP($callback = null, $default = true)
 * @method   \ChainObject  allP1($array, $default = true)
 * @method   \ChainObject  allP2($array, $callback = null)
 * @method   \ChainObject  allE($callback = null, $default = true)
 * @method   \ChainObject  allE1($array, $default = true)
 * @method   \ChainObject  allE2($array, $callback = null)
 *
 * @see array_any
 * @property \ChainObject $array_any
 * @method   \ChainObject  array_any($callback = null, $default = false)
 * @method   \ChainObject  array_any1($array, $default = false)
 * @method   \ChainObject  array_any2($array, $callback = null)
 * @method   \ChainObject  array_anyP($callback = null, $default = false)
 * @method   \ChainObject  array_anyP1($array, $default = false)
 * @method   \ChainObject  array_anyP2($array, $callback = null)
 * @method   \ChainObject  array_anyE($callback = null, $default = false)
 * @method   \ChainObject  array_anyE1($array, $default = false)
 * @method   \ChainObject  array_anyE2($array, $callback = null)
 *
 * @see array_any
 * @property \ChainObject $any
 * @method   \ChainObject  any($callback = null, $default = false)
 * @method   \ChainObject  any1($array, $default = false)
 * @method   \ChainObject  any2($array, $callback = null)
 * @method   \ChainObject  anyP($callback = null, $default = false)
 * @method   \ChainObject  anyP1($array, $default = false)
 * @method   \ChainObject  anyP2($array, $callback = null)
 * @method   \ChainObject  anyE($callback = null, $default = false)
 * @method   \ChainObject  anyE1($array, $default = false)
 * @method   \ChainObject  anyE2($array, $callback = null)
 *
 * @see array_append
 * @method   \ChainObject  array_append($value, $key = null)
 * @method   \ChainObject  array_append1($array, $key = null)
 * @method   \ChainObject  array_append2($array, $value)
 *
 * @see array_append
 * @method   \ChainObject  append($value, $key = null)
 * @method   \ChainObject  append1($array, $key = null)
 * @method   \ChainObject  append2($array, $value)
 *
 * @see array_assort
 * @method   \ChainObject  array_assort($rules)
 * @method   \ChainObject  array_assort1($array)
 *
 * @see array_assort
 * @method   \ChainObject  assort($rules)
 * @method   \ChainObject  assort1($array)
 *
 * @see array_change_key_case
 * @property \ChainObject $array_change_key_case
 * @method   \ChainObject  array_change_key_case(int $case = CASE_LOWER)
 * @method   \ChainObject  array_change_key_case1(array $array)
 *
 * @see array_change_key_case
 * @property \ChainObject $change_key_case
 * @method   \ChainObject  change_key_case(int $case = CASE_LOWER)
 * @method   \ChainObject  change_key_case1(array $array)
 *
 * @see array_chunk
 * @method   \ChainObject  array_chunk(int $length, bool $preserve_keys = false)
 * @method   \ChainObject  array_chunk1(array $array, bool $preserve_keys = false)
 * @method   \ChainObject  array_chunk2(array $array, int $length)
 *
 * @see array_chunk
 * @method   \ChainObject  chunk(int $length, bool $preserve_keys = false)
 * @method   \ChainObject  chunk1(array $array, bool $preserve_keys = false)
 * @method   \ChainObject  chunk2(array $array, int $length)
 *
 * @see array_column
 * @method   \ChainObject  array_column(string|int|null $column_key, string|int|null $index_key = null)
 * @method   \ChainObject  array_column1(array $array, string|int|null $index_key = null)
 * @method   \ChainObject  array_column2(array $array, string|int|null $column_key)
 *
 * @see array_column
 * @method   \ChainObject  column(string|int|null $column_key, string|int|null $index_key = null)
 * @method   \ChainObject  column1(array $array, string|int|null $index_key = null)
 * @method   \ChainObject  column2(array $array, string|int|null $column_key)
 *
 * @see array_columns
 * @property \ChainObject $array_columns
 * @method   \ChainObject  array_columns($column_keys = null, $index_key = null)
 * @method   \ChainObject  array_columns1($array, $index_key = null)
 * @method   \ChainObject  array_columns2($array, $column_keys = null)
 *
 * @see array_columns
 * @property \ChainObject $columns
 * @method   \ChainObject  columns($column_keys = null, $index_key = null)
 * @method   \ChainObject  columns1($array, $index_key = null)
 * @method   \ChainObject  columns2($array, $column_keys = null)
 *
 * @see array_combine
 * @method   \ChainObject  array_combine(array $values)
 * @method   \ChainObject  array_combine1(array $keys)
 *
 * @see array_combine
 * @method   \ChainObject  combine(array $values)
 * @method   \ChainObject  combine1(array $keys)
 *
 * @see array_convert
 * @method   \ChainObject  array_convert($callback, $apply_array = false)
 * @method   \ChainObject  array_convert1($array, $apply_array = false)
 * @method   \ChainObject  array_convert2($array, $callback)
 * @method   \ChainObject  array_convertP($callback, $apply_array = false)
 * @method   \ChainObject  array_convertP1($array, $apply_array = false)
 * @method   \ChainObject  array_convertP2($array, $callback)
 * @method   \ChainObject  array_convertE($callback, $apply_array = false)
 * @method   \ChainObject  array_convertE1($array, $apply_array = false)
 * @method   \ChainObject  array_convertE2($array, $callback)
 *
 * @see array_convert
 * @method   \ChainObject  convert($callback, $apply_array = false)
 * @method   \ChainObject  convert1($array, $apply_array = false)
 * @method   \ChainObject  convert2($array, $callback)
 * @method   \ChainObject  convertP($callback, $apply_array = false)
 * @method   \ChainObject  convertP1($array, $apply_array = false)
 * @method   \ChainObject  convertP2($array, $callback)
 * @method   \ChainObject  convertE($callback, $apply_array = false)
 * @method   \ChainObject  convertE1($array, $apply_array = false)
 * @method   \ChainObject  convertE2($array, $callback)
 *
 * @see array_count
 * @method   \ChainObject  array_count($callback, $recursive = false)
 * @method   \ChainObject  array_count1($array, $recursive = false)
 * @method   \ChainObject  array_count2($array, $callback)
 * @method   \ChainObject  array_countP($callback, $recursive = false)
 * @method   \ChainObject  array_countP1($array, $recursive = false)
 * @method   \ChainObject  array_countP2($array, $callback)
 * @method   \ChainObject  array_countE($callback, $recursive = false)
 * @method   \ChainObject  array_countE1($array, $recursive = false)
 * @method   \ChainObject  array_countE2($array, $callback)
 *
 * @see array_count_values
 * @property \ChainObject $array_count_values
 * @method   \ChainObject  array_count_values()
 *
 * @see array_count_values
 * @property \ChainObject $count_values
 * @method   \ChainObject  count_values()
 *
 * @see array_cross
 * @method   \ChainObject  array_cross(...$arrays)
 * @method   \ChainObject  array_cross1(...$arrays)
 * @method   \ChainObject  array_cross2(...$arrays)
 * @method   \ChainObject  array_cross3(...$arrays)
 * @method   \ChainObject  array_cross4(...$arrays)
 * @method   \ChainObject  array_cross5(...$arrays)
 *
 * @see array_cross
 * @method   \ChainObject  cross(...$arrays)
 * @method   \ChainObject  cross1(...$arrays)
 * @method   \ChainObject  cross2(...$arrays)
 * @method   \ChainObject  cross3(...$arrays)
 * @method   \ChainObject  cross4(...$arrays)
 * @method   \ChainObject  cross5(...$arrays)
 *
 * @see array_depth
 * @property \ChainObject $array_depth
 * @method   \ChainObject  array_depth($max_depth = null)
 * @method   \ChainObject  array_depth1($array)
 *
 * @see array_depth
 * @property \ChainObject $depth
 * @method   \ChainObject  depth($max_depth = null)
 * @method   \ChainObject  depth1($array)
 *
 * @see array_diff
 * @property \ChainObject $array_diff
 * @method   \ChainObject  array_diff(...array $arrays)
 * @method   \ChainObject  array_diff1(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff2(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff3(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff4(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff5(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff6(array $array, ...array $arrays)
 *
 * @see array_diff
 * @property \ChainObject $diff
 * @method   \ChainObject  diff(...array $arrays)
 * @method   \ChainObject  diff1(array $array, ...array $arrays)
 * @method   \ChainObject  diff2(array $array, ...array $arrays)
 * @method   \ChainObject  diff3(array $array, ...array $arrays)
 * @method   \ChainObject  diff4(array $array, ...array $arrays)
 * @method   \ChainObject  diff5(array $array, ...array $arrays)
 * @method   \ChainObject  diff6(array $array, ...array $arrays)
 *
 * @see array_diff_assoc
 * @property \ChainObject $array_diff_assoc
 * @method   \ChainObject  array_diff_assoc(...array $arrays)
 * @method   \ChainObject  array_diff_assoc1(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_assoc2(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_assoc3(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_assoc4(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_assoc5(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_assoc6(array $array, ...array $arrays)
 *
 * @see array_diff_assoc
 * @property \ChainObject $diff_assoc
 * @method   \ChainObject  diff_assoc(...array $arrays)
 * @method   \ChainObject  diff_assoc1(array $array, ...array $arrays)
 * @method   \ChainObject  diff_assoc2(array $array, ...array $arrays)
 * @method   \ChainObject  diff_assoc3(array $array, ...array $arrays)
 * @method   \ChainObject  diff_assoc4(array $array, ...array $arrays)
 * @method   \ChainObject  diff_assoc5(array $array, ...array $arrays)
 * @method   \ChainObject  diff_assoc6(array $array, ...array $arrays)
 *
 * @see array_diff_key
 * @property \ChainObject $array_diff_key
 * @method   \ChainObject  array_diff_key(...array $arrays)
 * @method   \ChainObject  array_diff_key1(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_key2(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_key3(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_key4(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_key5(array $array, ...array $arrays)
 * @method   \ChainObject  array_diff_key6(array $array, ...array $arrays)
 *
 * @see array_diff_key
 * @property \ChainObject $diff_key
 * @method   \ChainObject  diff_key(...array $arrays)
 * @method   \ChainObject  diff_key1(array $array, ...array $arrays)
 * @method   \ChainObject  diff_key2(array $array, ...array $arrays)
 * @method   \ChainObject  diff_key3(array $array, ...array $arrays)
 * @method   \ChainObject  diff_key4(array $array, ...array $arrays)
 * @method   \ChainObject  diff_key5(array $array, ...array $arrays)
 * @method   \ChainObject  diff_key6(array $array, ...array $arrays)
 *
 * @see array_diff_uassoc
 * @property \ChainObject $array_diff_uassoc
 * @method   \ChainObject  array_diff_uassoc(...$rest)
 * @method   \ChainObject  array_diff_uassoc1(array $array, ...$rest)
 * @method   \ChainObject  array_diff_uassoc2(array $array, ...$rest)
 * @method   \ChainObject  array_diff_uassoc3(array $array, ...$rest)
 * @method   \ChainObject  array_diff_uassoc4(array $array, ...$rest)
 * @method   \ChainObject  array_diff_uassoc5(array $array, ...$rest)
 * @method   \ChainObject  array_diff_uassoc6(array $array, ...$rest)
 *
 * @see array_diff_uassoc
 * @property \ChainObject $diff_uassoc
 * @method   \ChainObject  diff_uassoc(...$rest)
 * @method   \ChainObject  diff_uassoc1(array $array, ...$rest)
 * @method   \ChainObject  diff_uassoc2(array $array, ...$rest)
 * @method   \ChainObject  diff_uassoc3(array $array, ...$rest)
 * @method   \ChainObject  diff_uassoc4(array $array, ...$rest)
 * @method   \ChainObject  diff_uassoc5(array $array, ...$rest)
 * @method   \ChainObject  diff_uassoc6(array $array, ...$rest)
 *
 * @see array_diff_ukey
 * @property \ChainObject $array_diff_ukey
 * @method   \ChainObject  array_diff_ukey(...$rest)
 * @method   \ChainObject  array_diff_ukey1(array $array, ...$rest)
 * @method   \ChainObject  array_diff_ukey2(array $array, ...$rest)
 * @method   \ChainObject  array_diff_ukey3(array $array, ...$rest)
 * @method   \ChainObject  array_diff_ukey4(array $array, ...$rest)
 * @method   \ChainObject  array_diff_ukey5(array $array, ...$rest)
 * @method   \ChainObject  array_diff_ukey6(array $array, ...$rest)
 *
 * @see array_diff_ukey
 * @property \ChainObject $diff_ukey
 * @method   \ChainObject  diff_ukey(...$rest)
 * @method   \ChainObject  diff_ukey1(array $array, ...$rest)
 * @method   \ChainObject  diff_ukey2(array $array, ...$rest)
 * @method   \ChainObject  diff_ukey3(array $array, ...$rest)
 * @method   \ChainObject  diff_ukey4(array $array, ...$rest)
 * @method   \ChainObject  diff_ukey5(array $array, ...$rest)
 * @method   \ChainObject  diff_ukey6(array $array, ...$rest)
 *
 * @see array_difference
 * @method   \ChainObject  array_difference($array2, $delimiter = ".")
 * @method   \ChainObject  array_difference1($array1, $delimiter = ".")
 * @method   \ChainObject  array_difference2($array1, $array2)
 *
 * @see array_difference
 * @method   \ChainObject  difference($array2, $delimiter = ".")
 * @method   \ChainObject  difference1($array1, $delimiter = ".")
 * @method   \ChainObject  difference2($array1, $array2)
 *
 * @see array_distinct
 * @property \ChainObject $array_distinct
 * @method   \ChainObject  array_distinct($comparator = null)
 * @method   \ChainObject  array_distinct1($array)
 *
 * @see array_distinct
 * @property \ChainObject $distinct
 * @method   \ChainObject  distinct($comparator = null)
 * @method   \ChainObject  distinct1($array)
 *
 * @see array_dive
 * @method   \ChainObject  array_dive($path, $default = null, $delimiter = ".")
 * @method   \ChainObject  array_dive1($array, $default = null, $delimiter = ".")
 * @method   \ChainObject  array_dive2($array, $path, $delimiter = ".")
 * @method   \ChainObject  array_dive3($array, $path, $default = null)
 *
 * @see array_dive
 * @method   \ChainObject  dive($path, $default = null, $delimiter = ".")
 * @method   \ChainObject  dive1($array, $default = null, $delimiter = ".")
 * @method   \ChainObject  dive2($array, $path, $delimiter = ".")
 * @method   \ChainObject  dive3($array, $path, $default = null)
 *
 * @see array_each
 * @method   \ChainObject  array_each($callback, $default = null)
 * @method   \ChainObject  array_each1($array, $default = null)
 * @method   \ChainObject  array_each2($array, $callback)
 * @method   \ChainObject  array_eachP($callback, $default = null)
 * @method   \ChainObject  array_eachP1($array, $default = null)
 * @method   \ChainObject  array_eachP2($array, $callback)
 * @method   \ChainObject  array_eachE($callback, $default = null)
 * @method   \ChainObject  array_eachE1($array, $default = null)
 * @method   \ChainObject  array_eachE2($array, $callback)
 *
 * @see array_each
 * @method   \ChainObject  each($callback, $default = null)
 * @method   \ChainObject  each1($array, $default = null)
 * @method   \ChainObject  each2($array, $callback)
 * @method   \ChainObject  eachP($callback, $default = null)
 * @method   \ChainObject  eachP1($array, $default = null)
 * @method   \ChainObject  eachP2($array, $callback)
 * @method   \ChainObject  eachE($callback, $default = null)
 * @method   \ChainObject  eachE1($array, $default = null)
 * @method   \ChainObject  eachE2($array, $callback)
 *
 * @see array_explode
 * @method   \ChainObject  array_explode($condition, $limit = PHP_INT_MAX)
 * @method   \ChainObject  array_explode1($array, $limit = PHP_INT_MAX)
 * @method   \ChainObject  array_explode2($array, $condition)
 *
 * @see array_extend
 * @method   \ChainObject  array_extend(...$arrays)
 * @method   \ChainObject  array_extend1($default = [], ...$arrays)
 * @method   \ChainObject  array_extend2($default = [], ...$arrays)
 * @method   \ChainObject  array_extend3($default = [], ...$arrays)
 * @method   \ChainObject  array_extend4($default = [], ...$arrays)
 * @method   \ChainObject  array_extend5($default = [], ...$arrays)
 * @method   \ChainObject  array_extend6($default = [], ...$arrays)
 *
 * @see array_extend
 * @method   \ChainObject  extend(...$arrays)
 * @method   \ChainObject  extend1($default = [], ...$arrays)
 * @method   \ChainObject  extend2($default = [], ...$arrays)
 * @method   \ChainObject  extend3($default = [], ...$arrays)
 * @method   \ChainObject  extend4($default = [], ...$arrays)
 * @method   \ChainObject  extend5($default = [], ...$arrays)
 * @method   \ChainObject  extend6($default = [], ...$arrays)
 *
 * @see array_fill
 * @method   \ChainObject  array_fill(int $count, mixed $value)
 * @method   \ChainObject  array_fill1(int $start_index, mixed $value)
 * @method   \ChainObject  array_fill2(int $start_index, int $count)
 *
 * @see array_fill
 * @method   \ChainObject  fill(int $count, mixed $value)
 * @method   \ChainObject  fill1(int $start_index, mixed $value)
 * @method   \ChainObject  fill2(int $start_index, int $count)
 *
 * @see array_fill_callback
 * @method   \ChainObject  array_fill_callback($callback)
 * @method   \ChainObject  array_fill_callback1($keys)
 * @method   \ChainObject  array_fill_callbackP($callback)
 * @method   \ChainObject  array_fill_callbackP1($keys)
 * @method   \ChainObject  array_fill_callbackE($callback)
 * @method   \ChainObject  array_fill_callbackE1($keys)
 *
 * @see array_fill_callback
 * @method   \ChainObject  fill_callback($callback)
 * @method   \ChainObject  fill_callback1($keys)
 * @method   \ChainObject  fill_callbackP($callback)
 * @method   \ChainObject  fill_callbackP1($keys)
 * @method   \ChainObject  fill_callbackE($callback)
 * @method   \ChainObject  fill_callbackE1($keys)
 *
 * @see array_fill_gap
 * @property \ChainObject $array_fill_gap
 * @method   \ChainObject  array_fill_gap(...$values)
 * @method   \ChainObject  array_fill_gap1($array, ...$values)
 * @method   \ChainObject  array_fill_gap2($array, ...$values)
 * @method   \ChainObject  array_fill_gap3($array, ...$values)
 * @method   \ChainObject  array_fill_gap4($array, ...$values)
 * @method   \ChainObject  array_fill_gap5($array, ...$values)
 * @method   \ChainObject  array_fill_gap6($array, ...$values)
 *
 * @see array_fill_gap
 * @property \ChainObject $fill_gap
 * @method   \ChainObject  fill_gap(...$values)
 * @method   \ChainObject  fill_gap1($array, ...$values)
 * @method   \ChainObject  fill_gap2($array, ...$values)
 * @method   \ChainObject  fill_gap3($array, ...$values)
 * @method   \ChainObject  fill_gap4($array, ...$values)
 * @method   \ChainObject  fill_gap5($array, ...$values)
 * @method   \ChainObject  fill_gap6($array, ...$values)
 *
 * @see array_fill_keys
 * @method   \ChainObject  array_fill_keys(mixed $value)
 * @method   \ChainObject  array_fill_keys1(array $keys)
 *
 * @see array_fill_keys
 * @method   \ChainObject  fill_keys(mixed $value)
 * @method   \ChainObject  fill_keys1(array $keys)
 *
 * @see array_filter
 * @property \ChainObject $array_filter
 * @method   \ChainObject  array_filter(?callable $callback = null, int $mode = 0)
 * @method   \ChainObject  array_filter1(array $array, int $mode = 0)
 * @method   \ChainObject  array_filter2(array $array, ?callable $callback = null)
 * @method   \ChainObject  array_filterP(?callable $callback = null, int $mode = 0)
 * @method   \ChainObject  array_filterP1(array $array, int $mode = 0)
 * @method   \ChainObject  array_filterP2(array $array, ?callable $callback = null)
 * @method   \ChainObject  array_filterE(?callable $callback = null, int $mode = 0)
 * @method   \ChainObject  array_filterE1(array $array, int $mode = 0)
 * @method   \ChainObject  array_filterE2(array $array, ?callable $callback = null)
 *
 * @see array_filter
 * @property \ChainObject $filter
 * @method   \ChainObject  filter(?callable $callback = null, int $mode = 0)
 * @method   \ChainObject  filter1(array $array, int $mode = 0)
 * @method   \ChainObject  filter2(array $array, ?callable $callback = null)
 * @method   \ChainObject  filterP(?callable $callback = null, int $mode = 0)
 * @method   \ChainObject  filterP1(array $array, int $mode = 0)
 * @method   \ChainObject  filterP2(array $array, ?callable $callback = null)
 * @method   \ChainObject  filterE(?callable $callback = null, int $mode = 0)
 * @method   \ChainObject  filterE1(array $array, int $mode = 0)
 * @method   \ChainObject  filterE2(array $array, ?callable $callback = null)
 *
 * @see array_filter_key
 * @method   \ChainObject  array_filter_key($callback)
 * @method   \ChainObject  array_filter_key1($array)
 * @method   \ChainObject  array_filter_keyP($callback)
 * @method   \ChainObject  array_filter_keyP1($array)
 * @method   \ChainObject  array_filter_keyE($callback)
 * @method   \ChainObject  array_filter_keyE1($array)
 *
 * @see array_filter_key
 * @method   \ChainObject  filter_key($callback)
 * @method   \ChainObject  filter_key1($array)
 * @method   \ChainObject  filter_keyP($callback)
 * @method   \ChainObject  filter_keyP1($array)
 * @method   \ChainObject  filter_keyE($callback)
 * @method   \ChainObject  filter_keyE1($array)
 *
 * @see array_find
 * @method   \ChainObject  array_find($callback, $is_key = true)
 * @method   \ChainObject  array_find1($array, $is_key = true)
 * @method   \ChainObject  array_find2($array, $callback)
 * @method   \ChainObject  array_findP($callback, $is_key = true)
 * @method   \ChainObject  array_findP1($array, $is_key = true)
 * @method   \ChainObject  array_findP2($array, $callback)
 * @method   \ChainObject  array_findE($callback, $is_key = true)
 * @method   \ChainObject  array_findE1($array, $is_key = true)
 * @method   \ChainObject  array_findE2($array, $callback)
 *
 * @see array_find
 * @method   \ChainObject  find($callback, $is_key = true)
 * @method   \ChainObject  find1($array, $is_key = true)
 * @method   \ChainObject  find2($array, $callback)
 * @method   \ChainObject  findP($callback, $is_key = true)
 * @method   \ChainObject  findP1($array, $is_key = true)
 * @method   \ChainObject  findP2($array, $callback)
 * @method   \ChainObject  findE($callback, $is_key = true)
 * @method   \ChainObject  findE1($array, $is_key = true)
 * @method   \ChainObject  findE2($array, $callback)
 *
 * @see array_find_recursive
 * @method   \ChainObject  array_find_recursive($callback, $is_key = true)
 * @method   \ChainObject  array_find_recursive1($array, $is_key = true)
 * @method   \ChainObject  array_find_recursive2($array, $callback)
 * @method   \ChainObject  array_find_recursiveP($callback, $is_key = true)
 * @method   \ChainObject  array_find_recursiveP1($array, $is_key = true)
 * @method   \ChainObject  array_find_recursiveP2($array, $callback)
 * @method   \ChainObject  array_find_recursiveE($callback, $is_key = true)
 * @method   \ChainObject  array_find_recursiveE1($array, $is_key = true)
 * @method   \ChainObject  array_find_recursiveE2($array, $callback)
 *
 * @see array_find_recursive
 * @method   \ChainObject  find_recursive($callback, $is_key = true)
 * @method   \ChainObject  find_recursive1($array, $is_key = true)
 * @method   \ChainObject  find_recursive2($array, $callback)
 * @method   \ChainObject  find_recursiveP($callback, $is_key = true)
 * @method   \ChainObject  find_recursiveP1($array, $is_key = true)
 * @method   \ChainObject  find_recursiveP2($array, $callback)
 * @method   \ChainObject  find_recursiveE($callback, $is_key = true)
 * @method   \ChainObject  find_recursiveE1($array, $is_key = true)
 * @method   \ChainObject  find_recursiveE2($array, $callback)
 *
 * @see array_flatten
 * @property \ChainObject $array_flatten
 * @method   \ChainObject  array_flatten($delimiter = null)
 * @method   \ChainObject  array_flatten1($array)
 *
 * @see array_flatten
 * @property \ChainObject $flatten
 * @method   \ChainObject  flatten($delimiter = null)
 * @method   \ChainObject  flatten1($array)
 *
 * @see array_flip
 * @property \ChainObject $array_flip
 * @method   \ChainObject  array_flip()
 *
 * @see array_flip
 * @property \ChainObject $flip
 * @method   \ChainObject  flip()
 *
 * @see array_get
 * @method   \ChainObject  array_get($key, $default = null)
 * @method   \ChainObject  array_get1($array, $default = null)
 * @method   \ChainObject  array_get2($array, $key)
 *
 * @see array_get
 * @method   \ChainObject  get($key, $default = null)
 * @method   \ChainObject  get1($array, $default = null)
 * @method   \ChainObject  get2($array, $key)
 *
 * @see array_grep_key
 * @method   \ChainObject  array_grep_key($regex, $not = false)
 * @method   \ChainObject  array_grep_key1($array, $not = false)
 * @method   \ChainObject  array_grep_key2($array, $regex)
 *
 * @see array_grep_key
 * @method   \ChainObject  grep_key($regex, $not = false)
 * @method   \ChainObject  grep_key1($array, $not = false)
 * @method   \ChainObject  grep_key2($array, $regex)
 *
 * @see array_group
 * @property \ChainObject $array_group
 * @method   \ChainObject  array_group($callback = null, $preserve_keys = false)
 * @method   \ChainObject  array_group1($array, $preserve_keys = false)
 * @method   \ChainObject  array_group2($array, $callback = null)
 * @method   \ChainObject  array_groupP($callback = null, $preserve_keys = false)
 * @method   \ChainObject  array_groupP1($array, $preserve_keys = false)
 * @method   \ChainObject  array_groupP2($array, $callback = null)
 * @method   \ChainObject  array_groupE($callback = null, $preserve_keys = false)
 * @method   \ChainObject  array_groupE1($array, $preserve_keys = false)
 * @method   \ChainObject  array_groupE2($array, $callback = null)
 *
 * @see array_group
 * @property \ChainObject $group
 * @method   \ChainObject  group($callback = null, $preserve_keys = false)
 * @method   \ChainObject  group1($array, $preserve_keys = false)
 * @method   \ChainObject  group2($array, $callback = null)
 * @method   \ChainObject  groupP($callback = null, $preserve_keys = false)
 * @method   \ChainObject  groupP1($array, $preserve_keys = false)
 * @method   \ChainObject  groupP2($array, $callback = null)
 * @method   \ChainObject  groupE($callback = null, $preserve_keys = false)
 * @method   \ChainObject  groupE1($array, $preserve_keys = false)
 * @method   \ChainObject  groupE2($array, $callback = null)
 *
 * @see array_implode
 * @method   \ChainObject  array_implode($glue)
 * @method   \ChainObject  array_implode1($array)
 *
 * @see array_insert
 * @method   \ChainObject  array_insert($value, $position = null)
 * @method   \ChainObject  array_insert1($array, $position = null)
 * @method   \ChainObject  array_insert2($array, $value)
 *
 * @see array_insert
 * @method   \ChainObject  insert($value, $position = null)
 * @method   \ChainObject  insert1($array, $position = null)
 * @method   \ChainObject  insert2($array, $value)
 *
 * @see array_intersect
 * @property \ChainObject $array_intersect
 * @method   \ChainObject  array_intersect(...array $arrays)
 * @method   \ChainObject  array_intersect1(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect2(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect3(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect4(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect5(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect6(array $array, ...array $arrays)
 *
 * @see array_intersect
 * @property \ChainObject $intersect
 * @method   \ChainObject  intersect(...array $arrays)
 * @method   \ChainObject  intersect1(array $array, ...array $arrays)
 * @method   \ChainObject  intersect2(array $array, ...array $arrays)
 * @method   \ChainObject  intersect3(array $array, ...array $arrays)
 * @method   \ChainObject  intersect4(array $array, ...array $arrays)
 * @method   \ChainObject  intersect5(array $array, ...array $arrays)
 * @method   \ChainObject  intersect6(array $array, ...array $arrays)
 *
 * @see array_intersect_assoc
 * @property \ChainObject $array_intersect_assoc
 * @method   \ChainObject  array_intersect_assoc(...array $arrays)
 * @method   \ChainObject  array_intersect_assoc1(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_assoc2(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_assoc3(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_assoc4(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_assoc5(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_assoc6(array $array, ...array $arrays)
 *
 * @see array_intersect_assoc
 * @property \ChainObject $intersect_assoc
 * @method   \ChainObject  intersect_assoc(...array $arrays)
 * @method   \ChainObject  intersect_assoc1(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_assoc2(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_assoc3(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_assoc4(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_assoc5(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_assoc6(array $array, ...array $arrays)
 *
 * @see array_intersect_key
 * @property \ChainObject $array_intersect_key
 * @method   \ChainObject  array_intersect_key(...array $arrays)
 * @method   \ChainObject  array_intersect_key1(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_key2(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_key3(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_key4(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_key5(array $array, ...array $arrays)
 * @method   \ChainObject  array_intersect_key6(array $array, ...array $arrays)
 *
 * @see array_intersect_key
 * @property \ChainObject $intersect_key
 * @method   \ChainObject  intersect_key(...array $arrays)
 * @method   \ChainObject  intersect_key1(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_key2(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_key3(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_key4(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_key5(array $array, ...array $arrays)
 * @method   \ChainObject  intersect_key6(array $array, ...array $arrays)
 *
 * @see array_intersect_uassoc
 * @property \ChainObject $array_intersect_uassoc
 * @method   \ChainObject  array_intersect_uassoc(...$rest)
 * @method   \ChainObject  array_intersect_uassoc1(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_uassoc2(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_uassoc3(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_uassoc4(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_uassoc5(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_uassoc6(array $array, ...$rest)
 *
 * @see array_intersect_uassoc
 * @property \ChainObject $intersect_uassoc
 * @method   \ChainObject  intersect_uassoc(...$rest)
 * @method   \ChainObject  intersect_uassoc1(array $array, ...$rest)
 * @method   \ChainObject  intersect_uassoc2(array $array, ...$rest)
 * @method   \ChainObject  intersect_uassoc3(array $array, ...$rest)
 * @method   \ChainObject  intersect_uassoc4(array $array, ...$rest)
 * @method   \ChainObject  intersect_uassoc5(array $array, ...$rest)
 * @method   \ChainObject  intersect_uassoc6(array $array, ...$rest)
 *
 * @see array_intersect_ukey
 * @property \ChainObject $array_intersect_ukey
 * @method   \ChainObject  array_intersect_ukey(...$rest)
 * @method   \ChainObject  array_intersect_ukey1(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_ukey2(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_ukey3(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_ukey4(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_ukey5(array $array, ...$rest)
 * @method   \ChainObject  array_intersect_ukey6(array $array, ...$rest)
 *
 * @see array_intersect_ukey
 * @property \ChainObject $intersect_ukey
 * @method   \ChainObject  intersect_ukey(...$rest)
 * @method   \ChainObject  intersect_ukey1(array $array, ...$rest)
 * @method   \ChainObject  intersect_ukey2(array $array, ...$rest)
 * @method   \ChainObject  intersect_ukey3(array $array, ...$rest)
 * @method   \ChainObject  intersect_ukey4(array $array, ...$rest)
 * @method   \ChainObject  intersect_ukey5(array $array, ...$rest)
 * @method   \ChainObject  intersect_ukey6(array $array, ...$rest)
 *
 * @see array_key_exists
 * @method   \ChainObject  array_key_exists(array $array)
 * @method   \ChainObject  array_key_exists1($key)
 *
 * @see array_key_first
 * @property \ChainObject $array_key_first
 * @method   \ChainObject  array_key_first()
 *
 * @see array_key_first
 * @property \ChainObject $key_first
 * @method   \ChainObject  key_first()
 *
 * @see array_key_last
 * @property \ChainObject $array_key_last
 * @method   \ChainObject  array_key_last()
 *
 * @see array_key_last
 * @property \ChainObject $key_last
 * @method   \ChainObject  key_last()
 *
 * @see array_keys
 * @property \ChainObject $array_keys
 * @method   \ChainObject  array_keys(mixed $filter_value = null, bool $strict = false)
 * @method   \ChainObject  array_keys1(array $array, bool $strict = false)
 * @method   \ChainObject  array_keys2(array $array, mixed $filter_value = null)
 *
 * @see array_keys
 * @property \ChainObject $keys
 * @method   \ChainObject  keys(mixed $filter_value = null, bool $strict = false)
 * @method   \ChainObject  keys1(array $array, bool $strict = false)
 * @method   \ChainObject  keys2(array $array, mixed $filter_value = null)
 *
 * @see array_keys_exist
 * @method   \ChainObject  array_keys_exist($array)
 * @method   \ChainObject  array_keys_exist1($keys)
 *
 * @see array_keys_exist
 * @method   \ChainObject  keys_exist($array)
 * @method   \ChainObject  keys_exist1($keys)
 *
 * @see array_kmap
 * @method   \ChainObject  array_kmap($callback)
 * @method   \ChainObject  array_kmap1($array)
 * @method   \ChainObject  array_kmapP($callback)
 * @method   \ChainObject  array_kmapP1($array)
 * @method   \ChainObject  array_kmapE($callback)
 * @method   \ChainObject  array_kmapE1($array)
 *
 * @see array_kmap
 * @method   \ChainObject  kmap($callback)
 * @method   \ChainObject  kmap1($array)
 * @method   \ChainObject  kmapP($callback)
 * @method   \ChainObject  kmapP1($array)
 * @method   \ChainObject  kmapE($callback)
 * @method   \ChainObject  kmapE1($array)
 *
 * @see array_kvmap
 * @method   \ChainObject  array_kvmap($callback)
 * @method   \ChainObject  array_kvmap1($array)
 * @method   \ChainObject  array_kvmapP($callback)
 * @method   \ChainObject  array_kvmapP1($array)
 * @method   \ChainObject  array_kvmapE($callback)
 * @method   \ChainObject  array_kvmapE1($array)
 *
 * @see array_kvmap
 * @method   \ChainObject  kvmap($callback)
 * @method   \ChainObject  kvmap1($array)
 * @method   \ChainObject  kvmapP($callback)
 * @method   \ChainObject  kvmapP1($array)
 * @method   \ChainObject  kvmapE($callback)
 * @method   \ChainObject  kvmapE1($array)
 *
 * @see array_lmap
 * @method   \ChainObject  array_lmap($callback, ...$variadic)
 * @method   \ChainObject  array_lmap1($array, ...$variadic)
 * @method   \ChainObject  array_lmap2($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmap3($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmap4($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmap5($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmap6($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmap7($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapP($callback, ...$variadic)
 * @method   \ChainObject  array_lmapP1($array, ...$variadic)
 * @method   \ChainObject  array_lmapP2($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapP3($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapP4($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapP5($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapP6($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapP7($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapE($callback, ...$variadic)
 * @method   \ChainObject  array_lmapE1($array, ...$variadic)
 * @method   \ChainObject  array_lmapE2($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapE3($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapE4($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapE5($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapE6($array, $callback, ...$variadic)
 * @method   \ChainObject  array_lmapE7($array, $callback, ...$variadic)
 *
 * @see array_lmap
 * @method   \ChainObject  lmap($callback, ...$variadic)
 * @method   \ChainObject  lmap1($array, ...$variadic)
 * @method   \ChainObject  lmap2($array, $callback, ...$variadic)
 * @method   \ChainObject  lmap3($array, $callback, ...$variadic)
 * @method   \ChainObject  lmap4($array, $callback, ...$variadic)
 * @method   \ChainObject  lmap5($array, $callback, ...$variadic)
 * @method   \ChainObject  lmap6($array, $callback, ...$variadic)
 * @method   \ChainObject  lmap7($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapP($callback, ...$variadic)
 * @method   \ChainObject  lmapP1($array, ...$variadic)
 * @method   \ChainObject  lmapP2($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapP3($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapP4($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapP5($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapP6($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapP7($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapE($callback, ...$variadic)
 * @method   \ChainObject  lmapE1($array, ...$variadic)
 * @method   \ChainObject  lmapE2($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapE3($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapE4($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapE5($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapE6($array, $callback, ...$variadic)
 * @method   \ChainObject  lmapE7($array, $callback, ...$variadic)
 *
 * @see array_lookup
 * @property \ChainObject $array_lookup
 * @method   \ChainObject  array_lookup($column_key = null, $index_key = null)
 * @method   \ChainObject  array_lookup1($array, $index_key = null)
 * @method   \ChainObject  array_lookup2($array, $column_key = null)
 *
 * @see array_lookup
 * @property \ChainObject $lookup
 * @method   \ChainObject  lookup($column_key = null, $index_key = null)
 * @method   \ChainObject  lookup1($array, $index_key = null)
 * @method   \ChainObject  lookup2($array, $column_key = null)
 *
 * @see array_map
 * @method   \ChainObject  array_map(array $array, ...array $arrays)
 * @method   \ChainObject  array_map1(?callable $callback, ...array $arrays)
 * @method   \ChainObject  array_map2(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_map3(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_map4(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_map5(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_map6(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_map7(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapP(array $array, ...array $arrays)
 * @method   \ChainObject  array_mapP1(?callable $callback, ...array $arrays)
 * @method   \ChainObject  array_mapP2(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapP3(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapP4(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapP5(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapP6(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapP7(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapE(array $array, ...array $arrays)
 * @method   \ChainObject  array_mapE1(?callable $callback, ...array $arrays)
 * @method   \ChainObject  array_mapE2(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapE3(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapE4(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapE5(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapE6(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  array_mapE7(?callable $callback, array $array, ...array $arrays)
 *
 * @see array_map
 * @method   \ChainObject  map(array $array, ...array $arrays)
 * @method   \ChainObject  map1(?callable $callback, ...array $arrays)
 * @method   \ChainObject  map2(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  map3(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  map4(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  map5(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  map6(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  map7(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapP(array $array, ...array $arrays)
 * @method   \ChainObject  mapP1(?callable $callback, ...array $arrays)
 * @method   \ChainObject  mapP2(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapP3(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapP4(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapP5(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapP6(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapP7(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapE(array $array, ...array $arrays)
 * @method   \ChainObject  mapE1(?callable $callback, ...array $arrays)
 * @method   \ChainObject  mapE2(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapE3(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapE4(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapE5(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapE6(?callable $callback, array $array, ...array $arrays)
 * @method   \ChainObject  mapE7(?callable $callback, array $array, ...array $arrays)
 *
 * @see array_map_filter
 * @method   \ChainObject  array_map_filter($callback, $strict = false)
 * @method   \ChainObject  array_map_filter1($array, $strict = false)
 * @method   \ChainObject  array_map_filter2($array, $callback)
 * @method   \ChainObject  array_map_filterP($callback, $strict = false)
 * @method   \ChainObject  array_map_filterP1($array, $strict = false)
 * @method   \ChainObject  array_map_filterP2($array, $callback)
 * @method   \ChainObject  array_map_filterE($callback, $strict = false)
 * @method   \ChainObject  array_map_filterE1($array, $strict = false)
 * @method   \ChainObject  array_map_filterE2($array, $callback)
 *
 * @see array_map_filter
 * @method   \ChainObject  map_filter($callback, $strict = false)
 * @method   \ChainObject  map_filter1($array, $strict = false)
 * @method   \ChainObject  map_filter2($array, $callback)
 * @method   \ChainObject  map_filterP($callback, $strict = false)
 * @method   \ChainObject  map_filterP1($array, $strict = false)
 * @method   \ChainObject  map_filterP2($array, $callback)
 * @method   \ChainObject  map_filterE($callback, $strict = false)
 * @method   \ChainObject  map_filterE1($array, $strict = false)
 * @method   \ChainObject  map_filterE2($array, $callback)
 *
 * @see array_map_key
 * @method   \ChainObject  array_map_key($callback)
 * @method   \ChainObject  array_map_key1($array)
 * @method   \ChainObject  array_map_keyP($callback)
 * @method   \ChainObject  array_map_keyP1($array)
 * @method   \ChainObject  array_map_keyE($callback)
 * @method   \ChainObject  array_map_keyE1($array)
 *
 * @see array_map_key
 * @method   \ChainObject  map_key($callback)
 * @method   \ChainObject  map_key1($array)
 * @method   \ChainObject  map_keyP($callback)
 * @method   \ChainObject  map_keyP1($array)
 * @method   \ChainObject  map_keyE($callback)
 * @method   \ChainObject  map_keyE1($array)
 *
 * @see array_map_method
 * @method   \ChainObject  array_map_method($method, $args = [], $ignore = false)
 * @method   \ChainObject  array_map_method1($array, $args = [], $ignore = false)
 * @method   \ChainObject  array_map_method2($array, $method, $ignore = false)
 * @method   \ChainObject  array_map_method3($array, $method, $args = [])
 *
 * @see array_map_method
 * @method   \ChainObject  map_method($method, $args = [], $ignore = false)
 * @method   \ChainObject  map_method1($array, $args = [], $ignore = false)
 * @method   \ChainObject  map_method2($array, $method, $ignore = false)
 * @method   \ChainObject  map_method3($array, $method, $args = [])
 *
 * @see array_map_recursive
 * @method   \ChainObject  array_map_recursive($callback, $iterable = true, $apply_array = false)
 * @method   \ChainObject  array_map_recursive1($array, $iterable = true, $apply_array = false)
 * @method   \ChainObject  array_map_recursive2($array, $callback, $apply_array = false)
 * @method   \ChainObject  array_map_recursive3($array, $callback, $iterable = true)
 * @method   \ChainObject  array_map_recursiveP($callback, $iterable = true, $apply_array = false)
 * @method   \ChainObject  array_map_recursiveP1($array, $iterable = true, $apply_array = false)
 * @method   \ChainObject  array_map_recursiveP2($array, $callback, $apply_array = false)
 * @method   \ChainObject  array_map_recursiveP3($array, $callback, $iterable = true)
 * @method   \ChainObject  array_map_recursiveE($callback, $iterable = true, $apply_array = false)
 * @method   \ChainObject  array_map_recursiveE1($array, $iterable = true, $apply_array = false)
 * @method   \ChainObject  array_map_recursiveE2($array, $callback, $apply_array = false)
 * @method   \ChainObject  array_map_recursiveE3($array, $callback, $iterable = true)
 *
 * @see array_map_recursive
 * @method   \ChainObject  map_recursive($callback, $iterable = true, $apply_array = false)
 * @method   \ChainObject  map_recursive1($array, $iterable = true, $apply_array = false)
 * @method   \ChainObject  map_recursive2($array, $callback, $apply_array = false)
 * @method   \ChainObject  map_recursive3($array, $callback, $iterable = true)
 * @method   \ChainObject  map_recursiveP($callback, $iterable = true, $apply_array = false)
 * @method   \ChainObject  map_recursiveP1($array, $iterable = true, $apply_array = false)
 * @method   \ChainObject  map_recursiveP2($array, $callback, $apply_array = false)
 * @method   \ChainObject  map_recursiveP3($array, $callback, $iterable = true)
 * @method   \ChainObject  map_recursiveE($callback, $iterable = true, $apply_array = false)
 * @method   \ChainObject  map_recursiveE1($array, $iterable = true, $apply_array = false)
 * @method   \ChainObject  map_recursiveE2($array, $callback, $apply_array = false)
 * @method   \ChainObject  map_recursiveE3($array, $callback, $iterable = true)
 *
 * @see array_maps
 * @property \ChainObject $array_maps
 * @method   \ChainObject  array_maps(...$callbacks)
 * @method   \ChainObject  array_maps1($array, ...$callbacks)
 * @method   \ChainObject  array_maps2($array, ...$callbacks)
 * @method   \ChainObject  array_maps3($array, ...$callbacks)
 * @method   \ChainObject  array_maps4($array, ...$callbacks)
 * @method   \ChainObject  array_maps5($array, ...$callbacks)
 * @method   \ChainObject  array_maps6($array, ...$callbacks)
 * @method   \ChainObject  array_mapsP(...$callbacks)
 * @method   \ChainObject  array_mapsP1($array, ...$callbacks)
 * @method   \ChainObject  array_mapsP2($array, ...$callbacks)
 * @method   \ChainObject  array_mapsP3($array, ...$callbacks)
 * @method   \ChainObject  array_mapsP4($array, ...$callbacks)
 * @method   \ChainObject  array_mapsP5($array, ...$callbacks)
 * @method   \ChainObject  array_mapsP6($array, ...$callbacks)
 * @method   \ChainObject  array_mapsE(...$callbacks)
 * @method   \ChainObject  array_mapsE1($array, ...$callbacks)
 * @method   \ChainObject  array_mapsE2($array, ...$callbacks)
 * @method   \ChainObject  array_mapsE3($array, ...$callbacks)
 * @method   \ChainObject  array_mapsE4($array, ...$callbacks)
 * @method   \ChainObject  array_mapsE5($array, ...$callbacks)
 * @method   \ChainObject  array_mapsE6($array, ...$callbacks)
 *
 * @see array_maps
 * @property \ChainObject $maps
 * @method   \ChainObject  maps(...$callbacks)
 * @method   \ChainObject  maps1($array, ...$callbacks)
 * @method   \ChainObject  maps2($array, ...$callbacks)
 * @method   \ChainObject  maps3($array, ...$callbacks)
 * @method   \ChainObject  maps4($array, ...$callbacks)
 * @method   \ChainObject  maps5($array, ...$callbacks)
 * @method   \ChainObject  maps6($array, ...$callbacks)
 * @method   \ChainObject  mapsP(...$callbacks)
 * @method   \ChainObject  mapsP1($array, ...$callbacks)
 * @method   \ChainObject  mapsP2($array, ...$callbacks)
 * @method   \ChainObject  mapsP3($array, ...$callbacks)
 * @method   \ChainObject  mapsP4($array, ...$callbacks)
 * @method   \ChainObject  mapsP5($array, ...$callbacks)
 * @method   \ChainObject  mapsP6($array, ...$callbacks)
 * @method   \ChainObject  mapsE(...$callbacks)
 * @method   \ChainObject  mapsE1($array, ...$callbacks)
 * @method   \ChainObject  mapsE2($array, ...$callbacks)
 * @method   \ChainObject  mapsE3($array, ...$callbacks)
 * @method   \ChainObject  mapsE4($array, ...$callbacks)
 * @method   \ChainObject  mapsE5($array, ...$callbacks)
 * @method   \ChainObject  mapsE6($array, ...$callbacks)
 *
 * @see array_merge
 * @method   \ChainObject  array_merge(...array $arrays)
 * @method   \ChainObject  array_merge1(...array $arrays)
 * @method   \ChainObject  array_merge2(...array $arrays)
 * @method   \ChainObject  array_merge3(...array $arrays)
 * @method   \ChainObject  array_merge4(...array $arrays)
 * @method   \ChainObject  array_merge5(...array $arrays)
 *
 * @see array_merge
 * @method   \ChainObject  merge(...array $arrays)
 * @method   \ChainObject  merge1(...array $arrays)
 * @method   \ChainObject  merge2(...array $arrays)
 * @method   \ChainObject  merge3(...array $arrays)
 * @method   \ChainObject  merge4(...array $arrays)
 * @method   \ChainObject  merge5(...array $arrays)
 *
 * @see array_merge2
 * @method   \ChainObject  array_merge2(...$arrays)
 * @method   \ChainObject  array_merge21(...$arrays)
 * @method   \ChainObject  array_merge22(...$arrays)
 * @method   \ChainObject  array_merge23(...$arrays)
 * @method   \ChainObject  array_merge24(...$arrays)
 * @method   \ChainObject  array_merge25(...$arrays)
 *
 * @see array_merge2
 * @method   \ChainObject  merge2(...$arrays)
 * @method   \ChainObject  merge21(...$arrays)
 * @method   \ChainObject  merge22(...$arrays)
 * @method   \ChainObject  merge23(...$arrays)
 * @method   \ChainObject  merge24(...$arrays)
 * @method   \ChainObject  merge25(...$arrays)
 *
 * @see array_merge_recursive
 * @method   \ChainObject  array_merge_recursive(...array $arrays)
 * @method   \ChainObject  array_merge_recursive1(...array $arrays)
 * @method   \ChainObject  array_merge_recursive2(...array $arrays)
 * @method   \ChainObject  array_merge_recursive3(...array $arrays)
 * @method   \ChainObject  array_merge_recursive4(...array $arrays)
 * @method   \ChainObject  array_merge_recursive5(...array $arrays)
 *
 * @see array_merge_recursive
 * @method   \ChainObject  merge_recursive(...array $arrays)
 * @method   \ChainObject  merge_recursive1(...array $arrays)
 * @method   \ChainObject  merge_recursive2(...array $arrays)
 * @method   \ChainObject  merge_recursive3(...array $arrays)
 * @method   \ChainObject  merge_recursive4(...array $arrays)
 * @method   \ChainObject  merge_recursive5(...array $arrays)
 *
 * @see array_mix
 * @method   \ChainObject  array_mix(...$variadic)
 * @method   \ChainObject  array_mix1(...$variadic)
 * @method   \ChainObject  array_mix2(...$variadic)
 * @method   \ChainObject  array_mix3(...$variadic)
 * @method   \ChainObject  array_mix4(...$variadic)
 * @method   \ChainObject  array_mix5(...$variadic)
 *
 * @see array_mix
 * @method   \ChainObject  mix(...$variadic)
 * @method   \ChainObject  mix1(...$variadic)
 * @method   \ChainObject  mix2(...$variadic)
 * @method   \ChainObject  mix3(...$variadic)
 * @method   \ChainObject  mix4(...$variadic)
 * @method   \ChainObject  mix5(...$variadic)
 *
 * @see array_nest
 * @property \ChainObject $array_nest
 * @method   \ChainObject  array_nest($delimiter = ".")
 * @method   \ChainObject  array_nest1($array)
 *
 * @see array_nest
 * @property \ChainObject $nest
 * @method   \ChainObject  nest($delimiter = ".")
 * @method   \ChainObject  nest1($array)
 *
 * @see array_nmap
 * @method   \ChainObject  array_nmap($callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmap1($array, $n, ...$variadic)
 * @method   \ChainObject  array_nmap2($array, $callback, ...$variadic)
 * @method   \ChainObject  array_nmap3($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmap4($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmap5($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmap6($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmap7($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmap8($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapP($callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapP1($array, $n, ...$variadic)
 * @method   \ChainObject  array_nmapP2($array, $callback, ...$variadic)
 * @method   \ChainObject  array_nmapP3($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapP4($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapP5($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapP6($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapP7($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapP8($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapE($callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapE1($array, $n, ...$variadic)
 * @method   \ChainObject  array_nmapE2($array, $callback, ...$variadic)
 * @method   \ChainObject  array_nmapE3($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapE4($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapE5($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapE6($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapE7($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  array_nmapE8($array, $callback, $n, ...$variadic)
 *
 * @see array_nmap
 * @method   \ChainObject  nmap($callback, $n, ...$variadic)
 * @method   \ChainObject  nmap1($array, $n, ...$variadic)
 * @method   \ChainObject  nmap2($array, $callback, ...$variadic)
 * @method   \ChainObject  nmap3($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmap4($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmap5($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmap6($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmap7($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmap8($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapP($callback, $n, ...$variadic)
 * @method   \ChainObject  nmapP1($array, $n, ...$variadic)
 * @method   \ChainObject  nmapP2($array, $callback, ...$variadic)
 * @method   \ChainObject  nmapP3($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapP4($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapP5($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapP6($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapP7($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapP8($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapE($callback, $n, ...$variadic)
 * @method   \ChainObject  nmapE1($array, $n, ...$variadic)
 * @method   \ChainObject  nmapE2($array, $callback, ...$variadic)
 * @method   \ChainObject  nmapE3($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapE4($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapE5($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapE6($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapE7($array, $callback, $n, ...$variadic)
 * @method   \ChainObject  nmapE8($array, $callback, $n, ...$variadic)
 *
 * @see array_of
 * @property \ChainObject $array_of
 * @method   \ChainObject  array_of($default = null)
 * @method   \ChainObject  array_of1($key)
 *
 * @see array_of
 * @property \ChainObject $of
 * @method   \ChainObject  of($default = null)
 * @method   \ChainObject  of1($key)
 *
 * @see array_order
 * @method   \ChainObject  array_order($orders, $preserve_keys = false)
 * @method   \ChainObject  array_order1(array $array, $preserve_keys = false)
 * @method   \ChainObject  array_order2(array $array, $orders)
 *
 * @see array_order
 * @method   \ChainObject  order($orders, $preserve_keys = false)
 * @method   \ChainObject  order1(array $array, $preserve_keys = false)
 * @method   \ChainObject  order2(array $array, $orders)
 *
 * @see array_pad
 * @method   \ChainObject  array_pad(int $length, mixed $value)
 * @method   \ChainObject  array_pad1(array $array, mixed $value)
 * @method   \ChainObject  array_pad2(array $array, int $length)
 *
 * @see array_pad
 * @method   \ChainObject  pad(int $length, mixed $value)
 * @method   \ChainObject  pad1(array $array, mixed $value)
 * @method   \ChainObject  pad2(array $array, int $length)
 *
 * @see array_pickup
 * @method   \ChainObject  array_pickup($keys)
 * @method   \ChainObject  array_pickup1($array)
 *
 * @see array_pickup
 * @method   \ChainObject  pickup($keys)
 * @method   \ChainObject  pickup1($array)
 *
 * @see array_pos
 * @method   \ChainObject  array_pos($position, $return_key = false)
 * @method   \ChainObject  array_pos1($array, $return_key = false)
 * @method   \ChainObject  array_pos2($array, $position)
 *
 * @see array_pos_key
 * @method   \ChainObject  array_pos_key($key, $default = null)
 * @method   \ChainObject  array_pos_key1($array, $default = null)
 * @method   \ChainObject  array_pos_key2($array, $key)
 *
 * @see array_pos_key
 * @method   \ChainObject  pos_key($key, $default = null)
 * @method   \ChainObject  pos_key1($array, $default = null)
 * @method   \ChainObject  pos_key2($array, $key)
 *
 * @see array_prepend
 * @method   \ChainObject  array_prepend($value, $key = null)
 * @method   \ChainObject  array_prepend1($array, $key = null)
 * @method   \ChainObject  array_prepend2($array, $value)
 *
 * @see array_prepend
 * @method   \ChainObject  prepend($value, $key = null)
 * @method   \ChainObject  prepend1($array, $key = null)
 * @method   \ChainObject  prepend2($array, $value)
 *
 * @see array_product
 * @property \ChainObject $array_product
 * @method   \ChainObject  array_product()
 *
 * @see array_product
 * @property \ChainObject $product
 * @method   \ChainObject  product()
 *
 * @see array_rand
 * @property \ChainObject $array_rand
 * @method   \ChainObject  array_rand(int $num = 1)
 * @method   \ChainObject  array_rand1(array $array)
 *
 * @see array_random
 * @property \ChainObject $array_random
 * @method   \ChainObject  array_random($count = null, $preserve_keys = false)
 * @method   \ChainObject  array_random1($array, $preserve_keys = false)
 * @method   \ChainObject  array_random2($array, $count = null)
 *
 * @see array_random
 * @property \ChainObject $random
 * @method   \ChainObject  random($count = null, $preserve_keys = false)
 * @method   \ChainObject  random1($array, $preserve_keys = false)
 * @method   \ChainObject  random2($array, $count = null)
 *
 * @see array_reduce
 * @method   \ChainObject  array_reduce(callable $callback, mixed $initial = null)
 * @method   \ChainObject  array_reduce1(array $array, mixed $initial = null)
 * @method   \ChainObject  array_reduce2(array $array, callable $callback)
 * @method   \ChainObject  array_reduceP(callable $callback, mixed $initial = null)
 * @method   \ChainObject  array_reduceP1(array $array, mixed $initial = null)
 * @method   \ChainObject  array_reduceP2(array $array, callable $callback)
 * @method   \ChainObject  array_reduceE(callable $callback, mixed $initial = null)
 * @method   \ChainObject  array_reduceE1(array $array, mixed $initial = null)
 * @method   \ChainObject  array_reduceE2(array $array, callable $callback)
 *
 * @see array_reduce
 * @method   \ChainObject  reduce(callable $callback, mixed $initial = null)
 * @method   \ChainObject  reduce1(array $array, mixed $initial = null)
 * @method   \ChainObject  reduce2(array $array, callable $callback)
 * @method   \ChainObject  reduceP(callable $callback, mixed $initial = null)
 * @method   \ChainObject  reduceP1(array $array, mixed $initial = null)
 * @method   \ChainObject  reduceP2(array $array, callable $callback)
 * @method   \ChainObject  reduceE(callable $callback, mixed $initial = null)
 * @method   \ChainObject  reduceE1(array $array, mixed $initial = null)
 * @method   \ChainObject  reduceE2(array $array, callable $callback)
 *
 * @see array_rekey
 * @method   \ChainObject  array_rekey($keymap)
 * @method   \ChainObject  array_rekey1($array)
 *
 * @see array_rekey
 * @method   \ChainObject  rekey($keymap)
 * @method   \ChainObject  rekey1($array)
 *
 * @see array_remove
 * @method   \ChainObject  array_remove($keys)
 * @method   \ChainObject  array_remove1($array)
 *
 * @see array_remove
 * @method   \ChainObject  remove($keys)
 * @method   \ChainObject  remove1($array)
 *
 * @see array_replace
 * @property \ChainObject $array_replace
 * @method   \ChainObject  array_replace(...array $replacements)
 * @method   \ChainObject  array_replace1(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace2(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace3(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace4(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace5(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace6(array $array, ...array $replacements)
 *
 * @see array_replace
 * @property \ChainObject $replace
 * @method   \ChainObject  replace(...array $replacements)
 * @method   \ChainObject  replace1(array $array, ...array $replacements)
 * @method   \ChainObject  replace2(array $array, ...array $replacements)
 * @method   \ChainObject  replace3(array $array, ...array $replacements)
 * @method   \ChainObject  replace4(array $array, ...array $replacements)
 * @method   \ChainObject  replace5(array $array, ...array $replacements)
 * @method   \ChainObject  replace6(array $array, ...array $replacements)
 *
 * @see array_replace_recursive
 * @property \ChainObject $array_replace_recursive
 * @method   \ChainObject  array_replace_recursive(...array $replacements)
 * @method   \ChainObject  array_replace_recursive1(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace_recursive2(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace_recursive3(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace_recursive4(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace_recursive5(array $array, ...array $replacements)
 * @method   \ChainObject  array_replace_recursive6(array $array, ...array $replacements)
 *
 * @see array_replace_recursive
 * @property \ChainObject $replace_recursive
 * @method   \ChainObject  replace_recursive(...array $replacements)
 * @method   \ChainObject  replace_recursive1(array $array, ...array $replacements)
 * @method   \ChainObject  replace_recursive2(array $array, ...array $replacements)
 * @method   \ChainObject  replace_recursive3(array $array, ...array $replacements)
 * @method   \ChainObject  replace_recursive4(array $array, ...array $replacements)
 * @method   \ChainObject  replace_recursive5(array $array, ...array $replacements)
 * @method   \ChainObject  replace_recursive6(array $array, ...array $replacements)
 *
 * @see array_reverse
 * @property \ChainObject $array_reverse
 * @method   \ChainObject  array_reverse(bool $preserve_keys = false)
 * @method   \ChainObject  array_reverse1(array $array)
 *
 * @see array_reverse
 * @property \ChainObject $reverse
 * @method   \ChainObject  reverse(bool $preserve_keys = false)
 * @method   \ChainObject  reverse1(array $array)
 *
 * @see array_revise
 * @property \ChainObject $array_revise
 * @method   \ChainObject  array_revise(...$maps)
 * @method   \ChainObject  array_revise1($array, ...$maps)
 * @method   \ChainObject  array_revise2($array, ...$maps)
 * @method   \ChainObject  array_revise3($array, ...$maps)
 * @method   \ChainObject  array_revise4($array, ...$maps)
 * @method   \ChainObject  array_revise5($array, ...$maps)
 * @method   \ChainObject  array_revise6($array, ...$maps)
 *
 * @see array_revise
 * @property \ChainObject $revise
 * @method   \ChainObject  revise(...$maps)
 * @method   \ChainObject  revise1($array, ...$maps)
 * @method   \ChainObject  revise2($array, ...$maps)
 * @method   \ChainObject  revise3($array, ...$maps)
 * @method   \ChainObject  revise4($array, ...$maps)
 * @method   \ChainObject  revise5($array, ...$maps)
 * @method   \ChainObject  revise6($array, ...$maps)
 *
 * @see array_rmap
 * @method   \ChainObject  array_rmap($callback, ...$variadic)
 * @method   \ChainObject  array_rmap1($array, ...$variadic)
 * @method   \ChainObject  array_rmap2($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmap3($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmap4($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmap5($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmap6($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmap7($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapP($callback, ...$variadic)
 * @method   \ChainObject  array_rmapP1($array, ...$variadic)
 * @method   \ChainObject  array_rmapP2($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapP3($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapP4($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapP5($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapP6($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapP7($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapE($callback, ...$variadic)
 * @method   \ChainObject  array_rmapE1($array, ...$variadic)
 * @method   \ChainObject  array_rmapE2($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapE3($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapE4($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapE5($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapE6($array, $callback, ...$variadic)
 * @method   \ChainObject  array_rmapE7($array, $callback, ...$variadic)
 *
 * @see array_rmap
 * @method   \ChainObject  rmap($callback, ...$variadic)
 * @method   \ChainObject  rmap1($array, ...$variadic)
 * @method   \ChainObject  rmap2($array, $callback, ...$variadic)
 * @method   \ChainObject  rmap3($array, $callback, ...$variadic)
 * @method   \ChainObject  rmap4($array, $callback, ...$variadic)
 * @method   \ChainObject  rmap5($array, $callback, ...$variadic)
 * @method   \ChainObject  rmap6($array, $callback, ...$variadic)
 * @method   \ChainObject  rmap7($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapP($callback, ...$variadic)
 * @method   \ChainObject  rmapP1($array, ...$variadic)
 * @method   \ChainObject  rmapP2($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapP3($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapP4($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapP5($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapP6($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapP7($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapE($callback, ...$variadic)
 * @method   \ChainObject  rmapE1($array, ...$variadic)
 * @method   \ChainObject  rmapE2($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapE3($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapE4($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapE5($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapE6($array, $callback, ...$variadic)
 * @method   \ChainObject  rmapE7($array, $callback, ...$variadic)
 *
 * @see array_schema
 * @property \ChainObject $array_schema
 * @method   \ChainObject  array_schema(...$arrays)
 * @method   \ChainObject  array_schema1($schema, ...$arrays)
 * @method   \ChainObject  array_schema2($schema, ...$arrays)
 * @method   \ChainObject  array_schema3($schema, ...$arrays)
 * @method   \ChainObject  array_schema4($schema, ...$arrays)
 * @method   \ChainObject  array_schema5($schema, ...$arrays)
 * @method   \ChainObject  array_schema6($schema, ...$arrays)
 *
 * @see array_schema
 * @property \ChainObject $schema
 * @method   \ChainObject  schema(...$arrays)
 * @method   \ChainObject  schema1($schema, ...$arrays)
 * @method   \ChainObject  schema2($schema, ...$arrays)
 * @method   \ChainObject  schema3($schema, ...$arrays)
 * @method   \ChainObject  schema4($schema, ...$arrays)
 * @method   \ChainObject  schema5($schema, ...$arrays)
 * @method   \ChainObject  schema6($schema, ...$arrays)
 *
 * @see array_search
 * @method   \ChainObject  array_search(array $haystack, bool $strict = false)
 * @method   \ChainObject  array_search1(mixed $needle, bool $strict = false)
 * @method   \ChainObject  array_search2(mixed $needle, array $haystack)
 *
 * @see array_search
 * @method   \ChainObject  search(array $haystack, bool $strict = false)
 * @method   \ChainObject  search1(mixed $needle, bool $strict = false)
 * @method   \ChainObject  search2(mixed $needle, array $haystack)
 *
 * @see array_select
 * @method   \ChainObject  array_select($columns, $index = null)
 * @method   \ChainObject  array_select1($array, $index = null)
 * @method   \ChainObject  array_select2($array, $columns)
 *
 * @see array_select
 * @method   \ChainObject  select($columns, $index = null)
 * @method   \ChainObject  select1($array, $index = null)
 * @method   \ChainObject  select2($array, $columns)
 *
 * @see array_shrink_key
 * @method   \ChainObject  array_shrink_key(...$variadic)
 * @method   \ChainObject  array_shrink_key1(...$variadic)
 * @method   \ChainObject  array_shrink_key2(...$variadic)
 * @method   \ChainObject  array_shrink_key3(...$variadic)
 * @method   \ChainObject  array_shrink_key4(...$variadic)
 * @method   \ChainObject  array_shrink_key5(...$variadic)
 *
 * @see array_shrink_key
 * @method   \ChainObject  shrink_key(...$variadic)
 * @method   \ChainObject  shrink_key1(...$variadic)
 * @method   \ChainObject  shrink_key2(...$variadic)
 * @method   \ChainObject  shrink_key3(...$variadic)
 * @method   \ChainObject  shrink_key4(...$variadic)
 * @method   \ChainObject  shrink_key5(...$variadic)
 *
 * @see array_shuffle
 * @property \ChainObject $array_shuffle
 * @method   \ChainObject  array_shuffle()
 *
 * @see array_slice
 * @method   \ChainObject  array_slice(int $offset, ?int $length = null, bool $preserve_keys = false)
 * @method   \ChainObject  array_slice1(array $array, ?int $length = null, bool $preserve_keys = false)
 * @method   \ChainObject  array_slice2(array $array, int $offset, bool $preserve_keys = false)
 * @method   \ChainObject  array_slice3(array $array, int $offset, ?int $length = null)
 *
 * @see array_slice
 * @method   \ChainObject  slice(int $offset, ?int $length = null, bool $preserve_keys = false)
 * @method   \ChainObject  slice1(array $array, ?int $length = null, bool $preserve_keys = false)
 * @method   \ChainObject  slice2(array $array, int $offset, bool $preserve_keys = false)
 * @method   \ChainObject  slice3(array $array, int $offset, ?int $length = null)
 *
 * @see array_sprintf
 * @property \ChainObject $array_sprintf
 * @method   \ChainObject  array_sprintf($format = null, $glue = null)
 * @method   \ChainObject  array_sprintf1($array, $glue = null)
 * @method   \ChainObject  array_sprintf2($array, $format = null)
 *
 * @see array_strpad
 * @method   \ChainObject  array_strpad($key_prefix, $val_prefix = "")
 * @method   \ChainObject  array_strpad1($array, $val_prefix = "")
 * @method   \ChainObject  array_strpad2($array, $key_prefix)
 *
 * @see array_strpad
 * @method   \ChainObject  strpad($key_prefix, $val_prefix = "")
 * @method   \ChainObject  strpad1($array, $val_prefix = "")
 * @method   \ChainObject  strpad2($array, $key_prefix)
 *
 * @see array_sum
 * @property \ChainObject $array_sum
 * @method   \ChainObject  array_sum()
 *
 * @see array_udiff
 * @property \ChainObject $array_udiff
 * @method   \ChainObject  array_udiff(...$rest)
 * @method   \ChainObject  array_udiff1(array $array, ...$rest)
 * @method   \ChainObject  array_udiff2(array $array, ...$rest)
 * @method   \ChainObject  array_udiff3(array $array, ...$rest)
 * @method   \ChainObject  array_udiff4(array $array, ...$rest)
 * @method   \ChainObject  array_udiff5(array $array, ...$rest)
 * @method   \ChainObject  array_udiff6(array $array, ...$rest)
 *
 * @see array_udiff
 * @property \ChainObject $udiff
 * @method   \ChainObject  udiff(...$rest)
 * @method   \ChainObject  udiff1(array $array, ...$rest)
 * @method   \ChainObject  udiff2(array $array, ...$rest)
 * @method   \ChainObject  udiff3(array $array, ...$rest)
 * @method   \ChainObject  udiff4(array $array, ...$rest)
 * @method   \ChainObject  udiff5(array $array, ...$rest)
 * @method   \ChainObject  udiff6(array $array, ...$rest)
 *
 * @see array_udiff_assoc
 * @property \ChainObject $array_udiff_assoc
 * @method   \ChainObject  array_udiff_assoc(...$rest)
 * @method   \ChainObject  array_udiff_assoc1(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_assoc2(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_assoc3(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_assoc4(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_assoc5(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_assoc6(array $array, ...$rest)
 *
 * @see array_udiff_assoc
 * @property \ChainObject $udiff_assoc
 * @method   \ChainObject  udiff_assoc(...$rest)
 * @method   \ChainObject  udiff_assoc1(array $array, ...$rest)
 * @method   \ChainObject  udiff_assoc2(array $array, ...$rest)
 * @method   \ChainObject  udiff_assoc3(array $array, ...$rest)
 * @method   \ChainObject  udiff_assoc4(array $array, ...$rest)
 * @method   \ChainObject  udiff_assoc5(array $array, ...$rest)
 * @method   \ChainObject  udiff_assoc6(array $array, ...$rest)
 *
 * @see array_udiff_uassoc
 * @property \ChainObject $array_udiff_uassoc
 * @method   \ChainObject  array_udiff_uassoc(...$rest)
 * @method   \ChainObject  array_udiff_uassoc1(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_uassoc2(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_uassoc3(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_uassoc4(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_uassoc5(array $array, ...$rest)
 * @method   \ChainObject  array_udiff_uassoc6(array $array, ...$rest)
 *
 * @see array_udiff_uassoc
 * @property \ChainObject $udiff_uassoc
 * @method   \ChainObject  udiff_uassoc(...$rest)
 * @method   \ChainObject  udiff_uassoc1(array $array, ...$rest)
 * @method   \ChainObject  udiff_uassoc2(array $array, ...$rest)
 * @method   \ChainObject  udiff_uassoc3(array $array, ...$rest)
 * @method   \ChainObject  udiff_uassoc4(array $array, ...$rest)
 * @method   \ChainObject  udiff_uassoc5(array $array, ...$rest)
 * @method   \ChainObject  udiff_uassoc6(array $array, ...$rest)
 *
 * @see array_uintersect
 * @property \ChainObject $array_uintersect
 * @method   \ChainObject  array_uintersect(...$rest)
 * @method   \ChainObject  array_uintersect1(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect2(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect3(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect4(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect5(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect6(array $array, ...$rest)
 *
 * @see array_uintersect
 * @property \ChainObject $uintersect
 * @method   \ChainObject  uintersect(...$rest)
 * @method   \ChainObject  uintersect1(array $array, ...$rest)
 * @method   \ChainObject  uintersect2(array $array, ...$rest)
 * @method   \ChainObject  uintersect3(array $array, ...$rest)
 * @method   \ChainObject  uintersect4(array $array, ...$rest)
 * @method   \ChainObject  uintersect5(array $array, ...$rest)
 * @method   \ChainObject  uintersect6(array $array, ...$rest)
 *
 * @see array_uintersect_assoc
 * @property \ChainObject $array_uintersect_assoc
 * @method   \ChainObject  array_uintersect_assoc(...$rest)
 * @method   \ChainObject  array_uintersect_assoc1(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_assoc2(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_assoc3(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_assoc4(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_assoc5(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_assoc6(array $array, ...$rest)
 *
 * @see array_uintersect_assoc
 * @property \ChainObject $uintersect_assoc
 * @method   \ChainObject  uintersect_assoc(...$rest)
 * @method   \ChainObject  uintersect_assoc1(array $array, ...$rest)
 * @method   \ChainObject  uintersect_assoc2(array $array, ...$rest)
 * @method   \ChainObject  uintersect_assoc3(array $array, ...$rest)
 * @method   \ChainObject  uintersect_assoc4(array $array, ...$rest)
 * @method   \ChainObject  uintersect_assoc5(array $array, ...$rest)
 * @method   \ChainObject  uintersect_assoc6(array $array, ...$rest)
 *
 * @see array_uintersect_uassoc
 * @property \ChainObject $array_uintersect_uassoc
 * @method   \ChainObject  array_uintersect_uassoc(...$rest)
 * @method   \ChainObject  array_uintersect_uassoc1(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_uassoc2(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_uassoc3(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_uassoc4(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_uassoc5(array $array, ...$rest)
 * @method   \ChainObject  array_uintersect_uassoc6(array $array, ...$rest)
 *
 * @see array_uintersect_uassoc
 * @property \ChainObject $uintersect_uassoc
 * @method   \ChainObject  uintersect_uassoc(...$rest)
 * @method   \ChainObject  uintersect_uassoc1(array $array, ...$rest)
 * @method   \ChainObject  uintersect_uassoc2(array $array, ...$rest)
 * @method   \ChainObject  uintersect_uassoc3(array $array, ...$rest)
 * @method   \ChainObject  uintersect_uassoc4(array $array, ...$rest)
 * @method   \ChainObject  uintersect_uassoc5(array $array, ...$rest)
 * @method   \ChainObject  uintersect_uassoc6(array $array, ...$rest)
 *
 * @see array_uncolumns
 * @property \ChainObject $array_uncolumns
 * @method   \ChainObject  array_uncolumns($template = null)
 * @method   \ChainObject  array_uncolumns1($array)
 *
 * @see array_uncolumns
 * @property \ChainObject $uncolumns
 * @method   \ChainObject  uncolumns($template = null)
 * @method   \ChainObject  uncolumns1($array)
 *
 * @see array_unique
 * @property \ChainObject $array_unique
 * @method   \ChainObject  array_unique(int $flags = SORT_STRING)
 * @method   \ChainObject  array_unique1(array $array)
 *
 * @see array_unique
 * @property \ChainObject $unique
 * @method   \ChainObject  unique(int $flags = SORT_STRING)
 * @method   \ChainObject  unique1(array $array)
 *
 * @see array_values
 * @property \ChainObject $array_values
 * @method   \ChainObject  array_values()
 *
 * @see array_values
 * @property \ChainObject $values
 * @method   \ChainObject  values()
 *
 * @see array_where
 * @property \ChainObject $array_where
 * @method   \ChainObject  array_where($column = null, $callback = null)
 * @method   \ChainObject  array_where1($array, $callback = null)
 * @method   \ChainObject  array_where2($array, $column = null)
 * @method   \ChainObject  array_whereP($column = null, $callback = null)
 * @method   \ChainObject  array_whereP1($array, $callback = null)
 * @method   \ChainObject  array_whereP2($array, $column = null)
 * @method   \ChainObject  array_whereE($column = null, $callback = null)
 * @method   \ChainObject  array_whereE1($array, $callback = null)
 * @method   \ChainObject  array_whereE2($array, $column = null)
 *
 * @see array_where
 * @property \ChainObject $where
 * @method   \ChainObject  where($column = null, $callback = null)
 * @method   \ChainObject  where1($array, $callback = null)
 * @method   \ChainObject  where2($array, $column = null)
 * @method   \ChainObject  whereP($column = null, $callback = null)
 * @method   \ChainObject  whereP1($array, $callback = null)
 * @method   \ChainObject  whereP2($array, $column = null)
 * @method   \ChainObject  whereE($column = null, $callback = null)
 * @method   \ChainObject  whereE1($array, $callback = null)
 * @method   \ChainObject  whereE2($array, $column = null)
 *
 * @see array_zip
 * @method   \ChainObject  array_zip(...$arrays)
 * @method   \ChainObject  array_zip1(...$arrays)
 * @method   \ChainObject  array_zip2(...$arrays)
 * @method   \ChainObject  array_zip3(...$arrays)
 * @method   \ChainObject  array_zip4(...$arrays)
 * @method   \ChainObject  array_zip5(...$arrays)
 *
 * @see array_zip
 * @method   \ChainObject  zip(...$arrays)
 * @method   \ChainObject  zip1(...$arrays)
 * @method   \ChainObject  zip2(...$arrays)
 * @method   \ChainObject  zip3(...$arrays)
 * @method   \ChainObject  zip4(...$arrays)
 * @method   \ChainObject  zip5(...$arrays)
 *
 * @see arrayable_key_exists
 * @method   \ChainObject  arrayable_key_exists($arrayable)
 * @method   \ChainObject  arrayable_key_exists1($key)
 *
 * @see arrayize
 * @method   \ChainObject  arrayize(...$variadic)
 * @method   \ChainObject  arrayize1(...$variadic)
 * @method   \ChainObject  arrayize2(...$variadic)
 * @method   \ChainObject  arrayize3(...$variadic)
 * @method   \ChainObject  arrayize4(...$variadic)
 * @method   \ChainObject  arrayize5(...$variadic)
 *
 * @see arrays
 * @property \ChainObject $arrays
 * @method   \ChainObject  arrays()
 *
 * @see arrayval
 * @property \ChainObject $arrayval
 * @method   \ChainObject  arrayval($recursive = true)
 * @method   \ChainObject  arrayval1($var)
 *
 * @see asin
 * @property \ChainObject $asin
 * @method   \ChainObject  asin()
 *
 * @see asinh
 * @property \ChainObject $asinh
 * @method   \ChainObject  asinh()
 *
 * @see assert
 * @property \ChainObject $assert
 * @method   \ChainObject  assert(\Throwable|string|null $description = null)
 * @method   \ChainObject  assert1(mixed $assertion)
 *
 * @see assert_options
 * @property \ChainObject $assert_options
 * @method   \ChainObject  assert_options(mixed $value = null)
 * @method   \ChainObject  assert_options1(int $option)
 *
 * @see atan
 * @property \ChainObject $atan
 * @method   \ChainObject  atan()
 *
 * @see atan2
 * @method   \ChainObject  atan2(float $x)
 * @method   \ChainObject  atan21(float $y)
 *
 * @see atanh
 * @property \ChainObject $atanh
 * @method   \ChainObject  atanh()
 *
 * @see attr_exists
 * @method   \ChainObject  attr_exists($value)
 * @method   \ChainObject  attr_exists1($key)
 *
 * @see attr_get
 * @method   \ChainObject  attr_get($value, $default = null)
 * @method   \ChainObject  attr_get1($key, $default = null)
 * @method   \ChainObject  attr_get2($key, $value)
 *
 * @see auto_loader
 * @method   \ChainObject  auto_loader()
 *
 * @see average
 * @method   \ChainObject  average(...$variadic)
 * @method   \ChainObject  average1(...$variadic)
 * @method   \ChainObject  average2(...$variadic)
 * @method   \ChainObject  average3(...$variadic)
 * @method   \ChainObject  average4(...$variadic)
 * @method   \ChainObject  average5(...$variadic)
 *
 * @see backtrace
 * @method   \ChainObject  backtrace($options = [])
 * @method   \ChainObject  backtrace1($flags = DEBUG_BACKTRACE_PROVIDE_OBJECT)
 *
 * @see base64_decode
 * @property \ChainObject $base64_decode
 * @method   \ChainObject  base64_decode(bool $strict = false)
 * @method   \ChainObject  base64_decode1(string $string)
 *
 * @see base64_encode
 * @property \ChainObject $base64_encode
 * @method   \ChainObject  base64_encode()
 *
 * @see base_convert
 * @method   \ChainObject  base_convert(int $from_base, int $to_base)
 * @method   \ChainObject  base_convert1(string $num, int $to_base)
 * @method   \ChainObject  base_convert2(string $num, int $from_base)
 *
 * @see basename
 * @property \ChainObject $basename
 * @method   \ChainObject  basename(string $suffix = "")
 * @method   \ChainObject  basename1(string $path)
 *
 * @see benchmark
 * @property \ChainObject $benchmark
 * @method   \ChainObject  benchmark($args = [], $millisec = 1000, $output = true)
 * @method   \ChainObject  benchmark1($suite, $millisec = 1000, $output = true)
 * @method   \ChainObject  benchmark2($suite, $args = [], $output = true)
 * @method   \ChainObject  benchmark3($suite, $args = [], $millisec = 1000)
 *
 * @see bin2hex
 * @property \ChainObject $bin2hex
 * @method   \ChainObject  bin2hex()
 *
 * @see bindec
 * @property \ChainObject $bindec
 * @method   \ChainObject  bindec()
 *
 * @see blank_if
 * @property \ChainObject $blank_if
 * @method   \ChainObject  blank_if($default = null)
 * @method   \ChainObject  blank_if1($var)
 *
 * @see boolval
 * @property \ChainObject $boolval
 * @method   \ChainObject  boolval()
 *
 * @see build_query
 * @property \ChainObject $build_query
 * @method   \ChainObject  build_query($numeric_prefix = null, $arg_separator = null, $encoding_type = PHP_QUERY_RFC1738)
 * @method   \ChainObject  build_query1($data, $arg_separator = null, $encoding_type = PHP_QUERY_RFC1738)
 * @method   \ChainObject  build_query2($data, $numeric_prefix = null, $encoding_type = PHP_QUERY_RFC1738)
 * @method   \ChainObject  build_query3($data, $numeric_prefix = null, $arg_separator = null)
 *
 * @see build_uri
 * @property \ChainObject $build_uri
 * @method   \ChainObject  build_uri()
 *
 * @see by_builtin
 * @method   \ChainObject  by_builtin($function)
 * @method   \ChainObject  by_builtin1($class)
 *
 * @see cache
 * @method   \ChainObject  cache($provider, $namespace = null)
 * @method   \ChainObject  cache1($key, $namespace = null)
 * @method   \ChainObject  cache2($key, $provider)
 *
 * @see cachedir
 * @method   \ChainObject  cachedir()
 *
 * @see cacheobject
 * @property \ChainObject $cacheobject
 * @method   \ChainObject  cacheobject()
 *
 * @see calculate_formula
 * @property \ChainObject $calculate_formula
 * @method   \ChainObject  calculate_formula()
 *
 * @see call_if
 * @method   \ChainObject  call_if($callable, ...$arguments)
 * @method   \ChainObject  call_if1($condition, ...$arguments)
 * @method   \ChainObject  call_if2($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_if3($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_if4($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_if5($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_if6($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_if7($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifP($callable, ...$arguments)
 * @method   \ChainObject  call_ifP1($condition, ...$arguments)
 * @method   \ChainObject  call_ifP2($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifP3($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifP4($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifP5($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifP6($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifP7($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifE($callable, ...$arguments)
 * @method   \ChainObject  call_ifE1($condition, ...$arguments)
 * @method   \ChainObject  call_ifE2($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifE3($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifE4($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifE5($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifE6($condition, $callable, ...$arguments)
 * @method   \ChainObject  call_ifE7($condition, $callable, ...$arguments)
 *
 * @see call_safely
 * @property \ChainObject $call_safely
 * @method   \ChainObject  call_safely(...$variadic)
 * @method   \ChainObject  call_safely1($callback, ...$variadic)
 * @method   \ChainObject  call_safely2($callback, ...$variadic)
 * @method   \ChainObject  call_safely3($callback, ...$variadic)
 * @method   \ChainObject  call_safely4($callback, ...$variadic)
 * @method   \ChainObject  call_safely5($callback, ...$variadic)
 * @method   \ChainObject  call_safely6($callback, ...$variadic)
 * @method   \ChainObject  call_safelyP(...$variadic)
 * @method   \ChainObject  call_safelyP1($callback, ...$variadic)
 * @method   \ChainObject  call_safelyP2($callback, ...$variadic)
 * @method   \ChainObject  call_safelyP3($callback, ...$variadic)
 * @method   \ChainObject  call_safelyP4($callback, ...$variadic)
 * @method   \ChainObject  call_safelyP5($callback, ...$variadic)
 * @method   \ChainObject  call_safelyP6($callback, ...$variadic)
 * @method   \ChainObject  call_safelyE(...$variadic)
 * @method   \ChainObject  call_safelyE1($callback, ...$variadic)
 * @method   \ChainObject  call_safelyE2($callback, ...$variadic)
 * @method   \ChainObject  call_safelyE3($callback, ...$variadic)
 * @method   \ChainObject  call_safelyE4($callback, ...$variadic)
 * @method   \ChainObject  call_safelyE5($callback, ...$variadic)
 * @method   \ChainObject  call_safelyE6($callback, ...$variadic)
 *
 * @see call_user_func
 * @property \ChainObject $call_user_func
 * @method   \ChainObject  call_user_func(...mixed $args)
 * @method   \ChainObject  call_user_func1(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_func2(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_func3(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_func4(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_func5(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_func6(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcP(...mixed $args)
 * @method   \ChainObject  call_user_funcP1(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcP2(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcP3(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcP4(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcP5(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcP6(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcE(...mixed $args)
 * @method   \ChainObject  call_user_funcE1(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcE2(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcE3(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcE4(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcE5(callable $callback, ...mixed $args)
 * @method   \ChainObject  call_user_funcE6(callable $callback, ...mixed $args)
 *
 * @see call_user_func_array
 * @method   \ChainObject  call_user_func_array(array $args)
 * @method   \ChainObject  call_user_func_array1(callable $callback)
 * @method   \ChainObject  call_user_func_arrayP(array $args)
 * @method   \ChainObject  call_user_func_arrayP1(callable $callback)
 * @method   \ChainObject  call_user_func_arrayE(array $args)
 * @method   \ChainObject  call_user_func_arrayE1(callable $callback)
 *
 * @see callable_code
 * @property \ChainObject $callable_code
 * @method   \ChainObject  callable_code()
 * @method   \ChainObject  callable_codeP()
 * @method   \ChainObject  callable_codeE()
 *
 * @see camel_case
 * @property \ChainObject $camel_case
 * @method   \ChainObject  camel_case($delimiter = "_")
 * @method   \ChainObject  camel_case1($string)
 *
 * @see ceil
 * @property \ChainObject $ceil
 * @method   \ChainObject  ceil()
 *
 * @see chain
 * @method   \ChainObject  chain()
 *
 * @see chain_case
 * @property \ChainObject $chain_case
 * @method   \ChainObject  chain_case($delimiter = "-")
 * @method   \ChainObject  chain_case1($string)
 *
 * @see chdir
 * @property \ChainObject $chdir
 * @method   \ChainObject  chdir()
 *
 * @see checkdate
 * @method   \ChainObject  checkdate(int $day, int $year)
 * @method   \ChainObject  checkdate1(int $month, int $year)
 * @method   \ChainObject  checkdate2(int $month, int $day)
 *
 * @see checkdnsrr
 * @property \ChainObject $checkdnsrr
 * @method   \ChainObject  checkdnsrr(string $type = "MX")
 * @method   \ChainObject  checkdnsrr1(string $hostname)
 *
 * @see chgrp
 * @method   \ChainObject  chgrp(string|int $group)
 * @method   \ChainObject  chgrp1(string $filename)
 *
 * @see chmod
 * @method   \ChainObject  chmod(int $permissions)
 * @method   \ChainObject  chmod1(string $filename)
 *
 * @see chop
 * @property \ChainObject $chop
 * @method   \ChainObject  chop(string $characters = " 
	\000")
 * @method   \ChainObject  chop1(string $string)
 *
 * @see chown
 * @method   \ChainObject  chown(string|int $user)
 * @method   \ChainObject  chown1(string $filename)
 *
 * @see chr
 * @property \ChainObject $chr
 * @method   \ChainObject  chr()
 *
 * @see chroot
 * @property \ChainObject $chroot
 * @method   \ChainObject  chroot()
 *
 * @see chunk_split
 * @property \ChainObject $chunk_split
 * @method   \ChainObject  chunk_split(int $length = 76, string $separator = "
")
 * @method   \ChainObject  chunk_split1(string $string, string $separator = "
")
 * @method   \ChainObject  chunk_split2(string $string, int $length = 76)
 *
 * @see cipher_metadata
 * @property \ChainObject $cipher_metadata
 * @method   \ChainObject  cipher_metadata()
 *
 * @see clamp
 * @method   \ChainObject  clamp($min, $max, $circulative = false)
 * @method   \ChainObject  clamp1($value, $max, $circulative = false)
 * @method   \ChainObject  clamp2($value, $min, $circulative = false)
 * @method   \ChainObject  clamp3($value, $min, $max)
 *
 * @see class_alias
 * @method   \ChainObject  class_alias(string $alias, bool $autoload = true)
 * @method   \ChainObject  class_alias1(string $class, bool $autoload = true)
 * @method   \ChainObject  class_alias2(string $class, string $alias)
 *
 * @see class_aliases
 * @property \ChainObject $class_aliases
 * @method   \ChainObject  class_aliases()
 *
 * @see class_exists
 * @property \ChainObject $class_exists
 * @method   \ChainObject  class_exists(bool $autoload = true)
 * @method   \ChainObject  class_exists1(string $class)
 *
 * @see class_extends
 * @method   \ChainObject  class_extends($methods, $fields = [], $implements = [])
 * @method   \ChainObject  class_extends1($object, $fields = [], $implements = [])
 * @method   \ChainObject  class_extends2($object, $methods, $implements = [])
 * @method   \ChainObject  class_extends3($object, $methods, $fields = [])
 *
 * @see class_loader
 * @method   \ChainObject  class_loader()
 *
 * @see class_namespace
 * @property \ChainObject $class_namespace
 * @method   \ChainObject  class_namespace()
 *
 * @see class_replace
 * @method   \ChainObject  class_replace($register)
 * @method   \ChainObject  class_replace1($class)
 *
 * @see class_shorten
 * @property \ChainObject $class_shorten
 * @method   \ChainObject  class_shorten()
 *
 * @see class_uses_all
 * @property \ChainObject $class_uses_all
 * @method   \ChainObject  class_uses_all($autoload = true)
 * @method   \ChainObject  class_uses_all1($class)
 *
 * @see clearstatcache
 * @method   \ChainObject  clearstatcache(string $filename = "")
 * @method   \ChainObject  clearstatcache1(bool $clear_realpath_cache = false)
 *
 * @see cli_set_process_title
 * @property \ChainObject $cli_set_process_title
 * @method   \ChainObject  cli_set_process_title()
 *
 * @see closedir
 * @method   \ChainObject  closedir()
 *
 * @see compact
 * @property \ChainObject $compact
 * @method   \ChainObject  compact(...$var_names)
 * @method   \ChainObject  compact1($var_name, ...$var_names)
 * @method   \ChainObject  compact2($var_name, ...$var_names)
 * @method   \ChainObject  compact3($var_name, ...$var_names)
 * @method   \ChainObject  compact4($var_name, ...$var_names)
 * @method   \ChainObject  compact5($var_name, ...$var_names)
 * @method   \ChainObject  compact6($var_name, ...$var_names)
 *
 * @see concat
 * @method   \ChainObject  concat(...$variadic)
 * @method   \ChainObject  concat1(...$variadic)
 * @method   \ChainObject  concat2(...$variadic)
 * @method   \ChainObject  concat3(...$variadic)
 * @method   \ChainObject  concat4(...$variadic)
 * @method   \ChainObject  concat5(...$variadic)
 *
 * @see console_log
 * @method   \ChainObject  console_log(...$values)
 * @method   \ChainObject  console_log1(...$values)
 * @method   \ChainObject  console_log2(...$values)
 * @method   \ChainObject  console_log3(...$values)
 * @method   \ChainObject  console_log4(...$values)
 * @method   \ChainObject  console_log5(...$values)
 *
 * @see const_exists
 * @property \ChainObject $const_exists
 * @method   \ChainObject  const_exists($constname = "")
 * @method   \ChainObject  const_exists1($classname)
 *
 * @see constant
 * @property \ChainObject $constant
 * @method   \ChainObject  constant()
 *
 * @see convert_uudecode
 * @property \ChainObject $convert_uudecode
 * @method   \ChainObject  convert_uudecode()
 *
 * @see convert_uuencode
 * @property \ChainObject $convert_uuencode
 * @method   \ChainObject  convert_uuencode()
 *
 * @see copy
 * @method   \ChainObject  copy(string $to, $context = null)
 * @method   \ChainObject  copy1(string $from, $context = null)
 * @method   \ChainObject  copy2(string $from, string $to)
 *
 * @see cos
 * @property \ChainObject $cos
 * @method   \ChainObject  cos()
 *
 * @see cosh
 * @property \ChainObject $cosh
 * @method   \ChainObject  cosh()
 *
 * @see count
 * @property \ChainObject $count
 * @method   \ChainObject  count(int $mode = COUNT_NORMAL)
 * @method   \ChainObject  count1(\Countable|array $value)
 *
 * @see count_chars
 * @property \ChainObject $count_chars
 * @method   \ChainObject  count_chars(int $mode = 0)
 * @method   \ChainObject  count_chars1(string $string)
 *
 * @see cp_rf
 * @method   \ChainObject  cp_rf($dst)
 * @method   \ChainObject  cp_rf1($src)
 *
 * @see crc32
 * @property \ChainObject $crc32
 * @method   \ChainObject  crc32()
 *
 * @see crypt
 * @method   \ChainObject  crypt(string $salt)
 * @method   \ChainObject  crypt1(string $string)
 *
 * @see css_selector
 * @property \ChainObject $css_selector
 * @method   \ChainObject  css_selector()
 *
 * @see csv_export
 * @property \ChainObject $csv_export
 * @method   \ChainObject  csv_export($options = [])
 * @method   \ChainObject  csv_export1($csvarrays)
 *
 * @see csv_import
 * @property \ChainObject $csv_import
 * @method   \ChainObject  csv_import($options = [])
 * @method   \ChainObject  csv_import1($csvstring)
 *
 * @see current
 * @property \ChainObject $current
 * @method   \ChainObject  current()
 *
 * @see damerau_levenshtein
 * @method   \ChainObject  damerau_levenshtein($s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1)
 * @method   \ChainObject  damerau_levenshtein1($s1, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1)
 * @method   \ChainObject  damerau_levenshtein2($s1, $s2, $cost_rep = 1, $cost_del = 1, $cost_swp = 1)
 * @method   \ChainObject  damerau_levenshtein3($s1, $s2, $cost_ins = 1, $cost_del = 1, $cost_swp = 1)
 * @method   \ChainObject  damerau_levenshtein4($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_swp = 1)
 * @method   \ChainObject  damerau_levenshtein5($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1)
 *
 * @see date
 * @property \ChainObject $date
 * @method   \ChainObject  date(?int $timestamp = null)
 * @method   \ChainObject  date1(string $format)
 *
 * @see date_add
 * @method   \ChainObject  date_add(\DateInterval $interval)
 * @method   \ChainObject  date_add1(\DateTime $object)
 *
 * @see date_alter
 * @method   \ChainObject  date_alter($excluded_dates, $follow_count, $format = "Y-m-d")
 * @method   \ChainObject  date_alter1($datetime, $follow_count, $format = "Y-m-d")
 * @method   \ChainObject  date_alter2($datetime, $excluded_dates, $format = "Y-m-d")
 * @method   \ChainObject  date_alter3($datetime, $excluded_dates, $follow_count)
 *
 * @see date_convert
 * @property \ChainObject $date_convert
 * @method   \ChainObject  date_convert($datetimedata = null)
 * @method   \ChainObject  date_convert1($format)
 *
 * @see date_create
 * @method   \ChainObject  date_create(?\DateTimeZone $timezone = null)
 * @method   \ChainObject  date_create1(string $datetime = "now")
 *
 * @see date_create_from_format
 * @method   \ChainObject  date_create_from_format(string $datetime, ?\DateTimeZone $timezone = null)
 * @method   \ChainObject  date_create_from_format1(string $format, ?\DateTimeZone $timezone = null)
 * @method   \ChainObject  date_create_from_format2(string $format, string $datetime)
 *
 * @see date_create_immutable
 * @method   \ChainObject  date_create_immutable(?\DateTimeZone $timezone = null)
 * @method   \ChainObject  date_create_immutable1(string $datetime = "now")
 *
 * @see date_create_immutable_from_format
 * @method   \ChainObject  date_create_immutable_from_format(string $datetime, ?\DateTimeZone $timezone = null)
 * @method   \ChainObject  date_create_immutable_from_format1(string $format, ?\DateTimeZone $timezone = null)
 * @method   \ChainObject  date_create_immutable_from_format2(string $format, string $datetime)
 *
 * @see date_date_set
 * @method   \ChainObject  date_date_set(int $year, int $month, int $day)
 * @method   \ChainObject  date_date_set1(\DateTime $object, int $month, int $day)
 * @method   \ChainObject  date_date_set2(\DateTime $object, int $year, int $day)
 * @method   \ChainObject  date_date_set3(\DateTime $object, int $year, int $month)
 *
 * @see date_default_timezone_set
 * @property \ChainObject $date_default_timezone_set
 * @method   \ChainObject  date_default_timezone_set()
 *
 * @see date_diff
 * @method   \ChainObject  date_diff(\DateTimeInterface $targetObject, bool $absolute = false)
 * @method   \ChainObject  date_diff1(\DateTimeInterface $baseObject, bool $absolute = false)
 * @method   \ChainObject  date_diff2(\DateTimeInterface $baseObject, \DateTimeInterface $targetObject)
 *
 * @see date_format
 * @method   \ChainObject  date_format(string $format)
 * @method   \ChainObject  date_format1(\DateTimeInterface $object)
 *
 * @see date_fromto
 * @method   \ChainObject  date_fromto($datetimestring)
 * @method   \ChainObject  date_fromto1($format)
 *
 * @see date_interval
 * @property \ChainObject $date_interval
 * @method   \ChainObject  date_interval($format = null, $limit_type = "y")
 * @method   \ChainObject  date_interval1($sec, $limit_type = "y")
 * @method   \ChainObject  date_interval2($sec, $format = null)
 *
 * @see date_interval_create_from_date_string
 * @property \ChainObject $date_interval_create_from_date_string
 * @method   \ChainObject  date_interval_create_from_date_string()
 *
 * @see date_interval_format
 * @method   \ChainObject  date_interval_format(string $format)
 * @method   \ChainObject  date_interval_format1(\DateInterval $object)
 *
 * @see date_isodate_set
 * @method   \ChainObject  date_isodate_set(int $year, int $week, int $dayOfWeek = 1)
 * @method   \ChainObject  date_isodate_set1(\DateTime $object, int $week, int $dayOfWeek = 1)
 * @method   \ChainObject  date_isodate_set2(\DateTime $object, int $year, int $dayOfWeek = 1)
 * @method   \ChainObject  date_isodate_set3(\DateTime $object, int $year, int $week)
 *
 * @see date_modify
 * @method   \ChainObject  date_modify(string $modifier)
 * @method   \ChainObject  date_modify1(\DateTime $object)
 *
 * @see date_offset_get
 * @property \ChainObject $date_offset_get
 * @method   \ChainObject  date_offset_get()
 *
 * @see date_parse
 * @property \ChainObject $date_parse
 * @method   \ChainObject  date_parse()
 *
 * @see date_parse_from_format
 * @method   \ChainObject  date_parse_from_format(string $datetime)
 * @method   \ChainObject  date_parse_from_format1(string $format)
 *
 * @see date_sub
 * @method   \ChainObject  date_sub(\DateInterval $interval)
 * @method   \ChainObject  date_sub1(\DateTime $object)
 *
 * @see date_sun_info
 * @method   \ChainObject  date_sun_info(float $latitude, float $longitude)
 * @method   \ChainObject  date_sun_info1(int $timestamp, float $longitude)
 * @method   \ChainObject  date_sun_info2(int $timestamp, float $latitude)
 *
 * @see date_sunrise
 * @property \ChainObject $date_sunrise
 * @method   \ChainObject  date_sunrise(int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunrise1(int $timestamp, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunrise2(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunrise3(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $zenith = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunrise4(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunrise5(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null)
 *
 * @see date_sunset
 * @property \ChainObject $date_sunset
 * @method   \ChainObject  date_sunset(int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunset1(int $timestamp, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunset2(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunset3(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $zenith = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunset4(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $utcOffset = null)
 * @method   \ChainObject  date_sunset5(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null)
 *
 * @see date_time_set
 * @method   \ChainObject  date_time_set(int $hour, int $minute, int $second = 0, int $microsecond = 0)
 * @method   \ChainObject  date_time_set1(\DateTime $object, int $minute, int $second = 0, int $microsecond = 0)
 * @method   \ChainObject  date_time_set2(\DateTime $object, int $hour, int $second = 0, int $microsecond = 0)
 * @method   \ChainObject  date_time_set3(\DateTime $object, int $hour, int $minute, int $microsecond = 0)
 * @method   \ChainObject  date_time_set4(\DateTime $object, int $hour, int $minute, int $second = 0)
 *
 * @see date_timestamp
 * @property \ChainObject $date_timestamp
 * @method   \ChainObject  date_timestamp($baseTimestamp = null)
 * @method   \ChainObject  date_timestamp1($datetimedata)
 *
 * @see date_timestamp_get
 * @property \ChainObject $date_timestamp_get
 * @method   \ChainObject  date_timestamp_get()
 *
 * @see date_timestamp_set
 * @method   \ChainObject  date_timestamp_set(int $timestamp)
 * @method   \ChainObject  date_timestamp_set1(\DateTime $object)
 *
 * @see date_timezone_get
 * @property \ChainObject $date_timezone_get
 * @method   \ChainObject  date_timezone_get()
 *
 * @see date_timezone_set
 * @method   \ChainObject  date_timezone_set(\DateTimeZone $timezone)
 * @method   \ChainObject  date_timezone_set1(\DateTime $object)
 *
 * @see debug_backtrace
 * @method   \ChainObject  debug_backtrace(int $limit = 0)
 * @method   \ChainObject  debug_backtrace1(int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT)
 *
 * @see debug_print_backtrace
 * @method   \ChainObject  debug_print_backtrace(int $limit = 0)
 * @method   \ChainObject  debug_print_backtrace1(int $options = 0)
 *
 * @see debug_zval_dump
 * @property \ChainObject $debug_zval_dump
 * @method   \ChainObject  debug_zval_dump(...mixed $values)
 * @method   \ChainObject  debug_zval_dump1(mixed $value, ...mixed $values)
 * @method   \ChainObject  debug_zval_dump2(mixed $value, ...mixed $values)
 * @method   \ChainObject  debug_zval_dump3(mixed $value, ...mixed $values)
 * @method   \ChainObject  debug_zval_dump4(mixed $value, ...mixed $values)
 * @method   \ChainObject  debug_zval_dump5(mixed $value, ...mixed $values)
 * @method   \ChainObject  debug_zval_dump6(mixed $value, ...mixed $values)
 *
 * @see decbin
 * @property \ChainObject $decbin
 * @method   \ChainObject  decbin()
 *
 * @see dechex
 * @property \ChainObject $dechex
 * @method   \ChainObject  dechex()
 *
 * @see decimal
 * @property \ChainObject $decimal
 * @method   \ChainObject  decimal($precision = 0, $mode = 0)
 * @method   \ChainObject  decimal1($value, $mode = 0)
 * @method   \ChainObject  decimal2($value, $precision = 0)
 *
 * @see decoct
 * @property \ChainObject $decoct
 * @method   \ChainObject  decoct()
 *
 * @see decrypt
 * @method   \ChainObject  decrypt($password, $ciphers = "aes-256-cbc", $tag = "")
 * @method   \ChainObject  decrypt1($cipherdata, $ciphers = "aes-256-cbc", $tag = "")
 * @method   \ChainObject  decrypt2($cipherdata, $password, $tag = "")
 * @method   \ChainObject  decrypt3($cipherdata, $password, $ciphers = "aes-256-cbc")
 *
 * @see define
 * @method   \ChainObject  define($value, bool $case_insensitive = false)
 * @method   \ChainObject  define1(string $constant_name, bool $case_insensitive = false)
 * @method   \ChainObject  define2(string $constant_name, $value)
 *
 * @see defined
 * @property \ChainObject $defined
 * @method   \ChainObject  defined()
 *
 * @see deg2rad
 * @property \ChainObject $deg2rad
 * @method   \ChainObject  deg2rad()
 *
 * @see delegate
 * @method   \ChainObject  delegate($callable, $arity = null)
 * @method   \ChainObject  delegate1($invoker, $arity = null)
 * @method   \ChainObject  delegate2($invoker, $callable)
 * @method   \ChainObject  delegateP($callable, $arity = null)
 * @method   \ChainObject  delegateP1($invoker, $arity = null)
 * @method   \ChainObject  delegateP2($invoker, $callable)
 * @method   \ChainObject  delegateE($callable, $arity = null)
 * @method   \ChainObject  delegateE1($invoker, $arity = null)
 * @method   \ChainObject  delegateE2($invoker, $callable)
 *
 * @see detect_namespace
 * @property \ChainObject $detect_namespace
 * @method   \ChainObject  detect_namespace()
 *
 * @see dir
 * @property \ChainObject $dir
 * @method   \ChainObject  dir($context = null)
 * @method   \ChainObject  dir1(string $directory)
 *
 * @see dirmtime
 * @property \ChainObject $dirmtime
 * @method   \ChainObject  dirmtime($recursive = true)
 * @method   \ChainObject  dirmtime1($dirname)
 *
 * @see dirname
 * @property \ChainObject $dirname
 * @method   \ChainObject  dirname(int $levels = 1)
 * @method   \ChainObject  dirname1(string $path)
 *
 * @see dirname_r
 * @method   \ChainObject  dirname_r($callback)
 * @method   \ChainObject  dirname_r1($path)
 * @method   \ChainObject  dirname_rP($callback)
 * @method   \ChainObject  dirname_rP1($path)
 * @method   \ChainObject  dirname_rE($callback)
 * @method   \ChainObject  dirname_rE1($path)
 *
 * @see disk_free_space
 * @property \ChainObject $disk_free_space
 * @method   \ChainObject  disk_free_space()
 *
 * @see disk_total_space
 * @property \ChainObject $disk_total_space
 * @method   \ChainObject  disk_total_space()
 *
 * @see diskfreespace
 * @property \ChainObject $diskfreespace
 * @method   \ChainObject  diskfreespace()
 *
 * @see dl
 * @property \ChainObject $dl
 * @method   \ChainObject  dl()
 *
 * @see dns_check_record
 * @property \ChainObject $dns_check_record
 * @method   \ChainObject  dns_check_record(string $type = "MX")
 * @method   \ChainObject  dns_check_record1(string $hostname)
 *
 * @see doubleval
 * @property \ChainObject $doubleval
 * @method   \ChainObject  doubleval()
 *
 * @see ends_with
 * @method   \ChainObject  ends_with($with, $case_insensitivity = false)
 * @method   \ChainObject  ends_with1($string, $case_insensitivity = false)
 * @method   \ChainObject  ends_with2($string, $with)
 *
 * @see error
 * @property \ChainObject $error
 * @method   \ChainObject  error($destination = null)
 * @method   \ChainObject  error1($message)
 *
 * @see error_log
 * @property \ChainObject $error_log
 * @method   \ChainObject  error_log(int $message_type = 0, ?string $destination = null, ?string $additional_headers = null)
 * @method   \ChainObject  error_log1(string $message, ?string $destination = null, ?string $additional_headers = null)
 * @method   \ChainObject  error_log2(string $message, int $message_type = 0, ?string $additional_headers = null)
 * @method   \ChainObject  error_log3(string $message, int $message_type = 0, ?string $destination = null)
 *
 * @see error_reporting
 * @method   \ChainObject  error_reporting()
 *
 * @see escapeshellarg
 * @property \ChainObject $escapeshellarg
 * @method   \ChainObject  escapeshellarg()
 *
 * @see escapeshellcmd
 * @property \ChainObject $escapeshellcmd
 * @method   \ChainObject  escapeshellcmd()
 *
 * @see eval_func
 * @property \ChainObject $eval_func
 * @method   \ChainObject  eval_func(...$variadic)
 * @method   \ChainObject  eval_func1($expression, ...$variadic)
 * @method   \ChainObject  eval_func2($expression, ...$variadic)
 * @method   \ChainObject  eval_func3($expression, ...$variadic)
 * @method   \ChainObject  eval_func4($expression, ...$variadic)
 * @method   \ChainObject  eval_func5($expression, ...$variadic)
 * @method   \ChainObject  eval_func6($expression, ...$variadic)
 *
 * @see evaluate
 * @property \ChainObject $evaluate
 * @method   \ChainObject  evaluate($contextvars = [], $cachesize = 256)
 * @method   \ChainObject  evaluate1($phpcode, $cachesize = 256)
 * @method   \ChainObject  evaluate2($phpcode, $contextvars = [])
 *
 * @see exp
 * @property \ChainObject $exp
 * @method   \ChainObject  exp()
 *
 * @see explode
 * @method   \ChainObject  explode(string $string, int $limit = PHP_INT_MAX)
 * @method   \ChainObject  explode1(string $separator, int $limit = PHP_INT_MAX)
 * @method   \ChainObject  explode2(string $separator, string $string)
 *
 * @see expm1
 * @property \ChainObject $expm1
 * @method   \ChainObject  expm1()
 *
 * @see extension_loaded
 * @property \ChainObject $extension_loaded
 * @method   \ChainObject  extension_loaded()
 *
 * @see fclose
 * @property \ChainObject $fclose
 * @method   \ChainObject  fclose()
 *
 * @see fdiv
 * @method   \ChainObject  fdiv(float $num2)
 * @method   \ChainObject  fdiv1(float $num1)
 *
 * @see feof
 * @property \ChainObject $feof
 * @method   \ChainObject  feof()
 *
 * @see fflush
 * @property \ChainObject $fflush
 * @method   \ChainObject  fflush()
 *
 * @see fgetc
 * @property \ChainObject $fgetc
 * @method   \ChainObject  fgetc()
 *
 * @see fgetcsv
 * @property \ChainObject $fgetcsv
 * @method   \ChainObject  fgetcsv(?int $length = null, string $separator = ",", string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  fgetcsv1($stream, string $separator = ",", string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  fgetcsv2($stream, ?int $length = null, string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  fgetcsv3($stream, ?int $length = null, string $separator = ",", string $escape = "\\")
 * @method   \ChainObject  fgetcsv4($stream, ?int $length = null, string $separator = ",", string $enclosure = "\"")
 *
 * @see fgets
 * @property \ChainObject $fgets
 * @method   \ChainObject  fgets(?int $length = null)
 * @method   \ChainObject  fgets1($stream)
 *
 * @see file
 * @property \ChainObject $file
 * @method   \ChainObject  file(int $flags = 0, $context = null)
 * @method   \ChainObject  file1(string $filename, $context = null)
 * @method   \ChainObject  file2(string $filename, int $flags = 0)
 *
 * @see file_exists
 * @property \ChainObject $file_exists
 * @method   \ChainObject  file_exists()
 *
 * @see file_extension
 * @property \ChainObject $file_extension
 * @method   \ChainObject  file_extension($extension = "")
 * @method   \ChainObject  file_extension1($filename)
 *
 * @see file_get_arrays
 * @property \ChainObject $file_get_arrays
 * @method   \ChainObject  file_get_arrays($options = [])
 * @method   \ChainObject  file_get_arrays1($filename)
 *
 * @see file_get_contents
 * @property \ChainObject $file_get_contents
 * @method   \ChainObject  file_get_contents(bool $use_include_path = false, $context = null, int $offset = 0, ?int $length = null)
 * @method   \ChainObject  file_get_contents1(string $filename, $context = null, int $offset = 0, ?int $length = null)
 * @method   \ChainObject  file_get_contents2(string $filename, bool $use_include_path = false, int $offset = 0, ?int $length = null)
 * @method   \ChainObject  file_get_contents3(string $filename, bool $use_include_path = false, $context = null, ?int $length = null)
 * @method   \ChainObject  file_get_contents4(string $filename, bool $use_include_path = false, $context = null, int $offset = 0)
 *
 * @see file_list
 * @property \ChainObject $file_list
 * @method   \ChainObject  file_list($filter_condition = [])
 * @method   \ChainObject  file_list1($dirname)
 *
 * @see file_matcher
 * @property \ChainObject $file_matcher
 * @method   \ChainObject  file_matcher()
 *
 * @see file_mimetype
 * @property \ChainObject $file_mimetype
 * @method   \ChainObject  file_mimetype()
 *
 * @see file_pos
 * @method   \ChainObject  file_pos($needle, $start = 0, $end = null, $chunksize = null)
 * @method   \ChainObject  file_pos1($filename, $start = 0, $end = null, $chunksize = null)
 * @method   \ChainObject  file_pos2($filename, $needle, $end = null, $chunksize = null)
 * @method   \ChainObject  file_pos3($filename, $needle, $start = 0, $chunksize = null)
 * @method   \ChainObject  file_pos4($filename, $needle, $start = 0, $end = null)
 *
 * @see file_put_contents
 * @method   \ChainObject  file_put_contents(mixed $data, int $flags = 0, $context = null)
 * @method   \ChainObject  file_put_contents1(string $filename, int $flags = 0, $context = null)
 * @method   \ChainObject  file_put_contents2(string $filename, mixed $data, $context = null)
 * @method   \ChainObject  file_put_contents3(string $filename, mixed $data, int $flags = 0)
 *
 * @see file_rewrite_contents
 * @method   \ChainObject  file_rewrite_contents($callback, $operation = 0)
 * @method   \ChainObject  file_rewrite_contents1($filename, $operation = 0)
 * @method   \ChainObject  file_rewrite_contents2($filename, $callback)
 * @method   \ChainObject  file_rewrite_contentsP($callback, $operation = 0)
 * @method   \ChainObject  file_rewrite_contentsP1($filename, $operation = 0)
 * @method   \ChainObject  file_rewrite_contentsP2($filename, $callback)
 * @method   \ChainObject  file_rewrite_contentsE($callback, $operation = 0)
 * @method   \ChainObject  file_rewrite_contentsE1($filename, $operation = 0)
 * @method   \ChainObject  file_rewrite_contentsE2($filename, $callback)
 *
 * @see file_set_contents
 * @method   \ChainObject  file_set_contents($data, $umask = 2)
 * @method   \ChainObject  file_set_contents1($filename, $umask = 2)
 * @method   \ChainObject  file_set_contents2($filename, $data)
 *
 * @see file_set_tree
 * @method   \ChainObject  file_set_tree($contents_tree, $umask = 2)
 * @method   \ChainObject  file_set_tree1($root, $umask = 2)
 * @method   \ChainObject  file_set_tree2($root, $contents_tree)
 *
 * @see file_suffix
 * @method   \ChainObject  file_suffix($suffix)
 * @method   \ChainObject  file_suffix1($filename)
 *
 * @see file_tree
 * @property \ChainObject $file_tree
 * @method   \ChainObject  file_tree($filter_condition = [])
 * @method   \ChainObject  file_tree1($dirname)
 *
 * @see fileatime
 * @property \ChainObject $fileatime
 * @method   \ChainObject  fileatime()
 *
 * @see filectime
 * @property \ChainObject $filectime
 * @method   \ChainObject  filectime()
 *
 * @see filegroup
 * @property \ChainObject $filegroup
 * @method   \ChainObject  filegroup()
 *
 * @see fileinode
 * @property \ChainObject $fileinode
 * @method   \ChainObject  fileinode()
 *
 * @see filemtime
 * @property \ChainObject $filemtime
 * @method   \ChainObject  filemtime()
 *
 * @see fileowner
 * @property \ChainObject $fileowner
 * @method   \ChainObject  fileowner()
 *
 * @see fileperms
 * @property \ChainObject $fileperms
 * @method   \ChainObject  fileperms()
 *
 * @see filesize
 * @property \ChainObject $filesize
 * @method   \ChainObject  filesize()
 *
 * @see filetype
 * @property \ChainObject $filetype
 * @method   \ChainObject  filetype()
 *
 * @see first_key
 * @property \ChainObject $first_key
 * @method   \ChainObject  first_key($default = null)
 * @method   \ChainObject  first_key1($array)
 *
 * @see first_keyvalue
 * @property \ChainObject $first_keyvalue
 * @method   \ChainObject  first_keyvalue($default = null)
 * @method   \ChainObject  first_keyvalue1($array)
 *
 * @see first_value
 * @property \ChainObject $first_value
 * @method   \ChainObject  first_value($default = null)
 * @method   \ChainObject  first_value1($array)
 *
 * @see flagval
 * @property \ChainObject $flagval
 * @method   \ChainObject  flagval($trim = false)
 * @method   \ChainObject  flagval1($var)
 *
 * @see floatval
 * @property \ChainObject $floatval
 * @method   \ChainObject  floatval()
 *
 * @see floor
 * @property \ChainObject $floor
 * @method   \ChainObject  floor()
 *
 * @see fmod
 * @method   \ChainObject  fmod(float $num2)
 * @method   \ChainObject  fmod1(float $num1)
 *
 * @see fnmatch
 * @method   \ChainObject  fnmatch(string $filename, int $flags = 0)
 * @method   \ChainObject  fnmatch1(string $pattern, int $flags = 0)
 * @method   \ChainObject  fnmatch2(string $pattern, string $filename)
 *
 * @see fnmatch_and
 * @method   \ChainObject  fnmatch_and($string, $flags = 0)
 * @method   \ChainObject  fnmatch_and1($patterns, $flags = 0)
 * @method   \ChainObject  fnmatch_and2($patterns, $string)
 *
 * @see fnmatch_or
 * @method   \ChainObject  fnmatch_or($string, $flags = 0)
 * @method   \ChainObject  fnmatch_or1($patterns, $flags = 0)
 * @method   \ChainObject  fnmatch_or2($patterns, $string)
 *
 * @see fopen
 * @method   \ChainObject  fopen(string $mode, bool $use_include_path = false, $context = null)
 * @method   \ChainObject  fopen1(string $filename, bool $use_include_path = false, $context = null)
 * @method   \ChainObject  fopen2(string $filename, string $mode, $context = null)
 * @method   \ChainObject  fopen3(string $filename, string $mode, bool $use_include_path = false)
 *
 * @see forward_static_call
 * @property \ChainObject $forward_static_call
 * @method   \ChainObject  forward_static_call(...mixed $args)
 * @method   \ChainObject  forward_static_call1(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_call2(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_call3(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_call4(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_call5(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_call6(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callP(...mixed $args)
 * @method   \ChainObject  forward_static_callP1(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callP2(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callP3(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callP4(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callP5(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callP6(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callE(...mixed $args)
 * @method   \ChainObject  forward_static_callE1(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callE2(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callE3(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callE4(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callE5(callable $callback, ...mixed $args)
 * @method   \ChainObject  forward_static_callE6(callable $callback, ...mixed $args)
 *
 * @see forward_static_call_array
 * @method   \ChainObject  forward_static_call_array(array $args)
 * @method   \ChainObject  forward_static_call_array1(callable $callback)
 * @method   \ChainObject  forward_static_call_arrayP(array $args)
 * @method   \ChainObject  forward_static_call_arrayP1(callable $callback)
 * @method   \ChainObject  forward_static_call_arrayE(array $args)
 * @method   \ChainObject  forward_static_call_arrayE1(callable $callback)
 *
 * @see fpassthru
 * @property \ChainObject $fpassthru
 * @method   \ChainObject  fpassthru()
 *
 * @see fprintf
 * @method   \ChainObject  fprintf(string $format, ...mixed $values)
 * @method   \ChainObject  fprintf1($stream, ...mixed $values)
 * @method   \ChainObject  fprintf2($stream, string $format, ...mixed $values)
 * @method   \ChainObject  fprintf3($stream, string $format, ...mixed $values)
 * @method   \ChainObject  fprintf4($stream, string $format, ...mixed $values)
 * @method   \ChainObject  fprintf5($stream, string $format, ...mixed $values)
 * @method   \ChainObject  fprintf6($stream, string $format, ...mixed $values)
 * @method   \ChainObject  fprintf7($stream, string $format, ...mixed $values)
 *
 * @see fputcsv
 * @method   \ChainObject  fputcsv(array $fields, string $separator = ",", string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  fputcsv1($stream, string $separator = ",", string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  fputcsv2($stream, array $fields, string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  fputcsv3($stream, array $fields, string $separator = ",", string $escape = "\\")
 * @method   \ChainObject  fputcsv4($stream, array $fields, string $separator = ",", string $enclosure = "\"")
 *
 * @see fputs
 * @method   \ChainObject  fputs(string $data, ?int $length = null)
 * @method   \ChainObject  fputs1($stream, ?int $length = null)
 * @method   \ChainObject  fputs2($stream, string $data)
 *
 * @see fread
 * @method   \ChainObject  fread(int $length)
 * @method   \ChainObject  fread1($stream)
 *
 * @see fseek
 * @method   \ChainObject  fseek(int $offset, int $whence = SEEK_SET)
 * @method   \ChainObject  fseek1($stream, int $whence = SEEK_SET)
 * @method   \ChainObject  fseek2($stream, int $offset)
 *
 * @see fstat
 * @property \ChainObject $fstat
 * @method   \ChainObject  fstat()
 *
 * @see ftell
 * @property \ChainObject $ftell
 * @method   \ChainObject  ftell()
 *
 * @see ftok
 * @method   \ChainObject  ftok(string $project_id)
 * @method   \ChainObject  ftok1(string $filename)
 *
 * @see ftruncate
 * @method   \ChainObject  ftruncate(int $size)
 * @method   \ChainObject  ftruncate1($stream)
 *
 * @see func_get_arg
 * @property \ChainObject $func_get_arg
 * @method   \ChainObject  func_get_arg()
 *
 * @see func_method
 * @property \ChainObject $func_method
 * @method   \ChainObject  func_method(...$defaultargs)
 * @method   \ChainObject  func_method1($methodname, ...$defaultargs)
 * @method   \ChainObject  func_method2($methodname, ...$defaultargs)
 * @method   \ChainObject  func_method3($methodname, ...$defaultargs)
 * @method   \ChainObject  func_method4($methodname, ...$defaultargs)
 * @method   \ChainObject  func_method5($methodname, ...$defaultargs)
 * @method   \ChainObject  func_method6($methodname, ...$defaultargs)
 *
 * @see func_new
 * @property \ChainObject $func_new
 * @method   \ChainObject  func_new(...$defaultargs)
 * @method   \ChainObject  func_new1($classname, ...$defaultargs)
 * @method   \ChainObject  func_new2($classname, ...$defaultargs)
 * @method   \ChainObject  func_new3($classname, ...$defaultargs)
 * @method   \ChainObject  func_new4($classname, ...$defaultargs)
 * @method   \ChainObject  func_new5($classname, ...$defaultargs)
 * @method   \ChainObject  func_new6($classname, ...$defaultargs)
 *
 * @see func_user_func_array
 * @property \ChainObject $func_user_func_array
 * @method   \ChainObject  func_user_func_array()
 * @method   \ChainObject  func_user_func_arrayP()
 * @method   \ChainObject  func_user_func_arrayE()
 *
 * @see func_wiring
 * @method   \ChainObject  func_wiring($dependency)
 * @method   \ChainObject  func_wiring1($callable)
 * @method   \ChainObject  func_wiringP($dependency)
 * @method   \ChainObject  func_wiringP1($callable)
 * @method   \ChainObject  func_wiringE($dependency)
 * @method   \ChainObject  func_wiringE1($callable)
 *
 * @see function_alias
 * @method   \ChainObject  function_alias($alias)
 * @method   \ChainObject  function_alias1($original)
 *
 * @see function_exists
 * @property \ChainObject $function_exists
 * @method   \ChainObject  function_exists()
 *
 * @see function_parameter
 * @property \ChainObject $function_parameter
 * @method   \ChainObject  function_parameter()
 *
 * @see function_shorten
 * @property \ChainObject $function_shorten
 * @method   \ChainObject  function_shorten()
 *
 * @see fwrite
 * @method   \ChainObject  fwrite(string $data, ?int $length = null)
 * @method   \ChainObject  fwrite1($stream, ?int $length = null)
 * @method   \ChainObject  fwrite2($stream, string $data)
 *
 * @see get_browser
 * @method   \ChainObject  get_browser(bool $return_array = false)
 * @method   \ChainObject  get_browser1(?string $user_agent = null)
 *
 * @see get_cfg_var
 * @property \ChainObject $get_cfg_var
 * @method   \ChainObject  get_cfg_var()
 *
 * @see get_class
 * @method   \ChainObject  get_class()
 *
 * @see get_class_constants
 * @property \ChainObject $get_class_constants
 * @method   \ChainObject  get_class_constants($filter = null)
 * @method   \ChainObject  get_class_constants1($class)
 *
 * @see get_class_methods
 * @property \ChainObject $get_class_methods
 * @method   \ChainObject  get_class_methods()
 *
 * @see get_class_vars
 * @property \ChainObject $get_class_vars
 * @method   \ChainObject  get_class_vars()
 *
 * @see get_debug_type
 * @property \ChainObject $get_debug_type
 * @method   \ChainObject  get_debug_type()
 *
 * @see get_defined_constants
 * @method   \ChainObject  get_defined_constants()
 *
 * @see get_defined_functions
 * @method   \ChainObject  get_defined_functions()
 *
 * @see get_extension_funcs
 * @property \ChainObject $get_extension_funcs
 * @method   \ChainObject  get_extension_funcs()
 *
 * @see get_headers
 * @property \ChainObject $get_headers
 * @method   \ChainObject  get_headers(bool $associative = false, $context = null)
 * @method   \ChainObject  get_headers1(string $url, $context = null)
 * @method   \ChainObject  get_headers2(string $url, bool $associative = false)
 *
 * @see get_html_translation_table
 * @method   \ChainObject  get_html_translation_table(int $flags = ENT_COMPAT, string $encoding = "UTF-8")
 * @method   \ChainObject  get_html_translation_table1(int $table = HTML_SPECIALCHARS, string $encoding = "UTF-8")
 * @method   \ChainObject  get_html_translation_table2(int $table = HTML_SPECIALCHARS, int $flags = ENT_COMPAT)
 *
 * @see get_loaded_extensions
 * @method   \ChainObject  get_loaded_extensions()
 *
 * @see get_mangled_object_vars
 * @property \ChainObject $get_mangled_object_vars
 * @method   \ChainObject  get_mangled_object_vars()
 *
 * @see get_meta_tags
 * @property \ChainObject $get_meta_tags
 * @method   \ChainObject  get_meta_tags(bool $use_include_path = false)
 * @method   \ChainObject  get_meta_tags1(string $filename)
 *
 * @see get_object_vars
 * @property \ChainObject $get_object_vars
 * @method   \ChainObject  get_object_vars()
 *
 * @see get_parent_class
 * @method   \ChainObject  get_parent_class()
 *
 * @see get_resource_id
 * @property \ChainObject $get_resource_id
 * @method   \ChainObject  get_resource_id()
 *
 * @see get_resource_type
 * @property \ChainObject $get_resource_type
 * @method   \ChainObject  get_resource_type()
 *
 * @see get_resources
 * @method   \ChainObject  get_resources()
 *
 * @see get_uploaded_files
 * @method   \ChainObject  get_uploaded_files()
 *
 * @see getdate
 * @method   \ChainObject  getdate()
 *
 * @see getenv
 * @method   \ChainObject  getenv(bool $local_only = false)
 * @method   \ChainObject  getenv1(?string $name = null)
 *
 * @see getenvs
 * @property \ChainObject $getenvs
 * @method   \ChainObject  getenvs()
 *
 * @see gethostbyaddr
 * @property \ChainObject $gethostbyaddr
 * @method   \ChainObject  gethostbyaddr()
 *
 * @see gethostbyname
 * @property \ChainObject $gethostbyname
 * @method   \ChainObject  gethostbyname()
 *
 * @see gethostbynamel
 * @property \ChainObject $gethostbynamel
 * @method   \ChainObject  gethostbynamel()
 *
 * @see getipaddress
 * @method   \ChainObject  getipaddress()
 *
 * @see getprotobyname
 * @property \ChainObject $getprotobyname
 * @method   \ChainObject  getprotobyname()
 *
 * @see getprotobynumber
 * @property \ChainObject $getprotobynumber
 * @method   \ChainObject  getprotobynumber()
 *
 * @see getrusage
 * @method   \ChainObject  getrusage()
 *
 * @see getservbyname
 * @method   \ChainObject  getservbyname(string $protocol)
 * @method   \ChainObject  getservbyname1(string $service)
 *
 * @see getservbyport
 * @method   \ChainObject  getservbyport(string $protocol)
 * @method   \ChainObject  getservbyport1(int $port)
 *
 * @see gettimeofday
 * @method   \ChainObject  gettimeofday()
 *
 * @see gettype
 * @property \ChainObject $gettype
 * @method   \ChainObject  gettype()
 *
 * @see glob
 * @property \ChainObject $glob
 * @method   \ChainObject  glob(int $flags = 0)
 * @method   \ChainObject  glob1(string $pattern)
 *
 * @see gmdate
 * @property \ChainObject $gmdate
 * @method   \ChainObject  gmdate(?int $timestamp = null)
 * @method   \ChainObject  gmdate1(string $format)
 *
 * @see gmmktime
 * @property \ChainObject $gmmktime
 * @method   \ChainObject  gmmktime(?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null)
 * @method   \ChainObject  gmmktime1(int $hour, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null)
 * @method   \ChainObject  gmmktime2(int $hour, ?int $minute = null, ?int $month = null, ?int $day = null, ?int $year = null)
 * @method   \ChainObject  gmmktime3(int $hour, ?int $minute = null, ?int $second = null, ?int $day = null, ?int $year = null)
 * @method   \ChainObject  gmmktime4(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $year = null)
 * @method   \ChainObject  gmmktime5(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null)
 *
 * @see gmstrftime
 * @property \ChainObject $gmstrftime
 * @method   \ChainObject  gmstrftime(?int $timestamp = null)
 * @method   \ChainObject  gmstrftime1(string $format)
 *
 * @see hash
 * @method   \ChainObject  hash(string $data, bool $binary = false)
 * @method   \ChainObject  hash1(string $algo, bool $binary = false)
 * @method   \ChainObject  hash2(string $algo, string $data)
 *
 * @see hash_copy
 * @property \ChainObject $hash_copy
 * @method   \ChainObject  hash_copy()
 *
 * @see hash_equals
 * @method   \ChainObject  hash_equals(string $user_string)
 * @method   \ChainObject  hash_equals1(string $known_string)
 *
 * @see hash_file
 * @method   \ChainObject  hash_file(string $filename, bool $binary = false)
 * @method   \ChainObject  hash_file1(string $algo, bool $binary = false)
 * @method   \ChainObject  hash_file2(string $algo, string $filename)
 *
 * @see hash_final
 * @property \ChainObject $hash_final
 * @method   \ChainObject  hash_final(bool $binary = false)
 * @method   \ChainObject  hash_final1(\HashContext $context)
 *
 * @see hash_hkdf
 * @method   \ChainObject  hash_hkdf(string $key, int $length = 0, string $info = "", string $salt = "")
 * @method   \ChainObject  hash_hkdf1(string $algo, int $length = 0, string $info = "", string $salt = "")
 * @method   \ChainObject  hash_hkdf2(string $algo, string $key, string $info = "", string $salt = "")
 * @method   \ChainObject  hash_hkdf3(string $algo, string $key, int $length = 0, string $salt = "")
 * @method   \ChainObject  hash_hkdf4(string $algo, string $key, int $length = 0, string $info = "")
 *
 * @see hash_hmac
 * @method   \ChainObject  hash_hmac(string $data, string $key, bool $binary = false)
 * @method   \ChainObject  hash_hmac1(string $algo, string $key, bool $binary = false)
 * @method   \ChainObject  hash_hmac2(string $algo, string $data, bool $binary = false)
 * @method   \ChainObject  hash_hmac3(string $algo, string $data, string $key)
 *
 * @see hash_hmac_file
 * @method   \ChainObject  hash_hmac_file(string $data, string $key, bool $binary = false)
 * @method   \ChainObject  hash_hmac_file1(string $algo, string $key, bool $binary = false)
 * @method   \ChainObject  hash_hmac_file2(string $algo, string $data, bool $binary = false)
 * @method   \ChainObject  hash_hmac_file3(string $algo, string $data, string $key)
 *
 * @see hash_init
 * @property \ChainObject $hash_init
 * @method   \ChainObject  hash_init(int $flags = 0, string $key = "")
 * @method   \ChainObject  hash_init1(string $algo, string $key = "")
 * @method   \ChainObject  hash_init2(string $algo, int $flags = 0)
 *
 * @see hash_pbkdf2
 * @method   \ChainObject  hash_pbkdf2(string $password, string $salt, int $iterations, int $length = 0, bool $binary = false)
 * @method   \ChainObject  hash_pbkdf21(string $algo, string $salt, int $iterations, int $length = 0, bool $binary = false)
 * @method   \ChainObject  hash_pbkdf22(string $algo, string $password, int $iterations, int $length = 0, bool $binary = false)
 * @method   \ChainObject  hash_pbkdf23(string $algo, string $password, string $salt, int $length = 0, bool $binary = false)
 * @method   \ChainObject  hash_pbkdf24(string $algo, string $password, string $salt, int $iterations, bool $binary = false)
 * @method   \ChainObject  hash_pbkdf25(string $algo, string $password, string $salt, int $iterations, int $length = 0)
 *
 * @see hash_update
 * @method   \ChainObject  hash_update(string $data)
 * @method   \ChainObject  hash_update1(\HashContext $context)
 *
 * @see hash_update_file
 * @method   \ChainObject  hash_update_file(string $filename, $stream_context = null)
 * @method   \ChainObject  hash_update_file1(\HashContext $context, $stream_context = null)
 * @method   \ChainObject  hash_update_file2(\HashContext $context, string $filename)
 *
 * @see hash_update_stream
 * @method   \ChainObject  hash_update_stream($stream, int $length = -1)
 * @method   \ChainObject  hash_update_stream1(\HashContext $context, int $length = -1)
 * @method   \ChainObject  hash_update_stream2(\HashContext $context, $stream)
 *
 * @see hashvar
 * @method   \ChainObject  hashvar(...$vars)
 * @method   \ChainObject  hashvar1(...$vars)
 * @method   \ChainObject  hashvar2(...$vars)
 * @method   \ChainObject  hashvar3(...$vars)
 * @method   \ChainObject  hashvar4(...$vars)
 * @method   \ChainObject  hashvar5(...$vars)
 *
 * @see header
 * @property \ChainObject $header
 * @method   \ChainObject  header(bool $replace = true, int $response_code = 0)
 * @method   \ChainObject  header1(string $header, int $response_code = 0)
 * @method   \ChainObject  header2(string $header, bool $replace = true)
 *
 * @see header_register_callback
 * @property \ChainObject $header_register_callback
 * @method   \ChainObject  header_register_callback()
 * @method   \ChainObject  header_register_callbackP()
 * @method   \ChainObject  header_register_callbackE()
 *
 * @see header_remove
 * @method   \ChainObject  header_remove()
 *
 * @see hebrev
 * @property \ChainObject $hebrev
 * @method   \ChainObject  hebrev(int $max_chars_per_line = 0)
 * @method   \ChainObject  hebrev1(string $string)
 *
 * @see hex2bin
 * @property \ChainObject $hex2bin
 * @method   \ChainObject  hex2bin()
 *
 * @see hexdec
 * @property \ChainObject $hexdec
 * @method   \ChainObject  hexdec()
 *
 * @see highlight_file
 * @property \ChainObject $highlight_file
 * @method   \ChainObject  highlight_file(bool $return = false)
 * @method   \ChainObject  highlight_file1(string $filename)
 *
 * @see highlight_php
 * @property \ChainObject $highlight_php
 * @method   \ChainObject  highlight_php($options = [])
 * @method   \ChainObject  highlight_php1($phpcode)
 *
 * @see highlight_string
 * @property \ChainObject $highlight_string
 * @method   \ChainObject  highlight_string(bool $return = false)
 * @method   \ChainObject  highlight_string1(string $string)
 *
 * @see hrtime
 * @method   \ChainObject  hrtime()
 *
 * @see html_attr
 * @property \ChainObject $html_attr
 * @method   \ChainObject  html_attr($options = [])
 * @method   \ChainObject  html_attr1($array)
 *
 * @see html_entity_decode
 * @property \ChainObject $html_entity_decode
 * @method   \ChainObject  html_entity_decode(int $flags = ENT_COMPAT, ?string $encoding = null)
 * @method   \ChainObject  html_entity_decode1(string $string, ?string $encoding = null)
 * @method   \ChainObject  html_entity_decode2(string $string, int $flags = ENT_COMPAT)
 *
 * @see html_strip
 * @property \ChainObject $html_strip
 * @method   \ChainObject  html_strip($options = [])
 * @method   \ChainObject  html_strip1($html)
 *
 * @see htmlentities
 * @property \ChainObject $htmlentities
 * @method   \ChainObject  htmlentities(int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true)
 * @method   \ChainObject  htmlentities1(string $string, ?string $encoding = null, bool $double_encode = true)
 * @method   \ChainObject  htmlentities2(string $string, int $flags = ENT_COMPAT, bool $double_encode = true)
 * @method   \ChainObject  htmlentities3(string $string, int $flags = ENT_COMPAT, ?string $encoding = null)
 *
 * @see htmlspecialchars
 * @property \ChainObject $htmlspecialchars
 * @method   \ChainObject  htmlspecialchars(int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true)
 * @method   \ChainObject  htmlspecialchars1(string $string, ?string $encoding = null, bool $double_encode = true)
 * @method   \ChainObject  htmlspecialchars2(string $string, int $flags = ENT_COMPAT, bool $double_encode = true)
 * @method   \ChainObject  htmlspecialchars3(string $string, int $flags = ENT_COMPAT, ?string $encoding = null)
 *
 * @see htmlspecialchars_decode
 * @property \ChainObject $htmlspecialchars_decode
 * @method   \ChainObject  htmlspecialchars_decode(int $flags = ENT_COMPAT)
 * @method   \ChainObject  htmlspecialchars_decode1(string $string)
 *
 * @see htmltag
 * @property \ChainObject $htmltag
 * @method   \ChainObject  htmltag()
 *
 * @see http_build_query
 * @property \ChainObject $http_build_query
 * @method   \ChainObject  http_build_query(string $numeric_prefix = "", ?string $arg_separator = null, int $encoding_type = PHP_QUERY_RFC1738)
 * @method   \ChainObject  http_build_query1(object|array $data, ?string $arg_separator = null, int $encoding_type = PHP_QUERY_RFC1738)
 * @method   \ChainObject  http_build_query2(object|array $data, string $numeric_prefix = "", int $encoding_type = PHP_QUERY_RFC1738)
 * @method   \ChainObject  http_build_query3(object|array $data, string $numeric_prefix = "", ?string $arg_separator = null)
 *
 * @see http_response_code
 * @method   \ChainObject  http_response_code()
 *
 * @see hypot
 * @method   \ChainObject  hypot(float $y)
 * @method   \ChainObject  hypot1(float $x)
 *
 * @see idate
 * @property \ChainObject $idate
 * @method   \ChainObject  idate(?int $timestamp = null)
 * @method   \ChainObject  idate1(string $format)
 *
 * @see ignore_user_abort
 * @method   \ChainObject  ignore_user_abort()
 *
 * @see image_type_to_extension
 * @property \ChainObject $image_type_to_extension
 * @method   \ChainObject  image_type_to_extension(bool $include_dot = true)
 * @method   \ChainObject  image_type_to_extension1(int $image_type)
 *
 * @see image_type_to_mime_type
 * @property \ChainObject $image_type_to_mime_type
 * @method   \ChainObject  image_type_to_mime_type()
 *
 * @see implode
 * @property \ChainObject $implode
 * @method   \ChainObject  implode(?array $array = null)
 * @method   \ChainObject  implode1(array|string $separator)
 *
 * @see in_array
 * @method   \ChainObject  in_array(array $haystack, bool $strict = false)
 * @method   \ChainObject  in_array1(mixed $needle, bool $strict = false)
 * @method   \ChainObject  in_array2(mixed $needle, array $haystack)
 *
 * @see in_array_and
 * @method   \ChainObject  in_array_and($haystack, $strict = false)
 * @method   \ChainObject  in_array_and1($needle, $strict = false)
 * @method   \ChainObject  in_array_and2($needle, $haystack)
 *
 * @see in_array_or
 * @method   \ChainObject  in_array_or($haystack, $strict = false)
 * @method   \ChainObject  in_array_or1($needle, $strict = false)
 * @method   \ChainObject  in_array_or2($needle, $haystack)
 *
 * @see incidr
 * @method   \ChainObject  incidr($cidr)
 * @method   \ChainObject  incidr1($ipaddr)
 *
 * @see include_string
 * @property \ChainObject $include_string
 * @method   \ChainObject  include_string($array = [])
 * @method   \ChainObject  include_string1($template)
 *
 * @see indent_php
 * @property \ChainObject $indent_php
 * @method   \ChainObject  indent_php($options = [])
 * @method   \ChainObject  indent_php1($phpcode)
 *
 * @see inet_ntop
 * @property \ChainObject $inet_ntop
 * @method   \ChainObject  inet_ntop()
 *
 * @see inet_pton
 * @property \ChainObject $inet_pton
 * @method   \ChainObject  inet_pton()
 *
 * @see ini_alter
 * @method   \ChainObject  ini_alter(string $value)
 * @method   \ChainObject  ini_alter1(string $option)
 *
 * @see ini_export
 * @property \ChainObject $ini_export
 * @method   \ChainObject  ini_export($options = [])
 * @method   \ChainObject  ini_export1($iniarray)
 *
 * @see ini_get
 * @property \ChainObject $ini_get
 * @method   \ChainObject  ini_get()
 *
 * @see ini_get_all
 * @method   \ChainObject  ini_get_all(bool $details = true)
 * @method   \ChainObject  ini_get_all1(?string $extension = null)
 *
 * @see ini_import
 * @property \ChainObject $ini_import
 * @method   \ChainObject  ini_import($options = [])
 * @method   \ChainObject  ini_import1($inistring)
 *
 * @see ini_restore
 * @property \ChainObject $ini_restore
 * @method   \ChainObject  ini_restore()
 *
 * @see ini_set
 * @method   \ChainObject  ini_set(string $value)
 * @method   \ChainObject  ini_set1(string $option)
 *
 * @see ini_sets
 * @property \ChainObject $ini_sets
 * @method   \ChainObject  ini_sets()
 *
 * @see intdiv
 * @method   \ChainObject  intdiv(int $num2)
 * @method   \ChainObject  intdiv1(int $num1)
 *
 * @see interface_exists
 * @property \ChainObject $interface_exists
 * @method   \ChainObject  interface_exists(bool $autoload = true)
 * @method   \ChainObject  interface_exists1(string $interface)
 *
 * @see intval
 * @property \ChainObject $intval
 * @method   \ChainObject  intval(int $base = 10)
 * @method   \ChainObject  intval1(mixed $value)
 *
 * @see ip2long
 * @property \ChainObject $ip2long
 * @method   \ChainObject  ip2long()
 *
 * @see iptcembed
 * @method   \ChainObject  iptcembed(string $filename, int $spool = 0)
 * @method   \ChainObject  iptcembed1(string $iptc_data, int $spool = 0)
 * @method   \ChainObject  iptcembed2(string $iptc_data, string $filename)
 *
 * @see iptcparse
 * @property \ChainObject $iptcparse
 * @method   \ChainObject  iptcparse()
 *
 * @see is_a
 * @method   \ChainObject  is_a(string $class, bool $allow_string = false)
 * @method   \ChainObject  is_a1(mixed $object_or_class, bool $allow_string = false)
 * @method   \ChainObject  is_a2(mixed $object_or_class, string $class)
 *
 * @see is_ansi
 * @property \ChainObject $is_ansi
 * @method   \ChainObject  is_ansi()
 *
 * @see is_array
 * @property \ChainObject $is_array
 * @method   \ChainObject  is_array()
 *
 * @see is_arrayable
 * @property \ChainObject $is_arrayable
 * @method   \ChainObject  is_arrayable()
 *
 * @see is_bindable_closure
 * @property \ChainObject $is_bindable_closure
 * @method   \ChainObject  is_bindable_closure()
 * @method   \ChainObject  is_bindable_closureP()
 * @method   \ChainObject  is_bindable_closureE()
 *
 * @see is_bool
 * @property \ChainObject $is_bool
 * @method   \ChainObject  is_bool()
 *
 * @see is_countable
 * @property \ChainObject $is_countable
 * @method   \ChainObject  is_countable()
 *
 * @see is_dir
 * @property \ChainObject $is_dir
 * @method   \ChainObject  is_dir()
 *
 * @see is_double
 * @property \ChainObject $is_double
 * @method   \ChainObject  is_double()
 *
 * @see is_empty
 * @property \ChainObject $is_empty
 * @method   \ChainObject  is_empty($empty_stdClass = false)
 * @method   \ChainObject  is_empty1($var)
 *
 * @see is_executable
 * @property \ChainObject $is_executable
 * @method   \ChainObject  is_executable()
 *
 * @see is_file
 * @property \ChainObject $is_file
 * @method   \ChainObject  is_file()
 *
 * @see is_finite
 * @property \ChainObject $is_finite
 * @method   \ChainObject  is_finite()
 *
 * @see is_float
 * @property \ChainObject $is_float
 * @method   \ChainObject  is_float()
 *
 * @see is_hasharray
 * @property \ChainObject $is_hasharray
 * @method   \ChainObject  is_hasharray()
 *
 * @see is_indexarray
 * @property \ChainObject $is_indexarray
 * @method   \ChainObject  is_indexarray()
 *
 * @see is_infinite
 * @property \ChainObject $is_infinite
 * @method   \ChainObject  is_infinite()
 *
 * @see is_int
 * @property \ChainObject $is_int
 * @method   \ChainObject  is_int()
 *
 * @see is_integer
 * @property \ChainObject $is_integer
 * @method   \ChainObject  is_integer()
 *
 * @see is_iterable
 * @property \ChainObject $is_iterable
 * @method   \ChainObject  is_iterable()
 *
 * @see is_link
 * @property \ChainObject $is_link
 * @method   \ChainObject  is_link()
 *
 * @see is_long
 * @property \ChainObject $is_long
 * @method   \ChainObject  is_long()
 *
 * @see is_nan
 * @property \ChainObject $is_nan
 * @method   \ChainObject  is_nan()
 *
 * @see is_null
 * @property \ChainObject $is_null
 * @method   \ChainObject  is_null()
 *
 * @see is_numeric
 * @property \ChainObject $is_numeric
 * @method   \ChainObject  is_numeric()
 *
 * @see is_object
 * @property \ChainObject $is_object
 * @method   \ChainObject  is_object()
 *
 * @see is_primitive
 * @property \ChainObject $is_primitive
 * @method   \ChainObject  is_primitive()
 *
 * @see is_readable
 * @property \ChainObject $is_readable
 * @method   \ChainObject  is_readable()
 *
 * @see is_recursive
 * @property \ChainObject $is_recursive
 * @method   \ChainObject  is_recursive()
 *
 * @see is_resource
 * @property \ChainObject $is_resource
 * @method   \ChainObject  is_resource()
 *
 * @see is_scalar
 * @property \ChainObject $is_scalar
 * @method   \ChainObject  is_scalar()
 *
 * @see is_string
 * @property \ChainObject $is_string
 * @method   \ChainObject  is_string()
 *
 * @see is_stringable
 * @property \ChainObject $is_stringable
 * @method   \ChainObject  is_stringable()
 *
 * @see is_subclass_of
 * @method   \ChainObject  is_subclass_of(string $class, bool $allow_string = true)
 * @method   \ChainObject  is_subclass_of1(mixed $object_or_class, bool $allow_string = true)
 * @method   \ChainObject  is_subclass_of2(mixed $object_or_class, string $class)
 *
 * @see is_uploaded_file
 * @property \ChainObject $is_uploaded_file
 * @method   \ChainObject  is_uploaded_file()
 *
 * @see is_writable
 * @property \ChainObject $is_writable
 * @method   \ChainObject  is_writable()
 *
 * @see is_writeable
 * @property \ChainObject $is_writeable
 * @method   \ChainObject  is_writeable()
 *
 * @see join
 * @property \ChainObject $join
 * @method   \ChainObject  join(?array $array = null)
 * @method   \ChainObject  join1(array|string $separator)
 *
 * @see json_export
 * @property \ChainObject $json_export
 * @method   \ChainObject  json_export($options = [])
 * @method   \ChainObject  json_export1($value)
 *
 * @see json_import
 * @property \ChainObject $json_import
 * @method   \ChainObject  json_import($options = [])
 * @method   \ChainObject  json_import1($value)
 *
 * @see key
 * @property \ChainObject $key
 * @method   \ChainObject  key()
 *
 * @see key_exists
 * @method   \ChainObject  key_exists(array $array)
 * @method   \ChainObject  key_exists1($key)
 *
 * @see kvsort
 * @property \ChainObject $kvsort
 * @method   \ChainObject  kvsort($comparator = null)
 * @method   \ChainObject  kvsort1($array)
 *
 * @see kvsprintf
 * @method   \ChainObject  kvsprintf(array $array)
 * @method   \ChainObject  kvsprintf1($format)
 *
 * @see last_key
 * @property \ChainObject $last_key
 * @method   \ChainObject  last_key($default = null)
 * @method   \ChainObject  last_key1($array)
 *
 * @see last_keyvalue
 * @property \ChainObject $last_keyvalue
 * @method   \ChainObject  last_keyvalue($default = null)
 * @method   \ChainObject  last_keyvalue1($array)
 *
 * @see last_value
 * @property \ChainObject $last_value
 * @method   \ChainObject  last_value($default = null)
 * @method   \ChainObject  last_value1($array)
 *
 * @see lbind
 * @property \ChainObject $lbind
 * @method   \ChainObject  lbind(...$variadic)
 * @method   \ChainObject  lbind1($callable, ...$variadic)
 * @method   \ChainObject  lbind2($callable, ...$variadic)
 * @method   \ChainObject  lbind3($callable, ...$variadic)
 * @method   \ChainObject  lbind4($callable, ...$variadic)
 * @method   \ChainObject  lbind5($callable, ...$variadic)
 * @method   \ChainObject  lbind6($callable, ...$variadic)
 * @method   \ChainObject  lbindP(...$variadic)
 * @method   \ChainObject  lbindP1($callable, ...$variadic)
 * @method   \ChainObject  lbindP2($callable, ...$variadic)
 * @method   \ChainObject  lbindP3($callable, ...$variadic)
 * @method   \ChainObject  lbindP4($callable, ...$variadic)
 * @method   \ChainObject  lbindP5($callable, ...$variadic)
 * @method   \ChainObject  lbindP6($callable, ...$variadic)
 * @method   \ChainObject  lbindE(...$variadic)
 * @method   \ChainObject  lbindE1($callable, ...$variadic)
 * @method   \ChainObject  lbindE2($callable, ...$variadic)
 * @method   \ChainObject  lbindE3($callable, ...$variadic)
 * @method   \ChainObject  lbindE4($callable, ...$variadic)
 * @method   \ChainObject  lbindE5($callable, ...$variadic)
 * @method   \ChainObject  lbindE6($callable, ...$variadic)
 *
 * @see lcfirst
 * @property \ChainObject $lcfirst
 * @method   \ChainObject  lcfirst()
 *
 * @see lchgrp
 * @method   \ChainObject  lchgrp(string|int $group)
 * @method   \ChainObject  lchgrp1(string $filename)
 *
 * @see lchown
 * @method   \ChainObject  lchown(string|int $user)
 * @method   \ChainObject  lchown1(string $filename)
 *
 * @see levenshtein
 * @method   \ChainObject  levenshtein(string $string2, int $insertion_cost = 1, int $replacement_cost = 1, int $deletion_cost = 1)
 * @method   \ChainObject  levenshtein1(string $string1, int $insertion_cost = 1, int $replacement_cost = 1, int $deletion_cost = 1)
 * @method   \ChainObject  levenshtein2(string $string1, string $string2, int $replacement_cost = 1, int $deletion_cost = 1)
 * @method   \ChainObject  levenshtein3(string $string1, string $string2, int $insertion_cost = 1, int $deletion_cost = 1)
 * @method   \ChainObject  levenshtein4(string $string1, string $string2, int $insertion_cost = 1, int $replacement_cost = 1)
 *
 * @see link
 * @method   \ChainObject  link(string $link)
 * @method   \ChainObject  link1(string $target)
 *
 * @see linkinfo
 * @property \ChainObject $linkinfo
 * @method   \ChainObject  linkinfo()
 *
 * @see localtime
 * @method   \ChainObject  localtime(bool $associative = false)
 * @method   \ChainObject  localtime1(?int $timestamp = null)
 *
 * @see log
 * @property \ChainObject $log
 * @method   \ChainObject  log(float $base = M_E)
 * @method   \ChainObject  log1(float $num)
 *
 * @see log10
 * @property \ChainObject $log10
 * @method   \ChainObject  log10()
 *
 * @see log1p
 * @property \ChainObject $log1p
 * @method   \ChainObject  log1p()
 *
 * @see long2ip
 * @property \ChainObject $long2ip
 * @method   \ChainObject  long2ip()
 *
 * @see lstat
 * @property \ChainObject $lstat
 * @method   \ChainObject  lstat()
 *
 * @see ltrim
 * @property \ChainObject $ltrim
 * @method   \ChainObject  ltrim(string $characters = " 
	\000")
 * @method   \ChainObject  ltrim1(string $string)
 *
 * @see ltsv_export
 * @property \ChainObject $ltsv_export
 * @method   \ChainObject  ltsv_export($options = [])
 * @method   \ChainObject  ltsv_export1($ltsvarray)
 *
 * @see ltsv_import
 * @property \ChainObject $ltsv_import
 * @method   \ChainObject  ltsv_import($options = [])
 * @method   \ChainObject  ltsv_import1($ltsvstring)
 *
 * @see mail
 * @method   \ChainObject  mail(string $subject, string $message, array|string $additional_headers = [], string $additional_params = "")
 * @method   \ChainObject  mail1(string $to, string $message, array|string $additional_headers = [], string $additional_params = "")
 * @method   \ChainObject  mail2(string $to, string $subject, array|string $additional_headers = [], string $additional_params = "")
 * @method   \ChainObject  mail3(string $to, string $subject, string $message, string $additional_params = "")
 * @method   \ChainObject  mail4(string $to, string $subject, string $message, array|string $additional_headers = [])
 *
 * @see markdown_list
 * @property \ChainObject $markdown_list
 * @method   \ChainObject  markdown_list($option = [])
 * @method   \ChainObject  markdown_list1($array)
 *
 * @see markdown_table
 * @property \ChainObject $markdown_table
 * @method   \ChainObject  markdown_table($option = [])
 * @method   \ChainObject  markdown_table1($array)
 *
 * @see max
 * @property \ChainObject $max
 * @method   \ChainObject  max(...mixed $values)
 * @method   \ChainObject  max1(mixed $value, ...mixed $values)
 * @method   \ChainObject  max2(mixed $value, ...mixed $values)
 * @method   \ChainObject  max3(mixed $value, ...mixed $values)
 * @method   \ChainObject  max4(mixed $value, ...mixed $values)
 * @method   \ChainObject  max5(mixed $value, ...mixed $values)
 * @method   \ChainObject  max6(mixed $value, ...mixed $values)
 *
 * @see maximum
 * @method   \ChainObject  maximum(...$variadic)
 * @method   \ChainObject  maximum1(...$variadic)
 * @method   \ChainObject  maximum2(...$variadic)
 * @method   \ChainObject  maximum3(...$variadic)
 * @method   \ChainObject  maximum4(...$variadic)
 * @method   \ChainObject  maximum5(...$variadic)
 *
 * @see mb_check_encoding
 * @method   \ChainObject  mb_check_encoding(?string $encoding = null)
 * @method   \ChainObject  mb_check_encoding1(array|string|null $value = null)
 *
 * @see mb_chr
 * @property \ChainObject $mb_chr
 * @method   \ChainObject  mb_chr(?string $encoding = null)
 * @method   \ChainObject  mb_chr1(int $codepoint)
 *
 * @see mb_convert_case
 * @method   \ChainObject  mb_convert_case(int $mode, ?string $encoding = null)
 * @method   \ChainObject  mb_convert_case1(string $string, ?string $encoding = null)
 * @method   \ChainObject  mb_convert_case2(string $string, int $mode)
 *
 * @see mb_convert_encoding
 * @method   \ChainObject  mb_convert_encoding(string $to_encoding, array|string|null $from_encoding = null)
 * @method   \ChainObject  mb_convert_encoding1(array|string $string, array|string|null $from_encoding = null)
 * @method   \ChainObject  mb_convert_encoding2(array|string $string, string $to_encoding)
 *
 * @see mb_convert_kana
 * @property \ChainObject $mb_convert_kana
 * @method   \ChainObject  mb_convert_kana(string $mode = "KV", ?string $encoding = null)
 * @method   \ChainObject  mb_convert_kana1(string $string, ?string $encoding = null)
 * @method   \ChainObject  mb_convert_kana2(string $string, string $mode = "KV")
 *
 * @see mb_decode_mimeheader
 * @property \ChainObject $mb_decode_mimeheader
 * @method   \ChainObject  mb_decode_mimeheader()
 *
 * @see mb_decode_numericentity
 * @method   \ChainObject  mb_decode_numericentity(array $map, ?string $encoding = null)
 * @method   \ChainObject  mb_decode_numericentity1(string $string, ?string $encoding = null)
 * @method   \ChainObject  mb_decode_numericentity2(string $string, array $map)
 *
 * @see mb_detect_encoding
 * @property \ChainObject $mb_detect_encoding
 * @method   \ChainObject  mb_detect_encoding(array|string|null $encodings = null, bool $strict = false)
 * @method   \ChainObject  mb_detect_encoding1(string $string, bool $strict = false)
 * @method   \ChainObject  mb_detect_encoding2(string $string, array|string|null $encodings = null)
 *
 * @see mb_detect_order
 * @method   \ChainObject  mb_detect_order()
 *
 * @see mb_ellipsis
 * @method   \ChainObject  mb_ellipsis($width, $trimmarker = "...", $pos = null)
 * @method   \ChainObject  mb_ellipsis1($string, $trimmarker = "...", $pos = null)
 * @method   \ChainObject  mb_ellipsis2($string, $width, $pos = null)
 * @method   \ChainObject  mb_ellipsis3($string, $width, $trimmarker = "...")
 *
 * @see mb_encode_mimeheader
 * @property \ChainObject $mb_encode_mimeheader
 * @method   \ChainObject  mb_encode_mimeheader(?string $charset = null, ?string $transfer_encoding = null, string $newline = "
", int $indent = 0)
 * @method   \ChainObject  mb_encode_mimeheader1(string $string, ?string $transfer_encoding = null, string $newline = "
", int $indent = 0)
 * @method   \ChainObject  mb_encode_mimeheader2(string $string, ?string $charset = null, string $newline = "
", int $indent = 0)
 * @method   \ChainObject  mb_encode_mimeheader3(string $string, ?string $charset = null, ?string $transfer_encoding = null, int $indent = 0)
 * @method   \ChainObject  mb_encode_mimeheader4(string $string, ?string $charset = null, ?string $transfer_encoding = null, string $newline = "
")
 *
 * @see mb_encode_numericentity
 * @method   \ChainObject  mb_encode_numericentity(array $map, ?string $encoding = null, bool $hex = false)
 * @method   \ChainObject  mb_encode_numericentity1(string $string, ?string $encoding = null, bool $hex = false)
 * @method   \ChainObject  mb_encode_numericentity2(string $string, array $map, bool $hex = false)
 * @method   \ChainObject  mb_encode_numericentity3(string $string, array $map, ?string $encoding = null)
 *
 * @see mb_encoding_aliases
 * @property \ChainObject $mb_encoding_aliases
 * @method   \ChainObject  mb_encoding_aliases()
 *
 * @see mb_ereg_match
 * @method   \ChainObject  mb_ereg_match(string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_match1(string $pattern, ?string $options = null)
 * @method   \ChainObject  mb_ereg_match2(string $pattern, string $string)
 *
 * @see mb_ereg_replace
 * @method   \ChainObject  mb_ereg_replace(string $replacement, string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace1(string $pattern, string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace2(string $pattern, string $replacement, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace3(string $pattern, string $replacement, string $string)
 *
 * @see mb_ereg_replace_callback
 * @method   \ChainObject  mb_ereg_replace_callback(callable $callback, string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace_callback1(string $pattern, string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace_callback2(string $pattern, callable $callback, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace_callback3(string $pattern, callable $callback, string $string)
 * @method   \ChainObject  mb_ereg_replace_callbackP(callable $callback, string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace_callbackP1(string $pattern, string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace_callbackP2(string $pattern, callable $callback, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace_callbackP3(string $pattern, callable $callback, string $string)
 * @method   \ChainObject  mb_ereg_replace_callbackE(callable $callback, string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace_callbackE1(string $pattern, string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace_callbackE2(string $pattern, callable $callback, ?string $options = null)
 * @method   \ChainObject  mb_ereg_replace_callbackE3(string $pattern, callable $callback, string $string)
 *
 * @see mb_ereg_search
 * @method   \ChainObject  mb_ereg_search(?string $options = null)
 * @method   \ChainObject  mb_ereg_search1(?string $pattern = null)
 *
 * @see mb_ereg_search_init
 * @property \ChainObject $mb_ereg_search_init
 * @method   \ChainObject  mb_ereg_search_init(?string $pattern = null, ?string $options = null)
 * @method   \ChainObject  mb_ereg_search_init1(string $string, ?string $options = null)
 * @method   \ChainObject  mb_ereg_search_init2(string $string, ?string $pattern = null)
 *
 * @see mb_ereg_search_pos
 * @method   \ChainObject  mb_ereg_search_pos(?string $options = null)
 * @method   \ChainObject  mb_ereg_search_pos1(?string $pattern = null)
 *
 * @see mb_ereg_search_regs
 * @method   \ChainObject  mb_ereg_search_regs(?string $options = null)
 * @method   \ChainObject  mb_ereg_search_regs1(?string $pattern = null)
 *
 * @see mb_ereg_search_setpos
 * @property \ChainObject $mb_ereg_search_setpos
 * @method   \ChainObject  mb_ereg_search_setpos()
 *
 * @see mb_eregi_replace
 * @method   \ChainObject  mb_eregi_replace(string $replacement, string $string, ?string $options = null)
 * @method   \ChainObject  mb_eregi_replace1(string $pattern, string $string, ?string $options = null)
 * @method   \ChainObject  mb_eregi_replace2(string $pattern, string $replacement, ?string $options = null)
 * @method   \ChainObject  mb_eregi_replace3(string $pattern, string $replacement, string $string)
 *
 * @see mb_get_info
 * @method   \ChainObject  mb_get_info()
 *
 * @see mb_http_input
 * @method   \ChainObject  mb_http_input()
 *
 * @see mb_http_output
 * @method   \ChainObject  mb_http_output()
 *
 * @see mb_internal_encoding
 * @method   \ChainObject  mb_internal_encoding()
 *
 * @see mb_language
 * @method   \ChainObject  mb_language()
 *
 * @see mb_ord
 * @property \ChainObject $mb_ord
 * @method   \ChainObject  mb_ord(?string $encoding = null)
 * @method   \ChainObject  mb_ord1(string $string)
 *
 * @see mb_output_handler
 * @method   \ChainObject  mb_output_handler(int $status)
 * @method   \ChainObject  mb_output_handler1(string $string)
 *
 * @see mb_preferred_mime_name
 * @property \ChainObject $mb_preferred_mime_name
 * @method   \ChainObject  mb_preferred_mime_name()
 *
 * @see mb_regex_encoding
 * @method   \ChainObject  mb_regex_encoding()
 *
 * @see mb_regex_set_options
 * @method   \ChainObject  mb_regex_set_options()
 *
 * @see mb_scrub
 * @property \ChainObject $mb_scrub
 * @method   \ChainObject  mb_scrub(?string $encoding = null)
 * @method   \ChainObject  mb_scrub1(string $string)
 *
 * @see mb_send_mail
 * @method   \ChainObject  mb_send_mail(string $subject, string $message, array|string $additional_headers = [], ?string $additional_params = null)
 * @method   \ChainObject  mb_send_mail1(string $to, string $message, array|string $additional_headers = [], ?string $additional_params = null)
 * @method   \ChainObject  mb_send_mail2(string $to, string $subject, array|string $additional_headers = [], ?string $additional_params = null)
 * @method   \ChainObject  mb_send_mail3(string $to, string $subject, string $message, ?string $additional_params = null)
 * @method   \ChainObject  mb_send_mail4(string $to, string $subject, string $message, array|string $additional_headers = [])
 *
 * @see mb_split
 * @method   \ChainObject  mb_split(string $string, int $limit = -1)
 * @method   \ChainObject  mb_split1(string $pattern, int $limit = -1)
 * @method   \ChainObject  mb_split2(string $pattern, string $string)
 *
 * @see mb_str_pad
 * @method   \ChainObject  mb_str_pad($width, $pad_string = " ", $pad_type = STR_PAD_RIGHT)
 * @method   \ChainObject  mb_str_pad1($string, $pad_string = " ", $pad_type = STR_PAD_RIGHT)
 * @method   \ChainObject  mb_str_pad2($string, $width, $pad_type = STR_PAD_RIGHT)
 * @method   \ChainObject  mb_str_pad3($string, $width, $pad_string = " ")
 *
 * @see mb_str_split
 * @property \ChainObject $mb_str_split
 * @method   \ChainObject  mb_str_split(int $length = 1, ?string $encoding = null)
 * @method   \ChainObject  mb_str_split1(string $string, ?string $encoding = null)
 * @method   \ChainObject  mb_str_split2(string $string, int $length = 1)
 *
 * @see mb_strcut
 * @method   \ChainObject  mb_strcut(int $start, ?int $length = null, ?string $encoding = null)
 * @method   \ChainObject  mb_strcut1(string $string, ?int $length = null, ?string $encoding = null)
 * @method   \ChainObject  mb_strcut2(string $string, int $start, ?string $encoding = null)
 * @method   \ChainObject  mb_strcut3(string $string, int $start, ?int $length = null)
 *
 * @see mb_strimwidth
 * @method   \ChainObject  mb_strimwidth(int $start, int $width, string $trim_marker = "", ?string $encoding = null)
 * @method   \ChainObject  mb_strimwidth1(string $string, int $width, string $trim_marker = "", ?string $encoding = null)
 * @method   \ChainObject  mb_strimwidth2(string $string, int $start, string $trim_marker = "", ?string $encoding = null)
 * @method   \ChainObject  mb_strimwidth3(string $string, int $start, int $width, ?string $encoding = null)
 * @method   \ChainObject  mb_strimwidth4(string $string, int $start, int $width, string $trim_marker = "")
 *
 * @see mb_stripos
 * @method   \ChainObject  mb_stripos(string $needle, int $offset = 0, ?string $encoding = null)
 * @method   \ChainObject  mb_stripos1(string $haystack, int $offset = 0, ?string $encoding = null)
 * @method   \ChainObject  mb_stripos2(string $haystack, string $needle, ?string $encoding = null)
 * @method   \ChainObject  mb_stripos3(string $haystack, string $needle, int $offset = 0)
 *
 * @see mb_stristr
 * @method   \ChainObject  mb_stristr(string $needle, bool $before_needle = false, ?string $encoding = null)
 * @method   \ChainObject  mb_stristr1(string $haystack, bool $before_needle = false, ?string $encoding = null)
 * @method   \ChainObject  mb_stristr2(string $haystack, string $needle, ?string $encoding = null)
 * @method   \ChainObject  mb_stristr3(string $haystack, string $needle, bool $before_needle = false)
 *
 * @see mb_strlen
 * @property \ChainObject $mb_strlen
 * @method   \ChainObject  mb_strlen(?string $encoding = null)
 * @method   \ChainObject  mb_strlen1(string $string)
 *
 * @see mb_strpos
 * @method   \ChainObject  mb_strpos(string $needle, int $offset = 0, ?string $encoding = null)
 * @method   \ChainObject  mb_strpos1(string $haystack, int $offset = 0, ?string $encoding = null)
 * @method   \ChainObject  mb_strpos2(string $haystack, string $needle, ?string $encoding = null)
 * @method   \ChainObject  mb_strpos3(string $haystack, string $needle, int $offset = 0)
 *
 * @see mb_strrchr
 * @method   \ChainObject  mb_strrchr(string $needle, bool $before_needle = false, ?string $encoding = null)
 * @method   \ChainObject  mb_strrchr1(string $haystack, bool $before_needle = false, ?string $encoding = null)
 * @method   \ChainObject  mb_strrchr2(string $haystack, string $needle, ?string $encoding = null)
 * @method   \ChainObject  mb_strrchr3(string $haystack, string $needle, bool $before_needle = false)
 *
 * @see mb_strrichr
 * @method   \ChainObject  mb_strrichr(string $needle, bool $before_needle = false, ?string $encoding = null)
 * @method   \ChainObject  mb_strrichr1(string $haystack, bool $before_needle = false, ?string $encoding = null)
 * @method   \ChainObject  mb_strrichr2(string $haystack, string $needle, ?string $encoding = null)
 * @method   \ChainObject  mb_strrichr3(string $haystack, string $needle, bool $before_needle = false)
 *
 * @see mb_strripos
 * @method   \ChainObject  mb_strripos(string $needle, int $offset = 0, ?string $encoding = null)
 * @method   \ChainObject  mb_strripos1(string $haystack, int $offset = 0, ?string $encoding = null)
 * @method   \ChainObject  mb_strripos2(string $haystack, string $needle, ?string $encoding = null)
 * @method   \ChainObject  mb_strripos3(string $haystack, string $needle, int $offset = 0)
 *
 * @see mb_strrpos
 * @method   \ChainObject  mb_strrpos(string $needle, int $offset = 0, ?string $encoding = null)
 * @method   \ChainObject  mb_strrpos1(string $haystack, int $offset = 0, ?string $encoding = null)
 * @method   \ChainObject  mb_strrpos2(string $haystack, string $needle, ?string $encoding = null)
 * @method   \ChainObject  mb_strrpos3(string $haystack, string $needle, int $offset = 0)
 *
 * @see mb_strstr
 * @method   \ChainObject  mb_strstr(string $needle, bool $before_needle = false, ?string $encoding = null)
 * @method   \ChainObject  mb_strstr1(string $haystack, bool $before_needle = false, ?string $encoding = null)
 * @method   \ChainObject  mb_strstr2(string $haystack, string $needle, ?string $encoding = null)
 * @method   \ChainObject  mb_strstr3(string $haystack, string $needle, bool $before_needle = false)
 *
 * @see mb_strtolower
 * @property \ChainObject $mb_strtolower
 * @method   \ChainObject  mb_strtolower(?string $encoding = null)
 * @method   \ChainObject  mb_strtolower1(string $string)
 *
 * @see mb_strtoupper
 * @property \ChainObject $mb_strtoupper
 * @method   \ChainObject  mb_strtoupper(?string $encoding = null)
 * @method   \ChainObject  mb_strtoupper1(string $string)
 *
 * @see mb_strwidth
 * @property \ChainObject $mb_strwidth
 * @method   \ChainObject  mb_strwidth(?string $encoding = null)
 * @method   \ChainObject  mb_strwidth1(string $string)
 *
 * @see mb_substitute_character
 * @method   \ChainObject  mb_substitute_character()
 *
 * @see mb_substr
 * @method   \ChainObject  mb_substr(int $start, ?int $length = null, ?string $encoding = null)
 * @method   \ChainObject  mb_substr1(string $string, ?int $length = null, ?string $encoding = null)
 * @method   \ChainObject  mb_substr2(string $string, int $start, ?string $encoding = null)
 * @method   \ChainObject  mb_substr3(string $string, int $start, ?int $length = null)
 *
 * @see mb_substr_count
 * @method   \ChainObject  mb_substr_count(string $needle, ?string $encoding = null)
 * @method   \ChainObject  mb_substr_count1(string $haystack, ?string $encoding = null)
 * @method   \ChainObject  mb_substr_count2(string $haystack, string $needle)
 *
 * @see mb_substr_replace
 * @method   \ChainObject  mb_substr_replace($replacement, $start, $length = null)
 * @method   \ChainObject  mb_substr_replace1($string, $start, $length = null)
 * @method   \ChainObject  mb_substr_replace2($string, $replacement, $length = null)
 * @method   \ChainObject  mb_substr_replace3($string, $replacement, $start)
 *
 * @see mb_trim
 * @property \ChainObject $mb_trim
 * @method   \ChainObject  mb_trim()
 *
 * @see md5
 * @property \ChainObject $md5
 * @method   \ChainObject  md5(bool $binary = false)
 * @method   \ChainObject  md51(string $string)
 *
 * @see md5_file
 * @property \ChainObject $md5_file
 * @method   \ChainObject  md5_file(bool $binary = false)
 * @method   \ChainObject  md5_file1(string $filename)
 *
 * @see mean
 * @method   \ChainObject  mean(...$variadic)
 * @method   \ChainObject  mean1(...$variadic)
 * @method   \ChainObject  mean2(...$variadic)
 * @method   \ChainObject  mean3(...$variadic)
 * @method   \ChainObject  mean4(...$variadic)
 * @method   \ChainObject  mean5(...$variadic)
 *
 * @see median
 * @method   \ChainObject  median(...$variadic)
 * @method   \ChainObject  median1(...$variadic)
 * @method   \ChainObject  median2(...$variadic)
 * @method   \ChainObject  median3(...$variadic)
 * @method   \ChainObject  median4(...$variadic)
 * @method   \ChainObject  median5(...$variadic)
 *
 * @see memory_get_peak_usage
 * @method   \ChainObject  memory_get_peak_usage()
 *
 * @see memory_get_usage
 * @method   \ChainObject  memory_get_usage()
 *
 * @see memory_path
 * @property \ChainObject $memory_path
 * @method   \ChainObject  memory_path()
 *
 * @see metaphone
 * @property \ChainObject $metaphone
 * @method   \ChainObject  metaphone(int $max_phonemes = 0)
 * @method   \ChainObject  metaphone1(string $string)
 *
 * @see method_exists
 * @method   \ChainObject  method_exists(string $method)
 * @method   \ChainObject  method_exists1($object_or_class)
 *
 * @see mhash
 * @method   \ChainObject  mhash(string $data, ?string $key = null)
 * @method   \ChainObject  mhash1(int $algo, ?string $key = null)
 * @method   \ChainObject  mhash2(int $algo, string $data)
 *
 * @see mhash_get_block_size
 * @property \ChainObject $mhash_get_block_size
 * @method   \ChainObject  mhash_get_block_size()
 *
 * @see mhash_get_hash_name
 * @property \ChainObject $mhash_get_hash_name
 * @method   \ChainObject  mhash_get_hash_name()
 *
 * @see mhash_keygen_s2k
 * @method   \ChainObject  mhash_keygen_s2k(string $password, string $salt, int $length)
 * @method   \ChainObject  mhash_keygen_s2k1(int $algo, string $salt, int $length)
 * @method   \ChainObject  mhash_keygen_s2k2(int $algo, string $password, int $length)
 * @method   \ChainObject  mhash_keygen_s2k3(int $algo, string $password, string $salt)
 *
 * @see microtime
 * @method   \ChainObject  microtime()
 *
 * @see min
 * @property \ChainObject $min
 * @method   \ChainObject  min(...mixed $values)
 * @method   \ChainObject  min1(mixed $value, ...mixed $values)
 * @method   \ChainObject  min2(mixed $value, ...mixed $values)
 * @method   \ChainObject  min3(mixed $value, ...mixed $values)
 * @method   \ChainObject  min4(mixed $value, ...mixed $values)
 * @method   \ChainObject  min5(mixed $value, ...mixed $values)
 * @method   \ChainObject  min6(mixed $value, ...mixed $values)
 *
 * @see minimum
 * @method   \ChainObject  minimum(...$variadic)
 * @method   \ChainObject  minimum1(...$variadic)
 * @method   \ChainObject  minimum2(...$variadic)
 * @method   \ChainObject  minimum3(...$variadic)
 * @method   \ChainObject  minimum4(...$variadic)
 * @method   \ChainObject  minimum5(...$variadic)
 *
 * @see mkdir
 * @property \ChainObject $mkdir
 * @method   \ChainObject  mkdir(int $permissions = 511, bool $recursive = false, $context = null)
 * @method   \ChainObject  mkdir1(string $directory, bool $recursive = false, $context = null)
 * @method   \ChainObject  mkdir2(string $directory, int $permissions = 511, $context = null)
 * @method   \ChainObject  mkdir3(string $directory, int $permissions = 511, bool $recursive = false)
 *
 * @see mkdir_p
 * @property \ChainObject $mkdir_p
 * @method   \ChainObject  mkdir_p($umask = 2)
 * @method   \ChainObject  mkdir_p1($dirname)
 *
 * @see mktime
 * @property \ChainObject $mktime
 * @method   \ChainObject  mktime(?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null)
 * @method   \ChainObject  mktime1(int $hour, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null)
 * @method   \ChainObject  mktime2(int $hour, ?int $minute = null, ?int $month = null, ?int $day = null, ?int $year = null)
 * @method   \ChainObject  mktime3(int $hour, ?int $minute = null, ?int $second = null, ?int $day = null, ?int $year = null)
 * @method   \ChainObject  mktime4(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $year = null)
 * @method   \ChainObject  mktime5(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null)
 *
 * @see mode
 * @method   \ChainObject  mode(...$variadic)
 * @method   \ChainObject  mode1(...$variadic)
 * @method   \ChainObject  mode2(...$variadic)
 * @method   \ChainObject  mode3(...$variadic)
 * @method   \ChainObject  mode4(...$variadic)
 * @method   \ChainObject  mode5(...$variadic)
 *
 * @see move_uploaded_file
 * @method   \ChainObject  move_uploaded_file(string $to)
 * @method   \ChainObject  move_uploaded_file1(string $from)
 *
 * @see mt_rand
 * @method   \ChainObject  mt_rand(int $max = null)
 * @method   \ChainObject  mt_rand1(int $min = null)
 *
 * @see mt_srand
 * @method   \ChainObject  mt_srand(int $mode = MT_RAND_MT19937)
 * @method   \ChainObject  mt_srand1(int $seed = 0)
 *
 * @see multiexplode
 * @method   \ChainObject  multiexplode($string, $limit = PHP_INT_MAX)
 * @method   \ChainObject  multiexplode1($delimiter, $limit = PHP_INT_MAX)
 * @method   \ChainObject  multiexplode2($delimiter, $string)
 *
 * @see namedcallize
 * @property \ChainObject $namedcallize
 * @method   \ChainObject  namedcallize($defaults = [])
 * @method   \ChainObject  namedcallize1($callable)
 * @method   \ChainObject  namedcallizeP($defaults = [])
 * @method   \ChainObject  namedcallizeP1($callable)
 * @method   \ChainObject  namedcallizeE($defaults = [])
 * @method   \ChainObject  namedcallizeE1($callable)
 *
 * @see namespace_split
 * @property \ChainObject $namespace_split
 * @method   \ChainObject  namespace_split()
 *
 * @see nbind
 * @method   \ChainObject  nbind($n, ...$variadic)
 * @method   \ChainObject  nbind1($callable, ...$variadic)
 * @method   \ChainObject  nbind2($callable, $n, ...$variadic)
 * @method   \ChainObject  nbind3($callable, $n, ...$variadic)
 * @method   \ChainObject  nbind4($callable, $n, ...$variadic)
 * @method   \ChainObject  nbind5($callable, $n, ...$variadic)
 * @method   \ChainObject  nbind6($callable, $n, ...$variadic)
 * @method   \ChainObject  nbind7($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindP($n, ...$variadic)
 * @method   \ChainObject  nbindP1($callable, ...$variadic)
 * @method   \ChainObject  nbindP2($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindP3($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindP4($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindP5($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindP6($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindP7($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindE($n, ...$variadic)
 * @method   \ChainObject  nbindE1($callable, ...$variadic)
 * @method   \ChainObject  nbindE2($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindE3($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindE4($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindE5($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindE6($callable, $n, ...$variadic)
 * @method   \ChainObject  nbindE7($callable, $n, ...$variadic)
 *
 * @see next_key
 * @property \ChainObject $next_key
 * @method   \ChainObject  next_key($key = null)
 * @method   \ChainObject  next_key1($array)
 *
 * @see ngram
 * @method   \ChainObject  ngram($N, $encoding = "UTF-8")
 * @method   \ChainObject  ngram1($string, $encoding = "UTF-8")
 * @method   \ChainObject  ngram2($string, $N)
 *
 * @see nl2br
 * @property \ChainObject $nl2br
 * @method   \ChainObject  nl2br(bool $use_xhtml = true)
 * @method   \ChainObject  nl2br1(string $string)
 *
 * @see nl_langinfo
 * @property \ChainObject $nl_langinfo
 * @method   \ChainObject  nl_langinfo()
 *
 * @see normal_rand
 * @method   \ChainObject  normal_rand($std_deviation = 1.0)
 * @method   \ChainObject  normal_rand1($average = 0.0)
 *
 * @see not_func
 * @property \ChainObject $not_func
 * @method   \ChainObject  not_func()
 * @method   \ChainObject  not_funcP()
 * @method   \ChainObject  not_funcE()
 *
 * @see number_format
 * @property \ChainObject $number_format
 * @method   \ChainObject  number_format(int $decimals = 0, ?string $decimal_separator = ".", ?string $thousands_separator = ",")
 * @method   \ChainObject  number_format1(float $num, ?string $decimal_separator = ".", ?string $thousands_separator = ",")
 * @method   \ChainObject  number_format2(float $num, int $decimals = 0, ?string $thousands_separator = ",")
 * @method   \ChainObject  number_format3(float $num, int $decimals = 0, ?string $decimal_separator = ".")
 *
 * @see number_serial
 * @property \ChainObject $number_serial
 * @method   \ChainObject  number_serial($step = 1, $separator = null, $doSort = true)
 * @method   \ChainObject  number_serial1($numbers, $separator = null, $doSort = true)
 * @method   \ChainObject  number_serial2($numbers, $step = 1, $doSort = true)
 * @method   \ChainObject  number_serial3($numbers, $step = 1, $separator = null)
 *
 * @see numberify
 * @property \ChainObject $numberify
 * @method   \ChainObject  numberify($decimal = false)
 * @method   \ChainObject  numberify1($var)
 *
 * @see numval
 * @property \ChainObject $numval
 * @method   \ChainObject  numval($base = 10)
 * @method   \ChainObject  numval1($var)
 *
 * @see ob_capture
 * @property \ChainObject $ob_capture
 * @method   \ChainObject  ob_capture(...$variadic)
 * @method   \ChainObject  ob_capture1($callback, ...$variadic)
 * @method   \ChainObject  ob_capture2($callback, ...$variadic)
 * @method   \ChainObject  ob_capture3($callback, ...$variadic)
 * @method   \ChainObject  ob_capture4($callback, ...$variadic)
 * @method   \ChainObject  ob_capture5($callback, ...$variadic)
 * @method   \ChainObject  ob_capture6($callback, ...$variadic)
 * @method   \ChainObject  ob_captureP(...$variadic)
 * @method   \ChainObject  ob_captureP1($callback, ...$variadic)
 * @method   \ChainObject  ob_captureP2($callback, ...$variadic)
 * @method   \ChainObject  ob_captureP3($callback, ...$variadic)
 * @method   \ChainObject  ob_captureP4($callback, ...$variadic)
 * @method   \ChainObject  ob_captureP5($callback, ...$variadic)
 * @method   \ChainObject  ob_captureP6($callback, ...$variadic)
 * @method   \ChainObject  ob_captureE(...$variadic)
 * @method   \ChainObject  ob_captureE1($callback, ...$variadic)
 * @method   \ChainObject  ob_captureE2($callback, ...$variadic)
 * @method   \ChainObject  ob_captureE3($callback, ...$variadic)
 * @method   \ChainObject  ob_captureE4($callback, ...$variadic)
 * @method   \ChainObject  ob_captureE5($callback, ...$variadic)
 * @method   \ChainObject  ob_captureE6($callback, ...$variadic)
 *
 * @see ob_get_status
 * @method   \ChainObject  ob_get_status()
 *
 * @see ob_implicit_flush
 * @method   \ChainObject  ob_implicit_flush()
 *
 * @see ob_include
 * @property \ChainObject $ob_include
 * @method   \ChainObject  ob_include($array = [])
 * @method   \ChainObject  ob_include1($include_file)
 *
 * @see ob_start
 * @method   \ChainObject  ob_start(int $chunk_size = 0, int $flags = PHP_OUTPUT_HANDLER_STDFLAGS)
 * @method   \ChainObject  ob_start1($callback = null, int $flags = PHP_OUTPUT_HANDLER_STDFLAGS)
 * @method   \ChainObject  ob_start2($callback = null, int $chunk_size = 0)
 * @method   \ChainObject  ob_startP(int $chunk_size = 0, int $flags = PHP_OUTPUT_HANDLER_STDFLAGS)
 * @method   \ChainObject  ob_startP1($callback = null, int $flags = PHP_OUTPUT_HANDLER_STDFLAGS)
 * @method   \ChainObject  ob_startP2($callback = null, int $chunk_size = 0)
 * @method   \ChainObject  ob_startE(int $chunk_size = 0, int $flags = PHP_OUTPUT_HANDLER_STDFLAGS)
 * @method   \ChainObject  ob_startE1($callback = null, int $flags = PHP_OUTPUT_HANDLER_STDFLAGS)
 * @method   \ChainObject  ob_startE2($callback = null, int $chunk_size = 0)
 *
 * @see object_dive
 * @method   \ChainObject  object_dive($path, $default = null, $delimiter = ".")
 * @method   \ChainObject  object_dive1($object, $default = null, $delimiter = ".")
 * @method   \ChainObject  object_dive2($object, $path, $delimiter = ".")
 * @method   \ChainObject  object_dive3($object, $path, $default = null)
 *
 * @see octdec
 * @property \ChainObject $octdec
 * @method   \ChainObject  octdec()
 *
 * @see ope_func
 * @property \ChainObject $ope_func
 * @method   \ChainObject  ope_func(...$operands)
 * @method   \ChainObject  ope_func1($operator, ...$operands)
 * @method   \ChainObject  ope_func2($operator, ...$operands)
 * @method   \ChainObject  ope_func3($operator, ...$operands)
 * @method   \ChainObject  ope_func4($operator, ...$operands)
 * @method   \ChainObject  ope_func5($operator, ...$operands)
 * @method   \ChainObject  ope_func6($operator, ...$operands)
 *
 * @see opendir
 * @property \ChainObject $opendir
 * @method   \ChainObject  opendir($context = null)
 * @method   \ChainObject  opendir1(string $directory)
 *
 * @see openlog
 * @method   \ChainObject  openlog(int $flags, int $facility)
 * @method   \ChainObject  openlog1(string $prefix, int $facility)
 * @method   \ChainObject  openlog2(string $prefix, int $flags)
 *
 * @see optional
 * @property \ChainObject $optional
 * @method   \ChainObject  optional($expected = null)
 * @method   \ChainObject  optional1($object)
 *
 * @see ord
 * @property \ChainObject $ord
 * @method   \ChainObject  ord()
 *
 * @see output_add_rewrite_var
 * @method   \ChainObject  output_add_rewrite_var(string $value)
 * @method   \ChainObject  output_add_rewrite_var1(string $name)
 *
 * @see pack
 * @property \ChainObject $pack
 * @method   \ChainObject  pack(...mixed $values)
 * @method   \ChainObject  pack1(string $format, ...mixed $values)
 * @method   \ChainObject  pack2(string $format, ...mixed $values)
 * @method   \ChainObject  pack3(string $format, ...mixed $values)
 * @method   \ChainObject  pack4(string $format, ...mixed $values)
 * @method   \ChainObject  pack5(string $format, ...mixed $values)
 * @method   \ChainObject  pack6(string $format, ...mixed $values)
 *
 * @see paml_export
 * @property \ChainObject $paml_export
 * @method   \ChainObject  paml_export($options = [])
 * @method   \ChainObject  paml_export1($pamlarray)
 *
 * @see paml_import
 * @property \ChainObject $paml_import
 * @method   \ChainObject  paml_import($options = [])
 * @method   \ChainObject  paml_import1($pamlstring)
 *
 * @see parameter_default
 * @property \ChainObject $parameter_default
 * @method   \ChainObject  parameter_default($arguments = [])
 * @method   \ChainObject  parameter_default1(callable $callable)
 * @method   \ChainObject  parameter_defaultP($arguments = [])
 * @method   \ChainObject  parameter_defaultP1(callable $callable)
 * @method   \ChainObject  parameter_defaultE($arguments = [])
 * @method   \ChainObject  parameter_defaultE1(callable $callable)
 *
 * @see parameter_length
 * @property \ChainObject $parameter_length
 * @method   \ChainObject  parameter_length($require_only = false, $thought_variadic = false)
 * @method   \ChainObject  parameter_length1($callable, $thought_variadic = false)
 * @method   \ChainObject  parameter_length2($callable, $require_only = false)
 * @method   \ChainObject  parameter_lengthP($require_only = false, $thought_variadic = false)
 * @method   \ChainObject  parameter_lengthP1($callable, $thought_variadic = false)
 * @method   \ChainObject  parameter_lengthP2($callable, $require_only = false)
 * @method   \ChainObject  parameter_lengthE($require_only = false, $thought_variadic = false)
 * @method   \ChainObject  parameter_lengthE1($callable, $thought_variadic = false)
 * @method   \ChainObject  parameter_lengthE2($callable, $require_only = false)
 *
 * @see parameter_wiring
 * @method   \ChainObject  parameter_wiring($dependency)
 * @method   \ChainObject  parameter_wiring1($callable)
 * @method   \ChainObject  parameter_wiringP($dependency)
 * @method   \ChainObject  parameter_wiringP1($callable)
 * @method   \ChainObject  parameter_wiringE($dependency)
 * @method   \ChainObject  parameter_wiringE1($callable)
 *
 * @see parse_annotation
 * @property \ChainObject $parse_annotation
 * @method   \ChainObject  parse_annotation($schema = [], $nsfiles = [])
 * @method   \ChainObject  parse_annotation1($annotation, $nsfiles = [])
 * @method   \ChainObject  parse_annotation2($annotation, $schema = [])
 *
 * @see parse_ini_file
 * @property \ChainObject $parse_ini_file
 * @method   \ChainObject  parse_ini_file(bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL)
 * @method   \ChainObject  parse_ini_file1(string $filename, int $scanner_mode = INI_SCANNER_NORMAL)
 * @method   \ChainObject  parse_ini_file2(string $filename, bool $process_sections = false)
 *
 * @see parse_ini_string
 * @property \ChainObject $parse_ini_string
 * @method   \ChainObject  parse_ini_string(bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL)
 * @method   \ChainObject  parse_ini_string1(string $ini_string, int $scanner_mode = INI_SCANNER_NORMAL)
 * @method   \ChainObject  parse_ini_string2(string $ini_string, bool $process_sections = false)
 *
 * @see parse_namespace
 * @property \ChainObject $parse_namespace
 * @method   \ChainObject  parse_namespace($options = [])
 * @method   \ChainObject  parse_namespace1($filename)
 *
 * @see parse_php
 * @property \ChainObject $parse_php
 * @method   \ChainObject  parse_php($option = [])
 * @method   \ChainObject  parse_php1($phpcode)
 *
 * @see parse_query
 * @property \ChainObject $parse_query
 * @method   \ChainObject  parse_query()
 *
 * @see parse_uri
 * @property \ChainObject $parse_uri
 * @method   \ChainObject  parse_uri($default = [])
 * @method   \ChainObject  parse_uri1($uri)
 *
 * @see parse_url
 * @property \ChainObject $parse_url
 * @method   \ChainObject  parse_url(int $component = -1)
 * @method   \ChainObject  parse_url1(string $url)
 *
 * @see pascal_case
 * @property \ChainObject $pascal_case
 * @method   \ChainObject  pascal_case($delimiter = "_")
 * @method   \ChainObject  pascal_case1($string)
 *
 * @see password_get_info
 * @property \ChainObject $password_get_info
 * @method   \ChainObject  password_get_info()
 *
 * @see password_hash
 * @method   \ChainObject  password_hash(string|int|null $algo, array $options = [])
 * @method   \ChainObject  password_hash1(string $password, array $options = [])
 * @method   \ChainObject  password_hash2(string $password, string|int|null $algo)
 *
 * @see password_needs_rehash
 * @method   \ChainObject  password_needs_rehash(string|int|null $algo, array $options = [])
 * @method   \ChainObject  password_needs_rehash1(string $hash, array $options = [])
 * @method   \ChainObject  password_needs_rehash2(string $hash, string|int|null $algo)
 *
 * @see password_verify
 * @method   \ChainObject  password_verify(string $hash)
 * @method   \ChainObject  password_verify1(string $password)
 *
 * @see path_is_absolute
 * @property \ChainObject $path_is_absolute
 * @method   \ChainObject  path_is_absolute()
 *
 * @see path_normalize
 * @property \ChainObject $path_normalize
 * @method   \ChainObject  path_normalize()
 *
 * @see path_parse
 * @property \ChainObject $path_parse
 * @method   \ChainObject  path_parse()
 *
 * @see path_relative
 * @method   \ChainObject  path_relative($to)
 * @method   \ChainObject  path_relative1($from)
 *
 * @see path_resolve
 * @method   \ChainObject  path_resolve(...$paths)
 * @method   \ChainObject  path_resolve1(...$paths)
 * @method   \ChainObject  path_resolve2(...$paths)
 * @method   \ChainObject  path_resolve3(...$paths)
 * @method   \ChainObject  path_resolve4(...$paths)
 * @method   \ChainObject  path_resolve5(...$paths)
 *
 * @see pathinfo
 * @property \ChainObject $pathinfo
 * @method   \ChainObject  pathinfo(int $flags = PATHINFO_ALL)
 * @method   \ChainObject  pathinfo1(string $path)
 *
 * @see pclose
 * @property \ChainObject $pclose
 * @method   \ChainObject  pclose()
 *
 * @see php_strip_whitespace
 * @property \ChainObject $php_strip_whitespace
 * @method   \ChainObject  php_strip_whitespace()
 *
 * @see php_uname
 * @method   \ChainObject  php_uname()
 *
 * @see phpcredits
 * @method   \ChainObject  phpcredits()
 *
 * @see phpinfo
 * @method   \ChainObject  phpinfo()
 *
 * @see phpval
 * @property \ChainObject $phpval
 * @method   \ChainObject  phpval($contextvars = [])
 * @method   \ChainObject  phpval1($var)
 *
 * @see phpversion
 * @method   \ChainObject  phpversion()
 *
 * @see popen
 * @method   \ChainObject  popen(string $mode)
 * @method   \ChainObject  popen1(string $command)
 *
 * @see pos
 * @property \ChainObject $pos
 * @method   \ChainObject  pos()
 *
 * @see pow
 * @method   \ChainObject  pow(mixed $exponent)
 * @method   \ChainObject  pow1(mixed $num)
 *
 * @see preg_capture
 * @method   \ChainObject  preg_capture($subject, $default)
 * @method   \ChainObject  preg_capture1($pattern, $default)
 * @method   \ChainObject  preg_capture2($pattern, $subject)
 *
 * @see preg_grep
 * @method   \ChainObject  preg_grep(array $array, int $flags = 0)
 * @method   \ChainObject  preg_grep1(string $pattern, int $flags = 0)
 * @method   \ChainObject  preg_grep2(string $pattern, array $array)
 *
 * @see preg_matches
 * @method   \ChainObject  preg_matches($subject, $flags = 0, $offset = 0)
 * @method   \ChainObject  preg_matches1($pattern, $flags = 0, $offset = 0)
 * @method   \ChainObject  preg_matches2($pattern, $subject, $offset = 0)
 * @method   \ChainObject  preg_matches3($pattern, $subject, $flags = 0)
 *
 * @see preg_quote
 * @property \ChainObject $preg_quote
 * @method   \ChainObject  preg_quote(?string $delimiter = null)
 * @method   \ChainObject  preg_quote1(string $str)
 *
 * @see preg_split
 * @method   \ChainObject  preg_split(string $subject, int $limit = -1, int $flags = 0)
 * @method   \ChainObject  preg_split1(string $pattern, int $limit = -1, int $flags = 0)
 * @method   \ChainObject  preg_split2(string $pattern, string $subject, int $flags = 0)
 * @method   \ChainObject  preg_split3(string $pattern, string $subject, int $limit = -1)
 *
 * @see prev_key
 * @method   \ChainObject  prev_key($key)
 * @method   \ChainObject  prev_key1($array)
 *
 * @see print_r
 * @property \ChainObject $print_r
 * @method   \ChainObject  print_r(bool $return = false)
 * @method   \ChainObject  print_r1(mixed $value)
 *
 * @see printf
 * @property \ChainObject $printf
 * @method   \ChainObject  printf(...mixed $values)
 * @method   \ChainObject  printf1(string $format, ...mixed $values)
 * @method   \ChainObject  printf2(string $format, ...mixed $values)
 * @method   \ChainObject  printf3(string $format, ...mixed $values)
 * @method   \ChainObject  printf4(string $format, ...mixed $values)
 * @method   \ChainObject  printf5(string $format, ...mixed $values)
 * @method   \ChainObject  printf6(string $format, ...mixed $values)
 *
 * @see probability
 * @property \ChainObject $probability
 * @method   \ChainObject  probability($divisor = 100)
 * @method   \ChainObject  probability1($probability)
 *
 * @see proc_close
 * @property \ChainObject $proc_close
 * @method   \ChainObject  proc_close()
 *
 * @see proc_get_status
 * @property \ChainObject $proc_get_status
 * @method   \ChainObject  proc_get_status()
 *
 * @see proc_nice
 * @property \ChainObject $proc_nice
 * @method   \ChainObject  proc_nice()
 *
 * @see proc_terminate
 * @property \ChainObject $proc_terminate
 * @method   \ChainObject  proc_terminate(int $signal = 15)
 * @method   \ChainObject  proc_terminate1($process)
 *
 * @see process_parallel
 * @property \ChainObject $process_parallel
 * @method   \ChainObject  process_parallel($args = [], $autoload = null, $workdir = null, $env = null)
 * @method   \ChainObject  process_parallel1($tasks, $autoload = null, $workdir = null, $env = null)
 * @method   \ChainObject  process_parallel2($tasks, $args = [], $workdir = null, $env = null)
 * @method   \ChainObject  process_parallel3($tasks, $args = [], $autoload = null, $env = null)
 * @method   \ChainObject  process_parallel4($tasks, $args = [], $autoload = null, $workdir = null)
 *
 * @see profiler
 * @method   \ChainObject  profiler()
 *
 * @see property_exists
 * @method   \ChainObject  property_exists(string $property)
 * @method   \ChainObject  property_exists1($object_or_class)
 *
 * @see putenv
 * @property \ChainObject $putenv
 * @method   \ChainObject  putenv()
 *
 * @see quoted_printable_decode
 * @property \ChainObject $quoted_printable_decode
 * @method   \ChainObject  quoted_printable_decode()
 *
 * @see quoted_printable_encode
 * @property \ChainObject $quoted_printable_encode
 * @method   \ChainObject  quoted_printable_encode()
 *
 * @see quoteexplode
 * @method   \ChainObject  quoteexplode($string, $limit = null, $enclosures = "'\"", $escape = "\\")
 * @method   \ChainObject  quoteexplode1($delimiter, $limit = null, $enclosures = "'\"", $escape = "\\")
 * @method   \ChainObject  quoteexplode2($delimiter, $string, $enclosures = "'\"", $escape = "\\")
 * @method   \ChainObject  quoteexplode3($delimiter, $string, $limit = null, $escape = "\\")
 * @method   \ChainObject  quoteexplode4($delimiter, $string, $limit = null, $enclosures = "'\"")
 *
 * @see quotemeta
 * @property \ChainObject $quotemeta
 * @method   \ChainObject  quotemeta()
 *
 * @see rad2deg
 * @property \ChainObject $rad2deg
 * @method   \ChainObject  rad2deg()
 *
 * @see rand
 * @method   \ChainObject  rand(int $max = null)
 * @method   \ChainObject  rand1(int $min = null)
 *
 * @see random_at
 * @method   \ChainObject  random_at(...$args)
 * @method   \ChainObject  random_at1(...$args)
 * @method   \ChainObject  random_at2(...$args)
 * @method   \ChainObject  random_at3(...$args)
 * @method   \ChainObject  random_at4(...$args)
 * @method   \ChainObject  random_at5(...$args)
 *
 * @see random_bytes
 * @property \ChainObject $random_bytes
 * @method   \ChainObject  random_bytes()
 *
 * @see random_int
 * @method   \ChainObject  random_int(int $max)
 * @method   \ChainObject  random_int1(int $min)
 *
 * @see random_string
 * @method   \ChainObject  random_string($charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")
 * @method   \ChainObject  random_string1($length = 8)
 *
 * @see range
 * @method   \ChainObject  range($end, int|float $step = 1)
 * @method   \ChainObject  range1($start, int|float $step = 1)
 * @method   \ChainObject  range2($start, $end)
 *
 * @see rawurldecode
 * @property \ChainObject $rawurldecode
 * @method   \ChainObject  rawurldecode()
 *
 * @see rawurlencode
 * @property \ChainObject $rawurlencode
 * @method   \ChainObject  rawurlencode()
 *
 * @see rbind
 * @property \ChainObject $rbind
 * @method   \ChainObject  rbind(...$variadic)
 * @method   \ChainObject  rbind1($callable, ...$variadic)
 * @method   \ChainObject  rbind2($callable, ...$variadic)
 * @method   \ChainObject  rbind3($callable, ...$variadic)
 * @method   \ChainObject  rbind4($callable, ...$variadic)
 * @method   \ChainObject  rbind5($callable, ...$variadic)
 * @method   \ChainObject  rbind6($callable, ...$variadic)
 * @method   \ChainObject  rbindP(...$variadic)
 * @method   \ChainObject  rbindP1($callable, ...$variadic)
 * @method   \ChainObject  rbindP2($callable, ...$variadic)
 * @method   \ChainObject  rbindP3($callable, ...$variadic)
 * @method   \ChainObject  rbindP4($callable, ...$variadic)
 * @method   \ChainObject  rbindP5($callable, ...$variadic)
 * @method   \ChainObject  rbindP6($callable, ...$variadic)
 * @method   \ChainObject  rbindE(...$variadic)
 * @method   \ChainObject  rbindE1($callable, ...$variadic)
 * @method   \ChainObject  rbindE2($callable, ...$variadic)
 * @method   \ChainObject  rbindE3($callable, ...$variadic)
 * @method   \ChainObject  rbindE4($callable, ...$variadic)
 * @method   \ChainObject  rbindE5($callable, ...$variadic)
 * @method   \ChainObject  rbindE6($callable, ...$variadic)
 *
 * @see readdir
 * @method   \ChainObject  readdir()
 *
 * @see readfile
 * @property \ChainObject $readfile
 * @method   \ChainObject  readfile(bool $use_include_path = false, $context = null)
 * @method   \ChainObject  readfile1(string $filename, $context = null)
 * @method   \ChainObject  readfile2(string $filename, bool $use_include_path = false)
 *
 * @see readlink
 * @property \ChainObject $readlink
 * @method   \ChainObject  readlink()
 *
 * @see realpath
 * @property \ChainObject $realpath
 * @method   \ChainObject  realpath()
 *
 * @see reflect_callable
 * @property \ChainObject $reflect_callable
 * @method   \ChainObject  reflect_callable()
 * @method   \ChainObject  reflect_callableP()
 * @method   \ChainObject  reflect_callableE()
 *
 * @see reflect_types
 * @method   \ChainObject  reflect_types()
 *
 * @see register_shutdown_function
 * @property \ChainObject $register_shutdown_function
 * @method   \ChainObject  register_shutdown_function(...mixed $args)
 * @method   \ChainObject  register_shutdown_function1(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_function2(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_function3(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_function4(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_function5(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_function6(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionP(...mixed $args)
 * @method   \ChainObject  register_shutdown_functionP1(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionP2(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionP3(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionP4(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionP5(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionP6(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionE(...mixed $args)
 * @method   \ChainObject  register_shutdown_functionE1(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionE2(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionE3(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionE4(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionE5(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_shutdown_functionE6(callable $callback, ...mixed $args)
 *
 * @see register_tick_function
 * @property \ChainObject $register_tick_function
 * @method   \ChainObject  register_tick_function(...mixed $args)
 * @method   \ChainObject  register_tick_function1(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_function2(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_function3(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_function4(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_function5(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_function6(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionP(...mixed $args)
 * @method   \ChainObject  register_tick_functionP1(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionP2(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionP3(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionP4(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionP5(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionP6(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionE(...mixed $args)
 * @method   \ChainObject  register_tick_functionE1(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionE2(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionE3(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionE4(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionE5(callable $callback, ...mixed $args)
 * @method   \ChainObject  register_tick_functionE6(callable $callback, ...mixed $args)
 *
 * @see rename
 * @method   \ChainObject  rename(string $to, $context = null)
 * @method   \ChainObject  rename1(string $from, $context = null)
 * @method   \ChainObject  rename2(string $from, string $to)
 *
 * @see render_file
 * @method   \ChainObject  render_file($array)
 * @method   \ChainObject  render_file1($template_file)
 *
 * @see render_string
 * @method   \ChainObject  render_string($array)
 * @method   \ChainObject  render_string1($template)
 *
 * @see render_template
 * @method   \ChainObject  render_template($vars)
 * @method   \ChainObject  render_template1($template)
 *
 * @see resolve_symbol
 * @method   \ChainObject  resolve_symbol($nsfiles, $targets = ["const", "function", "alias"])
 * @method   \ChainObject  resolve_symbol1(string $shortname, $targets = ["const", "function", "alias"])
 * @method   \ChainObject  resolve_symbol2(string $shortname, $nsfiles)
 *
 * @see rewind
 * @property \ChainObject $rewind
 * @method   \ChainObject  rewind()
 *
 * @see rewinddir
 * @method   \ChainObject  rewinddir()
 *
 * @see rm_rf
 * @property \ChainObject $rm_rf
 * @method   \ChainObject  rm_rf($self = true)
 * @method   \ChainObject  rm_rf1($dirname)
 *
 * @see rmdir
 * @property \ChainObject $rmdir
 * @method   \ChainObject  rmdir($context = null)
 * @method   \ChainObject  rmdir1(string $directory)
 *
 * @see round
 * @property \ChainObject $round
 * @method   \ChainObject  round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP)
 * @method   \ChainObject  round1(int|float $num, int $mode = PHP_ROUND_HALF_UP)
 * @method   \ChainObject  round2(int|float $num, int $precision = 0)
 *
 * @see rtrim
 * @property \ChainObject $rtrim
 * @method   \ChainObject  rtrim(string $characters = " 
	\000")
 * @method   \ChainObject  rtrim1(string $string)
 *
 * @see scandir
 * @property \ChainObject $scandir
 * @method   \ChainObject  scandir(int $sorting_order = SCANDIR_SORT_ASCENDING, $context = null)
 * @method   \ChainObject  scandir1(string $directory, $context = null)
 * @method   \ChainObject  scandir2(string $directory, int $sorting_order = SCANDIR_SORT_ASCENDING)
 *
 * @see serialize
 * @property \ChainObject $serialize
 * @method   \ChainObject  serialize()
 *
 * @see set_error_handler
 * @property \ChainObject $set_error_handler
 * @method   \ChainObject  set_error_handler(int $error_levels = E_ALL)
 * @method   \ChainObject  set_error_handler1(?callable $callback)
 * @method   \ChainObject  set_error_handlerP(int $error_levels = E_ALL)
 * @method   \ChainObject  set_error_handlerP1(?callable $callback)
 * @method   \ChainObject  set_error_handlerE(int $error_levels = E_ALL)
 * @method   \ChainObject  set_error_handlerE1(?callable $callback)
 *
 * @see set_exception_handler
 * @property \ChainObject $set_exception_handler
 * @method   \ChainObject  set_exception_handler()
 * @method   \ChainObject  set_exception_handlerP()
 * @method   \ChainObject  set_exception_handlerE()
 *
 * @see set_file_buffer
 * @method   \ChainObject  set_file_buffer(int $size)
 * @method   \ChainObject  set_file_buffer1($stream)
 *
 * @see set_include_path
 * @property \ChainObject $set_include_path
 * @method   \ChainObject  set_include_path()
 *
 * @see set_time_limit
 * @property \ChainObject $set_time_limit
 * @method   \ChainObject  set_time_limit()
 *
 * @see setcookie
 * @property \ChainObject $setcookie
 * @method   \ChainObject  setcookie(string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setcookie1(string $name, array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setcookie2(string $name, string $value = "", string $path = "", string $domain = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setcookie3(string $name, string $value = "", array|int $expires_or_options = 0, string $domain = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setcookie4(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setcookie5(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $httponly = false)
 * @method   \ChainObject  setcookie6(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false)
 *
 * @see setenvs
 * @property \ChainObject $setenvs
 * @method   \ChainObject  setenvs()
 *
 * @see setlocale
 * @method   \ChainObject  setlocale($locales, ...$rest)
 * @method   \ChainObject  setlocale1(int $category, ...$rest)
 * @method   \ChainObject  setlocale2(int $category, $locales, ...$rest)
 * @method   \ChainObject  setlocale3(int $category, $locales, ...$rest)
 * @method   \ChainObject  setlocale4(int $category, $locales, ...$rest)
 * @method   \ChainObject  setlocale5(int $category, $locales, ...$rest)
 * @method   \ChainObject  setlocale6(int $category, $locales, ...$rest)
 * @method   \ChainObject  setlocale7(int $category, $locales, ...$rest)
 *
 * @see setrawcookie
 * @property \ChainObject $setrawcookie
 * @method   \ChainObject  setrawcookie(string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setrawcookie1(string $name, array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setrawcookie2(string $name, string $value = "", string $path = "", string $domain = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setrawcookie3(string $name, string $value = "", array|int $expires_or_options = 0, string $domain = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setrawcookie4(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", bool $secure = false, bool $httponly = false)
 * @method   \ChainObject  setrawcookie5(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $httponly = false)
 * @method   \ChainObject  setrawcookie6(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false)
 *
 * @see sha1
 * @property \ChainObject $sha1
 * @method   \ChainObject  sha1(bool $binary = false)
 * @method   \ChainObject  sha11(string $string)
 *
 * @see sha1_file
 * @property \ChainObject $sha1_file
 * @method   \ChainObject  sha1_file(bool $binary = false)
 * @method   \ChainObject  sha1_file1(string $filename)
 *
 * @see shell_exec
 * @property \ChainObject $shell_exec
 * @method   \ChainObject  shell_exec()
 *
 * @see show_source
 * @property \ChainObject $show_source
 * @method   \ChainObject  show_source(bool $return = false)
 * @method   \ChainObject  show_source1(string $filename)
 *
 * @see si_prefix
 * @property \ChainObject $si_prefix
 * @method   \ChainObject  si_prefix($unit = 1000, $format = "%.3f %s")
 * @method   \ChainObject  si_prefix1($var, $format = "%.3f %s")
 * @method   \ChainObject  si_prefix2($var, $unit = 1000)
 *
 * @see si_unprefix
 * @property \ChainObject $si_unprefix
 * @method   \ChainObject  si_unprefix($unit = 1000)
 * @method   \ChainObject  si_unprefix1($var)
 *
 * @see sin
 * @property \ChainObject $sin
 * @method   \ChainObject  sin()
 *
 * @see sinh
 * @property \ChainObject $sinh
 * @method   \ChainObject  sinh()
 *
 * @see sizeof
 * @property \ChainObject $sizeof
 * @method   \ChainObject  sizeof(int $mode = COUNT_NORMAL)
 * @method   \ChainObject  sizeof1(\Countable|array $value)
 *
 * @see sleep
 * @property \ChainObject $sleep
 * @method   \ChainObject  sleep()
 *
 * @see snake_case
 * @property \ChainObject $snake_case
 * @method   \ChainObject  snake_case($delimiter = "_")
 * @method   \ChainObject  snake_case1($string)
 *
 * @see socket_get_status
 * @property \ChainObject $socket_get_status
 * @method   \ChainObject  socket_get_status()
 *
 * @see socket_set_blocking
 * @method   \ChainObject  socket_set_blocking(bool $enable)
 * @method   \ChainObject  socket_set_blocking1($stream)
 *
 * @see socket_set_timeout
 * @method   \ChainObject  socket_set_timeout(int $seconds, int $microseconds = 0)
 * @method   \ChainObject  socket_set_timeout1($stream, int $microseconds = 0)
 * @method   \ChainObject  socket_set_timeout2($stream, int $seconds)
 *
 * @see soundex
 * @property \ChainObject $soundex
 * @method   \ChainObject  soundex()
 *
 * @see split_noempty
 * @method   \ChainObject  split_noempty($string, $trimchars = true)
 * @method   \ChainObject  split_noempty1($delimiter, $trimchars = true)
 * @method   \ChainObject  split_noempty2($delimiter, $string)
 *
 * @see sprintf
 * @property \ChainObject $sprintf
 * @method   \ChainObject  sprintf(...mixed $values)
 * @method   \ChainObject  sprintf1(string $format, ...mixed $values)
 * @method   \ChainObject  sprintf2(string $format, ...mixed $values)
 * @method   \ChainObject  sprintf3(string $format, ...mixed $values)
 * @method   \ChainObject  sprintf4(string $format, ...mixed $values)
 * @method   \ChainObject  sprintf5(string $format, ...mixed $values)
 * @method   \ChainObject  sprintf6(string $format, ...mixed $values)
 *
 * @see sql_bind
 * @method   \ChainObject  sql_bind($values)
 * @method   \ChainObject  sql_bind1($sql)
 *
 * @see sql_format
 * @property \ChainObject $sql_format
 * @method   \ChainObject  sql_format($options = [])
 * @method   \ChainObject  sql_format1($sql)
 *
 * @see sql_quote
 * @property \ChainObject $sql_quote
 * @method   \ChainObject  sql_quote()
 *
 * @see sqrt
 * @property \ChainObject $sqrt
 * @method   \ChainObject  sqrt()
 *
 * @see srand
 * @method   \ChainObject  srand(int $mode = MT_RAND_MT19937)
 * @method   \ChainObject  srand1(int $seed = 0)
 *
 * @see stacktrace
 * @method   \ChainObject  stacktrace($option = [])
 * @method   \ChainObject  stacktrace1($traces = null)
 *
 * @see starts_with
 * @method   \ChainObject  starts_with($with, $case_insensitivity = false)
 * @method   \ChainObject  starts_with1($string, $case_insensitivity = false)
 * @method   \ChainObject  starts_with2($string, $with)
 *
 * @see stat
 * @property \ChainObject $stat
 * @method   \ChainObject  stat()
 *
 * @see stdclass
 * @method   \ChainObject  stdclass()
 *
 * @see str_anyof
 * @method   \ChainObject  str_anyof($haystack, $case_insensitivity = false)
 * @method   \ChainObject  str_anyof1($needle, $case_insensitivity = false)
 * @method   \ChainObject  str_anyof2($needle, $haystack)
 *
 * @see str_anyof
 * @method   \ChainObject  anyof($haystack, $case_insensitivity = false)
 * @method   \ChainObject  anyof1($needle, $case_insensitivity = false)
 * @method   \ChainObject  anyof2($needle, $haystack)
 *
 * @see str_array
 * @method   \ChainObject  str_array($delimiter, $hashmode)
 * @method   \ChainObject  str_array1($string, $hashmode)
 * @method   \ChainObject  str_array2($string, $delimiter)
 *
 * @see str_array
 * @method   \ChainObject  array($delimiter, $hashmode)
 * @method   \ChainObject  array1($string, $hashmode)
 * @method   \ChainObject  array2($string, $delimiter)
 *
 * @see str_chop
 * @property \ChainObject $str_chop
 * @method   \ChainObject  str_chop($prefix = "", $suffix = "", $case_insensitivity = false)
 * @method   \ChainObject  str_chop1($string, $suffix = "", $case_insensitivity = false)
 * @method   \ChainObject  str_chop2($string, $prefix = "", $case_insensitivity = false)
 * @method   \ChainObject  str_chop3($string, $prefix = "", $suffix = "")
 *
 * @see str_chunk
 * @property \ChainObject $str_chunk
 * @method   \ChainObject  str_chunk(...$chunks)
 * @method   \ChainObject  str_chunk1($string, ...$chunks)
 * @method   \ChainObject  str_chunk2($string, ...$chunks)
 * @method   \ChainObject  str_chunk3($string, ...$chunks)
 * @method   \ChainObject  str_chunk4($string, ...$chunks)
 * @method   \ChainObject  str_chunk5($string, ...$chunks)
 * @method   \ChainObject  str_chunk6($string, ...$chunks)
 *
 * @see str_common_prefix
 * @method   \ChainObject  str_common_prefix(...$strings)
 * @method   \ChainObject  str_common_prefix1(...$strings)
 * @method   \ChainObject  str_common_prefix2(...$strings)
 * @method   \ChainObject  str_common_prefix3(...$strings)
 * @method   \ChainObject  str_common_prefix4(...$strings)
 * @method   \ChainObject  str_common_prefix5(...$strings)
 *
 * @see str_common_prefix
 * @method   \ChainObject  common_prefix(...$strings)
 * @method   \ChainObject  common_prefix1(...$strings)
 * @method   \ChainObject  common_prefix2(...$strings)
 * @method   \ChainObject  common_prefix3(...$strings)
 * @method   \ChainObject  common_prefix4(...$strings)
 * @method   \ChainObject  common_prefix5(...$strings)
 *
 * @see str_contains
 * @method   \ChainObject  str_contains(string $needle)
 * @method   \ChainObject  str_contains1(string $haystack)
 *
 * @see str_contains
 * @method   \ChainObject  contains(string $needle)
 * @method   \ChainObject  contains1(string $haystack)
 *
 * @see str_diff
 * @method   \ChainObject  str_diff($ystring, $options = [])
 * @method   \ChainObject  str_diff1($xstring, $options = [])
 * @method   \ChainObject  str_diff2($xstring, $ystring)
 *
 * @see str_ellipsis
 * @method   \ChainObject  str_ellipsis($width, $trimmarker = "...", $pos = null)
 * @method   \ChainObject  str_ellipsis1($string, $trimmarker = "...", $pos = null)
 * @method   \ChainObject  str_ellipsis2($string, $width, $pos = null)
 * @method   \ChainObject  str_ellipsis3($string, $width, $trimmarker = "...")
 *
 * @see str_ellipsis
 * @method   \ChainObject  ellipsis($width, $trimmarker = "...", $pos = null)
 * @method   \ChainObject  ellipsis1($string, $trimmarker = "...", $pos = null)
 * @method   \ChainObject  ellipsis2($string, $width, $pos = null)
 * @method   \ChainObject  ellipsis3($string, $width, $trimmarker = "...")
 *
 * @see str_embed
 * @method   \ChainObject  str_embed($replacemap, $enclosure = "'\"", $escape = "\\")
 * @method   \ChainObject  str_embed1($string, $enclosure = "'\"", $escape = "\\")
 * @method   \ChainObject  str_embed2($string, $replacemap, $escape = "\\")
 * @method   \ChainObject  str_embed3($string, $replacemap, $enclosure = "'\"")
 *
 * @see str_embed
 * @method   \ChainObject  embed($replacemap, $enclosure = "'\"", $escape = "\\")
 * @method   \ChainObject  embed1($string, $enclosure = "'\"", $escape = "\\")
 * @method   \ChainObject  embed2($string, $replacemap, $escape = "\\")
 * @method   \ChainObject  embed3($string, $replacemap, $enclosure = "'\"")
 *
 * @see str_ends_with
 * @method   \ChainObject  str_ends_with(string $needle)
 * @method   \ChainObject  str_ends_with1(string $haystack)
 *
 * @see str_equals
 * @method   \ChainObject  str_equals($str2, $case_insensitivity = false)
 * @method   \ChainObject  str_equals1($str1, $case_insensitivity = false)
 * @method   \ChainObject  str_equals2($str1, $str2)
 *
 * @see str_equals
 * @method   \ChainObject  equals($str2, $case_insensitivity = false)
 * @method   \ChainObject  equals1($str1, $case_insensitivity = false)
 * @method   \ChainObject  equals2($str1, $str2)
 *
 * @see str_exists
 * @method   \ChainObject  str_exists($needle, $case_insensitivity = false, $and_flag = false)
 * @method   \ChainObject  str_exists1($haystack, $case_insensitivity = false, $and_flag = false)
 * @method   \ChainObject  str_exists2($haystack, $needle, $and_flag = false)
 * @method   \ChainObject  str_exists3($haystack, $needle, $case_insensitivity = false)
 *
 * @see str_exists
 * @method   \ChainObject  exists($needle, $case_insensitivity = false, $and_flag = false)
 * @method   \ChainObject  exists1($haystack, $case_insensitivity = false, $and_flag = false)
 * @method   \ChainObject  exists2($haystack, $needle, $and_flag = false)
 * @method   \ChainObject  exists3($haystack, $needle, $case_insensitivity = false)
 *
 * @see str_getcsv
 * @property \ChainObject $str_getcsv
 * @method   \ChainObject  str_getcsv(string $separator = ",", string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  str_getcsv1(string $string, string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  str_getcsv2(string $string, string $separator = ",", string $escape = "\\")
 * @method   \ChainObject  str_getcsv3(string $string, string $separator = ",", string $enclosure = "\"")
 *
 * @see str_getcsv
 * @property \ChainObject $getcsv
 * @method   \ChainObject  getcsv(string $separator = ",", string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  getcsv1(string $string, string $enclosure = "\"", string $escape = "\\")
 * @method   \ChainObject  getcsv2(string $string, string $separator = ",", string $escape = "\\")
 * @method   \ChainObject  getcsv3(string $string, string $separator = ",", string $enclosure = "\"")
 *
 * @see str_lchop
 * @method   \ChainObject  str_lchop($prefix, $case_insensitivity = false)
 * @method   \ChainObject  str_lchop1($string, $case_insensitivity = false)
 * @method   \ChainObject  str_lchop2($string, $prefix)
 *
 * @see str_lchop
 * @method   \ChainObject  lchop($prefix, $case_insensitivity = false)
 * @method   \ChainObject  lchop1($string, $case_insensitivity = false)
 * @method   \ChainObject  lchop2($string, $prefix)
 *
 * @see str_pad
 * @method   \ChainObject  str_pad(int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT)
 * @method   \ChainObject  str_pad1(string $string, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT)
 * @method   \ChainObject  str_pad2(string $string, int $length, int $pad_type = STR_PAD_RIGHT)
 * @method   \ChainObject  str_pad3(string $string, int $length, string $pad_string = " ")
 *
 * @see str_putcsv
 * @property \ChainObject $str_putcsv
 * @method   \ChainObject  str_putcsv($delimiter = ",", $enclosure = "\"", $escape = "\\")
 * @method   \ChainObject  str_putcsv1($array, $enclosure = "\"", $escape = "\\")
 * @method   \ChainObject  str_putcsv2($array, $delimiter = ",", $escape = "\\")
 * @method   \ChainObject  str_putcsv3($array, $delimiter = ",", $enclosure = "\"")
 *
 * @see str_putcsv
 * @property \ChainObject $putcsv
 * @method   \ChainObject  putcsv($delimiter = ",", $enclosure = "\"", $escape = "\\")
 * @method   \ChainObject  putcsv1($array, $enclosure = "\"", $escape = "\\")
 * @method   \ChainObject  putcsv2($array, $delimiter = ",", $escape = "\\")
 * @method   \ChainObject  putcsv3($array, $delimiter = ",", $enclosure = "\"")
 *
 * @see str_rchop
 * @method   \ChainObject  str_rchop($suffix, $case_insensitivity = false)
 * @method   \ChainObject  str_rchop1($string, $case_insensitivity = false)
 * @method   \ChainObject  str_rchop2($string, $suffix)
 *
 * @see str_rchop
 * @method   \ChainObject  rchop($suffix, $case_insensitivity = false)
 * @method   \ChainObject  rchop1($string, $case_insensitivity = false)
 * @method   \ChainObject  rchop2($string, $suffix)
 *
 * @see str_repeat
 * @method   \ChainObject  str_repeat(int $times)
 * @method   \ChainObject  str_repeat1(string $string)
 *
 * @see str_repeat
 * @method   \ChainObject  repeat(int $times)
 * @method   \ChainObject  repeat1(string $string)
 *
 * @see str_rot13
 * @property \ChainObject $str_rot13
 * @method   \ChainObject  str_rot13()
 *
 * @see str_rot13
 * @property \ChainObject $rot13
 * @method   \ChainObject  rot13()
 *
 * @see str_shuffle
 * @property \ChainObject $str_shuffle
 * @method   \ChainObject  str_shuffle()
 *
 * @see str_shuffle
 * @property \ChainObject $shuffle
 * @method   \ChainObject  shuffle()
 *
 * @see str_split
 * @property \ChainObject $str_split
 * @method   \ChainObject  str_split(int $length = 1)
 * @method   \ChainObject  str_split1(string $string)
 *
 * @see str_split
 * @property \ChainObject $split
 * @method   \ChainObject  split(int $length = 1)
 * @method   \ChainObject  split1(string $string)
 *
 * @see str_starts_with
 * @method   \ChainObject  str_starts_with(string $needle)
 * @method   \ChainObject  str_starts_with1(string $haystack)
 *
 * @see str_submap
 * @method   \ChainObject  str_submap($replaces, $case_insensitivity = false)
 * @method   \ChainObject  str_submap1($subject, $case_insensitivity = false)
 * @method   \ChainObject  str_submap2($subject, $replaces)
 *
 * @see str_submap
 * @method   \ChainObject  submap($replaces, $case_insensitivity = false)
 * @method   \ChainObject  submap1($subject, $case_insensitivity = false)
 * @method   \ChainObject  submap2($subject, $replaces)
 *
 * @see str_subreplace
 * @method   \ChainObject  str_subreplace($search, $replaces, $case_insensitivity = false)
 * @method   \ChainObject  str_subreplace1($subject, $replaces, $case_insensitivity = false)
 * @method   \ChainObject  str_subreplace2($subject, $search, $case_insensitivity = false)
 * @method   \ChainObject  str_subreplace3($subject, $search, $replaces)
 *
 * @see str_subreplace
 * @method   \ChainObject  subreplace($search, $replaces, $case_insensitivity = false)
 * @method   \ChainObject  subreplace1($subject, $replaces, $case_insensitivity = false)
 * @method   \ChainObject  subreplace2($subject, $search, $case_insensitivity = false)
 * @method   \ChainObject  subreplace3($subject, $search, $replaces)
 *
 * @see str_word_count
 * @property \ChainObject $str_word_count
 * @method   \ChainObject  str_word_count(int $format = 0, ?string $characters = null)
 * @method   \ChainObject  str_word_count1(string $string, ?string $characters = null)
 * @method   \ChainObject  str_word_count2(string $string, int $format = 0)
 *
 * @see str_word_count
 * @property \ChainObject $word_count
 * @method   \ChainObject  word_count(int $format = 0, ?string $characters = null)
 * @method   \ChainObject  word_count1(string $string, ?string $characters = null)
 * @method   \ChainObject  word_count2(string $string, int $format = 0)
 *
 * @see strcasecmp
 * @method   \ChainObject  strcasecmp(string $string2)
 * @method   \ChainObject  strcasecmp1(string $string1)
 *
 * @see strcat
 * @method   \ChainObject  strcat(...$variadic)
 * @method   \ChainObject  strcat1(...$variadic)
 * @method   \ChainObject  strcat2(...$variadic)
 * @method   \ChainObject  strcat3(...$variadic)
 * @method   \ChainObject  strcat4(...$variadic)
 * @method   \ChainObject  strcat5(...$variadic)
 *
 * @see strchr
 * @method   \ChainObject  strchr(string $needle, bool $before_needle = false)
 * @method   \ChainObject  strchr1(string $haystack, bool $before_needle = false)
 * @method   \ChainObject  strchr2(string $haystack, string $needle)
 *
 * @see strcmp
 * @method   \ChainObject  strcmp(string $string2)
 * @method   \ChainObject  strcmp1(string $string1)
 *
 * @see strcoll
 * @method   \ChainObject  strcoll(string $string2)
 * @method   \ChainObject  strcoll1(string $string1)
 *
 * @see strcspn
 * @method   \ChainObject  strcspn(string $characters, int $offset = 0, ?int $length = null)
 * @method   \ChainObject  strcspn1(string $string, int $offset = 0, ?int $length = null)
 * @method   \ChainObject  strcspn2(string $string, string $characters, ?int $length = null)
 * @method   \ChainObject  strcspn3(string $string, string $characters, int $offset = 0)
 *
 * @see stream_bucket_append
 * @method   \ChainObject  stream_bucket_append(object $bucket)
 * @method   \ChainObject  stream_bucket_append1($brigade)
 *
 * @see stream_bucket_make_writeable
 * @property \ChainObject $stream_bucket_make_writeable
 * @method   \ChainObject  stream_bucket_make_writeable()
 *
 * @see stream_bucket_new
 * @method   \ChainObject  stream_bucket_new(string $buffer)
 * @method   \ChainObject  stream_bucket_new1($stream)
 *
 * @see stream_bucket_prepend
 * @method   \ChainObject  stream_bucket_prepend(object $bucket)
 * @method   \ChainObject  stream_bucket_prepend1($brigade)
 *
 * @see stream_context_create
 * @method   \ChainObject  stream_context_create(?array $params = null)
 * @method   \ChainObject  stream_context_create1(?array $options = null)
 *
 * @see stream_context_get_default
 * @method   \ChainObject  stream_context_get_default()
 *
 * @see stream_context_get_options
 * @property \ChainObject $stream_context_get_options
 * @method   \ChainObject  stream_context_get_options()
 *
 * @see stream_context_get_params
 * @property \ChainObject $stream_context_get_params
 * @method   \ChainObject  stream_context_get_params()
 *
 * @see stream_context_set_default
 * @property \ChainObject $stream_context_set_default
 * @method   \ChainObject  stream_context_set_default()
 *
 * @see stream_context_set_option
 * @method   \ChainObject  stream_context_set_option(array|string $wrapper_or_options, ?string $option_name = null, mixed $value = null)
 * @method   \ChainObject  stream_context_set_option1($context, ?string $option_name = null, mixed $value = null)
 * @method   \ChainObject  stream_context_set_option2($context, array|string $wrapper_or_options, mixed $value = null)
 * @method   \ChainObject  stream_context_set_option3($context, array|string $wrapper_or_options, ?string $option_name = null)
 *
 * @see stream_context_set_params
 * @method   \ChainObject  stream_context_set_params(array $params)
 * @method   \ChainObject  stream_context_set_params1($context)
 *
 * @see stream_copy_to_stream
 * @method   \ChainObject  stream_copy_to_stream($to, ?int $length = null, int $offset = 0)
 * @method   \ChainObject  stream_copy_to_stream1($from, ?int $length = null, int $offset = 0)
 * @method   \ChainObject  stream_copy_to_stream2($from, $to, int $offset = 0)
 * @method   \ChainObject  stream_copy_to_stream3($from, $to, ?int $length = null)
 *
 * @see stream_filter_append
 * @method   \ChainObject  stream_filter_append(string $filter_name, int $mode = 0, mixed $params = null)
 * @method   \ChainObject  stream_filter_append1($stream, int $mode = 0, mixed $params = null)
 * @method   \ChainObject  stream_filter_append2($stream, string $filter_name, mixed $params = null)
 * @method   \ChainObject  stream_filter_append3($stream, string $filter_name, int $mode = 0)
 *
 * @see stream_filter_prepend
 * @method   \ChainObject  stream_filter_prepend(string $filter_name, int $mode = 0, mixed $params = null)
 * @method   \ChainObject  stream_filter_prepend1($stream, int $mode = 0, mixed $params = null)
 * @method   \ChainObject  stream_filter_prepend2($stream, string $filter_name, mixed $params = null)
 * @method   \ChainObject  stream_filter_prepend3($stream, string $filter_name, int $mode = 0)
 *
 * @see stream_filter_register
 * @method   \ChainObject  stream_filter_register(string $class)
 * @method   \ChainObject  stream_filter_register1(string $filter_name)
 *
 * @see stream_filter_remove
 * @property \ChainObject $stream_filter_remove
 * @method   \ChainObject  stream_filter_remove()
 *
 * @see stream_get_contents
 * @property \ChainObject $stream_get_contents
 * @method   \ChainObject  stream_get_contents(?int $length = null, int $offset = -1)
 * @method   \ChainObject  stream_get_contents1($stream, int $offset = -1)
 * @method   \ChainObject  stream_get_contents2($stream, ?int $length = null)
 *
 * @see stream_get_line
 * @method   \ChainObject  stream_get_line(int $length, string $ending = "")
 * @method   \ChainObject  stream_get_line1($stream, string $ending = "")
 * @method   \ChainObject  stream_get_line2($stream, int $length)
 *
 * @see stream_get_meta_data
 * @property \ChainObject $stream_get_meta_data
 * @method   \ChainObject  stream_get_meta_data()
 *
 * @see stream_is_local
 * @property \ChainObject $stream_is_local
 * @method   \ChainObject  stream_is_local()
 *
 * @see stream_isatty
 * @property \ChainObject $stream_isatty
 * @method   \ChainObject  stream_isatty()
 *
 * @see stream_register_wrapper
 * @method   \ChainObject  stream_register_wrapper(string $class, int $flags = 0)
 * @method   \ChainObject  stream_register_wrapper1(string $protocol, int $flags = 0)
 * @method   \ChainObject  stream_register_wrapper2(string $protocol, string $class)
 *
 * @see stream_resolve_include_path
 * @property \ChainObject $stream_resolve_include_path
 * @method   \ChainObject  stream_resolve_include_path()
 *
 * @see stream_set_blocking
 * @method   \ChainObject  stream_set_blocking(bool $enable)
 * @method   \ChainObject  stream_set_blocking1($stream)
 *
 * @see stream_set_chunk_size
 * @method   \ChainObject  stream_set_chunk_size(int $size)
 * @method   \ChainObject  stream_set_chunk_size1($stream)
 *
 * @see stream_set_read_buffer
 * @method   \ChainObject  stream_set_read_buffer(int $size)
 * @method   \ChainObject  stream_set_read_buffer1($stream)
 *
 * @see stream_set_timeout
 * @method   \ChainObject  stream_set_timeout(int $seconds, int $microseconds = 0)
 * @method   \ChainObject  stream_set_timeout1($stream, int $microseconds = 0)
 * @method   \ChainObject  stream_set_timeout2($stream, int $seconds)
 *
 * @see stream_set_write_buffer
 * @method   \ChainObject  stream_set_write_buffer(int $size)
 * @method   \ChainObject  stream_set_write_buffer1($stream)
 *
 * @see stream_socket_enable_crypto
 * @method   \ChainObject  stream_socket_enable_crypto(bool $enable, ?int $crypto_method = null, $session_stream = null)
 * @method   \ChainObject  stream_socket_enable_crypto1($stream, ?int $crypto_method = null, $session_stream = null)
 * @method   \ChainObject  stream_socket_enable_crypto2($stream, bool $enable, $session_stream = null)
 * @method   \ChainObject  stream_socket_enable_crypto3($stream, bool $enable, ?int $crypto_method = null)
 *
 * @see stream_socket_get_name
 * @method   \ChainObject  stream_socket_get_name(bool $remote)
 * @method   \ChainObject  stream_socket_get_name1($socket)
 *
 * @see stream_socket_pair
 * @method   \ChainObject  stream_socket_pair(int $type, int $protocol)
 * @method   \ChainObject  stream_socket_pair1(int $domain, int $protocol)
 * @method   \ChainObject  stream_socket_pair2(int $domain, int $type)
 *
 * @see stream_socket_sendto
 * @method   \ChainObject  stream_socket_sendto(string $data, int $flags = 0, string $address = "")
 * @method   \ChainObject  stream_socket_sendto1($socket, int $flags = 0, string $address = "")
 * @method   \ChainObject  stream_socket_sendto2($socket, string $data, string $address = "")
 * @method   \ChainObject  stream_socket_sendto3($socket, string $data, int $flags = 0)
 *
 * @see stream_socket_shutdown
 * @method   \ChainObject  stream_socket_shutdown(int $mode)
 * @method   \ChainObject  stream_socket_shutdown1($stream)
 *
 * @see stream_supports_lock
 * @property \ChainObject $stream_supports_lock
 * @method   \ChainObject  stream_supports_lock()
 *
 * @see stream_wrapper_register
 * @method   \ChainObject  stream_wrapper_register(string $class, int $flags = 0)
 * @method   \ChainObject  stream_wrapper_register1(string $protocol, int $flags = 0)
 * @method   \ChainObject  stream_wrapper_register2(string $protocol, string $class)
 *
 * @see stream_wrapper_restore
 * @property \ChainObject $stream_wrapper_restore
 * @method   \ChainObject  stream_wrapper_restore()
 *
 * @see stream_wrapper_unregister
 * @property \ChainObject $stream_wrapper_unregister
 * @method   \ChainObject  stream_wrapper_unregister()
 *
 * @see strftime
 * @property \ChainObject $strftime
 * @method   \ChainObject  strftime(?int $timestamp = null)
 * @method   \ChainObject  strftime1(string $format)
 *
 * @see stringify
 * @property \ChainObject $stringify
 * @method   \ChainObject  stringify()
 *
 * @see strip_tags
 * @property \ChainObject $strip_tags
 * @method   \ChainObject  strip_tags(array|string|null $allowed_tags = null)
 * @method   \ChainObject  strip_tags1(string $string)
 *
 * @see stripcslashes
 * @property \ChainObject $stripcslashes
 * @method   \ChainObject  stripcslashes()
 *
 * @see stripos
 * @method   \ChainObject  stripos(string $needle, int $offset = 0)
 * @method   \ChainObject  stripos1(string $haystack, int $offset = 0)
 * @method   \ChainObject  stripos2(string $haystack, string $needle)
 *
 * @see stripslashes
 * @property \ChainObject $stripslashes
 * @method   \ChainObject  stripslashes()
 *
 * @see stristr
 * @method   \ChainObject  stristr(string $needle, bool $before_needle = false)
 * @method   \ChainObject  stristr1(string $haystack, bool $before_needle = false)
 * @method   \ChainObject  stristr2(string $haystack, string $needle)
 *
 * @see strlen
 * @property \ChainObject $strlen
 * @method   \ChainObject  strlen()
 *
 * @see strnatcasecmp
 * @method   \ChainObject  strnatcasecmp(string $string2)
 * @method   \ChainObject  strnatcasecmp1(string $string1)
 *
 * @see strnatcmp
 * @method   \ChainObject  strnatcmp(string $string2)
 * @method   \ChainObject  strnatcmp1(string $string1)
 *
 * @see strncasecmp
 * @method   \ChainObject  strncasecmp(string $string2, int $length)
 * @method   \ChainObject  strncasecmp1(string $string1, int $length)
 * @method   \ChainObject  strncasecmp2(string $string1, string $string2)
 *
 * @see strncmp
 * @method   \ChainObject  strncmp(string $string2, int $length)
 * @method   \ChainObject  strncmp1(string $string1, int $length)
 * @method   \ChainObject  strncmp2(string $string1, string $string2)
 *
 * @see strpbrk
 * @method   \ChainObject  strpbrk(string $characters)
 * @method   \ChainObject  strpbrk1(string $string)
 *
 * @see strpos
 * @method   \ChainObject  strpos(string $needle, int $offset = 0)
 * @method   \ChainObject  strpos1(string $haystack, int $offset = 0)
 * @method   \ChainObject  strpos2(string $haystack, string $needle)
 *
 * @see strpos_array
 * @method   \ChainObject  strpos_array($needles, $offset = 0)
 * @method   \ChainObject  strpos_array1($haystack, $offset = 0)
 * @method   \ChainObject  strpos_array2($haystack, $needles)
 *
 * @see strpos_quoted
 * @method   \ChainObject  strpos_quoted($needle, $offset = 0, $enclosure = "'\"", $escape = "\\")
 * @method   \ChainObject  strpos_quoted1($haystack, $offset = 0, $enclosure = "'\"", $escape = "\\")
 * @method   \ChainObject  strpos_quoted2($haystack, $needle, $enclosure = "'\"", $escape = "\\")
 * @method   \ChainObject  strpos_quoted3($haystack, $needle, $offset = 0, $escape = "\\")
 * @method   \ChainObject  strpos_quoted4($haystack, $needle, $offset = 0, $enclosure = "'\"")
 *
 * @see strptime
 * @method   \ChainObject  strptime(string $format)
 * @method   \ChainObject  strptime1(string $timestamp)
 *
 * @see strrchr
 * @method   \ChainObject  strrchr(string $needle)
 * @method   \ChainObject  strrchr1(string $haystack)
 *
 * @see strrev
 * @property \ChainObject $strrev
 * @method   \ChainObject  strrev()
 *
 * @see strripos
 * @method   \ChainObject  strripos(string $needle, int $offset = 0)
 * @method   \ChainObject  strripos1(string $haystack, int $offset = 0)
 * @method   \ChainObject  strripos2(string $haystack, string $needle)
 *
 * @see strrpos
 * @method   \ChainObject  strrpos(string $needle, int $offset = 0)
 * @method   \ChainObject  strrpos1(string $haystack, int $offset = 0)
 * @method   \ChainObject  strrpos2(string $haystack, string $needle)
 *
 * @see strrstr
 * @method   \ChainObject  strrstr($needle, $after_needle = true)
 * @method   \ChainObject  strrstr1($haystack, $after_needle = true)
 * @method   \ChainObject  strrstr2($haystack, $needle)
 *
 * @see strspn
 * @method   \ChainObject  strspn(string $characters, int $offset = 0, ?int $length = null)
 * @method   \ChainObject  strspn1(string $string, int $offset = 0, ?int $length = null)
 * @method   \ChainObject  strspn2(string $string, string $characters, ?int $length = null)
 * @method   \ChainObject  strspn3(string $string, string $characters, int $offset = 0)
 *
 * @see strstr
 * @method   \ChainObject  strstr(string $needle, bool $before_needle = false)
 * @method   \ChainObject  strstr1(string $haystack, bool $before_needle = false)
 * @method   \ChainObject  strstr2(string $haystack, string $needle)
 *
 * @see strtok
 * @property \ChainObject $strtok
 * @method   \ChainObject  strtok(?string $token = null)
 * @method   \ChainObject  strtok1(string $string)
 *
 * @see strtolower
 * @property \ChainObject $strtolower
 * @method   \ChainObject  strtolower()
 *
 * @see strtotime
 * @property \ChainObject $strtotime
 * @method   \ChainObject  strtotime(?int $baseTimestamp = null)
 * @method   \ChainObject  strtotime1(string $datetime)
 *
 * @see strtoupper
 * @property \ChainObject $strtoupper
 * @method   \ChainObject  strtoupper()
 *
 * @see strtr
 * @method   \ChainObject  strtr(array|string $from, ?string $to = null)
 * @method   \ChainObject  strtr1(string $string, ?string $to = null)
 * @method   \ChainObject  strtr2(string $string, array|string $from)
 *
 * @see strval
 * @property \ChainObject $strval
 * @method   \ChainObject  strval()
 *
 * @see substr
 * @method   \ChainObject  substr(int $offset, ?int $length = null)
 * @method   \ChainObject  substr1(string $string, ?int $length = null)
 * @method   \ChainObject  substr2(string $string, int $offset)
 *
 * @see substr_compare
 * @method   \ChainObject  substr_compare(string $needle, int $offset, ?int $length = null, bool $case_insensitive = false)
 * @method   \ChainObject  substr_compare1(string $haystack, int $offset, ?int $length = null, bool $case_insensitive = false)
 * @method   \ChainObject  substr_compare2(string $haystack, string $needle, ?int $length = null, bool $case_insensitive = false)
 * @method   \ChainObject  substr_compare3(string $haystack, string $needle, int $offset, bool $case_insensitive = false)
 * @method   \ChainObject  substr_compare4(string $haystack, string $needle, int $offset, ?int $length = null)
 *
 * @see substr_count
 * @method   \ChainObject  substr_count(string $needle, int $offset = 0, ?int $length = null)
 * @method   \ChainObject  substr_count1(string $haystack, int $offset = 0, ?int $length = null)
 * @method   \ChainObject  substr_count2(string $haystack, string $needle, ?int $length = null)
 * @method   \ChainObject  substr_count3(string $haystack, string $needle, int $offset = 0)
 *
 * @see substr_replace
 * @method   \ChainObject  substr_replace(array|string $replace, array|int $offset, array|int|null $length = null)
 * @method   \ChainObject  substr_replace1(array|string $string, array|int $offset, array|int|null $length = null)
 * @method   \ChainObject  substr_replace2(array|string $string, array|string $replace, array|int|null $length = null)
 * @method   \ChainObject  substr_replace3(array|string $string, array|string $replace, array|int $offset)
 *
 * @see sum
 * @method   \ChainObject  sum(...$variadic)
 * @method   \ChainObject  sum1(...$variadic)
 * @method   \ChainObject  sum2(...$variadic)
 * @method   \ChainObject  sum3(...$variadic)
 * @method   \ChainObject  sum4(...$variadic)
 * @method   \ChainObject  sum5(...$variadic)
 *
 * @see switchs
 * @method   \ChainObject  switchs($cases, $default = null)
 * @method   \ChainObject  switchs1($value, $default = null)
 * @method   \ChainObject  switchs2($value, $cases)
 *
 * @see symlink
 * @method   \ChainObject  symlink(string $link)
 * @method   \ChainObject  symlink1(string $target)
 *
 * @see syslog
 * @method   \ChainObject  syslog(string $message)
 * @method   \ChainObject  syslog1(int $priority)
 *
 * @see tan
 * @property \ChainObject $tan
 * @method   \ChainObject  tan()
 *
 * @see tanh
 * @property \ChainObject $tanh
 * @method   \ChainObject  tanh()
 *
 * @see tempnam
 * @method   \ChainObject  tempnam(string $prefix)
 * @method   \ChainObject  tempnam1(string $directory)
 *
 * @see throw_if
 * @method   \ChainObject  throw_if($ex, ...$ex_args)
 * @method   \ChainObject  throw_if1($flag, ...$ex_args)
 * @method   \ChainObject  throw_if2($flag, $ex, ...$ex_args)
 * @method   \ChainObject  throw_if3($flag, $ex, ...$ex_args)
 * @method   \ChainObject  throw_if4($flag, $ex, ...$ex_args)
 * @method   \ChainObject  throw_if5($flag, $ex, ...$ex_args)
 * @method   \ChainObject  throw_if6($flag, $ex, ...$ex_args)
 * @method   \ChainObject  throw_if7($flag, $ex, ...$ex_args)
 *
 * @see throws
 * @property \ChainObject $throws
 * @method   \ChainObject  throws()
 *
 * @see time_nanosleep
 * @method   \ChainObject  time_nanosleep(int $nanoseconds)
 * @method   \ChainObject  time_nanosleep1(int $seconds)
 *
 * @see time_sleep_until
 * @property \ChainObject $time_sleep_until
 * @method   \ChainObject  time_sleep_until()
 *
 * @see timer
 * @property \ChainObject $timer
 * @method   \ChainObject  timer($count = 1)
 * @method   \ChainObject  timer1(callable $callable)
 * @method   \ChainObject  timerP($count = 1)
 * @method   \ChainObject  timerP1(callable $callable)
 * @method   \ChainObject  timerE($count = 1)
 * @method   \ChainObject  timerE1(callable $callable)
 *
 * @see timezone_identifiers_list
 * @method   \ChainObject  timezone_identifiers_list(?string $countryCode = null)
 * @method   \ChainObject  timezone_identifiers_list1(int $timezoneGroup = DateTimeZone::ALL)
 *
 * @see timezone_location_get
 * @property \ChainObject $timezone_location_get
 * @method   \ChainObject  timezone_location_get()
 *
 * @see timezone_name_from_abbr
 * @property \ChainObject $timezone_name_from_abbr
 * @method   \ChainObject  timezone_name_from_abbr(int $utcOffset = -1, int $isDST = -1)
 * @method   \ChainObject  timezone_name_from_abbr1(string $abbr, int $isDST = -1)
 * @method   \ChainObject  timezone_name_from_abbr2(string $abbr, int $utcOffset = -1)
 *
 * @see timezone_name_get
 * @property \ChainObject $timezone_name_get
 * @method   \ChainObject  timezone_name_get()
 *
 * @see timezone_offset_get
 * @method   \ChainObject  timezone_offset_get(\DateTimeInterface $datetime)
 * @method   \ChainObject  timezone_offset_get1(\DateTimeZone $object)
 *
 * @see timezone_open
 * @property \ChainObject $timezone_open
 * @method   \ChainObject  timezone_open()
 *
 * @see timezone_transitions_get
 * @property \ChainObject $timezone_transitions_get
 * @method   \ChainObject  timezone_transitions_get(int $timestampBegin = PHP_INT_MIN, int $timestampEnd = PHP_INT_MAX)
 * @method   \ChainObject  timezone_transitions_get1(\DateTimeZone $object, int $timestampEnd = PHP_INT_MAX)
 * @method   \ChainObject  timezone_transitions_get2(\DateTimeZone $object, int $timestampBegin = PHP_INT_MIN)
 *
 * @see tmpname
 * @method   \ChainObject  tmpname($dir = null)
 * @method   \ChainObject  tmpname1($prefix = "rft")
 *
 * @see touch
 * @property \ChainObject $touch
 * @method   \ChainObject  touch(?int $mtime = null, ?int $atime = null)
 * @method   \ChainObject  touch1(string $filename, ?int $atime = null)
 * @method   \ChainObject  touch2(string $filename, ?int $mtime = null)
 *
 * @see trait_exists
 * @property \ChainObject $trait_exists
 * @method   \ChainObject  trait_exists(bool $autoload = true)
 * @method   \ChainObject  trait_exists1(string $trait)
 *
 * @see trigger_error
 * @property \ChainObject $trigger_error
 * @method   \ChainObject  trigger_error(int $error_level = E_USER_NOTICE)
 * @method   \ChainObject  trigger_error1(string $message)
 *
 * @see trim
 * @property \ChainObject $trim
 * @method   \ChainObject  trim(string $characters = " 
	\000")
 * @method   \ChainObject  trim1(string $string)
 *
 * @see try_catch
 * @property \ChainObject $try_catch
 * @method   \ChainObject  try_catch($catch = null, ...$variadic)
 * @method   \ChainObject  try_catch1($try, ...$variadic)
 * @method   \ChainObject  try_catch2($try, $catch = null, ...$variadic)
 * @method   \ChainObject  try_catch3($try, $catch = null, ...$variadic)
 * @method   \ChainObject  try_catch4($try, $catch = null, ...$variadic)
 * @method   \ChainObject  try_catch5($try, $catch = null, ...$variadic)
 * @method   \ChainObject  try_catch6($try, $catch = null, ...$variadic)
 * @method   \ChainObject  try_catch7($try, $catch = null, ...$variadic)
 *
 * @see try_catch_finally
 * @property \ChainObject $try_catch_finally
 * @method   \ChainObject  try_catch_finally($catch = null, $finally = null, ...$variadic)
 * @method   \ChainObject  try_catch_finally1($try, $finally = null, ...$variadic)
 * @method   \ChainObject  try_catch_finally2($try, $catch = null, ...$variadic)
 * @method   \ChainObject  try_catch_finally3($try, $catch = null, $finally = null, ...$variadic)
 * @method   \ChainObject  try_catch_finally4($try, $catch = null, $finally = null, ...$variadic)
 * @method   \ChainObject  try_catch_finally5($try, $catch = null, $finally = null, ...$variadic)
 * @method   \ChainObject  try_catch_finally6($try, $catch = null, $finally = null, ...$variadic)
 * @method   \ChainObject  try_catch_finally7($try, $catch = null, $finally = null, ...$variadic)
 * @method   \ChainObject  try_catch_finally8($try, $catch = null, $finally = null, ...$variadic)
 *
 * @see try_finally
 * @property \ChainObject $try_finally
 * @method   \ChainObject  try_finally($finally = null, ...$variadic)
 * @method   \ChainObject  try_finally1($try, ...$variadic)
 * @method   \ChainObject  try_finally2($try, $finally = null, ...$variadic)
 * @method   \ChainObject  try_finally3($try, $finally = null, ...$variadic)
 * @method   \ChainObject  try_finally4($try, $finally = null, ...$variadic)
 * @method   \ChainObject  try_finally5($try, $finally = null, ...$variadic)
 * @method   \ChainObject  try_finally6($try, $finally = null, ...$variadic)
 * @method   \ChainObject  try_finally7($try, $finally = null, ...$variadic)
 *
 * @see try_null
 * @property \ChainObject $try_null
 * @method   \ChainObject  try_null(...$variadic)
 * @method   \ChainObject  try_null1($try, ...$variadic)
 * @method   \ChainObject  try_null2($try, ...$variadic)
 * @method   \ChainObject  try_null3($try, ...$variadic)
 * @method   \ChainObject  try_null4($try, ...$variadic)
 * @method   \ChainObject  try_null5($try, ...$variadic)
 * @method   \ChainObject  try_null6($try, ...$variadic)
 *
 * @see try_return
 * @property \ChainObject $try_return
 * @method   \ChainObject  try_return(...$variadic)
 * @method   \ChainObject  try_return1($try, ...$variadic)
 * @method   \ChainObject  try_return2($try, ...$variadic)
 * @method   \ChainObject  try_return3($try, ...$variadic)
 * @method   \ChainObject  try_return4($try, ...$variadic)
 * @method   \ChainObject  try_return5($try, ...$variadic)
 * @method   \ChainObject  try_return6($try, ...$variadic)
 *
 * @see type_exists
 * @property \ChainObject $type_exists
 * @method   \ChainObject  type_exists($autoload = true)
 * @method   \ChainObject  type_exists1($typename)
 *
 * @see ucfirst
 * @property \ChainObject $ucfirst
 * @method   \ChainObject  ucfirst()
 *
 * @see ucwords
 * @property \ChainObject $ucwords
 * @method   \ChainObject  ucwords(string $separators = " 	
")
 * @method   \ChainObject  ucwords1(string $string)
 *
 * @see umask
 * @method   \ChainObject  umask()
 *
 * @see uniqid
 * @method   \ChainObject  uniqid(bool $more_entropy = false)
 * @method   \ChainObject  uniqid1(string $prefix = "")
 *
 * @see unique_string
 * @property \ChainObject $unique_string
 * @method   \ChainObject  unique_string($initial = null, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")
 * @method   \ChainObject  unique_string1($source, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")
 * @method   \ChainObject  unique_string2($source, $initial = null)
 *
 * @see unlink
 * @property \ChainObject $unlink
 * @method   \ChainObject  unlink($context = null)
 * @method   \ChainObject  unlink1(string $filename)
 *
 * @see unpack
 * @method   \ChainObject  unpack(string $string, int $offset = 0)
 * @method   \ChainObject  unpack1(string $format, int $offset = 0)
 * @method   \ChainObject  unpack2(string $format, string $string)
 *
 * @see unregister_tick_function
 * @property \ChainObject $unregister_tick_function
 * @method   \ChainObject  unregister_tick_function()
 * @method   \ChainObject  unregister_tick_functionP()
 * @method   \ChainObject  unregister_tick_functionE()
 *
 * @see unserialize
 * @property \ChainObject $unserialize
 * @method   \ChainObject  unserialize(array $options = [])
 * @method   \ChainObject  unserialize1(string $data)
 *
 * @see urldecode
 * @property \ChainObject $urldecode
 * @method   \ChainObject  urldecode()
 *
 * @see urlencode
 * @property \ChainObject $urlencode
 * @method   \ChainObject  urlencode()
 *
 * @see user_error
 * @property \ChainObject $user_error
 * @method   \ChainObject  user_error(int $error_level = E_USER_NOTICE)
 * @method   \ChainObject  user_error1(string $message)
 *
 * @see usleep
 * @property \ChainObject $usleep
 * @method   \ChainObject  usleep()
 *
 * @see utf8_decode
 * @property \ChainObject $utf8_decode
 * @method   \ChainObject  utf8_decode()
 *
 * @see utf8_encode
 * @property \ChainObject $utf8_encode
 * @method   \ChainObject  utf8_encode()
 *
 * @see var_apply
 * @method   \ChainObject  var_apply($callback, ...$args)
 * @method   \ChainObject  var_apply1($var, ...$args)
 * @method   \ChainObject  var_apply2($var, $callback, ...$args)
 * @method   \ChainObject  var_apply3($var, $callback, ...$args)
 * @method   \ChainObject  var_apply4($var, $callback, ...$args)
 * @method   \ChainObject  var_apply5($var, $callback, ...$args)
 * @method   \ChainObject  var_apply6($var, $callback, ...$args)
 * @method   \ChainObject  var_apply7($var, $callback, ...$args)
 * @method   \ChainObject  var_applyP($callback, ...$args)
 * @method   \ChainObject  var_applyP1($var, ...$args)
 * @method   \ChainObject  var_applyP2($var, $callback, ...$args)
 * @method   \ChainObject  var_applyP3($var, $callback, ...$args)
 * @method   \ChainObject  var_applyP4($var, $callback, ...$args)
 * @method   \ChainObject  var_applyP5($var, $callback, ...$args)
 * @method   \ChainObject  var_applyP6($var, $callback, ...$args)
 * @method   \ChainObject  var_applyP7($var, $callback, ...$args)
 * @method   \ChainObject  var_applyE($callback, ...$args)
 * @method   \ChainObject  var_applyE1($var, ...$args)
 * @method   \ChainObject  var_applyE2($var, $callback, ...$args)
 * @method   \ChainObject  var_applyE3($var, $callback, ...$args)
 * @method   \ChainObject  var_applyE4($var, $callback, ...$args)
 * @method   \ChainObject  var_applyE5($var, $callback, ...$args)
 * @method   \ChainObject  var_applyE6($var, $callback, ...$args)
 * @method   \ChainObject  var_applyE7($var, $callback, ...$args)
 *
 * @see var_applys
 * @method   \ChainObject  var_applys($callback, ...$args)
 * @method   \ChainObject  var_applys1($var, ...$args)
 * @method   \ChainObject  var_applys2($var, $callback, ...$args)
 * @method   \ChainObject  var_applys3($var, $callback, ...$args)
 * @method   \ChainObject  var_applys4($var, $callback, ...$args)
 * @method   \ChainObject  var_applys5($var, $callback, ...$args)
 * @method   \ChainObject  var_applys6($var, $callback, ...$args)
 * @method   \ChainObject  var_applys7($var, $callback, ...$args)
 * @method   \ChainObject  var_applysP($callback, ...$args)
 * @method   \ChainObject  var_applysP1($var, ...$args)
 * @method   \ChainObject  var_applysP2($var, $callback, ...$args)
 * @method   \ChainObject  var_applysP3($var, $callback, ...$args)
 * @method   \ChainObject  var_applysP4($var, $callback, ...$args)
 * @method   \ChainObject  var_applysP5($var, $callback, ...$args)
 * @method   \ChainObject  var_applysP6($var, $callback, ...$args)
 * @method   \ChainObject  var_applysP7($var, $callback, ...$args)
 * @method   \ChainObject  var_applysE($callback, ...$args)
 * @method   \ChainObject  var_applysE1($var, ...$args)
 * @method   \ChainObject  var_applysE2($var, $callback, ...$args)
 * @method   \ChainObject  var_applysE3($var, $callback, ...$args)
 * @method   \ChainObject  var_applysE4($var, $callback, ...$args)
 * @method   \ChainObject  var_applysE5($var, $callback, ...$args)
 * @method   \ChainObject  var_applysE6($var, $callback, ...$args)
 * @method   \ChainObject  var_applysE7($var, $callback, ...$args)
 *
 * @see var_dump
 * @property \ChainObject $var_dump
 * @method   \ChainObject  var_dump(...mixed $values)
 * @method   \ChainObject  var_dump1(mixed $value, ...mixed $values)
 * @method   \ChainObject  var_dump2(mixed $value, ...mixed $values)
 * @method   \ChainObject  var_dump3(mixed $value, ...mixed $values)
 * @method   \ChainObject  var_dump4(mixed $value, ...mixed $values)
 * @method   \ChainObject  var_dump5(mixed $value, ...mixed $values)
 * @method   \ChainObject  var_dump6(mixed $value, ...mixed $values)
 *
 * @see var_export
 * @property \ChainObject $var_export
 * @method   \ChainObject  var_export(bool $return = false)
 * @method   \ChainObject  var_export1(mixed $value)
 *
 * @see var_export2
 * @property \ChainObject $var_export2
 * @method   \ChainObject  var_export2($return = false)
 * @method   \ChainObject  var_export21($value)
 *
 * @see var_export3
 * @property \ChainObject $var_export3
 * @method   \ChainObject  var_export3($return = false)
 * @method   \ChainObject  var_export31($value)
 *
 * @see var_hash
 * @property \ChainObject $var_hash
 * @method   \ChainObject  var_hash($algos = ["md5", "sha1"], $base64 = true)
 * @method   \ChainObject  var_hash1($var, $base64 = true)
 * @method   \ChainObject  var_hash2($var, $algos = ["md5", "sha1"])
 *
 * @see var_html
 * @property \ChainObject $var_html
 * @method   \ChainObject  var_html()
 *
 * @see var_pretty
 * @property \ChainObject $var_pretty
 * @method   \ChainObject  var_pretty($options = [])
 * @method   \ChainObject  var_pretty1($value)
 *
 * @see var_type
 * @property \ChainObject $var_type
 * @method   \ChainObject  var_type($valid_name = false)
 * @method   \ChainObject  var_type1($var)
 *
 * @see varcmp
 * @method   \ChainObject  varcmp($b, $mode = null, $precision = null)
 * @method   \ChainObject  varcmp1($a, $mode = null, $precision = null)
 * @method   \ChainObject  varcmp2($a, $b, $precision = null)
 * @method   \ChainObject  varcmp3($a, $b, $mode = null)
 *
 * @see version_compare
 * @method   \ChainObject  version_compare(string $version2, ?string $operator = null)
 * @method   \ChainObject  version_compare1(string $version1, ?string $operator = null)
 * @method   \ChainObject  version_compare2(string $version1, string $version2)
 *
 * @see vfprintf
 * @method   \ChainObject  vfprintf(string $format, array $values)
 * @method   \ChainObject  vfprintf1($stream, array $values)
 * @method   \ChainObject  vfprintf2($stream, string $format)
 *
 * @see vprintf
 * @method   \ChainObject  vprintf(array $values)
 * @method   \ChainObject  vprintf1(string $format)
 *
 * @see vsprintf
 * @method   \ChainObject  vsprintf(array $values)
 * @method   \ChainObject  vsprintf1(string $format)
 *
 * @see wordwrap
 * @property \ChainObject $wordwrap
 * @method   \ChainObject  wordwrap(int $width = 75, string $break = "
", bool $cut_long_words = false)
 * @method   \ChainObject  wordwrap1(string $string, string $break = "
", bool $cut_long_words = false)
 * @method   \ChainObject  wordwrap2(string $string, int $width = 75, bool $cut_long_words = false)
 * @method   \ChainObject  wordwrap3(string $string, int $width = 75, string $break = "
")
 *
 * {/annotation}
 */
class ChainObject implements \IteratorAggregate
{
    public function __invoke(...$source) { }

    public function __toString() { return ''; }

    /**
     * @param string $name
     * @return $this
     */
    public function __get($name) { return $this; }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     */
    public function __call($name, $arguments) { return $this; }

    /**
     * @param callable $callback
     * @param mixed ...$args
     * @return $this
     */
    public function apply($callback, ...$args) { return $this; }

    /**
     * @return \Traversable
     */
    public function getIterator() { return new \ArrayIterator([]); }
}
