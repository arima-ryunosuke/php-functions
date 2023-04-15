<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 多階層配列をフラットに展開する
 *
 * 巷にあふれている実装と違って、 ["$pkey.$ckey" => $value] 形式の配列でも返せる。
 * $delimiter で区切り文字を指定した場合にそのようになる。
 * $delimiter = null の場合に本当の配列で返す（巷の実装と同じ）。
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
 *            'k223' => [1, 2, 3],
 *        ],
 *    ],
 * ];
 * // 区切り文字指定なし
 * that(array_flatten($array))->isSame([
 *    0 => 'v1',
 *    1 => 'v21',
 *    2 => 'v221',
 *    3 => 'v222',
 *    4 => 1,
 *    5 => 2,
 *    6 => 3,
 * ]);
 * // 区切り文字指定
 * that(array_flatten($array, '.'))->isSame([
 *    'k1'            => 'v1',
 *    'k2.k21'        => 'v21',
 *    'k2.k22.k221'   => 'v221',
 *    'k2.k22.k222'   => 'v222',
 *    'k2.k22.k223.0' => 1,
 *    'k2.k22.k223.1' => 2,
 *    'k2.k22.k223.2' => 3,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string|\Closure|null $delimiter キーの区切り文字。 null を与えると連番になる
 * @return array フラット化された配列
 */
function array_flatten($array, $delimiter = null)
{
    $result = [];
    $core = function ($array, $delimiter, $parents) use (&$core, &$result) {
        foreach ($array as $k => $v) {
            $keys = $parents;
            $keys[] = $k;
            if (is_iterable($v)) {
                $core($v, $delimiter, $keys);
            }
            else {
                if ($delimiter === null) {
                    $result[] = $v;
                }
                elseif ($delimiter instanceof \Closure) {
                    $result[$delimiter($keys)] = $v;
                }
                else {
                    $result[implode($delimiter, $keys)] = $v;
                }
            }
        }
    };

    $core($array, $delimiter, []);
    return $result;
}
