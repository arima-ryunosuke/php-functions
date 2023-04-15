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
    $result = [];
    foreach ($array as $k => $v) {
        $match = preg_match($regex, $k);
        if ((!$not && $match) || ($not && !$match)) {
            $result[$k] = $v;
        }
    }
    return $result;
}
