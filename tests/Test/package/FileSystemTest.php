<?php
namespace ryunosuke\Test\package;

class FileSystemTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_file_extension()
    {
        $DS = DIRECTORY_SEPARATOR;
        $this->assertEquals("filename.new", file_extension("filename.old", 'new'));
        $this->assertEquals("path{$DS}filename.new", file_extension("path{$DS}filename.old", 'new'));
        $this->assertEquals("{$DS}fullpath{$DS}filename.new", file_extension("{$DS}fullpath{$DS}filename.old", 'new'));
        $this->assertEquals("filename.new", file_extension("filename", 'new'));
        $this->assertEquals("filename.old.new", file_extension("filename.old.", 'new'));
        $this->assertEquals("filename.old1.new", file_extension("filename.old1.old2", 'new'));

        $this->assertEquals('filename.new', file_extension('filename.old', '.new'));
        $this->assertEquals('filename.new', file_extension('filename.old', 'new'));
        $this->assertEquals('filename', file_extension('filename.old', ''));
        $this->assertEquals('filename.', file_extension('filename.old', '.'));
        $this->assertEquals('filename.', file_extension('filename.old', '...'));

        $this->assertEquals('ext', file_extension('filename.suf.ext'));
        $this->assertEquals('ext', file_extension('filename.ext'));
        $this->assertEquals('', file_extension('filename.'));
        $this->assertEquals(null, file_extension('filename'));
        $this->assertEquals('ext', file_extension('.ext'));
    }

    function test_file_set_contents()
    {
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3/';
        rm_rf($dir);

        file_set_contents("$dir/hoge.txt", 'hoge');
        $this->assertStringEqualsFile("$dir/hoge.txt", 'hoge');

        $this->assertException('failed to mkdir', function () {
            file_set_contents('/dev/null/::::::/a', '');
        });
    }

    function test_mkdir_p()
    {
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3/';
        rm_rf($dir);
        $this->assertTrue(mkdir_p($dir));
        $this->assertFileExists($dir);
        $this->assertFalse(mkdir_p($dir));
    }

    function test_rm_rf()
    {
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3';
        $dir2 = dirname($dir);
        $dir1 = dirname($dir2);

        file_set_contents("$dir/a.txt", '');
        rm_rf($dir2);
        $this->assertFileNotExists($dir2); // 自身は消える
        $this->assertFileExists(dirname($dir2)); // 親は残る
        $this->assertFalse(rm_rf($dir)); // 存在しないと false を返す

        file_set_contents("$dir/a.txt", '');
        rm_rf($dir1, false);
        $this->assertFileExists($dir1); // 自身は残る
        $this->assertFileNotExists($dir2); // 子は消える
    }
}
