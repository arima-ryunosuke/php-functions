<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
// @codeCoverageIgnoreEnd

/**
 * callable の引数の型情報に基づいてワイヤリングした引数配列を返す
 *
 * ワイヤリングは下記のルールに基づいて行われる。
 *
 * - 引数の型とキーが完全一致
 * - 引数の型とキーが継承・実装関係
 *   - 複数一致した場合は解決されない
 * - 引数名とキーが完全一致
 *   - 可変引数は追加
 * - 引数のデフォルト値
 * - 得られた値がクロージャの場合は再帰的に解決
 *   - $this は $dependency になるが FromCallable 経由の場合は元のまま
 *
 * Example:
 * ```php
 * $closure = function (\ArrayObject $ao, \Throwable $t, $array, $none, $default1, $default2 = 'default2', ...$misc) { return get_defined_vars(); };
 * $params = parameter_wiring($closure, [
 *     \ArrayObject::class      => $ao = new \ArrayObject([1, 2, 3]),
 *     \RuntimeException::class => $t = new \RuntimeException('hoge'),
 *     '$array'                 => fn (\ArrayObject $ao) => (array) $ao,
 *     4                        => 'default1',
 *     '$misc'                  => ['x', 'y', 'z'],
 * ]);
 * that($params)->isSame([
 *     0 => $ao,        // 0番目はクラス名が完全一致
 *     1 => $t,         // 1番目はインターフェース実装
 *     2 => [1, 2, 3],  // 2番目はクロージャをコール
 *                      // 3番目は解決されない
 *     4 => 'default1', // 4番目は順番指定のデフォルト値
 *     5 => 'default2', // 5番目は引数定義のデフォルト値
 *     6 => 'x',        // 可変引数なのでフラットに展開
 *     7 => 'y',
 *     8 => 'z',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param callable $callable 対象 callable
 * @param array|\ArrayAccess $dependency 引数候補配列
 * @return array 引数配列
 */
function parameter_wiring($callable, $dependency)
{
    /** @var \ReflectionFunctionAbstract $ref */
    $ref = reflect_callable($callable);
    $result = [];

    foreach ($ref->getParameters() as $n => $parameter) {
        if (isset($dependency[$n])) {
            $result[$n] = $dependency[$n];
        }
        elseif (isset($dependency[$pname = '$' . $parameter->getName()])) {
            if ($parameter->isVariadic()) {
                foreach (array_values(arrayize($dependency[$pname])) as $i => $v) {
                    $result[$n + $i] = $v;
                }
            }
            else {
                $result[$n] = $dependency[$pname];
            }
        }
        elseif (($typename = strval($parameter->getType()))) {
            if (isset($dependency[$typename])) {
                $result[$n] = $dependency[$typename];
            }
            else {
                foreach ($dependency as $key => $value) {
                    if (is_subclass_of(ltrim($key, '\\'), $typename, true)) {
                        if (array_key_exists($n, $result)) {
                            unset($result[$n]);
                            break;
                        }
                        $result[$n] = $value;
                    }
                }
            }
        }
        elseif ($parameter->isDefaultValueAvailable()) {
            $result[$n] = $parameter->getDefaultValue();
        }
    }

    // $this bind するのでオブジェクト化しておく
    if (!is_object($dependency)) {
        $dependency = new \ArrayObject($dependency);
    }

    // recurse for closure
    return array_map(function ($arg) use ($dependency) {
        if ($arg instanceof \Closure) {
            if ((new \ReflectionFunction($arg))->getShortName() === '{closure}') {
                $arg = $arg->bindTo($dependency);
            }
            return $arg(...parameter_wiring($arg, $dependency));
        }
        return $arg;
    }, $result);
}
