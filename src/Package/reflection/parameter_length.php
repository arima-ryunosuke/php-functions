<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../reflection/reflect_callable.php';
require_once __DIR__ . '/../utility/cache.php';
// @codeCoverageIgnoreEnd

/**
 * callable の引数の数を返す
 *
 * クロージャはキャッシュされない。毎回リフレクションを生成し、引数の数を調べてそれを返す。
 * （クロージャには一意性がないので key-value なキャッシュが適用できない）。
 * ので、ループ内で使ったりすると目に見えてパフォーマンスが低下するので注意。
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
    // クロージャの $call_name には一意性がないのでキャッシュできない（spl_object_hash でもいいが、かなり重複するので完全ではない）
    if ($callable instanceof \Closure) {
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

    // $call_name 取得
    is_callable($callable, false, $call_name);

    $cache = cache($call_name, function () use ($callable) {
        /** @var \ReflectionFunctionAbstract $ref */
        $ref = reflect_callable($callable);
        return [
            '00' => $ref->getNumberOfParameters(),
            '01' => $ref->isVariadic() ? INF : $ref->getNumberOfParameters(),
            '10' => $ref->getNumberOfRequiredParameters(),
            '11' => $ref->isVariadic() ? INF : $ref->getNumberOfRequiredParameters(),
        ];
    }, __FUNCTION__);
    return $cache[(int) $require_only . (int) $thought_variadic];
}
