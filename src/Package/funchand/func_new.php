<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 指定クラスのコンストラクタを呼び出すクロージャを返す
 *
 * この関数を呼ぶとコンストラクタのクロージャを返す。
 *
 * オプションでデフォルト引数を設定できる（Example を参照）。
 *
 * Example:
 * ```php
 * // Exception のコンストラクタを呼ぶクロージャ
 * $newException = func_new(\Exception::class, 'hoge');
 * // デフォルト引数を使用して Exception を作成
 * that($newException()->getMessage())->isSame('hoge');
 * // 引数を指定して Exception を作成
 * that($newException('fuga')->getMessage())->isSame('fuga');
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param string $classname クラス名
 * @param mixed ...$defaultargs コンストラクタのデフォルト引数
 * @return \Closure コンストラクタを呼び出すクロージャ
 */
function func_new($classname, ...$defaultargs)
{
    return fn(...$args) => new $classname(...$args + $defaultargs);
}
