<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/mb_compatible_encoding.php';
// @codeCoverageIgnoreEnd

/**
 * DataURL をデコードする
 *
 * Example:
 * ```php
 * that(dataurl_decode("data:text/plain;charset=US-ASCII,hello%2C%20world"))->isSame('hello, world');
 * that(dataurl_decode("data:text/plain;charset=US-ASCII;base64,aGVsbG8sIHdvcmxk", $metadata))->isSame('hello, world');
 * that($metadata)->is([
 *     "mimetype" => "text/plain",
 *     "charset"  => "US-ASCII",
 *     "base64"   => true,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param string $url DataURL
 * @param array $metadata スキームのメタ情報が格納される
 * @return ?string 元データ。失敗時は null
 */
function dataurl_decode($url, &$metadata = [])
{
    $pos = strpos($url, ',');
    $head = substr($url, 0, $pos);
    $body = substr($url, $pos + 1);

    if (!preg_match('#^data:(?<mimetype>[^;]+?)?(;charset=(?<charset>[^;]+?))?(;(?<base64>[^;]+?))?$#iu', $head, $matches, PREG_UNMATCHED_AS_NULL)) {
        return null;
    }

    $metadata = [
        'mimetype' => $matches['mimetype'] ?? null,
        'charset'  => $matches['charset'] ?? null,
        'base64'   => isset($matches['base64']),
    ];

    $decoder = function ($data) use ($metadata) {
        if ($metadata['base64']) {
            return base64_decode($data, true);
        }
        else {
            return rawurldecode($data);
        }
    };

    $decoded = $decoder($body);
    if ($decoded === false) {
        return null;
    }

    if ($metadata['charset'] !== null) {
        if (!(mb_compatible_encoding($metadata['charset'], mb_internal_encoding()) ?? true)) {
            $decoded = mb_convert_encoding($decoded, mb_internal_encoding(), $metadata['charset']);
        }
    }

    return $decoded;
}
