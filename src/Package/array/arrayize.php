<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_hasharray.php';
// @codeCoverageIgnoreEnd

/**
 * 引数の配列を生成する。
 *
 * 配列以外を渡すと配列化されて追加される。
 * 配列を渡してもそのままだが、連番配列の場合はマージ、連想配列の場合は結合となる。
 * iterable や Traversable は考慮せずあくまで「配列」としてチェックする。
 *
 * Example:
 * ```php
 * // 値は配列化される
 * that(arrayize(1, 2, 3))->isSame([1, 2, 3]);
 * // 配列はそのまま
 * that(arrayize([1], [2], [3]))->isSame([1, 2, 3]);
 * // 連想配列、連番配列の挙動
 * that(arrayize([1, 2, 3], [4, 5, 6], ['a' => 'A1'], ['a' => 'A2']))->isSame([1, 2, 3, 4, 5, 6, 'a' => 'A1']);
 * // stdClass は foreach 可能だがあくまで配列としてチェックする
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
        elseif ($result && !is_hasharray($arg)) {
            $result = array_merge($result, $arg);
        }
        else {
            // array_merge に合わせるなら $result = $arg + $result で後方上書きの方がいいかも
            // 些細な変更だけど後方互換性が完全に壊れるのでいったん保留（可変引数なんてほとんど使ってないと思うけど…）
            $result += $arg; // for compatible
        }
    }
    return $result;
}
