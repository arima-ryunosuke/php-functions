<?php

// sys_get_temp_dir が返すディレクトリを変更しておく
$tmpdir = __DIR__ . DIRECTORY_SEPARATOR . 'temporary' . DIRECTORY_SEPARATOR . 'tmp';
@mkdir($tmpdir, 0777, true);
if (DIRECTORY_SEPARATOR === '\\') {
    if (getenv('TMP') !== $tmpdir) {
        $entries = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tmpdir, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($entries as $entry) {
            ($entry->isDir() ? 'rmdir' : 'unlink')($entry->getRealPath());
        }
    }
    putenv("TMP=$tmpdir");
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/ryunosuke/phpunit-extension/inc/bootstrap.php';
require __DIR__ . '/classes.php';

require_once(__DIR__ . '/../src/Package/constants.php');
foreach (glob(__DIR__ . '/../src/Package/*/*.php') as $fn) {
    require_once($fn);
}

if (false) {
    define('TESTWEBSERVER', null);
    define('TESTPINGSERVER', null);
    define('DIFF', null);
}

if (DIRECTORY_SEPARATOR === '\\') {
    setlocale(LC_CTYPE, 'C');
}

\ryunosuke\PHPUnit\Actual::generateStub(__DIR__ . '/../src/Transporter.php', __DIR__ . '/.stub');

\ryunosuke\PHPUnit\Actual::$constraintVariations['isEqualTrimming'] = new class('') extends \ryunosuke\PHPUnit\Constraint\Composite {
    public function __construct($value, bool $ignoreCase = false)
    {
        parent::__construct(new \PHPUnit\Framework\Constraint\IsEqual($this->filter($value), 0.0, 10, $ignoreCase));
    }

    protected function filter($other)
    {
        return trim($other);
    }
};

file_put_contents(__DIR__ . '/annotation.php', "<?php
namespace ryunosuke\\PHPUnit;
" . \ryunosuke\PHPUnit\Actual::generateAnnotation() . "
trait Annotation{}
");

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

// ダミー関数
function nullsafe_int_func(int $x, int $y)
{
    return $x - $y;
}

function concat_abc_z(string $a, string $b, string $c, string ...$z)
{
    return $a . $b . $c . "(" . implode(',', $z) . ")";
}

function range1_9()
{
    yield from range(1, 9);
}

// ファイルシステム系テストで clearstatcache を呼ぶのを忘れて「？？？」となることが多かったのでいっその事 tick を利用して無効化する
register_tick_function(function () {
    clearstatcache();
});
