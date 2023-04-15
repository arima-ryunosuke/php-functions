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
 *
 * 歴史的な理由により最後の引数を配列にするとその候補と PATH からの解決を試みる。
 * 解決できなかった場合 null を返す。
 * 配列を指定しなかった場合はカレントディレクトリを結合して返す。
 *
 * Example:
 * ```php
 * $DS = DIRECTORY_SEPARATOR;
 * that(path_resolve('/absolute/path'))->isSame("{$DS}absolute{$DS}path");
 * that(path_resolve('absolute/path'))->isSame(getcwd() . "{$DS}absolute{$DS}path");
 * that(path_resolve('/absolute/path/through', '../current/./path'))->isSame("{$DS}absolute{$DS}path{$DS}current{$DS}path");
 *
 * # 最後の引数に配列を与えるとそのパスと PATH から解決を試みる（要するに which 的な動作になる）
 * if ($DS === '/') {
 *     that(path_resolve('php', []))->isSame(PHP_BINARY);
 * }
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string|array ...$paths パス文字列（可変引数）
 * @return ?string 絶対パス
 */
function path_resolve(...$paths)
{
    $resolver = [];
    if (is_array($paths[count($paths) - 1] ?? '')) {
        $resolver = array_pop($paths);
        $resolver[] = getenv('PATH');
    }

    $DS = DIRECTORY_SEPARATOR;

    $path = implode($DS, $paths);

    if (!path_is_absolute($path)) {
        if ($resolver) {
            foreach ($resolver as $p) {
                foreach (explode(PATH_SEPARATOR, $p) as $dir) {
                    if (file_exists("$dir/$path")) {
                        return path_normalize("$dir/$path");
                    }
                }
            }
            return null;
        }
        else {
            $path = getcwd() . $DS . $path;
        }
    }

    return path_normalize($path);
}
