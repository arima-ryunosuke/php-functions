<?php

namespace ryunosuke\Functions\Package;

/**
 * 文字列関連のユーティリティ
 */
class Strings
{
    /** json_*** 関数で $depth 引数を表す定数 */
    const JSON_MAX_DEPTH = -1;

    /**
     * 文字列結合の関数版
     *
     * Example:
     * ```php
     * that(strcat('a', 'b', 'c'))->isSame('abc');
     * ```
     *
     * @param mixed $variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    public static function strcat(...$variadic)
    {
        return implode('', $variadic);
    }

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
     * that(concat('prefix-', 'middle', '-suffix'))->isSame('prefix-middle-suffix');
     * that(concat('prefix-', '', '-suffix'))->isSame('');
     * ```
     *
     * @param mixed $variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    public static function concat(...$variadic)
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
     * that(split_noempty(',', 'a, b, c'))->isSame(['a', 'b', 'c']);
     * that(split_noempty(',', 'a, , , b, c'))->isSame(['a', 'b', 'c']);
     * that(split_noempty(',', 'a, , , b, c', false))->isSame(['a', ' ', ' ', ' b', ' c']);
     * ```
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
        $trim = ($trimchars === true) ? 'trim' : (rbind)('trim', $trimchars);
        $parts = explode($delimiter, $string);
        $parts = array_map($trim, $parts);
        $parts = array_filter($parts, 'strlen');
        $parts = array_values($parts);
        return $parts;
    }

    /**
     * explode の配列対応と $limit の挙動を変えたもの
     *
     * $delimiter には配列が使える。いわゆる「複数文字列での分割」の動作になる。
     *
     * $limit に負数を与えると「その絶対値-1までを結合したものと残り」を返す。
     * 端的に言えば「正数を与えると後詰めでその個数で返す」「負数を与えると前詰めでその（絶対値）個数で返す」という動作になる。
     *
     * Example:
     * ```php
     * // 配列を与えると複数文字列での分割
     * that(multiexplode([',', ' ', '|'], 'a,b c|d'))->isSame(['a', 'b', 'c', 'd']);
     * // 負数を与えると前詰め
     * that(multiexplode(',', 'a,b,c,d', -2))->isSame(['a,b,c', 'd']);
     * // もちろん上記2つは共存できる
     * that(multiexplode([',', ' ', '|'], 'a,b c|d', -2))->isSame(['a,b c', 'd']);
     * ```
     *
     * @param string|array $delimiter 分割文字列。配列可
     * @param string $string 対象文字列
     * @param int $limit 分割数
     * @return array 分割された配列
     */
    public static function multiexplode($delimiter, $string, $limit = \PHP_INT_MAX)
    {
        $limit = (int) $limit;
        if ($limit < 0) {
            // 下手に php で小細工するよりこうやって富豪的にやるのが一番速かった
            return array_reverse(array_map('strrev', (multiexplode)($delimiter, strrev($string), -$limit)));
        }
        // explode において 0 は 1 と等しい
        if ($limit === 0) {
            $limit = 1;
        }
        $delimiter = array_map(function ($v) { return preg_quote($v, '#'); }, (arrayize)($delimiter));
        return preg_split('#' . implode('|', $delimiter) . '#', $string, $limit);
    }

    /**
     * エスケープやクオートに対応した explode
     *
     * $enclosures は配列で開始・終了文字が別々に指定できるが、実装上の都合で今のところ1文字ずつのみ。
     *
     * 歴史的な理由により第3引数は $limit でも $enclosures でもどちらでも渡すことができる。
     *
     * Example:
     * ```php
     * // シンプルな例
     * that(quoteexplode(',', 'a,b,c\\,d,"e,f"'))->isSame([
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     'c\\,d', // \\ でエスケープしているので区切り文字とみなされない
     *     '"e,f"', // "" でクオートされているので区切り文字とみなされない
     * ]);
     *
     * // $enclosures で囲い文字の開始・終了文字を明示できる
     * that(quoteexplode(',', 'a,b,{e,f}', ['{' => '}']))->isSame([
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     '{e,f}', // { } で囲まれているので区切り文字とみなされない
     * ]);
     *
     * // このように第3引数に $limit 引数を差し込むことができる
     * that(quoteexplode(',', 'a,b,{e,f}', 2, ['{' => '}']))->isSame([
     *     'a',
     *     'b,{e,f}',
     * ]);
     * ```
     *
     * @param string|array $delimiter 分割文字列
     * @param string $string 対象文字列
     * @param int $limit 分割数。負数未対応
     * @param array|string $enclosures 囲い文字。 ["start" => "end"] で開始・終了が指定できる
     * @param string $escape エスケープ文字
     * @return array 分割された配列
     */
    public static function quoteexplode($delimiter, $string, $limit = null, $enclosures = "'\"", $escape = '\\')
    {
        // for compatible 1.3.x
        if (!is_int($limit) && $limit !== null) {
            if (func_num_args() > 3) {
                $escape = $enclosures;
            }
            $enclosures = $limit;
            $limit = PHP_INT_MAX;
        }

        if ($limit === null) {
            $limit = PHP_INT_MAX;
        }
        $limit = max(1, $limit);

        $delimiters = (arrayize)($delimiter);
        $current = 0;
        $result = [];
        for ($i = 0, $l = strlen($string); $i < $l; $i++) {
            if (count($result) === $limit - 1) {
                break;
            }
            $i = (strpos_quoted)($string, $delimiters, $i, $enclosures, $escape);
            if ($i === false) {
                break;
            }
            foreach ($delimiters as $delimiter) {
                $delimiterlen = strlen($delimiter);
                if (substr_compare($string, $delimiter, $i, $delimiterlen) === 0) {
                    $result[] = substr($string, $current, $i - $current);
                    $current = $i + $delimiterlen;
                    $i += $delimiterlen - 1;
                    break;
                }
            }
        }
        $result[] = substr($string, $current, $l);
        return $result;
    }

    /**
     * 文字列が最後に現れる位置以前を返す
     *
     * strstr の逆のイメージで文字列を後ろから探索する動作となる。
     * strstr の動作は「文字列を前から探索して指定文字列があったらそれ以後を返す」なので、
     * その逆の動作の「文字列を後ろから探索して指定文字列があったらそれ以前を返す」という挙動を示す。
     *
     * strstr の「needle が文字列でない場合は、 それを整数に変換し、その番号に対応する文字として扱います」は直感的じゃないので踏襲しない。
     * （全体的にこの動作をやめよう、という RFC もあったはず）。
     *
     * 第3引数の意味合いもデフォルト値も逆になるので、単純に呼べばよくある「指定文字列より後ろを（指定文字列を含めないで）返す」という動作になる。
     *
     * Example:
     * ```php
     * // パス中の最後のディレクトリを取得
     * that(strrstr("path/to/1:path/to/2:path/to/3", ":"))->isSame('path/to/3');
     * // $after_needle を false にすると逆の動作になる
     * that(strrstr("path/to/1:path/to/2:path/to/3", ":", false))->isSame('path/to/1:path/to/2:');
     * // （参考）strrchr と違い、文字列が使えるしその文字そのものは含まれない
     * that(strrstr("A\r\nB\r\nC", "\r\n"))->isSame('C');
     * ```
     *
     * @param string $haystack 調べる文字列
     * @param string $needle 検索文字列
     * @param bool $after_needle $needle より後ろを返すか
     * @return string
     */
    public static function strrstr($haystack, $needle, $after_needle = true)
    {
        // return strrev(strstr(strrev($haystack), strrev($needle), $after_needle));

        $lastpos = mb_strrpos($haystack, $needle);
        if ($lastpos === false) {
            return false;
        }

        if ($after_needle) {
            return mb_substr($haystack, $lastpos + mb_strlen($needle));
        }
        else {
            return mb_substr($haystack, 0, $lastpos + mb_strlen($needle));
        }
    }

    /**
     * 複数の文字列で strpos する
     *
     * $needles のそれぞれの位置を配列で返す。
     * ただし、見つからなかった文字は結果に含まれない。
     *
     * Example:
     * ```php
     * // 見つかった位置を返す
     * that(strpos_array('hello world', ['hello', 'world']))->isSame([
     *     0 => 0,
     *     1 => 6,
     * ]);
     * // 見つからない文字は含まれない
     * that(strpos_array('hello world', ['notfound', 'world']))->isSame([
     *     1 => 6,
     * ]);
     * ```
     *
     * @param string $haystack 対象文字列
     * @param iterable $needles 位置を取得したい文字列配列
     * @param int $offset 開始位置
     * @return array $needles それぞれの位置配列
     */
    public static function strpos_array($haystack, $needles, $offset = 0)
    {
        if ($offset < 0) {
            $offset += strlen($haystack);
        }

        $result = [];
        foreach ((arrayval)($needles) as $key => $needle) {
            $pos = strpos($haystack, $needle, $offset);
            if ($pos !== false) {
                $result[$key] = $pos;
            }
        }
        return $result;
    }

    /**
     * クオートを考慮して strpos する
     *
     * Example:
     * ```php
     * // クオート中は除外される
     * that(strpos_quoted('hello "this" is world', 'is'))->isSame(13);
     * // 開始位置やクオート文字は指定できる（5文字目以降の \* に囲まれていない hoge の位置を返す）
     * that(strpos_quoted('1:hoge, 2:*hoge*, 3:hoge', 'hoge', 5, '*'))->isSame(20);
     * ```
     *
     * @param string $haystack 対象文字列
     * @param string|iterable $needle 位置を取得したい文字列
     * @param int $offset 開始位置
     * @param string|array $enclosure 囲い文字。この文字中にいる $from, $to 文字は走査外になる
     * @param string $escape エスケープ文字。この文字が前にある $from, $to 文字は走査外になる
     * @return false|int $needle の位置
     */
    public static function strpos_quoted($haystack, $needle, $offset = 0, $enclosure = "'\"", $escape = '\\')
    {
        if (is_string($enclosure) || is_null($enclosure)) {
            if (strlen($enclosure)) {
                $chars = str_split($enclosure);
                $enclosure = array_combine($chars, $chars);
            }
            else {
                $enclosure = [];
            }
        }
        $needles = (arrayval)($needle);

        $strlen = strlen($haystack);

        if ($offset < 0) {
            $offset += $strlen;
        }

        $enclosing = [];
        for ($i = $offset; $i < $strlen; $i++) {
            if ($i !== 0 && $haystack[$i - 1] === $escape) {
                continue;
            }
            foreach ($enclosure as $start => $end) {
                if (substr_compare($haystack, $end, $i, strlen($end)) === 0) {
                    if ($enclosing && $enclosing[count($enclosing) - 1] === $end) {
                        array_pop($enclosing);
                        $i += strlen($end) - 1;
                        continue 2;
                    }
                }
                if (substr_compare($haystack, $start, $i, strlen($start)) === 0) {
                    $enclosing[] = $end;
                    $i += strlen($start) - 1;
                    continue 2;
                }
            }

            if (empty($enclosing)) {
                foreach ($needles as $needle) {
                    if (substr_compare($haystack, $needle, $i, strlen($needle)) === 0) {
                        return $i;
                    }
                }
            }
        }
        return false;
    }

    /**
     * 文字列が候補の中にあるか調べる
     *
     * 候補配列の中に対象文字列があるならそのキーを返す。ないなら null を返す。
     *
     * あくまで文字列としての比較に徹する（in_array/array_search の第3引数は厳密すぎて使いにくいことがある）。
     * ので array_search の文字列特化版とも言える。
     * 動作的には `array_flip($haystack)[$needle] ?? null` と同じ（大文字小文字オプションはあるけど）。
     * ただ array_flip は巨大配列に弱いし、大文字小文字などの融通が効かないので foreach での素朴な実装になっている。
     *
     * Example:
     * ```php
     * that(str_anyof('b', ['a', 'b', 'c']))->isSame(1);       // 見つかったキーを返す
     * that(str_anyof('x', ['a', 'b', 'c']))->isSame(null);    // 見つからないなら null を返す
     * that(str_anyof('C', ['a', 'b', 'c'], true))->isSame(2); // 大文字文字を区別しない
     * that(str_anyof('1', [1, 2, 3]))->isSame(0);             // 文字列の比較に徹する
     * that(str_anyof(2, ['1', '2', '3']))->isSame(1);         // 同上
     * ```
     *
     * @param string $needle 調べる文字列
     * @param iterable $haystack 候補配列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return bool 候補の中にあるならそのキー。無いなら null
     */
    public static function str_anyof($needle, $haystack, $case_insensitivity = false)
    {
        $needle = (string) $needle;
        foreach ($haystack as $k => $v) {
            if (!$case_insensitivity && strcmp($needle, $v) === 0) {
                return $k;
            }
            elseif ($case_insensitivity && strcasecmp($needle, $v) === 0) {
                return $k;
            }
        }
        return null;
    }

    /**
     * 文字列比較の関数版
     *
     * 文字列以外が与えられた場合は常に false を返す。ただし __toString を実装したオブジェクトは別。
     *
     * Example:
     * ```php
     * that(str_equals('abc', 'abc'))->isTrue();
     * that(str_equals('abc', 'ABC', true))->isTrue();
     * that(str_equals('\0abc', '\0abc'))->isTrue();
     * ```
     *
     * @param string $str1 文字列1
     * @param string $str2 文字列2
     * @param bool $case_insensitivity 大文字小文字を無視するか
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
     * ```php
     * that(str_contains('abc', 'b'))->isTrue();
     * that(str_contains('abc', 'B', true))->isTrue();
     * that(str_contains('abc', ['b', 'x'], false, false))->isTrue();
     * that(str_contains('abc', ['b', 'x'], false, true))->isFalse();
     * ```
     *
     * @param string $haystack 対象文字列
     * @param string|array $needle 調べる文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
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
     * 先頭・末尾の指定文字列を削ぎ落とす
     *
     * Example:
     * ```php
     * // 文字列からパス文字列と拡張子を削ぎ落とす
     * $PATH = '/path/to/something';
     * that(str_chop("$PATH/hoge.php", "$PATH/", '.php'))->isSame('hoge');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $prefix 削ぎ落とす先頭文字列
     * @param string $suffix 削ぎ落とす末尾文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 削ぎ落とした文字列
     */
    public static function str_chop($string, $prefix = null, $suffix = null, $case_insensitivity = false)
    {
        $pattern = [];
        if (strlen($prefix)) {
            $pattern[] = '(\A' . preg_quote($prefix, '#') . ')';
        }
        if (strlen($suffix)) {
            $pattern[] = '(' . preg_quote($suffix, '#') . '\z)';
        }
        $flag = 'u' . ($case_insensitivity ? 'i' : '');
        return preg_replace('#' . implode('|', $pattern) . '#' . $flag, '', $string);
    }

    /**
     * 先頭の指定文字列を削ぎ落とす
     *
     * Example:
     * ```php
     * // 文字列からパス文字列を削ぎ落とす
     * $PATH = '/path/to/something';
     * that(str_lchop("$PATH/hoge.php", "$PATH/"))->isSame('hoge.php');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $prefix 削ぎ落とす先頭文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 削ぎ落とした文字列
     */
    public static function str_lchop($string, $prefix, $case_insensitivity = false)
    {
        return (str_chop)($string, $prefix, null, $case_insensitivity);
    }

    /**
     * 末尾の指定文字列を削ぎ落とす
     *
     * Example:
     * ```php
     * // 文字列から .php を削ぎ落とす
     * $PATH = '/path/to/something';
     * that(str_rchop("$PATH/hoge.php", ".php"))->isSame("$PATH/hoge");
     * ```
     *
     * @param string $string 対象文字列
     * @param string $suffix 削ぎ落とす末尾文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 削ぎ落とした文字列
     */
    public static function str_rchop($string, $suffix = null, $case_insensitivity = false)
    {
        return (str_chop)($string, null, $suffix, $case_insensitivity);
    }

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
     * that(str_putcsv(['a', 'b', 'c']))->isSame("a,b,c");
     * that(str_putcsv(['a', 'b', 'c'], "\t"))->isSame("a\tb\tc");
     * that(str_putcsv(['a', ' b ', 'c'], " ", "'"))->isSame("a ' b ' c");
     *
     * // 複数行を返す
     * that(str_putcsv([['a', 'b', 'c'], ['d', 'e', 'f']]))->isSame("a,b,c\nd,e,f");
     * that(str_putcsv((function() {
     *     yield ['a', 'b', 'c'];
     *     yield ['d', 'e', 'f'];
     * })()))->isSame("a,b,c\nd,e,f");
     * ```
     *
     * @param iterable $array 値の配列 or 値の配列の配列
     * @param string $delimiter フィールド区切り文字
     * @param string $enclosure フィールドを囲む文字
     * @param string $escape エスケープ文字
     * @return string CSV 文字列
     */
    public static function str_putcsv($array, $delimiter = ',', $enclosure = '"', $escape = "\\")
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

    /**
     * 指定文字列を置換する
     *
     * $subject 内の $search を $replaces に置換する。
     * str_replace とは「N 番目のみ置換できる」点で異なる。
     * つまり、$search='hoge', $replace=[2 => 'fuga'] とすると「2 番目の 'hoge' が 'fuga' に置換される」という動作になる（0 ベース）。
     *
     * $replace に 非配列を与えた場合は配列化される。
     * つまり `$replaces = 'hoge'` は `$replaces = [0 => 'hoge']` と同じ（最初のマッチを置換する）。
     *
     * $replace に空配列を与えると何もしない。
     * 負数キーは後ろから数える動作となる。
     * また、置換後の文字列は置換対象にはならない。
     *
     * N 番目の検索文字列が見つからない場合は例外を投げる。
     * ただし、文字自体が見つからない場合は投げない。
     *
     * Example:
     * ```php
     * // 1番目（0ベースなので2番目）の x を X に置換
     * that(str_subreplace('xxx', 'x', [1 => 'X']))->isSame('xXx');
     * // 0番目（最前列）の x を Xa に、-1番目（最後尾）の x を Xz に置換
     * that(str_subreplace('!xxx!', 'x', [0 => 'Xa', -1 => 'Xz']))->isSame('!XaxXz!');
     * // 置換結果は置換対象にならない
     * that(str_subreplace('xxx', 'x', [0 => 'xxx', 1 => 'X']))->isSame('xxxXx');
     * ```
     *
     * @param string $subject 対象文字列
     * @param string $search 検索文字列
     * @param array|string $replaces 置換文字列配列（単一指定は配列化される）
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 置換された文字列
     */
    public static function str_subreplace($subject, $search, $replaces, $case_insensitivity = false)
    {
        $replaces = is_iterable($replaces) ? $replaces : [$replaces];

        // 空はそのまま返す
        if ((is_empty)($replaces)) {
            return $subject;
        }

        // 負数対応のために逆数計算（ついでに整数チェック）
        $subcount = $case_insensitivity ? substr_count(strtolower($subject), strtolower($search)) : substr_count($subject, $search);
        if ($subcount === 0) {
            return $subject;
        }
        $mapping = [];
        foreach ($replaces as $n => $replace) {
            $origN = $n;
            if (!is_int($n)) {
                throw new \InvalidArgumentException('$replaces key must be integer.');
            }
            if ($n < 0) {
                $n += $subcount;
            }
            if (!(0 <= $n && $n < $subcount)) {
                throw new \InvalidArgumentException("notfound search string '$search' of {$origN}th.");
            }
            $mapping[$n] = $replace;
        }
        $maxseq = max(array_keys($mapping));
        $offset = 0;
        for ($n = 0; $n <= $maxseq; $n++) {
            $pos = $case_insensitivity ? stripos($subject, $search, $offset) : strpos($subject, $search, $offset);
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

    /**
     * 指定文字列を置換する
     *
     * $subject を $replaces に従って置換する。
     * 具体的には「$replaces を 複数指定できる str_subreplace」に近い。
     *
     * strtr とは「N 番目のみ置換できる」点で異なる。
     * つまり、$replaces=['hoge' => [2 => 'fuga']] とすると「2 番目の 'hoge' が 'fuga' に置換される」という動作になる（0 ベース）。
     *
     * $replaces の要素に非配列を与えた場合は配列化される。
     * つまり `$replaces = ['hoge' => 'fuga']` は `$replaces = ['hoge' => ['fuga']]` と同じ（最初のマッチを置換する）。
     *
     * $replace に空配列を与えると何もしない。
     * 負数キーは後ろから数える動作となる。
     * また、置換後の文字列は置換対象にはならない。
     *
     * N 番目の検索文字列が見つからない場合は例外を投げる。
     * ただし、文字自体が見つからない場合は投げない。
     *
     * Example:
     * ```php
     * // "hello, world" の l と o を置換
     * that(str_submap('hello, world', [
     *     // l は0番目と2番目のみを置換（1番目は何も行われない）
     *     'l' => [
     *         0 => 'L1',
     *         2 => 'L3',
     *     ],
     *     // o は後ろから数えて1番目を置換
     *     'o' => [
     *         -1 => 'O',
     *     ],
     * ]))->isSame('heL1lo, wOrL3d');
     * ```
     *
     * @param string $subject 対象文字列
     * @param array $replaces 読み換え配列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 置換された文字列
     */
    public static function str_submap($subject, $replaces, $case_insensitivity = false)
    {
        assert(is_iterable($replaces));

        $isubject = $subject;
        if ($case_insensitivity) {
            $isubject = strtolower($isubject);
        }

        // 負数対応のために逆数計算（ついでに整数チェック）
        $mapping = [];
        foreach ($replaces as $from => $map) {
            $ifrom = $from;
            if ($case_insensitivity) {
                $ifrom = strtolower($ifrom);
            }
            $subcount = substr_count($isubject, $ifrom);
            if ($subcount === 0) {
                continue;
            }
            $mapping[$ifrom] = [];
            $map = is_iterable($map) ? $map : [$map];
            foreach ($map as $n => $to) {
                $origN = $n;
                if (!is_int($n)) {
                    throw new \InvalidArgumentException('$replaces key must be integer.');
                }
                if ($n < 0) {
                    $n += $subcount;
                }
                if (!(0 <= $n && $n < $subcount)) {
                    throw new \InvalidArgumentException("notfound search string '$from' of {$origN}th.");
                }
                $mapping[$ifrom][$n] = $to;
            }
        }

        // 空はそのまま返す
        if ((is_empty)($mapping)) {
            return $subject;
        }

        // いろいろ試した感じ正規表現が最もシンプルかつ高速だった

        $repkeys = array_keys($mapping);
        $counter = array_fill_keys($repkeys, 0);
        $patterns = array_map(function ($k) { return preg_quote($k, '#'); }, $repkeys);

        $i_flag = $case_insensitivity ? 'i' : '';
        return preg_replace_callback("#" . implode('|', $patterns) . "#u$i_flag", function ($matches) use (&$counter, $mapping, $case_insensitivity) {
            $imatch = $matches[0];
            if ($case_insensitivity) {
                $imatch = strtolower($imatch);
            }
            $index = $counter[$imatch]++;
            if (array_key_exists($index, $mapping[$imatch])) {
                return $mapping[$imatch][$index];
            }
            return $matches[0];
        }, $subject);
    }

    /**
     * エスケープ付きで文字列を置換する
     *
     * $replacemap で from -> to 文字列を指定する。
     * to は文字列と配列を受け付ける。
     * 文字列の場合は普通に想起される動作で単純な置換となる。
     * 配列の場合は順次置換していく。要素が足りなくなったら例外を投げる。
     *
     * strtr と同様、最も長いキーから置換を行い、置換後の文字列は対象にならない。
     *
     * $enclosure で「特定文字に囲まれている」場合を無視することができる。
     * $escape で「特定文字が前にある」場合を無視することができる。
     *
     * Example:
     * ```php
     * // 最も単純な置換
     * that(str_embed('a, b, c', ['a' => 'A', 'b' => 'B', 'c' => 'C']))->isSame('A, B, C');
     * // 最も長いキーから置換される
     * that(str_embed('abc', ['a' => 'X', 'ab' => 'AB']))->isSame('ABc');
     * // 配列を渡すと「N番目の置換」が実現できる（文字列の場合は再利用される）
     * that(str_embed('a, a, b, b', [
     *     'a' => 'A',          // 全ての a が A になる
     *     'b' => ['B1', 'B2'], // 1番目の b が B1, 2番目の b が B2 になる
     * ]))->isSame('A, A, B1, B2');
     * // 最も重要な性質として "' で囲まれていると対象にならない
     * that(str_embed('a, "a", b, "b", b', [
     *     'a' => 'A',
     *     'b' => ['B1', 'B2'],
     * ]))->isSame('A, "a", B1, "b", B2');
     * ```
     *
     * @param string $string 対象文字列
     * @param array $replacemap 置換文字列
     * @param string|array $enclosure 囲い文字。この文字中にいる $from, $to 文字は走査外になる
     * @param string $escape エスケープ文字。この文字が前にある $from, $to 文字は走査外になる
     * @return string 置換された文字列
     */
    public static function str_embed($string, $replacemap, $enclosure = "'\"", $escape = '\\')
    {
        assert(is_iterable($replacemap));

        $string = (string) $string;

        // 長いキーから処理するためソートしておく
        $replacemap = (arrayval)($replacemap, false);
        uksort($replacemap, function ($a, $b) { return strlen($b) - strlen($a); });
        $srcs = array_keys($replacemap);

        $counter = array_fill_keys(array_keys($replacemap), 0);
        for ($i = 0; $i < strlen($string); $i++) {
            $i = (strpos_quoted)($string, $srcs, $i, $enclosure, $escape);
            if ($i === false) {
                break;
            }

            foreach ($replacemap as $src => $dst) {
                $srclen = strlen($src);
                if ($srclen === 0) {
                    throw new \InvalidArgumentException("src length is 0.");
                }
                if (substr_compare($string, $src, $i, $srclen) === 0) {
                    if (is_array($dst)) {
                        $n = $counter[$src]++;
                        if (!isset($dst[$n])) {
                            throw new \InvalidArgumentException("notfound search string '$src' of {$n}th.");
                        }
                        $dst = $dst[$n];
                    }
                    $string = substr_replace($string, $dst, $i, $srclen);
                    $i += strlen($dst) - 1;
                    break;
                }
            }
        }
        return $string;
    }

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
     * that(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n))->isSame('first');
     * that(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n))->isSame('second');
     * that(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n))->isSame('third');
     * // ネストしている場合は最も外側を返す
     * that(str_between('{nest1{nest2{nest3}}}', '{', '}'))->isSame('nest1{nest2{nest3}}');
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
    public static function str_between($string, $from, $to, &$position = 0, $enclosure = '\'"', $escape = '\\')
    {
        $strlen = strlen($string);
        $fromlen = strlen($from);
        $tolen = strlen($to);
        $position = intval($position);
        $nesting = 0;
        $start = null;
        for ($i = $position; $i < $strlen; $i++) {
            $i = (strpos_quoted)($string, [$from, $to], $i, $enclosure, $escape);
            if ($i === false) {
                break;
            }

            // 開始文字と終了文字が重複している可能性があるので $to からチェックする
            if (substr_compare($string, $to, $i, $tolen) === 0) {
                if (--$nesting === 0) {
                    $position = $i + $tolen;
                    return substr($string, $start, $i - $start);
                }
                // いきなり終了文字が来た場合は無視する
                if ($nesting < 0) {
                    $nesting = 0;
                }
            }
            if (substr_compare($string, $from, $i, $fromlen) === 0) {
                if ($nesting++ === 0) {
                    $start = $i + $fromlen;
                }
            }
        }
        return false;
    }

    /**
     * 文字列を指定幅に丸める
     *
     * mb_strimwidth と機能的には同じだが、省略文字の差し込み位置を $pos で指定できる。
     * $pos は負数が指定できる。負数の場合後ろから数えられる。
     * 省略した場合は真ん中となる。
     *
     * Example:
     * ```php
     * // 8文字に丸める（$pos 省略なので真ん中が省略される）
     * that(str_ellipsis('1234567890', 8, '...'))->isSame('12...890');
     * // 8文字に丸める（$pos=1 なので1文字目から省略される）
     * that(str_ellipsis('1234567890', 8, '...', 1))->isSame('1...7890');
     * // 8文字に丸める（$pos=-1 なので後ろから1文字目から省略される）
     * that(str_ellipsis('1234567890', 8, '...', -1))->isSame('1234...0');
     * ```
     *
     * @param string $string 対象文字列
     * @param int $width 丸める幅
     * @param string $trimmarker 省略文字列
     * @param int|null $pos 省略記号の差し込み位置
     * @return string 丸められた文字列
     */
    public static function str_ellipsis($string, $width, $trimmarker = '...', $pos = null)
    {
        $string = (string) $string;

        $strlen = mb_strlen($string);
        if ($strlen <= $width) {
            return $string;
        }

        $markerlen = mb_strlen($trimmarker);
        if ($markerlen >= $width) {
            return $trimmarker;
        }

        $length = $width - $markerlen;
        $pos = $pos ?? $length / 2;
        if ($pos < 0) {
            $pos += $length;
        }
        $pos = max(0, min($pos, $length));

        return (mb_substr_replace)($string, $trimmarker, $pos, $strlen - $length);
    }

    /**
     * テキストの diff を得る
     *
     * `$options['iignore-case'] = true` で大文字小文字を無視する。
     * `$options['ignore-space-change'] = true` 空白文字の数を無視する。
     * `$options['ignore-all-space'] = true` ですべての空白文字を無視する
     * `$options['stringify']` で差分データを文字列化するクロージャを指定する。
     *
     * - normal: 標準形式（diff のオプションなしに相当する）
     * - context: コンテキスト形式（context=3 のような形式で diff の -C 3 に相当する）
     * - unified: ユニファイド形式（unified=3 のような形式で diff の -U 3 に相当する）
     *     - unified のみを指定するとヘッダを含まない +- のみの差分を出す
     * - html: ins, del の html タグ形式
     *     - html=perline とすると行レベルでの差分も出す
     *
     * Example:
     * ```php
     * // 前文字列
     * $old = 'same
     * delete
     * same
     * same
     * change
     * ';
     * // 後文字列
     * $new = 'same
     * same
     * append
     * same
     * this is changed line
     * ';
     * // シンプルな差分テキストを返す
     * that(str_diff($old, $new))->isSame(' same
     * -delete
     *  same
     * +append
     *  same
     * -change
     * +this is changed line
     * ');
     * // html で差分を返す
     * that(str_diff($old, $new, ['stringify' => 'html']))->isSame('same
     * <del>delete</del>
     * same
     * <ins>append</ins>
     * same
     * <del>change</del>
     * <ins>this is changed line</ins>
     * ');
     * // 行レベルの html で差分を返す
     * that(str_diff($old, $new, ['stringify' => 'html=perline']))->isSame('same
     * <del>delete</del>
     * same
     * <ins>append</ins>
     * same
     * <ins>this is </ins>chang<ins>ed lin</ins>e
     * ');
     * // raw な配列で差分を返す
     * that(str_diff($old, $new, ['stringify' => null]))->isSame([
     *     // 等価行（'=' という記号と前後それぞれの文字列を返す（キーは行番号））
     *     ['=', [0 => 'same'], [0 => 'same']],
     *     // 削除行（'-' という記号と前の文字列を返す（キーは行番号）、後は int で行番号のみ）
     *     ['-', [1 => 'delete'], 0],
     *     // 等価行
     *     ['=', [2 => 'same'], [1 => 'same']],
     *     // 追加行（'+' という記号と後の文字列を返す（キーは行番号）、前は int で行番号のみ）
     *     ['+', 2, [2 => 'append']],
     *     // 等価行
     *     ['=', [3 => 'same'], [3 => 'same']],
     *     // 変更行（'*' という記号と前後それぞれの文字列を返す（キーは行番号））
     *     ['*', [4 => 'change'], [4 => 'this is changed line']],
     * ]);
     * ```
     *
     * @param string|array $xstring 元文字列
     * @param string|array $ystring 比較文字列
     * @param array $options オプション配列
     * @return string|array 差分テキスト。 stringify が null の場合は raw な差分配列
     */
    public static function str_diff($xstring, $ystring, $options = [])
    {
        $options += [
            'ignore-case'         => false,
            'ignore-space-change' => false,
            'ignore-all-space'    => false,
            'stringify'           => 'unified',
        ];

        $xstring = is_array($xstring) ? array_values($xstring) : preg_split('#\R#u', $xstring);
        $ystring = is_array($ystring) ? array_values($ystring) : preg_split('#\R#u', $ystring);
        $trailingN = "";
        if ($xstring[count($xstring) - 1] === '' && $ystring[count($ystring) - 1] === '') {
            $trailingN = "\n";
            array_pop($xstring);
            array_pop($ystring);
        }

        $getdiff = function (array $xarray, array $yarray, $converter) {
            $lcs = function (array $xarray, array $yarray) use (&$lcs) {
                $length = function (array $xarray, array $yarray) {
                    $xcount = count($xarray);
                    $ycount = count($yarray);
                    $current = array_fill(0, $ycount + 1, 0);
                    for ($i = 0; $i < $xcount; $i++) {
                        $prev = $current;
                        for ($j = 0; $j < $ycount; $j++) {
                            $current[$j + 1] = $xarray[$i] === $yarray[$j] ? $prev[$j] + 1 : max($current[$j], $prev[$j + 1]);
                        }
                    }
                    return $current;
                };

                $xcount = count($xarray);
                $ycount = count($yarray);
                if ($xcount === 0) {
                    return [];
                }
                if ($xcount === 1) {
                    if (in_array($xarray[0], $yarray, true)) {
                        return [$xarray[0]];
                    }
                    return [];
                }
                $i = (int) ($xcount / 2);
                $xprefix = array_slice($xarray, 0, $i);
                $xsuffix = array_slice($xarray, $i);
                $llB = $length($xprefix, $yarray);
                $llE = $length(array_reverse($xsuffix), array_reverse($yarray));
                $jMax = 0;
                $max = 0;
                for ($j = 0; $j <= $ycount; $j++) {
                    $m = $llB[$j] + $llE[$ycount - $j];
                    if ($m >= $max) {
                        $max = $m;
                        $jMax = $j;
                    }
                }
                $yprefix = array_slice($yarray, 0, $jMax);
                $ysuffix = array_slice($yarray, $jMax);
                return array_merge($lcs($xprefix, $yprefix), $lcs($xsuffix, $ysuffix));
            };

            $xarray2 = array_map($converter, $xarray);
            $yarray2 = array_map($converter, $yarray);
            $xcount = count($xarray2);
            $ycount = count($yarray2);

            $head = [];
            reset($yarray2);
            foreach ($xarray2 as $xk => $xv) {
                $yk = key($yarray2);
                if ($yk !== $xk || $xv !== $yarray2[$xk]) {
                    break;
                }
                $head[$xk] = $xv;
                unset($xarray2[$xk], $yarray2[$xk]);
            }

            $tail = [];
            end($xarray2);
            end($yarray2);
            do {
                $xk = key($xarray2);
                $yk = key($yarray2);
                if (null === $xk || null === $yk || current($xarray2) !== current($yarray2)) {
                    break;
                }
                prev($xarray2);
                prev($yarray2);
                $tail = [$xk - $xcount => $xarray2[$xk]] + $tail;
                unset($xarray2[$xk], $yarray2[$yk]);
            } while (true);

            $common = $lcs(array_values($xarray2), array_values($yarray2));

            $xchanged = $ychanged = [];
            foreach ($head as $n => $line) {
                $xchanged[$n] = false;
                $ychanged[$n] = false;
            }
            foreach ($common as $line) {
                foreach ($xarray2 as $n => $l) {
                    unset($xarray2[$n]);
                    $xchanged[$n] = $line !== $l;
                    if (!$xchanged[$n]) {
                        break;
                    }
                }
                foreach ($yarray2 as $n => $l) {
                    unset($yarray2[$n]);
                    $ychanged[$n] = $line !== $l;
                    if (!$ychanged[$n]) {
                        break;
                    }
                }
            }
            foreach ($xarray2 as $n => $line) {
                $xchanged[$n] = true;
            }
            foreach ($yarray2 as $n => $line) {
                $ychanged[$n] = true;
            }
            foreach ($tail as $n => $line) {
                $xchanged[$n + $xcount] = false;
                $ychanged[$n + $ycount] = false;
            }

            $diffs = [];
            $xi = $yi = 0;
            while ($xi < $xcount || $yi < $ycount) {
                for ($xequal = [], $yequal = []; $xi < $xcount && $yi < $ycount && !$xchanged[$xi] && !$ychanged[$yi]; $xi++, $yi++) {
                    $xequal[$xi] = $xarray[$xi];
                    $yequal[$yi] = $yarray[$yi];
                }
                for ($delete = []; $xi < $xcount && $xchanged[$xi]; $xi++) {
                    $delete[$xi] = $xarray[$xi];
                }
                for ($append = []; $yi < $ycount && $ychanged[$yi]; $yi++) {
                    $append[$yi] = $yarray[$yi];
                }

                if ($xequal && $yequal) {
                    $diffs[] = ['=', $xequal, $yequal];
                }
                if ($delete && $append) {
                    $diffs[] = ['*', $delete, $append];
                }
                elseif ($delete) {
                    $diffs[] = ['-', $delete, $yi - 1];
                }
                elseif ($append) {
                    $diffs[] = ['+', $xi - 1, $append];
                }
            }
            return $diffs;
        };

        $diffs = $getdiff($xstring, $ystring, function ($string) use ($options) {
            if ($options['ignore-case']) {
                $string = strtoupper($string);
            }
            if ($options['ignore-space-change']) {
                $string = preg_replace('#\s+#u', ' ', $string);
            }
            if ($options['ignore-all-space']) {
                $string = preg_replace('#\s+#u', '', $string);
            }
            return $string;
        });

        if (!$options['stringify']) {
            return $diffs;
        }

        $htmlescape = function ($v) use (&$htmlescape) {
            return is_array($v) ? array_map($htmlescape, $v) : htmlspecialchars($v, ENT_QUOTES);
        };
        $prefixjoin = function ($prefix, $array, $glue) {
            return implode($glue, array_map(function ($v) use ($prefix) { return $prefix . $v; }, $array));
        };
        $minmaxlen = function ($diffs) {
            $xmin = $ymin = PHP_INT_MAX;
            $xmax = $ymax = -1;
            $xlen = $ylen = 0;
            foreach ($diffs as $diff) {
                $xargs = (is_array($diff[1]) ? array_keys($diff[1]) : [$diff[1]]);
                $yargs = (is_array($diff[2]) ? array_keys($diff[2]) : [$diff[2]]);
                $xmin = min($xmin, ...$xargs);
                $ymin = min($ymin, ...$yargs);
                $xmax = max($xmax, ...$xargs);
                $ymax = max($ymax, ...$yargs);
                $xlen += is_array($diff[1]) ? count($diff[1]) : 0;
                $ylen += is_array($diff[2]) ? count($diff[2]) : 0;
            }
            if ($xmin === -1 && $xlen > 0) {
                $xmin = 0;
            }
            if ($ymin === -1 && $ylen > 0) {
                $ymin = 0;
            }
            return [$xmin + 1, $xmax + 1, $xlen, $ymin + 1, $ymax + 1, $ylen];
        };

        $block_size = null;

        if (is_string($options['stringify']) && preg_match('#html(=(.+))?#', $options['stringify'], $m)) {
            $mode = $m[2] ?? null;
            $options['stringify'] = function ($diffs) use ($htmlescape, $mode, $options) {
                $taging = function ($tag, $content) { return strlen($tag) && strlen($content) ? "<$tag>$content</$tag>" : $content; };
                $rule = [
                    '+' => [2 => 'ins'],
                    '-' => [1 => 'del'],
                    '*' => [1 => 'del', 2 => 'ins'],
                    '=' => [1 => null],
                ];
                $result = [];
                foreach ($diffs as $diff) {
                    if ($mode === 'perline' && $diff[0] === '*') {
                        $length = min(count($diff[1]), count($diff[2]));
                        $delete = array_splice($diff[1], 0, $length, []);
                        $append = array_splice($diff[2], 0, $length, []);
                        for ($i = 0; $i < $length; $i++) {
                            $options2 = ['stringify' => null] + $options;
                            $diffs2 = (str_diff)(preg_split('/(?<!^)(?!$)/u', $delete[$i]), preg_split('/(?<!^)(?!$)/u', $append[$i]), $options2);
                            $result2 = [];
                            foreach ($diffs2 as $diff2) {
                                foreach ($rule[$diff2[0]] as $n => $tag) {
                                    $content = $taging($tag, implode("", $htmlescape($diff2[$n])));
                                    if (strlen($content)) {
                                        $result2[] = $content;
                                    }
                                }
                            }
                            $result[] = implode("", $result2);
                        }
                    }
                    foreach ($rule[$diff[0]] as $n => $tag) {
                        $content = $taging($tag, implode("\n", $htmlescape($diff[$n])));
                        if ($diff[0] === '=' && !strlen($content)) {
                            $result[] = "";
                        }
                        if (strlen($content)) {
                            $result[] = $content;
                        }
                    }
                }
                return implode("\n", $result);
            };
        }

        if ($options['stringify'] === 'normal') {
            $options['stringify'] = function ($diffs) use ($prefixjoin) {
                $index = function ($v) {
                    if (!is_array($v)) {
                        return $v + 1;
                    }
                    $keys = array_keys($v);
                    $s = reset($keys) + 1;
                    $e = end($keys) + 1;
                    return $s === $e ? "$s" : "$s,$e";
                };

                $rule = [
                    '+' => ['a', [2 => '> ']],
                    '-' => ['d', [1 => '< ']],
                    '*' => ['c', [1 => '< ', 2 => '> ']],
                ];
                $result = [];
                foreach ($diffs as $diff) {
                    if (isset($rule[$diff[0]])) {
                        $difftext = [];
                        foreach ($rule[$diff[0]][1] as $n => $sign) {
                            $difftext[] = $prefixjoin($sign, $diff[$n], "\n");
                        }
                        $result[] = "{$index($diff[1])}{$rule[$diff[0]][0]}{$index($diff[2])}";
                        $result[] = implode("\n---\n", $difftext);
                    }
                }
                return implode("\n", $result);
            };
        }

        if (is_string($options['stringify']) && preg_match('#context(=(\d+))?#', $options['stringify'], $m)) {
            $block_size = (int) ($m[2] ?? 3);
            $options['stringify'] = function ($diffs) use ($prefixjoin, $minmaxlen) {
                $result = ["***************"];

                [$xmin, $xmax, , $ymin, $ymax,] = $minmaxlen($diffs);
                $xheader = $xmin === $xmax ? "$xmin" : "$xmin,$xmax";
                $yheader = $ymin === $ymax ? "$ymin" : "$ymin,$ymax";

                $rules = [
                    '-*' => [
                        'header' => "*** {$xheader} ****",
                        '-'      => [1 => '- '],
                        '*'      => [1 => '! '],
                        '='      => [1 => '  '],
                    ],
                    '+*' => [
                        'header' => "--- {$yheader} ----",
                        '+'      => [2 => '+ '],
                        '*'      => [2 => '! '],
                        '='      => [2 => '  '],
                    ],
                ];
                foreach ($rules as $key => $rule) {
                    $result[] = $rule['header'];
                    if (array_filter($diffs, function ($d) use ($key) { return strpos($key, $d[0]) !== false; })) {
                        foreach ($diffs as $diff) {
                            foreach ($rule[$diff[0]] ?? [] as $n => $sign) {
                                $result[] = $prefixjoin($sign, $diff[$n], "\n");
                            }
                        }
                    }
                }
                return implode("\n", $result);
            };
        }

        if (is_string($options['stringify']) && preg_match('#unified(=(\d+))?#', $options['stringify'], $m)) {
            $block_size = isset($m[2]) ? (int) $m[2] : null;
            $options['stringify'] = function ($diffs) use ($prefixjoin, $minmaxlen, $block_size) {
                $result = [];

                if ($block_size !== null) {
                    [$xmin, , $xlen, $ymin, , $ylen] = $minmaxlen($diffs);
                    $xheader = $xlen === 1 ? "$xmin" : "$xmin,$xlen";
                    $yheader = $ylen === 1 ? "$ymin" : "$ymin,$ylen";
                    $result[] = "@@ -{$xheader} +{$yheader} @@";
                }

                $rule = [
                    '+' => [2 => '+'],
                    '-' => [1 => '-'],
                    '*' => [1 => '-', 2 => '+'],
                    '=' => [1 => ' '],
                ];
                foreach ($diffs as $diff) {
                    foreach ($rule[$diff[0]] as $n => $sign) {
                        $result[] = $prefixjoin($sign, $diff[$n], "\n");
                    }
                }
                return implode("\n", $result);
            };
        }

        if (!strlen($block_size)) {
            $result = $options['stringify']($diffs);
            if (strlen($result)) {
                $result .= $trailingN;
            }
            return $result;
        }

        $head = function ($array) use ($block_size) { return array_slice($array, 0, $block_size, true); };
        $tail = function ($array) use ($block_size) { return array_slice($array, -$block_size, null, true); };

        $blocks = [];
        $block = [];
        $last = count($diffs) - 1;
        foreach ($diffs as $n => $diff) {
            if ($diff[0] !== '=') {
                $block[] = $diff;
                continue;
            }

            if (!$block) {
                if ($block_size) {
                    $block[] = ['=', $tail($diff[1]), $tail($diff[2])];
                }
            }
            elseif ($last === $n) {
                if ($block_size) {
                    $block[] = ['=', $head($diff[1]), $head($diff[2])];
                }
            }
            elseif (count($diff[1]) > $block_size * 2) {
                if ($block_size) {
                    $block[] = ['=', $head($diff[1]), $head($diff[2])];
                }
                $blocks[] = $block;
                $block = [];
                if ($block_size) {
                    $block[] = ['=', $tail($diff[1]), $tail($diff[2])];
                }
            }
            else {
                if ($block_size) {
                    $block[] = $diff;
                }
            }
        }
        if (trim(implode('', array_column($block, 0)), '=')) {
            $blocks[] = $block;
        }

        $result = implode("\n", array_map($options['stringify'], $blocks));
        if (strlen($result)) {
            $result .= $trailingN;
        }
        return $result;
    }

    /**
     * 指定文字列で始まるか調べる
     *
     * $with に配列を渡すといずれかで始まるときに true を返す。
     *
     * Example:
     * ```php
     * that(starts_with('abcdef', 'abc'))->isTrue();
     * that(starts_with('abcdef', 'ABC', true))->isTrue();
     * that(starts_with('abcdef', 'xyz'))->isFalse();
     * that(starts_with('abcdef', ['a', 'b', 'c']))->isTrue();
     * that(starts_with('abcdef', ['x', 'y', 'z']))->isFalse();
     * ```
     *
     * @param string $string 探される文字列
     * @param string|array $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return bool 指定文字列で始まるなら true を返す
     */
    public static function starts_with($string, $with, $case_insensitivity = false)
    {
        assert(is_string($string));

        foreach ((array) $with as $w) {
            assert(is_string($w));
            assert(strlen($w));

            if ((str_equals)(substr($string, 0, strlen($w)), $w, $case_insensitivity)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 指定文字列で終わるか調べる
     *
     * $with に配列を渡すといずれかで終わるときに true を返す。
     *
     * Example:
     * ```php
     * that(ends_with('abcdef', 'def'))->isTrue();
     * that(ends_with('abcdef', 'DEF', true))->isTrue();
     * that(ends_with('abcdef', 'xyz'))->isFalse();
     * that(ends_with('abcdef', ['d', 'e', 'f']))->isTrue();
     * that(ends_with('abcdef', ['x', 'y', 'z']))->isFalse();
     * ```
     *
     * @param string $string 探される文字列
     * @param string $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return bool 対象文字列で終わるなら true
     */
    public static function ends_with($string, $with, $case_insensitivity = false)
    {
        assert(is_string($string));

        foreach ((array) $with as $w) {
            assert(is_string($w));
            assert(strlen($w));

            if ((str_equals)(substr($string, -strlen($w)), $w, $case_insensitivity)) {
                return true;
            }
        }
        return false;
    }

    /**
     * camelCase に変換する
     *
     * Example:
     * ```php
     * that(camel_case('this_is_a_pen'))->isSame('thisIsAPen');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    public static function camel_case($string, $delimiter = '_')
    {
        return lcfirst((pascal_case)($string, $delimiter));
    }

    /**
     * PascalCase に変換する
     *
     * Example:
     * ```php
     * that(pascal_case('this_is_a_pen'))->isSame('ThisIsAPen');
     * ```
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
     * ```php
     * that(snake_case('ThisIsAPen'))->isSame('this_is_a_pen');
     * ```
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
     * ```php
     * that(chain_case('ThisIsAPen'))->isSame('this-is-a-pen');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    public static function chain_case($string, $delimiter = '-')
    {
        return (snake_case)($string, $delimiter);
    }

    /**
     * 文字列を名前空間とローカル名に区切ってタプルで返す
     *
     * class_namespace/class_shorten や function_shorten とほぼ同じだが下記の違いがある。
     *
     * - あくまで文字列として処理する
     *     - 例えば class_namespace は get_class されるが、この関数は（いうなれば） strval される
     * - \\ を trim しないし、特別扱いもしない
     *     - `ns\\hoge` と `\\ns\\hoge` で返り値が微妙に異なる
     *     - `ns\\` のような場合は名前空間だけを返す
     *
     * Example:
     * ```php
     * that(namespace_split('ns\\hoge'))->isSame(['ns', 'hoge']);
     * that(namespace_split('hoge'))->isSame(['', 'hoge']);
     * that(namespace_split('ns\\'))->isSame(['ns', '']);
     * that(namespace_split('\\hoge'))->isSame(['', 'hoge']);
     * ```
     *
     * @param string $string 対象文字列
     * @return array [namespace, localname]
     */
    public static function namespace_split($string)
    {
        $pos = strrpos($string, '\\');
        if ($pos === false) {
            return ['', $string];
        }
        return [substr($string, 0, $pos), substr($string, $pos + 1)];
    }

    /**
     * css セレクタから html 文字列を生成する
     *
     * `tag#id.class[attr=value]` のような css セレクタから `<tag id="id" class="class" attr="value"></tag>` のような html 文字列を返す。
     * 配列を与えるとキーがセレクタ、値がコンテント文字列になる。
     * さらに値が配列だと再帰して生成する。
     *
     * 値や属性は適切に htmlspecialchars される。
     *
     * Example:
     * ```php
     * // 単純文字列はただのタグを生成する
     * that(
     *     htmltag('a#hoge.c1.c2[name=hoge\[\]][href="http://hoge"][hidden]'))
     *     ->isSame('<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden></a>'
     * );
     * // ペア配列を与えるとコンテント文字列になる
     * that(
     *     htmltag(['a.c1#hoge.c2[name=hoge\[\]][href="http://hoge"][hidden]' => "this is text's content"]))
     *     ->isSame('<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden>this is text&#039;s content</a>'
     * );
     * // ネストした配列を与えると再帰される
     * that(
     *     htmltag([
     *         'div#wrapper' => [
     *             'b.class1' => [
     *                 '<plain>',
     *             ],
     *             'b.class2' => [
     *                 '<plain1>',
     *                 's' => '<strike>',
     *                 '<plain2>',
     *             ],
     *         ],
     *     ]))
     *     ->isSame('<div id="wrapper"><b class="class1">&lt;plain&gt;</b><b class="class2">&lt;plain1&gt;<s>&lt;strike&gt;</s>&lt;plain2&gt;</b></div>'
     * );
     * ```
     *
     * @param string|array $selector
     * @return string html 文字列
     */
    public static function htmltag($selector)
    {
        if (!is_iterable($selector)) {
            $selector = [$selector => ''];
        }

        $html = static function ($string) {
            return htmlspecialchars($string, ENT_QUOTES);
        };

        $build = static function ($selector, $content, $escape) use ($html) {
            $tag = '';
            $id = '';
            $classes = [];
            $attrs = [];

            $context = null;
            $escaping = null;
            $chars = preg_split('##u', $selector, -1, PREG_SPLIT_NO_EMPTY);
            for ($i = 0, $l = count($chars); $i < $l; $i++) {
                $char = $chars[$i];
                if ($char === '"' || $char === "'") {
                    $escaping = $escaping === $char ? null : $char;
                }

                if (!$escaping && $char === '#') {
                    if (strlen($id)) {
                        throw new \InvalidArgumentException('#id is multiple.');
                    }
                    $context = $char;
                    continue;
                }
                if (!$escaping && $char === '.') {
                    $context = $char;
                    $classes[] = '';
                    continue;
                }
                if (!$escaping && $char === '[') {
                    $context = $char;
                    $attrs[] = '';
                    continue;
                }
                if (!$escaping && $char === ']') {
                    $context = null;
                    continue;
                }

                if ($char === '\\') {
                    $char = $chars[++$i];
                }

                if ($context === null) {
                    $tag .= $char;
                    continue;
                }
                if ($context === '#') {
                    $id .= $char;
                    continue;
                }
                if ($context === '.') {
                    $classes[count($classes) - 1] .= $char;
                    continue;
                }
                if ($context === '[') {
                    $attrs[count($attrs) - 1] .= $char;
                    continue;
                }
            }

            if (!strlen($tag)) {
                throw new \InvalidArgumentException('tagname is empty.');
            }

            $attrkv = [];
            if (strlen($id)) {
                $attrkv['id'] = $id;
            }
            if ($classes) {
                $attrkv['class'] = implode(' ', $classes);
            }
            foreach ($attrs as $attr) {
                [$k, $v] = explode('=', $attr, 2) + [1 => null];
                if (array_key_exists($k, $attrkv)) {
                    throw new \InvalidArgumentException("[$k] is dumplicated.");
                }
                $attrkv[$k] = $v;
            }
            $attrs = [];
            foreach ($attrkv as $k => $v) {
                $attrs[] = $v === null
                    ? $html($k)
                    : sprintf('%s="%s"', $html($k), $html(preg_replace('#^([\"\'])|([^\\\\])([\"\'])$#u', '$2', $v)));
            }

            preg_match('#(\s*)(.+)(\s*)#u', $tag, $m);
            [, $prefix, $tag, $suffix] = $m;
            $tag_attr = $html($tag) . (concat)(' ', implode(' ', $attrs));
            $content = ($escape ? $html($content) : $content);

            return "$prefix<$tag_attr>$content</$tag>$suffix";
        };

        $result = '';
        foreach ($selector as $key => $value) {
            if (is_int($key)) {
                $result .= $html($value);
            }
            elseif (is_iterable($value)) {
                $result .= $build($key, (htmltag)($value), false);
            }
            else {
                $result .= $build($key, $value, true);
            }
        }
        return $result;
    }

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
     * that(build_uri([
     *     'scheme'   => 'http',
     *     'user'     => 'user',
     *     'pass'     => 'pass',
     *     'host'     => 'localhost',
     *     'port'     => '80',
     *     'path'     => '/path/to/file',
     *     'query'    => ['id' => 1],
     *     'fragment' => 'hash',
     * ]))->isSame('http://user:pass@localhost:80/path/to/file?id=1#hash');
     * // 一部だけ指定
     * that(build_uri([
     *     'scheme'   => 'http',
     *     'host'     => 'localhost',
     *     'path'     => '/path/to/file',
     *     'fragment' => 'hash',
     * ]))->isSame('http://localhost/path/to/file#hash');
     * ```
     *
     * @param array $parts URI の各パーツ配列
     * @return string URI 文字列
     */
    public static function build_uri($parts)
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
     * that(parse_uri('http://user:pass@localhost:80/path/to/file?id=1#hash'))->is([
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
     * that(parse_uri('localhost/path/to/file', [
     *     'scheme'   => 'http', // scheme のデフォルト値
     *     'user'     => 'user', // user のデフォルト値
     *     'port'     => '8080', // port のデフォルト値
     *     'host'     => 'hoge', // host のデフォルト値
     * ]))->is([
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
    public static function parse_uri($uri, $default = [])
    {
        /** @noinspection RequiredAttributes */
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

    /**
     * 連想配列を INI 的文字列に変換する
     *
     * Example:
     * ```php
     * that(ini_export(['a' => 1, 'b' => 'B', 'c' => PHP_SAPI]))->is('a = 1
     * b = "B"
     * c = "cli"
     * ');
     * ```
     *
     * @param array $iniarray ini 化する配列
     * @param array $options オプション配列
     * @return string ini 文字列
     */
    public static function ini_export($iniarray, $options = [])
    {
        $options += [
            'process_sections' => false,
            'alignment'        => true,
        ];

        $generate = function ($array, $key = null) use (&$generate, $options) {
            $ishasharray = is_array($array) && (is_hasharray)($array);
            return (array_sprintf)($array, function ($v, $k) use ($generate, $key, $ishasharray) {
                if (is_iterable($v)) {
                    return $generate($v, $k);
                }

                if ($key === null) {
                    return $k . ' = ' . (var_export2)($v, true);
                }
                return ($ishasharray ? "{$key}[$k]" : "{$key}[]") . ' = ' . (var_export2)($v, true);
            }, "\n");
        };

        if ($options['process_sections']) {
            return (array_sprintf)($iniarray, function ($v, $k) use ($generate) {
                return "[$k]\n{$generate($v)}\n";
            }, "\n");
        }

        return $generate($iniarray) . "\n";
    }

    /**
     * INI 的文字列を連想配列に変換する
     *
     * Example:
     * ```php
     * that(ini_import("
     * a = 1
     * b = 'B'
     * c = PHP_VERSION
     * "))->is(['a' => 1, 'b' => 'B', 'c' => PHP_VERSION]);
     * ```
     *
     * @param string $inistring ini 文字列
     * @param array $options オプション配列
     * @return array 配列
     */
    public static function ini_import($inistring, $options = [])
    {
        $options += [
            'process_sections' => false,
            'scanner_mode'     => INI_SCANNER_TYPED,
        ];

        return parse_ini_string($inistring, $options['process_sections'], $options['scanner_mode']);
    }

    /**
     * 連想配列の配列を CSV 的文字列に変換する
     *
     * CSV ヘッダ行は全連想配列のキーの共通項となる。
     * 順番には依存しないが、余計な要素があってもそのキーはヘッダには追加されないし、データ行にも含まれない。
     * ただし、オプションで headers が与えられた場合はそれを使用する。
     * この headers オプションはヘッダ文字列変換も兼ねる（[key => header] で「key を header で吐き出し」となる）。
     *
     * callback オプションが渡された場合は「あらゆる処理の最初」にコールされる。
     * つまりヘッダの読み換えや文字エンコーディングの変換が行われる前の状態でコールされる。
     * また、 false を返すとその要素はスルーされる。
     *
     * output オプションにリソースを渡すとそこに対して書き込みが行われる（fclose はされない）。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * $csvarrays = [
     *     ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],             // 普通の行
     *     ['c' => 'C2', 'a' => 'A2', 'b' => 'B2'],             // 順番が入れ替わっている行
     *     ['c' => 'C3', 'a' => 'A3', 'b' => 'B3', 'x' => 'X'], // 余計な要素が入っている行
     * ];
     * that(csv_export($csvarrays))->is("a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ");
     *
     * // ヘッダを指定できる
     * that(csv_export($csvarrays, [
     *     'headers' => ['a' => 'A', 'c' => 'C'], // a と c だけを出力＋ヘッダ文字変更
     * ]))->is("A,C
     * A1,C1
     * A2,C2
     * A3,C3
     * ");
     * ```
     *
     * @param array $csvarrays 連想配列の配列
     * @param array $options オプション配列。fputcsv の第3引数以降もここで指定する
     * @return string|int CSV 的文字列。output オプションを渡した場合は書き込みバイト数
     */
    public static function csv_export($csvarrays, $options = [])
    {
        $options += [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape'    => '\\',
            'encoding'  => mb_internal_encoding(),
            'headers'   => [],
            'callback'  => null, // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
            'output'    => null,
        ];

        $output = $options['output'];

        if ($output) {
            $fp = $options['output'];
        }
        else {
            $fp = fopen('php://temp', 'rw+');
        }
        try {
            $size = (call_safely)(function ($fp, $csvarrays, $delimiter, $enclosure, $escape, $encoding, $headers, $callback) {
                $size = 0;
                $mb_internal_encoding = mb_internal_encoding();
                if (!$headers) {
                    foreach ($csvarrays as $array) {
                        $headers = $headers ? array_intersect_key($headers, $array) : $array;
                    }
                    $headers = array_keys($headers);
                }
                if (!(is_hasharray)($headers)) {
                    $headers = array_combine($headers, $headers);
                }
                if ($encoding !== $mb_internal_encoding) {
                    mb_convert_variables($encoding, $mb_internal_encoding, $headers);
                }
                $size += fputcsv($fp, $headers, $delimiter, $enclosure, $escape);
                $default = array_fill_keys(array_keys($headers), '');

                foreach ($csvarrays as $n => $array) {
                    if ($callback) {
                        if ($callback($array, $n) === false) {
                            continue;
                        }
                    }
                    $row = array_intersect_key(array_replace($default, $array), $default);
                    if ($encoding !== $mb_internal_encoding) {
                        mb_convert_variables($encoding, $mb_internal_encoding, $row);
                    }
                    $size += fputcsv($fp, $row, $delimiter, $enclosure, $escape);
                }
                return $size;
            }, $fp, $csvarrays, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers'], $options['callback']);
            if ($output) {
                return $size;
            }
            rewind($fp);
            return stream_get_contents($fp);
        }
        finally {
            if (!$output) {
                fclose($fp);
            }
        }
    }

    /**
     * CSV 的文字列を連想配列の配列に変換する
     *
     * 1行目をヘッダ文字列とみなしてそれをキーとした連想配列の配列を返す。
     * ただし、オプションで headers が与えられた場合はそれを使用する。
     * この headers オプションはヘッダフィルタも兼ねる（[n => header] で「n 番目フィールドを header で取り込み」となる）。
     * 入力にヘッダがありかつ headers に連想配列が渡された場合はフィルタ兼読み換えとなる（Example を参照）。
     *
     * callback オプションが渡された場合は「あらゆる処理の最後」にコールされる。
     * つまりヘッダの読み換えや文字エンコーディングの変換が行われた後の状態でコールされる。
     * また、 false を返すとその要素はスルーされる。
     *
     * メモリ効率は意識しない（どうせ配列を返すので意識しても無駄）。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * that(csv_import("
     * a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * "))->is([
     *     ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],
     *     ['a' => 'A2', 'b' => 'B2', 'c' => 'C2'],
     *     ['a' => 'A3', 'b' => 'B3', 'c' => 'C3'],
     * ]);
     *
     * // ヘッダを指定できる
     * that(csv_import("
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ", [
     *     'headers' => [0 => 'a', 2 => 'c'], // 1がないので1番目のフィールドを読み飛ばしつつ、0, 2 は "a", "c" として取り込む
     * ]))->is([
     *     ['a' => 'A1', 'c' => 'C1'],
     *     ['a' => 'A2', 'c' => 'C2'],
     *     ['a' => 'A3', 'c' => 'C3'],
     * ]);
     *
     * // ヘッダありで連想配列で指定するとキーの読み換えとなる（指定しなければ読み飛ばしも行える）
     * that(csv_import("
     * a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ", [
     *     'headers' => ['a' => 'hoge', 'c' => 'piyo'], // a は hoge, c は piyo で読み込む。 b は指定がないので飛ばされる
     * ]))->is([
     *     ['hoge' => 'A1', 'piyo' => 'C1'],
     *     ['hoge' => 'A2', 'piyo' => 'C2'],
     *     ['hoge' => 'A3', 'piyo' => 'C3'],
     * ]);
     * ```
     *
     * @param string|resource $csvstring CSV 的文字列。ファイルポインタでも良いが終了後に必ず閉じられる
     * @param array $options オプション配列。fgetcsv の第3引数以降もここで指定する
     * @return array 連想配列の配列
     */
    public static function csv_import($csvstring, $options = [])
    {
        $options += [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape'    => '\\',
            'encoding'  => mb_internal_encoding(),
            'headers'   => [],
            'headermap' => null,
            'callback'  => null, // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
        ];

        // 文字キーを含む場合はヘッダーありの読み換えとなる
        if (is_array($options['headers']) && count(array_filter(array_keys($options['headers']), 'is_string')) > 0) {
            $options['headermap'] = $options['headers'];
            $options['headers'] = null;
        }

        if (is_resource($csvstring)) {
            $fp = $csvstring;
        }
        else {
            $fp = fopen('php://temp', 'r+b');
            fwrite($fp, $csvstring);
            rewind($fp);
        }

        try {
            return (call_safely)(function ($fp, $delimiter, $enclosure, $escape, $encoding, $headers, $headermap, $callback) {
                $mb_internal_encoding = mb_internal_encoding();
                $result = [];
                $n = -1;
                while ($row = fgetcsv($fp, 0, $delimiter, $enclosure, $escape)) {
                    if ($row === [null]) {
                        continue;
                    }
                    if ($mb_internal_encoding !== $encoding) {
                        mb_convert_variables($mb_internal_encoding, $encoding, $row);
                    }
                    if (!$headers) {
                        $headers = $row;
                        continue;
                    }

                    $n++;
                    $row = array_combine($headers, array_intersect_key($row, $headers));
                    if ($headermap) {
                        $row = (array_pickup)($row, $headermap);
                    }
                    if ($callback) {
                        if ($callback($row, $n) === false) {
                            continue;
                        }
                    }
                    $result[] = $row;
                }
                return $result;
            }, $fp, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers'], $options['headermap'], $options['callback']);
        }
        finally {
            fclose($fp);
        }
    }

    /**
     * json_encode のプロキシ関数
     *
     * 引数体系とデフォルト値を変更してある。また、エラー時に例外が飛ぶ。
     *
     * Example:
     * ```php
     * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
     * that(json_export(['a' => 'A', 'b' => 'B'], [
     *    JSON_PRETTY_PRINT => false,
     * ]))->is('{"a":"A","b":"B"}');
     * ```
     *
     * @param mixed $value encode する値
     * @param array $options JSON_*** をキーにした連想配列。 値が false は指定されていないとみなされる
     * @return string JSON 文字列
     */
    public static function json_export($value, $options = [])
    {
        $options += [
            JSON_UNESCAPED_UNICODE      => true, // エスケープなしで特にデメリットはない
            JSON_PRESERVE_ZERO_FRACTION => true, // 勝手に変換はできるだけ避けたい
        ];
        $depth = (array_unset)($options, JSON_MAX_DEPTH, 512);
        $option = array_sum(array_keys(array_filter($options)));

        // エラークリア関数が存在しないので null エンコードしてエラーを消しておく（分岐は不要かもしれない。ただ呼んだほうが速い？）
        if (json_last_error()) {
            json_encode(null);
        }

        $result = json_encode($value, $option, $depth);

        // エラーが出ていたら例外に変換
        if (json_last_error()) {
            throw new \ErrorException(json_last_error_msg(), json_last_error());
        }

        return $result;
    }

    /**
     * json_decode のプロキシ関数
     *
     * 引数体系とデフォルト値を変更してある。また、エラー時に例外が飛ぶ。
     *
     * Example:
     * ```php
     * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
     * that(json_import('{"a":"A","b":"B"}', [
     *    JSON_OBJECT_AS_ARRAY => true,
     * ]))->is(['a' => 'A', 'b' => 'B']);
     * ```
     *
     * @param string $value JSON 文字列
     * @param array $options JSON_*** をキーにした連想配列。 値が false は指定されていないとみなされる
     * @return mixed decode された値
     */
    public static function json_import($value, $options = [])
    {
        $options += [
            JSON_OBJECT_AS_ARRAY => true, // 個人的嗜好だが連想配列のほうが扱いやすい
        ];
        $depth = (array_unset)($options, JSON_MAX_DEPTH, 512);
        $option = array_sum(array_keys(array_filter($options)));

        // エラークリア関数が存在しないので null エンコードしてエラーを消しておく（分岐は不要かもしれない。ただ呼んだほうが速い？）
        if (json_last_error()) {
            json_encode(null);
        }

        $result = json_decode($value, $options[JSON_OBJECT_AS_ARRAY], $depth, $option);

        // エラーが出ていたら例外に変換
        if (json_last_error()) {
            throw new \ErrorException(json_last_error_msg(), json_last_error());
        }

        return $result;
    }

    /**
     * 連想配列を paml 的文字列に変換する
     *
     * paml で出力することはまずないのでおまけ（import との対称性のために定義している）。
     *
     * Example:
     * ```php
     * that(paml_export([
     *     'n' => null,
     *     'f' => false,
     *     'i' => 123,
     *     'd' => 3.14,
     *     's' => 'this is string',
     * ]))->isSame('n: null, f: false, i: 123, d: 3.14, s: "this is string"');
     * ```
     *
     * @param array $pamlarray 配列
     * @param array $options オプション配列
     * @return string PAML 的文字列
     */
    public static function paml_export($pamlarray, $options = [])
    {
        $options += [
            'trailing-comma' => false,
            'pretty-space'   => true,
        ];

        $space = $options['pretty-space'] ? ' ' : '';

        $result = [];
        $n = 0;
        foreach ($pamlarray as $k => $v) {
            if (is_array($v)) {
                $inner = (paml_export)($v, $options);
                if ((is_hasharray)($v)) {
                    $v = '{' . $inner . '}';
                }
                else {
                    $v = '[' . $inner . ']';
                }
            }
            elseif ($v === null) {
                $v = 'null';
            }
            elseif ($v === false) {
                $v = 'false';
            }
            elseif ($v === true) {
                $v = 'true';
            }
            elseif (is_string($v)) {
                $v = '"' . addcslashes($v, "\"\0\\") . '"';
            }

            if ($k === $n++) {
                $result[] = "$v";
            }
            else {
                $result[] = "$k:{$space}$v";
            }
        }
        return implode(",$space", $result) . ($options['trailing-comma'] ? ',' : '');
    }

    /**
     * paml 的文字列をパースする
     *
     * paml とは yaml を簡易化したような独自フォーマットを指す。
     * ざっくりと下記のような特徴がある。
     *
     * - ほとんど yaml と同じだがフロースタイルのみでキーコロンの後のスペースは不要
     * - yaml のアンカーや複数ドキュメントのようなややこしい仕様はすべて未対応
     * - 配列を前提にしているので、トップレベルの `[]` `{}` は不要
     * - 配列・連想配列の区別はなし。 `[]` でいわゆる php の配列、 `{}` で stdClass を表す
     * - bare string で php の定数を表す
     *
     * 簡易的な設定の注入に使える（yaml は標準で対応していないし、json や php 配列はクオートの必要やケツカンマ問題がある）。
     * なお、かなり緩くパースしてるので基本的にエラーにはならない。
     *
     * 早見表：
     *
     * - php:  `["n" => null, "f" => false, "i" => 123, "d" => 3.14, "s" => "this is string", "a" => [1, 2, "x" => "X"]]`
     *     - ダブルアローとキーのクオートが冗長
     * - json: `{"n":null, "f":false, "i":123, "d":3.14, "s":"this is string", "a":{"0": 1, "1": 2, "x": "X"}}`
     *     - キーのクオートが冗長だしケツカンマ非許容
     * - yaml: `{n: null, f: false, i: 123, d: 3.14, s: "this is string", a: {0: 1, 1: 2, x: X}}`
     *     - 理想に近いが、コロンの後にスペースが必要だし連想配列が少々難。なにより拡張や外部ライブラリが必要
     * - paml: `n:null, f:false, i:123, d:3.14, s:"this is string", a:[1, 2, x:X]`
     *     - シンプルイズベスト
     *
     * Example:
     * ```php
     * // こういったスカラー型はほとんど yaml と一緒だが、コロンの後のスペースは不要（あってもよい）
     * that(paml_import('n:null, f:false, i:123, d:3.14, s:"this is string"'))->isSame([
     *     'n' => null,
     *     'f' => false,
     *     'i' => 123,
     *     'd' => 3.14,
     *     's' => 'this is string',
     * ]);
     * // 配列が使える（キーは連番なら不要）。ネストも可能
     * that(paml_import('a:[1,2,x:X,3], nest:[a:[b:[c:[X]]]]'))->isSame([
     *     'a'    => [1, 2, 'x' => 'X', 3],
     *     'nest' => [
     *         'a' => [
     *             'b' => [
     *                 'c' => ['X']
     *             ],
     *         ],
     *     ],
     * ]);
     * // bare 文字列で定数が使える
     * that(paml_import('pv:PHP_VERSION, ao:ArrayObject::STD_PROP_LIST'))->isSame([
     *     'pv' => \PHP_VERSION,
     *     'ao' => \ArrayObject::STD_PROP_LIST,
     * ]);
     * ```
     *
     * @param string $pamlstring PAML 文字列
     * @param array $options オプション配列
     * @return array php 配列
     */
    public static function paml_import($pamlstring, $options = [])
    {
        $options += [
            'cache'          => true,
            'trailing-comma' => true,
        ];

        static $caches = [];
        if ($options['cache']) {
            return $caches[$pamlstring] = $caches[$pamlstring] ?? (paml_import)($pamlstring, ['cache' => false] + $options);
        }

        $escapers = ['"' => '"', "'" => "'", '[' => ']', '{' => '}'];

        $values = array_map('trim', (quoteexplode)(',', $pamlstring, null, $escapers));
        if ($options['trailing-comma'] && end($values) === '') {
            array_pop($values);
        }

        $result = [];
        foreach ($values as $value) {
            $key = null;
            $kv = array_map('trim', (quoteexplode)(':', $value, 2, $escapers));
            if (count($kv) === 2) {
                [$key, $value] = $kv;
            }

            $prefix = $value[0] ?? null;
            $suffix = $value[-1] ?? null;

            if ($prefix === '[' && $suffix === ']') {
                $value = (array) (paml_import)(substr($value, 1, -1), $options);
            }
            elseif ($prefix === '{' && $suffix === '}') {
                $value = (object) (paml_import)(substr($value, 1, -1), $options);
            }
            elseif ($prefix === '"' && $suffix === '"') {
                //$value = stripslashes(substr($value, 1, -1));
                $value = json_decode($value);
            }
            elseif ($prefix === "'" && $suffix === "'") {
                $value = substr($value, 1, -1);
            }
            elseif (defined($value)) {
                $value = constant($value);
            }
            elseif (is_numeric($value)) {
                if (ctype_digit(ltrim($value, '+-'))) {
                    $value = (int) $value;
                }
                else {
                    $value = (double) $value;
                }
            }

            if ($key === null) {
                $result[] = $value;
            }
            else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * 配列を LTSV 的文字列に変換する
     *
     * ラベル文字列に ":" を含む場合は例外を投げる（ラベルにコロンが来るとどうしようもない）。
     *
     * escape オプションで「LTSV 的にまずい文字」がその文字でエスケープされる（具体的には "\n" と "\t"）。
     * デフォルトでは "\\" でエスケープされるので、整合性が崩れることはない。
     *
     * encode オプションで「文字列化できない値」が来たときのその関数を通して出力される（その場合、目印として値の両サイドに ` が付く）。
     * デフォルトでは json_encode される。
     *
     * エンコード機能はおまけに過ぎない（大抵の場合はそんな機能は必要ない）。
     * ので、この実装は互換性を維持せず変更される可能性がある。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * that(ltsv_export([
     *     "label1" => "value1",
     *     "label2" => "value2",
     * ]))->is("label1:value1	label2:value2");
     *
     * // タブや改行文字のエスケープ
     * that(ltsv_export([
     *     "label1" => "val\tue1",
     *     "label2" => "val\nue2",
     * ]))->is("label1:val\\tue1	label2:val\\nue2");
     *
     * // 配列のエンコード
     * that(ltsv_export([
     *     "label1" => "value1",
     *     "label2" => [1, 2, 3],
     * ]))->is("label1:value1	label2:`[1,2,3]`");
     * ```
     *
     * @param array $ltsvarray 配列
     * @param array $options オプション配列
     * @return string LTSV 的文字列
     */
    public static function ltsv_export($ltsvarray, $options = [])
    {
        $options += [
            'escape' => '\\',
            'encode' => function ($v) { return json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); },
        ];
        $escape = $options['escape'];
        $encode = $options['encode'];

        $map = [];
        if (strlen($escape)) {
            $map["\\"] = "{$escape}\\";
            $map["\t"] = "{$escape}t";
            $map["\n"] = "{$escape}n";
        }

        $parts = [];
        foreach ($ltsvarray as $label => $value) {
            if (strpos($label, ':')) {
                throw new \InvalidArgumentException('label contains ":".');
            }
            $should_encode = !(is_stringable)($value);
            if ($should_encode) {
                $value = "`{$encode($value)}`";
            }
            if ($map) {
                $label = strtr($label, $map);
                if (!$should_encode) {
                    $value = strtr($value, $map);
                }
            }
            $parts[] = $label . ':' . $value;
        }
        return implode("\t", $parts);
    }

    /**
     * LTSV 的文字列を配列に変換する
     *
     * escape オプションで「LTSV 的にまずい文字」がその文字でエスケープされる（具体的には "\n" と "\t"）。
     * デフォルトでは "\\" でエスケープされるので、整合性が崩れることはない。
     *
     * decode オプションで「`` で囲まれた値」が来たときのその関数を通して出力される。
     * デフォルトでは json_decode される。
     *
     * エンコード機能はおまけに過ぎない（大抵の場合はそんな機能は必要ない）。
     * ので、この実装は互換性を維持せず変更される可能性がある。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * that(ltsv_import("label1:value1	label2:value2"))->is([
     *     "label1" => "value1",
     *     "label2" => "value2",
     * ]);
     *
     * // タブや改行文字のエスケープ
     * that(ltsv_import("label1:val\\tue1	label2:val\\nue2"))->is([
     *     "label1" => "val\tue1",
     *     "label2" => "val\nue2",
     * ]);
     *
     * // 配列のデコード
     * that(ltsv_import("label1:value1	label2:`[1,2,3]`"))->is([
     *     "label1" => "value1",
     *     "label2" => [1, 2, 3],
     * ]);
     * ```
     *
     * @param string $ltsvstring LTSV 的文字列
     * @param array $options オプション配列
     * @return array 配列
     */
    public static function ltsv_import($ltsvstring, $options = [])
    {
        $options += [
            'escape' => '\\',
            'decode' => function ($v) { return json_decode($v, true); },
        ];
        $escape = $options['escape'];
        $decode = $options['decode'];

        $map = [];
        if (strlen($escape)) {
            $map["{$escape}\\"] = "\\";
            $map["{$escape}t"] = "\t";
            $map["{$escape}n"] = "\n";
        }

        $result = [];
        foreach (explode("\t", $ltsvstring) as $part) {
            [$label, $value] = explode(':', $part, 2);
            $should_decode = substr($value, 0, 1) === '`' && substr($value, -1, 1) === '`';
            if ($map) {
                $label = strtr($label, $map);
                if (!$should_decode) {
                    $value = strtr($value, $map);
                }
            }
            if ($should_decode) {
                $value2 = $decode(substr($value, 1, -1));
                // たまたま ` が付いているだけかも知れないので結果で判定する
                if (!(is_stringable)($value2)) {
                    $value = $value2;
                }
            }
            $result[$label] = $value;
        }
        return $result;
    }

    /**
     * 連想配列の配列を markdown テーブル文字列にする
     *
     * 見出しはキーの和集合で生成され、改行は `<br>` に置換される。
     * 要素が全て数値の場合は右寄せになる。
     *
     * Example:
     * ```php
     * // 最初の "\n" に意味はない（ズレると見づらいので冒頭に足しているだけ）
     * that("\n" . markdown_table([
     *    ['a' => 'a1', 'b' => 'b1'],
     *    ['b' => 'b2', 'c' => '2'],
     *    ['a' => 'a3', 'c' => '3'],
     * ]))->is("
     * | a   | b   |   c |
     * | --- | --- | --: |
     * | a1  | b1  |     |
     * |     | b2  |   2 |
     * | a3  |     |   3 |
     * ");
     * ```
     *
     * @param array $array 連想配列の配列
     * @return string markdown テーブル文字列
     */
    public static function markdown_table($array)
    {
        if (!is_array($array) || (is_empty)($array)) {
            throw new \InvalidArgumentException('$array must be array of hasharray.');
        }

        $defaults = [];
        $numerics = [];
        $lengths = [];
        foreach ($array as $n => $fields) {
            assert(is_array($fields), '$array must be array of hasharray.');
            foreach ($fields as $k => $v) {
                $v = str_replace(["\r\n", "\r", "\n"], '<br>', $v);
                $array[$n][$k] = $v;
                $defaults[$k] = '';
                $numerics[$k] = ($numerics[$k] ?? true) && is_numeric($v);
                $lengths[$k] = max($lengths[$k] ?? 3, strlen($k), strlen($v)); // 3 は markdown の最低見出し長
            }
        }

        $linebuilder = function ($array, $padstr) use ($numerics, $lengths) {
            $line = [];
            foreach ($array as $k => $v) {
                $pad = str_pad($v, strlen($v) - mb_strwidth($v) + $lengths[$k], $padstr, $numerics[$k] ? STR_PAD_LEFT : STR_PAD_RIGHT);
                if ($padstr === '-' && $numerics[$k]) {
                    $pad[strlen($pad) - 1] = ':';
                }
                $line[] = $pad;
            }
            return '| ' . implode(' | ', $line) . ' |';
        };

        $result = [];

        $result[] = $linebuilder(array_combine($keys = array_keys($defaults), $keys), ' ');
        $result[] = $linebuilder($defaults, '-');
        foreach ($array as $fields) {
            $result[] = $linebuilder(array_replace($defaults, $fields), ' ');
        }

        return implode("\n", $result) . "\n";
    }

    /**
     * 配列を markdown リスト文字列にする
     *
     * Example:
     * ```php
     * // 最初の "\n" に意味はない（ズレると見づらいので冒頭に足しているだけ）
     * that("\n" . markdown_list([
     *     'dict'        => [
     *         'Key1' => 'Value1',
     *         'Key2' => 'Value2',
     *     ],
     *     'list'        => ['Item1', 'Item2', 'Item3'],
     *     'dict & list' => [
     *         'Key' => 'Value',
     *         ['Item1', 'Item2', 'Item3'],
     *     ],
     * ], ['separator' => ':']))->is("
     * - dict:
     *     - Key1:Value1
     *     - Key2:Value2
     * - list:
     *     - Item1
     *     - Item2
     *     - Item3
     * - dict & list:
     *     - Key:Value
     *         - Item1
     *         - Item2
     *         - Item3
     * ");
     * ```
     *
     * @param array $array 配列
     * @param array $option オプション配列
     * @return string markdown リスト文字列
     */
    public static function markdown_list($array, $option = [])
    {
        $option += [
            'indent'    => '    ',
            'separator' => ': ',
            'liststyle' => '-',
            'ordered'   => false,
        ];

        $f = function ($array, $nest) use (&$f, $option) {
            $spacer = str_repeat($option['indent'], $nest);
            $result = [];
            foreach ((arrays)($array) as $n => [$k, $v]) {
                if (is_iterable($v)) {
                    if (!is_int($k)) {
                        $result[] = $spacer . $option['liststyle'] . ' ' . $k . $option['separator'];
                    }
                    $result = array_merge($result, $f($v, $nest + 1));
                }
                else {
                    if (!is_int($k)) {
                        $result[] = $spacer . $option['liststyle'] . ' ' . $k . $option['separator'] . $v;
                    }
                    elseif (!$option['ordered']) {
                        $result[] = $spacer . $option['liststyle'] . ' ' . $v;
                    }
                    else {
                        $result[] = $spacer . ($n + 1) . '. ' . $v;
                    }
                }
            }
            return $result;
        };
        return implode("\n", $f($array, 0)) . "\n";
    }

    /**
     * 安全な乱数文字列を生成する
     *
     * @param int $length 生成文字列長
     * @param string $charlist 使用する文字セット
     * @return string 乱数文字列
     */
    public static function random_string($length = 8, $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
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

    /**
     * 連想配列を指定できるようにした vsprintf
     *
     * sprintf の順序指定構文('%1$d')にキーを指定できる。
     *
     * Example:
     * ```php
     * that(kvsprintf('%hoge$s %fuga$d', ['hoge' => 'ThisIs', 'fuga' => '3.14']))->isSame('ThisIs 3');
     * ```
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
     * 複数マッチに対応した preg_match
     *
     * 要するに preg_match_all とほぼ同義だが、下記の差異がある。
     *
     * - 正規表現フラグに "g" フラグが使用できる。 "g" を指定すると preg_match_all 相当の動作になる
     * - キャプチャは参照引数ではなく返り値で返す
     * - 「パターン全体マッチ」を表す 0 キーは返さない
     * - 上記2つの動作により「マッチしなかったら空配列を返す」という動作になる
     * - 名前付きキャプチャーに対応する数値キーは伏せられる
     * - 伏せられても数値キーは 0 ベースで通し連番となる
     *
     * Example:
     * ```php
     * $pattern = '#(\d{4})/(?<month>\d{1,2})(?:/(\d{1,2}))?#';
     * // 1(month)番目は名前付きキャプチャなので 1 キーとしては含まれず month というキーで返す（2 が詰められて 1 になる）
     * that(preg_matches($pattern, '2014/12/24'))->isSame([0 => '2014', 'month' => '12', 1 => '24']);
     * // 一切マッチしなければ空配列が返る
     * that(preg_matches($pattern, 'hoge'))->isSame([]);
     *
     * // g オプションを与えると preg_match_all 相当の動作になる（flags も使える）
     * $pattern = '#(\d{4})/(?<month>\d{1,2})(?:/(\d{1,2}))?#g';
     * that(preg_matches($pattern, '2013/11/23, 2014/12/24', PREG_SET_ORDER))->isSame([
     *     [0 => '2013', 'month' => '11', 1 => '23'],
     *     [0 => '2014', 'month' => '12', 1 => '24'],
     * ]);
     * ```
     *
     * @param string $pattern 正規表現
     * @param string $subject 対象文字列
     * @param int $flags PREG 定数
     * @param int $offset 開始位置
     * @return array キャプチャした配列
     */
    public static function preg_matches($pattern, $subject, $flags = 0, $offset = 0)
    {
        // 0 と名前付きに対応する数値キーを伏せてその上で通し連番にするクロージャ
        $unset = function ($match) {
            $result = [];
            $keys = array_keys($match);
            for ($i = 1; $i < count($keys); $i++) {
                $key = $keys[$i];
                if (is_string($key)) {
                    $result[$key] = $match[$key];
                    $i++;
                }
                else {
                    $result[] = $match[$key];
                }
            }
            return $result;
        };

        $endpairs = [
            '(' => ')',
            '{' => '}',
            '[' => ']',
            '<' => '>',
        ];
        $endpos = strrpos($pattern, $endpairs[$pattern[0]] ?? $pattern[0]);
        $expression = substr($pattern, 0, $endpos);
        $modifiers = str_split(substr($pattern, $endpos));

        if (($g = array_search('g', $modifiers, true)) !== false) {
            unset($modifiers[$g]);

            preg_match_all($expression . implode('', $modifiers), $subject, $matches, $flags, $offset);
            if (($flags & PREG_SET_ORDER) === PREG_SET_ORDER) {
                return array_map($unset, $matches);
            }
            return $unset($matches);
        }
        else {
            $flags = ~PREG_PATTERN_ORDER & ~PREG_SET_ORDER & $flags;

            preg_match($pattern, $subject, $matches, $flags, $offset);
            return $unset($matches);
        }
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
     * ```php
     * $pattern = '#(\d{4})/(\d{1,2})(/(\d{1,2}))?#';
     * $default = [1 => '2000', 2 => '1', 4 => '1'];
     * // 完全にマッチするのでそれぞれ返ってくる
     * that(preg_capture($pattern, '2014/12/24', $default))->isSame([1 => '2014', 2 => '12', 4 => '24']);
     * // 最後の \d{1,2} はマッチしないのでデフォルト値が使われる
     * that(preg_capture($pattern, '2014/12', $default))->isSame([1 => '2014', 2 => '12', 4 => '1']);
     * // 一切マッチしないので全てデフォルト値が使われる
     * that(preg_capture($pattern, 'hoge', $default))->isSame([1 => '2000', 2 => '1', 4 => '1']);
     * ```
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
     * キャプチャも行える preg_replace
     *
     * 「置換を行いつつ、キャプチャ文字列が欲しい」状況はまれによくあるはず。
     *
     * $replacement に callable を渡すと preg_replace_callback がコールされる。
     * callable とはいっても単純文字列 callble （"strtoupper" など）は callable とはみなされない。
     * 配列形式の callable や クロージャのみ preg_replace_callback になる。
     *
     * Example:
     * ```php
     * // 数字を除去しつつその除去された数字を得る
     * that(preg_splice('#\\d+#', '', 'abc123', $m))->isSame('abc');
     * that($m)->isSame(['123']);
     *
     * // callable だと preg_replace_callback が呼ばれる
     * that(preg_splice('#[a-z]+#', function($m){return strtoupper($m[0]);}, 'abc123', $m))->isSame('ABC123');
     * that($m)->isSame(['abc']);
     *
     * // ただし、 文字列 callable は文字列として扱う
     * that(preg_splice('#[a-z]+#', 'strtoupper', 'abc123', $m))->isSame('strtoupper123');
     * that($m)->isSame(['abc']);
     * ```
     *
     * @param string $pattern 正規表現
     * @param string|callable $replacement 置換文字列
     * @param string $subject 対象文字列
     * @param array $matches キャプチャ配列が格納される
     * @return string 置換された文字列
     */
    public static function preg_splice($pattern, $replacement, $subject, &$matches = [])
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

    /**
     * パターン番号を指定して preg_replace する
     *
     * パターン番号を指定してそれのみを置換する。
     * 名前付きキャプチャを使用している場合はキーに文字列も使える。
     * 値にクロージャを渡した場合はコールバックされて置換される。
     *
     * $replacements に単一文字列を渡した場合、 `[1 => $replacements]` と等しくなる（第1キャプチャを置換）。
     *
     * Example:
     * ```php
     * // a と z に囲まれた数字を XXX に置換する
     * that(preg_replaces('#a(\d+)z#', [1 => 'XXX'], 'a123z'))->isSame('aXXXz');
     * // 名前付きキャプチャも指定できる
     * that(preg_replaces('#a(?<digit>\d+)z#', ['digit' => 'XXX'], 'a123z'))->isSame('aXXXz');
     * // クロージャを渡すと元文字列を引数としてコールバックされる
     * that(preg_replaces('#a(?<digit>\d+)z#', ['digit' => function($src){return $src * 2;}], 'a123z'))->isSame('a246z');
     * // 複合的なサンプル（a タグの href と target 属性を書き換える）
     * that(preg_replaces('#<a\s+href="(?<href>.*)"\s+target="(?<target>.*)">#', [
     *     'href'   => function($href){return strtoupper($href);},
     *     'target' => function($target){return strtoupper($target);},
     * ], '<a href="hoge" target="fuga">inner text</a>'))->isSame('<a href="HOGE" target="FUGA">inner text</a>');
     * ```
     *
     * @param string $pattern 正規表現
     * @param array|string $replacements 置換文字列
     * @param string $subject 対象文字列
     * @param int $limit 置換回数
     * @param null $count 置換回数格納変数
     * @return string 置換された文字列
     */
    public static function preg_replaces($pattern, $replacements, $subject, $limit = -1, &$count = null)
    {
        $offset = 0;
        $count = 0;
        if (!(is_arrayable)($replacements)) {
            $replacements = [1 => $replacements];
        }

        preg_match_all($pattern, $subject, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        foreach ($matches as $match) {
            if ($limit-- === 0) {
                break;
            }
            $count++;

            foreach ($match as $index => $m) {
                if ($m[1] >= 0 && $index !== 0 && isset($replacements[$index])) {
                    $src = $m[0];
                    $dst = $replacements[$index];
                    if ($dst instanceof \Closure) {
                        $dst = $dst($src);
                    }

                    $srclen = strlen($src);
                    $dstlen = strlen($dst);

                    $subject = substr_replace($subject, $dst, $offset + $m[1], $srclen);
                    $offset += $dstlen - $srclen;
                }
            }
        }
        return $subject;
    }

    /**
     * Damerau–Levenshtein 距離を返す
     *
     * 簡単に言えば「転置（入れ替え）を考慮したレーベンシュタイン」である。
     * 例えば "destroy" と "destory" は 「1挿入1削除=2」であるが、Damerau 版だと「1転置=1」となる。
     *
     * また、マルチバイト（UTF-8 のみ）にも対応している。
     *
     * Example:
     * ```php
     * // destroy と destory は普通にレーベンシュタイン距離を取ると 2 になるが・・・
     * that(levenshtein("destroy", "destory"))->isSame(2);
     * // damerau_levenshtein だと1である
     * that(damerau_levenshtein("destroy", "destory"))->isSame(1);
     * // UTF-8 でも大丈夫
     * that(damerau_levenshtein("あいうえお", "あいえうお"))->isSame(1);
     * ```
     *
     * @param string $s1 対象文字列1
     * @param string $s2 対象文字列2
     * @param int $cost_ins 挿入のコスト
     * @param int $cost_rep 置換のコスト
     * @param int $cost_del 削除のコスト
     * @param int $cost_swp 転置のコスト
     * @return int Damerau–Levenshtein 距離
     */
    public static function damerau_levenshtein($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1)
    {
        $s1 = is_array($s1) ? $s1 : preg_split('//u', $s1, -1, PREG_SPLIT_NO_EMPTY);
        $s2 = is_array($s2) ? $s2 : preg_split('//u', $s2, -1, PREG_SPLIT_NO_EMPTY);
        $l1 = count($s1);
        $l2 = count($s2);
        if (!$l1) {
            return $l2 * $cost_ins;
        }
        if (!$l2) {
            return $l1 * $cost_del;
        }
        $p1 = array_fill(0, $l2 + 1, 0);
        $p2 = array_fill(0, $l2 + 1, 0);
        for ($i2 = 0; $i2 <= $l2; $i2++) {
            $p1[$i2] = $i2 * $cost_ins;
        }
        for ($i1 = 0; $i1 < $l1; $i1++) {
            $p2[0] = $p1[0] + $cost_del;
            for ($i2 = 0; $i2 < $l2; $i2++) {
                $c0 = $p1[$i2];
                if ($s1[$i1] !== $s2[$i2]) {
                    if (
                        $cost_swp && (
                            ($s1[$i1] === ($s2[$i2 - 1] ?? '') && ($s1[$i1 - 1] ?? '') === $s2[$i2]) ||
                            ($s1[$i1] === ($s2[$i2 + 1] ?? '') && ($s1[$i1 + 1] ?? '') === $s2[$i2])
                        )
                    ) {
                        $c0 += $cost_swp / 2;
                    }
                    else {
                        $c0 += $cost_rep;
                    }
                }
                $c1 = $p1[$i2 + 1] + $cost_del;
                if ($c1 < $c0) {
                    $c0 = $c1;
                }
                $c2 = $p2[$i2] + $cost_ins;
                if ($c2 < $c0) {
                    $c0 = $c2;
                }
                $p2[$i2 + 1] = $c0;
            }
            $tmp = $p1;
            $p1 = $p2;
            $p2 = $tmp;
        }
        return (int) $p1[$l2];
    }

    /**
     * N-gram 化して配列で返す
     *
     * 素朴な実装であり特記事項はない。
     * 末端要素や除去フィルタくらいは実装するかもしれない。
     *
     * Example:
     * ```php
     * that(ngram("あいうえお", 1))->isSame(["あ", "い", "う", "え", "お"]);
     * that(ngram("あいうえお", 2))->isSame(["あい", "いう", "うえ", "えお", "お"]);
     * that(ngram("あいうえお", 3))->isSame(["あいう", "いうえ", "うえお", "えお", "お"]);
     * ```
     *
     * @param string $string 対象文字列
     * @param int $N N-gram の N
     * @param string $encoding マルチバイトエンコーディング
     * @return array N-gram 配列
     */
    public static function ngram($string, $N, $encoding = 'UTF-8')
    {
        if (func_num_args() < 3) {
            $encoding = mb_internal_encoding();
        }

        $result = [];
        for ($i = 0, $l = mb_strlen($string, $encoding); $i < $l; ++$i) {
            $result[] = mb_substr($string, $i, $N, $encoding);
        }

        return $result;
    }

    /**
     * $string に最も近い文字列を返す
     *
     * N-gram 化して類似度の高い結果を返す。
     *
     * この関数の結果（内部実装）は互換性を考慮しない。
     *
     * Example:
     * ```php
     * // 「あいうえお」と最も近い文字列は「あいゆえに」である
     * that(str_guess("あいうえお", [
     *     'かきくけこ', // マッチ度 0%（1文字もかすらない）
     *     'ぎぼあいこ', // マッチ度約 13.1%（"あい"はあるが位置が異なる）
     *     'あいしてる', // マッチ度約 13.8%（"あい"がマッチ）
     *     'かとうあい', // マッチ度約 16.7%（"あい"があり"う"の位置が等しい）
     *     'あいゆえに', // マッチ度約 17.4%（"あい", "え"がマッチ）
     * ]))->isSame('あいゆえに');
     * ```
     *
     * @param string $string 調べる文字列
     * @param array $candidates 候補文字列配列
     * @param float $percent マッチ度（％）を受ける変数
     * @return string 候補の中で最も近い文字列
     */
    public static function str_guess($string, $candidates, &$percent = null)
    {
        $candidates = array_filter((arrayval)($candidates, false), 'strlen');
        if (!$candidates) {
            throw new \InvalidArgumentException('$candidates is empty.');
        }

        // uni, bi, tri して配列で返すクロージャ
        $ngramer = static function ($string) {
            $result = [];
            foreach ([1, 2, 3] as $n) {
                $result[$n] = (ngram)($string, $n);
            }
            return $result;
        };

        $sngram = $ngramer($string);

        $result = null;
        $percent = 0;
        foreach ($candidates as $i => $candidate) {
            $cngram = $ngramer($candidate);

            // uni, bi, tri で重み付けスコア（var_dump したいことが多いので配列に入れる）
            $scores = [];
            foreach ($sngram as $n => $_) {
                $scores[$n] = count(array_intersect($sngram[$n], $cngram[$n])) / max(count($sngram[$n]), count($cngram[$n])) * $n;
            }
            $score = array_sum($scores) * 10 + 1;

            // ↑のスコアが同じだった場合を考慮してレーベンシュタイン距離で下駄を履かせる
            $score -= (damerau_levenshtein)($sngram[1], $cngram[1]) / max(count($sngram[1]), count($cngram[1]));

            // 10(uni) + 20(bi) + 30(tri) + 1(levenshtein) で最大は 61
            $score = $score / 61 * 100;

            /*
            echo "$string <=> $candidate:
  score1     : $scores[1]
  score2     : $scores[2]
  score3     : $scores[3]
  score      : $score
";
            */

            if ($percent <= $score) {
                $percent = $score;
                $result = $i;
            }
        }

        return $candidates[$result];
    }

    /**
     * 文字列を区切り文字で区切って配列に変換する
     *
     * 典型的には http ヘッダとか sar の結果とかを配列にする。
     *
     * Example:
     * ```php
     * // http response header  を ":" 区切りで連想配列にする
     * that(str_array("
     * HTTP/1.1 200 OK
     * Content-Type: text/html; charset=utf-8
     * Connection: Keep-Alive
     * ", ':', true))->isSame([
     *     'HTTP/1.1 200 OK',
     *     'Content-Type' => 'text/html; charset=utf-8',
     *     'Connection'   => 'Keep-Alive',
     * ]);
     *
     * // sar の結果を " " 区切りで連想配列の配列にする
     * that(str_array("
     * 13:00:01        CPU     %user     %nice   %system   %iowait    %steal     %idle
     * 13:10:01        all      0.99      0.10      0.71      0.00      0.00     98.19
     * 13:20:01        all      0.60      0.10      0.56      0.00      0.00     98.74
     * ", ' ', false))->isSame([
     *     1 => [
     *         '13:00:01' => '13:10:01',
     *         'CPU'      => 'all',
     *         '%user'    => '0.99',
     *         '%nice'    => '0.10',
     *         '%system'  => '0.71',
     *         '%iowait'  => '0.00',
     *         '%steal'   => '0.00',
     *         '%idle'    => '98.19',
     *     ],
     *     2 => [
     *         '13:00:01' => '13:20:01',
     *         'CPU'      => 'all',
     *         '%user'    => '0.60',
     *         '%nice'    => '0.10',
     *         '%system'  => '0.56',
     *         '%iowait'  => '0.00',
     *         '%steal'   => '0.00',
     *         '%idle'    => '98.74',
     *     ],
     * ]);
     * ```
     *
     * @param string|array $string 対象文字列。配列を与えても動作する
     * @param string $delimiter 区切り文字
     * @param bool $hashmode 連想配列モードか
     * @return array 配列
     */
    public static function str_array($string, $delimiter, $hashmode)
    {
        $array = $string;
        if ((is_stringable)($string)) {
            $array = preg_split('#\R#u', $string, -1, PREG_SPLIT_NO_EMPTY);
        }
        $delimiter = preg_quote($delimiter, '#');

        $result = [];
        if ($hashmode) {
            foreach ($array as $n => $line) {
                $parts = preg_split("#$delimiter#u", $line, 2, PREG_SPLIT_NO_EMPTY);
                $key = isset($parts[1]) ? array_shift($parts) : $n;
                $result[trim($key)] = trim($parts[0]);
            }
        }
        else {
            foreach ($array as $n => $line) {
                $parts = preg_split("#$delimiter#u", $line, -1, PREG_SPLIT_NO_EMPTY);
                if (!isset($keys)) {
                    $keys = $parts;
                    continue;
                }
                $result[$n] = count($keys) === count($parts) ? array_combine($keys, $parts) : null;
            }
        }
        return $result;
    }

    /**
     * マルチバイト対応 substr_replace
     *
     * 本家は配列を与えたりできるが、ややこしいし使う気がしないので未対応。
     *
     * Example:
     * ```php
     * // 2文字目から5文字を「あいうえお」に置換する
     * that(mb_substr_replace('０１２３４５６７８９', 'あいうえお', 2, 5))->isSame('０１あいうえお７８９');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $replacement 置換文字列
     * @param int $start 開始位置
     * @param int $length 置換長
     * @return string 置換した文字列
     */
    public static function mb_substr_replace($string, $replacement, $start, $length = null)
    {
        $string = (string) $string;

        $strlen = mb_strlen($string);
        if ($start < 0) {
            $start += $strlen;
        }
        if ($length < 0) {
            $length += $strlen - $start;
        }

        return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length, null);
    }

    /**
     * マルチバイト対応 trim
     *
     * Example:
     * ```php
     * that(mb_trim(' 　 あああ　 　'))->isSame('あああ');
     * ```
     *
     * @param string $string 対象文字列
     * @return string trim した文字列
     */
    public static function mb_trim($string)
    {
        return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $string);
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
     * that(render_string('${0}', ['number']))->isSame('number');
     * // クロージャは呼び出し結果が埋め込まれる
     * that(render_string('$c', ['c' => function($vars, $k){return $k . '-closure';}]))->isSame('c-closure');
     * // 引数をそのまま返すだけの特殊な変数 $_ が宣言される
     * that(render_string('{$_(123 + 456)}', []))->isSame('579');
     * // 要するに '$_()' の中に php の式が書けるようになる
     * that(render_string('{$_(implode(\',\', $strs))}', ['strs' => ['a', 'n', 'z']]))->isSame('a,n,z');
     * that(render_string('{$_(max($nums))}', ['nums' => [1, 9, 3]]))->isSame('9');
     * ```
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

    /**
     * "hoge {$hoge}" 形式のレンダリングのファイル版
     *
     * @see render_string()
     *
     * @param string $template_file レンダリングするファイル名
     * @param array $array レンダリング変数
     * @return string レンダリングされた文字列
     */
    public static function render_file($template_file, $array)
    {
        return (render_string)(file_get_contents($template_file), $array);
    }

    /**
     * 変数を extract して include する
     *
     * Example:
     * ```php
     * // このようなテンプレートファイルを用意すると
     * file_put_contents(sys_get_temp_dir() . '/template.php', '
     * This is plain text.
     * This is <?= $var ?>.
     * This is <?php echo strtoupper($var) ?>.
     * ');
     * // このようにレンダリングできる
     * that(ob_include(sys_get_temp_dir() . '/template.php', ['var' => 'hoge']))->isSame('
     * This is plain text.
     * This is hoge.
     * This is HOGE.
     * ');
     * ```
     *
     * @param string $include_file include するファイル名
     * @param array $array extract される連想変数
     * @return string レンダリングされた文字列
     */
    public static function ob_include($include_file, $array = [])
    {
        return (static function () {
            ob_start();
            extract(func_get_arg(1));
            include func_get_arg(0);
            return ob_get_clean();
        })($include_file, $array);
    }

    /**
     * 変数を extract して include する（文字列指定）
     *
     * @see ob_include()
     *
     * @param string $template テンプレート文字列
     * @param array $array extract される連想変数
     * @return string レンダリングされた文字列
     */
    public static function include_string($template, $array = [])
    {
        // opcache が効かない気がする
        $path = (memory_path)(__FUNCTION__);
        file_put_contents($path, $template);
        $result = (ob_include)($path, $array);
        unlink($path);
        return $result;
    }
}
