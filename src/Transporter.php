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
     * @param ?string $dir エクスポートするディレクトリ
     */
    public static function exportAll($dir = null)
    {
        $dir = is_object($dir) || $dir === null ? __DIR__ . '/../include' : $dir;

        file_put_contents("$dir/global.php", self::exportNamespace(null));
        file_put_contents("$dir/namespace.php", self::exportNamespace(__NAMESPACE__));
        file_put_contents("$dir/package.php", self::exportNamespace(__NAMESPACE__ . '\\Package', true));
    }

    /**
     * 名前空間にエクスポートする
     *
     * @param string $namespace 吐き出す名前空間
     * @param bool $classmode メソッドモード（内部用）
     * @param ?array $funcname 吐き出す関数名。ファイル名っぽい文字列は中身で検出する
     * @return string php コード
     */
    public static function exportNamespace($namespace, $classmode = false, $funcname = null)
    {
        $ve = function ($v) { return self::exportVar($v); };
        $_ = function ($v) { return $v; };

        // 関数が指定されているときは依存関係を解決する
        if ($funcname !== null) {
            $funcname = self::detectDependent($funcname);
        }

        $namespace = trim($namespace, '\\');
        $nameprefix = $namespace;
        if (strlen($nameprefix)) {
            $nameprefix .= '\\';
        }
        $symbols = self::parseSymbol();

        // 定数コードの取得
        $consts = [];
        foreach ($symbols['constant'] as $name => $const) {
            /** @var \ReflectionClassConstant $const */
            if ($funcname !== null && !isset($funcname['constant'][$name])) {
                continue;
            }
            $doccomment = $const->getDocComment();
            $cname = $ve("{$nameprefix}$name");
            $cvalue = trim(substr($ve([$const->getValue()]), 1, -1), " \n\t,");
            $consts[] = <<<CONSTANT
if (!defined($cname)) {
    $doccomment
    define($cname, $cvalue);
}

CONSTANT;
        }

        // 関数コードの取得
        $funcs = [];
        foreach ($symbols['function'] as $name => $method) {
            /** @var \ReflectionMethod $method */
            if ($funcname !== null && !isset($funcname['function'][$name])) {
                continue;
            }

            if ($classmode) {
                $cname = $ve("{$nameprefix}$name");
                $id = '[' . $ve($method->class) . ', ' . $ve($name) . ']';
                $funcs[] = "define($cname, $id);";
            }
            else {
                $doccomment = $method->getDocComment();
                $polyfill = $ve(!!preg_match('#@polyfill#', $doccomment));

                $block = $symbols['phpblock'][$name];
                $block = self::replaceConstant($block, '');
                $block = preg_replace('#public static #', '', $block, 1);
                $block = trim($block);

                $cname = $ve("{$nameprefix}$name");
                $id = $ve("{$nameprefix}$name");
                $funcs[] = <<<FUNCTION
if (!isset(\$excluded_functions[{$ve($name)}]) && (!function_exists($id) || (!$polyfill && (new \\ReflectionFunction($id))->isInternal()))) {
    $doccomment
    $block
}
FUNCTION;
                $funcs[] = <<<CONSTANT
if (function_exists($id) && !defined($cname)) {
    define($cname, $id);
}

CONSTANT;
            }
        }

        // 完全な php コードを返す
        /** @noinspection PhpExpressionResultUnusedInspection */
        return <<<CONTENTS
<?php

# Don't touch this code. This is auto generated.

{$_($namespace ? "namespace $namespace;\n" : "")}
# constants
{$_(implode("\n", $consts))}

# functions
{$_(implode("\n", $funcs))}
CONTENTS;
    }

    /**
     * 単一の静的クラスにエクスポートする
     *
     * @param string $classname 吐き出すクラス名（完全修飾名）
     * @param ?array $funcname 吐き出す関数名。ファイル名っぽい文字列は中身で検出する
     * @return string php コード
     */
    public static function exportClass($classname, $funcname = null)
    {
        $ve = function ($v) { return self::exportVar($v); };
        $_ = function ($v) { return $v; };

        // 関数が指定されているときは依存関係を解決する
        if ($funcname !== null) {
            $funcname = self::detectDependent($funcname);
        }

        $classname = trim($classname, '\\');
        $shortname = $classname;
        $namespace = '';
        $parts = explode('\\', $classname);
        if (count($parts) > 1) {
            $shortname = array_pop($parts);
            $namespace = implode('\\', $parts);
        }

        $symbols = self::parseSymbol();

        // 定数コードの取得
        $consts = [];
        foreach ($symbols['constant'] as $name => $const) {
            /** @var \ReflectionClassConstant $const */
            if ($funcname !== null && !isset($funcname['constant'][$name])) {
                continue;
            }
            $doccomment = $const->getDocComment();
            $cvalue = trim(substr($ve([$const->getValue()]), 1, -1), " \n\t,");
            $consts[] = <<<CONSTANT
    $doccomment
    const $name = $cvalue;

CONSTANT;
        }

        // 関数コードの取得
        $funcs = [];
        foreach ($symbols['function'] as $name => $method) {
            /** @var \ReflectionMethod $method */
            if ($funcname !== null && !isset($funcname['function'][$name])) {
                continue;
            }

            $doccomment = $method->getDocComment();

            $block = $symbols['phpblock'][$name];
            $block = self::replaceConstant($block, "\\$classname");
            $block = trim($block);

            $consts[] = <<<CONSTANT
    const $name = {$_($ve(["\\$classname", $name]))};
CONSTANT;
            $funcs[] = <<<FUNCTION
    $doccomment
    $block
FUNCTION;
        }

        // 完全な php コードを返す
        /** @noinspection PhpExpressionResultUnusedInspection */
        return <<<CONTENTS
<?php

# Don't touch this code. This is auto generated.

{$_($namespace ? "namespace $namespace;\n" : "")}
class $shortname
{
{$_(implode("\n", $consts))}

{$_(implode("\n\n", $funcs))}
}
CONTENTS;
    }

    /**
     * 配下の Package からエクスポートすべき定数・関数を抽出する
     *
     * @param bool $nocache キャッシュ破棄フラグ
     * @return \Reflector[]
     */
    private static function parseSymbol($nocache = false)
    {
        static $cache;
        if ($nocache) {
            $cache = null;
        }
        if (!isset($cache)) {
            $cache = [
                'constant' => [],
                'function' => [],
                'phpblock' => [],
            ];
            foreach (glob(__DIR__ . '/Package/*.php') as $fn) {
                $refclass = new \ReflectionClass(__NAMESPACE__ . "\\Package\\" . basename($fn, '.php'));
                $lines = file($refclass->getFileName());

                foreach ($refclass->getReflectionConstants() as $const) {
                    $cache['constant'][$const->getName()] = $const;
                }
                foreach ($refclass->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_STATIC) as $method) {
                    $sl = $method->getStartLine();
                    $el = $method->getEndLine();
                    $cache['function'][$method->getName()] = $method;
                    $cache['phpblock'][$method->getName()] = implode('', array_slice($lines, $sl - 1, $el - $sl + 1));
                }
            }
        }
        return $cache;
    }

    /**
     * 配下の Package から定数・関数の依存関係を導出する
     *
     * @param string|array $funcname 依存関数
     * @return array
     */
    private static function detectDependent($funcname)
    {
        $symbols = self::parseSymbol();

        $depends = array_fill_keys(array_keys([$symbols['function']]), [
            'constant' => [],
            'function' => [],
        ]);
        foreach ($symbols['function'] as $name => $method) {
            $tokens = token_get_all("<?php {$symbols['phpblock'][$name]}");
            foreach ($tokens as $token) {
                if ($token[0] === T_STRING) {
                    if (isset($symbols['constant'][$token[1]])) {
                        $depends[$name]['constant'][$token[1]] = true;
                    }
                    if (isset($symbols['function'][$token[1]])) {
                        $depends[$name]['function'][$token[1]] = true;
                    }
                }
            }
        }
        $depends = array_map(function ($v) { return array_map('array_keys', $v); }, $depends);

        $main = function ($funcname, &$result) use (&$main, $depends) {
            foreach ($depends[$funcname]['constant'] ?? [] as $const) {
                $result['constant'][$const] = true;
            }

            $result['function'][$funcname] = true;
            foreach ($depends[$funcname]['function'] ?? [] as $func) {
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
            // ファイルエントリなら php とみなしてトークンで検出する
            elseif (file_exists($name)) {
                if (is_dir($name)) {
                    $rdi = new \RecursiveDirectoryIterator($name, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_PATHNAME);
                    $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::LEAVES_ONLY);
                    $name = iterator_to_array($rii);
                }
                foreach ((array) $name as $file) {
                    $tokens = token_get_all(file_get_contents($file));
                    foreach ($tokens as $token) {
                        if ($token[0] === T_STRING && isset($depends[$token[1]])) {
                            $main($token[1], $result);
                        }
                    }
                }
            }
            // それ以外のただの文字列なら含まれている文字列を検出する
            else {
                foreach ($depends as $fname => $dummy) {
                    if (strpos($name, "$fname") !== false) {
                        $main($fname, $result);
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 関数のコードブロックの定数呼び出し箇所を単純呼び出しに変更する
     *
     * @param string $code コードブロック
     * @param string $classname クラス名
     * @return string
     */
    private static function replaceConstant($code, $classname)
    {
        $symbols = self::parseSymbol();

        $classname = str_replace('\\', '\\\\', $classname);
        $prefix = strlen($classname) ? "$classname::" : '';
        $codes = explode("\n", $code);
        $tokens = token_get_all("<?php $code");
        foreach ($tokens as $n => $token) {
            if ($token[0] === T_STRING) {
                if (isset($symbols['function'][$token[1]]) && $tokens[$n - 1] === '(' && $tokens[$n + 1] === ')') {
                    $codes[$token[2] - 1] = preg_replace('#\((' . $token[1] . ')\)#', $prefix . '$1', $codes[$token[2] - 1], 1);
                }
                if ($prefix && isset($symbols['constant'][$token[1]])) {
                    $codes[$token[2] - 1] = preg_replace('#(?<!::)(' . $token[1] . ')#', $prefix . '$1', $codes[$token[2] - 1], 1);
                }
            }
            if ($prefix && $token[0] === T_CLASS_C) {
                $codes[$token[2] - 1] = preg_replace('#(' . $token[1] . ')#', var_export($classname, true), $codes[$token[2] - 1], 1);
            }
        }
        return implode("\n", $codes);
    }

    /**
     * 値の出力
     *
     * この Transporter のコンテキストでは var_export2 は使えないので自前で定義する
     *
     * @param mixed $value
     * @param int $nest
     * @return string
     */
    private static function exportVar($value, $nest = 0)
    {
        if (is_array($value)) {
            $spacer1 = str_repeat(' ', ($nest + 1) * 4);
            $spacer2 = str_repeat(' ', $nest * 4);

            $hashed = $value !== array_values($value);

            if (!$hashed) {
                $primitive_only = (array_filter($value, function ($v) { return is_scalar($v) || is_null($v) || is_resource($v); }));
                if ($primitive_only === $value) {
                    return '[' . implode(', ', array_map('self::exportVar', $value)) . ']';
                }
            }

            if ($hashed) {
                $keys = array_map('self::exportVar', array_combine($keys = array_keys($value), $keys));
                $maxlen = max(array_map('strlen', $keys));
            }
            $kvl = '';
            foreach ($value as $k => $v) {
                $keystr = $hashed ? $keys[$k] . str_repeat(' ', $maxlen - strlen($keys[$k])) . ' => ' : '';
                $kvl .= $spacer1 . $keystr . self::exportVar($v, $nest + 1) . ",\n";
            }
            return "[\n{$kvl}{$spacer2}]";
        }
        return is_string($value) ? '"' . addcslashes($value, "\"\0\\") . '"' : (is_null($value) ? 'null' : var_export($value, true));
    }
}
