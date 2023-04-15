<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列比較の関数版
 *
 * 文字列以外が与えられた場合は常に false を返す。ただし __toString を実装したオブジェクトは別。
 *
 * Example:
 * ```php
 * that(str_equals('abc', 'abc'))->isTrue();
 * that(str_equals('abc', 'ABC', true))->isTrue();
 * that(str_equals('\0abc', '\0abc'))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $str1 文字列1
 * @param string $str2 文字列2
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @return bool 同じ文字列なら true
 */
function str_equals($str1, $str2, $case_insensitivity = false)
{
    // __toString 実装のオブジェクトは文字列化する（strcmp がそうなっているから）
    if (is_object($str1) && method_exists($str1, '__toString')) {
        $str1 = (string) $str1;
    }
    if (is_object($str2) && method_exists($str2, '__toString')) {
        $str2 = (string) $str2;
    }

    // この関数は === の関数版という位置づけなので例外は投げないで不一致とみなす
    if (!is_string($str1) || !is_string($str2)) {
        return false;
    }

    if ($case_insensitivity) {
        return strcasecmp($str1, $str2) === 0;
    }

    return $str1 === $str2;
}
