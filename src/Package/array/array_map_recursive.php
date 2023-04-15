<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * array_map の再帰版
 *
 * 下記の点で少し array_map とは挙動が異なる。
 *
 * - 配列だけでなく iterable も対象になる（引数で指定可能。デフォルト true）
 *     - つまりオブジェクト構造は維持されず、結果はすべて配列になる
 * - 値だけでなくキーも渡ってくる
 *
 * Example:
 * ```php
 * // デフォルトでは array_walk 等と同様に葉のみが渡ってくる（iterable も対象になる）
 * that(array_map_recursive([
 *     'k' => 'v',
 *     'c' => new \ArrayObject([
 *         'k1' => 'v1',
 *         'k2' => 'v2',
 *     ]),
 * ], 'strtoupper'))->isSame([
 *     'k' => 'V',
 *     'c' => [
 *         'k1' => 'V1',
 *         'k2' => 'V2',
 *     ],
 * ]);
 *
 * // ただし、その挙動は引数で変更可能
 * that(array_map_recursive([
 *     'k' => 'v',
 *     'c' => new \ArrayObject([
 *         'k1' => 'v1',
 *         'k2' => 'v2',
 *     ]),
 * ], 'gettype', false))->isSame([
 *     'k' => 'string',
 *     'c' => 'object',
 * ]);
 *
 * // さらに、自身にも適用できる（呼び出しは子が先で、本当の意味で「すべての要素」で呼び出される）
 * that(array_map_recursive([
 *     'k' => 'v',
 *     'c' => [
 *         'k1' => 'v1',
 *         'k2' => 'v2',
 *     ],
 * ], function ($v) {
 *     // 配列は stdclass 化、それ以外は大文字化
 *     return is_array($v) ? (object) $v : strtoupper($v);
 * }, true, true))->is((object) [
 *     'k' => 'V',
 *     'c' => (object) [
 *         'k1' => 'V1',
 *         'k2' => 'V2',
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @param bool $iterable is_iterable で判定するか
 * @param bool $apply_array 配列要素にもコールバックを適用するか
 * @return array map された新しい配列
 */
function array_map_recursive($array, $callback, $iterable = true, $apply_array = false)
{
    $callback = func_user_func_array($callback);

    // ↑の変換を再帰ごとにやるのは現実的ではないのでクロージャに閉じ込めて再帰する
    $main = static function ($array, $parent) use (&$main, $callback, $iterable, $apply_array) {
        $result = [];
        $n = 0;
        foreach ($array as $k => $v) {
            if (($iterable && is_iterable($v)) || (!$iterable && is_array($v))) {
                $result[$k] = $main($v, $k);
            }
            else {
                $result[$k] = $callback($v, $k, $n++);
            }
        }
        if ($apply_array) {
            return $callback($result, $parent, null);
        }
        return $result;
    };

    return $main($array, null);
}
