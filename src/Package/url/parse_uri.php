<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../pcre/preg_capture.php';
require_once __DIR__ . '/../pcre/preg_splice.php';
require_once __DIR__ . '/../strings/concat.php';
// @codeCoverageIgnoreEnd

/**
 * parse_url の仕様を少しいじったもの
 *
 * parse_url とは下記が異なる。
 *
 * - "単一文字列" はホスト名とみなされる（parse_url はパスとみなされる）
 * - パートがなくてもキー自体は生成される（そしてその値は $default で指定したもの）
 * - query は配列で返す（parse_str される）
 * - パート値をスカラー値で返すことはできない（必ず8要素の配列を返す）
 *
 * Example:
 * ```php
 * // 完全指定
 * that(parse_uri('http://user:pass@localhost:80/path/to/file?id=1#hash'))->is([
 *     'scheme'   => 'http',
 *     'user'     => 'user',
 *     'pass'     => 'pass',
 *     'host'     => 'localhost',
 *     'port'     => '80',
 *     'path'     => '/path/to/file',
 *     'query'    => ['id' => 1],
 *     'fragment' => 'hash',
 * ]);
 * // デフォルト値つき
 * that(parse_uri('localhost/path/to/file', [
 *     'scheme'   => 'http', // scheme のデフォルト値
 *     'user'     => 'user', // user のデフォルト値
 *     'port'     => '8080', // port のデフォルト値
 *     'host'     => 'hoge', // host のデフォルト値
 * ]))->is([
 *     'scheme'   => 'http',      // scheme はないのでデフォルト値が使われている
 *     'user'     => 'user',      // user はないのでデフォルト値が使われている
 *     'pass'     => '',
 *     'host'     => 'localhost', // host はあるのでデフォルト値が使われていない
 *     'port'     => '8080',      // port はないのでデフォルト値が使われている
 *     'path'     => '/path/to/file',
 *     'query'    => [],
 *     'fragment' => '',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param string $uri パースする URI
 * @param array|string $default $uri に足りないパーツがあった場合のデフォルト値。文字列を与えた場合はそのパース結果がデフォルト値になる
 * @return array URI の各パーツ配列
 */
function parse_uri($uri, $default = [])
{
    /** @noinspection RequiredAttributes */
    $regex = "
            (?:(?<scheme>[a-z][-+.0-9a-z]*)://)?
            (?:
              (?: (?<user>(?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=])*)?
              (?::(?<pass>(?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=])*))?@)?
            )?
            (?<host>((?:\\[[0-9a-f:]+\\]) | (?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=]))*)
            (?::(?<port>\d{0,5}))?
            (?<path>(?:/(?: [-.~\\w!$&'()*+,;=:@] | %[0-9a-f]{2} )* )*)?
            (?:\\?(?<query>[^\\#]*))?
            (?:\\#(?<fragment>.*))?
        ";

    $default_default = [
        'scheme'   => '',
        'user'     => '',
        'pass'     => '',
        'host'     => '',
        'port'     => '',
        'path'     => '',
        'query'    => '',
        'fragment' => '',
    ];

    // 配列以外はパースしてそれをデフォルトとする
    if (!is_array($default)) {
        $default = preg_capture("#^$regex\$#ix", (string) $default, $default_default);
    }

    // パース。先頭の // はスキーム省略とみなすので除去する
    $uri = preg_splice('#^//#', '', $uri);
    $parts = preg_capture("#^$regex\$#ix", $uri, $default + $default_default);

    // 諸々調整（認証エンコード、IPv6、パス / の正規化、クエリ配列化）
    $parts['user'] = $parts['user'] === null ? null : rawurldecode($parts['user']);
    $parts['pass'] = $parts['pass'] === null ? null : rawurldecode($parts['pass']);
    $parts['host'] = $parts['host'] === null ? null : preg_splice('#^\\[(.+)]$#', '$1', $parts['host']);
    $parts['path'] = $parts['path'] === null ? null : rawurldecode(concat('/', ltrim($parts['path'], '/')));
    $parts['fragment'] = $parts['fragment'] === null ? null : rawurldecode($parts['fragment']);

    if (is_string($parts['query'])) {
        parse_str($parts['query'], $parts['query']);
    }

    return $parts;
}
