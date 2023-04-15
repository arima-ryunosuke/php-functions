<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * 指定文字列を置換する
 *
 * $subject を $replaces に従って置換する。
 * 具体的には「$replaces を 複数指定できる str_subreplace」に近い。
 *
 * strtr とは「N 番目のみ置換できる」点で異なる。
 * つまり、$replaces=['hoge' => [2 => 'fuga']] とすると「2 番目の 'hoge' が 'fuga' に置換される」という動作になる（0 ベース）。
 *
 * $replaces の要素に非配列を与えた場合は配列化される。
 * つまり `$replaces = ['hoge' => 'fuga']` は `$replaces = ['hoge' => ['fuga']]` と同じ（最初のマッチを置換する）。
 *
 * $replace に空配列を与えると何もしない。
 * 負数キーは後ろから数える動作となる。
 * また、置換後の文字列は置換対象にはならない。
 *
 * N 番目の検索文字列が見つからない場合は例外を投げる。
 * ただし、文字自体が見つからない場合は投げない。
 *
 * Example:
 * ```php
 * // "hello, world" の l と o を置換
 * that(str_submap('hello, world', [
 *     // l は0番目と2番目のみを置換（1番目は何も行われない）
 *     'l' => [
 *         0 => 'L1',
 *         2 => 'L3',
 *     ],
 *     // o は後ろから数えて1番目を置換
 *     'o' => [
 *         -1 => 'O',
 *     ],
 * ]))->isSame('heL1lo, wOrL3d');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $subject 対象文字列
 * @param array $replaces 読み換え配列
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @return string 置換された文字列
 */
function str_submap($subject, $replaces, $case_insensitivity = false)
{
    assert(is_iterable($replaces));

    $isubject = $subject;
    if ($case_insensitivity) {
        $isubject = strtolower($isubject);
    }

    // 負数対応のために逆数計算（ついでに整数チェック）
    $mapping = [];
    foreach ($replaces as $from => $map) {
        $ifrom = $from;
        if ($case_insensitivity) {
            $ifrom = strtolower($ifrom);
        }
        $subcount = substr_count($isubject, $ifrom);
        if ($subcount === 0) {
            continue;
        }
        $mapping[$ifrom] = [];
        $map = is_iterable($map) ? $map : [$map];
        foreach ($map as $n => $to) {
            $origN = $n;
            if (!is_int($n)) {
                throw new \InvalidArgumentException('$replaces key must be integer.');
            }
            if ($n < 0) {
                $n += $subcount;
            }
            if (!(0 <= $n && $n < $subcount)) {
                throw new \InvalidArgumentException("notfound search string '$from' of {$origN}th.");
            }
            $mapping[$ifrom][$n] = $to;
        }
    }

    // 空はそのまま返す
    if (is_empty($mapping)) {
        return $subject;
    }

    // いろいろ試した感じ正規表現が最もシンプルかつ高速だった

    $repkeys = array_keys($mapping);
    $counter = array_fill_keys($repkeys, 0);
    $patterns = array_map(fn($k) => preg_quote($k, '#'), $repkeys);

    $i_flag = $case_insensitivity ? 'i' : '';
    return preg_replace_callback("#" . implode('|', $patterns) . "#u$i_flag", function ($matches) use (&$counter, $mapping, $case_insensitivity) {
        $imatch = $matches[0];
        if ($case_insensitivity) {
            $imatch = strtolower($imatch);
        }
        $index = $counter[$imatch]++;
        if (array_key_exists($index, $mapping[$imatch])) {
            return $mapping[$imatch][$index];
        }
        return $matches[0];
    }, $subject);
}
