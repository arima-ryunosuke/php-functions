<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_primitive.php';
// @codeCoverageIgnoreEnd

/**
 * array キャストの関数版
 *
 * intval とか strval とかの array 版。
 * ただキャストするだけだが、関数なのでコールバックとして使える。
 *
 * $recursive を true にすると再帰的に適用する（デフォルト）。
 * 入れ子オブジェクトを配列化するときなどに使える。
 *
 * Example:
 * ```php
 * // キャストなので基本的には配列化される
 * that(arrayval(123))->isSame([123]);
 * that(arrayval('str'))->isSame(['str']);
 * that(arrayval([123]))->isSame([123]); // 配列は配列のまま
 *
 * // $recursive = false にしない限り再帰的に適用される
 * $stdclass = (object) ['key' => 'val'];
 * that(arrayval([$stdclass], true))->isSame([['key' => 'val']]); // true なので中身も配列化される
 * that(arrayval([$stdclass], false))->isSame([$stdclass]);       // false なので中身は変わらない
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var array 化する値
 * @param bool $recursive 再帰的に行うなら true
 * @return array array 化した配列
 */
function arrayval($var, $recursive = true)
{
    // return json_decode(json_encode($var), true);

    // 無駄なループを回したくないので非再帰で配列の場合はそのまま返す
    if (!$recursive && is_array($var)) {
        return $var;
    }

    if (is_primitive($var)) {
        return (array) $var;
    }

    $result = [];
    foreach ($var as $k => $v) {
        if ($recursive && !is_primitive($v)) {
            $v = arrayval($v, $recursive);
        }
        $result[$k] = $v;
    }
    return $result;
}
