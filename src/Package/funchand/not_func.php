<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/delegate.php';
// @codeCoverageIgnoreEnd

/**
 * 返り値の真偽値を逆転した新しいクロージャを返す
 *
 * Example:
 * ```php
 * $not_strlen = not_func('strlen');
 * that($not_strlen('hoge'))->isFalse();
 * that($not_strlen(''))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param callable $callable 対象 callable
 * @return callable 新しいクロージャ
 */
function not_func($callable)
{
    return delegate(fn($callable, $args) => !$callable(...$args), $callable);
}
