<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 値を数値化する
 *
 * int か float ならそのまま返す。
 * 文字列の場合、一言で言えば「.を含むなら float、含まないなら int」を返す。
 * int でも float でも stringable でもない場合は実装依存（ただの int キャスト）。
 *
 * Example:
 * ```php
 * that(numval(3.14))->isSame(3.14);   // int や float はそのまま返す
 * that(numval('3.14'))->isSame(3.14); // . を含む文字列は float を返す
 * that(numval('11', 8))->isSame(9);   // 基数が指定できる
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 数値化する値
 * @param int $base 基数。int 的な値のときしか意味をなさない
 * @return int|float 数値化した値
 */
function numval($var, $base = 10)
{
    if (is_int($var) || is_float($var)) {
        return $var;
    }
    if (is_object($var)) {
        $var = (string) $var;
    }
    if (is_string($var) && strpos($var, '.') !== false) {
        return (float) $var;
    }
    return intval($var, $base);
}
