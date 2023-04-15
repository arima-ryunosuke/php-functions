<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/varcmp.php';
// @codeCoverageIgnoreEnd

/**
 * 比較関数にキーも渡ってくる安定ソート
 *
 * 比較関数は ($avalue, $bvalue, $akey, $bkey) という引数を取る。
 * 「値で比較して同値だったらキーも見たい」という状況はまれによくあるはず。
 * さらに安定ソートであり、同値だとしても元の並び順は維持される。
 *
 * $comparator は省略できる。省略した場合、型に基づいてよしなにソートする。
 * （が、比較のたびに型チェックが入るので指定したほうが高速に動く）。
 *
 * ただし、標準のソート関数とは異なり、参照渡しではなくソートして返り値で返す。
 * また、いわゆる asort であり、キー・値は常に維持される。
 *
 * Example:
 * ```php
 * $array = [
 *     'a'  => 3,
 *     'b'  => 1,
 *     'c'  => 2,
 *     'x1' => 9,
 *     'x2' => 9,
 *     'x3' => 9,
 * ];
 * // 普通のソート
 * that(kvsort($array))->isSame([
 *     'b'  => 1,
 *     'c'  => 2,
 *     'a'  => 3,
 *     'x1' => 9,
 *     'x2' => 9,
 *     'x3' => 9,
 * ]);
 * // キーを使用したソート
 * that(kvsort($array, fn($av, $bv, $ak, $bk) => strcmp($bk, $ak)))->isSame([
 *     'x3' => 9,
 *     'x2' => 9,
 *     'x1' => 9,
 *     'c'  => 2,
 *     'b'  => 1,
 *     'a'  => 3,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable|array $array 対象配列
 * @param callable|int|null $comparator 比較関数。SORT_XXX も使える
 * @return array ソートされた配列
 */
function kvsort($array, $comparator = null)
{
    if ($comparator === null || is_int($comparator)) {
        $sort_flg = $comparator;
        $comparator = fn($av, $bv, $ak, $bk) => varcmp($av, $bv, $sort_flg);
    }

    $n = 0;
    $tmp = [];
    foreach ($array as $k => $v) {
        $tmp[$k] = [$n++, $k, $v];
    }

    uasort($tmp, fn($a, $b) => $comparator($a[2], $b[2], $a[1], $b[1]) ?: ($a[0] - $b[0]));

    foreach ($tmp as $k => $v) {
        $tmp[$k] = $v[2];
    }

    return $tmp;
}
