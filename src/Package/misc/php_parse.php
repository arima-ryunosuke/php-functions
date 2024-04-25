<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/var_hash.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

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
 * $part = php_parse($phpcode, [
 *     'begin' => T_NAMESPACE,
 *     'end'   => ';',
 * ]);
 * that(implode('', array_column($part, 1)))->isSame('namespace Hogera;');
 *
 * // class ～ { を取得
 * $part = php_parse($phpcode, [
 *     'begin' => T_CLASS,
 *     'end'   => '{',
 * ]);
 * that(implode('', array_column($part, 1)))->isSame("class Example\n{");
 * ```
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string $phpcode パースする php コード
 * @param array|int $option パースオプション
 * @return array トークン配列
 */
function php_parse($phpcode, $option = [])
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
        'greedy'         => false,// end と nest か一致したときに処理を継続するか
        'backtick'       => true, // `` もパースするか
        'nest_token'     => [
            ')' => '(',
            '}' => '{',
            ']' => '[',
        ],
    ];
    $option += $default;

    $cachekey = var_hash($phpcode) . $option['flags'] . '-' . $option['phptag'] . '-' . var_export($option['short_open_tag'], true);
    static $cache = [];
    if (!($option['cache'] && isset($cache[$cachekey]))) {
        $phptag = $option['phptag'] ? '<?php ' : '';
        $phpcode = $phptag . $phpcode;
        $position = -strlen($phptag);

        $backtick = '';
        $backticking = false;

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
                $html = implode('', array_map(fn($token) => is_array($token) ? $token[1] : $token, array_slice($tmp, $i, $j - $i + 1)));
                array_splice($tmp, $i + 1, $j - $i, [[T_INLINE_HTML, $html, $token[2]]]);
                continue;
            }
            // @codeCoverageIgnoreEnd

            if (!$option['backtick']) {
                if ($token[1] === '`') {
                    if ($backticking) {
                        $token[1] = $backtick . $token[1];
                        $backtick = '';
                    }
                    $backticking = !$backticking;
                }
                if ($backticking) {
                    $backtick .= $token[1];
                    continue;
                }
            }

            $token[] = $position;
            if ($option['flags'] & TOKEN_NAME) {
                $token[] = !$option['backtick'] && $token[0] === 96 ? 'T_BACKTICK' : token_name($token[0]);
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
        $cache[$cachekey] = $tokens;
    }
    $tokens = $cache[$cachekey];

    $lines = $option['line'] + [-PHP_INT_MAX, PHP_INT_MAX];
    $positions = $option['position'] + [-PHP_INT_MAX, PHP_INT_MAX];
    $begin_tokens = (array) $option['begin'];
    $end_tokens = (array) $option['end'];
    $nest_tokens = $option['nest_token'];
    $greedy = $option['greedy'];

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

        foreach ($nest_tokens as $end_nest => $start_nest) {
            if ($token[0] === $start_nest || $token[1] === $start_nest) {
                $nesting++;
            }
            if ($token[0] === $end_nest || $token[1] === $end_nest) {
                $nesting--;
            }
        }

        foreach ($end_tokens as $t) {
            if ($t === $token[0] || $t === $token[1]) {
                if ($nesting <= 0 || ($nesting === 1 && in_array($t, $nest_tokens, true))) {
                    if ($nesting === 0 && $greedy && isset($nest_tokens[$t])) {
                        break;
                    }
                    break 2;
                }
                break;
            }
        }
    }
    return $result;
}
