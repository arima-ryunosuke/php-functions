<?php
/**
 * 変数に関するユーティリティ
 *
 * @package var
 */

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
            return var_export2($var, true);
        case 'object':
            if (has_class_methods($var, '__toString')) {
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
 * 変数が再帰参照を含むか調べる
 *
 * Example:
 * ```php
 * // 配列の再帰
 * $array = [];
 * $array['recursive'] = &$array;
 * assert(is_recursive($array) === true);
 * // オブジェクトの再帰
 * $object = new \stdClass();
 * $object->recursive = $object;
 * assert(is_recursive($object) === true);
 * ```
 *
 * @param mixed $var 調べる値
 * @return bool 再帰参照を含むなら true
 */
function is_recursive($var)
{
    $core = function ($var, $parents) use (&$core) {
        // 複合型でないなら間違いなく false
        if (is_primitive($var)) {
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
