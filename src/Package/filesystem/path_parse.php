<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * パスをパースする
 *
 * pathinfo の（ほぼ）上位互換で下記の差異がある。
 * - drive: Windows 環境におけるドライブ文字
 * - root: 絶対パスの場合はルートパス
 * - parents: 正規化したディレクトリ名の配列
 * - dirnames: ディレクトリ名の配列（余計なことはしない）
 * - localname: 複数拡張子を考慮した本当のファイル名部分
 * - localpath: ディレクトリ名（余計なことはしない）＋複数拡張子を考慮した本当のファイル名部分（フルパス - 拡張子）
 * - extensions: 複数拡張子の配列（余計なことはしない）
 *
 * 「余計なことはしない」とは空文字をフィルタしたりパスを正規化したりを指す。
 * 結果のキーはバージョンアップで増えることがある（その場合は互換性破壊とはみなさない）。
 *
 * なお、いわゆる URL はサポートしない（スキーム付きを与えた場合の挙動は未定義）。
 *
 * Example:
 * ```php
 * $DS = DIRECTORY_SEPARATOR;
 * // 色々混ぜたサンプル
 * that(path_parse('C:/dir1/.././dir2/file.sjis..min.js'))->is([
 *     "dirname"    => "C:/dir1/.././dir2",
 *     "basename"   => "file.sjis..min.js",
 *     "extension"  => "js",
 *     "filename"   => "file.sjis..min",
 *     // ここまでオリジナルの pathinfo 結果
 *     "drive"      => "C:",
 *     "root"       => "/",                          // 環境依存しない元のルートパス
 *     "parents"    => ["dir2"],                     // 正規化されたディレクトリ配列
 *     "dirnames"   => ["dir1", "..", ".", "dir2"],  // 余計なことをしていないディレクトリ配列
 *     "localname"  => "file",                       // 複数拡張子を考慮した本当のファイル名部分
 *     "localpath"  => "C:/dir1/.././dir2{$DS}file", // ↑にディレクトリ名を付与したもの
 *     "extensions" => ["sjis", "", "min", "js"],    // 余計なことをしていない拡張子配列
 * ]);
 * // linux における絶対パス
 * that(path_parse('/dir1/dir2/file.sjis.min.js'))->is([
 *     "dirname"    => "/dir1/dir2",
 *     "basename"   => "file.sjis.min.js",
 *     "extension"  => "js",
 *     "filename"   => "file.sjis.min",
 *     // ここまでオリジナルの pathinfo 結果
 *     "drive"      => "",                    // 環境を問わず空
 *     "root"       => "/",                   // 絶対パスなので "/"
 *     "parents"    => ["dir1", "dir2"],      // ..等がないので dirnames と同じ
 *     "dirnames"   => ["dir1", "dir2"],      // ディレクトリ配列
 *     "localname"  => "file",
 *     "localpath"  => "/dir1/dir2{$DS}file",
 *     "extensions" => ["sjis", "min", "js"], // 余計なことをしていない拡張子配列
 * ]);
 * // linux における相対パス
 * that(path_parse('dir1/dir2/file.sjis.min.js'))->is([
 *     "dirname"    => "dir1/dir2",
 *     "basename"   => "file.sjis.min.js",
 *     "extension"  => "js",
 *     "filename"   => "file.sjis.min",
 *     // ここまでオリジナルの pathinfo 結果
 *     "drive"      => "",
 *     "root"       => "",                    // 相対パスなので空（ここ以外は絶対パスと同じ）
 *     "parents"    => ["dir1", "dir2"],
 *     "dirnames"   => ["dir1", "dir2"],
 *     "localname"  => "file",
 *     "localpath"  => "dir1/dir2{$DS}file",
 *     "extensions" => ["sjis", "min", "js"],
 * ]);
 * // ディレクトリ無し
 * that(path_parse('file.sjis.min.js'))->is([
 *     "dirname"    => ".",
 *     "basename"   => "file.sjis.min.js",
 *     "extension"  => "js",
 *     "filename"   => "file.sjis.min",
 *     // ここまでオリジナルの pathinfo 結果
 *     "drive"      => "",
 *     "root"       => "",
 *     "parents"    => [], // オリジナルの pathinfo のようにドットが紛れ込んだりはしない
 *     "dirnames"   => [], // オリジナルの pathinfo のようにドットが紛れ込んだりはしない
 *     "localname"  => "file",
 *     "localpath"  => "file",
 *     "extensions" => ["sjis", "min", "js"],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $path パス
 * @return array パス情報
 */
function path_parse($path)
{
    $DS = DIRECTORY_SEPARATOR === '\\' ? '\\/' : '/';

    // キーが存在しないことがあるので順番も含めて正規化する
    $pathinfo = array_replace([
        'dirname'   => '',
        'basename'  => '',
        'extension' => '',
        'filename'  => '',
    ], pathinfo($path));

    $result = $pathinfo;

    // pathinfo の直感的でない挙動を補正する（dirname が . を返したり C:/ の結果が曖昧だったり）
    if ($pathinfo['dirname'] === '.') {
        $pathinfo['dirname'] = '';
    }
    if (DIRECTORY_SEPARATOR === '\\' && strlen(rtrim($path, '\\')) === 2) {
        $pathinfo['basename'] = '';
        $pathinfo['extension'] = '';
        $pathinfo['filename'] = '';
    }
    $dirnames = preg_split("#([" . preg_quote($DS) . "]+)#u", $pathinfo['dirname'], -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $basenames = explode('.', $pathinfo['basename']);

    $result['drive'] = '';
    if (isset($dirnames[0]) && preg_match('#^[a-z]:$#ui', $dirnames[0])) {
        $result['drive'] = array_shift($dirnames);
    }

    $result['root'] = '';
    if (isset($dirnames[0]) && strpbrk($dirnames[0], $DS) !== false) {
        $result['root'] = array_shift($dirnames);
    }

    $result['parents'] = array_reduce($dirnames, function ($carry, $dirname) use ($DS) {
        if (strpbrk($dirname, $DS) !== false || $dirname === '.') {
            return $carry;
        }
        if ($dirname === '..') {
            return array_slice($carry, 0, -1);
        }
        else {
            return array_merge($carry, [$dirname]);
        }
    }, []);

    $result['dirnames'] = array_reduce($dirnames, function ($carry, $dirname) use ($DS) {
        if (strpbrk($dirname, $DS) === false) {
            return array_merge($carry, [$dirname]);
        }
        else {
            return array_merge($carry, array_pad([], strlen($dirname) - 1, ''));
        }
    }, []);

    $result['localname'] = array_shift($basenames);
    $result['localpath'] = implode(DIRECTORY_SEPARATOR, array_filter([$pathinfo['dirname'], $result['localname']], 'strlen'));
    $result['extensions'] = $basenames;

    return $result;
}
