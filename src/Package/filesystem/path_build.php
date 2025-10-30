<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * パスをビルドする
 *
 * pathinfo で得られたパス配列を元にパス文字列を構築する。
 * pathinfo のパス配列は微妙に癖があるし、一部だけを書き換えたい状況も多いのでこういう関数があると便利なことがある。
 *
 * basename は一切使用せず filename+extension だけを使用するのでそれは留意。
 * また dirname が "." の場合、それはスルーされる。
 *
 * Example:
 * ```php
 * $DS = DIRECTORY_SEPARATOR;
 *
 * that(path_build(pathinfo('/full/path/name.ext')))->is("/full/path{$DS}name.ext");
 * that(path_build(pathinfo('/full/path/name.')))->is("/full/path{$DS}name.");
 * that(path_build(pathinfo('/full/path/name')))->is("/full/path{$DS}name");
 * that(path_build(pathinfo('/full/path/.ext')))->is("/full/path{$DS}.ext");
 * that(path_build(pathinfo('/full/path/')))->is("/full{$DS}path");
 * that(path_build(pathinfo('/full/path')))->is("/full{$DS}path");
 *
 * that(path_build(pathinfo('relative/name.ext')))->is("relative{$DS}name.ext");
 * that(path_build(pathinfo('relative/name.')))->is("relative{$DS}name.");
 * that(path_build(pathinfo('relative/name')))->is("relative{$DS}name");
 * that(path_build(pathinfo('relative/.ext')))->is("relative{$DS}.ext");
 * that(path_build(pathinfo('relative/')))->is("relative");
 * that(path_build(pathinfo('relative')))->is("relative");
 *
 * that(path_build(pathinfo('./relative/name.ext')))->is("relative{$DS}name.ext");
 * that(path_build(pathinfo('./relative/name.')))->is("relative{$DS}name.");
 * that(path_build(pathinfo('./relative/name')))->is("relative{$DS}name");
 * that(path_build(pathinfo('./relative/.ext')))->is("relative{$DS}.ext");
 * that(path_build(pathinfo('./relative/')))->is("relative");
 * that(path_build(pathinfo('./relative')))->is("relative");
 *
 * that(path_build(pathinfo('/root.ext')))->is("{$DS}root.ext");
 * that(path_build(pathinfo('/root.')))->is("{$DS}root.");
 * that(path_build(pathinfo('/root.')))->is("{$DS}root.");
 * that(path_build(pathinfo('/.ext')))->is("{$DS}.ext");
 * that(path_build(pathinfo('/')))->is($DS);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 */
function path_build(array $pathinfo): string
{
    $pathinfo += [
        "dirname"   => '',
        "filename"  => '',
        "extension" => null,
    ];

    $result = [];

    if (str_starts_with($pathinfo['dirname'], "." . DIRECTORY_SEPARATOR) || str_starts_with($pathinfo['dirname'], "./")) {
        $pathinfo['dirname'] = substr($pathinfo['dirname'], 2);
    }
    if (strlen($pathinfo['dirname']) && $pathinfo['dirname'] !== '.') {
        $result[] = $pathinfo['dirname'] === DIRECTORY_SEPARATOR ? '' : $pathinfo['dirname'];
    }

    if (strlen($pathinfo['filename']) && isset($pathinfo['extension'])) {
        $result[] = $pathinfo['filename'] . '.' . $pathinfo['extension'];
    }
    elseif (strlen($pathinfo['filename'])) {
        $result[] = $pathinfo['filename'];
    }
    elseif (isset($pathinfo['extension'])) {
        $result[] = '.' . $pathinfo['extension'];
    }

    if (!$result) {
        return '';
    }

    $result = implode(DIRECTORY_SEPARATOR, $result);
    return strlen($result) ? $result : DIRECTORY_SEPARATOR;
}
