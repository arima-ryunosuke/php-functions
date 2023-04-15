<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * fnmatch の OR 版
 *
 * $patterns のうちどれか一つでもマッチしたら true を返す。
 * $patterns が空だと例外を投げる。
 *
 * Example:
 * ```php
 * // aaa にマッチするので true
 * that(fnmatch_or(['*aaa*', '*bbb*'], 'aaaX'))->isTrue();
 * // どれともマッチしないので false
 * that(fnmatch_or(['*aaa*', '*bbb*'], 'cccX'))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param array|string $patterns パターン配列（単一文字列可）
 * @param string $string 調べる文字列
 * @param int $flags FNM_***
 * @return bool どれかにマッチしたら true
 */
function fnmatch_or($patterns, $string, $flags = 0)
{
    $patterns = is_iterable($patterns) ? $patterns : [$patterns];
    if (is_empty($patterns)) {
        throw new \InvalidArgumentException('$patterns must be not empty.');
    }

    foreach ($patterns as $pattern) {
        if (fnmatch($pattern, $string, $flags)) {
            return true;
        }
    }
    return false;
}
