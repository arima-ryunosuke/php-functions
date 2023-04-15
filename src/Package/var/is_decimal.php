<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 値が10進的か調べる
 *
 * is_numeric を少しキツめにしたような関数で、なるべく「一般人の感覚」で数値とみなせるものを true で返す。
 *
 * なお、 0 始まりは false だが 0 終わり小数は許容される。
 * `1.20000` を false にするような動作だと `1.0` も false にしなければ一貫性がない。
 * しかし `1.0` が false になるのはあまり一般的とはいえない。
 *
 * 空白込みが false なのは空白許可は呼び元に委ねたいため（trim すればいいだけなので）。
 *
 * Example:
 * ```php
 * // 以下は is_numeric と違い false を返す
 * that(is_decimal('.12'))->isFalse();  // 整数部省略
 * that(is_decimal('12.'))->isFalse();  // 小数部省略
 * that(is_decimal('1e2'))->isFalse();  // 指数記法
 * that(is_decimal(' 12 '))->isFalse(); // 空白あり
 * that(is_decimal('012'))->isFalse();  // 0 始まり
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 判定する値
 * @param bool $allow_float false にすると整数のみを許可する
 * @return bool 数値なら true
 */
function is_decimal($var, $allow_float = true)
{
    if (!is_numeric($var)) {
        return false;
    }

    $integer = "(0|[1-9][0-9]*)";
    $fraction = $allow_float ? "(\.[0-9]+)?" : "";
    return !!preg_match("/^[+-]?$integer$fraction$/", (string) $var);
}
