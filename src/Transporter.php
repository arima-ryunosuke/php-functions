<?php

namespace ryunosuke\Functions;

class Transporter
{
    /**
     * グローバルに関数をインポートする
     *
     * @param array $excluded_functions 定義したくない関数名を配列で指定する
     */
    public static function importAsGlobal(array $excluded_functions = [])
    {
        $dir = __DIR__ . '/../include/';
        $excluded_functions = array_flip($excluded_functions);
        call_user_func(function ($dir, $excluded_functions) {
            require_once $dir . '/global/constant.php';
            require_once $dir . '/global/function.php';
            return $excluded_functions; // 特に意味はない
        }, $dir, $excluded_functions);
    }

    /**
     * 名前空間に関数をインポートする
     *
     * @param array $excluded_functions 定義したくない関数名を配列で指定する
     */
    public static function importAsNamespace(array $excluded_functions = [])
    {
        $dir = __DIR__ . '/../include/';
        $excluded_functions = array_flip($excluded_functions);
        call_user_func(function ($dir, $excluded_functions) {
            require_once $dir . '/namespace/constant.php';
            require_once $dir . '/namespace/function.php';
            return $excluded_functions; // 特に意味はない
        }, $dir, $excluded_functions);
    }

    /**
     * クラス定数のみインポートする
     */
    public static function importAsClass()
    {
        $dir = __DIR__ . '/../include/';
        require_once $dir . '/constant.php';
    }

    /**
     * グローバル・名前空間にエクスポートする
     *
     * test, composer 用で、明示的には呼ばれない
     *
     * @param string $dir エクスポートするディレクトリ
     */
    public static function exportAll($dir = null)
    {
        $dir = is_object($dir) || $dir === null ? __DIR__ . '/../include' : $dir;

        $files = self::exportFunction(null, false);
        file_put_contents("$dir/global/constant.php", $files['constant']);
        file_put_contents("$dir/global/function.php", $files['function']);

        $files = self::exportFunction(__NAMESPACE__, false);
        file_put_contents("$dir/namespace/constant.php", $files['constant']);
        file_put_contents("$dir/namespace/function.php", $files['function']);

        $files = self::exportFunction(__NAMESPACE__ . '\\Package', true);
        file_put_contents("$dir/constant.php", $files['constant']);
    }

    public static function exportFunction($namespace, $methodmode, $source = null)
    {
        if ($source) {
            foreach (glob(__DIR__ . '/Package/*.php') as $fn) {
                $content = file_get_contents($fn);
                $content = str_replace('namespace ryunosuke\\Functions\\Package', "/** Don't touch this code. This is auto generated. */\n
namespace $namespace", $content);
                file_put_contents($source . '/' . basename($fn), $content);
            }
        }

        $ve = function ($v) { return var_export($v, true); };
        $source = $source ?: __DIR__ . '/Package';
        $constants = [];
        $functions = [];

        foreach (glob("$source/*.php") as $fn) {
            require_once $fn;
            preg_match('#namespace (.*?);#', file_get_contents($fn), $m);
            $refclass = new \ReflectionClass($m[1] . '\\' . basename($fn, '.php'));
            $methods = $refclass->getMethods(\ReflectionMethod::IS_PUBLIC || \ReflectionMethod::IS_STATIC);
            $lines = file($refclass->getFileName());
            foreach ($methods as $method) {
                $params = [];
                foreach ($method->getParameters() as $param) {
                    $default = '';
                    if ($param->isOptional() && !$param->isVariadic()) {
                        // 組み込み関数のデフォルト値を取得することは出来ない（isDefaultValueAvailable も false を返す）
                        if ($param->isDefaultValueAvailable()) {
                            $default = ' = ' . ($param->getDefaultValue() === [] ? '[]' : $ve($param->getDefaultValue()));
                        }
                    }
                    $varname = ($param->isVariadic() ? '...' : '') . ($param->isPassedByReference() ? '&' : '') . '$' . $param->getName();
                    $params[] = $varname . $default;
                }

                $doccomment = $method->getDocComment();
                $mname = $method->getName();
                $funcname = ($method->returnsReference() ? '&' : '') . $mname;
                $const = $methodmode ? '[' . $ve($method->class) . ', ' . $ve($mname) . ']' : $ve(ltrim("$namespace\\$mname", '\\'));
                $full = $ve($namespace ? "$namespace\\$mname" : $mname);
                $params = implode(', ', $params);

                $sl = $method->getStartLine();
                $el = $method->getEndLine();
                $block = implode('', array_slice($lines, $sl, $el - $sl));

                $code = <<<CODE
    $doccomment
    function $funcname($params)
$block
CODE;

                $constants[] = "const $mname = $const;";
                $functions[] = "if (!isset(\$excluded_functions[{$ve($mname)}]) && (!function_exists($full) || (new \ReflectionFunction($full))->isInternal())) {\n$code}";
            }
        }

        $prefix = "<?php\n\n/** Don't touch this code. This is auto generated. */\n\n";

        if ($namespace) {
            $namespace = "namespace " . $namespace . ";\n\n";
        }

        return [
            'constant' => $prefix . $namespace . implode("\n", $constants) . "\n",
            'function' => $prefix . $namespace . implode("\n", $functions) . "\n",
        ];
    }
}
