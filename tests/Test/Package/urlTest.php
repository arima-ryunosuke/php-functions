<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\base62_decode;
use function ryunosuke\Functions\Package\base62_encode;
use function ryunosuke\Functions\Package\dataurl_decode;
use function ryunosuke\Functions\Package\dataurl_encode;
use function ryunosuke\Functions\Package\query_build;
use function ryunosuke\Functions\Package\query_parse;
use function ryunosuke\Functions\Package\uri_build;
use function ryunosuke\Functions\Package\uri_parse;

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
            'encoded'       => [
                'uri'   => 'scheme://user:pass@127.0.0.1:12345/path/to/hoge?a=%3D%26%23#x%3D%26%23',
                'parts' => $gen('scheme', 'user', 'pass', '127.0.0.1', '12345', '/path/to/hoge', ['a' => '=&#'], 'x=&#'),
            ],
            'multibyte'     => [
                'uri'   => 'scheme://local.host/path/to/hoge?aaa=' . rawurlencode('あああ') . '#' . rawurlencode('いいい'),
                'parts' => $gen('scheme', '', '', 'local.host', '', '/path/to/hoge', ['aaa' => 'あああ'], 'いいい'),
            ],
        ];
    }

    function test_base62()
    {
        foreach ([0, 1, 15, 16, 255, 256, 1023, 1024] as $length) {
            $string = $length === 0 ? '' : random_bytes($length);
            $encoded = base62_encode($string, false);
            $decoded = base62_decode($encoded, false);
            that($decoded)->isSame($string);

            that($encoded)->isSame(base62_encode($string, true));
            that($decoded)->isSame(base62_decode($encoded, true));
        }

        foreach ([false, true] as $ext) {
            // string
            that(base62_encode(61, $ext))->isSame('3bl');
            that(base62_decode('3bl', $ext))->isSame('61');

            // zero byte
            $zerobytestring = "\0\0\0\0\0\0\0\0A";
            that(base62_encode($zerobytestring, $ext))->isSame('0000000013');
            that(base62_decode('0000000013', $ext))->isSame($zerobytestring);

            // invalid
            that(self::resolveFunction('base62_decode'))('a+z', $ext)->wasThrown('is not');
        }
    }

    function test_dataurl()
    {
        $dataurl = dataurl_encode("hello, world");
        $plaindata = dataurl_decode($dataurl, $metadata);
        that($dataurl)->is("data:text/plain;charset=US-ASCII;base64,aGVsbG8sIHdvcmxk");
        that($plaindata)->is("hello, world");
        that($metadata)->is([
            "mimetype" => "text/plain",
            "charset"  => "US-ASCII",
            "base64"   => true,
        ]);

        $dataurl = dataurl_encode("hello,\0world");
        $plaindata = dataurl_decode($dataurl, $metadata);
        that($dataurl)->is("data:application/octet-stream;charset=8bit;base64,aGVsbG8sAHdvcmxk");
        that($plaindata)->is("hello,\0world");
        that($metadata)->is([
            "mimetype" => "application/octet-stream",
            "charset"  => "8bit",
            "base64"   => true,
        ]);

        $dataurl = dataurl_encode("hello, world", ['base64' => false]);
        $plaindata = dataurl_decode($dataurl, $metadata);
        that($dataurl)->is("data:text/plain;charset=US-ASCII,hello%2C%20world");
        that($plaindata)->is("hello, world");
        that($metadata)->is([
            "mimetype" => "text/plain",
            "charset"  => "US-ASCII",
            "base64"   => false,
        ]);

        $dataurl = dataurl_encode("aGVsbG8sIHdvcmxk", ['mimetype' => '', 'charset' => '', 'base64' => null]);
        $plaindata = dataurl_decode($dataurl, $metadata);
        that($dataurl)->is("data:;base64,aGVsbG8sIHdvcmxk");
        that($plaindata)->is("hello, world");
        that($metadata)->is([
            "mimetype" => null,
            "charset"  => null,
            "base64"   => true,
        ]);

        $dataurl = dataurl_encode(mb_convert_encoding("あ,い,う", "sjis"), ['mimetype' => 'text/csv', 'charset' => 'sjis', 'base64' => true]);
        $plaindata = dataurl_decode($dataurl, $metadata);
        that($dataurl)->is("data:text/csv;charset=sjis;base64,gqAsgqIsgqQ=");
        that($plaindata)->is("あ,い,う");
        that($metadata)->is([
            "mimetype" => "text/csv",
            "charset"  => "sjis",
            "base64"   => true,
        ]);

        that(dataurl_decode('invalid dataurl'))->isNull();
        that(dataurl_decode('data:;base64,invalid & base64 & string'))->isNull();
    }

    function test_query()
    {
        $data = [
            'x' => [[1, 2]],
        ];

        that(query_build($data, 1))->is($expected = 'x%5B0%5D%5B%5D=1&x%5B0%5D%5B%5D=2');
        that(query_parse($expected, '&'))->is(['x' => [[1, 2]]]);
        that(query_build($data, 2))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D=2');
        that(query_parse($expected, '&'))->is(['x' => [[1, 2]]]);
        that(query_build($data, 9))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D=2');
        that(query_parse($expected, '&'))->is(['x' => [[1, 2]]]);

        that(query_build($data, 0))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D=2');
        that(query_parse($expected, '&'))->is(['x' => [[1, 2]]]);
        that(query_build($data, -1))->is($expected = 'x%5B0%5D%5B%5D=1&x%5B0%5D%5B%5D=2');
        that(query_parse($expected, '&'))->is(['x' => [[1, 2]]]);
        that(query_build($data, -2))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D=2');
        that(query_parse($expected, '&'))->is(['x' => [[1], [2]]]);
        that(query_build($data, -3))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D=2');
        that(query_parse($expected, '&'))->is(['x' => [[1], [2]]]);
        that(query_build($data, -9))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D=2');
        that(query_parse($expected, '&'))->is(['x' => [[1], [2]]]);
        that(query_build($data))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D=2');
        that(query_parse($expected, '&'))->is(['x' => [[1], [2]]]);

        $data = [
            'x' => [[1, [2], [[3]]]],
        ];

        that(query_build($data, 1))->is($expected = 'x%5B0%5D%5B%5D=1&x%5B0%5D%5B%5D%5B%5D=2&x%5B0%5D%5B%5D%5B%5D%5B%5D=3');
        that(query_parse($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(query_build($data, 2))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D%5B%5D=2&x%5B0%5D%5B2%5D%5B%5D%5B%5D=3');
        that(query_parse($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(query_build($data, 9))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D%5B0%5D=2&x%5B0%5D%5B2%5D%5B0%5D%5B0%5D=3');
        that(query_parse($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);

        that(query_build($data, 0))->is($expected = 'x%5B0%5D%5B0%5D=1&x%5B0%5D%5B1%5D%5B0%5D=2&x%5B0%5D%5B2%5D%5B0%5D%5B0%5D=3');
        that(query_parse($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(query_build($data, -1))->is($expected = 'x%5B0%5D%5B%5D=1&x%5B0%5D%5B1%5D%5B%5D=2&x%5B0%5D%5B2%5D%5B0%5D%5B%5D=3');
        that(query_parse($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(query_build($data, -2))->is($expected = 'x%5B%5D%5B%5D=1&x%5B0%5D%5B%5D%5B%5D=2&x%5B0%5D%5B2%5D%5B%5D%5B%5D=3');
        that(query_parse($expected, '&'))->is(['x' => [[1, [2], [[3]]]]]);
        that(query_build($data, -3))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D%5B%5D=2&x%5B0%5D%5B%5D%5B%5D%5B%5D=3');
        that(query_parse($expected, '&'))->is(['x' => [[1, [[3]]], [[2]]]]);
        that(query_build($data, -9))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D%5B%5D=2&x%5B%5D%5B%5D%5B%5D%5B%5D=3');
        that(query_parse($expected, '&'))->is(['x' => [[1], [[2]], [[[3]]]]]);
        that(query_build($data))->is($expected = 'x%5B%5D%5B%5D=1&x%5B%5D%5B%5D%5B%5D=2&x%5B%5D%5B%5D%5B%5D%5B%5D=3');
        that(query_parse($expected, '&'))->is(['x' => [[1], [[2]], [[[3]]]]]);

        $data = [
            'x' => ['y' => ['z' => '[]']],
        ];

        that(query_build($data, null, '&', PHP_QUERY_RFC1738, ['[', ']']))->is($expected = 'x[y][z]=%5B%5D');
        that(query_parse($expected, '&'))->is(['x' => ['y' => ['z' => '[]']]]);
        that(query_build($data, null, '&', PHP_QUERY_RFC1738, ['.', '']))->is($expected = 'x.y.z=%5B%5D');
        that(query_parse($expected, '&'))->is(['x.y.z' => '[]']);
        that(query_build($data, null, '&', PHP_QUERY_RFC1738, ['', '']))->is($expected = 'xyz=%5B%5D');
        that(query_parse($expected, '&'))->is(['xyz' => '[]']);
        that(query_build($data, null, '&', PHP_QUERY_RFC1738, '-'))->is($expected = 'x-y-z=%5B%5D');
        that(query_parse($expected, '&'))->is(['x-y-z' => '[]']);

        that(query_build(['x y z' => 'xyz'], null, '&', PHP_QUERY_RFC1738))->is($expected = 'x+y+z=xyz');
        that(query_parse($expected, '&', PHP_QUERY_RFC1738))->is(['x y z' => 'xyz']);
        that(query_build(['x y z' => 'xyz'], null, '&', PHP_QUERY_RFC3986))->is($expected = 'x%20y%20z=xyz');
        that(query_parse($expected, '&', PHP_QUERY_RFC3986))->is(['x y z' => 'xyz']);

        that(query_build([1, 2, 3], 'pre-'))->is('pre-0=1&pre-1=2&pre-2=3');
    }

    function test_query_parse()
    {
        that(query_parse('a=1&b[]=2'))->is([
            'a' => 1,
            'b' => [2],
        ]);

        $query = implode('&', [
            'single=1',
            'multiple[]=1',
            'multiple[]=2',
            'same2[]=1',
            'same1=1',
            'same1=2',
            'same1[]=3',
            'same2=2',
            'same2=3',
            'nest[key1][key2][]=123',
            'nest[key1][key2][]=456',
            'nameonly',
            '=valueonly',
            'foo[bar]baz=invalid',
            '&&&&&',
        ]);
        parse_str($query, $expected);
        that(query_parse($query, '&'))->is($expected);

        $query = implode('&', [
            'plusmark=+',
            'atmark=@',
            '%40mark1=@',
            'dot.name=1',
            'hyphen-name=1',
            'space name1=1',
            'space%20name2=2',
        ]);
        that(query_parse($query, '&', PHP_QUERY_RFC3986))->is([
            "plusmark"    => "+",
            "atmark"      => "@",
            "@mark1"      => "@",
            "dot.name"    => "1",
            "hyphen-name" => "1",
            "space name1" => "1",
            "space name2" => "2",
        ]);
    }

    function test_uri()
    {
        foreach ($this->provideUri() as $title => $data) {
            that(uri_build($data['parts']))->as($title)->is($data['uri']);
        }

        // options:query
        $query = [
            'a' => [
                'b' => [
                    'c' => ['[', ']'],
                ],
            ],
        ];
        that(uri_build([
            'query' => $query,
        ], [
        ]))->is('?a%5Bb%5D%5Bc%5D%5B0%5D=%5B&a%5Bb%5D%5Bc%5D%5B1%5D=%5D');
        that(uri_build([
            'query' => $query,
        ], [
            'query' => [
                'bracket' => ['[', ']'],
            ],
        ]))->is('?a[b][c][0]=%5B&a[b][c][1]=%5D');
        that(uri_build([
            'query' => $query,
        ], [
            'query' => [
                'bracket' => ['[', ']'],
                'index'   => null,
            ],
        ]))->is('?a[b][c][]=%5B&a[b][c][]=%5D');
    }

    function test_uri_parse()
    {
        foreach ($this->provideUri() as $title => $data) {
            that(uri_parse($data['uri']))->as($title)->is($data['parts']);
        }

        // default array
        that(uri_parse('', [
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
        that(uri_parse('', 'defscheme://defuser:defpass@defhost:12345/defpath?defquery#deffragment'))->is([
            'scheme'   => 'defscheme',
            'user'     => 'defuser',
            'pass'     => 'defpass',
            'host'     => 'defhost',
            'port'     => '12345',
            'path'     => '/defpath',
            'query'    => ['defquery' => ''],
            'fragment' => 'deffragment',
        ]);

        // keep null
        that(uri_parse('', [
            'scheme'   => null,
            'user'     => null,
            'pass'     => null,
            'host'     => null,
            'port'     => null,
            'path'     => null,
            'query'    => null,
            'fragment' => null,
        ]))->is([
            'scheme'   => null,
            'user'     => null,
            'pass'     => null,
            'host'     => null,
            'port'     => null,
            'path'     => null,
            'query'    => null,
            'fragment' => null,
        ]);
    }

    function test_uri_parse_special()
    {
        // double slash
        that(uri_parse('//user:pass@host/path/to/hoge?op1=1&op2=2#hash'))->is([
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
        that(uri_parse('///path/to/hoge?op1=1&op2=2#hash'))->is([
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
        that(uri_parse('scheme://user:pass@host:/path/to/hoge?op1=1&op2=2#hash'))->is([
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
        that(uri_parse('scheme://user:pass@host?op1=1&op2=2#hash'))->is([
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
        that(uri_parse('scheme://user:pass@host/path/to/hoge?#hash'))->is([
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
        that(uri_parse('scheme://user:pass@host/path/to/hoge?#'))->is([
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
