<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/concat.php';
require_once __DIR__ . '/../url/build_query.php';
// @codeCoverageIgnoreEnd

/**
 * parse_uri の逆
 *
 * URI のパーツを与えると URI として構築する。
 * パーツは不完全でも良い。例えば scheme を省略すると "://" すら付かない URI が生成される。
 *
 * "query" パートだけは配列が許容される。その場合クエリ文字列に変換される。
 *
 * Example:
 * ```php
 * // 完全指定
 * that(build_uri([
 *     'scheme'   => 'http',
 *     'user'     => 'user',
 *     'pass'     => 'pass',
 *     'host'     => 'localhost',
 *     'port'     => '80',
 *     'path'     => '/path/to/file',
 *     'query'    => ['id' => 1],
 *     'fragment' => 'hash',
 * ]))->isSame('http://user:pass@localhost:80/path/to/file?id=1#hash');
 * // 一部だけ指定
 * that(build_uri([
 *     'scheme'   => 'http',
 *     'host'     => 'localhost',
 *     'path'     => '/path/to/file',
 *     'fragment' => 'hash',
 * ]))->isSame('http://localhost/path/to/file#hash');
 * ```
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param array $parts URI の各パーツ配列
 * @param array $options オプション
 * @return string URI 文字列
 */
function build_uri($parts, $options = [])
{
    $parts += [
        'scheme'   => '',
        'user'     => '',
        'pass'     => '',
        'host'     => '',
        'port'     => '',
        'path'     => '',
        'query'    => '',
        'fragment' => '',
    ];
    $options = array_replace_recursive([
        'query' => [
            'index'     => 0,
            'bracket'   => null,
            'separator' => ini_get('arg_separator.output'),
        ],
    ], $options);

    $parts['user'] = rawurlencode($parts['user']);
    $parts['pass'] = rawurlencode($parts['pass']);
    $parts['host'] = filter_var($parts['host'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? "[{$parts['host']}]" : $parts['host'];
    $parts['path'] = ltrim($parts['path'], '/');
    if (is_array($parts['query'])) {
        $parts['query'] = build_query(
            $parts['query'],
            $options['query']['index'],
            $options['query']['separator'],
            \PHP_QUERY_RFC1738,
            $options['query']['bracket'],
        );
    }

    $uri = '';
    $uri .= concat($parts['scheme'], '://');
    $uri .= concat($parts['user'] . concat(':', $parts['pass']), '@');
    $uri .= concat($parts['host']);
    $uri .= concat(':', $parts['port']);
    $uri .= concat('/', $parts['path']);
    $uri .= concat('?', $parts['query']);
    $uri .= concat('#', rawurlencode($parts['fragment']));
    return $uri;
}
