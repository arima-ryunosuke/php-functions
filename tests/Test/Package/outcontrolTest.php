<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\ob_capture;
use function ryunosuke\Functions\Package\ob_include;
use function ryunosuke\Functions\Package\ob_stdout;

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

    function test_ob_stdout()
    {
        $samplefile = tempnam(sys_get_temp_dir(), 'md');
        file_put_contents($samplefile, <<<MD
            Sample file
            =====
            
            ```
            <?php
            var_dump(123);
            var_export(123);
            ?>
            ```
            
            ```
            <?php
            if (true) {
                var_dump(range(0, 5));
                var_export(range(0, 5));
            }
            ?>
            ```
            MD
        );
        $actual = <<<RESULT
            Sample file
            =====
            
            ```
            <?php
            var_dump(123);
            /*= int(123) */
            var_export(123);
            /*= 123 */
            ?>
            ```
            
            ```
            <?php
            if (true) {
                var_dump(range(0, 5));
                /*= array(6) {
                  [0]=>
                  int(0)
                  [1]=>
                  int(1)
                  [2]=>
                  int(2)
                  [3]=>
                  int(3)
                  [4]=>
                  int(4)
                  [5]=>
                  int(5)
                } */
                var_export(range(0, 5));
                /*= array (
                  0 => 0,
                  1 => 1,
                  2 => 2,
                  3 => 3,
                  4 => 4,
                  5 => 5,
                ) */
            }
            ?>
            ```
            RESULT;

        $status = ob_stdout();
        include $samplefile;
        ob_end_clean();
        that(file_get_contents($samplefile))->is($actual);
        that((string) $status)->is(ob_capture(fn() => include $samplefile));

        // 何回呼んでも大丈夫
        $status = ob_stdout();
        include $samplefile;
        ob_end_clean();
        that(file_get_contents($samplefile))->is($actual);
        that((string) $status)->is(ob_capture(fn() => include $samplefile));
    }
}
