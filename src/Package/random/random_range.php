<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 指定範囲内からランダムで返す
 *
 * $count を null にすると個数すらもランダムで返す。
 * 結果は範囲内では重複しない。
 *
 * 範囲が負数の場合は例外を投げるが、$count の 0 や範囲超過数は許容される（array_rand とは違う）。
 *
 * Example:
 * ```php
 * mt_srand(5); // テストがコケるので種固定
 *
 * // [10~20] の区間でランダムに3件返す
 * that(random_range(10, 20, 3))->is([19, 20, 10]);
 * // 0 を渡しても OK（単に空配列を返す）
 * that(random_range(10, 20, 0))->is([]);
 * // 範囲超過数を渡しても OK（最大個数で返す）
 * that(count(random_range(10, 20, 999)))->is(11);
 * ```
 *
 * @package ryunosuke\Functions\Package\random
 *
 * @param int $min 最小値
 * @param int $max 最大値
 * @param ?int $count 返す個数
 * @return array min～maxの数値の配列
 */
function random_range($min, $max, $count = null)
{
    $range = $max - $min;
    if ($range < 0) {
        throw new \InvalidArgumentException("invalid range ($min > $max)");
    }

    if ($count === null) {
        $count = rand(0, $range + 1);
    }

    if ($count > ($range >> 1)) {
        $array = range($min, $max);
        shuffle($array);
        return array_slice($array, 0, $count);
    }

    $result = [];
    while (count($result) < $count) {
        $result[rand($min, $max)] = null;
    }
    return array_keys($result);
}
