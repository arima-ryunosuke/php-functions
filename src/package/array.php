<?php
/**
 * 配列に関するユーティリティ
 *
 * @package array
 */

/** @noinspection PhpDocSignatureInspection */
/**
 * 引数の配列を生成する。
 *
 * 配列以外を渡すと配列化されて追加される。
 * 連想配列は未対応。あくまで普通の配列化のみ。
 * iterable や Traversable は考慮せずあくまで「配列」としてチェックする。
 *
 * Example:
 * ```php
 * assert(arrayize(1, 2, 3)                   === [1, 2, 3]);
 * assert(arrayize([1], [2], [3])             === [1, 2, 3]);
 * $object = new \stdClass();
 * assert(arrayize($object, false, [1, 2, 3]) === [$object, false, 1, 2, 3]);
 * ```
 *
 * @param mixed $variadic 生成する要素（可変引数）
 * @return array 引数を配列化したもの
 */
function arrayize()
{
    $result = [];
    foreach (func_get_args() as $arg) {
        if (!is_array($arg)) {
            $arg = [$arg];
        }
        $result = array_merge($result, $arg);
    }
    return $result;
}

/**
 * 配列が連想配列か調べる
 *
 * 空の配列は普通の配列とみなす。
 *
 * Example:
 * ```php
 * assert(is_hasharray([])           === false);
 * assert(is_hasharray([1, 2, 3])    === false);
 * assert(is_hasharray(['x' => 'X']) === true);
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

/**
 * 配列の最初のキーを返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * assert(first_key(['a', 'b', 'c']) === 0);
 * assert(first_key([], 999)         === 999);
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
    list($k, $v) = first_keyvalue($array);
    return $k;
}

/**
 * 配列の最初の値を返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * assert(first_value(['a', 'b', 'c']) === 'a');
 * assert(first_value([], 999)         === 999);
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
    list($k, $v) = first_keyvalue($array);
    return $v;
}

/**
 * 配列の最初のキー/値ペアをタプルで返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * assert(first_keyvalue(['a', 'b', 'c']) === [0, 'a']);
 * assert(first_keyvalue([], 999)         === 999);
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

/**
 * 配列の最後のキーを返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * assert(last_key(['a', 'b', 'c']) === 2);
 * assert(last_key([], 999)         === 999);
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
    list($k, $v) = last_keyvalue($array);
    return $k;
}

/**
 * 配列の最後の値を返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * assert(last_value(['a', 'b', 'c']) === 'c');
 * assert(last_value([], 999)         === 999);
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
    list($k, $v) = last_keyvalue($array);
    return $v;
}

/**
 * 配列の最後のキー/値ペアをタプルで返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * assert(last_keyvalue(['a', 'b', 'c']) === [2, 'c']);
 * assert(last_keyvalue([], 999)         === 999);
 * ```
 *
 * @param array|\Traversable $array 対象配列
 * @param mixed $default 無かった場合のデフォルト値
 * @return array [最後のキー, 最後の値]
 */
function last_keyvalue($array, $default = null)
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
 * assert(prev_key($array, 'b') === 'a');
 * // 'a' キーの前は無いので null
 * assert(prev_key($array, 'a') === null);
 * // 'x' キーはそもそも存在しないので false
 * assert(prev_key($array, 'x') === false);
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
 * assert(next_key($array, 'b') === 'c');
 * // 'c' キーの次は無いので null
 * assert(next_key($array, 'c') === null);
 * // 'x' キーはそもそも存在しないので false
 * assert(next_key($array, 'x') === false);
 * // 次に生成されるキーは 10
 * assert(next_key($array, null) === 10);
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

/** @noinspection PhpDocSignatureInspection */
/**
 * 配列の+演算子の関数版
 *
 * Example:
 * ```php
 * // ただの加算の関数版なので同じキーは上書きされない
 * assert(array_add(['a', 'b', 'c'], ['X'])        === ['a', 'b', 'c']);
 * // 異なるキーは生える
 * assert(array_add(['a', 'b', 'c'], ['x' => 'X']) === ['a', 'b', 'c', 'x' => 'X']);
 * ```
 *
 * @param array $array 対象配列
 * @param array $variadic 足す配列
 * @return array 足された配列
 */
function array_add($array)
{
    foreach (array_slice(func_get_args(), 1) as $arg) {
        $array += $arg;
    }
    return $array;
}

/**
 * 配列・連想配列を問わず「N番目(0ベース)」の要素を返す
 *
 * 負数を与えると逆から N 番目となる。
 *
 * Example:
 * ```php
 * assert(array_pos([1, 2, 3], 1)                                  === 2);
 * assert(array_pos([1, 2, 3], -1)                                 === 3);
 * assert(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1)       === 'B');
 * assert(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1, true) === 'b');
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
 * assert($fuga_of_array(['hoge' => 'HOGE', 'fuga' => 'FUGA']) === 'FUGA');
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
            return array_get($array, $key);
        }
        else {
            return array_get($array, $key, $default);
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
 * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
 *
 * Example:
 * ```php
 * // 単純取得
 * assert(array_get(['a', 'b', 'c'], 1)      === 'b');
 * // 単純デフォルト
 * assert(array_get(['a', 'b', 'c'], 9, 999) === 999);
 * // 配列取得
 * assert(array_get(['a', 'b', 'c'], [0, 2]) === [0 => 'a', 2 => 'c']);
 * // 配列部分取得
 * assert(array_get(['a', 'b', 'c'], [0, 9]) === [0 => 'a']);
 * // 配列デフォルト（null ではなく [] を返す）
 * assert(array_get(['a', 'b', 'c'], [9])    === []);
 * ```
 *
 * @param array $array 配列
 * @param string|int|array $key 取得したいキー
 * @param mixed $default 無かった場合のデフォルト値
 * @return mixed 指定したキーの値
 */
function array_get($array, $key, $default = null)
{
    if (is_array($key)) {
        // $result = array_shrink_key(array_flip($key), $array);
        $result = [];
        foreach ($key as $k) {
            if (array_key_exists($k, $array)) {
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

/**
 * キー指定の配列値設定
 *
 * 第3引数を省略すると（null を与えると）言語機構を使用して配列の最後に設定する（$array[] = $value）。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'B'];
 * assert(array_set($array, 'Z')      === 1);
 * assert($array                      === ['a' => 'A', 'B', 'Z']);
 * assert(array_set($array, 'Z', 'z') === 'z');
 * assert($array                      === ['a' => 'A', 'B', 'Z', 'z' => 'Z']);
 * ```
 *
 * @param array $array 配列
 * @param mixed $value 設定する値
 * @param string|int $key 設定するキー
 * @return string|int 設定したキー
 */
function array_set(&$array, $value, $key = null)
{
    if ($key === null) {
        $array[] = $value;
        $key = last_key($array);
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
 * 配列を与えた場合の返り値は与えた配列の順番・キーが活きる。
 * これを利用すると list の展開の利便性が上がったり、連想配列で返すことができる。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'b' => 'B'];
 * // ない場合は $default を返す
 * assert(array_unset($array, 'x', 'X') === 'X');
 * // 指定したキーを返す。そのキーは伏せられている
 * assert(array_unset($array, 'a') === 'A');
 * assert($array === ['b' => 'B']);
 *
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * // 配列を与えるとそれらを返す。そのキーは全て伏せられている
 * assert(array_unset($array, ['a', 'b', 'x']) === ['A', 'B']);
 * assert($array === ['c' => 'C']);
 *
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * // 配列のキーは返されるキーを表す。順番も維持される
 * assert(array_unset($array, ['x2' => 'b', 'x1' => 'a']) === ['x2' => 'B', 'x1' => 'A']);
 * ```
 *
 * @param array $array 配列
 * @param string|int|array $key 伏せたいキー。配列を与えると全て伏せる
 * @param mixed $default 無かった場合のデフォルト値
 * @return mixed 指定したキーの値
 */
function array_unset(&$array, $key, $default = null)
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
 * assert(array_dive($array, 'a.b.c')    === 'vvv');
 * assert(array_dive($array, 'a.b.x', 9) === 9);
 * ```
 *
 * @param array $array 調べる配列
 * @param string $path パス文字列
 * @param mixed $default 無かった場合のデフォルト値
 * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
 * @return mixed パスが示す配列の値
 */
function array_dive($array, $path, $default = null, $delimiter = '.')
{
    foreach (explode($delimiter, $path) as $key) {
        if (!array_key_exists($key, $array)) {
            return $default;
        }
        $array = $array[$key];
    }
    return $array;
}

/**
 * array_search のクロージャ版のようなもの
 *
 * コールバックが true 相当を返す最初のキーを返す。
 * この関数は論理値 FALSE を返す可能性がありますが、FALSE として評価される値を返す可能性もあります。
 *
 * Example:
 * ```php
 * assert(array_exists(['a', 'b', '9'], 'ctype_digit')                    === 2);
 * assert(array_exists(['a', 'b', '9'], function($v){return $v === 'b';}) === 1);
 * ```
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

/**
 * キーを正規表現でフィルタする
 *
 * Example:
 * ```php
 * assert(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#')       === ['a' => 'A', 'aa' => 'AA']);
 * assert(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#', true) === ['b' => 'B']);
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

/**
 * キーをマップして変換する
 *
 * $callback が null を返すとその要素は取り除かれる。
 *
 * Example:
 * ```php
 * assert(array_map_key(['a' => 'A', 'b' => 'B'], 'strtoupper') === ['A' => 'A', 'B' => 'B']);
 * assert(array_map_key(['a' => 'A', 'b' => 'B'], function(){}) === []);
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

/**
 * array_filter の否定版
 *
 * 単に否定するだけなのにクロージャを書きたくないことはまれによくあるはず。
 *
 * Example:
 * ```php
 * assert(array_filter_not(['a', '', 'c'], 'strlen') === [1 => '']);
 * ```
 *
 * @param array|\Traversable $array 対象配列
 * @param callable $callback 評価 callable
 * @return array $callback が false を返した新しい配列
 */
function array_filter_not($array, $callback)
{
    return array_filter($array, not_func($callback));
}

/**
 * キーを主軸とした array_filter
 *
 * $callback が要求するなら値も渡ってくる。 php 5.6 の array_filter の ARRAY_FILTER_USE_BOTH と思えばよい。
 * ただし、完全な互換ではなく、引数順は ($k, $v) なので注意。
 *
 * Example:
 * ```php
 * assert(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $k !== 1; })   === [0 => 'a', 2 => 'c']);
 * assert(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $v !== 'b'; }) === [0 => 'a', 2 => 'c']);
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

/**
 * eval で評価して array_filter する
 *
 * キーは $k, 値は $v で宣言される。
 *
 * Example:
 * ```php
 * assert(array_filter_eval(['a', 'b', 'c'], '$k !== 1')   === [0 => 'a', 2 => 'c']);
 * assert(array_filter_eval(['a', 'b', 'c'], '$v !== "b"') === [0 => 'a', 2 => 'c']);
 * ```
 *
 * @param array|\Traversable $array 対象配列
 * @param string $expression eval コード
 * @return array $expression が true を返した新しい配列
 */
function array_filter_eval($array, $expression)
{
    return array_filter_key($array, eval_func($expression, 'k', 'v'));
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
 * $column は配列を受け入れる。配列を渡した場合その共通項がコールバックに渡る。
 *
 * $callback が要求するならキーも渡ってくる。
 *
 * Example:
 * ```php
 * $array = [
 * 0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
 * 1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
 * 2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
 * ];
 * // 'flag' が true 相当のものだけ返す
 * assert(array_where($array, 'flag')                           === [1 => ['id' => 2, 'name' => 'fuga', 'flag' => true]]);
 * // 'name' に 'h' を含むものだけ返す
 * $contain_h = function($name){return strpos($name, 'h') !== false;};
 * assert(array_where($array, 'name', $contain_h)               === [0 => ['id' => 1, 'name' => 'hoge', 'flag' => false]]);
 * // $callback が引数2つならキーも渡ってくる（キーが 2 のものだけ返す）
 * $equal_2 = function($row, $key){return $key === 2;};
 * assert(array_where($array, null, $equal_2)                   === [2 => ['id' => 3, 'name' => 'piyo', 'flag' => false]]);
 * // $column に配列を渡すと共通項が渡ってくる
 * $idname_is_2fuga = function($idname){return ($idname['id'] . $idname['name']) === '2fuga';};
 * assert(array_where($array, ['id', 'name'], $idname_is_2fuga) === [1 => ['id' => 2, 'name' => 'fuga', 'flag' => true]]);
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

    $callback = func_user_func_array($callback);

    $result = [];
    foreach ($array as $k => $v) {
        if ($column === null) {
            $vv = $v;
        }
        else if ($is_array) {
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
 * assert(array_map_filter([' a ', ' b ', ''], 'trim')       === ['a', 'b']);
 * assert(array_map_filter([' a ', ' b ', ''], 'trim', true) === ['a', 'b', '']);
 * ```
 *
 * @param array|\Traversable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @param bool $strict 厳密比較フラグ。 true だと null のみが偽とみなされる
 * @return array $callback が真を返した新しい配列
 */
function array_map_filter($array, $callback, $strict = false)
{
    $callback = func_user_func_array($callback);
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
 * $exa = new \Exception('a'); $exb = new \Exception('b'); $std = new \stdClass();
 * // getMessage で map される
 * assert(array_map_method([$exa, $exb], 'getMessage')                       === ['a', 'b']);
 * // getMessage で map されるが、メソッドが存在しない場合は取り除かれる
 * assert(array_map_method([$exa, $exb, $std, null], 'getMessage', [], true) === ['a', 'b']);
 * // getMessage で map されるが、メソッドが存在しない場合はそのまま返す
 * assert(array_map_method([$exa, $exb, $std, null], 'getMessage', [], null) === ['a', 'b', $std, null]);
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
        return call_user_func_array([$object, $method], $args);
    }, $array);
}

/** @noinspection PhpDocSignatureInspection */
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
 * assert(array_nmap(['a', 'b'], $sprintf, 1, 'prefix-', '-suffix')   === ['prefix-a-suffix', 'prefix-b-suffix']);
 * // 1番目にキー、2番目に値を渡して map
 * $sprintf = function(){return vsprintf('%s %s %s %s %s', func_get_args());};
 * assert(array_nmap(['k' => 'v'], $sprintf, [1 => 2], 'a', 'b', 'c') === ['k' => 'a k b v c']);
 * ```
 *
 * @param array|\Traversable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @param int|array $n 要素値を入れる引数番目。配列を渡すとキー・値の両方を指定でき、両方が渡ってくる
 * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
 * @return array 評価クロージャを通した新しい配列
 */
function array_nmap($array, $callback, $n)
{
    /** @var $kn */
    /** @var $vn */

    $is_array = is_array($n);
    $args = array_slice(func_get_args(), 3);

    // 配列が来たら [キー番目 => 値番目] とみなす
    if ($is_array) {
        if (empty($n)) {
            throw new \InvalidArgumentException('array $n is empty.');
        }
        list($kn, $vn) = first_keyvalue($n);

        // array_insert は負数も受け入れられるが、それを考慮しだすともう収拾がつかない
        if ($kn < 0 || $vn < 0) {
            throw new \InvalidArgumentException('$kn, $vn must be positive.');
        }

        // どちらが大きいかで順番がズレるので分岐しなければならない
        if ($kn <= $vn) {
            $args = array_insert($args, null, $kn);
            $args = array_insert($args, null, ++$vn);// ↑で挿入してるので+1
        }
        else {
            $args = array_insert($args, null, $vn);
            $args = array_insert($args, null, ++$kn);// ↑で挿入してるので+1
        }
    }
    else {
        $args = array_insert($args, null, $n);
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

/** @noinspection PhpDocSignatureInspection */
/**
 * 要素値を $callback の最左に適用して array_map する
 *
 * Example:
 * ```php
 * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
 * assert(array_lmap(['a', 'b'], $sprintf, '-suffix') === ['a-suffix', 'b-suffix']);
 * ```
 *
 * @param array|\Traversable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
 * @return array 評価クロージャを通した新しい配列
 */
function array_lmap($array, $callback)
{
    return call_user_func_array(array_nmap, array_insert(func_get_args(), 0, 2));
}

/** @noinspection PhpDocSignatureInspection */
/**
 * 要素値を $callback の最右に適用して array_map する
 *
 * Example:
 * ```php
 * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
 * assert(array_rmap(['a', 'b'], $sprintf, 'prefix-') === ['prefix-a', 'prefix-b']);
 * ```
 *
 * @param array|\Traversable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
 * @return array 評価クロージャを通した新しい配列
 */
function array_rmap($array, $callback)
{
    return call_user_func_array(array_nmap, array_insert(func_get_args(), func_num_args() - 2, 2));
}

/**
 * 配列の次元数を返す
 *
 * フラット配列は 1 と定義する。
 * つまり、配列を与える限りは 0 以下を返すことはない。
 *
 * Example:
 * ```php
 * assert(array_depth([])                       === 1);
 * assert(array_depth(['hoge'])                 === 1);
 * assert(array_depth([['nest1' => ['nest2']]]) === 3);
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
    return 1 + max(array_map(__FUNCTION__, $arrays));
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
 * assert(array_insert([1, 2, 3], 'x')                         === [1, 2, 3, 'x']);
 * assert(array_insert([1, 2, 3], 'x', 1)                      === [1, 'x', 2, 3]);
 * assert(array_insert([1, 2, 3], 'x', -1)                     === [1, 2, 'x', 3]);
 * assert(array_insert([1, 2, 3], ['a' => 'A', 'b' => 'B'], 1) === [1, 'a' => 'A', 'b' => 'B', 2, 3]);
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
 * assert(array_assort([1, 2, 3], ['lt2' => function($v){return $v < 2;}])                               === ['lt2' => [1]]);
 * // lt3(3より小さい)、ctd(ctype_digit)で分類（両方に属する要素が存在する）
 * assert(array_assort(['1', '2', '3'], ['lt3' => function($v){return $v < 3;}, 'ctd' => 'ctype_digit']) === ['lt3' => ['1', '2'], 'ctd' => ['1', '2', '3']]);
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
        $rule = func_user_func_array($rule);
        foreach ($array as $k => $v) {
            if ($rule($v, $k)) {
                $result[$name][$k] = $v;
            }
        }
    }
    return $result;
}

/**
 * 配列をコールバックの返り値でグループ化する
 *
 * Example:
 * ```php
 * assert(array_group([1, 1, 1])                                 === [1 => [1, 1, 1]]);
 * assert(array_group([1, 2, 3], function($v){return $v % 2;})   === [1 => [1, 3], 0 => [2]]);
 * ```
 *
 * @param array|\Traversable 対象配列
 * @param callable $callback 評価クロージャ。 null なら値そのもので評価
 * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
 * @return array グルーピングされた配列
 */
function array_group($array, $callback = null, $preserve_keys = false)
{
    $callback = func_user_func_array($callback);

    $result = [];
    foreach ($array as $k => $v) {
        $vv = $callback($v, $k);
        if (!$preserve_keys && is_int($k)) {
            $result[$vv][] = $v;
        }
        else {
            $result[$vv][$k] = $v;
        }
    }
    return $result;
}

/**
 * 全要素が true になるなら true を返す（1つでも false なら false を返す）
 *
 * $callback が要求するならキーも渡ってくる。
 *
 * Example:
 * ```php
 * assert(array_all([true, true])   === true);
 * assert(array_all([true, false])  === false);
 * assert(array_all([false, false]) === false);
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

    $callback = func_user_func_array($callback);

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
 * assert(array_any([true, true])   === true);
 * assert(array_any([true, false])  === true);
 * assert(array_any([false, false]) === false);
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

    $callback = func_user_func_array($callback);

    foreach ($array as $k => $v) {
        if ($callback($v, $k)) {
            return true;
        }
    }
    return false;
}

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
 * 'col1' => true,                               // true: 昇順, false: 降順。照合は型に依存
 * 'col2' => SORT_NATURAL,                       // SORT_NATURAL, SORT_REGULAR などで照合。正数で昇順、負数で降順
 * 'col3' => ['sort', 'this', 'order'],          // 指定した配列順で昇順
 * 'col4' => function($v) {return $v;},          // クロージャを通した値で昇順。照合は返り値の型(php7 は returnType)に依存
 * 'col5' => function($a, $b) {return $a - $b;}, // クロージャで比較して昇順（いわゆる比較関数を渡す）
 * ];
 * ```
 *
 * Example:
 * ```php
 * $v1 = ['id' => '1', 'no' => 'a03', 'name' => 'yyy'];
 * $v2 = ['id' => '2', 'no' => 'a4',  'name' => 'yyy'];
 * $v3 = ['id' => '3', 'no' => 'a12', 'name' => 'xxx'];
 * // name 昇順, no 自然降順
 * assert(array_order([$v1, $v2, $v3], ['name' => true, 'no' => -SORT_NATURAL]) === [$v3, $v2, $v1]);
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

    if (!is_array($orders) || !is_hasharray($orders)) {
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
        else if (is_int($order)) {
            $args[] = $columns;
            $args[] = $order > 0 ? SORT_ASC : SORT_DESC;
            $args[] = abs($order);
        }
        // 配列はその並び
        else if (is_array($order)) {
            $args[] = $position($columns, $order);
            $args[] = SORT_ASC;
            $args[] = SORT_NUMERIC;
        }
        // クロージャは色々
        else if ($order instanceof \Closure) {
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
                // @codeCoverageIgnoreStart
                if (method_exists($ref, 'hasReturnType') && $ref->hasReturnType()) {
                    // getReturnType があるならそれに基づく
                    /** @noinspection PhpUndefinedMethodInspection */
                    $type = (string) $ref->getReturnType();
                }
                // @codeCoverageIgnoreEnd
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

/** @noinspection PhpDocSignatureInspection */
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
 * assert(array_shrink_key($array1, $array2, $array3) === ['c' => 'C3']);
 * ```
 *
 * @param array $array 対象配列
 * @param array $arrays 比較する配列
 * @return array 新しい配列
 */
function array_shrink_key(array $array)
{
    $args = func_get_args();
    array_unshift($args, call_user_func_array('array_replace', $args));
    return call_user_func_array('array_intersect_key', $args);
}

/**
 * キー保存可能な array_column
 *
 * array_column は キーを保存することが出来ないが、この関数は引数を2つだけ与えるとキーはそのままで array_column 相当の配列を返す。
 *
 * Example:
 * ```php
 * $array = [11 => ['id' => 1, 'name' => 'name1'], 12 => ['id' => 2, 'name' => 'name2'], 13 => ['id' => 3, 'name' => 'name3']];
 * // 第3引数を渡せば array_column と全く同じ
 * assert(array_lookup($array, 'name', 'id') === array_column($array, 'name', 'id'));
 * assert(array_lookup($array, 'name', null) === array_column($array, 'name', null));
 * // 省略すればキーが保存される
 * assert(array_lookup($array, 'name')       === [11 => 'name1', 12 => 'name2', 13 => 'name3']);
 * assert(array_lookup($array)               === $array);
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
        else if (is_array($v) && array_key_exists($column_key, $v)) {
            $result[$k] = $v[$column_key];
        }
        else if (is_object($v) && (isset($v->$column_key) || property_exists($v, $column_key))) {
            $result[$k] = $v->$column_key;
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
 * assert(array_columns([['id' => 1, 'name' => 'A'], ['id' => 2, 'name' => 'B']])               === ['id' => [1, 2], 'name' => ['A', 'B']]);
 * assert(array_columns([['id' => 1, 'name' => 'A'], ['id' => 2, 'name' => 'B']], 'id')         === ['id' => [1, 2]]);
 * assert(array_columns([['id' => 1, 'name' => 'A'], ['id' => 2, 'name' => 'B']], 'name', 'id') === ['name' => [1 => 'A', 2 => 'B']]);
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

/**
 * array_columns のほぼ逆で [キー => [要素]] 配列から連想配列の配列を生成する
 *
 * $template を指定すると「それに含まれる配列かつ値がデフォルト」になる（要するに $default みたいなもの）。
 * キーがバラバラな配列を指定する場合は指定したほうが良い。が、null を指定すると最初の要素が使われるので大抵の場合は null で良い。
 *
 * Example:
 * ```php
 * assert(array_uncolumns(['id' => [1, 2], 'name' => ['A', 'B']]) === [['id' => 1, 'name' => 'A'], ['id' => 2, 'name' => 'B']]);
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
        $template = array_fill_keys(array_keys(first_value($array)), null);
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
 * 引数は (キー, 値, 元配列, 大元配列) で渡ってくる。
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
 *     'k1' => 'v1',
 *     'k2' => [
 *         'k21' => 'v21',
 *         'k22' => [
 *             'k221' => 'v221',
 *             'k222' => 'v222',
 *         ],
 *     ],
 * ];
 * // 全要素に 'prefix-' を付与する。キーには '_' をつける。ただし 'k22' はまるごと伏せる。さらに 'k21' はそのままとする
 * $callback = function($k, &$v){if ($k === 'k22') return false; if ($k === 'k21') return null; if(!is_array($v)) $v = "prefix-$v"; return "_$k";};
 * assert(array_convert($array, $callback, true) === [
 *     '_k1' => 'prefix-v1',
 *     '_k2' => [
 *         'k21' => 'v21',
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
    $recursive = function (&$result, $array, $source, $callback) use (&$recursive, $apply_array) {
        $sequences = [];
        foreach ($array as $key => $value) {
            $is_array = is_array($value);
            $newkey = $key;
            // 配列で $apply_array あるいは非配列の場合にコールバック適用
            if (($is_array && $apply_array) || !$is_array) {
                $newkey = $callback($key, $value, $array, $source);
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
                $result[$newkey] = [];
                $recursive($result[$newkey], $value, $source, $callback);
            }
            else {
                $result[$newkey] = $value;
            }
        }
        // 数値連番は上書きを防ぐためにあとでやる
        foreach ($sequences as $key => $value) {
            if (is_string($key)) {
                $v = [];
                $result[] = &$v;
                $recursive($v, $value, $source, $callback);
                unset($v);
            }
            else {
                $result[] = $value;
            }
        }
    };

    $result = [];
    $recursive($result, $array, $array, $callback);
    return $result;
}
