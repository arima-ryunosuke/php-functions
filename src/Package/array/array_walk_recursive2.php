<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * array_walk_recursive の改善版
 *
 * 違いは下記。
 *
 * - 第3引数はなし
 *     - クロージャの use で十分だしそちらの方が優れている
 * - コールバックは ($value, $key, $array, $keys) が渡ってくる
 *     - $value, $array はリファレンスにすることで書き換え可能
 * - 返り値で返す
 *     - 元の array_walk_recursive の返り値はほとんど意味がない
 *     - 返り値が空いてるなら変に参照を使わず返り値の方がシンプル
 *
 * array_walk_recursive で「この要素は伏せたいのに…」「このノードだけ触りたいのに…」ということはままあるが、
 * - $array が渡ってくるので unset したり他のキーを生やしたりすることが可能
 * - $keys が渡ってくるのでツリー構造の特定のノードだけ触ることが可能
 * になっている。
 *
 * 「map も filter も可能」という少しマッチョな関数。
 * 実質的には「再帰的な array_kvmap」のように振る舞う。
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param callable $callback コールバック
 * @return array walk 後の配列
 */
function array_walk_recursive2($array, $callback)
{
    $callback = func_user_func_array($callback);

    $main = function (&$array, $keys) use (&$main, $callback) {
        foreach ($array as $k => &$v) {
            if (is_array($v)) {
                $main($v, array_merge($keys, [$k]));
            }
            else {
                $callback($v, $k, $array, $keys);
            }
        }
    };
    $main($array, []);
    return $array;
}
