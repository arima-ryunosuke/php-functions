<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 全要素に対して array_column する
 *
 * 行列が逆転するイメージ。
 *
 * Example:
 * ```php
 * $row1 = ['id' => 1, 'name' => 'A'];
 * $row2 = ['id' => 2, 'name' => 'B'];
 * $rows = [$row1, $row2];
 * that(array_columns($rows))->isSame(['id' => [1, 2], 'name' => ['A', 'B']]);
 * that(array_columns($rows, 'id'))->isSame(['id' => [1, 2]]);
 * that(array_columns($rows, 'name', 'id'))->isSame(['name' => [1 => 'A', 2 => 'B']]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param string|array|null $column_keys 引っ張ってくるキー名
 * @param mixed $index_key 新しい配列のキーとなるキー名
 * @return array 新しい配列
 */
function array_columns($array, $column_keys = null, $index_key = null)
{
    if (count($array) === 0 && $column_keys === null) {
        throw new \InvalidArgumentException("can't auto detect keys.");
    }

    if ($column_keys === null) {
        $column_keys = array_keys(reset($array));
    }

    $result = [];
    foreach ((array) $column_keys as $key) {
        $result[$key] = array_column($array, $key, $index_key);
    }
    return $result;
}
