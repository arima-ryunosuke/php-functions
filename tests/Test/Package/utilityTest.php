<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\array_flatten;
use function ryunosuke\Functions\Package\array_maps;
use function ryunosuke\Functions\Package\benchmark;
use function ryunosuke\Functions\Package\cache;
use function ryunosuke\Functions\Package\cache_fetch;
use function ryunosuke\Functions\Package\cachedir;
use function ryunosuke\Functions\Package\cacheobject;
use function ryunosuke\Functions\Package\function_configure;
use function ryunosuke\Functions\Package\number_serial;
use function ryunosuke\Functions\Package\rm_rf;
use function ryunosuke\Functions\Package\timer;

class utilityTest extends AbstractTestCase
{
    function test_benchmark()
    {
        that(self::resolveFunction('benchmark'))->fn([
            [new \Concrete('hoge'), 'getName'],
            fn() => 'hoge',
        ], [], 100)
            ->outputMatches('#Concrete::getName#')
            ->outputContains(__FILE__)
            // 2関数を100でベンチするので 200ms～400ms の間のはず（カバレッジが有効だとすごく遅いので余裕を持たしてる）
            ->final('time')->break()->isBetween(0.2, 0.4);

        // return 検証
        @benchmark(['md5', 'sha1'], ['hoge'], 10, false);
        that(error_get_last()['message'])->stringContains('Results of md5 & sha1 are different');

        // 1000 ミリ秒間の usleep(50000) の呼び出し回数は 20 回のはず（Windows での分解能がめちゃくちゃ？なので余裕を持たしてる）
        $output = benchmark(['usleep'], [50 * 1000], 1000, false);
        that($output[0]['called'])->break()->isBetween(17, 20);

        // 参照渡しも呼べる
        benchmark(['reset', 'end'], [['hoge']], 10, false);
        // エラーが出なければいいので assert はナシ

        // 例外系
        that(self::resolveFunction('benchmark'))(['notfunc'])->wasThrown('caller is not callable');
        that(self::resolveFunction('benchmark'))([])->wasThrown('benchset is empty');
        that(self::resolveFunction('benchmark'))([
            [new \Concrete('hoge'), 'getName'],
            [new \Concrete('hoge'), 'getName'],
        ])->wasThrown('duplicated benchname');
    }

    function test_cache()
    {
        $provider = fn() => sha1(uniqid(mt_rand(), true));

        // 何度呼んでもキャッシュされるので一致する
        $current = cache('test', $provider, null);
        that(cache('test', $provider, null))->is($current);
        that(cache('test', $provider, null))->is($current);
        that(cache('test', $provider, null))->is($current);

        // 名前空間を変えれば異なる値が返る（ごく低確率でコケるが、無視していいレベル）
        that(cache('test', $provider, __FUNCTION__))->isNotEqual($current);

        // null を与えると削除される
        that(cache('test', null, __FUNCTION__))->isTrue();
        that(cache('test', fn() => 1, __FUNCTION__))->is(1);
    }

    function test_cache_fetch()
    {
        /** @var \Psr16CacheInterface $cache */
        $tmpdir = sys_get_temp_dir() . '/cache_fetch';
        rm_rf($tmpdir);
        $cache = cacheobject($tmpdir);

        $value = sha1(uniqid(mt_rand(), true));

        that($cache->get('sha1random'))->isNull();
        that(cache_fetch($cache, 'sha1random', fn() => $value, 1))->is($value);
        that($cache->get('sha1random'))->is($value);
        sleep(2);
        that($cache->get('sha1random'))->isNull();
    }

    function test_cache_object()
    {
        cache(null, null);
        $value = sha1(uniqid(mt_rand(), true));

        $tmpdir = self::$TMPDIR . '/cache_object';
        rm_rf($tmpdir);
        function_configure(['cachedir' => $tmpdir]);
        cache('key', fn() => $value, 'hoge');
        cache(null, 'dummy');
        that("$tmpdir/hoge.php-cache")->fileExists();
        that(cache('key', fn() => 'dummy', 'hoge'))->is($value);

        cache('key', fn() => $value, 'fuga');
        cache(null, null);
        that("$tmpdir/hoge.php-cache")->fileNotExists();
    }

    function test_cachedir()
    {
        $tmpdir = sys_get_temp_dir() . '/test';
        rm_rf($tmpdir);
        /** @noinspection PhpDeprecationInspection */
        {
            cachedir($tmpdir);
            that(cachedir())->is(realpath($tmpdir));
            that(cachedir(sys_get_temp_dir()))->is(realpath($tmpdir));
        }
    }

    function test_cacheobject()
    {
        /** @var \Psr16CacheInterface $cache */
        $tmpdir = sys_get_temp_dir() . '/cacheobject';
        rm_rf($tmpdir);
        $cache = cacheobject($tmpdir);

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
        $cache = cacheobject($tmpdir, 1);
        that("$tmpdir/dir/expired.php")->fileNotExists();
        that("$tmpdir/dir")->directoryNotExists();
        that($cache->has('expired'))->isFalse();

        that($cache->keys('fetch*'))->hasKeyAll(['fetch', 'fetchM']);

        touch("$tmpdir/dummy.php");
        $cache->clean();
        that("$tmpdir/dummy.php")->fileExists();
    }

    function test_function_configure()
    {
        that(function_configure('hoge'))->is(null);
        that(function_configure(['other' => 'hoge']))->is(['other' => null]);
        that(function_configure(['other' => 'fuga']))->is(['other' => 'hoge']);

        that(self::resolveFunction('function_configure'))(null)->wasThrown('unknown type(NULL)');
    }

    function test_number_serial()
    {
        $numbers = [1, 2, 3, 5, 7, 8, 9];
        that(number_serial($numbers, 1, '~'))->is(['1~3', 5, '7~9']);
        that(number_serial($numbers, 1, null))->is([[1, 3], [5, 5], [7, 9]]);
        that(number_serial($numbers, 1, fn($from, $to) => "$from~$to"))->is(['1~3', '5~5', '7~9']);
        that(number_serial($numbers, -1, null))->is([[9, 7], [5, 5], [3, 1]]);

        $numbers = [0.1, 0.2, 0.3, 0.5, 0.7, 0.8, 0.9];
        that(number_serial($numbers, 0.1, '~'))->is(['0.1~0.3', 0.5, '0.7~0.9']);
        that(number_serial($numbers, -0.1, '~'))->is(['0.9~0.7', 0.5, '0.3~0.1']);

        that(number_serial([]))->is([]);
        that(number_serial([0]))->is([[0, 0]]);
        that(number_serial([-1, 0, 1], 1, '~'))->is(['-1~1']);
        that(number_serial([-1, 0.0, 1], 1, '~'))->is(['-1~1']);
        that(number_serial([-0.1, 0.0, 0, 0.1], 0.1, '~'))->is(['-0.1~0', '0~0.1']);
        that(number_serial([-0.2, 0.0, 0.2], 0.1, '~'))->isSame([-0.2, 0.0, 0.2]);

        // null は要するに range で復元できる形式となる
        $array = [-9, -5, -4, -3, -1, 1, 3, 4, 5, 9];
        that(array_flatten(array_maps(number_serial($array), '...range')))->is($array);
    }

    function test_timer()
    {
        $time = timer(function () {
            usleep(10 * 1000);
        }, 10);
        // 0.01 秒を 10 回回すので 0.1 秒は超えるはず
        that($time)->greaterThan(0.1);

        that(self::resolveFunction('timer'))(function () { }, 0)->wasThrown('must be greater than');
    }
}
