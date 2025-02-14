<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/str_array.php';
// @codeCoverageIgnoreEnd

/**
 * 値の mimetype を返す
 *
 * 追加の引数で ; 区切りのパラメータを受け取れる。
 * mimetype は `タイプ/サブタイプ;引数=値` と規約されているので 引数=>値 の連想配列で受け取る。
 * したがって返り値は「タイプ/サブタイプ」の文字列で固定となる（ただし失敗時は null を返す）。
 * とは言っても finfo の仕様上、現状では charset しか返さない。
 *
 * Example:
 * ```php
 * // 普通の文字列は text/plain
 * that(var_mimetype('plain text', $parameters))->isSame('text/plain');
 * // $parameters で引数を受け取れる
 * that($parameters)->is(['charset' => 'us-ascii']);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 */
function var_mimetype($var, ?array &$parameters = null): ?string
{
    $parameters = [];

    $finfo = finfo_open(FILEINFO_MIME);
    try {
        // SplFileInfo 標準のファイルオブジェクトのようなものなので特別扱いする
        if ($var instanceof \SplFileInfo) {
            $mimetype = finfo_file($finfo, $var->getPathname()) ?: null;
        }
        else {
            $mimetype = finfo_buffer($finfo, $var) ?: null;
        }
    }
    finally {
        finfo_close($finfo);
    }

    if ($mimetype === null) {
        return null;
    }

    $parts = array_map('trim', explode(';', $mimetype));

    $result = array_shift($parts);
    $parameters = str_array($parts, '=', true);

    return $result;
}
