<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../errorfunc/set_error_exception_handler.php';
// @codeCoverageIgnoreEnd

/**
 * 0xff,0777 などを10進数値化する
 *
 * php のリテラル形式の数値文字列を int に変換すると考えればよい。
 * intval でも似たようなことはできるが、エラーも例外も発生せず静かに 0 を返すので使い勝手が悪い。
 * この関数は変換できない場合は例外を投げる。
 *
 * Example:
 * ```php
 * // 数値を与えれば数値のまま
 * that(strdec(12345))->isSame(12345);
 * // 通常の10進数字
 * that(strdec('12345'))->isSame(12345);
 * // 16進数字
 * that(strdec('0xff'))->isSame(255);
 * // 8進数字
 * that(strdec('077'))->isSame(63);
 * that(strdec('0o77'))->isSame(63);
 * // 2進数字
 * that(strdec('0b11'))->isSame(3);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 */
function strdec($var): int|float
{
    if (is_int($var) || is_float($var)) {
        return $var;
    }

    $restore = set_error_exception_handler();
    try {
        $var = strtr($var, ['_' => '']);
        $sign = 1;
        if (($var[0] ?? '') === '-') {
            $sign = -1;
            $var = substr($var, 1);
        }
        if (strcasecmp(substr($var, 0, 2), '0x') === 0) {
            return $sign * hexdec($var);
        }
        if (strcasecmp(substr($var, 0, 2), '0b') === 0) {
            return $sign * bindec($var);
        }
        if (strcasecmp(substr($var, 0, 2), '0o') === 0 || strcasecmp(substr($var, 0, 1), '0') === 0) {
            return $sign * octdec($var);
        }

        return $sign * $var;
    }
    finally {
        $restore();
    }
}
