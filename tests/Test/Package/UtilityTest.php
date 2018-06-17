<?php

namespace ryunosuke\Test\Package;

use ryunosuke\Functions\Package\FileSystem;
use ryunosuke\Functions\Package\Funchand;

class UtilityTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_cache()
    {
        $cache = cache;
        $provider = function () {
            return sha1(uniqid(mt_rand(), true));
        };

        // 何度呼んでもキャッシュされるので一致する
        $current = $cache('test', $provider, null, false);
        $this->assertEquals($current, $cache('test', $provider, null, false));
        $this->assertEquals($current, $cache('test', $provider, null, false));
        $this->assertEquals($current, $cache('test', $provider, null, false));

        // 名前空間を変えれば異なる値が返る（ごく低確率でコケるが、無視していいレベル）
        $this->assertNotEquals($current, $cache('test', $provider, __FUNCTION__, false));

        // null を与えると削除される
        $this->assertTrue($cache('test', null, __FUNCTION__, false));
        $this->assertEquals(1, $cache('test', function () { return 1; }, __FUNCTION__, false));
    }

    function test_cache_internal()
    {
        if (DIRECTORY_SEPARATOR !== '\\') {
            return;
        }

        $cache = cache;
        $provider = function () {
            return sha1(uniqid(mt_rand(), true));
        };

        // 何度呼んでもキャッシュされるので一致する
        $current = $cache('test', $provider, null, true);
        $this->assertEquals($current, $cache('test', $provider, null, true));
        $this->assertEquals($current, $cache('test', $provider, null, true));
        $this->assertEquals($current, $cache('test', $provider, null, true));

        // 名前空間を変えれば異なる値が返る（ごく低確率でコケるが、無視していいレベル）
        $this->assertNotEquals($current, $cache('test', $provider, __FUNCTION__, true));

        // null を与えると削除される
        $this->assertTrue($cache('test', null, __FUNCTION__, true));
        $this->assertEquals(1, $cache('test', function () { return 1; }, __FUNCTION__, true));
    }

    function test_process()
    {
        $process = process;
        $file = sys_get_temp_dir() . '/rf-process.php';
        $stdout = null;
        $stderr = null;

        file_put_contents($file, '<?php
            fwrite(STDOUT, stream_get_contents(STDIN));
            fwrite(STDERR, "STDERR!");
            exit(123);
        ');
        $return = $process(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
        $this->assertSame(123, $return);
        $this->assertSame('STDIN!', $stdout);
        $this->assertSame('STDERR!', $stderr);

        file_put_contents($file, '<?php
            $out = str_repeat("o", 100);
            $err = str_repeat("e", 100);
            for ($i = 0; $i < 1000; $i++) {
                fwrite(STDOUT, $out);
                fwrite(STDERR, $err);
            }
        ');
        $return = $process(PHP_BINARY, $file, "STDIN!", $stdout, $stderr);
        $this->assertSame(0, $return);
        $this->assertSame(str_repeat("o", 100 * 1000), $stdout);
        $this->assertSame(str_repeat("e", 100 * 1000), $stderr);

        $return = $process(PHP_BINARY, ['-r' => "syntax error"], '', $stdout, $stderr);
        $this->assertSame(254, $return);
        $this->assertContains('Parse error', "$stdout $stderr");

        $pingopt = DIRECTORY_SEPARATOR === '\\' ? '-n' : '-c';
        $return = $process('ping', ["127.0.0.2", $pingopt => 1], '', $stdout, $stderr);
        $this->assertSame(0, $return);
        $this->assertContains('127.0.0.2', $stdout);
        $this->assertSame('', $stderr);

        $return = $process('ping', "unknownhost", '', $stdout, $stderr);
        $this->assertNotSame(0, $return);
        $this->assertContains('unknownhost', "$stdout $stderr");

        $process(PHP_BINARY, ['-r' => "echo getcwd();"], '', $stdout, $stderr, __DIR__);
        $this->assertSame(__DIR__, $stdout);

        $process(PHP_BINARY, ['-r' => "echo getenv('HOGE');"], '', $stdout, $stderr, null, ['HOGE' => 'hoge']);
        $this->assertSame('hoge', $stdout);
    }

    function test_arguments()
    {
        $arguments = arguments;
        // 超シンプル
        $this->assertSame(['arg1', 'arg2'], $arguments([], 'arg1 arg2'));

        // 普通のオプション＋デフォルト引数
        $this->assertSame([
            'opt1' => 'O1',
            'opt2' => 'O2',
            'arg1',
            'arg2',
            'def3',
            'def4',
        ], $arguments([
            'opt1' => '',
            'opt2' => '',
            'arg1',
            'arg2',
            'def3',
            'def4',
        ], '--opt1 O1 --opt2 O2 arg1 arg2'));

        // ショートオプション
        $this->assertSame([
            'opt1' => 'O1',
            'opt2' => 'O2',
            'arg1',
            'arg2',
        ], $arguments([
            'opt1 a' => '',
            'opt2 b' => '',
        ], '-a O1 -b O2 arg1 arg2'));

        // 値なしオプション
        $this->assertSame([
            'opt1' => true,
            'opt2' => false,
            'arg1',
            'arg2',
        ], $arguments([
            'opt1 a' => null,
            'opt2 b' => null,
        ], '-a arg1 arg2'));

        // 値なしショートオプションの同時指定
        $this->assertSame([
            'opt1' => true,
            'opt2' => false,
            'opt3' => true,
            'arg1',
            'arg2',
        ], $arguments([
            'opt1 a' => null,
            'opt2 b' => null,
            'opt3 c' => null,
        ], '-ac arg1 arg2'));

        // デフォルト値オプション
        $this->assertSame([
            'opt1' => 'O1',
            'opt2' => 'def2',
            'arg1',
            'arg2',
        ], $arguments([
            'opt1 a' => 'def1',
            'opt2 b' => 'def2',
        ], '-a O1 arg1 arg2'));

        // 複数値オプション
        $this->assertSame([
            'opt1' => ['O11', 'O12'],
            'opt2' => ['O21'],
            'arg1',
            'arg2',
        ], $arguments([
            'opt1 a' => [],
            'opt2 b' => [],
        ], '-a O11 -a O12 -b O21 arg1 arg2'));

        // ルール不正
        $this->assertException('duplicated option name', $arguments, ['opt1' => null, 'opt1 o' => null]);
        $this->assertException('duplicated short option', $arguments, ['opt1 o' => null, 'opt2 o' => null]);

        // 知らんオプションが与えられた
        $this->assertException('undefined option name', $arguments, [], 'arg1 arg2 --hoge');
        $this->assertException('undefined short option', $arguments, [], 'arg1 arg2 -h');
        $this->assertException('undefined short option', $arguments, ['o1 a' => null, 'o2 b' => null], 'arg1 arg2 -abc');

        // 複数指定された
        $this->assertException('specified already', $arguments, ['noreq n' => null], '--noreq arg1 arg2 -n');
        $this->assertException('specified already', $arguments, ['opt a' => ''], '--opt O1 arg1 arg2 -a O2');

        // 値が指定されていない
        $this->assertException('requires value', $arguments, ['req' => 'hoge'], 'arg1 arg2 --req');
    }

    function test_error()
    {
        $error = error;

        ini_set('error_log', 'syslog');
        $error('message1');
        ini_restore('error_log');

        $t = tmpfile();
        $error('message2', $t);
        rewind($t);
        $contents = stream_get_contents($t);
        $this->assertContains('PHP Log:  message2', $contents);
        $this->assertContains(__FILE__, $contents);

        $t = FileSystem::tmpname();
        $error('message3', $t);
        $contents = file_get_contents($t);
        $this->assertContains('PHP Log:  message3', $contents);
        $this->assertContains(__FILE__, $contents);

        $persistences = Funchand::reflect_callable($error)->getStaticVariables()['persistences'];
        $this->assertCount(1, $persistences);
        $this->assertArrayHasKey($t, $persistences);
        $this->assertInternalType('resource', $persistences[$t]);

        $this->assertException('must be resource or string', $error, 'int', 1);
    }

    function test_timer()
    {
        $timer = timer;
        $time = $timer(function () {
            usleep(10 * 1000);
        }, 10);
        // 0.01 秒を 10 回回すので 0.1 秒は超えるはず
        $this->assertGreaterThan(0.1, $time);

        $this->assertException('must be greater than', $timer, function () { }, 0);
    }

    function test_benchmark()
    {
        $benchmark = benchmark;
        $return = '';
        $t = microtime(true);
        $output = Funchand::ob_capture(function () use (&$return, $benchmark) {
            $return = $benchmark([
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
        @$benchmark(['md5', 'sha1'], ['hoge'], 10, false);
        $this->assertContains('Results of sha1 and md5 are different', error_get_last()['message']);

        // 参照渡しも呼べる
        $benchmark(['reset', 'end'], [['hoge']], 10, false);
        // エラーが出なければいいので assert はナシ

        // 例外系
        $this->assertException('caller is not callable', $benchmark, ['notfunc']);
        $this->assertException('benchset is empty', $benchmark, []);
        $this->assertException('duplicated benchname', $benchmark, [
            [new \Concrete('hoge'), 'getName'],
            [new \Concrete('hoge'), 'getName'],
        ]);
    }
}
