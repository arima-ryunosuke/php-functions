<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 一定確率で true を返す
 *
 * 具体的には $probability / $divisor の確率で true を返す。
 * $divisor のデフォルトは 100 にしてあるので、 $probability だけ与えれば $probability パーセントで true を返すことになる。
 *
 * Example:
 * ```php
 * // 50% の確率で "hello" を出す
 * if (probability(50)) {
 *     echo "hello";
 * }
 * ```
 *
 * @package ryunosuke\Functions\Package\random
 *
 * @param int $probability 分子
 * @param int $divisor 分母
 * @return bool true or false
 */
function probability($probability, $divisor = 100)
{
    $probability = (int) $probability;
    if ($probability < 0) {
        throw new \InvalidArgumentException('$probability must be positive number.');
    }
    $divisor = (int) $divisor;
    if ($divisor < 0) {
        throw new \InvalidArgumentException('$divisor must be positive number.');
    }
    // 不等号の向きや=の有無が怪しかったのでメモ
    // 1. $divisor に 100 が与えられたとすると、取り得る範囲は 0 ～ 99（100個）
    // 2. $probability が 1 だとするとこの式を満たす数は 0 の1個のみ
    // 3. 100 個中1個なので 1%
    return $probability > mt_rand(0, $divisor - 1);
}
