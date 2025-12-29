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
 * 定数を許可しているのは PI(3.14) や HOUR(3600) などの利便性のため。ただし定数は $allow_constant で受け付ける物を制限できる。
 * 定数値が非数値の場合、強制的に数値化して警告を促す。
 *
 * $allow_comma を true にするとカンマ区切りの数値も許可される。
 * 内部的には _ への置換であり、シンタックスは保たれる。
 * つまり ",123" のような変な数値はエラーになるし、逆に言うと3桁等のチェックはされないことになる。
 * ちょっと懸念があるのでデフォルト false にしているが、将来的に true になるか引数自体が削除される見込み。
 *
 * $formula に配列を渡すと全てを計算してそのまま配列で返す。
 * つまり呼び元で foreach しても同じ結果になる。
 * 最大の違いは内部的に eval を使用しているため、都度呼ぶのと一括で呼ぶのとでは速度に明らかに違いが出る点。
 * このような処理は得てして1度で終わらず、何度も呼び出される傾向があるためまとめて呼びやすいようにこのような実装になっている。
 *
 * Example:
 * ```php
 * // 定数やカンマが使える
 * that(calculate_formula('1 + 2 - 3 * 4'))->isSame(-9);
 * that(calculate_formula('1 + (2 - 3) * 4'))->isSame(-3);
 * that(calculate_formula('1,234+5,678', allow_comma: true))->isSame(6912);
 * that(calculate_formula('PHP_INT_SIZE * 3'))->isSame(PHP_INT_SIZE * 3);
 * // 配列を与えると全て計算して配列を返す（キーは維持される）
 * that(calculate_formula([
 *     'k1' => '123+456',
 *     'k2' => '789+123',
 * ]))->is([
 *     'k1' => '579',
 *     'k2' => '912',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 */
function calculate_formula(
    string|array $formula,
    bool $allow_comma = false,
    bool|array $allow_constant = true,
): int|float|array {
    $isarray = is_array($formula);

    if (is_array($allow_constant)) {
        $allow_constant = array_flip(array_map(fn($v) => ltrim($v, '\\'), $allow_constant));
    }

    $throw = function ($k, $token) use ($isarray) {
        if ($isarray) {
            throw new \ParseError(sprintf("syntax error, unexpected '%s' in %s on line %d", $token->text, $k, $token->line));
        }
        else {
            throw new \ParseError(sprintf("syntax error, unexpected '%s' on line %d", $token->text, $token->line));
        }
    };

    $expressions = [];
    foreach ((array) $formula as $k => $v) {
        $tokens = php_tokens("<?php ($v);");
        array_shift($tokens);
        array_pop($tokens);

        $constants = [T_STRING, T_DOUBLE_COLON, T_NS_SEPARATOR, T_NAME_QUALIFIED, T_NAME_FULLY_QUALIFIED, T_NAME_RELATIVE];
        $operands = [T_LNUMBER, T_DNUMBER, '_'];
        $operators = ['(', ')', '+', '-', '*', '/', '%', '**'];

        if ($allow_comma) {
            foreach ($tokens as $n => $token) {
                if ($token->prev(fn() => true)?->is($operands) && $token->is(',') && $token->next(fn() => true)?->is($operands)) {
                    $tokens[$n] = $token->clone(id: ord('_'), text: '_');
                }
            }
        }

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
                    $constant = ltrim($constant, '\\');
                    if (!($allow_constant === true || isset($allow_constant[$constant]))) {
                        $throw($k, $token);
                    }
                    if (!defined($constant)) {
                        $throw($k, $token);
                    }
                    $expression .= constant($constant) + 0;
                    $constant = '';
                }
                $expression .= $token->text;
            }
            else {
                $throw($k, $token);
            }
        }
        $expressions[$k] = var_export($k, true) . '=>' . $expression;
    }

    $results = evaluate("return [" . implode(",", $expressions) . "];");
    if ($isarray) {
        return $results;
    }
    return $results[0];
}
