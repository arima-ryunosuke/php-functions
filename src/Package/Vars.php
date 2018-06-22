<?php

namespace ryunosuke\Functions\Package;

/**
 * 変数関連のユーティリティ
 */
class Vars
{
    /**
     * 値を何とかして文字列化する
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * @param mixed $var 文字列化する値
     * @return string $var を文字列化したもの
     */
    public static function stringify($var)
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
    public static function numberify($var, $decimal = false)
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
    public static function numval($var, $base = 10)
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
    public static function arrayval($var, $recursive = true)
    {
        if (!$recursive || call_user_func(is_primitive, $var)) {
            return (array) $var;
        }

        // return json_decode(json_encode($var), true);

        $result = [];
        foreach ($var as $k => $v) {
            if (!call_user_func(is_primitive, $v)) {
                $v = call_user_func(arrayval, $v, true);
            }
            $result[$k] = $v;
        }
        return $result;
    }

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
    public static function is_empty($var)
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
    public static function is_primitive($var)
    {
        return is_scalar($var) || is_null($var) || is_resource($var);
    }

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
    public static function is_recursive($var)
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
    public static function is_iterable($var)
    {
        return is_array($var) || $var instanceof \Traversable;
    }

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
    public static function is_countable($var)
    {
        return is_array($var) || $var instanceof \Countable;
    }

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
    public static function varcmp($a, $b, $mode = null)
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
    public static function var_type($var)
    {
        if (is_object($var)) {
            return '\\' . get_class($var);
        }
        return gettype($var);
    }

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
    public static function var_apply($var, $callback, ...$args)
    {
        $iterable = call_user_func(is_iterable, $var);
        if ($iterable) {
            $result = [];
            foreach ($var as $k => $v) {
                $result[$k] = call_user_func(var_apply, $v, $callback, ...$args);
            }
            return $result;
        }

        return $callback($var, ...$args);
    }

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
    public static function var_applys($var, $callback, ...$args)
    {
        $iterable = call_user_func(is_iterable, $var);
        if (!$iterable) {
            $var = [$var];
        }
        $var = $callback($var, ...$args);
        return $iterable ? $var : $var[0];
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
    public static function var_export2($value, $return = false)
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
                $parents[] = $value;
                return get_class($value) . '::__set_state(' . $export(call_user_func(get_object_properties, $value), $nest, $parents) . ')';
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
    public static function var_html($value)
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
                return get_class($value) . '::' . $export(call_user_func(get_object_properties, $value), $parents);
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
    public static function hashvar(...$vars)
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
