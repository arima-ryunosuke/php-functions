<?php

namespace ryunosuke\Functions\Package;

class Vars
{
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
     * assert(is_primitive(null)          === true);
     * assert(is_primitive(false)         === true);
     * assert(is_primitive(123)           === true);
     * assert(is_primitive(STDIN)         === true);
     * assert(is_primitive(new \stdClass) === false);
     * assert(is_primitive(['array'])     === false);
     * </code>
     *
     * @package Var
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
     * <code>
     * // 配列の再帰
     * $array = [];
     * $array['recursive'] = &$array;
     * assert(is_recursive($array)  === true);
     * // オブジェクトの再帰
     * $object = new \stdClass();
     * $object->recursive = $object;
     * assert(is_recursive($object) === true);
     * </code>
     *
     * @package Var
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
     * assert(var_export2(['array' => [1, 2, 3], 'hash' => ['a' => 'A', 'b' => 'B', 'c' => 'C']], true) === "[
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
     * assert(var_export2(compact('rarray', 'robject'), true) === "[
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
    public static function var_export2($value, $return = false)
    {
        // インデントの空白数
        $INDENT = 4;

        // オリジナルの var_export（返り値版）
        $var_export = function ($v) { return var_export($v, true); };

        // 再帰用クロージャ
        $export = function ($nest, $value, $parents) use (&$export, $INDENT, $var_export) {
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
                        $vals = array_map($var_export, $value);
                        return '[' . implode(', ', $vals) . ']';
                    }
                    // スカラー値以外が含まれているならキーを含めない
                    $kvl = '';
                    $parents[] = $value;
                    foreach ($value as $k => $v) {
                        $kvl .= $spacer1 . $export($nest + 1, $v, $parents) . ",\n";
                    }
                    return "[\n{$kvl}{$spacer2}]";
                }

                // 連想配列はキーを含めて桁あわせ
                $maxlen = max(array_map('strlen', array_keys($value)));
                $kvl = '';
                $parents[] = $value;
                foreach ($value as $k => $v) {
                    $align = str_repeat(' ', $maxlen - strlen($k));
                    $kvl .= $spacer1 . $var_export($k) . $align . ' => ' . $export($nest + 1, $v, $parents) . ",\n";
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
                return get_class($value) . '::__set_state(' . $export($nest, $vars, $parents) . ')';
            }
            // null は小文字で居て欲しい
            elseif (is_null($value)) {
                return 'null';
            }
            // それ以外は標準に従う
            else {
                return $var_export($value);
            }
        };

        // 結果を返したり出力したり
        $result = $export(0, $value, []);
        if ($return) {
            return $result;
        }
        echo $result;
    }

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
    public static function var_html($value)
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

    /** @noinspection PhpDocSignatureInspection */
    /**
     * 変数指定をできるようにした compact
     *
     * 名前空間指定の呼び出しは未対応。use して関数名だけで呼び出す必要がある。
     *
     * Example:
     * <code>
     * $hoge = 'HOGE';
     * $fuga = 'FUGA';
     * assert(hashvar($hoge, $fuga) === ['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * </code>
     *
     * @package Var
     *
     * @param mixed $var 変数（可変引数）
     * @return array 引数の変数を変数名で compact した配列
     */
    public static function hashvar()
    {
        $args = func_get_args();
        $num = func_num_args();

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
                return array_combine($caller, $args);
            }
        }

        // 仕組み上ここへは到達しないはず（呼び出し元のシンタックスが壊れてるときに到達しうるが、それならばそもそもこの関数自体が呼ばれないはず）。
        throw new \DomainException('syntax error.'); // @codeCoverageIgnore
    }
}
