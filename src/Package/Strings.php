<?php

namespace ryunosuke\Functions\Package;

/**
 * 文字列関連のユーティリティ
 */
class Strings implements Interfaces\Strings
{
    /** json_*** 関数で $depth 引数を表す定数 */
    const JSON_MAX_DEPTH = -1;
    /** json_*** 関数でインデント数・文字を指定する定数 */
    const JSON_INDENT = -71;
    /** json_*** 関数でクロージャをサポートするかの定数 */
    const JSON_CLOSURE = -72;
    /** json_*** 関数で一定以上の階層をインライン化するかの定数 */
    const JSON_INLINE_LEVEL = -73;
    /** json_*** 関数でスカラーのみのリストをインライン化するかの定数 */
    const JSON_INLINE_SCALARLIST = -74;
    /** json_*** 関数で json5 を取り扱うかの定数 */
    const JSON_ES5 = -100;
    /** json_*** 関数で整数を常に文字列で返すかの定数 */
    const JSON_INT_AS_STRING = -101;
    /** json_*** 関数で小数を常に文字列で返すかの定数 */
    const JSON_FLOAT_AS_STRING = -102;
    /** json_*** 関数で強制ケツカンマを振るかの定数 */
    const JSON_TRAILING_COMMA = -103;
    /** json_*** 関数でコメントを判定するプレフィックス定数 */
    const JSON_COMMENT_PREFIX = -104;
    /** json_*** 関数でテンプレートリテラルを有効にするかの定数 */
    const JSON_TEMPLATE_LITERAL = -105;
    /** json_*** 関数で bare string を文字列として扱うか */
    const JSON_BARE_AS_STRING = -106;

    /**
     * 文字列結合の関数版
     *
     * Example:
     * ```php
     * that(strcat('a', 'b', 'c'))->isSame('abc');
     * ```
     *
     * @param mixed ...$variadic 結合する文字列（可変引数）
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
     * @param mixed ...$variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    public static function concat(...$variadic)
    {
        $result = '';
        foreach ($variadic as $s) {
            if (strlen($s = (string) $s) === 0) {
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
        $trim = ($trimchars === true) ? 'trim' : Funchand::rbind('trim', $trimchars);
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
            return array_reverse(array_map('strrev', Strings::multiexplode($delimiter, strrev($string), -$limit)));
        }
        // explode において 0 は 1 と等しい
        if ($limit === 0) {
            $limit = 1;
        }
        $delimiter = array_map(fn($v) => preg_quote($v, '#'), Arrays::arrayize($delimiter));
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
     * that(quoteexplode(',', 'a,b,c\\,d,"e,f"'))->isSame([
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     'c\\,d', // \\ でエスケープしているので区切り文字とみなされない
     *     '"e,f"', // "" でクオートされているので区切り文字とみなされない
     * ]);
     *
     * // $enclosures で囲い文字の開始・終了文字を明示できる
     * that(quoteexplode(',', 'a,b,{e,f}', null, ['{' => '}']))->isSame([
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     '{e,f}', // { } で囲まれているので区切り文字とみなされない
     * ]);
     * ```
     *
     * @param string|array $delimiter 分割文字列
     * @param string $string 対象文字列
     * @param ?int $limit 分割数。負数未対応
     * @param array|string $enclosures 囲い文字。 ["start" => "end"] で開始・終了が指定できる
     * @param string $escape エスケープ文字
     * @return array 分割された配列
     */
    public static function quoteexplode($delimiter, $string, $limit = null, $enclosures = "'\"", $escape = '\\')
    {
        if ($limit === null) {
            $limit = PHP_INT_MAX;
        }
        $limit = max(1, $limit);

        $delimiters = Arrays::arrayize($delimiter);
        $current = 0;
        $result = [];
        for ($i = 0, $l = strlen($string); $i < $l; $i++) {
            if (count($result) === $limit - 1) {
                break;
            }
            $i = Strings::strpos_quoted($string, $delimiters, $i, $enclosures, $escape);
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
        foreach (Vars::arrayval($needles, false) as $key => $needle) {
            $pos = strpos($haystack, $needle, $offset);
            if ($pos !== false) {
                $result[$key] = $pos;
            }
        }
        return $result;
    }

    /**
     * エスケープを考慮して strpos する
     *
     * 文字列中のエスケープ中でない生の文字を検索する。
     * 例えば `"abc\nxyz"` という文字列で `"n"` という文字は存在しないとみなす。
     * `"\n"` は改行のエスケープシーケンスであり、 `"n"` という文字ではない（エスケープシーケンスとして "n" を流用しているだけ）。
     * 逆に `"\\n"` はバックスラッシュと `"n"` という文字であり `"n"` が存在する。
     * 簡単に言えば「直前にバックスラッシュがある場合はヒットしない strpos」である。
     * バックスラッシュは $escape 引数で指定可能。
     *
     * $needle 自体にエスケープ文字を含む場合、反対の意味で検索する。
     * つまり、「直前にバックスラッシュがある場合のみヒットする strpos」になる。
     *
     * $offset 引数を指定するとその位置から探索を開始するが、戻り読みはしないのでエスケープ文字の真っ只中を指定する場合は注意。
     * 例えば `"\n"` は改行文字だけであるが、offset に 1 に指定して "n" を探すとマッチする。
     *
     * Example:
     * ```php
     * # 分かりにくいので \ ではなく % をエスケープ文字とする
     * $defargs = [0, '%'];
     *
     * // これは false である（"%d" という文字の列であるため "d" という文字は存在しない）
     * that(strpos_escaped('%d', 'd', ...$defargs))->isSame(false);
     * // これは 2 である（"%" "d" という文字の列であるため（d の前の % は更にその前の % に呑まれておりメタ文字ではない））
     * that(strpos_escaped('%%d', 'd', ...$defargs))->isSame(2);
     *
     * // これは 0 である（% をつけて検索するとそのエスケープシーケンス的なものそのものを探すため）
     * that(strpos_escaped('%d', '%d', ...$defargs))->isSame(0);
     * // これは false である（"%" "d" という文字の列であるため "%d" という文字は存在しない）
     * that(strpos_escaped('%%d', '%d', ...$defargs))->isSame(false);
     * // これは 2 である（"%" "%d" という文字の列であるため）
     * that(strpos_escaped('%%%d', '%d', ...$defargs))->isSame(2);
     * ```
     *
     * @param string $haystack 対象文字列
     * @param string|array $needle 探す文字
     * @param int $offset 開始位置
     * @param string $escape エスケープ文字
     * @param ?string $found 見つかった文字が格納される
     * @return false|int 見つかった位置
     */
    public static function strpos_escaped($haystack, $needle, $offset = 0, $escape = '\\', &$found = null)
    {
        $q_escape = preg_quote($escape, '#');
        if (Vars::is_stringable($needle)) {
            $needle = preg_split("#($q_escape?.)#u", $needle, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        }

        $needles = Vars::arrayval($needle);
        assert(!in_array($escape, $needles, true), sprintf('$needle must not contain only escape charactor ("%s")', implode(', ', $needles)));

        $matched = [];
        foreach (array_map(fn($c) => preg_quote($c, '#'), $needles) as $need) {
            if (preg_match_all("#((?:$q_escape)*?)($need)#u", $haystack, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER, $offset)) {
                foreach ($matches as [, $m_escape, $m_needle]) {
                    if ((strlen($m_escape[0]) / strlen($escape)) % 2 === 0) {
                        $matched[$m_needle[1]] ??= $m_needle[0];
                    }
                }
            }
        }
        if (!$matched) {
            $found = null;
            return false;
        }

        ksort($matched);
        $min = array_key_first($matched);
        $found = $matched[$min];
        return $min;
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
     * @param ?string $found $needle の内、見つかった文字列が格納される
     * @return false|int $needle の位置
     */
    public static function strpos_quoted($haystack, $needle, $offset = 0, $enclosure = "'\"", $escape = '\\', &$found = null)
    {
        if (is_string($enclosure)) {
            if (strlen($enclosure)) {
                $chars = str_split($enclosure);
                $enclosure = array_combine($chars, $chars);
            }
            else {
                $enclosure = [];
            }
        }
        $needles = Vars::arrayval($needle, false);

        $strlen = strlen($haystack);

        if ($offset < 0) {
            $offset += $strlen;
        }

        $found = null;
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
                        $found = $needle;
                        return $i;
                    }
                }
            }
        }
        return false;
    }

    /**
     * 文字列のバイト配列を得る
     *
     * $base 引数で基数を変更できる。
     *
     * Example:
     * ```php
     * // 10進配列で返す
     * that(str_bytes('abc'))->isSame([97, 98, 99]);
     * // 16進配列で返す
     * that(str_bytes('abc', 16))->isSame(["61", "62", "63"]);
     * // マルチバイトで余計なことはしない（php としての文字列のバイト配列をそのまま返す）
     * that(str_bytes('あいう', 16))->isSame(["e3", "81", "82", "e3", "81", "84", "e3", "81", "86"]);
     * ```
     *
     * @param string $string 対象文字列
     * @param int $base 基数
     * @return array 文字のバイト配列
     */
    public static function str_bytes($string, $base = 10)
    {
        // return array_values(unpack('C*', $string));

        $base = intval($base);
        $strlen = strlen($string);
        $result = [];
        for ($i = 0; $i < $strlen; $i++) {
            $ord = ord($string[$i]);
            if ($base !== 10) {
                $ord = base_convert($ord, 10, $base);
            }
            $result[] = $ord;
        }
        return $result;
    }

    /**
     * 文字列を可変引数の数で分割する
     *
     * str_split の $length を個別に指定できるイメージ。
     * 長さ以上を指定したりしても最後の要素は必ずついてくる（指定数で分割した後のあまり文字が最後の要素になる）。
     * これは最後が空文字でも同様で、 list での代入を想定しているため。
     *
     * Example:
     * ```php
     * // 1, 2, 3 文字に分割（ぴったりなので変わったことはない）
     * that(str_chunk('abcdef', 1, 2, 3))->isSame(['a', 'bc', 'def', '']);
     * // 2, 3 文字に分割（余った f も最後の要素として含まれてくる）
     * that(str_chunk('abcdef', 2, 3))->isSame(['ab', 'cde', 'f']);
     * // 1, 10 文字に分割
     * that(str_chunk('abcdef', 1, 10))->isSame(['a', 'bcdef', '']);
     * ```
     *
     * @param string $string 対象文字列
     * @param int ...$chunks 分割の各文字数（可変引数）
     * @return string[] 分割された文字列配列
     */
    public static function str_chunk($string, ...$chunks)
    {
        $offset = 0;
        $length = strlen($string);
        $result = [];
        foreach ($chunks as $chunk) {
            if ($offset >= $length) {
                break;
            }
            $result[] = substr($string, $offset, $chunk);
            $offset += $chunk;
        }
        $result[] = (string) substr($string, $offset);
        return $result;
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
     * that(str_exists('abc', 'b'))->isTrue();
     * that(str_exists('abc', 'B', true))->isTrue();
     * that(str_exists('abc', ['b', 'x'], false, false))->isTrue();
     * that(str_exists('abc', ['b', 'x'], false, true))->isFalse();
     * ```
     *
     * @param string $haystack 対象文字列
     * @param string|array $needle 調べる文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @param bool $and_flag すべて含む場合に true を返すか
     * @return bool $needle を含むなら true
     */
    public static function str_exists($haystack, $needle, $case_insensitivity = false, $and_flag = false)
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
    public static function str_chop($string, $prefix = '', $suffix = '', $case_insensitivity = false)
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
        return Strings::str_chop($string, $prefix, '', $case_insensitivity);
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
    public static function str_rchop($string, $suffix, $case_insensitivity = false)
    {
        return Strings::str_chop($string, '', $suffix, $case_insensitivity);
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
            if (is_array($array) && Arrays::array_depth($array) === 1) {
                $array = [$array];
            }
            return Funchand::call_safely(function ($fp, $array, $delimiter, $enclosure, $escape) {
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
        if (Vars::is_empty($replaces)) {
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
        if (Vars::is_empty($mapping)) {
            return $subject;
        }

        // いろいろ試した感じ正規表現が最もシンプルかつ高速だった

        $repkeys = array_keys($mapping);
        $counter = array_fill_keys($repkeys, 0);
        $patterns = array_map(fn($k) => preg_quote($k, '#'), $repkeys);

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
        $replacemap = Vars::arrayval($replacemap, false);
        uksort($replacemap, fn($a, $b) => strlen($b) - strlen($a));
        $srcs = array_keys($replacemap);

        $counter = array_fill_keys(array_keys($replacemap), 0);
        for ($i = 0; $i < strlen($string); $i++) {
            $i = Strings::strpos_quoted($string, $srcs, $i, $enclosure, $escape);
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
            $i = Strings::strpos_quoted($string, [$from, $to], $i, $enclosure, $escape);
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
     * 文字列を指定数に丸める
     *
     * mb_strimwidth と似ているが、省略文字の差し込み位置を $pos で指定できる。
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
        $pos ??= (int) ($length / 2);
        if ($pos < 0) {
            $pos += $length;
        }
        $pos = max(0, min($pos, $length));

        return Strings::mb_substr_replace($string, $trimmarker, $pos, $strlen - $length);
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
        $differ = new class($options) {
            private $options;

            public function __construct($options)
            {
                $options += [
                    'ignore-case'         => false,
                    'ignore-space-change' => false,
                    'ignore-all-space'    => false,
                    'stringify'           => 'unified',
                ];
                $this->options = $options;
            }

            public function __invoke($xstring, $ystring)
            {
                $xstring = is_array($xstring) ? array_values($xstring) : preg_split('#\R#u', $xstring);
                $ystring = is_array($ystring) ? array_values($ystring) : preg_split('#\R#u', $ystring);

                $trailingN = "";
                if ($xstring[count($xstring) - 1] === '' && $ystring[count($ystring) - 1] === '') {
                    $trailingN = "\n";
                    array_pop($xstring);
                    array_pop($ystring);
                }

                $diffs = $this->diff($xstring, $ystring);

                $stringfy = $this->options['stringify'];
                if (!$stringfy) {
                    return $diffs;
                }
                if ($stringfy === 'normal') {
                    $stringfy = [$this, 'normal'];
                }
                if (is_string($stringfy) && preg_match('#context(=(\d+))?#', $stringfy, $m)) {
                    $block_size = (int) ($m[2] ?? 3);
                    $stringfy = [$this, 'context'];
                }
                if (is_string($stringfy) && preg_match('#unified(=(\d+))?#', $stringfy, $m)) {
                    $block_size = isset($m[2]) ? (int) $m[2] : null;
                    $stringfy = fn($diff) => $this->unified($diff, $block_size);
                }
                if (is_string($stringfy) && preg_match('#html(=(.+))?#', $stringfy, $m)) {
                    $mode = $m[2] ?? null;
                    $stringfy = fn($diff) => $this->html($diff, $mode);
                }

                if (isset($block_size)) {
                    $result = implode("\n", array_map($stringfy, $this->block($diffs, $block_size)));
                }
                else {
                    $result = $stringfy($diffs);
                }

                return !strlen($result) ? $result : $result . $trailingN;
            }

            private function diff(array $xarray, array $yarray)
            {
                $convert = function ($string) {
                    if ($this->options['ignore-case']) {
                        $string = strtoupper($string);
                    }
                    if ($this->options['ignore-space-change']) {
                        $string = preg_replace('#\s+#u', ' ', $string);
                    }
                    if ($this->options['ignore-all-space']) {
                        $string = preg_replace('#\s+#u', '', $string);
                    }
                    return $string;
                };
                $xarray2 = array_map($convert, $xarray);
                $yarray2 = array_map($convert, $yarray);
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

                $common = $this->lcs(array_values($xarray2), array_values($yarray2));

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
            }

            private function lcs(array $xarray, array $yarray)
            {
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
                $llB = $this->length($xprefix, $yarray);
                $llE = $this->length(array_reverse($xsuffix), array_reverse($yarray));
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
                return array_merge($this->lcs($xprefix, $yprefix), $this->lcs($xsuffix, $ysuffix));
            }

            private function length(array $xarray, array $yarray)
            {
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
            }

            private function minmaxlen($diffs)
            {
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
            }

            private function normal($diffs)
            {
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
                            $difftext[] = implode("\n", array_map(fn($v) => $sign . $v, $diff[$n]));
                        }
                        $result[] = "{$index($diff[1])}{$rule[$diff[0]][0]}{$index($diff[2])}";
                        $result[] = implode("\n---\n", $difftext);
                    }
                }
                return implode("\n", $result);
            }

            private function context($diffs)
            {
                [$xmin, $xmax, , $ymin, $ymax,] = $this->minmaxlen($diffs);
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
                $result = ["***************"];
                foreach ($rules as $key => $rule) {
                    $result[] = $rule['header'];
                    if (array_filter($diffs, fn($d) => strpos($key, $d[0]) !== false)) {
                        foreach ($diffs as $diff) {
                            foreach ($rule[$diff[0]] ?? [] as $n => $sign) {
                                $result[] = implode("\n", array_map(fn($v) => $sign . $v, $diff[$n]));
                            }
                        }
                    }
                }
                return implode("\n", $result);
            }

            private function unified($diffs, $block_size)
            {
                $result = [];

                if ($block_size !== null) {
                    [$xmin, , $xlen, $ymin, , $ylen] = $this->minmaxlen($diffs);
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
                        $result[] = implode("\n", array_map(fn($v) => $sign . $v, $diff[$n]));
                    }
                }
                return implode("\n", $result);
            }

            private function html($diffs, $mode)
            {
                $htmlescape = function ($v) use (&$htmlescape) { return is_array($v) ? array_map($htmlescape, $v) : htmlspecialchars($v, ENT_QUOTES); };
                $taging = fn($tag, $content) => strlen($tag) && strlen($content) ? "<$tag>$content</$tag>" : $content;

                $rule = [
                    '+' => [2 => 'ins'],
                    '-' => [1 => 'del'],
                    '*' => [1 => 'del', 2 => 'ins'],
                    '=' => [1 => ''],
                ];
                $result = [];
                foreach ($diffs as $diff) {
                    if ($mode === 'perline' && $diff[0] === '*') {
                        $length = min(count($diff[1]), count($diff[2]));
                        $delete = array_splice($diff[1], 0, $length, []);
                        $append = array_splice($diff[2], 0, $length, []);
                        for ($i = 0; $i < $length; $i++) {
                            $options2 = ['stringify' => null] + $this->options;
                            $diffs2 = Strings::str_diff(preg_split('/(?<!^)(?!$)/u', $delete[$i]), preg_split('/(?<!^)(?!$)/u', $append[$i]), $options2);
                            $result2 = [];
                            foreach ($diffs2 as $diff2) {
                                foreach ($rule[$diff2[0]] as $n => $tag) {
                                    $content = $taging($tag, implode("", (array) $htmlescape($diff2[$n])));
                                    if (strlen($content)) {
                                        $result2[] = $content;
                                    }
                                }
                            }
                            $result[] = implode("", $result2);
                        }
                    }
                    foreach ($rule[$diff[0]] as $n => $tag) {
                        $content = $taging($tag, implode("\n", (array) $htmlescape($diff[$n])));
                        if ($diff[0] === '=' && !strlen($content)) {
                            $result[] = "";
                        }
                        if (strlen($content)) {
                            $result[] = $content;
                        }
                    }
                }
                return implode("\n", $result);
            }

            private function block($diffs, $block_size)
            {
                $head = fn($array) => array_slice($array, 0, $block_size, true);
                $tail = fn($array) => array_slice($array, -$block_size, null, true);

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
                return $blocks;
            }
        };

        return $differ($xstring, $ystring);
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
     * @param string|string[] $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return bool 指定文字列で始まるなら true を返す
     */
    public static function starts_with($string, $with, $case_insensitivity = false)
    {
        assert(Vars::is_stringable($string));

        foreach ((array) $with as $w) {
            assert(strlen($w));

            if (Strings::str_equals(substr($string, 0, strlen($w)), $w, $case_insensitivity)) {
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
     * @param string|string[] $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return bool 対象文字列で終わるなら true
     */
    public static function ends_with($string, $with, $case_insensitivity = false)
    {
        assert(Vars::is_stringable($string));

        foreach ((array) $with as $w) {
            assert(strlen($w));

            if (Strings::str_equals(substr($string, -strlen($w)), $w, $case_insensitivity)) {
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
        return lcfirst(Strings::pascal_case($string, $delimiter));
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
        return Strings::snake_case($string, $delimiter);
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
     * html の空白類を除去して minify する
     *
     * 文字列的ではなく DOM 的に行うのでおかしな部分 html を食わせると意図しない結果になる可能性がある。
     * その副作用として属性のクオートやタグ内空白は全て正規化される。
     *
     * html コメントも削除される。
     * また、空白が意味を持つタグ（textarea, pre）は対象にならない。
     * さらに、php を含むような html （テンプレート）の php タグは一切の対象外となる。
     *
     * これらの挙動の一部はオプションで指定が可能。
     *
     * Example:
     * ```php
     * // e.g. id が " でクオートされている
     * // e.g. class のクオートが " になっている
     * // e.g. タグ内空白（id, class の間隔等）がスペース1つになっている
     * // e.g. php タグは一切変更されていない
     * // e.g. textarea は保持されている
     * that(html_strip("<span  id=id  class='c1  c2  c3'><?= '<hoge>  </hoge>' ?> a  b  c </span> <pre> a  b  c </pre>"))->isSame('<span id="id" class="c1  c2  c3"><?= \'<hoge>  </hoge>\' ?> a b c </span><pre> a  b  c </pre>');
     * ```
     *
     * @param string $html html 文字列
     * @param array $options オプション配列
     * @return string 空白除去された html 文字列
     */
    public static function html_strip($html, $options = [])
    {
        $options += [
            'error-level'    => E_USER_ERROR, // エラー時の報告レベル
            'encoding'       => 'UTF-8',      // html のエンコーディング
            'escape-phpcode' => true,         // php タグを退避するか
            'html-comment'   => true,         // html コメントも対象にするか
            'ignore-tags'    => [
                // 空白を除去しない特別タグ
                'pre',      // html の仕様でそのまま表示
                'textarea', // html の仕様...なのかスタイルなのかは分からないが普通はそのまま表示だろう
                'script',   // type が js とは限らない。そもそも js だとしても下手にいじるのは怖すぎる
                'style',    // 同上
            ],
        ];

        $preserving = Strings::unique_string($html, 64, range('a', 'z'));
        $mapping = [];

        if ($options['escape-phpcode']) {
            $mapping = [];
            $html = Syntax::strip_php($html, [
                'replacer'       => $preserving,
                'trailing_break' => false,
            ], $mapping);
        }

        // xml 宣言がないとマルチバイト文字が html エンティティになってしまうし documentElement がないと <p> が自動付与されてしまう
        $docTag = "root-$preserving";
        $mapping["<$docTag>"] = '';
        $mapping["</$docTag>"] = '';
        $html = "<?xml encoding=\"{$options['encoding']}\"><$docTag>$html</$docTag>";

        // dom 化
        libxml_clear_errors();
        $current = libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOXMLDECL);
        if ($options['error-level']) {
            // http://www.xmlsoft.org/html/libxml-xmlerror.html
            $nohandling = [];
            $nohandling[] = 801;
            if (!$options['escape-phpcode']) {
                $nohandling[] = 46;
            }
            foreach (libxml_get_errors() as $error) {
                if (!in_array($error->code, $nohandling, true)) {
                    trigger_error($error->code . ': ' . $error->message, $options['error-level']);
                }
            }
        }
        libxml_use_internal_errors($current);

        $xpath = new \DOMXPath($dom);

        if ($options['html-comment']) {
            /** @var \DOMComment[] $comments */
            $comments = iterator_to_array($xpath->query('//comment()'), true);
            foreach ($comments as $comment) {
                $comment->parentNode->removeChild($comment);
            }
            $dom->documentElement->normalize();
        }

        /** @var \DOMText[] $texts */
        $texts = iterator_to_array($xpath->query('//text()'), true);
        $texts = array_values(array_filter($texts, function (\DOMNode $node) use ($options) {
            while ($node = $node->parentNode) {
                if (in_array($node->nodeName, $options['ignore-tags'], true)) {
                    return false;
                }
            }
            return true;
        }));
        // @see https://developer.mozilla.org/ja/docs/Web/API/Document_Object_Model/Whitespace
        foreach ($texts as $n => $text) {
            // 連続空白の正規化
            $text->data = preg_replace("#[\t\n\r ]+#u", " ", $text->data);

            // 空白の直後に他の空白がある場合は (2 つが別々なインライン要素をまたぐ場合も含めて) 無視
            if (($next = $texts[$n + 1] ?? null) && ($text->data[-1] ?? null) === ' ') {
                $next->data = ltrim($next->data, "\t\n\r ");
            }

            // 行頭と行末の一連の空白が削除される
            $prev = $text->previousSibling ?? $text->parentNode->previousSibling;
            if (!$prev || in_array($prev->nodeName, $options['ignore-tags'], true)) {
                $text->data = ltrim($text->data, "\t\n\r ");
            }
            $next = $text->nextSibling ?? $text->parentNode->nextSibling;
            if (!$next || in_array($next->nodeName, $options['ignore-tags'], true)) {
                $text->data = rtrim($text->data, "\t\n\r ");
            }
        }
        return trim(strtr($dom->saveHTML($dom->documentElement), $mapping), "\t\n\r ");
    }

    /**
     * 配列を html の属性文字列に変換する
     *
     * data-* や style, 論理属性など、全てよしなに変換して文字列で返す。
     * 返り値の文字列はエスケープが施されており、基本的にはそのまま html に埋め込んで良い。
     * （オプション次第では危険だったり乱れたりすることはある）。
     *
     * separator オプションを指定すると属性の区切り文字を指定できる。
     * 大抵の場合は半角スペースであり、少し特殊な場合に改行文字を指定するくらいだろう。
     * ただし、この separator に null を与えると文字列ではなく生の配列で返す。
     * この配列は `属性名 => 属性値` な生の配列であり、エスケープも施されていない。
     * $options 自体に文字列を与えた場合は separator 指定とみなされる。
     *
     * 属性の変換ルールは下記。
     *
     * - 属性名が数値の場合は属性としては生成されない
     * - 属性名は camelCase -> cahin-case の変換が行われる
     * - 値が null の場合は無条件で無視される
     *     - 下記 false との違いは「配列返しの場合に渡ってくるか？」である（null は無条件フィルタなので配列返しでも渡ってこない）
     * - 値が true の場合は論理属性とみなし値なしで生成される
     * - 値が false の場合は論理属性とみなし、 属性としては生成されない
     * - 値が配列の場合は ","（カンマ）で結合される
     *     - これは観測範囲内でカンマ区切りが多いため（srcset, accept など）。属性によってはカンマが適切ではない場合がある
     *     - 更にその配列が文字キーを持つ場合、キーが "=" で結合される
     *         - これは観測範囲内で = 区切りが多いため（viewport など）。属性によっては = が適切ではない場合がある
     * - 値が配列で属性名が class, style, data の場合は下記の特殊な挙動を示す
     *     - class: 半角スペースで結合される
     *         - キーは無視される
     *     - style: キーが css 名、値が css 値として ";" で結合される
     *         - キーは cahin-case に変換される
     *         - キーが数値の場合は値がそのまま追加される
     *         - 値が配列の場合は半角スペースで結合される
     *     - data-: キーが data 名、値が data 値として data 属性になる
     *         - キーは cahin-case に変換される
     *         - 値が真偽値以外のスカラーの場合はそのまま、非スカラー||真偽値の場合は json で埋め込まれる
     *             - これは jQuery において json をよしなに扱うことができるため
     *
     * ※ 上記における「配列」とは iterable を指すが、toString を実装した iterable なオブジェクトは toString が優先され、文字列とみなされる
     *
     * 複雑に見えるが「よしなに」やってくれると考えて良い。
     * 配列や真偽値で分岐が大量にあるが、大前提として「string だった場合は余計なことはしない」がある。
     * ので迷ったり予期しない結果の場合は呼び出し側で文字列化して呼べば良い。
     *
     * Example:
     * ```php
     * that(html_attr([
     *     // camelCase は camel-case になる
     *     'camelCase' => '<value>',
     *     // true は論理属性 true とみなし、値なし属性になる
     *     'checked'   => true,
     *     // false は論理属性 false とみなし、属性として現れない
     *     'disabled'  => false,
     *     // null は無条件で無視され、属性として現れない
     *     'readonly'  => null,
     *     // 配列はカンマで結合される
     *     'srcset'    => [
     *         'hoge.jpg 1x',
     *         'fuga.jpg 2x',
     *     ],
     *     // 連想配列は = で結合される
     *     'content'   => [
     *         'width' => 'device-width',
     *         'scale' => '1.0',
     *     ],
     *     // class はスペースで結合される
     *     'class'     => ['hoge', 'fuga'],
     *     // style 原則的に proerty:value; とみなす
     *     'style'     => [
     *         'color'           => 'red',
     *         'backgroundColor' => 'white',      // camel-case になる
     *         'margin'          => [1, 2, 3, 4], // スペースで結合される
     *         'opacity:0.5',                     // 直値はそのまま追加される
     *     ],
     *     // data- はその分属性が生える
     *     'data-'     => [
     *         'camelCase' => 123,
     *         'hoge'      => false,        // 真偽値は文字列として埋め込まれる
     *         'fuga'      => "fuga",       // 文字列はそのまま文字列
     *         'piyo'      => ['a' => 'A'], // 非スカラー以外は json になる
     *     ],
     * ], ['separator' => "\n"]))->is('camel-case="&lt;value&gt;"
     * checked
     * srcset="hoge.jpg 1x,fuga.jpg 2x"
     * content="width=device-width,scale=1.0"
     * class="hoge fuga"
     * style="color:red;background-color:white;margin:1 2 3 4;opacity:0.5"
     * data-camel-case="123"
     * data-hoge="false"
     * data-fuga="fuga"
     * data-piyo="{&quot;a&quot;:&quot;A&quot;}"');
     * ```
     *
     * @param iterable $array 属性配列
     * @param string|array|null $options オプション配列
     * @return string|array 属性文字列 or 属性配列
     */
    public static function html_attr($array, $options = [])
    {
        if (!is_array($options)) {
            $options = ['separator' => $options];
        }

        $options += [
            'quote'     => '"',  // 属性のクオート文字
            'separator' => " ",  // 属性の区切り文字
            'chaincase' => true, // 属性名, data などキーで camelCase を chain-case に変換するか
        ];

        $chaincase = static function ($string) use ($options) {
            if ($options['chaincase']) {
                return Strings::chain_case($string);
            }
            return $string;
        };
        $is_iterable = static function ($value) {
            if (is_array($value)) {
                return true;
            }
            if (is_object($value) && $value instanceof \Traversable && !method_exists($value, '__toString')) {
                return true;
            }
            return false;
        };
        $implode = static function ($glue, $iterable) use ($is_iterable) {
            if (!$is_iterable($iterable)) {
                return $iterable;
            }
            if (is_array($iterable)) {
                return implode($glue, $iterable);
            }
            return implode($glue, iterator_to_array($iterable));
        };

        $attrs = [];
        foreach ($array as $k => $v) {
            if ($v === null) {
                continue;
            }

            $k = $chaincase($k);
            assert(!isset($attrs[$k]));

            if (strpbrk($k, "\r\n\t\f '\"<>/=") !== false) {
                throw new \UnexpectedValueException('found invalid charactor as attribute name');
            }

            switch ($k) {
                default:
                    if ($is_iterable($v)) {
                        $tmp = [];
                        foreach ($v as $name => $value) {
                            $name = (is_string($name) ? "$name=" : '');
                            $value = $implode(';', $value);
                            $tmp[] = $name . $value;
                        }
                        $v = implode(',', $tmp);
                    }
                    break;
                case 'class':
                    $v = $implode(' ', $v);
                    break;
                case 'style':
                    if ($is_iterable($v)) {
                        $tmp = [];
                        foreach ($v as $property => $value) {
                            // css において CamelCace は意味を為さないのでオプションによらず強制的に chain-case にする
                            $property = (is_string($property) ? Strings::chain_case($property) . ":" : '');
                            $value = $implode(' ', $value);
                            $tmp[] = rtrim($property . $value, ';');
                        }
                        $v = implode(';', $tmp);
                    }
                    break;
                case 'data-':
                    if ($is_iterable($v)) {
                        foreach ($v as $name => $data) {
                            $name = $chaincase($name);
                            $data = is_scalar($data) && !is_bool($data) ? $data : json_encode($data);
                            $attrs[$k . $name] = $data;
                        }
                        continue 2;
                    }
                    break;
            }

            $attrs[$k] = is_bool($v) ? $v : (string) $v;
        }

        if ($options['separator'] === null) {
            return $attrs;
        }

        $result = [];
        foreach ($attrs as $name => $value) {
            if (is_int($name)) {
                continue;
            }
            if ($value === false) {
                continue;
            }
            elseif ($value === true) {
                $result[] = htmlspecialchars($name, ENT_QUOTES);
            }
            else {
                $result[] = htmlspecialchars($name, ENT_QUOTES) . '=' . $options['quote'] . htmlspecialchars($value, ENT_QUOTES) . $options['quote'];
            }
        }
        return implode($options['separator'], $result);
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

        $html = static fn($string) => htmlspecialchars($string, ENT_QUOTES);

        $build = static function ($selector, $content, $escape) use ($html) {
            $attrs = Strings::css_selector($selector);
            $tag = Arrays::array_unset($attrs, '', '');
            if (!strlen($tag)) {
                throw new \InvalidArgumentException('tagname is empty.');
            }
            if (isset($attrs['class'])) {
                $attrs['class'] = implode(' ', $attrs['class']);
            }
            foreach ($attrs as $k => $v) {
                if ($v === false) {
                    unset($attrs[$k]);
                    continue;
                }
                elseif ($v === true) {
                    $v = $html($k);
                }
                elseif (is_array($v)) {
                    $v = 'style="' . Arrays::array_sprintf($v, fn($style, $key) => is_int($key) ? $style : "$key:$style", ';') . '"';
                }
                else {
                    $v = sprintf('%s="%s"', $html($k), $html(preg_replace('#^([\"\'])|([^\\\\])([\"\'])$#u', '$2', $v)));
                }
                $attrs[$k] = $v;
            }

            preg_match('#(\s*)(.+)(\s*)#u', $tag, $m);
            [, $prefix, $tag, $suffix] = $m;
            $tag_attr = $html($tag) . Strings::concat(' ', implode(' ', $attrs));
            $content = ($escape ? $html($content) : $content);

            return "$prefix<$tag_attr>$content</$tag>$suffix";
        };

        $result = '';
        foreach ($selector as $key => $value) {
            if (is_int($key)) {
                $result .= $html($value);
            }
            elseif (is_iterable($value)) {
                $result .= $build($key, Strings::htmltag($value), false);
            }
            else {
                $result .= $build($key, $value, true);
            }
        }
        return $result;
    }

    /**
     * CSS セレクタ文字をパースして配列で返す
     *
     * 包含などではない属性セレクタを与えると属性として認識する。
     * 独自仕様として・・・
     *
     * - [!attr]: 否定属性として false を返す
     * - {styles}: style 属性とみなす
     *
     * がある。
     *
     * Example:
     * ```php
     * that(css_selector('#hoge.c1.c2[name=hoge\[\]][href="http://hoge"][hidden][!readonly]{width:123px;height:456px}'))->is([
     *     'id'       => 'hoge',
     *     'class'    => ['c1', 'c2'],
     *     'name'     => 'hoge[]',
     *     'href'     => 'http://hoge',
     *     'hidden'   => true,
     *     'readonly' => false,
     *     'style'    => [
     *         'width'  => '123px',
     *         'height' => '456px',
     *     ],
     * ]);
     * ```
     *
     * @param string $selector CSS セレクタ
     * @return array 属性配列
     */
    public static function css_selector($selector)
    {
        $tag = '';
        $id = '';
        $classes = [];
        $styles = [];
        $attrs = [];

        $context = null;
        $escaping = null;
        $chars = preg_split('##u', $selector, -1, PREG_SPLIT_NO_EMPTY);
        for ($i = 0, $l = count($chars); $i < $l; $i++) {
            $char = $chars[$i];
            if ($char === '"' || $char === "'") {
                $escaping = $escaping === $char ? null : $char;
            }

            if (!$escaping) {
                if ($context !== '{' && $context !== '[') {
                    if ($char === '#') {
                        if (strlen($id)) {
                            throw new \InvalidArgumentException('#id is multiple.');
                        }
                        $context = $char;
                        continue;
                    }
                    if ($char === '.') {
                        $context = $char;
                        $classes[] = '';
                        continue;
                    }
                }
                if ($char === '{') {
                    $context = $char;
                    $styles[] = '';
                    continue;
                }
                if ($char === ';') {
                    $styles[] = '';
                    continue;
                }
                if ($char === '}') {
                    $context = null;
                    continue;
                }
                if ($char === '[') {
                    $context = $char;
                    $attrs[] = '';
                    continue;
                }
                if ($char === ']') {
                    $context = null;
                    continue;
                }
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
            if ($context === '{') {
                $styles[count($styles) - 1] .= $char;
                continue;
            }
            if ($context === '[') {
                $attrs[count($attrs) - 1] .= $char;
                continue;
            }
        }

        $attrkv = [];
        if (strlen($tag)) {
            $attrkv[''] = $tag;
        }
        if (strlen($id)) {
            $attrkv['id'] = $id;
        }
        if ($classes) {
            $attrkv['class'] = $classes;
        }
        foreach ($styles as $style) {
            $declares = array_filter(array_map('trim', explode(';', $style)), 'strlen');
            foreach ($declares as $declare) {
                [$k, $v] = array_map('trim', explode(':', $declare, 2)) + [1 => null];
                if ($v === null) {
                    throw new \InvalidArgumentException("[$k] is empty.");
                }
                $attrkv['style'][$k] = $v;
            }
        }
        foreach ($attrs as $attr) {
            [$k, $v] = explode('=', $attr, 2) + [1 => true];
            if (array_key_exists($k, $attrkv)) {
                throw new \InvalidArgumentException("[$k] is dumplicated.");
            }
            if ($k[0] === '!') {
                $k = substr($k, 1);
                $v = false;
            }
            $attrkv[$k] = is_string($v) ? json_decode($v) ?? $v : $v;
        }

        return $attrkv;
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

        $parts['user'] = rawurlencode($parts['user']);
        $parts['pass'] = rawurlencode($parts['pass']);
        $parts['host'] = filter_var($parts['host'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? "[{$parts['host']}]" : $parts['host'];
        $parts['path'] = ltrim($parts['path'], '/');
        $parts['query'] = is_array($parts['query']) ? http_build_query($parts['query'], '', '&') : $parts['query'];

        $uri = '';
        $uri .= Strings::concat($parts['scheme'], '://');
        $uri .= Strings::concat($parts['user'] . Strings::concat(':', $parts['pass']), '@');
        $uri .= Strings::concat($parts['host']);
        $uri .= Strings::concat(':', $parts['port']);
        $uri .= Strings::concat('/', $parts['path']);
        $uri .= Strings::concat('?', $parts['query']);
        $uri .= Strings::concat('#', $parts['fragment']);
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
            $default = Strings::preg_capture("#^$regex\$#ix", (string) $default, $default_default);
        }

        // パース。先頭の // はスキーム省略とみなすので除去する
        $uri = Strings::preg_splice('#^//#', '', $uri);
        $parts = Strings::preg_capture("#^$regex\$#ix", $uri, $default + $default_default);

        // 諸々調整（認証エンコード、IPv6、パス / の正規化、クエリ配列化）
        $parts['user'] = rawurldecode($parts['user']);
        $parts['pass'] = rawurldecode($parts['pass']);
        $parts['host'] = Strings::preg_splice('#^\\[(.+)]$#', '$1', $parts['host']);
        $parts['path'] = Strings::concat('/', ltrim($parts['path'], '/'));
        if (is_string($parts['query'])) {
            parse_str($parts['query'], $parts['query']);
        }

        return $parts;
    }

    /**
     * 数値キーを削除する http_build_query
     *
     * php の世界において配列のクエリ表現は `var[]=1&var[]=2` で事足りる。
     * しかし http_build_query では数値キーでも必ず `var[0]=1&var[1]=2` になる。
     * それはそれで正しいし、他言語との連携が必要な場合はそうせざるを得ない状況もあるが、単純に php だけで配列を表したい場合は邪魔だし文字長が長くなる。
     * この関数を使うと数値キーを削除し、`var[]=1&var[]=2` のようなクエリ文字列を生成できる。
     *
     * シグネチャは http_build_query と同じで、 $numeric_prefix に数値的文字列を与えたときのみ動作が変化する。
     * （$numeric_prefix の意味を考えればこの引数に数値的文字列を与える意味は皆無だろうので流用している）。
     *
     * - 1 を与えると最前列を残して [] (%5B%5D) が置換される
     * - 2 を与えると最前列とその右を残して [] (%5B%5D) が置換される
     * - 要するに正数を与えると「abs(n) 個を残して [] (%5B%5D) を置換する」という指定になる
     * - -1 を与えると最後尾の [] (%5B%5D) が置換される
     * - -2 を与えると最後尾とその左の [] (%5B%5D) が置換される
     * - 要するに負数を与えると「右から abs(n) 個の [] (%5B%5D) を置換する」という指定になる
     *
     * この仕様は `v[][]=1&v[][]=2` のようなときにおいしくないためである。
     * これは `$v=[[1], [2]]` のような値になるが、この場合 `$v=[[1, 2]]` という値が欲しい、という事が多い。
     * そのためには `v[0][]=1&v[0][]=2` のようにする必要があるための数値指定である。
     *
     * @param array|object $data クエリデータ
     * @param string|int|null $numeric_prefix 数値キープレフィックス
     * @param string|null $arg_separator クエリセパレータ
     * @param int $encoding_type エンコードタイプ
     * @return string クエリ文字列
     */
    public static function build_query($data, $numeric_prefix = null, $arg_separator = null, $encoding_type = \PHP_QUERY_RFC1738)
    {
        $arg_separator ??= ini_get('arg_separator.output');

        if ($numeric_prefix === null || ctype_digit(trim($numeric_prefix, '-+'))) {
            $REGEX = '%5B\d+%5D';
            $NOSEQ = '%5B%5D';
            $numeric_prefix = $numeric_prefix === null ? null : (int) $numeric_prefix;
            $query = http_build_query($data, '', $arg_separator, $encoding_type);
            // 0は置換しないを意味する
            if ($numeric_prefix === 0) {
                return $query;
            }
            // null は無制限置換
            if ($numeric_prefix === null) {
                return preg_replace("#($REGEX)#u", $NOSEQ, $query);
            }
            // 正数は残す数とする
            if ($numeric_prefix > 0) {
                return preg_replace_callback("#(?:$REGEX)+#u", function ($m) use ($numeric_prefix) {
                    $braces = explode('%5D', $m[0]);
                    foreach (array_slice($braces, $numeric_prefix, null, true) as $n => $brace) {
                        $braces[$n] = rtrim($brace, '0123456789');
                    }
                    return implode('%5D', $braces);
                }, $query);
            }
            // 負数は後ろから n 個目まで
            $pattern = str_repeat("($REGEX)?", abs($numeric_prefix) - 1);
            return preg_replace_callback("#$pattern($REGEX=)#u", function ($m) use ($NOSEQ) {
                return str_repeat($NOSEQ, count(array_filter($m, 'strlen')) - 2) . "$NOSEQ=";
            }, $query);
        }
        else {
            return http_build_query($data, $numeric_prefix ?? '', $arg_separator, $encoding_type);
        }
    }

    /**
     * parse_str の返り値版
     *
     * 標準の parse_str は参照で受ける謎シグネチャなのでそれを返り値に変更したもの。
     *
     * @param string $query クエリ文字列
     * @return array クエリのパース結果配列
     */
    public static function parse_query($query)
    {
        parse_str($query, $result);
        return $result;
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
            $ishasharray = is_array($array) && Arrays::is_hasharray($array);
            return Arrays::array_sprintf($array, function ($v, $k) use ($generate, $key, $ishasharray) {
                if (is_iterable($v)) {
                    return $generate($v, $k);
                }

                if ($key === null) {
                    return $k . ' = ' . Vars::var_export2($v, true);
                }
                return ($ishasharray ? "{$key}[$k]" : "{$key}[]") . ' = ' . Vars::var_export2($v, true);
            }, "\n");
        };

        if ($options['process_sections']) {
            return Arrays::array_sprintf($iniarray, fn($v, $k) => "[$k]\n{$generate($v)}\n", "\n");
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
     * この headers オプションに連想配列を与えるとヘッダ文字列変換になる（[key => header] で「key を header で吐き出し」となる）。
     * 数値配列を与えると単純に順序指定での出力指定になるが、ヘッダ行が出力されなくなる。
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
     *
     * // ヘッダ行を出さない
     * that(csv_export($csvarrays, [
     *     'headers' => ['a', 'c'], // a と c だけを出力＋ヘッダ行なし
     * ]))->is("A1,C1
     * A2,C2
     * A3,C3
     * ");
     *
     * // structure:true で配列も扱える
     * that(csv_export([
     *     ['scalar' => '123', 'list' => ['list11', 'list12'], 'hash' => ['a' => 'hash1A', 'b' => 'hash1B']],
     *     ['scalar' => '456', 'list' => ['list21', 'list22'], 'hash' => ['a' => 'hash2A', 'b' => 'hash2B']],
     * ], [
     *     'structure' => true,
     * ]))->is("scalar,list[],list[],hash[a],hash[b]
     * 123,list11,list12,hash1A,hash1B
     * 456,list21,list22,hash2A,hash2B
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
            'headers'   => null,
            'structure' => false,
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
            $size = Funchand::call_safely(function ($fp, $csvarrays, $delimiter, $enclosure, $escape, $encoding, $headers, $structure, $callback) {
                $size = 0;
                $mb_internal_encoding = mb_internal_encoding();
                if ($structure) {
                    foreach ($csvarrays as $n => $array) {
                        $query = strtr(http_build_query($array, ''), ['%5B' => '[', '%5D' => ']']);
                        $csvarrays[$n] = array_map('rawurldecode', Strings::str_array(explode('&', $query), '=', true));
                    }
                }
                if (!$headers) {
                    $tmp = [];
                    foreach ($csvarrays as $array) {
                        // この関数は積集合のヘッダを出すと定義してるが、構造化の場合は和集合で出す
                        if ($structure) {
                            $tmp += $array;
                        }
                        else {
                            $tmp = array_intersect_key($tmp ?: $array, $array);
                        }
                    }
                    $keys = array_keys($tmp);
                    if ($structure) {
                        $tmp = [];
                        for ($i = 0, $l = count($keys); $i < $l; $i++) {
                            $key = $keys[$i];
                            if (isset($tmp[$key])) {
                                continue;
                            }
                            $tmp[$key] = true;
                            $p = strrpos($key, '[');
                            if ($p !== false) {
                                $plain = substr($key, 0, $p + 1);
                                for ($j = $i + 1; $j < $l; $j++) {
                                    if (Strings::starts_with($keys[$j], $plain)) {
                                        $tmp[$keys[$j]] = true;
                                    }
                                }
                            }
                        }
                        $keys = array_keys($tmp);
                    }
                    $headers = is_array($headers) ? $keys : array_combine($keys, $keys);
                }
                if (!Arrays::is_hasharray($headers)) {
                    $headers = array_combine($headers, $headers);
                }
                else {
                    $headerline = $headers;
                    if ($encoding !== $mb_internal_encoding) {
                        mb_convert_variables($encoding, $mb_internal_encoding, $headerline);
                    }
                    if ($structure) {
                        $headerline = array_map(fn($header) => preg_replace('#\[\d+]$#imu', '[]', $header), $headerline);
                    }
                    $size += fputcsv($fp, $headerline, $delimiter, $enclosure, $escape);
                }
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
            }, $fp, $csvarrays, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers'], $options['structure'], $options['callback']);
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
     * structure オプションが渡された場合は query like なヘッダーで配列になる。
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
     *
     * // structure:true で配列も扱える
     * that(csv_import("
     * scalar,list[],list[],hash[a],hash[b]
     * 123,list11,list12,hash1A,hash1B
     * 456,list21,list22,hash2A,hash2B
     * ", [
     *     'structure' => true,
     * ]))->is([
     *     ['scalar' => '123', 'list' => ['list11', 'list12'], 'hash' => ['a' => 'hash1A', 'b' => 'hash1B']],
     *     ['scalar' => '456', 'list' => ['list21', 'list22'], 'hash' => ['a' => 'hash2A', 'b' => 'hash2B']],
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
            'structure' => false,
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
            return Funchand::call_safely(function ($fp, $delimiter, $enclosure, $escape, $encoding, $headers, $headermap, $structure, $callback) {
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
                    if ($structure) {
                        $query = [];
                        foreach ($headers as $i => $header) {
                            $query[] = $header . "=" . rawurlencode($row[$i]);
                        }
                        parse_str(implode('&', $query), $row);
                        // csv の仕様上、空文字を置かざるを得ないが、数値配列の場合は空にしたいことがある
                        $row = Arrays::array_map_recursive($row, function ($v) {
                            if (is_array($v) && Arrays::is_indexarray($v)) {
                                return array_values(array_filter($v, function ($v) {
                                    if (is_array($v)) {
                                        $v = implode('', Arrays::array_flatten($v));
                                    }
                                    return strlen($v);
                                }));
                            }
                            return $v;
                        }, true, true);
                    }
                    else {
                        $row = array_combine($headers, array_intersect_key($row, $headers));
                    }
                    if ($headermap) {
                        $row = Arrays::array_pickup($row, $headermap);
                    }
                    if ($callback) {
                        if ($callback($row, $n) === false) {
                            continue;
                        }
                    }
                    $result[] = $row;
                }
                return $result;
            }, $fp, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers'], $options['headermap'], $options['structure'], $options['callback']);
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
     * 下記の拡張オプションがある。
     *
     * - JSON_INLINE_LEVEL: PRETTY_PRINT 時に指定以上の階層をインライン化する（数値以外にパスで階層も指定できる）
     * - JSON_INLINE_SCALARLIST: PRETTY_PRINT 時にスカラーのみのリストをインライン化する
     * - JSON_INDENT: PRETTY_PRINT 時にインデント数・文字列を指定する
     * - JSON_CLOSURE: 任意のリテラルを埋め込む
     *   - クロージャの返り値がそのまま埋め込まれるので、文字列化可能な結果を返さなければならない
     *
     * JSON_ES5 を与えると JSON5 互換でエンコードされる。
     * その際下記のプションも使用可能になる。
     *
     * - JSON_TRAILING_COMMA: 末尾カンマを強制する
     * - JSON_COMMENT_PREFIX: コメントとして埋め込まれるキープレフィックスを指定する
     *   - そのキーで始まる要素が文字列なら // コメントになる
     *   - そのキーで始まる要素が配列なら /* コメントになる
     *
     * Example:
     * ```php
     * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
     * that(json_export(['a' => 'A', 'b' => 'B'], [
     *    JSON_PRETTY_PRINT => false,
     * ]))->is('{"a":"A","b":"B"}');
     * // json5 でコメント付きかつ末尾カンマ強制モード
     * that(json_export(['a' => 'A', '#comment' => 'this is comment', 'b' => 'B'], [
     *    JSON_ES5            => true,
     *    JSON_TRAILING_COMMA => true,
     *    JSON_COMMENT_PREFIX => '#',
     *    JSON_PRETTY_PRINT   => true,
     * ]))->is('{
     *     a: "A",
     *     // this is comment
     *     b: "B",
     * }');
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
            JSON_THROW_ON_ERROR         => true, // 標準動作はエラーすら出ずに false を返すだけ
        ];
        $es5 = Arrays::array_unset($options, Strings::JSON_ES5, false);
        $comma = Arrays::array_unset($options, Strings::JSON_TRAILING_COMMA, false);
        $comment = Arrays::array_unset($options, Strings::JSON_COMMENT_PREFIX, '');
        $depth = Arrays::array_unset($options, Strings::JSON_MAX_DEPTH, 512);
        $indent = Arrays::array_unset($options, Strings::JSON_INDENT, null);
        $closure = Arrays::array_unset($options, Strings::JSON_CLOSURE, false);
        $inline_level = Arrays::array_unset($options, Strings::JSON_INLINE_LEVEL, 0);
        $inline_scalarlist = Arrays::array_unset($options, Strings::JSON_INLINE_SCALARLIST, false);

        $option = array_sum(array_keys(array_filter($options)));

        $encode = function ($value, $parents, $objective) use (&$encode, $option, $depth, $indent, $closure, $inline_scalarlist, $inline_level, $es5, $comma, $comment) {
            $nest = count($parents);

            if ($depth < $nest) {
                throw new \ErrorException('Maximum stack depth exceeded', JSON_ERROR_DEPTH);
            }
            if ($closure && $value instanceof \Closure) {
                return $value();
            }
            if (is_object($value)) {
                if ($value instanceof \JsonSerializable) {
                    return $encode($value->jsonSerialize(), $parents, false);
                }
                return $encode(Vars::arrayval($value, false), $parents, true);
            }
            if (is_array($value)) {
                $pretty_print = $option & JSON_PRETTY_PRINT;
                $force_object = $option & JSON_FORCE_OBJECT;

                $withoutcommentarray = $value;
                if ($es5 && strlen($comment)) {
                    $withoutcommentarray = array_filter($withoutcommentarray, fn($k) => strpos("$k", $comment) === false, ARRAY_FILTER_USE_KEY);
                }

                $objective = $force_object || $objective || Arrays::is_hasharray($withoutcommentarray);

                if (!$value) {
                    return $objective ? '{}' : '[]';
                }

                $inline = false;
                if ($inline_level) {
                    if (is_array($inline_level)) {
                        $inline = $inline || FileSystem::fnmatch_or(array_map(fn($v) => "$v.*", $inline_level), implode('.', $parents) . '.');
                    }
                    elseif (ctype_digit("$inline_level")) {
                        $inline = $inline || $inline_level <= $nest;
                    }
                    else {
                        $inline = $inline || fnmatch("$inline_level.*", implode('.', $parents) . '.');
                    }
                }
                if ($inline_scalarlist) {
                    $inline = $inline || !$objective && Arrays::array_all($value, fn($v) => Vars::is_primitive($v) || $v instanceof \Closure);
                }

                $break = $indent0 = $indent1 = $indent2 = $separator = '';
                $delimiter = ',';
                if ($pretty_print && !$inline) {
                    $break = "\n";
                    $separator = ' ';
                    $indent = $indent ?: 4;
                    $indent0 = ctype_digit("$indent") ? str_repeat(' ', ($nest + 0) * $indent) : str_repeat($indent, ($nest + 0));
                    $indent1 = ctype_digit("$indent") ? str_repeat(' ', ($nest + 1) * $indent) : str_repeat($indent, ($nest + 1));
                    $indent2 = ctype_digit("$indent") ? str_repeat(' ', ($nest + 2) * $indent) : str_repeat($indent, ($nest + 2));
                }
                if ($pretty_print && $inline) {
                    $separator = ' ';
                    $delimiter = ', ';
                }

                $n = 0;
                $count = count($withoutcommentarray);
                $result = ($objective ? '{' : '[') . $break;
                foreach ($value as $k => $v) {
                    if ($es5 && strlen($comment) && strpos("$k", $comment) === 0) {
                        if (!$pretty_print) {
                            $v = (array) $v;
                        }
                        if (is_array($v)) {
                            $comments = [];
                            foreach ($v as $vv) {
                                $comments[] = "$indent2$vv";
                            }
                            $result .= "$indent1/*$break" . implode($break, $comments) . "$break$indent1*/";
                        }
                        else {
                            $comments = [];
                            foreach (preg_split('#\\R#u', $v) as $vv) {
                                $comments[] = "$indent1// $vv";
                            }
                            $result .= implode($break, $comments);
                        }
                    }
                    else {
                        $result .= $indent1;
                        if ($objective) {
                            $result .= ($es5 && preg_match("#^[a-zA-Z_$][a-zA-Z0-9_$]*$#u", $k) ? $k : json_encode("$k")) . ":$separator";
                        }
                        $result .= $encode($v, Arrays::array_append($parents, $k), false);
                        if (++$n !== $count || ($comma && !$inline)) {
                            $result .= $delimiter;
                        }
                    }
                    $result .= $break;
                }
                return $result . $indent0 . ($objective ? '}' : ']');
            }

            if ($es5) {
                if (is_float($value) && is_nan($value)) {
                    return 'NaN';
                }
                if (is_float($value) && is_infinite($value) && $value > 0) {
                    return '+Infinity';
                }
                if (is_float($value) && is_infinite($value) && $value < 0) {
                    return '-Infinity';
                }
            }
            return json_encode($value, $option, $depth);
        };

        // 特別な状況（クロージャを使うとか ES5 でないとか）以外は 標準を使用したほうが遥かに速い
        if ($indent || $closure || $inline_scalarlist || $inline_level || $es5 || $comma || $comment) {
            return $encode($value, [], false);
        }
        else {
            return json_encode($value, $option, $depth);
        }
    }

    /**
     * json_decode のプロキシ関数
     *
     * 引数体系とデフォルト値を変更してある。
     *
     * JSON_ES5 に null か true を渡すと json5 としてでデコードする（null はまず json_decode で試みる、true は json5 のみ）。
     * その場合拡張オプションとして下記がある。
     *
     * - JSON_INT_AS_STRING: 常に整数を文字列で返す
     * - JSON_FLOAT_AS_STRING: 常に小数を文字列で返す
     * - JSON_BARE_AS_STRING: bare string を文字列として扱う
     * - JSON_TEMPLATE_LITERAL: テンプレートリテラルが使用可能になる
     *   - あくまで「文字列の括りに ` が使えるようになる」というものでテンプレートリテラルそのものではない
     *   - 冒頭のインデントがすべて除去され、最終段階で trim される
     *
     * Example:
     * ```php
     * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
     * that(json_import('{"a":"A","b":"B"}', [
     *    JSON_OBJECT_AS_ARRAY => true,
     * ]))->is(['a' => 'A', 'b' => 'B']);
     *
     * // json5 が使える
     * that(json_import('{a: "A", b: "B", }'))->is(['a' => 'A', 'b' => 'B']);
     *
     * // テンプレートリテラル
     * that(json_import('`
     *     1
     *     2
     *     3
     * `', [
     *     JSON_TEMPLATE_LITERAL => true,
     * ]))->is("1\n2\n3");
     * ```
     *
     * @param string $value JSON 文字列
     * @param array $options JSON_*** をキーにした連想配列。値が false は指定されていないとみなされる
     * @return mixed decode された値
     */
    public static function json_import($value, $options = [])
    {
        $specials = [
            JSON_OBJECT_AS_ARRAY           => true, // 個人的嗜好だが連想配列のほうが扱いやすい
            Strings::JSON_MAX_DEPTH        => 512,
            Strings::JSON_ES5              => null,
            Strings::JSON_INT_AS_STRING    => false,
            Strings::JSON_FLOAT_AS_STRING  => false,
            Strings::JSON_TEMPLATE_LITERAL => false,
            Strings::JSON_BARE_AS_STRING   => false,
        ];
        foreach ($specials as $key => $default) {
            $specials[$key] = $options[$key] ?? $default;
            unset($options[$key]);
        }
        $specials[JSON_THROW_ON_ERROR] = $options[JSON_THROW_ON_ERROR] ?? true;
        $specials[JSON_BIGINT_AS_STRING] = $options[JSON_BIGINT_AS_STRING] ?? false;
        if ($specials[Strings::JSON_INT_AS_STRING] || $specials[Strings::JSON_FLOAT_AS_STRING] || $specials[Strings::JSON_TEMPLATE_LITERAL] || $specials[Strings::JSON_BARE_AS_STRING]) {
            $specials[Strings::JSON_ES5] = true;
        }

        // true でないならまず json_decode で試行（json が来るならその方が遥かに速い）
        if ($specials[Strings::JSON_ES5] === false || $specials[Strings::JSON_ES5] === null) {
            $option = array_sum(array_keys(array_filter($options)));
            $result = json_decode($value, $specials[JSON_OBJECT_AS_ARRAY], $specials[Strings::JSON_MAX_DEPTH], $option);

            // エラーが出なかったらもうその時点で返せば良い
            if (json_last_error() === JSON_ERROR_NONE) {
                return $result;
            }
            // json5 を試行しないモードならこの時点で例外
            if ($specials[Strings::JSON_ES5] === false) {
                throw new \ErrorException(json_last_error_msg(), json_last_error());
            }
        }

        // 上記を通り抜けたら json5 で試行
        $parser = new class($value) {
            private $json_string;
            private $type;
            private $begin_position;
            private $end_position;
            private $keys;
            private $values;

            public function __construct($json_string)
            {
                $this->json_string = "[$json_string]";
            }

            public function parse($options)
            {
                error_clear_last();
                $tokens = @Syntax::parse_php($this->json_string, [
                    'cache' => false,
                ]);
                $error = error_get_last();
                if (strpos($error['message'] ?? '', 'Unterminated comment') !== false) {
                    throw new \ErrorException(sprintf('%s at line %d of the JSON5 data', "Unterminated block comment", $error['line']));
                }
                array_shift($tokens);

                $braces = [];
                for ($i = 0; $i < count($tokens); $i++) {
                    $token = $tokens[$i];
                    if ($token[1] === '{' || $token[1] === '[') {
                        if ($options[Strings::JSON_MAX_DEPTH] <= count($braces) + 1) {
                            throw $this->exception("Maximum stack depth exceeded", $token);
                        }
                        $braces[] = $i;
                    }
                    elseif ($token[1] === '}' || $token[1] === ']') {
                        if (!$braces) {
                            throw $this->exception("Mismatch", $token);
                        }
                        $brace = array_pop($braces);
                        if ($tokens[$brace][1] !== '{' && $token[1] === '}' || $tokens[$brace][1] !== '[' && $token[1] === ']') {
                            throw $this->exception("Mismatch", $token);
                        }
                        $block = array_filter(array_slice(array_splice($tokens, $brace + 1, $i - $brace, []), 0, -1), fn($token) => !(is_array($token) && in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT, T_BAD_CHARACTER], true)));
                        $elements = Arrays::array_explode($block, fn($token) => is_array($token) && $token[1] === ',');
                        // for trailing comma
                        if ($elements && !$elements[count($elements) - 1]) {
                            array_pop($elements);
                        }
                        // check consecutive comma (e.g. [1,,3])
                        if (count(array_filter($elements)) !== count($elements)) {
                            throw $this->exception("Missing element", $token);
                        }
                        $i = $brace;
                        if ($token[1] === '}') {
                            $object = $this->token('object', $tokens[$brace][3], $token[3] + strlen($token[1]));
                            foreach ($elements as $element) {
                                $keyandval = Arrays::array_explode($element, fn($token) => is_array($token) && $token[1] === ':');
                                // check no colon (e.g. {123})
                                if (count($keyandval) !== 2) {
                                    throw $this->exception("Missing object key", Arrays::first_value($keyandval[0]));
                                }
                                // check objective key (e.g. {[1]: 123})
                                if (($k = Arrays::array_find($keyandval[0], 'is_object')) !== false) {
                                    throw $this->exception("Unexpected object key", $keyandval[0][$k]);
                                }
                                // check consecutive objective value (e.g. {k: 123 [1]})
                                if (!(count($keyandval[1]) === 1 && count(array_filter($keyandval[1], 'is_object')) === 1 || count(array_filter($keyandval[1], 'is_array')) === count($keyandval[1]))) {
                                    throw $this->exception("Unexpected object value", $token);
                                }
                                $key = Arrays::first_value($keyandval[0]);
                                $lastkey = Arrays::last_value($keyandval[0]);
                                $val = Arrays::first_value($keyandval[1]);
                                $lastval = Arrays::last_value($keyandval[1]);
                                if (!is_object($val)) {
                                    $val = $this->token('value', $val[3], $lastval[3] + strlen($lastval[1]));
                                }
                                $object->append($this->token('key', $key[3], $lastkey[3] + strlen($lastkey[1])), $val);
                            }
                            $tokens[$brace] = $object;
                        }
                        if ($token[1] === ']') {
                            $array = $this->token('array', $tokens[$brace][3], $token[3] + strlen($token[1]));
                            foreach ($elements as $element) {
                                // check consecutive objective value (e.g. [123 [1]])
                                if (!(count($element) === 1 && count(array_filter($element, 'is_object')) === 1 || count(array_filter($element, 'is_array')) === count($element))) {
                                    throw $this->exception("Unexpected array value", $token);
                                }
                                $val = Arrays::first_value($element);
                                $lastval = Arrays::last_value($element);
                                if (!is_object($val)) {
                                    $val = $this->token('value', $val[3], $lastval[3] + strlen($lastval[1]));
                                }
                                $array->append(null, $val);
                            }
                            $tokens[$brace] = $array;
                        }
                    }
                }

                if ($braces) {
                    throw $this->exception("Mismatch", $tokens[$braces[count($braces) - 1]]);
                }

                /** @var self $root */
                $root = $tokens[0];
                $result = $root->value($options);

                if (count($result) !== 1) {
                    throw $this->exception("Mismatch", $tokens[0]);
                }
                return $result[0];
            }

            private function token($type, $begin_position, $end_position)
            {
                $clone = clone $this;
                $clone->type = $type;
                $clone->begin_position = $begin_position;
                $clone->end_position = $end_position;
                $clone->keys = [];
                $clone->values = [];
                return $clone;
            }

            private function append($key, $value)
            {
                assert(($key !== null && $this->type === 'object') || ($key === null && $this->type === 'array'));
                $this->keys[] = $key ?? count($this->keys);
                $this->values[] = $value;
            }

            private function value($options = [])
            {
                $numberify = function ($token) use ($options) {
                    if (is_numeric($token[0]) || $token[0] === '-' || $token[0] === '+' || $token[0] === '.') {
                        $sign = 1;
                        if ($token[0] === '+' || $token[0] === '-') {
                            $sign = substr($token, 0, 1) === '-' ? -1 : 1;
                            $token = substr($token, 1);
                        }
                        if (($token[0] ?? null) === '0' && isset($token[1]) && $token[1] !== '.') {
                            if (!($token[1] === 'x' || $token[1] === 'X')) {
                                throw $this->exception("Octal literal", $this);
                            }
                            $token = substr($token, 2);
                            if (!ctype_xdigit($token)) {
                                throw $this->exception("Bad hex number", $this);
                            }
                            $token = hexdec($token);
                        }
                        if (!is_numeric($token) || !is_finite($token)) {
                            throw $this->exception("Bad number", $this);
                        }
                        if (false
                            || ($options[Strings::JSON_INT_AS_STRING] && ctype_digit("$token"))
                            || ($options[Strings::JSON_FLOAT_AS_STRING] && !ctype_digit("$token"))
                            || ($options[JSON_BIGINT_AS_STRING] && ctype_digit("$token") && is_float(($token + 0)))
                        ) {
                            return $sign === -1 ? "-$token" : $token;
                        }

                        return 0 + $sign * $token;
                    }
                    return null;
                };
                $stringify = function ($token) use ($options) {
                    if (strlen($token) > 1 && ($token[0] === '"' || $token[0] === "'" || ($options[Strings::JSON_TEMPLATE_LITERAL] && $token[0] === "`"))) {
                        if ($token[0] !== $token[-1]) {
                            throw $this->exception("Bad string", $this);
                        }
                        $quotation = $token[0];
                        $token = substr($token, 1, -1);
                        if ($quotation === "`" && preg_match('#^\n( +)#u', $token, $match)) {
                            $token = trim(preg_replace("#^{$match[1]}#um", '', $token));
                        }
                        $token = preg_replace_callback('/(?:\\\\u[0-9A-Fa-f]{4})+/u', function ($m) { return json_decode('"' . $m[0] . '"'); }, $token);
                        $token = strtr($token, [
                            "\\'"    => "'",
                            '\\"'    => '"',
                            '\\\\'   => '\\',
                            '\\/'    => '/',
                            "\\\n"   => "",
                            "\\\r"   => "",
                            "\\\r\n" => "",
                            '\\b'    => chr(8),
                            '\\f'    => "\f",
                            '\\n'    => "\n",
                            '\\r'    => "\r",
                            '\\t'    => "\t",
                        ]);
                        return $token;
                    }
                    return null;
                };

                switch ($this->type) {
                    default:
                        throw new \DomainException(); // @codeCoverageIgnore
                    case 'array':
                        return array_map(fn($value) => $value->value($options), $this->values);
                    case 'object':
                        $array = array_combine(
                            array_map(fn($value) => $value->value($options), $this->keys),
                            array_map(fn($value) => $value->value($options), $this->values)
                        );
                        return $options[JSON_OBJECT_AS_ARRAY] ? $array : (object) $array;
                    case 'key':
                        $token = substr($this->json_string, $this->begin_position, $this->end_position - $this->begin_position);
                        $token = trim($token, chr(0xC2) . chr(0xA0) . " \n\r\t\v\x00\x0c");
                        if (preg_match('/^(?:[\$_\p{L}\p{Nl}]|\\\\u[0-9A-Fa-f]{4})(?:[\$_\p{L}\p{Nl}\p{Mn}\p{Mc}\p{Nd}\p{Pc}‌‍]|\\\\u[0-9A-Fa-f]{4})*/u', $token)) {
                            $token = preg_replace_callback('/(?:\\\\u[0-9A-Fa-f]{4})+/u', fn($m) => json_decode('"' . $m[0] . '"'), $token);
                            return $token;
                        }
                        if (($string = $stringify($token)) !== null) {
                            return $string;
                        }
                        throw $this->exception("Bad identifier", $this);
                    case 'value':
                        $token = substr($this->json_string, $this->begin_position, $this->end_position - $this->begin_position);
                        $token = trim($token, chr(0xC2) . chr(0xA0) . " \n\r\t\v\x00\x0c");
                        $literals = [
                            'null'      => null,
                            'false'     => false,
                            'true'      => true,
                            'Infinity'  => INF,
                            '+Infinity' => +INF,
                            '-Infinity' => -INF,
                            'NaN'       => NAN,
                            '+NaN'      => +NAN,
                            '-NaN'      => -NAN,
                        ];
                        // literals
                        if (array_key_exists($token, $literals)) {
                            return $literals[$token];
                        }
                        // numbers
                        if (($number = $numberify($token)) !== null) {
                            return $number;
                        }
                        // strings
                        if (($string = $stringify($token)) !== null) {
                            return $string;
                        }
                        if ($options[Strings::JSON_BARE_AS_STRING]) {
                            return $token;
                        }
                        throw $this->exception("Bad value", $this);
                }
            }

            private function exception($message, $token)
            {
                $line = $column = $word = null;
                if (is_array($token)) {
                    $line = $token[2];
                    $column = $token[3] - strrpos($this->json_string, "\n", $token[3] - strlen($this->json_string));
                    $word = $token[1];
                }
                if (is_object($token)) {
                    $line = substr_count($token->json_string, "\n", 0, $token->begin_position) + 1;
                    $column = $token->begin_position - strrpos($token->json_string, "\n", $token->begin_position - strlen($token->json_string));
                    $word = substr($token->json_string, $token->begin_position, $token->end_position - $token->begin_position);
                }
                return new \ErrorException(sprintf("%s '%s' at line %d column %d of the JSON5 data", $message, $word, $line, $column));
            }
        };

        try {
            return $parser->parse($specials);
        }
        catch (\Throwable $t) {
            if ($specials[JSON_THROW_ON_ERROR]) {
                throw $t;
            }
            // json_last_error を設定する術はないので強制的に Syntax error にする（return することで返り値も統一される）
            return @json_decode('invalid json');
        }
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
                $inner = Strings::paml_export($v, $options);
                if (Arrays::is_hasharray($v)) {
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
     * paml とは yaml を簡易化したような独自フォーマットを指す（Php Array Markup Language）。
     * ざっくりと下記のような特徴がある。
     *
     * - ほとんど yaml と同じだがフロースタイルのみでキーコロンの後のスペースは不要
     * - yaml のアンカーや複数ドキュメントのようなややこしい仕様はすべて未対応
     * - 配列を前提にしているので、トップレベルの `[]` `{}` は不要
     * - `[]` でいわゆる php の配列、 `{}` で stdClass を表す（オプション指定可能）
     * - bare string で php の定数を表す（クラス定数も完全修飾すれば使用可能）
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
     * // bare 文字列で定数が使える。::class も特別扱いで定数とみなす
     * that(paml_import('pv:PHP_VERSION, ao:ArrayObject::STD_PROP_LIST, class:ArrayObject::class'))->isSame([
     *     'pv'    => \PHP_VERSION,
     *     'ao'    => \ArrayObject::STD_PROP_LIST,
     *     'class' => \ArrayObject::class,
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
            'stdclass'       => true,
            'expression'     => false,
            'escapers'       => ['"' => '"', "'" => "'", '[' => ']', '{' => '}'],
        ];

        static $caches = [];
        if ($options['cache']) {
            $key = $pamlstring . json_encode($options);
            return $caches[$key] ??= Strings::paml_import($pamlstring, ['cache' => false] + $options);
        }

        $resolve = function (&$value) use ($options) {
            $prefix = $value[0] ?? null;
            $suffix = $value[-1] ?? null;

            if (($prefix === '[' && $suffix === ']') || ($prefix === '{' && $suffix === '}')) {
                $values = Strings::paml_import(substr($value, 1, -1), $options);
                $value = ($prefix === '[' || !$options['stdclass']) ? (array) $values : (object) $values;
                return true;
            }

            if ($prefix === '"' && $suffix === '"') {
                //$element = stripslashes(substr($element, 1, -1));
                $value = json_decode($value);
                return true;
            }
            if ($prefix === "'" && $suffix === "'") {
                $value = substr($value, 1, -1);
                return true;
            }

            if (ctype_digit(ltrim($value, '+-'))) {
                $value = (int) $value;
                return true;
            }
            if (is_numeric($value)) {
                $value = (double) $value;
                return true;
            }

            if (defined($value)) {
                $value = constant($value);
                return true;
            }
            [$class, $cname] = explode('::', $value, 2) + [1 => ''];
            if (class_exists($class) && strtolower($cname) === 'class') {
                $value = ltrim($class, '\\');
                return true;
            }

            if ($options['expression']) {
                $semicolon = ';';
                if ($prefix === '`' && $suffix === '`') {
                    $value = eval("return " . substr($value, 1, -1) . $semicolon);
                    return true;
                }
                try {
                    $evalue = @eval("return $value$semicolon");
                    if ($value !== $evalue) {
                        $value = $evalue;
                        return true;
                    }
                }
                catch (\ParseError $e) {
                }
            }

            return false;
        };

        $values = array_map('trim', Strings::quoteexplode(',', $pamlstring, null, $options['escapers']));
        if ($options['trailing-comma'] && end($values) === '') {
            array_pop($values);
        }

        $result = [];
        foreach ($values as $value) {
            $key = null;
            if (!$resolve($value)) {
                $kv = array_map('trim', Strings::quoteexplode(':', $value, 2, $options['escapers']));
                if (count($kv) === 2) {
                    [$key, $value] = $kv;
                    $resolve($value);
                }
            }

            Arrays::array_put($result, $value, $key);
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
            'encode' => fn($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
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
            $should_encode = !Vars::is_stringable($value);
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
            'decode' => fn($v) => json_decode($v, true),
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
                if (!Vars::is_stringable($value2)) {
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
     * @param array $option オプション配列
     * @return string markdown テーブル文字列
     */
    public static function markdown_table($array, $option = [])
    {
        if (!is_array($array) || Vars::is_empty($array)) {
            throw new \InvalidArgumentException('$array must be array of hasharray.');
        }

        $option += [
            'keylabel' => null, // 指定すると一番左端にキーの列が生える
        ];

        $defaults = [];
        $numerics = [];
        $lengths = [];
        foreach ($array as $n => $fields) {
            assert(is_array($fields), '$array must be array of hasharray.');
            if ($option['keylabel'] !== null) {
                $fields = [$option['keylabel'] => $n] + $fields;
            }
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
            foreach (Arrays::arrays($array) as $n => [$k, $v]) {
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
     * 文字列に含まれない文字列を生成する
     *
     * 例えば http のマルチパートバウンダリのような、「競合しない文字列」を生成する。
     * 実装は愚直に文字列を調べて存在しなければそれを返すようになっている。
     * 一応初期値や文字セットは指定可能。
     *
     * $initial に int を与えると初期値としてその文字数分 $charlist から確保する。
     * 例えば生成後の変更が前提で、ある程度の長さを担保したいときに指定すれば最低でもその長さ以上は保証される。
     * $initial に string を与えるとそれがそのまま初期値として使用される。
     * 例えば「ほぼ存在しない文字列」が予測できるのであればそれを指定すれば無駄な処理が省ける。
     *
     * Example:
     * ```php
     * // 単純に呼ぶと生成1,2文字程度の文字列になる
     * that(unique_string('hello, world'))->stringLengthEqualsAny([1, 2]);
     * // 数値を含んでいないので候補文字に数値のみを指定すれば1文字で「存在しない文字列」となる
     * that(unique_string('hello, world', null, range(0, 9)))->stringLengthEquals(1);
     * // int を渡すと最低でもそれ以上は保証される
     * that(unique_string('hello, world', 5))->stringLengthEqualsAny([5, 6]);
     * // string を渡すとそれが初期値となる
     * that(unique_string('hello, world', 'prefix-'))->stringStartsWith('prefix');
     * ```
     *
     * @param string $source 元文字列
     * @param string|int $initial 初期文字列あるいは文字数
     * @param string|array $charlist 使用する文字セット
     * @return string 一意な文字列
     */
    public static function unique_string($source, $initial = null, $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        assert(Vars::is_stringable($initial) || is_int($initial) || is_null($initial));

        if (Vars::is_stringable($charlist)) {
            $charlist = preg_split('//', $charlist, -1, PREG_SPLIT_NO_EMPTY);
        }

        $charlength = count($charlist);
        if ($charlength === 0) {
            throw new \InvalidArgumentException('charlist is empty.');
        }

        $result = '';
        if (is_int($initial)) {
            shuffle($charlist);
            $result = implode('', array_slice($charlist, 0, $initial));
        }
        elseif (Vars::is_stringable($initial)) {
            $result = $initial;
        }

        $p = 0;
        do {
            $result .= $charlist[mt_rand(0, $charlength - 1)];
        } while (($p = strpos($source, $result, $p)) !== false);

        return $result;
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
     * that(preg_splice('#[a-z]+#', fn($m) => strtoupper($m[0]), 'abc123', $m))->isSame('ABC123');
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
     * that(preg_replaces('#a(?<digit>\d+)z#', ['digit' => fn($src) => $src * 2], 'a123z'))->isSame('a246z');
     * // 複合的なサンプル（a タグの href と target 属性を書き換える）
     * that(preg_replaces('#<a\s+href="(?<href>.*)"\s+target="(?<target>.*)">#', [
     *     'href'   => fn($href) => strtoupper($href),
     *     'target' => fn($target) => strtoupper($target),
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
        if (!Vars::is_arrayable($replacements)) {
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
     * $percent で一致度を受けられる。
     * 予め値が入った変数を渡すとその一致度以上の候補を高い順で配列で返す。
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
     *
     * // マッチ度30%以上を高い順に配列で返す
     * $percent = 30;
     * that(str_guess("destory", [
     *     'describe',
     *     'destroy',
     *     'destruct',
     *     'destiny',
     *     'destinate',
     * ], $percent))->isSame([
     *     'destroy',
     *     'destiny',
     *     'destruct',
     * ]);
     * ```
     *
     * @param string $string 調べる文字列
     * @param array $candidates 候補文字列配列
     * @param ?float $percent マッチ度（％）を受ける変数
     * @return string|array 候補の中で最も近い文字列
     */
    public static function str_guess($string, $candidates, &$percent = null)
    {
        $candidates = array_filter(Vars::arrayval($candidates, false), 'strlen');
        if (!$candidates) {
            throw new \InvalidArgumentException('$candidates is empty.');
        }

        // uni, bi, tri して配列で返すクロージャ
        $ngramer = static function ($string) {
            $result = [];
            foreach ([1, 2, 3] as $n) {
                $result[$n] = Strings::ngram($string, $n);
            }
            return $result;
        };

        $sngram = $ngramer($string);

        $result = array_fill_keys($candidates, null);
        foreach ($candidates as $candidate) {
            $cngram = $ngramer($candidate);

            // uni, bi, tri で重み付けスコア（var_dump したいことが多いので配列に入れる）
            $scores = [];
            foreach ($sngram as $n => $_) {
                $scores[$n] = count(array_intersect($sngram[$n], $cngram[$n])) / max(count($sngram[$n]), count($cngram[$n])) * $n;
            }
            $score = array_sum($scores) * 10 + 1;

            // ↑のスコアが同じだった場合を考慮してレーベンシュタイン距離で下駄を履かせる
            $score -= Strings::damerau_levenshtein($sngram[1], $cngram[1]) / max(count($sngram[1]), count($cngram[1]));

            // 10(uni) + 20(bi) + 30(tri) + 1(levenshtein) で最大は 61
            $score = $score / 61 * 100;

            $result[$candidate] = $score;
        }

        arsort($result);
        if ($percent === null) {
            $percent = reset($result);
        }
        else {
            return array_map('strval', array_keys(array_filter($result, fn($score) => $score >= $percent)));
        }

        return (string) key($result);
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
        if (Vars::is_stringable($string)) {
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
     * 文字列群の共通のプレフィックスを返す
     *
     * 共通部分がない場合は空文字を返す。
     * 引数は2個以上必要で足りない場合は null を返す。
     *
     * Example:
     * ```php
     * // 共通プレフィックスを返す
     * that(str_common_prefix('ab', 'abc', 'abcd'))->isSame('ab');
     * that(str_common_prefix('あ', 'あい', 'あいう'))->isSame('あ');
     * // 共通部分がない場合は空文字を返す
     * that(str_common_prefix('xab', 'yabc', 'zabcd'))->isSame('');
     * that(str_common_prefix('わあ', 'をあい', 'んあいう'))->isSame('');
     * // 引数不足の場合は null を返す
     * that(str_common_prefix('a'))->isSame(null);
     * ```
     *
     * @param string[] $strings
     * @return ?string 共通部分（共通がない場合は空文字）
     */
    public static function str_common_prefix(...$strings)
    {
        if (count($strings) < 2) {
            return null;
        }

        $n = 0;
        $result = '';
        $arrays = array_map(fn($string) => mb_str_split($string), $strings);
        foreach (array_intersect_assoc(...$arrays) as $i => $c) {
            if ($i !== $n++) {
                break;
            }
            $result .= $c;
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
     * @param ?int $length 置換長
     * @return string 置換した文字列
     */
    public static function mb_substr_replace($string, $replacement, $start, $length = null)
    {
        $string = (string) $string;

        $strlen = mb_strlen($string);
        if ($start < 0) {
            $start += $strlen;
        }
        if ($length === null) {
            $length = $strlen;
        }
        if ($length < 0) {
            $length += $strlen - $start;
        }

        return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length);
    }

    /**
     * マルチバイト版 str_pad
     *
     * 単純な mb_strlen での実装ではなく mb_strwidth による実装となっている。
     * 「文字数を指定して pad したい」という状況は utf8 で2バイト超えという状況がふさわしくないことが非常に多い。
     * 多くは単純に「全角は2文字、半角は1文字」というユースケースが多い（埋める文字がスペースなら特に）。
     *
     * また、$pad_string が切り捨てられることもない。
     * 標準の str_pad はできるだけ詰めようとして中途半端な $pad_string になることがあるが、その動作は模倣していない。
     * 端的に「$width を超えないようにできる限り敷き詰めて返す」という動作になる。
     *
     * Example:
     * ```php
     * // マルチバイトは2文字幅として換算される
     * that(mb_str_pad('aaaa', 12, '-'))->isSame('aaaa--------');
     * that(mb_str_pad('ああ', 12, '-'))->isSame('ああ--------');
     * // $pad_string は切り捨てられない
     * that(mb_str_pad('aaaa', 12, 'xyz'))->isSame('aaaaxyzxyz'); // 10文字で返す（あと1回 xyz すると 13 文字になり width を超えてしまう（かといって xy だけを足したりもしない））
     * that(mb_str_pad('ああ', 12, 'xyz'))->isSame('ああxyzxyz'); // マルチバイトでも同じ
     * ```
     *
     * @param string $string 対象文字列
     * @param int $width 埋める幅
     * @param string $pad_string 埋める文字列
     * @param int $pad_type 埋める位置
     * @return string 指定文字で埋められた文字列
     */
    public static function mb_str_pad($string, $width, $pad_string = " ", $pad_type = STR_PAD_RIGHT)
    {
        assert(in_array($pad_type, [STR_PAD_LEFT, STR_PAD_RIGHT, STR_PAD_BOTH]));

        $str_length = mb_strwidth($string);
        $pad_length = mb_strwidth($pad_string);
        $target_length = intval($width - $str_length);

        if ($pad_length === 0 || $target_length <= 0) {
            return $string;
        }

        $pad_count = $target_length / $pad_length;

        switch ($pad_type) {
            default:
                throw new \InvalidArgumentException("pad_type is invalid($pad_type)"); // @codeCoverageIgnore
            case STR_PAD_BOTH:
                $left = str_repeat($pad_string, floor($pad_count / 2));
                $right = str_repeat($pad_string, floor(($target_length - mb_strwidth($left)) / $pad_length));
                return $left . $string . $right;
            case STR_PAD_RIGHT:
                return $string . str_repeat($pad_string, floor($pad_count));
            case STR_PAD_LEFT:
                return str_repeat($pad_string, floor($pad_count)) . $string;
        }
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
     * // 10文字幅に丸める（$pos 省略なので真ん中が省略される）
     * that(mb_ellipsis('あいうえお1234567890', 10, '...'))->isSame('あい...890');
     * // 10文字幅に丸める（$pos=1 なので1幅目から省略される…が、1文字は「あ」なので前方に切られる）
     * that(mb_ellipsis('あいうえお1234567890', 10, '...', 1))->isSame('...567890');
     * // 10文字幅に丸める（$pos=2 なので2幅目から省略される）
     * that(mb_ellipsis('あいうえお1234567890', 10, '...', 2))->isSame('あ...67890');
     * // 10文字幅に丸める（$pos=-1 なので後ろから1幅目から省略される）
     * that(mb_ellipsis('あいうえお1234567890', 10, '...', -1))->isSame('あいう...0');
     * ```
     *
     * @param string $string 対象文字列
     * @param int $width 丸める幅
     * @param string $trimmarker 省略文字列
     * @param int|null $pos 省略記号の差し込み位置
     * @return string 丸められた文字列
     */
    public static function mb_ellipsis($string, $width, $trimmarker = '...', $pos = null)
    {
        $string = (string) $string;

        $strwidth = mb_strwidth($string);
        if ($strwidth <= $width) {
            return $string;
        }

        $markerwidth = mb_strwidth($trimmarker);
        if ($markerwidth >= $width) {
            return $trimmarker;
        }

        $maxwidth = $width - $markerwidth;
        $pos ??= $maxwidth / 2;
        if ($pos < 0) {
            $pos += $maxwidth;
        }
        $pos = ceil(max(0, min($pos, $maxwidth)));
        $end = $pos + $strwidth - $maxwidth;

        $widths = array_map('mb_strwidth', mb_str_split($string));
        $s = $e = null;
        $sum = 0;
        foreach ($widths as $n => $w) {
            $sum += $w;
            if (!isset($s) && $sum > $pos) {
                $s = $n;
            }
            if (!isset($e) && $sum >= $end) {
                $e = $n + 1;
            }
        }

        return mb_substr($string, 0, $s) . $trimmarker . mb_substr($string, $e);
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
     * "hoge ${hoge}" 形式のレンダリング
     *
     * ES6 のテンプレートリテラルのようなもの。
     *
     * - 埋め込みは ${var} のみで、{$var} は無効
     * - ${expression} は「評価結果の変数名」ではなく「評価結果」が埋め込まれる
     *
     * $vars に callable を渡すと元文字列とプレースホルダー部分の配列でコールバックされる（タグ付きテンプレートの模倣）。
     *
     * 実装的にはただの文字列 eval なので " はエスケープする必要がある。
     *
     * この関数は実験的機能のため、互換性を維持せず変更される可能性がある。
     *
     * Example:
     * ```php
     * that(render_template('${max($nums)}', ['nums' => [1, 9, 3]]))->isSame('9');
     * ```
     *
     * @param string $template レンダリングするファイル名
     * @param array|object|\Closure $vars レンダリング変数
     * @return string レンダリングされた文字列
     */
    public static function render_template($template, $vars)
    {
        assert(Vars::is_arrayable($vars) || is_callable($vars) || is_array($vars));

        $tokens = array_slice(Syntax::parse_php('"' . $template . '"', [
            //'flags' => Syntax::TOKEN_NAME,
        ]), 2, -1);

        $callable_mode = is_callable($vars);

        $embed = $callable_mode ? null : Strings::unique_string($template, "embedclosure");
        $blocks = [""];
        $values = [];
        for ($i = 0, $l = count($tokens); $i < $l; $i++) {
            if (!$callable_mode) {
                if ($tokens[$i][0] === T_VARIABLE) {
                    $tokens[$i][1] = '\\' . $tokens[$i][1];
                }
            }
            if ($tokens[$i][0] === T_DOLLAR_OPEN_CURLY_BRACES) {
                for ($j = $i; $j < $l; $j++) {
                    if ($tokens[$j][1] === '}') {
                        $stmt = implode('', array_column(array_slice($tokens, $i + 1, $j - $i - 1, true), 1));
                        if (Vars::attr_exists($stmt, $vars)) {
                            if ($callable_mode) {
                                $blocks[] = "";
                                $values[] = Vars::attr_get($stmt, $vars);
                            }
                            else {
                                // 書き換える必要はない（`${varname}` は正しく埋め込まれる）
                                assert(strlen($stmt));
                            }
                        }
                        else {
                            if ($callable_mode) {
                                $blocks[] = "";
                                $values[] = Vars::phpval($stmt, (array) $vars);
                            }
                            else {
                                // ${varname} を {$embedclosure(varname)} に書き換えて埋め込みを有効化する
                                $tokens = array_replace($tokens, array_fill($i, $j - $i + 1, [1 => '']));
                                $tokens[$i][1] = "{\$$embed($stmt)}";
                            }
                        }
                        $i = $j;
                        break;
                    }
                }
            }
            else {
                if ($callable_mode) {
                    $blocks[count($blocks) - 1] .= $tokens[$i][1];
                }
            }
        }

        if ($callable_mode) {
            if (strlen($blocks[count($blocks) - 1]) === 0) {
                unset($blocks[count($blocks) - 1]);
            }
            return $vars($blocks, ...$values);
        }

        $template = '"' . implode('', array_column($tokens, 1)) . '"';
        return Syntax::evaluate("return $template;", $vars + [$embed => fn($v) => $v]);
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
     * that(render_string('$c', ['c' => fn($vars, $k) => $k . '-closure']))->isSame('c-closure');
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
            $vars['_'] = fn($v) => $v;
        }

        try {
            /** @noinspection PhpMethodParametersCountMismatchInspection */
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
        return Strings::render_string(file_get_contents($template_file), $array);
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
        /** @noinspection PhpMethodParametersCountMismatchInspection */
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
        $path = FileSystem::memory_path(__FUNCTION__);
        file_put_contents($path, $template);
        $result = Strings::ob_include($path, $array);
        unlink($path);
        return $result;
    }
}
