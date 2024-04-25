<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 正規乱数（正規分布に従う乱数）を返す
 *
 * ※ ボックス＝ミュラー法
 *
 * Example:
 * ```php
 * mt_srand(4); // テストがコケるので種固定
 *
 * // 平均 100, 標準偏差 10 の正規乱数を得る
 * that(random_normal(100, 10))->isSame(101.16879645296162);
 * that(random_normal(100, 10))->isSame(96.49615862542069);
 * that(random_normal(100, 10))->isSame(87.74557282679618);
 * that(random_normal(100, 10))->isSame(117.93697951557125);
 * that(random_normal(100, 10))->isSame(99.1917453115627);
 * that(random_normal(100, 10))->isSame(96.74688207698713);
 * ```
 *
 * @package ryunosuke\Functions\Package\random
 *
 * @param float $average 平均
 * @param float $std_deviation 標準偏差
 * @return float 正規乱数
 */
function random_normal($average = 0.0, $std_deviation = 1.0)
{
    static $z2, $rand_max, $generate = true;
    $rand_max ??= mt_getrandmax();
    $generate = !$generate;

    if ($generate) {
        return $z2 * $std_deviation + $average;
    }

    $u1 = mt_rand(1, $rand_max) / $rand_max;
    $u2 = mt_rand(0, $rand_max) / $rand_max;
    $v1 = sqrt(-2 * log($u1));
    $v2 = 2 * M_PI * $u2;
    $z1 = $v1 * cos($v2);
    $z2 = $v1 * sin($v2);

    return $z1 * $std_deviation + $average;
}
