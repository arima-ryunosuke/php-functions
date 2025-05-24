<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\array_flatten;
use function ryunosuke\Functions\Package\cidr2ip;
use function ryunosuke\Functions\Package\dns_resolve;
use function ryunosuke\Functions\Package\fcgi_request;
use function ryunosuke\Functions\Package\function_configure;
use function ryunosuke\Functions\Package\getipaddress;
use function ryunosuke\Functions\Package\http_benchmark;
use function ryunosuke\Functions\Package\http_delete;
use function ryunosuke\Functions\Package\http_get;
use function ryunosuke\Functions\Package\http_head;
use function ryunosuke\Functions\Package\http_patch;
use function ryunosuke\Functions\Package\http_post;
use function ryunosuke\Functions\Package\http_put;
use function ryunosuke\Functions\Package\http_request;
use function ryunosuke\Functions\Package\http_requests;
use function ryunosuke\Functions\Package\incidr;
use function ryunosuke\Functions\Package\ip2cidr;
use function ryunosuke\Functions\Package\ip_info;
use function ryunosuke\Functions\Package\ip_normalize;
use function ryunosuke\Functions\Package\json_storage;
use function ryunosuke\Functions\Package\ping;
use function ryunosuke\Functions\Package\rm_rf;
use function ryunosuke\Functions\Package\snmp_trap;
use function ryunosuke\Functions\Package\str_array;

class networkTest extends AbstractTestCase
{
    function test_cidr2ip()
    {
        that(cidr2ip("0.0.0.0/29"))->isSame(["0.0.0.0", "0.0.0.1", "0.0.0.2", "0.0.0.3", "0.0.0.4", "0.0.0.5", "0.0.0.6", "0.0.0.7"]);
        that(cidr2ip("0.0.0.0/30"))->isSame(["0.0.0.0", "0.0.0.1", "0.0.0.2", "0.0.0.3"]);
        that(cidr2ip("0.0.0.0/31"))->isSame(["0.0.0.0", "0.0.0.1"]);
        that(cidr2ip("0.0.0.0/32"))->isSame(["0.0.0.0"]);
        that(cidr2ip("0.0.0.255/29"))->isSame(["0.0.0.248", "0.0.0.249", "0.0.0.250", "0.0.0.251", "0.0.0.252", "0.0.0.253", "0.0.0.254", "0.0.0.255"]);
        that(cidr2ip("0.0.0.255/30"))->isSame(["0.0.0.252", "0.0.0.253", "0.0.0.254", "0.0.0.255"]);
        that(cidr2ip("0.0.0.255/31"))->isSame(["0.0.0.254", "0.0.0.255"]);
        that(cidr2ip("0.0.0.255/32"))->isSame(["0.0.0.255"]);

        that(self::resolveFunction('cidr2ip'))('hogera')->wasThrown('subnet addr');
        that(self::resolveFunction('cidr2ip'))('256.256.256.256')->wasThrown('subnet addr');
        that(self::resolveFunction('cidr2ip'))('127.0.0.0/hogera')->wasThrown('subnet mask');
        that(self::resolveFunction('cidr2ip'))('127.0.0.0/33')->wasThrown('subnet mask');
    }

    function test_cidrip_verification_of_accounts()
    {
        $list = [
            ['0.0.0.0', '0.0.0.14'],
            ['10.0.0.0', '10.0.0.255'],
            ['192.0.2.0', '192.0.2.130'],
            ['192.168.1.1', '192.168.2.64'],
            ['255.255.255.127', '255.255.255.255'],
        ];
        foreach ($list as [$min, $max]) {
            $expected = array_map('long2ip', range(ip2long($min), ip2long($max)));
            $actual = array_flatten(array_map(self::resolveFunction('cidr2ip'), self::resolveFunction('ip2cidr')($min, $max)));
            that($actual)->isSame($expected);
        }
    }

    function test_dns_resolve()
    {
        srand(time());

        $hosts = [
            // SOA
            ['host' => 'localdomain', 'type' => 'SOA', 'rname' => 'localdomain', 'minimum-ttl' => 33],
            // A
            ['host' => 'localhost.localdomain', 'type' => 'A', 'ip' => '127.0.0.1'],
            ['host' => 'localhost.localdomain', 'type' => 'A', 'ip' => '127.0.0.2'],
            // AAAA
            ['host' => 'localhost.localdomain', 'type' => 'AAAA', 'ipv6' => '2001:db8::0001', 'ttl' => 1],
            ['host' => 'localhost.localdomain', 'type' => 'AAAA', 'ipv6' => '2001:db8::0002', 'ttl' => 1],
            // MX
            ['host' => 'localhost.localdomain', 'type' => 'MX', 'target' => 'smtp1', 'pri' => 1],
            ['host' => 'localhost.localdomain', 'type' => 'MX', 'target' => 'smtp2', 'pri' => 2],
            // SRV
            ['host' => 'localhost.localdomain', 'type' => 'SRV', 'target' => 'srv11', 'port' => 80, 'pri' => 1, 'weight' => 1],
            ['host' => 'localhost.localdomain', 'type' => 'SRV', 'target' => 'srv12', 'port' => 80, 'pri' => 1, 'weight' => 2],
            ['host' => 'localhost.localdomain', 'type' => 'SRV', 'target' => 'srv21', 'port' => 80, 'pri' => 2, 'weight' => 1],
            // HINFO
            ['host' => 'localhost.localdomain', 'type' => 'HINFO', 'cpu' => 'intel', 'os' => 'windows'],
        ];

        // 普通の問い合わせ
        that(dns_resolve('localdomain', DNS_SOA, flush: true, hosts: $hosts))->is('localdomain');
        that(dns_resolve('localhost.localdomain', DNS_A, flush: true, hosts: $hosts))->isAny(['127.0.0.1', '127.0.0.2']);
        that(dns_resolve('localhost.localdomain', DNS_MX, flush: true, hosts: $hosts))->is('smtp1');
        that(dns_resolve('localhost.localdomain', DNS_SRV, flush: true, hosts: $hosts))->isAny(['srv11:80', 'srv12:80']);
        that(dns_resolve('localhost.localdomain', DNS_HINFO, flush: true, hosts: $hosts))->objectHasPropertyAll(['cpu', 'os']);

        // 特殊
        that(dns_resolve('192.168.1.1', DNS_A, flush: true, hosts: $hosts))->is('192.168.1.1');
        that(dns_resolve('2001:db8::', DNS_AAAA, flush: true, hosts: $hosts))->is('2001:db8::');
        that(dns_resolve('undefined.localdomain', DNS_A, flush: true, hosts: $hosts))->is(null);
        that(dns_resolve('undefined.localdomain', DNS_A, 'values', flush: true, hosts: $hosts))->is([]);

        // 各種 TTL
        that(dns_resolve('localdomain', DNS_SOA, 'raw', 11, 22, flush: true, hosts: $hosts))[0]['ttl']->is(11);
        that(dns_resolve('localdomain', DNS_SOA, 'raw', 11, 22, flush: false, hosts: $hosts))[0]['ttl']->is(11);
        that(dns_resolve('localdomain', DNS_A, 'raw', 11, 22, flush: false, hosts: $hosts))[0]['ttl']->is(33);
        that(dns_resolve('localdomain', DNS_A, 'raw', 11, 22, flush: true, hosts: $hosts))[0]['ttl']->is(33);
        // hosts にあるので $ttl0 が使用される
        that(dns_resolve('localhost.localdomain', DNS_A, 'raw', 11, 22, hosts: $hosts))[0]['ttl']->is(11);
        // hosts にないので $nxdomainTtl が使用される
        that(dns_resolve('undefined', DNS_A, 'raw', 11, 22, hosts: $hosts))[0]['ttl']->is(22);
        // 親に SOA があるので minimum-ttl が使用される
        that(dns_resolve('undefined.localdomain', DNS_A, 'raw', 11, 22, hosts: $hosts))[0]['ttl']->is(33);
        // 自身にも親にも SOA がないので $nxdomainTtl が使用される
        that(dns_resolve('undefined.hogera', DNS_A, 'raw', 11, 22, hosts: $hosts))[0]['ttl']->is(22);

        // values&all
        $actual = dns_resolve('localhost.localdomain', DNS_ALL, 'values', flush: true, hosts: $hosts);
        that($actual)['A']->is(['127.0.0.1', '127.0.0.2'], 0, true);
        that($actual)['AAAA']->is(['2001:db8::0001', '2001:db8::0002'], 0, true);
        that($actual)['MX']->is(['smtp1', 'smtp2'], 0, true);
        that($actual)['SRV']->is(['srv11:80', 'srv12:80', 'srv21:80'], 0, true);

        // cache
        that(dns_resolve('localhost.localdomain', DNS_A, ttl0: 10, hosts: $hosts))->isAny(['127.0.0.1', '127.0.0.2']);
        that(dns_resolve('localhost.localdomain', DNS_AAAA, ttl0: 10, hosts: $hosts))->isAny(['2001:db8::0001', '2001:db8::0002']);
        $hosts[1]['ip'] = '127.0.0.9';
        $hosts[2]['ip'] = '127.0.0.9';
        sleep(2);
        that(dns_resolve('localhost.localdomain', DNS_A, ttl0: 10, hosts: $hosts))->isAny(['127.0.0.1', '127.0.0.2']);
        that(dns_resolve('localhost.localdomain', DNS_AAAA, ttl0: 10, flush: true, hosts: $hosts))->isAny(['2001:db8::0001', '2001:db8::0002']);

        that(self::resolveFunction('dns_resolve'))("local,host")->wasThrown('is not a valid DNS name');
        // dns_resolve に変更があったのかバージョンによってエラーが出たりでなかったりする
        if (version_compare(PHP_VERSION, '8.1') <= 0) {
            that(self::resolveFunction('dns_resolve'))("192.168")->wasThrown('dns_get_record');
        }
    }

    function test_fcgi_request()
    {
        if (!defined('TESTFCGISERVER')) {
            return;
        }
        $server = TESTFCGISERVER;

        /* /var/www/html/echo.php に下記のようなスクリプトを配置しておく
        <?php
        header('x-dummy-header: dummy');

        error_log('error', 4);
        echo json_encode([
            'ENV'   => getenv(),
            'GET'   => $_GET,
            'POST'  => $_POST,
            'FILES' => $_FILES,
        ]);
         */

        // ペイロードが 128 分岐だったり 65535 チャンクだったりするので大きめに投げる
        $long_key = str_repeat('abc', 100);
        $long_value = str_repeat('xyz', 100);
        $long_post = str_repeat('abcdefg', 10000);

        // application/x-www-form-urlencoded
        $response = fcgi_request("$server/var/www/html/echo.php?q=123", [
            "X-DUMMY-ENV"                    => 'dummy',
            "X-DUMMY-LONGKEY-$long_key"      => 'L',
            "X-DUMMY-LONGVALUE"              => $long_value,
            "X-DUMMY-LONGKEYVALUE-$long_key" => $long_value,
        ], [
            'p'         => '456',
            'long-post' => $long_post,
        ]);
        [$head, $body] = preg_split("#(\r?\n){2}#", $response['stdout'], 2);
        $head = str_array($head, ':', true);
        $body = json_decode($body, true);

        that($head)['x-dummy-header']->is('dummy');
        that($body)['ENV']["X-DUMMY-ENV"]->is('dummy');
        that($body)['ENV']["X-DUMMY-LONGKEY-$long_key"]->is('L');
        that($body)['ENV']["X-DUMMY-LONGVALUE"]->is($long_value);
        that($body)['ENV']["X-DUMMY-LONGKEYVALUE-$long_key"]->is($long_value);
        that($body)['GET']['q']->is('123');
        that($body)['POST']['p']->is('456');
        that($body)['POST']['long-post']->is($long_post);

        // docker 環境だと docker が stderr を握ってるので出ないことがある
        that($response['stderr'])->isAny(['error', '']);

        // multipart/form-data
        $response = fcgi_request("$server/var/www/html/echo.php?q=123", [], [
            'p'    => '456',
            'file' => new \SplFileInfo(__FILE__),
        ]);
        [, $body] = preg_split("#(\r?\n){2}#", $response['stdout'], 2);
        $body = json_decode($body, true);

        that($body)['GET']['q']->is('123');
        that($body)['FILES']['file']['name']->is(basename(__FILE__));
        that($body)['FILES']['file']['size']->is(filesize(__FILE__));

        // generator
        $response = fcgi_request("$server/var/www/html/echo.php?q=123", [], (function () {
            yield from [
                'p'    => '456',
                'file' => new \SplFileInfo(__FILE__),
            ];
        })());
        [, $body] = preg_split("#(\r?\n){2}#", $response['stdout'], 2);
        $body = json_decode($body, true);

        that($body)['GET']['q']->is('123');
        that($body)['FILES']['file']['name']->is(basename(__FILE__));
        that($body)['FILES']['file']['size']->is(filesize(__FILE__));

        // misc
        ['client' => $client, 'params' => $params, 'stdin' => $stdin] = fcgi_request("$server/var/www/html/echo.php?q=123", [], (function () {
            yield from [
                'p'    => '456',
                'file' => new \SplFileInfo(__FILE__),
            ];
        })(), ['debug' => true]);

        that($client)->split('', 1)->is(['']);
        that($client)->split('abc', 1)->is(['a', 'b', 'c']);
        that($client)->split((function () { yield from []; })(), 1)->is(['']);
        that($client)->split((function () { yield from ['a', 'b', 'c']; })(), 1)->is(['a', 'b', 'c']);
        that($client)->split((function () { yield from ['a', 'bc', 'def']; })(), 2)->is(['ab', 'cd', 'ef']);

        that($params)->subsetEquals([
            "SCRIPT_FILENAME"   => "/var/www/html/echo.php",
            "QUERY_STRING"      => "q=123",
            "REQUEST_METHOD"    => "POST",
            "GATEWAY_INTERFACE" => "CGI/1.1",
        ]);
        that($params['CONTENT_TYPE'])->stringStartsWith("multipart/form-data; boundary=--");
        that($params['CONTENT_LENGTH'])->isNumeric();

        that($stdin)->isIterable();

        that(self::resolveFunction('fcgi_request'))("unix://run%2Fnotfound-dummy.socket", [], [], [])->wasThrown('Unable to connect to unix://');

        // ポートが開いているが fcgi ではないところに投げておかしなことにならないかテスト
        if (defined('TESTWEBSERVER')) {
            $parts = parse_url(TESTWEBSERVER);
            that(self::resolveFunction('fcgi_request'))("tcp://{$parts['host']}:{$parts['port']}", [], [], [])->wasThrown();
        }
    }

    function test_fcgi_request_conf()
    {
        $workingdir = self::$TMPDIR . '/rf-php-fpm';
        @mkdir($workingdir, 0777, true);
        $fpm_conf = "$workingdir/fpm.conf";

        touch("$workingdir/dummy.socket");
        file_put_contents($fpm_conf, "listen=$workingdir/dummy.socket");
        that(self::resolveFunction('fcgi_request'))("/dummy.php", [], [], [
            'fpmConf'        => $fpm_conf,
            'connectTimeout' => 0.1,
        ])->wasThrown('Unable to connect to unix://');

        file_put_contents($fpm_conf, "listen=0.0.0.0:9999");
        that(self::resolveFunction('fcgi_request'))("/dummy.php", [], [], [
            'fpmConf'        => $fpm_conf,
            'connectTimeout' => 0.1,
        ])->wasThrown('Unable to connect to tcp://');

        file_put_contents($fpm_conf, "listen=9999");
        that(self::resolveFunction('fcgi_request'))("/dummy.php", [], [], [
            'fpmConf'        => $fpm_conf,
            'connectTimeout' => 0.1,
        ])->wasThrown('Unable to connect to tcp://');
    }

    function test_getipaddress()
    {
        // 差し替えないとテストにならない
        $storage = json_storage(self::resolveFunction('getipaddress'));
        $storage['net_get_interfaces'] = [
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
        ];

        that(getipaddress())->isValidIpv4();
        that(getipaddress(AF_INET))->isValidIpv4();
        that(getipaddress(AF_INET6))->isValidIpv6();
        that(getipaddress('127.0.0.9'))->is('127.0.0.1');

        that(getipaddress('192.168.0.200'))->isNull();
        that(getipaddress('192.168.1.100'))->is('192.168.1.100');
        that(getipaddress('192.168.1.200'))->is('192.168.1.100');
        that(getipaddress('192.168.2.200'))->isNull();

        that(getipaddress('172.16.0.0'))->isNull();
        that(getipaddress('172.17.100.100'))->is('172.17.100.200');
        that(getipaddress('172.17.200.200'))->is('172.17.100.200');
        that(getipaddress('172.18.0.0'))->isNull();

        that(getipaddress('0001:0203:0405:0606:1111:1111:1111:1111'))->isNull();
        that(getipaddress('0001:0203:0405:0607:1111:1111:1111:1111'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:1234');
        that(getipaddress('0001:0203:0405:0607:ffff:ffff:ffff:ffff'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:1234');
        that(getipaddress('0001:0203:0405:0608:1111:1111:1111:1111'))->isNull();

        that(getipaddress('0001:0203:0405:0607:0809:0a0a:1111:1111'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:1234');
        that(getipaddress('0001:0203:0405:0607:0809:0a0b:1111:1111'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:5678');
        that(getipaddress('0001:0203:0405:0607:0809:0a0b:ffff:ffff'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:5678');
        that(getipaddress('0001:0203:0405:0607:0809:0a0c:1111:1111'))->is('0001:0203:0405:0607:0809:0a0b:0c0d:1234');

        $storage['net_get_interfaces'] = [];

        that(getipaddress())->isNull();
        that(self::resolveFunction('getipaddress'))('256.256.256.256')->wasThrown('is invalid ip address');
    }

    function test_http_benchmark()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;

        // 細かなテストはしない。カバレッジのみ
        $output = tmpfile();
        $result = http_benchmark([
            "$server/delay/1",
            "$server/delay/2",
        ],
            requests: 3,
            concurrency: 2,
            output: $output,
        );

        that($result)->isArray();
        that($result["$server/delay/1"]['status'])->is([200 => 3]);
        that($result["$server/delay/2"]['status'])->is([200 => 3]);

        rewind($output);
        $result = stream_get_contents($output);
        that($result)->contains('urls (n/c=3/2)');
        that($result)->contains('200:3');
        that($result)->contains("$server/delay/1");
        that($result)->contains("$server/delay/2");
    }

    function test_http_cache()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        $infos = [];

        $cachedir = self::$TMPDIR . '/http-cache';
        @mkdir($cachedir);
        rm_rf($cachedir, false);
        $response_header = null;
        $info = null;

        $response = http_get("$server/cache?k=v", [], [
            'cachedir' => $cachedir,
        ], $response_header, $info);
        that($info['http_code'])->is(200);
        that($response['args'])->is(['k' => 'v']);

        $response = http_get("$server/cache?k=v", [], [
            'cachedir' => $cachedir,
        ], $response_header, $info);
        that($info['http_code'])->is(304);
        that($response['args'])->is(['k' => 'v']);

        $response = http_get("$server/cache/5?k=v", [], [
            'cachedir' => $cachedir,
        ], $response_header, $info);
        that($info['no_request'])->isFalse();
        that($response['args'])->is(['k' => 'v']);

        $response = http_get("$server/cache/5?k=v", [], [
            'cachedir' => $cachedir,
        ], $response_header, $info);
        that($info['no_request'])->isTrue();
        that($response['args'])->is(['k' => 'v']);

        $responses = http_requests([
            'oncache' => [
                CURLOPT_URL => "$server/cache?k=v2",
                'cachedir'  => $cachedir,
            ],
            'nocache' => "$server/get?k=v2",
        ], [], [], $infos);
        that($responses['oncache']['args'])->is(['k' => 'v2']);
        that($responses['nocache']['args'])->is(['k' => 'v2']);
        that($infos['oncache'][0][0])->is('HTTP/1.1 200 OK');
        that($infos['oncache'][1]['no_request'])->isFalse();
        that($infos['nocache'][0][0])->is('HTTP/1.1 200 OK');
        that($infos['nocache'][1]['no_request'])->isFalse();

        $responses = http_requests([
            'oncache' => [
                CURLOPT_URL => "$server/cache?k=v2",
                'cachedir'  => $cachedir,
            ],
            'nocache' => "$server/get?k=v2",
        ], [], [], $infos);
        that($responses['oncache']['args'])->is(['k' => 'v2']);
        that($responses['nocache']['args'])->is(['k' => 'v2']);
        that($infos['oncache'][0][0])->is('HTTP/1.1 304 NOT MODIFIED');
        that($infos['oncache'][1]['no_request'])->isFalse();
        that($infos['nocache'][0][0])->is('HTTP/1.1 200 OK');
        that($infos['nocache'][1]['no_request'])->isFalse();

        $responses = http_requests([
            'oncache' => [
                CURLOPT_URL => "$server/cache/5?k=v2",
                'cachedir'  => $cachedir,
            ],
            'nocache' => "$server/get?k=v2",
        ], [], [], $infos);
        that($responses['oncache']['args'])->is(['k' => 'v2']);
        that($responses['nocache']['args'])->is(['k' => 'v2']);
        that($infos['oncache'][0][0])->is('HTTP/1.1 200 OK');
        that($infos['oncache'][1]['no_request'])->isFalse();
        that($infos['nocache'][0][0])->is('HTTP/1.1 200 OK');
        that($infos['nocache'][1]['no_request'])->isFalse();

        $responses = http_requests([
            'oncache' => [
                CURLOPT_URL => "$server/cache/5?k=v2",
                'cachedir'  => $cachedir,
            ],
            'nocache' => "$server/get?k=v2",
        ], [], [], $infos);
        that($responses['oncache']['args'])->is(['k' => 'v2']);
        that($responses['nocache']['args'])->is(['k' => 'v2']);
        that($infos['oncache'][0][0])->is('HTTP/1.1 200 OK');
        that($infos['oncache'][1]['no_request'])->isTrue();
        that($infos['nocache'][0][0])->is('HTTP/1.1 200 OK');
        that($infos['nocache'][1]['no_request'])->isFalse();
    }

    function test_http_method()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        $file = __DIR__ . '/files/image/test.png';

        $response = http_head("$server/get", ['k' => 'v']);
        that($response)->subsetEquals([
            'HTTP/1.1 200 OK',
            'Content-Type' => 'application/json',
        ]);

        $response = http_get("$server/get?k1=v1", [
            'k2' => 'v2',
            'k3' => 'v3',
        ]);
        that($response['args'])->is([
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ]);

        $response = http_post("$server/post?k1=v1", [
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

        $response = http_post("$server/post?k1=v1", [
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

        $response = http_post("$server/post?k1=v1", new \CURLFile($file));
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['headers']['Content-Type'])->is('image/png');
        that($response['data'])->contains(base64_encode(file_get_contents($file)));

        $response = http_put("$server/put?k1=v1", new \CURLFile($file), [
            'header' => [
                'Content-Type' => 'text/plain',
            ],
        ]);
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['headers']['Content-Type'])->is('text/plain');
        that($response['data'])->contains(base64_encode(file_get_contents($file)));

        $response = http_put("$server/put?k1=v1", json_encode([
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => 'v3',
        ]), [
            'header' => [
                'Content-Type' => 'text/plain',
            ],
        ]);
        that($response['data'])->is('{"k1":"v1","k2":"v2","k3":"v3"}');

        $response = http_patch("$server/patch?k1=v1", ['a' => 'A', 'b' => 'B']);
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['form'])->is([
            'a' => 'A',
            'b' => 'B',
        ]);

        $response = http_delete("$server/delete?k1=v1", ['a' => 'A', 'b' => 'B']);
        that($response['args'])->is([
            'k1' => 'v1',
        ]);
        that($response['form'])->is([
            'a' => 'A',
            'b' => 'B',
        ]);
    }

    function test_http_request()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;

        $response = http_request([
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

        $response = http_request([
            'url'    => "$server/html",
            'method' => "GET",
            'parser' => [
                'text/html' => [
                    'response' => function ($contents, $type, $charset) {
                        that($type)->is('text/html');
                        that($charset)->is('charset=utf-8');
                        $dom = new \DOMDocument();
                        $dom->loadHTML($contents);
                        return $dom;
                    },
                ],
            ],
        ]);
        that($response)->isInstanceOf(\DOMDocument::class);


        $cookie_file = self::$TMPDIR . '/cookie.txt';
        @unlink($cookie_file);
        $response = http_request([
            CURLOPT_URL   => "$server/cookies/set/hoge/fuga",
            'cookie_file' => $cookie_file,
        ]);
        that($response['cookies'])->is(['hoge' => 'fuga']);
        that($cookie_file)->fileExists();

        $response = http_request([
            CURLOPT_URL   => "$server/cookies",
            'cookie_file' => $cookie_file,
        ]);
        that($response['cookies'])->is(['hoge' => 'fuga']);

        $response = http_request([
            CURLOPT_URL => "$server/gzip",
        ]);
        that($response['gzipped'])->isTrue();

        that(self::resolveFunction('http_request'))([
            CURLOPT_URL => "$server/status/404",
            'throw'     => true,
        ])->wasThrown('404');

        that(self::resolveFunction('http_request'))([
            CURLOPT_URL => "http://0.0.0.0:801",
        ])->wasThrown("Couldn't connect");
    }

    function test_http_request_nobody()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        $response_header = null;
        $info = null;

        $response = http_request([
            CURLOPT_URL => "$server/stream-bytes/128",
            'nobody'    => true,
        ], $response_header, $info);
        that($response)->is('');
        that($response_header[0])->is('HTTP/1.1 200 OK');
        that($info['errno'])->is(CURLE_WRITE_ERROR);

        that(self::resolveFunction('http_request'))([
            CURLOPT_URL => "http://0.0.0.0:801",
            'nobody'    => true,
        ], $response_header, $info)->wasThrown("Couldn't connect");
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
        http_request([
            CURLOPT_URL => "$server/status/404",
            'retry'     => [1, 2, 3],
            'throw'     => false,
        ], $response_header, $info);
        that(microtime(true) - $time)->break()->isBetween(0.0, 0.2);
        that($info['retry'])->is(0);

        // 503 はリトライ対象。1,2,3 間隔なので計6秒かかる
        $time = microtime(true);
        http_request([
            CURLOPT_URL => "$server/status/503",
            'retry'     => [1, 2, 3],
            'throw'     => false,
        ], $response_header, $info);
        that(microtime(true) - $time)->break()->isBetween(6.0, 6.2);
        that($info['retry'])->is(3);

        // 接続失敗はリトライ対象ではない
        $time = microtime(true);
        try {
            http_request([
                CURLOPT_URL => "http://0.0.0.0:801",
                'retry'     => [1, 2, 3],
            ], $response_header, $info);
        }
        catch (\Throwable $t) {
            that($t->getMessage())->contains("Couldn't connect");
        }
        that(microtime(true) - $time)->break()->isBetween(0.0, 0.2);
        that($info['retry'])->is(0);

        // タイムアウトはリトライ対象。delay1 を 1,2,3 間隔なので計10秒かかる
        $time = microtime(true);
        try {
            http_request([
                CURLOPT_URL     => "$server/delay/3",
                CURLOPT_TIMEOUT => 1,
                'retry'         => [1, 2, 3],
            ], $response_header, $info);
        }
        catch (\Throwable $t) {
            that($t->getMessage())->contains('Timeout was reached');
        }
        that(microtime(true) - $time)->break()->isBetween(10.0, 10.2);
        that($info['retry'])->is(3);
    }

    function test_http_request_async()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        $response_header = null;
        $info = null;

        $response = http_request([
            CURLOPT_URL => "$server/status/200",
            'throw'     => true,
            'async'     => true,
        ], $response_header, $info);
        // 成功して response_header,info が代入されている
        that($response())->is('');
        that($response_header[0])->is('HTTP/1.1 200 OK');
        that($info['http_code'])->is(200);

        $response = http_request([
            CURLOPT_URL => "$server/status/503",
            'throw'     => true,
            'async'     => true,
        ]);
        // 例外は取得時に発生する
        that($response)->try(null)->wasThrown('status is 503');

        // delay1,2,3 を投げてさらに 3 秒待っても精々 4 秒程度に収まる
        $time = microtime(true);
        $res1 = http_request([
            CURLOPT_URL => "$server/delay/1",
            'async'     => true,
        ]);
        $res2 = http_request([
            CURLOPT_URL => "$server/delay/2",
            'async'     => true,
        ]);
        $res3 = http_request([
            CURLOPT_URL => "$server/delay/3",
            'async'     => true,
        ]);
        sleep(3);
        that($res1())->isArray();
        that($res2())->isArray();
        that($res3())->isArray();
        that(microtime(true) - $time)->break()->isBetween(3.0, 4.0);

        // リダイレクトでも大丈夫（ただし、サーバーに依存しそう）
        $time = microtime(true);
        $response = http_request([
            CURLOPT_URL => "$server/redirect-to?url=/delay/3",
            'async'     => true,
        ]);
        that($response())->isArray();
        that(microtime(true) - $time)->break()->isBetween(3.0, 4.0);

        // タイムアウト例外も効く
        $response = http_request([
            CURLOPT_URL     => "$server/delay/2",
            CURLOPT_TIMEOUT => 1,
            'async'         => true,
        ]);
        that($response)->try(null)->wasThrown('Timeout was reached');
    }

    function test_http_requests()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        $infos = [];

        $time = microtime(true);
        $responses = http_requests([
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
        that($time)->break()->isBetween(4.0, 4.5);
        that($responses)->count(3);
        that($responses['to'])->is(null);
        that($infos['to'][1]['errno'])->is(CURLE_OPERATION_TIMEOUTED);

        $time = microtime(true);
        $responses = http_requests([
            "$server/delay/5",
            "$server/delay/1",
            "$server/delay/1",
            "$server/delay/1",
            "$server/delay/1",
            "$server/delay/1",
            "$server/delay/1" => fn($key, $body) => "done!",
        ], [], [
            CURLMOPT_MAX_TOTAL_CONNECTIONS => 2,
        ]);
        $time = microtime(true) - $time;

        // 並列度2なので d5 のリクエスト中に順次 d1 が入れ替わり実行される
        // つまり d1 は d5 に巻きこまれる形で5つまでは並列だが、最後の1つは個別で実行されるので約6秒で完了することになる
        that($time)->break()->isBetween(6.0, 6.5);
        that($responses)->count(7);
        // さらに最後の要素はコールバック指定なので返り値が変わっている
        that($responses["$server/delay/1"])->is('done!');

        that(self::resolveFunction('http_requests'))([
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
        $responses = http_requests([
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
        that($time)->break()->isBetween(5.0, 5.5);
        that($responses)->count(3);
        that(array_column(array_column($infos, 1), 'retry'))->is([0, 1, 2]);

        $stocks = [];
        $time = microtime(true);
        $responses = http_requests([
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
        that($time)->break()->isBetween(3.0, 3.5);
        that($responses)->count(3);
        // 3本のリクエストがリトライ3回（トータル4回）なので12個のUUIDが生成されており、かつすべてユニークになっているはず
        that(array_unique($stocks))->count(12);
    }

    function test_incidr()
    {
        that(incidr("192.168.1.1", "192.168.1.1"))->isSame(true);
        that(incidr("192.168.1.1", "192.168.1.1/1"))->isSame(true);
        that(incidr("192.168.1.1", "192.168.1.0/24"))->isSame(true);
        that(incidr("192.168.1.1", "1.2.3.4/1"))->isSame(false);
        that(incidr("192.168.1.1", ["1.2.3.4/1", "192.168.1.0/24"]))->isSame(true);
        that(incidr("192.168.1.1", ["192.168.1.0/24", "1.2.3.4/1"]))->isSame(true);
        that(incidr("192.168.1.1", ["1.2.3.4/1", "4.3.2.1/1"]))->isSame(false);
        that(incidr("1.2.3.4", "0.0.0.0/0"))->isSame(true);
        that(incidr("1.2.3.4", "192.168.1.0/0"))->isSame(true);

        that(incidr("192.168.0.0/16", "192.168.0.0/16"))->isSame(true);
        that(incidr("192.168.0.0/24", "192.168.0.0/16"))->isSame(true);
        that(incidr("192.168.0.0/16", "192.168.0.0/24"))->isSame(false);
        that(incidr("192.168.0.0/16", "192.168.0.32/27"))->isSame(false);
        that(incidr("192.168.0.32/27", "192.168.0.0/16"))->isSame(true);

        that(self::resolveFunction('incidr'))('192.168.1.1', '192.168.1.1/33')->wasThrown('subnet mask');
        that(self::resolveFunction('incidr'))('192.168.1.1', '192.168.1.1/x')->wasThrown('subnet mask');
        that(self::resolveFunction('incidr'))('1.2.3.4', '256.256.256/0')->wasThrown('subnet addr');
        that(self::resolveFunction('incidr'))('an_invalid_ip', '192.168.1.0/24')->wasThrown('subnet addr');
    }

    function test_ip2cidr()
    {
        that(ip2cidr("0.0.0.0", "0.0.0.0"))->isSame(["0.0.0.0/32"]);

        that(ip2cidr("0.0.0.0", "0.0.0.1"))->isSame(["0.0.0.0/31"]);
        that(ip2cidr("0.0.0.0", "0.0.0.2"))->isSame(["0.0.0.0/31", "0.0.0.2/32"]);

        that(ip2cidr("0.0.0.0", "0.0.0.3"))->isSame(["0.0.0.0/30"]);
        that(ip2cidr("0.0.0.0", "0.0.0.4"))->isSame(["0.0.0.0/30", "0.0.0.4/32"]);
        that(ip2cidr("0.0.0.0", "0.0.0.5"))->isSame(["0.0.0.0/30", "0.0.0.4/31"]);
        that(ip2cidr("0.0.0.0", "0.0.0.6"))->isSame(["0.0.0.0/30", "0.0.0.4/31", "0.0.0.6/32"]);

        that(ip2cidr("0.0.0.0", "0.0.0.7"))->isSame(["0.0.0.0/29"]);
        that(ip2cidr("0.0.0.0", "0.0.0.8"))->isSame(["0.0.0.0/29", "0.0.0.8/32"]);
        that(ip2cidr("0.0.0.0", "0.0.0.9"))->isSame(["0.0.0.0/29", "0.0.0.8/31"]);
        that(ip2cidr("0.0.0.0", "0.0.0.10"))->isSame(["0.0.0.0/29", "0.0.0.8/31", "0.0.0.10/32"]);
        that(ip2cidr("0.0.0.0", "0.0.0.11"))->isSame(["0.0.0.0/29", "0.0.0.8/30"]);
        that(ip2cidr("0.0.0.0", "0.0.0.12"))->isSame(["0.0.0.0/29", "0.0.0.8/30", "0.0.0.12/32"]);
        that(ip2cidr("0.0.0.0", "0.0.0.13"))->isSame(["0.0.0.0/29", "0.0.0.8/30", "0.0.0.12/31"]);
        that(ip2cidr("0.0.0.0", "0.0.0.14"))->isSame(["0.0.0.0/29", "0.0.0.8/30", "0.0.0.12/31", "0.0.0.14/32"]);

        that(ip2cidr("0.0.0.0", "0.0.0.15"))->isSame(["0.0.0.0/28"]);
        that(ip2cidr("0.0.0.0", "0.0.0.16"))->isSame(["0.0.0.0/28", "0.0.0.16/32"]);

        that(ip2cidr("255.255.255.250", "255.255.255.255"))->isSame(["255.255.255.250/31", "255.255.255.252/30"]);

        that(ip2cidr("0.0.0.0", "255.255.255.255"))->isSame(["0.0.0.0/0"]);

        that(ip2cidr("0.0.0.1", "0.0.0.0"))->isSame([]);
        that(ip2cidr("0.0.1.0", "0.0.0.1"))->isSame([]);
        that(ip2cidr("0.0.1.1", "0.0.1.0"))->isSame([]);

        that(self::resolveFunction('ip2cidr'))('256.256.256.256', 'hogera')->wasThrown('is invalid');
        that(self::resolveFunction('ip2cidr'))('127.0.0.0', 'hogera')->wasThrown('is invalid');
        that(self::resolveFunction('ip2cidr'))('256.256.256.256', '127.0.0.0')->wasThrown('is invalid');
    }

    function test_ip_info()
    {
        if (!defined('TESTRIRSERVER')) {
            return;
        }

        $storage = function_configure('storagedir');
        rm_rf($storage, false);

        $options = [
            'rir' => [
                'afrinic' => TESTRIRSERVER . '/afrinic.csv',
                'apnic'   => TESTRIRSERVER . '/apnic.csv',
                'arin'    => TESTRIRSERVER . '/arin.csv',
                'lacnic'  => TESTRIRSERVER . '/lacnic.csv',
                'ripe'    => TESTRIRSERVER . '/ripe.csv',
            ],
        ];

        // warmup 兼 generate
        if (version_compare(PHP_VERSION, '8.2') >= 0) {
            /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
            memory_reset_peak_usage();
        }
        $current = memory_get_usage(true);
        $array = ip_info(null, ['cache' => false, 'readonly' => true] + $options);
        that($array)->count(0);
        $generator = ip_info(null, ['cache' => false, 'generate' => true] + $options);
        that($generator)->isInstanceOf(\Generator::class);
        $c = 0;
        foreach ($generator as $info) {
            assert(is_array($info));
            $c++;
        }
        that($c)->gt(200000);
        if (version_compare(PHP_VERSION, '8.2') >= 0) {
            that(memory_get_peak_usage() - $current)->lt(160_000_000);
        }

        that(ip_info("0.0.0.0", $options))->is([
            "cidr"      => "0.0.0.0/8",
            "ipaddress" => "0.0.0.0",
            "netmask"   => 8,
            "registry"  => "RFC1700",
            "cc"        => null,
            "date"      => null,
        ]);
        that(ip_info("127.0.0.0", $options))->is([
            "cidr"      => "127.0.0.0/8",
            "ipaddress" => "127.0.0.0",
            "netmask"   => 8,
            "registry"  => "RFC1122",
            "cc"        => null,
            "date"      => null,
        ]);

        that(ip_info(gethostbyname('www.nic.ad.jp'), $options))->is([
            "cidr"      => "192.41.192.0/24",
            "ipaddress" => "192.41.192.0",
            "netmask"   => 24,
            "registry"  => "apnic",
            "cc"        => "JP",
            "date"      => "19880620",
        ]);
        that(ip_info(gethostbyname('www.internic.net'), $options))->is([
            "cidr"      => "192.0.32.0/20",
            "ipaddress" => "192.0.32.0",
            "netmask"   => 20,
            "registry"  => "arin",
            "cc"        => "US",
            "date"      => "20090629",
        ]);
        // キャッシュのテスト
        that(ip_info(gethostbyname('www.internic.net'), $options))->is([
            "cidr"      => "192.0.32.0/20",
            "ipaddress" => "192.0.32.0",
            "netmask"   => 20,
            "registry"  => "arin",
            "cc"        => "US",
            "date"      => "20090629",
        ]);

        that(ip_info('100.64.0.0', $options))->is(null);
        that(ip_info('100.64.0.0', $options))->is(null); // キャッシュミスのテスト
        that(count(ip_info(null, $options)))->gt(100000);

        that(@ip_info("1.2.3.4", [
            'cache' => false,
            'throw' => false,
            'rir'   => [
                'afrinic' => TESTRIRSERVER . '/notfound.csv',
                'apnic'   => TESTRIRSERVER . '/notfound.csv',
                'arin'    => TESTRIRSERVER . '/notfound.csv',
                'lacnic'  => TESTRIRSERVER . '/notfound.csv',
                'ripe'    => TESTRIRSERVER . '/notfound.csv',
            ],
        ]))->is(null);

        that(self::resolveFunction('ip_info'))("1.2.3.4", [
            'cache' => false,
            'throw' => true,
            'rir'   => [
                'afrinic' => TESTRIRSERVER . '/notfound.csv',
                'apnic'   => TESTRIRSERVER . '/notfound.csv',
                'arin'    => TESTRIRSERVER . '/notfound.csv',
                'lacnic'  => TESTRIRSERVER . '/notfound.csv',
                'ripe'    => TESTRIRSERVER . '/notfound.csv',
            ],
        ])->wasThrown('404');
        that(self::resolveFunction('ip_info'))("hogera", $options)->wasThrown('is invalid');
        that(self::resolveFunction('ip_info'))("00:00:5e:ef:10:00:00:00", $options)->wasThrown('is not supported');
    }

    function test_ip_normalize()
    {
        // v4
        that(ip_normalize('127.0.0.1'))->is('127.0.0.1');
        that(ip_normalize('127.0.0xff.077'))->is('127.0.255.63');
        that(ip_normalize('0xff.077.500'))->isSame('255.63.1.244');

        that(ip_normalize('127.0.0'))->is('127.0.0.0');
        that(ip_normalize('127.0.255'))->is('127.0.0.255');
        that(ip_normalize('127.0.256'))->is('127.0.1.0');
        that(ip_normalize('127.0.65535'))->is('127.0.255.255');

        that(ip_normalize('127.0'))->is('127.0.0.0');
        that(ip_normalize('127.255'))->is('127.0.0.255');
        that(ip_normalize('127.256'))->is('127.0.1.0');
        that(ip_normalize('127.65535'))->is('127.0.255.255');
        that(ip_normalize('127.65536'))->is('127.1.0.0');
        that(ip_normalize('127.16777215'))->is('127.255.255.255');

        that(ip_normalize('0'))->is('0.0.0.0');
        that(ip_normalize('255'))->is('0.0.0.255');
        that(ip_normalize('256'))->is('0.0.1.0');
        that(ip_normalize('65535'))->is('0.0.255.255');
        that(ip_normalize('65536'))->is('0.1.0.0');
        that(ip_normalize('16777215'))->is('0.255.255.255');
        that(ip_normalize('16777216'))->is('1.0.0.0');
        that(ip_normalize('4294967295'))->is('255.255.255.255');

        that(self::resolveFunction('ip_normalize'))("1.2.3.4.5")->wasThrown('invalid ip');
        that(self::resolveFunction('ip_normalize'))("127.0.65536")->wasThrown('invalid ip');
        that(self::resolveFunction('ip_normalize'))("127.16777216")->wasThrown('invalid ip');
        that(self::resolveFunction('ip_normalize'))("4294967296")->wasThrown('invalid ip');
        that(self::resolveFunction('ip_normalize'))("-1")->wasThrown('invalid ip');
        that(self::resolveFunction('ip_normalize'))("0xz")->wasThrown();
        that(self::resolveFunction('ip_normalize'))("hoge")->wasThrown();
        that(self::resolveFunction('ip_normalize'))("")->wasThrown();

        // v6
        that(ip_normalize('000a:0000:0000:0000:0000:0000:0000:000f'))->is('000a:0000:0000:0000:0000:0000:0000:000f');

        that(ip_normalize('1::8'))->is('0001:0000:0000:0000:0000:0000:0000:0008');
        that(ip_normalize('1:2::8'))->is('0001:0002:0000:0000:0000:0000:0000:0008');
        that(ip_normalize('1:2:3::8'))->is('0001:0002:0003:0000:0000:0000:0000:0008');
        that(ip_normalize('1:2:3:4::8'))->is('0001:0002:0003:0004:0000:0000:0000:0008');
        that(ip_normalize('1:2:3:4:5::8'))->is('0001:0002:0003:0004:0005:0000:0000:0008');
        that(ip_normalize('1:2:3:4:5:6::8'))->is('0001:0002:0003:0004:0005:0006:0000:0008');
        that(ip_normalize('1:2:3:4:5:6:7:8'))->is('0001:0002:0003:0004:0005:0006:0007:0008');

        that(ip_normalize('a::'))->is('000a:0000:0000:0000:0000:0000:0000:0000');
        that(ip_normalize('::f'))->is('0000:0000:0000:0000:0000:0000:0000:000f');
        that(ip_normalize('::'))->is('0000:0000:0000:0000:0000:0000:0000:0000');
    }

    function test_ping()
    {
        if (!defined('TESTPINGSERVER')) {
            return;
        }
        $server = TESTPINGSERVER;
        $err = null;

        that(ping($server, 80, 1, $err))->isFloat();
        that($err)->isEmpty();

        that(ping($server, 888, 1, $err))->isNull();
        that($err)->isNotEmpty();

        that(ping($server, null, 1, $err))->isFloat();
        that($err)->isEmpty();

        that(ping("udp://128.0.0.1", 1234, 1, $err))->isFloat();
        that($err)->isEmpty();

        that(ping("unknown-host", 1234, 1, $err))->isNull();
        that($err)->isNotEmpty();

        that(ping("unknown-host", null, 1, $err))->isNull();
        that($err)->isNotEmpty();

        that(self::resolveFunction('ping'))("http://hostname")->wasThrown('is not supported');
    }

    function test_snmp_trap()
    {
        // 基本的に失敗しないし返り値もないのでカバレッジ目的
        that(snmp_trap(1, '127.0.0.1', 'public', '1.3.6.1.4.1.8072.3.2.10', 99, variables: [
            '1.1' => 123,
            '1.2' => 3.14,
            '1.3' => 'hoge',
        ]))->is(null);
        that(snmp_trap(2, '127.0.0.1', 'public', '1.3.6.1.4.1.8072.3.2.10', 99, variables: [
            '1.1' => 123,
            '1.2' => 3.14,
            '1.3' => 'hoge',
        ]))->is(null);
    }
}
