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

    /**
     * 名前空間にエクスポートする
     *
     * @param string $namespace 吐き出す名前空間
     * @param bool $classmode メソッドモード（内部用）
     * @param array $funcname 吐き出す関数名
     * @return string php コード
     */
    public static function exportNamespace($namespace, $classmode = false, $funcname = null)
    {
        $ve = function ($v) { return self::exportVar($v); };
        $_ = function ($v) { return $v; };

        // 関数が指定されているときは依存関係を解決する
        if ($funcname !== null) {
            $depends = self::detectDependent();

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
                $main($name, $result);
            }
            $funcname = $result;
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
            $cvalue = $ve($const->getValue());
            $consts[] = "$doccomment\nconst $name = $cvalue;\n";
        }

        // 関数コードの取得
        $funcs = [];
        foreach ($symbols['function'] as $name => $method) {
            /** @var \ReflectionMethod $method */
            if ($funcname !== null && !isset($funcname['function'][$name])) {
                continue;
            }

            if ($classmode) {
                $id = '[' . $ve($method->class) . ', ' . $ve($name) . ']';
                $funcs[] = "const $name = $id;";
            }
            else {
                $doccomment = $method->getDocComment();
                $polyfill = $ve(!!preg_match('#@polyfill#', $doccomment));

                $block = $symbols['phpblock'][$name];
                $block = self::replaceConstant($block);
                $block = preg_replace('#public static #', '', $block, 1);
                $block = trim($block);

                $id = $ve(ltrim("$namespace\\$name", '\\'));
                $funcs[] = "const $name = $id;";
                $funcs[] = <<<FUNCTION
if (!isset(\$excluded_functions[{$ve($name)}]) && (!function_exists($id) || (!$polyfill && (new \\ReflectionFunction($id))->isInternal()))) {
    $doccomment
    $block
}

FUNCTION;
            }
        }

        // 完全な php コードを返す
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
     * @return array
     */
    private static function detectDependent()
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
        return array_map(function ($v) { return array_map('array_keys', $v); }, $depends);
    }

    /**
     * 関数のコードブロックの定数呼び出し箇所を単純呼び出しに変更する
     *
     * @param string $code コードブロック
     * @return string
     */
    private static function replaceConstant($code)
    {
        $symbols = self::parseSymbol();

        $codes = explode("\n", $code);
        $tokens = token_get_all("<?php $code");
        foreach ($tokens as $n => $token) {
            if ($token[0] === T_STRING) {
                if (isset($symbols['function'][$token[1]]) && $tokens[$n - 1] === '(' && $tokens[$n + 1] === ')') {
                    $codes[$token[2] - 1] = preg_replace('#\((' . $token[1] . ')\)#', '$1', $codes[$token[2] - 1]);
                }
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
                /** @noinspection PhpUndefinedVariableInspection */
                $keystr = $hashed ? $keys[$k] . str_repeat(' ', $maxlen - strlen($keys[$k])) . ' => ' : '';
                $kvl .= $spacer1 . $keystr . self::exportVar($v, $nest + 1) . ",\n";
            }
            return "[\n{$kvl}{$spacer2}]";
        }
        return is_string($value) ? '"' . addcslashes($value, "\"\0\\") . '"' : (is_null($value) ? 'null' : var_export($value, true));
    }
}
