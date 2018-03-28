<?php

namespace ryunosuke\Test;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
require __DIR__ . '/classes.php';

\ryunosuke\Functions\Cacher::initialize(new \ryunosuke\Functions\FileCache(__DIR__ . '/temporary'));
\ryunosuke\Functions\Cacher::clear();

\ryunosuke\Functions\Transporter::exportAll();

function require_nons($file)
{
    $constants = file_exists($file) ? file_get_contents($file) : $file;
    $constants = preg_replace('#^namespace .*$#um', '', $constants, 1);
    eval('?>' . $constants);
}

switch (getenv('TEST_TARGET')) {
    default:
    case 'package':
        require_nons(__DIR__ . '/../include/constant.php');
        assert(arrayize === ['ryunosuke\\Functions\\Package\\Arrays', 'arrayize']);
        break;

    case 'global':
        require_nons(__DIR__ . '/../include/global/constant.php');
        require(__DIR__ . '/../include/global/function.php');
        assert(arrayize === 'arrayize');
        break;

    case 'namespace':
        require_nons(__DIR__ . '/../include/namespace/constant.php');
        require(__DIR__ . '/../include/namespace/function.php');
        assert(arrayize === 'ryunosuke\\Functions\\arrayize');
        break;

    case 'extern':
        $incdir = __DIR__;
        $files = \ryunosuke\Functions\Transporter::exportFunction('ryunosuke\\Klass', true, "$incdir/klass");
        require_nons($files['constant']);
        assert(arrayize === ['ryunosuke\\Klass\\Arrays', 'arrayize']);
        break;
}
