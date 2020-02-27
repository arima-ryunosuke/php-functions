<?php

namespace ryunosuke\Functions\Package;

/**
 * 配列関連のユーティリティ
 */
class Arrays
{
    /**
     * 配列をシーケンシャルに走査するジェネレータを返す
     *
     * 「シーケンシャルに」とは要するに数値連番が得られるように走査するということ。
     * 0ベースの連番を作ってインクリメントしながら foreach するのと全く変わらない。
     *
     * キーは連番、値は [$key, $value] で返す。
     * つまり、 Example のように foreach の list 構文を使えば「連番、キー、値」でループを回すことが可能になる。
     * 「foreach で回したいんだけど連番も欲しい」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * $nkv = [];
     * foreach (arrays($array) as $n => [$k, $v]) {
     *     $nkv[] = "$n,$k,$v";
     * }
     * that($nkv)->isSame(['0,a,A', '1,b,B', '2,c,C']);
     * ```
     *
     * @param iterable $array 対象配列
     * @return \Generator [$seq => [$key, $value]] を返すジェネレータ
     */
    public static function arrays($array)
    {
        $n = 0;
        foreach ($array as $k => $v) {
            yield $n++ => [$k, $v];
        }
    }

    /**
     * 引数の配列を生成する。
     *
     * 配列以外を渡すと配列化されて追加される。
     * 連想配列は未対応。あくまで普通の配列化のみ。
     * iterable や Traversable は考慮せずあくまで「配列」としてチェックする。
     *
     * Example:
     * ```php
     * that(arrayize(1, 2, 3))->isSame([1, 2, 3]);
     * that(arrayize([1], [2], [3]))->isSame([1, 2, 3]);
     * $object = new \stdClass();
     * that(arrayize($object, false, [1, 2, 3]))->isSame([$object, false, 1, 2, 3]);
     * ```
     *
     * @param mixed $variadic 生成する要素（可変引数）
     * @return array 引数を配列化したもの
     */
    public static function arrayize(...$variadic)
    {
        $result = [];
        foreach ($variadic as $arg) {
            if (!is_array($arg)) {
                $result[] = $arg;
            }
            elseif (!(is_hasharray)($arg)) {
                $result = array_merge($result, $arg);
            }
            else {
                $result += $arg;
            }
        }
        return $result;
    }

    /**
     * 配列が数値配列か調べる
     *
     * 空の配列も数値配列とみなす。
     * さらにいわゆる「連番配列」ではなく「キーが数値のみか？」で判定する。
     *
     * つまり、 is_hasharray とは排他的ではない。
     *
     * Example:
     * ```php
     * that(is_indexarray([]))->isTrue();
     * that(is_indexarray([1, 2, 3]))->isTrue();
     * that(is_indexarray(['x' => 'X']))->isFalse();
     * // 抜け番があっても true になる（これは is_hasharray も true になる）
     * that(is_indexarray([1 => 1, 2 => 2, 3 => 3]))->isTrue();
     * ```
     *
     * @param array $array 調べる配列
     * @return bool 数値配列なら true
     */
    public static function is_indexarray($array)
    {
        foreach ($array as $k => $dummy) {
            if (!is_int($k)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 配列が連想配列か調べる
     *
     * 空の配列は普通の配列とみなす。
     *
     * Example:
     * ```php
     * that(is_hasharray([]))->isFalse();
     * that(is_hasharray([1, 2, 3]))->isFalse();
     * that(is_hasharray(['x' => 'X']))->isTrue();
     * ```
     *
     * @param array $array 調べる配列
     * @return bool 連想配列なら true
     */
    public static function is_hasharray(array $array)
    {
        $i = 0;
        foreach ($array as $k => $dummy) {
            if ($k !== $i++) {
                return true;
            }
        }
        return false;
    }

    /**
     * 配列の最初のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(first_key(['a', 'b', 'c']))->isSame(0);
     * that(first_key([], 999))->isSame(999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最初のキー
     */
    public static function first_key($array, $default = null)
    {
        if ((is_empty)($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$k, $v] = (first_keyvalue)($array);
        return $k;
    }

    /**
     * 配列の最初の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(first_value(['a', 'b', 'c']))->isSame('a');
     * that(first_value([], 999))->isSame(999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最初の値
     */
    public static function first_value($array, $default = null)
    {
        if ((is_empty)($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$k, $v] = (first_keyvalue)($array);
        return $v;
    }

    /**
     * 配列の最初のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(first_keyvalue(['a', 'b', 'c']))->isSame([0, 'a']);
     * that(first_keyvalue([], 999))->isSame(999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return array [最初のキー, 最初の値]
     */
    public static function first_keyvalue($array, $default = null)
    {
        foreach ($array as $k => $v) {
            return [$k, $v];
        }
        return $default;
    }

    /**
     * 配列の最後のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(last_key(['a', 'b', 'c']))->isSame(2);
     * that(last_key([], 999))->isSame(999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最後のキー
     */
    public static function last_key($array, $default = null)
    {
        if ((is_empty)($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$k, $v] = (last_keyvalue)($array);
        return $k;
    }

    /**
     * 配列の最後の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(last_value(['a', 'b', 'c']))->isSame('c');
     * that(last_value([], 999))->isSame(999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最後の値
     */
    public static function last_value($array, $default = null)
    {
        if ((is_empty)($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$k, $v] = (last_keyvalue)($array);
        return $v;
    }

    /**
     * 配列の最後のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(last_keyvalue(['a', 'b', 'c']))->isSame([2, 'c']);
     * that(last_keyvalue([], 999))->isSame(999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return array [最後のキー, 最後の値]
     */
    public static function last_keyvalue($array, $default = null)
    {
        if ((is_empty)($array)) {
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
     * that(prev_key($array, 'b'))->isSame('a');
     * // 'a' キーの前は無いので null
     * that(prev_key($array, 'a'))->isSame(null);
     * // 'x' キーはそもそも存在しないので false
     * that(prev_key($array, 'x'))->isSame(false);
     * ```
     *
     * @param array $array 対象配列
     * @param string|int $key 調べるキー
     * @return string|int|bool|null $key の前のキー
     */
    public static function prev_key($array, $key)
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
     * that(next_key($array, 'b'))->isSame('c');
     * // 'c' キーの次は無いので null
     * that(next_key($array, 'c'))->isSame(null);
     * // 'x' キーはそもそも存在しないので false
     * that(next_key($array, 'x'))->isSame(false);
     * // 次に生成されるキーは 10
     * that(next_key($array, null))->isSame(10);
     * ```
     *
     * @param array $array 対象配列
     * @param string|int|null $key 調べるキー
     * @return string|int|bool|null $key の次のキー
     */
    public static function next_key($array, $key = null)
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
     * that(in_array_and([1], [1, 2, 3]))->isTrue();
     * that(in_array_and([9], [1, 2, 3]))->isFalse();
     * that(in_array_and([1, 9], [1, 2, 3]))->isFalse();
     * ```
     *
     * @param array|mixed $needle 調べる値
     * @param array $haystack 調べる配列
     * @param bool $strict 厳密フラグ
     * @return bool $needle のすべてが含まれているなら true
     */
    public static function in_array_and($needle, $haystack, $strict = false)
    {
        $needle = is_iterable($needle) ? $needle : [$needle];
        if ((is_empty)($needle)) {
            return false;
        }

        foreach ($needle as $v) {
            if (!in_array($v, $haystack, $strict)) {
                return false;
            }
        }
        return true;
    }

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
     * that(in_array_or([1], [1, 2, 3]))->isTrue();
     * that(in_array_or([9], [1, 2, 3]))->isFalse();
     * that(in_array_or([1, 9], [1, 2, 3]))->isTrue();
     * ```
     *
     * @param array|mixed $needle 調べる値
     * @param array $haystack 調べる配列
     * @param bool $strict 厳密フラグ
     * @return bool $needle のどれかが含まれているなら true
     */
    public static function in_array_or($needle, $haystack, $strict = false)
    {
        $needle = is_iterable($needle) ? $needle : [$needle];
        if ((is_empty)($needle)) {
            return false;
        }

        foreach ($needle as $v) {
            if (in_array($v, $haystack, $strict)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 比較関数にキーも渡ってくる安定ソート
     *
     * 比較関数は ($avalue, $bvalue, $akey, $bkey) という引数を取る。
     * 「値で比較して同値だったらキーも見たい」という状況はまれによくあるはず。
     * さらに安定ソートであり、同値だとしても元の並び順は維持される。
     *
     * $comparator は省略できる。省略した場合、型に基づいてよしなにソートする。
     * （が、比較のたびに型チェックが入るので指定したほうが高速に動く）。
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
     * that(kvsort($array))->isSame([
     *     'b'  => 1,
     *     'c'  => 2,
     *     'a'  => 3,
     *     'x1' => 9,
     *     'x2' => 9,
     *     'x3' => 9,
     * ]);
     * // キーを使用したソート
     * that(kvsort($array, function($av, $bv, $ak, $bk){return strcmp($bk, $ak);}))->isSame([
     *     'x3' => 9,
     *     'x2' => 9,
     *     'x1' => 9,
     *     'c'  => 2,
     *     'b'  => 1,
     *     'a'  => 3,
     * ]);
     * ```
     *
     * @param iterable|string $array 対象配列
     * @param callable|int $comparator 比較関数。SORT_XXX も使える
     * @return array ソートされた配列
     */
    public static function kvsort($array, $comparator = null)
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

    /**
     * 配列の+演算子の関数版
     *
     * Example:
     * ```php
     * // ただの加算の関数版なので同じキーは上書きされない
     * that(array_add(['a', 'b', 'c'], ['X']))->isSame(['a', 'b', 'c']);
     * // 異なるキーは生える
     * that(array_add(['a', 'b', 'c'], ['x' => 'X']))->isSame(['a', 'b', 'c', 'x' => 'X']);
     * ```
     *
     * @param array $variadic 足す配列（可変引数）
     * @return array 足された配列
     */
    public static function array_add(...$variadic)
    {
        $array = [];
        foreach ($variadic as $arg) {
            $array += $arg;
        }
        return $array;
    }

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
     * that(array_mix([1, 3, 5], [2, 4, 6]))->isSame([1, 2, 3, 4, 5, 6]);
     * // 長さが異なる場合はそのまま追加される（短い方の足りない分は無視される）
     * that(array_mix([1], [2, 3, 4]))->isSame([1, 2, 3, 4]);
     * that(array_mix([1, 3, 4], [2]))->isSame([1, 2, 3, 4]);
     * // 可変引数なので3配列以上も可
     * that(array_mix([1], [2, 4], [3, 5, 6]))->isSame([1, 2, 3, 4, 5, 6]);
     * that(array_mix([1, 4, 6], [2, 5], [3]))->isSame([1, 2, 3, 4, 5, 6]);
     * // 文字キーは維持される
     * that(array_mix(['a' => 'A', 1, 3], ['b' => 'B', 2]))->isSame(['a' => 'A', 'b' => 'B', 1, 2, 3]);
     * ```
     *
     * @param array $variadic 対象配列（可変引数）
     * @return array 引数配列が交互に追加された配列
     */
    public static function array_mix(...$variadic)
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

    /**
     * 配列の各要素値で順番に配列を作る
     *
     * `array_map(null, ...$arrays)` とほぼ同義。ただし
     *
     * - 文字キーは保存される（数値キーは再割り振りされる）
     * - 一つだけ配列を与えても構造は壊れない（array_map(null) は壊れる）
     *
     * Example:
     * ```php
     * // 普通の zip
     * that(array_zip(
     *     [1, 2, 3],
     *     ['hoge', 'fuga', 'piyo']
     * ))->is([[1, 'hoge'], [2, 'fuga'], [3, 'piyo']]);
     * // キーが維持される
     * that(array_zip(
     *     ['a' => 1, 2, 3],
     *     ['hoge', 'b' => 'fuga', 'piyo']
     * ))->is([['a' => 1, 'hoge'], [2, 'b' => 'fuga'], [3, 'piyo']]);
     * ```
     *
     * @param array $arrays 対象配列（可変引数）
     * @return array 各要素値の配列
     */
    public static function array_zip(...$arrays)
    {
        $count = count($arrays);
        if ($count === 0) {
            throw new \InvalidArgumentException('$arrays is empty.');
        }

        // キー保持処理がかなり遅いので純粋な配列しかないのなら array_map(null) の方が（チェックを加味しても）速くなる
        foreach ($arrays as $a) {
            if ((is_hasharray)($a)) {
                /** @var \Generator[] $yielders */
                $yielders = array_map(function ($array) { yield from $array; }, $arrays);

                $result = [];
                for ($i = 0, $limit = max(array_map('count', $arrays)); $i < $limit; $i++) {
                    $e = [];
                    foreach ($yielders as $yielder) {
                        (array_put)($e, $yielder->current(), $yielder->key());
                        $yielder->next();
                    }
                    $result[] = $e;
                }
                return $result;
            }
        }

        // array_map(null) は1つだけ与えると構造がぶっ壊れる
        if ($count === 1) {
            return array_map(function ($v) { return [$v]; }, $arrays[0]);
        }
        return array_map(null, ...$arrays);

        /* MultipleIterator を使った実装。かなり遅かったので採用しなかったが、一応コメントとして残す
        $mi = new \MultipleIterator(\MultipleIterator::MIT_NEED_ANY | \MultipleIterator::MIT_KEYS_NUMERIC);
        foreach ($arrays as $array) {
            $mi->attachIterator((function ($array) { yield from $array; })($array));
        }

        $result = [];
        foreach ($mi as $k => $v) {
            $e = [];
            for ($i = 0; $i < $count; $i++) {
                (array_put)($e, $v[$i], $k[$i]);
            }
            $result[] = $e;
        }
        return $result;
        */
    }

    /**
     * 配列の直積を返す
     *
     * 文字キーは保存されるが数値キーは再割り振りされる。
     * ただし、文字キーが重複すると例外を投げる。
     *
     * Example:
     * ```php
     * // 普通の直積
     * that(array_cross(
     *     [1, 2],
     *     [3, 4]
     * ))->isSame([[1, 3], [1, 4], [2, 3], [2, 4]]);
     * // キーが維持される
     * that(array_cross(
     *     ['a' => 1, 2],
     *     ['b' => 3, 4]
     * ))->isSame([['a' => 1, 'b' => 3], ['a' => 1, 4], [2, 'b' => 3], [2, 4]]);
     * ```
     *
     * @param array $arrays 対象配列（可変引数）
     * @return array 各配列値の直積
     */
    public static function array_cross(...$arrays)
    {
        if (!$arrays) {
            return [];
        }

        $result = [[]];
        foreach ($arrays as $array) {
            $tmp = [];
            foreach ($result as $x) {
                foreach ($array as $k => $v) {
                    if (is_string($k) && array_key_exists($k, $x)) {
                        throw new \InvalidArgumentException("duplicated key '$k'.");
                    }
                    $tmp[] = array_merge($x, [$k => $v]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }

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
     * that(array_implode(['a', 'b', 'c'], 'X'))->isSame(['a', 'X', 'b', 'X', 'c']);
     * // (要素, ...配列) の呼び出し
     * that(array_implode('X', 'a', 'b', 'c'))->isSame(['a', 'X', 'b', 'X', 'c']);
     * ```
     *
     * @param iterable|string $array 対象配列
     * @param string $glue 差し込む要素
     * @return array 差し込まれた配列
     */
    public static function array_implode($array, $glue)
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

    /**
     * 配列を指定条件で分割する
     *
     * 文字列の explode を更に一階層掘り下げたイメージ。
     * $condition で指定された要素は結果配列に含まれない。
     *
     * $condition にはクロージャが指定できる。クロージャの場合は true 相当を返した場合に分割要素とみなされる。
     * 引数は (値, キー)の順番。
     *
     * $limit に負数を与えると「その絶対値-1までを結合したものと残り」を返す。
     * 端的に言えば「正数を与えると後詰めでその個数で返す」「負数を与えると前詰めでその（絶対値）個数で返す」という動作になる。
     *
     * Example:
     * ```php
     * // null 要素で分割
     * that(array_explode(['a', null, 'b', 'c'], null))->isSame([['a'], [2 => 'b', 3 => 'c']]);
     * // クロージャで分割（大文字で分割）
     * that(array_explode(['a', 'B', 'c', 'D', 'e'], function($v){return ctype_upper($v);}))->isSame([['a'], [2 => 'c'], [4 => 'e']]);
     * // 負数指定
     * that(array_explode(['a', null, 'b', null, 'c'], null, -2))->isSame([[0 => 'a', 1 => null, 2 => 'b'], [4 => 'c']]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $condition 分割条件
     * @param int $limit 最大分割数
     * @return array 分割された配列
     */
    public static function array_explode($array, $condition, $limit = \PHP_INT_MAX)
    {
        $array = (arrayval)($array, false);

        $limit = (int) $limit;
        if ($limit < 0) {
            // キーまで考慮するとかなりややこしくなるので富豪的にやる
            $reverse = (array_explode)(array_reverse($array, true), $condition, -$limit);
            $reverse = array_map(function ($v) { return array_reverse($v, true); }, $reverse);
            return array_reverse($reverse);
        }
        // explode において 0 は 1 と等しい
        if ($limit === 0) {
            $limit = 1;
        }

        $result = [];
        $chunk = [];
        $n = 0;
        foreach ($array as $k => $v) {
            if ($limit === 1) {
                $chunk = array_slice($array, $n, null, true);
                break;
            }

            $n++;
            if ($condition instanceof \Closure) {
                $match = $condition($v, $k);
            }
            else {
                $match = $condition === $v;
            }

            if ($match) {
                $limit--;
                $result[] = $chunk;
                $chunk = [];
            }
            else {
                $chunk[$k] = $v;
            }
        }
        $result[] = $chunk;
        return $result;
    }


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
     * that(array_sprintf($array, '%2$s=%1$s'))->isSame(['key1=val1', 'key2=val2']);
     * // 第3引数を与えるとさらに implode される
     * that(array_sprintf($array, '%2$s=%1$s', ' '))->isSame('key1=val1 key2=val2');
     * // クロージャを与えるとコールバック動作になる
     * $closure = function($v, $k){return "$k=" . strtoupper($v);};
     * that(array_sprintf($array, $closure, ' '))->isSame('key1=VAL1 key2=VAL2');
     * // 省略すると vsprintf になる
     * that(array_sprintf([
     *     'str:%s,int:%d' => ['sss', '3.14'],
     *     'single:%s'     => 'str',
     * ], null, '|'))->isSame('str:sss,int:3|single:str');
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|callable $format 書式文字列あるいはクロージャ
     * @param string $glue 結合文字列。未指定時は implode しない
     * @return array|string sprintf された配列
     */
    public static function array_sprintf($array, $format = null, $glue = null)
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
     * that(array_strpad($array, 'prefix-'))->isSame(['prefix-key1' => 'val1', 'prefix-key2' => 'val2']);
     * // 値にサフィックス付与
     * that(array_strpad($array, '', ['-suffix']))->isSame(['key1' => 'val1-suffix', 'key2' => 'val2-suffix']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|array $key_prefix キー側の付加文字列
     * @param string|array $val_prefix 値側の付加文字列
     * @return array 文字列付与された配列
     */
    public static function array_strpad($array, $key_prefix, $val_prefix = '')
    {
        $key_suffix = '';
        if (is_array($key_prefix)) {
            [$key_suffix, $key_prefix] = $key_prefix + [1 => ''];
        }
        $val_suffix = '';
        if (is_array($val_prefix)) {
            [$val_suffix, $val_prefix] = $val_prefix + [1 => ''];
        }

        $enable_key = strlen($key_prefix) || strlen($key_suffix);
        $enable_val = strlen($val_prefix) || strlen($val_suffix);

        $result = [];
        foreach ($array as $key => $val) {
            if ($enable_key) {
                $key = $key_prefix . $key . $key_suffix;
            }
            if ($enable_val) {
                $val = $val_prefix . $val . $val_suffix;
            }
            $result[$key] = $val;
        }
        return $result;
    }

    /**
     * 配列・連想配列を問わず「N番目(0ベース)」の要素を返す
     *
     * 負数を与えると逆から N 番目となる。
     *
     * Example:
     * ```php
     * that(array_pos([1, 2, 3], 1))->isSame(2);
     * that(array_pos([1, 2, 3], -1))->isSame(3);
     * that(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1))->isSame('B');
     * that(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1, true))->isSame('b');
     * ```
     *
     * @param array $array 対象配列
     * @param int $position 取得する位置
     * @param bool $return_key true にすると値ではなくキーを返す
     * @return mixed 指定位置の値
     */
    public static function array_pos($array, $position, $return_key = false)
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

    /**
     * 配列の指定キーの位置を返す
     *
     * Example:
     * ```php
     * that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'c'))->isSame(2);
     * that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x', -1))->isSame(-1);
     * ```
     *
     * @param array $array 対象配列
     * @param string|int $key 取得する位置
     * @param mixed $default 見つからなかったときのデフォルト値。指定しないと例外
     * @return mixed 指定キーの位置
     */
    public static function array_pos_key($array, $key, $default = null)
    {
        // very slow
        // return array_flip(array_keys($array))[$key];

        $n = 0;
        foreach ($array as $k => $v) {
            if ($k === $key) {
                return $n;
            }
            $n++;
        }

        if (func_num_args() === 2) {
            throw new \OutOfBoundsException("$key is not found.");
        }
        return $default;
    }

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
     * that($fuga_of_array(['hoge' => 'HOGE', 'fuga' => 'FUGA']))->isSame('FUGA');
     * ```
     *
     * @param string|int|array $key 取得したいキー
     * @param mixed $default デフォルト値
     * @return \Closure $key の値を返すクロージャ
     */
    public static function array_of($key, $default = null)
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
     * that(array_get(['a', 'b', 'c'], 1))->isSame('b');
     * // 単純デフォルト
     * that(array_get(['a', 'b', 'c'], 9, 999))->isSame(999);
     * // 配列取得
     * that(array_get(['a', 'b', 'c'], [0, 2]))->isSame([0 => 'a', 2 => 'c']);
     * // 配列部分取得
     * that(array_get(['a', 'b', 'c'], [0, 9]))->isSame([0 => 'a']);
     * // 配列デフォルト（null ではなく [] を返す）
     * that(array_get(['a', 'b', 'c'], [9]))->isSame([]);
     * // クロージャ指定＆単値（コールバックが true を返す最初の要素）
     * that(array_get(['a', 'b', 'c'], function($v){return in_array($v, ['b', 'c']);}))->isSame('b');
     * // クロージャ指定＆配列（コールバックが true を返すもの）
     * that(array_get(['a', 'b', 'c'], function($v){return in_array($v, ['b', 'c']);}, []))->isSame([1 => 'b', 2 => 'c']);
     * ```
     *
     * @param array $array 配列
     * @param string|int|array $key 取得したいキー。配列を与えると全て返す。クロージャの場合は true 相当を返す
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 指定したキーの値
     */
    public static function array_get($array, $key, $default = null)
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
     * that(array_set($array, 'Z'))->isSame(1);
     * that($array)->isSame(['a' => 'A', 'B', 'Z']);
     * // 第3引数でキーを指定
     * that(array_set($array, 'Z', 'z'))->isSame('z');
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'z' => 'Z']);
     * that(array_set($array, 'Z', 'z'))->isSame('z');
     * // 第3引数で配列を指定
     * that(array_set($array, 'Z', ['x', 'y', 'z']))->isSame('z');
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'z' => 'Z', 'x' => ['y' => ['z' => 'Z']]]);
     * ```
     *
     * @param array $array 配列
     * @param mixed $value 設定する値
     * @param array|string|int|null $key 設定するキー
     * @param bool $require_return 返り値が不要なら false を渡す
     * @return string|int 設定したキー
     */
    public static function array_set(&$array, $value, $key = null, $require_return = true)
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

    /**
     * キー指定の配列値設定
     *
     * array_set とほとんど同じ。
     * 第3引数を省略すると（null を与えると）言語機構を使用して配列の最後に設定する（$array[] = $value）。
     * また、**int を与えても同様の動作**となる。
     * 第3引数に配列を指定すると潜って設定する。
     *
     * array_set における $require_return は廃止している。
     * これはもともと end や last_key が遅かったのでオプショナルにしていたが、もう改善しているし、7.3 から array_key_last があるので、呼び元で適宜使えば良い。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'B'];
     * // 第3引数 int
     * that(array_put($array, 'Z', 999))->isSame(1);
     * that($array)->isSame(['a' => 'A', 'B', 'Z']);
     * // 第3引数省略（最後に連番キーで設定）
     * that(array_put($array, 'Z'))->isSame(2);
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'Z']);
     * // 第3引数でキーを指定
     * that(array_put($array, 'Z', 'z'))->isSame('z');
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z']);
     * that(array_put($array, 'Z', 'z'))->isSame('z');
     * // 第3引数で配列を指定
     * that(array_put($array, 'Z', ['x', 'y', 'z']))->isSame('z');
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z', 'x' => ['y' => ['z' => 'Z']]]);
     * ```
     *
     * @param array $array 配列
     * @param mixed $value 設定する値
     * @param array|string|int|null $key 設定するキー
     * @return string|int 設定したキー
     */
    public static function array_put(&$array, $value, $key = null)
    {
        if (is_array($key)) {
            $k = array_shift($key);
            if ($key) {
                if (is_array($array) && array_key_exists($k, $array) && !is_array($array[$k])) {
                    throw new \InvalidArgumentException('$array[$k] is not array.');
                }
                return (array_put)(...[&$array[$k], $value, $key]);
            }
            else {
                return (array_put)(...[&$array, $value, $k]);
            }
        }

        if ($key === null || is_int($key)) {
            $array[] = $value;
            // compatible array_key_last under 7.3
            end($array);
            $key = key($array);
        }
        else {
            $array[$key] = $value;
        }
        return $key;
    }

    /**
     * 伏せると同時にその値を返す
     *
     * $key に配列を与えると全て伏せて配列で返す。
     * その場合、$default が活きるのは「全て無かった場合」となる。
     *
     * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
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
     * that(array_unset($array, 'x', 'X'))->isSame('X');
     * // 指定したキーを返す。そのキーは伏せられている
     * that(array_unset($array, 'a'))->isSame('A');
     * that($array)->isSame(['b' => 'B']);
     *
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 配列を与えるとそれらを返す。そのキーは全て伏せられている
     * that(array_unset($array, ['a', 'b', 'x']))->isSame(['A', 'B']);
     * that($array)->isSame(['c' => 'C']);
     *
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 配列のキーは返されるキーを表す。順番も維持される
     * that(array_unset($array, ['x2' => 'b', 'x1' => 'a']))->isSame(['x2' => 'B', 'x1' => 'A']);
     *
     * $array = ['hoge' => 'HOGE', 'fuga' => 'FUGA', 'piyo' => 'PIYO'];
     * // 値に "G" を含むものを返す。その要素は伏せられている
     * that(array_unset($array, function($v){return strpos($v, 'G') !== false;}))->isSame(['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * that($array)->isSame(['piyo' => 'PIYO']);
     * ```
     *
     * @param array $array 配列
     * @param string|int|array|callable $key 伏せたいキー。配列を与えると全て伏せる。クロージャの場合は true 相当を伏せる
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 指定したキーの値
     */
    public static function array_unset(&$array, $key, $default = null)
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
     * that(array_dive($array, 'a.b.c'))->isSame('vvv');
     * that(array_dive($array, 'a.b.x', 9))->isSame(9);
     * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
     * that(array_dive($array, ['a', 'b', 'c']))->isSame('vvv');
     * ```
     *
     * @param array $array 調べる配列
     * @param string|array $path パス文字列。配列も与えられる
     * @param mixed $default 無かった場合のデフォルト値
     * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
     * @return mixed パスが示す配列の値
     */
    public static function array_dive($array, $path, $default = null, $delimiter = '.')
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
     * that(array_keys_exist(['a', 'b', 'c'], ['a' => 'A', 'b' => 'B', 'c' => 'C']))->isTrue();
     * // N は含まないので false
     * that(array_keys_exist(['a', 'b', 'N'], ['a' => 'A', 'b' => 'B', 'c' => 'C']))->isFalse();
     * // 配列を与えると潜る（日本語で言えば「a というキーと、x というキーとその中に x1, x2 というキーがあるか？」）
     * that(array_keys_exist(['a', 'x' => ['x1', 'x2']], ['a' => 'A', 'x' => ['x1' => 'X1', 'x2' => 'X2']]))->isTrue();
     * ```
     *
     * @param array|string $keys 調べるキー
     * @param array|\ArrayAccess $array 調べる配列
     * @return bool 指定キーが全て存在するなら true
     */
    public static function array_keys_exist($keys, $array)
    {
        $keys = is_iterable($keys) ? $keys : [$keys];
        if ((is_empty)($keys)) {
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
     * that(array_find(['a', 'b', '9'], 'ctype_digit'))->isSame(2);
     * that(array_find(['a', 'b', '9'], function($v){return $v === 'b';}))->isSame(1);
     * // 最初に見つかったコールバック結果を返す（最初の数字の2乗を返す）
     * $ifnumeric2power = function($v){return ctype_digit($v) ? $v * $v : false;};
     * that(array_find(['a', 'b', '9'], $ifnumeric2power, false))->isSame(81);
     * ```
     *
     * @param iterable $array 調べる配列
     * @param callable $callback 評価コールバック
     * @param bool $is_key キーを返すか否か
     * @return mixed コールバックが true を返した最初のキー。存在しなかったら false
     */
    public static function array_find($array, $callback, $is_key = true)
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

    /**
     * キーをマップ配列で置換する
     *
     * 変換先が null だとその要素は取り除かれる。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // a は x に c は z に置換される
     * that(array_rekey($array, ['a' => 'x', 'c' => 'z']))->isSame(['x' => 'A', 'b' => 'B', 'z' => 'C']);
     * // b は削除され c は z に置換される
     * that(array_rekey($array, ['b' => null, 'c' => 'z']))->isSame(['a' => 'A', 'z' => 'C']);
     * // キーの交換にも使える（a ⇔ c）
     * that(array_rekey($array, ['a' => 'c', 'c' => 'a']))->isSame(['c' => 'A', 'b' => 'B', 'a' => 'C']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param array $keymap マップ配列
     * @return array キーが置換された配列
     */
    public static function array_rekey($array, $keymap)
    {
        $result = [];
        foreach ($array as $k => $v) {
            if (array_key_exists($k, $keymap)) {
                // null は突っ込まない（除去）
                if ($keymap[$k] !== null) {
                    $result[$keymap[$k]] = $v;
                }
            }
            else {
                $result[$k] = $v;
            }
        }
        return $result;
    }

    /**
     * キーを正規表現でフィルタする
     *
     * Example:
     * ```php
     * that(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#'))->isSame(['a' => 'A', 'aa' => 'AA']);
     * that(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#', true))->isSame(['b' => 'B']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string $regex 正規表現
     * @param bool $not true にすると「マッチしない」でフィルタする
     * @return array 正規表現でフィルタされた配列
     */
    public static function array_grep_key($array, $regex, $not = false)
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

    /**
     * array_map の再帰版
     *
     * 下記の点で少し array_map とは挙動が異なる。
     *
     * - 配列だけでなく iterable も対象になる（引数で指定可能。デフォルト true）
     *     - つまりオブジェクト構造は維持されず、結果はすべて配列になる
     * - 値だけでなくキーも渡ってくる
     *
     * Example:
     * ```php
     * // array_walk 等と同様に葉のみが渡ってくる（iterable も対象になる）
     * that(array_map_recursive([
     *     'k' => 'v',
     *     'c' => new \ArrayObject([
     *         'k1' => 'v1',
     *         'k2' => 'v2',
     *     ]),
     * ], 'strtoupper'))->isSame([
     *     'k' => 'V',
     *     'c' => [
     *         'k1' => 'V1',
     *         'k2' => 'V2',
     *     ],
     * ]);
     *
     * // ただし、その挙動は引数で変更可能
     * that(array_map_recursive([
     *     'k' => 'v',
     *     'c' => new \ArrayObject([
     *         'k1' => 'v1',
     *         'k2' => 'v2',
     *     ]),
     * ], 'gettype', false))->isSame([
     *     'k' => 'string',
     *     'c' => 'object',
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param bool $iterable is_iterable で判定するか
     * @return array map された新しい配列
     */
    public static function array_map_recursive($array, $callback, $iterable = true)
    {
        $callback = (func_user_func_array)($callback);

        // ↑の変換を再帰ごとにやるのは現実的ではないのでクロージャに閉じ込めて再帰する
        $main = static function ($array) use (&$main, $callback, $iterable) {
            $result = [];
            foreach ($array as $k => $v) {
                if (($iterable && is_iterable($v)) || (!$iterable && is_array($v))) {
                    $result[$k] = $main($v);
                }
                else {
                    $result[$k] = $callback($v, $k);
                }
            }
            return $result;
        };

        return $main($array);
    }

    /**
     * キーをマップして変換する
     *
     * $callback が null を返すとその要素は取り除かれる。
     *
     * Example:
     * ```php
     * that(array_map_key(['a' => 'A', 'b' => 'B'], 'strtoupper'))->isSame(['A' => 'A', 'B' => 'B']);
     * that(array_map_key(['a' => 'A', 'b' => 'B'], function(){}))->isSame([]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array キーが変換された新しい配列
     */
    public static function array_map_key($array, $callback)
    {
        $callback = (func_user_func_array)($callback);
        $result = [];
        foreach ($array as $k => $v) {
            $k2 = $callback($k, $v);
            if ($k2 !== null) {
                $result[$k2] = $v;
            }
        }
        return $result;
    }

    /**
     * キーを主軸とした array_filter
     *
     * $callback が要求するなら値も渡ってくる。 php 5.6 の array_filter の ARRAY_FILTER_USE_BOTH と思えばよい。
     * ただし、完全な互換ではなく、引数順は ($k, $v) なので注意。
     *
     * Example:
     * ```php
     * that(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $k !== 1; }))->isSame([0 => 'a', 2 => 'c']);
     * that(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $v !== 'b'; }))->isSame([0 => 'a', 2 => 'c']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array $callback が true を返した新しい配列
     */
    public static function array_filter_key($array, $callback)
    {
        $callback = (func_user_func_array)($callback);
        $result = [];
        foreach ($array as $k => $v) {
            if ($callback($k, $v)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }

    /**
     * 指定キーの要素で array_filter する
     *
     * array_column があるなら array_where があってもいいはず。
     *
     * $column はコールバックに渡ってくる配列のキー名を渡す。null を与えると行全体が渡ってくる。
     * $callback は絞り込み条件を渡す。null を与えると true 相当の値でフィルタする。
     * つまり $column も $callback も省略した場合、実質的に array_filter と同じ動作になる。
     *
     * $column は配列を受け入れる。配列を渡した場合その値の共通項がコールバックに渡る。
     * 連想配列の場合は「キーのカラム == 値」で filter する（それぞれで AND。厳密かどうかは $callback で指定。説明が難しいので Example を参照）。
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
     * that(array_where($array, 'flag'))->isSame([
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     * ]);
     * // 'name' に 'h' を含むものだけ返す
     * $contain_h = function($name){return strpos($name, 'h') !== false;};
     * that(array_where($array, 'name', $contain_h))->isSame([
     *     0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
     * ]);
     * // $callback が引数2つならキーも渡ってくる（キーが 2 のものだけ返す）
     * $equal_2 = function($row, $key){return $key === 2;};
     * that(array_where($array, null, $equal_2))->isSame([
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * // $column に配列を渡すと共通項が渡ってくる
     * $idname_is_2fuga = function($idname){return ($idname['id'] . $idname['name']) === '2fuga';};
     * that(array_where($array, ['id', 'name'], $idname_is_2fuga))->isSame([
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     * ]);
     * // $column に連想配列を渡すと「キーのカラム == 値」で filter する（要するに「name が piyo かつ flag が false」で filter）
     * that(array_where($array, ['name' => 'piyo', 'flag' => false]))->isSame([
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * // 上記において値に配列を渡すと in_array で判定される
     * that(array_where($array, ['id' => [2, 3]]))->isSame([
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * // $column の連想配列の値にはコールバックが渡せる（それぞれで AND）
     * that(array_where($array, [
     *     'id'   => function($id){return $id >= 3;},                       // id が 3 以上
     *     'name' => function($name){return strpos($name, 'o') !== false;}, // name に o を含む
     * ]))->isSame([
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|array|null $column キー名
     * @param callable $callback 評価クロージャ
     * @return array $where が真を返した新しい配列
     */
    public static function array_where($array, $column = null, $callback = null)
    {
        if ($column instanceof \Closure) {
            $callback = $column;
            $column = null;
        }

        $is_array = is_array($column);
        if ($is_array) {
            if ((is_hasharray)($column)) {
                if ($callback !== null && !is_bool($callback)) {
                    throw new \InvalidArgumentException('if hash array $column, $callback must be bool.');
                }
                $callbacks = array_map(function ($c) use ($callback) {
                    if ($c instanceof \Closure) {
                        return $c;
                    }
                    if ($callback) {
                        return function ($v) use ($c) { return $v === $c; };
                    }
                    else {
                        return function ($v) use ($c) { return is_array($c) ? in_array($v, $c) : $v == $c; };
                    }
                }, $column);
                $callback = function ($vv, $k, $v) use ($callbacks) {
                    foreach ($callbacks as $c => $callback) {
                        if (!$callback($vv[$c], $k)) {
                            return false;
                        }
                    }
                    return true;
                };
            }
            else {
                $column = array_flip($column);
            }
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

            if ($callback($vv, $k, $v)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }

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
     * that(array_map_filter([' a ', ' b ', ''], 'trim'))->isSame(['a', 'b']);
     * that(array_map_filter([' a ', ' b ', ''], 'trim', true))->isSame(['a', 'b', '']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param bool $strict 厳密比較フラグ。 true だと null のみが偽とみなされる
     * @return array $callback が真を返した新しい配列
     */
    public static function array_map_filter($array, $callback, $strict = false)
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

    /**
     * メソッドを指定できるようにした array_map
     *
     * 配列内の要素は全て同一（少なくともシグネチャが同じ $method が存在する）オブジェクトでなければならない。
     * スルーする場合は $ignore=true とする。スルーした場合 map ではなく filter される（結果配列に含まれない）。
     * $ignore=null とすると 何もせずそのまま要素を返す。
     *
     * Example:
     * ```php
     * $exa = new \Exception('a');
     * $exb = new \Exception('b');
     * $std = new \stdClass();
     * // getMessage で map される
     * that(array_map_method([$exa, $exb], 'getMessage'))->isSame(['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合は取り除かれる
     * that(array_map_method([$exa, $exb, $std, null], 'getMessage', [], true))->isSame(['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合はそのまま返す
     * that(array_map_method([$exa, $exb, $std, null], 'getMessage', [], null))->isSame(['a', 'b', $std, null]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string $method メソッド
     * @param array $args メソッドに渡る引数
     * @param bool|null $ignore メソッドが存在しない場合にスルーするか。null を渡すと要素そのものを返す
     * @return array $method が true を返した新しい配列
     */
    public static function array_map_method($array, $method, $args = [], $ignore = false)
    {
        if ($ignore === true) {
            $array = array_filter((arrayval)($array, false), function ($object) use ($method) {
                return is_callable([$object, $method]);
            });
        }
        return array_map(function ($object) use ($method, $args, $ignore) {
            if ($ignore === null && !is_callable([$object, $method])) {
                return $object;
            }
            return ([$object, $method])(...$args);
        }, (arrayval)($array, false));
    }

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
     * that(array_maps([1, 2, 3, 4, 5], rbind('pow', 3), 'dechex', 'strtoupper'))->isSame(['1', '8', '1B', '40', '7D']);
     * // キーも渡ってくる
     * that(array_maps(['a' => 'A', 'b' => 'B'], function($v, $k){return "$k:$v";}))->isSame(['a' => 'a:A', 'b' => 'b:B']);
     * // メソッドコールもできる（引数不要なら `@method` でも同じ）
     * that(array_maps([new \Exception('a'), new \Exception('b')], ['getMessage' => []]))->isSame(['a', 'b']);
     * that(array_maps([new \Exception('a'), new \Exception('b')], '@getMessage'))->isSame(['a', 'b']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable[] $callbacks 評価クロージャ配列
     * @return array 評価クロージャを通した新しい配列
     */
    public static function array_maps($array, ...$callbacks)
    {
        $result = (arrayval)($array, false);
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

    /**
     * 配列の各キー・値にコールバックを適用する
     *
     * $callback は (キー, 値, $callback) が渡ってくるので 「その位置に配置したい配列」を返せばそこに置換される。
     * つまり、空配列を返せばそのキー・値は消えることになるし、複数の配列を返せば要素が増えることになる。
     * ただし、数値キーは新しく採番される。
     * null を返すと特別扱いで、そのキー・値をそのまま維持する。
     * iterable を返す必要があるが、もし iterable でない場合は配列キャストされる。
     *
     * 「map も filter も可能でキー変更可能」というとてもマッチョな関数。
     * 実質的には「数値キーが再採番される再帰的でない array_convert」のように振る舞う。
     * ただし、再帰処理はないので自前で管理する必要がある。
     *
     * Example:
     * ```php
     * $array = [
     *    'a' => 'A',
     *    'b' => 'B',
     *    'c' => 'C',
     *    'd' => 'D',
     * ];
     * // キーに '_' 、値に 'prefix-' を付与。'b' は一切何もしない。'c' は値のみ。'd' はそれ自体伏せる
     * that(array_kvmap($array, function($k, $v){
     *     if ($k === 'b') return null;
     *     if ($k === 'd') return [];
     *     if ($k !== 'c') $k = "_$k";
     *     return [$k => "prefix-$v"];
     * }))->isSame([
     *     '_a' => 'prefix-A',
     *     'b'  => 'B',
     *     'c'  => 'prefix-C',
     * ]);
     *
     * // 複数返せばその分増える（要素の水増し）
     * that(array_kvmap($array, function($k, $v){
     *     return [
     *         "{$k}1" => "{$v}1",
     *         "{$k}2" => "{$v}2",
     *     ];
     * }))->isSame([
     *    'a1' => 'A1',
     *    'a2' => 'A2',
     *    'b1' => 'B1',
     *    'b2' => 'B2',
     *    'c1' => 'C1',
     *    'c2' => 'C2',
     *    'd1' => 'D1',
     *    'd2' => 'D2',
     * ]);
     *
     * // $callback には $callback 自体も渡ってくるので再帰も比較的楽に書ける
     * that(array_kvmap([
     *     'x' => [
     *         'X',
     *         'y' => [
     *             'Y',
     *             'z' => ['Z'],
     *         ],
     *     ],
     * ], function($k, $v, $callback){
     *     // 配列だったら再帰する
     *     return ["_$k" => is_array($v) ? array_kvmap($v, $callback) : "prefix-$v"];
     * }))->isSame([
     *     "_x" => [
     *         "_0" => "prefix-X",
     *         "_y" => [
     *             "_0" => "prefix-Y",
     *             "_z" => [
     *                 "_0" => "prefix-Z",
     *             ],
     *         ],
     *     ],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 適用するコールバック
     * @return array 変換された配列
     */
    public static function array_kvmap($array, $callback)
    {
        $result = [];
        foreach ($array as $k => $v) {
            $kv = $callback($k, $v, $callback) ?? [$k => $v];
            if (!is_iterable($kv)) {
                $kv = [$kv];
            }
            // $result = array_merge($result, $kv); // 遅すぎる
            foreach ($kv as $k2 => $v2) {
                if (is_int($k2)) {
                    $result[] = $v2;
                }
                else {
                    $result[$k2] = $v2;
                }
            }
        }
        return $result;
    }

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
     * that(array_kmap([
     *     'k1' => 'v1',
     *     'k2' => 'v2',
     *     'k3' => 'v3',
     * ], function($v, $k){return "$k:$v";}))->isSame([
     *     'k1' => 'k1:v1',
     *     'k2' => 'k2:v2',
     *     'k3' => 'k3:v3',
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array $callback を通した新しい配列
     */
    public static function array_kmap($array, $callback)
    {
        $callback = (func_user_func_array)($callback);

        $n = 0;
        $result = [];
        foreach ($array as $k => $v) {
            $result[$k] = $callback($v, $k, $n++);
        }
        return $result;
    }

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
     * that(array_nmap(['a', 'b'], $sprintf, 1, 'prefix-', '-suffix'))->isSame(['prefix-a-suffix', 'prefix-b-suffix']);
     * // 1番目にキー、2番目に値を渡して map
     * $sprintf = function(){return vsprintf('%s %s %s %s %s', func_get_args());};
     * that(array_nmap(['k' => 'v'], $sprintf, [1 => 2], 'a', 'b', 'c'))->isSame(['k' => 'a k b v c']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param int|array $n 要素値を入れる引数番目。配列を渡すとキー・値の両方を指定でき、両方が渡ってくる
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    public static function array_nmap($array, $callback, $n, ...$variadic)
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
            [$kn, $vn] = (first_keyvalue)($n);

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

    /**
     * 要素値を $callback の最左に適用して array_map する
     *
     * Example:
     * ```php
     * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
     * that(array_lmap(['a', 'b'], $sprintf, '-suffix'))->isSame(['a-suffix', 'b-suffix']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    public static function array_lmap($array, $callback, ...$variadic)
    {
        return (array_nmap)(...(array_insert)(func_get_args(), 0, 2));
    }

    /**
     * 要素値を $callback の最右に適用して array_map する
     *
     * Example:
     * ```php
     * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
     * that(array_rmap(['a', 'b'], $sprintf, 'prefix-'))->isSame(['prefix-a', 'prefix-b']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    public static function array_rmap($array, $callback, ...$variadic)
    {
        return (array_nmap)(...(array_insert)(func_get_args(), func_num_args() - 2, 2));
    }

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
     * that(array_each([1, 2, 3, 4, 5], function(&$carry, $v){$carry .= $v;}, ''))->isSame('12345');
     * // 値をキーにして要素を2乗値にする
     * that(array_each([1, 2, 3, 4, 5], function(&$carry, $v){$carry[$v] = $v * $v;}, []))->isSame([
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     *     4 => 16,
     *     5 => 25,
     * ]);
     * // 上記と同じ。ただし、3 で break する
     * that(array_each([1, 2, 3, 4, 5], function(&$carry, $v, $k){
     *     if ($k === 3) return false;
     *     $carry[$v] = $v * $v;
     * }, []))->isSame([
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     * ]);
     *
     * // 下記は完全に同じ（第3引数の代わりにデフォルト引数を使っている）
     * that(array_each([1, 2, 3], function(&$carry = [], $v) {
     *         $carry[$v] = $v * $v;
     *     }))->isSame(array_each([1, 2, 3], function(&$carry, $v) {
     *         $carry[$v] = $v * $v;
     *     }, [])
     *     // 個人的に↑のようなぶら下がり引数があまり好きではない（クロージャを最後の引数にしたい）
     * );
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ。(&$carry, $key, $value) を受ける
     * @param mixed $default ループの最初や空の場合に適用される値
     * @return mixed each した結果
     */
    public static function array_each($array, $callback, $default = null)
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

    /**
     * 配列の次元数を返す
     *
     * フラット配列は 1 と定義する。
     * つまり、配列を与える限りは 0 以下を返すことはない。
     *
     * 第2引数 $max_depth を与えるとその階層になった時点で走査を打ち切る。
     * 「1階層のみか？」などを調べるときは指定したほうが高速に動作する。
     *
     * Example:
     * ```php
     * that(array_depth([]))->isSame(1);
     * that(array_depth(['hoge']))->isSame(1);
     * that(array_depth([['nest1' => ['nest2']]]))->isSame(3);
     * ```
     *
     * @param array $array 調べる配列
     * @param int|null $max_depth 最大階層数
     * @return int 次元数。素のフラット配列は 1
     */
    public static function array_depth($array, $max_depth = null)
    {
        assert((is_null($max_depth)) || $max_depth > 0);

        $main = function ($array, $depth) use (&$main, $max_depth) {
            // $max_depth を超えているなら打ち切る
            if ($max_depth !== null && $depth >= $max_depth) {
                return 1;
            }

            // 配列以外に興味はない
            $arrays = array_filter($array, 'is_array');

            // ネストしない配列は 1 と定義
            if (!$arrays) {
                return 1;
            }

            // 配下の内で最大を返す
            return 1 + max(array_map(function ($v) use ($main, $depth) { return $main($v, $depth + 1); }, $arrays));
        };

        return $main($array, 1);
    }

    /**
     * 配列・連想配列を問わず任意の位置に値を挿入する
     *
     * $position を省略すると最後に挿入される（≒ array_push）。
     * $position に負数を与えると後ろから数えられる。
     * $value には配列も与えられるが、その場合数値キーは振り直される
     *
     * Example:
     * ```php
     * that(array_insert([1, 2, 3], 'x'))->isSame([1, 2, 3, 'x']);
     * that(array_insert([1, 2, 3], 'x', 1))->isSame([1, 'x', 2, 3]);
     * that(array_insert([1, 2, 3], 'x', -1))->isSame([1, 2, 'x', 3]);
     * that(array_insert([1, 2, 3], ['a' => 'A', 'b' => 'B'], 1))->isSame([1, 'a' => 'A', 'b' => 'B', 2, 3]);
     * ```
     *
     * @param array $array 対象配列
     * @param mixed $value 挿入値
     * @param int|null $position 挿入位置
     * @return array 挿入された新しい配列
     */
    public static function array_insert($array, $value, $position = null)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $position = is_null($position) ? count($array) : intval($position);

        $sarray = array_splice($array, 0, $position);
        return array_merge($sarray, $value, $array);
    }

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
     * that(array_assort([1, 2, 3], [
     *     'lt2' => $lt2,
     * ]))->isSame([
     *     'lt2' => [1],
     * ]);
     * // lt3(3より小さい)、ctd(ctype_digit)で分類（両方に属する要素が存在する）
     * $lt3 = function($v){return $v < 3;};
     * that(array_assort(['1', '2', '3'], [
     *     'lt3' => $lt3,
     *     'ctd' => 'ctype_digit',
     * ]))->isSame([
     *     'lt3' => ['1', '2'],
     *     'ctd' => ['1', '2', '3'],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable[] $rules 分類ルール。[key => callable] 形式
     * @return array 分類された新しい配列
     */
    public static function array_assort($array, $rules)
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

    /**
     * 配列をコールバックに従ってカウントする
     *
     * コールバックが true 相当を返した要素をカウントして返す。
     * 普通に使う分には `count(array_filter($array, $callback))` とほとんど同じだが、下記の点が微妙に異なる。
     *
     * - $callback が要求するならキーも渡ってくる
     * - $callback には配列が渡せる。配列を渡した場合は件数を配列で返す（Example 参照）
     *
     * Example:
     * ```php
     * $array = ['hoge', 'fuga', 'piyo'];
     * // 'o' を含むものの数（2個）
     * that(array_count($array, function($s){return strpos($s, 'o') !== false;}))->isSame(2);
     * // 'a' と 'o' を含むものをそれぞれ（1個と2個）
     * that(array_count($array, [
     *     'a' => function($s){return strpos($s, 'a') !== false;},
     *     'o' => function($s){return strpos($s, 'o') !== false;},
     * ]))->isSame([
     *     'a' => 1,
     *     'o' => 2,
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback カウントルール。配列も渡せる
     * @return int|array 条件一致した件数
     */
    public static function array_count($array, $callback)
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

    /**
     * 配列をコールバックの返り値でグループ化する
     *
     * コールバックを省略すると値そのもので評価する。
     * コールバックが配列を返すと入れ子としてグループ化する。
     *
     * Example:
     * ```php
     * that(array_group([1, 1, 1]))->isSame([
     *     1 => [1, 1, 1],
     * ]);
     * that(array_group([1, 2, 3], function($v){return $v % 2;}))->isSame([
     *     1 => [1, 3],
     *     0 => [2],
     * ]);
     * // group -> id で入れ子グループにする
     * $row1 = ['id' => 1, 'group' => 'hoge'];
     * $row2 = ['id' => 2, 'group' => 'fuga'];
     * $row3 = ['id' => 3, 'group' => 'hoge'];
     * that(array_group([$row1, $row2, $row3], function($row){return [$row['group'], $row['id']];}))->isSame([
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
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
     * @return array グルーピングされた配列
     */
    public static function array_group($array, $callback = null, $preserve_keys = false)
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

    /**
     * 配列をコールバックの返り値で集計する
     *
     * $columns で集計列を指定する。
     * 単一の callable を渡すと結果も単一になる。
     * 複数の callable 連想配列を渡すと [キー => 集系列] の連想配列になる。
     * いずれにせよ引数としてそのグループの配列が渡ってくるので返り値がその列の値になる。
     * 第2引数には「今までの結果が詰まった配列」が渡ってくる（count, avg, sum など何度もでてくる集計で便利）。
     *
     * $key で集約列を指定する。
     * 指定しなければ引数の配列そのままで集計される。
     * 複数要素の配列を与えるとその数分潜って集計される。
     * クロージャを与えると返り値がキーになる。
     *
     * Example:
     * ```php
     * // 単純な配列の集計
     * that(array_aggregate([1, 2, 3], [
     *     'min' => function($elems) {return min($elems);},
     *     'max' => function($elems) {return max($elems);},
     *     'avg' => function($elems) {return array_sum($elems) / count($elems);},
     * ]))->isSame([
     *     'min' => 1, // 最小値
     *     'max' => 3, // 最大値
     *     'avg' => 2, // 平均値
     * ]);
     *
     * $row1 = ['user_id' => 'hoge', 'group' => 'A', 'score' => 4];
     * $row2 = ['user_id' => 'fuga', 'group' => 'B', 'score' => 6];
     * $row3 = ['user_id' => 'fuga', 'group' => 'A', 'score' => 5];
     * $row4 = ['user_id' => 'hoge', 'group' => 'A', 'score' => 8];
     *
     * // user_id, group ごとの score を集計して階層配列で返す（第2引数 $current を利用している）
     * that(array_aggregate([$row1, $row2, $row3, $row4], [
     *     'scores' => function($rows) {return array_column($rows, 'score');},
     *     'score'  => function($rows, $current) {return array_sum($current['scores']);},
     * ], ['user_id', 'group']))->isSame([
     *     'hoge' => [
     *         'A' => [
     *             'scores' => [4, 8],
     *             'score'  => 12,
     *         ],
     *     ],
     *     'fuga' => [
     *         'B' => [
     *             'scores' => [6],
     *             'score'  => 6,
     *         ],
     *         'A' => [
     *             'scores' => [5],
     *             'score'  => 5,
     *         ],
     *     ],
     * ]);
     *
     * // user_id ごとの score を集計して単一列で返す（キーのクロージャも利用している）
     * that(array_aggregate([$row1, $row2, $row3, $row4],
     *     function($rows) {return array_sum(array_column($rows, 'score'));},
     *     function($row) {return strtoupper($row['user_id']);}))->isSame([
     *     'HOGE' => 12,
     *     'FUGA' => 11,
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable|callable[] $columns 集計関数
     * @param string|array|null $key 集約列。クロージャを与えると返り値がキーになる
     * @return array 集約配列
     */
    public static function array_aggregate($array, $columns, $key = null)
    {
        if ($key === null) {
            $nest_level = 0;
        }
        elseif ($key instanceof \Closure) {
            $nest_level = 1;
        }
        elseif (is_string($key)) {
            $nest_level = 1;
            $key = (array_of)($key);
        }
        else {
            $nest_level = count($key);
            $key = (array_of)($key);
        }

        if ($key === null) {
            $group = (arrayval)($array);
        }
        else {
            $group = [];
            foreach ($array as $k => $v) {
                $vv = $key($v, $k);

                if (is_array($vv)) {
                    $tmp = &$group;
                    foreach ($vv as $vvv) {
                        $tmp = &$tmp[$vvv];
                    }
                    $tmp[] = $v;
                    unset($tmp);
                }
                else {
                    $group[$vv][$k] = $v;
                }
            }
        }

        if (!is_callable($columns)) {
            $columns = array_map(func_user_func_array, $columns);
        }

        $dive = function ($array, $level) use (&$dive, $columns) {
            $result = [];
            if ($level === 0) {
                if (is_callable($columns)) {
                    return $columns($array);
                }
                foreach ($columns as $name => $column) {
                    $result[$name] = $column($array, $result);
                }
            }
            else {
                foreach ($array as $k => $v) {
                    $result[$k] = $dive($v, $level - 1);
                }
            }
            return $result;
        };
        return $dive($group, $nest_level);
    }

    /**
     * 全要素が true になるなら true を返す（1つでも false なら false を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * that(array_all([true, true]))->isTrue();
     * that(array_all([true, false]))->isFalse();
     * that(array_all([false, false]))->isFalse();
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が true なら true
     */
    public static function array_all($array, $callback = null, $default = true)
    {
        if ((is_empty)($array)) {
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

    /**
     * 全要素が false になるなら false を返す（1つでも true なら true を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * that(array_any([true, true]))->isTrue();
     * that(array_any([true, false]))->isTrue();
     * that(array_any([false, false]))->isFalse();
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が false なら false
     */
    public static function array_any($array, $callback = null, $default = false)
    {
        if ((is_empty)($array)) {
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

    /**
     * 比較関数が渡せる array_unique
     *
     * array_unique は微妙に癖があるのでシンプルに使いやすくしたもの。
     *
     * - SORT_STRING|SORT_FLAG_CASE のような指定が使える（大文字小文字を無視した重複除去）
     *   - 厳密に言えば array_unique も指定すれば動く（が、ドキュメントに記載がない）
     * - 配列を渡すと下記の動作になる
     *   - 数値キーは配列アクセス
     *   - 文字キーはメソッドコール（値は引数）
     * - もちろん（$a, $b を受け取る）クロージャも渡せる
     *
     * Example:
     * ```php
     * // シンプルな重複除去
     * that(array_distinct([1, 2, 3, '3']))->isSame([1, 2, 3]);
     * // 大文字小文字を無視した重複除去
     * that(array_distinct(['a', 'b', 'A', 'B'], SORT_STRING|SORT_FLAG_CASE))->isSame(['a', 'b']);
     *
     * $v1 = new \ArrayObject(['id' => '1', 'group' => 'aaa']);
     * $v2 = new \ArrayObject(['id' => '2', 'group' => 'bbb', 'dummy' => 123]);
     * $v3 = new \ArrayObject(['id' => '3', 'group' => 'aaa', 'dummy' => 456]);
     * $v4 = new \ArrayObject(['id' => '4', 'group' => 'bbb', 'dummy' => 789]);
     * // クロージャを指定して重複除去
     * that(array_distinct([$v1, $v2, $v3, $v4], function($a, $b) { return $a['group'] <=> $b['group']; }))->isSame([$v1, $v2]);
     * // 単純な配列アクセスなら文字列や配列でよい（上記と同じ結果になる）
     * that(array_distinct([$v1, $v2, $v3, $v4], 'group'))->isSame([$v1, $v2]);
     * // 文字キーの配列はメソッドコールになる（ArrayObject::count で重複検出）
     * that(array_distinct([$v1, $v2, $v3, $v4], ['count' => []]))->isSame([$v1, $v2]);
     * // 上記2つは混在できる（group キー + count メソッドで重複検出。端的に言えば "aaa+2", "bbb+3", "aaa+3", "bbb+3" で除去）
     * that(array_distinct([$v1, $v2, $v3, $v4], ['group', 'count' => []]))->isSame([$v1, $v2, 2 => $v3]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable|int|string $comparator 比較関数
     * @return array 重複が除去された配列
     */
    public static function array_distinct($array, $comparator = null)
    {
        // 配列化と個数チェック（1以下は重複のしようがないので不要）
        $array = (arrayval)($array, false);
        if (count($array) <= 1) {
            return $array;
        }

        // 省略時は宇宙船
        if ($comparator === null) {
            $comparator = static function ($a, $b) {
                return $a <=> $b;
            };
        }
        // 数字が来たら varcmp とする
        elseif (is_int($comparator)) {
            $comparator = static function ($a, $b) use ($comparator) {
                return (varcmp)($a, $b, $comparator);
            };
        }
        // 文字列・配列が来たらキーアクセス/メソッドコールとする
        elseif (is_string($comparator) || is_array($comparator)) {
            $comparator = static function ($a, $b) use ($comparator) {
                foreach ((arrayize)($comparator) as $method => $args) {
                    if (is_int($method)) {
                        $delta = $a[$args] <=> $b[$args];
                    }
                    else {
                        $args = (arrayize)($args);
                        $delta = $a->$method(...$args) <=> $b->$method(...$args);
                    }
                    if ($delta !== 0) {
                        return $delta;
                    }
                }
                return 0;
            };
        }

        // 2重ループで探すよりは1度ソートしてしまったほうがマシ…だと思う（php の実装もそうだし）
        $backup = $array;
        uasort($array, $comparator);
        $keys = array_keys($array);

        // できるだけ元の順番は維持したいので、詰めて返すのではなくキーを導出して共通項を返す（ただし、この仕様は変えるかもしれない）
        $current = $keys[0];
        $keepkeys = [$current => null];
        for ($i = 1, $l = count($keys); $i < $l; $i++) {
            if ($comparator($array[$current], $array[$keys[$i]]) !== 0) {
                $current = $keys[$i];
                $keepkeys[$current] = null;
            }
        }
        return array_intersect_key($backup, $keepkeys);
    }

    /**
     * 配列を $orders に従って並べ替える
     *
     * データベースからフェッチしたような連想配列の配列を想定しているが、スカラー配列(['key' => 'value'])にも対応している。
     * その場合 $orders に配列ではなく直値を渡せば良い。
     *
     * $orders には下記のような配列を渡す。
     * キーに空文字を渡すとそれは「キー自体」を意味する。
     *
     * ```php
     * $orders = [
     *     'col1' => true,                               // true: 昇順, false: 降順。照合は型に依存
     *     'col2' => SORT_NATURAL,                       // SORT_NATURAL, SORT_REGULAR などで照合。正数で昇順、負数で降順
     *     'col3' => ['sort', 'this', 'order'],          // 指定した配列順で昇順
     *     'col4' => function($v) {return $v;},          // クロージャを通した値で昇順。照合は返り値の型に依存
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
     * that(array_order([$v1, $v2, $v3], ['name' => true, 'no' => -SORT_NATURAL]))->isSame([$v3, $v2, $v1]);
     * ```
     *
     * @param array $array 対象配列
     * @param mixed $orders ソート順
     * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
     * @return array 並び替えられた配列
     */
    public static function array_order(array $array, $orders, $preserve_keys = false)
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
                    /** @var \ReflectionNamedType $rtype */
                    $rtype = $ref->getReturnType();
                    $type = $rtype ? $rtype->getName() : gettype(reset($arg));
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

    /**
     * shuffle のキーが保存される＋参照渡しではない版
     *
     * Example:
     * ```php
     * that(array_shuffle(['a' => 'A', 'b' => 'B', 'c' => 'C']))->is(['b' => 'B', 'a' => 'A', 'c' => 'C']);
     * ```
     *
     * @param array $array 対象配列
     * @return array shuffle された配列
     */
    public static function array_shuffle($array)
    {
        $keys = array_keys($array);
        shuffle($keys);

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $array[$key];
        }
        return $result;
    }

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
     * that(array_shrink_key($array1, $array2, $array3))->isSame(['c' => 'C3']);
     * ```
     *
     * @param iterable[] $variadic 共通項を取る配列（可変引数）
     * @return array 新しい配列
     */
    public static function array_shrink_key(...$variadic)
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

    /**
     * 配列の隙間を埋める
     *
     * 「隙間」とは数値キーの隙間のこと。文字キーには関与しない。
     * 連番の抜けている箇所に $values の値を順次詰めていく動作となる。
     *
     * 値が足りなくてもエラーにはならない。つまり、この関数を通したとしても隙間が無くなるわけではない。
     * また、隙間を埋めても値が余る場合（隙間より与えられた値が多い場合）は末尾に全て追加される。
     *
     * 負数キーは考慮しない。
     *
     * Example:
     * ```php
     * // ところどころキーが抜け落ちている配列の・・・
     * $array = [
     *     1 => 'b',
     *     2 => 'c',
     *     5 => 'f',
     *     7 => 'h',
     * ];
     * // 抜けているところを可変引数で順次埋める（'i', 'j' は隙間というより末尾追加）
     * that(array_fill_gap($array, 'a', 'd', 'e', 'g', 'i', 'j'))->isSame([
     *     0 => 'a',
     *     1 => 'b',
     *     2 => 'c',
     *     3 => 'd',
     *     4 => 'e',
     *     5 => 'f',
     *     6 => 'g',
     *     7 => 'h',
     *     8 => 'i',
     *     9 => 'j',
     * ]);
     *
     * // 文字キーには関与しないし、値は足りなくても良い
     * $array = [
     *     1   => 'b',
     *     'x' => 'noize',
     *     4   => 'e',
     *     'y' => 'noize',
     *     7   => 'h',
     *     'z' => 'noize',
     * ];
     * // 文字キーはそのまま保持され、値が足りないので 6 キーはない
     * that(array_fill_gap($array, 'a', 'c', 'd', 'f'))->isSame([
     *     0   => 'a',
     *     1   => 'b',
     *     'x' => 'noize',
     *     2   => 'c',
     *     3   => 'd',
     *     4   => 'e',
     *     'y' => 'noize',
     *     5   => 'f',
     *     7   => 'h',
     *     'z' => 'noize',
     * ]);
     * ```
     *
     * @param array $array 対象配列
     * @param mixed $values 詰める値（可変引数）
     * @return array 隙間が詰められた配列
     */
    public static function array_fill_gap($array, ...$values)
    {
        $n = 0;
        $keys = array_keys($array);

        $result = [];
        for ($i = 0, $l = count($keys); $i < $l; $i++) {
            $key = $keys[$i];
            if (is_string($key)) {
                $result[$key] = $array[$key];
                continue;
            }

            if (array_key_exists($n, $array)) {
                $result[] = $array[$n];
            }
            elseif ($values) {
                $result[] = array_shift($values);
                $i--;
            }
            else {
                $result[$key] = $array[$key];
            }
            $n++;
        }
        if ($values) {
            $result = array_merge($result, $values);
        }
        return $result;
    }

    /**
     * array_fill_keys のコールバック版のようなもの
     *
     * 指定したキー配列をそれらのマップしたもので配列を生成する。
     * `array_combine($keys, array_map($callback, $keys))` とほぼ等価。
     *
     * Example:
     * ```php
     * $abc = ['a', 'b', 'c'];
     * // [a, b, c] から [a => A, b => B, c => C] を作る
     * that(array_fill_callback($abc, 'strtoupper'))->isSame([
     *     'a' => 'A',
     *     'b' => 'B',
     *     'c' => 'C',
     * ]);
     * // [a, b, c] からその sha1 配列を作って大文字化する
     * that(array_fill_callback($abc, function ($v){ return strtoupper(sha1($v)); }))->isSame([
     *     'a' => '86F7E437FAA5A7FCE15D1DDCB9EAEAEA377667B8',
     *     'b' => 'E9D71F5EE7C92D6DC9E92FFDAD17B8BD49418F98',
     *     'c' => '84A516841BA77A5B4648DE2CD0DFCB30EA46DBB4',
     * ]);
     * ```
     *
     * @param iterable $keys キーとなる配列
     * @param callable $callback 要素のコールバック（引数でキーが渡ってくる）
     * @return array 新しい配列
     */
    public static function array_fill_callback($keys, $callback)
    {
        $keys = (arrayval)($keys, false);
        return array_combine($keys, array_map((func_user_func_array)($callback), $keys));
    }

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
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // a と c を取り出す
     * that(array_pickup($array, ['a', 'c']))->isSame(['a' => 'A', 'c' => 'C']);
     * // 順番は $keys 基準になる
     * that(array_pickup($array, ['c', 'a']))->isSame(['c' => 'C', 'a' => 'A']);
     * // 連想配列を渡すと読み替えて返す
     * that(array_pickup($array, ['c' => 'cX', 'a' => 'aX']))->isSame(['cX' => 'C', 'aX' => 'A']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param array $keys 取り出すキー
     * @return array 新しい配列
     */
    public static function array_pickup($array, $keys)
    {
        $array = (arrayval)($array, false);

        $result = [];
        foreach ((arrayval)($keys, false) as $k => $key) {
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

    /**
     * キーを指定してそれらを除いた配列にする
     *
     * `array_diff_key($array, array_flip($keys))` とほぼ同義。
     * 違いは Traversable を渡せること。
     *
     * array_pickup の逆とも言える。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // a と c を伏せる（b を残す）
     * that(array_remove($array, ['a', 'c']))->isSame(['b' => 'B']);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param array $keys 伏せるキー
     * @return array 新しい配列
     */
    public static function array_remove($array, $keys)
    {
        foreach ((arrayval)($keys, false) as $k) {
            unset($array[$k]);
        }
        return $array;
    }

    /**
     * キー保存可能な array_column
     *
     * array_column は キーを保存することが出来ないが、この関数は引数を2つだけ与えるとキーはそのままで array_column 相当の配列を返す。
     *
     * Example:
     * ```php
     * $array = [
     *     11 => ['id' => 1, 'name' => 'name1'],
     *     12 => ['id' => 2, 'name' => 'name2'],
     *     13 => ['id' => 3, 'name' => 'name3'],
     * ];
     * // 第3引数を渡せば array_column と全く同じ
     * that(array_lookup($array, 'name', 'id'))->isSame(array_column($array, 'name', 'id'));
     * that(array_lookup($array, 'name', null))->isSame(array_column($array, 'name', null));
     * // 省略すればキーが保存される
     * that(array_lookup($array, 'name'))->isSame([
     *     11 => 'name1',
     *     12 => 'name2',
     *     13 => 'name3',
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|null $column_key 値となるキー
     * @param string|null $index_key キーとなるキー
     * @return array 新しい配列
     */
    public static function array_lookup($array, $column_key = null, $index_key = null)
    {
        $array = (arrayval)($array, false);
        if (func_num_args() === 3) {
            return array_column($array, $column_key, $index_key);
        }
        return array_combine(array_keys($array), array_column($array, $column_key));
    }

    /**
     * 指定キーの要素で抽出する
     *
     * $columns に単純な値を渡すとそのキーの値を選択する。
     * キー付きで値を渡すと読み替えて選択する。
     * キー付きでクロージャを渡すと `(キーの値, 行自体, 現在行のキー)` を引数としてコールバックして選択する。
     * 単一のクロージャを渡すと `(行自体, 現在行のキー)` を引数としてコールバックして選択する（array_map とほぼ同じ）。
     *
     * Example:
     * ```php
     * $array = [
     *     11 => ['id' => 1, 'name' => 'name1'],
     *     12 => ['id' => 2, 'name' => 'name2'],
     *     13 => ['id' => 3, 'name' => 'name3'],
     * ];
     *
     * that(array_select($array, [
     *     'id',              // id を単純取得
     *     'alias' => 'name', // name を alias として取得
     * ]))->isSame([
     *     11 => ['id' => 1, 'alias' => 'name1'],
     *     12 => ['id' => 2, 'alias' => 'name2'],
     *     13 => ['id' => 3, 'alias' => 'name3'],
     * ]);
     *
     * that(array_select($array, [
     *     // id の 10 倍を取得
     *     'id'     => function ($id) {return $id * 10;},
     *     // id と name の結合を取得
     *     'idname' => function ($null, $row, $index) {return $row['id'] . $row['name'];},
     * ]))->isSame([
     *     11 => ['id' => 10, 'idname' => '1name1'],
     *     12 => ['id' => 20, 'idname' => '2name2'],
     *     13 => ['id' => 30, 'idname' => '3name3'],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|iterable|\Closure $columns 抽出項目
     * @param int|string|null $index キーとなるキー
     * @return array 新しい配列
     */
    public static function array_select($array, $columns, $index = null)
    {
        if (!is_iterable($columns) && !$columns instanceof \Closure) {
            return (array_lookup)(...func_get_args());
        }

        if ($columns instanceof \Closure) {
            $callbacks = $columns;
        }
        else {
            $callbacks = [];
            foreach ($columns as $alias => $column) {
                if ($column instanceof \Closure) {
                    $callbacks[$alias] = (func_user_func_array)($column);
                }
            }
        }

        $argcount = func_num_args();
        $result = [];
        foreach ($array as $k => $v) {
            if ($callbacks instanceof \Closure) {
                $row = $callbacks($v, $k);
            }
            else {
                $row = [];
                foreach ($columns as $alias => $column) {
                    if (is_int($alias)) {
                        $alias = $column;
                    }

                    if (isset($callbacks[$alias])) {
                        $row[$alias] = $callbacks[$alias]((attr_get)($alias, $v, null), $v, $k);
                    }
                    elseif ((attr_exists)($column, $v)) {
                        $row[$alias] = (attr_get)($column, $v);
                    }
                    else {
                        throw new \InvalidArgumentException("$column is not exists.");
                    }
                }
            }

            if ($argcount === 2) {
                $result[$k] = $row;
            }
            elseif ($index === null) {
                $result[] = $row;
            }
            elseif (array_key_exists($index, $row)) {
                $result[$row[$index]] = $row;
            }
            elseif ((attr_exists)($index, $v)) {
                $result[(attr_get)($index, $v)] = $row;
            }
            else {
                throw new \InvalidArgumentException("$index is not exists.");
            }
        }
        return $result;
    }

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
     * that(array_columns($rows))->isSame(['id' => [1, 2], 'name' => ['A', 'B']]);
     * that(array_columns($rows, 'id'))->isSame(['id' => [1, 2]]);
     * that(array_columns($rows, 'name', 'id'))->isSame(['name' => [1 => 'A', 2 => 'B']]);
     * ```
     *
     * @param array $array 対象配列
     * @param string|array $column_keys 引っ張ってくるキー名
     * @param mixed $index_key 新しい配列のキーとなるキー名
     * @return array 新しい配列
     */
    public static function array_columns($array, $column_keys = null, $index_key = null)
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

    /**
     * array_columns のほぼ逆で [キー => [要素]] 配列から連想配列の配列を生成する
     *
     * $template を指定すると「それに含まれる配列かつ値がデフォルト」になる（要するに $default みたいなもの）。
     * キーがバラバラな配列を指定する場合は指定したほうが良い。が、null を指定すると最初の要素が使われるので大抵の場合は null で良い。
     *
     * Example:
     * ```php
     * that(array_uncolumns([
     *     'id'   => [1, 2],
     *     'name' => ['A', 'B'],
     * ]))->isSame([
     *     ['id' => 1, 'name' => 'A'],
     *     ['id' => 2, 'name' => 'B'],
     * ]);
     * ```
     *
     * @param array $array 対象配列
     * @param array $template 抽出要素とそのデフォルト値
     * @return array 新しい配列
     */
    public static function array_uncolumns($array, $template = null)
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

    /**
     * 配列の各要素に再帰的にコールバックを適用して変換する
     *
     * $callback は下記の仕様。
     *
     * 引数は (キー, 値, 今まで処理したキー配列) で渡ってくる。
     * 返り値は新しいキーを返す。
     *
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
     * that(array_convert($array, $callback, true))->isSame([
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
    public static function array_convert($array, $callback, $apply_array = false)
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
     * that(array_flatten($array))->isSame([
     *    0 => 'v1',
     *    1 => 'v21',
     *    2 => 'v221',
     *    3 => 'v222',
     *    4 => 1,
     *    5 => 2,
     *    6 => 3,
     * ]);
     * // 区切り文字指定
     * that(array_flatten($array, '.'))->isSame([
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
     * @param iterable $array 対象配列
     * @param string|\Closure|null $delimiter キーの区切り文字。 null を与えると連番になる
     * @return array フラット化された配列
     */
    public static function array_flatten($array, $delimiter = null)
    {
        $result = [];
        $core = function ($array, $delimiter, $parents) use (&$core, &$result) {
            foreach ($array as $k => $v) {
                $keys = $parents;
                $keys[] = $k;
                if (is_iterable($v)) {
                    $core($v, $delimiter, $keys);
                }
                else {
                    if ($delimiter === null) {
                        $result[] = $v;
                    }
                    elseif ($delimiter instanceof \Closure) {
                        $result[$delimiter($keys)] = $v;
                    }
                    else {
                        $result[implode($delimiter, $keys)] = $v;
                    }
                }
            }
        };

        $core($array, $delimiter, []);
        return $result;
    }

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
     * that(array_nest($array))->isSame([
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
     * that(array_nest($array))->isSame([
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
     *     that($e)->isInstanceOf(\InvalidArgumentException::class);
     * }
     * ```
     *
     * @param iterable $array 対象配列
     * @param string $delimiter キーの区切り文字
     * @return array 階層化された配列
     */
    public static function array_nest($array, $delimiter = '.')
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
     * that(array_difference([
     *     'common' => [
     *         'sub' => [
     *             'x' => 'val',
     *         ]
     *     ],
     *     'key1'   => 'hoge',
     *     'array'  => ['a', 'b', 'c'],
     * ], [
     *     'common' => [
     *         'sub' => [
     *             'x' => 'VAL',
     *         ]
     *     ],
     *     'key2'   => 'fuga',
     *     'array'  => ['c', 'd', 'e'],
     * ]))->isSame([
     *     'common.sub.x' => ['-' => 'val', '+' => 'VAL'],
     *     'key1'         => ['-' => 'hoge'],
     *     'array'        => ['-' => ['a', 'b'], '+' => ['d', 'e']],
     *     'key2'         => ['+' => 'fuga'],
     * ]);
     * ```
     *
     * @param iterable $array1 対象配列1
     * @param iterable $array2 対象配列2
     * @param string $delimiter 差分配列のキー区切り文字
     * @return array 差分を表す配列
     */
    public static function array_difference($array1, $array2, $delimiter = '.')
    {
        $rule = [
            'list' => static function ($v, $k) { return is_int($k); },
            'hash' => static function ($v, $k) { return !is_int($k); },
        ];

        $udiff = static function ($a, $b) { return $a <=> $b; };

        return call_user_func($f = static function ($array1, $array2, $key = null) use (&$f, $rule, $udiff, $delimiter) {
            $result = [];

            $array1 = (array_assort)($array1, $rule);
            $array2 = (array_assort)($array2, $rule);

            $list1 = array_values(array_udiff($array1['list'], $array2['list'], $udiff));
            $list2 = array_values(array_udiff($array2['list'], $array1['list'], $udiff));
            for ($k = 0, $l = max(count($list1), count($list2)); $k < $l; $k++) {
                $exists1 = array_key_exists($k, $list1);
                $exists2 = array_key_exists($k, $list2);

                $v1 = $exists1 ? $list1[$k] : null;
                $v2 = $exists2 ? $list2[$k] : null;

                $prefix = $key === null ? count($result) : $key;
                if ($exists1) {
                    $result[$prefix]['-'][] = $v1;
                }
                if ($exists2) {
                    $result[$prefix]['+'][] = $v2;
                }
            }

            $hash1 = array_udiff_assoc($array1['hash'], $array2['hash'], $udiff);
            $hash2 = array_udiff_assoc($array2['hash'], $array1['hash'], $udiff);
            foreach (array_keys($hash1 + $hash2) as $k) {
                $exists1 = array_key_exists($k, $hash1);
                $exists2 = array_key_exists($k, $hash2);

                $v1 = $exists1 ? $hash1[$k] : null;
                $v2 = $exists2 ? $hash2[$k] : null;

                $prefix = $key === null ? $k : $key . $delimiter . $k;
                if (is_array($v1) && is_array($v2)) {
                    $result += $f($v1, $v2, $prefix);
                    continue;
                }
                if ($exists1) {
                    $result[$prefix]['-'] = $v1;
                }
                if ($exists2) {
                    $result[$prefix]['+'] = $v2;
                }
            }

            return $result;
        }, $array1, $array2);
    }
}
