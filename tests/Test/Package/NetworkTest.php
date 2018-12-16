<?php

namespace ryunosuke\Test\Package;

class NetworkTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_http_requests()
    {
        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;

        $http_requests = http_requests;
        $time = microtime(true);
        $responses = $http_requests([
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

        $this->assertEquals($responses['w1'][1][0], 'HTTP/1.1 200 OK');
        $this->assertRange(0.8, 1.2, $responses['w1'][2]['total_time']);

        $this->assertEquals($responses['w2'][1][0], 'HTTP/1.1 200 OK');
        $this->assertRange(1.8, 2.2, $responses['w2'][2]['total_time']);

        $this->assertEquals($responses['to'], CURLE_OPERATION_TIMEOUTED);
    }
}
