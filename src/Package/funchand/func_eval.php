<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_sprintf.php';
require_once __DIR__ . '/../misc/php_parse.php';
// @codeCoverageIgnoreEnd

/**
 * 指定コードで eval するクロージャを返す
 *
 * create_function のクロージャ版みたいなもの。
 * 参照渡しは未対応。
 *
 * コード中の `$1`, `$2` 等の文字は `func_get_arg(1)` のような引数関数に変換される。
 *
 * Example:
 * ```php
 * $func_eval = func_eval('$a + $b + $c', 'a', 'b', 'c');
 * that($func_eval(1, 2, 3))->isSame(6);
 *
 * // $X による参照
 * $func_eval = func_eval('$1 + $2 + $3');
 * that($func_eval(1, 2, 3))->isSame(6);
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param string $expression eval コード
 * @param mixed ...$variadic 引数名（可変引数）
 * @return \Closure 新しいクロージャ
 */
function func_eval($expression, ...$variadic)
{
    static $cache = [];

    $args = array_sprintf($variadic, '$%s', ',');
    $cachekey = "$expression($args)";
    if (!isset($cache[$cachekey])) {
        $tmp = php_parse("<?php $expression");
        array_shift($tmp);
        $stmt = '';
        for ($i = 0; $i < count($tmp); $i++) {
            if (($tmp[$i]->text ?? null) === '$' && $tmp[$i + 1]->id === T_LNUMBER) {
                $n = $tmp[$i + 1]->text - 1;
                $stmt .= "func_get_arg($n)";
                $i++;
            }
            else {
                $stmt .= $tmp[$i]->text;
            }
        }
        $cache[$cachekey] = eval("return function($args) { return $stmt; };");
    }
    return $cache[$cachekey];
}
