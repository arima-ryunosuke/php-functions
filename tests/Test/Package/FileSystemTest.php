<?php

namespace ryunosuke\Test\Package;

class FileSystemTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_file_list()
    {
        $base = sys_get_temp_dir() . '/tree';
        (rm_rf)($base);
        (file_set_contents)($base . '/a/a1.txt', '');
        (file_set_contents)($base . '/a/a2.txt', '');
        (file_set_contents)($base . '/a//b/ab1.txt', '');
        (file_set_contents)($base . '/a//b/ab2.log', 'xxx');
        (file_set_contents)($base . '/a//b/c/abc1.log', 'xxxxx');
        (file_set_contents)($base . '/a//b/c/abc2.log', 'xxxxxxx');

        $this->assertFalse((file_list)('/notfound'));

        // 単純列挙
        $tree = (file_list)($base);
        $this->assertSame([
            realpath($base . '/a/a1.txt'),
            realpath($base . '/a/a2.txt'),
            realpath($base . '/a/b/ab1.txt'),
            realpath($base . '/a/b/ab2.log'),
            realpath($base . '/a/b/c/abc1.log'),
            realpath($base . '/a/b/c/abc2.log'),
        ], $tree);

        // 拡張子でフィルタ
        $tree = (file_list)($base, function ($fname) { return (file_extension)($fname) === 'txt'; });
        $this->assertSame([
            realpath($base . '/a/a1.txt'),
            realpath($base . '/a/a2.txt'),
            realpath($base . '/a/b/ab1.txt'),
        ], $tree);

        // ファイルサイズでフィルタ
        $tree = (file_list)($base, function ($fname) { return filesize($fname) > 0; });
        $this->assertSame([
            realpath($base . '/a/b/ab2.log'),
            realpath($base . '/a/b/c/abc1.log'),
            realpath($base . '/a/b/c/abc2.log'),
        ], $tree);
    }

    function test_file_tree()
    {
        $base = sys_get_temp_dir() . '/tree';
        (rm_rf)($base);
        (file_set_contents)($base . '/a/a1.txt', '');
        (file_set_contents)($base . '/a/a2.txt', '');
        (file_set_contents)($base . '/a//b/ab1.txt', '');
        (file_set_contents)($base . '/a//b/ab2.log', 'xxx');
        (file_set_contents)($base . '/a//b/c/abc1.log', 'xxxxx');
        (file_set_contents)($base . '/a//b/c/abc2.log', 'xxxxxxx');
        (file_set_contents)($base . '/x.ext', '');

        $this->assertFalse((file_tree)('/notfound'));

        // 単純列挙
        $tree = (file_tree)($base);
        $this->assertSame([
            'tree' => [
                'x.ext' => realpath($base . '/x.ext'),
                'a'     => [
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
        $tree = (file_tree)($base, function ($fname) { return (file_extension)($fname) === 'txt'; });
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
        $tree = (file_tree)($base, function ($fname) { return filesize($fname) > 0; });
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

    function test_file_suffix()
    {
        $DS = DIRECTORY_SEPARATOR;
        $this->assertEquals("filename-suffix.ext", (file_suffix)("filename.ext", '-suffix'));
        $this->assertEquals("path{$DS}filename-suffix.ext", (file_suffix)("path{$DS}filename.ext", '-suffix'));
        $this->assertEquals("path{$DS}filename-suffix", (file_suffix)("path{$DS}filename", '-suffix'));
        $this->assertEquals("filename.suffix.ext1.ext2", (file_suffix)("filename.ext1.ext2", '.suffix'));
        $this->assertEquals("filename..", (file_suffix)("filename.", '.'));
        $this->assertEquals("filename-suf.", (file_suffix)("filename.", '-suf'));
        $this->assertEquals("filename.ext", (file_suffix)("filename.ext", ''));
    }

    function test_file_extension()
    {
        $DS = DIRECTORY_SEPARATOR;
        $this->assertEquals("filename.new", (file_extension)("filename.old", 'new'));
        $this->assertEquals("path{$DS}filename.new", (file_extension)("path{$DS}filename.old", 'new'));
        $this->assertEquals("{$DS}fullpath{$DS}filename.new", (file_extension)("{$DS}fullpath{$DS}filename.old", 'new'));
        $this->assertEquals("filename.new", (file_extension)("filename", 'new'));
        $this->assertEquals("filename.old.new", (file_extension)("filename.old.", 'new'));
        $this->assertEquals("filename.old1.new", (file_extension)("filename.old1.old2", 'new'));

        $this->assertEquals('filename.new', (file_extension)('filename.old', '.new'));
        $this->assertEquals('filename.new', (file_extension)('filename.old', 'new'));
        $this->assertEquals('filename', (file_extension)('filename.old', ''));
        $this->assertEquals('filename.', (file_extension)('filename.old', '.'));
        $this->assertEquals('filename.', (file_extension)('filename.old', '...'));

        $this->assertEquals('ext', (file_extension)('filename.suf.ext'));
        $this->assertEquals('ext', (file_extension)('filename.ext'));
        $this->assertEquals('', (file_extension)('filename.'));
        $this->assertEquals(null, (file_extension)('filename'));
        $this->assertEquals('ext', (file_extension)('.ext'));
    }

    function test_file_rewrite_contents()
    {
        $testpath = sys_get_temp_dir() . '/rewrite/test.txt';
        (file_set_contents)($testpath, 'dummy');

        // standard
        $bytes = (file_rewrite_contents)($testpath, function ($contents, $fp) {
            $this->assertEquals('dummy', $contents);
            $this->assertInternalType('resource', $fp);
            return 'rewrite!';
        });
        $this->assertEquals(8, $bytes);
        $this->assertStringEqualsFile($testpath, 'rewrite!');

        // 0 bytes
        $bytes = (file_rewrite_contents)($testpath, function ($contents) { return ''; });
        $this->assertEquals(0, $bytes);
        $this->assertStringEqualsFile($testpath, '');

        // no exists
        $bytes = (file_rewrite_contents)(dirname($testpath) . '/test2.txt', function ($contents) {
            return 'test2!';
        }, LOCK_EX);
        $this->assertEquals(6, $bytes);
        $this->assertStringEqualsFile(dirname($testpath) . '/test2.txt', 'test2!');

        // lock
        $bytes = (file_rewrite_contents)($testpath, function ($contents) { return 'locked!'; }, LOCK_EX);
        $this->assertEquals(7, $bytes);
        $this->assertStringEqualsFile($testpath, 'locked!');

        // open failed
        @$this->assertException('failed to fopen', file_rewrite_contents, dirname($testpath), function () { });

        // lock failed
        $fp = fopen($testpath, 'r');
        flock($fp, LOCK_EX);
        @$this->assertException('failed to flock', file_rewrite_contents, $testpath, function () { }, LOCK_EX | LOCK_NB);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    function test_file_set_contents()
    {
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3/';
        (rm_rf)($dir);

        (file_set_contents)("$dir/hoge.txt", 'hoge');
        $this->assertStringEqualsFile("$dir/hoge.txt", 'hoge');

        $this->assertException('failed to mkdir', file_set_contents, '/dev/null/::::::/a', '');
    }

    function test_dirname_r()
    {
        // composer.json が見つかるまで親を辿って見つかったらそのパスを返す
        $this->assertEquals(realpath(__DIR__ . '/../../../composer.json'), (dirname_r)(__DIR__, function ($path) {
            return realpath("$path/composer.json");
        }));
        // 見つからない場合は false を返す
        $this->assertEquals(false, (dirname_r)(__DIR__, function ($path) {
            return realpath("$path/notfound.ext");
        }));
        // 使い方の毛色は違うが、このようにすると各構成要素が得られる
        $paths = [];
        $this->assertEquals(false, (dirname_r)('/root/path/to/something', function ($path) use (&$paths) {
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

    function test_fnmatch_and()
    {
        $this->assertTrue((fnmatch_and)(['*aaa*', '*bbb*'], 'aaaXbbbX'));
        $this->assertFalse((fnmatch_and)(['*aaa*', '*bbb*'], 'aaaX'));

        $this->assertException('empty', fnmatch_and, [], '');
    }

    function test_fnmatch_or()
    {
        $this->assertTrue((fnmatch_or)(['*aaa*', '*bbb*'], 'aaaX'));
        $this->assertFalse((fnmatch_or)(['*aaa*', '*bbb*'], 'cccX'));

        $this->assertException('empty', fnmatch_or, [], '');
    }

    function test_path_is_absolute()
    {
        $this->assertFalse((path_is_absolute)('a/b/c'));
        $this->assertTrue((path_is_absolute)('/a/b/c'));
        $DS = DIRECTORY_SEPARATOR;
        if ($DS === '\\') {
            $this->assertTrue((path_is_absolute)("C:"));
            $this->assertTrue((path_is_absolute)("C:\\path"));
            $this->assertTrue((path_is_absolute)("\\a\\/b\\c"));
            $this->assertFalse((path_is_absolute)('a\\b\\c'));
        }
    }

    function test_path_resolve()
    {
        $DS = DIRECTORY_SEPARATOR;
        $this->assertEquals(getcwd() . "{$DS}a{$DS}b{$DS}c", (path_resolve)('a/b/c'));
        $this->assertEquals("{$DS}a{$DS}b{$DS}c", (path_resolve)('/a/b/c'));
        $this->assertEquals("{$DS}root{$DS}a{$DS}b{$DS}c", (path_resolve)('/root', 'a/b/c'));
        $this->assertEquals("{$DS}a{$DS}b{$DS}c", (path_resolve)('/root', '../a/b/c'));
        $this->assertEquals(getcwd() . "{$DS}root{$DS}a{$DS}b{$DS}c", (path_resolve)('root', 'a/b/c'));
        if ($DS === '\\') {
            $this->assertEquals('C:\\a\\b\\c', (path_resolve)('C:\\a\\b\\c'));
        }
    }

    function test_path_normalize()
    {
        $DS = DIRECTORY_SEPARATOR;
        // 単純な相対
        $this->assertEquals("{$DS}a{$DS}b{$DS}d{$DS}e", (path_normalize)('/a/b/c/../d/./e'));
        // 相対パス
        $this->assertEquals("a{$DS}d{$DS}e", (path_normalize)('a/b/c/../../d/./e'));
        // 連続ドット
        $this->assertEquals("{$DS}a.b{$DS}c..d", (path_normalize)('/a.b/c..d'));
        // 連続区切り
        $this->assertEquals("{$DS}a{$DS}b", (path_normalize)('//a//b//'));
        // Windows
        if ($DS === '\\') {
            // \\ 区切り
            $this->assertEquals('C:\\a\\b\\d', (path_normalize)('C:\\//a\\/b/\\c/../\\d'));
            // 連続区切り
            $this->assertEquals("{$DS}a{$DS}b", (path_normalize)('\\/a/\\\\/\\b'));
        }
        // いきなり親をたどると例外
        $this->assertException('is invalid', path_normalize, '../');
        // 辿りすぎも例外
        $this->assertException('is invalid', path_normalize, 'a/b/c/../../../..');
    }

    function test_mkdir_p()
    {
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3/';
        (rm_rf)($dir);
        $this->assertTrue((mkdir_p)($dir));
        $this->assertFileExists($dir);
        $this->assertFalse((mkdir_p)($dir));
    }

    function test_cp_rf()
    {
        $tmpdir = sys_get_temp_dir() . '/cp_rf';

        $src = "$tmpdir/src";
        (rm_rf)($src);
        (file_set_contents)("$src/a/b/c.txt", 'aaa');
        (file_set_contents)("$src/a/b/c1/d1.txt", '');
        (file_set_contents)("$src/a/b/c2/d2.txt", '');

        $dst = "$tmpdir/dst";
        (mkdir_p)($dst);

        // ただのファイル（"/" なし）
        (cp_rf)("$src/a/b/c.txt", "$dst/x.txt");
        $this->assertStringEqualsFile("$dst/x.txt", 'aaa');

        // ただのファイル（"/" あり）
        (cp_rf)("$src/a/b/c.txt", "$dst/");
        $this->assertStringEqualsFile("$dst/c.txt", 'aaa');

        // "/" なし（dst 自身にコピー）
        (rm_rf)($dst);
        (file_set_contents)("$dst/xxx.txt", '');
        (cp_rf)("$src/", $dst);
        // 置換のような動作は行わないので元あったものは保持されているはず
        $this->assertFileExists("$dst/xxx.txt");
        // ツリーを確認（コピーされているはず）
        $srctree = (file_tree)($src);
        $dsttree = (file_tree)($dst);
        $this->assertEquals(['xxx.txt', 'a'], array_keys($dsttree['dst']));
        $this->assertEquals(array_keys($srctree['src']['a']), array_keys($dsttree['dst']['a']));
        $this->assertEquals(array_keys($srctree['src']['a']['b']), array_keys($dsttree['dst']['a']['b']));
        $this->assertEquals(array_keys($srctree['src']['a']['b']['c1']), array_keys($dsttree['dst']['a']['b']['c1']));
        $this->assertEquals(array_keys($srctree['src']['a']['b']['c2']), array_keys($dsttree['dst']['a']['b']['c2']));

        // "/" あり（dst の中にコピー）
        (rm_rf)($dst);
        (file_set_contents)("$dst/xxx.txt", '');
        (cp_rf)("$src/", "$dst/");
        // 置換のような動作は行わないので元あったものは保持されているはず
        $this->assertFileExists("$dst/xxx.txt");
        // ツリーを確認（コピーされているはず）
        $srctree = (file_tree)($src);
        $dsttree = (file_tree)($dst);
        $this->assertEquals(array_keys($srctree['src']), array_keys($dsttree['dst']['src']));
        $this->assertEquals(array_keys($srctree['src']['a']), array_keys($dsttree['dst']['src']['a']));
        $this->assertEquals(array_keys($srctree['src']['a']['b']), array_keys($dsttree['dst']['src']['a']['b']));
        $this->assertEquals(array_keys($srctree['src']['a']['b']['c1']), array_keys($dsttree['dst']['src']['a']['b']['c1']));
        $this->assertEquals(array_keys($srctree['src']['a']['b']['c2']), array_keys($dsttree['dst']['src']['a']['b']['c2']));
    }

    function test_rm_rf()
    {
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3';
        $dir2 = dirname($dir);
        $dir1 = dirname($dir2);

        (file_set_contents)("$dir/a.txt", '');
        (rm_rf)($dir2);
        $this->assertFileNotExists($dir2); // 自身は消える
        $this->assertFileExists(dirname($dir2)); // 親は残る
        $this->assertFalse((rm_rf)($dir)); // 存在しないと false を返す

        (file_set_contents)("$dir/a.txt", '');
        (rm_rf)($dir1, false);
        $this->assertFileExists($dir1); // 自身は残る
        $this->assertFileNotExists($dir2); // 子は消える
    }

    function test_tmpname()
    {
        $wd = sys_get_temp_dir() . '/tmpname';
        (mkdir_p)(sys_get_temp_dir() . '/tmpname');
        (rm_rf)(sys_get_temp_dir() . '/tmpname', false);

        $list = [
            (tmpname)(null, $wd),
            (tmpname)(null, $wd),
            (tmpname)(null, $wd),
        ];
        /** @noinspection PhpUndefinedMethodInspection */
        $files = ((reflect_callable)(tmpname))->getStaticVariables()['files'];
        $this->assertEquals($list, array_keys($files));

        foreach ($files as $name => $file) {
            $this->assertFileExists($name);
            $file();
            $this->assertFileNotExists($name);
        }
    }
}
