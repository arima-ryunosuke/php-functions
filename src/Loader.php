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
     */
    public static function importAsGlobal($dir = null)
    {
        $dir = $dir ?: __DIR__ . '/global/';
        require_once $dir . '/symbol.php';
        require_once $dir . '/function.php';
    }

    /**
     * 名前空間に関数をインポートする
     *
     * @param string $dir 読み込みディレクトリを指定できるが、使う側は気にしなくて良い
     */
    public static function importAsNamespace($dir = null)
    {
        $dir = $dir ?: __DIR__ . '/namespace/';
        require_once $dir . '/symbol.php';
        require_once $dir . '/function.php';
    }

    /**
     * グローバル・名前空間にエクスポートする
     *
     * composer command 用で、明示的には呼ばれない
     */
    public static function export()
    {
        $contents = "\n";
        foreach (self::getFunctions() as $function) {
            $contents .= "const $function = '{$function}';\n";
        }
        $fn = realpath(__DIR__ . "/../tests/symbol.php");
        file_put_contents($fn, self::render("echo '<?php' ?><?php echo \$contents ?>", [
            'namespace' => '',
            'contents'  => $contents,
        ]));
        echo "generated '$fn'\n";

        foreach (self::exportToGlobal() as $fn) {
            echo "generated '$fn'\n";
        }
        foreach (self::exportToNamespace() as $fn) {
            echo "generated '$fn'\n";
        }
    }

    /**
     * グローバルにエクスポートする
     *
     * @param string $dir 読み込みディレクトリを指定できるが、使う側は気にしなくて良い
     * @return array 書き出したファイル名配列
     */
    public static function exportToGlobal($dir = null)
    {
        return self::exportTo($dir ?: __DIR__ . '/global', '');
    }

    /**
     * 名前空間にエクスポートする
     *
     * @param string $dir 読み込みディレクトリを指定できるが、使う側は気にしなくて良い
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

<?php echo $namespace ? "namespace $namespace;\n" : "" ?>

<?php echo $contents ?>
';

        // 定数を出力
        $contents = '';
        foreach (self::getFunctions() as $function) {
            $contents .= "const $function = " . var_export("{$namespace}{$function}", true) . ";\n";
        }
        file_put_contents("$dir/symbol.php", self::render($template, [
            'namespace' => trim($namespace, '\\'),
            'contents'  => $contents,
        ]));

        // 関数コードを出力
        $contents = '';
        foreach (glob(__DIR__ . '/package/*.php') as $filename) {
            $lines = file($filename);
            unset($lines[0], $lines[1], $lines[2], $lines[3], $lines[4], $lines[5], $lines[6]);
            $contents .= implode("", $lines);
        }
        file_put_contents("$dir/function.php", self::render($template, [
            'namespace' => trim($namespace, '\\'),
            'contents'  => $contents,
        ]));

        return ["$dir/symbol.php", "$dir/function.php"];
    }

    private static function getFunctions()
    {
        // グローバルに定義されてしまうので別プロセスに閉じ込めなければならない
        $packagedir = __DIR__ . DIRECTORY_SEPARATOR . "package";
        $code = '<?php
        foreach (glob(' . var_export($packagedir . '/*.php', true) . ') as $filename) {
            require_once $filename;
        }
        foreach (get_defined_functions()["user"] as $function) {
            $ref = new \ReflectionFunction($function);
            if (dirname($ref->getFileName()) === ' . var_export($packagedir, true) . ') {
                echo "$function\n";
            }
        }';
        $tmp = tempnam(sys_get_temp_dir(), 'rf-');
        file_put_contents($tmp, $code);
        $output = shell_exec(PHP_BINARY . " $tmp");
        return array_filter(explode("\n", $output), 'strlen');
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
