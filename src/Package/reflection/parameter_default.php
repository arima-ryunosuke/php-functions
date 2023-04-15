<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_merge2.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
// @codeCoverageIgnoreEnd

/**
 * callable のデフォルト引数を返す
 *
 * オプションで指定もできる。
 * 負数を指定した場合「最後の引数から数えた位置」になる。
 *
 * 内部関数には使用できない（リフレクションが対応していない）。
 *
 * Example:
 * ```php
 * $f = function ($a, $b = 'b') {};
 * // デフォルト引数である b を返す
 * that(parameter_default($f))->isSame([1 => 'b']);
 * // 引数で与えるとそれが優先される
 * that(parameter_default($f, ['A', 'B']))->isSame(['A', 'B']);
 * ```
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param callable $callable 対象 callable
 * @param iterable|array $arguments デフォルト引数
 * @return array デフォルト引数
 */
function parameter_default(callable $callable, $arguments = [])
{
    static $cache = [];

    // $call_name でキャッシュ。しかしクロージャはすべて「Closure::__invoke」になるのでキャッシュできない
    is_callable($callable, true, $call_name);
    if (!isset($cache[$call_name]) || $callable instanceof \Closure) {
        /** @var \ReflectionFunctionAbstract $refunc */
        $refunc = reflect_callable($callable);
        $cache[$call_name] = [
            'length'  => $refunc->getNumberOfParameters(),
            'default' => [],
        ];
        foreach ($refunc->getParameters() as $n => $param) {
            if ($param->isDefaultValueAvailable()) {
                $cache[$call_name]['default'][$n] = $param->getDefaultValue();
            }
        }
    }

    // 指定されていないならそのまま返せば良い（高速化）
    if (is_array($arguments) && !$arguments) {
        return $cache[$call_name]['default'];
    }

    $args2 = [];
    foreach ($arguments as $n => $arg) {
        if ($n < 0) {
            $n += $cache[$call_name]['length'];
        }
        $args2[$n] = $arg;
    }

    return array_merge2($cache[$call_name]['default'], $args2);
}
