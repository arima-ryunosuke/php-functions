<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../funchand/func_user_func_array.php';
require_once __DIR__ . '/../var/varcmp.php';
// @codeCoverageIgnoreEnd

/**
 * 比較関数にキーも渡ってくる安定ソート
 *
 * 比較関数は ($valueA, $valueB, $keyA, $keyB) という引数を取る。
 * 「値で比較して同値だったらキーも見たい」という状況はまれによくあるはず。
 * さらに安定ソートであり、同値だとしても元の並び順は維持される。
 *
 * $schwartzians を指定した場合は呼び出しが ($schwartzianA, $schwartzianB, $valueA, $valueB, $keyA, $keyB) になる。
 * $schwartzianX は単一値の場合はその結果、配列の場合はキー構造が維持されて渡ってくる。
 * このあたりは表現しにくいので Example を参照。
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
 * // シュワルツ変換を使用したソート（引数説明のために全て列挙している）
 * that(kvsort($array, fn($hashA, $hashB, $av, $bv, $ak, $bk) => ($hashA['md5'] <=> $hashB['md5']) ?: ($hashA['sha1'] <=> $hashB['sha1']), [
 *     'md5'  => fn($v) => md5($v),
 *     'sha1' => fn($v) => sha1($v),
 * ]))->isSame([
 *     'x1' => 9,
 *     'x2' => 9,
 *     'x3' => 9,
 *     'b'  => 1,
 *     'c'  => 2,
 *     'a'  => 3,
 * ]);
 * // シュワルツ変換の場合 $comparator は省略可能（昇順）で、配列ではなく単一値を渡せばその結果値が渡ってくる（これは要するに md5 での昇順ソート）
 * that(kvsort($array, null, fn($v) => md5($v)))->isSame([
 *     'x1' => 9,
 *     'x2' => 9,
 *     'x3' => 9,
 *     'b'  => 1,
 *     'c'  => 2,
 *     'a'  => 3,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @template T of iterable|array
 * @param T $array 対象配列
 * @param callable|int|null $comparator 比較関数。SORT_XXX も使える
 * @param callable|callable[] $schwartzians シュワルツ変換に使用する仮想列
 * @return T ソートされた配列
 */
function kvsort($array, $comparator = null, $schwartzians = [])
{
    // シュワルツ変換の準備（単一であるとかピッタリ呼び出しとか）
    $is_array = is_array($schwartzians) && !is_callable($schwartzians);
    $schwartzians = arrayize($schwartzians);
    foreach ($schwartzians as $s => $schwartzian) {
        $schwartzians[$s] = func_user_func_array($schwartzian);
    }

    // $comparator が定数あるいは省略時は自動導出
    if ($comparator === null || is_int($comparator)) {
        // シュワルツ変換のときは型は意識しなくてよい（呼び元の責務）ので昇順降順だけ見る
        if ($schwartzians) {
            if (($comparator ?? SORT_ASC) === SORT_ASC) {
                $comparator = fn($as, $bs) => $as <=> $bs;
            }
            else {
                $comparator = fn($as, $bs) => -($as <=> $bs);
            }
        }
        // そうでない場合は varcmp に委譲
        else {
            $sort_flg = $comparator;
            $comparator = fn($av, $bv, $ak, $bk) => varcmp($av, $bv, $sort_flg);
        }
    }

    // 一時配列の準備
    $n = 0;
    $tmp = [];
    foreach ($array as $k => $v) {
        $virtuals = [];
        if ($is_array) {
            foreach ($schwartzians as $s => $schwartzian) {
                $virtuals[$s] = $schwartzian($v, $k, $n);
            }
        }
        else {
            $virtuals = $schwartzians[0]($v, $k, $n);
        }
        $tmp[] = [$n++, $k, $v, $virtuals];
    }

    // ソートしてから元の配列の体裁で返す
    usort($tmp, function ($a, $b) use ($comparator, $schwartzians) {
        $virtuals = $schwartzians ? [$a[3], $b[3]] : [];
        $com = $comparator(...$virtuals, ...[$a[2], $b[2], $a[1], $b[1]]);
        return $com !== 0 ? $com : ($a[0] - $b[0]);
    });
    return array_column($tmp, 2, 1);
}
