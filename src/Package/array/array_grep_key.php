<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * キーを正規表現でフィルタする
 *
 * Example:
 * ```php
 * that(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#'))->isSame(['a' => 'A', 'aa' => 'AA']);
 * that(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#', true))->isSame(['b' => 'B']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string $regex 正規表現
 * @param bool $not true にすると「マッチしない」でフィルタする
 * @return array 正規表現でフィルタされた配列
 */
function array_grep_key($array, $regex, $not = false)
{
    $array = is_array($array) ? $array : iterator_to_array($array);
    $keys = array_keys($array);
    $greped = preg_grep($regex, $keys, $not ? PREG_GREP_INVERT : 0);
    $flipped = array_flip($greped);
    return array_intersect_key($array, $flipped);
}
