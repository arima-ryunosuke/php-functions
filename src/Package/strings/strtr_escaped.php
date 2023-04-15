<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/strpos_escaped.php';
// @codeCoverageIgnoreEnd

/**
 * エスケープを考慮して strtr する
 *
 * 「エスケープ」についての詳細は strpos_escaped を参照。
 *
 * $replace_pairs は [from => to] な配列を指定する。
 * to がクロージャの場合はキーとオフセットでコールバックされる。
 *
 * strtr と同様、最も長いキーから置換を行い、置換後の文字列は対象にならない。
 *
 * Example:
 * ```php
 * # 分かりにくいので \ ではなく % をエスケープ文字とする
 * that(strtr_escaped('XYZ ab %% %s', [
 *     'ab'  => 'AB',  // 2. 1 で置換された文字は対象にならない
 *     'A'   => '%a',  // 使われない
 *     'Z'   => '%z',  // 使われない
 *     '%%'  => 'p',   // 普通に置換される
 *     's'   => 'S',   // エスケープが対象なので置換されない（%s は文字 "s" ではない（\n が文字 "n" ではないのと同じ））
 *     'XYZ' => 'abc', // 1. 後ろにあるがまず置換される
 * ], '%'))->isSame('abc AB p %s');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param array $replace_pairs 置換するペア
 * @param string $escape エスケープ文字
 * @return string 置換された文字列
 */
function strtr_escaped($string, $replace_pairs, $escape = '\\')
{
    uksort($replace_pairs, fn($a, $b) => strlen($b) - strlen($a));
    $froms = array_keys($replace_pairs);

    $offset = 0;
    while (($pos = strpos_escaped($string, $froms, $offset, $escape, $found)) !== false) {
        $to = $replace_pairs[$found];
        $replaced = $to instanceof \Closure ? $to($found, $pos) : $to;
        $string = substr_replace($string, $replaced, $pos, strlen($found));
        $offset = $pos + strlen($replaced);
    }
    return $string;
}
