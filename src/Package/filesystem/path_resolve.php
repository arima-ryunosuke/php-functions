<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/path_is_absolute.php';
require_once __DIR__ . '/../filesystem/path_normalize.php';
// @codeCoverageIgnoreEnd

/**
 * パスを絶対パスに変換して正規化する
 *
 * 可変引数で与えられた文字列群を結合して絶対パス化して返す。
 * 出来上がったパスが絶対パスでない場合は PATH 環境変数を使用して解決を試みる。
 * それでも絶対パスにできない場合は null を返す。
 *
 * Example:
 * ```php
 * $DS = DIRECTORY_SEPARATOR;
 * that(path_resolve('/absolute/path'))->isSame("{$DS}absolute{$DS}path");
 * that(path_resolve('/absolute/path/through', '../current/./path'))->isSame("{$DS}absolute{$DS}path{$DS}current{$DS}path");
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string ...$paths パス文字列（可変引数）
 * @return ?string 絶対パス
 */
function path_resolve(...$paths)
{
    $DS = DIRECTORY_SEPARATOR;

    $path = implode($DS, $paths);

    if (!path_is_absolute($path)) {
        foreach ([getcwd(), getenv('PATH')] as $p) {
            foreach (explode(PATH_SEPARATOR, $p) as $dir) {
                if (file_exists("$dir/$path")) {
                    return path_normalize("$dir/$path");
                }
            }
        }
        return null;
    }

    return path_normalize($path);
}
