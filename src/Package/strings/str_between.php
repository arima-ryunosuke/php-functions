<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/strpos_quoted.php';
// @codeCoverageIgnoreEnd

/**
 * 指定文字で囲まれた文字列を取得する
 *
 * $from, $to で指定した文字間を取得する（$from, $to 自体は結果に含まれない）。
 * ネストしている場合、一番外側の文字間を返す。
 *
 * $enclosure で「特定文字に囲まれている」場合を無視することができる。
 * $escape で「特定文字が前にある」場合を無視することができる。
 *
 * $position を与えた場合、その場所から走査を開始する。
 * さらに結果があった場合、 $position には「次の走査開始位置」が代入される。
 * これを使用すると連続で「次の文字, 次の文字, ...」と言った動作が可能になる。
 *
 * Example:
 * ```php
 * // $position を利用して "first", "second", "third" を得る（"で囲まれた "blank" は返ってこない）。
 * that(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n))->isSame('first');
 * that(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n))->isSame('second');
 * that(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n))->isSame('third');
 * // ネストしている場合は最も外側を返す
 * that(str_between('{nest1{nest2{nest3}}}', '{', '}'))->isSame('nest1{nest2{nest3}}');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $from 開始文字列
 * @param string $to 終了文字列
 * @param int $position 開始位置。渡した場合次の開始位置が設定される
 * @param string $enclosure 囲い文字。この文字中にいる $from, $to 文字は走査外になる
 * @param string $escape エスケープ文字。この文字が前にある $from, $to 文字は走査外になる
 * @return ?string $from, $to で囲まれた文字。見つからなかった場合は null
 */
function str_between($string, $from, $to, &$position = 0, $enclosure = '\'"', $escape = '\\')
{
    $strlen = strlen($string);
    $fromlen = strlen($from);
    $tolen = strlen($to);
    $position = intval($position);
    $nesting = 0;
    $start = null;
    for ($i = $position; $i < $strlen; $i++) {
        $i = strpos_quoted($string, [$from, $to], $i, $enclosure, $escape);
        if ($i === null) {
            break;
        }

        // 開始文字と終了文字が重複している可能性があるので $to からチェックする
        if (substr_compare($string, $to, $i, $tolen) === 0) {
            if (--$nesting === 0) {
                $position = $i + $tolen;
                return substr($string, $start, $i - $start);
            }
            // いきなり終了文字が来た場合は無視する
            if ($nesting < 0) {
                $nesting = 0;
            }
        }
        if (substr_compare($string, $from, $i, $fromlen) === 0) {
            if ($nesting++ === 0) {
                $start = $i + $fromlen;
            }
        }
    }
    return null;
}
