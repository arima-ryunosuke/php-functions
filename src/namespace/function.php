<?php

/**
 * Don't touch this code. This is auto generated.
 */

namespace ryunosuke\Functions;

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
        $result = array_intersect_key($array, array_flip($key));
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
    $plength = parameter_length($callback, true);
    $result = [];
    foreach ($array as $k => $v) {
        $vv = $plength === 1 ? $callback($k) : $callback($k, $v);
        if ($vv) {
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
 * $where は絞り込み条件を渡す。null を与えると true 相当の値でフィルタする。
 * つまり $column も $where も省略した場合、実質的に array_filter と同じ動作になる。
 *
 * $column は配列を受け入れる。配列を渡した場合その共通項がコールバックに渡る。
 *
 * $where が要求するならキーも渡ってくる。
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
 * // $where が引数2つならキーも渡ってくる（キーが 2 のものだけ返す）
 * $equal_2 = function($row, $key){return $key === 2;};
 * assert(array_where($array, null, $equal_2)                   === [2 => ['id' => 3, 'name' => 'piyo', 'flag' => false]]);
 * // $column に配列を渡すと共通項が渡ってくる
 * $idname_is_2fuga = function($idname){return ($idname['id'] . $idname['name']) === '2fuga';};
 * assert(array_where($array, ['id', 'name'], $idname_is_2fuga) === [1 => ['id' => 2, 'name' => 'fuga', 'flag' => true]]);
 * ```
 *
 * @param array|\Traversable $array 対象配列
 * @param string|array|null $column キー名
 * @param callable $where 評価クロージャ
 * @return array $where が真を返した新しい配列
 */
function array_where($array, $column = null, $where = null)
{
    $is_array = is_array($column);
    if ($is_array) {
        $column = array_flip($column);
    }

    $plength = 0;
    if ($where !== null) {
        $plength = parameter_length($where, true);
    }

    $result = [];
    foreach ($array as $k => $v) {
        if ($column === null) {
            $value = $v;
        }
        else if ($is_array) {
            $value = array_intersect_key($v, $column);
        }
        else {
            $value = $v[$column];
        }

        if ($where === null) {
            $match = $value;
        }
        else if ($plength === 1) {
            $match = $where($value);
        }
        else {
            $match = $where($value, $k);
        }

        if ($match) {
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
    $plength = parameter_length($callback, true);
    $result = [];
    foreach ($array as $k => $v) {
        $vv = $plength === 1 ? $callback($v) : $callback($v, $k);
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
        $plength = parameter_length($rule, true);
        foreach ($array as $k => $v) {
            $vv = $plength === 1 ? $rule($v) : $rule($v, $k);
            if ($vv) {
                $result[$name][$k] = $v;
            }
        }
    }
    return $result;
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
            if (!array_key_exists($key, $first)) {
                throw new \InvalidArgumentException("$key is undefined.");
            }
            $firstval = $first[$key];
            $columns = array_column($array, $key);
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
            if ($ref->getNumberOfParameters() === 2) {
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
 * composer のクラスローダを返す
 *
 * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
 *
 * Example:
 * ```php
 * assert(class_loader() instanceof \Composer\Autoload\ClassLoader);
 * ```
 *
 * @param string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
 * @return \Composer\Autoload\ClassLoader クラスローダ
 */
function class_loader($startdir = null)
{
    $file = \ryunosuke\Functions\Cacher::put(__FILE__, __FUNCTION__, function ($cache) use ($startdir) {
        if (!isset($cache)) {
            $dir = $startdir ?: __DIR__;
            while ($dir !== ($pdir = dirname($dir))) {
                $dir = $pdir;
                if (file_exists($file = "$dir/autoload.php") | file_exists($file = "$dir/vendor/autoload.php")) {
                    $cache = $file;
                    break;
                }
            }
            if ($cache === null) {
                throw new \DomainException('autoloader is not found.');
            }
        }
        return $cache;
    });
    return require $file;
}

/**
 * クラスの名前空間部分を取得する
 *
 * Example:
 * ```php
 * assert(class_namespace('vendor\\namespace\\ClassName') === 'vendor\\namespace');
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

/**
 * クラスの名前空間部分を除いた短い名前を取得する
 *
 * Example:
 * ```php
 * assert(class_shorten('vendor\\namespace\\ClassName') === 'ClassName');
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
    $classfile = class_loader()->findFile($class);
    $fname = rtrim(($dirname ?: sys_get_temp_dir()), '/\\') . '/' . str_replace('\\', '/', $class) . '.php';
    if (func_num_args() === 2 || !file_exists($fname)) {
        $content = file_get_contents($classfile);
        $content = preg_replace("#class\\s+[a-z0-9_]#ui", '$0_', $content);
        file_set_contents($fname, $content);
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

/**
 * クラスにメソッドがあるかを返す
 *
 * Example:
 * ```php
 * assert(has_class_methods('Exception', 'getMessage') === true);
 * assert(has_class_methods('Exception', 'getmessage') === true);
 * assert(has_class_methods('Exception', 'undefined')  === false);
 * ```
 *
 * @param string|object $class 対象クラス・オブジェクト
 * @param string $method_name 調べるメソッド名
 * @return bool 持っているなら true
 */
function has_class_methods($class, $method_name)
{
    if (is_object($class)) {
        $class = get_class($class);
    }

    // php はクラス名の大文字小文字を区別しない。
    // が、そんな頻繁にバラバラに与えられないだろうし動作は変わらないし変換するコストの方が大きそうなので考慮しない
    $cache = \ryunosuke\Functions\Cacher::put(__FILE__, __FUNCTION__, function ($cache) use ($class) {
        if (!isset($cache[$class])) {
            // php はメソッドの大文字小文字を区別しない
            $cache[$class] = array_change_key_case(array_flip(get_class_methods($class)), CASE_LOWER);
        }
        return $cache;
    });
    return isset($cache[$class][strtolower($method_name)]);
}
/**
 * ファイルの拡張子を変更する。引数を省略すると拡張子を返す
 *
 * pathinfoに準拠。例えば「filename.hoge.fuga」のような形式は「fuga」が変換対象になる。
 *
 * Example:
 * ```php
 * assert(file_extension('filename.ext')        === 'ext');
 * assert(file_extension('filename.ext', 'txt') === 'filename.txt');
 * assert(file_extension('filename.ext', '')    === 'filename');
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

/**
 * ディレクトリも掘る file_put_contents
 *
 * Example:
 * ```php
 * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
 * assert(file_get_contents(sys_get_temp_dir() . '/not/filename.ext') === 'hoge');
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
        if (!@mkdir($dirname, 0777 & (~$umask), true)) {
            throw new \RuntimeException("failed to mkdir($dirname)");
        }
    }
    return file_put_contents($filename, $data);
}

/**
 * 中身があっても消せる rmdir
 *
 * Example:
 * ```php
 * mkdir(sys_get_temp_dir() . '/new/make/dir', 0777, true);
 * rm_rf(sys_get_temp_dir() . '/new');
 * assert(file_exists(sys_get_temp_dir() . '/new') === false);
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
/** @noinspection PhpDocSignatureInspection */
/**
 * $callable の指定位置に引数を束縛したクロージャを返す
 *
 * Example:
 * ```php
 * $bind = nbind('sprintf', 2, 'X');
 * assert($bind('%s%s%s', 'N', 'N') === 'NXN');
 * ```
 *
 * @param callable $callable 対象 callable
 * @param int $n 挿入する引数位置
 * @param mixed $variadic 本来の引数（可変引数）
 * @return \Closure 束縛したクロージャ
 */
function nbind($callable, $n)
{
    $args = array_slice(func_get_args(), 2);
    return function () use ($callable, $n, $args) {
        return call_user_func_array($callable, array_insert(func_get_args(), $args, $n));
    };
}

/** @noinspection PhpDocSignatureInspection */
/**
 * $callable の最左に引数を束縛した callable を返す
 *
 * Example:
 * ```php
 * $bind = lbind('sprintf', '%s%s');
 * assert($bind('N', 'M') === 'NM');
 * ```
 *
 * @param callable $callable 対象 callable
 * @param mixed $variadic 本来の引数（可変引数）
 * @return \Closure 束縛したクロージャ
 */
function lbind($callable)
{
    return call_user_func_array(nbind, array_insert(func_get_args(), 0, 1));
}

/** @noinspection PhpDocSignatureInspection */
/**
 * $callable の最右に引数を束縛した callable を返す
 *
 * Example:
 * ```php
 * $bind = rbind('sprintf', 'X');
 * assert($bind('%s%s', 'N') === 'NX');
 * ```
 *
 * @param callable $callable 対象 callable
 * @param mixed $variadic 本来の引数（可変引数）
 * @return \Closure 束縛したクロージャ
 */
function rbind($callable)
{
    return call_user_func_array(nbind, array_insert(func_get_args(), null, 1));
}

/**
 * 返り値の真偽値を逆転した新しいクロージャを返す
 *
 * Example:
 * ```php
 * $not_strlen = not_func('strlen');
 * assert($not_strlen('hoge') === false);
 * assert($not_strlen('')     === true);
 * ```
 *
 * @param callable $callable 対象 callable
 * @return \Closure 新しいクロージャ
 */
function not_func($callable)
{
    return function () use ($callable) { return !call_user_func_array($callable, func_get_args()); };
}

/** @noinspection PhpDocSignatureInspection */
/**
 * 指定コードで eval するクロージャを返す
 *
 * create_function のクロージャ版みたいなもの。
 * 参照渡しは未対応。
 *
 * Example:
 * ```php
 * $evalfunc = eval_func('$a + $b + $c', 'a', 'b', 'c');
 * assert($evalfunc(1, 2, 3) === 6);
 * ```
 *
 * @param string $expression eval コード
 * @param mixed $variadic 引数名（可変引数）
 * @return \Closure 新しいクロージャ
 */
function eval_func($expression)
{
    $args = array_slice(func_get_args(), 1);
    return function () use ($expression, $args) {
        return call_user_func(function () {
            extract(func_get_arg(1));
            return eval("return " . func_get_arg(0) . ";");
        }, $expression, array_combine($args, func_get_args()));
    };
}

/**
 * callable から ReflectionFunctionAbstract を生成する
 *
 * Example:
 * ```php
 * assert(reflect_callable('sprintf')        instanceof \ReflectionFunction);
 * assert(reflect_callable('\Closure::bind') instanceof \ReflectionMethod);
 * ```
 *
 * @param callable $callable 対象 callable
 * @return \ReflectionFunction|\ReflectionMethod リフレクションインスタンス
 */
function reflect_callable($callable)
{
    // callable チェック兼 $call_name 取得
    if (!is_callable($callable, false, $call_name)) {
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

/**
 * callable を Closure に変換する
 *
 * php7.1 の fromCallable みたいなもの。
 *
 * Example:
 * ```php
 * $sprintf = closurize('sprintf');
 * assert($sprintf                            instanceof \Closure);
 * assert($sprintf('%s %s', 'hello', 'world') ===        'hello world');
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

    $ref = reflect_callable($callable);
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
 * assert(parameter_length('trim')       === 2);
 * // trim の必須引数は1つ
 * assert(parameter_length('trim', true) === 1);
 * ```
 *
 * @param callable $callable 対象 callable
 * @param bool $require_only true を渡すと必須パラメータの数を返す
 * @return int 引数の数
 */
function parameter_length($callable, $require_only = false)
{
    // クロージャの $call_name には一意性がないのでキャッシュできない（spl_object_hash でもいいが、かなり重複するので完全ではない）
    if ($callable instanceof \Closure) {
        $ref = reflect_callable($callable);
        return $require_only ? $ref->getNumberOfRequiredParameters() : $ref->getNumberOfParameters();
    }

    // $call_name 取得
    is_callable($callable, false, $call_name);

    $cache = \ryunosuke\Functions\Cacher::put(__FILE__, __FUNCTION__, function ($cache) use ($callable, $call_name) {
        if (!isset($cache[$call_name])) {
            $ref = reflect_callable($callable);
            $cache[$call_name] = [
                false => $ref->getNumberOfParameters(),
                true  => $ref->getNumberOfRequiredParameters(),
            ];
        }
        return $cache;
    });
    return $cache[$call_name][$require_only];
}

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
/** @noinspection PhpDocSignatureInspection */
/**
 * 文字列結合の関数版
 *
 * Example:
 * ```php
 * assert(strcat('a', 'b', 'c') === 'abc');
 * ```
 *
 * @param mixed $variadic 結合する文字列（可変引数）
 * @return string 結合した文字列
 */
function strcat()
{
    return implode('', func_get_args());
}

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
 * assert(split_noempty(',', 'a, b, c')            === ['a', 'b', 'c']);
 * assert(split_noempty(',', 'a, , , b, c')        === ['a', 'b', 'c']);
 * assert(split_noempty(',', 'a, , , b, c', false) === ['a', ' ', ' ', ' b', ' c']);
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
    $trim = ($trimchars === true) ? 'trim' : rbind('trim', $trimchars);
    $parts = explode($delimiter, $string);
    $parts = array_map($trim, $parts);
    $parts = array_filter($parts, 'strlen');
    $parts = array_values($parts);
    return $parts;
}

/**
 * 文字列比較の関数版
 *
 * 文字列以外が与えられた場合は常に false を返す。ただし __toString を実装したオブジェクトは別。
 *
 * Example:
 * ```php
 * assert(str_equals('abc', 'abc')       === true);
 * assert(str_equals('abc', 'ABC', true) === true);
 * assert(str_equals('\0abc', '\0abc')   === true);
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
    if (is_object($str1) && has_class_methods($str1, '__toString')) {
        $str1 = (string) $str1;
    }
    if (is_object($str2) && has_class_methods($str2, '__toString')) {
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

/**
 * 指定文字列を含むか返す
 *
 * Example:
 * ```php
 * assert(str_contains('abc', 'b')                      === true);
 * assert(str_contains('abc', 'B', true)                === true);
 * assert(str_contains('abc', ['b', 'x'], false, false) === true);
 * assert(str_contains('abc', ['b', 'x'], false, true)  === false);
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

/**
 * 指定文字列で始まるか調べる
 *
 * Example:
 * ```php
 * assert(starts_with('abcdef', 'abc')       === true);
 * assert(starts_with('abcdef', 'ABC', true) === true);
 * assert(starts_with('abcdef', 'xyz')       === false);
 * ```
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

    return str_equals(substr($string, 0, strlen($with)), $with, $case_insensitivity);
}

/**
 * 指定文字列で終わるか調べる
 *
 * Example:
 * ```php
 * assert(ends_with('abcdef', 'def')       === true);
 * assert(ends_with('abcdef', 'DEF', true) === true);
 * assert(ends_with('abcdef', 'xyz')       === false);
 * ```
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

    return str_equals(substr($string, -strlen($with)), $with, $case_insensitivity);
}

/**
 * camelCase に変換する
 *
 * Example:
 * ```php
 * assert(camel_case('this_is_a_pen') === 'thisIsAPen');
 * ```
 *
 * @param string $string 対象文字列
 * @param string $delimiter デリミタ
 * @return string 変換した文字列
 */
function camel_case($string, $delimiter = '_')
{
    return lcfirst(pascal_case($string, $delimiter));
}

/**
 * PascalCase に変換する
 *
 * Example:
 * ```php
 * assert(pascal_case('this_is_a_pen') === 'ThisIsAPen');
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

/**
 * snake_case に変換する
 *
 * Example:
 * ```php
 * assert(snake_case('ThisIsAPen') === 'this_is_a_pen');
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

/**
 * chain-case に変換する
 *
 * Example:
 * ```php
 * assert(chain_case('ThisIsAPen') === 'this-is-a-pen');
 * ```
 *
 * @param string $string 対象文字列
 * @param string $delimiter デリミタ
 * @return string 変換した文字列
 */
function chain_case($string, $delimiter = '-')
{
    return snake_case($string, $delimiter);
}

/**
 * 安全な乱数文字列を生成する
 *
 * 下記のいずれかを記述順の優先度で使用する。
 *
 * - random_bytes: 汎用だが php7 以降のみ
 * - openssl_random_pseudo_bytes: openSsl が必要
 * - mcrypt_create_iv: Mcrypt が必要
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

    // 使えるなら最も優秀なはず
    if (function_exists('random_bytes')) {
        $bytes = random_bytes($length);
    }
    // 次点
    else if (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes($length, $crypto_strong);
        if ($crypto_strong === false) {
            throw new \Exception('failed to random_string ($crypto_strong is false).');
        }
    }
    // よく分からない？
    else if (function_exists('mcrypt_create_iv')) {
        /** @noinspection PhpDeprecationInspection */
        $bytes = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
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

/**
 * 連想配列を指定できるようにした vsprintf
 *
 * sprintf の順序指定構文('%1$d')にキーを指定できる。
 *
 * Example:
 * ```php
 * assert(kvsprintf('%hoge$s %fuga$d', ['hoge' => 'ThisIs', 'fuga' => '3.14']) === 'ThisIs 3');
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
 * assert(render_string('${0}', ['number'])                                          === 'number');
 * // クロージャは呼び出し結果が埋め込まれる
 * assert(render_string('$c', ['c' => function($vars, $k){return $k . '-closure';}]) === 'c-closure');
 * // 引数をそのまま返すだけの特殊な変数 $_ が宣言される
 * assert(render_string('{$_(123 + 456)}', [])                                       === '579');
 * // 要するに '$_()' の中に php の式が書けるようになる
 * assert(render_string('{$_(implode(\',\', $strs))}', ['strs' => ['a', 'n', 'z']])  === 'a,n,z');
 * assert(render_string('{$_(max($nums))}', ['nums' => [1, 9, 3]])                   === '9');
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

/**
 * "hoge {$hoge}" 形式のレンダリングのファイル版
 *
 * @see render_string
 *
 * @param string $template_file レンダリングするファイル名
 * @param array $array レンダリング変数
 * @return string レンダリングされた文字列
 */
function render_file($template_file, $array)
{
    return render_string(file_get_contents($template_file), $array);
}
/**
 * 引数をそのまま返す
 *
 * clone などでそのまま返す関数が欲しいことがまれによくあるはず。
 *
 * Example:
 * ```php
 * $object = new \stdClass();
 * assert(returns($object) === $object);
 * ```
 *
 * @param mixed $v return する値
 * @return mixed $v を返す
 */
function returns($v)
{
    return $v;
}

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
 * ```php
 * // null を返すかもしれないステートメント
 * $getobject = function () {return null;};
 * // メソッド呼び出しは null を返す
 * assert(optional($getobject())->method()          === null);
 * // プロパティアクセスは null を返す
 * assert(optional($getobject())->property          === null);
 * // empty は true を返す
 * assert(empty(optional($getobject())->nothing)    === true);
 * // __isset は false を返す
 * assert(isset(optional($getobject())->nothing)    === false);
 * // __toString は '' を返す
 * assert(strval(optional($getobject()))            === '');
 * // __invoke は null を返す
 * assert(call_user_func(optional($getobject()))    === null);
 * // 配列アクセスは null を返す
 * assert($getobject()['hoge']                      === null);
 * // 空イテレータを返す
 * assert(iterator_to_array(optional($getobject())) === []);
 * ```
 *
 * @param object|null $object オブジェクト
 * @return mixed $object がオブジェクトならそのまま返し、違うなら NullObject を返す
 */
function optional($object)
{
    if (is_object($object)) {
        return $object;
    }

    static $nullobject = null;
    return $nullobject = $nullobject ?: new \ryunosuke\Functions\NullObject();
}

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
 *     assert($ex->getMessage() === 'throws');
 * }
 * ```
 *
 * @param \Exception $ex 投げる例外
 */
function throws($ex)
{
    throw $ex;
}

/**
 * try ～ catch 構文の関数版
 *
 * 例外機構構文が冗長なことがまれによくあるはず。
 *
 * Example:
 * ```php
 * $ex = new \Exception('try_catch');
 * assert(try_catch(function() use ($ex) { throw $ex; }) === $ex);
 * ```
 *
 * @param callable $try try ブロッククロージャ
 * @param callable $catch catch ブロッククロージャ
 * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
 */
function try_catch($try, $catch = null)
{
    return try_catch_finally($try, $catch, null);
}

/**
 * try ～ catch ～ finally 構文の関数版
 *
 * php < 5.5 にはないし、例外機構構文が冗長なことがまれによくあるはず。
 *
 * Example:
 * ```php
 * $ex = new \Exception('try_catch');
 * assert(try_catch(function() use ($ex) { throw $ex; }) === $ex);
 * ```
 *
 * @param callable $try try ブロッククロージャ
 * @param callable $catch catch ブロッククロージャ
 * @param callable $finally finally ブロッククロージャ
 * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
 */
function try_catch_finally($try, $catch = null, $finally = null)
{
    if ($catch === null) {
        $catch = function ($v) { return $v; };
    }

    try {
        $return = $try();
    }
    catch (\Exception $tried_ex) {
        try {
            $return = $catch($tried_ex);
        }
        catch (\Exception $catched_ex) {
            if ($finally !== null) {
                $finally();
            }
            throw $catched_ex;
        }
    }
    if ($finally !== null) {
        $finally();
    }
    return $return;
}
/**
 * 値が複合型でないか検査する
 *
 * 「複合型」とはオブジェクトとクラスのこと。
 * つまり
 *
 * - is_scalar($var) || is_null($var) || is_resource($var)
 *
 * と同義（!is_array($var) && !is_object($var) とも言える）。
 *
 * Example:
 * ```php
 * assert(is_primitive(null)          === true);
 * assert(is_primitive(false)         === true);
 * assert(is_primitive(123)           === true);
 * assert(is_primitive(STDIN)         === true);
 * assert(is_primitive(new \stdClass) === false);
 * assert(is_primitive(['array'])     === false);
 * ```
 *
 * @param mixed $var 調べる値
 * @return bool 複合型なら false
 */
function is_primitive($var)
{
    return is_scalar($var) || is_null($var) || is_resource($var);
}

/**
 * 組み込みの var_export をいい感じにしたもの
 *
 * 下記の点が異なる。
 *
 * - 配列は 5.4 以降のショートシンタックス（[]）で出力
 * - インデントは 4 固定
 * - ただの配列は1行（[1, 2, 3]）でケツカンマなし、連想配列は桁合わせインデントでケツカンマあり
 * - null は null（小文字）
 *
 * Example:
 * ```php
 * assert(var_export2(['array' => [1, 2, 3], 'hash' => ['a' => 'A', 'b' => 'B', 'c' => 'C']], true) === "[
 *     'array' => [1, 2, 3],
 *     'hash'  => [
 *         'a' => 'A',
 *         'b' => 'B',
 *         'c' => 'C',
 *     ],
 * ]");
 * ```
 *
 * @param mixed $value 出力する値
 * @param bool $return 返すなら true 出すなら false
 * @return string|void $return=true の場合は出力せず結果を返す
 */
function var_export2($value, $return = false)
{
    // インデントの空白数
    $INDENT = 4;

    // 再帰用クロージャ
    $export = function ($value, $nest = 0) use (&$export, $INDENT) {
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
                if (array_filter($value, function ($v) { return is_scalar($v) || is_null($v); })) {
                    return '[' . implode(', ', array_map($export, $value)) . ']';
                }
                // スカラー値以外が含まれているならキーを含めない
                $kvl = '';
                foreach ($value as $k => $v) {
                    $kvl .= $spacer1 . $export($v, $nest + 1) . ",\n";
                }
                return "[\n{$kvl}{$spacer2}]";
            }

            // 連想配列はキーを含めて桁あわせ
            $maxlen = max(array_map('strlen', array_keys($value)));
            $kvl = '';
            foreach ($value as $k => $v) {
                $align = str_repeat(' ', $maxlen - strlen($k));
                $kvl .= $spacer1 . var_export($k, true) . $align . ' => ' . $export($v, $nest + 1) . ",\n";
            }
            return "[\n{$kvl}{$spacer2}]";
        }
        // null は小文字で居て欲しい
        else if (is_null($value)) {
            return 'null';
        }
        // オブジェクトは単にプロパティを __set_state する文字列が出力される（っぽい）ので、その引数部分だけ再帰
        else if (is_object($value)) {
            return get_class($value) . '::__set_state(' . $export((array) $value, $nest) . ')';
        }
        // それ以外は標準に従う
        else {
            return var_export($value, true);
        }
    };

    // 結果を返したり出力したり
    $result = $export($value, 0);
    if ($return) {
        return $result;
    }
    echo $result;
}

/** @noinspection PhpDocSignatureInspection */
/**
 * 変数指定をできるようにした compact
 *
 * 名前空間指定の呼び出しは未対応。use して関数名だけで呼び出す必要がある。
 *
 * Example:
 * ```php
 * $hoge = 'HOGE';
 * $fuga = 'FUGA';
 * assert(hashvar($hoge, $fuga) === ['hoge' => 'HOGE', 'fuga' => 'FUGA']);
 * ```
 *
 * @param mixed $var 変数（可変引数）
 * @return array 引数の変数を変数名で compact した配列
 */
function hashvar()
{
    $args = func_get_args();
    $num = func_num_args();

    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
    $file = $trace['file'];
    $line = $trace['line'];
    $function = function_shorten($trace['function']);

    $cache = \ryunosuke\Functions\Cacher::put(__FILE__, __FUNCTION__, function ($cache) use ($file, $line, $function) {
        if (!isset($cache[$file][$line])) {
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
                    else if ($starting && $token[0] === T_VARIABLE) {
                        $caller[] = ltrim($token[1], '$');
                    }
                    // 上記以外の呼び出し中のトークンは空白しか許されない
                    else if ($starting && $token[0] !== T_WHITESPACE) {
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

            $cache[$file][$line] = $callers;
        }
        return $cache;
    });

    // 引数の数が一致する呼び出しを返す
    foreach ($cache[$file][$line] as $caller) {
        if (count($caller) === $num) {
            return array_combine($caller, $args);
        }
    }

    // 仕組み上ここへは到達しないはず（呼び出し元のシンタックスが壊れてるときに到達しうるが、それならばそもそもこの関数自体が呼ばれないはず）。
    throw new \DomainException('syntax error.'); // @codeCoverageIgnore
}
