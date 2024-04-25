<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\include_stream;
use function ryunosuke\Functions\Package\memory_stream;
use function ryunosuke\Functions\Package\profiler;
use function ryunosuke\Functions\Package\var_stream;

class streamTest extends AbstractTestCase
{
    function test_include_stream()
    {
        $stream = include_stream();

        // もろもろのストリーム操作
        opcache_reset();
        $stream->register(fn($filename) => strtr(file_get_contents($filename), ['# ' => '']));
        $actual = include __DIR__ . '/files/php/fake.php';
        $stream->restore();
        that($actual)->is('123');

        // 全体を小文字化して読み込み
        opcache_reset();
        $stream->register(fn($filename) => strtolower(file_get_contents($filename)));
        $actual = include __DIR__ . '/files/php/include_stream.php';
        $stream->restore();
        that($actual)->is('hijkxyz');

        // 完全に置換して読み込み
        opcache_reset();
        $stream->register(fn($filename) => "<?php return 123;");
        $actual = include __DIR__ . '/files/php/include_stream.php';
        $stream->restore();
        that($actual)->is('123');

        // 存在しない場合
        opcache_reset();
        $stream->register(fn($filename) => file_get_contents($filename));
        @include __DIR__ . '/files/php/notfound.php';
        that(error_get_last()['message'])->stringContains('include(): Failed opening');
        $stream->restore();
    }

    function test_memory_stream()
    {
        $hoge = memory_stream('hoge');
        $fuga = memory_stream('fuga');
        $piyo = memory_stream('piyo');

        // f 系の一連の流れ
        $f = fopen($hoge, 'w+');
        that(stream_set_timeout($f, 5))->isFalse();
        that(flock($f, LOCK_EX))->is(true);
        that(fwrite($f, 'Hello'))->is(5);
        that(fwrite($f, 'World!'))->is(6);
        that(fseek($f, 3, SEEK_SET))->is(0);
        that(ftell($f))->is(3);
        that(feof($f))->is(false);
        that(fread($f, 3))->is('loW');
        that(fread($f, 1024))->is('orld!');
        that(fseek($f, 100, SEEK_SET))->is(0);
        that(fwrite($f, 'x'))->is(1);
        that(feof($f))->is(true);
        that(fflush($f))->is(true);
        that(ftruncate($f, 1024))->is(true);
        that(flock($f, LOCK_UN))->is(true);
        that(fclose($f))->is(true);
        that(filesize($hoge))->is(1024);

        // file_get/put_contents
        that(file_put_contents($hoge, 'hogera'))->is(6);
        that(file_get_contents($hoge))->is('hogera');
        that(file_put_contents($hoge, 'fugawa', FILE_APPEND))->is(6);
        that(file_get_contents($hoge))->is('hogerafugawa');

        // file 系関数
        that(is_readable($hoge))->is(true);
        that(is_writable($hoge))->is(true);
        that(file_exists($fuga))->is(false);
        that(touch($fuga, 1234567890))->is(true);
        that(file_exists($fuga))->is(true);
        that(touch($fuga, 1234567890))->is(true);
        that(chown($fuga, 'user'))->is(true);
        that(filemtime($fuga))->is(1234567890);
        that(unlink($fuga))->is(true);
        that(unlink(memory_stream('piyo')))->is(false);
        that(file_exists($piyo))->is(false);

        that(rename($piyo, $fuga))->is(false);
        that(rename($hoge, $piyo))->is(true);
        that(file_exists($hoge))->is(false);
        that(file_exists($piyo))->is(true);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_memory_stream_already()
    {
        stream_wrapper_register('MemoryStreamV010000', 'stdClass');
        that(self::resolveFunction('memory_stream'))('hoge')->wasThrown('is registered already');
    }

    function test_memory_stream_dir()
    {
        $dir1 = memory_stream('root');

        that(mkdir($dir1))->isTrue();
        that(mkdir($dir1))->isFalse();

        that(mkdir("$dir1/aaa/bbb"))->isFalse();
        that(mkdir("$dir1/aaa/bbb", 0777, true))->isTrue();

        that(touch("$dir1/aaa/xxx"))->isTrue();
        that(touch("$dir1/aaa/bbb/yyy"))->isTrue();

        that(@opendir("$dir1/aaa/unknown"))->isFalse();
        $dir = opendir("$dir1/aaa");
        $files = [];
        while ($file = readdir($dir)) {
            $files[] = $file;
        }
        that(readdir($dir))->isFalse();
        rewinddir($dir);
        that(readdir($dir))->is('.');
        closedir($dir);
        that(scandir("$dir1/aaa"))->is(['.', '..', 'bbb', 'xxx'])->is($files);

        that(rmdir("$dir1/aaa/bbb/unknown"))->isFalse();
        that(rmdir("$dir1/aaa/bbb"))->isFalse();
        that(rmdir("$dir1/aaa"))->isFalse();
        that(rmdir("$dir1"))->isFalse();
        that(unlink("$dir1/aaa/xxx"))->isTrue();
        that(unlink("$dir1/aaa/bbb/yyy"))->isTrue();
        that(rmdir("$dir1/aaa/bbb"))->isTrue();
        that(rmdir("$dir1/aaa"))->isTrue();
        that(rmdir("$dir1"))->isTrue();
        that(rmdir("$dir1/aaa/bbb/unknown"))->isFalse();
    }

    function test_memory_stream_leak()
    {
        $path = memory_stream('path');
        $usage = memory_get_usage();

        file_put_contents($path, str_repeat('x', 4 * 1024 * 1024));
        that(memory_get_usage() - $usage)->greaterThan(4 * 1024 * 1024);

        unlink($path);
        that(memory_get_usage() - $usage)->lessThan(1024 * 1024);
    }

    function test_memory_stream_open()
    {
        $test = function ($expectedFile, $actualFile, $mode) {
            $expected = fopen($expectedFile, $mode);
            $actual = fopen($actualFile, $mode);

            that(ftell($actual))->is(ftell($expected));
            that(filesize($actualFile))->is(filesize($expectedFile));

            if (strpos($mode, '+') !== false) {
                that(fwrite($expected, '12345') === fwrite($actual, '12345'))->isTrue();
                rewind($expected);
                rewind($actual);
                that(fgets($actual))->is(fgets($expected));
                that(ftruncate($expected, '12345') === ftruncate($actual, '12345'))->isTrue();
            }
        };

        foreach (['r', 'r+', 'w', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+'] as $mode) {
            @unlink($expectedFile = self::$TMPDIR . "/tmp$mode.txt");
            @unlink($actualFile = memory_stream("/tmp$mode.txt"));
            if ($mode[0] !== 'x') {
                file_put_contents($expectedFile, 'abcde');
                file_put_contents($actualFile, 'abcde');
            }
            $test($expectedFile, $actualFile, $mode);
        }

        $path = memory_stream(__FUNCTION__);
        fopen($path, 'a');
        that(file_exists($path))->isTrue();
        unlink($path);
        fopen($path, 'c');
        that(file_exists($path))->isTrue();
        unlink($path);
        that('fopen')($path, 'r')->wasThrown('is not exist');
        touch($path);
        that('fopen')($path, 'x')->wasThrown('is exist already');
    }

    function test_memory_stream_perm()
    {
        $path = memory_stream('path');

        that(chmod($path, 0777))->is(false);
        that(chown($path, 48))->is(false);
        that(chgrp($path, 48))->is(false);

        umask(0);
        that(touch($path))->is(true);
        that(fileperms($path))->is(010_0777);
        that(chmod($path, 0755))->is(true);
        that(fileperms($path))->is(010_0755);

        that(chown($path, 48))->is(true);
        that(fileowner($path))->is(48);
        that(chown($path, 'mysql'))->is(true);
        that(fileowner($path))->is(27);

        that(chgrp($path, 48))->is(true);
        that(filegroup($path))->is(48);
        that(chgrp($path, 'mysql'))->is(true);
        that(filegroup($path))->is(27);

        that(chmod($path, 0700))->is(true);
        if (getmyuid() !== 0) {
            that(is_readable($path))->is(false);
            that(is_writable($path))->is(false);
        }
    }

    function test_memory_stream_seek()
    {
        $test = function ($expectedFile, $actualFile) {
            $expected = fopen($expectedFile, 'w+');
            $actual = fopen($actualFile, 'w+');
            that(fwrite($expected, '0123456789') === fwrite($actual, '0123456789'))->isTrue();

            that(fseek($expected, 1, SEEK_SET) === fseek($actual, 1, SEEK_SET))->isTrue();
            that(fseek($expected, -1, SEEK_SET) === fseek($actual, -1, SEEK_SET))->isTrue();
            that(ftell($expected) === ftell($actual))->isTrue();

            that(fseek($expected, 1, SEEK_CUR) === fseek($actual, 1, SEEK_CUR))->isTrue();
            that(fseek($expected, -1, SEEK_CUR) === fseek($actual, -1, SEEK_CUR))->isTrue();
            that(fseek($expected, -111, SEEK_CUR) === fseek($actual, -111, SEEK_CUR))->isTrue();
            that(ftell($expected) === ftell($actual))->isTrue();

            that(fseek($expected, 1, SEEK_END) === fseek($actual, 1, SEEK_END))->isTrue();
            that(fseek($expected, -1, SEEK_END) === fseek($actual, -1, SEEK_END))->isTrue();
            that(fseek($expected, -111, SEEK_END) === fseek($actual, -111, SEEK_END))->isTrue();
            that(ftell($expected) === ftell($actual))->isTrue();

            that(fseek($expected, 100, SEEK_SET) === fseek($actual, 100, SEEK_SET))->isTrue();
            that(fwrite($expected, 'x') === fwrite($actual, 'x'))->isTrue();
            that(rewind($expected) === rewind($actual))->isTrue();
            that(fread($expected, 1000) === fread($actual, 1000))->isTrue();
        };
        $test(self::$TMPDIR . '/tmp.txt', memory_stream('tmp.txt'));
    }

    function test_profiler()
    {
        $profiler = profiler([
            'callee'   => fn($callee) => $callee !== 'X',
            'location' => '#profile#',
        ]);
        require __DIR__ . '/files/php/profile.php';
        $result = iterator_to_array($profiler);
        that($result)->is($profiler());
        that($result['A'])->count(3);
        that($result['B'])->count(2);
        that($result['C'])->count(1);
        that($result)->notHasKey('X');

        $result = require __DIR__ . '/files/php/fake.php';
        that($result['scandir'])->is(array_merge(scandir(__DIR__ . '/files/php'), scandir(__DIR__ . '/files/php'), scandir(__DIR__ . '/files/php')));
        if (DIRECTORY_SEPARATOR === '/') {
            that($result['meta'])->is([
                'touch' => 1234,
                'chmod' => 33279,
            ]);
            that($result['option'])->is([
                'blocking' => true,
                'timeout'  => false,
                'buffer'   => -1,
            ]);
        }
        that($result['dir'])->is([
            'mkdir' => true,
            'rmdir' => true,
        ]);
        that($result['cast'])->is([
            'mime' => 'text/plain',
        ]);
        that($result['misc'])->is([
            'flock'       => 4,
            'file_exists' => true,
            'stat'        => stat(__DIR__ . '/files/php/fake.php'),
            'lstat'       => lstat(__DIR__ . '/files/php/fake.php'),
        ]);

        $fp = fopen(__DIR__ . '/files/php/fake.php', 'r');
        $fstat = fstat($fp);
        fclose($fp);
        that($fstat[7])->is(filesize(__DIR__ . '/files/php/fake.php'));
        that($fstat['size'])->is(filesize(__DIR__ . '/files/php/fake.php'));

        @file_get_contents(__DIR__ . '/files/php/notfound.php');
        that(error_get_last()['message'])->contains('failed to open stream', false);

        $backup = set_include_path(__DIR__);
        that(file_get_contents(basename(__FILE__), true))->equalsFile(__FILE__);
        set_include_path($backup);

        unset($profiler);
        unset($result);

        gc_collect_cycles();
    }

    function test_var_stream()
    {
        $var = null;
        $f = var_stream($var);

        // f 系の一連の流れ
        that(flock($f, LOCK_EX))->is(true);
        that(fwrite($f, 'Hello'))->is(5);
        that(fwrite($f, 'World!'))->is(6);
        that(fseek($f, 3, SEEK_SET))->is(0);
        that(ftell($f))->is(3);
        that(feof($f))->is(false);
        that(fread($f, 3))->is('loW');
        that(fread($f, 1024))->is('orld!');
        that(fseek($f, 100, SEEK_SET))->is(0);
        that(fwrite($f, 'x'))->is(1);
        that(fflush($f))->is(true);
        that(ftruncate($f, 16))->is(true);
        that(flock($f, LOCK_UN))->is(true);
        that(stream_get_contents($f, -1, 0))->is("HelloWorld!\0\0\0\0\0");
        that(fclose($f))->is(true);

        that($var)->is("HelloWorld!\0\0\0\0\0");

        $f = var_stream($var, 'init');
        that(stream_get_contents($f, -1, 0))->is("init");

        that($var)->is("init");
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_var_stream_already()
    {
        stream_wrapper_register('VarStreamV010000', 'stdClass');
        that(function () {
            $var = null;
            var_stream($var);
        })()->wasThrown('is registered already');
    }

    function test_var_stream_io()
    {
        $var = "initial\nstring";
        $f = var_stream($var);
        that(fread($f, 3))->is("ini");
        that(fgets($f))->is("tial\n");
        that(fgets($f))->is("string");
        that(fgets($f))->isFalse();
        $var .= "append\nstring";
        that(fgets($f))->is("append\n");
        that(fgets($f))->is("string");
        that(fgets($f))->isFalse();
        that(fwrite($f, 'final'))->is(5);
        that($var)->is("initial\nstringappend\nstringfinal");
    }

    function test_var_stream_seek()
    {
        $test = function ($expected, $actual) {
            that(fwrite($expected, '0123456789') === fwrite($actual, '0123456789'))->isTrue();

            that(fseek($expected, 1, SEEK_SET) === fseek($actual, 1, SEEK_SET))->isTrue();
            that(fseek($expected, -1, SEEK_SET) === fseek($actual, -1, SEEK_SET))->isTrue();
            that(ftell($expected) === ftell($actual))->isTrue();

            that(fseek($expected, 1, SEEK_CUR) === fseek($actual, 1, SEEK_CUR))->isTrue();
            that(fseek($expected, -1, SEEK_CUR) === fseek($actual, -1, SEEK_CUR))->isTrue();
            that(fseek($expected, -111, SEEK_CUR) === fseek($actual, -111, SEEK_CUR))->isTrue();
            that(ftell($expected) === ftell($actual))->isTrue();

            that(fseek($expected, 1, SEEK_END) === fseek($actual, 1, SEEK_END))->isTrue();
            that(fseek($expected, -1, SEEK_END) === fseek($actual, -1, SEEK_END))->isTrue();
            that(fseek($expected, -111, SEEK_END) === fseek($actual, -111, SEEK_END))->isTrue();
            that(ftell($expected) === ftell($actual))->isTrue();

            that(fseek($expected, 100, SEEK_SET) === fseek($actual, 100, SEEK_SET))->isTrue();
            that(fwrite($expected, 'x') === fwrite($actual, 'x'))->isTrue();
            that(rewind($expected) === rewind($actual))->isTrue();
            that(fread($expected, 1000) === fread($actual, 1000))->isTrue();
        };
        $var = null;
        $test(tmpfile(), var_stream($var));
    }
}
