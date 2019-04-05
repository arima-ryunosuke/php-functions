<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/classes.php';

\ryunosuke\Functions\Cacher::initialize(new \ryunosuke\Functions\FileCache(__DIR__ . '/temporary'));
\ryunosuke\Functions\Cacher::clear();

// Windows 用にダミーで apache(48)/mysql(27) を固定で返す
if (!function_exists('posix_getuid')) {
    function posix_getuid() { return 48; }
}
if (!function_exists('posix_getgid')) {
    function posix_getgid() { return 48; }
}
if (!function_exists('posix_getpwnam')) {
    function posix_getpwnam() { return ['uid' => 27]; }
}
if (!function_exists('posix_getgrnam')) {
    function posix_getgrnam() { return ['gid' => 27]; }
}

// ファイルシステム系テストで clearstatcache を呼ぶのを忘れて「？？？」となることが多かったのでいっその事 tick を利用して無効化する
register_tick_function(function () {
    clearstatcache();
});

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
