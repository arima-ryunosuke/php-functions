<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\opcache_gc;
use function ryunosuke\Functions\Package\opcache_info;
use function ryunosuke\Functions\Package\opcache_reload;
use function ryunosuke\Functions\Package\path_normalize;
use function ryunosuke\Functions\Package\rm_rf;

class opcacheTest extends AbstractTestCase
{
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        opcache_reset();
    }

    function test_opcache_gc()
    {
        $file_update_protection = ini_set('opcache.file_update_protection', 0);

        $workingdir = self::$TMPDIR . '/rf-opcache_gc';
        rm_rf($workingdir);
        @mkdir($workingdir, 0777, true);

        $file1 = path_normalize($workingdir . '/file1.php');
        $file2 = path_normalize($workingdir . '/file2.php');
        $file3 = path_normalize($workingdir . '/file3.php');
        $file4 = path_normalize($workingdir . '/file4.php');
        $file5 = path_normalize($workingdir . '/file5.php');

        file_put_contents($file1, '<?php return [1];');
        file_put_contents($file2, '<?php return [2];');
        file_put_contents($file3, '<?php return [3];');
        file_put_contents($file4, '<?php return [4];');
        file_put_contents($file5, '<?php return [5];');

        include($file1);
        include($file2);
        include($file2); // hits:1
        include($file3);
        include($file4);
        include($file5);

        $actual = opcache_gc(
            deletedFile     : false,
            excludeCondition: fn($script) => str_contains($script['full_path'], 'file5'),
        );
        that($actual)->notHasKey($file1);
        that($actual)->notHasKey($file2);
        that($actual)->notHasKey($file3);
        that($actual)->notHasKey($file4);
        that($actual)->hasKey($file5);    // excludeCondition により消える

        unlink($file3);
        unlink($file4);
        $actual = opcache_gc(
            deletedFile     : true,
            includeCondition: fn($script) => str_contains($script['full_path'], 'file3'),
        );
        that($actual)->notHasKey($file1);
        that($actual)->notHasKey($file2);
        that($actual)->notHasKey($file3); // includeCondition により消える
        that($actual)->hasKey($file4);    // deletedFile により消える

        $actual = opcache_gc(
            thresholdLifetime: 0,
            deletedFile      : true,
        );
        that($actual)->hasKey($file1);    // thresholdLifetime により消える
        that($actual)->notHasKey($file2); // hits:1 により残る
        that($actual)->hasKey($file3);    // thresholdLifetime により消える

        ini_set('opcache.file_update_protection', $file_update_protection);
    }

    function test_opcache_info()
    {
        // カバレッジのみ（エラーさえ出なければそれでいい）
        ob_start();
        opcache_info();
        $html = ob_get_clean();

        that($html)->contains('jit');
        that($html)->contains('Scripts');
    }

    function test_opcache_reload()
    {
        $file_update_protection = ini_set('opcache.file_update_protection', 0);

        $workingdir = self::$TMPDIR . '/rf-opcache_reload';
        rm_rf($workingdir);
        @mkdir($workingdir, 0777, true);

        $cachefile = "$workingdir/cachefile.json";
        $file1 = path_normalize($workingdir . '/file1.php');
        $file2 = path_normalize($workingdir . '/file2.php');
        $file3 = path_normalize($workingdir . '/file3.php');
        $file4 = path_normalize($workingdir . '/file4.hoge');

        file_put_contents($file1, '<?php return [1];');
        file_put_contents($file2, '<?php return [2];');
        file_put_contents($file3, '<?php invalid php');
        file_put_contents($file4, '<?php return [4];');

        // opcache を作っておく
        include($file1);
        include($file1);

        // file1 が書き込まれているはず
        opcache_reload(cachefile: $cachefile);
        that($cachefile)->fileContains('file1.php');

        // file1 は delete, file2,file3 は opcache に乗っていたとみなす
        unlink($file1);
        $cache = json_decode(file_get_contents($cachefile), true);
        $cache[$file2] = ['timestamp' => time()];
        $cache[$file3] = ['timestamp' => time()];
        $cache[$file4] = ['timestamp' => time()];
        file_put_contents($cachefile, json_encode($cache));

        // file1 は invalidate, file2 は compile される。file3,4 は読んで字のごとし
        that(opcache_reload(['*.php'], reset: true, cachefile: $cachefile))->subsetEquals([
            $file1 => 'invalidate',
            $file2 => 'compile',
            $file3 => 'error: syntax error, unexpected identifier "php"',
            $file4 => 'ignore',
        ]);
        that($cachefile)->fileNotContains('file1.php');
        that($cachefile)->fileContains('file2.php');
        that($cachefile)->fileNotContains('file3.php');
        that($cachefile)->fileContains('file4.hoge'); // 読み込まれないだけで別に消えたりはしない

        ini_set('opcache.file_update_protection', $file_update_protection);
    }
}
