<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列を可変引数の数で分割する
 *
 * str_split の $length を個別に指定できるイメージ。
 * 長さ以上を指定したりしても最後の要素は必ずついてくる（指定数で分割した後のあまり文字が最後の要素になる）。
 * これは最後が空文字でも同様で、 list での代入を想定しているため。
 *
 * Example:
 * ```php
 * // 1, 2, 3 文字に分割（ぴったりなので変わったことはない）
 * that(str_chunk('abcdef', 1, 2, 3))->isSame(['a', 'bc', 'def', '']);
 * // 2, 3 文字に分割（余った f も最後の要素として含まれてくる）
 * that(str_chunk('abcdef', 2, 3))->isSame(['ab', 'cde', 'f']);
 * // 1, 10 文字に分割
 * that(str_chunk('abcdef', 1, 10))->isSame(['a', 'bcdef', '']);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param int ...$chunks 分割の各文字数（可変引数）
 * @return string[] 分割された文字列配列
 */
function str_chunk(?string $string, ...$chunks)
{
    $offset = 0;
    $length = strlen($string);
    $result = [];
    foreach ($chunks as $chunk) {
        if ($offset >= $length) {
            break;
        }
        $result[] = substr($string, $offset, $chunk);
        $offset += $chunk;
    }
    $result[] = substr($string, $offset);
    return $result;
}
