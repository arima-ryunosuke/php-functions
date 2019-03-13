<?php

namespace ryunosuke\Test\Package;

class NetworkTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_getipaddress()
    {
        $this->assertRegExp('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#', (getipaddress)());

        @$this->assertException('php_network_getaddresses', getipaddress, '256.256.256.256');
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
            $this->assertSame($v[0], (incidr)($v[1], $v[2]), json_encode($v));
        }

        $invaliddata = [
            ['subnet mask', '192.168.1.1', '192.168.1.1/33'],
            ['subnet addr', '1.2.3.4', '256.256.256/0'],
            ['ipaddr', 'an_invalid_ip', '192.168.1.0/24'],
        ];
        foreach ($invaliddata as $v) {
            $this->assertException($v[0], incidr, $v[1], $v[2]);
        }
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
        $this->assertLessThan(7, $time);

        $this->assertEquals($responses['to'], CURLE_OPERATION_TIMEOUTED);
    }
}
