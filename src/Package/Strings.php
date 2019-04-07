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
     * assertSame(strcat('a', 'b', 'c'), 'abc');
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
     * assertSame(concat('prefix-', 'middle', '-suffix'), 'prefix-middle-suffix');
     * assertSame(concat('prefix-', '', '-suffix'), '');
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
     * assertSame(multiexplode([',', ' ', '|'], 'a,b c|d'), ['a', 'b', 'c', 'd']);
     * // 負数を与えると前詰め
     * assertSame(multiexplode(',', 'a,b,c,d', -2), ['a,b,c', 'd']);
     * // もちろん上記2つは共存できる
     * assertSame(multiexplode([',', ' ', '|'], 'a,b c|d', -2), ['a,b c', 'd']);
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
     * @param string|array $delimiter 分割文字列
     * @param string $string 対象文字列
     * @param array|string $enclosures 囲い文字。 ["start" => "end"] で開始・終了が指定できる
     * @param string $escape エスケープ文字
     * @return array 分割された配列
     */
    public static function quoteexplode($delimiter, $string, $enclosures = "'\"", $escape = '\\')
    {
        if (is_string($enclosures)) {
            $chars = str_split($enclosures);
            $enclosures = array_combine($chars, $chars);
        }

        $delimiters = (arrayize)($delimiter);
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
            if (empty($enclosing)) {
                foreach ($delimiters as $delimiter) {
                    $delimiterlen = strlen($delimiter);
                    if (substr_compare($string, $delimiter, $i, $delimiterlen) === 0) {
                        $result[] = substr($string, $current, $i - $current);
                        $current = $i + $delimiterlen;
                        break;
                    }
                }
            }
        }
        $result[] = substr($string, $current, $i);
        return $result;
    }

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
     * assertTrue(str_contains('abc', 'b'));
     * assertTrue(str_contains('abc', 'B', true));
     * assertTrue(str_contains('abc', ['b', 'x'], false, false));
     * assertFalse(str_contains('abc', ['b', 'x'], false, true));
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
     * assertSame(str_chop("$PATH/hoge.php", "$PATH/", '.php'), 'hoge');
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
     * assertSame(str_lchop("$PATH/hoge.php", "$PATH/"), 'hoge.php');
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
     * assertSame(str_rchop("$PATH/hoge.php", ".php"), "$PATH/hoge");
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
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 置換された文字列
     */
    public static function str_subreplace($subject, $search, $replaces, $case_insensitivity = false)
    {
        if (!is_array($replaces)) {
            $replaces = [$replaces];
        }

        // 空はそのまま返す
        if (empty($replaces)) {
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
     * assertSame(str_submap('hello, world', [
     *     // l は0番目と2番目のみを置換（1番目は何も行われない）
     *     'l' => [
     *         0 => 'L1',
     *         2 => 'L3',
     *     ],
     *     // o は後ろから数えて1番目を置換
     *     'o' => [
     *         -1 => 'O',
     *     ],
     * ]), 'heL1lo, wOrL3d');
     * ```
     *
     * @param string $subject 対象文字列
     * @param array $replaces 読み換え配列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 置換された文字列
     */
    public static function str_submap($subject, $replaces, $case_insensitivity = false)
    {
        assert((is_iterable)($replaces));

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
            $map = (is_iterable)($map) ? $map : [$map];
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
    public static function str_between($string, $from, $to, &$position = 0, $enclosure = '\'"', $escape = '\\')
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
     * assertSame(str_ellipsis('1234567890', 8, '...'), '12...890');
     * // 8文字に丸める（$pos=1 なので1文字目から省略される）
     * assertSame(str_ellipsis('1234567890', 8, '...', 1), '1...7890');
     * // 8文字に丸める（$pos=-1 なので後ろから1文字目から省略される）
     * assertSame(str_ellipsis('1234567890', 8, '...', -1), '1234...0');
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
     * 指定文字列で始まるか調べる
     *
     * $with に配列を渡すといずれかで始まるときに true を返す。
     *
     * Example:
     * ```php
     * assertTrue(starts_with('abcdef', 'abc'));
     * assertTrue(starts_with('abcdef', 'ABC', true));
     * assertFalse(starts_with('abcdef', 'xyz'));
     * assertTrue(starts_with('abcdef', ['a', 'b', 'c']));
     * assertFalse(starts_with('abcdef', ['x', 'y', 'z']));
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
     * assertTrue(ends_with('abcdef', 'def'));
     * assertTrue(ends_with('abcdef', 'DEF', true));
     * assertFalse(ends_with('abcdef', 'xyz'));
     * assertTrue(ends_with('abcdef', ['d', 'e', 'f']));
     * assertFalse(ends_with('abcdef', ['x', 'y', 'z']));
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
     * assertSame(camel_case('this_is_a_pen'), 'thisIsAPen');
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
     * assertSame(pascal_case('this_is_a_pen'), 'ThisIsAPen');
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
     * assertSame(snake_case('ThisIsAPen'), 'this_is_a_pen');
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
     * assertSame(chain_case('ThisIsAPen'), 'this-is-a-pen');
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
     * assertSame(namespace_split('ns\\hoge'), ['ns', 'hoge']);
     * assertSame(namespace_split('hoge'), ['', 'hoge']);
     * assertSame(namespace_split('ns\\'), ['ns', '']);
     * assertSame(namespace_split('\\hoge'), ['', 'hoge']);
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
     * assertSame(
     *     htmltag('a#hoge.c1.c2[name=hoge\[\]][href="http://hoge"][hidden]'),
     *     '<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden></a>'
     * );
     * // ペア配列を与えるとコンテント文字列になる
     * assertSame(
     *     htmltag(['a.c1#hoge.c2[name=hoge\[\]][href="http://hoge"][hidden]' => "this is text's content"]),
     *     '<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden>this is text&#039;s content</a>'
     * );
     * // ネストした配列を与えると再帰される
     * assertSame(
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
     *     ]),
     *     '<div id="wrapper"><b class="class1">&lt;plain&gt;</b><b class="class2">&lt;plain1&gt;<s>&lt;strike&gt;</s>&lt;plain2&gt;</b></div>'
     * );
     * ```
     *
     * @param string|array $selector
     * @return string html 文字列
     */
    public static function htmltag($selector)
    {
        if (!(is_iterable)($selector)) {
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
                list($k, $v) = explode('=', $attr, 2) + [1 => null];
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
            list(, $prefix, $tag, $suffix) = $m;
            $tag_attr = $html($tag) . (concat)(' ', implode(' ', $attrs));
            $content = ($escape ? $html($content) : $content);

            return "$prefix<$tag_attr>$content</$tag>$suffix";
        };

        $result = '';
        foreach ($selector as $key => $value) {
            if (is_int($key)) {
                $result .= $html($value);
            }
            elseif ((is_iterable)($value)) {
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
    public static function parse_uri($uri, $default = [])
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

    /**
     * 連想配列を INI 的文字列に変換する
     *
     * Example:
     * ```php
     * assertEquals(ini_export(['a' => 1, 'b' => 'B', 'c' => PHP_SAPI]), 'a = 1
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
                if ((is_iterable)($v)) {
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
     * assertEquals(ini_import("
     * a = 1
     * b = 'B'
     * c = PHP_VERSION
     * "), ['a' => 1, 'b' => 'B', 'c' => PHP_VERSION]);
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
     * メモリ効率は意識しない（どうせ元々配列を保持してるので意識しても無駄）。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * $csvarrays = [
     *     ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],             // 普通の行
     *     ['c' => 'C2', 'a' => 'A2', 'b' => 'B2'],             // 順番が入れ替わっている行
     *     ['c' => 'C3', 'a' => 'A3', 'b' => 'B3', 'x' => 'X'], // 余計な要素が入っている行
     * ];
     * assertEquals(csv_export($csvarrays), "a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ");
     *
     * // ヘッダを指定できる
     * assertEquals(csv_export($csvarrays, [
     *     'headers' => ['a' => 'A', 'c' => 'C'], // a と c だけを出力＋ヘッダ文字変更
     * ]), "A,C
     * A1,C1
     * A2,C2
     * A3,C3
     * ");
     * ```
     *
     * @param array $csvarrays 連想配列の配列
     * @param array $options オプション配列。fputcsv の第3引数以降もここで指定する
     * @return array CSV 的文字列
     */
    public static function csv_export($csvarrays, $options = [])
    {
        $options += [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape'    => '\\',
            'encoding'  => mb_internal_encoding(),
            'headers'   => [],
        ];

        $fp = fopen('php://temp', 'rw+');
        try {
            return (call_safely)(function ($fp, $csvarrays, $delimiter, $enclosure, $escape, $encoding, $headers) {
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
                fputcsv($fp, $headers, $delimiter, $enclosure, $escape);
                $default = array_fill_keys(array_keys($headers), '');

                foreach ($csvarrays as $array) {
                    $row = array_intersect_key(array_replace($default, $array), $default);
                    if ($encoding !== $mb_internal_encoding) {
                        mb_convert_variables($encoding, $mb_internal_encoding, $row);
                    }
                    fputcsv($fp, $row, $delimiter, $enclosure, $escape);
                }
                rewind($fp);
                return stream_get_contents($fp);
            }, $fp, $csvarrays, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers']);
        }
        finally {
            fclose($fp);
        }
    }

    /**
     * CSV 的文字列を連想配列の配列に変換する
     *
     * 1行目をヘッダ文字列とみなしてそれをキーとした連想配列の配列を返す。
     * ただし、オプションで headers が与えられた場合はそれを使用する。
     * この headers オプションはヘッダフィルタも兼ねる（[n => header] で「n 番目フィールドを header で取り込み」となる）。
     *
     * メモリ効率は意識しない（どうせ配列を返すので意識しても無駄）。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * assertEquals(csv_import("
     * a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * "), [
     *     ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],
     *     ['a' => 'A2', 'b' => 'B2', 'c' => 'C2'],
     *     ['a' => 'A3', 'b' => 'B3', 'c' => 'C3'],
     * ]);
     *
     * // ヘッダを指定できる
     * assertEquals(csv_import("
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ", [
     *     'headers' => [0 => 'a', 2 => 'c'], // 1がないので1番目のフィールドを読み飛ばしつつ、0, 2 は "a", "c" として取り込む
     * ]), [
     *     ['a' => 'A1', 'c' => 'C1'],
     *     ['a' => 'A2', 'c' => 'C2'],
     *     ['a' => 'A3', 'c' => 'C3'],
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
        ];

        if (is_resource($csvstring)) {
            $fp = $csvstring;
        }
        else {
            $fp = fopen('php://temp', 'r+b');
            fwrite($fp, $csvstring);
            rewind($fp);
        }

        try {
            return (call_safely)(function ($fp, $delimiter, $enclosure, $escape, $encoding, $headers) {
                $mb_internal_encoding = mb_internal_encoding();
                $result = [];
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
                    $result[] = array_combine($headers, array_intersect_key($row, $headers));
                }
                return $result;
            }, $fp, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers']);
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
     * assertEquals(json_export(['a' => 'A', 'b' => 'B'], [
     *    JSON_PRETTY_PRINT => false,
     * ]), '{"a":"A","b":"B"}');
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
     * assertEquals(json_import('{"a":"A","b":"B"}', [
     *    JSON_OBJECT_AS_ARRAY => true,
     * ]), ['a' => 'A', 'b' => 'B']);
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
     * 連想配列の配列を markdown テーブル文字列にする
     *
     * 見出しはキーの和集合で生成され、改行は `<br>` に置換される。
     * 要素が全て数値の場合は右寄せになる。
     *
     * Example:
     * ```php
     * // 最初の "\n" に意味はない（ズレると見づらいので冒頭に足しているだけ）
     * assertEquals("\n" . markdown_table([
     *    ['a' => 'a1', 'b' => 'b1'],
     *    ['b' => 'b2', 'c' => '2'],
     *    ['a' => 'a3', 'c' => '3'],
     * ]), "
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
     * assertEquals("\n" . markdown_list([
     *     'dict'        => [
     *         'Key1' => 'Value1',
     *         'Key2' => 'Value2',
     *     ],
     *     'list'        => ['Item1', 'Item2', 'Item3'],
     *     'dict & list' => [
     *         'Key' => 'Value',
     *         ['Item1', 'Item2', 'Item3'],
     *     ],
     * ], ['separator' => ':']), "
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
            foreach ((arrays)($array) as $n => list($k, $v)) {
                if ((is_iterable)($v)) {
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
     * assertSame(kvsprintf('%hoge$s %fuga$d', ['hoge' => 'ThisIs', 'fuga' => '3.14']), 'ThisIs 3');
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
     * assertSame(preg_replaces('#a(\d+)z#', [1 => 'XXX'], 'a123z'), 'aXXXz');
     * // 名前付きキャプチャも指定できる
     * assertSame(preg_replaces('#a(?<digit>\d+)z#', ['digit' => 'XXX'], 'a123z'), 'aXXXz');
     * // クロージャを渡すと元文字列を引数としてコールバックされる
     * assertSame(preg_replaces('#a(?<digit>\d+)z#', ['digit' => function($src){return $src * 2;}], 'a123z'), 'a246z');
     * // 複合的なサンプル（a タグの href と target 属性を書き換える）
     * assertSame(preg_replaces('#<a\s+href="(?<href>.*)"\s+target="(?<target>.*)">#', [
     *     'href'   => function($href){return strtoupper($href);},
     *     'target' => function($target){return strtoupper($target);},
     * ], '<a href="hoge" target="fuga">inner text</a>'), '<a href="HOGE" target="FUGA">inner text</a>');
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
     * assertSame(levenshtein("destroy", "destory"), 2);
     * // damerau_levenshtein だと1である
     * assertSame(damerau_levenshtein("destroy", "destory"), 1);
     * // UTF-8 でも大丈夫
     * assertSame(damerau_levenshtein("あいうえお", "あいえうお"), 1);
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
     * $string に最も近い文字列を返す
     *
     * レーベンシュタイン比の最も小さい要素を返す。
     *
     * この関数の結果（内部実装）は互換性を考慮しない。
     * 例えば現在は damerau_levenshtein で実装されているが、 similar_text になる可能性もある。
     *
     * Example:
     * ```php
     * // 「あいうえお」と最も距離の近い文字列は「あいゆえに」である
     * assertSame(str_guess("あいうえお", [
     *     'かきくけこ', // マッチ度 0%（1文字もかすらない）
     *     'ぎぼあいこ', // マッチ度 0%（"あい"はあるが位置が異なる）
     *     'かとうあい', // マッチ度 20%（"う"の位置が等しい）
     *     'あいしてる', // マッチ度 40&（"あい"がマッチ）
     *     'あいゆえに', // マッチ度 60&（"あい", "え"がマッチ）
     * ]), 'あいゆえに');
     * ```
     *
     * @param string $string 調べる文字列
     * @param array $candidates 候補文字列配列
     * @param int $percent マッチ度（％）を受ける変数
     * @return string 最も近い文字列
     */
    public static function str_guess($string, $candidates, &$percent = null)
    {
        $candidates = array_filter((arrayval)($candidates, false), 'strlen');
        if (!$candidates) {
            throw new \InvalidArgumentException('$candidates is empty.');
        }

        $sarray = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
        $closest = null;
        $shortest = PHP_INT_MAX;
        foreach ($candidates as $candidate) {
            $carray = preg_split('//u', $candidate, -1, PREG_SPLIT_NO_EMPTY);
            $delta = (damerau_levenshtein)($sarray, $carray) / max(count($sarray), count($carray));

            if ($delta < $shortest) {
                $closest = $candidate;
                $shortest = $delta;
            }

            if ($delta === 0) {
                break;
            }
        }

        $percent = intval(100 - $shortest * 100);

        return $closest;
    }

    /**
     * 文字列を区切り文字で区切って配列に変換する
     *
     * 典型的には http ヘッダとか sar の結果とかを配列にする。
     *
     * Example:
     * ```php
     * // http response header  を ":" 区切りで連想配列にする
     * assertSame(str_array("
     * HTTP/1.1 200 OK
     * Content-Type: text/html; charset=utf-8
     * Connection: Keep-Alive
     * ", ':', true), [
     *     'HTTP/1.1 200 OK',
     *     'Content-Type' => 'text/html; charset=utf-8',
     *     'Connection'   => 'Keep-Alive',
     * ]);
     *
     * // sar の結果を " " 区切りで連想配列の配列にする
     * assertSame(str_array("
     * 13:00:01        CPU     %user     %nice   %system   %iowait    %steal     %idle
     * 13:10:01        all      0.99      0.10      0.71      0.00      0.00     98.19
     * 13:20:01        all      0.60      0.10      0.56      0.00      0.00     98.74
     * ", ' ', false), [
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
     * assertSame(mb_substr_replace('０１２３４５６７８９', 'あいうえお', 2, 5), '０１あいうえお７８９');
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
     * assertSame(ob_include(sys_get_temp_dir() . '/template.php', ['var' => 'hoge']), '
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
