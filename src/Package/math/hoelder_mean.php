<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_find_first.php';
// @codeCoverageIgnoreEnd

/**
 * ヘルダー平均を返す
 *
 * 定義に従い、p=-INF,+INF,0 の場合は特別扱いされる。
 * - -INF: 最小値
 * - +INF: 最大値
 * - 0.0: 幾何平均
 *
 * 要素が 0 の場合はエラーではなく null を返す。
 * これは ?? default を意図したもので、呼び側は常に要素数を意識しなければならない。
 *
 * Example:
 * ```php
 * // 最小値
 * that(hoelder_mean(-INF, 1, 2, 3, 4, 5, 10))->isSame(1);
 * // 最大値
 * that(hoelder_mean(+INF, 1, 2, 3, 4, 5, 10))->isSame(10);
 * // 算術平均
 * that(hoelder_mean(1, 1, 2, 3, 4, 5, 10))->isSame(4.166666666666667);
 * // 平方根平均
 * that(hoelder_mean(0.5, 1, 2, 3, 4, 5, 10))->isSame(3.7021672285503406);
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @param float $p ヘルダー指数
 * @param float|int ...$numbers 数値の配列
 * @return float|int|null 計算結果
 */
function hoelder_mean(float $p, float|int ...$numbers): float|int|null
{
    $count = count($numbers);
    if (!$count) {
        return null;
    }

    if ($p === -INF) {
        return min($numbers);
    }
    if ($p === +INF) {
        return max($numbers);
    }
    if ($p === 0.0) {
        // 幾何平均で <=0 は定義されない
        if (array_find_first($numbers, fn($v) => $v <= 0) !== null) {
            throw new \LogicException("geometric mean must be number>0.");
        }
        return exp(array_sum(array_map(fn($v) => log($v), $numbers)) / $count);
    }

    return pow(array_sum(array_map(fn($v) => pow($v, $p), $numbers)) / $count, 1 / $p);
}
