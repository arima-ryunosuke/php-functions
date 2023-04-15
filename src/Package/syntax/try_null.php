<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 例外を握りつぶす try 構文
 *
 * 例外機構構文が冗長なことがまれによくあるはず。
 *
 * Example:
 * ```php
 * // 例外が飛ばない場合は平和極まりない
 * $try = function ($a, $b, $c) {return [$a, $b, $c];};
 * that(try_null($try, 1, 2, 3))->isSame([1, 2, 3]);
 * // 例外が飛ぶ場合は null が返ってくる
 * $try = function () {throw new \Exception('tried');};
 * that(try_null($try))->isSame(null);
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param callable $try try ブロッククロージャ
 * @param mixed ...$variadic $try に渡る引数
 * @return mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら null
 */
function try_null($try, ...$variadic)
{
    try {
        return $try(...$variadic);
    }
    catch (\Exception $tried_ex) {
        return null;
    }
}
