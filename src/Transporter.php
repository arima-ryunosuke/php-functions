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
        /** @noinspection PhpUnusedLocalVariableInspection */
        $excluded_functions = array_flip($excluded_functions);
        require_once __DIR__ . '/../include/global.php';
    }

    /**
     * 名前空間に関数をインポートする
     *
     * @param array $excluded_functions 定義したくない関数名を配列で指定する
     */
    public static function importAsNamespace(array $excluded_functions = [])
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $excluded_functions = array_flip($excluded_functions);
        require_once __DIR__ . '/../include/namespace.php';
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

        // このコンテキストで var_export2 は使えないのでインライン展開する
        $ve = function ($value, $nest = 0) use (&$ve) {
            if (is_array($value)) {
                $spacer1 = str_repeat(' ', ($nest + 1) * 4);
                $spacer2 = str_repeat(' ', $nest * 4);

                $hashed = $value !== array_values($value);

                if (!$hashed) {
                    $primitive_only = (array_filter($value, function ($v) { return is_scalar($v) || is_null($v) || is_resource($v); }));
                    if ($primitive_only === $value) {
                        return '[' . implode(', ', array_map($ve, $value)) . ']';
                    }
                }

                if ($hashed) {
                    $keys = array_map($ve, array_combine($keys = array_keys($value), $keys));
                    $maxlen = max(array_map('strlen', $keys));
                }
                $kvl = '';
                foreach ($value as $k => $v) {
                    /** @noinspection PhpUndefinedVariableInspection */
                    $keystr = $hashed ? $keys[$k] . str_repeat(' ', $maxlen - strlen($keys[$k])) . ' => ' : '';
                    $kvl .= $spacer1 . $keystr . $ve($v, $nest + 1) . ",\n";
                }
                return "[\n{$kvl}{$spacer2}]";
            }
            return is_string($value) ? '"' . addcslashes($value, "\"\0\\") . '"' : (is_null($value) ? 'null' : var_export($value, true));
        };
        $consts = $contents = [];

        foreach (glob(__DIR__ . '/Package/*.php') as $fn) {
            $refclass = new \ReflectionClass(__NAMESPACE__ . "\\Package\\" . basename($fn, '.php'));

            foreach ($refclass->getConstants() as $cname => $cvalue) {
                $cvalue = $ve($cvalue);
                $consts[] = "const $cname = $cvalue;";
            }

            $lines = file($refclass->getFileName());
            foreach ($refclass->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_STATIC) as $method) {
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

        return "<?php\n\n# $PREFIX\n\n" . ($namespace ? "namespace $namespace;\n\n" : "") . "# constants\n" . implode("\n", $consts) . "\n\n# functions\n" . implode("\n", $contents);
    }
}
