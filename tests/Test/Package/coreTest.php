<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\import_once;

class coreTest extends AbstractTestCase
{
    function test_import_once()
    {
        $file = self::$TMPDIR . '/rf-import_once.php';
        file_put_contents($file, '<?php usleep(10000); return microtime(true);');

        // require_once は2回目に true を返す
        $require_once1 = require_once($file);
        $require_once2 = require_once($file);
        that($require_once1)->isFloat();
        that($require_once2)->isTrue();
        that($require_once1)->isNotSame($require_once2);

        // require は2回読み込めるが毎回読み込む
        $require1 = require($file);
        $require2 = require($file);
        that($require1)->isFloat();
        that($require2)->isFloat();
        that($require1)->isNotSame($require2);

        // import_once は2回読み込めて同じ結果を返す
        $import_once1 = import_once($file);
        $import_once2 = import_once($file);
        that($import_once1)->isFloat();
        that($import_once2)->isFloat();
        that($import_once1)->isSame($import_once2);
    }
}
