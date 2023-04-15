<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * fnmatch の AND 版
 *
 * $patterns のうちどれか一つでもマッチしなかったら false を返す。
 * $patterns が空だと例外を投げる。
 *
 * Example:
 * ```php
 * // すべてにマッチするので true
 * that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaXbbbX'))->isTrue();
 * // aaa にはマッチするが bbb にはマッチしないので false
 * that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaX'))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param array|string $patterns パターン配列（単一文字列可）
 * @param string $string 調べる文字列
 * @param int $flags FNM_***
 * @return bool すべてにマッチしたら true
 */
function fnmatch_and($patterns, $string, $flags = 0)
{
    $patterns = is_iterable($patterns) ? $patterns : [$patterns];
    if (is_empty($patterns)) {
        throw new \InvalidArgumentException('$patterns must be not empty.');
    }

    foreach ($patterns as $pattern) {
        if (!fnmatch($pattern, $string, $flags)) {
            return false;
        }
    }
    return true;
}
