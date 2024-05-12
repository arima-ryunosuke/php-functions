<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/const_exists.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
require_once __DIR__ . '/../reflection/reflect_type_resolve.php';
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
            $declare .= reflect_type_resolve($parameter->getType()) . ' ';
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

            if ($parameter->isDefaultValueAvailable()) {
                // 修飾なしでデフォルト定数が使われているとその名前空間で解決してしまうので場合分けが必要
                if ($parameter->isDefaultValueConstant() && strpos($parameter->getDefaultValueConstantName(), '\\') === false) {
                    // 存在チェック＋$dummy でグローバル定数を回避しているが、いっそのこと一律 \\ を付与してしまっても良いような気がする
                    if (const_exists(...(explode('::', $parameter->getDefaultValueConstantName()) + [1 => '$dummy']))) {
                        $defval = '\\' . $parameter->getDefaultValueConstantName();
                    }
                    else {
                        $defval = $parameter->getDefaultValueConstantName();
                    }
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
            // isOptional だが isDefaultValueAvailable でないし isVariadic でもない（稀にある（stream_filter_append で確認））
            elseif (!$parameter->isVariadic()) {
                // Type に応じたデフォルト値が得られればベストだがそこまでする必要もない
                // 少なくとも 8.0 時点では = null してしまえば型エラーも起きない（8.4 で非推奨になってるけど）
                $defval = "null";
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
