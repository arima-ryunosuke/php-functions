<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/strpos_quoted.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * エスケープ付きで文字列を置換する
 *
 * $replacemap で from -> to 文字列を指定する。
 * to は文字列と配列を受け付ける。
 * 文字列の場合は普通に想起される動作で単純な置換となる。
 * 配列の場合は順次置換していく。要素が足りなくなったら例外を投げる。
 *
 * strtr と同様、最も長いキーから置換を行い、置換後の文字列は対象にならない。
 *
 * $enclosure で「特定文字に囲まれている」場合を無視することができる。
 * $escape で「特定文字が前にある」場合を無視することができる。
 *
 * Example:
 * ```php
 * // 最も単純な置換
 * that(str_embed('a, b, c', ['a' => 'A', 'b' => 'B', 'c' => 'C']))->isSame('A, B, C');
 * // 最も長いキーから置換される
 * that(str_embed('abc', ['a' => 'X', 'ab' => 'AB']))->isSame('ABc');
 * // 配列を渡すと「N番目の置換」が実現できる（文字列の場合は再利用される）
 * that(str_embed('a, a, b, b', [
 *     'a' => 'A',          // 全ての a が A になる
 *     'b' => ['B1', 'B2'], // 1番目の b が B1, 2番目の b が B2 になる
 * ]))->isSame('A, A, B1, B2');
 * // 最も重要な性質として "' で囲まれていると対象にならない
 * that(str_embed('a, "a", b, "b", b', [
 *     'a' => 'A',
 *     'b' => ['B1', 'B2'],
 * ]))->isSame('A, "a", B1, "b", B2');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param array $replacemap 置換文字列
 * @param string|array $enclosure 囲い文字。この文字中にいる $from, $to 文字は走査外になる
 * @param string $escape エスケープ文字。この文字が前にある $from, $to 文字は走査外になる
 * @return string 置換された文字列
 */
function str_embed($string, $replacemap, $enclosure = "'\"", $escape = '\\')
{
    assert(is_iterable($replacemap));

    $string = (string) $string;

    // 長いキーから処理するためソートしておく
    $replacemap = arrayval($replacemap, false);
    uksort($replacemap, fn($a, $b) => strlen($b) - strlen($a));
    $srcs = array_keys($replacemap);

    $counter = array_fill_keys(array_keys($replacemap), 0);
    for ($i = 0; $i < strlen($string); $i++) {
        $i = strpos_quoted($string, $srcs, $i, $enclosure, $escape);
        if ($i === false) {
            break;
        }

        foreach ($replacemap as $src => $dst) {
            $srclen = strlen($src);
            if ($srclen === 0) {
                throw new \InvalidArgumentException("src length is 0.");
            }
            if (substr_compare($string, $src, $i, $srclen) === 0) {
                if (is_array($dst)) {
                    $n = $counter[$src]++;
                    if (!isset($dst[$n])) {
                        throw new \InvalidArgumentException("notfound search string '$src' of {$n}th.");
                    }
                    $dst = $dst[$n];
                }
                $string = substr_replace($string, $dst, $i, $srclen);
                $i += strlen($dst) - 1;
                break;
            }
        }
    }
    return $string;
}
