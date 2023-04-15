<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\process;
use function ryunosuke\Functions\Package\process_async;
use function tmpfile;

class execTest extends AbstractTestCase
{
    function test_process()
    {
        $str_resource = function ($string) {
            $handle = tmpfile();
            fwrite($handle, $string);
            return $handle;
        };

        $file = sys_get_temp_dir() . '/rf-process.php';
        $stdout = null;
        $stderr = null;

        file_put_contents($file, '<?php
            fwrite(STDOUT, stream_get_contents(STDIN));
            fwrite(STDERR, "STDERR!");
            exit(123);
        ');
        $return = process(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
        that($return)->isSame(123);
        that($stdout)->isSame('STDIN!');
        that($stderr)->isSame('STDERR!');

        file_put_contents($file, '<?php
            while (!feof(STDIN)) {
                $line = fgets(STDIN);
                fwrite(STDOUT, "out:$line");
                fwrite(STDERR, "err:$line");
            }
            exit(123);
        ');

        $stdin = $str_resource("a\nb\nc");
        $stdout = $str_resource("firstout\n");
        $stderr = $str_resource("firsterr\n");
        rewind($stdin);
        $return = process(PHP_BINARY, $file, $stdin, $stdout, $stderr);
        rewind($stdout);
        rewind($stderr);
        that($return)->isSame(123);
        that(stream_get_contents($stdout))->isSame("firstout\nout:a\nout:b\nout:c");
        that(stream_get_contents($stderr))->isSame("firsterr\nerr:a\nerr:b\nerr:c");

        $stdout = null;
        $stderr = null;

        file_put_contents($file, '<?php
            $out = str_repeat("o", 100);
            $err = str_repeat("e", 100);
            for ($i = 0; $i < 1000; $i++) {
                fwrite(STDOUT, $out);
                fwrite(STDERR, $err);
            }
        ');
        $return = process(PHP_BINARY, $file, "STDIN!", $stdout, $stderr);
        that($return)->isSame(0);
        that($stdout)->isSame(str_repeat("o", 100 * 1000));
        that($stderr)->isSame(str_repeat("e", 100 * 1000));

        $return = process(PHP_BINARY, ['-r' => "syntax error"], '', $stdout, $stderr);
        that($return)->isSame(version_compare(PHP_VERSION, '8.0.0') >= 0 ? 255 : 254);
        that("$stdout $stderr")->stringContains('Parse error');

        $pingopt = DIRECTORY_SEPARATOR === '\\' ? '-n' : '-c';
        $return = process('ping', ["127.0.0.2", $pingopt => 1], '', $stdout, $stderr);
        that($return)->isSame(0);
        that($stdout)->stringContains('127.0.0.2');
        that($stderr)->isSame('');

        $return = process('ping', "unknownhost", '', $stdout, $stderr);
        that($return)->isNotSame(0);
        that("$stdout $stderr")->stringContains('unknownhost');

        process(PHP_BINARY, ['-r' => "echo getcwd();"], '', $stdout, $stderr, __DIR__);
        that($stdout)->isSame(__DIR__);

        process(PHP_BINARY, ['-r' => "echo getenv('HOGE');"], '', $stdout, $stderr, null, getenv() + ['HOGE' => 'hoge']);
        that($stdout)->isSame('hoge');
    }

    function test_process_async()
    {
        $file = sys_get_temp_dir() . '/rf-process_async.php';
        $stdout = null;
        $stderr = null;

        file_put_contents($file, '<?php
            fwrite(STDOUT, stream_get_contents(STDIN));
            fwrite(STDERR, "STDERR!");
            exit(123);
        ');
        $process = process_async(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
        that($process)->isObject();
        that($process->stdout)->isSame('');
        that($process->stderr)->isSame('');

        $status = $process->status();
        that($status['command'])->contains('rf-process_async.php');
        that($status['pid'])->isInt();
        that($status['running'])->isTrue();
        that($status['exitcode'])->isSame(-1);

        that($process())->isSame(123);
        that($process())->isSame(123); // 2回呼んでも同じ値が返る
        that($process->stdout)->isSame('STDIN!');
        that($process->stderr)->isSame('STDERR!');

        $process = process_async(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
        that($process->terminate())->isTrue();
        that($process->terminate())->isTrue(); // 2回呼んでもエラーにならない
        $status = $process->status();
        that($status['command'])->contains('rf-process_async.php');
        that($status['pid'])->isInt();
        that($status['running'])->isFalse();

        file_put_contents($file, '<?php
            for ($i=0; $i<3; $i++) {
                sleep(1);
            }
        ');

        // close だと3秒かかる
        $process = process_async(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
        $process->setDestructAction('close');
        $time = microtime(true);
        unset($process);
        that(microtime(true) - $time)->gte(3);

        // terminate だと1秒もかからない
        $process = process_async(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
        $process->setDestructAction('terminate');
        $time = microtime(true);
        unset($process);
        that(microtime(true) - $time)->lte(1.5);

        gc_collect_cycles();
    }

    function test_process_parallel()
    {
        that(self::resolveFunction('process_parallel'))(static function ($rate = 9) {
            $result = 0;
            foreach (range(1, 10) as $n) {
                usleep(100 * 1000);
                $result += $n * $rate;
            }
            fwrite(STDOUT, "out:$result");
            fwrite(STDERR, "err:$result");
            return $result;
        }, ['x' => 1, [2], []])->isSame([
            'x' => [
                'status' => 0,
                'stdout' => 'out:55',
                'stderr' => 'err:55',
                'return' => 55,
            ],
            [
                'status' => 0,
                'stdout' => 'out:110',
                'stderr' => 'err:110',
                'return' => 110,
            ],
            [
                'status' => 0,
                'stdout' => 'out:495',
                'stderr' => 'err:495',
                'return' => 495,
            ],
        ])->break()->inElapsedTime(1.9); // 100ms の sleep を10回回すのを3回行うので合計3秒…ではなく並列なので1秒前後になる

        that(self::resolveFunction('process_parallel'))([
            static function ($rate) {
                $result = 0;
                foreach (range(1, 10) as $n) {
                    usleep(100 * 1000);
                    $result += $n * $rate;
                }
                fwrite(STDOUT, "out:$result");
                fwrite(STDERR, "err:$result");
                return $result;
            },
            'y' => static function ($rate = 2) {
                $result = 1;
                foreach (range(1, 10) as $n) {
                    usleep(100 * 1000);
                    $result *= $n * $rate;
                }
                fwrite(STDOUT, "out:$result");
                fwrite(STDERR, "err:$result");
                return $result;
            },
            'e' => static function () {
                exit(127);
            },
        ], [1, 'y' => []])->isSame([
            [
                'status' => 0,
                'stdout' => 'out:55',
                'stderr' => 'err:55',
                'return' => 55,
            ],
            'y' => [
                'status' => 0,
                'stdout' => 'out:3715891200',
                'stderr' => 'err:3715891200',
                'return' => 3715891200,
            ],
            'e' => [
                'status' => 127,
                'stdout' => '',
                'stderr' => '',
                'return' => null,
            ],
        ])->break()->inElapsedTime(1.9); // 100ms の sleep を10回回すのを2回行うので合計2秒…ではなく並列なので1秒前後になる
    }
}
