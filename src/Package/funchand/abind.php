<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_fill_gap.php';
require_once __DIR__ . '/../funchand/delegate.php';
require_once __DIR__ . '/../reflection/parameter_length.php';
// @codeCoverageIgnoreEnd

/**
 * $callable の引数を指定配列で束縛したクロージャを返す
 *
 * Example:
 * ```php
 * $bind = abind('sprintf', [1 => 'a', 3 => 'c']);
 * that($bind('%s%s%s', 'b'))->isSame('abc');
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param callable $callable 対象 callable
 * @param array $default_args 本来の引数
 * @return callable 束縛したクロージャ
 */
function abind($callable, $default_args)
{
    return delegate(function ($callable, $args) use ($default_args) {
        return $callable(...array_fill_gap($default_args, ...$args));
    }, $callable, parameter_length($callable, true, true) - count($default_args));
}
