<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * あらゆるエラーをハンドルする
 *
 * 実質的には set_error_handler+set_exception_handler+register_shutdown_function してるだけ。
 * あと小細工して初動エラーも拾うがあまり気にしなくてよい。
 *
 * ハンドラの引数は Throwable 固定（エラーの場合は ErrorException に変換されてコールされる）。
 * ハンドラが true/null を返すと設定前（ない場合は標準）のハンドラがコールされる。
 * 実用上は「ログるかログらないか」くらいの差でしかない。
 *
 * @package ryunosuke\Functions\Package\errorfunc
 * @codeCoverageIgnore カバレッジ不可
 */
function set_all_error_handler(
    /** 実行されるクロージャ */ \Closure $handler,
    /** エラー抑制演算子をハンドリングするか */ bool $atmark_error = false,
    /** fatal 用に予約するサイズ */ int $reserved_byte = 0,
): /** キャンセルする callable */ callable
{
    // 初動エラーが error_get_last() で取得できることがある
    if (($error = error_get_last()) !== null) {
        // 初動エラーはスクリプト無関係なので line:0 で発生される
        if ($error['line'] === 0) {
            $handler(new \ErrorException($error['message'], -1, $error['type'], $error['file'], $error['line']));
            // 以後一度もエラーがないと shutdown で引っかかってしまう
            error_clear_last();
        }
    }

    return new class($handler, $atmark_error, $reserved_byte) {
        private static array  $instances         = [];
        private static string $reservedMemory    = '';
        private static bool   $regsteredShutdown = false;

        private $handler;
        private $error_handler;
        private $exception_handler;

        public function __construct(\Closure $handler, bool $atmark_error, int $reserved_byte)
        {
            self::$instances[spl_object_id($this)] = $this;
            if (strlen(self::$reservedMemory) < $reserved_byte) {
                self::$reservedMemory = str_repeat('x', $reserved_byte);
            }

            $this->handler = $handler;

            $this->error_handler = set_error_handler(function ($errno, $errstr, $errfile, $errline) use ($atmark_error) {
                if (!$atmark_error && !(error_reporting() & $errno)) {
                    return false;
                }

                $default = ($this->handler)(new \ErrorException($errstr, 0, $errno, $errfile, $errline)) ?? true;
                if ($default) {
                    return ($this->error_handler)($errno, $errstr, $errfile, $errline);
                }
            }) ?? fn() => false;

            $this->exception_handler = set_exception_handler(function (\Throwable $t) {
                $default = ($this->handler)($t) ?? true;
                if ($default) {
                    return ($this->exception_handler)($t);
                }
            }) ?? fn($t) => throw $t;

            if (!self::$regsteredShutdown) {
                self::$regsteredShutdown = true;
                register_shutdown_function(function () {
                    self::$reservedMemory = '';
                    // php は循環参照を片付けずに memory size エラーを飛ばすのでやっておく意味はある
                    gc_collect_cycles();
                    foreach (self::$instances as $instance) {
                        // 通常の実行時エラーは set_error_handler でハンドリングされているが
                        // - 実行時ではないコンパイル時エラー
                        // - エラーハンドラが呼ばれない実行時エラー（実行メモリ/時間など）
                        // が存在するので個別にハンドリングしないと呼ばれる機会が失われる
                        if (($error = error_get_last()) !== null) {
                            if (false
                                || in_array($error['type'], [E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_CORE_WARNING, E_COMPILE_WARNING], true)
                                || strpos($error['message'], 'Allowed memory size') === 0
                                || strpos($error['message'], 'Maximum execution time') === 0
                            ) {
                                ($instance->handler)(new \ErrorException($error['message'], 1, $error['type'], $error['file'], $error['line']));
                            }
                        }
                    }
                });
            }
        }

        public function __invoke()
        {
            restore_error_handler();
            restore_exception_handler();
            unset(self::$instances[spl_object_id($this)]);
        }
    };
}
