<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * コールバックを Generator に変換する
 *
 * Example:
 * ``php
 * // - iterable を回して $v,$k でコールバックする
 * // - その返り値が true ならループを打ち切る
 * // - 最終的に合計値を返す
 * // というコールバックな関数
 * $callbackable_function = function ($iterable, $callback) {
 *     $sum = 0;
 *     foreach ($iterable as $k => $v) {
 *         if ($callback($v, $k) === true) {
 *             break;
 *         }
 *         $sum += $v;
 *     }
 *     return $sum;
 * };
 *
 * // 上記を generator 化したもの
 * $generator = generatify(fn($c) => $callbackable_function(range(1, 9), $c));
 * that($generator)->isInstanceOf(\Generator::class);
 * that(iterator_to_array($generator))->isSame([
 *     [1, 0],
 *     [2, 1],
 *     [3, 2],
 *     [4, 3],
 *     [5, 4],
 *     [6, 5],
 *     [7, 6],
 *     [8, 7],
 *     [9, 8],
 * ]);
 * that($generator)->getReturn()->isSame(45);
 *
 * // 中の foreach を打ち切れる
 * $generator = generatify(fn($c) => $callbackable_function(range(1, 9), $c));
 * foreach ($generator as [$v, $k]) {
 *     if ($k === 5) {
 *         generator_end($generator, true);
 *         break;
 *     }
 * }
 * that($generator)->getReturn()->isSame(15);
 * ```
 *
 * @codeCoverageIgnore php < 8.1
 * @package ryunosuke\Functions\Package\iterator
 */
function generatify(
    /** 対象 callable */ callable $callable,
) {
    $fiber = new \Fiber(fn() => $callable(fn(...$args) => \Fiber::suspend($args)));

    for ($args = $fiber->start(); !$fiber->isTerminated(); $args = $fiber->resume($result)) {
        $result = yield $args;
    }
    return $fiber->getReturn();
}
