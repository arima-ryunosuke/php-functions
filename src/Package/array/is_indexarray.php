<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列が数値配列か調べる
 *
 * 空の配列も数値配列とみなす。
 * さらにいわゆる「連番配列」ではなく「キーが数値のみか？」で判定する。
 *
 * つまり、 is_hasharray とは排他的ではない。
 *
 * Example:
 * ```php
 * that(is_indexarray([]))->isTrue();
 * that(is_indexarray([1, 2, 3]))->isTrue();
 * that(is_indexarray(['x' => 'X']))->isFalse();
 * // 抜け番があっても true になる（これは is_hasharray も true になる）
 * that(is_indexarray([1 => 1, 2 => 2, 3 => 3]))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 調べる配列
 * @return bool 数値配列なら true
 */
function is_indexarray($array)
{
    foreach ($array as $k => $dummy) {
        if (!is_int($k)) {
            return false;
        }
    }
    return true;
}
