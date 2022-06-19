<?php
declare(ticks=1);

namespace ryunosuke\Test\Package;

class FileSystemTest extends AbstractTestCase
{
    function test_file_matcher()
    {
        $base = sys_get_temp_dir() . '/tree';
        (file_set_contents)($base . '/a/a1.txt', 'xxx');
        (file_set_contents)($base . '/a/a2.txt', str_repeat("y\n", 30000));

        chmod($base . '/a/a1.txt', 0666);
        touch($base . '/a/a1.txt', strtotime('2000/12/24 12:34:56'));
        touch($base . '/a/a2.txt', strtotime('-1 week'));

        that((file_matcher)([])('hoge'))->isTrue();

        that((file_matcher)(['dotfile' => true])('/a/b/c/.file'))->isTrue();
        that((file_matcher)(['dotfile' => true])('/a/b/c/file'))->isFalse();
        that((file_matcher)(['dotfile' => false])('/a/b/c/.file'))->isFalse();
        that((file_matcher)(['dotfile' => false])('/a/b/c/file'))->isTrue();

        if (DIRECTORY_SEPARATOR === '\\') {
            that((file_matcher)(['unixpath' => true, 'dir' => '/a/b/c'])('\\a\\b\\c\\file'))->isTrue();
            that((file_matcher)(['unixpath' => false, 'dir' => '/a/b/c'])('\\a\\b\\c\\file'))->isFalse();
        }

        that((file_matcher)(['casefold' => true, 'name' => 'FILE'])('/a/b/c/file'))->isTrue();
        that((file_matcher)(['casefold' => false, 'name' => 'FILE'])('/a/b/c/file'))->isFalse();
        that((file_matcher)(['casefold' => true, 'extension' => 'TXT'])('/a/b/c/file.txt'))->isTrue();
        that((file_matcher)(['casefold' => false, 'extension' => 'TXT'])('/a/b/c/file.txt'))->isFalse();

        that((file_matcher)(['type' => 'file'])($base . '/a/a1.txt'))->isTrue();
        that((file_matcher)(['type' => 'link'])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['!type' => 'file'])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['!type' => 'link'])($base . '/a/a1.txt'))->isTrue();

        that((file_matcher)(['perms' => 0400])($base . '/a/a1.txt'))->isTrue();
        that((file_matcher)(['!perms' => 0400])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['perms' => 0100])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['!perms' => 0100])($base . '/a/a1.txt'))->isTrue();

        that((file_matcher)(['mtime' => strtotime('2000/12/24 12:34:56')])($base . '/a/a1.txt'))->isTrue();
        that((file_matcher)(['!mtime' => strtotime('2000/12/24 12:34:56')])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['mtime' => strtotime('1999/12/24 12:34:56')])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['!mtime' => strtotime('1999/12/24 12:34:56')])($base . '/a/a1.txt'))->isTrue();

        that((file_matcher)(['mtime' => ['-1 month']])($base . '/a/a2.txt'))->isTrue();
        that((file_matcher)(['!mtime' => ['-1 month']])($base . '/a/a2.txt'))->isFalse();
        that((file_matcher)(['mtime' => ['-1 month', '-2 week']])($base . '/a/a2.txt'))->isFalse();
        that((file_matcher)(['!mtime' => ['-1 month', '-2 week']])($base . '/a/a2.txt'))->isTrue();

        that((file_matcher)(['size' => 3])($base . '/a/a1.txt'))->isTrue();
        that((file_matcher)(['!size' => 3])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['size' => 9])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['!size' => 9])($base . '/a/a1.txt'))->isTrue();

        that((file_matcher)(['size' => ['10k', '70k']])($base . '/a/a2.txt'))->isTrue();
        that((file_matcher)(['!size' => ['10k', '70k']])($base . '/a/a2.txt'))->isFalse();
        that((file_matcher)(['size' => ['70k', '99k']])($base . '/a/a2.txt'))->isFalse();
        that((file_matcher)(['!size' => ['70k', '99k']])($base . '/a/a2.txt'))->isTrue();

        that((file_matcher)(['path' => '#a/b/c/f#i'])('/a/b/c/file'))->isTrue();
        that((file_matcher)(['!path' => '#a/b/c/f#i'])('/a/b/c/file'))->isFalse();
        that((file_matcher)(['path' => '#a/b/c/X#i'])('/a/b/c/file'))->isFalse();
        that((file_matcher)(['!path' => '#a/b/c/X#i'])('/a/b/c/file'))->isTrue();

        that((file_matcher)(['path' => '/a/*.txt'])('/a/b/c/file.txt'))->isTrue();
        that((file_matcher)(['!path' => '/a/*.txt'])('/a/b/c/file.txt'))->isFalse();
        that((file_matcher)(['path' => '/a/*.not'])('/a/b/c/file.txt'))->isFalse();
        that((file_matcher)(['!path' => '/a/*.not'])('/a/b/c/file.txt'))->isTrue();

        that((file_matcher)(['path' => '{a.*\.TXT}i'])('/a/b/c/file.txt'))->isTrue();
        that((file_matcher)(['!path' => '{a.*\.TXT}i'])('/a/b/c/file.txt'))->isFalse();
        that((file_matcher)(['path' => '{a.*\.NOT}i'])('/a/b/c/file.txt'))->isFalse();
        that((file_matcher)(['!path' => '{a.*\.NOT}i'])('/a/b/c/file.txt'))->isTrue();

        that((file_matcher)(['dir' => '#a/b/c#i'])('/a/b/c/file'))->isTrue();
        that((file_matcher)(['!dir' => '#a/b/c#i'])('/a/b/c/file'))->isFalse();
        that((file_matcher)(['dir' => '#a/b/c/f#i'])('/a/b/c/file'))->isFalse();
        that((file_matcher)(['!dir' => '#a/b/c/f#i'])('/a/b/c/file'))->isTrue();

        that((file_matcher)(['name' => '#file#i'])('/a/b/c/file'))->isTrue();
        that((file_matcher)(['!name' => '#file#i'])('/a/b/c/file'))->isFalse();
        that((file_matcher)(['name' => '#fail#i'])('/a/b/c/file'))->isFalse();
        that((file_matcher)(['!name' => '#fail#i'])('/a/b/c/file'))->isTrue();

        that((file_matcher)(['extension' => 'ext'])('/a/b/c/file.ext'))->isTrue();
        that((file_matcher)(['!extension' => 'ext'])('/a/b/c/file.ext'))->isFalse();
        that((file_matcher)(['extension' => 'not'])('/a/b/c/file.ext'))->isFalse();
        that((file_matcher)(['!extension' => 'not'])('/a/b/c/file.ext'))->isTrue();

        that((file_matcher)(['contains' => 'xx'])($base . '/a/a1.txt'))->isTrue();
        that((file_matcher)(['!contains' => 'xx'])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['contains' => 'zz'])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['!contains' => 'zz'])($base . '/a/a1.txt'))->isTrue();

        $filter = fn($file) => mime_content_type($file->getPathname()) === 'text/plain';
        that((file_matcher)(['filter' => $filter])($base . '/a/a1.txt'))->isTrue();
        that((file_matcher)(['!filter' => $filter])($base . '/a/a1.txt'))->isFalse();
        $filter = fn($file) => mime_content_type($file->getPathname()) === 'text/html';
        that((file_matcher)(['filter' => $filter])($base . '/a/a1.txt'))->isFalse();
        that((file_matcher)(['!filter' => $filter])($base . '/a/a1.txt'))->isTrue();
    }

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

        that((file_list)('/notfound'))->isFalse();

        // 単純列挙
        that((file_list)($base))->equalsCanonicalizing([
            realpath($base . '/a/a1.txt'),
            realpath($base . '/a/a2.txt'),
            realpath($base . '/a/b/ab1.txt'),
            realpath($base . '/a/b/ab2.log'),
            realpath($base . '/a/b/c/abc1.log'),
            realpath($base . '/a/b/c/abc2.log'),
        ]);

        // 拡張子でフィルタ
        that((file_list)($base, fn($fname) => (file_extension)($fname) === 'txt'))->equalsCanonicalizing([
            realpath($base . '/a/a1.txt'),
            realpath($base . '/a/a2.txt'),
            realpath($base . '/a/b/ab1.txt'),
        ]);

        // ファイルサイズでフィルタ
        that((file_list)($base, fn($fname) => filesize($fname) > 0))->equalsCanonicalizing([
            realpath($base . '/a/b/ab2.log'),
            realpath($base . '/a/b/c/abc1.log'),
            realpath($base . '/a/b/c/abc2.log'),
        ]);
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

        that((file_tree)('/notfound'))->isFalse();

        // 単純列挙
        that((file_tree)($base))->isSame([
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
                        ],
                    ],
                ],
            ],
        ]);

        // 拡張子でフィルタ
        that((file_tree)($base, fn($fname) => (file_extension)($fname) === 'txt'))->isSame([
            'tree' => [
                'a' => [
                    'a1.txt' => realpath($base . '/a/a1.txt'),
                    'a2.txt' => realpath($base . '/a/a2.txt'),
                    'b'      => [
                        'ab1.txt' => realpath($base . '/a/b/ab1.txt'),
                    ],
                ],
            ],
        ]);

        // ファイルサイズでフィルタ
        that((file_tree)($base, fn($fname) => filesize($fname) > 0))->isSame([
            'tree' => [
                'a' => [
                    'b' => [
                        'ab2.log' => realpath($base . '/a/b/ab2.log'),
                        'c'       => [
                            'abc1.log' => realpath($base . '/a/b/c/abc1.log'),
                            'abc2.log' => realpath($base . '/a/b/c/abc2.log'),
                        ],
                    ],
                ],
            ],
        ]);
    }

    function test_file_suffix()
    {
        $DS = DIRECTORY_SEPARATOR;
        that((file_suffix)("filename.ext", '-suffix'))->is("filename-suffix.ext");
        that((file_suffix)("path{$DS}filename.ext", '-suffix'))->is("path{$DS}filename-suffix.ext");
        that((file_suffix)("path{$DS}filename", '-suffix'))->is("path{$DS}filename-suffix");
        that((file_suffix)("filename.ext1.ext2", '.suffix'))->is("filename.suffix.ext1.ext2");
        that((file_suffix)("filename.", '.'))->is("filename..");
        that((file_suffix)("filename.", '-suf'))->is("filename-suf.");
        that((file_suffix)("filename.ext", ''))->is("filename.ext");
    }

    function test_file_extension()
    {
        $DS = DIRECTORY_SEPARATOR;
        that((file_extension)("filename.old", 'new'))->is("filename.new");
        that((file_extension)("path{$DS}filename.old", 'new'))->is("path{$DS}filename.new");
        that((file_extension)("{$DS}fullpath{$DS}filename.old", 'new'))->is("{$DS}fullpath{$DS}filename.new");
        that((file_extension)("filename", 'new'))->is("filename.new");
        that((file_extension)("filename.old.", 'new'))->is("filename.old.new");
        that((file_extension)("filename.old1.old2", 'new'))->is("filename.old1.new");

        that((file_extension)('filename.old', '.new'))->is('filename.new');
        that((file_extension)('filename.old', 'new'))->is('filename.new');
        that((file_extension)('filename.old', ''))->is('filename');
        that((file_extension)('filename.old', '.'))->is('filename.');
        that((file_extension)('filename.old', '...'))->is('filename.');

        that((file_extension)('filename.suf.ext'))->is('ext');
        that((file_extension)('filename.ext'))->is('ext');
        that((file_extension)('filename.'))->is('');
        that((file_extension)('filename'))->is(null);
        that((file_extension)('.ext'))->is('ext');
    }

    function test_file_get_arrays()
    {
        $array = [
            [
                'id'   => 1,
                'name' => 'ほげ',
                'list' => [1],
                'hash' => ['x' => 'A'],
                'nest' => [
                    ['a' => 'A11', 'b' => 'B11', 'c' => 'C11'],
                ],
            ],
            [
                'id'   => 2,
                'name' => 'ふが',
                'list' => [1, 2],
                'hash' => ['x' => 'B'],
                'nest' => [
                    ['a' => 'A21', 'b' => 'B21', 'c' => 'C21'],
                    ['a' => 'A22', 'b' => 'B22', 'c' => 'C22'],
                ],
            ],
            [
                'id'   => 3,
                'name' => 'ぴよ',
                'list' => [1, 2, 3],
                'hash' => ['x' => 'C'],
                'nest' => [
                    ['a' => 'A31', 'b' => 'B31', 'c' => 'C31'],
                    ['a' => 'A32', 'b' => 'B32', 'c' => 'C32'],
                    ['a' => 'A33', 'b' => 'B33', 'c' => 'C33'],
                ],
            ],
        ];

        $tmpdir = sys_get_temp_dir();
        file_put_contents($php_utf8 = "$tmpdir/data.php", '<?php return ' . var_export($array, true) . ';');
        file_put_contents($csv_utf8 = "$tmpdir/data.csv", (csv_export)($array, ['structure' => true]));
        file_put_contents($csv_sjis = "$tmpdir/data.sjis.csv", mb_convert_encoding((csv_export)($array, ['structure' => true]), 'sjis'));
        file_put_contents($json_utf8 = "$tmpdir/data.json", (json_export)($array));
        file_put_contents($json_sjis = "$tmpdir/data.sjis.json", mb_convert_encoding((json_export)($array), 'sjis'));
        file_put_contents($jsonl_utf8 = "$tmpdir/data.jsonl", implode("\n", array_map(fn($v) => (json_export)($v), $array)));
        file_put_contents($jsonl_sjis = "$tmpdir/data.sjis.jsonl", mb_convert_encoding(implode("\n", array_map(fn($v) => (json_export)($v), $array)), 'sjis'));
        file_put_contents($yaml_utf8 = "$tmpdir/data.yaml", yaml_emit($array, YAML_UTF8_ENCODING));
        file_put_contents($yaml_sjis = "$tmpdir/data.sjis.yaml", mb_convert_encoding(yaml_emit($array, YAML_UTF8_ENCODING), 'sjis'));
        file_put_contents($ltsv_utf8 = "$tmpdir/data.ltsv", implode("\n", array_map(fn($v) => (ltsv_export)($v), $array)));
        file_put_contents($ltsv_sjis = "$tmpdir/data.sjis.ltsv", mb_convert_encoding(implode("\n", array_map(fn($v) => (ltsv_export)($v), $array)), 'sjis'));

        that((file_get_arrays)($php_utf8))->is($array);
        that((file_get_arrays)($csv_utf8))->is($array);
        that((file_get_arrays)($csv_sjis))->is($array);
        that((file_get_arrays)($json_utf8))->is($array);
        that((file_get_arrays)($json_sjis))->is($array);
        that((file_get_arrays)($jsonl_utf8))->is($array);
        that((file_get_arrays)($jsonl_sjis))->is($array);
        that((file_get_arrays)($yaml_utf8))->is($array);
        that((file_get_arrays)($yaml_sjis))->is($array);
        that((file_get_arrays)($ltsv_utf8))->is($array);
        that((file_get_arrays)($ltsv_sjis))->is($array);

        file_put_contents($empty_php = "$tmpdir/empty.php", "<?php return [];");
        file_put_contents($empty1_csv = "$tmpdir/empty1.csv", "id,name");
        file_put_contents($empty2_csv = "$tmpdir/empty2.csv", "");
        file_put_contents($empty_json = "$tmpdir/empty.json", "[]");
        file_put_contents($empty_jsonl = "$tmpdir/empty.jsonl", "");
        file_put_contents($empty1_yaml = "$tmpdir/empty.yaml", "---");
        file_put_contents($empty2_yaml = "$tmpdir/empty2.yaml", "");
        file_put_contents($empty_ltsv = "$tmpdir/empty.ltsv", "");

        that((file_get_arrays)($empty_php))->is([]);
        that((file_get_arrays)($empty1_csv))->is([]);
        that((file_get_arrays)($empty2_csv))->is([]);
        that((file_get_arrays)($empty_json))->is([]);
        that((file_get_arrays)($empty_jsonl))->is([]);
        that((file_get_arrays)($empty1_yaml))->is([]);
        that((file_get_arrays)($empty2_yaml))->is([]);
        that((file_get_arrays)($empty_ltsv))->is([]);

        file_put_contents($csv_undefined = "$tmpdir/data.undefined.csv", "a,i,u,e,o\nあ,い,う,え,お");
        that((file_get_arrays)($csv_undefined))->is([['a' => 'あ', 'i' => 'い', 'u' => 'う', 'e' => 'え', 'o' => 'お']]);

        touch($txt = sys_get_temp_dir() . '/hoge.txt');
        touch($xml = sys_get_temp_dir() . '/hoge.xml');
        that(file_get_arrays)('notfoundfile')->wasThrown('is not exists');
        that(file_get_arrays)($txt)->wasThrown('is not supported');
        that(file_get_arrays)($xml)->wasThrown('in the future');
    }

    function test_file_rewrite_contents()
    {
        $testpath = sys_get_temp_dir() . '/rewrite/test.txt';
        (file_set_contents)($testpath, 'dummy');

        // standard
        $bytes = (file_rewrite_contents)($testpath, function ($contents, $fp) {
            that($contents)->is('dummy');
            that($fp)->isResource();
            return 'rewrite!';
        });
        that($bytes)->is(8);
        that('rewrite!')->equalsFile($testpath);

        // 0 bytes
        $bytes = (file_rewrite_contents)($testpath, fn($contents) => '');
        that($bytes)->is(0);
        that('')->equalsFile($testpath);

        // no exists
        $bytes = (file_rewrite_contents)(dirname($testpath) . '/test2.txt', fn($contents) => 'test2!', LOCK_EX);
        that($bytes)->is(6);
        that('test2!')->equalsFile(dirname($testpath) . '/test2.txt');

        // lock
        $bytes = (file_rewrite_contents)($testpath, fn($contents) => 'locked!', LOCK_EX);
        that($bytes)->is(7);
        that('locked!')->equalsFile($testpath);

        // open failed
        @that(file_rewrite_contents)(dirname($testpath), fn() => null)->wasThrown('failed to fopen');

        // lock failed
        $fp = fopen($testpath, 'r');
        flock($fp, LOCK_EX);
        @that(file_rewrite_contents)($testpath, fn() => null, LOCK_EX | LOCK_NB)->wasThrown('failed to flock');
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    function test_file_set_contents()
    {
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3/';
        (rm_rf)($dir);

        (file_set_contents)("$dir/hoge.txt", 'hoge');
        that('hoge')->equalsFile("$dir/hoge.txt");

        (file_set_contents)("$dir/dir4/fuga/../", 'fuga');
        that('fuga')->equalsFile("$dir/dir4");

        that(file_set_contents)('/dev/null/::::::/a', '')->wasThrown('failed to mkdir');

        if (DIRECTORY_SEPARATOR === '\\') {
            error_clear_last();
            @(file_set_contents)('/dev/null/::::::', '');
            that(error_get_last()['message'])->stringContains('rename');
        }
    }

    function test_file_pos()
    {
        $tmpfile = sys_get_temp_dir() . '/posfile.txt';
        file_put_contents($tmpfile, str_repeat('x', 100) . "abc");

        that((file_pos)($tmpfile, 'x'))->is(0);
        that((file_pos)($tmpfile, 'x', 1))->is(1);
        that((file_pos)($tmpfile, 'x', 2))->is(2);
        that((file_pos)($tmpfile, 'x', 99))->is(99);
        that((file_pos)($tmpfile, 'x', 100))->is(false);

        that((file_pos)($tmpfile, 'abc'))->is(100);
        that((file_pos)($tmpfile, 'abc', -1))->is(false);
        that((file_pos)($tmpfile, 'abc', -2))->is(false);
        that((file_pos)($tmpfile, 'abc', -3))->is(100);

        that((file_pos)($tmpfile, 'abc', 1, 10, 4))->is(false);
        that((file_pos)($tmpfile, 'abc', 1, 100))->is(false);
        that((file_pos)($tmpfile, 'abc', 1, 101))->is(false);
        that((file_pos)($tmpfile, 'abc', 1, 102))->is(false);
        that((file_pos)($tmpfile, 'abc', 1, 103))->is(100);
        that((file_pos)($tmpfile, 'abc', 101))->is(false);

        that((file_pos)($tmpfile, 'abc', 100, 101))->is(false);
        that((file_pos)($tmpfile, 'abc', 100, 102))->is(false);
        that((file_pos)($tmpfile, 'abc', 100, 103))->is(100);

        that((file_pos)($tmpfile, 'ab', 0, -1))->is(100);
        that((file_pos)($tmpfile, 'ab', 0, -2))->is(false);
        that((file_pos)($tmpfile, 'ab', 0, -3))->is(false);

        that((file_pos)($tmpfile, 'xab', 99, -1))->is(99);
        that((file_pos)($tmpfile, 'xab', 99, -2))->is(false);
        that((file_pos)($tmpfile, 'xab', 99, -3))->is(false);

        that((file_pos)($tmpfile, 'abc', null, null, 3))->is(100);
        that((file_pos)($tmpfile, 'abc', null, null, 4))->is(100);
        that((file_pos)($tmpfile, 'abc', null, null, 5))->is(100);

        file_put_contents($tmpfile, "0123|4567|89AB|CDEF|GHIJ|KLMN|OPQR|STUV|WXYZ|abcd|efgh|ijkl|mnop|qrst|uvwx|yz");

        that((file_pos)($tmpfile, ['0123|', 'uvwx|'], 0, null, 5))->is(0);
        that((file_pos)($tmpfile, ['X123|', 'uvwx|'], 0, null, 5))->is(70);
        that((file_pos)($tmpfile, ['X123|', 'Xvwx|'], 0, null, 5))->is(false);
        that((file_pos)($tmpfile, ['23|45', 'st|uv'], 0, null, 5))->is(2);
        that((file_pos)($tmpfile, ['X3|45', 'st|uv'], 0, null, 5))->is(67);
        that((file_pos)($tmpfile, ['X3|45', 'Xt|uv'], 0, null, 5))->is(false);

        that((file_pos)($tmpfile, ['X123|4567', '0123|4567|89AB'], 0, 10))->is(false);
        that((file_pos)($tmpfile, ['X123|4567', '0123|4567|89AB'], 0, 15))->is(0);

        file_put_contents($tmpfile, str_repeat('ん', 100) . "あ");

        that((file_pos)($tmpfile, 'あ'))->is(300);
        that((file_pos)($tmpfile, 'あ', 299))->is(300);
        that((file_pos)($tmpfile, 'あ', 300))->is(300);
        that((file_pos)($tmpfile, 'あ', 301))->is(false);

        that(file_pos)('not found', 'hoge')->wasThrown('is not found');
    }

    function test_file_mimetype()
    {
        that((file_mimetype)(__FILE__))->is('text/x-php');
        that(@(file_mimetype)('notfound'))->isNull();
        that(error_get_last()['message'])->contains('mime_content_type(notfound)');

        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        that((file_mimetype)("$server/get"))->is('application/json');
        @that((file_mimetype)("$server/not"))->isNull();
        that(error_get_last()['message'])->contains('404');
    }

    function test_dirname_r()
    {
        // composer.json が見つかるまで親を辿って見つかったらそのパスを返す
        that((dirname_r)(__DIR__, fn($path) => realpath("$path/composer.json")))->is(realpath(__DIR__ . '/../../../composer.json'));
        // 見つからない場合は false を返す
        that((dirname_r)(__DIR__, fn($path) => realpath("$path/notfound.ext")))->is(false);
        // 使い方の毛色は違うが、このようにすると各構成要素が得られる
        $paths = [];
        that((dirname_r)('/root/path/to/something', function ($path) use (&$paths) {
            $paths[] = $path;
        }))->is(false);
        that($paths)->is([
            '/root/path/to/something',
            '/root/path/to',
            '/root/path',
            '/root',
            DIRECTORY_SEPARATOR,
        ]);
    }

    function test_dirmtime()
    {
        $dir = sys_get_temp_dir() . '/mtime';
        (mkdir_p)($dir);
        (rm_rf)($dir, false);
        $base = strtotime('2036/12/31 12:34:56');

        // 空っぽなので自身の mtime
        touch($dir, $base);
        that((dirmtime)($dir))->is($base);

        // ファイルが有ればその mtime
        touch("$dir/tmp1", $base + 10);
        that((dirmtime)($dir))->is($base + 10);

        // 更に新しい方
        touch("$dir/tmp2", $base + 20);
        that((dirmtime)($dir))->is($base + 20);

        // 新しい方を消すと古い方
        unlink("$dir/tmp2");
        that((dirmtime)($dir))->is($base + 10);

        // 古い方も消すと自分自身（他にエントリがなく、削除によって自身も更新されているので現在時刻になる）
        unlink("$dir/tmp1");
        that((dirmtime)($dir))->isBetween(time() - 2, time());

        // 再帰フラグの確認
        (file_set_contents)("$dir/dir1/tmp", 'dummy');
        touch("$dir/dir1/tmp", $base + 20);
        touch("$dir/dir1", $base + 10);
        that((dirmtime)($dir, true))->is($base + 20);
        that((dirmtime)($dir, false))->is($base + 10);

        that(dirmtime)(__FILE__)->wasThrown('is not directory');
    }

    function test_fnmatch_and()
    {
        that((fnmatch_and)(['*aaa*', '*bbb*'], 'aaaXbbbX'))->isTrue();
        that((fnmatch_and)(['*aaa*', '*bbb*'], 'aaaX'))->isFalse();

        that(fnmatch_and)([], '')->wasThrown('empty');
    }

    function test_fnmatch_or()
    {
        that((fnmatch_or)(['*aaa*', '*bbb*'], 'aaaX'))->isTrue();
        that((fnmatch_or)(['*aaa*', '*bbb*'], 'cccX'))->isFalse();

        that(fnmatch_or)([], '')->wasThrown('empty');
    }

    function test_path_is_absolute()
    {
        that((path_is_absolute)('a/b/c'))->isFalse();
        that((path_is_absolute)('/a/b/c'))->isTrue();
        $DS = DIRECTORY_SEPARATOR;
        if ($DS === '\\') {
            that((path_is_absolute)("C:"))->isTrue();
            that((path_is_absolute)("C:\\path"))->isTrue();
            that((path_is_absolute)("\\a\\/b\\c"))->isTrue();
            that((path_is_absolute)('a\\b\\c'))->isFalse();
            that((path_is_absolute)('file:///C:\\path'))->isTrue();
        }

        that((path_is_absolute)('http://example.jp'))->isFalse();
        that((path_is_absolute)('http://example.jp/path'))->isTrue();
        that((path_is_absolute)('file:///path'))->isTrue();
        that((path_is_absolute)('file://localhost/C:\\path'))->isTrue();
    }

    function test_path_resolve()
    {
        $DS = DIRECTORY_SEPARATOR;
        that((path_resolve)('a/b/c'))->is(getcwd() . "{$DS}a{$DS}b{$DS}c");
        that((path_resolve)('/a/b/c'))->is("{$DS}a{$DS}b{$DS}c");
        that((path_resolve)('/root', 'a/b/c'))->is("{$DS}root{$DS}a{$DS}b{$DS}c");
        that((path_resolve)('/root', '../a/b/c'))->is("{$DS}a{$DS}b{$DS}c");
        that((path_resolve)('root', 'a/b/c'))->is(getcwd() . "{$DS}root{$DS}a{$DS}b{$DS}c");
        if ($DS === '\\') {
            that((path_resolve)('C:\\a\\b\\c'))->is('C:\\a\\b\\c');
        }

        that((path_resolve)(basename(__FILE__), [__DIR__]))->is(__FILE__);
        that((path_resolve)(basename(__DIR__) . DIRECTORY_SEPARATOR . basename(__FILE__), [dirname(__DIR__)]))->is(__FILE__);
        that((path_resolve)('notfound', [__DIR__]))->isNull();
    }

    function test_path_relative()
    {
        $dataset = [
            ['/a/b/c', '/a/b/c/d', 'd'],
            ['/a/b/c/d', '/a/b/c', '../'],
            ['/a/b/c/d', '/a/b/c/e', '../e'],
            ['/a/b/c/d', '/x/y/z', '../../../../x/y/z'],
            ['/x/y/z', '/a/b/c/d', '../../../a/b/c/d'],
            ['/////a/b/c////', '/a/b/c/d', 'd'],
            ['/c/c/c', '/c/c/c/c', 'c'],
            ['/a/b/c/S', '/a/b/c/S', ''],
            ['a/b/c/x', 'a/b/c/y', '../y'],
        ];

        foreach ($dataset as $data) {
            $data[0] = strtr($data[0], '/', DIRECTORY_SEPARATOR);
            $data[1] = strtr($data[1], '/', DIRECTORY_SEPARATOR);
            $data[2] = strtr($data[2], '/', DIRECTORY_SEPARATOR);

            that((path_relative)($data[0], $data[1]))->as((var_pretty)([
                'args'   => [$data[0], $data[1]],
                'return' => $data[2],
            ], ['return' => true]
            ))->is($data[2]);

            if (DIRECTORY_SEPARATOR === '\\') {
                $data[0] = strtolower('C:' . $data[0]);
                $data[1] = strtoupper('C:' . $data[1]);
                $data[2] = strtoupper($data[2]);

                that((path_relative)($data[0], $data[1]))->as((var_pretty)([
                    'args'   => [$data[0], $data[1]],
                    'return' => $data[2],
                ], ['return' => true]
                ))->is($data[2]);
            }
        }
    }

    function test_path_normalize()
    {
        $DS = DIRECTORY_SEPARATOR;
        // empty
        that((path_normalize)(''))->is("");
        // current
        that((path_normalize)('./'))->is("");
        that((path_normalize)('./././././'))->is("");
        // root
        that((path_normalize)('/'))->is("{$DS}");
        that((path_normalize)('///////'))->is("{$DS}");
        // 1文字
        that((path_normalize)('a'))->is("a");
        // /1文字
        that((path_normalize)('/a'))->is("{$DS}a");
        that((path_normalize)('/////a'))->is("{$DS}a");
        // root ピッタリな相対
        that((path_normalize)('/a/../'))->is("{$DS}");
        that((path_normalize)('/a/../././b/../'))->is("{$DS}");
        // 単純な相対
        that((path_normalize)('/a/b/c/../d/./e'))->is("{$DS}a{$DS}b{$DS}d{$DS}e");
        // 相対パス
        that((path_normalize)('a/b/c/../../d/./e'))->is("a{$DS}d{$DS}e");
        // 連続ドット
        that((path_normalize)('/a.b/c..d'))->is("{$DS}a.b{$DS}c..d");
        // 連続区切り
        that((path_normalize)('//a//b//'))->is("{$DS}a{$DS}b");
        // Windows
        if ($DS === '\\') {
            // \\ 区切り
            that((path_normalize)('C:\\//a\\/b/\\c/../\\d'))->is('C:\\a\\b\\d');
            // 連続区切り
            that((path_normalize)('\\/a/\\\\/\\b'))->is("{$DS}a{$DS}b");
        }
        // いきなり親をたどると例外
        that(path_normalize)('../')->wasThrown('is invalid');
        // 辿りすぎも例外
        that(path_normalize)('a/b/c/../../../..')->wasThrown('is invalid');
    }

    function test_path_parse()
    {
        $DS = DIRECTORY_SEPARATOR;

        that((path_parse)("/path/to/local.txt"))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => "local.txt",
            "extension"    => "txt",
            "filename"     => "local",
            "dirlocalname" => "{$DS}path{$DS}to{$DS}local",
            "localname"    => "local",
            "extensions"   => ["txt"],
        ]);
        that((path_parse)("/path/to/local.txt1.txt2"))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => "local.txt1.txt2",
            "filename"     => "local.txt1",
            "extension"    => "txt2",
            "dirlocalname" => "{$DS}path{$DS}to{$DS}local",
            "localname"    => "local",
            "extensions"   => ["txt1", "txt2"],
        ]);
        that((path_parse)("/path/to/local"))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => "local",
            "filename"     => "local",
            "extension"    => null,
            "dirlocalname" => "{$DS}path{$DS}to{$DS}local",
            "localname"    => "local",
            "extensions"   => [],
        ]);
        that((path_parse)("/path/to/local."))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => "local.",
            "filename"     => "local",
            "extension"    => "",
            "dirlocalname" => "{$DS}path{$DS}to{$DS}local",
            "localname"    => "local",
            "extensions"   => [""],
        ]);
        that((path_parse)("/path/to/.local"))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => ".local",
            "filename"     => "",
            "extension"    => "local",
            "dirlocalname" => "{$DS}path{$DS}to",
            "localname"    => "",
            "extensions"   => ["local"],
        ]);
        that((path_parse)("/local.txt"))->is([
            "dirname"      => "{$DS}",
            "basename"     => "local.txt",
            "filename"     => "local",
            "extension"    => "txt",
            "dirlocalname" => "{$DS}local",
            "localname"    => "local",
            "extensions"   => ["txt"],
        ]);
        that((path_parse)("local"))->is([
            "dirname"      => "",
            "basename"     => "local",
            "filename"     => "local",
            "extension"    => null,
            "dirlocalname" => "local",
            "localname"    => "local",
            "extensions"   => [],
        ]);
        that((path_parse)(""))->is([
            "dirname"      => "",
            "basename"     => "",
            "filename"     => "",
            "extension"    => null,
            "dirlocalname" => "{$DS}",
            "localname"    => "",
            "extensions"   => [],
        ]);
        that((path_parse)("/"))->is([
            "dirname"      => "{$DS}",
            "basename"     => "",
            "filename"     => "",
            "extension"    => null,
            "dirlocalname" => "{$DS}",
            "localname"    => "",
            "extensions"   => [],
        ]);
    }

    function test_mkdir_p()
    {
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3/';
        (rm_rf)($dir);
        that((mkdir_p)($dir))->isTrue();
        that($dir)->fileExists();
        that((mkdir_p)($dir))->isFalse();
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
        that('aaa')->equalsFile("$dst/x.txt");

        // ただのファイル（"/" あり）
        (cp_rf)("$src/a/b/c.txt", "$dst/");
        that('aaa')->equalsFile("$dst/c.txt");

        // "/" なし（dst 自身にコピー）
        (rm_rf)($dst);
        (file_set_contents)("$dst/xxx.txt", '');
        (cp_rf)("$src/", $dst);
        // 置換のような動作は行わないので元あったものは保持されているはず
        that("$dst/xxx.txt")->fileExists();
        // ツリーを確認（コピーされているはず）
        $srctree = (file_tree)($src);
        $dsttree = (file_tree)($dst);
        that(array_keys($dsttree['dst']))->is(['xxx.txt', 'a']);
        that(array_keys($dsttree['dst']['a']))->is(array_keys($srctree['src']['a']));
        that(array_keys($dsttree['dst']['a']['b']))->is(array_keys($srctree['src']['a']['b']));
        that(array_keys($dsttree['dst']['a']['b']['c1']))->is(array_keys($srctree['src']['a']['b']['c1']));
        that(array_keys($dsttree['dst']['a']['b']['c2']))->is(array_keys($srctree['src']['a']['b']['c2']));

        // "/" あり（dst の中にコピー）
        (rm_rf)($dst);
        (file_set_contents)("$dst/xxx.txt", '');
        (cp_rf)("$src/", "$dst/");
        // 置換のような動作は行わないので元あったものは保持されているはず
        that("$dst/xxx.txt")->fileExists();
        // ツリーを確認（コピーされているはず）
        $srctree = (file_tree)($src);
        $dsttree = (file_tree)($dst);
        that(array_keys($dsttree['dst']['src']))->is(array_keys($srctree['src']));
        that(array_keys($dsttree['dst']['src']['a']))->is(array_keys($srctree['src']['a']));
        that(array_keys($dsttree['dst']['src']['a']['b']))->is(array_keys($srctree['src']['a']['b']));
        that(array_keys($dsttree['dst']['src']['a']['b']['c1']))->is(array_keys($srctree['src']['a']['b']['c1']));
        that(array_keys($dsttree['dst']['src']['a']['b']['c2']))->is(array_keys($srctree['src']['a']['b']['c2']));
    }

    function test_rm_rf()
    {
        $dir = sys_get_temp_dir() . '/dir1/dir2/dir3';
        $dir2 = dirname($dir);
        $dir1 = dirname($dir2);

        (file_set_contents)("$dir/a.txt", '');
        (rm_rf)($dir2);
        that($dir2)->fileNotExists();       // 自身は消える
        that(dirname($dir2))->fileExists(); // 親は残る
        that((rm_rf)($dir))->isFalse();     // 存在しないと false を返す

        (file_set_contents)("$dir/a.txt", '');
        (rm_rf)($dir1, false);
        that($dir1)->fileExists();    // 自身は残る
        that($dir2)->fileNotExists(); // 子は消える

        $dir = sys_get_temp_dir() . '/rm_rf';
        (file_set_contents)("$dir/a/x.txt", '');
        (file_set_contents)("$dir/b/x.txt", '');
        (file_set_contents)("$dir/c/x.txt", '');
        (file_set_contents)("$dir/.dotfile", '');

        that((rm_rf)("$dir/a", false))->isTrue();
        that("$dir/a")->directoryExists();     // x は残る
        that("$dir/a/x.txt")->fileNotExists(); // x は消える

        that((rm_rf)("$dir/b", true))->isTrue();
        that("$dir/b")->directoryNotExists();  // y は消える
        that("$dir/b/x.txt")->fileNotExists(); // x は消える

        that((rm_rf)("$dir/*", false))->isTrue();
        that("$dir/c")->directoryExists();     // c は残る
        that("$dir/c/x.txt")->fileNotExists(); // x は消える

        that((rm_rf)("$dir/*", true))->isTrue();
        that("$dir/c")->directoryNotExists();  // c は消える
        that("$dir/c/x.txt")->fileNotExists(); // x は消える

        that((rm_rf)("$dir/*", true))->isFalse();
        that("$dir/.dotfile")->fileExists();
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
        $files = ((reflect_callable)(tmpname))->getStaticVariables()['files'];
        that(array_keys($files))->is($list);

        foreach ($files as $name => $file) {
            that($name)->fileExists();
            $file();
            that($name)->fileNotExists();
        }
    }

    function test_memory_path()
    {
        $hoge = (memory_path)('hoge');
        $fuga = (memory_path)('fuga');
        $piyo = (memory_path)('piyo');

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
        that(unlink((memory_path)('piyo')))->is(false);
        that(file_exists($piyo))->is(false);

        that(rename($piyo, $fuga))->is(false);
        that(rename($hoge, $piyo))->is(true);
        that(file_exists($hoge))->is(false);
        that(file_exists($piyo))->is(true);

        that('mkdir')($hoge)->wasThrown('is not supported');
    }

    function test_memory_path_open()
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
            @unlink($expectedFile = sys_get_temp_dir() . "/tmp$mode.txt");
            @unlink($actualFile = (memory_path)("/tmp$mode.txt"));
            if ($mode[0] !== 'x') {
                file_put_contents($expectedFile, 'abcde');
                file_put_contents($actualFile, 'abcde');
            }
            $test($expectedFile, $actualFile, $mode);
        }

        $path = (memory_path)(__FUNCTION__);
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

    function test_memory_path_seek()
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
        $test(sys_get_temp_dir() . '/tmp.txt', (memory_path)('tmp.txt'));
    }

    function test_memory_path_perm()
    {
        $path = (memory_path)('path');

        that(chmod($path, 0777))->is(false);
        that(chown($path, 48))->is(false);
        that(chgrp($path, 48))->is(false);

        umask(0077);
        that(touch($path))->is(true);
        if (DIRECTORY_SEPARATOR === '/') {
            that(fileperms($path))->is(0700);
            that(chmod($path, 0777))->is(true);
            that(fileperms($path))->is(0777);
        }

        that(chown($path, 48))->is(true);
        that(fileowner($path))->is(48);
        that(chown($path, 'mysql'))->is(true);
        that(fileowner($path))->is(27);

        that(chgrp($path, 48))->is(true);
        that(filegroup($path))->is(48);
        that(chgrp($path, 'mysql'))->is(true);
        that(filegroup($path))->is(27);

        that(chmod($path, 0700))->is(true);
        if (DIRECTORY_SEPARATOR === '/') {
            that(is_readable($path))->is(false);
            that(is_writable($path))->is(false);
        }
    }

    function test_memory_path_leak()
    {
        $path = (memory_path)('path');
        $usage = memory_get_usage();

        file_put_contents($path, str_repeat('x', 4 * 1024 * 1024));
        that(memory_get_usage() - $usage)->greaterThan(4 * 1024 * 1024);

        unlink($path);
        that(memory_get_usage() - $usage)->lessThan(1024 * 1024);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_memory_path_already()
    {
        stream_wrapper_register('MemoryStreamV010000', 'stdClass');
        that(memory_path)('hoge')->wasThrown('is registered already');
    }
}
