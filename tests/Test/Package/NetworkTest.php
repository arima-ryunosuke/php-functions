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
            'w1' => "$server/sleep.php?wait=1",
            'w2' => "$server/sleep.php?wait=2",
            'to' => [
                CURLOPT_URL     => "$server/sleep.php?wait=10",
                CURLOPT_TIMEOUT => 2,
            ],
        ]);
        $time = microtime(true) - $time;

        // トータルで最大である2秒程度（これがキモ。他はおまけに過ぎない）
        $this->assertRange(1.8, 2.2, $time);

        $this->assertEquals($responses['to'], CURLE_OPERATION_TIMEOUTED);
    }
}
