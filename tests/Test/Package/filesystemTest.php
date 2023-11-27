<?php
declare(ticks=1);

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\cp_rf;
use function ryunosuke\Functions\Package\csv_export;
use function ryunosuke\Functions\Package\dir_diff;
use function ryunosuke\Functions\Package\dirmtime;
use function ryunosuke\Functions\Package\dirname_r;
use function ryunosuke\Functions\Package\file_equals;
use function ryunosuke\Functions\Package\file_extension;
use function ryunosuke\Functions\Package\file_get_arrays;
use function ryunosuke\Functions\Package\file_list;
use function ryunosuke\Functions\Package\file_matcher;
use function ryunosuke\Functions\Package\file_mimetype;
use function ryunosuke\Functions\Package\file_pos;
use function ryunosuke\Functions\Package\file_rewrite_contents;
use function ryunosuke\Functions\Package\file_set_contents;
use function ryunosuke\Functions\Package\file_set_tree;
use function ryunosuke\Functions\Package\file_slice;
use function ryunosuke\Functions\Package\file_suffix;
use function ryunosuke\Functions\Package\file_tree;
use function ryunosuke\Functions\Package\fnmatch_and;
use function ryunosuke\Functions\Package\fnmatch_or;
use function ryunosuke\Functions\Package\json_export;
use function ryunosuke\Functions\Package\ltsv_export;
use function ryunosuke\Functions\Package\memory_path;
use function ryunosuke\Functions\Package\mkdir_p;
use function ryunosuke\Functions\Package\path_info;
use function ryunosuke\Functions\Package\path_is_absolute;
use function ryunosuke\Functions\Package\path_normalize;
use function ryunosuke\Functions\Package\path_parse;
use function ryunosuke\Functions\Package\path_relative;
use function ryunosuke\Functions\Package\path_resolve;
use function ryunosuke\Functions\Package\reflect_callable;
use function ryunosuke\Functions\Package\rm_rf;
use function ryunosuke\Functions\Package\strmode;
use function ryunosuke\Functions\Package\strmode2oct;
use function ryunosuke\Functions\Package\tmpname;
use function ryunosuke\Functions\Package\var_pretty;

class filesystemTest extends AbstractTestCase
{
    function test_cp_rf()
    {
        $tmpdir = self::$TMPDIR . '/cp_rf';

        $src = "$tmpdir/src";
        rm_rf($src);
        file_set_contents("$src/a/b/c.txt", 'aaa');
        file_set_contents("$src/a/b/c1/d1.txt", '');
        file_set_contents("$src/a/b/c2/d2.txt", '');

        $dst = "$tmpdir/dst";
        mkdir_p($dst);

        // ただのファイル（"/" なし）
        cp_rf("$src/a/b/c.txt", "$dst/x.txt");
        that('aaa')->equalsFile("$dst/x.txt");

        // ただのファイル（"/" あり）
        cp_rf("$src/a/b/c.txt", "$dst/");
        that('aaa')->equalsFile("$dst/c.txt");

        // "/" なし（dst 自身にコピー）
        rm_rf($dst);
        file_set_contents("$dst/xxx.txt", '');
        cp_rf("$src/", $dst);
        // 置換のような動作は行わないので元あったものは保持されているはず
        that("$dst/xxx.txt")->fileExists();
        // ツリーを確認（コピーされているはず）
        $srctree = file_tree($src);
        $dsttree = file_tree($dst);
        that(array_keys($dsttree['dst']))->is(['xxx.txt', 'a']);
        that(array_keys($dsttree['dst']['a']))->is(array_keys($srctree['src']['a']));
        that(array_keys($dsttree['dst']['a']['b']))->is(array_keys($srctree['src']['a']['b']));
        that(array_keys($dsttree['dst']['a']['b']['c1']))->is(array_keys($srctree['src']['a']['b']['c1']));
        that(array_keys($dsttree['dst']['a']['b']['c2']))->is(array_keys($srctree['src']['a']['b']['c2']));

        // "/" あり（dst の中にコピー）
        rm_rf($dst);
        file_set_contents("$dst/xxx.txt", '');
        cp_rf("$src/", "$dst/");
        // 置換のような動作は行わないので元あったものは保持されているはず
        that("$dst/xxx.txt")->fileExists();
        // ツリーを確認（コピーされているはず）
        $srctree = file_tree($src);
        $dsttree = file_tree($dst);
        that(array_keys($dsttree['dst']['src']))->is(array_keys($srctree['src']));
        that(array_keys($dsttree['dst']['src']['a']))->is(array_keys($srctree['src']['a']));
        that(array_keys($dsttree['dst']['src']['a']['b']))->is(array_keys($srctree['src']['a']['b']));
        that(array_keys($dsttree['dst']['src']['a']['b']['c1']))->is(array_keys($srctree['src']['a']['b']['c1']));
        that(array_keys($dsttree['dst']['src']['a']['b']['c2']))->is(array_keys($srctree['src']['a']['b']['c2']));

        // 隠しファイルとカスタムプロトコル
        $src = memory_path('cp_rf_src');
        $dst = memory_path('cp_rf_dst');
        file_set_contents("$src/a.txt", '');
        file_set_contents("$src/dir/a.txt", '');
        cp_rf("$src/", $dst);
        that("$dst/a.txt")->fileExists();
        that("$dst/dir/a.txt")->fileExists();
    }

    function test_dir_diff()
    {
        $root1 = memory_path('dir_diff1');
        $root2 = memory_path('dir_diff2');
        rm_rf($root1);
        rm_rf($root2);

        that(self::resolveFunction('dir_diff'))($root1, $root2)->wasThrown('does not exists');
        mkdir($root1, 0777, true);
        that(self::resolveFunction('dir_diff'))($root1, $root2)->notWasThrown('does not exists');

        file_set_tree([
            $root1 => [
                'file1'     => 'file',
                'file2'     => 'file2',
                'file3'     => 'file3',
                'empty'     => [],
                'empty1'    => [],
                'samedir'   => [
                    'file' => 'file',
                ],
                'directory' => [
                    'file1' => 'file',
                    'file2' => 'file2',
                    'file3' => 'file3',
                ],
                'casedir'   => [
                    'file1' => 'file',
                    'file2' => 'file2',
                    'file3' => 'file3',
                ],
                'entry'     => [
                    'file1' => 'file1',
                ],
            ],
            $root2 => [
                'file1'     => 'file',
                'file2'     => 'fileEX',
                'file4'     => 'file4',
                'empty'     => [],
                'empty2'    => [],
                'samedir'   => [
                    'file' => 'file',
                ],
                'directory' => [
                    'file1' => 'file',
                    'file2' => 'fileEX',
                    'file4' => 'file4',
                ],
                'CASEDIR'   => [
                    'file1' => 'file',
                    'file2' => 'fileEX',
                    'file4' => 'file4',
                ],
                'entry'     => 'file',
            ],
        ]);

        that(dir_diff($root1, $root2, [
            'unixpath'       => true,
            'case-sensitive' => true,
        ]))->is([
            "CASEDIR/"        => false,
            "CASEDIR/file1"   => false,
            "CASEDIR/file2"   => false,
            "CASEDIR/file4"   => false,
            "casedir/"        => true,
            "casedir/file1"   => true,
            "casedir/file2"   => true,
            "casedir/file3"   => true,
            "directory/file2" => "",
            "directory/file3" => true,
            "directory/file4" => false,
            "empty1/"         => true,
            "empty2/"         => false,
            "entry"           => false,
            "entry/"          => true,
            "entry/file1"     => true,
            "file2"           => "",
            "file3"           => true,
            "file4"           => false,
        ]);

        $DS = DIRECTORY_SEPARATOR;
        that(dir_diff($root1, $root2, [
            'case-sensitive' => true,
        ]))->is([
            "CASEDIR{$DS}"        => false,
            "CASEDIR{$DS}file1"   => false,
            "CASEDIR{$DS}file2"   => false,
            "CASEDIR{$DS}file4"   => false,
            "casedir{$DS}"        => true,
            "casedir{$DS}file1"   => true,
            "casedir{$DS}file2"   => true,
            "casedir{$DS}file3"   => true,
            "directory{$DS}file2" => "",
            "directory{$DS}file3" => true,
            "directory{$DS}file4" => false,
            "empty1{$DS}"         => true,
            "empty2{$DS}"         => false,
            "entry"               => false,
            "entry{$DS}"          => true,
            "entry{$DS}file1"     => true,
            "file2"               => "",
            "file3"               => true,
            "file4"               => false,
        ]);
        that(dir_diff($root1, $root2, [
            'case-sensitive' => false,
        ]))->is([
            "CASEDIR{$DS}file4"   => false,
            "casedir{$DS}file2"   => "",
            "casedir{$DS}file3"   => true,
            "directory{$DS}file2" => "",
            "directory{$DS}file3" => true,
            "directory{$DS}file4" => false,
            "empty1{$DS}"         => true,
            "empty2{$DS}"         => false,
            "entry"               => false,
            "entry{$DS}"          => true,
            "entry{$DS}file1"     => true,
            "file2"               => "",
            "file3"               => true,
            "file4"               => false,
        ]);

        that(dir_diff($root1, $root2, [
            'case-sensitive' => true,
            'recursive'      => false,
        ]))->is([
            "CASEDIR{$DS}" => false,
            "casedir{$DS}" => true,
            "empty1{$DS}"  => true,
            "empty2{$DS}"  => false,
            "entry"        => false,
            "entry{$DS}"   => true,
            "file2"        => "",
            "file3"        => true,
            "file4"        => false,
        ]);

        that(dir_diff($root1, $root2, [
            'case-sensitive' => false,
            'recursive'      => false,
            'differ'         => fn($file1, $file2) => file_equals($file1, $file2) ? null : file_get_contents($file1) . '<>' . file_get_contents($file2),
        ]))->is([
            "empty1{$DS}" => true,
            "empty2{$DS}" => false,
            "entry"       => false,
            "entry{$DS}"  => true,
            "file2"       => "file2<>fileEX",
            "file3"       => true,
            "file4"       => false,
        ]);
    }

    function test_dirmtime()
    {
        $dir = self::$TMPDIR . '/mtime';
        mkdir_p($dir);
        rm_rf($dir, false);
        $base = strtotime('2036/12/31 12:34:56');

        // 空っぽなので自身の mtime
        touch($dir, $base);
        that(dirmtime($dir))->is($base);

        // ファイルが有ればその mtime
        touch("$dir/tmp1", $base + 10);
        that(dirmtime($dir))->is($base + 10);

        // 更に新しい方
        touch("$dir/tmp2", $base + 20);
        that(dirmtime($dir))->is($base + 20);

        // 新しい方を消すと古い方
        unlink("$dir/tmp2");
        that(dirmtime($dir))->is($base + 10);

        // 古い方も消すと自分自身（他にエントリがなく、削除によって自身も更新されているので現在時刻になる）
        unlink("$dir/tmp1");
        that(dirmtime($dir))->isBetween(time() - 2, time());

        // 再帰フラグの確認
        file_set_contents("$dir/dir1/tmp", 'dummy');
        touch("$dir/dir1/tmp", $base + 20);
        touch("$dir/dir1", $base + 10);
        that(dirmtime($dir, true))->is($base + 20);
        that(dirmtime($dir, false))->is($base + 10);

        that(self::resolveFunction('dirmtime'))(__FILE__)->wasThrown('is not directory');
    }

    function test_dirname_r()
    {
        // composer.json が見つかるまで親を辿って見つかったらそのパスを返す
        that(dirname_r(__DIR__, fn($path) => realpath("$path/composer.json")))->is(realpath(__DIR__ . '/../../../composer.json'));
        // 見つからない場合は false を返す
        that(dirname_r(__DIR__, fn($path) => realpath("$path/notfound.ext")))->is(false);
        // 使い方の毛色は違うが、このようにすると各構成要素が得られる
        $paths = [];
        that(dirname_r('/root/path/to/something', function ($path) use (&$paths) {
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

    function test_file_equals()
    {
        $root1 = self::$TMPDIR . '/file_equals1';
        $root2 = self::$TMPDIR . '/file_equals2';
        rm_rf($root1);
        rm_rf($root2);

        file_set_tree([
            $root1 => [
                'file1'      => 'file',
                'file2'      => 'file2',
                'file3'      => 'file3',
                'directory1' => [
                    'hoge' => 'hoge',
                    'fuga' => 'fuga',
                    'piyo' => 'piyo',
                ],
                'directory2' => [
                    'hoge' => 'hoge',
                    'fuga' => 'fuga',
                ],
            ],
            $root2 => [
                'file1'      => 'file',
                'file2'      => 'file9',
                'file3'      => 'file999',
                'directory1' => [
                    'hoge' => 'hoge',
                    'fuga' => 'fuga',
                ],
                'directory2' => [
                    'hoge' => 'hoge',
                    'fuga' => 'fuga',
                    'piyo' => 'piyo',
                ],
            ],
        ]);

        that(file_equals($root1, $root2))->isTrue();
        that(file_equals("$root1/file1", "$root2/file1"))->isTrue();
        that(file_equals("$root1/file2", "$root2/file2"))->isFalse();
        that(file_equals("$root1/file3", "$root2/file3"))->isFalse();
        that(file_equals("$root1/directory1", "$root2/directory1"))->isFalse();
        that(file_equals("$root1/directory2", "$root2/directory2"))->isFalse();
        that(file_equals("$root1/file1", "$root2/directory1"))->isFalse();

        that(self::resolveFunction('file_equals'))("$root1/file1", "$root2/unknown")->wasThrown('not exist');
    }

    function test_file_extension()
    {
        $DS = DIRECTORY_SEPARATOR;
        that(file_extension("filename.old", 'new'))->is("filename.new");
        that(file_extension("path{$DS}filename.old", 'new'))->is("path{$DS}filename.new");
        that(file_extension("{$DS}fullpath{$DS}filename.old", 'new'))->is("{$DS}fullpath{$DS}filename.new");
        that(file_extension("filename", 'new'))->is("filename.new");
        that(file_extension("filename.old.", 'new'))->is("filename.old.new");
        that(file_extension("filename.old1.old2", 'new'))->is("filename.old1.new");

        that(file_extension('filename.old', '.new'))->is('filename.new');
        that(file_extension('filename.old', 'new'))->is('filename.new');
        that(file_extension('filename.old', ''))->is('filename');
        that(file_extension('filename.old', '.'))->is('filename.');
        that(file_extension('filename.old', '...'))->is('filename.');

        that(file_extension('filename.suf.ext'))->is('ext');
        that(file_extension('filename.ext'))->is('ext');
        that(file_extension('filename.'))->is('');
        that(file_extension('filename'))->is(null);
        that(file_extension('.ext'))->is('ext');
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

        $tmpdir = self::$TMPDIR;
        file_put_contents($php_utf8 = "$tmpdir/data.php", '<?php return ' . var_export($array, true) . ';');
        file_put_contents($csv_utf8 = "$tmpdir/data.csv", csv_export($array, ['structure' => true]));
        file_put_contents($csv_sjis = "$tmpdir/data.sjis.csv", mb_convert_encoding(csv_export($array, ['structure' => true]), 'sjis'));
        file_put_contents($json_utf8 = "$tmpdir/data.json", json_export($array));
        file_put_contents($json_sjis = "$tmpdir/data.sjis.json", mb_convert_encoding(json_export($array), 'sjis'));
        file_put_contents($jsonl_utf8 = "$tmpdir/data.jsonl", implode("\n", array_map(fn($v) => json_export($v), $array)));
        file_put_contents($jsonl_sjis = "$tmpdir/data.sjis.jsonl", mb_convert_encoding(implode("\n", array_map(fn($v) => json_export($v), $array)), 'sjis'));
        file_put_contents($yaml_utf8 = "$tmpdir/data.yaml", yaml_emit($array, YAML_UTF8_ENCODING));
        file_put_contents($yaml_sjis = "$tmpdir/data.sjis.yaml", mb_convert_encoding(yaml_emit($array, YAML_UTF8_ENCODING), 'sjis'));
        file_put_contents($ltsv_utf8 = "$tmpdir/data.ltsv", implode("\n", array_map(fn($v) => ltsv_export($v), $array)));
        file_put_contents($ltsv_sjis = "$tmpdir/data.sjis.ltsv", mb_convert_encoding(implode("\n", array_map(fn($v) => ltsv_export($v), $array)), 'sjis'));

        that(file_get_arrays($php_utf8))->is($array);
        that(file_get_arrays($csv_utf8))->is($array);
        that(file_get_arrays($csv_sjis))->is($array);
        that(file_get_arrays($json_utf8))->is($array);
        that(file_get_arrays($json_sjis))->is($array);
        that(file_get_arrays($jsonl_utf8))->is($array);
        that(file_get_arrays($jsonl_sjis))->is($array);
        that(file_get_arrays($yaml_utf8))->is($array);
        that(file_get_arrays($yaml_sjis))->is($array);
        that(file_get_arrays($ltsv_utf8))->is($array);
        that(file_get_arrays($ltsv_sjis))->is($array);

        file_put_contents($empty_php = "$tmpdir/empty.php", "<?php return [];");
        file_put_contents($empty1_csv = "$tmpdir/empty1.csv", "id,name");
        file_put_contents($empty2_csv = "$tmpdir/empty2.csv", "");
        file_put_contents($empty_json = "$tmpdir/empty.json", "[]");
        file_put_contents($empty_jsonl = "$tmpdir/empty.jsonl", "");
        file_put_contents($empty1_yaml = "$tmpdir/empty.yaml", "---");
        file_put_contents($empty2_yaml = "$tmpdir/empty2.yaml", "");
        file_put_contents($empty_ltsv = "$tmpdir/empty.ltsv", "");

        that(file_get_arrays($empty_php))->is([]);
        that(file_get_arrays($empty1_csv))->is([]);
        that(file_get_arrays($empty2_csv))->is([]);
        that(file_get_arrays($empty_json))->is([]);
        that(file_get_arrays($empty_jsonl))->is([]);
        that(file_get_arrays($empty1_yaml))->is([]);
        that(file_get_arrays($empty2_yaml))->is([]);
        that(file_get_arrays($empty_ltsv))->is([]);

        file_put_contents($csv_undefined = "$tmpdir/data.undefined.csv", "a,i,u,e,o\nあ,い,う,え,お");
        that(file_get_arrays($csv_undefined))->is([['a' => 'あ', 'i' => 'い', 'u' => 'う', 'e' => 'え', 'o' => 'お']]);

        touch($txt = self::$TMPDIR . '/hoge.txt');
        touch($xml = self::$TMPDIR . '/hoge.xml');
        that(self::resolveFunction('file_get_arrays'))('notfoundfile')->wasThrown('is not exists');
        that(self::resolveFunction('file_get_arrays'))($txt)->wasThrown('is not supported');
        that(self::resolveFunction('file_get_arrays'))($xml)->wasThrown('in the future');
    }

    function test_file_list()
    {
        $DS = DIRECTORY_SEPARATOR;
        $base = self::$TMPDIR . $DS . 'list';
        rm_rf($base);
        file_set_contents($base . '/a/a1.txt', '');
        file_set_contents($base . '/a/a2.txt', '');
        file_set_contents($base . '/a//b/ab1.txt', '');
        file_set_contents($base . '/a//b/ab2.log', 'xxx');
        file_set_contents($base . '/a//b/c/abc1.log', 'xxxxx');
        file_set_contents($base . '/a//b/c/abc2.log', 'xxxxxxx');

        that(file_list('/notfound'))->isFalse();

        // 単純列挙
        that(file_list($base))->equalsCanonicalizing([
            "$base{$DS}a{$DS}a1.txt",
            "$base{$DS}a{$DS}a2.txt",
            "$base{$DS}a{$DS}b{$DS}ab1.txt",
            "$base{$DS}a{$DS}b{$DS}ab2.log",
            "$base{$DS}a{$DS}b{$DS}c{$DS}abc1.log",
            "$base{$DS}a{$DS}b{$DS}c{$DS}abc2.log",
        ]);

        // ツリー構造
        that(file_list($base, ["nesting" => true, '!type' => null]))->equalsCanonicalizing([
            [
                "a1.txt" => "$base{$DS}a{$DS}a1.txt",
                "a2.txt" => "$base{$DS}a{$DS}a2.txt",
                "b"      => [
                    "ab1.txt" => "$base{$DS}a{$DS}b{$DS}ab1.txt",
                    "ab2.log" => "$base{$DS}a{$DS}b{$DS}ab2.log",
                    "c"       => [
                        "abc1.log" => "$base{$DS}a{$DS}b{$DS}c{$DS}abc1.log",
                        "abc2.log" => "$base{$DS}a{$DS}b{$DS}c{$DS}abc2.log",
                    ],
                ],
            ],
        ]);

        // 非再帰モード
        that(file_list("$base{$DS}a", ["recursive" => false, "!type" => null]))->equalsCanonicalizing([
            "$base{$DS}a{$DS}a1.txt",
            "$base{$DS}a{$DS}a2.txt",
            "$base{$DS}a{$DS}b{$DS}",
        ]);

        // 相対パスモード
        that(file_list($base, ["relative" => true]))->equalsCanonicalizing([
            "a{$DS}a1.txt",
            "a{$DS}a2.txt",
            "a{$DS}b{$DS}ab1.txt",
            "a{$DS}b{$DS}ab2.log",
            "a{$DS}b{$DS}c{$DS}abc1.log",
            "a{$DS}b{$DS}c{$DS}abc2.log",
        ]);

        // unixpath モード
        that(file_list($base, ['unixpath' => true]))->equalsCanonicalizing([
            strtr($base, [$DS => '/']) . "/a/a1.txt",
            strtr($base, [$DS => '/']) . "/a/a2.txt",
            strtr($base, [$DS => '/']) . "/a/b/ab1.txt",
            strtr($base, [$DS => '/']) . "/a/b/ab2.log",
            strtr($base, [$DS => '/']) . "/a/b/c/abc1.log",
            strtr($base, [$DS => '/']) . "/a/b/c/abc2.log",
        ]);

        // glob モード
        that(file_list("$base/*/*.txt"))->equalsCanonicalizing([
            strtr($base, [$DS => '/']) . "/a/a1.txt",
            strtr($base, [$DS => '/']) . "/a/a2.txt",
        ]);
        that(file_list("$base/a/*.txt"))->equalsCanonicalizing([
            strtr($base, [$DS => '/']) . "/a/a1.txt",
            strtr($base, [$DS => '/']) . "/a/a2.txt",
        ]);
        that(file_list("$base/*/*/*.log"))->equalsCanonicalizing([
            strtr($base, [$DS => '/']) . "/a/b/ab2.log",
        ]);
        that(file_list("$base/**.log"))->equalsCanonicalizing([
            strtr($base, [$DS => '/']) . "/a/b/ab2.log",
            strtr($base, [$DS => '/']) . "/a/b/c/abc1.log",
            strtr($base, [$DS => '/']) . "/a/b/c/abc2.log",
        ]);

        // 拡張子でフィルタ
        that(file_list($base, ["extension" => "txt"]))->equalsCanonicalizing([
            "$base{$DS}a{$DS}a1.txt",
            "$base{$DS}a{$DS}a2.txt",
            "$base{$DS}a{$DS}b{$DS}ab1.txt",
        ]);

        // ファイルサイズでフィルタ
        that(file_list($base, ["size" => [1]]))->equalsCanonicalizing([
            "$base{$DS}a{$DS}b{$DS}ab2.log",
            "$base{$DS}a{$DS}b{$DS}c{$DS}abc1.log",
            "$base{$DS}a{$DS}b{$DS}c{$DS}abc2.log",
        ]);

        that(self::resolveFunction('file_list'))('hoge/*', ['subpath' => 'fuga'])->wasThrown('both subpath and subpattern are specified');
    }

    function test_file_matcher()
    {
        $base = self::$TMPDIR . '/tree';
        file_set_contents($base . '/a/a1.txt', 'xxx');
        file_set_contents($base . '/a/a2.txt', str_repeat("y\n", 30000));

        chmod($base . '/a/a1.txt', 0666);
        touch($base . '/a/a1.txt', strtotime('2000/12/24 12:34:56'));
        touch($base . '/a/a2.txt', strtotime('-1 week'));

        that(file_matcher([])('hoge'))->isTrue();

        that(file_matcher(['dotfile' => true])('/a/b/c/.file'))->isTrue();
        that(file_matcher(['dotfile' => true])('/a/b/c/file'))->isFalse();
        that(file_matcher(['dotfile' => false])('/a/b/c/.file'))->isFalse();
        that(file_matcher(['dotfile' => false])('/a/b/c/file'))->isTrue();

        if (DIRECTORY_SEPARATOR === '\\') {
            that(file_matcher(['unixpath' => true, 'dir' => '/a/b/c'])('\\a\\b\\c\\file'))->isTrue();
            that(file_matcher(['unixpath' => false, 'dir' => '/a/b/c'])('\\a\\b\\c\\file'))->isFalse();
        }

        that(file_matcher(['casefold' => true, 'name' => 'FILE'])('/a/b/c/file'))->isTrue();
        that(file_matcher(['casefold' => false, 'name' => 'FILE'])('/a/b/c/file'))->isFalse();
        that(file_matcher(['casefold' => true, 'extension' => 'TXT'])('/a/b/c/file.txt'))->isTrue();
        that(file_matcher(['casefold' => false, 'extension' => 'TXT'])('/a/b/c/file.txt'))->isFalse();

        that(file_matcher(['type' => 'file'])($base . '/a/a1.txt'))->isTrue();
        that(file_matcher(['type' => 'link'])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['!type' => 'file'])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['!type' => 'link'])($base . '/a/a1.txt'))->isTrue();

        that(file_matcher(['perms' => 0400])($base . '/a/a1.txt'))->isTrue();
        that(file_matcher(['!perms' => 0400])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['perms' => 0100])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['!perms' => 0100])($base . '/a/a1.txt'))->isTrue();

        that(file_matcher(['mtime' => strtotime('2000/12/24 12:34:56')])($base . '/a/a1.txt'))->isTrue();
        that(file_matcher(['!mtime' => strtotime('2000/12/24 12:34:56')])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['mtime' => strtotime('1999/12/24 12:34:56')])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['!mtime' => strtotime('1999/12/24 12:34:56')])($base . '/a/a1.txt'))->isTrue();

        that(file_matcher(['mtime' => ['-1 month']])($base . '/a/a2.txt'))->isTrue();
        that(file_matcher(['!mtime' => ['-1 month']])($base . '/a/a2.txt'))->isFalse();
        that(file_matcher(['mtime' => ['-1 month', '-2 week']])($base . '/a/a2.txt'))->isFalse();
        that(file_matcher(['!mtime' => ['-1 month', '-2 week']])($base . '/a/a2.txt'))->isTrue();

        that(file_matcher(['size' => 3])($base . '/a/a1.txt'))->isTrue();
        that(file_matcher(['!size' => 3])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['size' => 9])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['!size' => 9])($base . '/a/a1.txt'))->isTrue();

        that(file_matcher(['size' => ['10k', '70k']])($base . '/a/a2.txt'))->isTrue();
        that(file_matcher(['!size' => ['10k', '70k']])($base . '/a/a2.txt'))->isFalse();
        that(file_matcher(['size' => ['70k', '99k']])($base . '/a/a2.txt'))->isFalse();
        that(file_matcher(['!size' => ['70k', '99k']])($base . '/a/a2.txt'))->isTrue();

        that(file_matcher(['path' => '#a/b/c/f#i'])('/a/b/c/file'))->isTrue();
        that(file_matcher(['!path' => '#a/b/c/f#i'])('/a/b/c/file'))->isFalse();
        that(file_matcher(['path' => '#a/b/c/X#i'])('/a/b/c/file'))->isFalse();
        that(file_matcher(['!path' => '#a/b/c/X#i'])('/a/b/c/file'))->isTrue();

        that(file_matcher(['path' => '/a/*.txt'])('/a/b/c/file.txt'))->isTrue();
        that(file_matcher(['!path' => '/a/*.txt'])('/a/b/c/file.txt'))->isFalse();
        that(file_matcher(['path' => '/a/*.not'])('/a/b/c/file.txt'))->isFalse();
        that(file_matcher(['!path' => '/a/*.not'])('/a/b/c/file.txt'))->isTrue();

        that(file_matcher(['path' => ['#file#i', '*.txt']])('/a/b/c/file.txt'))->isTrue();
        that(file_matcher(['path' => ['*.txt', '#.*\.invalid#i']])('/a/b/c/file.txt'))->isTrue();
        that(file_matcher(['path' => ['#.*\.invalid#i', '*.txt']])('/a/b/c/file.txt'))->isTrue();
        that(file_matcher(['path' => ['#.*\.invalid#i', '*.invalid']])('/a/b/c/file.txt'))->isFalse();

        that(file_matcher(['path' => '{a.*\.TXT}i'])('/a/b/c/file.txt'))->isTrue();
        that(file_matcher(['!path' => '{a.*\.TXT}i'])('/a/b/c/file.txt'))->isFalse();
        that(file_matcher(['path' => '{a.*\.NOT}i'])('/a/b/c/file.txt'))->isFalse();
        that(file_matcher(['!path' => '{a.*\.NOT}i'])('/a/b/c/file.txt'))->isTrue();

        that(file_matcher(['subpath' => '/a/*.txt'])('/a/b/c/file.txt'))->isTrue();
        that(file_matcher(['!subpath' => '/a/*.txt'])('/a/b/c/file.txt'))->isFalse();
        that(file_matcher(['subpath' => '/a/*.not'])('/a/b/c/file.txt'))->isFalse();
        that(file_matcher(['!subpath' => '/a/*.not'])('/a/b/c/file.txt'))->isTrue();

        that(file_matcher(['dir' => '#a/b/c#i'])('/a/b/c/file'))->isTrue();
        that(file_matcher(['!dir' => '#a/b/c#i'])('/a/b/c/file'))->isFalse();
        that(file_matcher(['dir' => '#a/b/c/f#i'])('/a/b/c/file'))->isFalse();
        that(file_matcher(['!dir' => '#a/b/c/f#i'])('/a/b/c/file'))->isTrue();

        that(file_matcher(['name' => '#file#i'])('/a/b/c/file'))->isTrue();
        that(file_matcher(['!name' => '#file#i'])('/a/b/c/file'))->isFalse();
        that(file_matcher(['name' => '#fail#i'])('/a/b/c/file'))->isFalse();
        that(file_matcher(['!name' => '#fail#i'])('/a/b/c/file'))->isTrue();

        that(file_matcher(['basename' => '#^file$#i'])('/a/b/c/file.ext'))->isTrue();
        that(file_matcher(['!basename' => '#^file$#i'])('/a/b/c/file.ext'))->isFalse();
        that(file_matcher(['basename' => '#^fail$#i'])('/a/b/c/file.ext'))->isFalse();
        that(file_matcher(['!basename' => '#^fail$#i'])('/a/b/c/file.ext'))->isTrue();

        that(file_matcher(['extension' => 'ext'])('/a/b/c/file.ext'))->isTrue();
        that(file_matcher(['!extension' => 'ext'])('/a/b/c/file.ext'))->isFalse();
        that(file_matcher(['extension' => 'not'])('/a/b/c/file.ext'))->isFalse();
        that(file_matcher(['!extension' => 'not'])('/a/b/c/file.ext'))->isTrue();

        that(file_matcher(['contains' => 'xx'])($base . '/a/a1.txt'))->isTrue();
        that(file_matcher(['!contains' => 'xx'])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['contains' => 'zz'])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['!contains' => 'zz'])($base . '/a/a1.txt'))->isTrue();

        $filter = fn($file) => mime_content_type($file->getPathname()) === 'text/plain';
        that(file_matcher(['filter' => $filter])($base . '/a/a1.txt'))->isTrue();
        that(file_matcher(['!filter' => $filter])($base . '/a/a1.txt'))->isFalse();
        $filter = fn($file) => mime_content_type($file->getPathname()) === 'text/html';
        that(file_matcher(['filter' => $filter])($base . '/a/a1.txt'))->isFalse();
        that(file_matcher(['!filter' => $filter])($base . '/a/a1.txt'))->isTrue();
    }

    function test_file_mimetype()
    {
        that(file_mimetype(__FILE__))->is('text/x-php');
        that(@(fn(...$args) => file_mimetype(...$args))('notfound'))->isNull();
        that(error_get_last()['message'])->contains('mime_content_type(notfound)');

        if (!defined('TESTWEBSERVER')) {
            return;
        }
        $server = TESTWEBSERVER;
        that(file_mimetype("$server/get"))->is('application/json');
        @that(file_mimetype("$server/not"))->isNull();
        that(error_get_last()['message'])->contains('404');
    }

    function test_file_pos()
    {
        $tmpfile = self::$TMPDIR . '/posfile.txt';
        file_put_contents($tmpfile, str_repeat('x', 100) . "abc");

        that(file_pos($tmpfile, 'x'))->is(0);
        that(file_pos($tmpfile, 'x', 1))->is(1);
        that(file_pos($tmpfile, 'x', 2))->is(2);
        that(file_pos($tmpfile, 'x', 99))->is(99);
        that(file_pos($tmpfile, 'x', 100))->is(false);

        that(file_pos($tmpfile, 'abc'))->is(100);
        that(file_pos($tmpfile, 'abc', -1))->is(false);
        that(file_pos($tmpfile, 'abc', -2))->is(false);
        that(file_pos($tmpfile, 'abc', -3))->is(100);

        that(file_pos($tmpfile, 'abc', 1, 10, 4))->is(false);
        that(file_pos($tmpfile, 'abc', 1, 100))->is(false);
        that(file_pos($tmpfile, 'abc', 1, 101))->is(false);
        that(file_pos($tmpfile, 'abc', 1, 102))->is(false);
        that(file_pos($tmpfile, 'abc', 1, 103))->is(100);
        that(file_pos($tmpfile, 'abc', 101))->is(false);

        that(file_pos($tmpfile, 'abc', 100, 101))->is(false);
        that(file_pos($tmpfile, 'abc', 100, 102))->is(false);
        that(file_pos($tmpfile, 'abc', 100, 103))->is(100);

        that(file_pos($tmpfile, 'ab', 0, -1))->is(100);
        that(file_pos($tmpfile, 'ab', 0, -2))->is(false);
        that(file_pos($tmpfile, 'ab', 0, -3))->is(false);

        that(file_pos($tmpfile, 'xab', 99, -1))->is(99);
        that(file_pos($tmpfile, 'xab', 99, -2))->is(false);
        that(file_pos($tmpfile, 'xab', 99, -3))->is(false);

        that(file_pos($tmpfile, 'abc', 0, null, 3))->is(100);
        that(file_pos($tmpfile, 'abc', 0, null, 4))->is(100);
        that(file_pos($tmpfile, 'abc', 0, null, 5))->is(100);

        file_put_contents($tmpfile, "0123|4567|89AB|CDEF|GHIJ|KLMN|OPQR|STUV|WXYZ|abcd|efgh|ijkl|mnop|qrst|uvwx|yz");

        that(file_pos($tmpfile, ['0123|', 'uvwx|'], 0, null, 5))->is(0);
        that(file_pos($tmpfile, ['X123|', 'uvwx|'], 0, null, 5))->is(70);
        that(file_pos($tmpfile, ['X123|', 'Xvwx|'], 0, null, 5))->is(false);
        that(file_pos($tmpfile, ['23|45', 'st|uv'], 0, null, 5))->is(2);
        that(file_pos($tmpfile, ['X3|45', 'st|uv'], 0, null, 5))->is(67);
        that(file_pos($tmpfile, ['X3|45', 'Xt|uv'], 0, null, 5))->is(false);

        that(file_pos($tmpfile, ['X123|4567', '0123|4567|89AB'], 0, 10))->is(false);
        that(file_pos($tmpfile, ['X123|4567', '0123|4567|89AB'], 0, 15))->is(0);

        file_put_contents($tmpfile, str_repeat('ん', 100) . "あ");

        that(file_pos($tmpfile, 'あ'))->is(300);
        that(file_pos($tmpfile, 'あ', 299))->is(300);
        that(file_pos($tmpfile, 'あ', 300))->is(300);
        that(file_pos($tmpfile, 'あ', 301))->is(false);

        that(self::resolveFunction('file_pos'))('not found', 'hoge')->wasThrown('is not found');
    }

    function test_file_rewrite_contents()
    {
        $testpath = self::$TMPDIR . '/rewrite/test.txt';
        file_set_contents($testpath, 'dummy');

        // standard
        $bytes = file_rewrite_contents($testpath, function ($contents, $fp) {
            that($contents)->is('dummy');
            that($fp)->isResource();
            return 'rewrite!';
        });
        that($bytes)->is(8);
        that('rewrite!')->equalsFile($testpath);

        // 0 bytes
        $bytes = file_rewrite_contents($testpath, fn($contents) => '');
        that($bytes)->is(0);
        that('')->equalsFile($testpath);

        // no exists
        $bytes = file_rewrite_contents(dirname($testpath) . '/test2.txt', fn($contents) => 'test2!', LOCK_EX);
        that($bytes)->is(6);
        that('test2!')->equalsFile(dirname($testpath) . '/test2.txt');

        // lock
        $bytes = file_rewrite_contents($testpath, fn($contents) => 'locked!', LOCK_EX);
        that($bytes)->is(7);
        that('locked!')->equalsFile($testpath);

        // open failed
        @that(self::resolveFunction('file_rewrite_contents'))(dirname($testpath), fn() => null)->wasThrown('failed to fopen');

        // lock failed
        $fp = fopen($testpath, 'r');
        flock($fp, LOCK_EX);
        @that(self::resolveFunction('file_rewrite_contents'))($testpath, fn() => null, LOCK_EX | LOCK_NB)->wasThrown('failed to flock');
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    function test_file_set_contents()
    {
        $dir = self::$TMPDIR . '/dir1/dir2/dir3/';
        rm_rf($dir);

        file_set_contents("$dir/hoge.txt", 'hoge');
        that('hoge')->equalsFile("$dir/hoge.txt");

        file_set_contents("$dir/dir4/fuga/../", 'fuga');
        that('fuga')->equalsFile("$dir/dir4");

        that(self::resolveFunction('file_set_contents'))('/dev/null/::::::/a', '')->wasThrown('failed to mkdir');

        $mpath = memory_path(__FUNCTION__);
        file_set_contents("$mpath/hoge.txt", 'hoge');
        that('hoge')->equalsFile("$mpath/hoge.txt");

        if (DIRECTORY_SEPARATOR === '\\') {
            error_clear_last();
            @file_set_contents('/dev/null/::::::', '');
            that(error_get_last()['message'])->stringContains('rename');
        }
    }

    function test_file_set_tree()
    {
        $DS = DIRECTORY_SEPARATOR;

        $root = self::$TMPDIR . $DS . 'file_set_tree';
        rm_rf($root);

        that(file_set_tree([
            $root => [
                'blank'      => '',
                'empty'      => [],
                'single.txt' => 'single',
                'directory'  => [
                    '1.txt' => '1',
                    '2.txt' => '22',
                    '3.txt' => '333',
                ],
                'closure1'   => fn() => [
                    'c' => 'c',
                ],
                'closure2'   => fn() => str_replace('/', $DS, implode(',', func_get_args())),
                'x'          => [
                    'y' => [
                        'z.txt' => 'xyz',
                    ],
                ],
                'a/b/c1'     => 'abc1',
                'a'          => [
                    'b/c2' => 'abc2',
                ],
            ],
        ]))->is([
            "$root{$DS}single.txt"          => 6,
            "$root{$DS}directory{$DS}1.txt" => 1,
            "$root{$DS}directory{$DS}2.txt" => 2,
            "$root{$DS}directory{$DS}3.txt" => 3,
            "$root{$DS}blank"               => 0,
            "$root{$DS}closure1{$DS}c"      => 1,
            "$root{$DS}closure2"            => strlen("$root{$DS}closure2") + strlen("$root") + strlen("closure2") + 2,
            "$root{$DS}x{$DS}y{$DS}z.txt"   => 3,
            "$root{$DS}a{$DS}b{$DS}c1"      => 4,
            "$root{$DS}a{$DS}b{$DS}c2"      => 4,
        ]);

        that("$root{$DS}blank")->fileEquals('');
        that("$root{$DS}empty")->directoryExists();
        that("$root{$DS}single.txt")->fileEquals('single');
        that("$root{$DS}directory{$DS}1.txt")->fileEquals('1');
        that("$root{$DS}directory{$DS}2.txt")->fileEquals('22');
        that("$root{$DS}directory{$DS}3.txt")->fileEquals('333');
        that("$root{$DS}closure1{$DS}c")->fileEquals('c');
        that("$root{$DS}closure2")->fileEquals(path_normalize("$root{$DS}closure2,$root,closure2"));
        that("$root{$DS}x{$DS}y{$DS}z.txt")->fileEquals('xyz');
        that("$root{$DS}a{$DS}b{$DS}c1")->fileEquals('abc1');
        that("$root{$DS}a{$DS}b{$DS}c2")->fileEquals('abc2');
    }

    function test_file_slice()
    {
        $tmpfile = self::$TMPDIR . '/file_slice.txt';
        file_put_contents($tmpfile, implode("\n", array_map(fn($n) => $n % 2 ? $n : "", range(1, 20))));

        // 1行だけサクッと読む
        that(file_slice($tmpfile, 1, 1))->is([
            1 => "1\n",
        ]);

        // normal
        that(file_slice($tmpfile, 2, 5))->count(5)->is([
            2 => "\n",
            3 => "3\n",
            4 => "\n",
            5 => "5\n",
            6 => "\n",
        ]);

        // end_line
        that(file_slice($tmpfile, 4, -9))->is([
            4 => "\n",
            5 => "5\n",
            6 => "\n",
            7 => "7\n",
            8 => "\n",
            9 => "9\n",
        ]);

        // end_line
        that(file_slice($tmpfile, 15, null))->is([
            15 => "15\n",
            16 => "\n",
            17 => "17\n",
            18 => "\n",
            19 => "19\n",
        ]);

        // flags
        that(file_slice($tmpfile, 2, 5, FILE_IGNORE_NEW_LINES))->is([
            2 => "",
            3 => "3",
            4 => "",
            5 => "5",
            6 => "",
        ]);
        that(file_slice($tmpfile, 2, 5, FILE_SKIP_EMPTY_LINES))->is([
            3 => "3\n",
            5 => "5\n",
        ]);
        that(file_slice($tmpfile, 2, 5, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))->is([
            3 => "3",
            5 => "5",
        ]);
    }

    function test_file_suffix()
    {
        $DS = DIRECTORY_SEPARATOR;
        that(file_suffix("filename.ext", '-suffix'))->is("filename-suffix.ext");
        that(file_suffix("path{$DS}filename.ext", '-suffix'))->is("path{$DS}filename-suffix.ext");
        that(file_suffix("path{$DS}filename", '-suffix'))->is("path{$DS}filename-suffix");
        that(file_suffix("filename.ext1.ext2", '.suffix'))->is("filename.suffix.ext1.ext2");
        that(file_suffix("filename.", '.'))->is("filename..");
        that(file_suffix("filename.", '-suf'))->is("filename-suf.");
        that(file_suffix("filename.ext", ''))->is("filename.ext");
    }

    function test_file_tree()
    {
        $DS = DIRECTORY_SEPARATOR;

        $base = self::$TMPDIR . $DS . 'tree';
        rm_rf($base);
        file_set_contents($base . '/a/a1.txt', '');
        file_set_contents($base . '/a/a2.txt', '');
        file_set_contents($base . '/a//b/ab1.txt', '');
        file_set_contents($base . '/a//b/ab2.log', 'xxx');
        file_set_contents($base . '/a//b/c/abc1.log', 'xxxxx');
        file_set_contents($base . '/a//b/c/abc2.log', 'xxxxxxx');
        file_set_contents($base . '/x.ext', '');

        that(file_tree('/notfound'))->isFalse();

        // 単純列挙
        that(file_tree($base))->isSame([
            "tree" => [
                "x.ext" => "$base{$DS}x.ext",
                "a"     => [
                    "a1.txt" => "$base{$DS}a{$DS}a1.txt",
                    "a2.txt" => "$base{$DS}a{$DS}a2.txt",
                    "b"      => [
                        "ab1.txt" => "$base{$DS}a{$DS}b{$DS}ab1.txt",
                        "ab2.log" => "$base{$DS}a{$DS}b{$DS}ab2.log",
                        "c"       => [
                            "abc1.log" => "$base{$DS}a{$DS}b{$DS}c{$DS}abc1.log",
                            "abc2.log" => "$base{$DS}a{$DS}b{$DS}c{$DS}abc2.log",
                        ],
                    ],
                ],
            ],
        ]);

        // 拡張子でフィルタ
        that(file_tree($base, ["extension" => "txt"]))->isSame([
            "tree" => [
                "a" => [
                    "a1.txt" => "$base{$DS}a{$DS}a1.txt",
                    "a2.txt" => "$base{$DS}a{$DS}a2.txt",
                    "b"      => [
                        "ab1.txt" => "$base{$DS}a{$DS}b{$DS}ab1.txt",
                        "c"       => [],
                    ],
                ],
            ],
        ]);

        // ファイルサイズでフィルタ
        that(file_tree($base, ["size" => [1]]))->isSame([
            "tree" => [
                "a" => [
                    "b" => [
                        "ab2.log" => "$base{$DS}a{$DS}b{$DS}ab2.log",
                        "c"       => [
                            "abc1.log" => "$base{$DS}a{$DS}b{$DS}c{$DS}abc1.log",
                            "abc2.log" => "$base{$DS}a{$DS}b{$DS}c{$DS}abc2.log",
                        ],
                    ],
                ],
            ],
        ]);
    }

    function test_fnmatch_and()
    {
        that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaXbbbX'))->isTrue();
        that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaX'))->isFalse();

        that(self::resolveFunction('fnmatch_and'))([], '')->wasThrown('empty');
    }

    function test_fnmatch_or()
    {
        that(fnmatch_or(['*aaa*', '*bbb*'], 'aaaX'))->isTrue();
        that(fnmatch_or(['*aaa*', '*bbb*'], 'cccX'))->isFalse();

        that(self::resolveFunction('fnmatch_or'))([], '')->wasThrown('empty');
    }

    function test_mkdir_p()
    {
        $dir = self::$TMPDIR . '/dir1/dir2/dir3/';
        rm_rf($dir);
        that(mkdir_p($dir))->isTrue();
        that($dir)->fileExists();
        that(mkdir_p($dir))->isFalse();
    }

    function test_path_info()
    {
        $DS = DIRECTORY_SEPARATOR;

        if ($DS === '\\') {
            that(path_info('C:\\dir1\\dir2\\\\file.sjis.min.js'))->is([
                "dirname"    => "C:\\dir1\dir2",
                "basename"   => "file.sjis.min.js",
                "extension"  => "js",
                "filename"   => "file.sjis.min",
                "drive"      => "C:",
                "root"       => "\\",
                "parents"    => ["dir1", "dir2"],
                "dirnames"   => ["dir1", "dir2"],
                "localname"  => "file",
                "localpath"  => "C:\\dir1\\dir2\\file",
                "extensions" => ["sjis", "min", "js"],
            ]);
            that(path_info('\\dir1\\dir2\\\\file.sjis.min.js'))->is([
                "dirname"    => "\\dir1\\dir2",
                "basename"   => "file.sjis.min.js",
                "extension"  => "js",
                "filename"   => "file.sjis.min",
                "drive"      => "",
                "root"       => "\\",
                "parents"    => ["dir1", "dir2"],
                "dirnames"   => ["dir1", "dir2"],
                "localname"  => "file",
                "localpath"  => "\\dir1\\dir2\\file",
                "extensions" => ["sjis", "min", "js"],
            ]);
            that(path_info('dir1\\dir2\\\\file.sjis.min.js'))->is([
                "dirname"    => "dir1\\dir2",
                "basename"   => "file.sjis.min.js",
                "extension"  => "js",
                "filename"   => "file.sjis.min",
                "drive"      => "",
                "root"       => "",
                "parents"    => ["dir1", "dir2"],
                "dirnames"   => ["dir1", "dir2"],
                "localname"  => "file",
                "localpath"  => "dir1\\dir2\\file",
                "extensions" => ["sjis", "min", "js"],
            ]);
            // 下記2ケースのオリジナルの pathinfo の結果が明らかに不穏
            that(path_info('C:\\'))->is([
                "dirname"    => "C:\\",
                "basename"   => "C",
                "extension"  => "",
                "filename"   => "C",
                "drive"      => "C:",
                "root"       => "\\",
                "parents"    => [],
                "dirnames"   => [],
                "localname"  => "",
                "localpath"  => "C:\\",
                "extensions" => [],
            ]);
            that(path_info('C:\\C'))->is([
                "dirname"    => "C:\\",
                "basename"   => "C",
                "extension"  => "",
                "filename"   => "C",
                "drive"      => "C:",
                "root"       => "\\",
                "parents"    => [],
                "dirnames"   => [],
                "localname"  => "C",
                "localpath"  => "C:\\\\C",
                "extensions" => [],
            ]);
        }
        that(path_info('C:/dir1/dir2//file.sjis.min.js'))->is([
            "dirname"    => "C:/dir1/dir2",
            "basename"   => "file.sjis.min.js",
            "extension"  => "js",
            "filename"   => "file.sjis.min",
            "drive"      => "C:",
            "root"       => "/",
            "parents"    => ["dir1", "dir2"],
            "dirnames"   => ["dir1", "dir2"],
            "localname"  => "file",
            "localpath"  => "C:/dir1/dir2{$DS}file",
            "extensions" => ["sjis", "min", "js"],
        ]);
        that(path_info('/dir1/dir2//file.sjis.min.js'))->is([
            "dirname"    => "/dir1/dir2",
            "basename"   => "file.sjis.min.js",
            "extension"  => "js",
            "filename"   => "file.sjis.min",
            "drive"      => "",
            "root"       => "/",
            "parents"    => ["dir1", "dir2"],
            "dirnames"   => ["dir1", "dir2"],
            "localname"  => "file",
            "localpath"  => "/dir1/dir2{$DS}file",
            "extensions" => ["sjis", "min", "js"],
        ]);
        that(path_info('dir1/dir2//file.sjis.min.js'))->is([
            "dirname"    => "dir1/dir2",
            "basename"   => "file.sjis.min.js",
            "extension"  => "js",
            "filename"   => "file.sjis.min",
            "drive"      => "",
            "root"       => "",
            "parents"    => ["dir1", "dir2"],
            "dirnames"   => ["dir1", "dir2"],
            "localname"  => "file",
            "localpath"  => "dir1/dir2{$DS}file",
            "extensions" => ["sjis", "min", "js"],
        ]);
        that(path_info('dir1.dot/./dir2.dot/file.ext'))->is([
            "dirname"    => "dir1.dot/./dir2.dot",
            "basename"   => "file.ext",
            "extension"  => "ext",
            "filename"   => "file",
            "drive"      => "",
            "root"       => "",
            "parents"    => ["dir1.dot", "dir2.dot"],
            "dirnames"   => ["dir1.dot", ".", "dir2.dot"],
            "localname"  => "file",
            "localpath"  => "dir1.dot/./dir2.dot{$DS}file",
            "extensions" => ["ext"],
        ]);
        that(path_info('dir1.dot/../dir2.dot/file.ext'))->is([
            "dirname"    => "dir1.dot/../dir2.dot",
            "basename"   => "file.ext",
            "extension"  => "ext",
            "filename"   => "file",
            "drive"      => "",
            "root"       => "",
            "parents"    => ["dir2.dot"],
            "dirnames"   => ["dir1.dot", "..", "dir2.dot"],
            "localname"  => "file",
            "localpath"  => "dir1.dot/../dir2.dot{$DS}file",
            "extensions" => ["ext"],
        ]);
        that(path_info('no.dir'))->is([
            "dirname"    => ".",
            "basename"   => "no.dir",
            "extension"  => "dir",
            "filename"   => "no",
            "drive"      => "",
            "root"       => "",
            "parents"    => [],
            "dirnames"   => [],
            "localname"  => "no",
            "localpath"  => "no",
            "extensions" => ["dir"],
        ]);
        that(path_info('localonly'))->is([
            "dirname"    => ".",
            "basename"   => "localonly",
            "extension"  => "",
            "filename"   => "localonly",
            "drive"      => "",
            "root"       => "",
            "parents"    => [],
            "dirnames"   => [],
            "localname"  => "localonly",
            "localpath"  => "localonly",
            "extensions" => [],
        ]);
        that(path_info('.ext.only'))->is([
            "dirname"    => ".",
            "basename"   => ".ext.only",
            "extension"  => "only",
            "filename"   => ".ext",
            "drive"      => "",
            "root"       => "",
            "parents"    => [],
            "dirnames"   => [],
            "localname"  => "",
            "localpath"  => "",
            "extensions" => ["ext", "only"],
        ]);
        that(path_info('...'))->is([
            "dirname"    => ".",
            "basename"   => "...",
            "extension"  => "",
            "filename"   => "..",
            "drive"      => "",
            "root"       => "",
            "parents"    => [],
            "dirnames"   => [],
            "localname"  => "",
            "localpath"  => "",
            "extensions" => ["", "", ""],
        ]);
        that(path_info(''))->is([
            "dirname"    => "",
            "basename"   => "",
            "extension"  => "",
            "filename"   => "",
            "drive"      => "",
            "root"       => "",
            "parents"    => [],
            "dirnames"   => [],
            "localname"  => "",
            "localpath"  => "",
            "extensions" => [],
        ]);
    }

    function test_path_is_absolute()
    {
        that(path_is_absolute('a/b/c'))->isFalse();
        that(path_is_absolute('/a/b/c'))->isTrue();
        $DS = DIRECTORY_SEPARATOR;
        if ($DS === '\\') {
            that(path_is_absolute("C:"))->isTrue();
            that(path_is_absolute("C:\\path"))->isTrue();
            that(path_is_absolute("\\a\\/b\\c"))->isTrue();
            that(path_is_absolute('a\\b\\c'))->isFalse();
            that(path_is_absolute('file:///C:\\path'))->isTrue();
        }

        that(path_is_absolute('http://example.jp'))->isFalse();
        that(path_is_absolute('http://example.jp/path'))->isTrue();
        that(path_is_absolute('file:///path'))->isTrue();
        that(path_is_absolute('file://localhost/C:\\path'))->isTrue();
    }

    function test_path_normalize()
    {
        $DS = DIRECTORY_SEPARATOR;
        // empty
        that(path_normalize(''))->is("");
        // current
        that(path_normalize('./'))->is("");
        that(path_normalize('./././././'))->is("");
        // root
        that(path_normalize('/'))->is("{$DS}");
        that(path_normalize('///////'))->is("{$DS}");
        // 1文字
        that(path_normalize('a'))->is("a");
        // /1文字
        that(path_normalize('/a'))->is("{$DS}a");
        that(path_normalize('/////a'))->is("{$DS}a");
        // root ピッタリな相対
        that(path_normalize('/a/../'))->is("{$DS}");
        that(path_normalize('/a/../././b/../'))->is("{$DS}");
        // 単純な相対
        that(path_normalize('/a/b/c/../d/./e'))->is("{$DS}a{$DS}b{$DS}d{$DS}e");
        // 相対パス
        that(path_normalize('a/b/c/../../d/./e'))->is("a{$DS}d{$DS}e");
        // 連続ドット
        that(path_normalize('/a.b/c..d'))->is("{$DS}a.b{$DS}c..d");
        // 連続区切り
        that(path_normalize('//a//b//'))->is("{$DS}a{$DS}b");
        // Windows
        if ($DS === '\\') {
            // \\ 区切り
            that(path_normalize('C:\\//a\\/b/\\c/../\\d'))->is('C:\\a\\b\\d');
            // 連続区切り
            that(path_normalize('\\/a/\\\\/\\b'))->is("{$DS}a{$DS}b");
        }
        // スキームは保持される
        that(path_normalize('dummy://a/b'))->is("dummy://a/b");
        // いきなり親をたどると例外
        that(self::resolveFunction('path_normalize'))('../')->wasThrown('is invalid');
        // 辿りすぎも例外
        that(self::resolveFunction('path_normalize'))('a/b/c/../../../..')->wasThrown('is invalid');
    }

    function test_path_parse()
    {
        $DS = DIRECTORY_SEPARATOR;

        that(path_parse("/path/to/local.txt"))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => "local.txt",
            "extension"    => "txt",
            "filename"     => "local",
            "dirlocalname" => "{$DS}path{$DS}to{$DS}local",
            "localname"    => "local",
            "extensions"   => ["txt"],
        ]);
        that(path_parse("/path/to/local.txt1.txt2"))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => "local.txt1.txt2",
            "filename"     => "local.txt1",
            "extension"    => "txt2",
            "dirlocalname" => "{$DS}path{$DS}to{$DS}local",
            "localname"    => "local",
            "extensions"   => ["txt1", "txt2"],
        ]);
        that(path_parse("/path/to/local"))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => "local",
            "filename"     => "local",
            "extension"    => null,
            "dirlocalname" => "{$DS}path{$DS}to{$DS}local",
            "localname"    => "local",
            "extensions"   => [],
        ]);
        that(path_parse("/path/to/local."))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => "local.",
            "filename"     => "local",
            "extension"    => "",
            "dirlocalname" => "{$DS}path{$DS}to{$DS}local",
            "localname"    => "local",
            "extensions"   => [""],
        ]);
        that(path_parse("/path/to/.local"))->is([
            "dirname"      => "{$DS}path{$DS}to",
            "basename"     => ".local",
            "filename"     => "",
            "extension"    => "local",
            "dirlocalname" => "{$DS}path{$DS}to",
            "localname"    => "",
            "extensions"   => ["local"],
        ]);
        that(path_parse("/local.txt"))->is([
            "dirname"      => "{$DS}",
            "basename"     => "local.txt",
            "filename"     => "local",
            "extension"    => "txt",
            "dirlocalname" => "{$DS}local",
            "localname"    => "local",
            "extensions"   => ["txt"],
        ]);
        that(path_parse("local"))->is([
            "dirname"      => "",
            "basename"     => "local",
            "filename"     => "local",
            "extension"    => null,
            "dirlocalname" => "local",
            "localname"    => "local",
            "extensions"   => [],
        ]);
        that(path_parse(""))->is([
            "dirname"      => "",
            "basename"     => "",
            "filename"     => "",
            "extension"    => null,
            "dirlocalname" => "{$DS}",
            "localname"    => "",
            "extensions"   => [],
        ]);
        that(path_parse("/"))->is([
            "dirname"      => "{$DS}",
            "basename"     => "",
            "filename"     => "",
            "extension"    => null,
            "dirlocalname" => "{$DS}",
            "localname"    => "",
            "extensions"   => [],
        ]);
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

            that(path_relative($data[0], $data[1]))->as(var_pretty([
                'args'   => [$data[0], $data[1]],
                'return' => $data[2],
            ], ['return' => true]
            ))->is($data[2]);

            if (DIRECTORY_SEPARATOR === '\\') {
                $data[0] = strtolower('C:' . $data[0]);
                $data[1] = strtoupper('C:' . $data[1]);
                $data[2] = strtoupper($data[2]);

                that(path_relative($data[0], $data[1]))->as(var_pretty([
                    'args'   => [$data[0], $data[1]],
                    'return' => $data[2],
                ], ['return' => true]
                ))->is($data[2]);
            }
        }
    }

    function test_path_resolve()
    {
        $DS = DIRECTORY_SEPARATOR;
        that(path_resolve('a/b/c'))->is(getcwd() . "{$DS}a{$DS}b{$DS}c");
        that(path_resolve('/a/b/c'))->is("{$DS}a{$DS}b{$DS}c");
        that(path_resolve('/root', 'a/b/c'))->is("{$DS}root{$DS}a{$DS}b{$DS}c");
        that(path_resolve('/root', '../a/b/c'))->is("{$DS}a{$DS}b{$DS}c");
        that(path_resolve('root', 'a/b/c'))->is(getcwd() . "{$DS}root{$DS}a{$DS}b{$DS}c");
        if ($DS === '\\') {
            that(path_resolve('C:\\a\\b\\c'))->is('C:\\a\\b\\c');
        }

        that(path_resolve(basename(__FILE__), [__DIR__]))->is(__FILE__);
        that(path_resolve(basename(__DIR__) . DIRECTORY_SEPARATOR . basename(__FILE__), [dirname(__DIR__)]))->is(__FILE__);
        that(path_resolve('notfound', [__DIR__]))->isNull();
    }

    function test_rm_rf()
    {
        $dir = self::$TMPDIR . '/dir1/dir2/dir3';
        $dir2 = dirname($dir);
        $dir1 = dirname($dir2);

        file_set_contents("$dir/a.txt", '');
        rm_rf($dir2);
        that($dir2)->fileNotExists();       // 自身は消える
        that(dirname($dir2))->fileExists(); // 親は残る
        that(rm_rf($dir))->isFalse();       // 存在しないと false を返す

        file_set_contents("$dir/a.txt", '');
        rm_rf($dir1, false);
        that($dir1)->fileExists();    // 自身は残る
        that($dir2)->fileNotExists(); // 子は消える

        $dir = self::$TMPDIR . '/rm_rf';
        file_set_contents("$dir/a/x.txt", '');
        file_set_contents("$dir/a/aa/xx.txt", '');
        file_set_contents("$dir/b/x.txt", '');
        file_set_contents("$dir/c/x.txt", '');
        file_set_contents("$dir/.dotfile", '');

        that(rm_rf("$dir/a", false))->isTrue();
        that("$dir/a")->directoryExists();     // a は残る
        that("$dir/a/x.txt")->fileNotExists(); // x は消える

        that(rm_rf("$dir/b", true))->isTrue();
        that("$dir/b")->directoryNotExists();  // b は消える
        that("$dir/b/x.txt")->fileNotExists(); // x は消える

        that(rm_rf("$dir/*", false))->isTrue();
        that("$dir/c")->directoryExists();     // c は残る
        that("$dir/c/x.txt")->fileNotExists(); // x は消える

        that(rm_rf("$dir/*", true))->isTrue();
        that("$dir/c")->directoryNotExists();  // c は消える
        that("$dir/c/x.txt")->fileNotExists(); // x は消える

        that(rm_rf("$dir/*", true))->isFalse();
        that("$dir/.dotfile")->fileExists();

        that(rm_rf("$dir/.dotfile", true))->isTrue();
        that("$dir/.dotfile")->fileNotExists(); // ファイルも消せる

        $dir = memory_path('rm_rf');
        file_set_contents("$dir/a/x.txt", '');
        file_set_contents("$dir/a.txt", '');
        that(rm_rf($dir))->isTrue();
        that($dir)->fileNotExists();
    }

    function test_strmode()
    {
        $cases = [
            [004_0777, 'drwxrwxrwx'],
            [010_0700, '-rwx------'],
            [012_0070, 'l---rwx---'],
            [000_0007, '------rwx'],

            [0001, '--------x'],
            [0002, '-------w-'],
            [0003, '-------wx'],
            [0004, '------r--'],
            [0005, '------r-x'],
            [0006, '------rw-'],
            [0007, '------rwx'],

            [0_0000, '---------'],
            [0_1000, '--------T'],
            [0_1001, '--------t'],
            [0_2000, '-----S---'],
            [0_2010, '-----s---'],
            [0_4000, '--S------'],
            [0_4100, '--s------'],
        ];

        foreach ($cases as [$octet, $perms]) {
            that(strmode($octet))->as(sprintf('%05o<=>%s', $octet, $perms))->is($perms);
        }
        that(self::resolveFunction('strmode'))('hoge')->wasThrown('must be int');
        that(self::resolveFunction('strmode'))(077_0000)->wasThrown('unknown type');

        foreach ($cases as [$octet, $perms]) {
            that(strmode2oct($perms))->as(sprintf('%05o<=>%s', $octet, $perms))->is($octet);
        }
        that(self::resolveFunction('strmode2oct'))('hoge')->wasThrown('invalid permission');
    }

    function test_tmpname()
    {
        $wd = self::$TMPDIR . '/tmpname';
        mkdir_p(self::$TMPDIR . '/tmpname');
        rm_rf(self::$TMPDIR . '/tmpname', false);

        $list = [
            tmpname('', $wd),
            tmpname('', $wd),
            tmpname('', $wd),
        ];
        $files = reflect_callable(self::resolveFunction('tmpname'))->getStaticVariables()['files'];
        that($files)->arrayHasKeyAll($list);

        foreach ($files as $name => $file) {
            that($name)->fileExists();
            $file->__destruct();
            that($name)->fileNotExists();
        }
    }
}
