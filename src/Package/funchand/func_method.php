<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 指定メソッドを呼び出すクロージャを返す
 *
 * この関数を呼ぶとメソッドのクロージャを返す。
 * そのクロージャにオブジェクトを与えて呼び出すとそれはメソッド呼び出しとなる。
 *
 * オプションでデフォルト引数を設定できる（Example を参照）。
 *
 * Example:
 * ```php
 * // 与えられた引数を結合して返すメソッド hoge を持つクラス
 * $object = new class()
 * {
 *     function hoge(...$args) { return implode(',', $args); }
 * };
 * // hoge を呼び出すクロージャ
 * $hoge = func_method('hoge');
 * // ↑を使用して $object の hoge を呼び出す
 * that($hoge($object, 1, 2, 3))->isSame('1,2,3');
 *
 * // デフォルト値付きで hoge を呼び出すクロージャ
 * $hoge789 = func_method('hoge', 7, 8, 9);
 * // ↑を使用して $object の hoge を呼び出す（引数指定してるので結果は同じ）
 * that($hoge789($object, 1, 2, 3))->isSame('1,2,3');
 * // 同上（一部デフォルト値）
 * that($hoge789($object, 1, 2))->isSame('1,2,9');
 * // 同上（全部デフォルト値）
 * that($hoge789($object))->isSame('7,8,9');
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param string $methodname メソッド名
 * @param mixed ...$defaultargs メソッドのデフォルト引数
 * @return \Closure メソッドを呼び出すクロージャ
 */
function func_method($methodname, ...$defaultargs)
{
    if ($methodname === '__construct') {
        return fn($object, ...$args) => new $object(...$args + $defaultargs);
    }
    return fn($object, ...$args) => ([$object, $methodname])(...$args + $defaultargs);
}
