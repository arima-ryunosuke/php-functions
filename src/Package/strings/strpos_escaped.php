<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * エスケープを考慮して strpos する
 *
 * 文字列中のエスケープ中でない生の文字を検索する。
 * 例えば `"abc\nxyz"` という文字列で `"n"` という文字は存在しないとみなす。
 * `"\n"` は改行のエスケープシーケンスであり、 `"n"` という文字ではない（エスケープシーケンスとして "n" を流用しているだけ）。
 * 逆に `"\\n"` はバックスラッシュと `"n"` という文字であり `"n"` が存在する。
 * 簡単に言えば「直前にバックスラッシュがある場合はヒットしない strpos」である。
 * バックスラッシュは $escape 引数で指定可能。
 *
 * $needle 自体にエスケープ文字を含む場合、反対の意味で検索する。
 * つまり、「直前にバックスラッシュがある場合のみヒットする strpos」になる。
 *
 * $offset 引数を指定するとその位置から探索を開始するが、戻り読みはしないのでエスケープ文字の真っ只中を指定する場合は注意。
 * 例えば `"\n"` は改行文字だけであるが、offset に 1 に指定して "n" を探すとマッチする。
 *
 * Example:
 * ```php
 * # 分かりにくいので \ ではなく % をエスケープ文字とする
 * $defargs = [0, '%'];
 *
 * // これは false である（"%d" という文字の列であるため "d" という文字は存在しない）
 * that(strpos_escaped('%d', 'd', ...$defargs))->isSame(false);
 * // これは 2 である（"%" "d" という文字の列であるため（d の前の % は更にその前の % に呑まれておりメタ文字ではない））
 * that(strpos_escaped('%%d', 'd', ...$defargs))->isSame(2);
 *
 * // これは 0 である（% をつけて検索するとそのエスケープシーケンス的なものそのものを探すため）
 * that(strpos_escaped('%d', '%d', ...$defargs))->isSame(0);
 * // これは false である（"%" "d" という文字の列であるため "%d" という文字は存在しない）
 * that(strpos_escaped('%%d', '%d', ...$defargs))->isSame(false);
 * // これは 2 である（"%" "%d" という文字の列であるため）
 * that(strpos_escaped('%%%d', '%d', ...$defargs))->isSame(2);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $haystack 対象文字列
 * @param string|array $needle 探す文字
 * @param int $offset 開始位置
 * @param string $escape エスケープ文字
 * @param ?string $found 見つかった文字が格納される
 * @return false|int 見つかった位置
 */
function strpos_escaped($haystack, $needle, $offset = 0, $escape = '\\', &$found = null)
{
    $q_escape = preg_quote($escape, '#');
    if (is_stringable($needle)) {
        $needle = preg_split("#($q_escape?.)#u", $needle, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    }

    $needles = arrayval($needle);
    assert(!in_array($escape, $needles, true), sprintf('$needle must not contain only escape charactor ("%s")', implode(', ', $needles)));

    $matched = [];
    foreach (array_map(fn($c) => preg_quote($c, '#'), $needles) as $need) {
        if (preg_match_all("#((?:$q_escape)*?)($need)#u", $haystack, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER, $offset)) {
            foreach ($matches as [, $m_escape, $m_needle]) {
                if ((strlen($m_escape[0]) / strlen($escape)) % 2 === 0) {
                    $matched[$m_needle[1]] ??= $m_needle[0];
                }
            }
        }
    }
    if (!$matched) {
        $found = null;
        return false;
    }

    ksort($matched);
    $min = array_key_first($matched);
    $found = $matched[$min];
    return $min;
}
