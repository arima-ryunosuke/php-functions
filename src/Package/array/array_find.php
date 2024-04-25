<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * array_search のクロージャ版のようなもの
 *
 * コールバックの返り値が true 相当のものを返す。
 * $is_key に true を与えるとそのキーを返す（デフォルトの動作）。
 * $is_key に false を与えるとコールバックの結果を返す。
 *
 * この関数は論理値 FALSE を返す可能性がありますが、FALSE として評価される値を返す可能性もあります。
 *
 * Example:
 * ```php
 * // 最初に見つかったキーを返す
 * that(array_find(['a', '8', '9'], 'ctype_digit'))->isSame(1);
 * that(array_find(['a', 'b', 'b'], fn($v) => $v === 'b'))->isSame(1);
 * // 最初に見つかったコールバック結果を返す（最初の数字の2乗を返す）
 * $ifnumeric2power = fn($v) => ctype_digit($v) ? $v * $v : false;
 * that(array_find(['a', '8', '9'], $ifnumeric2power, false))->isSame(64);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 調べる配列
 * @param callable $callback 評価コールバック
 * @param bool $is_key キーを返すか否か
 * @return mixed コールバックが true を返した最初のキー。存在しなかったら null
 */
function array_find($array, $callback, $is_key = true)
{
    $callback = func_user_func_array($callback);

    $n = 0;
    foreach ($array as $k => $v) {
        $result = $callback($v, $k, $n++);
        if ($result) {
            if ($is_key) {
                return $k;
            }
            return $result;
        }
    }
    return null;
}
