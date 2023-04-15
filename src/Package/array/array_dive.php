<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_keys_exist.php';
require_once __DIR__ . '/../var/is_arrayable.php';
// @codeCoverageIgnoreEnd

/**
 * パス形式で配列値を取得
 *
 * 存在しない場合は $default を返す。
 *
 * Example:
 * ```php
 * $array = [
 *     'a' => [
 *         'b' => [
 *             'c' => 'vvv'
 *         ]
 *     ]
 * ];
 * that(array_dive($array, 'a.b.c'))->isSame('vvv');
 * that(array_dive($array, 'a.b.x', 9))->isSame(9);
 * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
 * that(array_dive($array, ['a', 'b', 'c']))->isSame('vvv');
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array|\ArrayAccess $array 調べる配列
 * @param string|array $path パス文字列。配列も与えられる
 * @param mixed $default 無かった場合のデフォルト値
 * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
 * @return mixed パスが示す配列の値
 */
function array_dive($array, $path, $default = null, $delimiter = '.')
{
    $keys = is_array($path) ? $path : explode($delimiter, $path);
    foreach ($keys as $key) {
        if (!is_arrayable($array)) {
            return $default;
        }
        if (!array_keys_exist($key, $array)) {
            return $default;
        }
        $array = $array[$key];
    }
    return $array;
}
