<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の各要素に再帰的にコールバックを適用して変換する
 *
 * $callback は下記の仕様。
 *
 * 引数は (キー, 値, 今まで処理したキー配列) で渡ってくる。
 * 返り値は新しいキーを返す。
 *
 * - 文字列や数値を返すとそれがキーとして使われる
 * - null を返すと元のキーがそのまま使われる
 * - true を返すと数値連番が振られる
 * - false を返すとその要素は無かったことになる
 * - 配列を返すとその配列で完全に置換される
 *
 * $apply_array=false で要素が配列の場合は再帰され、コールバックが適用されない（array_walk_recursive と同じ仕様）。
 *
 * $apply_array=true だと配列かは問わず全ての要素にコールバックが適用される。
 * 配列も渡ってきてしまうのでコールバック内部で is_array 判定が必要になる場合がある。
 *
 * 「map も filter も可能でキー変更可能かつ再帰的」というとてもマッチョな関数。
 * 複雑だが実質的には「キーも設定できる array_walk_recursive」のように振る舞う（そしてそのような使い方を想定している）。
 *
 * Example:
 * ```php
 * $array = [
 *    'k1' => 'v1',
 *    'k2' => [
 *        'k21' => 'v21',
 *        'k22' => [
 *            'k221' => 'v221',
 *            'k222' => 'v222',
 *        ],
 *        'k23' => 'v23',
 *    ],
 * ];
 * // 全要素に 'prefix-' を付与する。キーには '_' をつける。ただし 'k21' はそのままとする。さらに 'k22' はまるごと伏せる。 'k23' は数値キーになる
 * $callback = function ($k, &$v) {
 *     if ($k === 'k21') return null;
 *     if ($k === 'k22') return false;
 *     if ($k === 'k23') return true;
 *     if (!is_array($v)) $v = "prefix-$v";
 *     return "_$k";
 * };
 * that(array_convert($array, $callback, true))->isSame([
 *     '_k1' => 'prefix-v1',
 *     '_k2' => [
 *         'k21' => 'v21',
 *         0     => 'v23',
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param callable $callback 適用するコールバック
 * @param bool $apply_array 配列要素にもコールバックを適用するか
 * @return array 変換された配列
 */
function array_convert($array, $callback, $apply_array = false)
{
    $recursive = function (&$result, $array, $history, $callback) use (&$recursive, $apply_array) {
        $sequences = [];
        foreach ($array as $key => $value) {
            $is_array = is_array($value);
            $newkey = $key;
            // 配列で $apply_array あるいは非配列の場合にコールバック適用
            if (($is_array && $apply_array) || !$is_array) {
                $newkey = $callback($key, $value, $history);
            }
            // 配列は置換
            if (is_array($newkey)) {
                foreach ($newkey as $k => $v) {
                    $result[$k] = $v;
                }
                continue;
            }
            // false はスルー
            if ($newkey === false) {
                continue;
            }
            // true は数値連番
            if ($newkey === true) {
                if ($is_array) {
                    $sequences["_$key"] = $value;
                }
                else {
                    $sequences[] = $value;
                }
                continue;
            }
            // null は元のキー
            if ($newkey === null) {
                $newkey = $key;
            }
            // 配列と非配列で代入の仕方が異なる
            if ($is_array) {
                $history[] = $key;
                $result[$newkey] = [];
                $recursive($result[$newkey], $value, $history, $callback);
                array_pop($history);
            }
            else {
                $result[$newkey] = $value;
            }
        }
        // 数値連番は上書きを防ぐためにあとでやる
        foreach ($sequences as $key => $value) {
            if (is_string($key)) {
                $history[] = substr($key, 1);
                $v = [];
                $result[] = &$v;
                $recursive($v, $value, $history, $callback);
                array_pop($history);
                unset($v);
            }
            else {
                $result[] = $value;
            }
        }
    };

    $result = [];
    $recursive($result, $array, [], $callback);
    return $result;
}
