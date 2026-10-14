<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_hasharray.php';
// @codeCoverageIgnoreEnd

/**
 * 多階層配列をフラットに展開する
 *
 * 巷にあふれている実装と違って、 ["$pkey.$ckey" => $value] 形式の配列でも返せる。
 * $delimiter で区切り文字を指定した場合にそのようになる。
 * $delimiter = null の場合に本当の配列で返す（巷の実装と同じ）。
 * $delimiter に bool を与えると preserve_keys 的な動きになる。
 * - true: 数値キーをできるだけ維持する
 * - false: 数値キーを完全に振りなおす
 *
 * Example:
 * ```php
 * $array = [
 *     'k1' => 'v1',
 *     'k2' => [
 *         'k21' => 'v21',
 *         'k22' => [
 *             'k221' => 'v221',
 *             'k222' => 'v222',
 *             'k223' => [1 => 1, 2, 3],
 *         ],
 *     ],
 * ];
 * // 区切り文字指定なし
 * that(array_flatten($array))->isSame([
 *     0 => 'v1',
 *     1 => 'v21',
 *     2 => 'v221',
 *     3 => 'v222',
 *     4 => 1,
 *     5 => 2,
 *     6 => 3,
 * ]);
 * // 区切り文字指定
 * that(array_flatten($array, '.'))->isSame([
 *     'k1'            => 'v1',
 *     'k2.k21'        => 'v21',
 *     'k2.k22.k221'   => 'v221',
 *     'k2.k22.k222'   => 'v222',
 *     'k2.k22.k223.1' => 1,
 *     'k2.k22.k223.2' => 2,
 *     'k2.k22.k223.3' => 3,
 * ]);
 * // true 指定（連番キーをなるべく維持）
 * that(array_flatten($array, true))->isSame([
 *     'k1'   => 'v1',
 *     'k21'  => 'v21',
 *     'k221' => 'v221',
 *     'k222' => 'v222',
 *     1      => 1,
 *     2      => 2,
 *     3      => 3,
 * ]);
 * // false 指定（連番キーを振り直し）
 * that(array_flatten($array, false))->isSame([
 *    'k1'   => 'v1',
 *    'k21'  => 'v21',
 *    'k221' => 'v221',
 *    'k222' => 'v222',
 *    0      => 1,
 *    1      => 2,
 *    2      => 3,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string|bool|\Closure|null $delimiter キーの区切り文字。 null を与えると連番になる
 * @param bool $iterable is_iterable で再帰判定するか
 * @return array フラット化された配列
 */
function array_flatten($array, $delimiter = null, bool $iterable = true)
{
    $result = [];
    $core = function ($array, $parents) use (&$core, &$result, $delimiter, $iterable) {
        $array_is_list = null;
        foreach ($array as $k => $v) {
            $keys = $parents;
            $keys[] = $k;
            if (($iterable && is_iterable($v)) || (!$iterable && is_array($v))) {
                $core($v, $keys);
            }
            else {
                $delimiter2 = $delimiter;
                if ($delimiter2 instanceof \Closure) {
                    $delimiter2 = $delimiter2($keys);
                }

                $newkey = null;
                if ($delimiter2 === null) {
                    // do nothing
                }
                elseif ($delimiter2 === true) {
                    $array_is_list ??= is_array($array) && !is_hasharray($array);
                    if (is_string($k) || !$array_is_list) {
                        $newkey = $k;
                    }
                }
                elseif ($delimiter2 === false) {
                    if (is_string($k)) {
                        $newkey = $k;
                    }
                }
                else {
                    if ($delimiter2 !== $delimiter) {
                        $newkey = $delimiter2;
                    }
                    else {
                        $newkey = implode($delimiter2, $keys);
                    }
                }

                if ($newkey === null) {
                    $result[] = $v;
                }
                else {
                    assert(!array_key_exists($newkey, $result)); // for compatible. change to throw in future scope
                    $result[$newkey] = $v;
                }
            }
        }
    };

    $core($array, []);
    return $result;
}
