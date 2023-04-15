<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_hasharray.php';
// @codeCoverageIgnoreEnd

/**
 * 引数の配列を生成する。
 *
 * 配列以外を渡すと配列化されて追加される。
 * 連想配列は未対応。あくまで普通の配列化のみ。
 * iterable や Traversable は考慮せずあくまで「配列」としてチェックする。
 *
 * Example:
 * ```php
 * that(arrayize(1, 2, 3))->isSame([1, 2, 3]);
 * that(arrayize([1], [2], [3]))->isSame([1, 2, 3]);
 * $object = new \stdClass();
 * that(arrayize($object, false, [1, 2, 3]))->isSame([$object, false, 1, 2, 3]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param mixed ...$variadic 生成する要素（可変引数）
 * @return array 引数を配列化したもの
 */
function arrayize(...$variadic)
{
    $result = [];
    foreach ($variadic as $arg) {
        if (!is_array($arg)) {
            $result[] = $arg;
        }
        elseif (!is_hasharray($arg)) {
            $result = array_merge($result, $arg);
        }
        else {
            $result += $arg;
        }
    }
    return $result;
}
