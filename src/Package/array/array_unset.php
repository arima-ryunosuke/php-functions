<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_keys_exist.php';
// @codeCoverageIgnoreEnd

/**
 * 伏せると同時にその値を返す
 *
 * $key に配列を与えると全て伏せて配列で返す。
 * その場合、$default が活きるのは「全て無かった場合」となる。
 *
 * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
 *
 * 配列を与えた場合の返り値は与えた配列の順番・キーが活きる。
 * これを利用すると list の展開の利便性が上がったり、連想配列で返すことができる。
 *
 * 同様に、$key にクロージャを与えると、その返り値が true 相当のものを伏せて配列で返す。
 * callable ではなくクロージャのみ対応する。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'b' => 'B'];
 * // ない場合は $default を返す
 * that(array_unset($array, 'x', 'X'))->isSame('X');
 * // 指定したキーを返す。そのキーは伏せられている
 * that(array_unset($array, 'a'))->isSame('A');
 * that($array)->isSame(['b' => 'B']);
 *
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * // 配列を与えるとそれらを返す。そのキーは全て伏せられている
 * that(array_unset($array, ['a', 'b', 'x']))->isSame(['A', 'B']);
 * that($array)->isSame(['c' => 'C']);
 *
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * // 配列のキーは返されるキーを表す。順番も維持される
 * that(array_unset($array, ['x2' => 'b', 'x1' => 'a']))->isSame(['x2' => 'B', 'x1' => 'A']);
 *
 * $array = ['hoge' => 'HOGE', 'fuga' => 'FUGA', 'piyo' => 'PIYO'];
 * // 値に "G" を含むものを返す。その要素は伏せられている
 * that(array_unset($array, fn($v) => strpos($v, 'G') !== false))->isSame(['hoge' => 'HOGE', 'fuga' => 'FUGA']);
 * that($array)->isSame(['piyo' => 'PIYO']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array|\ArrayAccess $array 配列
 * @param string|int|array|callable $key 伏せたいキー。配列を与えると全て伏せる。クロージャの場合は true 相当を伏せる
 * @param mixed $default 無かった場合のデフォルト値
 * @return mixed 指定したキーの値
 */
function array_unset(&$array, $key, $default = null)
{
    if (is_array($key)) {
        $result = [];
        foreach ($key as $rk => $ak) {
            if (array_keys_exist($ak, $array)) {
                $result[$rk] = $array[$ak];
                unset($array[$ak]);
            }
        }
        if (!$result) {
            // 明示的に与えられていないなら [] を使用する
            if (func_num_args() === 2) {
                $default = [];
            }
            return $default;
        }
        return $result;
    }

    if ($key instanceof \Closure) {
        $result = [];
        $n = 0;
        foreach ($array as $k => $v) {
            if ($key($v, $k, $n++)) {
                $result[$k] = $v;
                unset($array[$k]);
            }
        }
        if (!$result) {
            return $default;
        }
        return $result;
    }

    if (array_keys_exist($key, $array)) {
        $result = $array[$key];
        unset($array[$key]);
        return $result;
    }
    return $default;
}
