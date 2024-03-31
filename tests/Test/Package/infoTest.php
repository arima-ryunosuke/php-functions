<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\ansi_colorize;
use function ryunosuke\Functions\Package\ansi_strip;
use function ryunosuke\Functions\Package\arguments;
use function ryunosuke\Functions\Package\cpu_timer;
use function ryunosuke\Functions\Package\file_set_contents;
use function ryunosuke\Functions\Package\get_modified_files;
use function ryunosuke\Functions\Package\get_uploaded_files;
use function ryunosuke\Functions\Package\ini_sets;
use function ryunosuke\Functions\Package\is_ansi;
use function ryunosuke\Functions\Package\php_binary;
use function ryunosuke\Functions\Package\sys_set_temp_dir;

class infoTest extends AbstractTestCase
{
    function test_ansi_colorize()
    {
        that(json_encode(ansi_colorize('hoge', 'RED black')))->isSame('"\u001b[30;41mhoge\u001b[39;49m"');
        that(json_encode(ansi_colorize('hoge', 'black+RED|bold,italic')))->isSame('"\u001b[30;41;1;3mhoge\u001b[39;49;22;23m"');
        that(json_encode(ansi_colorize('hoge', 'foo+bar')))->isSame('"\u001b[mhoge\u001b[m"');
        that(json_encode(ansi_colorize('A' . ansi_colorize('hoge', 'blue') . 'Z', 'RED')))->isSame('"\u001b[41mA\u001b[34mhoge\u001b[39mZ\u001b[49m"');

        // 視覚的に確認したいことがあるのでコピペ用に残しておく
        /** @noinspection PhpUnusedLocalVariableInspection */
        $test = function () {
            $styles = [
                'default',
                'black',
                'red',
                'green',
                'yellow',
                'blue',
                'magenta',
                'cyan',
                'white',
                'gray',
                'DEFAULT',
                'BLACK',
                'RED',
                'GREEN',
                'YELLOW',
                'BLUE',
                'MAGENTA',
                'CYAN',
                'WHITE',
                'GRAY',
                'bold',
                'faint',
                'italic',
                'underscore',
                'blink',
                'reverse',
                'conceal',
            ];
            foreach ($styles as $style) {
                printf("%10s: %s\n", $style, ansi_colorize("test", $style));
            }
        };
    }

    function test_ansi_strip()
    {
        $ansi_string = ansi_colorize('hoge', 'green');
        that(ansi_strip($ansi_string))->isSame('hoge');

        $ansi_string = ansi_colorize('hoge', 'bold green');
        that(ansi_strip($ansi_string))->isSame('hoge');

        $ansi_string = ansi_colorize('hoge', 'RED bold green');
        that(ansi_strip($ansi_string))->isSame('hoge');

        that(ansi_strip("prefix\e[a;b;cMsuffix"))->isSame('prefixsuffix');
        that(ansi_strip("prefix\e[a;b;Msuffix"))->isSame('prefixuffix');
    }

    function test_arguments()
    {
        // 超シンプル
        that(arguments([], 'arg1 arg2'))->isSame(['arg1', 'arg2']);

        // 普通のオプション＋デフォルト引数
        that(arguments([
            'opt1' => '',
            'opt2' => '',
            'arg1',
            'arg2',
            'def3',
            'def4',
        ], '--opt1 O1 --opt2 O2 arg1 arg2'))->isSame([
            'opt1' => 'O1',
            'opt2' => 'O2',
            'arg1',
            'arg2',
            'def3',
            'def4',
        ]);

        // ショートオプション
        that(arguments([
            'opt1 a' => '',
            'opt2 b' => '',
        ], '-a O1 -b O2 arg1 arg2'))->isSame([
            'opt1' => 'O1',
            'opt2' => 'O2',
            'arg1',
            'arg2',
        ]);

        // 値なしオプション
        that(arguments([
            'opt1 a' => null,
            'opt2 b' => null,
        ], '-a arg1 arg2'))->isSame([
            'opt1' => true,
            'opt2' => false,
            'arg1',
            'arg2',
        ]);

        // 値なしショートオプションの同時指定
        that(arguments([
            'opt1 a' => null,
            'opt2 b' => null,
            'opt3 c' => null,
        ], '-ac arg1 arg2'))->isSame([
            'opt1' => true,
            'opt2' => false,
            'opt3' => true,
            'arg1',
            'arg2',
        ]);

        // デフォルト値オプション
        that(arguments([
            'opt1 a' => 'def1',
            'opt2 b' => 'def2',
        ], '-a O1 arg1 arg2'))->isSame([
            'opt1' => 'O1',
            'opt2' => 'def2',
            'arg1',
            'arg2',
        ]);

        // 複数値オプション
        that(arguments([
            'opt1 a' => [],
            'opt2 b' => [],
        ], '-a O11 -a O12 -b O21 arg1 arg2'))->isSame([
            'opt1' => ['O11', 'O12'],
            'opt2' => ['O21'],
            'arg1',
            'arg2',
        ]);

        // クオーティング
        that(arguments([
            'opt' => '',
        ], '--opt "A B" "arg1 arg2" "a\\"b"'))->isSame([
            'opt' => 'A B',
            'arg1 arg2',
            'a"b',
        ]);

        // 知らんオプションが与えられた・・・が、 thrown が false である
        that(arguments([
            ''       => false,
            'opt1'   => '',
            'opt2 o' => '',
        ], '--opt1 A --long -o B -short'))->isSame([
            'opt1' => 'A',
            'opt2' => 'B',
            '--long',
            '-short',
        ]);

        // 知らんオプションが短縮名で複数与えられた・・・が、 thrown が false である
        that(arguments([
            ''       => false,
            'opt1 a' => null,
            'opt2 b' => null,
        ], ' A -ab B --unknown'))->isSame([
            'opt1' => true,
            'opt2' => true,
            'A',
            'B',
            '--unknown',
        ]);

        // 上記が成り立つのは「すべての短縮オプションが既知の場合」のみ
        that(arguments([
            ''       => false,
            'opt1 a' => null,
            'opt2 b' => null,
        ], ' A -aXb B --unknown'))->isSame([
            'opt1' => false,
            'opt2' => false,
            'A',
            '-aXb',
            'B',
            '--unknown',
        ]);

        // 知らんオプションが与えられた
        that(self::resolveFunction('arguments'))([], 'arg1 arg2 --hoge')->wasThrown('undefined option name');
        that(self::resolveFunction('arguments'))([], 'arg1 arg2 -h')->wasThrown('undefined short option');
        that(self::resolveFunction('arguments'))(['o1 a' => null, 'o2 b' => null], 'arg1 arg2 -abc')->wasThrown('undefined short option');

        // ルール不正
        that(self::resolveFunction('arguments'))(['opt1' => null, 'opt1 o' => null])->wasThrown('duplicated option name');
        that(self::resolveFunction('arguments'))(['opt1 o' => null, 'opt2 o' => null])->wasThrown('duplicated short option');

        // 複数指定された
        that(self::resolveFunction('arguments'))(['noreq n' => null], '--noreq arg1 arg2 -n')->wasThrown('specified already');
        that(self::resolveFunction('arguments'))(['opt a' => ''], '--opt O1 arg1 arg2 -a O2')->wasThrown('specified already');

        // 値が指定されていない
        that(self::resolveFunction('arguments'))(['req' => 'hoge'], 'arg1 arg2 --req')->wasThrown('requires value');
    }

    function test_cpu_timer()
    {
        $timer = cpu_timer();
        $result = $timer(function () {
            usleep(100 * 1000);
            $hash = '';
            foreach (range(0, 500) as $i) {
                $hash .= $i . sha1_file(realpath(__FILE__));
            }
            return $hash;
        });

        // 値自体に意味はないので結果の意味合いだけ確認
        that($result['user'] + $result['system'])->closesTo($result['time']);
        that($result['time'] + $result['idle'])->closesTo($result['real']);
        that($result['user%'] + $result['system%'])->closesTo(100.0);
        that($result['time%'] + $result['idle%'])->closesTo(100.0);
    }

    function test_get_modified_files()
    {
        $dir = self::$TMPDIR . '/get_modified_files/';
        file_set_contents("$dir/required.php", <<<PHP
            <?php
            require(__DIR__ . "/required1.php");
            require(__DIR__ . "/required2.tpl");
            require(__DIR__ . "/required3.php");
            PHP
        );
        file_set_contents("$dir/required1.php", '<?php return 1;');
        file_set_contents("$dir/required2.tpl", '<?php return 2;');
        file_set_contents("$dir/required3.php", '<?php return 3;');

        $file1 = realpath("$dir/required1.php");
        $file2 = realpath("$dir/required2.tpl");
        $file3 = realpath("$dir/required3.php");

        require "$dir/required.php";
        that(get_modified_files('*.php', '*.tpl'))->notContainsAll([$file1, $file2, $file3]);

        touch($file1, time() + 2);
        touch($file2, time() + 2);
        that(get_modified_files('*.php', '*.tpl'))->containsAll([$file1])->notContainsAll([$file2, $file3]);
        touch($file2, time() + 3);
        that(get_modified_files('*.tpl', '*.dmy'))->containsAll([$file2])->notContainsAll([$file1, $file3]);

        sleep(1);
        unlink($file3);
        that(get_modified_files('*.php', '*.tpl'))->containsAll([$file1, $file3])->notContainsAll([$file2]);

        touch($file3, time() + 2);
        that(get_modified_files('*.php', '*.tpl'))->containsAll([$file1, $file3])->notContainsAll([$file2]);
    }

    function test_get_uploaded_files()
    {
        $actual = get_uploaded_files([
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
        that($actual)->isSame([
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
        ]);
    }

    function test_getenvs()
    {
        putenv('ENV_1=env1');
        putenv('ENV_2=env2');
        putenv('ENV_3=');
        putenv('ENV_X');

        that(self::resolveFunction('getenvs'))([
            'env1'      => 'ENV_1',
            'env2'      => 'ENV_2',
            'env3'      => 'ENV_3',
            'envX'      => 'ENV_X',
            'undefined' => 'UNDEFINED',
        ])->is([
            'env1'      => 'env1',
            'env2'      => 'env2',
            'env3'      => '',
            'envX'      => null,
            'undefined' => null,
        ]);

        that(self::resolveFunction('getenvs'))([
            'c1' => ['undefined1', 'ENV_1', 'ENV_2'],
            'c2' => ['undefined1', 'undefined2', 'ENV_2', 'ENV_1'],
            ['undefined1', 'undefined2', 'ENV_2', 'ENV_1'],
            'c3' => ['undefined1', 'undefined2', 'undefined3'],
        ])->is([
            'c1'    => 'env1',
            'c2'    => 'env2',
            'ENV_2' => 'env2',
            'c3'    => null,
        ]);

        that(self::resolveFunction('getenvs'))(['ENV_1', 'ENV_2', 'ENV_3', 'ENV_X', 'undefined'])->is([
            'ENV_1'     => 'env1',
            'ENV_2'     => 'env2',
            'ENV_3'     => '',
            'ENV_X'     => null,
            'undefined' => null,
        ]);

        that(self::resolveFunction('getenvs'))([[]])->wasThrown('ambiguous');
        that(self::resolveFunction('getenvs'))([['u1', 'u2']])->wasThrown('ambiguous');
    }

    function test_ini_sets()
    {
        $precision = ini_get('precision');
        $disable_functions = ini_get('disable_functions');

        $restore = ini_sets([
            'precision'         => '1',
            'disable_functions' => 'time',
        ]);
        // precision は設定できる
        that(ini_get('precision'))->isSame('1');
        // disable_functions は設定不可
        that(ini_get('disable_functions'))->isSame($disable_functions);

        $restore();
        // 返り値のクロージャを呼ぶと戻る
        that(ini_get('precision'))->isSame($precision);
        that(ini_get('disable_functions'))->isSame($disable_functions);
    }

    function test_is_ansi()
    {
        // common
        putenv('TERM_PROGRAM=Hyper');
        that(is_ansi(STDOUT))->isTrue();
        putenv('TERM_PROGRAM=');

        // windows
        if (DIRECTORY_SEPARATOR === '\\') {
            putenv('TERM=dummy');
            that(is_ansi(STDOUT, '\\'))->isFalse();
            putenv('TERM=xterm');
            that(is_ansi(STDOUT, '\\'))->isTrue();
            putenv('TERM=');
            that(is_ansi(STDOUT, '/'))->isFalse();
            that(is_ansi(tmpfile(), '/'))->isFalse();
        }
    }

    function test_php_binary()
    {
        that(php_binary())->is(PHP_BINARY);
    }

    function test_setenvs()
    {
        that(self::resolveFunction('setenvs'))([
            'ENV_1'     => 'env1',
            'ENV_2'     => 'env2',
            'ENV_3'     => '',
            'ENV_X'     => null,
            'UNDEFINED' => null,
        ])->is([
            'ENV_1'     => true,
            'ENV_2'     => true,
            'ENV_3'     => true,
            'ENV_X'     => true,
            'UNDEFINED' => true,
        ]);

        that(getenv('ENV_1', true))->is('env1');
        that(getenv('ENV_2', true))->is('env2');
        that(getenv('ENV_3', true))->is('');
        that(getenv('ENV_X', true))->isFalse();
        that(getenv('undefined', true))->isFalse();
    }

    function test_sys_set_temp_dir()
    {
        // 変更できないので実質的にカバレッジのみ

        $tmpdir = $this->emptyDirectory();
        that(sys_set_temp_dir($tmpdir))->isFalse();
        that(sys_set_temp_dir('local'))->isFalse();
        that(sys_set_temp_dir($tmpdir, true, false))->isTrue();
        that(sys_set_temp_dir('local', true, false))->isTrue();
        that(sys_set_temp_dir($tmpdir, false, false))->isTrue();
        that(sys_set_temp_dir('local', false, false))->isTrue();
    }
}
