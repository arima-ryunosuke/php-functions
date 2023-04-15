<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ob_start ～ ob_get_clean のブロックでコールバックを実行する
 *
 * Example:
 * ```php
 * // コールバック内のテキストが得られる
 * that(ob_capture(fn() => print(123)))->isSame('123');
 * // こういう事もできる
 * that(ob_capture(function () {
 * ?>
 * bare string1
 * bare string2
 * <?php
 * }))->isSame("bare string1\nbare string2\n");
 * ```
 *
 * @package ryunosuke\Functions\Package\outcontrol
 *
 * @param callable $callback 実行するコールバック
 * @param mixed ...$variadic $callback に渡される引数（可変引数）
 * @return string オフスリーンバッファの文字列
 */
function ob_capture($callback, ...$variadic)
{
    ob_start();
    try {
        $callback(...$variadic);
        return ob_get_contents();
    }
    finally {
        ob_end_clean();
    }
}
