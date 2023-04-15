<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * array_filter + array_map する
 *
 * コールバックを適用して、結果が !false 要素のみ取り出す。
 * コールバックの第1引数を参照にして書き換えると結果にも反映される。
 *
 * $callback が要求するならキーも渡ってくる。
 *
 * Example:
 * ```php
 * that(array_filter_map([' a ', ' b ', ''], fn(&$v) => strlen($v) ? $v = trim($v) : false))->isSame(['a', 'b']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @return array $callback が !false を返し map された配列
 */
function array_filter_map($array, $callback)
{
    $callback = func_user_func_array($callback);
    $result = [];
    $n = 0;
    foreach ($array as $k => &$v) {
        if ($callback($v, $k, $n++) !== false) {
            $result[$k] = $v;
        }
    }
    return $result;
}
