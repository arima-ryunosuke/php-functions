<?php

namespace ryunosuke\Functions;

use function ryunosuke\Functions\Package\indent_php;
use function ryunosuke\Functions\Package\var_export2;

class Transporter
{
    /**
     * リリース用のビルドコマンド
     *
     * @internal
     * @codeCoverageIgnore
     */
    public static function build()
    {
        $namespace = 'ryunosuke\\Functions\\Package';

        $depends = self::detectDependent(null);

        $functions = self::getAllFunction();

        foreach ($functions as $funcname => $function) {
            $funcs = ($depends[$funcname]['function'] ?? []);
            unset($funcs[$funcname]);
            uksort($funcs, fn($a, $b) => "{$functions[$a]['directory']}\\$a" <=> "{$functions[$b]['directory']}\\$b");

            $reqs = [];

            foreach ($funcs as $func => $dummy) {
                $package = $functions[$func]['directory'];
                $reqs[] = "require_once __DIR__ . '/../$package/$func.php';\n";
            }
            if (($depends[$funcname]['constant'] ?? [])) {
                $reqs[] = "require_once __DIR__ . '/../constants.php';\n";
            }

            $declare = '';
            $declare .= "// @codeCoverageIgnoreStart\n";
            $declare .= implode("", $reqs);
            $declare .= "// @codeCoverageIgnoreEnd\n";

            $contents = $newcontents = file_get_contents($function['filename']);

            $s = strpos($newcontents, ";") + 2;
            $e = strpos($newcontents, "/**\n");
            $newcontents = substr_replace($newcontents, "\n" . $declare, $s, $e - $s - 1);

            $newcontents = preg_replace("#@package.*$#uim", "@package $namespace\\{$function['directory']}", $newcontents, 1, $count);
            if ($count !== 1) {
                trigger_error("$funcname @package is invalid(none or multiple specified)");
            }

            if ($contents !== $newcontents) {
                file_put_contents($function['filename'], $newcontents);
            }
        }

        file_put_contents(__DIR__ . "/../include/global.php", self::exportGlobal());
        file_put_contents(__DIR__ . "/../include/namespace.php", self::exportNamespace(__NAMESPACE__));
    }

    /**
     * ダイレクトに関数をインポートする
     *
     * @codeCoverageIgnore
     */
    public static function importAsDirect()
    {
        foreach (glob(__DIR__ . '/../src/Package/*/*.php') as $file) {
            require_once $file;
        }
    }

    /**
     * グローバルに関数をインポートする
     *
     * @codeCoverageIgnore
     */
    public static function importAsGlobal()
    {
        require_once __DIR__ . '/../include/global.php';
    }

    /**
     * 名前空間に関数をインポートする
     *
     * @codeCoverageIgnore
     */
    public static function importAsNamespace()
    {
        require_once __DIR__ . '/../include/namespace.php';
    }

    /**
     * グローバルにエクスポートする
     *
     * @param array|string|null $funcname 吐き出す関数名。ファイル名っぽい文字列は中身で検出する
     * @return string php コード
     */
    public static function exportGlobal($funcname = null)
    {
        return self::exportNamespace('', $funcname);
    }

    /**
     * 名前空間にエクスポートする
     *
     * @param string $namespace 吐き出す名前空間
     * @param array|string|null $funcname 吐き出す関数名。ファイル名っぽい文字列は中身で検出する
     * @return string php コード
     */
    public static function exportNamespace(string $namespace, $funcname = null)
    {
        $_ = function ($v) { return $v; };

        // 関数が指定されているときは依存関係を解決する
        if ($funcname !== null) {
            $funcname = self::detectDependent($funcname);
        }

        require_once __DIR__ . '/Package/misc/indent_php.php';
        require_once __DIR__ . '/Package/var/var_export2.php';

        $namespace = trim($namespace, '\\');
        $constants = self::getAllConstant();
        $functions = self::getAllFunction();

        $consts = [];
        foreach ($constants as $name => $constant) {

            $id = var_export(ltrim("$namespace\\$name", '\\'), true);
            $consts[] = <<<CONSTANT
            if (!defined($id)) {
                define($id, {$_(trim(indent_php("\n" . var_export2($constant['value'], true), ['baseline' => 0, 'indent' => 4])))});
            }
            
            CONSTANT;
        }

        $funcs = [];
        foreach ($functions as $name => $function) {
            if ($funcname !== null && !isset($funcname['function'][$name])) {
                continue;
            }

            $id = var_export(ltrim("$namespace\\$name", '\\'), true);
            $funcs[] = <<<FUNCTION
            assert(!function_exists($id) || (new \ReflectionFunction($id))->isUserDefined());
            if (!function_exists($id)) {
                {$_(trim(indent_php("\n" . $function['codeblock'], ['baseline' => 0, 'indent' => 4])))}
            }
            
            FUNCTION;
        }

        // 完全な php コードを返す
        return <<<CONTENTS
        <?php
        # Don't touch this code. This is auto generated.
        {$_($namespace ? "namespace $namespace;\n" : "")}
        {$_(implode("\n", $consts))}
        {$_(implode("\n", $funcs))}
        CONTENTS;
    }

    /**
     * クラスにエクスポートする
     *
     * @param string $classname 吐き出すクラス名（FQSEN）
     * @param array|string $funcname 吐き出す関数名
     * @return string php コード
     */
    public static function exportClass($classname, $funcname)
    {
        $_ = function ($v) { return $v; };

        $funcname = self::detectDependent($funcname);

        require_once __DIR__ . '/Package/misc/indent_php.php';
        require_once __DIR__ . '/Package/var/var_export2.php';

        $classname = trim($classname, "\\");
        $constants = self::getAllConstant();
        $functions = self::getAllFunction();

        $consts = [];
        foreach ($constants as $name => $constant) {
            if (!isset($funcname['constant'][$name])) {
                continue;
            }

            $consts[] = <<<CONSTANT
                public const $name = {$_(trim(indent_php("\n" . var_export2($constant['value'], true), ['baseline' => 0, 'indent' => 4])))};
            CONSTANT;
        }

        $funcs = [];
        foreach ($functions as $name => $function) {
            if (!isset($funcname['function'][$name])) {
                continue;
            }

            $tokens = self::getDependentTokens($name);
            foreach ($tokens as $i => $token) {
                if (isset($token['dependent'])) {
                    $tokens[$i][1] = "\\$classname::" . $token[1];
                }
            }
            $body = substr_replace(implode('', array_column($tokens, 1)), 'public static ', $function['funcstart'], 0);
            $funcs[] = <<<FUNCTION
                {$_(trim(indent_php("\n" . $body, ['baseline' => 0, 'indent' => 4])))}
            FUNCTION;
        }

        // 完全な php コードを返す
        $parts = explode("\\", $classname);
        $shortname = array_pop($parts);
        $namespace = implode("\\", $parts);
        return <<<CONTENTS
        <?php
        # Don't touch this code. This is auto generated.
        namespace $namespace;
        
        // @formatter:off
        
        /**
         * @codeCoverageIgnore
         */
        class $shortname
        {
        {$_(implode("\n\n", $consts))}
        
        {$_(implode("\n\n", $funcs))}
        }
        
        CONTENTS;
    }

    /**
     * エクスポートすべき定数を抽出する
     *
     * @param bool $nocache キャッシュ破棄フラグ
     * @return array
     */
    private static function getAllConstant($nocache = false)
    {
        static $cache;
        if ($nocache) {
            $cache = null;
        }
        if (!isset($cache)) {
            $cache = [];
            $fn = __DIR__ . '/Package/constants.php';
            $tmpfile = sys_get_temp_dir() . '/tmpfunc/constants.php' . basename($fn);
            if ($nocache || !file_exists($tmpfile) || filemtime($fn) >= filemtime($tmpfile)) {
                @mkdir(dirname($tmpfile), 0777, true);
                $lines = file($fn);
                array_splice($lines, 1, 1, ["namespace tmp;\n"]);
                file_put_contents($tmpfile, implode("", $lines));
            }
            $constants = get_defined_constants(true)['user'] ?? [];
            require $tmpfile;
            foreach (array_diff_key(get_defined_constants(true)['user'] ?? [], $constants) as $name => $value) {
                $cache[substr($name, 4)] = [
                    'filename' => $fn,
                    'value'    => $value,
                ];
            }
        }
        return $cache;
    }

    /**
     * エクスポートすべき関数を抽出する
     *
     * @param bool $nocache キャッシュ破棄フラグ
     * @return array
     */
    private static function getAllFunction($nocache = false)
    {
        static $cache;
        if ($nocache) {
            $cache = null;
        }
        if (!isset($cache)) {
            $cache = [];
            foreach (glob(__DIR__ . '/Package/*/*.php') as $fn) {
                $name = basename($fn, '.php');
                $contents = file_get_contents($fn);
                $docstart = strpos($contents, "/**\n");
                $codeblock = substr($contents, $docstart);
                $funcstart = strpos($codeblock, " */\nfunction $name(", $docstart) + 4;
                $cache[$name] = [
                    'filename'  => $fn,
                    'directory' => basename(dirname($fn)),
                    'funcstart' => $funcstart,
                    'codeblock' => $codeblock,
                ];
            }
        }
        return $cache;
    }

    /**
     * 指定関数のトークン（依存トークンを特殊化したもの）配列を返す
     *
     * @param string $funcname 関数名
     * @return array
     */
    private static function getDependentTokens($funcname)
    {
        $constants = self::getAllConstant();
        $functions = self::getAllFunction();

        $tokens = token_get_all("<?php {$functions[$funcname]['codeblock']}");
        array_shift($tokens);
        for ($i = 0; $i < count($tokens); $i++) {
            $token = is_array($tokens[$i]) ? $tokens[$i] : [null, $tokens[$i], null];
            if ($token[0] === T_STRING) {
                if (isset($constants[$token[1]])) {
                    $token['dependent'] = 'constant';
                }
                if (isset($functions[$token[1]]) && ($tokens[$i - 2][0] ?? '') !== T_FUNCTION && ($tokens[$i + 1] ?? '') === '(') {
                    $token['dependent'] = 'function';
                }
            }
            $tokens[$i] = $token;
        }
        return $tokens;
    }

    /**
     * 配下の Package から定数・関数の依存関係を導出する
     *
     * @param string|array|null $funcname 依存関数
     * @return array
     */
    private static function detectDependent($funcname)
    {
        static $depends = null;
        if (!isset($depends)) {
            foreach (self::getAllFunction() as $name => $function) {
                $depends[$name] = array_fill_keys(['constant', 'function'], []);
                $tokens = self::getDependentTokens($name);
                foreach ($tokens as $token) {
                    if (isset($token['dependent'])) {
                        $depends[$name][$token['dependent']][$token[1]] = true;
                    }
                }
            }
        }

        if ($funcname === null) {
            return $depends;
        }

        $main = function ($funcname, &$result) use (&$main, $depends) {
            foreach ($depends[$funcname]['constant'] ?? [] as $const => $true) {
                $result['constant'][$const] = true;
            }

            if (isset($depends[$funcname]['function'])) {
                $result['function'][$funcname] = true;
            }
            foreach ($depends[$funcname]['function'] ?? [] as $func => $true) {
                if (!isset($result['function'][$func])) {
                    $main($func, $result);
                }
            }
        };

        $result = array_fill_keys(['constant', 'function'], []);
        foreach ((array) $funcname as $name) {
            // 直指定ならそのまま使う
            if (isset($depends[$name])) {
                $main($name, $result);
            }
            // ディレクトリならすべて舐める
            elseif (is_dir($name)) {
                $rdi = new \RecursiveDirectoryIterator($name, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_PATHNAME);
                $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::LEAVES_ONLY);
                $ri = new \RegexIterator($rii, '#\.php#i', \RecursiveRegexIterator::MATCH);
                $name = iterator_to_array($ri);
            }
            // ファイルエントリなら php とみなしてトークンで検出する
            foreach ((array) $name as $file) {
                $tokens = token_get_all(file_exists($file) ? file_get_contents($file) : "<?php $file;");
                foreach ($tokens as $token) {
                    if ($token[0] === T_STRING && isset($depends[$token[1]])) {
                        $main($token[1], $result);
                    }
                    // @codeCoverageIgnoreStart
                    if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
                        if (in_array($token[0], [T_NAME_QUALIFIED, T_NAME_FULLY_QUALIFIED, T_NAME_RELATIVE, T_STRING], true)) {
                            $parts = explode('\\', $token[1]);
                            $main(array_pop($parts), $result);
                        }
                    }
                    // @codeCoverageIgnoreEnd
                }
            }
        }
        return $result;
    }
}
