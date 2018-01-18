<?php
namespace ryunosuke\Test\package;

class UtilityTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_cache()
    {
        $provider = function () {
            return sha1(uniqid(mt_rand(), true));
        };

        // 何度呼んでもキャッシュされるので 1 になる
        $current = cache('test', $provider, null, false);
        $this->assertEquals($current, cache('test', $provider, null, false));
        $this->assertEquals($current, cache('test', $provider, null, false));
        $this->assertEquals($current, cache('test', $provider, null, false));

        // 名前空間を変えれば異なる値が返る（ごく低確率でコケるが、無視していいレベル）
        $this->assertNotEquals($current, cache('test', $provider, __FUNCTION__, false));
    }

    function test_benchmark()
    {
        $return = '';
        $t = microtime(true);
        $output = ob_capture(function () use (&$return) {
            $return = benchmark([
                [new \Concrete('hoge'), 'getName'],
                function () { return 'hoge'; },
            ], [], 100);
        });

        // 2関数を100でベンチするので 200ms～400ms の間のはず（カバレッジが有効だとすごく遅いので余裕を持たしてる）
        $t = microtime(true) - $t;
        $this->assertGreaterThan(0.2, $t);
        $this->assertLessThan(0.4, $t);

        // それらしい結果が返ってきている
        $this->assertInternalType('string', $return[0]['name']);
        $this->assertInternalType('integer', $return[0]['called']);
        $this->assertInternalType('numeric', $return[0]['ratio']);

        // それらしい名前が振られている
        $this->assertContains('Concrete::getName', $output);
        $this->assertContains(__FILE__, $output);

        // return 検証
        @benchmark(['md5', 'sha1'], ['hoge'], 10, false);
        $this->assertContains('Results of sha1 and md5 are different', error_get_last()['message']);

        // 例外系
        $this->assertException('caller is not callable', function () { benchmark(['notfunc']); });
        $this->assertException('benchset is empty', function () { benchmark([]); });
        $this->assertException('duplicated benchname', function () {
            benchmark([
                [new \Concrete('hoge'), 'getName'],
                [new \Concrete('hoge'), 'getName'],
            ]);
        });
    }
}
