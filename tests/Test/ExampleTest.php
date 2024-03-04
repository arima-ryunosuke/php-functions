<?php

namespace ryunosuke\Test;

class ExampleTest extends \ryunosuke\Test\AbstractTestCase
{
    public function providePackage()
    {
        $packages = glob(__DIR__ . '/../../src/Package/*', GLOB_ONLYDIR);
        $names = array_map(fn($package) => basename($package), $packages);
        $datas = array_map(fn($package) => [$package], $packages);
        return array_combine($names, $datas);
    }


    /**
     * @dataProvider providePackage
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_all($package)
    {
        $header = <<<EVAL
<?php
namespace Example;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../include/global.php';

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));

function_configure([
    'chain.version' => 2,
]);

if (!function_exists('Example\\that')) {
    function that(\$value)
    {
        return (new \\ryunosuke\\PHPUnit\\Actual(\$value));
    }
}

EVAL;

        $contents = '';
        foreach (glob("$package/*.php") as $file) {
            if (preg_match('#```php(.*?)```#us', file_get_contents($file), $matches)) {
                $fn = basename($file);
                $content = trim(preg_replace('#^ \* ?#um', '', $matches[1]));
                $contents .= "// {$fn}\n(function () {\n{$content}\n})();\n\n";
            }
        }
        $exfile = __DIR__ . "/../examples/" . basename($package) . '.php';
        file_put_contents($exfile, "$header\n$contents");
        ob_start();
        include $exfile;
        ob_end_clean();
    }
}
