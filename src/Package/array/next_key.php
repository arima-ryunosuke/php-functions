<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列の指定キーの次のキーを返す
 *
 * $key が最後のキーだった場合は null を返す。
 * $key が存在しない場合は false を返す。
 * $key が未指定だと「次に生成されるキー」（$array[]='hoge' で生成されるキー）を返す。
 *
 * $array[] = 'hoge' で作成されるキーには完全準拠しない（標準は unset すると結構乱れる）。公式マニュアルを参照。
 *
 * Example:
 * ```php
 * $array = [9 => 9, 'a' => 'A', 'b' => 'B', 'c' => 'C'];
 * // 'b' キーの次は 'c'
 * that(next_key($array, 'b'))->isSame('c');
 * // 'c' キーの次は無いので null
 * that(next_key($array, 'c'))->isSame(null);
 * // 'x' キーはそもそも存在しないので false
 * that(next_key($array, 'x'))->isSame(false);
 * // 次に生成されるキーは 10
 * that(next_key($array, null))->isSame(10);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param string|int|null $key 調べるキー
 * @return string|int|bool|null $key の次のキー
 */
function next_key($array, $key = null)
{
    $keynull = $key === null;
    $key = (string) $key;
    $current = false;
    $max = -1;
    foreach ($array as $k => $v) {
        if ($current !== false) {
            return $k;
        }
        if ($key === (string) $k) {
            $current = null;
        }
        if ($keynull && is_int($k) && $k > $max) {
            $max = $k;
        }
    }
    if ($keynull) {
        // PHP 4.3.0 以降は0以下にはならない
        return max(0, $max + 1);
    }
    else {
        return $current;
    }
}
