<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\array_flatten;
use function ryunosuke\Functions\Package\array_maps;
use function ryunosuke\Functions\Package\benchmark;
use function ryunosuke\Functions\Package\built_in_server;
use function ryunosuke\Functions\Package\cache;
use function ryunosuke\Functions\Package\cache_fetch;
use function ryunosuke\Functions\Package\cacheobject;
use function ryunosuke\Functions\Package\function_configure;
use function ryunosuke\Functions\Package\number_serial;
use function ryunosuke\Functions\Package\rm_rf;

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
        that($output['usleep']['called'])->break()->isBetween(17, 20);

        // メモリ使用量（ticks なので直接 return しても得られない）
        $output = benchmark([
            'mem100' => static fn() => str_repeat('X', 1024 * 100),
            'mem200' => static fn() => str_repeat('X', 1024 * 200),
        ], [], 100, false);
        that($output['mem100']['memory'])->isBetween(100 * 1024, 120 * 1024);
        that($output['mem200']['memory'])->isBetween(200 * 1024, 220 * 1024);

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

    function test_built_in_server()
    {
        // https://bugs.php.net/bug.php?id=80931
        if (DIRECTORY_SEPARATOR === '/') {
            $this->markTestSkipped();
        }

        $docroot = __DIR__ . '/files/server';
        $server = built_in_server($docroot);
        that(file_get_contents('http://127.0.0.1:8000/hoge.txt'))->is(file_get_contents("$docroot/hoge.txt"));
        that(file_get_contents('http://127.0.0.1:8000/fuga.txt'))->is(file_get_contents("$docroot/fuga.txt"));
        $server->terminate();

        $routerscript = self::$TMPDIR . '/rf-built_in_server.php';
        file_put_contents($routerscript, '<?php
            echo "response";
        ');
        $server = built_in_server($docroot, $routerscript);
        that(file_get_contents('http://127.0.0.1:8000/undefined'))->is('response');
        $server->terminate();

        $server = built_in_server($docroot, static function () {
            switch ($_SERVER['REQUEST_URI']) {
                default:
                    return false;
                case '/hoge':
                    echo 'HOGE';
                    break;
                case '/fuga':
                    echo 'FUGA';
                    break;
            }
        }, [
            'port' => 8001,
        ]);
        that(file_get_contents('http://127.0.0.1:8001/hoge'))->is('HOGE');
        that(file_get_contents('http://127.0.0.1:8001/fuga'))->is('FUGA');
        that(file_get_contents('http://127.0.0.1:8001/hoge.txt'))->is(file_get_contents("$docroot/hoge.txt"));
        that(file_get_contents('http://127.0.0.1:8001/fuga.txt'))->is(file_get_contents("$docroot/fuga.txt"));
        $server->terminate();
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
        /** @var \Cacheobject $cache */
        $tmpdir = self::$TMPDIR . '/cache_fetch';
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

    function test_cacheobject()
    {
        /** @var \Cacheobject $cache */
        $tmpdir = self::$TMPDIR . '/cacheobject';
        rm_rf($tmpdir);
        $cache = cacheobject($tmpdir);

        /// same object
        $obj1 = that($cache)->var('cacheobject');
        $obj2 = that(cacheobject($tmpdir))->var('cacheobject');
        that($obj1)->isSame($obj2);

        /// var_export3

        $cache->set('closure', static fn() => null);
        that($cache->get('closure'))->isInstanceOf(\Closure::class);

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

        // provide
        srand(123);
        $provider = fn($min, $max) => rand($min, $max);
        that($cache->provide($provider, 100, 200))->isSame(128);
        that($cache->provide($provider, 100, 200))->isSame(128);
        that($cache->provide($provider, 100, 200))->isSame(128);
        that($cache->provide(fn($min, $max) => rand($min, $max), 100, 200))->isSame(172);
        that($cache->provide($provider, 200, 300))->isSame(291);
        that($cache->provide($provider, 200, 300))->isSame(291);
        that($cache->provide($provider, 200, 300))->isSame(291);
        that($cache->provide(fn($min, $max) => rand($min, $max), 200, 300))->isSame(229);
        that($cache->provide(fn() => null))->isSame(null);

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

        that($cache)->cacheobject->_getMetadata('notfound')->is(null);

        $debugString = print_r($cache, true);
        that($debugString)->contains($tmpdir);
        that($debugString)->contains('path.to.dir');

        // clean

        that($cache->set('dir.expired', 'value', 1))->isTrue();
        sleep(2);
        that("$tmpdir/dir/expired.php-cache")->fileExists();
        $cache = cacheobject($tmpdir, 1);
        that("$tmpdir/dir/expired.php-cache")->fileNotExists();
        that("$tmpdir/dir")->directoryNotExists();
        that($cache->has('expired'))->isFalse();

        that($cache->keys('fetch*'))->hasKeyAll(['fetch', 'fetchM']);

        touch("$tmpdir/dummy.php-cache");
        $cache->clean();
        that("$tmpdir/dummy.php-cache")->fileExists();
    }

    function test_function_configure()
    {
        that(function_configure('hoge'))->is(null);
        that(function_configure(['other' => 'hoge']))->is(['other' => null]);
        that(function_configure(['other' => 'fuga']))->is(['other' => 'hoge']);
        that(function_configure(null))->isArray();

        that(self::resolveFunction('function_configure'))(123)->wasThrown('unknown type(integer)');
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
}
