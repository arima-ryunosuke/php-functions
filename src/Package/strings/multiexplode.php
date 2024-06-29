<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
// @codeCoverageIgnoreEnd

/**
 * explode の配列対応と $limit の挙動を変えたもの
 *
 * $delimiter には配列が使える。いわゆる「複数文字列での分割」の動作になる。
 *
 * $limit に負数を与えると「その絶対値-1までを結合したものと残り」を返す。
 * 端的に言えば「正数を与えると後詰めでその個数で返す」「負数を与えると前詰めでその（絶対値）個数で返す」という動作になる。
 *
 * Example:
 * ```php
 * // 配列を与えると複数文字列での分割
 * that(multiexplode([',', ' ', '|'], 'a,b c|d'))->isSame(['a', 'b', 'c', 'd']);
 * // 負数を与えると前詰め
 * that(multiexplode(',', 'a,b,c,d', -2))->isSame(['a,b,c', 'd']);
 * // もちろん上記2つは共存できる
 * that(multiexplode([',', ' ', '|'], 'a,b c|d', -2))->isSame(['a,b c', 'd']);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string|array $delimiter 分割文字列。配列可
 * @param string $string 対象文字列
 * @param int $limit 分割数
 * @return array 分割された配列
 */
function multiexplode($delimiter, ?string $string, $limit = \PHP_INT_MAX)
{
    $limit = (int) $limit;
    if ($limit < 0) {
        // 下手に php で小細工するよりこうやって富豪的にやるのが一番速かった
        return array_reverse(array_map('strrev', multiexplode($delimiter, strrev($string), -$limit)));
    }
    // explode において 0 は 1 と等しい
    if ($limit === 0) {
        $limit = 1;
    }
    $delimiter = array_map(fn($v) => preg_quote($v, '#'), arrayize($delimiter));
    return preg_split('#' . implode('|', $delimiter) . '#', $string, $limit);
}
