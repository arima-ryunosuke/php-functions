<?php

namespace ryunosuke\Test\Package;

use function tmpfile;

class UtilityTest extends AbstractTestCase
{
    function test_function_configure()
    {
        that((function_configure)('hoge'))->is(null);
        that((function_configure)(['other' => 'hoge']))->is(['other' => null]);
        that((function_configure)(['other' => 'fuga']))->is(['other' => 'hoge']);

        that(function_configure)(null)->wasThrown('unknown type(NULL)');
    }

    function test_ini_sets()
    {
        $precision = ini_get('precision');
        $disable_functions = ini_get('disable_functions');

        $restore = (ini_sets)([
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

    function test_getenvs()
    {
        putenv('ENV_1=env1');
        putenv('ENV_2=env2');
        putenv('ENV_3=');
        putenv('ENV_X');

        that(getenvs)([
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

        that(getenvs)([
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

        that(getenvs)(['ENV_1', 'ENV_2', 'ENV_3', 'ENV_X', 'undefined'])->is([
            'ENV_1'     => 'env1',
            'ENV_2'     => 'env2',
            'ENV_3'     => '',
            'ENV_X'     => null,
            'undefined' => null,
        ]);

        that(getenvs)([[]])->wasThrown('ambiguous');
        that(getenvs)([['u1', 'u2']])->wasThrown('ambiguous');
    }

    function test_setenvs()
    {
        that(setenvs)([
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

    function test_number_serial()
    {
        $numbers = [1, 2, 3, 5, 7, 8, 9];
        that((number_serial)($numbers, 1, '~'))->is(['1~3', 5, '7~9']);
        that((number_serial)($numbers, 1, null))->is([[1, 3], [5, 5], [7, 9]]);
        that((number_serial)($numbers, 1, fn($from, $to) => "$from~$to"))->is(['1~3', '5~5', '7~9']);
        that((number_serial)($numbers, -1, null))->is([[9, 7], [5, 5], [3, 1]]);

        $numbers = [0.1, 0.2, 0.3, 0.5, 0.7, 0.8, 0.9];
        that((number_serial)($numbers, 0.1, '~'))->is(['0.1~0.3', 0.5, '0.7~0.9']);
        that((number_serial)($numbers, -0.1, '~'))->is(['0.9~0.7', 0.5, '0.3~0.1']);

        that((number_serial)([]))->is([]);
        that((number_serial)([0]))->is([[0, 0]]);
        that((number_serial)([-1, 0, 1], 1, '~'))->is(['-1~1']);
        that((number_serial)([-1, 0.0, 1], 1, '~'))->is(['-1~1']);
        that((number_serial)([-0.1, 0.0, 0, 0.1], 0.1, '~'))->is(['-0.1~0', '0~0.1']);
        that((number_serial)([-0.2, 0.0, 0.2], 0.1, '~'))->isSame([-0.2, 0.0, 0.2]);

        // null は要するに range で復元できる形式となる
        $array = [-9, -5, -4, -3, -1, 1, 3, 4, 5, 9];
        that((array_flatten)((array_maps)((number_serial)($array), '...range')))->is($array);
    }

    function test_cacheobject()
    {
        /** @var \Psr16CacheInterface $cache */
        $tmpdir = sys_get_temp_dir() . '/cacheobject';
        (rm_rf)($tmpdir);
        $cache = (cacheobject)($tmpdir);

        /// single

        that($cache->get('hoge', 'notfound'))->isSame('notfound');
        that($cache->set('hoge', 'value'))->isTrue();
        that($cache->has('hoge'))->isTrue();
        that($cache->get('hoge'))->isSame('value');

        that($cache->delete('hoge'))->isTrue();
        that($cache->get('hoge'))->isNull();
        that($cache->delete('hoge'))->isFalse();

        that($cache->get('fuga'))->isNull();
        that($cache->set('fuga', 'value', 1))->isTrue();
        that($cache->has('fuga'))->isTrue();
        that($cache->get('fuga'))->isSame('value');
        sleep(2);
        that($cache->has('fuga'))->isFalse();
        that($cache->get('fuga'))->isNull();

        that($cache->get('piyo'))->isNull();
        that($cache->set('piyo', 'value', 1))->isTrue();
        that($cache->set('piyo', 'value', 0))->isTrue();
        that($cache->has('piyo'))->isFalse();
        that($cache->get('piyo'))->isNull();

        that($cache->clear())->isTrue();

        /// multiple

        that($cache->setMultiple([
            'hoge' => 'HOGE',
            'fuga' => 'FUGA',
        ]))->isTrue();
        that($cache->getMultiple(['hoge', 'fuga']))->isSame([
            'hoge' => 'HOGE',
            'fuga' => 'FUGA',
        ]);

        that($cache->deleteMultiple(['hoge']))->isTrue();
        that($cache->deleteMultiple(['hoge']))->isFalse();

        that($cache->getMultiple(['hoge', 'fuga'], 'default'))->isSame([
            'hoge' => 'default',
            'fuga' => 'FUGA',
        ]);

        that($cache->setMultiple(['fuga' => 'new'], 0))->isTrue();

        that($cache->getMultiple(['hoge', 'fuga'], 'default'))->isSame([
            'hoge' => 'default',
            'fuga' => 'default',
        ]);

        that($cache->setMultiple(['hoge' => 'new'], 1))->isTrue();

        that($cache->getMultiple(['hoge', 'fuga'], 'default'))->isSame([
            'hoge' => 'new',
            'fuga' => 'default',
        ]);
        sleep(2);
        that($cache->getMultiple(['hoge', 'fuga'], 'default'))->isSame([
            'hoge' => 'default',
            'fuga' => 'default',
        ]);

        // fetch
        that($cache->fetch('fetch', fn($cache) => 'ok', 1))->isSame('ok');
        that($cache->fetch('fetch', fn($cache) => 'ok2'))->isSame('ok');
        sleep(2);
        that($cache->fetch('fetch', fn($cache) => 'ok2', 1))->isSame('ok2');

        // fetchMultiple
        that($cache->fetchMultiple([
            'fetch'  => fn() => 'ok3',
            'fetchM' => fn() => 'okM',
        ], 1))->isSame([
            'fetch'  => 'ok2',
            'fetchM' => 'okM',
        ]);
        sleep(2);
        that($cache->fetchMultiple([
            'fetch'  => fn() => 'ok3',
            'fetchM' => fn() => 'okM2',
        ]))->isSame([
            'fetch'  => 'ok3',
            'fetchM' => 'okM2',
        ]);

        /// misc

        that($cache->set('path.to.dir', 'value'))->isTrue();
        that($cache->set('ttl', 'value', new \DateInterval('PT15S')))->isTrue();
        that($cache->get('hoge'))->isNull();
        that($cache->set('hoge', false))->isTrue();
        that($cache->has('hoge'))->isTrue();
        that($cache->get('hoge'))->isFalse();

        that($cache)->get('')->wasThrown('empty string');
        that($cache)->get('{dummy}')->wasThrown('reserved character');
        that($cache)->getMultiple(new \ArrayObject(['']))->wasThrown('empty string');
        that($cache)->set('ttl', 'value', 'hoge')->wasThrown('ttl must be');

        // clean

        that($cache->set('dir.expired', 'value', 1))->isTrue();
        sleep(2);
        that("$tmpdir/dir/expired.php")->fileExists();
        $cache = (cacheobject)($tmpdir, 1);
        that("$tmpdir/dir/expired.php")->fileNotExists();
        that("$tmpdir/dir")->directoryNotExists();
        that($cache->has('expired'))->isFalse();

        that($cache->keys('fetch*'))->hasKeyAll(['fetch', 'fetchM']);

        touch("$tmpdir/dummy.php");
        $cache->clean();
        that("$tmpdir/dummy.php")->fileExists();
    }

    function test_cachedir()
    {
        $tmpdir = sys_get_temp_dir() . '/test';
        (rm_rf)($tmpdir);
        /** @noinspection PhpDeprecationInspection */
        {
            (cachedir)($tmpdir);
            that((cachedir)())->is(realpath($tmpdir));
            that((cachedir)(sys_get_temp_dir()))->is(realpath($tmpdir));
        }
    }

    function test_cache()
    {
        $provider = fn() => sha1(uniqid(mt_rand(), true));

        // 何度呼んでもキャッシュされるので一致する
        $current = (cache)('test', $provider, null, false);
        that((cache)('test', $provider, null, false))->is($current);
        that((cache)('test', $provider, null, false))->is($current);
        that((cache)('test', $provider, null, false))->is($current);

        // 名前空間を変えれば異なる値が返る（ごく低確率でコケるが、無視していいレベル）
        that((cache)('test', $provider, __FUNCTION__, false))->isNotEqual($current);

        // null を与えると削除される
        that((cache)('test', null, __FUNCTION__, false))->isTrue();
        that((cache)('test', fn() => 1, __FUNCTION__, false))->is(1);
    }

    function test_cache_object()
    {
        (cache)(null, null);
        $value = sha1(uniqid(mt_rand(), true));

        $tmpdir = self::$TMPDIR . '/cache_object';
        (rm_rf)($tmpdir);
        (function_configure)(['cachedir' => $tmpdir]);
        (cache)('key', fn() => $value, 'hoge');
        (cache)(null, 'dummy');
        that("$tmpdir/hoge.php-cache")->fileExists();
        that((cache)('key', fn() => 'dummy', 'hoge'))->is($value);

        (cache)('key', fn() => $value, 'fuga');
        (cache)(null, null);
        that("$tmpdir/hoge.php-cache")->fileNotExists();
    }

    function test_cache_fetch()
    {
        /** @var \Psr16CacheInterface $cache */
        $tmpdir = sys_get_temp_dir() . '/cache_fetch';
        (rm_rf)($tmpdir);
        $cache = (cacheobject)($tmpdir);

        $value = sha1(uniqid(mt_rand(), true));

        that($cache->get('sha1random'))->isNull();
        that((cache_fetch)($cache, 'sha1random', fn() => $value, 1))->is($value);
        that($cache->get('sha1random'))->is($value);
        sleep(2);
        that($cache->get('sha1random'))->isNull();
    }

    function test_parse_namespace()
    {
        $actual = (parse_namespace)(__DIR__ . '/Utility/namespace-standard.php');
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "vendor\\NS"   => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "Space"       => "Sub\\Space",
                    "nsC"         => "vendor\\NS\\nsC",
                    "nsI"         => "vendor\\NS\\nsI",
                    "nsT"         => "vendor\\NS\\nsT",
                ],
            ],
            "other\\space" => [
                "const"    => [
                    "CONST" => "other\\space\\CONST",
                ],
                "function" => [],
                "alias"    => [],
            ],
        ]);

        $actual = (parse_namespace)(__DIR__ . '/Utility/namespace-multispace1.php');
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "vendor\\NS1"  => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS1\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS1\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "nsC"         => "vendor\\NS1\\nsC",
                    "nsI"         => "vendor\\NS1\\nsI",
                    "nsT"         => "vendor\\NS1\\nsT",
                    "D"           => "Main\\Sub11\\D",
                ],
            ],
            "other\\space" => [
                "const"    => [
                    "CONST1" => "other\\space\\CONST1",
                    "CONST2" => "other\\space\\CONST2",
                ],
                "function" => [],
                "alias"    => [],
            ],
            "vendor\\NS2"  => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS2\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS2\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "nsC"         => "vendor\\NS2\\nsC",
                    "nsI"         => "vendor\\NS2\\nsI",
                    "nsT"         => "vendor\\NS2\\nsT",
                    "D"           => "Main\\Sub12\\D",
                ],
            ],
        ]);

        $actual = (parse_namespace)(__DIR__ . '/Utility/namespace-multispace2.php');
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "vendor\\NS1"  => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS1\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS1\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "nsC"         => "vendor\\NS1\\nsC",
                    "nsI"         => "vendor\\NS1\\nsI",
                    "nsT"         => "vendor\\NS1\\nsT",
                    "D"           => "Main\\Sub21\\D",
                ],
            ],
            "other\\space" => [
                "const"    => [
                    "CONST1" => "other\\space\\CONST1",
                    "CONST2" => "other\\space\\CONST2",
                ],
                "function" => [],
                "alias"    => [],
            ],
            "vendor\\NS2"  => [
                "const"    => [
                    "DIRECTORY_SEPARATOR" => "DIRECTORY_SEPARATOR",
                    "DS"                  => "DIRECTORY_SEPARATOR",
                    "C1"                  => "Main\\C1",
                    "xC2"                 => "Main\\C2",
                    "C"                   => "Main\\Sub\\C",
                    "xC"                  => "Main\\Sub\\C",
                    "nsC"                 => "vendor\\NS2\\nsC",
                ],
                "function" => [
                    "array_chunk" => "array_chunk",
                    "AC"          => "array_chunk",
                    "f1"          => "Main\\f1",
                    "xf2"         => "Main\\f2",
                    "F"           => "Main\\Sub\\F",
                    "xF"          => "Main\\Sub\\F",
                    "nsF"         => "vendor\\NS2\\nsF",
                ],
                "alias"    => [
                    "ArrayObject" => "ArrayObject",
                    "AO"          => "ArrayObject",
                    "C1"          => "Main\\C1",
                    "xC2"         => "Main\\C2",
                    "sC"          => "Main\\Sub\\sC",
                    "C"           => "Main\\Sub\\C",
                    "xC"          => "Main\\Sub\\C",
                    "nsC"         => "vendor\\NS2\\nsC",
                    "nsI"         => "vendor\\NS2\\nsI",
                    "nsT"         => "vendor\\NS2\\nsT",
                    "D"           => "Main\\Sub22\\D",
                ],
            ],
        ]);

        $file = sys_get_temp_dir() . '/rf-parse_namespace.php';
        file_put_contents($file, '<?php namespace hoge;');
        that((parse_namespace)($file, ['cache' => false]))->hasKey('hoge');
        file_put_contents($file, '<?php namespace fuga;');
        that((parse_namespace)($file, ['cache' => false]))->hasKey('fuga');
    }

    function test_resolve_symbol()
    {
        $standard = __DIR__ . '/Utility/namespace-standard.php';
        $multispace1 = __DIR__ . '/Utility/namespace-multispace1.php';
        $multispace2 = __DIR__ . '/Utility/namespace-multispace2.php';

        that((resolve_symbol)('\\Full\\middle\\name', []))->is('\\Full\\middle\\name');
        that((resolve_symbol)('Space\\middle\\name', $standard))->is('Sub\\Space\\middle\\name');
        that((resolve_symbol)('xC', $standard))->is('Main\\Sub\\C');
        that((resolve_symbol)('ArrayObject', $standard))->is('ArrayObject');
        that((resolve_symbol)('ArrayObject', $standard, ['function']))->is(null);
        that((resolve_symbol)('AC', $standard))->is('array_chunk');
        that((resolve_symbol)('AC', $standard, ['const']))->is(null);
        that((resolve_symbol)('DS', $standard))->is('DIRECTORY_SEPARATOR');
        that((resolve_symbol)('DS', $standard, ['alias']))->is(null);

        that((resolve_symbol)('D', $standard))->is(null);
        that((resolve_symbol)('D', [$multispace1 => ['vendor\\NS1']]))->is('Main\\Sub11\\D');
        that((resolve_symbol)('D', [$multispace1 => ['vendor\\NS2']]))->is('Main\\Sub12\\D');
        that((resolve_symbol)('D', [$multispace2 => ['vendor\\NS1']]))->is('Main\\Sub21\\D');
        that((resolve_symbol)('D', [$multispace2 => ['vendor\\NS2']]))->is('Main\\Sub22\\D');
    }

    function test_parse_annotation()
    {
        that((parse_annotation)('aaaaa'))->isEmpty();

        $refmethod = new \ReflectionMethod(require __DIR__ . '/Utility/annotation.php', 'm');

        $actual = (parse_annotation)($refmethod);
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "single"    => ["123"],
            "closure"   => ["123", "+", "456"],
            "multi"     => ["a", "b", "c"],
            "quote"     => ["\"a b c\"", "123"],
            "noval"     => [
                null,
                null,
            ],
            "hash"      => [
                "a" => 123,
            ],
            "list"      => [123, 456],
            "hashX"     => [
                "a" => 123,
            ],
            "listX"     => [123, 456],
            "block"     => [
                "message" => ["this is message1\n    this is message2"],
            ],
            "blockX"    => [
                "message1" => ["this is message1"],
                "message2" => ["this is message2"],
            ],
            "double"    => [
                ["a"],
                ["b"],
                ["c\n\nthis", "is", "\\@escape"],
            ],
            "DateTime2" => \This\Is\Space\DateTime2::__set_state([
                "date"          => "2019-12-23 00:00:00.000000",
                "timezone_type" => 3,
                "timezone"      => "Asia/Tokyo",
            ]),
            "param"     => [
                ["string", "\$arg1", "引数1"],
                ["array", "\$arg2", "this", "is", "second", "argument"],
            ],
            "return"    => ["null", "返り値\nthis", "is", "\\@escape"],
        ]);

        $actual = (parse_annotation)($refmethod, [
            'single'  => true,
            'double'  => true,
            'block'   => true,
            'blockX'  => true,
            'closure' => fn($value) => (phpval)($value),
        ]);
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "single"    => "123",
            "closure"   => 579,
            "multi"     => ["a", "b", "c"],
            "quote"     => ["\"a b c\"", "123"],
            "noval"     => [
                null,
                null,
            ],
            "hash"      => [
                "a" => 123,
            ],
            "list"      => [123, 456],
            "hashX"     => [
                "a" => 123,
            ],
            "listX"     => [123, 456],
            "block"     => [
                "message" => "
    this is message1
    this is message2
",
            ],
            "blockX"    => [
                "message1" => "
    this is message1
",
                "message2" => "
    this is message2
",
            ],
            "double"    => ["a", "b", "c\n\nthis is \\@escape"],
            "DateTime2" => \This\Is\Space\DateTime2::__set_state([
                "date"          => "2019-12-23 00:00:00.000000",
                "timezone_type" => 3,
                "timezone"      => "Asia/Tokyo",
            ]),
            "param"     => [
                ["string", "\$arg1", "引数1"],
                ["array", "\$arg2", "this", "is", "second", "argument"],
            ],
            "return"    => ["null", "返り値\nthis", "is", "\\@escape"],
        ]);

        $actual = (parse_annotation)(new \ReflectionMethod(\This\Is\Space\DateTime2::class, 'method'), true);
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "message" => 'this is annotation',
        ]);

        $annotation = '
@hoge{a: 123}

@fuga {
    fuga1
    fuga2
}

@piyo dummy {
    piyo1: 1,
    piyo2: 2
}';
        $actual = (parse_annotation)($annotation);
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "hoge" => ['a' => 123],
            "fuga" => ["fuga1\n    fuga2"],
            "piyo" => [
                "dummy" => [
                    "piyo1" => 1,
                    "piyo2" => 2,
                ],
            ],
        ]);

        $actual = (parse_annotation)($annotation, true);
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "hoge" => "{a: 123}",
            "fuga" => "
    fuga1
    fuga2
",
            "piyo" => [
                "dummy" => "
    piyo1: 1,
    piyo2: 2
",
            ],
        ]);

        $actual = (parse_annotation)('
@mix type1{
    hoge1
    hoge2
}
@mix type2 {
    fuga1
    fuga2
}', true);
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "mix" => [
                "type1" => "
    hoge1
    hoge2
",
                "type2" => "
    fuga1
    fuga2
",
            ],
        ]);

        $actual = (parse_annotation)('
@mix hoge
@mix type {
    fuga1
    fuga2
}');
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "mix" => [
                0      => ["hoge"],
                "type" => ["fuga1\n    fuga2"],
            ],
        ]);

        $actual = (parse_annotation)('
@mix type{
    hoge1
    hoge2
}
@mix fuga
}');
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "mix" => [
                "type" => ["hoge1\n    hoge2"],
                0      => ["fuga\n}"],
            ],
        ]);

        $actual = (parse_annotation)('
@hoge This is hoge
@fuga This is fuga1
@fuga This is fuga2
', [
            'hoge' => [],
            'fuga' => null,
        ]);
        that($actual)->as('actual:' . (var_export2)($actual, true))->is([
            "hoge" => [
                ["This", "is", "hoge"],
            ],
            "fuga" => ["This", "is", "fuga2"],
        ]);
    }

    function test_is_ansi()
    {
        // common
        putenv('TERM_PROGRAM=Hyper');
        that((is_ansi)(STDOUT))->isTrue();
        putenv('TERM_PROGRAM=');

        // windows
        if (DIRECTORY_SEPARATOR === '\\') {
            putenv('TERM=dummy');
            that((is_ansi)(STDOUT, '\\'))->isFalse();
            putenv('TERM=xterm');
            that((is_ansi)(STDOUT, '\\'))->isTrue();
            putenv('TERM=');
            that((is_ansi)(STDOUT, '/'))->isFalse();
            that((is_ansi)(tmpfile(), '/'))->isFalse();
        }
    }

    function test_ansi_colorize()
    {
        that(json_encode((ansi_colorize)('hoge', 'RED black')))->isSame('"\u001b[30;41mhoge\u001b[39;49m"');
        that(json_encode((ansi_colorize)('hoge', 'black+RED|bold,italic')))->isSame('"\u001b[30;41;1;3mhoge\u001b[39;49;22;23m"');
        that(json_encode((ansi_colorize)('hoge', 'foo+bar')))->isSame('"\u001b[mhoge\u001b[m"');
        that(json_encode((ansi_colorize)('A' . (ansi_colorize)('hoge', 'blue') . 'Z', 'RED')))->isSame('"\u001b[41mA\u001b[34mhoge\u001b[39mZ\u001b[49m"');

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
                printf("%10s: %s\n", $style, (ansi_colorize)("test", $style));
            }
        };
    }

    function test_ansi_strip()
    {
        $ansi_string = (ansi_colorize)('hoge', 'green');
        that((ansi_strip)($ansi_string))->isSame('hoge');

        $ansi_string = (ansi_colorize)('hoge', 'bold green');
        that((ansi_strip)($ansi_string))->isSame('hoge');

        $ansi_string = (ansi_colorize)('hoge', 'RED bold green');
        that((ansi_strip)($ansi_string))->isSame('hoge');

        that((ansi_strip)("prefix\e[a;b;cMsuffix"))->isSame('prefixsuffix');
        that((ansi_strip)("prefix\e[a;b;Msuffix"))->isSame('prefixuffix');
    }

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
        $return = (process)(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
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
        $return = (process)(PHP_BINARY, $file, $stdin, $stdout, $stderr);
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
        $return = (process)(PHP_BINARY, $file, "STDIN!", $stdout, $stderr);
        that($return)->isSame(0);
        that($stdout)->isSame(str_repeat("o", 100 * 1000));
        that($stderr)->isSame(str_repeat("e", 100 * 1000));

        $return = (process)(PHP_BINARY, ['-r' => "syntax error"], '', $stdout, $stderr);
        that($return)->isSame(version_compare(PHP_VERSION, '8.0.0') >= 0 ? 255 : 254);
        that("$stdout $stderr")->stringContains('Parse error');

        $pingopt = DIRECTORY_SEPARATOR === '\\' ? '-n' : '-c';
        $return = (process)('ping', ["127.0.0.2", $pingopt => 1], '', $stdout, $stderr);
        that($return)->isSame(0);
        that($stdout)->stringContains('127.0.0.2');
        that($stderr)->isSame('');

        $return = (process)('ping', "unknownhost", '', $stdout, $stderr);
        that($return)->isNotSame(0);
        that("$stdout $stderr")->stringContains('unknownhost');

        (process)(PHP_BINARY, ['-r' => "echo getcwd();"], '', $stdout, $stderr, __DIR__);
        that($stdout)->isSame(__DIR__);

        (process)(PHP_BINARY, ['-r' => "echo getenv('HOGE');"], '', $stdout, $stderr, null, getenv() + ['HOGE' => 'hoge']);
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
        $process = (process_async)(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
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

        $process = (process_async)(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
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
        $process = (process_async)(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
        $process->setDestructAction('close');
        $time = microtime(true);
        unset($process);
        that(microtime(true) - $time)->gte(3);

        // terminate だと1秒もかからない
        $process = (process_async)(PHP_BINARY, $file, 'STDIN!', $stdout, $stderr);
        $process->setDestructAction('terminate');
        $time = microtime(true);
        unset($process);
        that(microtime(true) - $time)->lte(1.5);

        gc_collect_cycles();
    }

    function test_process_parallel()
    {
        that(process_parallel)(static function ($rate = 9) {
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

        that(process_parallel)([
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

    function test_arguments()
    {
        // 超シンプル
        that((arguments)([], 'arg1 arg2'))->isSame(['arg1', 'arg2']);

        // 普通のオプション＋デフォルト引数
        that((arguments)([
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
        that((arguments)([
            'opt1 a' => '',
            'opt2 b' => '',
        ], '-a O1 -b O2 arg1 arg2'))->isSame([
            'opt1' => 'O1',
            'opt2' => 'O2',
            'arg1',
            'arg2',
        ]);

        // 値なしオプション
        that((arguments)([
            'opt1 a' => null,
            'opt2 b' => null,
        ], '-a arg1 arg2'))->isSame([
            'opt1' => true,
            'opt2' => false,
            'arg1',
            'arg2',
        ]);

        // 値なしショートオプションの同時指定
        that((arguments)([
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
        that((arguments)([
            'opt1 a' => 'def1',
            'opt2 b' => 'def2',
        ], '-a O1 arg1 arg2'))->isSame([
            'opt1' => 'O1',
            'opt2' => 'def2',
            'arg1',
            'arg2',
        ]);

        // 複数値オプション
        that((arguments)([
            'opt1 a' => [],
            'opt2 b' => [],
        ], '-a O11 -a O12 -b O21 arg1 arg2'))->isSame([
            'opt1' => ['O11', 'O12'],
            'opt2' => ['O21'],
            'arg1',
            'arg2',
        ]);

        // クオーティング
        that((arguments)([
            'opt' => '',
        ], '--opt "A B" "arg1 arg2" "a\\"b"'))->isSame([
            'opt' => 'A B',
            'arg1 arg2',
            'a"b',
        ]);

        // 知らんオプションが与えられた・・・が、 thrown が false である
        that((arguments)([
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
        that((arguments)([
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
        that((arguments)([
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
        that(arguments)([], 'arg1 arg2 --hoge')->wasThrown('undefined option name');
        that(arguments)([], 'arg1 arg2 -h')->wasThrown('undefined short option');
        that(arguments)(['o1 a' => null, 'o2 b' => null], 'arg1 arg2 -abc')->wasThrown('undefined short option');

        // ルール不正
        that(arguments)(['opt1' => null, 'opt1 o' => null])->wasThrown('duplicated option name');
        that(arguments)(['opt1 o' => null, 'opt2 o' => null])->wasThrown('duplicated short option');

        // 複数指定された
        that(arguments)(['noreq n' => null], '--noreq arg1 arg2 -n')->wasThrown('specified already');
        that(arguments)(['opt a' => ''], '--opt O1 arg1 arg2 -a O2')->wasThrown('specified already');

        // 値が指定されていない
        that(arguments)(['req' => 'hoge'], 'arg1 arg2 --req')->wasThrown('requires value');
    }

    function test_stacktrace()
    {
        function test_stacktrace_in()
        {
            return (stacktrace)();
        }

        function test_stacktrace($that)
        {
            $that->that = $that;
            $c = fn($that) => (phpval)('\\ryunosuke\\Test\\Package\\test_stacktrace_in()');
            return $c($that);
        }

        $mock = new class() {
            static function sm($that) { return test_stacktrace($that); }

            function im() { return $this::sm($this); }
        };

        // stack
        $traces = explode("\n", $mock->im());
        that($traces[0])->stringContains('test_stacktrace_in');
        that($traces[1])->stringContains('eval');
        that($traces[2])->stringContains('{closure}');
        that($traces[3])->stringContains('evaluate');
        that($traces[4])->stringContains('phpval');
        that($traces[5])->stringContains('{closure}');
        that($traces[6])->stringContains('test_stacktrace');
        that($traces[7])->stringContains('::sm');
        that($traces[8])->stringContains('->im');

        // limit
        $traces = (stacktrace)([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    123456789,
                    'stringarg',
                    'long string long string long string',
                    (stdclass)(['name' => "fields"]),
                    ['a', 'b', 'c'],
                    ['a' => 'A', 'b' => 'B', 'c' => 'C'],
                    ['n' => ['e' => ['s' => ['t' => 'X']]]],
                    ['la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la', 'la'],
                ],
            ],
        ]);
        that($traces)->stringContains('123456789')
            ->stringContains('stringarg')
            ->stringContains('long string long...(more 19 length)')
            ->stringContains('stdClass{name:"fields"}')
            ->stringContains('["a", "b", "c"]')
            ->stringContains('{a:"A", b:"B", c:"C"}')
            ->stringContains('{n:{e:{s:{t:"X"}}}}')
            ->stringContains('["la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", "la", ...(more 1 length)');

        // limit (specify)
        $traces = (stacktrace)([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    'abc',
                    ['a', 'b', 'c'],
                ],
            ],
        ], 2);
        that($traces)->is('hoge:1 func("ab...(more 1 length)", ["a", "b", ...(more 1 length)])');

        // format
        $traces = (stacktrace)([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
            ],
        ], '%s');
        that($traces)->is('hoge');

        // args
        $traces = (stacktrace)([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    'abc',
                    ['a', 'b', 'c'],
                ],
            ],
        ], ['args' => false]);
        that($traces)->is('hoge:1 func()');

        // delimiter
        $traces = (stacktrace)([
            [
                'file'     => 'hoge',
                'line'     => 1,
                'function' => 'func',
                'args'     => [
                    'abc',
                    ['a', 'b', 'c'],
                ],
            ],
        ], ['delimiter' => null]);
        that($traces)->is(['hoge:1 func("abc", ["a", "b", "c"])']);

        /** @noinspection PhpUnusedParameterInspection */
        function test_stacktrace_mask($password, $array, $config)
        {
            return (stacktrace)();
        }

        $class = new class() {
            static function sm($password, $array, $config)
            {
                return test_stacktrace_mask($password, $array, $config);
            }

            function im($password, $array, $config)
            {
                return self::sm($password, $array, $config);
            }
        };

        // mask
        $actual = $class->im('XXX', ['secret' => 'XXX'], (object) ['credit' => 'XXX']);
        // XXX は塗りつぶされるので決して出現しない
        that($actual)->stringNotContains('XXX');
        // im, sm, test_stacktrace_mask の3回呼び出してるので計9個塗りつぶされる
        that(substr_count($actual, '***'))->is(9);
    }

    function test_backtrace()
    {
        $mock = new class() {
            function m1($options) { return (backtrace)(0, $options); }

            function m2($options) { return $this->m1($options); }

            function m3($options) { return $this->m2($options); }
        };

        $traces = $mock->m3([
            'function' => 'm2',
        ]);
        that($traces[0])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm2',
            'class'    => get_class($mock),
        ]);
        that($traces[1])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm3',
            'class'    => get_class($mock),
        ]);

        $traces = $mock->m3([
            'class' => fn($v) => (str_exists)($v, 'class@anonymous'),
        ]);
        that($traces[0])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm1',
            'class'    => get_class($mock),
        ]);
        that($traces[1])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm2',
            'class'    => get_class($mock),
        ]);
        that($traces[2])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm3',
            'class'    => get_class($mock),
        ]);

        $traces = $mock->m3([
            'class' => 'not found',
        ]);
        that($traces)->count(0);

        $traces = $mock->m3([
            'hoge' => 'not found',
        ]);
        that($traces)->count(0);

        $traces = $mock->m3([
            'file'   => __FILE__,
            'offset' => 1,
            'limit'  => 3,
        ]);
        that($traces)->count(3);
        that($traces[0])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm1',
            'class'    => get_class($mock),
        ]);
        that($traces[1])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm2',
            'class'    => get_class($mock),
        ]);
        that($traces[2])->subsetEquals([
            'file'     => __FILE__,
            'function' => 'm3',
            'class'    => get_class($mock),
        ]);
    }

    function test_profiler()
    {
        $profiler = (profiler)([
            'callee'   => fn($callee) => $callee !== 'X',
            'location' => '#profile#',
        ]);
        require_once __DIR__ . '/Utility/profile.php';
        $result = iterator_to_array($profiler);
        that($result)->is($profiler());
        that($result['A'])->count(3);
        that($result['B'])->count(2);
        that($result['C'])->count(1);
        that($result)->notHasKey('X');

        $result = require_once __DIR__ . '/Utility/fake.php';
        that($result['scandir'])->is(array_merge(scandir(__DIR__ . '/Utility'), scandir(__DIR__ . '/Utility'), scandir(__DIR__ . '/Utility')));
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
        that($result['misc'])->is([
            'flock'       => 4,
            'file_exists' => true,
            'stat'        => stat(__DIR__ . '/Utility/fake.php'),
            'lstat'       => lstat(__DIR__ . '/Utility/fake.php'),
        ]);

        $fp = fopen(__DIR__ . '/Utility/fake.php', 'r');
        $fstat = fstat($fp);
        fclose($fp);
        that($fstat[7])->is(filesize(__DIR__ . '/Utility/fake.php'));
        that($fstat['size'])->is(filesize(__DIR__ . '/Utility/fake.php'));

        @file_get_contents(__DIR__ . '/Utility/notfound.php');
        that(error_get_last()['message'])->contains('failed to open stream', false);

        $backup = set_include_path(__DIR__);
        that(file_get_contents(basename(__FILE__), true))->equalsFile(__FILE__);
        set_include_path($backup);

        unset($profiler);
        unset($result);

        gc_collect_cycles();
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
        that($contents)->stringContains('PHP Log:  message2');
        that($contents)->stringContains(__FILE__);

        $t = (tmpname)();
        (error)('message3', $t);
        $contents = file_get_contents($t);
        that($contents)->stringContains('PHP Log:  message3');
        that($contents)->stringContains(__FILE__);

        $persistences = (reflect_callable)((error))->getStaticVariables()['persistences'];
        that($persistences)->count(1)
            ->arrayHasKey($t)
        [$t]->isResource();

        that(error)('int', 1)->wasThrown('must be resource or string');
    }

    function test_add_error_handler()
    {
        $handler1 = function ($errno) use (&$receiver) {
            if ($errno === E_WARNING || $errno === E_USER_WARNING) {
                return false;
            }
            $receiver = 'handler1';
        };
        $handler2 = function ($errno) use (&$receiver) {
            if (!(error_reporting() & $errno)) {
                return false;
            }
            $receiver = 'handler2';
        };
        $phpunit = (add_error_handler)($handler1);
        $current = (add_error_handler)($handler2);

        // 返り値は直前に設定していたもの
        that($phpunit)->isInstanceOf(\PHPUnit\Util\ErrorHandler::class);
        that($current)->is($handler1);

        // @ をつけなければ handler2 が呼ばれる（receiver = handler2）
        $receiver = null;
        trigger_error('', E_USER_NOTICE);
        that($receiver)->is('handler2');

        // @ をつけると handler1 に移譲される（receiver = handler1）
        $receiver = null;
        @trigger_error('', E_USER_NOTICE);
        that($receiver)->is('handler1');

        // さらに WARNING ならその前（phpunit のハンドラ）に移譲される（receiver が設定されない）
        $receiver = null;
        @trigger_error('', E_USER_WARNING);
        that($receiver)->is(null);

        restore_error_handler();
        restore_error_handler();
    }

    function test_timer()
    {
        $time = (timer)(function () {
            usleep(10 * 1000);
        }, 10);
        // 0.01 秒を 10 回回すので 0.1 秒は超えるはず
        that($time)->greaterThan(0.1);

        that(timer)(function () { }, 0)->wasThrown('must be greater than');
    }

    function test_benchmark()
    {
        that(benchmark)->fn([
            [new \Concrete('hoge'), 'getName'],
            fn() => 'hoge',
        ], [], 100)
            ->outputMatches('#Concrete::getName#')
            ->outputContains(__FILE__)
            // 2関数を100でベンチするので 200ms～400ms の間のはず（カバレッジが有効だとすごく遅いので余裕を持たしてる）
            ->final('time')->break()->isBetween(0.2, 0.4);

        // return 検証
        @(benchmark)(['md5', 'sha1'], ['hoge'], 10, false);
        that(error_get_last()['message'])->stringContains('Results of md5 & sha1 are different');

        // 1000 ミリ秒間の usleep(50000) の呼び出し回数は 20 回のはず（Windows での分解能がめちゃくちゃ？なので余裕を持たしてる）
        $output = (benchmark)(['usleep'], [50 * 1000], 1000, false);
        that($output[0]['called'])->break()->isBetween(17, 20);

        // 参照渡しも呼べる
        (benchmark)(['reset', 'end'], [['hoge']], 10, false);
        // エラーが出なければいいので assert はナシ

        // 例外系
        that(benchmark)(['notfunc'])->wasThrown('caller is not callable');
        that(benchmark)([])->wasThrown('benchset is empty');
        that(benchmark)([
            [new \Concrete('hoge'), 'getName'],
            [new \Concrete('hoge'), 'getName'],
        ])->wasThrown('duplicated benchname');
    }
}
