<?php

namespace ryunosuke\Test;

class ExampleTest extends \ryunosuke\Test\AbstractTestCase
{
    /**
     * @runInSeparateProcess
     */
    function test_all()
    {
        if (getenv('TEST_TARGET') !== 'package') {
            return;
        }

        foreach (glob(__DIR__ . '/../../src/Package/*.php') as $file) {
            preg_match_all('#```php(.*?)```.*?function (.+?)\\(#us', file_get_contents($file), $matches, PREG_SET_ORDER);
            $contents = [];
            foreach ($matches as $match) {
                $contents[] = '// ' . $match[2];
                $contents[] = "(function () {" . rtrim(preg_replace('#^     \* ?#um', '', $match[1])) . "\n})();\n";
            }

            $exfile = __DIR__ . '/../examples/' . basename($file);
            file_put_contents($exfile, <<<EVAL
<?php
namespace Example;

@require_once __DIR__ . '/../../include/global.php';
@require_once __DIR__ . '/../../vendor/autoload.php';
@require_once __DIR__ . '/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));


EVAL
                . implode("\n", $contents));
            ob_start();
            include $exfile;
            ob_end_clean();
        };
    }
}
