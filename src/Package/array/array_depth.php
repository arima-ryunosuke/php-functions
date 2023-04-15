<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の次元数を返す
 *
 * フラット配列は 1 と定義する。
 * つまり、配列を与える限りは 0 以下を返すことはない。
 *
 * 第2引数 $max_depth を与えるとその階層になった時点で走査を打ち切る。
 * 「1階層のみか？」などを調べるときは指定したほうが高速に動作する。
 *
 * Example:
 * ```php
 * that(array_depth([]))->isSame(1);
 * that(array_depth(['hoge']))->isSame(1);
 * that(array_depth([['nest1' => ['nest2']]]))->isSame(3);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 調べる配列
 * @param int|null $max_depth 最大階層数
 * @return int 次元数。素のフラット配列は 1
 */
function array_depth($array, $max_depth = null)
{
    assert((is_null($max_depth)) || $max_depth > 0);

    $main = function ($array, $depth) use (&$main, $max_depth) {
        // $max_depth を超えているなら打ち切る
        if ($max_depth !== null && $depth >= $max_depth) {
            return 1;
        }

        // 配列以外に興味はない
        $arrays = array_filter($array, 'is_array');

        // ネストしない配列は 1 と定義
        if (!$arrays) {
            return 1;
        }

        // 配下の内で最大を返す
        return 1 + max(array_map(fn($v) => $main($v, $depth + 1), $arrays));
    };

    return $main($array, 1);
}
