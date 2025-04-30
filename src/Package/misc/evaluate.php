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
 *  ただし、引数で変数配列を渡せるようにしてあるので get_defined_vars を併用すれば基本的には同じ。
 * コンテキストに $this がある場合は bind して疑似的に模倣する。
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
        $evaler = function () {
            // extract は数値キーをそのまま展開できない
            // しかし "${0}" のような記法で数値変数を利用することはできる（可変変数限定だし php8.2 で非推奨になったが）
            // 要するに数値キーのみをローカルコンテキストに展開しないと完全な eval の代替にならない
            if (func_get_arg(1)) {
                foreach (func_get_arg(1) as $k => $v) {
                    $$k = $v;
                }
                // 現スコープで宣言してしまっているので伏せなければならない
                unset($k, $v);
            }
            extract(func_get_arg(1));
            return require func_get_arg(0);
        };

        // $this を模倣する
        if (isset($contextvars['this'])) {
            assert(is_object($contextvars['this']));
            $evaler = $evaler->bindTo($contextvars['this'], get_class($contextvars['this']));
            unset($contextvars['this']);
        }

        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return $evaler($cachefile, $contextvars);
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
