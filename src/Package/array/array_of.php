<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_get.php';
// @codeCoverageIgnoreEnd

/**
 * 配列を与えると指定キーの値を返すクロージャを返す
 *
 * 存在しない場合は $default を返す。
 *
 * $key に配列を与えるとそれらの値の配列を返す（lookup 的な動作）。
 * その場合、$default が活きるのは「全て無かった場合」となる。
 * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
 *
 * Example:
 * ```php
 * $fuga_of_array = array_of('fuga');
 * that($fuga_of_array(['hoge' => 'HOGE', 'fuga' => 'FUGA']))->isSame('FUGA');
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param string|int|array $key 取得したいキー
 * @param mixed $default デフォルト値
 * @return \Closure $key の値を返すクロージャ
 */
function array_of($key, $default = null)
{
    $nodefault = func_num_args() === 1;
    return fn(array $array) => $nodefault ? array_get($array, $key) : array_get($array, $key, $default);
}
