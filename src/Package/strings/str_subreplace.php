<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * 指定文字列を置換する
 *
 * $subject 内の $search を $replaces に置換する。
 * str_replace とは「N 番目のみ置換できる」点で異なる。
 * つまり、$search='hoge', $replace=[2 => 'fuga'] とすると「2 番目の 'hoge' が 'fuga' に置換される」という動作になる（0 ベース）。
 *
 * $replace に 非配列を与えた場合は配列化される。
 * つまり `$replaces = 'hoge'` は `$replaces = [0 => 'hoge']` と同じ（最初のマッチを置換する）。
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
 * // 1番目（0ベースなので2番目）の x を X に置換
 * that(str_subreplace('xxx', 'x', [1 => 'X']))->isSame('xXx');
 * // 0番目（最前列）の x を Xa に、-1番目（最後尾）の x を Xz に置換
 * that(str_subreplace('!xxx!', 'x', [0 => 'Xa', -1 => 'Xz']))->isSame('!XaxXz!');
 * // 置換結果は置換対象にならない
 * that(str_subreplace('xxx', 'x', [0 => 'xxx', 1 => 'X']))->isSame('xxxXx');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $subject 対象文字列
 * @param string $search 検索文字列
 * @param array|string $replaces 置換文字列配列（単一指定は配列化される）
 * @param bool $case_insensitivity 大文字小文字を無視するか
 * @return string 置換された文字列
 */
function str_subreplace(?string $subject, ?string $search, $replaces, $case_insensitivity = false)
{
    $replaces = is_iterable($replaces) ? $replaces : [$replaces];

    // 空はそのまま返す
    if (is_empty($replaces)) {
        return $subject;
    }

    // 負数対応のために逆数計算（ついでに整数チェック）
    $subcount = $case_insensitivity ? substr_count(strtolower($subject), strtolower($search)) : substr_count($subject, $search);
    if ($subcount === 0) {
        return $subject;
    }
    $mapping = [];
    foreach ($replaces as $n => $replace) {
        $origN = $n;
        if (!is_int($n)) {
            throw new \InvalidArgumentException('$replaces key must be integer.');
        }
        if ($n < 0) {
            $n += $subcount;
        }
        if (!(0 <= $n && $n < $subcount)) {
            throw new \InvalidArgumentException("notfound search string '$search' of {$origN}th.");
        }
        $mapping[$n] = $replace;
    }
    $maxseq = max(array_keys($mapping));
    $offset = 0;
    for ($n = 0; $n <= $maxseq; $n++) {
        $pos = $case_insensitivity ? stripos($subject, $search, $offset) : strpos($subject, $search, $offset);
        if (isset($mapping[$n])) {
            $subject = substr_replace($subject, $mapping[$n], $pos, strlen($search));
            $offset = $pos + strlen($mapping[$n]);
        }
        else {
            $offset = $pos + strlen($search);
        }
    }
    return $subject;
}
