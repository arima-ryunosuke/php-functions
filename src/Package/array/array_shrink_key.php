<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 値の優先順位を逆にした array_intersect_key
 *
 * array_intersect_key は「左優先で共通項を取る」という動作だが、この関数は「右優先で共通項を取る」という動作になる。
 * 「配列の並び順はそのままで値だけ変えたい/削ぎ落としたい」という状況はまれによくあるはず。
 *
 * Example:
 * ```php
 * $array1 = ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'];
 * $array2 = ['c' => 'C2', 'b' => 'B2', 'a' => 'A2'];
 * $array3 = ['c' => 'C3', 'dummy' => 'DUMMY'];
 * // 全共通項である 'c' キーのみが生き残り、その値は最後の 'C3' になる
 * that(array_shrink_key($array1, $array2, $array3))->isSame(['c' => 'C3']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable|array|object ...$variadic 共通項を取る配列（可変引数）
 * @return array 新しい配列
 */
function array_shrink_key(...$variadic)
{
    $result = [];
    foreach ($variadic as $n => $array) {
        if (!is_array($array)) {
            $variadic[$n] = arrayval($array, false);
        }
        $result = array_replace($result, $variadic[$n]);
    }
    return array_intersect_key($result, ...$variadic);
}
