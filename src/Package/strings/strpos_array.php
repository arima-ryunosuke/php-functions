<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 複数の文字列で strpos する
 *
 * $needles のそれぞれの位置を配列で返す。
 * ただし、見つからなかった文字は結果に含まれない。
 *
 * Example:
 * ```php
 * // 見つかった位置を返す
 * that(strpos_array('hello world', ['hello', 'world']))->isSame([
 *     0 => 0,
 *     1 => 6,
 * ]);
 * // 見つからない文字は含まれない
 * that(strpos_array('hello world', ['notfound', 'world']))->isSame([
 *     1 => 6,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $haystack 対象文字列
 * @param iterable $needles 位置を取得したい文字列配列
 * @param int $offset 開始位置
 * @return array $needles それぞれの位置配列
 */
function strpos_array($haystack, $needles, $offset = 0)
{
    if ($offset < 0) {
        $offset += strlen($haystack);
    }

    $result = [];
    foreach (arrayval($needles, false) as $key => $needle) {
        $pos = strpos($haystack, $needle, $offset);
        if ($pos !== false) {
            $result[$key] = $pos;
        }
    }
    return $result;
}
