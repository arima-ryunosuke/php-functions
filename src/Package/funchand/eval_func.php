<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_sprintf.php';
require_once __DIR__ . '/../misc/parse_php.php';
require_once __DIR__ . '/../constants.php';
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
 * $evalfunc = eval_func('$a + $b + $c', 'a', 'b', 'c');
 * that($evalfunc(1, 2, 3))->isSame(6);
 *
 * // $X による参照
 * $evalfunc = eval_func('$1 + $2 + $3');
 * that($evalfunc(1, 2, 3))->isSame(6);
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param string $expression eval コード
 * @param mixed ...$variadic 引数名（可変引数）
 * @return \Closure 新しいクロージャ
 */
function eval_func($expression, ...$variadic)
{
    static $cache = [];

    $args = array_sprintf($variadic, '$%s', ',');
    $cachekey = "$expression($args)";
    if (!isset($cache[$cachekey])) {
        $tmp = parse_php($expression, TOKEN_NAME);
        array_shift($tmp);
        $stmt = '';
        for ($i = 0; $i < count($tmp); $i++) {
            if (($tmp[$i][1] ?? null) === '$' && $tmp[$i + 1][0] === T_LNUMBER) {
                $n = $tmp[$i + 1][1] - 1;
                $stmt .= "func_get_arg($n)";
                $i++;
            }
            else {
                $stmt .= $tmp[$i][1];
            }
        }
        $cache[$cachekey] = eval("return function($args) { return $stmt; };");
    }
    return $cache[$cachekey];
}
