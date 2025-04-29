<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * 配列の最後のキー/値ペアをタプルで返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * that(last_keyvalue(['a', 'b', 'c']))->isSame([2, 'c']);
 * that(last_keyvalue([], 999))->isSame(999);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable|object $array 対象配列
 * @param mixed $default 無かった場合のデフォルト値
 * @return array [最後のキー, 最後の値]
 */
function last_keyvalue($array, $default = null)
{
    if (is_empty($array)) {
        return $default;
    }
    if (is_array($array)) {
        $k = array_key_last($array);
        return [$k, $array[$k]];
    }
    foreach ($array as $k => $v) {
        // dummy
    }
    // $k がセットされてるなら「ループが最低でも1度回った（≠空）」とみなせる
    if (isset($k)) {
        /** @noinspection PhpUndefinedVariableInspection */
        return [$k, $v];
    }
    return $default;
}
