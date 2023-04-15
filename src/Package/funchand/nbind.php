<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_insert.php';
require_once __DIR__ . '/../funchand/delegate.php';
require_once __DIR__ . '/../reflection/parameter_length.php';
// @codeCoverageIgnoreEnd

/**
 * $callable の指定位置に引数を束縛したクロージャを返す
 *
 * Example:
 * ```php
 * $bind = nbind('sprintf', 2, 'X');
 * that($bind('%s%s%s', 'N', 'N'))->isSame('NXN');
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param callable $callable 対象 callable
 * @param int $n 挿入する引数位置
 * @param mixed ...$variadic 本来の引数（可変引数）
 * @return callable 束縛したクロージャ
 */
function nbind($callable, $n, ...$variadic)
{
    return delegate(function ($callable, $args) use ($variadic, $n) {
        return $callable(...array_insert($args, $variadic, $n));
    }, $callable, parameter_length($callable, true, true) - count($variadic));
}
