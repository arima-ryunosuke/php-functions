<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\build_query;
use function ryunosuke\Functions\Package\build_uri;
use function ryunosuke\Functions\Package\parse_query;
use function ryunosuke\Functions\Package\parse_uri;

class urlTest extends AbstractTestCase
{
    static function provideUri()
    {
        $gen = function ($scheme = '', $user = '', $pass = '', $host = '', $port = '', $path = '', $query = [], $fragment = '') {
            return compact('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment');
        };
        return [
            'full'          => [
                'uri'   => 'scheme://user:pass@host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('scheme', 'user', 'pass', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no schema'     => [
                'uri'   => 'user:pass@host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', 'user', 'pass', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no user'       => [
                'uri'   => ':pass@host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', 'pass', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no pass'       => [
                'uri'   => 'user@host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', 'user', '', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no auth'       => [
                'uri'   => 'host:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', 'host', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no host'       => [
                'uri'   => ':12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', '', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no port'       => [
                'uri'   => 'host/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', 'host', '', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no origin'     => [
                'uri'   => '/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', '', '', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no path'       => [
                'uri'   => '?op1=1&op2=2#hash',
                'parts' => $gen('', '', '', '', '', '', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'no query'      => [
                'uri'   => '#hash',
                'parts' => $gen('', '', '', '', '', '', [], 'hash'),
            ],
            'no query hash' => [
                'uri'   => '/path/to/hoge#hash',
                'parts' => $gen('', '', '', '', '', '/path/to/hoge', [], 'hash'),
            ],
            'no all'        => [
                'uri'   => '',
                'parts' => $gen(),
            ],
            'array query'   => [
                'uri'   => 'scheme://user:pass@127.0.0.1:12345/path/to/hoge?op%5B0%5D=1&op%5B1%5D=2#hash',
                'parts' => $gen('scheme', 'user', 'pass', '127.0.0.1', '12345', '/path/to/hoge', ['op' => [1, 2]], 'hash'),
            ],
            'signed auth'   => [
                'uri'   => 'scheme://user%2313:pass%40word@127.0.0.1:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('scheme', 'user#13', 'pass@word', '127.0.0.1', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'ipv4'          => [
                'uri'   => 'scheme://user:pass@127.0.0.1:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('scheme', 'user', 'pass', '127.0.0.1', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'ipv6'          => [
                'uri'   => 'scheme://user:pass@[2001:db8::1234:0:0:9abc]:12345/path/to/hoge?op1=1&op2=2#hash',
                'parts' => $gen('scheme', 'user', 'pass', '2001:db8::1234:0:0:9abc', '12345', '/path/to/hoge', ['op1' => 1, 'op2' => 2], 'hash'),
            ],
            'multibyte'     => [
                'uri'   => 'scheme://local.host/path/to/hoge?aaa=' . rawurlencode('あああ'),
                'parts' => $gen('scheme', '', '', 'local.host', '', '/path/to/hoge', ['aaa' => 'あああ'], ''),
            ],
        ];
    }

    function test_build_query()
    {
        $data = [
            'x' => [[1, 2]],
        ];

        that(build_query($data, 1))->is($expected = 'x%5B0%5D%5B%5D=1&x%5B0%5D%5B%5D=2');
        that(parse_query($expected, '&'))->is(['x' => [[1, 2]]]);
        that(build_query($data, 2))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D=2');
        that(parse_query($expected, '&'))->is(['x' => [[1, 2]]]);
        that(build_query($data, 9))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D=2');
        that(parse_query($expected, '&'))->is(['x' => [[1, 2]]]);

        that(build_query($data, 0))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D=2');
        that(parse_query($expected, '&'))->is(['x' => [[1, 2]]]);
        that(build_query($data, -1))->is($expected = 'x%5B0%5D%5B%5D=1&x%5B0%5D%5B%5D=2');
        that(parse_query($expected, '&'))->is(['x' => [[1, 2]]]);
        that(build_query($data, -2))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D=2');
        that(parse_query($expected, '&'))->is(['x' => [[1], [2]]]);
        that(build_query($data, -3))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D=2');
        that(parse_query($expected, '&'))->is(['x' => [[1], [2]]]);
        that(build_query($data, -9))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D=2');
        that(parse_query($expected, '&'))->is(['x' => [[1], [2]]]);
        that(build_query($data))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D=2');
        that(parse_query($expected, '&'))->is(['x' => [[1], [2]]]);

        $data = [
            'x' => [[1, [2], [[3]]]],
        ];

        that(build_query($data, 1))->is($expected = 'x%5B0%5D%5B%5D=1&x%5B0%5D%5B%5D%5B%5D=2&x%5B0%5D%5B%5D%5B%5D%5B%5D=3');
        that(parse_query($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(build_query($data, 2))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D%5B%5D=2&x%5B0%5D%5B2%5D%5B%5D%5B%5D=3');
        that(parse_query($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(build_query($data, 9))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D%5B0%5D=2&x%5B0%5D%5B2%5D%5B0%5D%5B0%5D=3');
        that(parse_query($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);

        that(build_query($data, 0))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D%5B0%5D=2&x%5B0%5D%5B2%5D%5B0%5D%5B0%5D=3');
        that(parse_query($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(build_query($data, -1))->is($expected = 'x%5B0%5D%5B%5D=1&x%5B0%5D%5B1%5D%5B%5D=2&x%5B0%5D%5B2%5D%5B0%5D%5B%5D=3');
        that(parse_query($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(build_query($data, -2))->is($expected = 'x%5B%5D%5B%5D=1&x%5B0%5D%5B%5D%5B%5D=2&x%5B0%5D%5B2%5D%5B%5D%5B%5D=3');
        that(parse_query($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(build_query($data, -3))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D%5B%5D=2&x%5B0%5D%5B%5D%5B%5D%5B%5D=3');
        that(parse_query($expected, '&'))->is(['x' => [[1, [[3]]], [[2]]]]);
        that(build_query($data, -9))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D%5B%5D=2&x%5B%5D%5B%5D%5B%5D%5B%5D=3');
        that(parse_query($expected, '&'))->is(['x' => [[1], [[2]], [[[3]]]]]);
        that(build_query($data))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D%5B%5D=2&x%5B%5D%5B%5D%5B%5D%5B%5D=3');
        that(parse_query($expected, '&'))->is(['x' => [[1], [[2]], [[[3]]]]]);

        $data = [
            'x' => ['y' => ['z' => '[]']],
        ];

        that(build_query($data, null, '&', PHP_QUERY_RFC1738, ['[', ']']))->is($expected = 'x[y][z]=%5B%5D');
        that(parse_query($expected, '&'))->is(['x' => ['y' => ['z' => '[]']]]);
        that(build_query($data, null, '&', PHP_QUERY_RFC1738, ['.', '']))->is($expected = 'x.y.z=%5B%5D');
        that(parse_query($expected, '&'))->is(['x.y.z' => '[]']);
        that(build_query($data, null, '&', PHP_QUERY_RFC1738, ['', '']))->is($expected = 'xyz=%5B%5D');
        that(parse_query($expected, '&'))->is(['xyz' => '[]']);
        that(build_query($data, null, '&', PHP_QUERY_RFC1738, '-'))->is($expected = 'x-y-z=%5B%5D');
        that(parse_query($expected, '&'))->is(['x-y-z' => '[]']);

        that(build_query(['x y z' => 'xyz'], null, '&', PHP_QUERY_RFC1738))->is($expected = 'x+y+z=xyz');
        that(parse_query($expected, '&', PHP_QUERY_RFC1738))->is(['x y z' => 'xyz']);
        that(build_query(['x y z' => 'xyz'], null, '&', PHP_QUERY_RFC3986))->is($expected = 'x%20y%20z=xyz');
        that(parse_query($expected, '&', PHP_QUERY_RFC3986))->is(['x y z' => 'xyz']);

        that(build_query([1, 2, 3], 'pre-'))->is('pre-0=1&pre-1=2&pre-2=3');
    }

    function test_build_uri()
    {
        foreach ($this->provideUri() as $title => $data) {
            that(build_uri($data['parts']))->as($title)->is($data['uri']);
        }

        // options:query
        $query = [
            'a' => [
                'b' => [
                    'c' => ['[', ']'],
                ],
            ],
        ];
        that(build_uri([
            'query' => $query,
        ], [
        ]))->is('?a%5Bb%5D%5Bc%5D%5B0%5D=%5B&a%5Bb%5D%5Bc%5D%5B1%5D=%5D');
        that(build_uri([
            'query' => $query,
        ], [
            'query' => [
                'bracket' => ['[', ']'],
            ],
        ]))->is('?a[b][c][0]=%5B&a[b][c][1]=%5D');
        that(build_uri([
            'query' => $query,
        ], [
            'query' => [
                'bracket' => ['[', ']'],
                'index'   => null,
            ],
        ]))->is('?a[b][c][]=%5B&a[b][c][]=%5D');
    }

    function test_parse_query()
    {
        that(parse_query('a=1&b[]=2'))->is([
            'a' => 1,
            'b' => [2],
        ]);
    }

    function test_parse_uri()
    {
        foreach ($this->provideUri() as $title => $data) {
            that(parse_uri($data['uri']))->as($title)->is($data['parts']);
        }

        // default array
        that(parse_uri('', [
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => 'defpath',
            'query'    => 'defquery',
            'fragment' => 'deffragment',
        ]))->is([
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => '/defpath',
            'query'    => ['defquery' => ''],
            'fragment' => 'deffragment',
        ]);

        // default string
        that(parse_uri('', 'defscheme://defuser:defpass@defhost:12345/defpath?defquery#deffragment'))->is([
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => '/defpath',
            'query'    => ['defquery' => ''],
            'fragment' => 'deffragment',
        ]);
    }

    function test_parse_uri_special()
    {
        // double slash
        that(parse_uri('//user:pass@host/path/to/hoge?op1=1&op2=2#hash'))->is([
            'scheme'   => '',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ]);

        // tripple slash
        that(parse_uri('///path/to/hoge?op1=1&op2=2#hash'))->is([
            'scheme'   => '',
            'user'     => '',
            'pass'     => '',
            'host'     => '',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ]);

        // no port value
        that(parse_uri('scheme://user:pass@host:/path/to/hoge?op1=1&op2=2#hash'))->is([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ]);

        // no path value
        that(parse_uri('scheme://user:pass@host?op1=1&op2=2#hash'))->is([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '',
            'query'    => ['op1' => 1, 'op2' => 2],
            'fragment' => 'hash',
        ]);

        // no query value
        that(parse_uri('scheme://user:pass@host/path/to/hoge?#hash'))->is([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => [],
            'fragment' => 'hash',
        ]);

        // no fragment value
        that(parse_uri('scheme://user:pass@host/path/to/hoge?#'))->is([
            'scheme'   => 'scheme',
            'user'     => 'user',
            'pass'     => 'pass',
            'host'     => 'host',
            'port'     => '',
            'path'     => '/path/to/hoge',
            'query'    => [],
            'fragment' => '',
        ]);
    }
}
