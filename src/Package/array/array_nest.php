<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * シンプルな [キー => 値] な配列から階層配列を生成する
 *
 * 定義的に array_flatten の逆関数のような扱いになる。
 * $delimiter で階層を表現する。
 *
 * 同名とみなされるキーは上書きされるか例外が飛ぶ。具体的には Example を参照。
 *
 * Example:
 * ```php
 * // 単純な階層展開
 * $array = [
 *    'k1'            => 'v1',
 *    'k2.k21'        => 'v21',
 *    'k2.k22.k221'   => 'v221',
 *    'k2.k22.k222'   => 'v222',
 *    'k2.k22.k223.0' => 1,
 *    'k2.k22.k223.1' => 2,
 *    'k2.k22.k223.2' => 3,
 * ];
 * that(array_nest($array))->isSame([
 *    'k1' => 'v1',
 *    'k2' => [
 *        'k21' => 'v21',
 *        'k22' => [
 *            'k221' => 'v221',
 *            'k222' => 'v222',
 *            'k223' => [1, 2, 3],
 *        ],
 *    ],
 * ]);
 * // 同名になるようなキーは上書きされる
 * $array = [
 *    'k1.k2' => 'v1', // この時点で 'k1' は配列になるが・・・
 *    'k1'    => 'v2', // この時点で 'k1' は文字列として上書きされる
 * ];
 * that(array_nest($array))->isSame([
 *    'k1' => 'v2',
 * ]);
 * // 上書きすら出来ない場合は例外が飛ぶ
 * $array = [
 *    'k1'    => 'v1', // この時点で 'k1' は文字列になるが・・・
 *    'k1.k2' => 'v2', // この時点で 'k1' にインデックスアクセスすることになるので例外が飛ぶ
 * ];
 * try {
 *     array_nest($array);
 * }
 * catch (\Exception $e) {
 *     that($e)->isInstanceOf(\InvalidArgumentException::class);
 * }
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string $delimiter キーの区切り文字
 * @return array 階層化された配列
 */
function array_nest($array, $delimiter = '.')
{
    $result = [];
    foreach ($array as $k => $v) {
        $keys = explode($delimiter, $k);
        $rkeys = [];
        $tmp = &$result;
        foreach ($keys as $key) {
            $rkeys[] = $key;
            if (isset($tmp[$key]) && !is_array($tmp[$key])) {
                throw new \InvalidArgumentException("'" . implode($delimiter, $rkeys) . "' of '$k' is already exists.");
            }
            $tmp = &$tmp[$key];
        }
        $tmp = $v;
        unset($tmp);
    }
    return $result;
}
