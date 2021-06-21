<?php

namespace ryunosuke\Test;

class ExampleTest extends \ryunosuke\Test\AbstractTestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_all()
    {
        if (getenv('TEST_TARGET') !== 'package') {
            return;
        }

        /** @noinspection PhpUndefinedNamespaceInspection */
        /** @noinspection PhpUndefinedClassInspection */
        $header = <<<EVAL
<?php
namespace Example;

require_once __DIR__ . '/../../include/global.php';
require_once __DIR__ . '/../../vendor/autoload.php';

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));

if (!function_exists('Example\\that')) {
    function that(\$value)
    {
        return (new \\ryunosuke\\PHPUnit\\Actual(\$value));
    }
}

EVAL;

        foreach (glob(__DIR__ . '/../../src/Package/*.php') as $file) {
            preg_match_all('#```php(.*?)```.*?function (.+?)\\(#us', file_get_contents($file), $matches, PREG_SET_ORDER);
            $contents = '';
            foreach ($matches as $match) {
                $content = trim(preg_replace('#^ {5}\* ?#um', '', $match[1]));
                $contents .= "// {$match[2]}\n(function () {\n{$content}\n})();\n\n";
            }

            $exfile = __DIR__ . '/../examples/' . basename($file);
            file_put_contents($exfile, "$header\n$contents");
            ob_start();
            include $exfile;
            ob_end_clean();
        }
    }
}
