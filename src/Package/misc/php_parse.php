<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/var_hash.php';
// @codeCoverageIgnoreEnd

/**
 * php のコード断片をパースする
 *
 * @todo そもそも何がしたいのかよくわからない関数になってきたので動作の洗い出しが必要
 *
 * Example:
 * ```php
 * $phpcode = '<?php
 * namespace Hogera;
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
 * that(implode('', array_column($part, 'text')))->isSame('namespace Hogera;');
 *
 * // class ～ { を取得
 * $part = php_parse($phpcode, [
 *     'begin' => T_CLASS,
 *     'end'   => '{',
 * ]);
 * that(implode('', array_column($part, 'text')))->isSame("class Example\n{");
 * ```
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string $phpcode パースする php コード
 * @param array|int $option パースオプション
 * @return \PhpToken[] トークン配列
 */
function php_parse($phpcode, $option = [])
{
    if (is_int($option)) {
        $option = ['flags' => $option];
    }

    $default = [
        'short_open_tag' => null, // ショートオープンタグを扱うか（null だと余計なことはせず ini に従う）
        'line'           => [],   // 行の範囲（以上以下）
        'position'       => [],   // 文字位置の範囲（以上以下）
        'begin'          => [],   // 開始トークン
        'end'            => [],   // 終了トークン
        'offset'         => 0,    // 開始トークン位置
        'flags'          => 0,    // PHPToken の $flags. TOKEN_PARSE を与えると ParseError が出ることがあるのでデフォルト 0
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

    $cachekey = var_hash($phpcode) . $option['flags'] . '-' . $option['backtick'] . '-' . var_export($option['short_open_tag'], true);
    static $cache = [];
    if (!($option['cache'] && isset($cache[$cachekey]))) {
        $position = 0;
        $backtick = '';
        $backticktoken = null;
        $backticking = false;

        $tokens = [];
        $tmp = \PhpToken::tokenize($phpcode, $option['flags']);
        for ($i = 0; $i < count($tmp); $i++) {
            $token = $tmp[$i];

            // @codeCoverageIgnoreStart
            if ($option['short_open_tag'] === true && $token->id === T_INLINE_HTML && ($p = strpos($token->text, '<?')) !== false) {
                $newtokens = [];
                $nlcount = 0;

                if ($p !== 0) {
                    $html = substr($token->text, 0, $p);
                    $nlcount = preg_match_all('#\r\n|\r|\n#u', $html);
                    $newtokens[] = new \PhpToken(T_INLINE_HTML, $html, $token->line);
                }

                $code = substr($token->text, $p + 2);
                $subtokens = \PhpToken::tokenize("<?php $code");
                $subtokens[0]->text = '<?';
                foreach ($subtokens as $subtoken) {
                    $subtoken->line += $token->line + $nlcount - 1;
                    $newtokens[] = $subtoken;
                }

                array_splice($tmp, $i + 1, 0, $newtokens);
                continue;
            }
            if ($option['short_open_tag'] === false && $token->id === T_OPEN_TAG && $token->text === '<?') {
                for ($j = $i + 1; $j < count($tmp); $j++) {
                    if ($tmp[$j]->id === T_CLOSE_TAG) {
                        break;
                    }
                }
                $html = implode('', array_map(fn($token) => $token->text, array_slice($tmp, $i, $j - $i + 1)));
                array_splice($tmp, $i + 1, $j - $i, [new \PhpToken(T_INLINE_HTML, $html, $token->line)]);
                continue;
            }
            // @codeCoverageIgnoreEnd

            if (!$option['backtick']) {
                if ($token->text === '`') {
                    if ($backticking) {
                        $token->text = $backtick . $token->text;
                        $token->line = $backticktoken->line;
                        $token->pos = $backticktoken->pos;
                        $backtick = '';
                    }
                    else {
                        $backticktoken = $token;
                    }
                    $backticking = !$backticking;
                }
                if ($backticking) {
                    $backtick .= $token->text;
                    continue;
                }
            }

            $token->pos = $position;
            $position += strlen($token->text);

            /* PhpToken になりコピーオンライトが効かなくなったので時々書き換えをチェックした方が良い
            $token = new class($token->id, $token->text, $token->line, $token->pos) extends \PhpToken {
                private array $backup = [];

                public function backup()
                {
                    $this->backup = [
                        'id'   => $this->id,
                        'text' => $this->text,
                        'line' => $this->line,
                        'pos'  => $this->pos,
                    ];
                }

                public function __clone(): void
                {
                    $this->backup = [];
                }

                public function __destruct()
                {
                    foreach ($this->backup as $name => $value) {
                        assert($this->$name === $value);
                    }
                }
            };
            $token->backup();
             */

            $tokens[] = $token;
        }
        // @codeCoverageIgnoreStart
        if ($option['short_open_tag'] === false) {
            for ($i = 0; $i < count($tokens); $i++) {
                if ($tokens[$i]->id === T_INLINE_HTML && isset($tokens[$i + 1]) && $tokens[$i + 1]->id === T_INLINE_HTML) {
                    $tokens[$i]->text .= $tokens[$i + 1]->text;
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

        if ($lines[0] > $token->line) {
            continue;
        }
        if ($lines[1] < $token->line) {
            continue;
        }
        if ($positions[0] > $token->pos) {
            continue;
        }
        if ($positions[1] < $token->pos) {
            continue;
        }

        foreach ($begin_tokens as $t) {
            if ($t === $token->id || $t === $token->text) {
                $starting = true;
                break;
            }
        }
        if (!$starting) {
            continue;
        }

        $result[$i] = $token;

        foreach ($nest_tokens as $end_nest => $start_nest) {
            if ($token->id === $start_nest || $token->text === $start_nest) {
                $nesting++;
            }
            if ($token->id === $end_nest || $token->text === $end_nest) {
                $nesting--;
            }
        }

        foreach ($end_tokens as $t) {
            if ($t === $token->id || $t === $token->text) {
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
