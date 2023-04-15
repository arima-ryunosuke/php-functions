<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列群の共通のプレフィックスを返す
 *
 * 共通部分がない場合は空文字を返す。
 * 引数は2個以上必要で足りない場合は null を返す。
 *
 * Example:
 * ```php
 * // 共通プレフィックスを返す
 * that(str_common_prefix('ab', 'abc', 'abcd'))->isSame('ab');
 * that(str_common_prefix('あ', 'あい', 'あいう'))->isSame('あ');
 * // 共通部分がない場合は空文字を返す
 * that(str_common_prefix('xab', 'yabc', 'zabcd'))->isSame('');
 * that(str_common_prefix('わあ', 'をあい', 'んあいう'))->isSame('');
 * // 引数不足の場合は null を返す
 * that(str_common_prefix('a'))->isSame(null);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string[] $strings
 * @return ?string 共通部分（共通がない場合は空文字）
 */
function str_common_prefix(...$strings)
{
    if (count($strings) < 2) {
        return null;
    }

    $n = 0;
    $result = '';
    $arrays = array_map(fn($string) => mb_str_split($string), $strings);
    foreach (array_intersect_assoc(...$arrays) as $i => $c) {
        if ($i !== $n++) {
            break;
        }
        $result .= $c;
    }
    return $result;
}
