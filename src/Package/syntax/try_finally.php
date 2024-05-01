<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../syntax/try_catch_finally.php';
// @codeCoverageIgnoreEnd

/**
 * try ～ finally 構文の関数版
 *
 * 例外は投げっぱなす。例外機構構文が冗長なことがまれによくあるはず。
 *
 * Example:
 * ```php
 * $finally_count = 0;
 * $finally = function () use (&$finally_count) {$finally_count++;};
 * // 例外が飛ぼうと飛ぶまいと $finally は実行される
 * $try = function ($a, $b, $c) {return [$a, $b, $c];};
 * that(try_finally($try, $finally, 1, 2, 3))->isSame([1, 2, 3]);
 * that($finally_count)->isSame(1); // 呼ばれている
 * // 例外は投げっぱなすが、 $finally は実行される
 * $try = function () {throw new \Exception('tried');};
 * try {try_finally($try, $finally, 1, 2, 3);} catch(\Exception $e){}
 * that($finally_count)->isSame(2); // 呼ばれている
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param callable $try try ブロッククロージャ
 * @param ?callable $finally finally ブロッククロージャ
 * @param mixed ...$variadic $try に渡る引数
 * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
 */
function try_finally($try, $finally = null, ...$variadic)
{
    return try_catch_finally($try, fn($arg) => throw $arg, $finally, ...$variadic);
}
