<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * キーと値で sprintf する
 *
 * 配列の各要素を文字列化して返すイメージ。
 * $glue を与えるとさらに implode して返す（返り値が文字列になる）。
 *
 * $format は書式文字列（$v, $k）。
 * callable を与えると sprintf ではなくコールバック処理になる（$v, $k）。
 * 省略（null）するとキーを format 文字列、値を引数として **vsprintf** する。
 *
 * Example:
 * ```php
 * $array = ['key1' => 'val1', 'key2' => 'val2'];
 * // key, value を利用した sprintf
 * that(array_sprintf($array, '%2$s=%1$s'))->isSame(['key1=val1', 'key2=val2']);
 * // 第3引数を与えるとさらに implode される
 * that(array_sprintf($array, '%2$s=%1$s', ' '))->isSame('key1=val1 key2=val2');
 * // クロージャを与えるとコールバック動作になる
 * $closure = fn($v, $k) => "$k=" . strtoupper($v);
 * that(array_sprintf($array, $closure, ' '))->isSame('key1=VAL1 key2=VAL2');
 * // 省略すると vsprintf になる
 * that(array_sprintf([
 *     'str:%s,int:%d' => ['sss', '3.14'],
 *     'single:%s'     => 'str',
 * ], null, '|'))->isSame('str:sss,int:3|single:str');
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string|callable|null $format 書式文字列あるいはクロージャ
 * @param ?string $glue 結合文字列。未指定時は implode しない
 * @return array|string sprintf された配列
 */
function array_sprintf($array, $format = null, $glue = null)
{
    if (is_callable($format)) {
        $callback = func_user_func_array($format);
    }
    elseif ($format === null) {
        $callback = fn($v, $k, $n) => vsprintf($k, is_array($v) ? $v : [$v]);
    }
    else {
        $callback = fn($v, $k, $n) => sprintf($format, $v, $k);
    }

    $result = [];
    $n = 0;
    foreach ($array as $k => $v) {
        $result[] = $callback($v, $k, $n++);
    }

    if ($glue !== null) {
        return implode($glue, $result);
    }

    return $result;
}
