<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 疑似乱数小数を返す
 *
 * 疑似的に生成しているので偏りはあることに注意。
 * https://www.php.net/manual/random-randomizer.getfloat.php
 * https://www.php.net/manual/random-randomizer.nextfloat.php
 *
 * Example:
 * ```php
 * // [-M_PI~+M_PI] の区間でランダムに返す
 * that(random_float(-M_PI, +M_PI))->isBetween(-M_PI, +M_PI);
 * ```
 *
 * @package ryunosuke\Functions\Package\random
 *
 * @param float $min 最小値
 * @param float $max 最大値
 * @return float min～maxの乱数
 */
function random_float($min, $max)
{
    if ($min > $max) {
        throw new \Error('Minimum value must be less than or equal to the maximum value');
    }
    //return ($min + ($max - $min) * lcg_value());
    return $min + ($max - $min) * rand(0, getrandmax()) / getrandmax();
}
