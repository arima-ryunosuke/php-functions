<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * $this を bind 可能なクロージャか調べる
 *
 * Example:
 * ```php
 * that(is_bindable_closure(function () {}))->isTrue();
 * that(is_bindable_closure(static function () {}))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param \Closure $closure 調べるクロージャ
 * @return bool $this を bind 可能なクロージャなら true
 */
function is_bindable_closure(\Closure $closure)
{
    return !!@$closure->bindTo(new \stdClass());
}
