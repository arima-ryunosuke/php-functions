<?php
/**
 * 文字列に関するユーティリティ
 *
 * @package string
 */

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
