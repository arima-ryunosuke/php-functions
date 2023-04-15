<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 処理時間を計測する
 *
 * 第1引数 $callable を $count 回回してその処理時間を返す。
 *
 * Example:
 * ```php
 * // 0.01 秒を 10 回回すので 0.1 秒は超える
 * that(timer(function () {usleep(10 * 1000);}, 10))->greaterThan(0.1);
 * ```
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param callable $callable 処理クロージャ
 * @param int $count ループ回数
 * @return float 処理時間
 */
function timer(callable $callable, $count = 1)
{
    $count = (int) $count;
    if ($count < 1) {
        throw new \InvalidArgumentException("\$count must be greater than 0 (specified $count).");
    }

    $t = microtime(true);
    for ($i = 0; $i < $count; $i++) {
        $callable();
    }
    return microtime(true) - $t;
}
