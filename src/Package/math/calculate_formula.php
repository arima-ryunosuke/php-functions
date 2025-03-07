<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/evaluate.php';
require_once __DIR__ . '/../misc/php_tokens.php';
// @codeCoverageIgnoreEnd

/**
 * 数式を計算して結果を返す
 *
 * 内部的には eval で計算するが、文字列や関数呼び出しなどは受け付けないため原則としてセーフティ。
 * 許可されるのは定数・数値リテラルと演算子のみ。
 * 定数を許可しているのは PI(3.14) や HOUR(3600) などの利便性のため。
 * 定数値が非数値の場合、強制的に数値化して警告を促す。
 *
 * Example:
 * ```php
 * that(calculate_formula('1 + 2 - 3 * 4'))->isSame(-9);
 * that(calculate_formula('1 + (2 - 3) * 4'))->isSame(-3);
 * that(calculate_formula('PHP_INT_SIZE * 3'))->isSame(PHP_INT_SIZE * 3);
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @param string $formula 計算式
 * @return int|float 計算結果
 */
function calculate_formula($formula)
{
    // TOKEN_PARSE を渡せばシンタックスチェックも行ってくれる
    $tokens = php_tokens("<?php ($formula);", TOKEN_PARSE);
    array_shift($tokens);
    array_pop($tokens);

    $constants = [T_STRING, T_DOUBLE_COLON, T_NS_SEPARATOR, T_NAME_QUALIFIED, T_NAME_FULLY_QUALIFIED, T_NAME_RELATIVE];
    $operands = [T_LNUMBER, T_DNUMBER];
    $operators = ['(', ')', '+', '-', '*', '/', '%', '**'];

    $constant = '';
    $expression = '';
    foreach ($tokens as $token) {
        if ($token->isIgnorable()) {
            continue;
        }
        if ($token->is($constants)) {
            $constant .= $token->text;
        }
        elseif ($token->is($operands) || $token->is($operators)) {
            if (strlen($constant)) {
                $expression .= constant($constant) + 0;
                $constant = '';
            }
            $expression .= $token->text;
        }
        else {
            throw new \ParseError(sprintf("syntax error, unexpected '%s' in  on line %d", $token->text, $token->line));
        }
    }
    return evaluate("return $expression;");
}
