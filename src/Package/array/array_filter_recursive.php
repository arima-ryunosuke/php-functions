<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
require_once __DIR__ . '/../var/is_arrayable.php';
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * 再帰的に array_filter する
 *
 * 要素が配列だった場合に再帰する点とコールバックの引数以外は array_filter とほとんど変わらない。
 * $callback が要求するならキーも渡ってくる。
 *
 * $unset_empty:true だと再帰で伏せられた結果が空になった場合、そのキーも伏せられる。
 *
 * Example:
 * ```php
 * $array = [
 *     'a'  => 'A', // 生き残る
 *     'e'  => '',  // 生き残らない
 *     'a1' => [    // A がいるため $unset_empty は無関係に a1 自体も生き残る
 *         'A', // 生き残る
 *         '',  // 生き残らない
 *     ],
 *     'a2' => [    // 生き残りが居ないため $unset_empty:true だと a2 自体も生き残らない
 *         '',  // 生き残らない
 *         '',  // 生き残らない
 *     ],
 *     'b1' => [    // a1 のネスト版
 *         'a' => [
 *             'a' => 'A',
 *             'e' => '',
 *         ],
 *     ],
 *     'b2' => [    // a2 のネスト版
 *         'a' => [
 *             'a' => '',
 *             'e' => '',
 *         ],
 *     ],
 * ];
 * // 親を伏せない版
 * that(array_filter_recursive($array, fn($v) => strlen($v), false))->isSame([
 *     "a"  => "A",
 *     "a1" => ["A"],
 *     "a2" => [],
 *     "b1" => [
 *         "a" => [
 *             "a" => "A",
 *         ],
 *     ],
 *     "b2" => [
 *         "a" => [],
 *     ],
 * ]);
 * // 親を伏せる版
 * that(array_filter_recursive($array, fn($v) => strlen($v), true))->isSame([
 *     "a"  => "A",
 *     "a1" => ["A"],
 *     "b1" => [
 *         "a" => [
 *             "a" => "A",
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @template T as iterable&\ArrayAccess
 */
function array_filter_recursive(
    /** @var T 対象配列 */ iterable $array,
    /** 評価クロージャ（値, キー, 親キー配列） */ callable $callback,
    /** 再帰の際に空になった要素も伏せるか */ bool $unset_empty = true,
): /** フィルタされた配列 */ iterable
{
    $callback = func_user_func_array($callback);

    $main = function ($array, $parents) use (&$main, $callback, $unset_empty) {
        // オブジェクトによっては活きたイテレータなのでループ内で unset することはできず、あらかじめ集めておく必要がある（ArrayObject 等）
        $keys = [];
        foreach ($array as $k => $v) {
            $keys[] = $k;
        }

        foreach ($keys as $k) {
            if (is_iterable($array[$k]) && is_arrayable($array[$k])) {
                $array[$k] = $main($array[$k], array_merge($parents, [$k]));
                if ($unset_empty && is_empty($array[$k])) {
                    unset($array[$k]);
                }
            }
            else {
                if (!$callback($array[$k], $k, $parents)) {
                    unset($array[$k]);
                }
            }
        }
        return $array;
    };
    return $main($array, []);
}
