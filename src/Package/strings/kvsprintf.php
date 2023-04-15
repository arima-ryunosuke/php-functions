<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 連想配列を指定できるようにした vsprintf
 *
 * sprintf の順序指定構文('%1$d')にキーを指定できる。
 *
 * Example:
 * ```php
 * that(kvsprintf('%hoge$s %fuga$d', ['hoge' => 'ThisIs', 'fuga' => '3.14']))->isSame('ThisIs 3');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $format フォーマット文字列
 * @param array $array フォーマット引数
 * @return string フォーマットされた文字列
 */
function kvsprintf($format, array $array)
{
    $keys = array_flip(array_keys($array));
    $vals = array_values($array);

    $format = preg_replace_callback('#%%|%(.*?)\$#u', function ($m) use ($keys) {
        if (!isset($m[1])) {
            return $m[0];
        }

        $w = $m[1];
        if (!isset($keys[$w])) {
            throw new \OutOfBoundsException("kvsprintf(): Undefined index: $w");
        }

        return '%' . ($keys[$w] + 1) . '$';

    }, $format);

    return vsprintf($format, $vals);
}
