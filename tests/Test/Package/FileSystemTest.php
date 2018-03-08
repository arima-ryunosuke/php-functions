<?php

namespace ryunosuke\Test\Package;

use ryunosuke\Functions\Package\FileSystem;

class FileSystemTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_file_list()
    {
        $file_list = file_list;
        $base = sys_get_temp_dir() . '/tree';
        FileSystem::rm_rf($base);
        FileSystem::file_set_contents($base . '/a/a1.txt', '');
        FileSystem::file_set_contents($base . '/a/a2.txt', '');
        FileSystem::file_set_contents($base . '/a//b/ab1.txt', '');
        FileSystem::file_set_contents($base . '/a//b/ab2.log', 'xxx');
        FileSystem::file_set_contents($base . '/a//b/c/abc1.log', 'xxxxx');
        FileSystem::file_set_contents($base . '/a//b/c/abc2.log', 'xxxxxxx');

        $this->assertFalse($file_list('/notfound'));

        // 単純列挙
        $tree = $file_list($base);
        $this->assertSame([
            realpath($base . '/a/a1.txt'),
            realpath($base . '/a/a2.txt'),
            realpath($base . '/a/b/ab1.txt'),
            realpath($base . '/a/b/ab2.log'),
            realpath($base . '/a/b/c/abc1.log'),
            realpath($base . '/a/b/c/abc2.log'),
        ], $tree);

        // 拡張子でフィルタ
        $tree = $file_list($base, function ($fname) { return FileSystem::file_extension($fname) === 'txt'; });
        $this->assertSame([
            realpath($base . '/a/a1.txt'),
            realpath($base . '/a/a2.txt'),
            realpath($base . '/a/b/ab1.txt'),
        ], $tree);

        // ファイルサイズでフィルタ
        $tree = $file_list($base, function ($fname) { return filesize($fname) > 0; });
        $this->assertSame([
            realpath($base . '/a/b/ab2.log'),
            realpath($base . '/a/b/c/abc1.log'),
            realpath($base . '/a/b/c/abc2.log'),
        ], $tree);
    }

    function test_file_tree()
    {
        $file_tree = file_tree;
        $base = sys_get_temp_dir() . '/tree';
        FileSystem::rm_rf($base);
        FileSystem::file_set_contents($base . '/a/a1.txt', '');
        FileSystem::file_set_contents($base . '/a/a2.txt', '');
        FileSystem::file_set_contents($base . '/a//b/ab1.txt', '');
        FileSystem::file_set_contents($base . '/a//b/ab2.log', 'xxx');
        FileSystem::file_set_contents($base . '/a//b/c/abc1.log', 'xxxxx');
        FileSystem::file_set_contents($base . '/a//b/c/abc2.log', 'xxxxxxx');

        $this->assertFalse($file_tree('/notfound'));

        // 単純列挙
        $tree = $file_tree($base);
        $this->assertSame([
            'tree' => [
                'a' => [
                    'a1.txt' => realpath($base . '/a/a1.txt'),
                    'a2.txt' => realpath($base . '/a/a2.txt'),
                    'b'      => [
                        'ab1.txt' => realpath($base . '/a/b/ab1.txt'),
                        'ab2.log' => realpath($base . '/a/b/ab2.log'),
                        'c'       => [
                            'abc1.log' => realpath($base . '/a/b/c/abc1.log'),
                            'abc2.log' => realpath($base . '/a/b/c/abc2.log'),
                        ]
                    ],
                ],
            ],
        ], $tree);

        // 拡張子でフィルタ
        $tree = $file_tree($base, function ($fname) { return FileSystem::file_extension($fname) === 'txt'; });
        $this->assertSame([
            'tree' => [
                'a' => [
                    'a1.txt' => realpath($base . '/a/a1.txt'),
                    'a2.txt' => realpath($base . '/a/a2.txt'),
                    'b'      => [
                        'ab1.txt' => realpath($base . '/a/b/ab1.txt'),
                    ],
                ],
            ]
        ], $tree);

        // ファイルサイズでフィルタ
        $tree = $file_tree($base, function ($fname) { return filesize($fname) > 0; });
        $this->assertSame([
            'tree' => [
                'a' => [
                    'b' => [
                        'ab2.log' => realpath($base . '/a/b/ab2.log'),
                        'c'       => [
                            'abc1.log' => realpath($base . '/a/b/c/abc1.log'),
                            'abc2.log' => realpath($base . '/a/b/c/abc2.log'),
                        ]
                    ],
                ],
            ],
        ], $tree);
    }

    function test_file_extension()
    {
        $file_extension = file_extension;
        $DS = DIRECTORY_SEPARATOR;
        $this->assertEquals("filename.new", $file_extension("filename.old", 'new'));
        $this->assertEquals("path{$DS}filename.new", $file_extension("path{$DS}filename.old", 'new'));
        $this->assertEquals("{$DS}fullpath{$DS}filename.new", $file_extension("{$DS}fullpath{$DS}filename.old", 'new'));
        $this->assertEquals("filename.new", $file_extension("filename", 'new'));
        $this->assertEquals("filename.old.new", $file_extension("filename.old.", 'new'));
        $this->assertEquals("filename.old1.new", $file_extension("filename.old1.old2", 'new'));

        $this->assertEquals('filename.new', $file_extension('filename.old', '.new'));
        $this->assertEquals('filename.new', $file_extension('filename.old', 'new'));
        $this->assertEquals('filename', $file_extension('filename.old', ''));
        $this->assertEquals('filename.', $file_extension('filename.old', '.'));
        $this->assertEquals('filename.', $file_extension('filename.old', '...'));

        $this->assertEquals('ext', $file_extension('filename.suf.ext'));
        $this->assertEquals('ext', $file_extension('filename.ext'));
        $this->assertEquals('', $file_extension('filename.'));
        $this->assertEquals(null, $file_extension('filename'));
        $this->assertEquals('ext', $file_extension('.ext'));
    }

    function test_file_set_contents()
    {
        $file_set_contents = file_set_contents;
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3/';
        FileSystem::rm_rf($dir);

        $file_set_contents("$dir/hoge.txt", 'hoge');
        $this->assertStringEqualsFile("$dir/hoge.txt", 'hoge');

        $this->assertException('failed to mkdir', $file_set_contents, '/dev/null/::::::/a', '');
    }

    function test_dirname_r()
    {
        $dirname_r = dirname_r;
        // composer.json が見つかるまで親を辿って見つかったらそのパスを返す
        $this->assertEquals(realpath(__DIR__ . '/../../../composer.json'), $dirname_r(__DIR__, function ($path) {
            return realpath("$path/composer.json");
        }));
        // 見つからない場合は false を返す
        $this->assertEquals(false, $dirname_r(__DIR__, function ($path) {
            return realpath("$path/notfound.ext");
        }));
        // 使い方の毛色は違うが、このようにすると各構成要素が得られる
        $paths = [];
        $this->assertEquals(false, $dirname_r('/root/path/to/something', function ($path) use (&$paths) {
            $paths[] = $path;
        }));
        $this->assertEquals([
            '/root/path/to/something',
            '/root/path/to',
            '/root/path',
            '/root',
            DIRECTORY_SEPARATOR,
        ], $paths);
    }

    function test_path_is_absolute()
    {
        $path_is_absolute = path_is_absolute;
        $this->assertFalse($path_is_absolute('a/b/c'));
        $this->assertTrue($path_is_absolute('/a/b/c'));
        $DS = DIRECTORY_SEPARATOR;
        if ($DS === '\\') {
            $this->assertTrue($path_is_absolute("C:"));
            $this->assertTrue($path_is_absolute("C:\\path"));
            $this->assertTrue($path_is_absolute("\\a\\/b\\c"));
            $this->assertFalse($path_is_absolute('a\\b\\c'));
        }
    }

    function test_mkdir_p()
    {
        $mkdir_p = mkdir_p;
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3/';
        FileSystem::rm_rf($dir);
        $this->assertTrue($mkdir_p($dir));
        $this->assertFileExists($dir);
        $this->assertFalse($mkdir_p($dir));
    }

    function test_rm_rf()
    {
        $rm_rf = rm_rf;
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3';
        $dir2 = dirname($dir);
        $dir1 = dirname($dir2);

        FileSystem::file_set_contents("$dir/a.txt", '');
        $rm_rf($dir2);
        $this->assertFileNotExists($dir2); // 自身は消える
        $this->assertFileExists(dirname($dir2)); // 親は残る
        $this->assertFalse($rm_rf($dir)); // 存在しないと false を返す

        FileSystem::file_set_contents("$dir/a.txt", '');
        $rm_rf($dir1, false);
        $this->assertFileExists($dir1); // 自身は残る
        $this->assertFileNotExists($dir2); // 子は消える
    }

    function test_tmpname()
    {
        // @todo closurize すると getStaticVariables が腐る？

        $wd = sys_get_temp_dir() . '/tmpname';
        FileSystem::mkdir_p(sys_get_temp_dir() . '/tmpname');

        $list = [
            FileSystem::tmpname(null, $wd),
            FileSystem::tmpname(null, $wd),
            FileSystem::tmpname(null, $wd),
        ];
        $files = (new \ReflectionMethod('\ryunosuke\\Functions\\Package\\FileSystem::tmpname'))->getStaticVariables()['files'];
        $this->assertArraySubset($list, $files);

        // こういうこともできるっぽいが多分黒魔術（カバレッジもされないし…）まぁコケてはくれるので許容する
        register_shutdown_function(function ($wd) {
            $this->assertEquals([], glob("$wd/*"));
        }, $wd);
    }
}
