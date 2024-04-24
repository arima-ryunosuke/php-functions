<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../reflection/reflect_callable.php';
require_once __DIR__ . '/../reflection/reflect_types.php';
require_once __DIR__ . '/../var/var_export2.php';
// @codeCoverageIgnoreEnd

/**
 * 関数/メソッドの引数定義を取得する
 *
 * ほぼ内部向けで外から呼ぶことはあまり想定していない。
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param \ReflectionFunctionAbstract|callable $eitherReffuncOrCallable 関数/メソッドリフレクション or callable
 * @return array [引数名 => 引数宣言] の配列
 */
function function_parameter($eitherReffuncOrCallable)
{
    $reffunc = $eitherReffuncOrCallable instanceof \ReflectionFunctionAbstract
        ? $eitherReffuncOrCallable
        : reflect_callable($eitherReffuncOrCallable);

    $result = [];
    foreach ($reffunc->getParameters() as $parameter) {
        $declare = '';

        if ($parameter->hasType()) {
            $declare .= reflect_types($parameter->getType())->getName() . ' ';
        }

        if ($parameter->isPassedByReference()) {
            $declare .= '&';
        }

        if ($parameter->isVariadic()) {
            $declare .= '...';
        }

        $declare .= '$' . $parameter->getName();

        if ($parameter->isOptional()) {
            $defval = null;

            // 組み込み関数のデフォルト値を取得することは出来ない（isDefaultValueAvailable も false を返す）
            if ($parameter->isDefaultValueAvailable()) {
                // 修飾なしでデフォルト定数が使われているとその名前空間で解決してしまうので場合分けが必要
                if ($parameter->isDefaultValueConstant() && strpos($parameter->getDefaultValueConstantName(), '\\') === false) {
                    $defval = $parameter->getDefaultValueConstantName();
                }
                else {
                    $default = $parameter->getDefaultValue();
                    $defval = var_export2($default, true);
                    if (is_string($default)) {
                        $defval = strtr($defval, [
                            "\r" => "\\r",
                            "\n" => "\\n",
                            "\t" => "\\t",
                            "\f" => "\\f",
                            "\v" => "\\v",
                        ]);
                    }
                }
            }

            if (isset($defval)) {
                $declare .= ' = ' . $defval;
            }
        }

        $name = ($parameter->isPassedByReference() ? '&' : '') . '$' . $parameter->getName();
        $result[$name] = $declare;
    }

    return $result;
}
