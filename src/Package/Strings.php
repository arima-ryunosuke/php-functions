<?php

namespace ryunosuke\Functions\Package;

class Strings
{
    /**
     * 文字列結合の関数版
     *
     * Example:
     * <code>
     * assert(strcat('a', 'b', 'c') === 'abc');
     * </code>
     *
     * @package String
     *
     * @param mixed $variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    public static function strcat(...$variadic)
    {
        return implode('', $variadic);
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
     * <code>
     * assert(split_noempty(',', 'a, b, c')            === ['a', 'b', 'c']);
     * assert(split_noempty(',', 'a, , , b, c')        === ['a', 'b', 'c']);
     * assert(split_noempty(',', 'a, , , b, c', false) === ['a', ' ', ' ', ' b', ' c']);
     * </code>
     *
     * @package String
     *
     * @param string $delimiter 区切り文字
     * @param string $string 対象文字
     * @param string|bool $trimchars 指定した文字を trim する。true を指定すると trim する
     * @return array 指定文字で分割して空文字を除いた配列
     */
    public static function split_noempty($delimiter, $string, $trimchars = true)
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

    /**
     * 文字列比較の関数版
     *
     * 文字列以外が与えられた場合は常に false を返す。ただし __toString を実装したオブジェクトは別。
     *
     * Example:
     * <code>
     * assert(str_equals('abc', 'abc')       === true);
     * assert(str_equals('abc', 'ABC', true) === true);
     * assert(str_equals('\0abc', '\0abc')   === true);
     * </code>
     *
     * @package String
     *
     * @param string $str1 文字列1
     * @param string $str2 文字列2
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return bool 同じ文字列なら true
     */
    public static function str_equals($str1, $str2, $case_insensitivity = false)
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

    /**
     * 指定文字列を含むか返す
     *
     * Example:
     * <code>
     * assert(str_contains('abc', 'b')                      === true);
     * assert(str_contains('abc', 'B', true)                === true);
     * assert(str_contains('abc', ['b', 'x'], false, false) === true);
     * assert(str_contains('abc', ['b', 'x'], false, true)  === false);
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
    public static function str_contains($haystack, $needle, $case_insensitivity = false, $and_flag = false)
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
     * fputcsv の文字列版（str_getcsv の put 版）
     *
     * 特に難しいことはないシンプルな実装。ただし、エラーは例外に変換される。
     *
     * Example:
     * <code>
     * assert(str_putcsv(['a', 'b', 'c'])             === "a,b,c");
     * assert(str_putcsv(['a', 'b', 'c'], "\t")       === "a\tb\tc");
     * assert(str_putcsv(['a', ' b ', 'c'], " ", "'") === "a ' b ' c");
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
    public static function str_putcsv($array, $delimiter = ',', $enclosure = '"', $escape = "\\")
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

    /**
     * 指定文字列で始まるか調べる
     *
     * Example:
     * <code>
     * assert(starts_with('abcdef', 'abc')       === true);
     * assert(starts_with('abcdef', 'ABC', true) === true);
     * assert(starts_with('abcdef', 'xyz')       === false);
     * </code>
     *
     * @package String
     *
     * @param string $string 探される文字列
     * @param string $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return bool 指定文字列で始まるなら true を返す
     */
    public static function starts_with($string, $with, $case_insensitivity = false)
    {
        assert('is_string($string)');
        assert('is_string($with)');
        assert('strlen($with)');

        return call_user_func(str_equals, substr($string, 0, strlen($with)), $with, $case_insensitivity);
    }

    /**
     * 指定文字列で終わるか調べる
     *
     * Example:
     * <code>
     * assert(ends_with('abcdef', 'def')       === true);
     * assert(ends_with('abcdef', 'DEF', true) === true);
     * assert(ends_with('abcdef', 'xyz')       === false);
     * </code>
     *
     * @package String
     *
     * @param string $string 探される文字列
     * @param string $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を区別するか
     * @return bool 対象文字列で終わるなら true
     */
    public static function ends_with($string, $with, $case_insensitivity = false)
    {
        assert('is_string($string)');
        assert('is_string($with)');
        assert('strlen($with)');

        return call_user_func(str_equals, substr($string, -strlen($with)), $with, $case_insensitivity);
    }

    /**
     * camelCase に変換する
     *
     * Example:
     * <code>
     * assert(camel_case('this_is_a_pen') === 'thisIsAPen');
     * </code>
     *
     * @package String
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    public static function camel_case($string, $delimiter = '_')
    {
        return lcfirst(call_user_func(pascal_case, $string, $delimiter));
    }

    /**
     * PascalCase に変換する
     *
     * Example:
     * <code>
     * assert(pascal_case('this_is_a_pen') === 'ThisIsAPen');
     * </code>
     *
     * @package String
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    public static function pascal_case($string, $delimiter = '_')
    {
        return strtr(ucwords(strtr($string, [$delimiter => ' '])), [' ' => '']);
    }

    /**
     * snake_case に変換する
     *
     * Example:
     * <code>
     * assert(snake_case('ThisIsAPen') === 'this_is_a_pen');
     * </code>
     *
     * @package String
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    public static function snake_case($string, $delimiter = '_')
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', $delimiter . '\0', $string)), $delimiter);
    }

    /**
     * chain-case に変換する
     *
     * Example:
     * <code>
     * assert(chain_case('ThisIsAPen') === 'this-is-a-pen');
     * </code>
     *
     * @package String
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    public static function chain_case($string, $delimiter = '-')
    {
        return call_user_func(snake_case, $string, $delimiter);
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
     * @package String
     *
     * @param int $length 生成文字列長
     * @param string $charlist 使用する文字セット
     * @return string 乱数文字列
     */
    public static function random_string($length = 8, $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
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

    /**
     * 連想配列を指定できるようにした vsprintf
     *
     * sprintf の順序指定構文('%1$d')にキーを指定できる。
     *
     * Example:
     * <code>
     * assert(kvsprintf('%hoge$s %fuga$d', ['hoge' => 'ThisIs', 'fuga' => '3.14']) === 'ThisIs 3');
     * </code>
     *
     * @package String
     *
     * @param string $format フォーマット文字列
     * @param array $array フォーマット引数
     * @return string フォーマットされた文字列
     */
    public static function kvsprintf($format, array $array)
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
     * assert(preg_capture($pattern, '2014/12/24', $default) === [1 => '2014', 2 => '12', 4 => '24']);
     * // 最後の \d{1,2} はマッチしないのでデフォルト値が使われる
     * assert(preg_capture($pattern, '2014/12', $default)    === [1 => '2014', 2 => '12', 4 => '1']);
     * // 一切マッチしないので全てデフォルト値が使われる
     * assert(preg_capture($pattern, 'hoge', $default)       === [1 => '2000', 2 => '1', 4 => '1']);
     * </code>
     *
     * @package String
     *
     * @param string $pattern 正規表現
     * @param string $subject 対象文字列
     * @param array $default デフォルト値
     * @return array キャプチャした配列
     */
    public static function preg_capture($pattern, $subject, $default)
    {
        preg_match($pattern, $subject, $matches);

        foreach ($matches as $n => $match) {
            if (array_key_exists($n, $default) && strlen($match)) {
                $default[$n] = $match;
            }
        }

        return $default;
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
     * <code>
     * // 数値キーが参照できる
     * assert(render_string('${0}', ['number'])                                          === 'number');
     * // クロージャは呼び出し結果が埋め込まれる
     * assert(render_string('$c', ['c' => function($vars, $k){return $k . '-closure';}]) === 'c-closure');
     * // 引数をそのまま返すだけの特殊な変数 $_ が宣言される
     * assert(render_string('{$_(123 + 456)}', [])                                       === '579');
     * // 要するに '$_()' の中に php の式が書けるようになる
     * assert(render_string('{$_(implode(\',\', $strs))}', ['strs' => ['a', 'n', 'z']])  === 'a,n,z');
     * assert(render_string('{$_(max($nums))}', ['nums' => [1, 9, 3]])                   === '9');
     * </code>
     *
     * @package String
     *
     * @param string $template レンダリング文字列
     * @param array $array レンダリング変数
     * @return string レンダリングされた文字列
     */
    public static function render_string($template, $array)
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
     * @package String
     *
     * @see render_string
     *
     * @param string $template_file レンダリングするファイル名
     * @param array $array レンダリング変数
     * @return string レンダリングされた文字列
     */
    public static function render_file($template_file, $array)
    {
        return call_user_func(render_string, file_get_contents($template_file), $array);
    }
}
