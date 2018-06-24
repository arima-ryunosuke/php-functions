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
        $excluded_functions = array_flip($excluded_functions);
        call_user_func(function ($excluded_functions) {
            require_once __DIR__ . '/../include/global.php';
        }, $excluded_functions);
    }

    /**
     * 名前空間に関数をインポートする
     *
     * @param array $excluded_functions 定義したくない関数名を配列で指定する
     */
    public static function importAsNamespace(array $excluded_functions = [])
    {
        $excluded_functions = array_flip($excluded_functions);
        call_user_func(function ($excluded_functions) {
            require_once __DIR__ . '/../include/namespace.php';
        }, $excluded_functions);
    }

    /**
     * クラス定数のみインポートする
     */
    public static function importAsClass()
    {
        require_once __DIR__ . '/../include/package.php';
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

        file_put_contents("$dir/global.php", self::exportNamespace(null));
        file_put_contents("$dir/namespace.php", self::exportNamespace(__NAMESPACE__));
        file_put_contents("$dir/package.php", self::exportNamespace(__NAMESPACE__ . '\\Package', true));
    }

    public static function exportNamespace($namespace, $classmode = false)
    {
        $PREFIX = "Don't touch this code. This is auto generated.";

        $ve = function ($v) { return var_export($v, true); };
        $contents = [];

        foreach (glob(__DIR__ . '/Package/*.php') as $fn) {
            $refclass = new \ReflectionClass(__NAMESPACE__ . "\\Package\\" . basename($fn, '.php'));
            $methods = $refclass->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_STATIC);
            $lines = file($refclass->getFileName());
            foreach ($methods as $method) {
                $doccomment = $method->getDocComment();
                $polyfill = $ve(!!preg_match('#@polyfill#', $doccomment));
                $mname = $method->getName();

                $sl = $method->getStartLine();
                $el = $method->getEndLine();
                $block = implode('', array_slice($lines, $sl - 1, $el - $sl + 1));
                $block = preg_replace('#public static #', '', $block, 1);
                $code = "    $doccomment\n$block";

                if ($classmode) {
                    $id = '[' . $ve($refclass->name) . ', ' . $ve($mname) . ']';
                    $contents[] = "const $mname = $id;";
                }
                else {
                    $id = $ve(ltrim("$namespace\\$mname", '\\'));
                    $contents[] = "const $mname = $id;";
                    $contents[] = "if (!isset(\$excluded_functions[{$ve($mname)}]) && (!function_exists($id) || (!$polyfill && (new \\ReflectionFunction($id))->isInternal()))) {\n$code}\n";
                }
            }
        }

        return "<?php\n\n# $PREFIX\n\n" . ($namespace ? "namespace $namespace;\n\n" : "") . implode("\n", $contents);
    }
}
