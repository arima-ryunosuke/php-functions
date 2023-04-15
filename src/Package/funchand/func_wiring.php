<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../reflection/parameter_wiring.php';
// @codeCoverageIgnoreEnd

/**
 * 引数の型情報に基づいてワイヤリングしたクロージャを返す
 *
 * $dependency に数値キーの配列を混ぜるとデフォルト値として使用される。
 * 得られたクロージャの呼び出し時に引数を与える事ができる。
 *
 * parameter_wiring も参照。
 *
 * Example:
 * ```php
 * $closure = fn ($a, $b) => func_get_args();
 * $new_closure = func_wiring($closure, [
 *     '$a' => 'a',
 *     '$b' => 'b',
 *     1    => 'B',
 * ]);
 * that($new_closure())->isSame(['a', 'B']);    // 同時指定の場合は数値キー優先
 * that($new_closure('A'))->isSame(['A', 'B']); // 呼び出し時の引数優先
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param callable $callable 対象 callable
 * @param array|\ArrayAccess $dependency 引数候補配列
 * @return \Closure 引数を確定したクロージャ
 */
function func_wiring($callable, $dependency)
{
    $params = parameter_wiring($callable, $dependency);
    return fn(...$args) => $callable(...$args + $params);
}
