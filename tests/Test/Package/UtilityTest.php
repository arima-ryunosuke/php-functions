<?php

namespace ryunosuke\Test\Package;

class UtilityTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_get_uploaded_files()
    {
        $actual = (get_uploaded_files)([
            // <input type="file" name="file1">
            'file1'   => [
                'name'     => '/home/file1',
                'type'     => 'text/plain',
                'tmp_name' => '/tmp/file1',
                'error'    => UPLOAD_ERR_NO_FILE,
                'size'     => 1,
            ],
            // <input type="file" name="file2[]">
            'file2'   => [
                'name'     => ['/home/file2'],
                'type'     => ['text/plain'],
                'tmp_name' => ['/tmp/file2'],
                'error'    => [UPLOAD_ERR_NO_FILE],
                'size'     => [2],
            ],
            // <input type="file" name="file2[]"> <input type="file" name="file2[]">
            'file2-2' => [
                'name'     => ['/home/file2-1', '/home/file2-2'],
                'type'     => ['text/plain', 'text/plain'],
                'tmp_name' => ['/tmp/file2-1', '/tmp/file2-2'],
                'error'    => [UPLOAD_ERR_NO_FILE, UPLOAD_ERR_NO_FILE],
                'size'     => [21, 22],
            ],
            // <input type="file" name="file3[0][sub]">
            'file3'   => [
                'name'     => [
                    ['sub' => '/home/file3'],
                ],
                'type'     => [
                    ['sub' => 'text/plain'],
                ],
                'tmp_name' => [
                    ['sub' => '/tmp/file3'],
                ],
                'error'    => [
                    ['sub' => UPLOAD_ERR_NO_FILE],
                ],
                'size'     => [
                    ['sub' => 3],
                ],
            ],
            // <input type="file" name="file4[0][sub1]"> <input type="file" name="file4[0][sub2]">
            'file3-2' => [
                'name'     => [
                    [
                        'sub1' => '/home/file3-1',
                        'sub2' => '/home/file3-2',
                    ],
                ],
                'type'     => [
                    [
                        'sub1' => 'text/plain',
                        'sub2' => 'text/plain',
                    ],
                ],
                'tmp_name' => [
                    [
                        'sub1' => '/tmp/file3-1',
                        'sub2' => '/tmp/file3-2',
                    ],
                ],
                'error'    => [
                    [
                        'sub1' => UPLOAD_ERR_NO_FILE,
                        'sub2' => UPLOAD_ERR_NO_FILE,
                    ],
                ],
                'size'     => [
                    [
                        'sub1' => 31,
                        'sub2' => 32,
                    ],
                ],
            ],
            // <input type="file" name="file4[0][sub]"> <input type="file" name="file4[1][sub]">
            'file4-2' => [
                'name'     => [
                    ['sub' => '/home/file4-1'],
                    ['sub' => '/home/file4-2'],
                ],
                'type'     => [
                    ['sub' => 'text/plain'],
                    ['sub' => 'text/plain'],
                ],
                'tmp_name' => [
                    ['sub' => '/tmp/file4-1'],
                    ['sub' => '/tmp/file4-2'],
                ],
                'error'    => [
                    ['sub' => UPLOAD_ERR_NO_FILE],
                    ['sub' => UPLOAD_ERR_NO_FILE],
                ],
                'size'     => [
                    ['sub' => 41],
                    ['sub' => 42],
                ],
            ],
        ]);
        $this->assertSame([
            'file1'   => [
                'name'     => '/home/file1',
                'type'     => 'text/plain',
                'tmp_name' => '/tmp/file1',
                'error'    => UPLOAD_ERR_NO_FILE,
                'size'     => 1,
            ],
            'file2'   => [
                [
                    'name'     => '/home/file2',
                    'type'     => 'text/plain',
                    'tmp_name' => '/tmp/file2',
                    'error'    => UPLOAD_ERR_NO_FILE,
                    'size'     => 2,
                ],
            ],
            'file2-2' => [
                [
                    'name'     => '/home/file2-1',
                    'type'     => 'text/plain',
                    'tmp_name' => '/tmp/file2-1',
                    'error'    => UPLOAD_ERR_NO_FILE,
                    'size'     => 21,
                ],
                [
                    'name'     => '/home/file2-2',
                    'type'     => 'text/plain',
                    'tmp_name' => '/tmp/file2-2',
                    'error'    => UPLOAD_ERR_NO_FILE,
                    'size'     => 22,
                ],
            ],
            'file3'   => [
                [
                    'sub' => [
                        'name'     => '/home/file3',
                        'type'     => 'text/plain',
                        'tmp_name' => '/tmp/file3',
                        'error'    => UPLOAD_ERR_NO_FILE,
                        'size'     => 3,
                    ],
                ],
            ],
            'file3-2' => [
                [
                    'sub1' => [
                        'name'     => '/home/file3-1',
                        'type'     => 'text/plain',
                        'tmp_name' => '/tmp/file3-1',
                        'error'    => UPLOAD_ERR_NO_FILE,
                        'size'     => 31,
                    ],
                    'sub2' => [
                        'name'     => '/home/file3-2',
                        'type'     => 'text/plain',
                        'tmp_name' => '/tmp/file3-2',
                        'error'    => UPLOAD_ERR_NO_FILE,
                        'size'     => 32,
                    ],
                ],
            ],
            'file4-2' => [
                [
                    'sub' => [
                        'name'     => '/home/file4-1',
                        'type'     => 'text/plain',
                        'tmp_name' => '/tmp/file4-1',
                        'error'    => UPLOAD_ERR_NO_FILE,
                        'size'     => 41,
                    ],
                ],
                [
                    'sub' => [
                        'name'     => '/home/file4-2',
                        'type'     => 'text/plain',
                        'tmp_name' => '/tmp/file4-2',
                        'error'    => UPLOAD_ERR_NO_FILE,
                        'size'     => 42,
                    ],
                ],
            ],
        ], $actual);
    }

    function test_cache()
    {
        $provider = function () {
            return sha1(uniqid(mt_rand(), true));
        };

        // 何度呼んでもキャッシュされるので一致する
        $current = (cache)('test', $provider, null, false);
        $this->assertEquals($current, (cache)('test', $provider, null, false));
        $this->assertEquals($current, (cache)('test', $provider, null, false));
        $this->assertEquals($current, (cache)('test', $provider, null, false));

        // 名前空間を変えれば異なる値が返る（ごく低確率でコケるが、無視していいレベル）
        $this->assertNotEquals($current, (cache)('test', $provider, __FUNCTION__, false));

        // null を与えると削除される
        $this->assertTrue((cache)('test', null, __FUNCTION__, false));
        $this->assertEquals(1, (cache)('test', function () { return 1; }, __FUNCTION__, false));
    }

    function test_cache_internal()
    {
        if (DIRECTORY_SEPARATOR !== '\\') {
            return;
        }

        $provider = function () {
            return sha1(uniqid(mt_rand(), true));
        };

        // 何度呼んでもキャッシュされるので一致する
        $current = (cache)('test', $provider, null, true);
        $this->assertEquals($current, (cache)('test', $provider, null, true));
        $this->assertEquals($current, (cache)('test', $provider, null, true));
        $this->assertEquals($current, (cache)('test', $provider, null, true));

        // 名前空間を変えれば異なる値が返る（ごく低確率でコケるが、無視していいレベル）
        $this->assertNotEquals($current, (cache)('test', $provider, __FUNCTION__, true));

        // null を与えると削除される
        $this->assertTrue((cache)('test', null, __FUNCTION__, true));
        $this->assertEquals(1, (cache)('test', function () { return 1; }, __FUNCTION__, true));
    }

    function test_process()
    {
        $file = sys_get_temp_dir() . '/rf-process.php';
        $stdout = null;
        $stderr = null;

        file_put_contents($file, '<?php
            fwrite(STDOUT, stream_get_contents(STDIN));
            fwrite(STDERR, "STDERR!");
            exit(123);
        ');
        $return = (process)(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
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
        $return = (process)(PHP_BINARY, $file, "STDIN!", $stdout, $stderr);
        $this->assertSame(0, $return);
        $this->assertSame(str_repeat("o", 100 * 1000), $stdout);
        $this->assertSame(str_repeat("e", 100 * 1000), $stderr);

        $return = (process)(PHP_BINARY, ['-r' => "syntax error"], '', $stdout, $stderr);
        $this->assertSame(254, $return);
        $this->assertContains('Parse error', "$stdout $stderr");

        $pingopt = DIRECTORY_SEPARATOR === '\\' ? '-n' : '-c';
        $return = (process)('ping', ["127.0.0.2", $pingopt => 1], '', $stdout, $stderr);
        $this->assertSame(0, $return);
        $this->assertContains('127.0.0.2', $stdout);
        $this->assertSame('', $stderr);

        $return = (process)('ping', "unknownhost", '', $stdout, $stderr);
        $this->assertNotSame(0, $return);
        $this->assertContains('unknownhost', "$stdout $stderr");

        (process)(PHP_BINARY, ['-r' => "echo getcwd();"], '', $stdout, $stderr, __DIR__);
        $this->assertSame(__DIR__, $stdout);

        (process)(PHP_BINARY, ['-r' => "echo getenv('HOGE');"], '', $stdout, $stderr, null, ['HOGE' => 'hoge']);
        $this->assertSame('hoge', $stdout);
    }

    function test_arguments()
    {
        // 超シンプル
        $this->assertSame(['arg1', 'arg2'], (arguments)([], 'arg1 arg2'));

        // 普通のオプション＋デフォルト引数
        $this->assertSame([
            'opt1' => 'O1',
            'opt2' => 'O2',
            'arg1',
            'arg2',
            'def3',
            'def4',
        ], (arguments)([
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
        ], (arguments)([
            'opt1 a' => '',
            'opt2 b' => '',
        ], '-a O1 -b O2 arg1 arg2'));

        // 値なしオプション
        $this->assertSame([
            'opt1' => true,
            'opt2' => false,
            'arg1',
            'arg2',
        ], (arguments)([
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
        ], (arguments)([
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
        ], (arguments)([
            'opt1 a' => 'def1',
            'opt2 b' => 'def2',
        ], '-a O1 arg1 arg2'));

        // 複数値オプション
        $this->assertSame([
            'opt1' => ['O11', 'O12'],
            'opt2' => ['O21'],
            'arg1',
            'arg2',
        ], (arguments)([
            'opt1 a' => [],
            'opt2 b' => [],
        ], '-a O11 -a O12 -b O21 arg1 arg2'));

        // クオーティング
        $this->assertSame([
            'opt' => 'A B',
            'arg1 arg2',
            'a"b'
        ], (arguments)([
            'opt' => '',
        ], '--opt "A B" "arg1 arg2" "a\\"b"'));

        // ルール不正
        $this->assertException('duplicated option name', arguments, ['opt1' => null, 'opt1 o' => null]);
        $this->assertException('duplicated short option', arguments, ['opt1 o' => null, 'opt2 o' => null]);

        // 知らんオプションが与えられた
        $this->assertException('undefined option name', arguments, [], 'arg1 arg2 --hoge');
        $this->assertException('undefined short option', arguments, [], 'arg1 arg2 -h');
        $this->assertException('undefined short option', arguments, ['o1 a' => null, 'o2 b' => null], 'arg1 arg2 -abc');

        // 複数指定された
        $this->assertException('specified already', arguments, ['noreq n' => null], '--noreq arg1 arg2 -n');
        $this->assertException('specified already', arguments, ['opt a' => ''], '--opt O1 arg1 arg2 -a O2');

        // 値が指定されていない
        $this->assertException('requires value', arguments, ['req' => 'hoge'], 'arg1 arg2 --req');
    }

    function test_stacktrace()
    {
        function test_stacktrace_in()
        {
            return (stacktrace)();
        }

        function test_stacktrace()
        {
            $c = function () {
                return eval('return \ryunosuke\\Test\\Package\\test_stacktrace_in();');
            };
            return $c();
        }

        $mock = new class()
        {
            static function sm() { return test_stacktrace(); }

            function im() { return $this::sm(); }
        };

        $traces = explode("\n", $mock->im());
        $this->assertContains('test_stacktrace_in', $traces[0]);
        $this->assertContains('eval', $traces[1]);
        $this->assertContains('{closure}', $traces[2]);
        $this->assertContains('test_stacktrace', $traces[3]);
        $this->assertContains('::sm', $traces[4]);
        $this->assertContains('->im', $traces[5]);

        $traces = (stacktrace)([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    123456789,
                    'stringarg',
                    'long string long string long string',
                    new \Concrete('fields'),
                    ['a', 'b', 'c'],
                    ['a' => 'A', 'b' => 'B', 'c' => 'C'],
                    ['n' => ['e' => ['s' => ['t' => 'X']]]],
                    ['la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la'],
                ],
            ]
        ]);
        $this->assertContains('123456789', $traces);
        $this->assertContains('stringarg', $traces);
        $this->assertContains('long string long...(more 19 length)', $traces);
        $this->assertContains('Concrete{value:null, name:fields}', $traces);
        $this->assertContains('[a, b, c]', $traces);
        $this->assertContains('{a:A, b:B, c:C}', $traces);
        $this->assertContains('{n:{e:{s:{t:X}}}}', $traces);
        $this->assertContains('[la, la, la, la, la, la, la, la, la, la, la, la, la, la, la, la, ...(more 1 length)]', $traces);

        $traces = (stacktrace)([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
            ]
        ], '%s');
        $this->assertEquals('hoge', $traces);

        $traces = (stacktrace)([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    'abc',
                    ['a', 'b', 'c'],
                ],
            ]
        ], 2);
        $this->assertEquals('hoge:1 func(ab...(more 1 length), [a, b, ...(more 1 length)])', $traces);
    }

    function test_backtrace()
    {
        $mock = new class()
        {
            function m1($options) { return (backtrace)(0, $options); }

            function m2($options) { return $this->m1($options); }

            function m3($options) { return $this->m2($options); }
        };

        $traces = $mock->m3([
            'function' => 'm2',
            'limit'    => 2,
        ]);
        $this->assertCount(2, $traces);
        $this->assertArraySubset([
            'file'     => __FILE__,
            'function' => 'm2',
            'class'    => get_class($mock),
        ], $traces[0]);
        $this->assertArraySubset([
            'file'     => __FILE__,
            'function' => 'm3',
            'class'    => get_class($mock),
        ], $traces[1]);

        $traces = $mock->m3([
            'class' => function ($v) { return (str_contains)($v, 'class@anonymous'); },
            'limit' => 3,
        ]);
        $this->assertCount(3, $traces);
        $this->assertArraySubset([
            'file'     => __FILE__,
            'function' => 'm1',
            'class'    => get_class($mock),
        ], $traces[0]);
        $this->assertArraySubset([
            'file'     => __FILE__,
            'function' => 'm2',
            'class'    => get_class($mock),
        ], $traces[1]);
        $this->assertArraySubset([
            'file'     => __FILE__,
            'function' => 'm3',
            'class'    => get_class($mock),
        ], $traces[2]);

        $traces = $mock->m3([
            'class' => 'not found',
        ]);
        $this->assertCount(0, $traces);
    }

    function test_error()
    {
        ini_set('error_log', 'syslog');
        (error)('message1');
        ini_restore('error_log');

        $t = tmpfile();
        (error)('message2', $t);
        rewind($t);
        $contents = stream_get_contents($t);
        $this->assertContains('PHP Log:  message2', $contents);
        $this->assertContains(__FILE__, $contents);

        $t = (tmpname)();
        (error)('message3', $t);
        $contents = file_get_contents($t);
        $this->assertContains('PHP Log:  message3', $contents);
        $this->assertContains(__FILE__, $contents);

        $persistences = (reflect_callable)((error))->getStaticVariables()['persistences'];
        $this->assertCount(1, $persistences);
        $this->assertArrayHasKey($t, $persistences);
        $this->assertInternalType('resource', $persistences[$t]);

        $this->assertException('must be resource or string', error, 'int', 1);
    }

    function test_timer()
    {
        $time = (timer)(function () {
            usleep(10 * 1000);
        }, 10);
        // 0.01 秒を 10 回回すので 0.1 秒は超えるはず
        $this->assertGreaterThan(0.1, $time);

        $this->assertException('must be greater than', timer, function () { }, 0);
    }

    function test_benchmark()
    {
        $return = '';
        $t = microtime(true);
        $output = (ob_capture)(function () use (&$return) {
            $return = (benchmark)([
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
        @(benchmark)(['md5', 'sha1'], ['hoge'], 10, false);
        $this->assertContains('Results of sha1 and md5 are different', error_get_last()['message']);

        // usleep(15000) の平均実行時間は 15ms のはず（カバレッジが有効だとすごく遅いので余裕を持たしてる）
        $output = (benchmark)(['usleep'], [15000], 300, false);
        $this->assertLessThan(15 + 5, $output[0]['mills']);

        // 参照渡しも呼べる
        (benchmark)(['reset', 'end'], [['hoge']], 10, false);
        // エラーが出なければいいので assert はナシ

        // 例外系
        $this->assertException('caller is not callable', benchmark, ['notfunc']);
        $this->assertException('benchset is empty', benchmark, []);
        $this->assertException('duplicated benchname', benchmark, [
            [new \Concrete('hoge'), 'getName'],
            [new \Concrete('hoge'), 'getName'],
        ]);
    }
}
