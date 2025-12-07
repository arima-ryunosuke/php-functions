<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 一度しか読み込まない require
 *
 * require_once と同じだが require_once は2回目以降 true を返すので「そのファイルで生成した何か」を得るのにやや不向き。
 * js の import のようにファイル側で何かインスタンスを生成してそれを使いまわしたいことは多々ある。
 * （php の仕様上 js のようにクラス定義を返したりすることは不可能だが）。
 *
 * Example:
 * ```php
 * $file = sys_get_temp_dir() . '/rf-import_once.php';
 * file_put_contents($file, '<?php usleep(10000); return microtime(true);');
 *
 * // require_once は2回目に true を返す
 * $require_once1 = require_once($file);
 * $require_once2 = require_once($file);
 * that($require_once1)->isFloat();
 * that($require_once2)->isTrue();
 * that($require_once1)->isNotSame($require_once2);
 *
 * // require は2回読み込めるが毎回読み込む
 * $require1 = require($file);
 * $require2 = require($file);
 * that($require1)->isFloat();
 * that($require2)->isFloat();
 * that($require1)->isNotSame($require2);
 *
 * // import_once は2回読み込めて同じ結果を返す
 * $import_once1 = import_once($file);
 * $import_once2 = import_once($file);
 * that($import_once1)->isFloat();
 * that($import_once2)->isFloat();
 * that($import_once1)->isSame($import_once2);
 * ```
 *
 * @package ryunosuke\Functions\Package\core
 *
 * @param string $filename
 * @return mixed require の返り値
 */
function import_once(string $filename)
{
    static $imports = [];

    $filename = realpath($filename);
    return $imports[$filename] ??= require $filename;
}
