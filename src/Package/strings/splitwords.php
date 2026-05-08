<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ucwords の配列返し版
 *
 * PascalCase, camelCase, snake_case などのスタイルは数あれど、結局のところ単語に分割さえできれば文字列関数を適用して結合するだけで済む。
 * つまり標準の ucwords を配列で返すようにすれば十分。
 * それだけじゃつまらないので、$keep_abbr で連続大文字をバラさないように指定できるようにしてある。
 *
 * Example:
 * ```php
 * that(splitwords('ThisIsAPen'))->isSame(["This", "Is", "A", "Pen"]);
 * that(splitwords('this-is-a-pen'))->isSame(["this", "is", "a", "pen"]);
 * that(splitwords('This-Is-A-Pen'))->isSame(["This", "Is", "A", "Pen"]);
 *
 * that(splitwords('URLEncode', false))->isSame(["U", "R", "L", "Encode"]);
 * that(splitwords('URLEncode', true))->isSame(["URL", "Encode"]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param bool $keep_abbr すべて大文字の単語を1単語として扱うか
 * @param bool $no_empty 空文字を除去するか
 * @param string $separators デリミタ
 * @return array 単語配列
 */
function splitwords(string $string, $keep_abbr = true, $no_empty = true, $separators = "-_ \t\r\n\f\v"): array
{
    $pattern = $keep_abbr ? "#[A-Z]([A-Z](?![a-z]))*#" : "#[A-Z]#";
    $string = ltrim(preg_replace($pattern, $separators[0] . '\0', $string), $separators); // for compatible ltrim

    $pattern = "[" . preg_quote($separators) . "]";
    $words = preg_split("#$pattern#u", $string);

    if ($no_empty) {
        $words = array_values(array_filter($words, 'strlen'));
    }

    return $words;
}
