<?php

namespace ryunosuke\Functions;

/**
 * @codeCoverageIgnore グローバル汚染があるのでテストはほぼ無理（こいつがだめならあらゆるテストが死ぬのでそれで担保）
 */
class Loader
{
    /**
     * グローバルに関数をインポートする
     *
     * @param string $dir 読み込みディレクトリを指定できるが、使う側は気にしなくて良い
     * @param array $excluded_functions 定義したくない関数名を配列で指定する
     */
    public static function importAsGlobal($dir = null, array $excluded_functions = [])
    {
        $dir = $dir ?: __DIR__ . '/global/';
        $excluded_functions = array_flip($excluded_functions);
        call_user_func(function ($dir, $excluded_functions) {
            require_once $dir . '/symbol.php';
            require_once $dir . '/function.php';
            return $excluded_functions; // 特に意味はない
        }, $dir, $excluded_functions);
    }

    /**
     * 名前空間に関数をインポートする
     *
     * @param string $dir 読み込みディレクトリを指定できるが、使う側は気にしなくて良い
     * @param array $excluded_functions 定義したくない関数名を配列で指定する
     */
    public static function importAsNamespace($dir = null, array $excluded_functions = [])
    {
        $dir = $dir ?: __DIR__ . '/namespace/';
        $excluded_functions = array_flip($excluded_functions);
        call_user_func(function ($dir, $excluded_functions) {
            require_once $dir . '/symbol.php';
            require_once $dir . '/function.php';
            return $excluded_functions; // 特に意味はない
        }, $dir, $excluded_functions);
    }

    /**
     * グローバル・名前空間にエクスポートする
     *
     * composer command 用で、明示的には呼ばれない
     *
     * @param string $dir 書き出すディレクトリを指定できるが、使う側は気にしなくて良い
     */
    public static function export($dir = null)
    {
        $dir = is_object($dir) ? null : $dir;

        $contents = "\n";
        foreach (self::getFunctions() as $function => $declare) {
            $contents .= "const $function = '{$function}';\n";
        }
        $fn = $dir ? "$dir/symbol.php" : __DIR__ . "/../tests/symbol.php";
        file_put_contents($fn, self::render("echo '<?php' ?><?php echo \$contents ?>", [
            'namespace' => '',
            'contents'  => $contents,
        ]));
        echo "generated '$fn'\n";

        foreach (self::exportToGlobal($dir ? "$dir/global" : null) as $fn) {
            echo "generated '$fn'\n";
        }
        foreach (self::exportToNamespace($dir ? "$dir/namespace" : null) as $fn) {
            echo "generated '$fn'\n";
        }
    }

    /**
     * グローバルにエクスポートする
     *
     * @param string $dir 書き出すディレクトリを指定できるが、使う側は気にしなくて良い
     * @return array 書き出したファイル名配列
     */
    public static function exportToGlobal($dir = null)
    {
        return self::exportTo($dir ?: __DIR__ . '/global', '');
    }

    /**
     * 名前空間にエクスポートする
     *
     * @param string $dir 書き出すディレクトリを指定できるが、使う側は気にしなくて良い
     * @param string $namespace 書き出す名前空間名
     * @return array 書き出したファイル名配列
     */
    public static function exportToNamespace($dir = null, $namespace = null)
    {
        return self::exportTo($dir ?: __DIR__ . '/namespace', ($namespace ?: __NAMESPACE__) . '\\');
    }

    private static function exportTo($dir, $namespace)
    {
        $template = 'echo "<?php\n" ?>

/**
 * Don\'t touch this code. This is auto generated.
 */
<?php echo $namespace ? "\nnamespace $namespace;\n" : "" ?>

<?php echo $contents ?>
';

        $functions = self::getFunctions();

        // 定数を出力
        file_put_contents("$dir/symbol.php", self::render($template, [
            'namespace' => trim($namespace, '\\'),
            'contents'  => implode("", array_map(function ($function) use ($namespace) {
                $value = var_export("{$namespace}{$function}", true);
                return "const $function = $value;\n";
            }, array_keys($functions))),
        ]));

        // 関数コードを出力
        file_put_contents("$dir/function.php", self::render($template, [
            'namespace' => trim($namespace, '\\'),
            'contents'  => implode("\n", array_map(function ($function, $declare) use ($namespace) {
                $local = var_export($function, true);
                $value = var_export("{$namespace}{$function}", true);
                return "if (!isset(\$excluded_functions[$local]) && (!function_exists($value) || (new \ReflectionFunction($value))->isInternal())) {\n$declare}\n";
            }, array_keys($functions), $functions)),
        ]));

        return ["$dir/symbol.php", "$dir/function.php"];
    }

    private static function getFunctions()
    {
        static $functions = [];
        if (!$functions) {
            $files = [];
            $namespace = 'rf\\temporary' . sha1(uniqid('rf-', true));
            foreach (glob(__DIR__ . '/package/*.php') as $filename) {
                $contents = preg_replace('#^<\?php#', "<?php\nnamespace $namespace;", file_get_contents($filename));
                $tn = tempnam(sys_get_temp_dir(), 'rf-');
                file_put_contents($tn, $contents);
                require_once $tn;
                $files[] = $tn;
            }
            foreach (get_defined_functions()['user'] as $function) {
                $ref = new \ReflectionFunction($function);
                if ($ref->getNamespaceName() === $namespace) {
                    $sline = $ref->getStartLine();
                    $eline = $ref->getEndLine();
                    $code = array_slice(file($ref->getFileName()), $sline - 1, $eline - $sline + 1);
                    $functions[$ref->getShortName()] = $ref->getDocComment() . "\n" . implode("", $code);
                }
            }
            array_map('unlink', $files);
        }
        return $functions;
    }

    private static function render($template, $vars)
    {
        return call_user_func(function () {
            ob_start();
            extract(func_get_arg(1));
            eval(func_get_arg(0));
            return ob_get_clean();
        }, $template, $vars);
    }
}
