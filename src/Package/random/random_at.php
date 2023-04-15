<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 引数をランダムで返す
 *
 * - 候補がない場合はエラーではなく例外を投げる
 *
 * Example:
 * ```php
 * // 1 ～ 6 のどれかを返す
 * that(random_at(1, 2, 3, 4, 5, 6))->isAny([1, 2, 3, 4, 5, 6]);
 * ```
 *
 * @package ryunosuke\Functions\Package\random
 *
 * @param mixed ...$args 候補
 * @return mixed 引数のうちどれか
 */
function random_at(...$args)
{
    return $args[mt_rand(0, count($args) - 1)];
}
