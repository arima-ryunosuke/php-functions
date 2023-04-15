<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * callable から ReflectionFunctionAbstract を生成する
 *
 * Example:
 * ```php
 * that(reflect_callable('sprintf'))->isInstanceOf(\ReflectionFunction::class);
 * that(reflect_callable('\Closure::bind'))->isInstanceOf(\ReflectionMethod::class);
 * ```
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param callable $callable 対象 callable
 * @return \ReflectionFunction|\ReflectionMethod リフレクションインスタンス
 */
function reflect_callable($callable)
{
    // callable チェック兼 $call_name 取得
    if (!is_callable($callable, true, $call_name)) {
        throw new \InvalidArgumentException("'$call_name' is not callable");
    }

    if ($callable instanceof \Closure || strpos($call_name, '::') === false) {
        return new \ReflectionFunction($callable);
    }
    else {
        [$class, $method] = explode('::', $call_name, 2);
        // for タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        if (strpos($method, 'parent::') === 0) {
            [, $method] = explode('::', $method);
            return (new \ReflectionClass($class))->getParentClass()->getMethod($method);
        }
        return new \ReflectionMethod($class, $method);
    }
}
