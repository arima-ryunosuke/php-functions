<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
require_once __DIR__ . '/../utility/function_configure.php';
require_once __DIR__ . '/../var/arrayval.php';
require_once __DIR__ . '/../var/is_arrayable.php';
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
 * @return iterable|array $callback が !false を返し map された配列
 */
function array_filter_map($array, $callback)
{
    // Iterator だが ArrayAccess ではないオブジェクト（Generator とか）は unset できないので配列として扱わざるを得ない
    if (!(function_configure('array.variant') && is_arrayable($array))) {
        $array = arrayval($array, false);
    }

    $callback = func_user_func_array($callback);
    $n = 0;
    foreach (arrayval($array, false) as $k => $v) {
        $map = $callback($v, $k, $n++);
        if ($map === false) {
            unset($array[$k]);
        }
        else {
            $array[$k] = $v;
        }
    }
    return $array;
}
