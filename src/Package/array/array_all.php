<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * 全要素が true になるなら true を返す（1つでも false なら false を返す）
 *
 * $callback が要求するならキーも渡ってくる。
 *
 * Example:
 * ```php
 * that(array_all([true, true]))->isTrue();
 * that(array_all([true, false]))->isFalse();
 * that(array_all([false, false]))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param ?callable $callback 評価クロージャ。 null なら値そのもので評価
 * @param bool|mixed $default 空配列の場合のデフォルト値
 * @return bool 全要素が true なら true
 */
function array_all($array, $callback = null, $default = true)
{
    if (is_empty($array)) {
        return $default;
    }

    $callback = func_user_func_array($callback);

    $n = 0;
    foreach ($array as $k => $v) {
        if (!$callback($v, $k, $n++)) {
            return false;
        }
    }
    return true;
}
