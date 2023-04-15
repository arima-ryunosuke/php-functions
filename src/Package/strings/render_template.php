<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/evaluate.php';
require_once __DIR__ . '/../misc/parse_php.php';
require_once __DIR__ . '/../random/unique_string.php';
require_once __DIR__ . '/../var/attr_exists.php';
require_once __DIR__ . '/../var/attr_get.php';
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
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $template レンダリングするファイル名
 * @param array|object|\Closure $vars レンダリング変数
 * @return string レンダリングされた文字列
 */
function render_template($template, $vars)
{
    assert(is_arrayable($vars) || is_callable($vars) || is_array($vars));

    $tokens = array_slice(parse_php('"' . $template . '"', [
        //'flags' => Syntax::TOKEN_NAME,
    ]), 2, -1);

    $callable_mode = is_callable($vars);

    $embed = $callable_mode ? null : unique_string($template, "embedclosure");
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
                    if (attr_exists($stmt, $vars)) {
                        if ($callable_mode) {
                            $blocks[] = "";
                            $values[] = attr_get($stmt, $vars);
                        }
                        else {
                            // 書き換える必要はない（`${varname}` は正しく埋め込まれる）
                            assert(strlen($stmt));
                        }
                    }
                    else {
                        if ($callable_mode) {
                            $blocks[] = "";
                            $values[] = phpval($stmt, (array) $vars);
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
    return evaluate("return $template;", $vars + [$embed => fn($v) => $v]);
}
