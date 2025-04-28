<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * eval のプロキシ関数
 *
 * 一度ファイルに吐いてから require した方が opcache が効くので抜群に速い。
 * また、素の eval は ParseError が起こったときの表示がわかりにくすぎるので少し見やすくしてある。
 *
 * 関数化してる以上 eval におけるコンテキストの引き継ぎはできない。
 * ただし、引数で変数配列を渡せるようにしてあるので get_defined_vars を併用すれば基本的には同じ（$this はどうしようもない）。
 *
 * Example:
 * ```php
 * $a = 1;
 * $b = 2;
 * $phpcode = ';
 * $c = $a + $b;
 * return $c * 3;
 * ';
 * that(evaluate($phpcode, get_defined_vars()))->isSame(9);
 * ```
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string $phpcode 実行する php コード
 * @param array $contextvars コンテキスト変数配列
 * @return mixed eval の return 値
 */
function evaluate($phpcode, $contextvars = [])
{
    $cachefile = function_configure('storagedir') . '/' . rawurlencode(__FUNCTION__) . '-' . sha1($phpcode) . '.php';
    if (!file_exists($cachefile)) {
        file_put_contents($cachefile, "<?php $phpcode", LOCK_EX);
    }

    try {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return (static function () {
            extract(func_get_arg(1));
            return require func_get_arg(0);
        })($cachefile, $contextvars);
    }
    catch (\ParseError $ex) {
        $errline = $ex->getLine();
        $errline_1 = $errline - 1;
        $codes = preg_split('#\\R#u', $phpcode);
        $codes[$errline_1] = '>>> ' . $codes[$errline_1];

        $N = 5; // 前後の行数
        $message = $ex->getMessage();
        $message .= "\n" . implode("\n", array_slice($codes, max(0, $errline_1 - $N), $N * 2 + 1));
        $message .= "\n in " . realpath($cachefile) . " on line " . $errline . "\n";
        throw new \ParseError($message, $ex->getCode(), $ex);
    }
}
