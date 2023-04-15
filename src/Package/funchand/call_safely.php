<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * エラーを例外に変換するブロックでコールバックを実行する
 *
 * Example:
 * ```php
 * try {
 *     call_safely(fn() => []['dummy']);
 * }
 * catch (\Exception $ex) {
 *     that($ex->getMessage())->containsAll(['Undefined', 'dummy']);
 * }
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param callable $callback 実行するコールバック
 * @param mixed ...$variadic $callback に渡される引数（可変引数）
 * @return mixed $callback の返り値
 */
function call_safely($callback, ...$variadic)
{
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            return false;
        }
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    });

    try {
        return $callback(...$variadic);
    }
    finally {
        restore_error_handler();
    }
}
