<?php

/** Don't touch this code. This is auto generated. */

if (!isset($excluded_functions['arrayize']) && (!function_exists('arrayize') || (new \ReflectionFunction('arrayize'))->isInternal())) {
    /**
     * 引数の配列を生成する。
     *
     * 配列以外を渡すと配列化されて追加される。
     * 連想配列は未対応。あくまで普通の配列化のみ。
     * iterable や Traversable は考慮せずあくまで「配列」としてチェックする。
     *
     * Example:
     * <code>
     * assertSame(arrayize(1, 2, 3), [1, 2, 3]);
     * assertSame(arrayize([1], [2], [3]), [1, 2, 3]);
     * $object = new \stdClass();
     * assertSame(arrayize($object, false, [1, 2, 3]), [$object, false, 1, 2, 3]);
     * </code>
     *
     * @package Array
     *
     * @param mixed $variadic 生成する要素（可変引数）
     * @return array 引数を配列化したもの
     */
    function arrayize(...$variadic)
    {
        $result = [];
        foreach ($variadic as $arg) {
            if (!is_array($arg)) {
                $arg = [$arg];
            }
            $result = array_merge($result, $arg);
        }
        return $result;
    }
}
if (!isset($excluded_functions['is_hasharray']) && (!function_exists('is_hasharray') || (new \ReflectionFunction('is_hasharray'))->isInternal())) {
    /**
     * 配列が連想配列か調べる
     *
     * 空の配列は普通の配列とみなす。
     *
     * Example:
     * <code>
     * assertFalse(is_hasharray([]));
     * assertFalse(is_hasharray([1, 2, 3]));
     * assertTrue(is_hasharray(['x' => 'X']));
     * </code>
     *
     * @package Array
     *
     * @param array $array 調べる配列
     * @return bool 連想配列なら true
     */
    function is_hasharray($array)
    {
        $i = 0;
        foreach ($array as $k => $dummy) {
            if ($k !== $i++) {
                return true;
            }
        }
        return false;
    }
}
if (!isset($excluded_functions['first_key']) && (!function_exists('first_key') || (new \ReflectionFunction('first_key'))->isInternal())) {
    /**
     * 配列の最初のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * <code>
     * assertSame(first_key(['a', 'b', 'c']), 0);
     * assertSame(first_key([], 999), 999);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最初のキー
     */
    function first_key($array, $default = NULL)
    {
        if (empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = call_user_func(first_keyvalue, $array);
        return $k;
    }
}
if (!isset($excluded_functions['first_value']) && (!function_exists('first_value') || (new \ReflectionFunction('first_value'))->isInternal())) {
    /**
     * 配列の最初の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * <code>
     * assertSame(first_value(['a', 'b', 'c']), 'a');
     * assertSame(first_value([], 999), 999);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最初の値
     */
    function first_value($array, $default = NULL)
    {
        if (empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = call_user_func(first_keyvalue, $array);
        return $v;
    }
}
if (!isset($excluded_functions['first_keyvalue']) && (!function_exists('first_keyvalue') || (new \ReflectionFunction('first_keyvalue'))->isInternal())) {
    /**
     * 配列の最初のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * <code>
     * assertSame(first_keyvalue(['a', 'b', 'c']), [0, 'a']);
     * assertSame(first_keyvalue([], 999), 999);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return array [最初のキー, 最初の値]
     */
    function first_keyvalue($array, $default = NULL)
    {
        foreach ($array as $k => $v) {
            return [$k, $v];
        }
        return $default;
    }
}
if (!isset($excluded_functions['last_key']) && (!function_exists('last_key') || (new \ReflectionFunction('last_key'))->isInternal())) {
    /**
     * 配列の最後のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * <code>
     * assertSame(last_key(['a', 'b', 'c']), 2);
     * assertSame(last_key([], 999), 999);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最後のキー
     */
    function last_key($array, $default = NULL)
    {
        if (empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = call_user_func(last_keyvalue, $array);
        return $k;
    }
}
if (!isset($excluded_functions['last_value']) && (!function_exists('last_value') || (new \ReflectionFunction('last_value'))->isInternal())) {
    /**
     * 配列の最後の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * <code>
     * assertSame(last_value(['a', 'b', 'c']), 'c');
     * assertSame(last_value([], 999), 999);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最後の値
     */
    function last_value($array, $default = NULL)
    {
        if (empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = call_user_func(last_keyvalue, $array);
        return $v;
    }
}
if (!isset($excluded_functions['last_keyvalue']) && (!function_exists('last_keyvalue') || (new \ReflectionFunction('last_keyvalue'))->isInternal())) {
    /**
     * 配列の最後のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * <code>
     * assertSame(last_keyvalue(['a', 'b', 'c']), [2, 'c']);
     * assertSame(last_keyvalue([], 999), 999);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return array [最後のキー, 最後の値]
     */
    function last_keyvalue($array, $default = NULL)
    {
        /** @noinspection PhpStatementHasEmptyBodyInspection */
        foreach ($array as $k => $v) {
            // duumy
        }
        // $k がセットされてるなら「ループが最低でも1度回った（≠空）」とみなせる
        if (isset($k)) {
            /** @noinspection PhpUndefinedVariableInspection */
            return [$k, $v];
        }
        return $default;
    }
}
if (!isset($excluded_functions['prev_key']) && (!function_exists('prev_key') || (new \ReflectionFunction('prev_key'))->isInternal())) {
    /**
     * 配列の指定キーの前のキーを返す
     *
     * $key が最初のキーだった場合は null を返す。
     * $key が存在しない場合は false を返す。
     *
     * Example:
     * <code>
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 'b' キーの前は 'a'
     * assertSame(prev_key($array, 'b'), 'a');
     * // 'a' キーの前は無いので null
     * assertSame(prev_key($array, 'a'), null);
     * // 'x' キーはそもそも存在しないので false
     * assertSame(prev_key($array, 'x'), false);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param string|int $key 調べるキー
     * @return string|int|bool|null $key の前のキー
     */
    function prev_key($array, $key)
    {
        $key = (string) $key;
        $current = null;
        foreach ($array as $k => $v) {
            if ($key === (string) $k) {
                return $current;
            }
            $current = $k;
        }
        return false;
    }
}
if (!isset($excluded_functions['next_key']) && (!function_exists('next_key') || (new \ReflectionFunction('next_key'))->isInternal())) {
    /**
     * 配列の指定キーの次のキーを返す
     *
     * $key が最後のキーだった場合は null を返す。
     * $key が存在しない場合は false を返す。
     * $key が未指定だと「次に生成されるキー」（$array[]='hoge' で生成されるキー）を返す。
     *
     * $array[] = 'hoge' で作成されるキーには完全準拠しない（標準は unset すると結構乱れる）。公式マニュアルを参照。
     *
     * Example:
     * <code>
     * $array = [9 => 9, 'a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 'b' キーの次は 'c'
     * assertSame(next_key($array, 'b'), 'c');
     * // 'c' キーの次は無いので null
     * assertSame(next_key($array, 'c'), null);
     * // 'x' キーはそもそも存在しないので false
     * assertSame(next_key($array, 'x'), false);
     * // 次に生成されるキーは 10
     * assertSame(next_key($array, null), 10);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param string|int|null $key 調べるキー
     * @return string|int|bool|null $key の次のキー
     */
    function next_key($array, $key = NULL)
    {
        $keynull = $key === null;
        $key = (string) $key;
        $current = false;
        $max = -1;
        foreach ($array as $k => $v) {
            if ($current !== false) {
                return $k;
            }
            if ($key === (string) $k) {
                $current = null;
            }
            if ($keynull && is_int($k) && $k > $max) {
                $max = $k;
            }
        }
        if ($keynull) {
            // PHP 4.3.0 以降は0以下にはならない
            return max(0, $max + 1);
        }
        else {
            return $current;
        }
    }
}
if (!isset($excluded_functions['in_array_and']) && (!function_exists('in_array_and') || (new \ReflectionFunction('in_array_and'))->isInternal())) {
    /**
     * in_array の複数版（AND）
     *
     * 配列 $haystack が $needle の「すべてを含む」ときに true を返す。
     *
     * $needle が非配列の場合は配列化される。
     * $needle が空の場合は常に false を返す。
     *
     * Example:
     * <code>
     * assertTrue(in_array_and([1], [1, 2, 3]));
     * assertFalse(in_array_and([9], [1, 2, 3]));
     * assertFalse(in_array_and([1, 9], [1, 2, 3]));
     * </code>
     *
     * @package Array
     *
     * @param array|mixed $needle 調べる値
     * @param array $haystack 調べる配列
     * @param bool $strict 厳密フラグ
     * @return bool $needle のすべてが含まれているなら true
     */
    function in_array_and($needle, $haystack, $strict = false)
    {
        $needle = is_array($needle) ? $needle : [$needle];
        if (empty($needle)) {
            return false;
        }

        foreach ($needle as $v) {
            if (!in_array($v, $haystack, $strict)) {
                return false;
            }
        }
        return true;
    }
}
if (!isset($excluded_functions['in_array_or']) && (!function_exists('in_array_or') || (new \ReflectionFunction('in_array_or'))->isInternal())) {
    /**
     * in_array の複数版（OR）
     *
     * 配列 $haystack が $needle の「どれかを含む」ときに true を返す。
     *
     * $needle が非配列の場合は配列化される。
     * $needle が空の場合は常に false を返す。
     *
     * Example:
     * <code>
     * assertTrue(in_array_or([1], [1, 2, 3]), true);
     * assertFalse(in_array_or([9], [1, 2, 3]), false);
     * assertTrue(in_array_or([1, 9], [1, 2, 3]), true);
     * </code>
     *
     * @package Array
     *
     * @param array|mixed $needle 調べる値
     * @param array $haystack 調べる配列
     * @param bool $strict 厳密フラグ
     * @return bool $needle のどれかが含まれているなら true
     */
    function in_array_or($needle, $haystack, $strict = false)
    {
        $needle = is_array($needle) ? $needle : [$needle];
        if (empty($needle)) {
            return false;
        }

        foreach ($needle as $v) {
            if (in_array($v, $haystack, $strict)) {
                return true;
            }
        }
        return false;
    }
}
if (!isset($excluded_functions['array_add']) && (!function_exists('array_add') || (new \ReflectionFunction('array_add'))->isInternal())) {
    /**
     * 配列の+演算子の関数版
     *
     * Example:
     * <code>
     * // ただの加算の関数版なので同じキーは上書きされない
     * assertSame(array_add(['a', 'b', 'c'], ['X']), ['a', 'b', 'c']);
     * // 異なるキーは生える
     * assertSame(array_add(['a', 'b', 'c'], ['x' => 'X']), ['a', 'b', 'c', 'x' => 'X']);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param array $variadic 足す配列
     * @return array 足された配列
     */
    function array_add($array, ...$variadic)
    {
        foreach ($variadic as $arg) {
            $array += $arg;
        }
        return $array;
    }
}
if (!isset($excluded_functions['array_implode']) && (!function_exists('array_implode') || (new \ReflectionFunction('array_implode'))->isInternal())) {
    /**
     * 配列の各要素の間に要素を差し込む
     *
     * 歴史的な理由はないが、引数をどちらの順番でも受けつけることが可能。
     * ただし、$glue を先に渡すパターンの場合は配列指定が可変引数渡しになる。
     *
     * 文字キーは保存されるが数値キーは再割り振りされる。
     *
     * Example:
     * <code>
     * // (配列, 要素) の呼び出し
     * assertSame(array_implode(['a', 'b', 'c'], 'X'), ['a', 'X', 'b', 'X', 'c']);
     * // (要素, ...配列) の呼び出し
     * assertSame(array_implode('X', 'a', 'b', 'c'), ['a', 'X', 'b', 'X', 'c']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable|string $array 対象配列
     * @param string $glue 差し込む要素
     * @return array 差し込まれた配列
     */
    function array_implode($array, $glue)
    {
        // 第1引数が回せない場合は引数を入れ替えて可変引数パターン
        if (!is_array($array) && !$array instanceof \Traversable) {
            return call_user_func(array_implode, array_slice(func_get_args(), 1), $array);
        }

        $result = [];
        foreach ($array as $k => $v) {
            if (is_int($k)) {
                $result[] = $v;
            }
            else {
                $result[$k] = $v;
            }
            $result[] = $glue;
        }
        array_pop($result);
        return $result;
    }
}
if (!isset($excluded_functions['array_sprintf']) && (!function_exists('array_sprintf') || (new \ReflectionFunction('array_sprintf'))->isInternal())) {
    /**
     * キーと値で sprintf する
     *
     * 配列の各要素を文字列化して返すイメージ。
     * $glue を与えるとさらに implode して返す（返り値が文字列になる）。
     *
     * $format は書式文字列（$v, $k）。
     * callable を与えると sprintf ではなくコールバック処理になる（$v, $k）。
     *
     * Example:
     * <code>
     * $array = ['key1' => 'val1', 'key2' => 'val2'];
     * // key, value を利用した sprintf
     * assertSame(array_sprintf($array, '%2$s=%1$s'), ['key1=val1', 'key2=val2']);
     * // 第3引数を与えるとさらに implode される
     * assertSame(array_sprintf($array, '%2$s=%1$s', ' '), 'key1=val1 key2=val2');
     * // クロージャを与えるとコールバック動作になる
     * $closure = function($v, $k){return "$k=" . strtoupper($v);};
     * assertSame(array_sprintf($array, $closure, ' '), 'key1=VAL1 key2=VAL2');
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param string|callable $format 書式文字列あるいはクロージャ
     * @param string $glue 結合文字列。未指定時は implode しない
     * @return array|string sprintf された配列
     */
    function array_sprintf($array, $format, $glue = NULL)
    {
        if (is_callable($format)) {
            $callback = call_user_func(func_user_func_array, $format);
        }
        else {
            $callback = function ($v, $k) use ($format) { return sprintf($format, $v, $k); };
        }

        $result = [];
        foreach ($array as $k => $v) {
            $result[] = $callback($v, $k);
        }

        if ($glue !== null) {
            return implode($glue, $result);
        }

        return $result;
    }
}
if (!isset($excluded_functions['array_strpad']) && (!function_exists('array_strpad') || (new \ReflectionFunction('array_strpad'))->isInternal())) {
    /**
     * 配列のキー・要素に文字列を付加する
     *
     * $key_prefix, $val_prefix でそれぞれ「キーに付与する文字列」「値に付与する文字列」が指定できる。
     * 配列を与えると [サフィックス, プレフィックス] という意味になる。
     * デフォルト（ただの文字列）はプレフィックス（値だけに付与したいなら array_map で十分なので）。
     *
     * Example:
     * <code>
     * $array = ['key1' => 'val1', 'key2' => 'val2'];
     * // キーにプレフィックス付与
     * assertSame(array_strpad($array, 'prefix-'), ['prefix-key1' => 'val1', 'prefix-key2' => 'val2']);
     * // 値にサフィックス付与
     * assertSame(array_strpad($array, '', ['-suffix']), ['key1' => 'val1-suffix', 'key2' => 'val2-suffix']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param string|array $key_prefix キー側の付加文字列
     * @param string|array $val_prefix 値側の付加文字列
     * @return array 文字列付与された配列
     */
    function array_strpad($array, $key_prefix, $val_prefix = '')
    {
        $key_suffix = '';
        if (is_array($key_prefix)) {
            list($key_suffix, $key_prefix) = $key_prefix + [1 => ''];
        }
        $val_suffix = '';
        if (is_array($val_prefix)) {
            list($val_suffix, $val_prefix) = $val_prefix + [1 => ''];
        }

        $result = [];
        foreach ($array as $key => $val) {
            $key = $key_prefix . $key . $key_suffix;
            $val = $val_prefix . $val . $val_suffix;
            $result[$key] = $val;
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_pos']) && (!function_exists('array_pos') || (new \ReflectionFunction('array_pos'))->isInternal())) {
    /**
     * 配列・連想配列を問わず「N番目(0ベース)」の要素を返す
     *
     * 負数を与えると逆から N 番目となる。
     *
     * Example:
     * <code>
     * assertSame(array_pos([1, 2, 3], 1), 2);
     * assertSame(array_pos([1, 2, 3], -1), 3);
     * assertSame(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1), 'B');
     * assertSame(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1, true), 'b');
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param int $position 取得する位置
     * @param bool $return_key true にすると値ではなくキーを返す
     * @return mixed 指定位置の値
     */
    function array_pos($array, $position, $return_key = false)
    {
        $position = (int) $position;
        $keys = array_keys($array);

        if ($position < 0) {
            $position = abs($position + 1);
            $keys = array_reverse($keys);
        }

        $count = count($keys);
        for ($i = 0; $i < $count; $i++) {
            if ($i === $position) {
                $key = $keys[$i];
                if ($return_key) {
                    return $key;
                }
                return $array[$key];
            }
        }

        throw new \OutOfBoundsException("$position is not found.");
    }
}
if (!isset($excluded_functions['array_of']) && (!function_exists('array_of') || (new \ReflectionFunction('array_of'))->isInternal())) {
    /**
     * 配列を与えると指定キーの値を返すクロージャを返す
     *
     * 存在しない場合は $default を返す。
     *
     * $key に配列を与えるとそれらの値の配列を返す（lookup 的な動作）。
     * その場合、$default が活きるのは「全て無かった場合」となる。
     * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
     *
     * Example:
     * <code>
     * $fuga_of_array = array_of('fuga');
     * assertSame($fuga_of_array(['hoge' => 'HOGE', 'fuga' => 'FUGA']), 'FUGA');
     * </code>
     *
     * @package Array
     *
     * @param string|int|array $key 取得したいキー
     * @param mixed $default デフォルト値
     * @return \Closure $key の値を返すクロージャ
     */
    function array_of($key, $default = NULL)
    {
        $nodefault = func_num_args() === 1;
        return function (array $array) use ($key, $default, $nodefault) {
            if ($nodefault) {
                return call_user_func(array_get, $array, $key);
            }
            else {
                return call_user_func(array_get, $array, $key, $default);
            }
        };
    }
}
if (!isset($excluded_functions['array_get']) && (!function_exists('array_get') || (new \ReflectionFunction('array_get'))->isInternal())) {
    /**
     * デフォルト値付きの配列値取得
     *
     * 存在しない場合は $default を返す。
     *
     * $key に配列を与えるとそれらの値の配列を返す（lookup 的な動作）。
     * その場合、$default が活きるのは「全て無かった場合」となる。
     * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
     *
     * Example:
     * <code>
     * // 単純取得
     * assertSame(array_get(['a', 'b', 'c'], 1), 'b');
     * // 単純デフォルト
     * assertSame(array_get(['a', 'b', 'c'], 9, 999), 999);
     * // 配列取得
     * assertSame(array_get(['a', 'b', 'c'], [0, 2]), [0 => 'a', 2 => 'c']);
     * // 配列部分取得
     * assertSame(array_get(['a', 'b', 'c'], [0, 9]), [0 => 'a']);
     * // 配列デフォルト（null ではなく [] を返す）
     * assertSame(array_get(['a', 'b', 'c'], [9]), []);
     * </code>
     *
     * @package Array
     *
     * @param array $array 配列
     * @param string|int|array $key 取得したいキー
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 指定したキーの値
     */
    function array_get($array, $key, $default = NULL)
    {
        if (is_array($key)) {
            $result = [];
            foreach ($key as $k) {
                // 深遠な事情で少しでも高速化したかったので isset || array_key_exists にしてある
                if (isset($array[$k]) || array_key_exists($k, $array)) {
                    $result[$k] = $array[$k];
                }
            }
            if (!$result) {
                // 明示的に与えられていないなら [] を使用する
                if (func_num_args() === 2) {
                    $default = [];
                }
                return $default;
            }
            return $result;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        return $default;
    }
}
if (!isset($excluded_functions['array_set']) && (!function_exists('array_set') || (new \ReflectionFunction('array_set'))->isInternal())) {
    /**
     * キー指定の配列値設定
     *
     * 第3引数を省略すると（null を与えると）言語機構を使用して配列の最後に設定する（$array[] = $value）。
     * 第3引数に配列を指定すると潜って設定する。
     *
     * Example:
     * <code>
     * $array = ['a' => 'A', 'B'];
     * // 第3引数省略（最後に連番キーで設定）
     * assertSame(array_set($array, 'Z'), 1);
     * assertSame($array, ['a' => 'A', 'B', 'Z']);
     * // 第3引数でキーを指定
     * assertSame(array_set($array, 'Z', 'z'), 'z');
     * assertSame($array, ['a' => 'A', 'B', 'Z', 'z' => 'Z']);
     * assertSame(array_set($array, 'Z', 'z'), 'z');
     * // 第3引数で配列を指定
     * assertSame(array_set($array, 'Z', ['x', 'y', 'z']), 'z');
     * assertSame($array, ['a' => 'A', 'B', 'Z', 'z' => 'Z', 'x' => ['y' => ['z' => 'Z']]]);
     * </code>
     *
     * @package Array
     *
     * @param array $array 配列
     * @param mixed $value 設定する値
     * @param array|string|int|null $key 設定するキー
     * @param bool $require_return 返り値が不要なら false を渡す
     * @return string|int 設定したキー
     */
    function array_set(&$array, $value, $key = NULL, $require_return = true)
    {
        if (is_array($key)) {
            $k = array_shift($key);
            if ($key) {
                if (is_array($array) && array_key_exists($k, $array) && !is_array($array[$k])) {
                    throw new \InvalidArgumentException('$array[$k] is not array.');
                }
                return call_user_func_array(array_set, [&$array[$k], $value, $key, $require_return]);
            }
            else {
                return call_user_func_array(array_set, [&$array, $value, $k, $require_return]);
            }
        }

        if ($key === null) {
            $array[] = $value;
            if ($require_return === true) {
                $key = call_user_func(last_key, $array);
            }
        }
        else {
            $array[$key] = $value;
        }
        return $key;
    }
}
if (!isset($excluded_functions['array_unset']) && (!function_exists('array_unset') || (new \ReflectionFunction('array_unset'))->isInternal())) {
    /**
     * 伏せると同時にその値を返す
     *
     * $key に配列を与えると全て伏せて配列で返す。
     * その場合、$default が活きるのは「全て無かった場合」となる。
     *
     * 配列を与えた場合の返り値は与えた配列の順番・キーが活きる。
     * これを利用すると list の展開の利便性が上がったり、連想配列で返すことができる。
     *
     * Example:
     * <code>
     * $array = ['a' => 'A', 'b' => 'B'];
     * // ない場合は $default を返す
     * assertSame(array_unset($array, 'x', 'X'), 'X');
     * // 指定したキーを返す。そのキーは伏せられている
     * assertSame(array_unset($array, 'a'), 'A');
     * assertSame($array, ['b' => 'B']);
     *
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 配列を与えるとそれらを返す。そのキーは全て伏せられている
     * assertSame(array_unset($array, ['a', 'b', 'x']), ['A', 'B']);
     * assertSame($array, ['c' => 'C']);
     *
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 配列のキーは返されるキーを表す。順番も維持される
     * assertSame(array_unset($array, ['x2' => 'b', 'x1' => 'a']), ['x2' => 'B', 'x1' => 'A']);
     * </code>
     *
     * @package Array
     *
     * @param array $array 配列
     * @param string|int|array $key 伏せたいキー。配列を与えると全て伏せる
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 指定したキーの値
     */
    function array_unset(&$array, $key, $default = NULL)
    {
        if (is_array($key)) {
            $result = [];
            foreach ($key as $rk => $ak) {
                if (array_key_exists($ak, $array)) {
                    $result[$rk] = $array[$ak];
                    unset($array[$ak]);
                }
            }
            if (!$result) {
                return $default;
            }
            return $result;
        }

        if (array_key_exists($key, $array)) {
            $result = $array[$key];
            unset($array[$key]);
            return $result;
        }
        return $default;
    }
}
if (!isset($excluded_functions['array_dive']) && (!function_exists('array_dive') || (new \ReflectionFunction('array_dive'))->isInternal())) {
    /**
     * パス形式で配列値を取得
     *
     * 存在しない場合は $default を返す。
     *
     * Example:
     * <code>
     * $array = [
     *     'a' => [
     *         'b' => [
     *             'c' => 'vvv'
     *         ]
     *     ]
     * ];
     * assertSame(array_dive($array, 'a.b.c'), 'vvv');
     * assertSame(array_dive($array, 'a.b.x', 9), 9);
     * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
     * assertSame(array_dive($array, ['a', 'b', 'c']), 'vvv');
     * </code>
     *
     * @package Array
     *
     * @param array $array 調べる配列
     * @param string|array $path パス文字列。配列も与えられる
     * @param mixed $default 無かった場合のデフォルト値
     * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
     * @return mixed パスが示す配列の値
     */
    function array_dive($array, $path, $default = NULL, $delimiter = '.')
    {
        $keys = is_array($path) ? $path : explode($delimiter, $path);
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                return $default;
            }
            $array = $array[$key];
        }
        return $array;
    }
}
if (!isset($excluded_functions['array_exists']) && (!function_exists('array_exists') || (new \ReflectionFunction('array_exists'))->isInternal())) {
    /**
     * array_search のクロージャ版のようなもの
     *
     * コールバックが true 相当を返す最初のキーを返す。
     * この関数は論理値 FALSE を返す可能性がありますが、FALSE として評価される値を返す可能性もあります。
     *
     * Example:
     * <code>
     * assertSame(array_exists(['a', 'b', '9'], 'ctype_digit'), 2);
     * assertSame(array_exists(['a', 'b', '9'], function($v){return $v === 'b';}), 1);
     * </code>
     *
     * @package Array
     * @deprecated array_exists という名前で真偽値を返さないのは直感に反する。 キーが欲しい用途には array_find を使う
     *
     * @param array|\Traversable $array 調べる配列
     * @param callable $callback 評価コールバック
     * @return mixed コールバックが true を返した最初のキー。存在しなかったら false
     */
    function array_exists($array, $callback)
    {
        foreach ($array as $k => $v) {
            if ($callback($v)) {
                return $k;
            }
        }
        return false;
    }
}
if (!isset($excluded_functions['array_find']) && (!function_exists('array_find') || (new \ReflectionFunction('array_find'))->isInternal())) {
    /**
     * array_search のクロージャ版のようなもの
     *
     * コールバックの返り値が true 相当のものを返す。
     * $is_key に true を与えるとそのキーを返す（デフォルトの動作）。
     * $is_key に false を与えるとコールバックの結果を返す。
     *
     * この関数は論理値 FALSE を返す可能性がありますが、FALSE として評価される値を返す可能性もあります。
     *
     * Example:
     * <code>
     * // 最初に見つかったキーを返す
     * assertSame(array_find(['a', 'b', '9'], 'ctype_digit'), 2);
     * assertSame(array_find(['a', 'b', '9'], function($v){return $v === 'b';}), 1);
     * // 最初に見つかったコールバック結果を返す（最初の数字の2乗を返す）
     * $ifnumeric2power = function($v){return ctype_digit($v) ? $v * $v : false;};
     * assertSame(array_find(['a', 'b', '9'], $ifnumeric2power, false), 81);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 調べる配列
     * @param callable $callback 評価コールバック
     * @param bool $is_key キーを返すか否か
     * @return mixed コールバックが true を返した最初のキー。存在しなかったら false
     */
    function array_find($array, $callback, $is_key = true)
    {
        $callback = call_user_func(func_user_func_array, $callback);

        foreach ($array as $k => $v) {
            $result = $callback($v, $k);
            if ($result) {
                if ($is_key) {
                    return $k;
                }
                return $result;
            }
        }
        return false;
    }
}
if (!isset($excluded_functions['array_grep_key']) && (!function_exists('array_grep_key') || (new \ReflectionFunction('array_grep_key'))->isInternal())) {
    /**
     * キーを正規表現でフィルタする
     *
     * Example:
     * <code>
     * assertSame(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#'), ['a' => 'A', 'aa' => 'AA']);
     * assertSame(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#', true), ['b' => 'B']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param string $regex 正規表現
     * @param bool $not true にすると「マッチしない」でフィルタする
     * @return array 正規表現でフィルタされた配列
     */
    function array_grep_key($array, $regex, $not = false)
    {
        $result = [];
        foreach ($array as $k => $v) {
            $match = preg_match($regex, $k);
            if ((!$not && $match) || ($not && !$match)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_map_key']) && (!function_exists('array_map_key') || (new \ReflectionFunction('array_map_key'))->isInternal())) {
    /**
     * キーをマップして変換する
     *
     * $callback が null を返すとその要素は取り除かれる。
     *
     * Example:
     * <code>
     * assertSame(array_map_key(['a' => 'A', 'b' => 'B'], 'strtoupper'), ['A' => 'A', 'B' => 'B']);
     * assertSame(array_map_key(['a' => 'A', 'b' => 'B'], function(){}), []);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array キーが変換された新しい配列
     */
    function array_map_key($array, $callback)
    {
        $result = [];
        foreach ($array as $k => $v) {
            $k2 = $callback($k);
            if ($k2 !== null) {
                $result[$k2] = $v;
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_filter_not']) && (!function_exists('array_filter_not') || (new \ReflectionFunction('array_filter_not'))->isInternal())) {
    /**
     * array_filter の否定版
     *
     * 単に否定するだけなのにクロージャを書きたくないことはまれによくあるはず。
     *
     * Example:
     * <code>
     * assertSame(array_filter_not(['a', '', 'c'], 'strlen'), [1 => '']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価 callable
     * @return array $callback が false を返した新しい配列
     */
    function array_filter_not($array, $callback)
    {
        return array_filter($array, call_user_func(not_func, $callback));
    }
}
if (!isset($excluded_functions['array_filter_key']) && (!function_exists('array_filter_key') || (new \ReflectionFunction('array_filter_key'))->isInternal())) {
    /**
     * キーを主軸とした array_filter
     *
     * $callback が要求するなら値も渡ってくる。 php 5.6 の array_filter の ARRAY_FILTER_USE_BOTH と思えばよい。
     * ただし、完全な互換ではなく、引数順は ($k, $v) なので注意。
     *
     * Example:
     * <code>
     * assertSame(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $k !== 1; }), [0 => 'a', 2 => 'c']);
     * assertSame(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $v !== 'b'; }), [0 => 'a', 2 => 'c']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array $callback が true を返した新しい配列
     */
    function array_filter_key($array, $callback)
    {
        $result = [];
        foreach ($array as $k => $v) {
            if ($callback($k, $v)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_filter_eval']) && (!function_exists('array_filter_eval') || (new \ReflectionFunction('array_filter_eval'))->isInternal())) {
    /**
     * eval で評価して array_filter する
     *
     * キーは $k, 値は $v で宣言される。
     *
     * Example:
     * <code>
     * assertSame(array_filter_eval(['a', 'b', 'c'], '$k !== 1'), [0 => 'a', 2 => 'c']);
     * assertSame(array_filter_eval(['a', 'b', 'c'], '$v !== "b"'), [0 => 'a', 2 => 'c']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param string $expression eval コード
     * @return array $expression が true を返した新しい配列
     */
    function array_filter_eval($array, $expression)
    {
        return call_user_func(array_filter_key, $array, call_user_func(eval_func, $expression, 'k', 'v'));
    }
}
if (!isset($excluded_functions['array_where']) && (!function_exists('array_where') || (new \ReflectionFunction('array_where'))->isInternal())) {
    /**
     * 指定キーの要素で array_filter する
     *
     * array_column があるなら array_where があってもいいはず。
     *
     * $column はコールバックに渡ってくる配列のキー名を渡す。null を与えると行全体が渡ってくる。
     * $callback は絞り込み条件を渡す。null を与えると true 相当の値でフィルタする。
     * つまり $column も $callback も省略した場合、実質的に array_filter と同じ動作になる。
     *
     * $column は配列を受け入れる。配列を渡した場合その共通項がコールバックに渡る。
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * <code>
     * $array = [
     *     0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ];
     * // 'flag' が true 相当のものだけ返す
     * assertSame(array_where($array, 'flag'), [1 => ['id' => 2, 'name' => 'fuga', 'flag' => true]]);
     * // 'name' に 'h' を含むものだけ返す
     * $contain_h = function($name){return strpos($name, 'h') !== false;};
     * assertSame(array_where($array, 'name', $contain_h), [0 => ['id' => 1, 'name' => 'hoge', 'flag' => false]]);
     * // $callback が引数2つならキーも渡ってくる（キーが 2 のものだけ返す）
     * $equal_2 = function($row, $key){return $key === 2;};
     * assertSame(array_where($array, null, $equal_2), [2 => ['id' => 3, 'name' => 'piyo', 'flag' => false]]);
     * // $column に配列を渡すと共通項が渡ってくる
     * $idname_is_2fuga = function($idname){return ($idname['id'] . $idname['name']) === '2fuga';};
     * assertSame(array_where($array, ['id', 'name'], $idname_is_2fuga), [1 => ['id' => 2, 'name' => 'fuga', 'flag' => true]]);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param string|array|null $column キー名
     * @param callable $callback 評価クロージャ
     * @return array $where が真を返した新しい配列
     */
    function array_where($array, $column = NULL, $callback = NULL)
    {
        $is_array = is_array($column);
        if ($is_array) {
            $column = array_flip($column);
        }

        $callback = call_user_func(func_user_func_array, $callback);

        $result = [];
        foreach ($array as $k => $v) {
            if ($column === null) {
                $vv = $v;
            }
            elseif ($is_array) {
                $vv = array_intersect_key($v, $column);
            }
            else {
                $vv = $v[$column];
            }

            if ($callback($vv, $k)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_map_filter']) && (!function_exists('array_map_filter') || (new \ReflectionFunction('array_map_filter'))->isInternal())) {
    /**
     * array_map + array_filter する
     *
     * コールバックを適用して、結果が true 相当の要素のみ取り出す。
     * $strict に true を与えると「null でない」要素のみ返される。
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * <code>
     * assertSame(array_map_filter([' a ', ' b ', ''], 'trim'), ['a', 'b']);
     * assertSame(array_map_filter([' a ', ' b ', ''], 'trim', true), ['a', 'b', '']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param bool $strict 厳密比較フラグ。 true だと null のみが偽とみなされる
     * @return array $callback が真を返した新しい配列
     */
    function array_map_filter($array, $callback, $strict = false)
    {
        $callback = call_user_func(func_user_func_array, $callback);
        $result = [];
        foreach ($array as $k => $v) {
            $vv = $callback($v, $k);
            if (($strict && $vv !== null) || (!$strict && $vv)) {
                $result[$k] = $vv;
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_map_method']) && (!function_exists('array_map_method') || (new \ReflectionFunction('array_map_method'))->isInternal())) {
    /**
     * メソッドを指定できるようにした array_map
     *
     * 配列内の要素は全て同一（少なくともシグネチャが同じ $method が存在する）オブジェクトでなければならない。
     * スルーする場合は $ignore=true とする。スルーした場合 map ではなく filter される（結果配列に含まれない）。
     * $ignore=null とすると 何もせずそのまま要素を返す。
     *
     * Example:
     * <code>
     * $exa = new \Exception('a'); $exb = new \Exception('b'); $std = new \stdClass();
     * // getMessage で map される
     * assertSame(array_map_method([$exa, $exb], 'getMessage'), ['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合は取り除かれる
     * assertSame(array_map_method([$exa, $exb, $std, null], 'getMessage', [], true), ['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合はそのまま返す
     * assertSame(array_map_method([$exa, $exb, $std, null], 'getMessage', [], null), ['a', 'b', $std, null]);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param string $method メソッド
     * @param array $args メソッドに渡る引数
     * @param bool|null $ignore メソッドが存在しない場合にスルーするか。null を渡すと要素そのものを返す
     * @return array $method が true を返した新しい配列
     */
    function array_map_method($array, $method, $args = [], $ignore = false)
    {
        if ($ignore === true) {
            $array = array_filter($array, function ($object) use ($method) {
                return is_callable([$object, $method]);
            });
        }
        return array_map(function ($object) use ($method, $args, $ignore) {
            if ($ignore === null && !is_callable([$object, $method])) {
                return $object;
            }
            return call_user_func_array([$object, $method], $args);
        }, $array);
    }
}
if (!isset($excluded_functions['array_maps']) && (!function_exists('array_maps') || (new \ReflectionFunction('array_maps'))->isInternal())) {
    /**
     * 複数コールバックを指定できる array_map
     *
     * 指定したコールバックで複数回回してマップする。
     * `array_maps($array, $f, $g)` は `array_map($g, array_map($f, $array))` とほぼ等しい。
     * ただし、引数は順番が違う（可変引数のため）し、コールバックが要求するならキーも渡ってくる。
     *
     * 少し変わった仕様として、コールバックに [$method => $args] を付けるとそれはメソッド呼び出しになる。
     * つまり各要素 $v に対して `$v->$method(...$args)` がマップ結果になる。
     * さらに引数が不要なら `@method` とするだけで良い。
     *
     * Example:
     * <code>
     * // 値を3乗したあと16進表記にして大文字化する
     * assertSame(array_maps([1, 2, 3, 4, 5], rbind('pow', 3), 'dechex', 'strtoupper'), ['1', '8', '1B', '40', '7D']);
     * // キーも渡ってくる
     * assertSame(array_maps(['a' => 'A', 'b' => 'B'], function($v, $k){return "$k:$v";}), ['a' => 'a:A', 'b' => 'b:B']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable[] $callbacks 評価クロージャ配列
     * @return array 評価クロージャを通した新しい配列
     */
    function array_maps($array, ...$callbacks)
    {
        $result = $array;
        foreach ($callbacks as $callback) {
            if (is_string($callback) && $callback[0] === '@') {
                $margs = [];
                $callback = substr($callback, 1);
            }
            elseif (is_array($callback) && count($callback) === 1) {
                $margs = reset($callback);
                $callback = key($callback);
            }
            else {
                $callback = call_user_func(func_user_func_array, $callback);
            }
            foreach ($result as $k => $v) {
                if (isset($margs)) {
                    $result[$k] = call_user_func_array([$v, $callback], $margs);
                }
                else {
                    $result[$k] = $callback($v, $k);
                }
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_nmap']) && (!function_exists('array_nmap') || (new \ReflectionFunction('array_nmap'))->isInternal())) {
    /**
     * 要素値を $callback の n 番目(0ベース)に適用して array_map する
     *
     * 引数 $n に配列を与えると [キー番目 => 値番目] とみなしてキー・値も渡される（Example 参照）。
     * その際、「挿入後の番目」ではなく、単純に「元の引数の番目」であることに留意。キー・値が同じ位置を指定している場合はキーが先にくる。
     *
     * Example:
     * <code>
     * // 1番目に値を渡して map
     * $sprintf = function(){return vsprintf('%s%s%s', func_get_args());};
     * assertSame(array_nmap(['a', 'b'], $sprintf, 1, 'prefix-', '-suffix'), ['prefix-a-suffix', 'prefix-b-suffix']);
     * // 1番目にキー、2番目に値を渡して map
     * $sprintf = function(){return vsprintf('%s %s %s %s %s', func_get_args());};
     * assertSame(array_nmap(['k' => 'v'], $sprintf, [1 => 2], 'a', 'b', 'c'), ['k' => 'a k b v c']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param int|array $n 要素値を入れる引数番目。配列を渡すとキー・値の両方を指定でき、両方が渡ってくる
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_nmap($array, $callback, $n, ...$variadic)
    {
        /** @var $kn */
        /** @var $vn */

        $is_array = is_array($n);
        $args = $variadic;

        // 配列が来たら [キー番目 => 値番目] とみなす
        if ($is_array) {
            if (empty($n)) {
                throw new \InvalidArgumentException('array $n is empty.');
            }
            list($kn, $vn) = call_user_func(first_keyvalue, $n);

            // array_insert は負数も受け入れられるが、それを考慮しだすともう収拾がつかない
            if ($kn < 0 || $vn < 0) {
                throw new \InvalidArgumentException('$kn, $vn must be positive.');
            }

            // どちらが大きいかで順番がズレるので分岐しなければならない
            if ($kn <= $vn) {
                $args = call_user_func(array_insert, $args, null, $kn);
                $args = call_user_func(array_insert, $args, null, ++$vn);// ↑で挿入してるので+1
            }
            else {
                $args = call_user_func(array_insert, $args, null, $vn);
                $args = call_user_func(array_insert, $args, null, ++$kn);// ↑で挿入してるので+1
            }
        }
        else {
            $args = call_user_func(array_insert, $args, null, $n);
        }

        $result = [];
        foreach ($array as $k => $v) {
            // キー値モードなら両方埋める
            if ($is_array) {
                $args[$kn] = $k;
                $args[$vn] = $v;
            }
            // 値のみなら値だけ
            else {
                $args[$n] = $v;
            }
            $result[$k] = call_user_func_array($callback, $args);
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_lmap']) && (!function_exists('array_lmap') || (new \ReflectionFunction('array_lmap'))->isInternal())) {
    /**
     * 要素値を $callback の最左に適用して array_map する
     *
     * Example:
     * <code>
     * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
     * assertSame(array_lmap(['a', 'b'], $sprintf, '-suffix'), ['a-suffix', 'b-suffix']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_lmap($array, $callback, ...$variadic)
    {
        return call_user_func_array(array_nmap, call_user_func(array_insert, func_get_args(), 0, 2));
    }
}
if (!isset($excluded_functions['array_rmap']) && (!function_exists('array_rmap') || (new \ReflectionFunction('array_rmap'))->isInternal())) {
    /**
     * 要素値を $callback の最右に適用して array_map する
     *
     * Example:
     * <code>
     * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
     * assertSame(array_rmap(['a', 'b'], $sprintf, 'prefix-'), ['prefix-a', 'prefix-b']);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_rmap($array, $callback, ...$variadic)
    {
        return call_user_func_array(array_nmap, call_user_func(array_insert, func_get_args(), func_num_args() - 2, 2));
    }
}
if (!isset($excluded_functions['array_depth']) && (!function_exists('array_depth') || (new \ReflectionFunction('array_depth'))->isInternal())) {
    /**
     * 配列の次元数を返す
     *
     * フラット配列は 1 と定義する。
     * つまり、配列を与える限りは 0 以下を返すことはない。
     *
     * Example:
     * <code>
     * assertSame(array_depth([]), 1);
     * assertSame(array_depth(['hoge']), 1);
     * assertSame(array_depth([['nest1' => ['nest2']]]), 3);
     * </code>
     *
     * @package Array
     *
     * @param array $array 調べる配列
     * @return int 次元数。素のフラット配列は 1
     */
    function array_depth($array)
    {
        // 配列以外に興味はない
        $arrays = array_filter($array, 'is_array');

        // ネストしない配列は 1 と定義
        if (!$arrays) {
            return 1;
        }

        // 配下の内で最大を返す
        return 1 + max(array_map(__METHOD__, $arrays));
    }
}
if (!isset($excluded_functions['array_insert']) && (!function_exists('array_insert') || (new \ReflectionFunction('array_insert'))->isInternal())) {
    /**
     * 配列・連想配列を問わず任意の位置に値を挿入する
     *
     * $position を省略すると最後に挿入される（≒ array_push）。
     * $position に負数を与えると後ろから数えられる。
     * $value には配列も与えられるが、その場合数値キーは振り直される
     *
     * Example:
     * <code>
     * assertSame(array_insert([1, 2, 3], 'x'), [1, 2, 3, 'x']);
     * assertSame(array_insert([1, 2, 3], 'x', 1), [1, 'x', 2, 3]);
     * assertSame(array_insert([1, 2, 3], 'x', -1), [1, 2, 'x', 3]);
     * assertSame(array_insert([1, 2, 3], ['a' => 'A', 'b' => 'B'], 1), [1, 'a' => 'A', 'b' => 'B', 2, 3]);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param mixed $value 挿入値
     * @param int|null $position 挿入位置
     * @return array 挿入された新しい配列
     */
    function array_insert($array, $value, $position = NULL)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $position = is_null($position) ? count($array) : intval($position);

        $sarray = array_splice($array, 0, $position);
        return array_merge($sarray, $value, $array);
    }
}
if (!isset($excluded_functions['array_assort']) && (!function_exists('array_assort') || (new \ReflectionFunction('array_assort'))->isInternal())) {
    /**
     * 配列をコールバックに従って分類する
     *
     * コールバックは配列で複数与える。そのキーが結果配列のキーになるが、一切マッチしなくてもキー自体は作られる。
     * 複数のコールバックにマッチしたらその分代入されるし、どれにもマッチしなければ代入されない。
     * つまり5個の配列を分類したからと言って、全要素数が5個になるとは限らない（多い場合も少ない場合もある）。
     *
     * $rule が要求するならキーも渡ってくる。
     *
     * Example:
     * <code>
     * // lt2(2より小さい)で分類
     * $lt2 = function($v){return $v < 2;};
     * assertSame(array_assort([1, 2, 3], ['lt2' => $lt2]), ['lt2' => [1]]);
     * // lt3(3より小さい)、ctd(ctype_digit)で分類（両方に属する要素が存在する）
     * $lt3 = function($v){return $v < 3;};
     * assertSame(array_assort(['1', '2', '3'], ['lt3' => $lt3, 'ctd' => 'ctype_digit']), ['lt3' => ['1', '2'], 'ctd' => ['1', '2', '3']]);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable[] $rules 分類ルール。[key => callable] 形式
     * @return array 分類された新しい配列
     */
    function array_assort($array, $rules)
    {
        $result = array_fill_keys(array_keys($rules), []);
        foreach ($rules as $name => $rule) {
            $rule = call_user_func(func_user_func_array, $rule);
            foreach ($array as $k => $v) {
                if ($rule($v, $k)) {
                    $result[$name][$k] = $v;
                }
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_count']) && (!function_exists('array_count') || (new \ReflectionFunction('array_count'))->isInternal())) {
    /**
     * 配列をコールバックに従ってカウントする
     *
     * コールバックが true 相当を返した要素をカウントして返す。
     * 普通に使う分には `count(array_filter($array, $callback))` とほとんど同じだが、下記の点が微妙に異なる。
     * - $callback が要求するならキーも渡ってくる
     * - $callback には配列が渡せる。配列を渡した場合は件数を配列で返す（Example 参照）
     *
     * Example:
     * <code>
     * $array = ['hoge', 'fuga', 'piyo'];
     * // 'o' を含むものの数（2個）
     * assertSame(array_count($array, function($s){return strpos($s, 'o') !== false;}), 2);
     * // 'a' と 'o' を含むものをそれぞれ（1個と2個）
     * assertSame(array_count($array, [
     *     'a' => function($s){return strpos($s, 'a') !== false;},
     *     'o' => function($s){return strpos($s, 'o') !== false;},
     * ]), ['a' => 1, 'o' => 2]);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback カウントルール。配列も渡せる
     * @return int|array 条件一致した件数
     */
    function array_count($array, $callback)
    {
        // 配列が来た場合はまるで動作が異なる（再帰でもいいがそれだと旨味がない。複数欲しいなら呼び出し元で複数回呼べば良い。ワンループに閉じ込めるからこそメリットがある））
        if (is_array($callback) && !is_callable($callback)) {
            $result = array_fill_keys(array_keys($callback), 0);
            foreach ($callback as $name => $rule) {
                $rule = call_user_func(func_user_func_array, $rule);
                foreach ($array as $k => $v) {
                    if ($rule($v, $k)) {
                        $result[$name]++;
                    }
                }
            }
            return $result;
        }

        $callback = call_user_func(func_user_func_array, $callback);
        $result = 0;
        foreach ($array as $k => $v) {
            if ($callback($v, $k)) {
                $result++;
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_group']) && (!function_exists('array_group') || (new \ReflectionFunction('array_group'))->isInternal())) {
    /**
     * 配列をコールバックの返り値でグループ化する
     *
     * コールバックが配列を返すと入れ子としてグループする。
     *
     * Example:
     * <code>
     * assertSame(array_group([1, 1, 1]), [1 => [1, 1, 1]]);
     * assertSame(array_group([1, 2, 3], function($v){return $v % 2;}), [1 => [1, 3], 0 => [2]]);
     * // group -> id で入れ子グループにする
     * $row1 = ['id' => 1, 'group' => 'hoge'];
     * $row2 = ['id' => 2, 'group' => 'fuga'];
     * $row3 = ['id' => 3, 'group' => 'hoge'];
     * assertSame(array_group([$row1, $row2, $row3], function($row){return [$row['group'], $row['id']];}), [
     *     'hoge' => [
     *         1 => $row1,
     *         3 => $row3,
     *     ],
     *     'fuga' => [
     *         2 => $row2,
     *     ],
     * ]);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
     * @return array グルーピングされた配列
     */
    function array_group($array, $callback = NULL, $preserve_keys = false)
    {
        $callback = call_user_func(func_user_func_array, $callback);

        $result = [];
        foreach ($array as $k => $v) {
            $vv = $callback($v, $k);
            // 配列は潜る
            if (is_array($vv)) {
                $tmp = &$result;
                foreach ($vv as $vvv) {
                    $tmp = &$tmp[$vvv];
                }
                $tmp = $v;
                unset($tmp);
            }
            elseif (!$preserve_keys && is_int($k)) {
                $result[$vv][] = $v;
            }
            else {
                $result[$vv][$k] = $v;
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_all']) && (!function_exists('array_all') || (new \ReflectionFunction('array_all'))->isInternal())) {
    /**
     * 全要素が true になるなら true を返す（1つでも false なら false を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * <code>
     * assertTrue(array_all([true, true]));
     * assertFalse(array_all([true, false]));
     * assertFalse(array_all([false, false]));
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が true なら true
     */
    function array_all($array, $callback = NULL, $default = true)
    {
        if (empty($array)) {
            return $default;
        }

        $callback = call_user_func(func_user_func_array, $callback);

        foreach ($array as $k => $v) {
            if (!$callback($v, $k)) {
                return false;
            }
        }
        return true;
    }
}
if (!isset($excluded_functions['array_any']) && (!function_exists('array_any') || (new \ReflectionFunction('array_any'))->isInternal())) {
    /**
     * 全要素が false になるなら false を返す（1つでも true なら true を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * <code>
     * assertTrue(array_any([true, true]));
     * assertTrue(array_any([true, false]));
     * assertFalse(array_any([false, false]));
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が false なら false
     */
    function array_any($array, $callback = NULL, $default = false)
    {
        if (empty($array)) {
            return $default;
        }

        $callback = call_user_func(func_user_func_array, $callback);

        foreach ($array as $k => $v) {
            if ($callback($v, $k)) {
                return true;
            }
        }
        return false;
    }
}
if (!isset($excluded_functions['array_order']) && (!function_exists('array_order') || (new \ReflectionFunction('array_order'))->isInternal())) {
    /**
     * 配列を $orders に従って並べ替える
     *
     * データベースからフェッチしたような連想配列の配列を想定しているが、スカラー配列(['key' => 'value'])にも対応している。
     * その場合 $orders に配列ではなく直値を渡せば良い。
     *
     * $orders には下記のような配列を渡す。
     *
     * <code>
     * $orders = [
     *     'col1' => true,                               // true: 昇順, false: 降順。照合は型に依存
     *     'col2' => SORT_NATURAL,                       // SORT_NATURAL, SORT_REGULAR などで照合。正数で昇順、負数で降順
     *     'col3' => ['sort', 'this', 'order'],          // 指定した配列順で昇順
     *     'col4' => function($v) {return $v;},          // クロージャを通した値で昇順。照合は返り値の型(php7 は returnType)に依存
     *     'col5' => function($a, $b) {return $a - $b;}, // クロージャで比較して昇順（いわゆる比較関数を渡す）
     * ];
     * </code>
     *
     * Example:
     * <code>
     * $v1 = ['id' => '1', 'no' => 'a03', 'name' => 'yyy'];
     * $v2 = ['id' => '2', 'no' => 'a4',  'name' => 'yyy'];
     * $v3 = ['id' => '3', 'no' => 'a12', 'name' => 'xxx'];
     * // name 昇順, no 自然降順
     * assertSame(array_order([$v1, $v2, $v3], ['name' => true, 'no' => -SORT_NATURAL]), [$v3, $v2, $v1]);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param mixed $orders ソート順
     * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
     * @return array 並び替えられた配列
     */
    function array_order($array, $orders, $preserve_keys = false)
    {
        if (count($array) <= 1) {
            return $array;
        }

        if (!is_array($orders) || !call_user_func(is_hasharray, $orders)) {
            $orders = [$orders];
        }

        // 配列内の位置をマップして返すクロージャ
        $position = function ($columns, $order) {
            return array_map(function ($v) use ($order) {
                $ndx = array_search($v, $order, true);
                return $ndx === false ? count($order) : $ndx;
            }, $columns);
        };

        // 全要素は舐めてられないので最初の要素を代表選手としてピックアップ
        $first = reset($array);
        $is_scalar = is_scalar($first) || is_null($first);

        // array_multisort 用の配列を生成
        $args = [];
        foreach ($orders as $key => $order) {
            if ($is_scalar) {
                $firstval = reset($array);
                $columns = $array;
            }
            else {
                if ($key !== '' && !array_key_exists($key, $first)) {
                    throw new \InvalidArgumentException("$key is undefined.");
                }
                if ($key === '') {
                    $columns = array_keys($array);
                    $firstval = reset($columns);
                }
                else {
                    $firstval = $first[$key];
                    $columns = array_column($array, $key);
                }
            }

            // bool は ASC, DESC
            if (is_bool($order)) {
                $args[] = $columns;
                $args[] = $order ? SORT_ASC : SORT_DESC;
                $args[] = is_string($firstval) ? SORT_STRING : SORT_NUMERIC;
            }
            // int は SORT_*****
            elseif (is_int($order)) {
                $args[] = $columns;
                $args[] = $order > 0 ? SORT_ASC : SORT_DESC;
                $args[] = abs($order);
            }
            // 配列はその並び
            elseif (is_array($order)) {
                $args[] = $position($columns, $order);
                $args[] = SORT_ASC;
                $args[] = SORT_NUMERIC;
            }
            // クロージャは色々
            elseif ($order instanceof \Closure) {
                $ref = new \ReflectionFunction($order);
                // 引数2個なら比較関数
                if ($ref->getNumberOfRequiredParameters() === 2) {
                    $map = $columns;
                    usort($map, $order);
                    $args[] = $position($columns, $map);
                    $args[] = SORT_ASC;
                    $args[] = SORT_NUMERIC;
                }
                // でないなら通した値で比較
                else {
                    $arg = array_map($order, $columns);
                    if (method_exists($ref, 'hasReturnType') && $ref->hasReturnType()) {
                        // getReturnType があるならそれに基づく
                        $type = (string) $ref->getReturnType();
                    }
                    else {
                        // ないなら返り値の型から推測
                        $type = gettype(reset($arg));
                    }
                    $args[] = $arg;
                    $args[] = SORT_ASC;
                    $args[] = $type === 'string' ? SORT_STRING : SORT_NUMERIC;
                }
            }
            else {
                throw new \DomainException('$order is invalid.');
            }
        }

        // array_multisort はキーを保持しないので、ソートされる配列にキー配列を加えて後で combine する
        if ($preserve_keys) {
            $keys = array_keys($array);
            $args[] =& $array;
            $args[] =& $keys;
            call_user_func_array('array_multisort', $args);
            return array_combine($keys, $array);
        }
        // キーを保持しないなら単純呼び出しで OK
        else {
            $args[] =& $array;
            call_user_func_array('array_multisort', $args);
            return $array;
        }
    }
}
if (!isset($excluded_functions['array_shuffle']) && (!function_exists('array_shuffle') || (new \ReflectionFunction('array_shuffle'))->isInternal())) {
    /**
     * shuffle のキーが保存される＋参照渡しではない版
     *
     * Example:
     * <code>
     * srand(4);mt_srand(4);
     * assertSame(array_shuffle(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['b' => 'B', 'a' => 'A', 'c' => 'C']);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @return array shuffle された配列
     */
    function array_shuffle($array)
    {
        $keys = array_keys($array);
        shuffle($keys);

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $array[$key];
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_shrink_key']) && (!function_exists('array_shrink_key') || (new \ReflectionFunction('array_shrink_key'))->isInternal())) {
    /**
     * 値の優先順位を逆にした array_intersect_key
     *
     * array_intersect_key は「左優先で共通項を取る」という動作だが、この関数は「右優先で共通項を取る」という動作になる。
     * 「配列の並び順はそのままで値だけ変えたい/削ぎ落としたい」という状況はまれによくあるはず。
     *
     * Example:
     * <code>
     * $array1 = ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'];
     * $array2 = ['c' => 'C2', 'b' => 'B2', 'a' => 'A2'];
     * $array3 = ['c' => 'C3', 'dummy' => 'DUMMY'];
     * // 全共通項である 'c' キーのみが生き残り、その値は最後の 'C3' になる
     * assertSame(array_shrink_key($array1, $array2, $array3), ['c' => 'C3']);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param array $variadic 比較する配列
     * @return array 新しい配列
     */
    function array_shrink_key($array, ...$variadic)
    {
        $args = func_get_args();
        array_unshift($args, call_user_func_array('array_replace', $args));
        return call_user_func_array('array_intersect_key', $args);
    }
}
if (!isset($excluded_functions['array_lookup']) && (!function_exists('array_lookup') || (new \ReflectionFunction('array_lookup'))->isInternal())) {
    /**
     * キー保存可能な array_column
     *
     * array_column は キーを保存することが出来ないが、この関数は引数を2つだけ与えるとキーはそのままで array_column 相当の配列を返す。
     *
     * Example:
     * <code>
     * $array = [11 => ['id' => 1, 'name' => 'name1'], 12 => ['id' => 2, 'name' => 'name2'], 13 => ['id' => 3, 'name' => 'name3']];
     * // 第3引数を渡せば array_column と全く同じ
     * assertSame(array_lookup($array, 'name', 'id'), array_column($array, 'name', 'id'));
     * assertSame(array_lookup($array, 'name', null), array_column($array, 'name', null));
     * // 省略すればキーが保存される
     * assertSame(array_lookup($array, 'name'), [11 => 'name1', 12 => 'name2', 13 => 'name3']);
     * assertSame(array_lookup($array), $array);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param string|null $column_key 値となるキー
     * @param string|null $index_key キーとなるキー
     * @return array 新しい配列
     */
    function array_lookup($array, $column_key = NULL, $index_key = NULL)
    {
        if (func_num_args() === 3) {
            return array_column($array, $column_key, $index_key);
        }

        // null 対応できないし、php7 からオブジェクトに対応してるらしいので止め。ベタにやる
        // return array_map(array_of($column_keys), $array);

        // 実質的にはこれで良いはずだが、オブジェクト対応が救えないので止め。ベタにやる
        // return array_combine(array_keys($array), array_column($array, $column_key));

        $result = [];
        foreach ($array as $k => $v) {
            if ($column_key === null) {
                $result[$k] = $v;
            }
            elseif (is_array($v) && array_key_exists($column_key, $v)) {
                $result[$k] = $v[$column_key];
            }
            elseif (is_object($v) && (isset($v->$column_key) || property_exists($v, $column_key))) {
                $result[$k] = $v->$column_key;
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_columns']) && (!function_exists('array_columns') || (new \ReflectionFunction('array_columns'))->isInternal())) {
    /**
     * 全要素に対して array_column する
     *
     * 行列が逆転するイメージ。
     *
     * Example:
     * <code>
     * $row1 = ['id' => 1, 'name' => 'A'];
     * $row2 = ['id' => 2, 'name' => 'B'];
     * $rows = [$row1, $row2];
     * assertSame(array_columns($rows), ['id' => [1, 2], 'name' => ['A', 'B']]);
     * assertSame(array_columns($rows, 'id'), ['id' => [1, 2]]);
     * assertSame(array_columns($rows, 'name', 'id'), ['name' => [1 => 'A', 2 => 'B']]);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param string|array $column_keys 引っ張ってくるキー名
     * @param mixed $index_key 新しい配列のキーとなるキー名
     * @return array 新しい配列
     */
    function array_columns($array, $column_keys = NULL, $index_key = NULL)
    {
        if (count($array) === 0 && $column_keys === null) {
            throw new \InvalidArgumentException("can't auto detect keys.");
        }

        if ($column_keys === null) {
            $column_keys = array_keys(reset($array));
        }

        $result = [];
        foreach ((array) $column_keys as $key) {
            $result[$key] = array_column($array, $key, $index_key);
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_uncolumns']) && (!function_exists('array_uncolumns') || (new \ReflectionFunction('array_uncolumns'))->isInternal())) {
    /**
     * array_columns のほぼ逆で [キー => [要素]] 配列から連想配列の配列を生成する
     *
     * $template を指定すると「それに含まれる配列かつ値がデフォルト」になる（要するに $default みたいなもの）。
     * キーがバラバラな配列を指定する場合は指定したほうが良い。が、null を指定すると最初の要素が使われるので大抵の場合は null で良い。
     *
     * Example:
     * <code>
     * assertSame(array_uncolumns(['id' => [1, 2], 'name' => ['A', 'B']]), [
     *     ['id' => 1, 'name' => 'A'],
     *     ['id' => 2, 'name' => 'B'],
     * ]);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param array $template 抽出要素とそのデフォルト値
     * @return array 新しい配列
     */
    function array_uncolumns($array, $template = NULL)
    {
        // 指定されていないなら生のまま
        if (func_num_args() === 1) {
            $template = false;
        }
        // null なら最初の要素のキー・null
        if ($template === null) {
            $template = array_fill_keys(array_keys(call_user_func(first_value, $array)), null);
        }

        $result = [];
        foreach ($array as $key => $vals) {
            if ($template !== false) {
                $vals = array_intersect_key($vals + $template, $template);
            }
            foreach ($vals as $n => $val) {
                $result[$n][$key] = $val;
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['array_convert']) && (!function_exists('array_convert') || (new \ReflectionFunction('array_convert'))->isInternal())) {
    /**
     * 配列の各要素に再帰的にコールバックを適用して変換する
     *
     * $callback は下記の仕様。
     *
     * 引数は (キー, 値, 今まで処理したキー配列) で渡ってくる。
     * 返り値は新しいキーを返す。
     * - 文字列や数値を返すとそれがキーとして使われる
     * - null を返すと元のキーがそのまま使われる
     * - true を返すと数値連番が振られる
     * - false を返すとその要素は無かったことになる
     * - 配列を返すとその配列で完全に置換される
     *
     * $apply_array=false で要素が配列の場合は再帰され、コールバックが適用されない（array_walk_recursive と同じ仕様）。
     *
     * $apply_array=true だと配列かは問わず全ての要素にコールバックが適用される。
     * 配列も渡ってきてしまうのでコールバック内部で is_array 判定が必要になる場合がある。
     *
     * 「map も filter も可能でキー変更可能かつ再帰的」というとてもマッチョな関数。
     * 複雑だが実質的には「キーも設定できる array_walk_recursive」のように振る舞う（そしてそのような使い方を想定している）。
     *
     * Example:
     * <code>
     * $array = [
     *    'k1' => 'v1',
     *    'k2' => [
     *        'k21' => 'v21',
     *        'k22' => [
     *            'k221' => 'v221',
     *            'k222' => 'v222',
     *        ],
     *        'k23' => 'v23',
     *    ],
     * ];
     * // 全要素に 'prefix-' を付与する。キーには '_' をつける。ただし 'k21' はそのままとする。さらに 'k22' はまるごと伏せる。 'k23' は数値キーになる
     * $callback = function($k, &$v){
     *     if ($k === 'k21') return null;
     *     if ($k === 'k22') return false;
     *     if ($k === 'k23') return true;
     *     if (!is_array($v)) $v = "prefix-$v";
     *     return "_$k";
     * };
     * assertSame(array_convert($array, $callback, true), [
     *     '_k1' => 'prefix-v1',
     *     '_k2' => [
     *         'k21' => 'v21',
     *         0     => 'v23',
     *     ],
     * ]);
     * </code>
     *
     * @package Array
     *
     * @param array $array 対象配列
     * @param callable $callback 適用するコールバック
     * @param bool $apply_array 配列要素にもコールバックを適用するか
     * @return array 変換された配列
     */
    function array_convert($array, $callback, $apply_array = false)
    {
        $recursive = function (&$result, $array, $history, $callback) use (&$recursive, $apply_array) {
            $sequences = [];
            foreach ($array as $key => $value) {
                $is_array = is_array($value);
                $newkey = $key;
                // 配列で $apply_array あるいは非配列の場合にコールバック適用
                if (($is_array && $apply_array) || !$is_array) {
                    $newkey = $callback($key, $value, $history);
                }
                // 配列は置換
                if (is_array($newkey)) {
                    foreach ($newkey as $k => $v) {
                        $result[$k] = $v;
                    }
                    continue;
                }
                // false はスルー
                if ($newkey === false) {
                    continue;
                }
                // true は数値連番
                if ($newkey === true) {
                    if ($is_array) {
                        $sequences["_$key"] = $value;
                    }
                    else {
                        $sequences[] = $value;
                    }
                    continue;
                }
                // null は元のキー
                if ($newkey === null) {
                    $newkey = $key;
                }
                // 配列と非配列で代入の仕方が異なる
                if ($is_array) {
                    $history[] = $key;
                    $result[$newkey] = [];
                    $recursive($result[$newkey], $value, $history, $callback);
                    array_pop($history);
                }
                else {
                    $result[$newkey] = $value;
                }
            }
            // 数値連番は上書きを防ぐためにあとでやる
            foreach ($sequences as $key => $value) {
                if (is_string($key)) {
                    $history[] = substr($key, 1);
                    $v = [];
                    $result[] = &$v;
                    $recursive($v, $value, $history, $callback);
                    array_pop($history);
                    unset($v);
                }
                else {
                    $result[] = $value;
                }
            }
        };

        $result = [];
        $recursive($result, $array, [], $callback);
        return $result;
    }
}
if (!isset($excluded_functions['array_flatten']) && (!function_exists('array_flatten') || (new \ReflectionFunction('array_flatten'))->isInternal())) {
    /**
     * 多階層配列をフラットに展開する
     *
     * 巷にあふれている実装と違って、 ["$pkey.$ckey" => $value] 形式の配列でも返せる。
     * $delimiter で区切り文字を指定した場合にそのようになる。
     * $delimiter = null の場合に本当の配列で返す（巷の実装と同じ）。
     *
     * Example:
     * <code>
     * $array = [
     *    'k1' => 'v1',
     *    'k2' => [
     *        'k21' => 'v21',
     *        'k22' => [
     *            'k221' => 'v221',
     *            'k222' => 'v222',
     *            'k223' => [1, 2, 3],
     *        ],
     *    ],
     * ];
     * // 区切り文字指定なし
     * assertSame(array_flatten($array), [
     *    0 => 'v1',
     *    1 => 'v21',
     *    2 => 'v221',
     *    3 => 'v222',
     *    4 => 1,
     *    5 => 2,
     *    6 => 3,
     * ]);
     * // 区切り文字指定
     * assertSame(array_flatten($array, '.'), [
     *    'k1'            => 'v1',
     *    'k2.k21'        => 'v21',
     *    'k2.k22.k221'   => 'v221',
     *    'k2.k22.k222'   => 'v222',
     *    'k2.k22.k223.0' => 1,
     *    'k2.k22.k223.1' => 2,
     *    'k2.k22.k223.2' => 3,
     * ]);
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param string|null $delimiter キーの区切り文字。 null を与えると連番になる
     * @return array フラット化された配列
     */
    function array_flatten($array, $delimiter = NULL)
    {
        // 要素追加について、 array_set だと目に見えて速度低下したのでベタに if else で分岐する
        $core = function ($array, $delimiter) use (&$core) {
            $result = [];
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($core($v, $delimiter) as $ik => $iv) {
                        if ($delimiter === null) {
                            $result[] = $iv;
                        }
                        else {
                            $result[$k . $delimiter . $ik] = $iv;
                        }
                    }
                }
                else {
                    if ($delimiter === null) {
                        $result[] = $v;
                    }
                    else {
                        $result[$k] = $v;
                    }
                }
            }
            return $result;
        };

        return $core($array, $delimiter);
    }
}
if (!isset($excluded_functions['array_nest']) && (!function_exists('array_nest') || (new \ReflectionFunction('array_nest'))->isInternal())) {
    /**
     * シンプルな [キー => 値] な配列から階層配列を生成する
     *
     * 定義的に array_flatten の逆関数のような扱いになる。
     * $delimiter で階層を表現する。
     *
     * 同名とみなされるキーは上書きされるか例外が飛ぶ。具体的には Example を参照。
     *
     * Example:
     * <code>
     * // 単純な階層展開
     * $array = [
     *    'k1'            => 'v1',
     *    'k2.k21'        => 'v21',
     *    'k2.k22.k221'   => 'v221',
     *    'k2.k22.k222'   => 'v222',
     *    'k2.k22.k223.0' => 1,
     *    'k2.k22.k223.1' => 2,
     *    'k2.k22.k223.2' => 3,
     * ];
     * assertSame(array_nest($array), [
     *    'k1' => 'v1',
     *    'k2' => [
     *        'k21' => 'v21',
     *        'k22' => [
     *            'k221' => 'v221',
     *            'k222' => 'v222',
     *            'k223' => [1, 2, 3],
     *        ],
     *    ],
     * ]);
     * // 同名になるようなキーは上書きされる
     * $array = [
     *    'k1.k2' => 'v1', // この時点で 'k1' は配列になるが・・・
     *    'k1'    => 'v2', // この時点で 'k1' は文字列として上書きされる
     * ];
     * assertSame(array_nest($array), [
     *    'k1' => 'v2',
     * ]);
     * // 上書きすら出来ない場合は例外が飛ぶ
     * $array = [
     *    'k1'    => 'v1', // この時点で 'k1' は文字列になるが・・・
     *    'k1.k2' => 'v2', // この時点で 'k1' にインデックスアクセスすることになるので例外が飛ぶ
     * ];
     * try {
     *     array_nest($array);
     * }
     * catch (\Exception $e) {
     *     assertInstanceof(\InvalidArgumentException::class, $e);
     * }
     * </code>
     *
     * @package Array
     *
     * @param array|\Traversable $array 対象配列
     * @param string $delimiter キーの区切り文字
     * @return array 階層化された配列
     */
    function array_nest($array, $delimiter = '.')
    {
        $result = [];
        foreach ($array as $k => $v) {
            $keys = explode($delimiter, $k);
            $rkeys = [];
            $tmp = &$result;
            foreach ($keys as $key) {
                $rkeys[] = $key;
                if (isset($tmp[$key]) && !is_array($tmp[$key])) {
                    throw new \InvalidArgumentException("'" . implode($delimiter, $rkeys) . "' of '$k' is already exists.");
                }
                $tmp = &$tmp[$key];
            }
            $tmp = $v;
            unset($tmp);
        }
        return $result;
    }
}
if (!isset($excluded_functions['stdclass']) && (!function_exists('stdclass') || (new \ReflectionFunction('stdclass'))->isInternal())) {
    /**
     * 初期フィールド値を与えて stdClass を生成する
     *
     * 手元にある配列でサクッと stdClass を作りたいことがまれによくあるはず。
     *
     * object キャストでもいいんだが、 Iterator/Traversable とかも stdClass 化したいかもしれない。
     * それにキャストだとコールバックで呼べなかったり、数値キーが死んだりして微妙に使いづらいところがある。
     *
     * Example:
     * <code>
     * // 基本的には object キャストと同じ
     * $fields = ['a' => 'A', 'b' => 'B'];
     * assertEquals(stdclass($fields), (object) $fields);
     * // ただしこういうことはキャストでは出来ない
     * assertEquals(array_map('stdclass', [$fields]), [(object) $fields]); // コールバックとして利用する
     * assertTrue(property_exists(stdclass(['a', 'b']), '0')); // 数値キー付きオブジェクトにする
     * </code>
     *
     * @package ClassObject
     *
     * @param array|\Traversable $fields フィールド配列
     * @return \stdClass 生成した stdClass インスタンス
     */
    function stdclass($fields = [])
    {
        $stdclass = new \stdClass();
        foreach ($fields as $key => $value) {
            $stdclass->$key = $value;
        }
        return $stdclass;
    }
}
if (!isset($excluded_functions['detect_namespace']) && (!function_exists('detect_namespace') || (new \ReflectionFunction('detect_namespace'))->isInternal())) {
    /**
     * ディレクトリ構造から名前空間を推測して返す
     *
     * 指定パスに名前空間を持つような php ファイルが有るならその名前空間を返す。
     * 指定パスに名前空間を持つような php ファイルが無いなら親をたどる。
     * 親に名前空間を持つような php ファイルが有るならその名前空間＋ローカルパスを返す。
     *
     * 言葉で表すとややこしいが、「そのパスに配置しても違和感の無い名前空間」を返してくれるはず。
     *
     * @package ClassObject
     *
     * @param string $location 配置パス。ファイル名を与えるとそのファイルを配置すべきクラス名を返す
     * @return string 名前空間
     */
    function detect_namespace($location)
    {
        // php をパースして名前空間部分を得るクロージャ
        $detectNS = function ($phpfile) {
            $tokens = token_get_all(file_get_contents($phpfile));
            $count = count($tokens);

            $namespace = [];
            foreach ($tokens as $n => $token) {
                if (is_array($token) && $token[0] === T_NAMESPACE) {
                    // T_NAMESPACE と T_WHITESPACE で最低でも2つは読み飛ばしてよい
                    for ($m = $n + 2; $m < $count; $m++) {
                        // よほどのことがないと T_NAMESPACE の次の T_STRING は名前空間の一部
                        if (is_array($tokens[$m]) && $tokens[$m][0] === T_STRING) {
                            $namespace[] = $tokens[$m][1];
                        }
                        // 終わりが来たら結合して返す
                        if ($tokens[$m] === ';') {
                            return implode('\\', $namespace);
                        }
                    }
                }
            }
            return null;
        };

        // 指定パスの兄弟ファイルを調べた後、親ディレクトリを辿っていく
        $basenames = [];
        return call_user_func(dirname_r, $location, function ($directory) use ($detectNS, &$basenames) {
            foreach (array_filter(glob("$directory/*.php"), 'is_file') as $file) {
                $namespace = $detectNS($file);
                if ($namespace !== null) {
                    $localspace = implode('\\', array_reverse($basenames));
                    return rtrim($namespace . '\\' . $localspace, '\\');
                }
            }
            $basenames[] = pathinfo($directory, PATHINFO_FILENAME);
        }) ?: call_user_func(throws, new \InvalidArgumentException('can not detect namespace. invalid output path or not specify namespace.'));
    }
}
if (!isset($excluded_functions['class_loader']) && (!function_exists('class_loader') || (new \ReflectionFunction('class_loader'))->isInternal())) {
    /**
     * composer のクラスローダを返す
     *
     * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
     *
     * Example:
     * <code>
     * assertInstanceof(\Composer\Autoload\ClassLoader::class, class_loader());
     * </code>
     *
     * @package ClassObject
     *
     * @param string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
     * @return \Composer\Autoload\ClassLoader クラスローダ
     */
    function class_loader($startdir = NULL)
    {
        $file = call_user_func(cache, 'path', function () use ($startdir) {
            $dir = $startdir ?: __DIR__;
            while ($dir !== ($pdir = dirname($dir))) {
                $dir = $pdir;
                if (file_exists($file = "$dir/autoload.php") || file_exists($file = "$dir/vendor/autoload.php")) {
                    $cache = $file;
                    break;
                }
            }
            if (!isset($cache)) {
                throw new \DomainException('autoloader is not found.');
            }
            return $cache;
        }, __FUNCTION__);
        return require $file;
    }
}
if (!isset($excluded_functions['class_namespace']) && (!function_exists('class_namespace') || (new \ReflectionFunction('class_namespace'))->isInternal())) {
    /**
     * クラスの名前空間部分を取得する
     *
     * Example:
     * <code>
     * assertSame(class_namespace('vendor\\namespace\\ClassName'), 'vendor\\namespace');
     * </code>
     *
     * @package ClassObject
     *
     * @param string|object $class 対象クラス・オブジェクト
     * @return string クラスの名前空間
     */
    function class_namespace($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $parts = explode('\\', $class);
        array_pop($parts);
        return ltrim(implode('\\', $parts), '\\');
    }
}
if (!isset($excluded_functions['class_shorten']) && (!function_exists('class_shorten') || (new \ReflectionFunction('class_shorten'))->isInternal())) {
    /**
     * クラスの名前空間部分を除いた短い名前を取得する
     *
     * Example:
     * <code>
     * assertSame(class_shorten('vendor\\namespace\\ClassName'), 'ClassName');
     * </code>
     *
     * @package ClassObject
     *
     * @param string|object $class 対象クラス・オブジェクト
     * @return string クラスの短い名前
     */
    function class_shorten($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $parts = explode('\\', $class);
        return array_pop($parts);
    }
}
if (!isset($excluded_functions['class_replace']) && (!function_exists('class_replace') || (new \ReflectionFunction('class_replace'))->isInternal())) {
    /**
     * 既存（未読み込みに限る）クラスを強制的に置換する
     *
     * 例えば継承ツリーが下記の場合を考える。
     *
     * classA <- classB <- classC
     *
     * この場合、「classC は classB に」「classB は classA に」それぞれ依存している、と考えることができる。
     * これは静的に決定的であり、この依存を壊したり注入したりする手段は存在しない。
     * 例えば classA の実装を差し替えたいときに、いかに classA を継承した classAA を定義したとしても classB の親は classA で決して変わらない。
     *
     * この関数を使うと本当に classA そのものを弄るので、継承ツリーを下記のように変えることができる。
     *
     * classA <- classAA <- classB <- classC
     *
     * つまり、classA を継承した classAA を定義してそれを classA とみなすことが可能になる。
     * ただし、内部的には class_alias を使用して実現しているので厳密には異なるクラスとなる。
     *
     * 実際のところかなり強力な機能だが、同時にかなり黒魔術的なので乱用は控えたほうがいい。
     *
     * @package ClassObject
     *
     * @param string $class 対象クラス名
     * @param \Closure $register 置換クラスを定義 or 返すクロージャ。「返せる」のは php7.0 以降のみ
     * @param string $dirname 一時ファイル書き出しディレクトリ。指定すると実質的にキャッシュとして振る舞う
     */
    function class_replace($class, $register, $dirname = NULL)
    {
        $class = ltrim($class, '\\');

        // 読み込み済みクラスは置換できない（php はクラスのアンロード機能が存在しない）
        if (class_exists($class, false)) {
            throw new \DomainException("'$class' is already declared.");
        }

        // 対象クラス名をちょっとだけ変えたクラスを用意して読み込む
        $classfile = call_user_func(class_loader)->findFile($class);
        $fname = rtrim(($dirname ?: sys_get_temp_dir()), '/\\') . '/' . str_replace('\\', '/', $class) . '.php';
        if (func_num_args() === 2 || !file_exists($fname)) {
            $content = file_get_contents($classfile);
            $content = preg_replace("#class\\s+[a-z0-9_]+#ui", '$0_', $content);
            call_user_func(file_set_contents, $fname, $content);
        }
        require_once $fname;

        $classess = get_declared_classes();
        $newclass = $register();

        // クロージャ内部でクラス定義した場合（増えたクラスでエイリアスする）
        if ($newclass === null) {
            $classes = array_diff(get_declared_classes(), $classess);
            if (count($classes) !== 1) {
                throw new \DomainException('declared multi classes.');
            }
            $newclass = reset($classes);
        }
        // php7.0 から無名クラスが使えるのでそのクラス名でエイリアスする
        if (is_object($newclass)) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $newclass = get_class($newclass);
        }

        class_alias($newclass, $class);
    }
}
if (!isset($excluded_functions['file_list']) && (!function_exists('file_list') || (new \ReflectionFunction('file_list'))->isInternal())) {
    /**
     * ファイル一覧を配列で返す
     *
     * @package FileSystem
     *
     * @param string $dirname 調べるディレクトリ名
     * @param \Closure|array $filter_condition フィルタ条件
     * @return array|false ファイルの配列
     */
    function file_list($dirname, $filter_condition = NULL)
    {
        $dirname = realpath($dirname);
        if (!file_exists($dirname)) {
            return false;
        }

        $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
        $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

        $result = [];
        foreach ($rii as $it) {
            if (!$it->isDir()) {
                if ($filter_condition === null || $filter_condition($it->getPathname())) {
                    $result[] = $it->getPathname();
                }
            }
        }
        return $result;
    }
}
if (!isset($excluded_functions['file_tree']) && (!function_exists('file_tree') || (new \ReflectionFunction('file_tree'))->isInternal())) {
    /**
     * ディレクトリ階層をツリー構造で返す
     *
     * @package FileSystem
     *
     * @param string $dirname 調べるディレクトリ名
     * @param \Closure|array $filter_condition フィルタ条件
     * @return array|false ツリー構造の配列
     */
    function file_tree($dirname, $filter_condition = NULL)
    {
        $dirname = realpath($dirname);
        if (!file_exists($dirname)) {
            return false;
        }

        $basedir = basename($dirname);

        $result = [];
        $items = iterator_to_array(new \FilesystemIterator($dirname, \FilesystemIterator::SKIP_DOTS));
        usort($items, function (\SplFileInfo $a, \SplFileInfo $b) {
            if ($a->isDir() xor $b->isDir()) {
                return $a->isDir() - $b->isDir();
            }
            return strcmp($a->getPathname(), $b->getPathname());
        });
        foreach ($items as $item) {
            if (!isset($result[$basedir])) {
                $result[$basedir] = [];
            }
            if ($item->isDir()) {
                $result[$basedir] += call_user_func(file_tree, $item->getPathname(), $filter_condition);
            }
            else {
                if ($filter_condition === null || $filter_condition($item->getPathname())) {
                    $result[$basedir][$item->getBasename()] = $item->getPathname();
                }
            }
        }
        // フィルタで全除去されると空エントリになるので明示的に削除
        if (!$result[$basedir]) {
            unset($result[$basedir]);
        }
        return $result;
    }
}
if (!isset($excluded_functions['file_extension']) && (!function_exists('file_extension') || (new \ReflectionFunction('file_extension'))->isInternal())) {
    /**
     * ファイルの拡張子を変更する。引数を省略すると拡張子を返す
     *
     * pathinfoに準拠。例えば「filename.hoge.fuga」のような形式は「fuga」が変換対象になる。
     *
     * Example:
     * <code>
     * assertSame(file_extension('filename.ext'), 'ext');
     * assertSame(file_extension('filename.ext', 'txt'), 'filename.txt');
     * assertSame(file_extension('filename.ext', ''), 'filename');
     * </code>
     *
     * @package FileSystem
     *
     * @param string $filename 調べるファイル名
     * @param string $extension 拡張子。nullや空文字なら拡張子削除
     * @return string 拡張子変換後のファイル名 or 拡張子
     */
    function file_extension($filename, $extension = '')
    {
        $pathinfo = pathinfo($filename);

        if (func_num_args() === 1) {
            return isset($pathinfo['extension']) ? $pathinfo['extension'] : null;
        }

        if (strlen($extension)) {
            $extension = '.' . ltrim($extension, '.');
        }
        $basename = $pathinfo['filename'] . $extension;

        if ($pathinfo['dirname'] === '.') {
            return $basename;
        }

        return $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $basename;
    }
}
if (!isset($excluded_functions['file_set_contents']) && (!function_exists('file_set_contents') || (new \ReflectionFunction('file_set_contents'))->isInternal())) {
    /**
     * ディレクトリも掘る file_put_contents
     *
     * Example:
     * <code>
     * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
     * assertSame(file_get_contents(sys_get_temp_dir() . '/not/filename.ext'), 'hoge');
     * </code>
     *
     * @package FileSystem
     *
     * @param string $filename 書き込むファイル名
     * @param string $data 書き込む内容
     * @param int $umask ディレクトリを掘る際の umask
     * @return int 書き込まれたバイト数
     */
    function file_set_contents($filename, $data, $umask = 2)
    {
        if (func_num_args() === 2) {
            $umask = umask();
        }

        if (!is_dir($dirname = dirname($filename))) {
            if (!@call_user_func(mkdir_p, $dirname, $umask)) {
                throw new \RuntimeException("failed to mkdir($dirname)");
            }
        }
        return file_put_contents($filename, $data);
    }
}
if (!isset($excluded_functions['mkdir_p']) && (!function_exists('mkdir_p') || (new \ReflectionFunction('mkdir_p'))->isInternal())) {
    /**
     * ディレクトリを再帰的に掘る
     *
     * 既に存在する場合は何もしない（エラーも出さない）。
     *
     * @package FileSystem
     *
     * @param string $dirname ディレクトリ名
     * @param int $umask ディレクトリを掘る際の umask
     * @return bool 作成したら true
     */
    function mkdir_p($dirname, $umask = 2)
    {
        if (func_num_args() === 1) {
            $umask = umask();
        }

        if (file_exists($dirname)) {
            return false;
        }

        return mkdir($dirname, 0777 & (~$umask), true);
    }
}
if (!isset($excluded_functions['dirname_r']) && (!function_exists('dirname_r') || (new \ReflectionFunction('dirname_r'))->isInternal())) {
    /**
     * コールバックが true 相当を返すまで親ディレクトリを辿り続ける
     *
     * コールバックには親ディレクトリが引数として渡ってくる。
     *
     * Example:
     * <code>
     * // //tmp/a/b/file.txt を作っておく
     * $tmp = sys_get_temp_dir();
     * file_set_contents("$tmp/a/b/file.txt", 'hoge');
     * // /a/b/c/d/e/f から開始して「どこかの階層の file.txt を探したい」という状況を想定
     * $callback = function($path){return realpath("$path/file.txt");};
     * assertSame(dirname_r("$tmp/a/b/c/d/e/f", $callback), realpath("$tmp/a/b/file.txt"));
     * </code>
     *
     * @package FileSystem
     *
     * @param string $path パス名
     * @param callable $callback コールバック
     * @return mixed $callback の返り値。頂上まで辿ったら false
     */
    function dirname_r($path, $callback)
    {
        $return = $callback($path);
        if ($return) {
            return $return;
        }

        $dirname = dirname($path);
        if ($dirname === $path) {
            return false;
        }
        return call_user_func(dirname_r, $dirname, $callback);
    }
}
if (!isset($excluded_functions['path_is_absolute']) && (!function_exists('path_is_absolute') || (new \ReflectionFunction('path_is_absolute'))->isInternal())) {
    /**
     * パスが絶対パスか判定する
     *
     * Example:
     * <code>
     * assertTrue(path_is_absolute('/absolute/path'));
     * assertFalse(path_is_absolute('relative/path'));
     * // Windows 環境では下記も true になる
     * if (DIRECTORY_SEPARATOR === '\\') {
     *     assertTrue(path_is_absolute('\\absolute\\path'));
     *     assertTrue(path_is_absolute('C:\\absolute\\path'));
     * }
     * </code>
     *
     * @package FileSystem
     *
     * @param string $path パス文字列
     * @return bool 絶対パスなら true
     */
    function path_is_absolute($path)
    {
        if (substr($path, 0, 1) == '/') {
            return true;
        }

        if (DIRECTORY_SEPARATOR === '\\') {
            if (preg_match('#^([a-z]+:(\\\\|\\/|$)|\\\\)#i', $path) !== 0) {
                return true;
            }
        }

        return false;
    }
}
if (!isset($excluded_functions['path_resolve']) && (!function_exists('path_resolve') || (new \ReflectionFunction('path_resolve'))->isInternal())) {
    /**
     * パスを絶対パスに変換して正規化する
     *
     * 可変引数で与えられた文字列群を結合して絶対パス化して返す。
     * 出来上がったパスが絶対パスでない場合はカレントディレクトリを結合して返す。
     *
     * Example:
     * <code>
     * $DS = DIRECTORY_SEPARATOR;
     * assertSame(path_resolve('/absolute/path'), "{$DS}absolute{$DS}path");
     * assertSame(path_resolve('absolute/path'), getcwd() . "{$DS}absolute{$DS}path");
     * assertSame(path_resolve('/absolute/path/through', '../current/./path'), "{$DS}absolute{$DS}path{$DS}current{$DS}path");
     * </code>
     *
     * @package FileSystem
     *
     * @param array $paths パス文字列（可変引数）
     * @return string 絶対パス
     */
    function path_resolve(...$paths)
    {
        $DS = DIRECTORY_SEPARATOR;

        $path = implode($DS, $paths);

        if (!call_user_func(path_is_absolute, $path)) {
            $path = getcwd() . $DS . $path;
        }

        return call_user_func(path_normalize, $path);
    }
}
if (!isset($excluded_functions['path_normalize']) && (!function_exists('path_normalize') || (new \ReflectionFunction('path_normalize'))->isInternal())) {
    /**
     * パスを正規化する
     *
     * 具体的には ./ や ../ を取り除いたり連続したディレクトリ区切りをまとめたりする。
     * realpath ではない。のでシンボリックリンクの解決などはしない。その代わりファイルが存在しなくても使用することができる。
     *
     * Example:
     * <code>
     * $DS = DIRECTORY_SEPARATOR;
     * assertSame(path_normalize('/path/to/something'), "{$DS}path{$DS}to{$DS}something");
     * assertSame(path_normalize('/path/through/../something'), "{$DS}path{$DS}something");
     * assertSame(path_normalize('./path/current/./through/../something'), "path{$DS}current{$DS}something");
     * </code>
     *
     * @package FileSystem
     *
     * @param string $path パス文字列
     * @return string 正規化されたパス
     */
    function path_normalize($path)
    {
        $ds = '/';
        if (DIRECTORY_SEPARATOR === '\\') {
            $ds .= '\\\\';
        }

        $result = [];
        foreach (preg_split("#[$ds]#u", $path) as $n => $part) {
            if ($n > 0 && $part === '') {
                continue;
            }
            if ($part === '.') {
                continue;
            }
            if ($part === '..') {
                if (empty($result)) {
                    throw new \InvalidArgumentException("'$path' is invalid as path string.");
                }
                array_pop($result);
                continue;
            }
            $result[] = $part;
        }
        return implode(DIRECTORY_SEPARATOR, $result);
    }
}
if (!isset($excluded_functions['cp_rf']) && (!function_exists('cp_rf') || (new \ReflectionFunction('cp_rf'))->isInternal())) {
    /**
     * ディレクトリのコピー
     *
     * $dst に / を付けると「$dst に自身をコピー」する。付けないと「$dst に中身をコピー」するという動作になる。
     *
     * ディレクトリではなくファイルを与えても動作する（copy とほぼ同じ動作になるが、対象にディレクトリを指定できる点が異なる）。
     *
     * Example:
     * <code>
     * // /tmp/src/hoge.txt, /tmp/src/dir/fuga.txt を作っておく
     * $tmp = sys_get_temp_dir();
     * file_set_contents("$tmp/src/hoge.txt", 'hoge');
     * file_set_contents("$tmp/src/dir/fuga.txt", 'fuga');
     *
     * // "/" を付けないと中身コピー
     * cp_rf("$tmp/src", "$tmp/dst1");
     * assertStringEqualsFile("$tmp/dst1/hoge.txt", 'hoge');
     * assertStringEqualsFile("$tmp/dst1/dir/fuga.txt", 'fuga');
     * // "/" を付けると自身コピー
     * cp_rf("$tmp/src", "$tmp/dst2/");
     * assertStringEqualsFile("$tmp/dst2/src/hoge.txt", 'hoge');
     * assertStringEqualsFile("$tmp/dst2/src/dir/fuga.txt", 'fuga');
     *
     * // $src はファイルでもいい（$dst に "/" を付けるとそのディレクトリにコピーする）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst3/");
     * assertStringEqualsFile("$tmp/dst3/hoge.txt", 'hoge');
     * // $dst に "/" を付けないとそのパスとしてコピー（copy と完全に同じ）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst4");
     * assertStringEqualsFile("$tmp/dst4", 'hoge');
     * </code>
     *
     * @package FileSystem
     *
     * @param string $src コピー元パス
     * @param string $dst コピー先パス。末尾/でディレクトリであることを明示できる
     * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
     */
    function cp_rf($src, $dst)
    {
        $dss = '/' . (DIRECTORY_SEPARATOR === '\\' ? '\\\\' : '');
        $dirmode = preg_match("#[$dss]$#u", $dst);

        // ディレクトリでないなら copy へ移譲
        if (!is_dir($src)) {
            if ($dirmode) {
                call_user_func(mkdir_p, $dst);
                return copy($src, $dst . basename($src));
            }
            else {
                call_user_func(mkdir_p, dirname($dst));
                return copy($src, $dst);
            }
        }

        if ($dirmode) {
            return call_user_func(cp_rf, $src, $dst . basename($src));
        }

        call_user_func(mkdir_p, $dst);

        foreach (glob("$src/*") as $file) {
            if (is_dir($file)) {
                call_user_func(cp_rf, $file, "$dst/" . basename($file));
            }
            else {
                copy($file, "$dst/" . basename($file));
            }
        }
        return file_exists($dst);
    }
}
if (!isset($excluded_functions['rm_rf']) && (!function_exists('rm_rf') || (new \ReflectionFunction('rm_rf'))->isInternal())) {
    /**
     * 中身があっても消せる rmdir
     *
     * Example:
     * <code>
     * mkdir(sys_get_temp_dir() . '/new/make/dir', 0777, true);
     * rm_rf(sys_get_temp_dir() . '/new');
     * assertSame(file_exists(sys_get_temp_dir() . '/new'), false);
     * </code>
     *
     * @package FileSystem
     *
     * @param string $dirname 削除するディレクトリ名
     * @param bool $self 自分自身も含めるか。false を与えると中身だけを消す
     * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
     */
    function rm_rf($dirname, $self = true)
    {
        if (!file_exists($dirname)) {
            return false;
        }

        $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
        $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($rii as $it) {
            if ($it->isDir()) {
                rmdir($it->getPathname());
            }
            else {
                unlink($it->getPathname());
            }
        }

        if ($self) {
            return rmdir($dirname);
        }
    }
}
if (!isset($excluded_functions['tmpname']) && (!function_exists('tmpname') || (new \ReflectionFunction('tmpname'))->isInternal())) {
    /**
     * 終了時に削除される一時ファイル名を生成する
     *
     * tempnam とほぼ同じで違いは下記。
     * - 引数が逆
     * - 終了時に削除される
     * - 失敗時に false を返すのではなく例外を投げる
     *
     * @package FileSystem
     *
     * @param string $prefix ファイル名プレフィックス
     * @param string $dir 生成ディレクトリ。省略時は sys_get_temp_dir()
     * @return string 一時ファイル名
     */
    function tmpname($prefix = 'rft', $dir = NULL)
    {
        // デフォルト付きで tempnam を呼ぶ
        $dir = $dir ?: sys_get_temp_dir();
        $tempfile = tempnam($dir, $prefix);

        // tempnam が何をしても false を返してくれないんだがどうしたら返してくれるんだろうか？
        if ($tempfile === false) {
            throw new \UnexpectedValueException("tmpname($dir, $prefix) failed.");// @codeCoverageIgnore
        }

        // 生成したファイルを覚えておいて最後に消す
        static $files = [];
        $files[] = $tempfile;
        // ただし、 shutdown_function にあまり大量に追加したくないので初回のみ登録する（$files は参照で渡す）
        if (count($files) === 1) {
            register_shutdown_function(function () use (&$files) {
                // @codeCoverageIgnoreStart
                foreach ($files as $file) {
                    // 明示的に消されたかもしれないので file_exists してから消す
                    if (file_exists($file)) {
                        // レースコンディションのため @ を付ける
                        @unlink($file);
                    }
                }
                // @codeCoverageIgnoreEnd
            });
        }

        return $tempfile;
    }
}
if (!isset($excluded_functions['delegate']) && (!function_exists('delegate') || (new \ReflectionFunction('delegate'))->isInternal())) {
    /**
     * 指定 callable を指定クロージャで実行するクロージャを返す
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @package Callable
     *
     * @param \Closure $invoker クロージャを実行するためのクロージャ（実処理）
     * @param callable $callable 最終的に実行したいクロージャ
     * @param int $arity 引数の数
     * @return \Closure $callable を実行するクロージャ
     */
    function delegate($invoker, $callable, $arity = NULL)
    {
        if ($arity === null) {
            $arity = call_user_func(parameter_length, $callable, true, true);
        }

        if (is_infinite($arity)) {
            return eval('return function (...$_) use ($invoker, $callable) {
                return $invoker($callable, func_get_args());
            };');
        }

        $arity = abs($arity);
        switch ($arity) {
            case 0:
                return function () use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 1:
                return function ($_1) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 2:
                return function ($_1, $_2) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 3:
                return function ($_1, $_2, $_3) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 4:
                return function ($_1, $_2, $_3, $_4) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 5:
                return function ($_1, $_2, $_3, $_4, $_5) use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            default:
                $argstring = call_user_func(array_rmap, range(1, $arity), strcat, '$_');
                return eval('return function (' . implode(', ', $argstring) . ') use ($invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };');
        }
    }
}
if (!isset($excluded_functions['nbind']) && (!function_exists('nbind') || (new \ReflectionFunction('nbind'))->isInternal())) {
    /**
     * $callable の指定位置に引数を束縛したクロージャを返す
     *
     * Example:
     * <code>
     * $bind = nbind('sprintf', 2, 'X');
     * assertSame($bind('%s%s%s', 'N', 'N'), 'NXN');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @param int $n 挿入する引数位置
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    function nbind($callable, $n, ...$variadic)
    {
        return call_user_func(delegate, function ($callable, $args) use ($variadic, $n) {
            return call_user_func_array($callable, call_user_func(array_insert, $args, $variadic, $n));
        }, $callable, call_user_func(parameter_length, $callable, true) - count($variadic));
    }
}
if (!isset($excluded_functions['lbind']) && (!function_exists('lbind') || (new \ReflectionFunction('lbind'))->isInternal())) {
    /**
     * $callable の最左に引数を束縛した callable を返す
     *
     * Example:
     * <code>
     * $bind = lbind('sprintf', '%s%s');
     * assertSame($bind('N', 'M'), 'NM');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    function lbind($callable, ...$variadic)
    {
        return call_user_func_array(nbind, call_user_func(array_insert, func_get_args(), 0, 1));
    }
}
if (!isset($excluded_functions['rbind']) && (!function_exists('rbind') || (new \ReflectionFunction('rbind'))->isInternal())) {
    /**
     * $callable の最右に引数を束縛した callable を返す
     *
     * Example:
     * <code>
     * $bind = rbind('sprintf', 'X');
     * assertSame($bind('%s%s', 'N'), 'NX');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    function rbind($callable, ...$variadic)
    {
        return call_user_func_array(nbind, call_user_func(array_insert, func_get_args(), null, 1));
    }
}
if (!isset($excluded_functions['composite']) && (!function_exists('composite') || (new \ReflectionFunction('composite'))->isInternal())) {
    /**
     * 合成関数を返す
     *
     * 基本的には callable を可変引数で呼び出せばそれらの合成関数を返す。
     * ただし $arrayalbe=true のときは若干挙動が異なり、連鎖のときに「前の返り値を**配列として**次の引数へ渡す」動作になる。
     * つまり、前の関数が `[1, 2, 3]` を返せば次の関数へは `f(1, 2, 3)` が渡る（ただしただの配列の場合のみ。連想配列は単値で渡る）。
     * $arrayalbe=false のときは渡る引数は常に単値（単値というか素直に渡すだけ）。
     * 上の例で言えば、前の関数が `[1, 2, 3]` を返せば次の関数へは `f($array=[1, 2, 3])` が渡る。
     *
     * $arrayalbe=true の方が利便性は高い。が、「本当にただの配列を渡したいとき」が判断できないので誤動作の原因にもなる。
     * e.g. `[1, 2, 3]` を配列として渡したいが $arrayalbe=true だと3つの引数として渡ってしまう
     *
     * いずれにせよ $arrayalbe は必須ではなく、第1引数が bool ならオプションだと判断し、そうでないなら true とみなす。
     *
     * Example:
     * <code>
     * $add5 = function ($v) { return $v + 5; };            // 来た値を +5 するクロージャ
     * $mul3 = function ($v) { return $v * 3; };            // 来た値を *3 するクロージャ
     * $split = function ($v) { return str_split($v); };    // 文字列的に桁分割するクロージャ
     * $union = function ($v) { return $v[0] + $v[1]; };    // 来た配列を足すクロージャ
     * $composite = composite(false, $add5, $mul3, $split, $union);// 上記を合成したクロージャ
     * // false を渡すと配列を考慮しない（つまり、単一の引数しか受け取れず、単一の返り値しか返せない）
     * // 7 + 5 -> 12 |> 12 * 3 -> 36 |> 36 -> [3, 6] |> 3 + 6 |> 9
     * assertSame($composite(7), 9);
     *
     * $upper = function ($s) { return [$s, strtoupper($s)]; };   // 来た値と大文字化したものを配列で返すクロージャ
     * $prefix = function ($s, $S) { return 'pre-' . $s . $S; };  // 来た値を結合して'pre-'を付けるクロージャ
     * $hash = function ($sS) { return ['sS' => $sS]; };          // 来た値を連想配列にするクロージャ
     * $key = function ($sSsS) { return strrev(reset($sSsS));};   // 来た配列の値をstrrevして返すクロージャ
     * $composite = composite(true, $upper, $prefix, $hash, $key);// 上記を合成したクロージャ
     * // true を渡すとただの配列は引数として、連想配列は単値として渡ってくる
     * // ['hoge', 'HOGE'] |> 'pre-hogeHOGE' |> ['sS' => 'pre-hogeHOGE'] |> 'EGOHegoh-erp'
     * assertSame($composite('hoge'), 'EGOHegoh-erp');
     * </code>
     *
     * @package Callable
     *
     * @param bool $arrayalbe 呼び出しチェーンを配列として扱うか
     * @param callable[] $variadic 合成する関数（可変引数）
     * @return \Closure 合成関数
     */
    function composite($arrayalbe = true, ...$variadic)
    {
        $callables = func_get_args();

        // モード引数が来てるなら捨てる
        if (!is_callable($arrayalbe)) {
            array_shift($callables);
        }
        // 来てないなら前方省略なのでデフォルト値を代入
        else {
            $arrayalbe = true;
        }

        if (empty($callables)) {
            throw new \InvalidArgumentException('too few arguments.');
        }

        $first = array_shift($callables);
        return call_user_func(delegate, function ($first, $args) use ($callables, $arrayalbe) {
            $result = call_user_func_array($first, $args);
            foreach ($callables as $callable) {
                // 「配列モードでただの配列」でないなら配列化
                if (!($arrayalbe && is_array($result) && !call_user_func(is_hasharray, $result))) {
                    $result = [$result];
                }
                $result = call_user_func_array($callable, $result);
            }
            return $result;
        }, $first);
    }
}
if (!isset($excluded_functions['return_arg']) && (!function_exists('return_arg') || (new \ReflectionFunction('return_arg'))->isInternal())) {
    /**
     * $n 番目の引数（0 ベース）をそのまま返すクロージャを返す
     *
     * Example:
     * <code>
     * $arg0 = return_arg(0);
     * assertSame($arg0('hoge'), 'hoge');
     * $arg1 = return_arg(1);
     * assertSame($arg1('dummy', 'hoge'), 'hoge');
     * </code>
     *
     * @package Callable
     *
     * @param int $n $n 番目の引数
     * @return \Closure $n 番目の引数をそのまま返すクロージャ
     */
    function return_arg($n)
    {
        static $cache = [];
        if (!isset($cache[$n])) {
            $cache[$n] = function () use ($n) {
                return func_get_arg($n);
            };
        }
        return $cache[$n];
    }
}
if (!isset($excluded_functions['not_func']) && (!function_exists('not_func') || (new \ReflectionFunction('not_func'))->isInternal())) {
    /**
     * 返り値の真偽値を逆転した新しいクロージャを返す
     *
     * Example:
     * <code>
     * $not_strlen = not_func('strlen');
     * assertFalse($not_strlen('hoge'));
     * assertTrue($not_strlen(''));
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @return \Closure 新しいクロージャ
     */
    function not_func($callable)
    {
        return call_user_func(delegate, function ($callable, $args) {
            return !call_user_func_array($callable, $args);
        }, $callable);
    }
}
if (!isset($excluded_functions['eval_func']) && (!function_exists('eval_func') || (new \ReflectionFunction('eval_func'))->isInternal())) {
    /**
     * 指定コードで eval するクロージャを返す
     *
     * create_function のクロージャ版みたいなもの。
     * 参照渡しは未対応。
     *
     * Example:
     * <code>
     * $evalfunc = eval_func('$a + $b + $c', 'a', 'b', 'c');
     * assertSame($evalfunc(1, 2, 3), 6);
     * </code>
     *
     * @package Callable
     *
     * @param string $expression eval コード
     * @param mixed $variadic 引数名（可変引数）
     * @return \Closure 新しいクロージャ
     */
    function eval_func($expression, ...$variadic)
    {
        $eargs = $variadic;
        return call_user_func(delegate, function ($expression, $args) use ($eargs) {
            return call_user_func(function () {
                extract(func_get_arg(1));
                return eval("return " . func_get_arg(0) . ";");
            }, $expression, array_combine($eargs, $args));
        }, $expression, count($eargs));
    }
}
if (!isset($excluded_functions['reflect_callable']) && (!function_exists('reflect_callable') || (new \ReflectionFunction('reflect_callable'))->isInternal())) {
    /**
     * callable から ReflectionFunctionAbstract を生成する
     *
     * Example:
     * <code>
     * assertInstanceof(\ReflectionFunction::class, reflect_callable('sprintf'));
     * assertInstanceof(\ReflectionMethod::class, reflect_callable('\Closure::bind'));
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @return \ReflectionFunction|\ReflectionMethod リフレクションインスタンス
     */
    function reflect_callable($callable)
    {
        // callable チェック兼 $call_name 取得
        if (!is_callable($callable, true, $call_name)) {
            throw new \InvalidArgumentException("'$call_name' is not callable");
        }

        if ($callable instanceof \Closure || strpos($call_name, '::') === false) {
            return new \ReflectionFunction($callable);
        }
        else {
            list($class, $method) = explode('::', $call_name, 2);
            // for タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
            if (strpos($method, 'parent::') === 0) {
                list(, $method) = explode('::', $method);
                return (new \ReflectionClass($class))->getParentClass()->getMethod($method);
            }
            return new \ReflectionMethod($class, $method);
        }
    }
}
if (!isset($excluded_functions['closurize']) && (!function_exists('closurize') || (new \ReflectionFunction('closurize'))->isInternal())) {
    /**
     * callable を Closure に変換する
     *
     * php7.1 の fromCallable みたいなもの。
     *
     * Example:
     * <code>
     * $sprintf = closurize('sprintf');
     * assertInstanceof(\Closure::class, $sprintf);
     * assertSame($sprintf('%s %s', 'hello', 'world'), 'hello world');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 変換する callable
     * @return \Closure 変換したクロージャ
     */
    function closurize($callable)
    {
        if ($callable instanceof \Closure) {
            return $callable;
        }

        $ref = call_user_func(reflect_callable, $callable);
        if ($ref instanceof \ReflectionMethod) {
            // for タイプ 6: __invoke を実装したオブジェクトを callable として用いる (PHP 5.3 以降)
            if (is_object($callable)) {
                return $ref->getClosure($callable);
            }
            if (is_array($callable)) {
                return $ref->getClosure($callable[0]);
            }
        }
        return $ref->getClosure();
    }
}
if (!isset($excluded_functions['call_safely']) && (!function_exists('call_safely') || (new \ReflectionFunction('call_safely'))->isInternal())) {
    /**
     * エラーを例外に変換するブロックでコールバックを実行する
     *
     * Example:
     * <code>
     * try {
     *     call_safely(function(){return $v;});
     * }
     * catch (\Exception $ex) {
     *     assertSame($ex->getMessage(), 'Undefined variable: v');
     * }
     * </code>
     *
     * @package Callable
     *
     * @param callable $callback 実行するコールバック
     * @param mixed $variadic $callback に渡される引数（可変引数）
     * @return mixed $callback の返り値
     */
    function call_safely($callback, ...$variadic)
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (error_reporting() === 0) {
                return false;
            }
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            $return = call_user_func_array($callback, $variadic);
            restore_error_handler();
            return $return;
        }
        catch (\Exception $ex) {
            restore_error_handler();
            throw $ex;
        }
    }
}
if (!isset($excluded_functions['ob_capture']) && (!function_exists('ob_capture') || (new \ReflectionFunction('ob_capture'))->isInternal())) {
    /**
     * ob_start ～ ob_get_clean のブロックでコールバックを実行する
     *
     * Example:
     * <code>
     * assertSame(ob_capture(function(){echo 123;}), '123');
     * </code>
     *
     * @package Callable
     *
     * @param callable $callback 実行するコールバック
     * @param mixed $variadic $callback に渡される引数（可変引数）
     * @return string オフスリーンバッファの文字列
     */
    function ob_capture($callback, ...$variadic)
    {
        ob_start();
        try {
            call_user_func_array($callback, $variadic);
            return ob_get_clean();
        }
        catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }
    }
}
if (!isset($excluded_functions['parameter_length']) && (!function_exists('parameter_length') || (new \ReflectionFunction('parameter_length'))->isInternal())) {
    /**
     * callable の引数の数を返す
     *
     * クロージャはキャッシュされない。毎回リフレクションを生成し、引数の数を調べてそれを返す。
     * （クロージャには一意性がないので key-value なキャッシュが適用できない）。
     * ので、ループ内で使ったりすると目に見えてパフォーマンスが低下するので注意。
     *
     * Example:
     * <code>
     * // trim の引数は2つ
     * assertSame(parameter_length('trim'), 2);
     * // trim の必須引数は1つ
     * assertSame(parameter_length('trim', true), 1);
     * </code>
     *
     * @package Callable
     *
     * @param callable $callable 対象 callable
     * @param bool $require_only true を渡すと必須パラメータの数を返す
     * @param bool $thought_variadic 可変引数を考慮するか。 true を渡すと可変引数の場合に無限長を返す
     * @return int 引数の数
     */
    function parameter_length($callable, $require_only = false, $thought_variadic = false)
    {
        // クロージャの $call_name には一意性がないのでキャッシュできない（spl_object_hash でもいいが、かなり重複するので完全ではない）
        if ($callable instanceof \Closure) {
            /** @var \ReflectionFunctionAbstract $ref */
            $ref = call_user_func(reflect_callable, $callable);
            if ($thought_variadic && $ref->isVariadic()) {
                return INF;
            }
            elseif ($require_only) {
                return $ref->getNumberOfRequiredParameters();
            }
            else {
                return $ref->getNumberOfParameters();
            }
        }

        // $call_name 取得
        is_callable($callable, false, $call_name);

        $cache = call_user_func(cache, $call_name, function () use ($callable) {
            /** @var \ReflectionFunctionAbstract $ref */
            $ref = call_user_func(reflect_callable, $callable);
            return [
                '00' => $ref->getNumberOfParameters(),
                '01' => $ref->isVariadic() ? INF : $ref->getNumberOfParameters(),
                '10' => $ref->getNumberOfRequiredParameters(),
                '11' => $ref->isVariadic() ? INF : $ref->getNumberOfRequiredParameters(),
            ];
        }, __FUNCTION__);
        return $cache[(int) $require_only . (int) $thought_variadic];
    }
}
if (!isset($excluded_functions['function_shorten']) && (!function_exists('function_shorten') || (new \ReflectionFunction('function_shorten'))->isInternal())) {
    /**
     * 関数の名前空間部分を除いた短い名前を取得する
     *
     * @package Callable
     *
     * @param string $function 短くする関数名
     * @return string 短い関数名
     */
    function function_shorten($function)
    {
        $parts = explode('\\', $function);
        return array_pop($parts);
    }
}
if (!isset($excluded_functions['func_user_func_array']) && (!function_exists('func_user_func_array') || (new \ReflectionFunction('func_user_func_array'))->isInternal())) {
    /**
     * パラメータ定義数に応じて呼び出し引数を可変にしてコールする
     *
     * デフォルト引数はカウントされない。必須パラメータの数で呼び出す。
     * もちろん可変引数は未対応。
     *
     * $callback に null を与えると例外的に「第1引数を返すクロージャ」を返す。
     *
     * php の標準関数は定義数より多い引数を投げるとエラーを出すのでそれを抑制したい場合に使う。
     *
     * Example:
     * <code>
     * // strlen に2つの引数を渡してもエラーにならない
     * $strlen = func_user_func_array('strlen');
     * assertSame($strlen('abc', null), 3);
     * </code>
     *
     * @package Callable
     *
     * @param callable $callback 呼び出すクロージャ
     * @return \Closure 引数ぴったりで呼び出すクロージャ
     */
    function func_user_func_array($callback)
    {
        if ($callback === null) {
            return function ($v) { return $v; };
        }
        $plength = call_user_func(parameter_length, $callback, true, true);
        return call_user_func(delegate, function ($callback, $args) use ($plength) {
            if (is_infinite($plength)) {
                return call_user_func_array($callback, $args);
            }
            return call_user_func_array($callback, array_slice($args, 0, $plength));
        }, $callback, $plength);
    }
}
if (!isset($excluded_functions['function_alias']) && (!function_exists('function_alias') || (new \ReflectionFunction('function_alias'))->isInternal())) {
    /**
     * 関数のエイリアスを作成する
     *
     * 単に移譲するだけではなく、参照渡し・参照返しも模倣される。
     * その代わり、単純なエイリアスではなく別定義で吐き出すので「エイリアス」ではなく「処理が同じな別関数」と思ったほうがよい。
     *
     * 静的であればクラスメソッドも呼べる。
     *
     * Example:
     * <code>
     * // trim のエイリアス
     * function_alias('trim', 'trim_alias');
     * assertSame(trim_alias(' abc '), 'abc');
     * </code>
     *
     * @package Callable
     *
     * @param callable $original 元となる関数
     * @param string $alias 関数のエイリアス名
     * @param string|bool $cachedir キャッシュパス。未指定/falseだとキャッシュされない。true だと一時ディレクトリに書き出す
     */
    function function_alias($original, $alias, $cachedir = false)
    {
        // クロージャとか __invoke とかは無理なので例外を投げる
        if (is_object($original)) {
            throw new \InvalidArgumentException('$original must not be object.');
        }
        // callname の取得と非静的のチェック
        is_callable($original, true, $calllname);
        $calllname = ltrim($calllname, '\\');
        $ref = call_user_func(reflect_callable, $original);
        if ($ref instanceof \ReflectionMethod && !$ref->isStatic()) {
            throw new \InvalidArgumentException("$calllname is non-static method.");
        }
        // エイリアスが既に存在している
        if (function_exists($alias)) {
            throw new \InvalidArgumentException("$alias is already declared.");
        }

        // キャッシュ指定有りなら読み込むだけで eval しない
        $cachedir = call_user_func(ifelse, $cachedir, true, sys_get_temp_dir());
        $cachefile = $cachedir ? $cachedir . '/' . rawurlencode($calllname . '-' . $alias) . '.php' : null;
        if ($cachefile && file_exists($cachefile)) {
            require $cachefile;
            return;
        }

        // 仮引数と実引数の構築
        $params = [];
        $args = [];
        foreach ($ref->getParameters() as $param) {
            $default = '';
            if ($param->isOptional()) {
                // 組み込み関数のデフォルト値を取得することは出来ない（isDefaultValueAvailable も false を返す）
                if ($param->isDefaultValueAvailable()) {
                    $defval = var_export($param->getDefaultValue(), true);
                }
                // 「オプショナルだけどデフォルト値がないって有り得るのか？」と思ったが、上記の通り組み込み関数だと普通に有り得るようだ
                // notice が出るので記述せざるを得ないがその値を得る術がない。が、どうせ与えられないので null でいい
                else {
                    $defval = 'null';
                }
                $default = ' = ' . $defval;
            }
            $varname = ($param->isPassedByReference() ? '&' : '') . '$' . $param->getName();
            $params[] = $varname . $default;
            $args[] = $varname;
        }

        $parts = explode('\\', ltrim($alias, '\\'));
        $reference = $ref->returnsReference() ? '&' : '';
        $funcname = $reference . array_pop($parts);
        $namespace = implode('\\', $parts);

        $params = implode(', ', $params);
        $args = implode(', ', $args);

        $code = <<<CODE
namespace $namespace {
    function $funcname($params) {
        \$return = $reference \\$calllname(...array_slice([$args] + func_get_args(), 0, func_num_args()));
        return \$return;
    }
}
CODE;

        eval($code);
        if ($cachefile) {
            file_put_contents($cachefile, "<?php\n" . $code);
        }
    }
}
if (!isset($excluded_functions['minimum']) && (!function_exists('minimum') || (new \ReflectionFunction('minimum'))->isInternal())) {
    /**
     * 引数の最小値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * assertSame(minimum(-1, 0, 1), -1);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最小値
     */
    function minimum(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        return min($args);
    }
}
if (!isset($excluded_functions['maximum']) && (!function_exists('maximum') || (new \ReflectionFunction('maximum'))->isInternal())) {
    /**
     * 引数の最大値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * assertSame(maximum(-1, 0, 1), 1);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最大値
     */
    function maximum(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        return max($args);
    }
}
if (!isset($excluded_functions['mode']) && (!function_exists('mode') || (new \ReflectionFunction('mode'))->isInternal())) {
    /**
     * 引数の最頻値を返す
     *
     * - 等価比較は文字列で行う。小数時は注意。おそらく php.ini の precision に従うはず
     * - 等価値が複数ある場合の返り値は不定
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * assertSame(mode(0, 1, 2, 2, 3, 3, 3), 3);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最頻値
     */
    function mode(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        $vals = array_map(function ($v) {
            if (is_object($v)) {
                // ここに特別扱いのオブジェクトを列挙していく
                if ($v instanceof \DateTimeInterface) {
                    return $v->getTimestamp();
                }
                // それ以外は stringify へ移譲（__toString もここに含まれている）
                return call_user_func(stringify, $v);
            }
            return (string) $v;
        }, $args);
        $args = array_combine($vals, $args);
        $counts = array_count_values($vals);
        arsort($counts);
        reset($counts);
        return $args[key($counts)];
    }
}
if (!isset($excluded_functions['mean']) && (!function_exists('mean') || (new \ReflectionFunction('mean'))->isInternal())) {
    /**
     * 引数の相加平均値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * assertSame(mean(1, 2, 3, 4, 5, 6), 3.5);
     * assertSame(mean(1, '2', 3, 'noize', 4, 5, 'noize', 6), 3.5);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return int|float 相加平均値
     */
    function mean(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or call_user_func(throws, new \LengthException("argument's must be contain munber."));
        return array_sum($args) / count($args);
    }
}
if (!isset($excluded_functions['median']) && (!function_exists('median') || (new \ReflectionFunction('median'))->isInternal())) {
    /**
     * 引数の中央値を返す
     *
     * - 要素数が奇数の場合は完全な中央値/偶数の場合は中2つの平均。「平均」という概念が存在しない値なら中2つの後の値
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * // 偶数個なので中2つの平均
     * assertSame(median(1, 2, 3, 4, 5, 6), 3.5);
     * // 奇数個なのでど真ん中
     * assertSame(median(1, 2, 3, 4, 5), 3);
     * // 偶数個だが文字列なので中2つの後
     * assertSame(median('a', 'b', 'c', 'd'), 'c');
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 中央値
     */
    function median(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        $count = count($args);
        $center = (int) ($count / 2);
        sort($args);
        // 偶数で共に数値なら平均値
        if ($count % 2 === 0 && (is_numeric($args[$center - 1]) && is_numeric($args[$center]))) {
            return ($args[$center - 1] + $args[$center]) / 2;
        }
        // 奇数なら単純に中央値
        else {
            return $args[$center];
        }
    }
}
if (!isset($excluded_functions['average']) && (!function_exists('average') || (new \ReflectionFunction('average'))->isInternal())) {
    /**
     * 引数の意味平均値を返す
     *
     * - 3座標の重心座標とか日付の平均とかそういうもの
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 意味平均値
     */
    function average(...$variadic)
    {
        // 用意したはいいが統一的なうまい実装が思いつかない（関数ベースじゃ無理だと思う）
        // average は意味平均、mean は相加平均を明示するために定義は残しておく
        assert(is_array($variadic));
        throw new \DomainException('not implement yet.');
    }
}
if (!isset($excluded_functions['sum']) && (!function_exists('sum') || (new \ReflectionFunction('sum'))->isInternal())) {
    /**
     * 引数の合計値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * assertSame(sum(1, 2, 3, 4, 5, 6), 21);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 合計値
     */
    function sum(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or call_user_func(throws, new \LengthException("argument's must be contain munber."));
        return array_sum($args);
    }
}
if (!isset($excluded_functions['random_at']) && (!function_exists('random_at') || (new \ReflectionFunction('random_at'))->isInternal())) {
    /**
     * 引数をランダムで返す
     *
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * srand(1);mt_srand(1);
     * assertSame(random_at(1, 2, 3, 4, 5, 6), 4);
     * assertSame(random_at(1, 2, 3, 4, 5, 6), 1);
     * </code>
     *
     * @package Math
     *
     * @param array $args 候補
     * @return mixed 引数のうちどれか
     */
    function random_at(...$args)
    {
        return $args[mt_rand(0, count($args) - 1)];
    }
}
if (!isset($excluded_functions['probability']) && (!function_exists('probability') || (new \ReflectionFunction('probability'))->isInternal())) {
    /**
     * 一定確率で true を返す
     *
     * 具体的には $probability / $divisor の確率で true を返す。
     * $divisor のデフォルトは 100 にしてあるので、 $probability だけ与えれば $probability パーセントで true を返すことになる。
     *
     * Example:
     * <code>
     * srand(1);mt_srand(1);
     * assertFalse(probability(50));
     * assertTrue(probability(50));
     * </code>
     *
     * @package Math
     *
     * @param int $probability 分子
     * @param int $divisor 分母
     * @return bool true or false
     */
    function probability($probability, $divisor = 100)
    {
        $probability = (int) $probability;
        if ($probability < 0) {
            throw new \InvalidArgumentException('$probability must be positive number.');
        }
        $divisor = (int) $divisor;
        if ($divisor < 0) {
            throw new \InvalidArgumentException('$divisor must be positive number.');
        }
        // 不等号の向きや=の有無が怪しかったのでメモ
        // 1. $divisor に 100 が与えられたとすると、取り得る範囲は 0 ～ 99（100個）
        // 2. $probability が 1 だとするとこの式を満たす数は 0 の1個のみ
        // 3. 100 個中1個なので 1%
        return $probability > mt_rand(0, $divisor - 1);
    }
}
if (!isset($excluded_functions['strcat']) && (!function_exists('strcat') || (new \ReflectionFunction('strcat'))->isInternal())) {
    /**
     * 文字列結合の関数版
     *
     * Example:
     * <code>
     * assertSame(strcat('a', 'b', 'c'), 'abc');
     * </code>
     *
     * @package String
     *
     * @param mixed $variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    function strcat(...$variadic)
    {
        return implode('', $variadic);
    }
}
if (!isset($excluded_functions['split_noempty']) && (!function_exists('split_noempty') || (new \ReflectionFunction('split_noempty'))->isInternal())) {
    /**
     * 空文字を除外する文字列分割
     *
     * - 空文字を任意の区切り文字で分割しても常に空配列
     * - キーは連番で返す（歯抜けがないただの配列）
     *
     * $triming を指定した場合、結果配列にも影響する。
     * つまり「除外は trim したいが結果配列にはしたくない」はできない。
     *
     * Example:
     * <code>
     * assertSame(split_noempty(',', 'a, b, c'), ['a', 'b', 'c']);
     * assertSame(split_noempty(',', 'a, , , b, c'), ['a', 'b', 'c']);
     * assertSame(split_noempty(',', 'a, , , b, c', false), ['a', ' ', ' ', ' b', ' c']);
     * </code>
     *
     * @package String
     *
     * @param string $delimiter 区切り文字
     * @param string $string 対象文字
     * @param string|bool $trimchars 指定した文字を trim する。true を指定すると trim する
     * @return array 指定文字で分割して空文字を除いた配列
     */
    function split_noempty($delimiter, $string, $trimchars = true)
    {
        // trim しないなら preg_split(PREG_SPLIT_NO_EMPTY) で十分
        if (strlen($trimchars) === 0) {
            return preg_split('#' . preg_quote($delimiter, '#') . '#u', $string, -1, PREG_SPLIT_NO_EMPTY);
        }

        // trim するなら preg_split だと無駄にややこしくなるのでベタにやる
        $trim = ($trimchars === true) ? 'trim' : call_user_func(rbind, 'trim', $trimchars);
        $parts = explode($delimiter, $string);
        $parts = array_map($trim, $parts);
        $parts = array_filter($parts, 'strlen');
        $parts = array_values($parts);
        return $parts;
    }
}
if (!isset($excluded_functions['str_equals']) && (!function_exists('str_equals') || (new \ReflectionFunction('str_equals'))->isInternal())) {
    /**
     * 文字列比較の関数版
     *
     * 文字列以外が与えられた場合は常に false を返す。ただし __toString を実装したオブジェクトは別。
     *
     * Example:
     * <code>
     * assertTrue(str_equals('abc', 'abc'));
     * assertTrue(str_equals('abc', 'ABC', true));
     * assertTrue(str_equals('\0abc', '\0abc'));
     * </code>
     *
     * @package String
     *
     * @param string $str1 文字列1
     * @param string $str2 文字列2
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return bool 同じ文字列なら true
     */
    function str_equals($str1, $str2, $case_insensitivity = false)
    {
        // __toString 実装のオブジェクトは文字列化する（strcmp がそうなっているから）
        if (is_object($str1) && method_exists($str1, '__toString')) {
            $str1 = (string) $str1;
        }
        if (is_object($str2) && method_exists($str2, '__toString')) {
            $str2 = (string) $str2;
        }

        // この関数は === の関数版という位置づけなので例外は投げないで不一致とみなす
        if (!is_string($str1) || !is_string($str2)) {
            return false;
        }

        if ($case_insensitivity) {
            return strcasecmp($str1, $str2) === 0;
        }

        return $str1 === $str2;
    }
}
if (!isset($excluded_functions['str_contains']) && (!function_exists('str_contains') || (new \ReflectionFunction('str_contains'))->isInternal())) {
    /**
     * 指定文字列を含むか返す
     *
     * Example:
     * <code>
     * assertTrue(str_contains('abc', 'b'));
     * assertTrue(str_contains('abc', 'B', true));
     * assertTrue(str_contains('abc', ['b', 'x'], false, false));
     * assertFalse(str_contains('abc', ['b', 'x'], false, true));
     * </code>
     *
     * @package String
     *
     * @param string $haystack 対象文字列
     * @param string|array $needle 調べる文字列
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @param bool $and_flag すべて含む場合に true を返すか
     * @return bool $needle を含むなら true
     */
    function str_contains($haystack, $needle, $case_insensitivity = false, $and_flag = false)
    {
        if (!is_array($needle)) {
            $needle = [$needle];
        }

        // あくまで文字列としての判定に徹する（strpos の第2引数は闇が深い気がする）
        $haystack = (string) $haystack;
        $needle = array_map('strval', $needle);

        foreach ($needle as $str) {
            if ($str === '') {
                continue;
            }
            $pos = $case_insensitivity ? stripos($haystack, $str) : strpos($haystack, $str);
            if ($and_flag && $pos === false) {
                return false;
            }
            if (!$and_flag && $pos !== false) {
                return true;
            }
        }
        return !!$and_flag;
    }
}
if (!isset($excluded_functions['str_putcsv']) && (!function_exists('str_putcsv') || (new \ReflectionFunction('str_putcsv'))->isInternal())) {
    /**
     * fputcsv の文字列版（str_getcsv の put 版）
     *
     * 特に難しいことはないシンプルな実装。ただし、エラーは例外に変換される。
     *
     * Example:
     * <code>
     * assertSame(str_putcsv(['a', 'b', 'c']), "a,b,c");
     * assertSame(str_putcsv(['a', 'b', 'c'], "\t"), "a\tb\tc");
     * assertSame(str_putcsv(['a', ' b ', 'c'], " ", "'"), "a ' b ' c");
     * </code>
     *
     * @package String
     *
     * @param array $array 値の配列
     * @param string $delimiter フィールド区切り文字
     * @param string $enclosure フィールドを囲む文字
     * @param string $escape エスケープ文字
     * @return string CSV 文字列
     */
    function str_putcsv($array, $delimiter = ',', $enclosure = '"', $escape = '\\')
    {
        try {
            $fp = fopen('php://memory', 'rw+');
            return call_user_func(call_safely, function ($fp, $array, $delimiter, $enclosure, $escape) {
                if (version_compare(PHP_VERSION, '5.5.4') >= 0) {
                    fputcsv($fp, $array, $delimiter, $enclosure, $escape);
                }
                else {
                    fputcsv($fp, $array, $delimiter, $enclosure); // @codeCoverageIgnore
                }
                rewind($fp);
                $result = stream_get_contents($fp);
                fclose($fp);
                return rtrim($result, "\n");
            }, $fp, $array, $delimiter, $enclosure, $escape);
        }
        catch (\ErrorException $ex) {
            if (isset($fp) && $fp) {
                fclose($fp);
            }
            throw $ex;
        }
    }
}
if (!isset($excluded_functions['str_subreplace']) && (!function_exists('str_subreplace') || (new \ReflectionFunction('str_subreplace'))->isInternal())) {
    /**
     * 指定文字列を置換する
     *
     * $subject 内の $search を $replaces に置換する。
     * str_replace とは「N 番目のみ置換できる」点で異なる。
     * つまり、$subject='hoge', $replace=[2 => 'fuga'] とすると「3 番目の 'hoge' が hoge に置換される」という動作になる（0 ベース）。
     *
     * $replace に空配列を与えると何もしない。
     * 負数キーは後ろから数える動作となる。
     * また、置換後の文字列は置換対象にはならない。
     *
     * N 番目の検索文字列が見つからない場合は例外を投げる。
     *
     * Example:
     * <code>
     * // 1番目（0ベースなので2番目）の x を X に置換
     * assertSame(str_subreplace('xxx', 'x', [1 => 'X']), 'xXx');
     * // 0番目（最前列）の x を Xa に、-1番目（最後尾）の x を Xz に置換
     * assertSame(str_subreplace('!xxx!', 'x', [0 => 'Xa', -1 => 'Xz']), '!XaxXz!');
     * // 置換結果は置換対象にならない
     * assertSame(str_subreplace('xxx', 'x', [0 => 'xxx', 1 => 'X']), 'xxxXx');
     * </code>
     *
     * @package String
     *
     * @param string $subject 対象文字列
     * @param string $search 検索文字列
     * @param array $replaces 置換文字列
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return string 置換された文字列
     */
    function str_subreplace($subject, $search, $replaces, $case_insensitivity = false)
    {
        // 空はそのまま返す
        if (empty($replaces)) {
            return $subject;
        }

        // 負数対応のために逆数計算（ついでに整数チェック）
        $subcount = substr_count($subject, $search);
        $mapping = [];
        foreach ($replaces as $n => $replace) {
            if (!is_int($n)) {
                throw new \InvalidArgumentException('$replaces key must be integer.');
            }
            if ($n < 0) {
                $n += $subcount;
            }
            if ($n < 0) {
                throw new \InvalidArgumentException("notfound search string '$search' of {$n}th.");
            }
            $mapping[$n] = $replace;
        }
        $maxseq = max(array_keys($mapping));
        $offset = 0;
        for ($n = 0; $n <= $maxseq; $n++) {
            $pos = $case_insensitivity ? stripos($subject, $search, $offset) : strpos($subject, $search, $offset);
            if ($pos === false) {
                throw new \InvalidArgumentException("notfound search string '$search' of {$n}th.");
            }
            if (isset($mapping[$n])) {
                $subject = substr_replace($subject, $mapping[$n], $pos, strlen($search));
                $offset = $pos + strlen($mapping[$n]);
            }
            else {
                $offset = $pos + strlen($search);
            }
        }
        return $subject;
    }
}
if (!isset($excluded_functions['str_between']) && (!function_exists('str_between') || (new \ReflectionFunction('str_between'))->isInternal())) {
    /**
     * 指定文字で囲まれた文字列を取得する
     *
     * $from, $to で指定した文字間を取得する（$from, $to 自体は結果に含まれない）。
     * ネストしている場合、一番外側の文字間を返す。
     *
     * $enclosure で「特定文字に囲まれている」場合を無視することができる。
     * $escape で「特定文字が前にある」場合を無視することができる。
     *
     * $position を与えた場合、その場所から走査を開始する。
     * さらに結果があった場合、 $position には「次の走査開始位置」が代入される。
     * これを使用すると連続で「次の文字, 次の文字, ...」と言った動作が可能になる。
     *
     * Example:
     * <code>
     * // $position を利用して "first", "second", "third" を得る（"で囲まれた "blank" は返ってこない）。
     * $n = 0;
     * assertSame(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n), 'first');
     * assertSame(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n), 'second');
     * assertSame(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n), 'third');
     * // ネストしている場合は最も外側を返す
     * assertSame(str_between('{nest1{nest2{nest3}}}', '{', '}'), 'nest1{nest2{nest3}}');
     * </code>
     *
     * @package String
     *
     * @param string $string 対象文字列
     * @param string $from 開始文字列
     * @param string $to 終了文字列
     * @param int $position 開始位置。渡した場合次の開始位置が設定される
     * @param string $enclosure 囲い文字。この文字中にいる $from, $to 文字は走査外になる
     * @param string $escape エスケープ文字。この文字が前にある $from, $to 文字は走査外になる
     * @return string|bool $from, $to で囲まれた文字。見つからなかった場合は false
     */
    function str_between($string, $from, $to, &$position = 0, $enclosure = '\'"', $escape = '\\')
    {
        $strlen = strlen($string);
        $fromlen = strlen($from);
        $tolen = strlen($to);
        $enclosing = null;
        $nesting = 0;
        $start = null;
        for ($i = $position; $i < $strlen; $i++) {
            if ($i !== 0 && $string[$i - 1] === $escape) {
                continue;
            }
            if (strpos($enclosure, $string[$i]) !== false) {
                if ($enclosing === null) {
                    $enclosing = $string[$i];
                }
                elseif ($enclosing === $string[$i]) {
                    $enclosing = null;
                }
                continue;
            }

            // 開始文字と終了文字が重複している可能性があるので $to からチェックする
            if ($enclosing === null && substr_compare($string, $to, $i, $tolen) === 0) {
                if (--$nesting === 0) {
                    $position = $i + $tolen;
                    return substr($string, $start, $i - $start);
                }
                // いきなり終了文字が来た場合は無視する
                if ($nesting < 0) {
                    $nesting = 0;
                }
            }
            if ($enclosing === null && substr_compare($string, $from, $i, $fromlen) === 0) {
                if ($nesting++ === 0) {
                    $start = $i + $fromlen;
                }
            }
        }
        return false;
    }
}
if (!isset($excluded_functions['starts_with']) && (!function_exists('starts_with') || (new \ReflectionFunction('starts_with'))->isInternal())) {
    /**
     * 指定文字列で始まるか調べる
     *
     * Example:
     * <code>
     * assertTrue(starts_with('abcdef', 'abc'));
     * assertTrue(starts_with('abcdef', 'ABC', true));
     * assertFalse(starts_with('abcdef', 'xyz'));
     * </code>
     *
     * @package String
     *
     * @param string $string 探される文字列
     * @param string $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return bool 指定文字列で始まるなら true を返す
     */
    function starts_with($string, $with, $case_insensitivity = false)
    {
        assert('is_string($string)');
        assert('is_string($with)');
        assert('strlen($with)');

        return call_user_func(str_equals, substr($string, 0, strlen($with)), $with, $case_insensitivity);
    }
}
if (!isset($excluded_functions['ends_with']) && (!function_exists('ends_with') || (new \ReflectionFunction('ends_with'))->isInternal())) {
    /**
     * 指定文字列で終わるか調べる
     *
     * Example:
     * <code>
     * assertTrue(ends_with('abcdef', 'def'));
     * assertTrue(ends_with('abcdef', 'DEF', true));
     * assertFalse(ends_with('abcdef', 'xyz'));
     * </code>
     *
     * @package String
     *
     * @param string $string 探される文字列
     * @param string $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return bool 対象文字列で終わるなら true
     */
    function ends_with($string, $with, $case_insensitivity = false)
    {
        assert('is_string($string)');
        assert('is_string($with)');
        assert('strlen($with)');

        return call_user_func(str_equals, substr($string, -strlen($with)), $with, $case_insensitivity);
    }
}
if (!isset($excluded_functions['camel_case']) && (!function_exists('camel_case') || (new \ReflectionFunction('camel_case'))->isInternal())) {
    /**
     * camelCase に変換する
     *
     * Example:
     * <code>
     * assertSame(camel_case('this_is_a_pen'), 'thisIsAPen');
     * </code>
     *
     * @package String
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function camel_case($string, $delimiter = '_')
    {
        return lcfirst(call_user_func(pascal_case, $string, $delimiter));
    }
}
if (!isset($excluded_functions['pascal_case']) && (!function_exists('pascal_case') || (new \ReflectionFunction('pascal_case'))->isInternal())) {
    /**
     * PascalCase に変換する
     *
     * Example:
     * <code>
     * assertSame(pascal_case('this_is_a_pen'), 'ThisIsAPen');
     * </code>
     *
     * @package String
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function pascal_case($string, $delimiter = '_')
    {
        return strtr(ucwords(strtr($string, [$delimiter => ' '])), [' ' => '']);
    }
}
if (!isset($excluded_functions['snake_case']) && (!function_exists('snake_case') || (new \ReflectionFunction('snake_case'))->isInternal())) {
    /**
     * snake_case に変換する
     *
     * Example:
     * <code>
     * assertSame(snake_case('ThisIsAPen'), 'this_is_a_pen');
     * </code>
     *
     * @package String
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function snake_case($string, $delimiter = '_')
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', $delimiter . '\0', $string)), $delimiter);
    }
}
if (!isset($excluded_functions['chain_case']) && (!function_exists('chain_case') || (new \ReflectionFunction('chain_case'))->isInternal())) {
    /**
     * chain-case に変換する
     *
     * Example:
     * <code>
     * assertSame(chain_case('ThisIsAPen'), 'this-is-a-pen');
     * </code>
     *
     * @package String
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function chain_case($string, $delimiter = '-')
    {
        return call_user_func(snake_case, $string, $delimiter);
    }
}
if (!isset($excluded_functions['random_string']) && (!function_exists('random_string') || (new \ReflectionFunction('random_string'))->isInternal())) {
    /**
     * 安全な乱数文字列を生成する
     *
     * 下記のいずれかを記述順の優先度で使用する。
     *
     * - random_bytes: 汎用だが php7 以降のみ
     * - openssl_random_pseudo_bytes: openSsl が必要
     * - mcrypt_create_iv: Mcrypt が必要
     *
     * @package String
     *
     * @param int $length 生成文字列長
     * @param string $charlist 使用する文字セット
     * @return string 乱数文字列
     */
    function random_string($length = 8, $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        // テスト＋カバレッジのための隠し引数
        /** @noinspection PhpUnusedLocalVariableInspection */
        $args = func_get_args();
        $pf = true;

        assert('$pf = count($args) > 2 ? $args[2] : true;');

        if ($length <= 0) {
            throw new \InvalidArgumentException('$length must be positive number.');
        }

        $charlength = strlen($charlist);
        if ($charlength === 0) {
            throw new \InvalidArgumentException('charlist is empty.');
        }

        // 使えるなら最も優秀なはず
        if ((function_exists('random_bytes') && $pf === true) || $pf === 'random_bytes') {
            $bytes = random_bytes($length);
        }
        // 次点
        elseif ((function_exists('openssl_random_pseudo_bytes') && $pf === true) || $pf === 'openssl_random_pseudo_bytes') {
            $bytes = openssl_random_pseudo_bytes($length, $crypto_strong);
            if ($crypto_strong === false) {
                throw new \Exception('failed to random_string ($crypto_strong is false).');
            }
        }
        // よく分からない？
        elseif ((function_exists('mcrypt_create_iv') && $pf === true) || $pf === 'mcrypt_create_iv') {
            /** @noinspection PhpDeprecationInspection */
            $bytes = mcrypt_create_iv($length);
        }
        // どれもないなら例外
        else {
            throw new \Exception('failed to random_string (enabled function is not exists).');
        }

        if (strlen($bytes) === 0) {
            throw new \Exception('failed to random_string (bytes length is 0).');
        }

        // 1文字1バイト使う。文字種によっては出現率に差が出るがう～ん
        $string = '';
        foreach (str_split($bytes) as $byte) {
            $string .= $charlist[ord($byte) % $charlength];
        }
        return $string;
    }
}
if (!isset($excluded_functions['kvsprintf']) && (!function_exists('kvsprintf') || (new \ReflectionFunction('kvsprintf'))->isInternal())) {
    /**
     * 連想配列を指定できるようにした vsprintf
     *
     * sprintf の順序指定構文('%1$d')にキーを指定できる。
     *
     * Example:
     * <code>
     * assertSame(kvsprintf('%hoge$s %fuga$d', ['hoge' => 'ThisIs', 'fuga' => '3.14']), 'ThisIs 3');
     * </code>
     *
     * @package String
     *
     * @param string $format フォーマット文字列
     * @param array $array フォーマット引数
     * @return string フォーマットされた文字列
     */
    function kvsprintf($format, $array)
    {
        $keys = array_flip(array_keys($array));
        $vals = array_values($array);

        $format = preg_replace_callback('#%%|%(.*?)\$#u', function ($m) use ($keys) {
            if (!isset($m[1])) {
                return $m[0];
            }

            $w = $m[1];
            if (!isset($keys[$w])) {
                throw new \OutOfBoundsException("kvsprintf(): Undefined index: $w");
            }

            return '%' . ($keys[$w] + 1) . '$';

        }, $format);

        return vsprintf($format, $vals);
    }
}
if (!isset($excluded_functions['preg_capture']) && (!function_exists('preg_capture') || (new \ReflectionFunction('preg_capture'))->isInternal())) {
    /**
     * キャプチャを主軸においた preg_match
     *
     * $pattern で $subject をマッチングして $default で埋めて返す。$default はフィルタも兼ねる。
     * 空文字マッチは「マッチしていない」とみなすので注意（$default が使用される）。
     *
     * キャプチャを主軸においているので「マッチしなかった」は検出不可能。
     * $default がそのまま返ってくる。
     *
     * Example:
     * <code>
     * $pattern = '#(\d{4})/(\d{1,2})(/(\d{1,2}))?#';
     * $default = [1 => '2000', 2 => '1', 4 => '1'];
     * // 完全にマッチするのでそれぞれ返ってくる
     * assertSame(preg_capture($pattern, '2014/12/24', $default), [1 => '2014', 2 => '12', 4 => '24']);
     * // 最後の \d{1,2} はマッチしないのでデフォルト値が使われる
     * assertSame(preg_capture($pattern, '2014/12', $default), [1 => '2014', 2 => '12', 4 => '1']);
     * // 一切マッチしないので全てデフォルト値が使われる
     * assertSame(preg_capture($pattern, 'hoge', $default), [1 => '2000', 2 => '1', 4 => '1']);
     * </code>
     *
     * @package String
     *
     * @param string $pattern 正規表現
     * @param string $subject 対象文字列
     * @param array $default デフォルト値
     * @return array キャプチャした配列
     */
    function preg_capture($pattern, $subject, $default)
    {
        preg_match($pattern, $subject, $matches);

        foreach ($matches as $n => $match) {
            if (array_key_exists($n, $default) && strlen($match)) {
                $default[$n] = $match;
            }
        }

        return $default;
    }
}
if (!isset($excluded_functions['render_string']) && (!function_exists('render_string') || (new \ReflectionFunction('render_string'))->isInternal())) {
    /**
     * "hoge {$hoge}" 形式のレンダリング
     *
     * 文字列を eval して "hoge {$hoge}" 形式の文字列に変数を埋め込む。
     * 基本処理は `eval("return '" . addslashes($template) . "';");` と考えて良いが、下記が異なる。
     *
     * - 数値キーが参照できる
     * - クロージャは呼び出し結果が埋め込まれる。引数は (変数配列, 自身のキー文字列)
     * - 引数をそのまま返すだけの特殊な変数 $_ が宣言される
     * - シングルクォートのエスケープは外される
     *
     * $_ が宣言されるのは変数配列に '_' を含んでいないときのみ（上書きを防止するため）。
     * この $_ は php の埋め込み変数の闇を利用するととんでもないことが出来たりする（サンプルやテストコードを参照）。
     *
     * ダブルクオートはエスケープされるので文字列からの脱出はできない。
     * また、 `{$_(syntax(""))}` のように {$_()} 構文で " も使えなくなるので \' を使用しなければならない。
     *
     * Example:
     * <code>
     * // 数値キーが参照できる
     * assertSame(render_string('${0}', ['number']), 'number');
     * // クロージャは呼び出し結果が埋め込まれる
     * assertSame(render_string('$c', ['c' => function($vars, $k){return $k . '-closure';}]), 'c-closure');
     * // 引数をそのまま返すだけの特殊な変数 $_ が宣言される
     * assertSame(render_string('{$_(123 + 456)}', []), '579');
     * // 要するに '$_()' の中に php の式が書けるようになる
     * assertSame(render_string('{$_(implode(\',\', $strs))}', ['strs' => ['a', 'n', 'z']]), 'a,n,z');
     * assertSame(render_string('{$_(max($nums))}', ['nums' => [1, 9, 3]]), '9');
     * </code>
     *
     * @package String
     *
     * @param string $template レンダリング文字列
     * @param array $array レンダリング変数
     * @return string レンダリングされた文字列
     */
    function render_string($template, $array)
    {
        // eval 可能な形式に変換
        $evalcode = 'return "' . addcslashes($template, "\"\\\0") . '";';

        // 利便性を高めるために変数配列を少しいじる
        $vars = [];
        foreach ($array as $k => $v) {
            // クロージャはその実行結果を埋め込む仕様
            if ($v instanceof \Closure) {
                $v = $v($array, $k);
            }
            $vars[$k] = $v;
        }
        // '_' はそのまま返すクロージャとする（キーがないときのみ）
        if (!array_key_exists('_', $vars)) {
            $vars['_'] = function ($v) { return $v; };
        }

        try {
            $return = call_user_func(function () {
                // extract は数値キーを展開してくれないので自前ループで展開
                foreach (func_get_arg(1) as $k => $v) {
                    $$k = $v;
                }
                // 現スコープで宣言してしまっているので伏せなければならない
                unset($k, $v);
                // かと言って変数配列に k, v キーがあると使えなくなるので更に extract で補完
                extract(func_get_arg(1));
                // そして eval. ↑は要するに数値キーのみを展開している
                return eval(func_get_arg(0));
            }, $evalcode, $vars);
        }
            /** @noinspection PhpUndefinedClassInspection */
        catch (\ParseError $ex) {
            // for php 7
            $return = false;
        }

        if ($return === false) {
            throw new \RuntimeException('failed to eval code.' . $evalcode);
        }

        return $return;
    }
}
if (!isset($excluded_functions['render_file']) && (!function_exists('render_file') || (new \ReflectionFunction('render_file'))->isInternal())) {
    /**
     * "hoge {$hoge}" 形式のレンダリングのファイル版
     *
     * @package String
     *
     * @see render_string
     *
     * @param string $template_file レンダリングするファイル名
     * @param array $array レンダリング変数
     * @return string レンダリングされた文字列
     */
    function render_file($template_file, $array)
    {
        return call_user_func(render_string, file_get_contents($template_file), $array);
    }
}
if (!isset($excluded_functions['returns']) && (!function_exists('returns') || (new \ReflectionFunction('returns'))->isInternal())) {
    /**
     * 引数をそのまま返す
     *
     * clone などでそのまま返す関数が欲しいことがまれによくあるはず。
     *
     * Example:
     * <code>
     * $object = new \stdClass();
     * assertSame(returns($object), $object);
     * </code>
     *
     * @package Syntax
     *
     * @param mixed $v return する値
     * @return mixed $v を返す
     */
    function returns($v)
    {
        return $v;
    }
}
if (!isset($excluded_functions['optional']) && (!function_exists('optional') || (new \ReflectionFunction('optional'))->isInternal())) {
    /**
     * オブジェクトならそれを、オブジェクトでないなら NullObject を返す
     *
     * null を返すかもしれないステートメントを一時変数を介さずワンステートメントで呼ぶことが可能になる。
     * 基本的には null を返すが、return type が規約されている場合は null 以外を返すこともある。
     *
     * 取得系呼び出しを想定しているので、設定系呼び出しは行うべきではない。
     * __set のような明らかに設定が意図されているものは例外が飛ぶ。
     *
     * Example:
     * <code>
     * // null を返すかもしれないステートメント
     * $getobject = function () {return null;};
     * // メソッド呼び出しは null を返す
     * assertSame(optional($getobject())->method(), null);
     * // プロパティアクセスは null を返す
     * assertSame(optional($getobject())->property, null);
     * // empty は true を返す
     * assertSame(empty(optional($getobject())->nothing), true);
     * // __isset は false を返す
     * assertSame(isset(optional($getobject())->nothing), false);
     * // __toString は '' を返す
     * assertSame(strval(optional($getobject())), '');
     * // __invoke は null を返す
     * assertSame(call_user_func(optional($getobject())), null);
     * // 配列アクセスは null を返す
     * assertSame($getobject()['hoge'], null);
     * // 空イテレータを返す
     * assertSame(iterator_to_array(optional($getobject())), []);
     *
     * // $expected を与えるとその型以外は NullObject を返す（\ArrayObject はオブジェクトだが stdClass ではない）
     * assertSame(optional(new \ArrayObject([1]), 'stdClass')->count(), null);
     * </code>
     *
     * @package Syntax
     *
     * @param object|null $object オブジェクト
     * @param string $expected 期待するクラス名。指定した場合は is_a される
     * @return mixed $object がオブジェクトならそのまま返し、違うなら NullObject を返す
     */
    function optional($object, $expected = NULL)
    {
        if (is_object($object)) {
            if ($expected === null || is_a($object, $expected)) {
                return $object;
            }
        }

        static $nullobject = null;
        if ($nullobject === null) {
            // @formatter:off
            $declare = <<<'NO'
            class NULLObject implements \ArrayAccess, \IteratorAggregate
            {
                public function __isset($name) { return false; }
                public function __get($name) { return null; }
                public function __set($name, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __unset($name) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __call($name, $arguments) { return null; }
                public function __invoke() { return null; }
                public function __toString() { return ''; }
                public function offsetExists($offset) { return false; }
                public function offsetGet($offset) { return null; }
                public function offsetSet($offset, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function offsetUnset($offset) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function getIterator() { return new \ArrayIterator([]); }
            }
            return new NULLObject();
NO;

            $nullobject = eval("$declare;");
            // @formatter:on
        }
        return $nullobject;
    }
}
if (!isset($excluded_functions['throws']) && (!function_exists('throws') || (new \ReflectionFunction('throws'))->isInternal())) {
    /**
     * throw の関数版
     *
     * hoge() or throw などしたいことがまれによくあるはず。
     *
     * Example:
     * <code>
     * try {
     *     throws(new \Exception('throws'));
     * }
     * catch (\Exception $ex) {
     *     assertSame($ex->getMessage(), 'throws');
     * }
     * </code>
     *
     * @package Syntax
     *
     * @param \Exception $ex 投げる例外
     */
    function throws($ex)
    {
        throw $ex;
    }
}
if (!isset($excluded_functions['ifelse']) && (!function_exists('ifelse') || (new \ReflectionFunction('ifelse'))->isInternal())) {
    /**
     * if ～ else 構文の関数版
     *
     * 一言で言えば `$actual === $expected ? $then : $else` という動作になる。
     * ただし、 $expected が callable の場合は呼び出した結果を緩い bool 判定する。
     * つまり `ifelse('hoge', 'is_string', true, false)` は常に true を返すので注意。
     *
     * ?? 演算子があれば大抵の状況で不要だが、=== null 限定ではなく 他の値で判定したい場合などには使える。
     *
     * Example:
     * <code>
     * // とても処理が遅い関数。これの返り値が「false ならばデフォルト値、でなければ自身値」という処理が下記のように書ける（一時変数が不要）
     * $heavyfunc = function($v){return $v;};
     * // $heavyfunc(1) ?? 'default' とほぼ同義
     * assertSame(ifelse($heavyfunc(1), false, 'default'), $heavyfunc(1));
     * // $heavyfunc(null) ?? 'default' とほぼ同義…ではない。厳密な比較で false ではないので第1引数を返す
     * assertSame(ifelse($heavyfunc(null), false, 'default'), $heavyfunc(null));
     * // $heavyfunc(false) ?? 'default' とほぼ同義…ではない。厳密な比較で false なので 'default' を返す
     * assertSame(ifelse($heavyfunc(false), false, 'default'), 'default');
     * </code>
     *
     * @package Syntax
     *
     * @param mixed $actual 調べる値（左辺値）
     * @param mixed $expected 比較する値（右辺値）
     * @param mixed $then 真の場合の値
     * @param mixed $else 偽の場合の値。省略時は $actual
     * @return mixed $then or $else
     */
    function ifelse($actual, $expected, $then, $else = NULL)
    {
        // $else 省略時は $actual を返す
        if (func_num_args() === 3) {
            $else = $actual;
        }

        if (is_callable($expected)) {
            return $expected($actual) ? $then : $else;
        }
        return $expected === $actual ? $then : $else;
    }
}
if (!isset($excluded_functions['try_catch']) && (!function_exists('try_catch') || (new \ReflectionFunction('try_catch'))->isInternal())) {
    /**
     * try ～ catch 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * <code>
     * // 例外が飛ばない場合は平和極まりない
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_catch($try, null, 1, 2, 3), [1, 2, 3]);
     * // 例外が飛ぶ場合は特殊なことをしなければ例外オブジェクトが返ってくる
     * $try = function(){throw new \Exception('tried');};
     * assertSame(try_catch($try)->getMessage(), 'tried');
     * </code>
     *
     * @package Syntax
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_catch($try, $catch = NULL, ...$variadic)
    {
        return call_user_func(try_catch_finally, $try, $catch, null, ...$variadic);
    }
}
if (!isset($excluded_functions['try_finally']) && (!function_exists('try_finally') || (new \ReflectionFunction('try_finally'))->isInternal())) {
    /**
     * try ～ finally 構文の関数版
     *
     * 例外は投げっぱなす。例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * <code>
     * $finally_count = 0;
     * $finally = function()use(&$finally_count){$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_finally($try, $finally, 1, 2, 3), [1, 2, 3]);
     * assertSame($finally_count, 1); // 呼ばれている
     * // 例外は投げっぱなすが、 $finally は実行される
     * $try = function(){throw new \Exception('tried');};
     * try {try_finally($try, $finally, 1, 2, 3);} catch(\Exception $e){};
     * assertSame($finally_count, 2); // 呼ばれている
     * </code>
     *
     * @package Syntax
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_finally($try, $finally = NULL, ...$variadic)
    {
        return call_user_func(try_catch_finally, $try, throws, $finally, ...$variadic);
    }
}
if (!isset($excluded_functions['try_catch_finally']) && (!function_exists('try_catch_finally') || (new \ReflectionFunction('try_catch_finally'))->isInternal())) {
    /**
     * try ～ catch ～ finally 構文の関数版
     *
     * php < 5.5 にはないし、例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * <code>
     * $finally_count = 0;
     * $finally = function()use(&$finally_count){$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_catch_finally($try, null, $finally, 1, 2, 3), [1, 2, 3]);
     * assertSame($finally_count, 1); // 呼ばれている
     * // 例外を投げるが、 $catch で握りつぶす
     * $try = function(){throw new \Exception('tried');};
     * assertSame(try_catch_finally($try, null, $finally, 1, 2, 3)->getMessage(), 'tried');
     * assertSame($finally_count, 2); // 呼ばれている
     * </code>
     *
     * @package Syntax
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @param callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_catch_finally($try, $catch = NULL, $finally = NULL, ...$variadic)
    {
        if ($catch === null) {
            $catch = function ($v) { return $v; };
        }

        try {
            return $try(...$variadic);
        }
        catch (\Exception $tried_ex) {
            try {
                return $catch($tried_ex);
            }
            catch (\Exception $catched_ex) {
                throw $catched_ex;
            }
        }
        finally {
            if ($finally !== null) {
                $finally();
            }
        }
    }
}
if (!isset($excluded_functions['cache']) && (!function_exists('cache') || (new \ReflectionFunction('cache'))->isInternal())) {
    /**
     * シンプルにキャッシュする
     *
     * この関数は get/set を兼ねる。
     * キャッシュがある場合はそれを返し、ない場合は $provider を呼び出してその結果をキャッシュしつつそれを返す。
     *
     * 内部キャッシュオブジェクトがあるならそれを使う。その場合リクエストを跨いでキャッシュされる。
     * 内部キャッシュオブジェクトがないあるいは $use_internal=false なら素の static 変数でキャッシュする。
     *
     * $provider に null を与えるとキャッシュの削除となる。
     *
     * Example:
     * <code>
     * $provider = function(){return rand();};
     * // 乱数を返す処理だが、キャッシュされるので同じ値になる
     * $rand1 = cache('rand', $provider);
     * $rand2 = cache('rand', $provider);
     * assertSame($rand1, $rand2);
     * // $provider に null を与えると削除される
     * cache('rand', null);
     * $rand3 = cache('rand', $provider);
     * assertNotSame($rand1, $rand3);
     * </code>
     *
     * @package Utility
     *
     * @param string $key キャッシュのキー
     * @param callable $provider キャッシュがない場合にコールされる callable
     * @param string $namespace 名前空間
     * @param bool $use_internal 内部キャッシュオブジェクトを使うか
     * @return mixed キャッシュ
     */
    function cache($key, $provider, $namespace = NULL, $use_internal = true)
    {
        if ($namespace === null) {
            $namespace = __FILE__;
        }

        // 内部オブジェクトが使えるなら使う
        if ($use_internal && class_exists(\ryunosuke\Functions\Cacher::class)) {
            if ($provider === null) {
                return \ryunosuke\Functions\Cacher::delete($namespace, $key);
            }
            return \ryunosuke\Functions\Cacher::put($namespace, $key, $provider);
        }

        static $cache = [];
        if ($provider === null) {
            $return = isset($cache[$namespace][$key]);
            unset($cache[$namespace][$key]);
            return $return;
        }
        if (!isset($cache[$namespace])) {
            $cache[$namespace] = [];
        }
        if (!array_key_exists($key, $cache[$namespace])) {
            $cache[$namespace][$key] = $provider();
        }
        return $cache[$namespace][$key];
    }
}
if (!isset($excluded_functions['benchmark']) && (!function_exists('benchmark') || (new \ReflectionFunction('benchmark'))->isInternal())) {
    /**
     * 簡易ベンチマークを取る
     *
     * 「指定ミリ秒内で何回コールできるか？」でベンチする。
     *
     * $suite は ['表示名' => $callable] 形式の配列。
     * 表示名が与えられていない場合、それらしい名前で表示する。
     *
     * Example:
     * <code>
     * // intval と int キャストはどちらが早いか調べる
     * benchmark([
     *     'intval',
     *     'intcast' => function($v){return (int)$v;},
     * ], ['12345'], 10);
     * </code>
     *
     * @package Utility
     *
     * @param array|callable $suite ベンチ対象処理
     * @param array $args 各ケースに与えられる引数
     * @param int $millisec 呼び出しミリ秒
     * @param bool $output true だと標準出力に出力される
     * @return array ベンチ結果の配列
     */
    function benchmark($suite, $args = [], $millisec = 1000, $output = true)
    {
        $benchset = [];
        foreach (call_user_func(arrayize, $suite) as $name => $caller) {
            if (!is_callable($caller, false, $callname)) {
                throw new \InvalidArgumentException('caller is not callable.');
            }

            if (is_int($name)) {
                // クロージャは "Closure::__invoke" になるので "ファイル#開始行-終了行" にする
                if ($caller instanceof \Closure) {
                    $ref = new \ReflectionFunction($caller);
                    $callname = $ref->getFileName() . '#' . $ref->getStartLine() . '-' . $ref->getEndLine();
                }
                $name = $callname;
            }

            if (isset($benchset[$name])) {
                throw new \InvalidArgumentException('duplicated benchname.');
            }

            $benchset[$name] = call_user_func(closurize, $caller);
        }

        if (!$benchset) {
            throw new \InvalidArgumentException('benchset is empty.');
        }

        // ウォームアップ兼検証（大量に実行してエラーの嵐になる可能性があるのでウォームアップの時点でエラーがないかチェックする）
        $assertions = call_user_func(call_safely, function ($benchset, $args) {
            return call_user_func(array_lmap, $benchset, 'call_user_func_array', $args);
        }, $benchset, $args);

        // 返り値の検証（ベンチマークという性質上、基本的に戻り値が一致しないのはおかしい）
        // rand/mt_rand, md5/sha1 のような例外はあるが、そんなのベンチしないし、クロージャでラップすればいいし、それでも邪魔なら @ で黙らせればいい
        foreach ($assertions as $name1 => $return1) {
            foreach ($assertions as $name2 => $return2) {
                if ($return1 !== null && $return2 !== null && $return1 !== $return2) {
                    $returns1 = call_user_func(stringify, $return1);
                    $returns2 = call_user_func(stringify, $return2);
                    trigger_error("Results of $name1 and $name2 are different. ($returns1, $returns2)");
                }
            }
        }

        // ベンチ
        $counts = [];
        foreach ($benchset as $name => $caller) {
            $end = microtime(true) + $millisec / 1000;
            for ($n = 0; microtime(true) <= $end; $n++) {
                call_user_func_array($caller, $args);
            }
            $counts[$name] = $n;
        }

        // 結果配列
        $result = [];
        $maxcount = max($counts);
        arsort($counts);
        foreach ($counts as $name => $count) {
            $result[] = [
                'name'   => $name,
                'called' => $count,
                'mills'  => $millisec / $count,
                'ratio'  => $count / $maxcount,
            ];
        }

        // 出力するなら出力
        if ($output) {
            $nlength = max(5, max(array_map('strlen', array_keys($benchset))));
            $slength = 9;
            $olength = 12;
            $rlength = 6;
            $defformat = "| %-{$nlength}s | %{$slength}s | %{$olength}s | %{$rlength}s |";
            $sepformat = "| %'-{$nlength}s | %'-{$slength}s:| %'-{$olength}s:| %'-{$rlength}s:|";

            $template = <<<'RESULT'
Running %count$s cases (between %millsec$s ms):
%header$s
%separator$s
%summary$s

RESULT;
            echo call_user_func(kvsprintf, $template, [
                'count'     => count($benchset),
                'millsec'   => number_format($millisec),
                'header'    => sprintf($defformat, 'name', 'called', '1 call(ms)', 'ratio'),
                'separator' => sprintf($sepformat, '', '', '', ''),
                'summary'   => implode("\n", array_map(function ($data) use ($defformat) {
                    return vsprintf($defformat, [
                            $data['name'],
                            number_format($data['called']),
                            number_format($data['mills'] * 1000, 6),
                            number_format($data['ratio'], 3),
                        ]
                    );
                }, $result)),
            ]);
        }

        return $result;
    }
}
if (!isset($excluded_functions['stringify']) && (!function_exists('stringify') || (new \ReflectionFunction('stringify'))->isInternal())) {
    /**
     * 値を何とかして文字列化する
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * @package Var
     *
     * @param mixed $var 文字列化する値
     * @return string $var を文字列化したもの
     */
    function stringify($var)
    {
        $type = gettype($var);
        switch ($type) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return $var ? 'true' : 'false';
            case 'array':
                return call_user_func(var_export2, $var, true);
            case 'object':
                if (method_exists($var, '__toString')) {
                    return (string) $var;
                }
                if ($var instanceof \Serializable) {
                    return serialize($var);
                }
                if ($var instanceof \JsonSerializable) {
                    return get_class($var) . ':' . json_encode($var, JSON_UNESCAPED_UNICODE);
                }
                return get_class($var);

            default:
                return (string) $var;
        }
    }
}
if (!isset($excluded_functions['numberify']) && (!function_exists('numberify') || (new \ReflectionFunction('numberify'))->isInternal())) {
    /**
     * 値を何とかして数値化する
     *
     * - 配列は要素数
     * - int/float はそのまま（ただし $decimal に応じた型にキャストされる）
     * - resource はリソースID（php 標準の int キャスト）
     * - null/bool はその int 値（php 標準の int キャストだが $decimal を見る）
     * - それ以外（文字列・オブジェクト）は文字列表現から数値以外を取り除いたもの
     *
     * 文字列・オブジェクト以外の変換は互換性を考慮しない。頻繁に変更される可能性がある（特に配列）。
     *
     * -記号は受け入れるが+記号は受け入れない。
     *
     * Example:
     * <code>
     * // 配列は要素数となる
     * assertSame(numberify([1, 2, 3]), 3);
     * // int/float は基本的にそのまま
     * assertSame(numberify(123), 123);
     * assertSame(numberify(123.45), 123);
     * assertSame(numberify(123.45, true), 123.45);
     * // 文字列は数値抽出
     * assertSame(numberify('a1b2c3'), 123);
     * assertSame(numberify('a1b2.c3', true), 12.3);
     * </code>
     *
     * @package Var
     *
     * @param string $var 対象の値
     * @param bool $decimal 小数として扱うか
     * @return int|float 数値化した値
     */
    function numberify($var, $decimal = false)
    {
        // resource はその int 値を返す
        if (is_resource($var)) {
            return (int) $var;
        }

        // 配列は要素数を返す・・・が、$decimal を見るので後段へフォールスルー
        if (is_array($var)) {
            $var = count($var);
        }
        // null/bool はその int 値を返す・・・が、$decimal を見るので後段へフォールスルー
        if ($var === null || $var === false || $var === true) {
            $var = (int) $var;
        }

        // int はそのまま返す・・・と言いたいところだが $decimal をみてキャストして返す
        if (is_int($var)) {
            if ($decimal) {
                $var = (float) $var;
            }
            return $var;
        }
        // float はそのまま返す・・・と言いたいところだが $decimal をみてキャストして返す
        if (is_float($var)) {
            if (!$decimal) {
                $var = (int) $var;
            }
            return $var;
        }

        // 上記以外は文字列として扱い、数値のみでフィルタする（__toString 未実装は標準に任せる。多分 fatal error）
        $number = preg_replace("#[^-.0-9]#u", '', $var);

        // 正規表現レベルでチェックもできそうだけど大変な匂いがするので is_numeric に日和る
        if (!is_numeric($number)) {
            throw new \UnexpectedValueException("$var to $number, this is not numeric.");
        }

        if ($decimal) {
            return (float) $number;
        }
        return (int) $number;
    }
}
if (!isset($excluded_functions['is_primitive']) && (!function_exists('is_primitive') || (new \ReflectionFunction('is_primitive'))->isInternal())) {
    /**
     * 値が複合型でないか検査する
     *
     * 「複合型」とはオブジェクトと配列のこと。
     * つまり
     *
     * - is_scalar($var) || is_null($var) || is_resource($var)
     *
     * と同義（!is_array($var) && !is_object($var) とも言える）。
     *
     * Example:
     * <code>
     * assertTrue(is_primitive(null));
     * assertTrue(is_primitive(false));
     * assertTrue(is_primitive(123));
     * assertTrue(is_primitive(STDIN));
     * assertFalse(is_primitive(new \stdClass));
     * assertFalse(is_primitive(['array']));
     * </code>
     *
     * @package Var
     *
     * @param mixed $var 調べる値
     * @return bool 複合型なら false
     */
    function is_primitive($var)
    {
        return is_scalar($var) || is_null($var) || is_resource($var);
    }
}
if (!isset($excluded_functions['is_recursive']) && (!function_exists('is_recursive') || (new \ReflectionFunction('is_recursive'))->isInternal())) {
    /**
     * 変数が再帰参照を含むか調べる
     *
     * Example:
     * <code>
     * // 配列の再帰
     * $array = [];
     * $array['recursive'] = &$array;
     * assertTrue(is_recursive($array));
     * // オブジェクトの再帰
     * $object = new \stdClass();
     * $object->recursive = $object;
     * assertTrue(is_recursive($object));
     * </code>
     *
     * @package Var
     *
     * @param mixed $var 調べる値
     * @return bool 再帰参照を含むなら true
     */
    function is_recursive($var)
    {
        $core = function ($var, $parents) use (&$core) {
            // 複合型でないなら間違いなく false
            if (call_user_func(is_primitive, $var)) {
                return false;
            }

            // 「親と同じ子」は再帰以外あり得ない。よって === で良い（オブジェクトに関してはそもそも等値比較で絶対に一致しない）
            // sql_object_hash とか serialize でキーに保持して isset の方が速いか？
            // → ベンチ取ったところ in_array の方が10倍くらい速い。多分生成コストに起因
            // raw な比較であれば瞬時に比較できるが、isset だと文字列化が必要でかなり無駄が生じていると考えられる
            foreach ($parents as $parent) {
                if ($parent === $var) {
                    return true;
                }
            }

            // 全要素を再帰的にチェック
            $parents[] = $var;
            foreach ($var as $k => $v) {
                if ($core($v, $parents)) {
                    return true;
                }
            }
            return false;
        };
        return $core($var, []);
    }
}
if (!isset($excluded_functions['var_type']) && (!function_exists('var_type') || (new \ReflectionFunction('var_type'))->isInternal())) {
    /**
     * 値の型を取得する（gettype + get_class）
     *
     * プリミティブ型（gettype で得られるやつ）はそのまま、オブジェクトのときのみクラス名を返す。
     * ただし、オブジェクトの場合は先頭に '\\' が必ず付く。
     *
     * Example:
     * <code>
     * // プリミティブ型は gettype と同義
     * assertSame(var_type(false), 'boolean');
     * assertSame(var_type(123), 'integer');
     * assertSame(var_type(3.14), 'double');
     * assertSame(var_type([1, 2, 3]), 'array');
     * // オブジェクトは型名を返す
     * assertSame(var_type(new \stdClass), '\\stdClass');
     * assertSame(var_type(new \Exception()), '\\Exception');
     * </code>
     *
     * @package Var
     *
     * @param mixed $var 型を取得する値
     * @return string 型名
     */
    function var_type($var)
    {
        if (is_object($var)) {
            return '\\' . get_class($var);
        }
        return gettype($var);
    }
}
if (!isset($excluded_functions['var_export2']) && (!function_exists('var_export2') || (new \ReflectionFunction('var_export2'))->isInternal())) {
    /**
     * 組み込みの var_export をいい感じにしたもの
     *
     * 下記の点が異なる。
     *
     * - 配列は 5.4 以降のショートシンタックス（[]）で出力
     * - インデントは 4 固定
     * - ただの配列は1行（[1, 2, 3]）でケツカンマなし、連想配列は桁合わせインデントでケツカンマあり
     * - null は null（小文字）
     * - 再帰構造を渡しても警告がでない（さらに NULL ではなく `'*RECURSION*'` という文字列になる）
     * - 配列の再帰構造の出力が異なる（Example参照）
     *
     * Example:
     * <code>
     * // 単純なエクスポート
     * assertSame(var_export2(['array' => [1, 2, 3], 'hash' => ['a' => 'A', 'b' => 'B', 'c' => 'C']], true), "[
     *     'array' => [1, 2, 3],
     *     'hash'  => [
     *         'a' => 'A',
     *         'b' => 'B',
     *         'c' => 'C',
     *     ],
     * ]");
     * // 再帰構造を含むエクスポート（標準の var_export は形式が異なる。 var_export すれば分かる）
     * $rarray = [];
     * $rarray['a']['b']['c'] = &$rarray;
     * $robject = new \stdClass();
     * $robject->a = new \stdClass();
     * $robject->a->b = new \stdClass();
     * $robject->a->b->c = $robject;
     * assertSame(var_export2(compact('rarray', 'robject'), true), "[
     *     'rarray'  => [
     *         'a' => [
     *             'b' => [
     *                 'c' => '*RECURSION*',
     *             ],
     *         ],
     *     ],
     *     'robject' => stdClass::__set_state([
     *         'a' => stdClass::__set_state([
     *             'b' => stdClass::__set_state([
     *                 'c' => '*RECURSION*',
     *             ]),
     *         ]),
     *     ]),
     * ]");
     * </code>
     *
     * @package Var
     *
     * @param mixed $value 出力する値
     * @param bool $return 返すなら true 出すなら false
     * @return string|null $return=true の場合は出力せず結果を返す
     */
    function var_export2($value, $return = false)
    {
        // インデントの空白数
        $INDENT = 4;

        // 再帰用クロージャ
        $export = function ($value, $nest = 0, $parents = []) use (&$export, $INDENT) {
            // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
            foreach ($parents as $parent) {
                if ($parent === $value) {
                    return var_export('*RECURSION*', true);
                }
            }
            // 配列は連想判定したり再帰したり色々
            if (is_array($value)) {
                // 空配列は固定文字列
                if (!$value) {
                    return '[]';
                }

                $spacer1 = str_repeat(' ', ($nest + 1) * $INDENT);
                $spacer2 = str_repeat(' ', $nest * $INDENT);

                // ただの配列
                if ($value === array_values($value)) {
                    // スカラー値のみで構成されているならシンプルな再帰
                    if (call_user_func(array_all, $value, is_primitive)) {
                        $vals = array_map($export, $value);
                        return '[' . implode(', ', $vals) . ']';
                    }
                    // スカラー値以外が含まれているならキーを含めない
                    $kvl = '';
                    $parents[] = $value;
                    foreach ($value as $k => $v) {
                        $kvl .= $spacer1 . $export($v, $nest + 1, $parents) . ",\n";
                    }
                    return "[\n{$kvl}{$spacer2}]";
                }

                // 連想配列はキーを含めて桁あわせ
                $values = call_user_func(array_map_key, $value, $export);
                $maxlen = max(array_map('strlen', array_keys($values)));
                $kvl = '';
                $parents[] = $value;
                foreach ($values as $k => $v) {
                    $align = str_repeat(' ', $maxlen - strlen($k));
                    $kvl .= $spacer1 . $k . $align . ' => ' . $export($v, $nest + 1, $parents) . ",\n";
                }
                return "[\n{$kvl}{$spacer2}]";
            }
            // オブジェクトは単にプロパティを __set_state する文字列を出力する
            elseif (is_object($value)) {
                // クラスごとに \ReflectionProperty をキャッシュしておく
                static $refs = [];
                $class = get_class($value);
                if (!isset($refs[$class])) {
                    $refs[$class] = array_reduce((new \ReflectionClass($value))->getProperties(), function ($carry, \ReflectionProperty $rp) {
                        if (!$rp->isStatic()) {
                            $rp->setAccessible(true);
                            $carry[$rp->getName()] = $rp;
                        }
                        return $carry;
                    }, []);
                }

                // 単純に配列キャストだと private で ヌル文字が出たり static が含まれたりするのでリフレクションで取得して勝手プロパティで埋める
                $vars = call_user_func(array_map_method, $refs[$class], 'getValue', [$value]);
                $vars += get_object_vars($value);

                $parents[] = $value;
                return get_class($value) . '::__set_state(' . $export($vars, $nest, $parents) . ')';
            }
            // null は小文字で居て欲しい
            elseif (is_null($value)) {
                return 'null';
            }
            // それ以外は標準に従う
            else {
                return var_export($value, true);
            }
        };

        // 結果を返したり出力したり
        $result = $export($value);
        if ($return) {
            return $result;
        }
        echo $result;
    }
}
if (!isset($excluded_functions['var_html']) && (!function_exists('var_html') || (new \ReflectionFunction('var_html'))->isInternal())) {
    /**
     * var_export2 を html コンテキストに特化させたもの
     *
     * 下記のような出力になる。
     * - `<pre class='var_html'> ～ </pre>` で囲まれる
     * - php 構文なのでハイライトされて表示される
     * - Content-Type が強制的に text/html になる
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * @package Var
     *
     * @param mixed $value 出力する値
     */
    function var_html($value)
    {
        $result = call_user_func(var_export2, $value, true);
        $result = highlight_string("<?php " . $result, true);
        $result = preg_replace('#&lt;\\?php(\s|&nbsp;)#', '', $result, 1);
        $result = "<pre class='var_html'>$result</pre>";

        // text/html を強制する（でないと見やすいどころか見づらくなる）
        // @codeCoverageIgnoreStart
        if (!headers_sent()) {
            header_remove('Content-Type');
            ob_end_flush();
            header('Content-Type: text/html');
        }
        // @codeCoverageIgnoreEnd

        echo $result;
    }
}
if (!isset($excluded_functions['hashvar']) && (!function_exists('hashvar') || (new \ReflectionFunction('hashvar'))->isInternal())) {
    /**
     * 変数指定をできるようにした compact
     *
     * 名前空間指定の呼び出しは未対応。use して関数名だけで呼び出す必要がある。
     *
     * Example:
     * <code>
     * $hoge = 'HOGE';
     * $fuga = 'FUGA';
     * assertSame(hashvar($hoge, $fuga), ['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * </code>
     *
     * @package Var
     *
     * @param mixed $vars 変数（可変引数）
     * @return array 引数の変数を変数名で compact した配列
     */
    function hashvar(...$vars)
    {
        $num = count($vars);

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $file = $trace['file'];
        $line = $trace['line'];
        $function = call_user_func(function_shorten, $trace['function']);

        $cache = call_user_func(cache, $file . '#' . $line, function () use ($file, $line, $function) {
            // 呼び出し元の1行を取得
            $lines = file($file, FILE_IGNORE_NEW_LINES);
            $target = $lines[$line - 1];

            // 1行内で複数呼んでいる場合のための配列
            $caller = [];
            $callers = [];

            // php パーシング
            $starting = false;
            $tokens = token_get_all('<?php ' . $target);
            foreach ($tokens as $token) {
                // トークン配列の場合
                if (is_array($token)) {
                    // 自身の呼び出しが始まった
                    if (!$starting && $token[0] === T_STRING && $token[1] === $function) {
                        $starting = true;
                    }
                    // 呼び出し中でかつ変数トークンなら変数名を確保
                    elseif ($starting && $token[0] === T_VARIABLE) {
                        $caller[] = ltrim($token[1], '$');
                    }
                    // 上記以外の呼び出し中のトークンは空白しか許されない
                    elseif ($starting && $token[0] !== T_WHITESPACE) {
                        throw new \UnexpectedValueException('argument allows variable only.');
                    }
                }
                // 1文字単位の文字列の場合
                else {
                    // 自身の呼び出しが終わった
                    if ($starting && $token === ')') {
                        $callers[] = $caller;
                        $caller = [];
                        $starting = false;
                    }
                }
            }

            // 同じ引数の数の呼び出しは区別することが出来ない
            $length = count($callers);
            for ($i = 0; $i < $length; $i++) {
                for ($j = $i + 1; $j < $length; $j++) {
                    if (count($callers[$i]) === count($callers[$j])) {
                        throw new \UnexpectedValueException('argument is ambiguous.');
                    }
                }
            }

            return $callers;
        }, __FUNCTION__);

        // 引数の数が一致する呼び出しを返す
        foreach ($cache as $caller) {
            if (count($caller) === $num) {
                return array_combine($caller, $vars);
            }
        }

        // 仕組み上ここへは到達しないはず（呼び出し元のシンタックスが壊れてるときに到達しうるが、それならばそもそもこの関数自体が呼ばれないはず）。
        throw new \DomainException('syntax error.'); // @codeCoverageIgnore
    }
}
