<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_head.php';
require_once __DIR__ . '/../strings/str_array.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * ファイルの mimetype を返す
 *
 * mime_content_type の http 対応版。
 * 変更点は下記。
 *
 * - http(s) に対応（HEAD メソッドで取得する）
 * - 失敗時に false ではなく null を返す
 *
 * for compatible: $prefer_extension と $parameters 引数は将来的に入れ替わる。
 *
 * Example:
 * ```php
 * that(file_mimetype(__FILE__))->is('text/x-php');
 * that(file_mimetype('http://httpbin.org/get?name=value'))->is('application/json');
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $filename ファイル名（URL）
 * @param array|bool $prefer_extension extension => mimetype のマップ（true を与えると組み込みを使用する）
 * @param ?array $parameters 引数=値 の連想配列
 * @return string|null MIME タイプ
 */
function file_mimetype($filename, $prefer_extension = [], ?array &$parameters = null)
{
    $parameters = [];

    $mimetypes = GENERAL_MIMETYPE;
    if (is_array($prefer_extension)) {
        $mimetypes = $prefer_extension + $mimetypes;
    }

    $parts = parse_url($filename) ?: [];

    if ($prefer_extension) {
        $extension = strtolower(pathinfo($parts['path'] ?? '', PATHINFO_EXTENSION));
        if (isset($mimetypes[$extension])) {
            return $mimetypes[$extension];
        }
    }

    $mimetype = match (strtolower($parts['scheme'] ?? '')) {
        default         => (function () use ($filename) {
            $finfo = finfo_open(FILEINFO_MIME);
            try {
                return finfo_file($finfo, $filename) ?: null;
            }
            finally {
                finfo_close($finfo);
            }
        })(),
        'http', 'https' => (function () use ($filename) {
            $r = $c = [];
            http_head($filename, [], ['throw' => false], $r, $c);
            if ($c['http_code'] === 200) {
                return $c['content_type'] ?? null;
            }
            trigger_error("HEAD $filename {$c['http_code']}", E_USER_WARNING);
        })(),
    };
    if ($mimetype === null) {
        return null;
    }

    $parts = array_map('trim', explode(';', $mimetype));

    $result = array_shift($parts);
    $parameters = str_array($parts, '=', true);

    return $result;
}
