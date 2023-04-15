<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/first_keyvalue.php';
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * 配列の最初の値を返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * that(first_value(['a', 'b', 'c']))->isSame('a');
 * that(first_value([], 999))->isSame(999);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param mixed $default 無かった場合のデフォルト値
 * @return mixed 最初の値
 */
function first_value($array, $default = null)
{
    if (is_empty($array)) {
        return $default;
    }
    /** @noinspection PhpUnusedLocalVariableInspection */
    [$k, $v] = first_keyvalue($array);
    return $v;
}
