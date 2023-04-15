<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * キーをマップ配列・callable で置換する
 *
 * 変換先・返り値が null だとその要素は取り除かれる。
 * callable 指定時の引数は `(キー, 値, 連番インデックス, 対象配列そのもの)` が渡ってくる。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * // a は x に c は z に置換される
 * that(array_rekey($array, ['a' => 'x', 'c' => 'z']))->isSame(['x' => 'A', 'b' => 'B', 'z' => 'C']);
 * // b は削除され c は z に置換される
 * that(array_rekey($array, ['b' => null, 'c' => 'z']))->isSame(['a' => 'A', 'z' => 'C']);
 * // キーの交換にも使える（a ⇔ c）
 * that(array_rekey($array, ['a' => 'c', 'c' => 'a']))->isSame(['c' => 'A', 'b' => 'B', 'a' => 'C']);
 * // callable
 * that(array_rekey($array, 'strtoupper'))->isSame(['A' => 'A', 'B' => 'B', 'C' => 'C']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param array|callable $keymap マップ配列かキーを返すクロージャ
 * @return array キーが置換された配列
 */
function array_rekey($array, $keymap)
{
    // 互換性のため callable は配列以外に限定する
    $callable = ($keymap instanceof \Closure) || (!is_array($keymap) && is_callable($keymap));
    if ($callable) {
        $keymap = func_user_func_array($keymap);
    }

    $result = [];
    $n = 0;
    foreach ($array as $k => $v) {
        if ($callable) {
            $k = $keymap($k, $v, $n, $array);
            // null は突っ込まない（除去）
            if ($k !== null) {
                $result[$k] = $v;
            }
        }
        elseif (array_key_exists($k, $keymap)) {
            // null は突っ込まない（除去）
            if ($keymap[$k] !== null) {
                $result[$keymap[$k]] = $v;
            }
        }
        else {
            $result[$k] = $v;
        }
        $n++;
    }
    return $result;
}
