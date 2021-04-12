<?php

namespace ryunosuke\Functions\Package;

/**
 * 構文関連のユーティリティ
 */
class Syntax
{
    /** parse_php 関数でトークン名変換をするか */
    const TOKEN_NAME = 2;

    /**
     * eval のプロキシ関数
     *
     * 一度ファイルに吐いてから require した方が opcache が効くので抜群に速い。
     * また、素の eval は ParseError が起こったときの表示がわかりにくすぎるので少し見やすくしてある。
     *
     * 関数化してる以上 eval におけるコンテキストの引き継ぎはできない。
     * ただし、引数で変数配列を渡せるようにしてあるので get_defined_vars を併用すれば基本的には同じ（$this はどうしようもない）。
     *
     * 短いステートメントだと opcode が少ないのでファイルを経由せず直接 eval したほうが速いことに留意。
     * 一応引数で指定できるようにはしてある。
     *
     * Example:
     * ```php
     * $a = 1;
     * $b = 2;
     * $phpcode = ';
     * $c = $a + $b;
     * return $c * 3;
     * ';
     * that(evaluate($phpcode, get_defined_vars()))->isSame(9);
     * ```
     *
     * @param string $phpcode 実行する php コード
     * @param array $contextvars コンテキスト変数配列
     * @param int $cachesize キャッシュするサイズ
     * @return mixed eval の return 値
     */
    public static function evaluate($phpcode, $contextvars = [], $cachesize = 256)
    {
        $cachefile = null;
        if ($cachesize && strlen($phpcode) >= $cachesize) {
            $cachefile = (cachedir)() . '/' . rawurlencode(__FUNCTION__) . '-' . sha1($phpcode) . '.php';
            if (!file_exists($cachefile)) {
                file_put_contents($cachefile, "<?php $phpcode", LOCK_EX);
            }
        }

        try {
            if ($cachefile) {
                return ($dummy = static function () {
                    extract(func_get_arg(1));
                    return require func_get_arg(0);
                })($cachefile, $contextvars);
            }
            else {
                return ($dummy = static function () {
                    extract(func_get_arg(1));
                    return eval(func_get_arg(0));
                })($phpcode, $contextvars);
            }
        }
        catch (\ParseError $ex) {
            $errline = $ex->getLine();
            $errline_1 = $errline - 1;
            $codes = preg_split('#\\R#u', $phpcode);
            $codes[$errline_1] = '>>> ' . $codes[$errline_1];

            $N = 5; // 前後の行数
            $message = $ex->getMessage();
            $message .= "\n" . implode("\n", array_slice($codes, max(0, $errline_1 - $N), $N * 2 + 1));
            if ($cachefile) {
                $message .= "\n in " . realpath($cachefile) . " on line " . $errline . "\n";
            }
            throw new \ParseError($message, $ex->getCode(), $ex);
        }
    }

    /**
     * php のコード断片をパースする
     *
     * 結果配列は token_get_all したものだが、「字句の場合に文字列で返す」仕様は適用されずすべて配列で返す。
     * つまり必ず `[TOKENID, TOKEN, LINE, POS]` で返す。
     *
     * @todo 現在の仕様では php タグが自動で付与されるが、標準と異なり直感的ではないのでその仕様は除去する
     * @todo そもそも何がしたいのかよくわからない関数になってきたので動作の洗い出しが必要
     *
     * Example:
     * ```php
     * $phpcode = 'namespace Hogera;
     * class Example
     * {
     *     // something
     * }';
     *
     * // namespace ～ ; を取得
     * $part = parse_php($phpcode, [
     *     'begin' => T_NAMESPACE,
     *     'end'   => ';',
     * ]);
     * that(implode('', array_column($part, 1)))->isSame('namespace Hogera;');
     *
     * // class ～ { を取得
     * $part = parse_php($phpcode, [
     *     'begin' => T_CLASS,
     *     'end'   => '{',
     * ]);
     * that(implode('', array_column($part, 1)))->isSame("class Example\n{");
     * ```
     *
     * @param string $phpcode パースする php コード
     * @param array|int $option パースオプション
     * @return array トークン配列
     */
    public static function parse_php($phpcode, $option = [])
    {
        if (is_int($option)) {
            $option = ['flags' => $option];
        }

        $default = [
            'phptag'         => true, // 初めに php タグを付けるか
            'short_open_tag' => null, // ショートオープンタグを扱うか（null だと余計なことはせず ini に従う）
            'line'           => [],   // 行の範囲（以上以下）
            'position'       => [],   // 文字位置の範囲（以上以下）
            'begin'          => [],   // 開始トークン
            'end'            => [],   // 終了トークン
            'offset'         => 0,    // 開始トークン位置
            'flags'          => 0,    // token_get_all の $flags. TOKEN_PARSE を与えると ParseError が出ることがあるのでデフォルト 0
            'cache'          => true, // キャッシュするか否か
            'nest_token'     => [
                ')' => '(',
                '}' => '{',
                ']' => '[',
            ],
        ];
        $option += $default;

        $cachekey = $option['flags'] . '-' . $option['phptag'] . '-' . var_export($option['short_open_tag'], true);
        static $cache = [];
        if (!($option['cache'] && isset($cache[$phpcode][$cachekey]))) {
            $phptag = $option['phptag'] ? '<?php ' : '';
            $phpcode = $phptag . $phpcode;
            $position = -strlen($phptag);

            $tokens = [];
            $tmp = token_get_all($phpcode, $option['flags']);
            for ($i = 0; $i < count($tmp); $i++) {
                $token = $tmp[$i];

                // token_get_all の結果は微妙に扱いづらいので少し調整する（string/array だったり、名前変換の必要があったり）
                if (!is_array($token)) {
                    $last = $tokens[count($tokens) - 1] ?? [null, 1, 0];
                    $token = [ord($token), $token, $last[2] + preg_match_all('/(?:\r\n|\r|\n)/', $last[1])];
                }

                // @codeCoverageIgnoreStart
                if ($option['short_open_tag'] === true && $token[0] === T_INLINE_HTML && ($p = strpos($token[1], '<?')) !== false) {
                    $newtokens = [];
                    $nlcount = 0;

                    if ($p !== 0) {
                        $html = substr($token[1], 0, $p);
                        $nlcount = preg_match_all('#\r\n|\r|\n#u', $html);
                        $newtokens[] = [T_INLINE_HTML, $html, $token[2]];
                    }

                    $code = substr($token[1], $p + 2);
                    $subtokens = token_get_all("<?php $code");
                    $subtokens[0][1] = '<?';
                    foreach ($subtokens as $subtoken) {
                        if (is_array($subtoken)) {
                            $subtoken[2] += $token[2] + $nlcount - 1;
                        }
                        $newtokens[] = $subtoken;
                    }

                    array_splice($tmp, $i + 1, 0, $newtokens);
                    continue;
                }
                if ($option['short_open_tag'] === false && $token[0] === T_OPEN_TAG && $token[1] === '<?') {
                    for ($j = $i + 1; $j < count($tmp); $j++) {
                        if ($tmp[$j][0] === T_CLOSE_TAG) {
                            break;
                        }
                    }
                    $html = implode('', array_map(function ($token) {
                        return is_array($token) ? $token[1] : $token;
                    }, array_slice($tmp, $i, $j - $i + 1)));
                    array_splice($tmp, $i + 1, $j - $i, [[T_INLINE_HTML, $html, $token[2]]]);
                    continue;
                }
                // @codeCoverageIgnoreEnd

                $token[] = $position;
                if ($option['flags'] & TOKEN_NAME) {
                    $token[] = token_name($token[0]);
                }

                $position += strlen($token[1]);
                $tokens[] = $token;
            }
            // @codeCoverageIgnoreStart
            if ($option['short_open_tag'] === false) {
                for ($i = 0; $i < count($tokens); $i++) {
                    if ($tokens[$i][0] === T_INLINE_HTML && isset($tokens[$i + 1]) && $tokens[$i + 1][0] === T_INLINE_HTML) {
                        $tokens[$i][1] .= $tokens[$i + 1][1];
                        array_splice($tokens, $i + 1, 1, []);
                        $i--;
                    }
                }
            }
            // @codeCoverageIgnoreEnd
            $cache[$phpcode][$cachekey] = $tokens;
        }
        $tokens = $cache[$phpcode][$cachekey];

        $lines = $option['line'] + [-PHP_INT_MAX, PHP_INT_MAX];
        $positions = $option['position'] + [-PHP_INT_MAX, PHP_INT_MAX];
        $begin_tokens = (array) $option['begin'];
        $end_tokens = (array) $option['end'];
        $nest_tokens = $option['nest_token'];

        $result = [];
        $starting = !$begin_tokens;
        $nesting = 0;
        $offset = is_array($option['offset']) ? ($option['offset'][0] ?? 0) : $option['offset'];
        $endset = is_array($option['offset']) ? ($option['offset'][1] ?? count($tokens)) : count($tokens);

        for ($i = $offset; $i < $endset; $i++) {
            $token = $tokens[$i];

            if ($lines[0] > $token[2]) {
                continue;
            }
            if ($lines[1] < $token[2]) {
                continue;
            }
            if ($positions[0] > $token[3]) {
                continue;
            }
            if ($positions[1] < $token[3]) {
                continue;
            }

            foreach ($begin_tokens as $t) {
                if ($t === $token[0] || $t === $token[1]) {
                    $starting = true;
                    break;
                }
            }
            if (!$starting) {
                continue;
            }

            $result[$i] = $token;

            foreach ($end_tokens as $t) {
                if (isset($nest_tokens[$t])) {
                    $nest_token = $nest_tokens[$t];
                    if ($token[0] === $nest_token || $token[1] === $nest_token) {
                        $nesting++;
                    }
                }
                if ($t === $token[0] || $t === $token[1]) {
                    $nesting--;
                    if ($nesting <= 0) {
                        break 2;
                    }
                    break;
                }
            }
        }
        return $result;
    }

    /**
     * 文字列から php コードを取り除く
     *
     * 正確には $replacer で指定したものに置換される（デフォルト空文字なので削除になる）。
     * $replacer にクロージャを渡すと(phpコード, 出現番号) が渡ってくるので、それに応じて値を返せばそれに置換される。
     * 文字列を指定すると自動で出現番号が付与される。
     *
     * $mapping 配列には「どれをどのように」と言った変換表が格納される。
     * 典型的には strtr に渡して php コードを復元させるのに使用する。
     *
     * Example:
     * ```php
     * $phtml = 'begin php code <?php echo 123 ?> end';
     * // php コードが消えている
     * that(strip_php($phtml))->is('begin php code  end');
     * // $mapping を使用すると元の文字列に復元できる
     * $html = strip_php($phtml, null, $mapping);
     * that(strtr($html, $mapping))->is($phtml);
     * ```
     *
     * @param string $phtml php コードを含む文字列
     * @param ?string|\Closure $replacer 置換文字列・処理
     * @param array $mapping 変換表が格納される参照変数
     * @return string php コードが除かれた文字列
     */
    public static function strip_php($phtml, $replacer = '', &$mapping = [])
    {
        if ($replacer === '') {
            $replacer = function ($phptag, $n) { return ''; };
        }
        if ($replacer === null) {
            $replacer = (unique_string)($phtml, 64);
        }

        $tokens = (parse_php)($phtml, [
            //'flags'          => TOKEN_NAME,
            //'cache'          => false,
            'phptag'         => false,
            'short_open_tag' => true,
        ]);
        $offsets = [];
        foreach ($tokens as $token) {
            if ($token[0] === T_OPEN_TAG || $token[0] === T_OPEN_TAG_WITH_ECHO) {
                $offsets[] = [$token[3], null];
            }
            elseif ($token[0] === T_CLOSE_TAG) {
                $lastkey = count($offsets) - 1;
                $offsets[$lastkey][1] = $token[3] + strlen($token[1]) - $offsets[$lastkey][0];
            }
        }
        if ($offsets) {
            $lastkey = count($offsets) - 1;
            $offsets[$lastkey][1] = $offsets[$lastkey][1] ?? strlen($phtml) - $offsets[$lastkey][0];
        }

        $mapping = [];
        foreach (array_reverse($offsets) as $n => [$offset, $length]) {
            if ($replacer instanceof \Closure) {
                $mapping[$n] = substr($phtml, $offset, $length);
                $phtml = substr_replace($phtml, $replacer($mapping[$n], $n), $offset, $length);
            }
            else {
                $tag = $replacer . $n;
                $mapping[$tag] = substr($phtml, $offset, $length);
                $phtml = substr_replace($phtml, $tag, $offset, $length);
            }
        }

        return $phtml;
    }

    /**
     * php のコードのインデントを調整する
     *
     * baseline で基準インデント位置を指定する。
     * その基準インデントを削除した後、指定したインデントレベルでインデントするようなイメージ。
     *
     * Example:
     * ```php
     * $phpcode = '
     *     echo 123;
     *
     *     if (true) {
     *         echo 456;
     *     }
     * ';
     * // 数値指定は空白換算
     * that(indent_php($phpcode, 8))->isSame('
     *         echo 123;
     *
     *         if (true) {
     *             echo 456;
     *         }
     * ');
     * // 文字列を指定すればそれが使用される
     * that(indent_php($phpcode, "  "))->isSame('
     *   echo 123;
     *
     *   if (true) {
     *       echo 456;
     *   }
     * ');
     * // オプション指定
     * that(indent_php($phpcode, [
     *     'baseline'  => 1,    // 基準インデントの行番号（負数で下からの指定になる）
     *     'indent'    => 4,    // インデント指定（上記の数値・文字列指定はこれの糖衣構文）
     *     'trimempty' => true, // 空行を trim するか
     *     'heredoc'   => true, // php7.3 の Flexible Heredoc もインデントするか
     * ]))->isSame('
     *     echo 123;
     *
     *     if (true) {
     *         echo 456;
     *     }
     * ');
     * ```
     *
     * @param string $phpcode インデントする php コード
     * @param array|int|string $options オプション
     * @return string インデントされた php コード
     */
    public static function indent_php($phpcode, $options = [])
    {
        if (!is_array($options)) {
            $options = ['indent' => $options];
        }
        $options += [
            'baseline'  => 1,
            'indent'    => 0,
            'trimempty' => true,
            'heredoc'   => version_compare(PHP_VERSION, '7.3.0') < 0,
        ];
        if (is_int($options['indent'])) {
            $options['indent'] = str_repeat(' ', $options['indent']);
        }

        $lines = preg_split('#\\R#u', $phpcode);
        $baseline = $options['baseline'];
        if ($baseline < 0) {
            $baseline = count($lines) + $baseline;
        }
        preg_match('@^[ \t]*@u', $lines[$baseline] ?? '', $matches);
        $indent = $matches[0] ?? '';

        $tmp = token_get_all("<?php $phpcode");
        array_shift($tmp);

        // トークンの正規化
        $tokens = [];
        for ($i = 0; $i < count($tmp); $i++) {
            if (is_string($tmp[$i])) {
                $tmp[$i] = [-1, $tmp[$i], null];
            }

            // 行コメントの分割（T_COMMENT には改行が含まれている）
            if ($tmp[$i][0] === T_COMMENT && preg_match('@^(#|//).*?(\\R)@um', $tmp[$i][1], $matches)) {
                $tmp[$i][1] = trim($tmp[$i][1]);
                if (($tmp[$i + 1][0] ?? null) === T_WHITESPACE) {
                    $tmp[$i + 1][1] = $matches[2] . $tmp[$i + 1][1];
                }
                else {
                    array_splice($tmp, $i + 1, 0, [[T_WHITESPACE, $matches[2], null]]);
                }
            }

            if ($options['heredoc']) {
                // 行コメントと同じ（T_START_HEREDOC には改行が含まれている）
                if ($tmp[$i][0] === T_START_HEREDOC && preg_match('@^(<<<).*?(\\R)@um', $tmp[$i][1], $matches)) {
                    $tmp[$i][1] = trim($tmp[$i][1]);
                    if (($tmp[$i + 1][0] ?? null) === T_ENCAPSED_AND_WHITESPACE) {
                        $tmp[$i + 1][1] = $matches[2] . $tmp[$i + 1][1];
                    }
                    else {
                        array_splice($tmp, $i + 1, 0, [[T_ENCAPSED_AND_WHITESPACE, $matches[2], null]]);
                    }
                }
                // php 7.3 において T_END_HEREDOC は必ず単一行になる
                if ($tmp[$i][0] === T_ENCAPSED_AND_WHITESPACE) {
                    if (($tmp[$i + 1][0] ?? null) === T_END_HEREDOC && preg_match('@^(\\s+)(.*)@um', $tmp[$i + 1][1], $matches)) {
                        $tmp[$i][1] = $tmp[$i][1] . $matches[1];
                        $tmp[$i + 1][1] = $matches[2];
                    }
                }
            }

            $tokens[] = $tmp[$i] + [3 => token_name($tmp[$i][0])];
        }

        // 改行を置換してインデント
        $hereing = false;
        foreach ($tokens as $i => $token) {
            if ($options['heredoc']) {
                if ($token[0] === T_START_HEREDOC) {
                    $hereing = true;
                }
                if ($token[0] === T_END_HEREDOC) {
                    $hereing = false;
                }
            }
            if (in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true) || ($hereing && $token[0] === T_ENCAPSED_AND_WHITESPACE)) {
                $token[1] = preg_replace("@(\\R)$indent@um", '$1' . $options['indent'], $token[1]);
            }
            if ($options['trimempty']) {
                if ($token[0] === T_WHITESPACE) {
                    $token[1] = preg_replace("@(\\R)[ \\t]+(\\R)@um", '$1$2', $token[1]);
                }
            }

            $tokens[$i] = $token;
        }
        return implode('', array_column($tokens, 1));
    }

    /**
     * php のコードをハイライトする
     *
     * SAPI に応じて自動でハイライトする（html タグだったり ASCII color だったり）。
     * highlight_string の CLI 対応版とも言える。
     *
     * @param string $phpcode ハイライトする php コード
     * @param array|int $options オプション
     * @return string ハイライトされた php コード
     */
    public static function highlight_php($phpcode, $options = [])
    {
        $options += [
            'context' => null,
        ];

        $context = $options['context'];

        if ($context === null) {
            $context = 'html'; // SAPI でテストカバレッジが辛いので if else ではなくデフォルト代入にしてある
            if (PHP_SAPI === 'cli') {
                $context = (is_ansi)(STDOUT) ? 'cli' : 'plain';
            }
        }

        $colorize = static function ($value, $style) use ($context) {
            switch ($context) {
                default:
                    throw new \InvalidArgumentException("'$context' is not supported.");
                case 'plain':
                    return $value;
                case 'cli':
                    return (ansi_colorize)($value, $style);
                case 'html':
                    $names = array_flip(preg_split('#[^a-z]#i', $style));
                    $keys = [
                        'bold'       => 'font-weight:bold',
                        'faint'      => '',
                        'italic'     => 'font-style:italic',
                        'underscore' => 'text-decoration:underline',
                        'blink'      => '',
                        'reverse'    => '',
                        'conceal'    => '',
                    ];
                    $colors = array_keys(array_diff_key($names, $keys));
                    $styles = array_intersect_key($keys, $names);
                    $styles[] = 'color:' . reset($colors);
                    $style = implode(';', $styles);
                    return "<span style='$style'>" . htmlspecialchars($value, ENT_QUOTES) . '</span>';
            }
        };

        $type = 'bold';
        $keyword = 'magenta|bold';
        $symbol = 'green|italic';
        $literal = 'red';
        $variable = 'underscore';
        $comment = 'blue|italic';

        $rules = [
            'null'                     => $type,
            'false'                    => $type,
            'true'                     => $type,
            'iterable'                 => $type,
            'bool'                     => $type,
            'float'                    => $type,
            'int'                      => $type,
            'string'                   => $type,
            T_ABSTRACT                 => $keyword,
            T_ARRAY                    => $keyword,
            T_CALLABLE                 => $keyword,
            T_CLASS_C                  => $keyword,
            T_DIR                      => $keyword,
            T_FILE                     => $keyword,
            T_FUNC_C                   => $keyword,
            T_LINE                     => $keyword,
            T_METHOD_C                 => $keyword,
            T_NS_C                     => $keyword,
            T_TRAIT_C                  => $keyword,
            T_AS                       => $keyword,
            T_BOOLEAN_AND              => $keyword,
            T_BOOLEAN_OR               => $keyword,
            T_BREAK                    => $keyword,
            T_CASE                     => $keyword,
            T_CATCH                    => $keyword,
            T_CLASS                    => $keyword,
            T_CLONE                    => $keyword,
            T_CONST                    => $keyword,
            T_CONTINUE                 => $keyword,
            T_DECLARE                  => $keyword,
            T_DEFAULT                  => $keyword,
            T_DO                       => $keyword,
            T_ELSE                     => $keyword,
            T_ELSEIF                   => $keyword,
            T_ENDDECLARE               => $keyword,
            T_ENDFOR                   => $keyword,
            T_ENDFOREACH               => $keyword,
            T_ENDIF                    => $keyword,
            T_ENDSWITCH                => $keyword,
            T_ENDWHILE                 => $keyword,
            T_END_HEREDOC              => $keyword,
            T_EXIT                     => $keyword,
            T_EXTENDS                  => $keyword,
            T_FINAL                    => $keyword,
            T_FINALLY                  => $keyword,
            T_FOR                      => $keyword,
            T_FOREACH                  => $keyword,
            T_ECHO                     => $keyword,
            T_FUNCTION                 => $keyword,
            T_GLOBAL                   => $keyword,
            T_GOTO                     => $keyword,
            T_IF                       => $keyword,
            T_IMPLEMENTS               => $keyword,
            T_INSTANCEOF               => $keyword,
            T_INSTEADOF                => $keyword,
            T_INTERFACE                => $keyword,
            T_LOGICAL_AND              => $keyword,
            T_LOGICAL_OR               => $keyword,
            T_LOGICAL_XOR              => $keyword,
            T_NAMESPACE                => $keyword,
            T_NEW                      => $keyword,
            T_PRIVATE                  => $keyword,
            T_PUBLIC                   => $keyword,
            T_PROTECTED                => $keyword,
            T_RETURN                   => $keyword,
            T_STATIC                   => $keyword,
            T_SWITCH                   => $keyword,
            T_THROW                    => $keyword,
            T_TRAIT                    => $keyword,
            T_TRY                      => $keyword,
            T_USE                      => $keyword,
            T_VAR                      => $keyword,
            T_WHILE                    => $keyword,
            T_YIELD                    => $keyword,
            T_YIELD_FROM               => $keyword,
            T_EMPTY                    => $keyword,
            T_EVAL                     => $keyword,
            T_ISSET                    => $keyword,
            T_LIST                     => $keyword,
            T_PRINT                    => $keyword,
            T_UNSET                    => $keyword,
            T_INCLUDE                  => $keyword,
            T_INCLUDE_ONCE             => $keyword,
            T_REQUIRE                  => $keyword,
            T_REQUIRE_ONCE             => $keyword,
            T_HALT_COMPILER            => $keyword,
            T_STRING                   => $symbol,
            T_CONSTANT_ENCAPSED_STRING => $literal,
            T_ENCAPSED_AND_WHITESPACE  => $literal,
            T_NUM_STRING               => $literal,
            T_DNUMBER                  => $literal,
            T_LNUMBER                  => $literal,
            // T_STRING_VARNAME           => $literal,
            // T_CURLY_OPEN               => $literal,
            // T_DOLLAR_OPEN_CURLY_BRACES => $literal,
            '"'                        => $literal,
            T_VARIABLE                 => $variable,
            T_COMMENT                  => $comment,
            T_DOC_COMMENT              => $comment,
        ];

        $tokens = token_get_all($phpcode, TOKEN_PARSE);
        foreach ($tokens as $n => $token) {
            if (is_string($token)) {
                $token = [null, $token, null];
            }

            $style = $rules[strtolower($token[1])] ?? $rules[$token[0]] ?? null;
            if ($style !== null) {
                $token[1] = $colorize($token[1], $style);
            }
            $tokens[$n] = $token;
        }
        return implode('', array_column($tokens, 1));
    }

    /**
     * オブジェクトならそれを、オブジェクトでないなら NullObject を返す
     *
     * null を返すかもしれないステートメントを一時変数を介さずワンステートメントで呼ぶことが可能になる。
     *
     * NullObject は 基本的に null を返すが、return type が規約されている場合は null 以外を返すこともある。
     * 取得系呼び出しを想定しているので、設定系呼び出しは行うべきではない。
     * __set のような明らかに設定が意図されているものは例外が飛ぶ。
     *
     * Example:
     * ```php
     * // null を返すかもしれないステートメント
     * $getobject = function () {return null;};
     * // メソッド呼び出しは null を返す
     * that(optional($getobject())->method())->isSame(null);
     * // プロパティアクセスは null を返す
     * that(optional($getobject())->property)->isSame(null);
     * // empty は true を返す
     * that(empty(optional($getobject())->nothing))->isSame(true);
     * // __isset は false を返す
     * that(isset(optional($getobject())->nothing))->isSame(false);
     * // __toString は '' を返す
     * that(strval(optional($getobject())))->isSame('');
     * // __invoke は null を返す
     * that(call_user_func(optional($getobject())))->isSame(null);
     * // 配列アクセスは null を返す
     * that(optional($getobject())['hoge'])->isSame(null);
     * // 空イテレータを返す
     * that(iterator_to_array(optional($getobject())))->isSame([]);
     *
     * // $expected を与えるとその型以外は NullObject を返す（\ArrayObject はオブジェクトだが stdClass ではない）
     * that(optional(new \ArrayObject([1]), 'stdClass')->count())->isSame(null);
     * ```
     *
     * @param object|null $object オブジェクト
     * @param ?string $expected 期待するクラス名。指定した場合は is_a される
     * @return object $object がオブジェクトならそのまま返し、違うなら NullObject を返す
     */
    public static function optional($object, $expected = null)
    {
        if (is_object($object)) {
            if ($expected === null || is_a($object, $expected)) {
                return $object;
            }
        }

        static $nullobject = null;
        if ($nullobject === null) {
            $nullobject = new class implements \ArrayAccess, \IteratorAggregate {
                // @formatter:off
                public function __isset($name) { return false; }
                public function __get($name) { return null; }
                public function __set($name, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __unset($name) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __call($name, $arguments) { return null; }
                public function __invoke() { return null; }
                public function __toString() { return ''; }
                public function offsetExists($offset) { return false; }
                public function offsetGet($offset) { return null; }
                public function offsetSet($offset, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function offsetUnset($offset) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function getIterator() { return new \ArrayIterator([]); }
                // @formatter:on
            };
        }
        /** @var object $nullobject */
        return $nullobject;
    }

    /**
     * 関数をメソッドチェーンできるオブジェクトを返す
     *
     * ChainObject という関数をチェーンできるオブジェクトを返す。
     * ChainObject は大抵のグローバル関数がアノテーションされており、コード補完することが出来る（利便性のためであり、IDE がエラーなどを出しても呼び出し自体は可能）。
     * 呼び出しは「第1引数に現在の値が適用」されて実行される（下記の func1 コールで任意の位置に適用されることもできる）。
     *
     * 下記の特殊ルールにより、特殊な呼び出し方ができる。
     *
     * - array_XXX, str_XXX は省略して XXX で呼び出せる
     *   - 省略した結果、他の関数と被るようであれば短縮呼び出しは出来ない（array_優先でコールされる）
     *   - ini に 'rfunc.chain_overload' 定義されていれば型で分岐させることができる
     * - funcE で eval される文字列のクロージャを呼べる
     *   - 変数名は `$_` 固定だが、 `$_` が無いときに限り 最左に自動付与される
     * - funcP で配列指定オペレータのクロージャを呼べる
     *   - 複数指定した場合は順次呼ばれる。つまり map はともかく filter 用途では使えない
     * - func1 で「引数1（0 ベースなので要は2番目）に適用して func を呼び出す」ことができる
     *   - func2, func3 等も呼び出し可能
     * - 引数が1つの呼び出しは () を省略できる
     *
     * この特殊ルールは普通に使う分にはそこまで気にしなくて良い。
     * map や filter を駆使しようとすると必要になるが、イテレーション目的ではなく文字列のチェインなどが目的であればほぼ使うことはない。
     *
     * 特殊なメソッドとして下記がある。
     *
     * - apply($callback, ...$cbargs): 任意のコールバックを現在の値に適用する
     *
     * 上記を含むメソッド呼び出しはすべて自分自身を返すので、最終結果を得たい場合は `invoke` を実行する必要がある。
     * ただし、 IteratorAggregate が実装されているので、配列の場合に限り foreach で直接回すことができる。
     * さらに、 __toString も実装されているので、文字列的値の場合に限り自動で文字列化される。
     *
     * 用途は配列のイテレーションを想定しているが、あくまで「チェイン可能にする」が目的なので、ソースが文字列だろうとオブジェクトだろうと何でも呼び出しが可能。
     * ただし、遅延評価も最適化も何もしていないので、 chain するだけでも動作は相当遅くなることに注意。
     *
     * なお、最初の引数を省略するとスタックモードになり、一切の処理が適用されなくなる。
     * その代わり `invoke` で遅延的に値を渡すことができるようになる。
     * 「処理の流れだけ決めておいて後で適用する」イメージ。
     *
     * Example:
     * ```php
     * # 1～9 のうち「5以下を抽出」して「値を2倍」して「合計」を出すシチュエーション
     * $n1_9 = range(1, 9);
     * // 素の php で処理したもの。パッと見で何してるか分からないし、処理の順番が思考と逆なので混乱する
     * that(array_sum(array_map(function ($v) { return $v * 2; }, array_filter($n1_9, function ($v) { return $v <= 5; }))))->isSame(30);
     * // chain でクロージャを渡したもの。処理の順番が思考どおりだが、 function(){} が微妙にうざい（array_ は省略できるので filter, map, sum のような呼び出しができている）
     * that(chain($n1_9)->filter(function ($v) { return $v <= 5; })->map(function ($v) { return $v * 2; })->sum()())->isSame(30);
     * // funcP を介して function(){} をなくしたもの。ここまで来ると若干読みやすい
     * that(chain($n1_9)->filterP(['<=' => 5])->mapP(['*' => 2])->sum()())->isSame(30);
     * // funcE を介したもの。かなり直感的だが eval なので少し不安
     * that(chain($n1_9)->filterE('<= 5')->mapE('* 2')->sum()())->isSame(30);
     *
     * # "hello   world" を「" " で分解」して「空文字を除去」してそれぞれに「ucfirst」して「"/" で結合」して「rot13」して「md5」して「大文字化」するシチュエーション
     * $string = 'hello   world';
     * // 素の php で処理したもの。もはやなにがなんだか分からない
     * that(strtoupper(md5(str_rot13(implode('/', array_map('ucfirst', array_filter(explode(' ', $string))))))))->isSame('10AF4DAF67D0D666FCEA0A8C6EF57EE7');
     * // chain だとかなりそれっぽくできる。 explode/implode の第1引数は区切り文字なので func1 構文を使用している。また、 rot13 以降は引数がないので () を省略している
     * that(chain($string)->explode1(' ')->filter()->map('ucfirst')->implode1('/')->rot13->md5->strtoupper()())->isSame('10AF4DAF67D0D666FCEA0A8C6EF57EE7');
     *
     *  # よくある DB レコードをあれこれするシチュエーション
     * $rows = [
     *     ['id' => 1, 'name' => 'hoge', 'sex' => 'F', 'age' => 17, 'salary' => 230000],
     *     ['id' => 3, 'name' => 'fuga', 'sex' => 'M', 'age' => 43, 'salary' => 480000],
     *     ['id' => 7, 'name' => 'piyo', 'sex' => 'M', 'age' => 21, 'salary' => 270000],
     *     ['id' => 9, 'name' => 'hage', 'sex' => 'F', 'age' => 30, 'salary' => 320000],
     * ];
     * // e.g. 男性の平均給料
     * that(chain($rows)->whereP('sex', ['===' => 'M'])->column('salary')->mean()())->isSame(375000);
     * // e.g. 女性の平均年齢
     * that(chain($rows)->whereE('sex', '=== "F"')->column('age')->mean()())->isSame(23.5);
     * // e.g. 30歳以上の平均給料
     * that(chain($rows)->whereP('age', ['>=' => 30])->column('salary')->mean()())->isSame(400000);
     * // e.g. 20～30歳の平均給料
     * that(chain($rows)->whereP('age', ['>=' => 20])->whereE('age', '<= 30')->column('salary')->mean()())->isSame(295000);
     * // e.g. 男性の最小年齢
     * that(chain($rows)->whereP('sex', ['===' => 'M'])->column('age')->min()())->isSame(21);
     * // e.g. 女性の最大給料
     * that(chain($rows)->whereE('sex', '=== "F"')->column('salary')->max()())->isSame(320000);
     *
     * # 上記の引数遅延モード（結果は同じなのでいくつかピックアップ）
     * that(chain()->whereP('sex', ['===' => 'M'])->column('salary')->mean()($rows))->isSame(375000);
     * that(chain()->whereP('age', ['>=' => 30])->column('salary')->mean()($rows))->isSame(400000);
     * that(chain()->whereP('sex', ['===' => 'M'])->column('age')->min()($rows))->isSame(21);
     * ```
     *
     * @param mixed $source 元データ
     * @return \ChainObject
     */
    public static function chain($source = null)
    {
        return new class(...func_get_args()) implements \IteratorAggregate {
            private $data;
            private $stack;

            public function __construct($source = null)
            {
                if (func_num_args() === 0) {
                    $this->stack = [];
                }
                $this->data = $source;
            }

            public function __invoke(...$source)
            {
                $func_num_args = func_num_args();

                if ($this->stack !== null && $func_num_args === 0) {
                    throw new \InvalidArgumentException('nonempty stack and no parameter given. maybe invalid __invoke args.');
                }
                if ($this->stack === null && $func_num_args > 0) {
                    throw new \UnexpectedValueException('empty stack and parameter given > 0. maybe invalid __invoke args.');
                }

                if ($func_num_args > 0) {
                    $result = [];
                    foreach ($source as $s) {
                        $chain = (chain)($s);
                        foreach ($this->stack as $stack) {
                            $chain->{$stack[0]}(...$stack[1]);
                        }
                        $result[] = $chain();
                    }
                    return $func_num_args === 1 ? reset($result) : $result;
                }
                return $this->data;
            }

            public function __get($name)
            {
                return $this->_apply($name, []);
            }

            public function __call($name, $arguments)
            {
                return $this->_apply($name, $arguments);
            }

            public function __toString()
            {
                return (string) $this->data;
            }

            public function getIterator()
            {
                foreach ($this->data as $k => $v) {
                    yield $k => $v;
                }
            }

            public function apply($callback, ...$args)
            {
                if (is_array($this->stack)) {
                    $this->stack[] = [__FUNCTION__, func_get_args()];
                    return $this;
                }

                $this->data = $callback($this->data, ...$args);
                return $this;
            }

            private function _resolve($name)
            {
                $overload = get_cfg_var('rfunc.chain_overload') ?: false; // for compatible
                $isiterable = !$overload || is_iterable($this->data);
                if (false
                    // for global
                    || (function_exists($fname = $name))
                    || ($isiterable && function_exists($fname = "array_$name"))
                    || (function_exists($fname = "str_$name"))
                    // for package
                    || (defined($cname = $name) && is_callable($fname = constant($cname)))
                    || ($isiterable && defined($cname = "array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = "str_$name") && is_callable($fname = constant($cname)))
                    // for namespace
                    || (defined($cname = __NAMESPACE__ . "\\$name") && is_callable($fname = constant($cname)))
                    || ($isiterable && defined($cname = __NAMESPACE__ . "\\array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __NAMESPACE__ . "\\str_$name") && is_callable($fname = constant($cname)))
                    // for class
                    || (defined($cname = __CLASS__ . "::$name") && is_callable($fname = constant($cname)))
                    || ($isiterable && defined($cname = __CLASS__ . "::array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __CLASS__ . "::str_$name") && is_callable($fname = constant($cname)))
                ) {
                    return $fname;
                }
            }

            private function _apply($name, $arguments)
            {
                if (is_array($this->stack)) {
                    $this->stack[] = [$name, $arguments];
                    return $this;
                }

                // 特別扱い1: map は非常によく呼ぶので引数を補正する
                if ($name === 'map') {
                    return $this->_apply('array_map1', $arguments);
                }

                // 実際の呼び出し1: 存在する関数はそのまま移譲する
                if ($fname = $this->_resolve($name)) {
                    $this->data = $fname($this->data, ...$arguments);
                    return $this;
                }
                // 実際の呼び出し2: 数値で終わる呼び出しは引数埋め込み位置を指定して移譲する
                if (preg_match('#(.+?)(\d+)$#', $name, $match) && $fname = $this->_resolve($match[1])) {
                    $this->data = $fname(...(array_insert)($arguments, [$this->data], $match[2]));
                    return $this;
                }

                // 接尾呼び出し1: E で終わる呼び出しは文字列を eval した callback とする
                if (preg_match('#(.+?)E$#', $name, $match)) {
                    $expr = array_pop($arguments);
                    $expr = strpos($expr, '$_') === false ? '$_ ' . $expr : $expr;
                    $arguments[] = (eval_func)($expr, '_');
                    return $this->{$match[1]}(...$arguments);
                }
                // 接尾呼び出し2: P で終わる呼び出しは演算子を callback とする
                if (preg_match('#(.+?)P$#', $name, $match)) {
                    $ops = array_reverse((array) array_pop($arguments));
                    $arguments[] = function ($v) use ($ops) {
                        foreach ($ops as $ope => $rand) {
                            if (is_int($ope)) {
                                $ope = $rand;
                                $rand = [];
                            }
                            if (!is_array($rand)) {
                                $rand = [$rand];
                            }
                            $v = (ope_func)($ope)($v, ...$rand);
                        }
                        return $v;
                    };
                    return $this->{$match[1]}(...$arguments);
                }

                throw new \BadFunctionCallException("$name is not defined.");
            }
        };
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
     *     that($ex->getMessage())->isSame('throws');
     * }
     * ```
     *
     * @param \Exception $ex 投げる例外
     * @return mixed （`return hoge or throws` のようなコードで警告が出るので抑止用）
     */
    public static function throws($ex)
    {
        throw $ex;
    }

    /**
     * 条件付き throw
     *
     * 第1引数が true 相当のときに例外を投げる。
     *
     * Example:
     * ```php
     * // 投げない
     * throw_if(false, new \Exception());
     * // 投げる
     * try{throw_if(true, new \Exception());}catch(\Exception $ex){}
     * // クラス指定で投げる
     * try{throw_if(true, \Exception::class, 'message', 123);}catch(\Exception $ex){}
     * ```
     *
     * @param bool|mixed $flag true 相当値を与えると例外を投げる
     * @param \Exception|string $ex 投げる例外。クラス名の場合は中で new する
     * @param array $ex_args $ex にクラス名を与えたときの引数（可変引数）
     */
    public static function throw_if($flag, $ex, ...$ex_args)
    {
        if ($flag) {
            if (is_string($ex)) {
                $ex = new $ex(...$ex_args);
            }
            throw $ex;
        }
    }

    /**
     * 値が空なら null を返す
     *
     * `is_empty($value) ? $value : null` とほぼ同じ。
     * 言ってしまえば「falsy な値を null に変換する」とも言える。
     *
     * ここでいう falsy とは php 標準の `empty` ではなく本ライブラリの `is_empty` であることに留意（"0" は空ではない）。
     * さらに利便性のため 0, 0.0 も空ではない判定をする（strpos や array_search などで「0 は意味のある値」という事が多いので）。
     * 乱暴に言えば「仮に文字列化したとき、情報量がゼロ」が falsy になる。
     *
     * - 「 `$var ?: 'default'` で十分なんだけど "0" が…」
     * - 「 `$var ?? 'default'` で十分なんだけど false が…」
     *
     * という状況はまれによくあるはず。
     *
     * ?? との親和性のため null を返す動作がデフォルトだが、そのデフォルト値は引数で渡すこともできる。
     * 用途は Example を参照。
     *
     * Example:
     * ```php
     * // falsy な値は null を返すので null 合体演算子でデフォルト値が得られる
     * that(blank_if(null) ?? 'default')->isSame('default');
     * that(blank_if('')   ?? 'default')->isSame('default');
     * // falsy じゃない値の場合は引数をそのまま返すので null 合体演算子には反応しない
     * that(blank_if(0)   ?? 'default')->isSame(0);   // 0 は空ではない
     * that(blank_if('0') ?? 'default')->isSame('0'); // "0" は空ではない
     * that(blank_if(1)   ?? 'default')->isSame(1);
     * that(blank_if('X') ?? 'default')->isSame('X');
     * // 第2引数で返る値を指定できるので下記も等価となる。ただし、php の仕様上第2引数が必ず評価されるため、関数呼び出しなどだと無駄な処理となる
     * that(blank_if(null, 'default'))->isSame('default');
     * that(blank_if('',   'default'))->isSame('default');
     * that(blank_if(0,    'default'))->isSame(0);
     * that(blank_if('0',  'default'))->isSame('0');
     * that(blank_if(1,    'default'))->isSame(1);
     * that(blank_if('X',  'default'))->isSame('X');
     * // 第2引数の用途は少し短く書けることと演算子の優先順位のつらみの回避程度（`??` は結構優先順位が低い。下記を参照）
     * that(0 < blank_if(null) ?? 1)->isFalse();  // (0 < null) ?? 1 となるので false
     * that(0 < blank_if(null, 1))->isTrue();     // 0 < 1 となるので true
     * that(0 < (blank_if(null) ?? 1))->isTrue(); // ?? で同じことしたいならこのように括弧が必要
     *
     * # ここから下は既存言語機構との比較（愚痴っぽいので読まなくてもよい）
     *
     * // エルビス演算子は "0" にも反応するので正直言って使いづらい（php における falsy の定義は広すぎる）
     * that(null ?: 'default')->isSame('default');
     * that(''   ?: 'default')->isSame('default');
     * that(1    ?: 'default')->isSame(1);
     * that('0'  ?: 'default')->isSame('default'); // こいつが反応してしまう
     * that('X'  ?: 'default')->isSame('X');
     * // 逆に null 合体演算子は null にしか反応しないので微妙に使い勝手が悪い（php の標準関数が false を返したりするし）
     * that(null ?? 'default')->isSame('default'); // こいつしか反応しない
     * that(''   ?? 'default')->isSame('');
     * that(1    ?? 'default')->isSame(1);
     * that('0'  ?? 'default')->isSame('0');
     * that('X'  ?? 'default')->isSame('X');
     * // 恣意的な例だが、 substr は false も '0' も返し得るので ?: は使えない。 null を返すこともないので ?? も使えない（エラーも吐かない）
     * that(substr('000', 1, 1) ?: 'default')->isSame('default'); // '0' を返すので 'default' になる
     * that(substr('xxx', 9, 1) ?: 'default')->isSame('default'); // （文字数が足りなくて）false を返すので 'default' になる
     * that(substr('000', 1, 1) ?? 'default')->isSame('0');   // substr が null を返すことはないので 'default' になることはない
     * that(substr('xxx', 9, 1) ?? 'default')->isSame(false); // substr が null を返すことはないので 'default' になることはない
     * // 要するに単に「false が返ってきた場合に 'default' としたい」だけなんだが、下記のようにめんどくさいことをせざるを得ない
     * that(substr('xxx', 9, 1) === false ? 'default' : substr('xxx', 9, 1))->isSame('default'); // 3項演算子で2回呼ぶ
     * that(($tmp = substr('xxx', 9, 1) === false) ? 'default' : $tmp)->isSame('default');       // 一時変数を使用する（あるいは if 文）
     * // このように書きたかった
     * that(blank_if(substr('xxx', 9, 1)) ?? 'default')->isSame('default'); // null 合体演算子版
     * that(blank_if(substr('xxx', 9, 1), 'default'))->isSame('default');   // 第2引数版
     *
     * // 恣意的な例その2。 0 は空ではないので array_search などにも応用できる（見つからない場合に false を返すので ?? はできないし、 false 相当を返し得るので ?: もできない）
     * that(array_search('x', ['a', 'b', 'c']) ?? 'default')->isSame(false);     // 見つからないので 'default' としたいが false になってしまう
     * that(array_search('a', ['a', 'b', 'c']) ?: 'default')->isSame('default'); // 見つかったのに 0 に反応するので 'default' になってしまう
     * that(blank_if(array_search('x', ['a', 'b', 'c'])) ?? 'default')->isSame('default'); // このように書きたかった
     * that(blank_if(array_search('a', ['a', 'b', 'c'])) ?? 'default')->isSame(0);         // このように書きたかった
     * ```
     *
     * @param mixed $var 判定する値
     * @param mixed $default 空だった場合のデフォルト値
     * @return mixed 空なら $default, 空じゃないなら $var をそのまま返す
     */
    public static function blank_if($var, $default = null)
    {
        if (is_object($var)) {
            // 文字列化できるかが優先
            if ((is_stringable)($var)) {
                return strlen($var) ? $var : $default;
            }
            // 次点で countable
            if ((is_countable)($var)) {
                return count($var) ? $var : $default;
            }
            return $var;
        }

        // 0, 0.0, "0" は false
        if ($var === 0 || $var === 0.0 || $var === '0') {
            return $var;
        }

        // 上記以外は empty に任せる
        return empty($var) ? $default : $var;
    }

    /**
     * 条件を満たしたときにコールバックを実行する
     *
     * `if ($condition) $callable(...$arguments);` と（$condition はクロージャを受け入れるけど）ほぼ同じ。
     * ただし、 $condition に数値を与えると「指定回数呼ばれたあとに実行する」という意味になる。
     * 主に「ループ内でデバッグ出力したいけど、毎回だと少しうざい」というデバッグ用途。
     *
     * $condition が正数だと「指定回数呼ばれた次のみ」負数だと「指定回数呼ばれた次以降」実行される。
     * 0 のときは無条件で実行される。
     *
     * Example:
     * ```php
     * $output = [];
     * $debug_print = function ($debug) use (&$output) { $output[] = $debug; };
     * for ($i=0; $i<4; $i++) {
     *     call_if($i == 1, $debug_print, '$i == 1のとき呼ばれた');
     *     call_if(2, $debug_print, '2回呼ばれた');
     *     call_if(-2, $debug_print, '2回以上呼ばれた');
     * }
     * that($output)->isSame([
     *     '$i == 1のとき呼ばれた',
     *     '2回呼ばれた',
     *     '2回以上呼ばれた',
     *     '2回以上呼ばれた',
     * ]);
     * ```
     *
     * @param mixed $condition 呼ばれる条件
     * @param callable $callable 呼ばれる処理
     * @param array $arguments $callable の引数（可変引数）
     * @return mixed 呼ばれた場合は $callable の返り値
     */
    public static function call_if($condition, $callable, ...$arguments)
    {
        // 数値の場合はかなり特殊な動きになる
        if (is_int($condition)) {
            static $counts = [];
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            $caller = $trace['file'] . '#' . $trace['line'];
            $counts[$caller] = $counts[$caller] ?? 0;
            if ($condition === 0) {
                $condition = true;
            }
            elseif ($condition > 0) {
                $condition = $condition === $counts[$caller]++;
            }
            else {
                $condition = -$condition <= $counts[$caller]++;
            }
        }
        elseif (is_callable($condition)) {
            $condition = ((func_user_func_array)($condition))();
        }

        if ($condition) {
            return $callable(...$arguments);
        }
        return null;
    }

    /**
     * switch 構文の関数版
     *
     * case にクロージャを与えると実行して返す。
     * つまり、クロージャを返すことは出来ないので注意。
     *
     * $default を与えないとマッチしなかったときに例外を投げる。
     *
     * Example:
     * ```php
     * $cases = [
     *     1 => 'value is 1',
     *     2 => function(){return 'value is 2';},
     * ];
     * that(switchs(1, $cases))->isSame('value is 1');
     * that(switchs(2, $cases))->isSame('value is 2');
     * that(switchs(3, $cases, 'undefined'))->isSame('undefined');
     * ```
     *
     * @param mixed $value 調べる値
     * @param array $cases case 配列
     * @param null $default マッチしなかったときのデフォルト値。指定しないと例外
     * @return mixed
     */
    public static function switchs($value, $cases, $default = null)
    {
        if (!array_key_exists($value, $cases)) {
            if (func_num_args() === 2) {
                throw new \OutOfBoundsException("value $value is not defined in " . json_encode(array_keys($cases)));
            }
            return $default;
        }

        $case = $cases[$value];
        if ($case instanceof \Closure) {
            return $case($value);
        }
        return $case;
    }

    /**
     * 例外を握りつぶす try 構文
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * that(try_null($try, 1, 2, 3))->isSame([1, 2, 3]);
     * // 例外が飛ぶ場合は null が返ってくる
     * $try = function(){throw new \Exception('tried');};
     * that(try_null($try))->isSame(null);
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら null
     */
    public static function try_null($try, ...$variadic)
    {
        try {
            return $try(...$variadic);
        }
        catch (\Exception $tried_ex) {
            return null;
        }
    }

    /**
     * 例外が飛んだら例外オブジェクトを返す
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * that(try_return($try, 1, 2, 3))->isSame([1, 2, 3]);
     * // 例外が飛ぶ場合は例外オブジェクトが返ってくる
     * $try = function(){throw new \Exception('tried');};
     * that(try_return($try))->IsInstanceOf(\Exception::class);
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら null
     */
    public static function try_return($try, ...$variadic)
    {
        try {
            return $try(...$variadic);
        }
        catch (\Exception $tried_ex) {
            return $tried_ex;
        }
    }

    /**
     * try ～ catch 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * that(try_catch($try, null, 1, 2, 3))->isSame([1, 2, 3]);
     * // 例外が飛ぶ場合は特殊なことをしなければ例外オブジェクトが返ってくる
     * $try = function(){throw new \Exception('tried');};
     * that(try_catch($try)->getMessage())->isSame('tried');
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param ?callable $catch catch ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    public static function try_catch($try, $catch = null, ...$variadic)
    {
        return (try_catch_finally)($try, $catch, null, ...$variadic);
    }

    /**
     * try ～ finally 構文の関数版
     *
     * 例外は投げっぱなす。例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $finally_count = 0;
     * $finally = function()use(&$finally_count){$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * that(try_finally($try, $finally, 1, 2, 3))->isSame([1, 2, 3]);
     * that($finally_count)->isSame(1); // 呼ばれている
     * // 例外は投げっぱなすが、 $finally は実行される
     * $try = function(){throw new \Exception('tried');};
     * try {try_finally($try, $finally, 1, 2, 3);} catch(\Exception $e){};
     * that($finally_count)->isSame(2); // 呼ばれている
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param ?callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    public static function try_finally($try, $finally = null, ...$variadic)
    {
        return (try_catch_finally)($try, throws, $finally, ...$variadic);
    }

    /**
     * try ～ catch ～ finally 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $finally_count = 0;
     * $finally = function()use(&$finally_count){$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * that(try_catch_finally($try, null, $finally, 1, 2, 3))->isSame([1, 2, 3]);
     * that($finally_count)->isSame(1); // 呼ばれている
     * // 例外を投げるが、 $catch で握りつぶす
     * $try = function(){throw new \Exception('tried');};
     * that(try_catch_finally($try, null, $finally, 1, 2, 3)->getMessage())->isSame('tried');
     * that($finally_count)->isSame(2); // 呼ばれている
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param ?callable $catch catch ブロッククロージャ
     * @param ?callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    public static function try_catch_finally($try, $catch = null, $finally = null, ...$variadic)
    {
        if ($catch === null) {
            $catch = function ($v) { return $v; };
        }

        try {
            return $try(...$variadic);
        }
        catch (\Exception $tried_ex) {
            try {
                return $catch($tried_ex);
            }
            catch (\Exception $catched_ex) {
                throw $catched_ex;
            }
        }
        finally {
            if ($finally !== null) {
                $finally();
            }
        }
    }
}
