<?php

namespace ryunosuke\Test\Package;

class NetworkTest extends AbstractTestCase
{
    function test_getipaddress()
    {
        that((getipaddress)())->matches('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#');

        @that(getipaddress)->try('256.256.256.256')->wasThrown('php_network_getaddresses');
    }

    function test_incidr()
    {
        $validdata = [
            [true, '192.168.1.1', '192.168.1.1'],
            [true, '192.168.1.1', '192.168.1.1/1'],
            [true, '192.168.1.1', '192.168.1.0/24'],
            [false, '192.168.1.1', '1.2.3.4/1'],
            [true, '192.168.1.1', ['1.2.3.4/1', '192.168.1.0/24']],
            [true, '192.168.1.1', ['192.168.1.0/24', '1.2.3.4/1']],
            [false, '192.168.1.1', ['1.2.3.4/1', '4.3.2.1/1']],
            [true, '1.2.3.4', '0.0.0.0/0'],
            [true, '1.2.3.4', '192.168.1.0/0'],
        ];
        foreach ($validdata as $v) {
            that((incidr)($v[1], $v[2]))->isSame($v[0]);
        }

        $invaliddata = [
            ['subnet mask', '192.168.1.1', '192.168.1.1/33'],
            ['subnet addr', '1.2.3.4', '256.256.256/0'],
            ['ipaddr', 'an_invalid_ip', '192.168.1.0/24'],
        ];
        foreach ($invaliddata as $v) {
            that(incidr)->try($v[1], $v[2])->wasThrown($v[0]);
        }
    }

    function test_ping()
    {
        if (!defined('TESTPINGSERVER')) {
            return;
        }
        $server = TESTPINGSERVER;
        $err = null;

        that((ping)($server, 80, 1, $err))->isFloat();
        that($err)->isEmpty();

        that((ping)($server, 888, 1, $err))->isFalse();
        that($err)->isNotEmpty();

        that((ping)($server, null, 1, $err))->isFloat();
        that($err)->isEmpty();

        that((ping)("udp://128.0.0.1", 1234, 1, $err))->isFloat();
        that($err)->isEmpty();

        that((ping)("unknown-host", 1234, 1, $err))->isFalse();
        that($err)->isNotEmpty();

        that((ping)("unknown-host", null, 1, $err))->isFalse();
        that($err)->isNotEmpty();

        that(ping)->try("http://hostname")->wasThrown('is not supported');
    }

    function test_http_requests()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;

        $time = microtime(true);
        $responses = (http_requests)([
            'w3' => "$server/delay/3",
            'w4' => "$server/delay/4",
            'to' => [
                CURLOPT_URL     => "$server/delay/10",
                CURLOPT_TIMEOUT => 3,
            ],
        ], [
            CURLOPT_TIMEOUT => 10,
        ]);
        $time = microtime(true) - $time;

        // 普通に投げると(3+4+3)秒かかるがそんなにかかっていないはず
        that($time)->lessThan(7);
        that($responses['to'])->is(CURLE_OPERATION_TIMEOUTED);
    }

    function test_http_request()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;

        $response = (http_request)([
            'url'    => "$server/post",
            'method' => "POST",
            'header' => [
                'Content-Type'     => 'application/json',
                'X-Custom-Header1' => 'value1',
                'X-Custom-Header2: value2',
            ],
            'cookie' => [
                'name1' => 'value1',
                'name2=value2',
                'name3' => '=va;ue3=',
            ],
            'body'   => [
                'x' => ['y' => ['z' => [1, 2, 3]]],
            ],
        ]);
        that($response['headers']['Content-Type'])->is('application/json');
        that($response['headers']['X-Custom-Header1'])->is('value1');
        that($response['headers']['X-Custom-Header2'])->is('value2');
        that($response['headers']['Cookie'])->is("name1=value1; name2=value2; name3=%3Dva%3Bue3%3D");
        that($response['data'])->is('{"x":{"y":{"z":[1,2,3]}}}');
        that($response['json'])->is(['x' => ['y' => ['z' => [1, 2, 3]]]]);

        $cookie_file = sys_get_temp_dir() . '/cookie.txt';
        @unlink($cookie_file);
        $response = (http_request)([
            CURLOPT_URL   => "$server/cookies/set/hoge/fuga",
            'cookie_file' => $cookie_file,
        ]);
        that($response['cookies'])->is(['hoge' => 'fuga']);
        that($cookie_file)->fileExists();

        $response = (http_request)([
            CURLOPT_URL   => "$server/cookies",
            'cookie_file' => $cookie_file,
        ]);
        that($response['cookies'])->is(['hoge' => 'fuga']);

        $response = (http_request)([
            CURLOPT_URL => "$server/gzip",
        ]);
        that($response['gzipped'])->isTrue();

        that(http_request)->try([
            CURLOPT_URL => "$server/status/404",
            'throw'     => true,
        ])->wasThrown('404');

        that(http_request)->try([
            CURLOPT_URL => "http://0.0.0.0:801",
        ])->wasThrown('Failed to connect');
    }

    function test_http_method()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        $file = __DIR__ . '/Network/test.png';

        $response = (http_head)("$server/get", ['k' => 'v']);
        that($response)->arraySubset([
            'HTTP/1.1 200 OK',
            'Content-Type' => 'application/json',
        ]);

        $response = (http_get)("$server/get?k1=v1", [
            'k2' => 'v2',
            'k3' => 'v3',
        ]);
        that($response['args'])->is([
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ]);

        $response = (http_post)("$server/post?k1=v1", [
            'k2' => [
                'k3' => 'v3',
            ],
        ]);
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['form'])->is([
            'k2[k3]' => 'v3',
        ]);

        $response = (http_post)("$server/post?k1=v1", [
            '@a' => $file,
            'b'  => ['@bb' => $file],
            '@c' => [$file, 'x' => ['y' => 'x'], $file],
            'd'  => [$file, 'x' => ['y' => 'x']],
        ]);
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['form'])->is([
            'c[x][y]' => 'x',
            'd[0]'    => $file,
            'd[x][y]' => 'x',
        ]);
        that($response['files'])->hasKeyAll(['a', 'b[bb]', 'c[0]', 'c[1]']);

        $response = (http_post)("$server/post?k1=v1", new \CURLFile($file));
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['headers']['Content-Type'])->is('image/png');
        that($response['data'])->contains(base64_encode(file_get_contents($file)));

        $response = (http_put)("$server/put?k1=v1", new \CURLFile($file), [
            'header' => [
                'Content-Type' => 'text/plain',
            ],
        ]);
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['headers']['Content-Type'])->is('text/plain');
        that($response['data'])->contains(base64_encode(file_get_contents($file)));

        $response = (http_put)("$server/put?k1=v1", json_encode([
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ]), [
            'header' => [
                'Content-Type' => 'text/plain',
            ],
        ]);
        that($response['data'])->is('{"k1":"v1","k2":"v2","k3":"v3"}');

        $response = (http_patch)("$server/patch?k1=v1", ['a' => 'A', 'b' => 'B']);
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['form'])->is([
            'a' => 'A',
            'b' => 'B',
        ]);

        $response = (http_delete)("$server/delete?k1=v1", ['a' => 'A', 'b' => 'B']);
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['form'])->is([
            'a' => 'A',
            'b' => 'B',
        ]);
    }

    function test_http_cache()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;

        $cachedir = sys_get_temp_dir() . '/http-cache';
        @mkdir($cachedir);
        (rm_rf)($cachedir, false);
        $response_header = null;
        $info = null;

        $response = (http_get)("$server/cache?k=v", [], [
            'cachedir' => $cachedir,
        ], $response_header, $info);
        that($info['http_code'])->is(200);
        that($response['args'])->is(['k' => 'v']);

        $response = (http_get)("$server/cache?k=v", [], [
            'cachedir' => $cachedir,
        ], $response_header, $info);
        that($info['http_code'])->is(304);
        that($response['args'])->is(['k' => 'v']);

        $response = (http_get)("$server/cache/5?k=v", [], [
            'cachedir' => $cachedir,
        ], $response_header, $info);
        that($info['no_request'])->isFalse();
        that($response['args'])->is(['k' => 'v']);

        $response = (http_get)("$server/cache/5?k=v", [], [
            'cachedir' => $cachedir,
        ], $response_header, $info);
        that($info['no_request'])->isTrue();
        that($response['args'])->is(['k' => 'v']);

        $responses = (http_requests)([
            'oncache' => [
                CURLOPT_URL => "$server/cache?k=v2",
                'cachedir'  => $cachedir,
            ],
            'nocache' => "$server/get?k=v2",
        ]);
        that($responses['oncache'][0]['args'])->is(['k' => 'v2']);
        that($responses['oncache'][1][0])->is('HTTP/1.1 200 OK');
        that($responses['oncache'][2]['no_request'])->isFalse();
        that($responses['nocache'][0]['args'])->is(['k' => 'v2']);
        that($responses['nocache'][1][0])->is('HTTP/1.1 200 OK');
        that($responses['nocache'][2]['no_request'])->isFalse();

        $responses = (http_requests)([
            'oncache' => [
                CURLOPT_URL => "$server/cache?k=v2",
                'cachedir'  => $cachedir,
            ],
            'nocache' => "$server/get?k=v2",
        ]);
        that($responses['oncache'][0]['args'])->is(['k' => 'v2']);
        that($responses['oncache'][1][0])->is('HTTP/1.1 304 NOT MODIFIED');
        that($responses['oncache'][2]['no_request'])->isFalse();
        that($responses['nocache'][0]['args'])->is(['k' => 'v2']);
        that($responses['nocache'][1][0])->is('HTTP/1.1 200 OK');
        that($responses['nocache'][2]['no_request'])->isFalse();

        $responses = (http_requests)([
            'oncache' => [
                CURLOPT_URL => "$server/cache/5?k=v2",
                'cachedir'  => $cachedir,
            ],
            'nocache' => "$server/get?k=v2",
        ]);
        that($responses['oncache'][0]['args'])->is(['k' => 'v2']);
        that($responses['oncache'][1][0])->is('HTTP/1.1 200 OK');
        that($responses['oncache'][2]['no_request'])->isFalse();
        that($responses['nocache'][0]['args'])->is(['k' => 'v2']);
        that($responses['nocache'][1][0])->is('HTTP/1.1 200 OK');
        that($responses['nocache'][2]['no_request'])->isFalse();

        $responses = (http_requests)([
            'oncache' => [
                CURLOPT_URL => "$server/cache/5?k=v2",
                'cachedir'  => $cachedir,
            ],
            'nocache' => "$server/get?k=v2",
        ]);
        that($responses['oncache'][0]['args'])->is(['k' => 'v2']);
        that($responses['oncache'][1][0])->is('HTTP/1.1 200 OK');
        that($responses['oncache'][2]['no_request'])->isTrue();
        that($responses['nocache'][0]['args'])->is(['k' => 'v2']);
        that($responses['nocache'][1][0])->is('HTTP/1.1 200 OK');
        that($responses['nocache'][2]['no_request'])->isFalse();
    }
}
