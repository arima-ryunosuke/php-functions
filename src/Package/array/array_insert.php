<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列・連想配列を問わず任意の位置に値を挿入する
 *
 * $position を省略すると最後に挿入される（≒ array_push）。
 * $position に負数を与えると後ろから数えられる。
 * $value には配列も与えられるが、その場合数値キーは振り直される
 *
 * Example:
 * ```php
 * that(array_insert([1, 2, 3], 'x'))->isSame([1, 2, 3, 'x']);
 * that(array_insert([1, 2, 3], 'x', 1))->isSame([1, 'x', 2, 3]);
 * that(array_insert([1, 2, 3], 'x', -1))->isSame([1, 2, 'x', 3]);
 * that(array_insert([1, 2, 3], ['a' => 'A', 'b' => 'B'], 1))->isSame([1, 'a' => 'A', 'b' => 'B', 2, 3]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param mixed $value 挿入値
 * @param int|null $position 挿入位置
 * @return array 挿入された新しい配列
 */
function array_insert($array, $value, $position = null)
{
    if (!is_array($value)) {
        $value = [$value];
    }

    $position = is_null($position) ? count($array) : intval($position);

    $sarray = array_splice($array, 0, $position);
    return array_merge($sarray, $value, $array);
}
