<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/evaluate.php';
// @codeCoverageIgnoreEnd

/**
 * 文字列を php の式として評価して値を返す
 *
 * 実質的には `eval("return $var;")` とほぼ同義。
 * ただ、 eval するまでもない式はそのまま返し、bare な文字列はそのまま文字列として返す（7.2 以前の未定義定数のような動作）。
 *
 * Example:
 * ```php
 * that(phpval('strtoupper($var)', ['var' => 'string']))->isSame('STRING');
 * that(phpval('bare string'))->isSame('bare string');
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 評価する式
 * @param array $contextvars eval される場合のローカル変数
 * @return mixed 評価した値
 */
function phpval($var, $contextvars = [])
{
    if (!is_string($var)) {
        return $var;
    }

    if (defined($var)) {
        return constant($var);
    }
    if (ctype_digit(ltrim($var, '+-'))) {
        return (int) $var;
    }
    if (is_numeric($var)) {
        return (double) $var;
    }

    set_error_handler(function () { });
    try {
        return evaluate("return $var;", $contextvars);
    }
    catch (\Throwable $t) {
        return $var;
    }
    finally {
        restore_error_handler();
    }
}
