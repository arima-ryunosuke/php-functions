<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/last_keyvalue.php';
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * 配列の最後のキーを返す
 *
 * 空の場合は $default を返す。
 *
 * Example:
 * ```php
 * that(last_key(['a', 'b', 'c']))->isSame(2);
 * that(last_key([], 999))->isSame(999);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param mixed $default 無かった場合のデフォルト値
 * @return mixed 最後のキー
 */
function last_key($array, $default = null)
{
    if (is_empty($array)) {
        return $default;
    }
    /** @noinspection PhpUnusedLocalVariableInspection */
    [$k, $v] = last_keyvalue($array);
    return $k;
}
