<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * パスを正規化する
 *
 * 具体的には ./ や ../ を取り除いたり連続したディレクトリ区切りをまとめたりする。
 * realpath ではない。のでシンボリックリンクの解決などはしない。その代わりファイルが存在しなくても使用することができる。
 *
 * Example:
 * ```php
 * $DS = DIRECTORY_SEPARATOR;
 * that(path_normalize('/path/to/something'))->isSame("{$DS}path{$DS}to{$DS}something");
 * that(path_normalize('/path/through/../something'))->isSame("{$DS}path{$DS}something");
 * that(path_normalize('./path/current/./through/../something'))->isSame("path{$DS}current{$DS}something");
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $path パス文字列
 * @return string 正規化されたパス
 */
function path_normalize($path)
{
    $DS = DIRECTORY_SEPARATOR;

    // スキームの保護
    $with_scheme = false;
    $scheme = parse_url($path, PHP_URL_SCHEME);
    if (!($scheme === null || $scheme === 'file') && substr($path, strlen($scheme), 3) === '://') {
        $path = substr($path, strlen($scheme) + 3);
        $DS = '/';
        $with_scheme = true;
    }

    $delimiter = '/';
    if ($DS === '\\') {
        $delimiter .= '\\\\';
    }

    $result = [];
    foreach (preg_split("#[$delimiter]+#u", $path) as $part) {
        if ($part === '.') {
            continue;
        }
        if ($part === '..') {
            if (empty($result)) {
                throw new \InvalidArgumentException("'$path' is invalid as path string.");
            }
            array_pop($result);
            continue;
        }
        $result[] = $part;
    }
    if (count($result) > 2 && $result[count($result) - 1] === '') {
        array_pop($result);
    }

    $path = implode($DS, $result);

    if ($with_scheme) {
        $path = "$scheme://$path";
    }

    return $path;
}
