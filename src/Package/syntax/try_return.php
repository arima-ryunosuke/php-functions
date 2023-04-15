<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 例外が飛んだら例外オブジェクトを返す
 *
 * 例外機構構文が冗長なことがまれによくあるはず。
 *
 * Example:
 * ```php
 * // 例外が飛ばない場合は平和極まりない
 * $try = function ($a, $b, $c) {return [$a, $b, $c];};
 * that(try_return($try, 1, 2, 3))->isSame([1, 2, 3]);
 * // 例外が飛ぶ場合は例外オブジェクトが返ってくる
 * $try = function () {throw new \Exception('tried');};
 * that(try_return($try))->IsInstanceOf(\Exception::class);
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param callable $try try ブロッククロージャ
 * @param mixed ...$variadic $try に渡る引数
 * @return mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら null
 */
function try_return($try, ...$variadic)
{
    try {
        return $try(...$variadic);
    }
    catch (\Exception $tried_ex) {
        return $tried_ex;
    }
}
