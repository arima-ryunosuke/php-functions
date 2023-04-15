<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * array_key_exists の複数版
 *
 * 指定キーが全て存在するなら true を返す。
 * 配列ではなく単一文字列を与えても動作する（array_key_exists と全く同じ動作になる）。
 *
 * $keys に空を与えると例外を投げる。
 * $keys に配列を与えるとキーで潜ってチェックする（Example 参照）。
 *
 * Example:
 * ```php
 * // すべて含むので true
 * that(array_keys_exist(['a', 'b', 'c'], ['a' => 'A', 'b' => 'B', 'c' => 'C']))->isTrue();
 * // N は含まないので false
 * that(array_keys_exist(['a', 'b', 'N'], ['a' => 'A', 'b' => 'B', 'c' => 'C']))->isFalse();
 * // 配列を与えると潜る（日本語で言えば「a というキーと、x というキーとその中に x1, x2 というキーがあるか？」）
 * that(array_keys_exist(['a', 'x' => ['x1', 'x2']], ['a' => 'A', 'x' => ['x1' => 'X1', 'x2' => 'X2']]))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array|string $keys 調べるキー
 * @param array|\ArrayAccess $array 調べる配列
 * @return bool 指定キーが全て存在するなら true
 */
function array_keys_exist($keys, $array)
{
    $keys = is_iterable($keys) ? $keys : [$keys];
    if (is_empty($keys)) {
        throw new \InvalidArgumentException('$keys is empty.');
    }

    $is_arrayaccess = $array instanceof \ArrayAccess;

    foreach ($keys as $k => $key) {
        if (is_array($key)) {
            // まずそのキーをチェックして
            if (!array_keys_exist($k, $array)) {
                return false;
            }
            // あるなら再帰する
            if (!array_keys_exist($key, $array[$k])) {
                return false;
            }
        }
        elseif ($is_arrayaccess) {
            if (!$array->offsetExists($key)) {
                return false;
            }
        }
        elseif (!array_key_exists($key, $array)) {
            return false;
        }
    }
    return true;
}
