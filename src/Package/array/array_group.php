<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_of.php';
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * 配列をコールバックの返り値でグループ化する
 *
 * コールバックを省略すると値そのもので評価する。
 * コールバックに配列・文字列を与えるとキーでグループ化する。
 * コールバックが配列を返すと入れ子としてグループ化する。
 *
 * Example:
 * ```php
 * that(array_group([1, 1, 1]))->isSame([
 *     1 => [1, 1, 1],
 * ]);
 * that(array_group([1, 2, 3], fn($v) => $v % 2))->isSame([
 *     1 => [1, 3],
 *     0 => [2],
 * ]);
 * // group -> id で入れ子グループにする
 * $row1 = ['id' => 1, 'group' => 'hoge'];
 * $row2 = ['id' => 2, 'group' => 'fuga'];
 * $row3 = ['id' => 3, 'group' => 'hoge'];
 * that(array_group([$row1, $row2, $row3], fn($row) => [$row['group'], $row['id']]))->isSame([
 *     'hoge' => [
 *         1 => $row1,
 *         3 => $row3,
 *     ],
 *     'fuga' => [
 *         2 => $row2,
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param ?callable|string|array $callback 評価クロージャ。 null なら値そのもので評価
 * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
 * @return array グルーピングされた配列
 */
function array_group($array, $callback = null, $preserve_keys = false)
{
    if ($callback !== null && !is_callable($callback)) {
        $callback = array_of($callback);
    }
    $callback = func_user_func_array($callback);

    $result = [];
    $n = 0;
    foreach ($array as $k => $v) {
        $vv = $callback($v, $k, $n++);
        // 配列は潜る
        if (is_array($vv)) {
            $tmp = &$result;
            foreach ($vv as $vvv) {
                $tmp = &$tmp[$vvv];
            }
            $tmp = $v;
            unset($tmp);
        }
        elseif (!$preserve_keys && is_int($k)) {
            $result[$vv][] = $v;
        }
        else {
            $result[$vv][$k] = $v;
        }
    }
    return $result;
}
