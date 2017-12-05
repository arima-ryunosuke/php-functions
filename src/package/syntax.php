<?php
/**
 * 構文に関するユーティリティ
 *
 * @package syntax
 */

/**
 * 引数をそのまま返す
 *
 * clone などでそのまま返す関数が欲しいことがまれによくあるはず。
 *
 * Example:
 * ```php
 * $object = new \stdClass();
 * assert(returns($object) === $object);
 * ```
 *
 * @param mixed $v return する値
 * @return mixed $v を返す
 */
function returns($v)
{
    return $v;
}

/**
 * オブジェクトならそれを、オブジェクトでないなら NullObject を返す
 *
 * null を返すかもしれないステートメントを一時変数を介さずワンステートメントで呼ぶことが可能になる。
 * 基本的には null を返すが、return type が規約されている場合は null 以外を返すこともある。
 *
 * 取得系呼び出しを想定しているので、設定系呼び出しは行うべきではない。
 * __set のような明らかに設定が意図されているものは例外が飛ぶ。
 *
 * Example:
 * ```php
 * // null を返すかもしれないステートメント
 * $getobject = function () {return null;};
 * // メソッド呼び出しは null を返す
 * assert(optional($getobject())->method()          === null);
 * // プロパティアクセスは null を返す
 * assert(optional($getobject())->property          === null);
 * // empty は true を返す
 * assert(empty(optional($getobject())->nothing)    === true);
 * // __isset は false を返す
 * assert(isset(optional($getobject())->nothing)    === false);
 * // __toString は '' を返す
 * assert(strval(optional($getobject()))            === '');
 * // __invoke は null を返す
 * assert(call_user_func(optional($getobject()))    === null);
 * // 配列アクセスは null を返す
 * assert($getobject()['hoge']                      === null);
 * // 空イテレータを返す
 * assert(iterator_to_array(optional($getobject())) === []);
 * ```
 *
 * @param object|null $object オブジェクト
 * @return mixed $object がオブジェクトならそのまま返し、違うなら NullObject を返す
 */
function optional($object)
{
    if (is_object($object)) {
        return $object;
    }

    static $nullobject = null;
    return $nullobject = $nullobject ?: new \ryunosuke\Functions\NullObject();
}

/**
 * throw の関数版
 *
 * hoge() or throw などしたいことがまれによくあるはず。
 *
 * Example:
 * ```php
 * try {
 *     throws(new \Exception('throws'));
 * }
 * catch (\Exception $ex) {
 *     assert($ex->getMessage() === 'throws');
 * }
 * ```
 *
 * @param \Exception $ex 投げる例外
 */
function throws($ex)
{
    throw $ex;
}

/**
 * try ～ catch 構文の関数版
 *
 * 例外機構構文が冗長なことがまれによくあるはず。
 *
 * Example:
 * ```php
 * $ex = new \Exception('try_catch');
 * assert(try_catch(function() use ($ex) { throw $ex; }) === $ex);
 * ```
 *
 * @param callable $try try ブロッククロージャ
 * @param callable $catch catch ブロッククロージャ
 * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
 */
function try_catch($try, $catch = null)
{
    return try_catch_finally($try, $catch, null);
}

/**
 * try ～ catch ～ finally 構文の関数版
 *
 * php < 5.5 にはないし、例外機構構文が冗長なことがまれによくあるはず。
 *
 * Example:
 * ```php
 * $ex = new \Exception('try_catch');
 * assert(try_catch(function() use ($ex) { throw $ex; }) === $ex);
 * ```
 *
 * @param callable $try try ブロッククロージャ
 * @param callable $catch catch ブロッククロージャ
 * @param callable $finally finally ブロッククロージャ
 * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
 */
function try_catch_finally($try, $catch = null, $finally = null)
{
    if ($catch === null) {
        $catch = function ($v) { return $v; };
    }

    try {
        $return = $try();
    }
    catch (\Exception $tried_ex) {
        try {
            $return = $catch($tried_ex);
        }
        catch (\Exception $catched_ex) {
            if ($finally !== null) {
                $finally();
            }
            throw $catched_ex;
        }
    }
    if ($finally !== null) {
        $finally();
    }
    return $return;
}
