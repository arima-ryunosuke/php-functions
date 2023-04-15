<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_head.php';
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
 * @return string|null MIME タイプ
 */
function file_mimetype($filename)
{
    $scheme = parse_url($filename, PHP_URL_SCHEME) ?? null;
    switch (strtolower($scheme)) {
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
