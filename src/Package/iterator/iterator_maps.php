<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * iterable にコールバック（複数）を適用した Iterator を返す
 *
 * 指定したコールバックで複数回回してマップする。
 * 引数は (値, キー, 連番) が渡ってくる。
 *
 * Example:
 * ```php
 * // Generator の値を2乗してから3を足す
 * $it = iterator_maps((function () {
 *     yield 1;
 *     yield 2;
 *     yield 3;
 * })(), fn($v) => $v ** 2, fn($v) => $v + 3);
 * that(iterator_to_array($it))->isSame([4, 7, 12]);
 * ```
 *
 * @package ryunosuke\Functions\Package\iterator
 *
 * @param iterable $iterable iterable
 * @param callable ...$callbacks コールバック
 * @return \Iterator コールバックを適用した iterable
 */
function iterator_maps($iterable, ...$callbacks)
{
    $n = 0;
    foreach ($iterable as $k => $v) {
        foreach ($callbacks as $callback) {
            $callback = func_user_func_array($callback);
            $v = $callback($v, $k, $n);
        }
        yield $k => $v;
        $n++;
    }
}
