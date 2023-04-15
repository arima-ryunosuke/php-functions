<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * array_find の再帰版
 *
 * コールバックの返り値が true 相当のものを返す。
 * $is_key に true を与えるとそのキー配列を返す（デフォルトの動作）。
 * $is_key に false を与えるとコールバックの結果を返す。
 *
 * この関数は論理値 FALSE を返す可能性がありますが、FALSE として評価される値を返す可能性もあります。
 *
 * Example:
 * ```php
 * // 最初に見つかったキーを配列で返す
 * that(array_find_recursive([
 *     'a' => [
 *         'b' => [
 *             'c' => [1, 2, 3],
 *         ],
 *     ],
 * ], fn($v) => $v === 2))->isSame(['a', 'b', 'c', 1]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 調べる配列
 * @param callable $callback 評価コールバック
 * @param bool $is_key キーを返すか否か
 * @return mixed コールバックが true を返した最初のキー。存在しなかったら false
 */
function array_find_recursive($array, $callback, $is_key = true)
{
    $callback = func_user_func_array($callback);

    $notfound = new \stdClass();
    $main = function ($array, $keys, $parents) use (&$main, $notfound, $callback, $is_key) {
        $parents[] = $array;
        foreach ($array as $k => $v) {
            $result = $callback($v, $k, $keys);
            if ($result) {
                if ($is_key) {
                    return [...$keys, $k];
                }
                return $result;
            }

            if (is_iterable($v)) {
                if (in_array($v, $parents, true)) {
                    continue;
                }

                $return = $main($v, [...$keys, $k], $parents);
                if ($return !== $notfound) {
                    return $return;
                }
            }
        }
        return $notfound;
    };

    $return = $main($array, [], []);
    return $return === $notfound ? false : $return;
}
