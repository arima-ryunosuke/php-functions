<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/path_build.php';
require_once __DIR__ . '/../filesystem/path_is_absolute.php';
require_once __DIR__ . '/../filesystem/path_normalize.php';
// @codeCoverageIgnoreEnd

/**
 * ファイルをコールバックでリネームする
 *
 * ファイルの上書きは決して行われない（もちろん別プロセスでの競合状態などは考慮しない）。
 * 対象ファイル名が既に存在する場合は（次の候補でリネームされるかもしれないので）スキップして再試行する。
 * つまり、いわゆる「連番ずらし」の場合でも安全にリネームできる。
 *
 * $callback には元ファイル名が渡ってくる。
 * null を返した場合、リネームの対象とはならない。
 * また、相対パスを返すと元ファイルのディレクトリが指定されたものとみなす。
 *
 * 結果配列として [元ファイル名 => 新ファイル名] の配列を返す。
 * 元ファイルが存在しないなどで rename されなかったファイルは null が設定される。
 *
 * Example:
 * ```php
 * $DS = DIRECTORY_SEPARATOR;
 * // 適当にファイルを用意
 * $root = sys_get_temp_dir(). "{$DS}file_rename";
 * rm_rf($root);
 * file_set_tree([
 *     $root => [
 *         '1.txt'     => '1',
 *         '2.txt'     => '2',
 *         'noise.txt' => 'noise',
 *         '3.txt'     => '3',
 *     ],
 * ]);
 * // 連番ファイルを +1 してrename
 * that(file_rename(glob("$root/*"), function ($fn) {
 *     $pathinfo = pathinfo($fn);
 *     // null を返すと対象にならない
 *     if (!is_numeric($pathinfo['filename'])) {
 *         return null;
 *     }
 *     return ($pathinfo['filename'] + '1') . '.' . $pathinfo['extension'];
 * }))->isSame([
 *     "$root/3.txt" => "$root{$DS}4.txt",
 *     "$root/2.txt" => "$root{$DS}3.txt",
 *     "$root/1.txt" => "$root{$DS}2.txt",
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 */
function file_rename(
    /** 対象ファイル名 */ array $filenames,
    /** リネームコールバック */ callable $callback,
): /** 新ファイル名対応配列 */ array
{
    // まず対応表を得る（いきなり rename すると対象が存在するときに事故る）
    $newnames = [];
    foreach ($filenames as $filename) {
        $pathinfo = pathinfo($filename);
        $newname = $callback($filename, $pathinfo);
        if (is_array($newname)) {
            $newname = path_build($newname);
        }
        if ($newname !== null) {
            if (!path_is_absolute($newname)) {
                $newname = "{$pathinfo['dirname']}/$newname";
            }
            $newnames[$filename] = path_normalize($newname);
        }
    }

    // rename 前に意図しない移動・上書きが行われないかチェックして例外を飛ばす
    $realnames = array_fill_keys(array_map(fn($name) => path_normalize($name), array_keys($newnames)), true);
    foreach ($newnames as $filename => $newname) {
        // 候補に存在しないのに対象ファイルが存在する（どうあがいても rename できない or 上書きされてしまう）
        if (!isset($realnames[$newname]) && file_exists($newname)) {
            throw new \RuntimeException("$filename => $newname failed. $newname is already exists");
        }
    }

    // ここまで来てやっと処理ができる
    $result = [];
    while ($newnames) {
        $count = count($newnames);
        foreach ($newnames as $filename => $newname) {
            // 存在するなら後回し（いずれチャンスは来る）
            if (file_exists($newname)) {
                continue;
            }

            unset($newnames[$filename]);
            if (@rename($filename, $newname)) {
                $result[$filename] = $newname;
            }
            else {
                $result[$filename] = null;
            }
        }

        // 数が変わっていない=別プロセスの割り込み等で無限ループになっている可能性がある
        if ($count === count($newnames)) {
            throw new \RuntimeException("failed to rename " . implode(',', $newnames)); // @codeCoverageIgnore
        }
    }

    return $result;
}
