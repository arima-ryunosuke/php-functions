<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_head.php';
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
 * @return string|null MIME タイプ
 */
function file_mimetype($filename, $prefer_extension = [])
{
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

    switch (strtolower($parts['scheme'] ?? '')) {
        default:
        case 'file':
            return mime_content_type($filename) ?: null;

        case 'http':
        case 'https':
            $r = $c = [];
            http_head($filename, [], ['throw' => false], $r, $c);
            if ($c['http_code'] === 200) {
                return $c['content_type'] ?? null;
            }
            trigger_error("HEAD $filename {$c['http_code']}", E_USER_WARNING);
    }
}
