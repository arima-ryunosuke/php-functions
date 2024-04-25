<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../strings/strpos_quoted.php';
// @codeCoverageIgnoreEnd

/**
 * エスケープやクオートに対応した explode
 *
 * $enclosures は配列で開始・終了文字が別々に指定できるが、実装上の都合で今のところ1文字ずつのみ。
 *
 * Example:
 * ```php
 * // シンプルな例
 * that(quoteexplode(',', 'a,b,c\\,d,"e,f"'))->isSame([
 *     'a', // 普通に分割される
 *     'b', // 普通に分割される
 *     'c\\,d', // \\ でエスケープしているので区切り文字とみなされない
 *     '"e,f"', // "" でクオートされているので区切り文字とみなされない
 * ]);
 *
 * // $enclosures で囲い文字の開始・終了文字を明示できる
 * that(quoteexplode(',', 'a,b,{e,f}', null, ['{' => '}']))->isSame([
 *     'a', // 普通に分割される
 *     'b', // 普通に分割される
 *     '{e,f}', // { } で囲まれているので区切り文字とみなされない
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string|array $delimiter 分割文字列
 * @param string $string 対象文字列
 * @param ?int $limit 分割数。負数未対応
 * @param array|string $enclosures 囲い文字。 ["start" => "end"] で開始・終了が指定できる
 * @param string $escape エスケープ文字
 * @return array 分割された配列
 */
function quoteexplode($delimiter, $string, $limit = null, $enclosures = "'\"", $escape = '\\')
{
    if ($limit === null) {
        $limit = PHP_INT_MAX;
    }
    $limit = max(1, $limit);

    $delimiters = arrayize($delimiter);
    $current = 0;
    $result = [];
    for ($i = 0, $l = strlen($string); $i < $l; $i++) {
        if (count($result) === $limit - 1) {
            break;
        }
        $i = strpos_quoted($string, $delimiters, $i, $enclosures, $escape);
        if ($i === null) {
            break;
        }
        foreach ($delimiters as $delimiter) {
            $delimiterlen = strlen($delimiter);
            if (substr_compare($string, $delimiter, $i, $delimiterlen) === 0) {
                $result[] = substr($string, $current, $i - $current);
                $current = $i + $delimiterlen;
                $i += $delimiterlen - 1;
                break;
            }
        }
    }
    $result[] = substr($string, $current, $l);
    return $result;
}
