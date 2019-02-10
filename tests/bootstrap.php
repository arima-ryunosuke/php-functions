<?php

namespace ryunosuke\Test;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/classes.php';

\ryunosuke\Functions\Cacher::initialize(new \ryunosuke\Functions\FileCache(__DIR__ . '/temporary'));
\ryunosuke\Functions\Cacher::clear();

$env = getenv('TEST_TARGET') ?: 'package';
putenv("TEST_TARGET=$env");
switch ($env) {
    case 'global':
        file_put_contents(__DIR__ . '/temporary/global.php', \ryunosuke\Functions\Transporter::exportNamespace(null));
        require_once(__DIR__ . '/temporary/global.php');
        assert(constant('arrayize') === 'arrayize');
        break;

    case 'namespace':
        file_put_contents(__DIR__ . '/temporary/namespace.php', \ryunosuke\Functions\Transporter::exportNamespace('ryunosuke\\Test\\Package'));
        require_once(__DIR__ . '/temporary/namespace.php');
        assert(constant('ryunosuke\\Test\\Package\\arrayize') === 'ryunosuke\\Test\\Package\\arrayize');
        break;

    case 'package':
        file_put_contents(__DIR__ . '/temporary/package.php', \ryunosuke\Functions\Transporter::exportNamespace(null, true));
        require_once(__DIR__ . '/temporary/package.php');
        assert(constant('arrayize') === ['ryunosuke\\Functions\\Package\\Arrays', 'arrayize']);
        break;
}
