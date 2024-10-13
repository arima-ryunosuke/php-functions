<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_find_first.php';
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * array_find の後ろから探す版
 *
 * コールバックの返り値が true 相当のものを返す。
 * $is_key に true を与えるとそのキーを返す（デフォルトの動作）。
 * $is_key に false を与えるとコールバックの結果を返す。
 *
 * この関数は論理値 FALSE を返す可能性がありますが、FALSE として評価される値を返す可能性もあります。
 *
 * Example:
 * ```php
 * // 最後に見つかったキーを返す
 * that(array_find_last(['a', '8', '9'], 'ctype_digit'))->isSame(2);
 * that(array_find_last(['a', 'b', 'b'], fn($v) => $v === 'b'))->isSame(2);
 * // 最後に見つかったコールバック結果を返す（最初の数字の2乗を返す）
 * $ifnumeric2power = fn($v) => ctype_digit($v) ? $v * $v : false;
 * that(array_find_last(['a', '8', '9'], $ifnumeric2power, false))->isSame(81);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 調べる配列
 * @param callable $callback 評価コールバック
 * @param bool $is_key キーを返すか否か
 * @return mixed コールバックが true を返した最初のキー。存在しなかったら false
 */
function array_find_last($array, $callback, $is_key = true)
{
    // 配列なら reverse すればよい
    if (is_array($array)) {
        return array_find_first(array_reverse($array, true), $callback, $is_key);
    }

    $callback = func_user_func_array($callback);

    // イテレータは全ループするしかない
    $return = $notfound = new \stdClass();
    $n = 0;
    foreach ($array as $k => $v) {
        $result = $callback($v, $k, $n++);
        if ($result) {
            $return = $is_key ? $k : $result;
        }
    }
    return $return === $notfound ? false : $return;
}
