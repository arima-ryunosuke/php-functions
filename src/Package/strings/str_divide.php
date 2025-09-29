<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../math/int_divide.php';
// @codeCoverageIgnoreEnd

/**
 * str_split の配列長指定版
 *
 * Example:
 * ```php
 * // "abcdefg" を3つに分割（余りを左に分配）
 * that(str_divide("abcdefg", 3))->isSame(["abc", "de", "fg"]);
 * // "abcdefg" を3つに分割（余りを右に分配）
 * that(str_divide("abcdefg", -3))->isSame(["ab", "cd", "efg"]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 */
function str_divide(string $string, int $divisor): array
{
    $last = 0;
    $result = [];
    foreach (int_divide(strlen($string), $divisor) as $int) {
        $result[] = substr($string, $last, $int);
        $last += $int;
    }

    return $result;
}
