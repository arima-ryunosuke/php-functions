<?php

# Don't touch this code. This is auto generated.

namespace ryunosuke\Functions;

const arrayize = 'ryunosuke\\Functions\\arrayize';
if (!isset($excluded_functions['arrayize']) && (!function_exists('ryunosuke\\Functions\\arrayize') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\arrayize'))->isInternal()))) {
    /**
     * 引数の配列を生成する。
     *
     * 配列以外を渡すと配列化されて追加される。
     * 連想配列は未対応。あくまで普通の配列化のみ。
     * iterable や Traversable は考慮せずあくまで「配列」としてチェックする。
     *
     * Example:
     * ```php
     * assertSame(arrayize(1, 2, 3), [1, 2, 3]);
     * assertSame(arrayize([1], [2], [3]), [1, 2, 3]);
     * $object = new \stdClass();
     * assertSame(arrayize($object, false, [1, 2, 3]), [$object, false, 1, 2, 3]);
     * ```
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

const is_hasharray = 'ryunosuke\\Functions\\is_hasharray';
if (!isset($excluded_functions['is_hasharray']) && (!function_exists('ryunosuke\\Functions\\is_hasharray') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\is_hasharray'))->isInternal()))) {
    /**
     * 配列が連想配列か調べる
     *
     * 空の配列は普通の配列とみなす。
     *
     * Example:
     * ```php
     * assertFalse(is_hasharray([]));
     * assertFalse(is_hasharray([1, 2, 3]));
     * assertTrue(is_hasharray(['x' => 'X']));
     * ```
     *
     * @param array $array 調べる配列
     * @return bool 連想配列なら true
     */
    function is_hasharray(array $array)
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

const first_key = 'ryunosuke\\Functions\\first_key';
if (!isset($excluded_functions['first_key']) && (!function_exists('ryunosuke\\Functions\\first_key') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\first_key'))->isInternal()))) {
    /**
     * 配列の最初のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(first_key(['a', 'b', 'c']), 0);
     * assertSame(first_key([], 999), 999);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最初のキー
     */
    function first_key($array, $default = null)
    {
        if (empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = (first_keyvalue)($array);
        return $k;
    }
}

const first_value = 'ryunosuke\\Functions\\first_value';
if (!isset($excluded_functions['first_value']) && (!function_exists('ryunosuke\\Functions\\first_value') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\first_value'))->isInternal()))) {
    /**
     * 配列の最初の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(first_value(['a', 'b', 'c']), 'a');
     * assertSame(first_value([], 999), 999);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最初の値
     */
    function first_value($array, $default = null)
    {
        if (empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = (first_keyvalue)($array);
        return $v;
    }
}

const first_keyvalue = 'ryunosuke\\Functions\\first_keyvalue';
if (!isset($excluded_functions['first_keyvalue']) && (!function_exists('ryunosuke\\Functions\\first_keyvalue') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\first_keyvalue'))->isInternal()))) {
    /**
     * 配列の最初のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(first_keyvalue(['a', 'b', 'c']), [0, 'a']);
     * assertSame(first_keyvalue([], 999), 999);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return array [最初のキー, 最初の値]
     */
    function first_keyvalue($array, $default = null)
    {
        foreach ($array as $k => $v) {
            return [$k, $v];
        }
        return $default;
    }
}

const last_key = 'ryunosuke\\Functions\\last_key';
if (!isset($excluded_functions['last_key']) && (!function_exists('ryunosuke\\Functions\\last_key') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\last_key'))->isInternal()))) {
    /**
     * 配列の最後のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(last_key(['a', 'b', 'c']), 2);
     * assertSame(last_key([], 999), 999);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最後のキー
     */
    function last_key($array, $default = null)
    {
        if (empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = (last_keyvalue)($array);
        return $k;
    }
}

const last_value = 'ryunosuke\\Functions\\last_value';
if (!isset($excluded_functions['last_value']) && (!function_exists('ryunosuke\\Functions\\last_value') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\last_value'))->isInternal()))) {
    /**
     * 配列の最後の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(last_value(['a', 'b', 'c']), 'c');
     * assertSame(last_value([], 999), 999);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最後の値
     */
    function last_value($array, $default = null)
    {
        if (empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = (last_keyvalue)($array);
        return $v;
    }
}

const last_keyvalue = 'ryunosuke\\Functions\\last_keyvalue';
if (!isset($excluded_functions['last_keyvalue']) && (!function_exists('ryunosuke\\Functions\\last_keyvalue') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\last_keyvalue'))->isInternal()))) {
    /**
     * 配列の最後のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(last_keyvalue(['a', 'b', 'c']), [2, 'c']);
     * assertSame(last_keyvalue([], 999), 999);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return array [最後のキー, 最後の値]
     */
    function last_keyvalue($array, $default = null)
    {
        if (empty($array)) {
            return $default;
        }
        if (is_array($array)) {
            $v = end($array);
            $k = key($array);
            return [$k, $v];
        }
        /** @noinspection PhpStatementHasEmptyBodyInspection */
        foreach ($array as $k => $v) {
            // dummy
        }
        // $k がセットされてるなら「ループが最低でも1度回った（≠空）」とみなせる
        if (isset($k)) {
            /** @noinspection PhpUndefinedVariableInspection */
            return [$k, $v];
        }
        return $default;
    }
}

const prev_key = 'ryunosuke\\Functions\\prev_key';
if (!isset($excluded_functions['prev_key']) && (!function_exists('ryunosuke\\Functions\\prev_key') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\prev_key'))->isInternal()))) {
    /**
     * 配列の指定キーの前のキーを返す
     *
     * $key が最初のキーだった場合は null を返す。
     * $key が存在しない場合は false を返す。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 'b' キーの前は 'a'
     * assertSame(prev_key($array, 'b'), 'a');
     * // 'a' キーの前は無いので null
     * assertSame(prev_key($array, 'a'), null);
     * // 'x' キーはそもそも存在しないので false
     * assertSame(prev_key($array, 'x'), false);
     * ```
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

const next_key = 'ryunosuke\\Functions\\next_key';
if (!isset($excluded_functions['next_key']) && (!function_exists('ryunosuke\\Functions\\next_key') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\next_key'))->isInternal()))) {
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
     * ```php
     * $array = [9 => 9, 'a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 'b' キーの次は 'c'
     * assertSame(next_key($array, 'b'), 'c');
     * // 'c' キーの次は無いので null
     * assertSame(next_key($array, 'c'), null);
     * // 'x' キーはそもそも存在しないので false
     * assertSame(next_key($array, 'x'), false);
     * // 次に生成されるキーは 10
     * assertSame(next_key($array, null), 10);
     * ```
     *
     * @param array $array 対象配列
     * @param string|int|null $key 調べるキー
     * @return string|int|bool|null $key の次のキー
     */
    function next_key($array, $key = null)
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

const in_array_and = 'ryunosuke\\Functions\\in_array_and';
if (!isset($excluded_functions['in_array_and']) && (!function_exists('ryunosuke\\Functions\\in_array_and') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\in_array_and'))->isInternal()))) {
    /**
     * in_array の複数版（AND）
     *
     * 配列 $haystack が $needle の「すべてを含む」ときに true を返す。
     *
     * $needle が非配列の場合は配列化される。
     * $needle が空の場合は常に false を返す。
     *
     * Example:
     * ```php
     * assertTrue(in_array_and([1], [1, 2, 3]));
     * assertFalse(in_array_and([9], [1, 2, 3]));
     * assertFalse(in_array_and([1, 9], [1, 2, 3]));
     * ```
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

const in_array_or = 'ryunosuke\\Functions\\in_array_or';
if (!isset($excluded_functions['in_array_or']) && (!function_exists('ryunosuke\\Functions\\in_array_or') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\in_array_or'))->isInternal()))) {
    /**
     * in_array の複数版（OR）
     *
     * 配列 $haystack が $needle の「どれかを含む」ときに true を返す。
     *
     * $needle が非配列の場合は配列化される。
     * $needle が空の場合は常に false を返す。
     *
     * Example:
     * ```php
     * assertTrue(in_array_or([1], [1, 2, 3]), true);
     * assertFalse(in_array_or([9], [1, 2, 3]), false);
     * assertTrue(in_array_or([1, 9], [1, 2, 3]), true);
     * ```
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

const kvsort = 'ryunosuke\\Functions\\kvsort';
if (!isset($excluded_functions['kvsort']) && (!function_exists('ryunosuke\\Functions\\kvsort') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\kvsort'))->isInternal()))) {
    /**
     * 比較関数にキーも渡ってくる安定ソート
     *
     * 比較関数は ($avalue, $bvalue, $akey, $bkey) という引数を取る。
     * 「値で比較して同値だったらキーも見たい」という状況はまれによくあるはず。
     * さらに安定ソートであり、同値だとしても元の並び順は維持される。
     *
     * $comparator は省略できる。省略した場合、型に基づいてよしなにソートする。
     * （が、比較のたびに型チェックが入るので指定したほうが高速に動く）
     *
     * ただし、標準のソート関数とは異なり、参照渡しではなくソートして返り値で返す。
     * また、いわゆる asort であり、キー・値は常に維持される。
     *
     * Example:
     * ```php
     * $array = [
     *     'a'  => 3,
     *     'b'  => 1,
     *     'c'  => 2,
     *     'x1' => 9,
     *     'x2' => 9,
     *     'x3' => 9,
     * ];
     * // 普通のソート
     * assertSame(kvsort($array), [
     *     'b'  => 1,
     *     'c'  => 2,
     *     'a'  => 3,
     *     'x1' => 9,
     *     'x2' => 9,
     *     'x3' => 9,
     * ]);
     * // キーを使用したソート
     * assertSame(kvsort($array, function($av, $bv, $ak, $bk){return strcmp($bk, $ak);}), [
     *     'x3' => 9,
     *     'x2' => 9,
     *     'x1' => 9,
     *     'c'  => 2,
     *     'b'  => 1,
     *     'a'  => 3,
     * ]);
     * ```
     *
     * @param array|\Traversable|string $array 対象配列
     * @param callable|int $comparator 比較関数。SORT_XXX も使える
     * @return array ソートされた配列
     */
    function kvsort($array, $comparator = null)
    {
        if ($comparator === null || is_int($comparator)) {
            $sort_flg = $comparator;
            $comparator = function ($av, $bv, $ak, $bk) use ($sort_flg) {
                return (varcmp)($av, $bv, $sort_flg);
            };
        }

        $n = 0;
        $tmp = [];
        foreach ($array as $k => $v) {
            $tmp[$k] = [$n++, $k, $v];
        }

        uasort($tmp, function ($a, $b) use ($comparator) {
            return $comparator($a[2], $b[2], $a[1], $b[1]) ?: ($a[0] - $b[0]);
        });

        foreach ($tmp as $k => $v) {
            $tmp[$k] = $v[2];
        }

        return $tmp;
    }
}

const array_add = 'ryunosuke\\Functions\\array_add';
if (!isset($excluded_functions['array_add']) && (!function_exists('ryunosuke\\Functions\\array_add') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_add'))->isInternal()))) {
    /**
     * 配列の+演算子の関数版
     *
     * Example:
     * ```php
     * // ただの加算の関数版なので同じキーは上書きされない
     * assertSame(array_add(['a', 'b', 'c'], ['X']), ['a', 'b', 'c']);
     * // 異なるキーは生える
     * assertSame(array_add(['a', 'b', 'c'], ['x' => 'X']), ['a', 'b', 'c', 'x' => 'X']);
     * ```
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

const array_mix = 'ryunosuke\\Functions\\array_mix';
if (!isset($excluded_functions['array_mix']) && (!function_exists('ryunosuke\\Functions\\array_mix') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_mix'))->isInternal()))) {
    /**
     * 配列を交互に追加する
     *
     * 引数の配列を横断的に追加して返す。
     * 数値キーは振り直される。文字キーはそのまま追加される（同じキーは後方上書き）。
     *
     * 配列の長さが異なる場合、短い方に対しては何もしない。そのまま追加される。
     *
     * Example:
     * ```php
     * // 奇数配列と偶数配列をミックスして自然数配列を生成
     * assertSame(array_mix([1, 3, 5], [2, 4, 6]), [1, 2, 3, 4, 5, 6]);
     * // 長さが異なる場合はそのまま追加される（短い方の足りない分は無視される）
     * assertSame(array_mix([1], [2, 3, 4]), [1, 2, 3, 4]);
     * assertSame(array_mix([1, 3, 4], [2]), [1, 2, 3, 4]);
     * // 可変引数なので3配列以上も可
     * assertSame(array_mix([1], [2, 4], [3, 5, 6]), [1, 2, 3, 4, 5, 6]);
     * assertSame(array_mix([1, 4, 6], [2, 5], [3]), [1, 2, 3, 4, 5, 6]);
     * // 文字キーは維持される
     * assertSame(array_mix(['a' => 'A', 1, 3], ['b' => 'B', 2]), ['a' => 'A', 'b' => 'B', 1, 2, 3]);
     * ```
     *
     * @param array $variadic 対象配列（可変引数）
     * @return array 引数配列が交互に追加された配列
     */
    function array_mix(...$variadic)
    {
        assert(count(array_filter($variadic, function ($v) { return !is_array($v); })) === 0);

        if (!$variadic) {
            return [];
        }

        $keyses = array_map('array_keys', $variadic);
        $limit = max(array_map('count', $keyses));

        $result = [];
        for ($i = 0; $i < $limit; $i++) {
            foreach ($keyses as $n => $keys) {
                if (isset($keys[$i])) {
                    $key = $keys[$i];
                    $val = $variadic[$n][$key];
                    if (is_int($key)) {
                        $result[] = $val;
                    }
                    else {
                        $result[$key] = $val;
                    }
                }
            }
        }
        return $result;
    }
}

const array_implode = 'ryunosuke\\Functions\\array_implode';
if (!isset($excluded_functions['array_implode']) && (!function_exists('ryunosuke\\Functions\\array_implode') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_implode'))->isInternal()))) {
    /**
     * 配列の各要素の間に要素を差し込む
     *
     * 歴史的な理由はないが、引数をどちらの順番でも受けつけることが可能。
     * ただし、$glue を先に渡すパターンの場合は配列指定が可変引数渡しになる。
     *
     * 文字キーは保存されるが数値キーは再割り振りされる。
     *
     * Example:
     * ```php
     * // (配列, 要素) の呼び出し
     * assertSame(array_implode(['a', 'b', 'c'], 'X'), ['a', 'X', 'b', 'X', 'c']);
     * // (要素, ...配列) の呼び出し
     * assertSame(array_implode('X', 'a', 'b', 'c'), ['a', 'X', 'b', 'X', 'c']);
     * ```
     *
     * @param array|\Traversable|string $array 対象配列
     * @param string $glue 差し込む要素
     * @return array 差し込まれた配列
     */
    function array_implode($array, $glue)
    {
        // 第1引数が回せない場合は引数を入れ替えて可変引数パターン
        if (!is_array($array) && !$array instanceof \Traversable) {
            return (array_implode)(array_slice(func_get_args(), 1), $array);
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

const array_sprintf = 'ryunosuke\\Functions\\array_sprintf';
if (!isset($excluded_functions['array_sprintf']) && (!function_exists('ryunosuke\\Functions\\array_sprintf') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_sprintf'))->isInternal()))) {
    /**
     * キーと値で sprintf する
     *
     * 配列の各要素を文字列化して返すイメージ。
     * $glue を与えるとさらに implode して返す（返り値が文字列になる）。
     *
     * $format は書式文字列（$v, $k）。
     * callable を与えると sprintf ではなくコールバック処理になる（$v, $k）。
     * 省略（null）するとキーを format 文字列、値を引数として **vsprintf** する。
     *
     * Example:
     * ```php
     * $array = ['key1' => 'val1', 'key2' => 'val2'];
     * // key, value を利用した sprintf
     * assertSame(array_sprintf($array, '%2$s=%1$s'), ['key1=val1', 'key2=val2']);
     * // 第3引数を与えるとさらに implode される
     * assertSame(array_sprintf($array, '%2$s=%1$s', ' '), 'key1=val1 key2=val2');
     * // クロージャを与えるとコールバック動作になる
     * $closure = function($v, $k){return "$k=" . strtoupper($v);};
     * assertSame(array_sprintf($array, $closure, ' '), 'key1=VAL1 key2=VAL2');
     * // 省略すると vsprintf になる
     * assertSame(array_sprintf([
     *     'str:%s,int:%d' => ['sss', '3.14'],
     *     'single:%s'     => 'str',
     * ], null, '|'), 'str:sss,int:3|single:str');
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param string|callable $format 書式文字列あるいはクロージャ
     * @param string $glue 結合文字列。未指定時は implode しない
     * @return array|string sprintf された配列
     */
    function array_sprintf($array, $format = null, $glue = null)
    {
        if (is_callable($format)) {
            $callback = (func_user_func_array)($format);
        }
        elseif ($format === null) {
            $callback = function ($v, $k) { return vsprintf($k, is_array($v) ? $v : [$v]); };
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

const array_strpad = 'ryunosuke\\Functions\\array_strpad';
if (!isset($excluded_functions['array_strpad']) && (!function_exists('ryunosuke\\Functions\\array_strpad') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_strpad'))->isInternal()))) {
    /**
     * 配列のキー・要素に文字列を付加する
     *
     * $key_prefix, $val_prefix でそれぞれ「キーに付与する文字列」「値に付与する文字列」が指定できる。
     * 配列を与えると [サフィックス, プレフィックス] という意味になる。
     * デフォルト（ただの文字列）はプレフィックス（値だけに付与したいなら array_map で十分なので）。
     *
     * Example:
     * ```php
     * $array = ['key1' => 'val1', 'key2' => 'val2'];
     * // キーにプレフィックス付与
     * assertSame(array_strpad($array, 'prefix-'), ['prefix-key1' => 'val1', 'prefix-key2' => 'val2']);
     * // 値にサフィックス付与
     * assertSame(array_strpad($array, '', ['-suffix']), ['key1' => 'val1-suffix', 'key2' => 'val2-suffix']);
     * ```
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

const array_pos = 'ryunosuke\\Functions\\array_pos';
if (!isset($excluded_functions['array_pos']) && (!function_exists('ryunosuke\\Functions\\array_pos') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_pos'))->isInternal()))) {
    /**
     * 配列・連想配列を問わず「N番目(0ベース)」の要素を返す
     *
     * 負数を与えると逆から N 番目となる。
     *
     * Example:
     * ```php
     * assertSame(array_pos([1, 2, 3], 1), 2);
     * assertSame(array_pos([1, 2, 3], -1), 3);
     * assertSame(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1), 'B');
     * assertSame(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1, true), 'b');
     * ```
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

const array_of = 'ryunosuke\\Functions\\array_of';
if (!isset($excluded_functions['array_of']) && (!function_exists('ryunosuke\\Functions\\array_of') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_of'))->isInternal()))) {
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
     * ```php
     * $fuga_of_array = array_of('fuga');
     * assertSame($fuga_of_array(['hoge' => 'HOGE', 'fuga' => 'FUGA']), 'FUGA');
     * ```
     *
     * @param string|int|array $key 取得したいキー
     * @param mixed $default デフォルト値
     * @return \Closure $key の値を返すクロージャ
     */
    function array_of($key, $default = null)
    {
        $nodefault = func_num_args() === 1;
        return function (array $array) use ($key, $default, $nodefault) {
            if ($nodefault) {
                return (array_get)($array, $key);
            }
            else {
                return (array_get)($array, $key, $default);
            }
        };
    }
}

const array_get = 'ryunosuke\\Functions\\array_get';
if (!isset($excluded_functions['array_get']) && (!function_exists('ryunosuke\\Functions\\array_get') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_get'))->isInternal()))) {
    /**
     * デフォルト値付きの配列値取得
     *
     * 存在しない場合は $default を返す。
     *
     * $key に配列を与えるとそれらの値の配列を返す（lookup 的な動作）。
     * その場合、$default が活きるのは「全て無かった場合」となる。
     *
     * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
     *
     * 同様に、$key にクロージャを与えると、その返り値が true 相当のものを返す。
     * その際、 $default が配列なら一致するものを配列で返し、配列でないなら単値で返す。
     *
     * Example:
     * ```php
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
     * // クロージャ指定＆単値（コールバックが true を返す最初の要素）
     * assertSame(array_get(['a', 'b', 'c'], function($v){return in_array($v, ['b', 'c']);}), 'b');
     * // クロージャ指定＆配列（コールバックが true を返すもの）
     * assertSame(array_get(['a', 'b', 'c'], function($v){return in_array($v, ['b', 'c']);}, []), [1 => 'b', 2 => 'c']);
     * ```
     *
     * @param array $array 配列
     * @param string|int|array $key 取得したいキー。配列を与えると全て返す。クロージャの場合は true 相当を返す
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 指定したキーの値
     */
    function array_get($array, $key, $default = null)
    {
        if (is_array($key)) {
            $result = [];
            foreach ($key as $k) {
                // 深遠な事情で少しでも高速化したかったので isset || array_keys_exist にしてある
                if (isset($array[$k]) || (array_keys_exist)($k, $array)) {
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

        if ($key instanceof \Closure) {
            $result = [];
            foreach ($array as $k => $v) {
                if ($key($v, $k)) {
                    if (func_num_args() === 2) {
                        return $v;
                    }
                    $result[$k] = $v;
                }
            }
            if (!$result) {
                return $default;
            }
            return $result;
        }

        if ((array_keys_exist)($key, $array)) {
            return $array[$key];
        }
        return $default;
    }
}

const array_set = 'ryunosuke\\Functions\\array_set';
if (!isset($excluded_functions['array_set']) && (!function_exists('ryunosuke\\Functions\\array_set') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_set'))->isInternal()))) {
    /**
     * キー指定の配列値設定
     *
     * 第3引数を省略すると（null を与えると）言語機構を使用して配列の最後に設定する（$array[] = $value）。
     * 第3引数に配列を指定すると潜って設定する。
     *
     * Example:
     * ```php
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
     * ```
     *
     * @param array $array 配列
     * @param mixed $value 設定する値
     * @param array|string|int|null $key 設定するキー
     * @param bool $require_return 返り値が不要なら false を渡す
     * @return string|int 設定したキー
     */
    function array_set(&$array, $value, $key = null, $require_return = true)
    {
        if (is_array($key)) {
            $k = array_shift($key);
            if ($key) {
                if (is_array($array) && array_key_exists($k, $array) && !is_array($array[$k])) {
                    throw new \InvalidArgumentException('$array[$k] is not array.');
                }
                return (array_set)(...[&$array[$k], $value, $key, $require_return]);
            }
            else {
                return (array_set)(...[&$array, $value, $k, $require_return]);
            }
        }

        if ($key === null) {
            $array[] = $value;
            if ($require_return === true) {
                $key = (last_key)($array);
            }
        }
        else {
            $array[$key] = $value;
        }
        return $key;
    }
}

const array_unset = 'ryunosuke\\Functions\\array_unset';
if (!isset($excluded_functions['array_unset']) && (!function_exists('ryunosuke\\Functions\\array_unset') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_unset'))->isInternal()))) {
    /**
     * 伏せると同時にその値を返す
     *
     * $key に配列を与えると全て伏せて配列で返す。
     * その場合、$default が活きるのは「全て無かった場合」となる。
     *
     * 配列を与えた場合の返り値は与えた配列の順番・キーが活きる。
     * これを利用すると list の展開の利便性が上がったり、連想配列で返すことができる。
     *
     * 同様に、$key にクロージャを与えると、その返り値が true 相当のものを伏せて配列で返す。
     * callable ではなくクロージャのみ対応する。
     *
     * Example:
     * ```php
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
     *
     * $array = ['hoge' => 'HOGE', 'fuga' => 'FUGA', 'piyo' => 'PIYO'];
     * // 値に "G" を含むものを返す。その要素は伏せられている
     * assertSame(array_unset($array, function($v){return strpos($v, 'G') !== false;}), ['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * assertSame($array, ['piyo' => 'PIYO']);
     * ```
     *
     * @todo array_get と同じように $default に応じて返り値を変える（互換性が壊れるのでメジャー待ち）
     *
     * @param array $array 配列
     * @param string|int|array|callable $key 伏せたいキー。配列を与えると全て伏せる。クロージャの場合は true 相当を伏せる
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 指定したキーの値
     */
    function array_unset(&$array, $key, $default = null)
    {
        if (is_array($key)) {
            $result = [];
            foreach ($key as $rk => $ak) {
                if ((array_keys_exist)($ak, $array)) {
                    $result[$rk] = $array[$ak];
                    unset($array[$ak]);
                }
            }
            if (!$result) {
                return $default;
            }
            return $result;
        }

        if ($key instanceof \Closure) {
            $result = [];
            foreach ($array as $k => $v) {
                if ($key($v, $k)) {
                    $result[$k] = $v;
                    unset($array[$k]);
                }
            }
            if (!$result) {
                return $default;
            }
            return $result;
        }

        if ((array_keys_exist)($key, $array)) {
            $result = $array[$key];
            unset($array[$key]);
            return $result;
        }
        return $default;
    }
}

const array_dive = 'ryunosuke\\Functions\\array_dive';
if (!isset($excluded_functions['array_dive']) && (!function_exists('ryunosuke\\Functions\\array_dive') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_dive'))->isInternal()))) {
    /**
     * パス形式で配列値を取得
     *
     * 存在しない場合は $default を返す。
     *
     * Example:
     * ```php
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
     * ```
     *
     * @param array $array 調べる配列
     * @param string|array $path パス文字列。配列も与えられる
     * @param mixed $default 無かった場合のデフォルト値
     * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
     * @return mixed パスが示す配列の値
     */
    function array_dive($array, $path, $default = null, $delimiter = '.')
    {
        $keys = is_array($path) ? $path : explode($delimiter, $path);
        foreach ($keys as $key) {
            if (!(is_arrayable)($array)) {
                return $default;
            }
            if (!(array_keys_exist)($key, $array)) {
                return $default;
            }
            $array = $array[$key];
        }
        return $array;
    }
}

const array_keys_exist = 'ryunosuke\\Functions\\array_keys_exist';
if (!isset($excluded_functions['array_keys_exist']) && (!function_exists('ryunosuke\\Functions\\array_keys_exist') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_keys_exist'))->isInternal()))) {
    /**
     * array_key_exists の複数版
     *
     * 指定キーが全て存在するなら true を返す。
     * 配列ではなく単一文字列を与えても動作する（array_key_exists と全く同じ動作になる）。
     *
     * $keys に空を与えると例外を投げる。
     * $keys に配列を与えるとキーで潜ってチェックする（Example 参照）。
     *
     * Example:
     * ```php
     * // すべて含むので true
     * assertTrue(array_keys_exist(['a', 'b', 'c'], ['a' => 'A', 'b' => 'B', 'c' => 'C']));
     * // N は含まないので false
     * assertFalse(array_keys_exist(['a', 'b', 'N'], ['a' => 'A', 'b' => 'B', 'c' => 'C']));
     * // 配列を与えると潜る（日本語で言えば「a というキーと、x というキーとその中に x1, x2 というキーがあるか？」）
     * assertTrue(array_keys_exist(['a', 'x' => ['x1', 'x2']], ['a' => 'A', 'x' => ['x1' => 'X1', 'x2' => 'X2']]));
     * ```
     *
     * @param array|string $keys 調べるキー
     * @param array|\ArrayAccess $array 調べる配列
     * @return bool 指定キーが全て存在するなら true
     */
    function array_keys_exist($keys, $array)
    {
        $keys = (array) $keys;
        if (empty($keys)) {
            throw new \InvalidArgumentException('$keys is empty.');
        }

        $is_arrayaccess = $array instanceof \ArrayAccess;

        foreach ($keys as $k => $key) {
            if (is_array($key)) {
                // まずそのキーをチェックして
                if (!(array_keys_exist)($k, $array)) {
                    return false;
                }
                // あるなら再帰する
                if (!(array_keys_exist)($key, $array[$k])) {
                    return false;
                }
            }
            elseif ($is_arrayaccess) {
                if (!$array->offsetExists($key)) {
                    return false;
                }
            }
            elseif (!array_key_exists($key, $array)) {
                return false;
            }
        }
        return true;
    }
}

const array_find = 'ryunosuke\\Functions\\array_find';
if (!isset($excluded_functions['array_find']) && (!function_exists('ryunosuke\\Functions\\array_find') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_find'))->isInternal()))) {
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
     * ```php
     * // 最初に見つかったキーを返す
     * assertSame(array_find(['a', 'b', '9'], 'ctype_digit'), 2);
     * assertSame(array_find(['a', 'b', '9'], function($v){return $v === 'b';}), 1);
     * // 最初に見つかったコールバック結果を返す（最初の数字の2乗を返す）
     * $ifnumeric2power = function($v){return ctype_digit($v) ? $v * $v : false;};
     * assertSame(array_find(['a', 'b', '9'], $ifnumeric2power, false), 81);
     * ```
     *
     * @param array|\Traversable $array 調べる配列
     * @param callable $callback 評価コールバック
     * @param bool $is_key キーを返すか否か
     * @return mixed コールバックが true を返した最初のキー。存在しなかったら false
     */
    function array_find($array, $callback, $is_key = true)
    {
        $callback = (func_user_func_array)($callback);

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

const array_grep_key = 'ryunosuke\\Functions\\array_grep_key';
if (!isset($excluded_functions['array_grep_key']) && (!function_exists('ryunosuke\\Functions\\array_grep_key') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_grep_key'))->isInternal()))) {
    /**
     * キーを正規表現でフィルタする
     *
     * Example:
     * ```php
     * assertSame(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#'), ['a' => 'A', 'aa' => 'AA']);
     * assertSame(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#', true), ['b' => 'B']);
     * ```
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

const array_map_key = 'ryunosuke\\Functions\\array_map_key';
if (!isset($excluded_functions['array_map_key']) && (!function_exists('ryunosuke\\Functions\\array_map_key') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_map_key'))->isInternal()))) {
    /**
     * キーをマップして変換する
     *
     * $callback が null を返すとその要素は取り除かれる。
     *
     * Example:
     * ```php
     * assertSame(array_map_key(['a' => 'A', 'b' => 'B'], 'strtoupper'), ['A' => 'A', 'B' => 'B']);
     * assertSame(array_map_key(['a' => 'A', 'b' => 'B'], function(){}), []);
     * ```
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

const array_filter_not = 'ryunosuke\\Functions\\array_filter_not';
if (!isset($excluded_functions['array_filter_not']) && (!function_exists('ryunosuke\\Functions\\array_filter_not') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_filter_not'))->isInternal()))) {
    /**
     * array_filter の否定版
     *
     * 単に否定するだけなのにクロージャを書きたくないことはまれによくあるはず。
     *
     * Example:
     * ```php
     * assertSame(array_filter_not(['a', '', 'c'], 'strlen'), [1 => '']);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価 callable
     * @return array $callback が false を返した新しい配列
     */
    function array_filter_not($array, $callback)
    {
        return array_filter($array, (not_func)($callback));
    }
}

const array_filter_key = 'ryunosuke\\Functions\\array_filter_key';
if (!isset($excluded_functions['array_filter_key']) && (!function_exists('ryunosuke\\Functions\\array_filter_key') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_filter_key'))->isInternal()))) {
    /**
     * キーを主軸とした array_filter
     *
     * $callback が要求するなら値も渡ってくる。 php 5.6 の array_filter の ARRAY_FILTER_USE_BOTH と思えばよい。
     * ただし、完全な互換ではなく、引数順は ($k, $v) なので注意。
     *
     * Example:
     * ```php
     * assertSame(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $k !== 1; }), [0 => 'a', 2 => 'c']);
     * assertSame(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $v !== 'b'; }), [0 => 'a', 2 => 'c']);
     * ```
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

const array_filter_eval = 'ryunosuke\\Functions\\array_filter_eval';
if (!isset($excluded_functions['array_filter_eval']) && (!function_exists('ryunosuke\\Functions\\array_filter_eval') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_filter_eval'))->isInternal()))) {
    /**
     * eval で評価して array_filter する
     *
     * キーは $k, 値は $v で宣言される。
     *
     * Example:
     * ```php
     * assertSame(array_filter_eval(['a', 'b', 'c'], '$k !== 1'), [0 => 'a', 2 => 'c']);
     * assertSame(array_filter_eval(['a', 'b', 'c'], '$v !== "b"'), [0 => 'a', 2 => 'c']);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param string $expression eval コード
     * @return array $expression が true を返した新しい配列
     */
    function array_filter_eval($array, $expression)
    {
        return (array_filter_key)($array, (eval_func)($expression, 'k', 'v'));
    }
}

const array_where = 'ryunosuke\\Functions\\array_where';
if (!isset($excluded_functions['array_where']) && (!function_exists('ryunosuke\\Functions\\array_where') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_where'))->isInternal()))) {
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
     * ```php
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
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param string|array|null $column キー名
     * @param callable $callback 評価クロージャ
     * @return array $where が真を返した新しい配列
     */
    function array_where($array, $column = null, $callback = null)
    {
        $is_array = is_array($column);
        if ($is_array) {
            $column = array_flip($column);
        }

        $callback = (func_user_func_array)($callback);

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

const array_map_filter = 'ryunosuke\\Functions\\array_map_filter';
if (!isset($excluded_functions['array_map_filter']) && (!function_exists('ryunosuke\\Functions\\array_map_filter') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_map_filter'))->isInternal()))) {
    /**
     * array_map + array_filter する
     *
     * コールバックを適用して、結果が true 相当の要素のみ取り出す。
     * $strict に true を与えると「null でない」要素のみ返される。
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * assertSame(array_map_filter([' a ', ' b ', ''], 'trim'), ['a', 'b']);
     * assertSame(array_map_filter([' a ', ' b ', ''], 'trim', true), ['a', 'b', '']);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param bool $strict 厳密比較フラグ。 true だと null のみが偽とみなされる
     * @return array $callback が真を返した新しい配列
     */
    function array_map_filter($array, $callback, $strict = false)
    {
        $callback = (func_user_func_array)($callback);
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

const array_map_method = 'ryunosuke\\Functions\\array_map_method';
if (!isset($excluded_functions['array_map_method']) && (!function_exists('ryunosuke\\Functions\\array_map_method') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_map_method'))->isInternal()))) {
    /**
     * メソッドを指定できるようにした array_map
     *
     * 配列内の要素は全て同一（少なくともシグネチャが同じ $method が存在する）オブジェクトでなければならない。
     * スルーする場合は $ignore=true とする。スルーした場合 map ではなく filter される（結果配列に含まれない）。
     * $ignore=null とすると 何もせずそのまま要素を返す。
     *
     * Example:
     * ```php
     * $exa = new \Exception('a'); $exb = new \Exception('b'); $std = new \stdClass();
     * // getMessage で map される
     * assertSame(array_map_method([$exa, $exb], 'getMessage'), ['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合は取り除かれる
     * assertSame(array_map_method([$exa, $exb, $std, null], 'getMessage', [], true), ['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合はそのまま返す
     * assertSame(array_map_method([$exa, $exb, $std, null], 'getMessage', [], null), ['a', 'b', $std, null]);
     * ```
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
            return ([$object, $method])(...$args);
        }, $array);
    }
}

const array_maps = 'ryunosuke\\Functions\\array_maps';
if (!isset($excluded_functions['array_maps']) && (!function_exists('ryunosuke\\Functions\\array_maps') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_maps'))->isInternal()))) {
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
     * ```php
     * // 値を3乗したあと16進表記にして大文字化する
     * assertSame(array_maps([1, 2, 3, 4, 5], rbind('pow', 3), 'dechex', 'strtoupper'), ['1', '8', '1B', '40', '7D']);
     * // キーも渡ってくる
     * assertSame(array_maps(['a' => 'A', 'b' => 'B'], function($v, $k){return "$k:$v";}), ['a' => 'a:A', 'b' => 'b:B']);
     * // `@method` でメソッドコールになる
     * assertSame(array_maps([new \Exception('a'), new \Exception('b')], '@getMessage'), ['a', 'b']);
     * ```
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
                $margs = null;
                $callback = (func_user_func_array)($callback);
            }
            foreach ($result as $k => $v) {
                if (isset($margs)) {
                    $result[$k] = ([$v, $callback])(...$margs);
                }
                else {
                    $result[$k] = $callback($v, $k);
                }
            }
        }
        return $result;
    }
}

const array_kmap = 'ryunosuke\\Functions\\array_kmap';
if (!isset($excluded_functions['array_kmap']) && (!function_exists('ryunosuke\\Functions\\array_kmap') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_kmap'))->isInternal()))) {
    /**
     * キーも渡ってくる array_map
     *
     * `array_map($callback, $array, array_keys($array))` とほとんど変わりはない。
     * 違いは下記。
     *
     * - 引数の順番が異なる（$array が先）
     * - キーが死なない（array_map は複数配列を与えるとキーが死ぬ）
     * - 配列だけでなく Traversable も受け入れる
     * - callback の第3引数に 0 からの連番が渡ってくる
     *
     * Example:
     * ```php
     * // キー・値をくっつけるシンプルな例
     * assertSame(array_kmap([
     *     'k1' => 'v1',
     *     'k2' => 'v2',
     *     'k3' => 'v3',
     * ], function($v, $k){return "$k:$v";}), [
     *     'k1' => 'k1:v1',
     *     'k2' => 'k2:v2',
     *     'k3' => 'k3:v3',
     * ]);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array $callback を通した新しい配列
     */
    function array_kmap($array, $callback)
    {
        $callback = (func_user_func_array)($callback);

        $n = 0;
        $result = [];
        foreach ($array as $k => $v) {
            $result[$k] = $callback($v, $k, $n++);
        }
        return $result;
    }
}

const array_nmap = 'ryunosuke\\Functions\\array_nmap';
if (!isset($excluded_functions['array_nmap']) && (!function_exists('ryunosuke\\Functions\\array_nmap') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_nmap'))->isInternal()))) {
    /**
     * 要素値を $callback の n 番目(0ベース)に適用して array_map する
     *
     * 引数 $n に配列を与えると [キー番目 => 値番目] とみなしてキー・値も渡される（Example 参照）。
     * その際、「挿入後の番目」ではなく、単純に「元の引数の番目」であることに留意。キー・値が同じ位置を指定している場合はキーが先にくる。
     *
     * Example:
     * ```php
     * // 1番目に値を渡して map
     * $sprintf = function(){return vsprintf('%s%s%s', func_get_args());};
     * assertSame(array_nmap(['a', 'b'], $sprintf, 1, 'prefix-', '-suffix'), ['prefix-a-suffix', 'prefix-b-suffix']);
     * // 1番目にキー、2番目に値を渡して map
     * $sprintf = function(){return vsprintf('%s %s %s %s %s', func_get_args());};
     * assertSame(array_nmap(['k' => 'v'], $sprintf, [1 => 2], 'a', 'b', 'c'), ['k' => 'a k b v c']);
     * ```
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
            list($kn, $vn) = (first_keyvalue)($n);

            // array_insert は負数も受け入れられるが、それを考慮しだすともう収拾がつかない
            if ($kn < 0 || $vn < 0) {
                throw new \InvalidArgumentException('$kn, $vn must be positive.');
            }

            // どちらが大きいかで順番がズレるので分岐しなければならない
            if ($kn <= $vn) {
                $args = (array_insert)($args, null, $kn);
                $args = (array_insert)($args, null, ++$vn);// ↑で挿入してるので+1
            }
            else {
                $args = (array_insert)($args, null, $vn);
                $args = (array_insert)($args, null, ++$kn);// ↑で挿入してるので+1
            }
        }
        else {
            $args = (array_insert)($args, null, $n);
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
            $result[$k] = $callback(...$args);
        }
        return $result;
    }
}

const array_lmap = 'ryunosuke\\Functions\\array_lmap';
if (!isset($excluded_functions['array_lmap']) && (!function_exists('ryunosuke\\Functions\\array_lmap') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_lmap'))->isInternal()))) {
    /**
     * 要素値を $callback の最左に適用して array_map する
     *
     * Example:
     * ```php
     * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
     * assertSame(array_lmap(['a', 'b'], $sprintf, '-suffix'), ['a-suffix', 'b-suffix']);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_lmap($array, $callback, ...$variadic)
    {
        return (array_nmap)(...(array_insert)(func_get_args(), 0, 2));
    }
}

const array_rmap = 'ryunosuke\\Functions\\array_rmap';
if (!isset($excluded_functions['array_rmap']) && (!function_exists('ryunosuke\\Functions\\array_rmap') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_rmap'))->isInternal()))) {
    /**
     * 要素値を $callback の最右に適用して array_map する
     *
     * Example:
     * ```php
     * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
     * assertSame(array_rmap(['a', 'b'], $sprintf, 'prefix-'), ['prefix-a', 'prefix-b']);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_rmap($array, $callback, ...$variadic)
    {
        return (array_nmap)(...(array_insert)(func_get_args(), func_num_args() - 2, 2));
    }
}

const array_each = 'ryunosuke\\Functions\\array_each';
if (!isset($excluded_functions['array_each']) && (!function_exists('ryunosuke\\Functions\\array_each') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_each'))->isInternal()))) {
    /**
     * array_reduce の参照版（のようなもの）
     *
     * 配列をループで回し、その途中経過、値、キー、連番をコールバック引数で渡して最終的な結果を返り値として返す。
     * array_reduce と少し似てるが、下記の点が異なる。
     *
     * - いわゆる $carry は返り値で表すのではなく、参照引数で表す
     * - 値だけでなくキー、連番も渡ってくる
     * - 巨大配列の場合でも速度劣化が少ない（array_reduce に巨大配列を渡すと実用にならないレベルで遅くなる）
     *
     * $callback の引数は `($value, $key, $n)` （$n はキーとは関係がない 0 ～ 要素数-1 の通し連番）。
     *
     * 返り値ではなく参照引数なので return する必要はない（ワンライナーが書きやすくなる）。
     * 返り値が空くのでループ制御に用いる。
     * 今のところ $callback が false を返すとそこで break するのみ。
     *
     * 第3引数を省略した場合、**クロージャの第1引数のデフォルト値が使われる**。
     * これは特筆すべき動作で、不格好な第3引数を完全に省略することができる（サンプルコードを参照）。
     * ただし「php の文法違反（今のところエラーにはならないし、全てにデフォルト値をつければ一応回避可能）」「リフレクションを使う（ほんの少し遅くなる）」などの弊害が有るので推奨はしない。
     * （ただ、「意図していることをコードで表す」といった観点ではこの記法の方が正しいとも思う）。
     *
     * Example:
     * ```php
     * // 全要素を文字列的に足し合わせる
     * assertSame(array_each([1, 2, 3, 4, 5], function(&$carry, $v){$carry .= $v;}, ''), '12345');
     * // 値をキーにして要素を2乗値にする
     * assertSame(array_each([1, 2, 3, 4, 5], function(&$carry, $v){$carry[$v] = $v * $v;}, []), [
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     *     4 => 16,
     *     5 => 25,
     * ]);
     * // 上記と同じ。ただし、3 で break する
     * assertSame(array_each([1, 2, 3, 4, 5], function(&$carry, $v, $k){
     *     if ($k === 3) return false;
     *     $carry[$v] = $v * $v;
     * }, []), [
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     * ]);
     *
     * // 下記は完全に同じ（第3引数の代わりにデフォルト引数を使っている）
     * assertSame(
     *     array_each([1, 2, 3], function(&$carry = [], $v) {
     *         $carry[$v] = $v * $v;
     *     }),
     *     array_each([1, 2, 3], function(&$carry, $v) {
     *         $carry[$v] = $v * $v;
     *     }, [])
     *     // 個人的に↑のようなぶら下がり引数があまり好きではない（クロージャを最後の引数にしたい）
     * );
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param callable $callback 評価クロージャ。(&$carry, $key, $value) を受ける
     * @param mixed $default ループの最初や空の場合に適用される値
     * @return mixed each した結果
     */
    function array_each($array, $callback, $default = null)
    {
        if (func_num_args() === 2) {
            /** @var \ReflectionFunction $ref */
            $ref = (reflect_callable)($callback);
            $params = $ref->getParameters();
            if ($params[0]->isDefaultValueAvailable()) {
                $default = $params[0]->getDefaultValue();
            }
        }

        $n = 0;
        foreach ($array as $k => $v) {
            $return = $callback($default, $v, $k, $n++);
            if ($return === false) {
                break;
            }
        }
        return $default;
    }
}

const array_depth = 'ryunosuke\\Functions\\array_depth';
if (!isset($excluded_functions['array_depth']) && (!function_exists('ryunosuke\\Functions\\array_depth') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_depth'))->isInternal()))) {
    /**
     * 配列の次元数を返す
     *
     * フラット配列は 1 と定義する。
     * つまり、配列を与える限りは 0 以下を返すことはない。
     *
     * Example:
     * ```php
     * assertSame(array_depth([]), 1);
     * assertSame(array_depth(['hoge']), 1);
     * assertSame(array_depth([['nest1' => ['nest2']]]), 3);
     * ```
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

const array_insert = 'ryunosuke\\Functions\\array_insert';
if (!isset($excluded_functions['array_insert']) && (!function_exists('ryunosuke\\Functions\\array_insert') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_insert'))->isInternal()))) {
    /**
     * 配列・連想配列を問わず任意の位置に値を挿入する
     *
     * $position を省略すると最後に挿入される（≒ array_push）。
     * $position に負数を与えると後ろから数えられる。
     * $value には配列も与えられるが、その場合数値キーは振り直される
     *
     * Example:
     * ```php
     * assertSame(array_insert([1, 2, 3], 'x'), [1, 2, 3, 'x']);
     * assertSame(array_insert([1, 2, 3], 'x', 1), [1, 'x', 2, 3]);
     * assertSame(array_insert([1, 2, 3], 'x', -1), [1, 2, 'x', 3]);
     * assertSame(array_insert([1, 2, 3], ['a' => 'A', 'b' => 'B'], 1), [1, 'a' => 'A', 'b' => 'B', 2, 3]);
     * ```
     *
     * @param array $array 対象配列
     * @param mixed $value 挿入値
     * @param int|null $position 挿入位置
     * @return array 挿入された新しい配列
     */
    function array_insert($array, $value, $position = null)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $position = is_null($position) ? count($array) : intval($position);

        $sarray = array_splice($array, 0, $position);
        return array_merge($sarray, $value, $array);
    }
}

const array_assort = 'ryunosuke\\Functions\\array_assort';
if (!isset($excluded_functions['array_assort']) && (!function_exists('ryunosuke\\Functions\\array_assort') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_assort'))->isInternal()))) {
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
     * ```php
     * // lt2(2より小さい)で分類
     * $lt2 = function($v){return $v < 2;};
     * assertSame(array_assort([1, 2, 3], ['lt2' => $lt2]), ['lt2' => [1]]);
     * // lt3(3より小さい)、ctd(ctype_digit)で分類（両方に属する要素が存在する）
     * $lt3 = function($v){return $v < 3;};
     * assertSame(array_assort(['1', '2', '3'], ['lt3' => $lt3, 'ctd' => 'ctype_digit']), ['lt3' => ['1', '2'], 'ctd' => ['1', '2', '3']]);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param callable[] $rules 分類ルール。[key => callable] 形式
     * @return array 分類された新しい配列
     */
    function array_assort($array, $rules)
    {
        $result = array_fill_keys(array_keys($rules), []);
        foreach ($rules as $name => $rule) {
            $rule = (func_user_func_array)($rule);
            foreach ($array as $k => $v) {
                if ($rule($v, $k)) {
                    $result[$name][$k] = $v;
                }
            }
        }
        return $result;
    }
}

const array_count = 'ryunosuke\\Functions\\array_count';
if (!isset($excluded_functions['array_count']) && (!function_exists('ryunosuke\\Functions\\array_count') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_count'))->isInternal()))) {
    /**
     * 配列をコールバックに従ってカウントする
     *
     * コールバックが true 相当を返した要素をカウントして返す。
     * 普通に使う分には `count(array_filter($array, $callback))` とほとんど同じだが、下記の点が微妙に異なる。
     * - $callback が要求するならキーも渡ってくる
     * - $callback には配列が渡せる。配列を渡した場合は件数を配列で返す（Example 参照）
     *
     * Example:
     * ```php
     * $array = ['hoge', 'fuga', 'piyo'];
     * // 'o' を含むものの数（2個）
     * assertSame(array_count($array, function($s){return strpos($s, 'o') !== false;}), 2);
     * // 'a' と 'o' を含むものをそれぞれ（1個と2個）
     * assertSame(array_count($array, [
     *     'a' => function($s){return strpos($s, 'a') !== false;},
     *     'o' => function($s){return strpos($s, 'o') !== false;},
     * ]), ['a' => 1, 'o' => 2]);
     * ```
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
                $rule = (func_user_func_array)($rule);
                foreach ($array as $k => $v) {
                    if ($rule($v, $k)) {
                        $result[$name]++;
                    }
                }
            }
            return $result;
        }

        $callback = (func_user_func_array)($callback);
        $result = 0;
        foreach ($array as $k => $v) {
            if ($callback($v, $k)) {
                $result++;
            }
        }
        return $result;
    }
}

const array_group = 'ryunosuke\\Functions\\array_group';
if (!isset($excluded_functions['array_group']) && (!function_exists('ryunosuke\\Functions\\array_group') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_group'))->isInternal()))) {
    /**
     * 配列をコールバックの返り値でグループ化する
     *
     * コールバックが配列を返すと入れ子としてグループする。
     *
     * Example:
     * ```php
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
     * ```
     *
     * @param array|\Traversable 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
     * @return array グルーピングされた配列
     */
    function array_group($array, $callback = null, $preserve_keys = false)
    {
        $callback = (func_user_func_array)($callback);

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

const array_all = 'ryunosuke\\Functions\\array_all';
if (!isset($excluded_functions['array_all']) && (!function_exists('ryunosuke\\Functions\\array_all') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_all'))->isInternal()))) {
    /**
     * 全要素が true になるなら true を返す（1つでも false なら false を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * assertTrue(array_all([true, true]));
     * assertFalse(array_all([true, false]));
     * assertFalse(array_all([false, false]));
     * ```
     *
     * @param array|\Traversable 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が true なら true
     */
    function array_all($array, $callback = null, $default = true)
    {
        if (empty($array)) {
            return $default;
        }

        $callback = (func_user_func_array)($callback);

        foreach ($array as $k => $v) {
            if (!$callback($v, $k)) {
                return false;
            }
        }
        return true;
    }
}

const array_any = 'ryunosuke\\Functions\\array_any';
if (!isset($excluded_functions['array_any']) && (!function_exists('ryunosuke\\Functions\\array_any') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_any'))->isInternal()))) {
    /**
     * 全要素が false になるなら false を返す（1つでも true なら true を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * assertTrue(array_any([true, true]));
     * assertTrue(array_any([true, false]));
     * assertFalse(array_any([false, false]));
     * ```
     *
     * @param array|\Traversable 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が false なら false
     */
    function array_any($array, $callback = null, $default = false)
    {
        if (empty($array)) {
            return $default;
        }

        $callback = (func_user_func_array)($callback);

        foreach ($array as $k => $v) {
            if ($callback($v, $k)) {
                return true;
            }
        }
        return false;
    }
}

const array_order = 'ryunosuke\\Functions\\array_order';
if (!isset($excluded_functions['array_order']) && (!function_exists('ryunosuke\\Functions\\array_order') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_order'))->isInternal()))) {
    /**
     * 配列を $orders に従って並べ替える
     *
     * データベースからフェッチしたような連想配列の配列を想定しているが、スカラー配列(['key' => 'value'])にも対応している。
     * その場合 $orders に配列ではなく直値を渡せば良い。
     *
     * $orders には下記のような配列を渡す。
     *
     * ```php
     * $orders = [
     *     'col1' => true,                               // true: 昇順, false: 降順。照合は型に依存
     *     'col2' => SORT_NATURAL,                       // SORT_NATURAL, SORT_REGULAR などで照合。正数で昇順、負数で降順
     *     'col3' => ['sort', 'this', 'order'],          // 指定した配列順で昇順
     *     'col4' => function($v) {return $v;},          // クロージャを通した値で昇順。照合は返り値の型(php7 は returnType)に依存
     *     'col5' => function($a, $b) {return $a - $b;}, // クロージャで比較して昇順（いわゆる比較関数を渡す）
     * ];
     * ```
     *
     * Example:
     * ```php
     * $v1 = ['id' => '1', 'no' => 'a03', 'name' => 'yyy'];
     * $v2 = ['id' => '2', 'no' => 'a4',  'name' => 'yyy'];
     * $v3 = ['id' => '3', 'no' => 'a12', 'name' => 'xxx'];
     * // name 昇順, no 自然降順
     * assertSame(array_order([$v1, $v2, $v3], ['name' => true, 'no' => -SORT_NATURAL]), [$v3, $v2, $v1]);
     * ```
     *
     * @param array $array 対象配列
     * @param mixed $orders ソート順
     * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
     * @return array 並び替えられた配列
     */
    function array_order(array $array, $orders, $preserve_keys = false)
    {
        if (count($array) <= 1) {
            return $array;
        }

        if (!is_array($orders) || !(is_hasharray)($orders)) {
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
                    $type = $ref->hasReturnType() ? (string) $ref->getReturnType() : gettype(reset($arg));
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
            $args[] = &$array;
            $args[] = &$keys;
            array_multisort(...$args);
            return array_combine($keys, $array);
        }
        // キーを保持しないなら単純呼び出しで OK
        else {
            $args[] = &$array;
            array_multisort(...$args);
            return $array;
        }
    }
}

const array_shuffle = 'ryunosuke\\Functions\\array_shuffle';
if (!isset($excluded_functions['array_shuffle']) && (!function_exists('ryunosuke\\Functions\\array_shuffle') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_shuffle'))->isInternal()))) {
    /**
     * shuffle のキーが保存される＋参照渡しではない版
     *
     * Example:
     * ```php
     * assertEquals(array_shuffle(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['b' => 'B', 'a' => 'A', 'c' => 'C']);
     * ```
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

const array_shrink_key = 'ryunosuke\\Functions\\array_shrink_key';
if (!isset($excluded_functions['array_shrink_key']) && (!function_exists('ryunosuke\\Functions\\array_shrink_key') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_shrink_key'))->isInternal()))) {
    /**
     * 値の優先順位を逆にした array_intersect_key
     *
     * array_intersect_key は「左優先で共通項を取る」という動作だが、この関数は「右優先で共通項を取る」という動作になる。
     * 「配列の並び順はそのままで値だけ変えたい/削ぎ落としたい」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * $array1 = ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'];
     * $array2 = ['c' => 'C2', 'b' => 'B2', 'a' => 'A2'];
     * $array3 = ['c' => 'C3', 'dummy' => 'DUMMY'];
     * // 全共通項である 'c' キーのみが生き残り、その値は最後の 'C3' になる
     * assertSame(array_shrink_key($array1, $array2, $array3), ['c' => 'C3']);
     * ```
     *
     * @param array|\Traversable[] $variadic 共通項を取る配列（可変引数）
     * @return array 新しい配列
     */
    function array_shrink_key(...$variadic)
    {
        $result = [];
        foreach ($variadic as $n => $array) {
            if (!is_array($array)) {
                $variadic[$n] = (arrayval)($array, false);
            }
            $result = array_replace($result, $variadic[$n]);
        }
        return array_intersect_key($result, ...$variadic);
    }
}

const array_pickup = 'ryunosuke\\Functions\\array_pickup';
if (!isset($excluded_functions['array_pickup']) && (!function_exists('ryunosuke\\Functions\\array_pickup') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_pickup'))->isInternal()))) {
    /**
     * キーを指定してそれだけの配列にする
     *
     * `array_intersect_key($array, array_flip($keys))` とほぼ同義。
     * 違いは Traversable を渡せることと、結果配列の順番が $keys に従うこと。
     *
     * $keys に連想配列を渡すとキーを読み替えて動作する（Example を参照）。
     *
     * Example:
     * ```php
     * // a と c を取り出す
     * assertSame(array_pickup(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['a', 'c']), ['a' => 'A', 'c' => 'C']);
     * // 順番は $keys 基準になる
     * assertSame(array_pickup(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['c', 'a']), ['c' => 'C', 'a' => 'A']);
     * // 連想配列を渡すと読み替えて返す
     * assertSame(array_pickup(['a' => 'A', 'b' => 'B', 'c' => 'C'], ['c' => 'cX', 'a' => 'aX']), ['cX' => 'C', 'aX' => 'A']);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param array $keys 取り出すキー（可変引数）
     * @return array 新しい配列
     */
    function array_pickup($array, $keys)
    {
        if (!is_array($array)) {
            $array = (arrayval)($array, false);
        }

        $result = [];
        foreach ($keys as $k => $key) {
            if (is_int($k)) {
                if (array_key_exists($key, $array)) {
                    $result[$key] = $array[$key];
                }
            }
            else {
                if (array_key_exists($k, $array)) {
                    $result[$key] = $array[$k];
                }
            }
        }
        return $result;
    }
}

const array_lookup = 'ryunosuke\\Functions\\array_lookup';
if (!isset($excluded_functions['array_lookup']) && (!function_exists('ryunosuke\\Functions\\array_lookup') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_lookup'))->isInternal()))) {
    /**
     * キー保存可能な array_column
     *
     * array_column は キーを保存することが出来ないが、この関数は引数を2つだけ与えるとキーはそのままで array_column 相当の配列を返す。
     *
     * Example:
     * ```php
     * $array = [11 => ['id' => 1, 'name' => 'name1'], 12 => ['id' => 2, 'name' => 'name2'], 13 => ['id' => 3, 'name' => 'name3']];
     * // 第3引数を渡せば array_column と全く同じ
     * assertSame(array_lookup($array, 'name', 'id'), array_column($array, 'name', 'id'));
     * assertSame(array_lookup($array, 'name', null), array_column($array, 'name', null));
     * // 省略すればキーが保存される
     * assertSame(array_lookup($array, 'name'), [11 => 'name1', 12 => 'name2', 13 => 'name3']);
     * assertSame(array_lookup($array), $array);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param string|null $column_key 値となるキー
     * @param string|null $index_key キーとなるキー
     * @return array 新しい配列
     */
    function array_lookup($array, $column_key = null, $index_key = null)
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

const array_columns = 'ryunosuke\\Functions\\array_columns';
if (!isset($excluded_functions['array_columns']) && (!function_exists('ryunosuke\\Functions\\array_columns') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_columns'))->isInternal()))) {
    /**
     * 全要素に対して array_column する
     *
     * 行列が逆転するイメージ。
     *
     * Example:
     * ```php
     * $row1 = ['id' => 1, 'name' => 'A'];
     * $row2 = ['id' => 2, 'name' => 'B'];
     * $rows = [$row1, $row2];
     * assertSame(array_columns($rows), ['id' => [1, 2], 'name' => ['A', 'B']]);
     * assertSame(array_columns($rows, 'id'), ['id' => [1, 2]]);
     * assertSame(array_columns($rows, 'name', 'id'), ['name' => [1 => 'A', 2 => 'B']]);
     * ```
     *
     * @param array $array 対象配列
     * @param string|array $column_keys 引っ張ってくるキー名
     * @param mixed $index_key 新しい配列のキーとなるキー名
     * @return array 新しい配列
     */
    function array_columns($array, $column_keys = null, $index_key = null)
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

const array_uncolumns = 'ryunosuke\\Functions\\array_uncolumns';
if (!isset($excluded_functions['array_uncolumns']) && (!function_exists('ryunosuke\\Functions\\array_uncolumns') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_uncolumns'))->isInternal()))) {
    /**
     * array_columns のほぼ逆で [キー => [要素]] 配列から連想配列の配列を生成する
     *
     * $template を指定すると「それに含まれる配列かつ値がデフォルト」になる（要するに $default みたいなもの）。
     * キーがバラバラな配列を指定する場合は指定したほうが良い。が、null を指定すると最初の要素が使われるので大抵の場合は null で良い。
     *
     * Example:
     * ```php
     * assertSame(array_uncolumns(['id' => [1, 2], 'name' => ['A', 'B']]), [
     *     ['id' => 1, 'name' => 'A'],
     *     ['id' => 2, 'name' => 'B'],
     * ]);
     * ```
     *
     * @param array $array 対象配列
     * @param array $template 抽出要素とそのデフォルト値
     * @return array 新しい配列
     */
    function array_uncolumns($array, $template = null)
    {
        // 指定されていないなら生のまま
        if (func_num_args() === 1) {
            $template = false;
        }
        // null なら最初の要素のキー・null
        if ($template === null) {
            $template = array_fill_keys(array_keys((first_value)($array)), null);
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

const array_convert = 'ryunosuke\\Functions\\array_convert';
if (!isset($excluded_functions['array_convert']) && (!function_exists('ryunosuke\\Functions\\array_convert') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_convert'))->isInternal()))) {
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
     * ```php
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
     * ```
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

const array_flatten = 'ryunosuke\\Functions\\array_flatten';
if (!isset($excluded_functions['array_flatten']) && (!function_exists('ryunosuke\\Functions\\array_flatten') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_flatten'))->isInternal()))) {
    /**
     * 多階層配列をフラットに展開する
     *
     * 巷にあふれている実装と違って、 ["$pkey.$ckey" => $value] 形式の配列でも返せる。
     * $delimiter で区切り文字を指定した場合にそのようになる。
     * $delimiter = null の場合に本当の配列で返す（巷の実装と同じ）。
     *
     * Example:
     * ```php
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
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param string|null $delimiter キーの区切り文字。 null を与えると連番になる
     * @return array フラット化された配列
     */
    function array_flatten($array, $delimiter = null)
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

const array_nest = 'ryunosuke\\Functions\\array_nest';
if (!isset($excluded_functions['array_nest']) && (!function_exists('ryunosuke\\Functions\\array_nest') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_nest'))->isInternal()))) {
    /**
     * シンプルな [キー => 値] な配列から階層配列を生成する
     *
     * 定義的に array_flatten の逆関数のような扱いになる。
     * $delimiter で階層を表現する。
     *
     * 同名とみなされるキーは上書きされるか例外が飛ぶ。具体的には Example を参照。
     *
     * Example:
     * ```php
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
     * ```
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

const array_difference = 'ryunosuke\\Functions\\array_difference';
if (!isset($excluded_functions['array_difference']) && (!function_exists('ryunosuke\\Functions\\array_difference') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\array_difference'))->isInternal()))) {
    /**
     * 配列の差分を取り配列で返す
     *
     * 返り値の配列は構造化されたデータではない。
     * 主に文字列化して出力することを想定している。
     *
     * ユースケースとしては「スキーマデータ」「各環境の設定ファイル」などの差分。
     *
     * - '+' はキーが追加されたことを表す
     * - '-' はキーが削除されたことを表す
     * - 両方が含まれている場合、値の変更を表す
     *
     * 数値キーはキーの比較は行われない。値の差分のみ返す。
     *
     * Example:
     * ```php
     * // common は 中身に差分がある。 1 に key1 はあるが、 2 にはない。2 に key2 はあるが、 1 にはない。
     * assertSame(array_difference([
     *     'common' => [
     *         'sub' => [
     *             'x' => 'val',
     *         ]
     *     ],
     *     'key1'   => 'hoge',
     * ], [
     *     'common' => [
     *         'sub' => [
     *             'x' => 'VAL',
     *         ]
     *     ],
     *     'key2'   => 'fuga',
     * ]), [
     *     'common.sub.x' => ['-' => 'val', '+' => 'VAL'],
     *     'key1'         => ['-' => 'hoge'],
     *     'key2'         => ['+' => 'fuga'],
     * ]);
     * ```
     *
     * @param array|\Traversable $array1 対象配列1
     * @param array|\Traversable $array2 対象配列2
     * @param string $delimiter 差分配列のキー区切り文字
     * @return array 差分を表す配列
     */
    function array_difference($array1, $array2, $delimiter = '.')
    {
        $rule = [
            'list' => static function ($v, $k) { return is_int($k); },
            'hash' => static function ($v, $k) { return !is_int($k); },
        ];
        $prefixer = static function ($key, $k) use ($delimiter) {
            return $key === '' ? $k : $key . $delimiter . $k;
        };

        return call_user_func($f = static function ($array1, $array2, $key = '') use (&$f, $rule, $prefixer) {
            $result = [];

            $array1 = (array_assort)($array1, $rule);
            $array2 = (array_assort)($array2, $rule);

            foreach (array_diff($array1['list'], $array2['list']) as $k => $v1) {
                $prefix = $prefixer($key, $k);
                $result[$prefix] = ['-' => $v1];
            }
            foreach (array_diff($array2['list'], $array1['list']) as $k => $v2) {
                $prefix = $prefixer($key, $k);
                $result[$prefix] = ['+' => $v2];
            }
            foreach ($array1['hash'] + $array2['hash'] as $k => $dummy) {
                $exists1 = array_key_exists($k, $array1['hash']);
                $exists2 = array_key_exists($k, $array2['hash']);

                $v1 = $exists1 ? $array1['hash'][$k] : null;
                $v2 = $exists2 ? $array2['hash'][$k] : null;

                $is_array1 = is_array($v1);
                $is_array2 = is_array($v2);

                $prefix = $prefixer($key, $k);
                if ($exists1 && $exists2) {
                    if ($is_array1 && $is_array2) {
                        $result += $f($v1, $v2, $prefix);
                    }
                    elseif ($is_array1) {
                        $result += $f($v1, [], $prefix);
                        $result[$prefix] = ['+' => $v2];
                    }
                    elseif ($is_array2) {
                        $result[$prefix] = ['-' => $v1];
                        $result += $f([], $v2, $prefix);
                    }
                    elseif ($v1 !== $v2) {
                        $result[$prefix] = ['-' => $v1, '+' => $v2];
                    }
                }
                elseif ($exists1) {
                    $result[$prefix] = ['-' => $v1];
                }
                elseif ($exists2) {
                    $result[$prefix] = ['+' => $v2];
                }
            }

            return $result;
        }, $array1, $array2);
    }
}

const stdclass = 'ryunosuke\\Functions\\stdclass';
if (!isset($excluded_functions['stdclass']) && (!function_exists('ryunosuke\\Functions\\stdclass') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\stdclass'))->isInternal()))) {
    /**
     * 初期フィールド値を与えて stdClass を生成する
     *
     * 手元にある配列でサクッと stdClass を作りたいことがまれによくあるはず。
     *
     * object キャストでもいいんだが、 Iterator/Traversable とかも stdClass 化したいかもしれない。
     * それにキャストだとコールバックで呼べなかったり、数値キーが死んだりして微妙に使いづらいところがある。
     *
     * Example:
     * ```php
     * // 基本的には object キャストと同じ
     * $fields = ['a' => 'A', 'b' => 'B'];
     * assertEquals(stdclass($fields), (object) $fields);
     * // ただしこういうことはキャストでは出来ない
     * assertEquals(array_map('stdclass', [$fields]), [(object) $fields]); // コールバックとして利用する
     * assertTrue(property_exists(stdclass(['a', 'b']), '0')); // 数値キー付きオブジェクトにする
     * ```
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

const detect_namespace = 'ryunosuke\\Functions\\detect_namespace';
if (!isset($excluded_functions['detect_namespace']) && (!function_exists('ryunosuke\\Functions\\detect_namespace') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\detect_namespace'))->isInternal()))) {
    /**
     * ディレクトリ構造から名前空間を推測して返す
     *
     * 指定パスに名前空間を持つような php ファイルが有るならその名前空間を返す。
     * 指定パスに名前空間を持つような php ファイルが無いなら親をたどる。
     * 親に名前空間を持つような php ファイルが有るならその名前空間＋ローカルパスを返す。
     *
     * 言葉で表すとややこしいが、「そのパスに配置しても違和感の無い名前空間」を返してくれるはず。
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
        return (dirname_r)($location, function ($directory) use ($detectNS, &$basenames) {
            foreach (array_filter(glob("$directory/*.php"), 'is_file') as $file) {
                $namespace = $detectNS($file);
                if ($namespace !== null) {
                    $localspace = implode('\\', array_reverse($basenames));
                    return rtrim($namespace . '\\' . $localspace, '\\');
                }
            }
            $basenames[] = pathinfo($directory, PATHINFO_FILENAME);
        }) ?: (throws)(new \InvalidArgumentException('can not detect namespace. invalid output path or not specify namespace.'));
    }
}

const class_loader = 'ryunosuke\\Functions\\class_loader';
if (!isset($excluded_functions['class_loader']) && (!function_exists('ryunosuke\\Functions\\class_loader') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\class_loader'))->isInternal()))) {
    /**
     * composer のクラスローダを返す
     *
     * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
     *
     * Example:
     * ```php
     * assertInstanceof(\Composer\Autoload\ClassLoader::class, class_loader());
     * ```
     *
     * @param string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
     * @return \Composer\Autoload\ClassLoader クラスローダ
     */
    function class_loader($startdir = null)
    {
        $file = (cache)('path', function () use ($startdir) {
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

const class_namespace = 'ryunosuke\\Functions\\class_namespace';
if (!isset($excluded_functions['class_namespace']) && (!function_exists('ryunosuke\\Functions\\class_namespace') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\class_namespace'))->isInternal()))) {
    /**
     * クラスの名前空間部分を取得する
     *
     * Example:
     * ```php
     * assertSame(class_namespace('vendor\\namespace\\ClassName'), 'vendor\\namespace');
     * ```
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

const class_shorten = 'ryunosuke\\Functions\\class_shorten';
if (!isset($excluded_functions['class_shorten']) && (!function_exists('ryunosuke\\Functions\\class_shorten') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\class_shorten'))->isInternal()))) {
    /**
     * クラスの名前空間部分を除いた短い名前を取得する
     *
     * Example:
     * ```php
     * assertSame(class_shorten('vendor\\namespace\\ClassName'), 'ClassName');
     * ```
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

const class_replace = 'ryunosuke\\Functions\\class_replace';
if (!isset($excluded_functions['class_replace']) && (!function_exists('ryunosuke\\Functions\\class_replace') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\class_replace'))->isInternal()))) {
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
     * @param string $class 対象クラス名
     * @param \Closure $register 置換クラスを定義 or 返すクロージャ。「返せる」のは php7.0 以降のみ
     * @param string $dirname 一時ファイル書き出しディレクトリ。指定すると実質的にキャッシュとして振る舞う
     */
    function class_replace($class, $register, $dirname = null)
    {
        $class = ltrim($class, '\\');

        // 読み込み済みクラスは置換できない（php はクラスのアンロード機能が存在しない）
        if (class_exists($class, false)) {
            throw new \DomainException("'$class' is already declared.");
        }

        // 対象クラス名をちょっとだけ変えたクラスを用意して読み込む
        $classfile = (class_loader)()->findFile($class);
        $fname = rtrim(($dirname ?: sys_get_temp_dir()), '/\\') . '/' . str_replace('\\', '/', $class) . '.php';
        if (func_num_args() === 2 || !file_exists($fname)) {
            $content = file_get_contents($classfile);
            $content = preg_replace("#class\\s+[a-z0-9_]+#ui", '$0_', $content);
            (file_set_contents)($fname, $content);
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

const object_dive = 'ryunosuke\\Functions\\object_dive';
if (!isset($excluded_functions['object_dive']) && (!function_exists('ryunosuke\\Functions\\object_dive') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\object_dive'))->isInternal()))) {
    /**
     * パス形式でプロパティ値を取得
     *
     * 存在しない場合は $default を返す。
     *
     * Example:
     * ```php
     * $class = stdclass([
     *     'a' => stdclass([
     *         'b' => stdclass([
     *             'c' => 'vvv'
     *         ])
     *     ])
     * ]);
     * assertSame(object_dive($class, 'a.b.c'), 'vvv');
     * assertSame(object_dive($class, 'a.b.x', 9), 9);
     * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
     * assertSame(object_dive($class, ['a', 'b', 'c']), 'vvv');
     * ```
     *
     * @param object $object 調べるオブジェクト
     * @param string|array $path パス文字列。配列も与えられる
     * @param mixed $default 無かった場合のデフォルト値
     * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
     * @return mixed パスが示すプロパティ値
     */
    function object_dive($object, $path, $default = null, $delimiter = '.')
    {
        $keys = is_array($path) ? $path : explode($delimiter, $path);
        foreach ($keys as $key) {
            if (!isset($object->$key)) {
                return $default;
            }
            $object = $object->$key;
        }
        return $object;
    }
}

const get_object_properties = 'ryunosuke\\Functions\\get_object_properties';
if (!isset($excluded_functions['get_object_properties']) && (!function_exists('ryunosuke\\Functions\\get_object_properties') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\get_object_properties'))->isInternal()))) {
    /**
     * オブジェクトのプロパティを可視・不可視を問わず取得する
     *
     * get_object_vars + no public プロパティを返すイメージ。
     *
     * Example:
     * ```php
     * $object = new \Exception('something', 42);
     * $object->oreore = 'oreore';
     *
     * // get_object_vars はそのスコープから見えないプロパティを取得できない
     * // var_dump(get_object_vars($object));
     *
     * // array キャストは全て得られるが null 文字を含むので扱いにくい
     * // var_dump((array) $object);
     *
     * // この関数を使えば不可視プロパティも取得できる
     * assertArraySubset([
     *     'message' => 'something',
     *     'code'    => 42,
     *     'oreore'  => 'oreore',
     * ], get_object_properties($object));
     * ```
     *
     * @param object $object オブジェクト
     * @return array 全プロパティ
     */
    function get_object_properties($object)
    {
        static $refs = [];
        $class = get_class($object);
        if (!isset($refs[$class])) {
            $props = (new \ReflectionClass($class))->getProperties();
            $refs[$class] = (array_each)($props, function (&$carry, \ReflectionProperty $rp) {
                if (!$rp->isStatic()) {
                    $rp->setAccessible(true);
                    $carry[$rp->getName()] = $rp;
                }
            }, []);
        }

        // 配列キャストだと private で ヌル文字が出たり static が含まれたりするのでリフレクションで取得して勝手プロパティで埋める
        $vars = (array_map_method)($refs[$class], 'getValue', [$object]);
        $vars += get_object_vars($object);

        return $vars;
    }
}

const file_list = 'ryunosuke\\Functions\\file_list';
if (!isset($excluded_functions['file_list']) && (!function_exists('ryunosuke\\Functions\\file_list') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\file_list'))->isInternal()))) {
    /**
     * ファイル一覧を配列で返す
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $DS = DIRECTORY_SEPARATOR;
     * $tmp = sys_get_temp_dir() . "{$DS}file_list";
     * rm_rf($tmp, false);
     * file_set_contents("$tmp/a.txt", 'a');
     * file_set_contents("$tmp/dir/b.txt", 'b');
     * file_set_contents("$tmp/dir/dir/c.txt", 'c');
     * // ファイル一覧が取得できる
     * assertEquals(file_list($tmp), [
     *     "$tmp{$DS}a.txt",
     *     "$tmp{$DS}dir{$DS}b.txt",
     *     "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
     * ]);
     * ```
     *
     * @param string $dirname 調べるディレクトリ名
     * @param \Closure|array $filter_condition フィルタ条件
     * @return array|false ファイルの配列
     */
    function file_list($dirname, $filter_condition = null)
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

const file_tree = 'ryunosuke\\Functions\\file_tree';
if (!isset($excluded_functions['file_tree']) && (!function_exists('ryunosuke\\Functions\\file_tree') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\file_tree'))->isInternal()))) {
    /**
     * ディレクトリ階層をツリー構造で返す
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $DS = DIRECTORY_SEPARATOR;
     * $tmp = sys_get_temp_dir() . "{$DS}file_tree";
     * rm_rf($tmp, false);
     * file_set_contents("$tmp/a.txt", 'a');
     * file_set_contents("$tmp/dir/b.txt", 'b');
     * file_set_contents("$tmp/dir/dir/c.txt", 'c');
     * // ファイルツリーが取得できる
     * assertEquals(file_tree($tmp), [
     *     'file_tree' => [
     *         'a.txt' => "$tmp{$DS}a.txt",
     *         'dir'   => [
     *             'b.txt' => "$tmp{$DS}dir{$DS}b.txt",
     *             'dir'   => [
     *                 'c.txt' => "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
     *             ],
     *         ],
     *     ],
     * ]);
     * ```
     *
     * @param string $dirname 調べるディレクトリ名
     * @param \Closure|array $filter_condition フィルタ条件
     * @return array|false ツリー構造の配列
     */
    function file_tree($dirname, $filter_condition = null)
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
                $result[$basedir] += (file_tree)($item->getPathname(), $filter_condition);
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

const file_extension = 'ryunosuke\\Functions\\file_extension';
if (!isset($excluded_functions['file_extension']) && (!function_exists('ryunosuke\\Functions\\file_extension') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\file_extension'))->isInternal()))) {
    /**
     * ファイルの拡張子を変更する。引数を省略すると拡張子を返す
     *
     * pathinfoに準拠。例えば「filename.hoge.fuga」のような形式は「fuga」が変換対象になる。
     *
     * Example:
     * ```php
     * assertSame(file_extension('filename.ext'), 'ext');
     * assertSame(file_extension('filename.ext', 'txt'), 'filename.txt');
     * assertSame(file_extension('filename.ext', ''), 'filename');
     * ```
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

const file_set_contents = 'ryunosuke\\Functions\\file_set_contents';
if (!isset($excluded_functions['file_set_contents']) && (!function_exists('ryunosuke\\Functions\\file_set_contents') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\file_set_contents'))->isInternal()))) {
    /**
     * ディレクトリも掘る file_put_contents
     *
     * Example:
     * ```php
     * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
     * assertSame(file_get_contents(sys_get_temp_dir() . '/not/filename.ext'), 'hoge');
     * ```
     *
     * @param string $filename 書き込むファイル名
     * @param string $data 書き込む内容
     * @param int $umask ディレクトリを掘る際の umask
     * @return int 書き込まれたバイト数
     */
    function file_set_contents($filename, $data, $umask = 0002)
    {
        if (func_num_args() === 2) {
            $umask = umask();
        }

        if (!is_dir($dirname = dirname($filename))) {
            if (!@(mkdir_p)($dirname, $umask)) {
                throw new \RuntimeException("failed to mkdir($dirname)");
            }
        }
        return file_put_contents($filename, $data);
    }
}

const mkdir_p = 'ryunosuke\\Functions\\mkdir_p';
if (!isset($excluded_functions['mkdir_p']) && (!function_exists('ryunosuke\\Functions\\mkdir_p') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\mkdir_p'))->isInternal()))) {
    /**
     * ディレクトリを再帰的に掘る
     *
     * 既に存在する場合は何もしない（エラーも出さない）。
     *
     * @param string $dirname ディレクトリ名
     * @param int $umask ディレクトリを掘る際の umask
     * @return bool 作成したら true
     */
    function mkdir_p($dirname, $umask = 0002)
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

const dirname_r = 'ryunosuke\\Functions\\dirname_r';
if (!isset($excluded_functions['dirname_r']) && (!function_exists('ryunosuke\\Functions\\dirname_r') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\dirname_r'))->isInternal()))) {
    /**
     * コールバックが true 相当を返すまで親ディレクトリを辿り続ける
     *
     * コールバックには親ディレクトリが引数として渡ってくる。
     *
     * Example:
     * ```php
     * // //tmp/a/b/file.txt を作っておく
     * $tmp = sys_get_temp_dir();
     * file_set_contents("$tmp/a/b/file.txt", 'hoge');
     * // /a/b/c/d/e/f から開始して「どこかの階層の file.txt を探したい」という状況を想定
     * $callback = function($path){return realpath("$path/file.txt");};
     * assertSame(dirname_r("$tmp/a/b/c/d/e/f", $callback), realpath("$tmp/a/b/file.txt"));
     * ```
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
        return (dirname_r)($dirname, $callback);
    }
}

const fnmatch_and = 'ryunosuke\\Functions\\fnmatch_and';
if (!isset($excluded_functions['fnmatch_and']) && (!function_exists('ryunosuke\\Functions\\fnmatch_and') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\fnmatch_and'))->isInternal()))) {
    /**
     * fnmatch の AND 版
     *
     * $patterns のうちどれか一つでもマッチしなかったら false を返す。
     * $patterns が空だと例外を投げる。
     *
     * Example:
     * ```php
     * // すべてにマッチするので true
     * assertTrue(fnmatch_and(['*aaa*', '*bbb*'], 'aaaXbbbX'));
     * // aaa にはマッチするが bbb にはマッチしないので false
     * assertFalse(fnmatch_and(['*aaa*', '*bbb*'], 'aaaX'));
     * ```
     *
     * @param array|string $patterns パターン配列（単一文字列可）
     * @param string $string 調べる文字列
     * @param int $flags FNM_***
     * @return bool すべてにマッチしたら true
     */
    function fnmatch_and($patterns, $string, $flags = 0)
    {
        $patterns = (is_iterable)($patterns) ? $patterns : [$patterns];
        if (empty($patterns)) {
            throw new \InvalidArgumentException('$patterns must be not empty.');
        }

        foreach ($patterns as $pattern) {
            if (!fnmatch($pattern, $string, $flags)) {
                return false;
            }
        }
        return true;
    }
}

const fnmatch_or = 'ryunosuke\\Functions\\fnmatch_or';
if (!isset($excluded_functions['fnmatch_or']) && (!function_exists('ryunosuke\\Functions\\fnmatch_or') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\fnmatch_or'))->isInternal()))) {
    /**
     * fnmatch の OR 版
     *
     * $patterns のうちどれか一つでもマッチしたら true を返す。
     * $patterns が空だと例外を投げる。
     *
     * Example:
     * ```php
     * // aaa にマッチするので true
     * assertTrue(fnmatch_or(['*aaa*', '*bbb*'], 'aaaX'));
     * // どれともマッチしないので false
     * assertFalse(fnmatch_or(['*aaa*', '*bbb*'], 'cccX'));
     * ```
     *
     * @param array|string $patterns パターン配列（単一文字列可）
     * @param string $string 調べる文字列
     * @param int $flags FNM_***
     * @return bool どれかにマッチしたら true
     */
    function fnmatch_or($patterns, $string, $flags = 0)
    {
        $patterns = (is_iterable)($patterns) ? $patterns : [$patterns];
        if (empty($patterns)) {
            throw new \InvalidArgumentException('$patterns must be not empty.');
        }

        foreach ($patterns as $pattern) {
            if (fnmatch($pattern, $string, $flags)) {
                return true;
            }
        }
        return false;
    }
}

const path_is_absolute = 'ryunosuke\\Functions\\path_is_absolute';
if (!isset($excluded_functions['path_is_absolute']) && (!function_exists('ryunosuke\\Functions\\path_is_absolute') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\path_is_absolute'))->isInternal()))) {
    /**
     * パスが絶対パスか判定する
     *
     * Example:
     * ```php
     * assertTrue(path_is_absolute('/absolute/path'));
     * assertFalse(path_is_absolute('relative/path'));
     * // Windows 環境では下記も true になる
     * if (DIRECTORY_SEPARATOR === '\\') {
     *     assertTrue(path_is_absolute('\\absolute\\path'));
     *     assertTrue(path_is_absolute('C:\\absolute\\path'));
     * }
     * ```
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

const path_resolve = 'ryunosuke\\Functions\\path_resolve';
if (!isset($excluded_functions['path_resolve']) && (!function_exists('ryunosuke\\Functions\\path_resolve') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\path_resolve'))->isInternal()))) {
    /**
     * パスを絶対パスに変換して正規化する
     *
     * 可変引数で与えられた文字列群を結合して絶対パス化して返す。
     * 出来上がったパスが絶対パスでない場合はカレントディレクトリを結合して返す。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * assertSame(path_resolve('/absolute/path'), "{$DS}absolute{$DS}path");
     * assertSame(path_resolve('absolute/path'), getcwd() . "{$DS}absolute{$DS}path");
     * assertSame(path_resolve('/absolute/path/through', '../current/./path'), "{$DS}absolute{$DS}path{$DS}current{$DS}path");
     * ```
     *
     * @param array $paths パス文字列（可変引数）
     * @return string 絶対パス
     */
    function path_resolve(...$paths)
    {
        $DS = DIRECTORY_SEPARATOR;

        $path = implode($DS, $paths);

        if (!(path_is_absolute)($path)) {
            $path = getcwd() . $DS . $path;
        }

        return (path_normalize)($path);
    }
}

const path_normalize = 'ryunosuke\\Functions\\path_normalize';
if (!isset($excluded_functions['path_normalize']) && (!function_exists('ryunosuke\\Functions\\path_normalize') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\path_normalize'))->isInternal()))) {
    /**
     * パスを正規化する
     *
     * 具体的には ./ や ../ を取り除いたり連続したディレクトリ区切りをまとめたりする。
     * realpath ではない。のでシンボリックリンクの解決などはしない。その代わりファイルが存在しなくても使用することができる。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * assertSame(path_normalize('/path/to/something'), "{$DS}path{$DS}to{$DS}something");
     * assertSame(path_normalize('/path/through/../something'), "{$DS}path{$DS}something");
     * assertSame(path_normalize('./path/current/./through/../something'), "path{$DS}current{$DS}something");
     * ```
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

const cp_rf = 'ryunosuke\\Functions\\cp_rf';
if (!isset($excluded_functions['cp_rf']) && (!function_exists('ryunosuke\\Functions\\cp_rf') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\cp_rf'))->isInternal()))) {
    /**
     * ディレクトリのコピー
     *
     * $dst に / を付けると「$dst に自身をコピー」する。付けないと「$dst に中身をコピー」するという動作になる。
     *
     * ディレクトリではなくファイルを与えても動作する（copy とほぼ同じ動作になるが、対象にディレクトリを指定できる点が異なる）。
     *
     * Example:
     * ```php
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
     * ```
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
                (mkdir_p)($dst);
                return copy($src, $dst . basename($src));
            }
            else {
                (mkdir_p)(dirname($dst));
                return copy($src, $dst);
            }
        }

        if ($dirmode) {
            return (cp_rf)($src, $dst . basename($src));
        }

        (mkdir_p)($dst);

        foreach (glob("$src/*") as $file) {
            if (is_dir($file)) {
                (cp_rf)($file, "$dst/" . basename($file));
            }
            else {
                copy($file, "$dst/" . basename($file));
            }
        }
        return file_exists($dst);
    }
}

const rm_rf = 'ryunosuke\\Functions\\rm_rf';
if (!isset($excluded_functions['rm_rf']) && (!function_exists('ryunosuke\\Functions\\rm_rf') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\rm_rf'))->isInternal()))) {
    /**
     * 中身があっても消せる rmdir
     *
     * Example:
     * ```php
     * mkdir(sys_get_temp_dir() . '/new/make/dir', 0777, true);
     * rm_rf(sys_get_temp_dir() . '/new');
     * assertSame(file_exists(sys_get_temp_dir() . '/new'), false);
     * ```
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

const tmpname = 'ryunosuke\\Functions\\tmpname';
if (!isset($excluded_functions['tmpname']) && (!function_exists('ryunosuke\\Functions\\tmpname') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\tmpname'))->isInternal()))) {
    /**
     * 終了時に削除される一時ファイル名を生成する
     *
     * tempnam とほぼ同じで違いは下記。
     * - 引数が逆
     * - 終了時に削除される
     * - 失敗時に false を返すのではなく例外を投げる
     *
     * @param string $prefix ファイル名プレフィックス
     * @param string $dir 生成ディレクトリ。省略時は sys_get_temp_dir()
     * @return string 一時ファイル名
     */
    function tmpname($prefix = 'rft', $dir = null)
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

const delegate = 'ryunosuke\\Functions\\delegate';
if (!isset($excluded_functions['delegate']) && (!function_exists('ryunosuke\\Functions\\delegate') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\delegate'))->isInternal()))) {
    /**
     * 指定 callable を指定クロージャで実行するクロージャを返す
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @param \Closure $invoker クロージャを実行するためのクロージャ（実処理）
     * @param callable $callable 最終的に実行したいクロージャ
     * @param int $arity 引数の数
     * @return \Closure $callable を実行するクロージャ
     */
    function delegate($invoker, $callable, $arity = null)
    {
        // 「delegate 経由で作成されたクロージャ」であることをマーキングするための use 変数
        $__rfunc_delegate_marker = true;

        if ($arity === null) {
            $arity = (parameter_length)($callable, true, true);
        }

        if (is_infinite($arity)) {
            return eval('return function (...$_) use ($__rfunc_delegate_marker, $invoker, $callable) {
                return $invoker($callable, func_get_args());
            };');
        }

        $arity = abs($arity);
        switch ($arity) {
            case 0:
                return function () use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 1:
                return function ($_1) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 2:
                return function ($_1, $_2) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 3:
                return function ($_1, $_2, $_3) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 4:
                return function ($_1, $_2, $_3, $_4) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 5:
                return function ($_1, $_2, $_3, $_4, $_5) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            default:
                $argstring = (array_rmap)(range(1, $arity), strcat, '$_');
                return eval('return function (' . implode(', ', $argstring) . ') use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };');
        }
    }
}

const nbind = 'ryunosuke\\Functions\\nbind';
if (!isset($excluded_functions['nbind']) && (!function_exists('ryunosuke\\Functions\\nbind') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\nbind'))->isInternal()))) {
    /**
     * $callable の指定位置に引数を束縛したクロージャを返す
     *
     * Example:
     * ```php
     * $bind = nbind('sprintf', 2, 'X');
     * assertSame($bind('%s%s%s', 'N', 'N'), 'NXN');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param int $n 挿入する引数位置
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    function nbind($callable, $n, ...$variadic)
    {
        return (delegate)(function ($callable, $args) use ($variadic, $n) {
            return $callable(...(array_insert)($args, $variadic, $n));
        }, $callable, (parameter_length)($callable, true) - count($variadic));
    }
}

const lbind = 'ryunosuke\\Functions\\lbind';
if (!isset($excluded_functions['lbind']) && (!function_exists('ryunosuke\\Functions\\lbind') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\lbind'))->isInternal()))) {
    /**
     * $callable の最左に引数を束縛した callable を返す
     *
     * Example:
     * ```php
     * $bind = lbind('sprintf', '%s%s');
     * assertSame($bind('N', 'M'), 'NM');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    function lbind($callable, ...$variadic)
    {
        return (nbind)(...(array_insert)(func_get_args(), 0, 1));
    }
}

const rbind = 'ryunosuke\\Functions\\rbind';
if (!isset($excluded_functions['rbind']) && (!function_exists('ryunosuke\\Functions\\rbind') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\rbind'))->isInternal()))) {
    /**
     * $callable の最右に引数を束縛した callable を返す
     *
     * Example:
     * ```php
     * $bind = rbind('sprintf', 'X');
     * assertSame($bind('%s%s', 'N'), 'NX');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    function rbind($callable, ...$variadic)
    {
        return (nbind)(...(array_insert)(func_get_args(), null, 1));
    }
}

const composite = 'ryunosuke\\Functions\\composite';
if (!isset($excluded_functions['composite']) && (!function_exists('ryunosuke\\Functions\\composite') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\composite'))->isInternal()))) {
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
     * ```php
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
     * ```
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
        return (delegate)(function ($first, $args) use ($callables, $arrayalbe) {
            $result = $first(...$args);
            foreach ($callables as $callable) {
                // 「配列モードでただの配列」でないなら配列化
                if (!($arrayalbe && is_array($result) && !(is_hasharray)($result))) {
                    $result = [$result];
                }
                $result = $callable(...$result);
            }
            return $result;
        }, $first);
    }
}

const return_arg = 'ryunosuke\\Functions\\return_arg';
if (!isset($excluded_functions['return_arg']) && (!function_exists('ryunosuke\\Functions\\return_arg') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\return_arg'))->isInternal()))) {
    /**
     * $n 番目の引数（0 ベース）をそのまま返すクロージャを返す
     *
     * Example:
     * ```php
     * $arg0 = return_arg(0);
     * assertSame($arg0('hoge'), 'hoge');
     * $arg1 = return_arg(1);
     * assertSame($arg1('dummy', 'hoge'), 'hoge');
     * ```
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

const not_func = 'ryunosuke\\Functions\\not_func';
if (!isset($excluded_functions['not_func']) && (!function_exists('ryunosuke\\Functions\\not_func') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\not_func'))->isInternal()))) {
    /**
     * 返り値の真偽値を逆転した新しいクロージャを返す
     *
     * Example:
     * ```php
     * $not_strlen = not_func('strlen');
     * assertFalse($not_strlen('hoge'));
     * assertTrue($not_strlen(''));
     * ```
     *
     * @param callable $callable 対象 callable
     * @return \Closure 新しいクロージャ
     */
    function not_func($callable)
    {
        return (delegate)(function ($callable, $args) {
            return !$callable(...$args);
        }, $callable);
    }
}

const eval_func = 'ryunosuke\\Functions\\eval_func';
if (!isset($excluded_functions['eval_func']) && (!function_exists('ryunosuke\\Functions\\eval_func') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\eval_func'))->isInternal()))) {
    /**
     * 指定コードで eval するクロージャを返す
     *
     * create_function のクロージャ版みたいなもの。
     * 参照渡しは未対応。
     *
     * Example:
     * ```php
     * $evalfunc = eval_func('$a + $b + $c', 'a', 'b', 'c');
     * assertSame($evalfunc(1, 2, 3), 6);
     * ```
     *
     * @param string $expression eval コード
     * @param mixed $variadic 引数名（可変引数）
     * @return \Closure 新しいクロージャ
     */
    function eval_func($expression, ...$variadic)
    {
        $eargs = $variadic;
        return (delegate)(function ($expression, $args) use ($eargs) {
            return (function () {
                extract(func_get_arg(1));
                return eval("return " . func_get_arg(0) . ";");
            })($expression, array_combine($eargs, $args));
        }, $expression, count($eargs));
    }
}

const reflect_callable = 'ryunosuke\\Functions\\reflect_callable';
if (!isset($excluded_functions['reflect_callable']) && (!function_exists('ryunosuke\\Functions\\reflect_callable') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\reflect_callable'))->isInternal()))) {
    /**
     * callable から ReflectionFunctionAbstract を生成する
     *
     * Example:
     * ```php
     * assertInstanceof(\ReflectionFunction::class, reflect_callable('sprintf'));
     * assertInstanceof(\ReflectionMethod::class, reflect_callable('\Closure::bind'));
     * ```
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

const closurize = 'ryunosuke\\Functions\\closurize';
if (!isset($excluded_functions['closurize']) && (!function_exists('ryunosuke\\Functions\\closurize') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\closurize'))->isInternal()))) {
    /**
     * callable を Closure に変換する
     *
     * php7.1 の fromCallable みたいなもの。
     *
     * Example:
     * ```php
     * $sprintf = closurize('sprintf');
     * assertInstanceof(\Closure::class, $sprintf);
     * assertSame($sprintf('%s %s', 'hello', 'world'), 'hello world');
     * ```
     *
     * @param callable $callable 変換する callable
     * @return \Closure 変換したクロージャ
     */
    function closurize($callable)
    {
        if ($callable instanceof \Closure) {
            return $callable;
        }

        $ref = (reflect_callable)($callable);
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

const call_safely = 'ryunosuke\\Functions\\call_safely';
if (!isset($excluded_functions['call_safely']) && (!function_exists('ryunosuke\\Functions\\call_safely') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\call_safely'))->isInternal()))) {
    /**
     * エラーを例外に変換するブロックでコールバックを実行する
     *
     * Example:
     * ```php
     * try {
     *     call_safely(function(){return $v;});
     * }
     * catch (\Exception $ex) {
     *     assertSame($ex->getMessage(), 'Undefined variable: v');
     * }
     * ```
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
            return $callback(...$variadic);
        }
        finally {
            restore_error_handler();
        }
    }
}

const ob_capture = 'ryunosuke\\Functions\\ob_capture';
if (!isset($excluded_functions['ob_capture']) && (!function_exists('ryunosuke\\Functions\\ob_capture') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\ob_capture'))->isInternal()))) {
    /**
     * ob_start ～ ob_get_clean のブロックでコールバックを実行する
     *
     * Example:
     * ```php
     * assertSame(ob_capture(function(){echo 123;}), '123');
     * ```
     *
     * @param callable $callback 実行するコールバック
     * @param mixed $variadic $callback に渡される引数（可変引数）
     * @return string オフスリーンバッファの文字列
     */
    function ob_capture($callback, ...$variadic)
    {
        ob_start();
        try {
            $callback(...$variadic);
            return ob_get_contents();
        }
        finally {
            ob_end_clean();
        }
    }
}

const is_bindable_closure = 'ryunosuke\\Functions\\is_bindable_closure';
if (!isset($excluded_functions['is_bindable_closure']) && (!function_exists('ryunosuke\\Functions\\is_bindable_closure') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\is_bindable_closure'))->isInternal()))) {
    /**
     * $this を bind 可能なクロージャか調べる
     *
     * Example:
     * ```php
     * assertTrue(is_bindable_closure(function(){}));
     * assertFalse(is_bindable_closure(static function(){}));
     * ```
     *
     * @param \Closure $closure 調べるクロージャ
     * @return bool $this を bind 可能なクロージャなら true
     */
    function is_bindable_closure(\Closure $closure)
    {
        return !!@$closure->bindTo(new \stdClass());
    }
}

const by_builtin = 'ryunosuke\\Functions\\by_builtin';
if (!isset($excluded_functions['by_builtin']) && (!function_exists('ryunosuke\\Functions\\by_builtin') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\by_builtin'))->isInternal()))) {
    /**
     * Countable#count, Serializable#serialize などの「ネイティブ由来かメソッド由来か」を判定して返す
     *
     * Countable#count, Serializable#serialize のように「インターフェースのメソッド名」と「ネイティブ関数名」が一致している必要がある。
     *
     * Example:
     * ```php
     * class CountClass implements \Countable
     * {
     *     public function count() {
     *         // count 経由なら 1 を、メソッド経由なら 0 を返す
     *         return (int) by_builtin($this, 'count');
     *     }
     * }
     * $counter = new CountClass();
     * assertSame(count($counter), 1);
     * assertSame($counter->count(), 0);
     * ```
     *
     * のように判定できる。
     *
     * @param object|string $class
     * @param string $function
     * @return bool ネイティブなら true
     */
    function by_builtin($class, $function)
    {
        $class = is_object($class) ? get_class($class) : $class;

        // 特殊な方法でコールされる名前達(コールスタックの大文字小文字は正規化されるので気にする必要はない)
        $invoker = [
            'call_user_func'       => true,
            'call_user_func_array' => true,
            'invoke'               => true,
            'invokeArgs'           => true,
        ];

        $traces = array_reverse(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3));
        foreach ($traces as $trace) {
            if (isset($trace['class'], $trace['function']) && $trace['class'] === $class && $trace['function'] === $function) {
                // for $object->func()
                if (isset($trace['file'], $trace['line'])) {
                    return false;
                }
                // for call_user_func([$object, 'func']), (new ReflectionMethod($object, 'func'))->invoke($object)
                elseif (isset($last) && isset($last['function']) && isset($invoker[$last['function']])) {
                    return false;
                }
                // for func($object)
                elseif (isset($last) && isset($last['function']) && $last['function'] === $function) {
                    return true;
                }
            }
            $last = $trace;
        }
        throw new \RuntimeException('failed to search backtrace.');
    }
}

const parameter_length = 'ryunosuke\\Functions\\parameter_length';
if (!isset($excluded_functions['parameter_length']) && (!function_exists('ryunosuke\\Functions\\parameter_length') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\parameter_length'))->isInternal()))) {
    /**
     * callable の引数の数を返す
     *
     * クロージャはキャッシュされない。毎回リフレクションを生成し、引数の数を調べてそれを返す。
     * （クロージャには一意性がないので key-value なキャッシュが適用できない）。
     * ので、ループ内で使ったりすると目に見えてパフォーマンスが低下するので注意。
     *
     * Example:
     * ```php
     * // trim の引数は2つ
     * assertSame(parameter_length('trim'), 2);
     * // trim の必須引数は1つ
     * assertSame(parameter_length('trim', true), 1);
     * ```
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
            $ref = (reflect_callable)($callable);
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

        $cache = (cache)($call_name, function () use ($callable) {
            /** @var \ReflectionFunctionAbstract $ref */
            $ref = (reflect_callable)($callable);
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

const function_shorten = 'ryunosuke\\Functions\\function_shorten';
if (!isset($excluded_functions['function_shorten']) && (!function_exists('ryunosuke\\Functions\\function_shorten') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\function_shorten'))->isInternal()))) {
    /**
     * 関数の名前空間部分を除いた短い名前を取得する
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

const func_user_func_array = 'ryunosuke\\Functions\\func_user_func_array';
if (!isset($excluded_functions['func_user_func_array']) && (!function_exists('ryunosuke\\Functions\\func_user_func_array') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\func_user_func_array'))->isInternal()))) {
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
     * ```php
     * // strlen に2つの引数を渡してもエラーにならない
     * $strlen = func_user_func_array('strlen');
     * assertSame($strlen('abc', null), 3);
     * ```
     *
     * @param callable $callback 呼び出すクロージャ
     * @return \Closure 引数ぴったりで呼び出すクロージャ
     */
    function func_user_func_array($callback)
    {
        // null は第1引数を返す特殊仕様
        if ($callback === null) {
            return function ($v) { return $v; };
        }
        // クロージャはユーザ定義しかありえないので調べる必要がない
        if ($callback instanceof \Closure) {
            // が、組み込みをバイパスする delegate はクロージャなのでそれだけは除外
            $uses = (reflect_callable)($callback)->getStaticVariables();
            if (!isset($uses['__rfunc_delegate_marker'])) {
                return $callback;
            }
        }

        // 上記以外は「引数ぴったりで削ぎ落としてコールするクロージャ」を返す
        $plength = (parameter_length)($callback, true, true);
        return (delegate)(function ($callback, $args) use ($plength) {
            if (is_infinite($plength)) {
                return $callback(...$args);
            }
            return $callback(...array_slice($args, 0, $plength));
        }, $callback, $plength);
    }
}

const function_alias = 'ryunosuke\\Functions\\function_alias';
if (!isset($excluded_functions['function_alias']) && (!function_exists('ryunosuke\\Functions\\function_alias') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\function_alias'))->isInternal()))) {
    /**
     * 関数のエイリアスを作成する
     *
     * 単に移譲するだけではなく、参照渡し・参照返しも模倣される。
     * その代わり、単純なエイリアスではなく別定義で吐き出すので「エイリアス」ではなく「処理が同じな別関数」と思ったほうがよい。
     *
     * 静的であればクラスメソッドも呼べる。
     *
     * Example:
     * ```php
     * // trim のエイリアス
     * function_alias('trim', 'trim_alias');
     * assertSame(trim_alias(' abc '), 'abc');
     * ```
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
        $ref = (reflect_callable)($original);
        if ($ref instanceof \ReflectionMethod && !$ref->isStatic()) {
            throw new \InvalidArgumentException("$calllname is non-static method.");
        }
        // エイリアスが既に存在している
        if (function_exists($alias)) {
            throw new \InvalidArgumentException("$alias is already declared.");
        }

        // キャッシュ指定有りなら読み込むだけで eval しない
        $cachedir = (ifelse)($cachedir, true, sys_get_temp_dir());
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

const minimum = 'ryunosuke\\Functions\\minimum';
if (!isset($excluded_functions['minimum']) && (!function_exists('ryunosuke\\Functions\\minimum') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\minimum'))->isInternal()))) {
    /**
     * 引数の最小値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(minimum(-1, 0, 1), -1);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最小値
     */
    function minimum(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        return min($args);
    }
}

const maximum = 'ryunosuke\\Functions\\maximum';
if (!isset($excluded_functions['maximum']) && (!function_exists('ryunosuke\\Functions\\maximum') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\maximum'))->isInternal()))) {
    /**
     * 引数の最大値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(maximum(-1, 0, 1), 1);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最大値
     */
    function maximum(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        return max($args);
    }
}

const mode = 'ryunosuke\\Functions\\mode';
if (!isset($excluded_functions['mode']) && (!function_exists('ryunosuke\\Functions\\mode') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\mode'))->isInternal()))) {
    /**
     * 引数の最頻値を返す
     *
     * - 等価比較は文字列で行う。小数時は注意。おそらく php.ini の precision に従うはず
     * - 等価値が複数ある場合の返り値は不定
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(mode(0, 1, 2, 2, 3, 3, 3), 3);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最頻値
     */
    function mode(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        $vals = array_map(function ($v) {
            if (is_object($v)) {
                // ここに特別扱いのオブジェクトを列挙していく
                if ($v instanceof \DateTimeInterface) {
                    return $v->getTimestamp();
                }
                // それ以外は stringify へ移譲（__toString もここに含まれている）
                return (stringify)($v);
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

const mean = 'ryunosuke\\Functions\\mean';
if (!isset($excluded_functions['mean']) && (!function_exists('ryunosuke\\Functions\\mean') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\mean'))->isInternal()))) {
    /**
     * 引数の相加平均値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(mean(1, 2, 3, 4, 5, 6), 3.5);
     * assertSame(mean(1, '2', 3, 'noize', 4, 5, 'noize', 6), 3.5);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return int|float 相加平均値
     */
    function mean(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or (throws)(new \LengthException("argument's must be contain munber."));
        return array_sum($args) / count($args);
    }
}

const median = 'ryunosuke\\Functions\\median';
if (!isset($excluded_functions['median']) && (!function_exists('ryunosuke\\Functions\\median') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\median'))->isInternal()))) {
    /**
     * 引数の中央値を返す
     *
     * - 要素数が奇数の場合は完全な中央値/偶数の場合は中2つの平均。「平均」という概念が存在しない値なら中2つの後の値
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * // 偶数個なので中2つの平均
     * assertSame(median(1, 2, 3, 4, 5, 6), 3.5);
     * // 奇数個なのでど真ん中
     * assertSame(median(1, 2, 3, 4, 5), 3);
     * // 偶数個だが文字列なので中2つの後
     * assertSame(median('a', 'b', 'c', 'd'), 'c');
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 中央値
     */
    function median(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
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

const average = 'ryunosuke\\Functions\\average';
if (!isset($excluded_functions['average']) && (!function_exists('ryunosuke\\Functions\\average') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\average'))->isInternal()))) {
    /**
     * 引数の意味平均値を返す
     *
     * - 3座標の重心座標とか日付の平均とかそういうもの
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
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

const sum = 'ryunosuke\\Functions\\sum';
if (!isset($excluded_functions['sum']) && (!function_exists('ryunosuke\\Functions\\sum') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\sum'))->isInternal()))) {
    /**
     * 引数の合計値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(sum(1, 2, 3, 4, 5, 6), 21);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 合計値
     */
    function sum(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or (throws)(new \LengthException("argument's must be contain munber."));
        return array_sum($args);
    }
}

const random_at = 'ryunosuke\\Functions\\random_at';
if (!isset($excluded_functions['random_at']) && (!function_exists('ryunosuke\\Functions\\random_at') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\random_at'))->isInternal()))) {
    /**
     * 引数をランダムで返す
     *
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * // 1 ～ 6 のどれかを返す
     * assertContains(random_at(1, 2, 3, 4, 5, 6), [1, 2, 3, 4, 5, 6]);
     * ```
     *
     * @param array $args 候補
     * @return mixed 引数のうちどれか
     */
    function random_at(...$args)
    {
        return $args[mt_rand(0, count($args) - 1)];
    }
}

const probability = 'ryunosuke\\Functions\\probability';
if (!isset($excluded_functions['probability']) && (!function_exists('ryunosuke\\Functions\\probability') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\probability'))->isInternal()))) {
    /**
     * 一定確率で true を返す
     *
     * 具体的には $probability / $divisor の確率で true を返す。
     * $divisor のデフォルトは 100 にしてあるので、 $probability だけ与えれば $probability パーセントで true を返すことになる。
     *
     * Example:
     * ```php
     * // 50% の確率で "hello" を出す
     * if (probability(50)) {
     *     echo "hello";
     * }
     * ```
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

const strcat = 'ryunosuke\\Functions\\strcat';
if (!isset($excluded_functions['strcat']) && (!function_exists('ryunosuke\\Functions\\strcat') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\strcat'))->isInternal()))) {
    /**
     * 文字列結合の関数版
     *
     * Example:
     * ```php
     * assertSame(strcat('a', 'b', 'c'), 'abc');
     * ```
     *
     * @param mixed $variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    function strcat(...$variadic)
    {
        return implode('', $variadic);
    }
}

const concat = 'ryunosuke\\Functions\\concat';
if (!isset($excluded_functions['concat']) && (!function_exists('ryunosuke\\Functions\\concat') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\concat'))->isInternal()))) {
    /**
     * strcat の空文字回避版
     *
     * 基本は strcat と同じ。ただし、**引数の内1つでも空文字を含むなら空文字を返す**。
     *
     * 「プレフィックスやサフィックスを付けたいんだけど、空文字の場合はそのままで居て欲しい」という状況はまれによくあるはず。
     * コードで言えば `strlen($string) ? 'prefix-' . $string : '';` のようなもの。
     * 可変引数なので 端的に言えば mysql の CONCAT みたいな動作になる（あっちは NULL だが）。
     *
     * ```php
     * assertSame(concat('prefix-', 'middle', '-suffix'), 'prefix-middle-suffix');
     * assertSame(concat('prefix-', '', '-suffix'), '');
     * ```
     *
     * @param mixed $variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    function concat(...$variadic)
    {
        $result = '';
        foreach ($variadic as $s) {
            if (strlen($s) === 0) {
                return '';
            }
            $result .= $s;
        }
        return $result;
    }
}

const split_noempty = 'ryunosuke\\Functions\\split_noempty';
if (!isset($excluded_functions['split_noempty']) && (!function_exists('ryunosuke\\Functions\\split_noempty') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\split_noempty'))->isInternal()))) {
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
     * ```php
     * assertSame(split_noempty(',', 'a, b, c'), ['a', 'b', 'c']);
     * assertSame(split_noempty(',', 'a, , , b, c'), ['a', 'b', 'c']);
     * assertSame(split_noempty(',', 'a, , , b, c', false), ['a', ' ', ' ', ' b', ' c']);
     * ```
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
        $trim = ($trimchars === true) ? 'trim' : (rbind)('trim', $trimchars);
        $parts = explode($delimiter, $string);
        $parts = array_map($trim, $parts);
        $parts = array_filter($parts, 'strlen');
        $parts = array_values($parts);
        return $parts;
    }
}

const multiexplode = 'ryunosuke\\Functions\\multiexplode';
if (!isset($excluded_functions['multiexplode']) && (!function_exists('ryunosuke\\Functions\\multiexplode') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\multiexplode'))->isInternal()))) {
    /**
     * explode の配列対応と $limit の挙動を変えたもの
     *
     * $delimiter には配列が使える。いわゆる「複数文字列での分割」の動作になる。
     *
     * $limit に負数を与えると「その絶対値-1までを結合したものと残り」を返す。
     * 素の explode の負数 $limit の動作が微妙に気に入らない（implode 正数と対称性がない）ので再実装。
     *
     * Example:
     * ```php
     * // 配列を与えると複数文字列での分割
     * assertSame(multiexplode([',', ' ', '|'], 'a,b c|d'), ['a', 'b', 'c', 'd']);
     * // 負数を与えると前詰め
     * assertSame(multiexplode(',', 'a,b,c,d', -2), ['a,b,c', 'd']);
     * // もちろん上記2つは共存できる
     * assertSame(multiexplode([',', ' ', '|'], 'a,b c|d', -2), ['a,b,c', 'd']);
     * ```
     *
     * @param string|array $delimiter 分割文字列。配列可
     * @param string $string 対象文字列
     * @param int $limit 分割数
     * @return array 分割された配列
     */
    function multiexplode($delimiter, $string, $limit = \PHP_INT_MAX)
    {
        if (is_array($delimiter)) {
            $representative = reset($delimiter);
            $string = str_replace($delimiter, $representative, $string);
            $delimiter = $representative;
        }

        if ($limit < 0) {
            $parts = explode($delimiter, $string);
            $sub = array_splice($parts, 0, $limit + 1);
            if ($sub) {
                array_unshift($parts, implode($delimiter, $sub));
            }
            return $parts;
        }
        return explode($delimiter, $string, $limit);
    }
}

const quoteexplode = 'ryunosuke\\Functions\\quoteexplode';
if (!isset($excluded_functions['quoteexplode']) && (!function_exists('ryunosuke\\Functions\\quoteexplode') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\quoteexplode'))->isInternal()))) {
    /**
     * エスケープやクオートに対応した explode
     *
     * $enclosures は配列で開始・終了文字が別々に指定できるが、実装上の都合で今のところ1文字ずつのみ。
     *
     * Example:
     * ```php
     * // シンプルな例
     * assertSame(quoteexplode(',', 'a,b,c\\,d,"e,f"'), [
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     'c\\,d', // \\ でエスケープしているので区切り文字とみなされない
     *     '"e,f"', // "" でクオートされているので区切り文字とみなされない
     * ]);
     *
     * // $enclosures で囲い文字の開始・終了文字を明示できる
     * assertSame(quoteexplode(',', 'a,b,{e,f}', ['{' => '}']), [
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     '{e,f}', // { } で囲まれているので区切り文字とみなされない
     * ]);
     * ```
     *
     * @param string $delimiter 分割文字列
     * @param string $string 対象文字列
     * @param array|string $enclosures 囲い文字。 ["start" => "end"] で開始・終了が指定できる
     * @param string $escape エスケープ文字
     * @return array 分割された配列
     */
    function quoteexplode($delimiter, $string, $enclosures = "'\"", $escape = '\\')
    {
        if (is_string($enclosures)) {
            $chars = str_split($enclosures);
            $enclosures = array_combine($chars, $chars);
        }

        $delimiterlen = strlen($delimiter);
        $starts = implode('', array_keys($enclosures));
        $ends = implode('', $enclosures);
        $enclosing = [];
        $current = 0;
        $result = [];
        for ($i = 0, $l = strlen($string); $i < $l; $i++) {
            if ($i !== 0 && $string[$i - 1] === $escape) {
                continue;
            }
            if (strpos($ends, $string[$i]) !== false) {
                if ($enclosing && $enclosures[$enclosing[count($enclosing) - 1]] === $string[$i]) {
                    array_pop($enclosing);
                    continue;
                }
            }
            if (strpos($starts, $string[$i]) !== false) {
                $enclosing[] = $string[$i];
                continue;
            }
            if (empty($enclosing) && substr_compare($string, $delimiter, $i, $delimiterlen) === 0) {
                $result[] = substr($string, $current, $i - $current);
                $current = $i + $delimiterlen;
            }
        }
        $result[] = substr($string, $current, $i);
        return $result;
    }
}

const str_equals = 'ryunosuke\\Functions\\str_equals';
if (!isset($excluded_functions['str_equals']) && (!function_exists('ryunosuke\\Functions\\str_equals') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\str_equals'))->isInternal()))) {
    /**
     * 文字列比較の関数版
     *
     * 文字列以外が与えられた場合は常に false を返す。ただし __toString を実装したオブジェクトは別。
     *
     * Example:
     * ```php
     * assertTrue(str_equals('abc', 'abc'));
     * assertTrue(str_equals('abc', 'ABC', true));
     * assertTrue(str_equals('\0abc', '\0abc'));
     * ```
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

const str_contains = 'ryunosuke\\Functions\\str_contains';
if (!isset($excluded_functions['str_contains']) && (!function_exists('ryunosuke\\Functions\\str_contains') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\str_contains'))->isInternal()))) {
    /**
     * 指定文字列を含むか返す
     *
     * Example:
     * ```php
     * assertTrue(str_contains('abc', 'b'));
     * assertTrue(str_contains('abc', 'B', true));
     * assertTrue(str_contains('abc', ['b', 'x'], false, false));
     * assertFalse(str_contains('abc', ['b', 'x'], false, true));
     * ```
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

const str_putcsv = 'ryunosuke\\Functions\\str_putcsv';
if (!isset($excluded_functions['str_putcsv']) && (!function_exists('ryunosuke\\Functions\\str_putcsv') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\str_putcsv'))->isInternal()))) {
    /**
     * fputcsv の文字列版（str_getcsv の put 版）
     *
     * エラーは例外に変換される。
     *
     * 普通の配列を与えるとシンプルに "a,b,c" のような1行を返す。
     * 多次元配列（2次元のみを想定）や Traversable を与えるとループして "a,b,c\nd,e,f" のような複数行を返す。
     *
     * Example:
     * ```php
     * // シンプルな1行を返す
     * assertSame(str_putcsv(['a', 'b', 'c']), "a,b,c");
     * assertSame(str_putcsv(['a', 'b', 'c'], "\t"), "a\tb\tc");
     * assertSame(str_putcsv(['a', ' b ', 'c'], " ", "'"), "a ' b ' c");
     *
     * // 複数行を返す
     * assertSame(str_putcsv([['a', 'b', 'c'], ['d', 'e', 'f']]), "a,b,c\nd,e,f");
     * assertSame(str_putcsv((function() {
     *     yield ['a', 'b', 'c'];
     *     yield ['d', 'e', 'f'];
     * })()), "a,b,c\nd,e,f");
     * ```
     *
     * @param array|\Traversable $array 値の配列 or 値の配列の配列
     * @param string $delimiter フィールド区切り文字
     * @param string $enclosure フィールドを囲む文字
     * @param string $escape エスケープ文字
     * @return string CSV 文字列
     */
    function str_putcsv($array, $delimiter = ',', $enclosure = '"', $escape = "\\")
    {
        $fp = fopen('php://memory', 'rw+');
        try {
            if (is_array($array) && (array_depth)($array) === 1) {
                $array = [$array];
            }
            return (call_safely)(function ($fp, $array, $delimiter, $enclosure, $escape) {
                foreach ($array as $line) {
                    fputcsv($fp, $line, $delimiter, $enclosure, $escape);
                }
                rewind($fp);
                return rtrim(stream_get_contents($fp), "\n");
            }, $fp, $array, $delimiter, $enclosure, $escape);
        }
        finally {
            fclose($fp);
        }
    }
}

const str_subreplace = 'ryunosuke\\Functions\\str_subreplace';
if (!isset($excluded_functions['str_subreplace']) && (!function_exists('ryunosuke\\Functions\\str_subreplace') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\str_subreplace'))->isInternal()))) {
    /**
     * 指定文字列を置換する
     *
     * $subject 内の $search を $replaces に置換する。
     * str_replace とは「N 番目のみ置換できる」点で異なる。
     * つまり、$subject='hoge', $replace=[2 => 'fuga'] とすると「3 番目の 'hoge' が hoge に置換される」という動作になる（0 ベース）。
     *
     * $replace に 非配列を与えた場合は配列化される。
     * つまり `$replaces = 'hoge'` は `$replaces = [0 => 'hoge']` と同じ（最初のマッチを置換する）。
     *
     * $replace に空配列を与えると何もしない。
     * 負数キーは後ろから数える動作となる。
     * また、置換後の文字列は置換対象にはならない。
     *
     * N 番目の検索文字列が見つからない場合は例外を投げる。
     *
     * Example:
     * ```php
     * // 1番目（0ベースなので2番目）の x を X に置換
     * assertSame(str_subreplace('xxx', 'x', [1 => 'X']), 'xXx');
     * // 0番目（最前列）の x を Xa に、-1番目（最後尾）の x を Xz に置換
     * assertSame(str_subreplace('!xxx!', 'x', [0 => 'Xa', -1 => 'Xz']), '!XaxXz!');
     * // 置換結果は置換対象にならない
     * assertSame(str_subreplace('xxx', 'x', [0 => 'xxx', 1 => 'X']), 'xxxXx');
     * ```
     *
     * @param string $subject 対象文字列
     * @param string $search 検索文字列
     * @param array|string $replaces 置換文字列配列（単一指定は配列化される）
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return string 置換された文字列
     */
    function str_subreplace($subject, $search, $replaces, $case_insensitivity = false)
    {
        if (!is_array($replaces)) {
            $replaces = [$replaces];
        }

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

const str_between = 'ryunosuke\\Functions\\str_between';
if (!isset($excluded_functions['str_between']) && (!function_exists('ryunosuke\\Functions\\str_between') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\str_between'))->isInternal()))) {
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
     * ```php
     * // $position を利用して "first", "second", "third" を得る（"で囲まれた "blank" は返ってこない）。
     * assertSame(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n), 'first');
     * assertSame(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n), 'second');
     * assertSame(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n), 'third');
     * // ネストしている場合は最も外側を返す
     * assertSame(str_between('{nest1{nest2{nest3}}}', '{', '}'), 'nest1{nest2{nest3}}');
     * ```
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
        $position = intval($position);
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

const starts_with = 'ryunosuke\\Functions\\starts_with';
if (!isset($excluded_functions['starts_with']) && (!function_exists('ryunosuke\\Functions\\starts_with') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\starts_with'))->isInternal()))) {
    /**
     * 指定文字列で始まるか調べる
     *
     * Example:
     * ```php
     * assertTrue(starts_with('abcdef', 'abc'));
     * assertTrue(starts_with('abcdef', 'ABC', true));
     * assertFalse(starts_with('abcdef', 'xyz'));
     * ```
     *
     * @param string $string 探される文字列
     * @param string $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return bool 指定文字列で始まるなら true を返す
     */
    function starts_with($string, $with, $case_insensitivity = false)
    {
        assert(is_string($string));
        assert(is_string($with));
        assert(strlen($with));

        return (str_equals)(substr($string, 0, strlen($with)), $with, $case_insensitivity);
    }
}

const ends_with = 'ryunosuke\\Functions\\ends_with';
if (!isset($excluded_functions['ends_with']) && (!function_exists('ryunosuke\\Functions\\ends_with') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\ends_with'))->isInternal()))) {
    /**
     * 指定文字列で終わるか調べる
     *
     * Example:
     * ```php
     * assertTrue(ends_with('abcdef', 'def'));
     * assertTrue(ends_with('abcdef', 'DEF', true));
     * assertFalse(ends_with('abcdef', 'xyz'));
     * ```
     *
     * @param string $string 探される文字列
     * @param string $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return bool 対象文字列で終わるなら true
     */
    function ends_with($string, $with, $case_insensitivity = false)
    {
        assert(is_string($string));
        assert(is_string($with));
        assert(strlen($with));

        return (str_equals)(substr($string, -strlen($with)), $with, $case_insensitivity);
    }
}

const camel_case = 'ryunosuke\\Functions\\camel_case';
if (!isset($excluded_functions['camel_case']) && (!function_exists('ryunosuke\\Functions\\camel_case') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\camel_case'))->isInternal()))) {
    /**
     * camelCase に変換する
     *
     * Example:
     * ```php
     * assertSame(camel_case('this_is_a_pen'), 'thisIsAPen');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function camel_case($string, $delimiter = '_')
    {
        return lcfirst((pascal_case)($string, $delimiter));
    }
}

const pascal_case = 'ryunosuke\\Functions\\pascal_case';
if (!isset($excluded_functions['pascal_case']) && (!function_exists('ryunosuke\\Functions\\pascal_case') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\pascal_case'))->isInternal()))) {
    /**
     * PascalCase に変換する
     *
     * Example:
     * ```php
     * assertSame(pascal_case('this_is_a_pen'), 'ThisIsAPen');
     * ```
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

const snake_case = 'ryunosuke\\Functions\\snake_case';
if (!isset($excluded_functions['snake_case']) && (!function_exists('ryunosuke\\Functions\\snake_case') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\snake_case'))->isInternal()))) {
    /**
     * snake_case に変換する
     *
     * Example:
     * ```php
     * assertSame(snake_case('ThisIsAPen'), 'this_is_a_pen');
     * ```
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

const chain_case = 'ryunosuke\\Functions\\chain_case';
if (!isset($excluded_functions['chain_case']) && (!function_exists('ryunosuke\\Functions\\chain_case') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\chain_case'))->isInternal()))) {
    /**
     * chain-case に変換する
     *
     * Example:
     * ```php
     * assertSame(chain_case('ThisIsAPen'), 'this-is-a-pen');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function chain_case($string, $delimiter = '-')
    {
        return (snake_case)($string, $delimiter);
    }
}

const build_uri = 'ryunosuke\\Functions\\build_uri';
if (!isset($excluded_functions['build_uri']) && (!function_exists('ryunosuke\\Functions\\build_uri') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\build_uri'))->isInternal()))) {
    /**
     * parse_uri の逆
     *
     * URI のパーツを与えると URI として構築する。
     * パーツは不完全でも良い。例えば scheme を省略すると "://" すら付かない URI が生成される。
     *
     * "query" パートだけは配列が許容される。その場合クエリ文字列に変換される。
     *
     * Example:
     * ```php
     * // 完全指定
     * assertSame(build_uri([
     *     'scheme'   => 'http',
     *     'user'     => 'user',
     *     'pass'     => 'pass',
     *     'host'     => 'localhost',
     *     'port'     => '80',
     *     'path'     => '/path/to/file',
     *     'query'    => ['id' => 1],
     *     'fragment' => 'hash',
     * ]), 'http://user:pass@localhost:80/path/to/file?id=1#hash');
     * // 一部だけ指定
     * assertSame(build_uri([
     *     'scheme'   => 'http',
     *     'host'     => 'localhost',
     *     'path'     => '/path/to/file',
     *     'fragment' => 'hash',
     * ]), 'http://localhost/path/to/file#hash');
     * ```
     *
     * @param array $parts URI の各パーツ配列
     * @return string URI 文字列
     */
    function build_uri($parts)
    {
        $parts += [
            'scheme'   => '',
            'user'     => '',
            'pass'     => '',
            'host'     => '',
            'port'     => '',
            'path'     => '',
            'query'    => '',
            'fragment' => '',
        ];
        $parts['host'] = filter_var($parts['host'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? "[{$parts['host']}]" : $parts['host'];
        $parts['path'] = ltrim($parts['path'], '/');
        $parts['query'] = is_array($parts['query']) ? http_build_query($parts['query'], '', '&') : $parts['query'];

        $uri = '';
        $uri .= (concat)($parts['scheme'], '://');
        $uri .= (concat)($parts['user'] . (concat)(':', $parts['pass']), '@');
        $uri .= (concat)($parts['host']);
        $uri .= (concat)(':', $parts['port']);
        $uri .= (concat)('/', $parts['path']);
        $uri .= (concat)('?', $parts['query']);
        $uri .= (concat)('#', $parts['fragment']);
        return $uri;
    }
}

const parse_uri = 'ryunosuke\\Functions\\parse_uri';
if (!isset($excluded_functions['parse_uri']) && (!function_exists('ryunosuke\\Functions\\parse_uri') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\parse_uri'))->isInternal()))) {
    /**
     * parse_url の仕様を少しいじったもの
     *
     * parse_url とは下記が異なる。
     *
     * - "単一文字列" はホスト名とみなされる（parse_url はパスとみなされる）
     * - パートがなくてもキー自体は生成される（そしてその値は $default で指定したもの）
     * - query は配列で返す（parse_str される）
     * - パート値をスカラー値で返すことはできない（必ず8要素の配列を返す）
     *
     * Example:
     * ```php
     * // 完全指定
     * assertEquals(parse_uri('http://user:pass@localhost:80/path/to/file?id=1#hash'), [
     *     'scheme'   => 'http',
     *     'user'     => 'user',
     *     'pass'     => 'pass',
     *     'host'     => 'localhost',
     *     'port'     => '80',
     *     'path'     => '/path/to/file',
     *     'query'    => ['id' => 1],
     *     'fragment' => 'hash',
     * ]);
     * // デフォルト値つき
     * assertEquals(parse_uri('localhost/path/to/file', [
     *     'scheme'   => 'http', // scheme のデフォルト値
     *     'user'     => 'user', // user のデフォルト値
     *     'port'     => '8080', // port のデフォルト値
     *     'host'     => 'hoge', // host のデフォルト値
     * ]), [
     *     'scheme'   => 'http',      // scheme はないのでデフォルト値が使われている
     *     'user'     => 'user',      // user はないのでデフォルト値が使われている
     *     'pass'     => '',
     *     'host'     => 'localhost', // host はあるのでデフォルト値が使われていない
     *     'port'     => '8080',      // port はないのでデフォルト値が使われている
     *     'path'     => '/path/to/file',
     *     'query'    => [],
     *     'fragment' => '',
     * ]);
     * ```
     *
     * @param string $uri パースする URI
     * @param array|string $default $uri に足りないパーツがあった場合のデフォルト値。文字列を与えた場合はそのパース結果がデフォルト値になる
     * @return array URI の各パーツ配列
     */
    function parse_uri($uri, $default = [])
    {
        $regex = "
            (?:(?<scheme>[a-z][-+.0-9a-z]*)://)?
            (?:
              (?: (?<user>(?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=])*)?
              (?::(?<pass>(?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=])*))?@)?
            )?
            (?<host>((?:\\[[0-9a-f:]+\\]) | (?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=]))*)
            (?::(?<port>\d{0,5}))?
            (?<path>(?:/(?: [-.~\\w!$&'()*+,;=:@] | %[0-9a-f]{2} )* )*)?
            (?:\\?(?<query>   (?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=/:?@])*))?
            (?:\\#(?<fragment>(?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=/:?@])*))?
        ";

        $default_default = [
            'scheme'   => '',
            'user'     => '',
            'pass'     => '',
            'host'     => '',
            'port'     => '',
            'path'     => '',
            'query'    => '',
            'fragment' => '',
        ];

        // 配列以外はパースしてそれをデフォルトとする
        if (!is_array($default)) {
            $default = (preg_capture)("#^$regex\$#ix", (string) $default, $default_default);
        }

        // パース。先頭の // はスキーム省略とみなすので除去する
        $uri = (preg_splice)('#^//#', '', $uri);
        $parts = (preg_capture)("#^$regex\$#ix", $uri, $default + $default_default);

        // 諸々調整（IPv6、パス / の正規化、クエリ配列化）
        $parts['host'] = (preg_splice)('#^\\[(.+)\\]$#', '$1', $parts['host']);
        $parts['path'] = (concat)('/', ltrim($parts['path'], '/'));
        if (is_string($parts['query'])) {
            parse_str($parts['query'], $parts['query']);
        }

        return $parts;
    }
}

const random_string = 'ryunosuke\\Functions\\random_string';
if (!isset($excluded_functions['random_string']) && (!function_exists('ryunosuke\\Functions\\random_string') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\random_string'))->isInternal()))) {
    /**
     * 安全な乱数文字列を生成する
     *
     * @param int $length 生成文字列長
     * @param string $charlist 使用する文字セット
     * @return string 乱数文字列
     */
    function random_string($length = 8, $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        if ($length <= 0) {
            throw new \InvalidArgumentException('$length must be positive number.');
        }

        $charlength = strlen($charlist);
        if ($charlength === 0) {
            throw new \InvalidArgumentException('charlist is empty.');
        }

        $bytes = random_bytes($length);

        // 1文字1バイト使う。文字種によっては出現率に差が出るがう～ん
        $string = '';
        foreach (str_split($bytes) as $byte) {
            $string .= $charlist[ord($byte) % $charlength];
        }
        return $string;
    }
}

const kvsprintf = 'ryunosuke\\Functions\\kvsprintf';
if (!isset($excluded_functions['kvsprintf']) && (!function_exists('ryunosuke\\Functions\\kvsprintf') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\kvsprintf'))->isInternal()))) {
    /**
     * 連想配列を指定できるようにした vsprintf
     *
     * sprintf の順序指定構文('%1$d')にキーを指定できる。
     *
     * Example:
     * ```php
     * assertSame(kvsprintf('%hoge$s %fuga$d', ['hoge' => 'ThisIs', 'fuga' => '3.14']), 'ThisIs 3');
     * ```
     *
     * @param string $format フォーマット文字列
     * @param array $array フォーマット引数
     * @return string フォーマットされた文字列
     */
    function kvsprintf($format, array $array)
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

const preg_capture = 'ryunosuke\\Functions\\preg_capture';
if (!isset($excluded_functions['preg_capture']) && (!function_exists('ryunosuke\\Functions\\preg_capture') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\preg_capture'))->isInternal()))) {
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
     * ```php
     * $pattern = '#(\d{4})/(\d{1,2})(/(\d{1,2}))?#';
     * $default = [1 => '2000', 2 => '1', 4 => '1'];
     * // 完全にマッチするのでそれぞれ返ってくる
     * assertSame(preg_capture($pattern, '2014/12/24', $default), [1 => '2014', 2 => '12', 4 => '24']);
     * // 最後の \d{1,2} はマッチしないのでデフォルト値が使われる
     * assertSame(preg_capture($pattern, '2014/12', $default), [1 => '2014', 2 => '12', 4 => '1']);
     * // 一切マッチしないので全てデフォルト値が使われる
     * assertSame(preg_capture($pattern, 'hoge', $default), [1 => '2000', 2 => '1', 4 => '1']);
     * ```
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

const preg_splice = 'ryunosuke\\Functions\\preg_splice';
if (!isset($excluded_functions['preg_splice']) && (!function_exists('ryunosuke\\Functions\\preg_splice') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\preg_splice'))->isInternal()))) {
    /**
     * キャプチャも行える preg_replace
     *
     * 「置換を行いつつ、キャプチャ文字列が欲しい」状況はまれによくあるはず。
     *
     * $replacement に callable を渡すと preg_replace_callback がコールされる。
     * callable と入っても単純文字列 callble （"strtoupper" など）は callable とはみなされない。
     * 配列形式の callable や クロージャのみ preg_replace_callback になる。
     *
     * Example:
     * ```php
     * // 数字を除去しつつその除去された数字を得る
     * assertSame(preg_splice('#\\d+#', '', 'abc123', $m), 'abc');
     * assertSame($m, ['123']);
     *
     * // callable だと preg_replace_callback が呼ばれる
     * assertSame(preg_splice('#[a-z]+#', function($m){return strtoupper($m[0]);}, 'abc123', $m), 'ABC123');
     * assertSame($m, ['abc']);
     *
     * // ただし、 文字列 callable は文字列として扱う
     * assertSame(preg_splice('#[a-z]+#', 'strtoupper', 'abc123', $m), 'strtoupper123');
     * assertSame($m, ['abc']);
     * ```
     *
     * @param string $pattern 正規表現
     * @param string|callable $replacement 置換文字列
     * @param string $subject 対象文字列
     * @param array $matches キャプチャ配列が格納される
     * @return string 置換された文字列
     */
    function preg_splice($pattern, $replacement, $subject, &$matches = [])
    {
        if (preg_match($pattern, $subject, $matches)) {
            if (!is_string($replacement) && is_callable($replacement)) {
                $subject = preg_replace_callback($pattern, $replacement, $subject);
            }
            else {
                $subject = preg_replace($pattern, $replacement, $subject);
            }
        }
        return $subject;
    }
}

const render_string = 'ryunosuke\\Functions\\render_string';
if (!isset($excluded_functions['render_string']) && (!function_exists('ryunosuke\\Functions\\render_string') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\render_string'))->isInternal()))) {
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
     * ```php
     * // 数値キーが参照できる
     * assertSame(render_string('${0}', ['number']), 'number');
     * // クロージャは呼び出し結果が埋め込まれる
     * assertSame(render_string('$c', ['c' => function($vars, $k){return $k . '-closure';}]), 'c-closure');
     * // 引数をそのまま返すだけの特殊な変数 $_ が宣言される
     * assertSame(render_string('{$_(123 + 456)}', []), '579');
     * // 要するに '$_()' の中に php の式が書けるようになる
     * assertSame(render_string('{$_(implode(\',\', $strs))}', ['strs' => ['a', 'n', 'z']]), 'a,n,z');
     * assertSame(render_string('{$_(max($nums))}', ['nums' => [1, 9, 3]]), '9');
     * ```
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
            return (function () {
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
            })($evalcode, $vars);
        }
        catch (\ParseError $ex) {
            throw new \RuntimeException('failed to eval code.' . $evalcode, 0, $ex);
        }
    }
}

const render_file = 'ryunosuke\\Functions\\render_file';
if (!isset($excluded_functions['render_file']) && (!function_exists('ryunosuke\\Functions\\render_file') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\render_file'))->isInternal()))) {
    /**
     * "hoge {$hoge}" 形式のレンダリングのファイル版
     *
     * @see render_string()
     *
     * @param string $template_file レンダリングするファイル名
     * @param array $array レンダリング変数
     * @return string レンダリングされた文字列
     */
    function render_file($template_file, $array)
    {
        return (render_string)(file_get_contents($template_file), $array);
    }
}

const returns = 'ryunosuke\\Functions\\returns';
if (!isset($excluded_functions['returns']) && (!function_exists('ryunosuke\\Functions\\returns') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\returns'))->isInternal()))) {
    /**
     * 引数をそのまま返す
     *
     * clone などでそのまま返す関数が欲しいことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $object = new \stdClass();
     * assertSame(returns($object), $object);
     * ```
     *
     * @param mixed $v return する値
     * @return mixed $v を返す
     */
    function returns($v)
    {
        return $v;
    }
}

const optional = 'ryunosuke\\Functions\\optional';
if (!isset($excluded_functions['optional']) && (!function_exists('ryunosuke\\Functions\\optional') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\optional'))->isInternal()))) {
    /**
     * オブジェクトならそれを、オブジェクトでないなら NullObject を返す
     *
     * null を返すかもしれないステートメントを一時変数を介さずワンステートメントで呼ぶことが可能になる。
     *
     * NullObject は 基本的に null を返すが、return type が規約されている場合は null 以外を返すこともある。
     * 取得系呼び出しを想定しているので、設定系呼び出しは行うべきではない。
     * __set のような明らかに設定が意図されているものは例外が飛ぶ。
     *
     * Example:
     * ```php
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
     * ```
     *
     * @param object|null $object オブジェクト
     * @param string $expected 期待するクラス名。指定した場合は is_a される
     * @return mixed $object がオブジェクトならそのまま返し、違うなら NullObject を返す
     */
    function optional($object, $expected = null)
    {
        if (is_object($object)) {
            if ($expected === null || is_a($object, $expected)) {
                return $object;
            }
        }

        static $nullobject = null;
        if ($nullobject === null) {
            $nullobject = new class implements \ArrayAccess, \IteratorAggregate
            {
                // @formatter:off
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
                // @formatter:on
            };
        }
        return $nullobject;
    }
}

const throws = 'ryunosuke\\Functions\\throws';
if (!isset($excluded_functions['throws']) && (!function_exists('ryunosuke\\Functions\\throws') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\throws'))->isInternal()))) {
    /**
     * throw の関数版
     *
     * hoge() or throw などしたいことがまれによくあるはず。
     *
     * Example:
     * ```php
     * try {
     *     throws(new \Exception('throws'));
     * }
     * catch (\Exception $ex) {
     *     assertSame($ex->getMessage(), 'throws');
     * }
     * ```
     *
     * @param \Exception $ex 投げる例外
     */
    function throws($ex)
    {
        throw $ex;
    }
}

const throw_if = 'ryunosuke\\Functions\\throw_if';
if (!isset($excluded_functions['throw_if']) && (!function_exists('ryunosuke\\Functions\\throw_if') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\throw_if'))->isInternal()))) {
    /**
     * 条件付き throw
     *
     * 第1引数が true 相当のときに例外を投げる。
     *
     * Example:
     * ```php
     * // 投げない
     * throw_if(false, new \Exception());
     * // 投げる
     * try{throw_if(true, new \Exception());}catch(\Exception $ex){}
     * // クラス指定で投げる
     * try{throw_if(true, \Exception::class, 'message', 123);}catch(\Exception $ex){}
     * ```
     *
     * @param bool|mixed $flag true 相当値を与えると例外を投げる
     * @param \Exception|string $ex 投げる例外。クラス名の場合は中で new する
     * @param array $ex_args $ex にクラス名を与えたときの引数（可変引数）
     */
    function throw_if($flag, $ex, ...$ex_args)
    {
        if ($flag) {
            if (is_string($ex)) {
                $ex = new $ex(...$ex_args);
            }
            throw $ex;
        }
    }
}

const ifelse = 'ryunosuke\\Functions\\ifelse';
if (!isset($excluded_functions['ifelse']) && (!function_exists('ryunosuke\\Functions\\ifelse') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\ifelse'))->isInternal()))) {
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
     * ```php
     * // とても処理が遅い関数。これの返り値が「false ならばデフォルト値、でなければ自身値」という処理が下記のように書ける（一時変数が不要）
     * $heavyfunc = function($v){return $v;};
     * // $heavyfunc(1) ?? 'default' とほぼ同義
     * assertSame(ifelse($heavyfunc(1), false, 'default'), 1);
     * // $heavyfunc(null) ?? 'default' とほぼ同義…ではない。厳密な比較で false ではないので第1引数を返す
     * assertSame(ifelse($heavyfunc(null), false, 'default'), null);
     * // $heavyfunc(false) ?? 'default' とほぼ同義…ではない。厳密な比較で false なので 'default' を返す
     * assertSame(ifelse($heavyfunc(false), false, 'default'), 'default');
     * ```
     *
     * @param mixed $actual 調べる値（左辺値）
     * @param mixed $expected 比較する値（右辺値）
     * @param mixed $then 真の場合の値
     * @param mixed $else 偽の場合の値。省略時は $actual
     * @return mixed $then or $else
     */
    function ifelse($actual, $expected, $then, $else = null)
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

const try_catch = 'ryunosuke\\Functions\\try_catch';
if (!isset($excluded_functions['try_catch']) && (!function_exists('ryunosuke\\Functions\\try_catch') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\try_catch'))->isInternal()))) {
    /**
     * try ～ catch 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_catch($try, null, 1, 2, 3), [1, 2, 3]);
     * // 例外が飛ぶ場合は特殊なことをしなければ例外オブジェクトが返ってくる
     * $try = function(){throw new \Exception('tried');};
     * assertSame(try_catch($try)->getMessage(), 'tried');
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_catch($try, $catch = null, ...$variadic)
    {
        return (try_catch_finally)($try, $catch, null, ...$variadic);
    }
}

const try_finally = 'ryunosuke\\Functions\\try_finally';
if (!isset($excluded_functions['try_finally']) && (!function_exists('ryunosuke\\Functions\\try_finally') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\try_finally'))->isInternal()))) {
    /**
     * try ～ finally 構文の関数版
     *
     * 例外は投げっぱなす。例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
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
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_finally($try, $finally = null, ...$variadic)
    {
        return (try_catch_finally)($try, throws, $finally, ...$variadic);
    }
}

const try_catch_finally = 'ryunosuke\\Functions\\try_catch_finally';
if (!isset($excluded_functions['try_catch_finally']) && (!function_exists('ryunosuke\\Functions\\try_catch_finally') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\try_catch_finally'))->isInternal()))) {
    /**
     * try ～ catch ～ finally 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
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
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @param callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_catch_finally($try, $catch = null, $finally = null, ...$variadic)
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

const get_uploaded_files = 'ryunosuke\\Functions\\get_uploaded_files';
if (!isset($excluded_functions['get_uploaded_files']) && (!function_exists('ryunosuke\\Functions\\get_uploaded_files') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\get_uploaded_files'))->isInternal()))) {
    /**
     * $_FILES の構造を組み替えて $_POST などと同じにする
     *
     * $_FILES の配列構造はバグとしか思えないのでそれを是正する関数。
     * 第1引数 $files は指定可能だが、大抵は $_FILES であり、指定するのはテスト用。
     *
     * サンプルを書くと長くなるので例は{@source \ryunosuke\Test\Package\UtilityTest::test_get_uploaded_files() テストファイル}を参照。
     *
     * @param array $files $_FILES の同じ構造の配列。省略時は $_FILES
     * @return array $_FILES を $_POST などと同じ構造にした配列
     */
    function get_uploaded_files($files = null)
    {
        $result = [];
        foreach (($files ?: $_FILES) as $name => $file) {
            if (is_array($file['name'])) {
                $file = (get_uploaded_files)((array_each)($file['name'], function (&$carry, $dummy, $subkey) use ($file) {
                    $carry[$subkey] = (array_lookup)($file, $subkey);
                }, []));
            }
            $result[$name] = $file;
        }
        return $result;
    }
}

const cache = 'ryunosuke\\Functions\\cache';
if (!isset($excluded_functions['cache']) && (!function_exists('ryunosuke\\Functions\\cache') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\cache'))->isInternal()))) {
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
     * ```php
     * $provider = function(){return rand();};
     * // 乱数を返す処理だが、キャッシュされるので同じ値になる
     * $rand1 = cache('rand', $provider);
     * $rand2 = cache('rand', $provider);
     * assertSame($rand1, $rand2);
     * // $provider に null を与えると削除される
     * cache('rand', null);
     * $rand3 = cache('rand', $provider);
     * assertNotSame($rand1, $rand3);
     * ```
     *
     * @param string $key キャッシュのキー
     * @param callable $provider キャッシュがない場合にコールされる callable
     * @param string $namespace 名前空間
     * @param bool $use_internal 内部キャッシュオブジェクトを使うか
     * @return mixed キャッシュ
     */
    function cache($key, $provider, $namespace = null, $use_internal = true)
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

const process = 'ryunosuke\\Functions\\process';
if (!isset($excluded_functions['process']) && (!function_exists('ryunosuke\\Functions\\process') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\process'))->isInternal()))) {
    /**
     * proc_open ～ proc_close の一連の処理を行う
     *
     * 標準入出力は受け渡しできるが、決め打ち実装なのでいわゆる対話型なプロセスは起動できない。
     *
     * Example:
     * ```php
     * // サンプル実行用ファイルを用意
     * $phpfile = sys_get_temp_dir() . '/rf-sample.php';
     * file_put_contents($phpfile, "<?php
     *     fwrite(STDOUT, fgets(STDIN));
     *     fwrite(STDERR, 'err');
     *     exit((int) ini_get('max_file_uploads'));
     * ");
     * // 引数と標準入出力エラーを使った単純な例
     * $rc = process(PHP_BINARY, [
     *     '-d' => 'max_file_uploads=123',
     *     $phpfile,
     * ], 'out', $stdout, $stderr);
     * assertSame($rc, 123); // -d で与えた max_file_uploads で exit してるので 123
     * assertSame($stdout, 'out'); // 標準出力に標準入力を書き込んでいるので "out" が格納される
     * assertSame($stderr, 'err'); // 標準エラーに書き込んでいるので "err" が格納される
     * ```
     *
     * @param string $command 実行コマンド。escapeshellcmd される
     * @param array|string $args コマンドライン引数。文字列はそのまま結合される。配列は escapeshellarg された上でキーと結合される
     * @param string $stdin 標準入力
     * @param string $stdout 標準出力（参照渡しで格納される）
     * @param string $stderr 標準エラー（参照渡しで格納される）
     * @param string $cwd 作業ディレクトリ
     * @param array $env 環境変数
     * @return int リターンコード
     */
    function process($command, $args = [], $stdin = '', &$stdout = '', &$stderr = '', $cwd = null, array $env = null)
    {
        $ecommand = escapeshellcmd($command);

        if (is_array($args)) {
            $args = (array_sprintf)($args, function ($v, $k) {
                $ev = escapeshellarg($v);
                return is_int($k) ? $ev : "$k $ev";
            }, ' ');
        }

        $proc = proc_open("$ecommand $args", [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes, $cwd, $env);

        if ($proc === false) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command start failed."); // @codeCoverageIgnore
        }

        fwrite($pipes[0], $stdin);
        fclose($pipes[0]);

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        $stdout = $stderr = '';
        while (feof($pipes[1]) === false || feof($pipes[2]) === false) {
            $read = [$pipes[1], $pipes[2]];
            $write = $except = null;
            if (stream_select($read, $write, $except, 1) === false) {
                // （システムコールが別のシグナルによって中断された場合などに起こりえます）
                // @codeCoverageIgnoreStart
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($proc);
                throw new \RuntimeException('stream_select failed.');
                // @codeCoverageIgnoreEnd
            }
            foreach ($read as $fp) {
                if ($fp === $pipes[1]) {
                    $stdout .= fread($fp, 1024);
                }
                elseif ($fp === $pipes[2]) {
                    $stderr .= fread($fp, 1024);
                }
            }
        }

        fclose($pipes[1]);
        fclose($pipes[2]);
        $rc = proc_close($proc);
        if ($rc === -1) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command exit failed."); // @codeCoverageIgnore
        }
        return $rc;
    }
}

const arguments = 'ryunosuke\\Functions\\arguments';
if (!isset($excluded_functions['arguments']) && (!function_exists('ryunosuke\\Functions\\arguments') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\arguments'))->isInternal()))) {
    /**
     * コマンドライン引数をパースして引数とオプションを返す
     *
     * 少しリッチな {@link http://php.net/manual/function.getopt.php getopt} として使える（shell 由来のオプション構文(a:b::)はどうも馴染みにくい）。
     * ただし「値が必須なオプション」はサポートしない。
     * もっとも、オプションとして空文字が来ることはほぼ無いのでデフォルト値を空文字にすることで対応可能。
     *
     * $rule に従って `--noval filename --opt optval` のような文字列・配列をパースする。
     * $rule 配列の仕様は下記。
     *
     * - キーは「オプション名」を指定する。ただし・・・
     *     - 数値キーは「引数」を意味する
     *     - スペースの後に「ショート名」を与えられる
     * - 値は「デフォルト値」を指定する。ただし・・・
     *     - `[]` は「複数値オプション」を意味する（配列にしない限り同オプションの多重指定は許されない）
     *     - `null` は「値なしオプション」を意味する（スイッチングオプション）
     *
     * 上記の仕様でパースして「引数は数値連番、オプションはオプション名をキーとした配列」を返す。
     * なお、いわゆる「引数」はどこに来ても良い（前オプション、後オプションの区別がない）。
     *
     * $argv には配列や文字列が与えられるが、ほとんどテスト用に近く、普通は未指定で $argv を使うはず。
     *
     * Example:
     * ```php
     * // いくつか織り交ぜたスタンダードな例
     * $rule = [
     *     'opt'       => 'def',    // 基本的には「デフォルト値」を表す
     *     'longopt l' => '',       // スペース区切りで「ショート名」を意味する
     *     1           => 'defarg', // 数値キーは「引数」を意味する
     * ];
     * assertSame(arguments($rule, '--opt optval arg1 -l longval'), [
     *     'opt'     => 'optval',  // optval と指定している
     *     'longopt' => 'longval', // ショート名指定でも本来の名前で返ってくる
     *     'arg1',   // いわゆるコマンドライン引数（optval は opt に飲まれるので含まれない）
     *     'defarg', // いわゆるコマンドライン引数（与えられていないが、ルールの 1 => 'defarg' が活きている）
     * ]);
     *
     * // 「値なしオプション」と「複数値オプション」の例
     * $rule = [
     *     'noval1 l'  => null, // null は「値なしオプション」を意味する（指定されていれば true されていなければ false を返す）
     *     'noval2 m'  => null, // 同上
     *     'noval3 n'  => null, // 同上
     *     'opts o' => [],      // 配列を与えると「複数値オプション」を表す
     * ];
     * assertSame(arguments($rule, '--opts o1 -ln arg1 -o o2 arg2 --opts o3'), [
     *     'noval1' => true,  // -ln で同時指定されているので true
     *     'noval2' => false, // -ln で同時指定されてないので false
     *     'noval3' => true,  // -ln の同時指定されているので true
     *     'opts'   => ['o1', 'o2', 'o3'], // ロング、ショート混在でも OK
     *     'arg1', // 一見 -ln のオプション値に見えるが、 noval は値なしなので引数として得られる
     *     'arg2', // 前オプション、後オプションの区別はないのでどこに居ようと引数として得られる
     * ]);
     * ```
     *
     * @param array $rule オプションルール
     * @param array|string|null $argv パースするコマンドライン引数。未指定時は $argv が使用される
     * @return array コマンドライン引数＋オプション
     */
    function arguments($rule, $argv = null)
    {
        if ($argv === null) {
            $argv = array_slice($_SERVER['argv'], 1); // @codeCoverageIgnore
        }
        if (is_string($argv)) {
            $argv = preg_split('#\s+#', $argv, -1, PREG_SPLIT_NO_EMPTY);
        }
        $argv = array_values($argv);

        $shortmap = [];
        $argsdefaults = [];
        $optsdefaults = [];
        foreach ($rule as $name => $default) {
            if (is_int($name)) {
                $argsdefaults[$name] = $default;
                continue;
            }
            list($longname, $shortname) = preg_split('#\s+#', $name, -1, PREG_SPLIT_NO_EMPTY) + [1 => null];
            if ($shortname !== null) {
                if (array_key_exists($shortname, $shortmap)) {
                    throw new \InvalidArgumentException("duplicated short option name '$shortname'");
                }
                $shortmap[$shortname] = $longname;
            }
            if (array_key_exists($longname, $optsdefaults)) {
                throw new \InvalidArgumentException("duplicated option name '$shortname'");
            }
            $optsdefaults[$longname] = $default;
        }

        $n = 0;
        $already = [];
        $result = array_map(function ($v) { return $v === null ? false : $v; }, $optsdefaults);
        while (($token = array_shift($argv)) !== null) {
            if (strlen($token) >= 2 && $token[0] === '-') {
                if ($token[1] === '-') {
                    $optname = substr($token, 2);
                }
                else {
                    $shortname = substr($token, 1);
                    if (strlen($shortname) > 1) {
                        array_unshift($argv, '-' . substr($shortname, 1));
                        $shortname = substr($shortname, 0, 1);
                    }
                    if (!isset($shortmap[$shortname])) {
                        throw new \InvalidArgumentException("undefined short option name '$shortname'.");
                    }
                    $optname = $shortmap[$shortname];
                }

                if (!array_key_exists($optname, $optsdefaults)) {
                    throw new \InvalidArgumentException("undefined option name '$optname'.");
                }
                if (isset($already[$optname]) && !is_array($result[$optname])) {
                    throw new \InvalidArgumentException("'$optname' is specified already.");
                }
                $already[$optname] = true;

                if ($optsdefaults[$optname] === null) {
                    $result[$optname] = true;
                }
                else {
                    if (!isset($argv[0]) || strpos($argv[0], '-') === 0) {
                        throw new \InvalidArgumentException("'$optname' requires value.");
                    }
                    if (is_array($result[$optname])) {
                        $result[$optname][] = array_shift($argv);
                    }
                    else {
                        $result[$optname] = array_shift($argv);
                    }
                }
            }
            else {
                $result[$n++] = $token;
            }
        }

        return $result + $argsdefaults;
    }
}

const backtrace = 'ryunosuke\\Functions\\backtrace';
if (!isset($excluded_functions['backtrace']) && (!function_exists('ryunosuke\\Functions\\backtrace') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\backtrace'))->isInternal()))) {
    /**
     * 特定条件までのバックトレースを取得する
     *
     * 第2引数 $options を満たすトレース以降を返す。
     * $options は ['$trace の key' => "条件"] を渡す。
     * 条件は文字列かクロージャで、文字列の場合は緩い一致、クロージャの場合は true を返した場合にそれ以降を返す。
     *
     * Example:
     * ```php
     * function f001 () {return backtrace(0, ['function' => 'f002', 'limit' => 2]);}
     * function f002 () {return f001();}
     * function f003 () {return f002();}
     * $traces = f003();
     * // limit 指定してるので2個
     * assertCount(2, $traces);
     * // 「function が f002 以降」を返す
     * assertArraySubset([
     *     'function' => 'f002'
     * ], $traces[0]);
     * assertArraySubset([
     *     'function' => 'f003'
     * ], $traces[1]);
     * ```
     *
     * @param int $flags debug_backtrace の引数
     * @param array $options フィルタ条件
     * @return array バックトレース
     */
    function backtrace($flags = \DEBUG_BACKTRACE_PROVIDE_OBJECT, $options = [])
    {
        $result = [];
        $traces = debug_backtrace($flags);
        foreach ($traces as $n => $trace) {
            foreach ($options as $key => $val) {
                if (!isset($trace[$key])) {
                    continue;
                }

                if ($val instanceof \Closure) {
                    $break = $val($trace[$key]);
                }
                else {
                    $break = $trace[$key] == $val;
                }
                if ($break) {
                    $result = array_slice($traces, $n);
                    break 2;
                }
            }
        }

        // limit は特別扱いで千切り指定
        if (isset($options['limit'])) {
            $result = array_slice($result, 0, $options['limit']);
        }

        return $result;
    }
}

const error = 'ryunosuke\\Functions\\error';
if (!isset($excluded_functions['error']) && (!function_exists('ryunosuke\\Functions\\error') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\error'))->isInternal()))) {
    /**
     * エラー出力する
     *
     * 第1引数 $message はそれらしく文字列化されて出力される。基本的にはあらゆる型を与えて良い。
     *
     * 第2引数 $destination で出力対象を指定する。省略すると error_log 設定に従う。
     * 文字列を与えるとファイル名とみなし、ファイルに追記される。
     * ファイルを開くが、**ファイルは閉じない**。閉じ処理は php の終了処理に身を任せる。
     * したがって閉じる必要がある場合はファイルポインタを渡す必要がある。
     *
     * @param string|mixed $message 出力メッセージ
     * @param resource|string|mixed $destination 出力先
     * @return int 書き込んだバイト数
     */
    function error($message, $destination = null)
    {
        static $persistences = [];

        $time = date('d-M-Y H:i:s e');
        $content = (stringify)($message);
        $location = '';
        if (!($message instanceof \Exception || $message instanceof \Throwable)) {
            foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
                if (isset($trace['file'], $trace['line'])) {
                    $location = " in {$trace['file']} on line {$trace['line']}";
                    break;
                }
            }
        }
        $line = "[$time] PHP Log:  $content$location\n";

        if ($destination === null) {
            $destination = ini_get('error_log');
        }

        if ($destination === 'syslog') {
            syslog(LOG_INFO, $message);
            return strlen($line);
        }

        if (is_resource($destination)) {
            $fp = $destination;
        }
        elseif (is_string($destination)) {
            if (!isset($persistences[$destination])) {
                $persistences[$destination] = fopen($destination, 'a');
            }
            $fp = $persistences[$destination];
        }

        if (empty($fp)) {
            throw new \InvalidArgumentException('$destination must be resource or string.');
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $line);
        flock($fp, LOCK_UN);

        return strlen($line);
    }
}

const timer = 'ryunosuke\\Functions\\timer';
if (!isset($excluded_functions['timer']) && (!function_exists('ryunosuke\\Functions\\timer') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\timer'))->isInternal()))) {
    /**
     * 処理時間を計測する
     *
     * 第1引数 $callable を $count 回回してその処理時間を返す。
     *
     * Example:
     * ```php
     * // 0.01 秒を 10 回回すので 0.1 秒は超える
     * assertGreaterThan(0.1, timer(function(){usleep(10 * 1000);}, 10));
     * ```
     *
     * @param callable $callable 処理クロージャ
     * @param int $count ループ回数
     * @return float 処理時間
     */
    function timer(callable $callable, $count = 1)
    {
        $count = (int) $count;
        if ($count < 1) {
            throw new \InvalidArgumentException("\$count must be greater than 0 (specified $count).");
        }

        $t = microtime(true);
        for ($i = 0; $i < $count; $i++) {
            $callable();
        }
        return microtime(true) - $t;
    }
}

const benchmark = 'ryunosuke\\Functions\\benchmark';
if (!isset($excluded_functions['benchmark']) && (!function_exists('ryunosuke\\Functions\\benchmark') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\benchmark'))->isInternal()))) {
    /**
     * 簡易ベンチマークを取る
     *
     * 「指定ミリ秒内で何回コールできるか？」でベンチする。
     *
     * $suite は ['表示名' => $callable] 形式の配列。
     * 表示名が与えられていない場合、それらしい名前で表示する。
     *
     * Example:
     * ```php
     * // intval と int キャストはどちらが早いか調べる
     * benchmark([
     *     'intval',
     *     'intcast' => function($v){return (int)$v;},
     * ], ['12345'], 10);
     * ```
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
        foreach ((arrayize)($suite) as $name => $caller) {
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

            $benchset[$name] = (closurize)($caller);
        }

        if (!$benchset) {
            throw new \InvalidArgumentException('benchset is empty.');
        }

        // ウォームアップ兼検証（大量に実行してエラーの嵐になる可能性があるのでウォームアップの時点でエラーがないかチェックする）
        $assertions = (call_safely)(function ($benchset, $args) {
            $result = [];
            $args2 = $args;
            foreach ($benchset as $name => $caller) {
                $result[$name] = $caller(...$args2);
            }
            return $result;
        }, $benchset, $args);

        // 返り値の検証（ベンチマークという性質上、基本的に戻り値が一致しないのはおかしい）
        // rand/mt_rand, md5/sha1 のような例外はあるが、そんなのベンチしないし、クロージャでラップすればいいし、それでも邪魔なら @ で黙らせればいい
        foreach ($assertions as $name1 => $return1) {
            foreach ($assertions as $name2 => $return2) {
                if ($return1 !== null && $return2 !== null && $return1 !== $return2) {
                    $returns1 = (stringify)($return1);
                    $returns2 = (stringify)($return2);
                    trigger_error("Results of $name1 and $name2 are different. ($returns1, $returns2)");
                }
            }
        }

        // ベンチ
        $counts = [];
        foreach ($benchset as $name => $caller) {
            $end = microtime(true) + $millisec / 1000;
            $args2 = $args;
            for ($n = 0; microtime(true) <= $end; $n++) {
                $caller(...$args2);
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
                'ratio'  => $maxcount / $count,
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
            echo (kvsprintf)($template, [
                'count'     => count($benchset),
                'millsec'   => number_format($millisec),
                'header'    => sprintf($defformat, 'name', 'called', '1 call(ms)', 'ratio'),
                'separator' => sprintf($sepformat, '', '', '', ''),
                'summary'   => implode("\n", array_map(function ($data) use ($defformat) {
                    return vsprintf($defformat, [
                            $data['name'],
                            number_format($data['called']),
                            number_format($data['mills'], 6),
                            number_format($data['ratio'], 3),
                        ]
                    );
                }, $result)),
            ]);
        }

        return $result;
    }
}

const stringify = 'ryunosuke\\Functions\\stringify';
if (!isset($excluded_functions['stringify']) && (!function_exists('ryunosuke\\Functions\\stringify') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\stringify'))->isInternal()))) {
    /**
     * 値を何とかして文字列化する
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
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
                return (var_export2)($var, true);
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

const numberify = 'ryunosuke\\Functions\\numberify';
if (!isset($excluded_functions['numberify']) && (!function_exists('ryunosuke\\Functions\\numberify') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\numberify'))->isInternal()))) {
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
     * ```php
     * // 配列は要素数となる
     * assertSame(numberify([1, 2, 3]), 3);
     * // int/float は基本的にそのまま
     * assertSame(numberify(123), 123);
     * assertSame(numberify(123.45), 123);
     * assertSame(numberify(123.45, true), 123.45);
     * // 文字列は数値抽出
     * assertSame(numberify('a1b2c3'), 123);
     * assertSame(numberify('a1b2.c3', true), 12.3);
     * ```
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

const numval = 'ryunosuke\\Functions\\numval';
if (!isset($excluded_functions['numval']) && (!function_exists('ryunosuke\\Functions\\numval') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\numval'))->isInternal()))) {
    /**
     * 値を数値化する
     *
     * int か float ならそのまま返す。
     * 文字列の場合、一言で言えば「.を含むなら float、含まないなら int」を返す。
     * int でも float でも stringable でもない場合は実装依存（ただの int キャスト）。
     *
     * Example:
     * ```php
     * assertSame(numval(3.14), 3.14);   // int や float はそのまま返す
     * assertSame(numval('3.14'), 3.14); // . を含む文字列は float を返す
     * assertSame(numval('11', 8), 9);   // 基数が指定できる
     * ```
     *
     * @param mixed $var 数値化する値
     * @param int $base 基数。int 的な値のときしか意味をなさない
     * @return int|float 数値化した値
     */
    function numval($var, $base = 10)
    {
        if (is_int($var) || is_float($var)) {
            return $var;
        }
        if (is_object($var)) {
            $var = (string) $var;
        }
        if (is_string($var) && strpos($var, '.') !== false) {
            return (float) $var;
        }
        return intval($var, $base);
    }
}

const arrayval = 'ryunosuke\\Functions\\arrayval';
if (!isset($excluded_functions['arrayval']) && (!function_exists('ryunosuke\\Functions\\arrayval') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\arrayval'))->isInternal()))) {
    /**
     * array キャストの関数版
     *
     * intval とか strval とかの array 版。
     * ただキャストするだけだが、関数なのでコールバックとして使える。
     *
     * $recursive を true にすると再帰的に適用する（デフォルト）。
     * 入れ子オブジェクトを配列化するときなどに使える。
     *
     * Example:
     * ```php
     * // キャストなので基本的には配列化される
     * assertSame(arrayval(123), [123]);
     * assertSame(arrayval('str'), ['str']);
     * assertSame(arrayval([123]), [123]); // 配列は配列のまま
     *
     * // $recursive = false にしない限り再帰的に適用される
     * $stdclass = stdclass(['key' => 'val']);
     * assertSame(arrayval([$stdclass], true), [['key' => 'val']]); // true なので中身も配列化される
     * assertSame(arrayval([$stdclass], false), [$stdclass]);       // false なので中身は変わらない
     * ```
     *
     * @param mixed $var array 化する値
     * @param bool $recursive 再帰的に行うなら true
     * @return array array 化した配列
     */
    function arrayval($var, $recursive = true)
    {
        // return json_decode(json_encode($var), true);

        // 無駄なループを回したくないので非再帰で配列の場合はそのまま返す
        if (!$recursive && is_array($var)) {
            return $var;
        }

        if ((is_primitive)($var)) {
            return (array) $var;
        }

        $result = [];
        foreach ($var as $k => $v) {
            if ($recursive && !(is_primitive)($v)) {
                $v = (arrayval)($v, $recursive);
            }
            $result[$k] = $v;
        }
        return $result;
    }
}

const si_prefix = 'ryunosuke\\Functions\\si_prefix';
if (!isset($excluded_functions['si_prefix']) && (!function_exists('ryunosuke\\Functions\\si_prefix') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\si_prefix'))->isInternal()))) {
    /**
     * 数値に SI 接頭辞を付与する
     *
     * 値は 1 <= $var < 1000 の範囲内に収められる。
     * ヨクト（10^24）～ヨタ（1024）まで。整数だとしても 64bit の範囲を超えるような値の精度は保証しない。
     *
     * Example:
     * ```php
     * // シンプルに k をつける
     * assertSame(si_prefix(12345), '12.345 k');
     * // シンプルに m をつける
     * assertSame(si_prefix(0.012345), '12.345 m');
     * // 書式フォーマットを指定できる
     * assertSame(si_prefix(12345, '%d%s'), '12k');
     * assertSame(si_prefix(0.012345, '%d%s'), '12m');
     * // ファイルサイズを byte で表示する
     * assertSame(si_prefix(12345, '%d %sbyte'), '12 kbyte');
     * // フォーマットに null を与えると sprintf せずに配列で返す
     * assertSame(si_prefix(12345, null), [12.345, 'k']);
     * ```
     *
     * @param mixed $var 丸める値
     * @param string $format 書式フォーマット。 null を与えると sprintf せずに配列で返す
     * @return string|array SI 丸めた数値と SI 接頭辞で sprintf した文字列（$format が null の場合は配列）
     */
    function si_prefix($var, $format = '%.3f %s')
    {
        $units = [
            -24 => 'y', // ヨクト
            -21 => 'z', // ゼプト
            -18 => 'a', // アト
            -15 => 'f', // フェムト
            -12 => 'p', // ピコ
            -9  => 'n', // ナノ
            -6  => 'µ', // マイクロ
            -3  => 'm', // ミリ
            0   => '',  //
            3   => 'k', // キロ
            6   => 'M', // メガ
            9   => 'G', // ギガ
            12  => 'T', // テラ
            15  => 'P', // ペタ
            18  => 'E', // エクサ
            21  => 'Z', // ゼタ
            24  => 'Y', // ヨタ
        ];

        $result = function ($format, $var, $unit) {
            if ($format === null) {
                return [$var, $unit];
            }
            return sprintf($format, $var, $unit);
        };

        if ($var == 0) {
            return $result($format, $var, '');
        }

        $original = $var;
        $var = abs($var);
        $n = 0;
        while (!(1 <= $var && $var < 1000)) {
            if ($var < 1) {
                $n--;
                $var *= 1000;
            }
            else {
                $n++;
                $var /= 1000;
            }
        }
        if (!isset($units[$n * 3])) {
            throw new \InvalidArgumentException("$original is too large or small.");
        }
        return $result($format, ($original > 0 ? 1 : -1) * $var, $units[$n * 3]);
    }
}

const is_empty = 'ryunosuke\\Functions\\is_empty';
if (!isset($excluded_functions['is_empty']) && (!function_exists('ryunosuke\\Functions\\is_empty') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\is_empty'))->isInternal()))) {
    /**
     * 値が空か検査する
     *
     * `empty` とほぼ同じ。ただし
     *
     * - string: "0"
     * - あらゆる object
     *
     * は false 判定する。
     *
     * なお、関数の仕様上、未定義変数を true 判定することはできない。
     * 未定義変数をチェックしたい状況は大抵の場合コードが悪いが `$array['key1']['key2']` を調べたいことはある。
     * そういう時には使えない（?? する必要がある）。
     *
     * 「 `if ($var) {}` で十分なんだけど "0" が…」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // この辺は empty と全く同じ
     * assertTrue(is_empty(null));
     * assertTrue(is_empty(false));
     * assertTrue(is_empty(0));
     * assertTrue(is_empty(''));
     * // この辺だけが異なる
     * assertFalse(is_empty('0'));
     * assertFalse(is_empty(new \SimpleXMLElement('<foo></foo>')));
     * ```
     *
     * @param mixed $var 判定する値
     * @return bool 空なら true
     */
    function is_empty($var)
    {
        // empty で空でない判定ならそれで良い
        if (!empty($var)) {
            return false;
        }

        // "0" は false
        if ($var === '0') {
            return false;
        }

        // object は false
        if (is_object($var)) {
            return false;
        }

        return true;
    }
}

const is_primitive = 'ryunosuke\\Functions\\is_primitive';
if (!isset($excluded_functions['is_primitive']) && (!function_exists('ryunosuke\\Functions\\is_primitive') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\is_primitive'))->isInternal()))) {
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
     * ```php
     * assertTrue(is_primitive(null));
     * assertTrue(is_primitive(false));
     * assertTrue(is_primitive(123));
     * assertTrue(is_primitive(STDIN));
     * assertFalse(is_primitive(new \stdClass));
     * assertFalse(is_primitive(['array']));
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 複合型なら false
     */
    function is_primitive($var)
    {
        return is_scalar($var) || is_null($var) || is_resource($var);
    }
}

const is_recursive = 'ryunosuke\\Functions\\is_recursive';
if (!isset($excluded_functions['is_recursive']) && (!function_exists('ryunosuke\\Functions\\is_recursive') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\is_recursive'))->isInternal()))) {
    /**
     * 変数が再帰参照を含むか調べる
     *
     * Example:
     * ```php
     * // 配列の再帰
     * $array = [];
     * $array['recursive'] = &$array;
     * assertTrue(is_recursive($array));
     * // オブジェクトの再帰
     * $object = new \stdClass();
     * $object->recursive = $object;
     * assertTrue(is_recursive($object));
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 再帰参照を含むなら true
     */
    function is_recursive($var)
    {
        $core = function ($var, $parents) use (&$core) {
            // 複合型でないなら間違いなく false
            if ((is_primitive)($var)) {
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

const is_stringable = 'ryunosuke\\Functions\\is_stringable';
if (!isset($excluded_functions['is_stringable']) && (!function_exists('ryunosuke\\Functions\\is_stringable') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\is_stringable'))->isInternal()))) {
    /**
     * 変数が文字列化できるか調べる
     *
     * 「配列」「__toString を持たないオブジェクト」が false になる。
     * （厳密に言えば配列は "Array" になるので文字列化できるといえるがここでは考えない）。
     *
     * Example:
     * ```php
     * // こいつらは true
     * assertTrue(is_stringable(null));
     * assertTrue(is_stringable(true));
     * assertTrue(is_stringable(3.14));
     * assertTrue(is_stringable(STDOUT));
     * assertTrue(is_stringable(new \Exception()));
     * // こいつらは false
     * assertFalse(is_stringable(new \ArrayObject()));
     * assertFalse(is_stringable([1, 2, 3]));
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 文字列化できるなら true
     */
    function is_stringable($var)
    {
        if (is_array($var)) {
            return false;
        }
        if (is_object($var) && !method_exists($var, '__toString')) {
            return false;
        }
        return true;
    }
}

const is_arrayable = 'ryunosuke\\Functions\\is_arrayable';
if (!isset($excluded_functions['is_arrayable']) && (!function_exists('ryunosuke\\Functions\\is_arrayable') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\is_arrayable'))->isInternal()))) {
    /**
     * 変数が配列アクセス可能か調べる
     *
     * Example:
     * ```php
     * assertTrue(is_arrayable([]));
     * assertTrue(is_arrayable(new \ArrayObject()));
     * assertFalse(is_arrayable(new \stdClass()));
     * ```
     *
     * @param array $var 調べる値
     * @return bool 配列アクセス可能なら true
     */
    function is_arrayable($var)
    {
        return is_array($var) || $var instanceof \ArrayAccess;
    }
}

const is_iterable = 'ryunosuke\\Functions\\is_iterable';
if (!isset($excluded_functions['is_iterable']) && (!function_exists('ryunosuke\\Functions\\is_iterable') || (!true && (new \ReflectionFunction('ryunosuke\\Functions\\is_iterable'))->isInternal()))) {
    /**
     * 変数が foreach で回せるか調べる
     *
     * オブジェクトの場合は \Traversable のみ。
     * 要するに {@link http://php.net/manual/ja/function.is-iterable.php is_iterable} の polyfill。
     *
     * Example:
     * ```php
     * assertTrue(is_iterable([1, 2, 3]));
     * assertTrue(is_iterable((function () { yield 1; })()));
     * assertFalse(is_iterable(1));
     * assertFalse(is_iterable(new \stdClass()));
     * ```
     *
     * @polyfill
     *
     * @param mixed $var 調べる値
     * @return bool foreach で回せるなら true
     */
    function is_iterable($var)
    {
        return is_array($var) || $var instanceof \Traversable;
    }
}

const is_countable = 'ryunosuke\\Functions\\is_countable';
if (!isset($excluded_functions['is_countable']) && (!function_exists('ryunosuke\\Functions\\is_countable') || (!true && (new \ReflectionFunction('ryunosuke\\Functions\\is_countable'))->isInternal()))) {
    /**
     * 変数が count でカウントできるか調べる
     *
     * Example:
     * ```php
     * assertTrue(is_countable([1, 2, 3]));
     * assertTrue(is_countable(new \ArrayObject()));
     * assertFalse(is_countable((function () { yield 1; })()));
     * assertFalse(is_countable(1));
     * assertFalse(is_countable(new \stdClass()));
     * ```
     *
     * @polyfill
     *
     * @param mixed $var 調べる値
     * @return bool count でカウントできるなら true
     */
    function is_countable($var)
    {
        return is_array($var) || $var instanceof \Countable;
    }
}

const varcmp = 'ryunosuke\\Functions\\varcmp';
if (!isset($excluded_functions['varcmp']) && (!function_exists('ryunosuke\\Functions\\varcmp') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\varcmp'))->isInternal()))) {
    /**
     * php7 の `<=>` の関数版
     *
     * 引数で大文字小文字とか自然順とか型モードとかが指定できる。
     *
     * Example:
     * ```php
     * // 'a' と 'z' なら 'z' の方が大きい
     * assertTrue(varcmp('z', 'a') > 0);
     * assertTrue(varcmp('a', 'z') < 0);
     * assertTrue(varcmp('a', 'a') === 0);
     *
     * // 'a' と 'Z' なら 'a' の方が大きい…が SORT_FLAG_CASE なので 'Z' のほうが大きい
     * assertTrue(varcmp('Z', 'a', SORT_FLAG_CASE) > 0);
     * assertTrue(varcmp('a', 'Z', SORT_FLAG_CASE) < 0);
     * assertTrue(varcmp('a', 'A', SORT_FLAG_CASE) === 0);
     *
     * // '2' と '12' なら '2' の方が大きい…が SORT_NATURAL なので '12' のほうが大きい
     * assertTrue(varcmp('12', '2', SORT_NATURAL) > 0);
     * assertTrue(varcmp('2', '12', SORT_NATURAL) < 0);
     * ```
     *
     * @param mixed $a 比較する値1
     * @param mixed $b 比較する値2
     * @param int $mode 比較モード（SORT_XXX）。省略すると型でよしなに選択
     * @return int 等しいなら 0、 $a のほうが大きいなら > 0、 $bのほうが大きいなら < 0
     */
    function varcmp($a, $b, $mode = null)
    {
        // null が来たらよしなにする（なるべく型に寄せるが SORT_REGULAR はキモいので避ける）
        if ($mode === null || $mode === SORT_FLAG_CASE) {
            if ((is_int($a) || is_float($a)) && (is_int($b) || is_float($b))) {
                $mode = SORT_NUMERIC;
            }
            elseif (is_string($a) && is_string($b)) {
                $mode = SORT_STRING | $mode; // SORT_FLAG_CASE が単品で来てるかもしれないので混ぜる
            }
        }

        $flag_case = $mode & SORT_FLAG_CASE;
        $mode = $mode & ~SORT_FLAG_CASE;

        if ($mode === SORT_NUMERIC) {
            return $a - $b;
        }
        if ($mode === SORT_STRING) {
            if ($flag_case) {
                return strcasecmp($a, $b);
            }
            return strcmp($a, $b);
        }
        if ($mode === SORT_NATURAL) {
            if ($flag_case) {
                return strnatcasecmp($a, $b);
            }
            return strnatcmp($a, $b);
        }

        // for SORT_REGULAR
        return $a == $b ? 0 : ($a > $b ? 1 : -1);
    }
}

const var_type = 'ryunosuke\\Functions\\var_type';
if (!isset($excluded_functions['var_type']) && (!function_exists('ryunosuke\\Functions\\var_type') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\var_type'))->isInternal()))) {
    /**
     * 値の型を取得する（gettype + get_class）
     *
     * プリミティブ型（gettype で得られるやつ）はそのまま、オブジェクトのときのみクラス名を返す。
     * ただし、オブジェクトの場合は先頭に '\\' が必ず付く。
     *
     * Example:
     * ```php
     * // プリミティブ型は gettype と同義
     * assertSame(var_type(false), 'boolean');
     * assertSame(var_type(123), 'integer');
     * assertSame(var_type(3.14), 'double');
     * assertSame(var_type([1, 2, 3]), 'array');
     * // オブジェクトは型名を返す
     * assertSame(var_type(new \stdClass), '\\stdClass');
     * assertSame(var_type(new \Exception()), '\\Exception');
     * ```
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

const var_apply = 'ryunosuke\\Functions\\var_apply';
if (!isset($excluded_functions['var_apply']) && (!function_exists('ryunosuke\\Functions\\var_apply') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\var_apply'))->isInternal()))) {
    /**
     * 値にコールバックを適用する
     *
     * 普通のスカラー値であれば `$callback($var)` と全く同じ。
     * この関数は「$var が配列だったら中身に適用して返す（再帰）」という点で上記とは異なる。
     *
     * 「配列が与えられたら要素に適用して配列で返す、配列じゃないなら直に適用してそれを返す」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // 素の値は素の呼び出しと同じ
     * assertSame(var_apply(' x ', 'trim'), 'x');
     * // 配列は中身に適用して配列で返す（再帰）
     * assertSame(var_apply([' x ', ' y ', [' z ']], 'trim'), ['x', 'y', ['z']]);
     * // 第3引数以降は残り引数を意味する
     * assertSame(var_apply(['!x!', '!y!'], 'trim', '!'), ['x', 'y']);
     * // 「まれによくある」の具体例
     * assertSame(var_apply(['<x>', ['<y>']], 'htmlspecialchars', ENT_QUOTES, 'utf-8'), ['&lt;x&gt;', ['&lt;y&gt;']]);
     * ```
     *
     * @param mixed $var $callback を適用する値
     * @param callable $callback 値変換コールバック
     * @param array $args $callback の残り引数（可変引数）
     * @return mixed|array $callback が適用された値。元が配列なら配列で返す
     */
    function var_apply($var, $callback, ...$args)
    {
        $iterable = (is_iterable)($var);
        if ($iterable) {
            $result = [];
            foreach ($var as $k => $v) {
                $result[$k] = (var_apply)($v, $callback, ...$args);
            }
            return $result;
        }

        return $callback($var, ...$args);
    }
}

const var_applys = 'ryunosuke\\Functions\\var_applys';
if (!isset($excluded_functions['var_applys']) && (!function_exists('ryunosuke\\Functions\\var_applys') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\var_applys'))->isInternal()))) {
    /**
     * 配列にコールバックを適用する
     *
     * 配列であれば `$callback($var)` と全く同じ。
     * この関数は「$var がスカラー値だったら配列化して適用してスカラーで返す」という点で上記とは異なる。
     *
     * 「配列を受け取って配列を返す関数があるが、手元にスカラー値しか無い」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // 配列を受け取って中身を大文字化して返すクロージャ
     * $upper = function($array){return array_map('strtoupper', $array);};
     * // 普通はこうやって使うが・・・
     * assertSame($upper(['a', 'b', 'c']), ['A', 'B', 'C']);
     * // 手元に配列ではなくスカラー値しか無いときはこうせざるをえない
     * assertSame($upper(['a'])[0], 'A');
     * // var_applys を使うと配列でもスカラーでも統一的に記述することができる
     * assertSame(var_applys(['a', 'b', 'c'], $upper), ['A', 'B', 'C']);
     * assertSame(var_applys('a', $upper), 'A');
     * # 要するに「大文字化したい」だけなわけだが、$upper が配列を前提としているので、「大文字化」部分を得るには配列化しなければならなくなっている
     * # 「strtoupper だけ切り出せばよいのでは？」と思うかもしれないが、「（外部ライブラリなどで）手元に配列しか受け取ってくれない処理しかない」状況がまれによくある
     * ```
     *
     * @param mixed $var $callback を適用する値
     * @param callable $callback 値変換コールバック
     * @param array $args $callback の残り引数（可変引数）
     * @return mixed|array $callback が適用された値。元が配列なら配列で返す
     */
    function var_applys($var, $callback, ...$args)
    {
        $iterable = (is_iterable)($var);
        if (!$iterable) {
            $var = [$var];
        }
        $var = $callback($var, ...$args);
        return $iterable ? $var : $var[0];
    }
}

const var_export2 = 'ryunosuke\\Functions\\var_export2';
if (!isset($excluded_functions['var_export2']) && (!function_exists('ryunosuke\\Functions\\var_export2') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\var_export2'))->isInternal()))) {
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
     * ```php
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
     * ```
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
                    if ((array_all)($value, is_primitive)) {
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
                $values = (array_map_key)($value, $export);
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
                $parents[] = $value;
                return get_class($value) . '::__set_state(' . $export((get_object_properties)($value), $nest, $parents) . ')';
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

const var_html = 'ryunosuke\\Functions\\var_html';
if (!isset($excluded_functions['var_html']) && (!function_exists('ryunosuke\\Functions\\var_html') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\var_html'))->isInternal()))) {
    /**
     * var_export2 を html コンテキストに特化させたようなもの
     *
     * 下記のような出力になる。
     * - `<pre class='var_html'> ～ </pre>` で囲まれる
     * - php 構文なのでハイライトされて表示される
     * - Content-Type が強制的に text/html になる
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * @param mixed $value 出力する値
     */
    function var_html($value)
    {
        $var_export = function ($value) {
            $result = var_export($value, true);
            $result = highlight_string("<?php " . $result, true);
            $result = preg_replace('#&lt;\\?php(\s|&nbsp;)#u', '', $result, 1);
            $result = preg_replace('#<br />#u', "\n", $result);
            $result = preg_replace('#>\n<#u', '><', $result);
            return $result;
        };

        $export = function ($value, $parents) use (&$export, $var_export) {
            foreach ($parents as $parent) {
                if ($parent === $value) {
                    return '*RECURSION*';
                }
            }
            if (is_array($value)) {
                $count = count($value);
                if (!$count) {
                    return '[empty]';
                }

                $maxlen = max(array_map('strlen', array_keys($value)));
                $kvl = '';
                $parents[] = $value;
                foreach ($value as $k => $v) {
                    $align = str_repeat(' ', $maxlen - strlen($k));
                    $kvl .= $var_export($k) . $align . ' => ' . $export($v, $parents) . "\n";
                }
                $var = "<var style='text-decoration:underline'>$count elements</var>";
                $summary = "<summary style='cursor:pointer;color:#0a6ebd'>[$var]</summary>";
                return "<details style='display:inline;vertical-align:text-top'>$summary$kvl</details>";
            }
            elseif (is_object($value)) {
                $parents[] = $value;
                return get_class($value) . '::' . $export((get_object_properties)($value), $parents);
            }
            elseif (is_null($value)) {
                return 'null';
            }
            elseif (is_resource($value)) {
                return ((string) $value) . '(' . get_resource_type($value) . ')';
            }
            else {
                return $var_export($value);
            }
        };

        // text/html を強制する（でないと見やすいどころか見づらくなる）
        // @codeCoverageIgnoreStart
        if (!headers_sent()) {
            header_remove('Content-Type');
            header('Content-Type: text/html');
        }
        // @codeCoverageIgnoreEnd

        echo "<pre class='var_html'>{$export($value, [])}</pre>";
    }
}

const hashvar = 'ryunosuke\\Functions\\hashvar';
if (!isset($excluded_functions['hashvar']) && (!function_exists('ryunosuke\\Functions\\hashvar') || (!false && (new \ReflectionFunction('ryunosuke\\Functions\\hashvar'))->isInternal()))) {
    /**
     * 変数指定をできるようにした compact
     *
     * 名前空間指定の呼び出しは未対応。use して関数名だけで呼び出す必要がある。
     *
     * Example:
     * ```php
     * $hoge = 'HOGE';
     * $fuga = 'FUGA';
     * assertSame(hashvar($hoge, $fuga), ['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * ```
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
        $function = (function_shorten)($trace['function']);

        $cache = (cache)($file . '#' . $line, function () use ($file, $line, $function) {
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
                    if ($starting && $token === ')' && $caller) {
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
