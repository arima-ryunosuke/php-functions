<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * try ～ catch ～ finally 構文の関数版
 *
 * 例外機構構文が冗長なことがまれによくあるはず。
 *
 * Example:
 * ```php
 * $finally_count = 0;
 * $finally = function () use (&$finally_count) {$finally_count++;};
 * // 例外が飛ぼうと飛ぶまいと $finally は実行される
 * $try = function ($a, $b, $c) {return [$a, $b, $c];};
 * that(try_catch_finally($try, null, $finally, 1, 2, 3))->isSame([1, 2, 3]);
 * that($finally_count)->isSame(1); // 呼ばれている
 * // 例外を投げるが、 $catch で握りつぶす
 * $try = function () {throw new \Exception('tried');};
 * that(try_catch_finally($try, null, $finally, 1, 2, 3)->getMessage())->isSame('tried');
 * that($finally_count)->isSame(2); // 呼ばれている
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param callable $try try ブロッククロージャ
 * @param ?callable $catch catch ブロッククロージャ
 * @param ?callable $finally finally ブロッククロージャ
 * @param mixed ...$variadic $try に渡る引数
 * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
 */
function try_catch_finally($try, $catch = null, $finally = null, ...$variadic)
{
    if ($catch === null) {
        $catch = fn($v) => $v;
    }

    try {
        return $try(...$variadic);
    }
    catch (\Exception $tried_ex) {
        try {
            return $catch($tried_ex);
        }
        catch (\Exception $catched_ex) {
            throw $catched_ex;
        }
    }
    finally {
        if ($finally !== null) {
            $finally();
        }
    }
}
