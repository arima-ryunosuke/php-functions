<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../reflection/reflect_callable.php';
// @codeCoverageIgnoreEnd

/**
 * callable の引数の数を返す
 *
 * Example:
 * ```php
 * // trim の引数は2つ
 * that(parameter_length('trim'))->isSame(2);
 * // trim の必須引数は1つ
 * that(parameter_length('trim', true))->isSame(1);
 * ```
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param callable $callable 対象 callable
 * @param bool $require_only true を渡すと必須パラメータの数を返す
 * @param bool $thought_variadic 可変引数を考慮するか。 true を渡すと可変引数の場合に無限長を返す
 * @return int 引数の数
 */
function parameter_length($callable, $require_only = false, $thought_variadic = false)
{
    /** @var \ReflectionFunctionAbstract $ref */
    $ref = reflect_callable($callable);
    if ($thought_variadic && $ref->isVariadic()) {
        return INF;
    }
    elseif ($require_only) {
        return $ref->getNumberOfRequiredParameters();
    }
    else {
        return $ref->getNumberOfParameters();
    }
}
