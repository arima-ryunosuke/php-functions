<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 大文字小文字を区別しない strtr
 *
 * それ以外のすべての動作は strtr と同じ。
 * ただし3引数版は用途がほぼないので2引数版のみ。
 *
 * また str_replace を真似て $count に置換回数が格納される。
 * ただしこの $count はマッチ回数ではなく置換回数を返す。
 * つまり検索文字が見つかったが、結果として変わらなかった場合は $count には計上されない。
 * $count は往々にして「置換が行われたか？」の判断に使われるのでマッチ回数だとやや不便。
 * （そのようなことは strtr や str_replace では検索と置換を同じ文字にしない限りあり得ないが、大文字小文字を区別しない場合はそこそこあり得る話である）。
 *
 * Example:
 * ```php
 * // 長いものから置換される
 * that(stritr('Hello', ['Hel' => 'X', 'Hell' => 'Y']))->isSame('Yo');
 * // 一度置換したものは置換しない
 * that(stritr('Hello', ['Hel' => 'X', 'X' => 'Y', 'Y' => 'Z']))->isSame('Xlo');
 * // 大文字小文字は区別しない
 * that(stritr('Hello', ['hel' => 'X', 'hell' => 'Y']))->isSame('Yo');
 * // $count には置換回数が格納される
 * // この場合、apple という単語を Apple という upper に置換する処理で、マッチ回数は4,置換回数は2 である
 * that(stritr('apple to Apple, APPLE to Apple', ['apple' => 'Apple'], $count))->isSame('Apple to Apple, Apple to Apple');
 * that($count)->is(2);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 */
function stritr(string $string, array $replace_pairs, ?int &$count = null): string
{
    uksort($replace_pairs, fn($a, $b) => strlen($b) <=> strlen($a));

    $patterns = array_map(fn($s) => preg_quote($s, '#'), array_keys($replace_pairs));
    $pattern = '#' . implode('|', $patterns) . '#iu';

    $replace_pairs = array_change_key_case($replace_pairs, CASE_LOWER);

    $count = 0;
    return preg_replace_callback($pattern, function ($matches) use ($replace_pairs, &$count) {
        $lower = strtolower($matches[0]);
        if ($matches[0] !== $replace_pairs[$lower]) {
            $count++;
            return $replace_pairs[$lower];
        }
        return $matches[0];
    }, $string);
}
