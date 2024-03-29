<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_depth.php';
require_once __DIR__ . '/../funchand/call_safely.php';
// @codeCoverageIgnoreEnd

/**
 * fputcsv の文字列版（str_getcsv の put 版）
 *
 * エラーは例外に変換される。
 *
 * 普通の配列を与えるとシンプルに "a,b,c" のような1行を返す。
 * 多次元配列（2次元のみを想定）や Traversable を与えるとループして "a,b,c\nd,e,f" のような複数行を返す。
 *
 * Example:
 * ```php
 * // シンプルな1行を返す
 * that(str_putcsv(['a', 'b', 'c']))->isSame("a,b,c");
 * that(str_putcsv(['a', 'b', 'c'], "\t"))->isSame("a\tb\tc");
 * that(str_putcsv(['a', ' b ', 'c'], " ", "'"))->isSame("a ' b ' c");
 *
 * // 複数行を返す
 * that(str_putcsv([['a', 'b', 'c'], ['d', 'e', 'f']]))->isSame("a,b,c\nd,e,f");
 * that(str_putcsv((function() {
 *     yield ['a', 'b', 'c'];
 *     yield ['d', 'e', 'f'];
 * })()))->isSame("a,b,c\nd,e,f");
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param iterable $array 値の配列 or 値の配列の配列
 * @param string $delimiter フィールド区切り文字
 * @param string $enclosure フィールドを囲む文字
 * @param string $escape エスケープ文字
 * @return string CSV 文字列
 */
function str_putcsv($array, $delimiter = ',', $enclosure = '"', $escape = "\\")
{
    $fp = fopen('php://memory', 'rw+');
    try {
        if (is_array($array) && array_depth($array) === 1) {
            $array = [$array];
        }
        return call_safely(function ($fp, $array, $delimiter, $enclosure, $escape) {
            foreach ($array as $line) {
                fputcsv($fp, $line, $delimiter, $enclosure, $escape);
            }
            rewind($fp);
            return rtrim(stream_get_contents($fp), "\n");
        }, $fp, $array, $delimiter, $enclosure, $escape);
    }
    finally {
        fclose($fp);
    }
}
