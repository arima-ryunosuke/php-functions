<?php

namespace ryunosuke\Functions;

use Seld\PharUtils\Timestamps;

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
        $PREFIX = "Don't touch this code. This is auto generated.";

        if ($source) {
            foreach (glob(__DIR__ . '/Package/*.php') as $fn) {
                $content = file_get_contents($fn);
                $content = str_replace('namespace ryunosuke\\Functions\\Package', "# $PREFIX\n
namespace $namespace", $content);
                $path = $source . '/' . basename($fn);
                file_put_contents($path, $content);
                touch($path, filemtime($fn));
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
                $doccomment = $method->getDocComment();
                $polyfill = $ve(!!preg_match('#@polyfill#', $doccomment));
                $mname = $method->getName();
                $const = $methodmode ? '[' . $ve($method->class) . ', ' . $ve($mname) . ']' : $ve(ltrim("$namespace\\$mname", '\\'));
                $full = $ve($namespace ? "$namespace\\$mname" : $mname);

                $sl = $method->getStartLine();
                $el = $method->getEndLine();
                $block = implode('', array_slice($lines, $sl - 1, $el - $sl + 1));
                $block = preg_replace('#public static #', '', $block, 1);

                $code = <<<CODE
    $doccomment
$block
CODE;

                $constants[] = "const $mname = $const;";
                $functions[] = "if (!isset(\$excluded_functions[{$ve($mname)}]) && (!function_exists($full) || (!$polyfill && (new \\ReflectionFunction($full))->isInternal()))) {\n$code}";
            }
        }

        if ($namespace) {
            $namespace = "namespace " . $namespace . ";\n\n";
        }

        return [
            'constant' => "<?php\n\n# $PREFIX\n\n" . $namespace . implode("\n", $constants) . "\n",
            'function' => "<?php\n\n# $PREFIX\n\n" . $namespace . implode("\n", $functions) . "\n",
        ];
    }

    public static function exportPhar($namespace, $pharpath)
    {
        $ve = function ($v) { return var_export($v, true); };
        if (is_file($pharpath)) {
            unlink($pharpath);
        }
        $phar = new \Phar($pharpath);

        $constants = [];
        $files = glob(__DIR__ . '/Package/*.php');
        foreach ($files as $fn) {
            require_once $fn;
            $refclass = new \ReflectionClass('ryunosuke\\Functions\\Package\\' . basename($fn, '.php'));
            $methods = $refclass->getMethods(\ReflectionMethod::IS_PUBLIC || \ReflectionMethod::IS_STATIC);
            foreach ($methods as $method) {
                $mname = $method->getName();
                $const = '[' . $ve($namespace . "\\" . $refclass->getShortName()) . ', ' . $ve($mname) . ']';
                $constants[] = "const $mname = $const;";
            }

            $content = file_get_contents($fn);
            $content = str_replace('namespace ryunosuke\\Functions\\Package;', "namespace $namespace;", $content);
            $phar->addFromString(str_replace('\\', '/', $namespace) . '/' . basename($fn), $content);
        }
        $phar->addFromString('constants.php', "<?php\nnamespace $namespace;\n" . implode("\n", $constants) . "\n");

        $phar->setStub(<<<'PHP'
<?php
require "phar://" . __FILE__ . DIRECTORY_SEPARATOR . "constants.php";
spl_autoload_register(function ($class) {
    $path = 'phar://' . __FILE__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (is_file($path)) {
        require $path;
    }
});
__HALT_COMPILER();
PHP
        );

        // phar 内の ctime や mtime が要因で生成のたびに差分が出てしまうので、元ファイルの mtime 統一する
        $timestamp = new Timestamps($pharpath);
        $timestamp->updateTimestamps(max(array_map('filemtime', $files)));
        $timestamp->save($pharpath, \Phar::SHA512);

        return $phar;
    }
}
