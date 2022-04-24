<?php

namespace ryunosuke\Test\Package;

class NetworkTest extends AbstractTestCase
{
    function test_getipaddress()
    {
        if (getenv('TEST_TARGET') === 'namespace') {
            return;
        }

        // cachedir を設定することで擬似的にインジェクションする
        $cachedir = (cachedir)();
        (cachedir)(sys_get_temp_dir() . '/' . __FUNCTION__);
        (cache)('net_get_interfaces', null, 'getipaddress');
        (cache)('net_get_interfaces', fn() => [
            'lo'   => [
                'unicast' => [
                    [
                        'family'  => AF_INET,
                        'address' => '127.0.0.1',
                        'netmask' => '255.0.0.0',
                    ],
                ],
            ],
            'hoge' => [
                'unicast' => [
                    [
                        'family'  => AF_INET,
                        'address' => '192.168.1.100',
                        'netmask' => '255.255.255.0',
                    ],
                    [
                        'family'  => AF_INET6,
                        'address' => '0001:0203:0405:0607:0809:0a0b:0c0d:5678',
                        'netmask' => 'ffff:ffff:ffff:ffff:ffff:ffff:0000:0000',
                    ],
                ],
            ],
            'fuga' => [
                'unicast' => [
                    [
                        'family'  => AF_INET,
                        'address' => '172.17.100.200',
                        'netmask' => '255.255.0.0',
                    ],
                    [
                        'family'  => AF_INET6,
                        'address' => '0001:0203:0405:0607:0809:0a0b:0c0d:1234',
                        'netmask' => 'ffff:ffff:ffff:ffff:0000:0000:0000:0000',
                    ],
                ],
            ],
        ], 'getipaddress');

        that((getipaddress)())->isValidIpv4();
        that((getipaddress)(AF_INET))->isValidIpv4();
        that((getipaddress)(AF_INET6))->isValidIpv6();
        that((getipaddress)('127.0.0.9'))->is('127.0.0.1');

        that((getipaddress)('192.168.0.200'))->isNull();
        that((getipaddress)('192.168.1.100'))->is('192.168.1.100');
        that((getipaddress)('192.168.1.200'))->is('192.168.1.100');
        that((getipaddress)('192.168.2.200'))->isNull();

        that((getipaddress)('172.16.0.0'))->isNull();
        that((getipaddress)('172.17.100.100'))->is('172.17.100.200');
        that((getipaddress)('172.17.200.200'))->is('172.17.100.200');
        that((getipaddress)('172.18.0.0'))->isNull();

        that((getipaddress)('0001:0203:0405:0606:1111:1111:1111:1111'))->isNull();
        that((getipaddress)('0001:0203:0405:0607:1111:1111:1111:1111'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:1234');
        that((getipaddress)('0001:0203:0405:0607:ffff:ffff:ffff:ffff'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:1234');
        that((getipaddress)('0001:0203:0405:0608:1111:1111:1111:1111'))->isNull();

        that((getipaddress)('0001:0203:0405:0607:0809:0a0a:1111:1111'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:1234');
        that((getipaddress)('0001:0203:0405:0607:0809:0a0b:1111:1111'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:5678');
        that((getipaddress)('0001:0203:0405:0607:0809:0a0b:ffff:ffff'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:5678');
        that((getipaddress)('0001:0203:0405:0607:0809:0a0c:1111:1111'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:1234');

        (cache)('net_get_interfaces', null, 'getipaddress');
        (cache)('net_get_interfaces', fn() => [], 'getipaddress');

        that((getipaddress)())->isNull();
        that(getipaddress)->try('256.256.256.256')->wasThrown('is invalid ip address');

        (cachedir)($cachedir);
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
        $infos = [];

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
        ], [], $infos);
        $time = microtime(true) - $time;

        // 普通に投げると(3+4+3)秒かかるが並列なので max(3, 4, 3) = 4 のはず
        that($time)->isBetween(4.0, 4.2);
        that($responses)->count(3);
        that($responses['to'])->is(null);
        that($infos['to'][1]['errno'])->is(CURLE_OPERATION_TIMEOUTED);

        $time = microtime(true);
        $responses = (http_requests)([
            "$server/delay/5",
            "$server/delay/1",
            "$server/delay/1",
            "$server/delay/1",
            "$server/delay/1",
            "$server/delay/1",
            "$server/delay/1",
        ], [], [
            CURLMOPT_MAX_TOTAL_CONNECTIONS => 2,
        ]);
        $time = microtime(true) - $time;

        // 並列度2なので d5 のリクエスト中に順次 d1 が入れ替わり実行される
        // つまり d1 は d5 に巻きこまれる形で5つまでは並列だが、最後の1つは個別で実行されるので約6秒で完了することになる
        that($time)->isBetween(6.0, 6.2);
        that($responses)->count(7);

        that(http_requests)->try([
            "$server/delay/1",
            "$server/delay/2" => [
                CURLOPT_TIMEOUT => 1,
            ],
        ], [], [
            'throw' => true,
        ])->wasThrown('curl_errno');
    }

    function test_http_requests_retry()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        $infos = [];

        $time = microtime(true);
        $responses = (http_requests)([
            's200' => "$server/status/200",
            's502' => [
                'url'   => "$server/status/502",
                'retry' => [1],
            ],
            's503' => [
                'url'   => "$server/status/503",
                'retry' => [2, 3],
            ],
        ], [], [], $infos);
        $time = microtime(true) - $time;

        // マルチのリトライはフェーズごとの最大値で max(1, 2) + max(3) なので約5秒かかる
        that($time)->isBetween(5.0, 5.2);
        that($responses)->count(3);
        that(array_column(array_column($infos, 1), 'retry'))->is([0, 1, 2]);

        $stocks = [];
        $time = microtime(true);
        $responses = (http_requests)([
            "$server/uuid",
            "$server/uuid",
            "$server/uuid",
        ], [
            'retry' => function ($info, $response) use (&$stocks) {
                $stocks[] = preg_split("#\R\R#u", $response)[1];
                // 3回目で成功とする
                if ($info['retry'] === 3) {
                    return 0;
                }
                return 1;
            },
        ], [], $infos);
        $time = microtime(true) - $time;

        // 同時に投げているので約3秒以上はかからない
        that($time)->isBetween(3.0, 3.2);
        that($responses)->count(3);
        // 3本のリクエストがリトライ3回（トータル4回）なので12個のUUIDが生成されており、かつすべてユニークになっているはず
        that(array_unique($stocks))->count(12);
    }

    function test_http_requests_compatible()
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

    function test_http_request_retry()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        $response_header = null;
        $info = null;

        // 404 はリトライ対象ではない
        $time = microtime(true);
        (http_request)([
            CURLOPT_URL => "$server/status/404",
            'retry'     => [1, 2, 3],
            'throw'     => false,
        ], $response_header, $info);
        that(microtime(true) - $time)->isBetween(0.0, 0.2);
        that($info['retry'])->is(0);

        // 503 はリトライ対象。1,2,3 間隔なので計6秒かかる
        $time = microtime(true);
        (http_request)([
            CURLOPT_URL => "$server/status/503",
            'retry'     => [1, 2, 3],
            'throw'     => false,
        ], $response_header, $info);
        that(microtime(true) - $time)->isBetween(6.0, 6.2);
        that($info['retry'])->is(3);

        // 接続失敗はリトライ対象ではない
        $time = microtime(true);
        try {
            (http_request)([
                CURLOPT_URL => "http://0.0.0.0:801",
                'retry'     => [1, 2, 3],
            ], $response_header, $info);
        }
        catch (\Throwable $t) {
            that($t->getMessage())->contains('Failed to connect');
        }
        that(microtime(true) - $time)->isBetween(0.0, 0.2);
        that($info['retry'])->is(0);

        // タイムアウトはリトライ対象。delay1 を 1,2,3 間隔なので計10秒かかる
        $time = microtime(true);
        try {
            (http_request)([
                CURLOPT_URL     => "$server/delay/3",
                CURLOPT_TIMEOUT => 1,
                'retry'         => [1, 2, 3],
            ], $response_header, $info);
        }
        catch (\Throwable $t) {
            that($t->getMessage())->contains('timed out after');
        }
        that(microtime(true) - $time)->isBetween(10.0, 10.2);
        that($info['retry'])->is(3);
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
