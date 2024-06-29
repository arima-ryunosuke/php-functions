<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列のバイト配列を得る
 *
 * $base 引数で基数を変更できる。
 *
 * Example:
 * ```php
 * // 10進配列で返す
 * that(str_bytes('abc'))->isSame([97, 98, 99]);
 * // 16進配列で返す
 * that(str_bytes('abc', 16))->isSame(["61", "62", "63"]);
 * // マルチバイトで余計なことはしない（php としての文字列のバイト配列をそのまま返す）
 * that(str_bytes('あいう', 16))->isSame(["e3", "81", "82", "e3", "81", "84", "e3", "81", "86"]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param int $base 基数
 * @return array 文字のバイト配列
 */
function str_bytes(?string $string, $base = 10)
{
    // return array_values(unpack('C*', $string));

    $base = intval($base);
    $strlen = strlen($string);
    $result = [];
    for ($i = 0; $i < $strlen; $i++) {
        $ord = ord($string[$i]);
        if ($base !== 10) {
            $ord = base_convert($ord, 10, $base);
        }
        $result[] = $ord;
    }
    return $result;
}
