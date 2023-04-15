<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_insert.php';
require_once __DIR__ . '/../funchand/nbind.php';
// @codeCoverageIgnoreEnd

/**
 * $callable の最右に引数を束縛した callable を返す
 *
 * Example:
 * ```php
 * $bind = rbind('sprintf', 'X');
 * that($bind('%s%s', 'N'))->isSame('NX');
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param callable $callable 対象 callable
 * @param mixed ...$variadic 本来の引数（可変引数）
 * @return callable 束縛したクロージャ
 */
function rbind($callable, ...$variadic)
{
    return nbind(...array_insert(func_get_args(), null, 1));
}
