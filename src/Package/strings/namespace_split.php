<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列を名前空間とローカル名に区切ってタプルで返す
 *
 * class_namespace/class_shorten や function_shorten とほぼ同じだが下記の違いがある。
 *
 * - あくまで文字列として処理する
 *     - 例えば class_namespace は get_class されるが、この関数は（いうなれば） strval される
 * - \\ を trim しないし、特別扱いもしない
 *     - `ns\\hoge` と `\\ns\\hoge` で返り値が微妙に異なる
 *     - `ns\\` のような場合は名前空間だけを返す
 *
 * Example:
 * ```php
 * that(namespace_split('ns\\hoge'))->isSame(['ns', 'hoge']);
 * that(namespace_split('hoge'))->isSame(['', 'hoge']);
 * that(namespace_split('ns\\'))->isSame(['ns', '']);
 * that(namespace_split('\\hoge'))->isSame(['', 'hoge']);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @return array [namespace, localname]
 */
function namespace_split($string)
{
    $pos = strrpos($string, '\\');
    if ($pos === false) {
        return ['', $string];
    }
    return [substr($string, 0, $pos), substr($string, $pos + 1)];
}
