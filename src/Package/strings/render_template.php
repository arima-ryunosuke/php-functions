<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/parse_php.php';
require_once __DIR__ . '/../strings/strtr_escaped.php';
require_once __DIR__ . '/../utility/cache.php';
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
function render_template($template, $vars, $tag = null)
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

    [$blocks, $stmts] = cache("template-$template", function () use ($template) {
        $tokens = array_slice(parse_php("<<<PHPTEMPLATELITERAL\n" . $template . "\nPHPTEMPLATELITERAL;", [
            'backtick' => false,
        ]), 2, -2);
        $last = array_key_last($tokens);
        if ($tokens[$last][0] === T_ENCAPSED_AND_WHITESPACE) {
            $tokens[$last][1] = substr($tokens[$last][1], 0, -1);
        }

        $blocks = [""];
        $stmts = [];
        for ($i = 0, $l = count($tokens); $i < $l; $i++) {
            if ($tokens[$i][0] === T_DOLLAR_OPEN_CURLY_BRACES) {
                for ($j = $i + 1; $j < $l; $j++) {
                    if ($tokens[$j][1] === '}') {
                        $blocks[] = "";
                        $stmts[] = array_slice($tokens, $i + 1, $j - $i - 1, true);
                        $i = $j;
                        break;
                    }
                }
            }
            else {
                $blocks[count($blocks) - 1] .= strtr_escaped($tokens[$i][1], ['\$' => '$']);
            }
        }

        return [$blocks, $stmts];
    }, __FUNCTION__);

    $values = [];
    foreach ($stmts as $stmt) {
        foreach ($stmt as $n => $subtoken) {
            if ($subtoken[0] === ord('`')) {
                $stmt[$n][1] = var_export(render_template(substr($subtoken[1], 1, -1), $vars), true);
            }
            elseif (attr_exists($subtoken[1], $vars) && ($stmt[$n + 1][1] ?? '') !== '(') {
                $stmt[$n][1] = '$' . $subtoken[1];
            }
        }
        $values[] = phpval(implode('', array_column($stmt, 1)), (array) $vars);
    }

    return $tag($blocks, ...$values);
}
