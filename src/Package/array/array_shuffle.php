<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * shuffle のキーが保存される＋参照渡しではない版
 *
 * Example:
 * ```php
 * that(array_shuffle(['a' => 'A', 'b' => 'B', 'c' => 'C']))->is(['b' => 'B', 'a' => 'A', 'c' => 'C']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @return array shuffle された配列
 */
function array_shuffle($array)
{
    $keys = array_keys($array);
    shuffle($keys);

    $result = [];
    foreach ($keys as $key) {
        $result[$key] = $array[$key];
    }
    return $result;
}
