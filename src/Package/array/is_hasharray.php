<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列が連想配列か調べる
 *
 * 空の配列は普通の配列とみなす。
 *
 * Example:
 * ```php
 * that(is_hasharray([]))->isFalse();
 * that(is_hasharray([1, 2, 3]))->isFalse();
 * that(is_hasharray(['x' => 'X']))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 調べる配列
 * @return bool 連想配列なら true
 */
function is_hasharray(array $array)
{
    if (function_exists('array_is_list')) {
        return !array_is_list($array); // @codeCoverageIgnore
    }

    $i = 0;
    foreach ($array as $k => $dummy) {
        if ($k !== $i++) {
            return true;
        }
    }
    return false;
}
