<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 配列を指定条件で分割する
 *
 * 文字列の explode を更に一階層掘り下げたイメージ。
 * $condition で指定された要素は結果配列に含まれない。
 *
 * $condition にはクロージャが指定できる。クロージャの場合は true 相当を返した場合に分割要素とみなされる。
 * 引数は (値, キー)の順番。
 *
 * $limit に負数を与えると「その絶対値-1までを結合したものと残り」を返す。
 * 端的に言えば「正数を与えると後詰めでその個数で返す」「負数を与えると前詰めでその（絶対値）個数で返す」という動作になる。
 *
 * Example:
 * ```php
 * // null 要素で分割
 * that(array_explode(['a', null, 'b', 'c'], null))->isSame([['a'], [2 => 'b', 3 => 'c']]);
 * // クロージャで分割（大文字で分割）
 * that(array_explode(['a', 'B', 'c', 'D', 'e'], fn($v) => ctype_upper($v)))->isSame([['a'], [2 => 'c'], [4 => 'e']]);
 * // 負数指定
 * that(array_explode(['a', null, 'b', null, 'c'], null, -2))->isSame([[0 => 'a', 1 => null, 2 => 'b'], [4 => 'c']]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param mixed $condition 分割条件
 * @param int $limit 最大分割数
 * @return array 分割された配列
 */
function array_explode($array, $condition, $limit = \PHP_INT_MAX)
{
    $array = arrayval($array, false);

    $limit = (int) $limit;
    if ($limit < 0) {
        // キーまで考慮するとかなりややこしくなるので富豪的にやる
        $reverse = array_explode(array_reverse($array, true), $condition, -$limit);
        $reverse = array_map(fn($v) => array_reverse($v, true), $reverse);
        return array_reverse($reverse);
    }
    // explode において 0 は 1 と等しい
    if ($limit === 0) {
        $limit = 1;
    }

    $result = [];
    $chunk = [];
    $n = -1;
    foreach ($array as $k => $v) {
        $n++;

        if ($limit === 1) {
            $chunk = array_slice($array, $n, null, true);
            break;
        }

        if ($condition instanceof \Closure) {
            $match = $condition($v, $k, $n);
        }
        else {
            $match = $condition === $v;
        }

        if ($match) {
            $limit--;
            $result[] = $chunk;
            $chunk = [];
        }
        else {
            $chunk[$k] = $v;
        }
    }
    $result[] = $chunk;
    return $result;
}
