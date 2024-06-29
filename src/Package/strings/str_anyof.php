<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列が候補の中にあるか調べる
 *
 * 候補配列の中に対象文字列があるならそのキーを返す。ないなら null を返す。
 *
 * あくまで文字列としての比較に徹する（in_array/array_search の第3引数は厳密すぎて使いにくいことがある）。
 * ので array_search の文字列特化版とも言える。
 * 動作的には `array_flip($haystack)[$needle] ?? null` と同じ（大文字小文字オプションはあるけど）。
 * ただ array_flip は巨大配列に弱いし、大文字小文字などの融通が効かないので foreach での素朴な実装になっている。
 *
 * Example:
 * ```php
 * that(str_anyof('b', ['a', 'b', 'c']))->isSame(1);       // 見つかったキーを返す
 * that(str_anyof('x', ['a', 'b', 'c']))->isSame(null);    // 見つからないなら null を返す
 * that(str_anyof('C', ['a', 'b', 'c'], true))->isSame(2); // 大文字文字を区別しない
 * that(str_anyof('1', [1, 2, 3]))->isSame(0);             // 文字列の比較に徹する
 * that(str_anyof(2, ['1', '2', '3']))->isSame(1);         // 同上
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $needle 調べる文字列
 * @param iterable $haystack 候補配列
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @return bool 候補の中にあるならそのキー。無いなら null
 */
function str_anyof(?string $needle, $haystack, $case_insensitivity = false)
{
    foreach ($haystack as $k => $v) {
        if (!$case_insensitivity && strcmp($needle, $v) === 0) {
            return $k;
        }
        elseif ($case_insensitivity && strcasecmp($needle, $v) === 0) {
            return $k;
        }
    }
    return null;
}
