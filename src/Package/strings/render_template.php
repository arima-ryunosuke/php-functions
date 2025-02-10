<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/php_parse.php';
require_once __DIR__ . '/../strings/strtr_escaped.php';
require_once __DIR__ . '/../utility/json_storage.php';
require_once __DIR__ . '/../var/attr_exists.php';
require_once __DIR__ . '/../var/is_arrayable.php';
require_once __DIR__ . '/../var/phpval.php';
// @codeCoverageIgnoreEnd

/**
 * "hoge ${hoge}" 形式のレンダリング
 *
 * ES6 のテンプレートリテラルのようなもの。
 *
 * - 埋め込みは ${var} のみで、{$var} は無効
 * - ${expression} は「評価結果の変数名」ではなく「評価結果」が埋め込まれる
 *
 * この関数は実験的機能のため、互換性を維持せず変更される可能性がある。
 * また、 token_get_all に頼っているため php9 で `${var}` 構文が廃止されたらおそらく動かない。
 *
 * Example:
 * ```php
 * that(render_template('${max($nums)}', ['nums' => [1, 9, 3]]))->isSame('9');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $template レンダリングする文字列
 * @param array|object $vars レンダリング変数
 * @param callable $tag ブロックと変数値が渡ってくるクロージャ（タグ付きテンプレートリテラルのようなもの）
 * @return string レンダリングされた文字列
 */
function render_template(?string $template, $vars, $tag = null)
{
    assert(is_arrayable($vars) || is_array($vars));

    $tag ??= function ($literals, ...$values) {
        $l = max(count($literals), count($values));
        $result = '';
        for ($i = 0; $i < $l; $i++) {
            $result .= ($literals[$i] ?? '') . ($values[$i] ?? '');
        }
        return $result;
    };

    [$blocks, $stmts] = json_storage(__FUNCTION__)[$template] ??= (function () use ($template) {
        $tokens = array_slice(php_parse("<?php <<<PHPTEMPLATELITERAL\n" . $template . "\nPHPTEMPLATELITERAL;", [
            'backtick' => false,
        ]), 2, -2);
        $last = array_key_last($tokens);
        if ($tokens[$last]->id === T_ENCAPSED_AND_WHITESPACE) {
            $tokens[$last] = clone $tokens[$last];
            $tokens[$last]->text = substr($tokens[$last]->text, 0, -1);
        }

        $blocks = [""];
        $stmts = [];
        for ($i = 0, $l = count($tokens); $i < $l; $i++) {
            if ($tokens[$i]->id === T_DOLLAR_OPEN_CURLY_BRACES) {
                for ($j = $i + 1; $j < $l; $j++) {
                    if ($tokens[$j]->text === '}') {
                        $blocks[] = "";
                        $stmts[] = array_slice($tokens, $i + 1, $j - $i - 1, true);
                        $i = $j;
                        break;
                    }
                }
            }
            else {
                $blocks[count($blocks) - 1] .= strtr_escaped($tokens[$i]->text, ['\$' => '$']);
            }
        }

        array_walk_recursive($stmts, fn(&$token) => $token = (array) $token);
        return [$blocks, $stmts];
    })();

    $values = [];
    foreach ($stmts as $stmt) {
        foreach ($stmt as $n => $subtoken) {
            if ($subtoken['id'] === ord('`')) {
                $stmt[$n]['text'] = var_export(render_template(substr($subtoken['text'], 1, -1), $vars), true);
            }
            elseif (attr_exists($subtoken['text'], $vars) && ($stmt[$n + 1]['text'] ?? '') !== '(') {
                $stmt[$n]['text'] = '$' . $subtoken['text'];
            }
        }
        $values[] = phpval(implode('', array_column($stmt, 'text')), (array) $vars);
    }

    return $tag($blocks, ...$values);
}
