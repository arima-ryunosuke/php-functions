<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の最初のキー/値ペアをタプルで返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * that(first_keyvalue(['a', 'b', 'c']))->isSame([0, 'a']);
 * that(first_keyvalue([], 999))->isSame(999);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable|object $array 対象配列
 * @param mixed $default 無かった場合のデフォルト値
 * @return array [最初のキー, 最初の値]
 */
function first_keyvalue($array, $default = null)
{
    foreach ($array as $k => $v) {
        return [$k, $v];
    }
    return $default;
}
