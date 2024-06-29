<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列が最後に現れる位置以前を返す
 *
 * strstr の逆のイメージで文字列を後ろから探索する動作となる。
 * strstr の動作は「文字列を前から探索して指定文字列があったらそれ以後を返す」なので、
 * その逆の動作の「文字列を後ろから探索して指定文字列があったらそれ以前を返す」という挙動を示す。
 *
 * strstr の「needle が文字列でない場合は、 それを整数に変換し、その番号に対応する文字として扱います」は直感的じゃないので踏襲しない。
 * （全体的にこの動作をやめよう、という RFC もあったはず）。
 *
 * 第3引数の意味合いもデフォルト値も逆になるので、単純に呼べばよくある「指定文字列より後ろを（指定文字列を含めないで）返す」という動作になる。
 *
 * Example:
 * ```php
 * // パス中の最後のディレクトリを取得
 * that(strrstr("path/to/1:path/to/2:path/to/3", ":"))->isSame('path/to/3');
 * // $after_needle を false にすると逆の動作になる
 * that(strrstr("path/to/1:path/to/2:path/to/3", ":", false))->isSame('path/to/1:path/to/2:');
 * // （参考）strrchr と違い、文字列が使えるしその文字そのものは含まれない
 * that(strrstr("A\r\nB\r\nC", "\r\n"))->isSame('C');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $haystack 調べる文字列
 * @param string $needle 検索文字列
 * @param bool $after_needle $needle より後ろを返すか
 * @return ?string
 */
function strrstr(?string $haystack, ?string $needle, $after_needle = true)
{
    // return strrev(strstr(strrev($haystack), strrev($needle), $after_needle));

    $lastpos = mb_strrpos($haystack, $needle);
    if ($lastpos === false) {
        return null;
    }

    if ($after_needle) {
        return mb_substr($haystack, $lastpos + mb_strlen($needle));
    }
    else {
        return mb_substr($haystack, 0, $lastpos + mb_strlen($needle));
    }
}
