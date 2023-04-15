<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/kvsort.php';
require_once __DIR__ . '/../var/varcmp.php';
// @codeCoverageIgnoreEnd

/**
 * 連続した数値の配列を縮めて返す
 *
 * 例えば `[1, 2, 4, 6, 7, 9]` が `['1~2', 4, '6~7', 9]` になる。
 * 結合法則は指定可能（上記は "~" を指定したもの）。
 * null を与えると配列の配列で返すことも可能。
 *
 * Example:
 * ```php
 * // 単純に文字列指定
 * that(number_serial([1, 2, 4, 6, 7, 9], 1, '~'))->is(['1~2', 4, '6~7', 9]);
 * // null を与えると from, to の配列で返す
 * that(number_serial([1, 2, 4, 6, 7, 9], 1, null))->is([[1, 2], [4, 4], [6, 7], [9, 9]]);
 * // $step は負数・小数・逆順も対応している（正負でよしなにソートされる）
 * that(number_serial([-9, 0.2, 0.5, -0.3, 0.1, 0, -0.2, 9], -0.1, '~'))->is([9, 0.5, '0.2~0', '-0.2~-0.3', -9]);
 * ```
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param iterable|array $numbers 数値配列
 * @param int|float $step 連続とみなすステップ。負数を指定すれば逆順指定にも使える
 * @param string|null|\Closure $separator 連続列を結合する文字列（string: 文字結合、null: 配列、Closure: 2引数が渡ってくる）
 * @param bool $doSort ソートをするか否か。事前にソート済みであることが明らかであれば false の方が良い
 * @return array 連続値をまとめた配列
 */
function number_serial($numbers, $step = 1, $separator = null, $doSort = true)
{
    $precision = ini_get('precision');
    $step = $step + 0;

    if ($doSort) {
        $numbers = kvsort($numbers, $step < 0 ? -SORT_NUMERIC : SORT_NUMERIC);
    }

    $build = function ($from, $to) use ($separator, $precision) {
        if ($separator instanceof \Closure) {
            return $separator($from, $to);
        }
        if (varcmp($from, $to, SORT_NUMERIC, $precision) === 0) {
            if ($separator === null) {
                return [$from, $to];
            }
            return $from;
        }
        elseif ($separator === null) {
            return [$from, $to];
        }
        else {
            return $from . $separator . $to;
        }
    };

    $result = [];
    foreach ($numbers as $number) {
        $number = $number + 0;
        if (!isset($from, $to)) {
            $from = $to = $number;
            continue;
        }
        if (varcmp($to + $step, $number, SORT_NUMERIC, $precision) !== 0) {
            $result[] = $build($from, $to);
            $from = $number;
        }
        $to = $number;
    }
    if (isset($from, $to)) {
        $result[] = $build($from, $to);
    }

    return $result;
}
