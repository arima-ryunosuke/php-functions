<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../math/int_divide.php';
// @codeCoverageIgnoreEnd

/**
 * array_chunk の配列長指定版
 *
 * Example:
 * ```php
 * // ['A', 'B', 'C', 'D', 'E', 'F', 'G'] を3つに分割（余りを左に分配）
 * that(array_divide(['A', 'B', 'C', 'D', 'E', 'F', 'G'], 3))->isSame([
 *     ["A", "B", "C"],
 *     ["D", "E"],
 *     ["F", "G"],
 * ]);
 * // ['A', 'B', 'C', 'D', 'E', 'F', 'G'] を3つに分割（余りを右に分配）
 * that(array_divide(['A', 'B', 'C', 'D', 'E', 'F', 'G'], -3))->isSame([
 *     ["A", "B"],
 *     ["C", "D"],
 *     ["E", "F", "G"],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 */
function array_divide(iterable $array, int $divisor, bool $preserve_keys = false): array
{
    $array = is_array($array) ? $array : iterator_to_array($array);

    $last = 0;
    $result = [];
    foreach (int_divide(count($array), $divisor) as $int) {
        $result[] = array_slice($array, $last, $int, $preserve_keys);
        $last += $int;
    }

    return $result;
}
