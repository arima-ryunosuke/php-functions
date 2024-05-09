<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_depth.php';
// @codeCoverageIgnoreEnd

/**
 * fputcsv の文字列版（str_getcsv の put 版）
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
    static $fp = null;
    $fp ??= fopen('php://memory', 'rw+');
    rewind($fp);
    ftruncate($fp, 0);
    if (is_array($array) && array_depth($array, 2) === 1) {
        $array = [$array];
    }
    foreach ($array as $line) {
        fputcsv($fp, $line, $delimiter, $enclosure, $escape);
    }
    rewind($fp);
    return rtrim(stream_get_contents($fp), "\n");
}
