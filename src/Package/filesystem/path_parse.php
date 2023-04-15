<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/path_normalize.php';
// @codeCoverageIgnoreEnd

/**
 * パスをパースする
 *
 * pathinfo の（ほぼ）上位互換で下記の差異がある。
 *
 * - パスは正規化される
 * - $flags 引数はない（指定した各部だけを返すことはできない）
 * - 要素が未設定になることはない（例えば extension は拡張子がなくても明示的に null が入る）
 *
 * 更に独自で下記のキーを返す。
 *
 * - dirlocalname: 親ディレクトリと localname の結合（≒フルパスから複数拡張子を除いたもの）
 * - localname: 複数拡張子を除いた filename
 * - extensions: 複数拡張子を配列で返す（拡張子がない場合は空配列）
 *
 * Example:
 * ```php
 * $DS = DIRECTORY_SEPARATOR;
 * that(path_parse('/path/to/file.min.css'))->isSame([
 *     'dirname'      => "{$DS}path{$DS}to",
 *     'basename'     => "file.min.css",
 *     'filename'     => "file.min",
 *     'extension'    => "css",
 *     // ここまでは（正規化はされるが） pathinfo と同じ
 *     // ここからは独自のキー
 *     'dirlocalname' => "{$DS}path{$DS}to{$DS}file",
 *     'localname'    => "file",
 *     'extensions'   => ["min", "css"],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $path パス文字列
 * @return array パスパーツ
 */
function path_parse($path)
{
    // dirname や extension など、キーの有無が分岐するのは使いにくいことこの上ないのでまずすべて null で埋める
    $pathinfo = array_replace([
        'dirname'   => null,
        'basename'  => null,
        'filename'  => null,
        'extension' => null,
    ], pathinfo(path_normalize($path)));

    $localname = $pathinfo['filename'];
    $extensions = (array) $pathinfo['extension'];

    while ((($info = pathinfo($localname))['extension'] ?? null) !== null) {
        $localname = $info['filename'];
        array_unshift($extensions, $info['extension']);
    }

    return [
        'dirname'      => path_normalize($pathinfo['dirname'] ?? ''),
        'basename'     => $pathinfo['basename'],
        'filename'     => $pathinfo['filename'],
        'extension'    => $pathinfo['extension'],
        'dirlocalname' => path_normalize(($pathinfo['dirname'] ?? '') . "/$localname"),
        'localname'    => $localname,
        'extensions'   => $extensions,
    ];
}
