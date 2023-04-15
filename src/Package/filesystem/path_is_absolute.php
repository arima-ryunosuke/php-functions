<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * パスが絶対パスか判定する
 *
 * Example:
 * ```php
 * that(path_is_absolute('/absolute/path'))->isTrue();
 * that(path_is_absolute('relative/path'))->isFalse();
 * // Windows 環境では下記も true になる
 * if (DIRECTORY_SEPARATOR === '\\') {
 *     that(path_is_absolute('\\absolute\\path'))->isTrue();
 *     that(path_is_absolute('C:\\absolute\\path'))->isTrue();
 * }
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $path パス文字列
 * @return bool 絶対パスなら true
 */
function path_is_absolute($path)
{
    // スキームが付いている場合は path 部分で判定
    $parts = parse_url($path);
    if (isset($parts['scheme'], $parts['path'])) {
        $path = $parts['path'];
    }
    elseif (isset($parts['scheme'], $parts['host'])) {
        $path = $parts['host'];
    }

    if (substr($path, 0, 1) === '/') {
        return true;
    }

    if (DIRECTORY_SEPARATOR === '\\') {
        if (preg_match('#^([a-z]+:(\\\\|/|$)|\\\\)#i', $path) !== 0) {
            return true;
        }
    }

    return false;
}
