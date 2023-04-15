<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の指定キーの前のキーを返す
 *
 * $key が最初のキーだった場合は null を返す。
 * $key が存在しない場合は false を返す。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * // 'b' キーの前は 'a'
 * that(prev_key($array, 'b'))->isSame('a');
 * // 'a' キーの前は無いので null
 * that(prev_key($array, 'a'))->isSame(null);
 * // 'x' キーはそもそも存在しないので false
 * that(prev_key($array, 'x'))->isSame(false);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param string|int $key 調べるキー
 * @return string|int|bool|null $key の前のキー
 */
function prev_key($array, $key)
{
    $key = (string) $key;
    $current = null;
    foreach ($array as $k => $v) {
        if ($key === (string) $k) {
            return $current;
        }
        $current = $k;
    }
    return false;
}
