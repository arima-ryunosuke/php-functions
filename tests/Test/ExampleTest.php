<?php

namespace ryunosuke\Test;

class ExampleTest extends \ryunosuke\Test\AbstractTestCase
{
    /**
     * @runInSeparateProcess
     */
    function test_all()
    {
        if (getenv('TEST_TARGET') !== false && getenv('TEST_TARGET') !== 'package') {
            return;
        }

        defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
        defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));

        foreach (glob(__DIR__ . '/../../src/package/*.php') as $file) {
            preg_match_all('#<code>(.*?)</code>.*?function (.+?)\\(#us', file_get_contents($file), $matches, PREG_SET_ORDER);
            $contents = [];
            foreach ($matches as $match) {
                $contents[] = '//' . $match[2] . preg_replace('#^ \* ?#um', '', $match[1]);
            }

            $exfile = __DIR__ . '/../example-code/' . basename($file);
            file_put_contents($exfile, "<?php\n" . implode("\n", $contents));
            ob_start();
            include $exfile;
            ob_end_clean();
        };
    }
}
