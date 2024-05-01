<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * エラーを ErrorException に変換するハンドラを設定する
 *
 * かなり局所的だが、使用するケースは結構ある。
 * 戻り値として callable を返すので、それを呼べば restore される。
 * あるいは参照が切れれば RAII で restore される。
 *
 * Example:
 * ```php
 * // 呼ぶとエラーが例外に変換されるようになる
 * $restore = set_error_exception_handler();
 * try {
 *     $array = [];
 *     $dummy = $array['undefined'];
 * }
 * catch (\Throwable $t) {
 *     // undefined 例外が飛ぶ
 *     that($t)->isInstanceof(\ErrorException::class);
 * }
 * finally {
 *     // こうするとハンドラが戻る
 *     $restore();
 * }
 * ```
 *
 * @package ryunosuke\Functions\Package\errorfunc
 *
 * @param int $error_levels エラーレベル
 * @param bool $handle_atmark_error エラー抑制時もハンドリングするか
 * @return callable restore するコールバック
 */
function set_error_exception_handler($error_levels = \E_ALL, $handle_atmark_error = false)
{
    set_error_handler(static function ($errno, $errstr, $errfile, $errline) use ($handle_atmark_error) {
        if (!$handle_atmark_error && !(error_reporting() & $errno)) {
            return false;
        }
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }, $error_levels);

    return new class() {
        private $restored = false;

        public function __destruct() { $this->__invoke(); }

        public function __invoke()
        {
            if (!$this->restored) {
                $this->restored = true;
                restore_error_handler();
            }
        }
    };
}
