<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の各キー・値にコールバックを適用する
 *
 * $callback は (キー, 値, $callback) が渡ってくるので 「その位置に配置したい配列」を返せばそこに置換される。
 * つまり、空配列を返せばそのキー・値は消えることになるし、複数の配列を返せば要素が増えることになる。
 * ただし、数値キーは新しく採番される。
 * null を返すと特別扱いで、そのキー・値をそのまま維持する。
 * iterable を返す必要があるが、もし iterable でない場合は配列キャストされる。
 *
 * 「map も filter も可能でキー変更可能」というとてもマッチョな関数。
 * 実質的には「数値キーが再採番される再帰的でない array_convert」のように振る舞う。
 * ただし、再帰処理はないので自前で管理する必要がある。
 *
 * Example:
 * ```php
 * $array = [
 *    'a' => 'A',
 *    'b' => 'B',
 *    'c' => 'C',
 *    'd' => 'D',
 * ];
 * // キーに '_' 、値に 'prefix-' を付与。'b' は一切何もしない。'c' は値のみ。'd' はそれ自体伏せる
 * that(array_kvmap($array, function ($k, $v) {
 *     if ($k === 'b') return null;
 *     if ($k === 'd') return [];
 *     if ($k !== 'c') $k = "_$k";
 *     return [$k => "prefix-$v"];
 * }))->isSame([
 *     '_a' => 'prefix-A',
 *     'b'  => 'B',
 *     'c'  => 'prefix-C',
 * ]);
 *
 * // 複数返せばその分増える（要素の水増し）
 * that(array_kvmap($array, fn($k, $v) => [
 *     "{$k}1" => "{$v}1",
 *     "{$k}2" => "{$v}2",
 * ]))->isSame([
 *    'a1' => 'A1',
 *    'a2' => 'A2',
 *    'b1' => 'B1',
 *    'b2' => 'B2',
 *    'c1' => 'C1',
 *    'c2' => 'C2',
 *    'd1' => 'D1',
 *    'd2' => 'D2',
 * ]);
 *
 * // $callback には $callback 自体も渡ってくるので再帰も比較的楽に書ける
 * that(array_kvmap([
 *     'x' => [
 *         'X',
 *         'y' => [
 *             'Y',
 *             'z' => ['Z'],
 *         ],
 *     ],
 * ], function ($k, $v, $callback) {
 *     // 配列だったら再帰する
 *     return ["_$k" => is_array($v) ? array_kvmap($v, $callback) : "prefix-$v"];
 * }))->isSame([
 *     "_x" => [
 *         "_0" => "prefix-X",
 *         "_y" => [
 *             "_0" => "prefix-Y",
 *             "_z" => [
 *                 "_0" => "prefix-Z",
 *             ],
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 適用するコールバック
 * @return array 変換された配列
 */
function array_kvmap($array, $callback)
{
    $result = [];
    foreach ($array as $k => $v) {
        $kv = $callback($k, $v, $callback) ?? [$k => $v];
        if (!is_iterable($kv)) {
            $kv = [$kv];
        }
        // $result = array_merge($result, $kv); // 遅すぎる
        foreach ($kv as $k2 => $v2) {
            if (is_int($k2)) {
                $result[] = $v2;
            }
            else {
                $result[$k2] = $v2;
            }
        }
    }
    return $result;
}
