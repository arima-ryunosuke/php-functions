<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * array_replace のコールバック版
 *
 * 基本的なルールは array_replace と全く同じ（連番の扱いや後方優先など）。
 * 値が重複している場合に重複している配列でコールバックが呼ばれる。
 *
 * コールバックの引数は($重複値配列, $そのキー)であり、$重複値配列には重複しなかった配列の値は含まれない。
 * ただし、キーは維持されるので歯抜けになっていたり、あるべきキーが無かったりを調べればどれとどれが重複ししていたの判定が可能。
 * もっとも、普通の使用（2引数の配列）では両方に値が入ってくるという前提で問題ない。
 *
 * Example:
 * ```php
 * $a1 = [
 *     'a' => 'a1',
 *     'b' => 'b1',
 *     'c' => 'c1',
 *     'x' => 'x1',
 * ];
 * $a2 = [
 *     'a' => 'a2',
 *     'b' => 'b2',
 *     'y' => 'y2',
 * ];
 * $a3 = [
 *     'a' => 'a3',
 *     'c' => 'c3',
 *     'z' => 'z3',
 * ];
 * that(array_replace_callback(fn($args, $k) => "$k:" . json_encode($args), $a1, $a2, $a3))->isSame([
 *     "a" => 'a:["a1","a2","a3"]',    // 全てに存在するので3つ全てが渡ってくる
 *     "b" => 'b:["b1","b2"]',         // 1,2 に存在するので2つ渡ってくる
 *     "c" => 'c:{"0":"c1","2":"c3"}', // 1,3 に存在するので2つ渡ってくる（2が歯抜けになる）
 *     "x" => 'x1', // 重複していないのでコールバック自体が呼ばれない
 *     "y" => 'y2', // 重複していないのでコールバック自体が呼ばれない
 *     "z" => 'z3', // 重複していないのでコールバック自体が呼ばれない
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param callable $callback 重複コールバック
 * @param array ...$arrays マージする配列
 * @return array マージされた配列
 */
function array_replace_callback(callable $callback, array ...$arrays)
{
    $callback = func_user_func_array($callback);

    // まず普通に呼んで・・・
    $result = array_replace(...$arrays);

    // 重複値をコールバックすれば順番も乱れずシンプルに上書きできる
    foreach ($result as $k => $v) {
        $duplicated = [];
        foreach ($arrays as $n => $array) {
            if (array_key_exists($k, $array)) {
                $duplicated[$n] = $array[$k];
            }
        }
        if (count($duplicated) > 1) {
            $result[$k] = $callback($duplicated, $k);
        }
    }
    return $result;
}
