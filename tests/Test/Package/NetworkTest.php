<?php

namespace ryunosuke\Test\Package;

class NetworkTest extends AbstractTestCase
{
    function test_getipaddress()
    {
        that((getipaddress)())->matches('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#');

        @that([getipaddress, '256.256.256.256'])->throws('php_network_getaddresses');
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
            that([incidr, $v[1], $v[2]])->throws($v[0]);
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

        that((ping)("unknown-host", null, 1, $err))->isFalse();
        that($err)->isNotEmpty();

        that([ping, "http://hostname"])->throws('is not supported');
    }

    function test_http_requests()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;

        $time = microtime(true);
        $responses = (http_requests)([
            'w3' => "$server/sleep.php?wait=3",
            'w4' => "$server/sleep.php?wait=4",
            'to' => [
                CURLOPT_URL     => "$server/sleep.php?wait=10",
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
}
