<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../syntax/try_catch_finally.php';
// @codeCoverageIgnoreEnd

/**
 * try ～ catch 構文の関数版
 *
 * 例外機構構文が冗長なことがまれによくあるはず。
 *
 * Example:
 * ```php
 * // 例外が飛ばない場合は平和極まりない
 * $try = function ($a, $b, $c) {return [$a, $b, $c];};
 * that(try_catch($try, null, 1, 2, 3))->isSame([1, 2, 3]);
 * // 例外が飛ぶ場合は特殊なことをしなければ例外オブジェクトが返ってくる
 * $try = function () {throw new \Exception('tried');};
 * that(try_catch($try)->getMessage())->isSame('tried');
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param callable $try try ブロッククロージャ
 * @param ?callable $catch catch ブロッククロージャ
 * @param mixed ...$variadic $try に渡る引数
 * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
 */
function try_catch($try, $catch = null, ...$variadic)
{
    return try_catch_finally($try, $catch, null, ...$variadic);
}
