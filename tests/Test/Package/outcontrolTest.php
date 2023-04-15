<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\ob_capture;
use function ryunosuke\Functions\Package\ob_include;

class outcontrolTest extends AbstractTestCase
{
    function test_ob_capture()
    {
        $current = ob_get_level();

        // コールバックの出力が返される
        that(ob_capture(function ($v) {
            echo $v;
        }, 'hoge'))->is('hoge');
        // ob レベルは変わらない
        that(ob_get_level())->is($current);

        // 処理中に飛んだ例外が飛ぶ
        that(self::resolveFunction('ob_capture'))(function ($v) {
            throw new \Exception('inob');
        },
            'hoge')->wasThrown('inob');
        // ob レベルは変わらない
        that(ob_get_level())->is($current);
    }

    function test_ob_include()
    {
        $actual = ob_include(__DIR__ . '/files/template/template.php', [
            'variable' => 'variable',
        ]);
        that($actual)->is("This is plain text.
This is variable.
This is VARIABLE.
");
    }
}
