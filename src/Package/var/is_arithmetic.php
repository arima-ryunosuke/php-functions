<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 変数が算術可能か調べる
 *
 * Example:
 * ```php
 * // 整数
 * that(is_arithmetic(123))->isTrue();
 * // 小数
 * that(is_arithmetic(3.14))->isTrue();
 * // 数値文字列
 * that(is_arithmetic('-3.14'))->isTrue();
 * // GMP
 * that(is_arithmetic(gmp_init('3')))->isTrue();
 * // 変な文字列やオブジェクトは false
 * that(is_arithmetic('hoge'))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 調べる値
 * @return bool 配列アクセス可能なら true
 * @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection
 */
function is_arithmetic($var)
{
    // cast_object レベルで実装されているので計算可能
    if ($var instanceof \GMP || $var instanceof \BcMath\Number || $var instanceof \SimpleXMLElement) {
        return true;
    }

    return is_numeric($var);
}
