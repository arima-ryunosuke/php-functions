<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_assort.php';
// @codeCoverageIgnoreEnd

/**
 * 配列の差分を取り配列で返す
 *
 * 返り値の配列は構造化されたデータではない。
 * 主に文字列化して出力することを想定している。
 *
 * ユースケースとしては「スキーマデータ」「各環境の設定ファイル」などの差分。
 *
 * - '+' はキーが追加されたことを表す
 * - '-' はキーが削除されたことを表す
 * - 両方が含まれている場合、値の変更を表す
 *
 * 数値キーはキーの比較は行われない。値の差分のみ返す。
 *
 * Example:
 * ```php
 * // common は 中身に差分がある。 1 に key1 はあるが、 2 にはない。2 に key2 はあるが、 1 にはない。
 * that(array_difference([
 *     'common' => [
 *         'sub' => [
 *             'x' => 'val',
 *         ]
 *     ],
 *     'key1'   => 'hoge',
 *     'array'  => ['a', 'b', 'c'],
 * ], [
 *     'common' => [
 *         'sub' => [
 *             'x' => 'VAL',
 *         ]
 *     ],
 *     'key2'   => 'fuga',
 *     'array'  => ['c', 'd', 'e'],
 * ]))->isSame([
 *     'common.sub.x' => ['-' => 'val', '+' => 'VAL'],
 *     'key1'         => ['-' => 'hoge'],
 *     'array'        => ['-' => ['a', 'b'], '+' => ['d', 'e']],
 *     'key2'         => ['+' => 'fuga'],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array1 対象配列1
 * @param iterable $array2 対象配列2
 * @param string $delimiter 差分配列のキー区切り文字
 * @return array 差分を表す配列
 */
function array_difference($array1, $array2, $delimiter = '.')
{
    $rule = [
        'list' => static fn($v, $k) => is_int($k),
        'hash' => static fn($v, $k) => !is_int($k),
    ];

    $udiff = static fn($a, $b) => $a <=> $b;

    return call_user_func($f = static function ($array1, $array2, $key = null) use (&$f, $rule, $udiff, $delimiter) {
        $result = [];

        $array1 = array_assort($array1, $rule);
        $array2 = array_assort($array2, $rule);

        $list1 = array_values(array_udiff($array1['list'], $array2['list'], $udiff));
        $list2 = array_values(array_udiff($array2['list'], $array1['list'], $udiff));
        for ($k = 0, $l = max(count($list1), count($list2)); $k < $l; $k++) {
            $exists1 = array_key_exists($k, $list1);
            $exists2 = array_key_exists($k, $list2);

            $v1 = $exists1 ? $list1[$k] : null;
            $v2 = $exists2 ? $list2[$k] : null;

            $prefix = $key === null ? count($result) : $key;
            if ($exists1) {
                $result[$prefix]['-'][] = $v1;
            }
            if ($exists2) {
                $result[$prefix]['+'][] = $v2;
            }
        }

        $hash1 = array_udiff_assoc($array1['hash'], $array2['hash'], $udiff);
        $hash2 = array_udiff_assoc($array2['hash'], $array1['hash'], $udiff);
        foreach (array_keys($hash1 + $hash2) as $k) {
            $exists1 = array_key_exists($k, $hash1);
            $exists2 = array_key_exists($k, $hash2);

            $v1 = $exists1 ? $hash1[$k] : null;
            $v2 = $exists2 ? $hash2[$k] : null;

            $prefix = $key === null ? $k : $key . $delimiter . $k;
            if (is_array($v1) && is_array($v2)) {
                $result += $f($v1, $v2, $prefix);
                continue;
            }
            if ($exists1) {
                $result[$prefix]['-'] = $v1;
            }
            if ($exists2) {
                $result[$prefix]['+'] = $v2;
            }
        }

        return $result;
    }, $array1, $array2);
}
