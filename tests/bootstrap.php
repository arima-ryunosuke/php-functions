<?php
namespace ryunosuke\Test;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/classes.php';

\ryunosuke\Functions\Cacher::initialize(new \ryunosuke\Functions\FileCache(__DIR__ . '/temporary'));
\ryunosuke\Functions\Cacher::clear();

switch (getenv('TEST_TARGET')) {
    default:
    case 'package':
        foreach (glob(__DIR__ . '/../src/package/*.php') as $filename) {
            require_once $filename;
        }
        foreach (get_defined_functions()["user"] as $function) {
            $ref = new \ReflectionFunction($function);
            if (dirname($ref->getFileName()) === realpath(__DIR__ . '/../src/package/')) {
                define($function, $function);
            }
        };
        break;

    case 'global':
        \ryunosuke\Functions\Loader::importAsGlobal();
        // 排他的な定義でないとテストにならない
        assert(function_exists('arrayize'));
        assert(!function_exists('ryunosuke\\Test\\arrayize'));
        break;

    case 'namespace':
        \ryunosuke\Functions\Loader::exportToNamespace(__DIR__ . '/namespace', 'ryunosuke\\Test\\package');
        \ryunosuke\Functions\Loader::importAsNamespace(__DIR__ . '/namespace');
        // 排他的な定義でないとテストにならない
        assert(!function_exists('arrayize'));
        assert(function_exists('ryunosuke\\Test\\package\\arrayize'));
        break;
}
