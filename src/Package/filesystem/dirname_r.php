<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * コールバックが true 相当を返すまで親ディレクトリを辿り続ける
 *
 * コールバックには親ディレクトリが引数として渡ってくる。
 *
 * Example:
 * ```php
 * // //tmp/a/b/file.txt を作っておく
 * $tmp = sys_get_temp_dir();
 * file_set_contents("$tmp/a/b/file.txt", 'hoge');
 * // /a/b/c/d/e/f から開始して「どこかの階層の file.txt を探したい」という状況を想定
 * $callback = fn($path) => realpath("$path/file.txt");
 * that(dirname_r("$tmp/a/b/c/d/e/f", $callback))->isSame(realpath("$tmp/a/b/file.txt"));
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $path パス名
 * @param callable $callback コールバック
 * @return mixed $callback の返り値。頂上まで辿ったら null
 */
function dirname_r($path, $callback)
{
    $return = $callback($path);
    if ($return) {
        return $return;
    }

    $dirname = dirname($path);
    if ($dirname === $path) {
        return null;
    }
    return dirname_r($dirname, $callback);
}
