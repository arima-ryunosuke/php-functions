<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * array_intersect+array_diff の組み合わせ
 *
 * 集合演算系の標準関数がカオスすぎるのである程度使いやすくしたもの。
 * (u)intersect,(u)diff,(u)key,(u)assoc の組み合わせで16通りもある。
 * - array_intersect
 * - array_uintersect
 * - array_intersect_key
 * - array_intersect_ukey
 * - array_intersect_assoc
 * - array_uintersect_assoc
 * - array_intersect_uassoc
 * - array_uintersect_uassoc
 * - array_diff
 * - array_udiff
 * - array_diff_key
 * - array_diff_ukey
 * - array_diff_assoc
 * - array_udiff_assoc
 * - array_diff_uassoc
 * - array_udiff_uassoc
 *
 * ドキュメントはアルファベット順であり一覧性が悪いので、どれを使えばいいのかぱっと見では全く分からない。
 * そして intersect,diff は往々にして両方欲しいことが多いので、この関数でコールバックを工夫すれば一発で済む。
 * ただし php レイヤーでの実装なので猛烈に遅い。単純な結果でよい場合は普通に標準関数を使うこと。
 *
 * コールバックは ([値, キー, 連番], [値, キー, 連番]) を受け取る。
 * キーで比較をしたければキーだけを見ればよいし、値で比較したければ値だけを見ればよい（もちろん両方でもよい）。
 * このコールバックを工夫するだけで上記16関数全ての大体となりうる。
 * コールバック省略時はキー・値の両方を見る（array_u(intersect|diff)_uassoc に相当する）。
 *
 * Example:
 * ```php
 * // 単純な配列
 * $a = [
 *     1 => 'hoge',
 *     2 => 'fuga',
 *     3 => 'foo',
 *     4 => 'bar',
 *     5 => 'common',
 *     6 => 'onlyA',
 * ];
 * $b = [
 *     1 => 'foo',
 *     2 => 'bar',
 *     3 => 'hoge',
 *     4 => 'fuga',
 *     5 => 'common',
 *     7 => 'onlyB',
 * ];
 * // array_* 相当
 * $result = array_intersection_differences($a, $b, fn($avkn, $bvkn) => $avkn[0] <=> $bvkn[0]);
 * that($result[''])->isSame(array_intersect($a, $b));
 * that($result[0])->isSame(array_diff($a, $b));
 * that($result[1])->isSame(array_diff($b, $a));
 * // array_*_key 相当
 * $result = array_intersection_differences($a, $b, fn($avkn, $bvkn) => $avkn[1] <=> $bvkn[1]);
 * that($result[''])->isSame(array_intersect_key($a, $b));
 * that($result[0])->isSame(array_diff_key($a, $b));
 * that($result[1])->isSame(array_diff_key($b, $a));
 * // array_*_assoc 相当
 * $result = array_intersection_differences($a, $b, fn($avkn, $bvkn) => $avkn[0] <=> $bvkn[0] ?: $avkn[1] <=> $bvkn[1]);
 * that($result[''])->isSame(array_intersect_assoc($a, $b));
 * that($result[0])->isSame(array_diff_assoc($a, $b));
 * that($result[1])->isSame(array_diff_assoc($b, $a));
 *
 * // レコード的な配列（標準関数は基本的に文字列比較なので、u 系が必須。こういう使い分けをしたくないがための関数）
 * $a = [
 *     ['id' => 1, 'name' => 'hoge'],
 *     ['id' => 2, 'name' => 'fuga'],
 *     ['id' => 3, 'name' => 'foo'],
 *     ['id' => 4, 'name' => 'bar'],
 *     ['id' => 5, 'name' => 'common'],
 *     ['id' => 6, 'name' => 'onlyA'],
 * ];
 * $b = [
 *     ['id' => 1, 'name' => 'foo'],
 *     ['id' => 2, 'name' => 'bar'],
 *     ['id' => 3, 'name' => 'hoge'],
 *     ['id' => 4, 'name' => 'fuga'],
 *     ['id' => 5, 'name' => 'common'],
 *     ['id' => 7, 'name' => 'onlyB'],
 * ];
 * // array_* 相当
 * $result = array_intersection_differences($a, $b, fn($avkn, $bvkn) => $avkn[0]['id'] <=> $bvkn[0]['id']);
 * that($result[''])->isSame(array_uintersect($a, $b, fn($a, $b) => $a['id'] <=> $b['id']));
 * that($result[0])->isSame(array_udiff($a, $b, fn($a, $b) => $a['id'] <=> $b['id']));
 * that($result[1])->isSame(array_udiff($b, $a, fn($a, $b) => $a['id'] <=> $b['id']));
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array|callable ...$arrays 対象配列（最後の要素のみ callable を受け付ける）
 * @return array ['' => 共通配列, $array1 にしかない配列, $array2にしかない配列, ..., $arrayNにしかない配列]
 */
function array_intersection_differences(...$arrays): array
{
    $comparator = null;
    if ($arrays[count($arrays) - 1] instanceof \Closure) {
        $comparator = array_pop($arrays);
    }

    $comparator ??= function (array $avkn, array $bvkn) {
        [$av, $ak,] = $avkn;
        [$bv, $bk,] = $bvkn;
        return $ak <=> $bk ?: $av <=> $bv;
    };

    $count = count($arrays);

    $result = ['' => [], ...$arrays];
    foreach ($arrays as $i => $array) {
        $n1 = -1;
        foreach ($array as $k1 => $v1) {
            $n1++;
            $found = 0;
            for ($j = $i + 1; $j < $count; $j++) {
                $n2 = -1;
                foreach ($arrays[$j] as $k2 => $v2) {
                    $n2++;
                    if (((int) $comparator([$v1, $k1, $n1], [$v2, $k2, $n2])) === 0) {
                        $found++;
                        unset($result[$i][$k1]);
                        unset($result[$j][$k2]);
                    }
                }
            }
            if ($found === $count - 1) {
                $result[''][$k1] = $v1;
            }
        }
    }

    return $result;
}
