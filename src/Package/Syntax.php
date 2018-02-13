<?php

namespace ryunosuke\Functions\Package;

class Syntax
{
    /**
     * 引数をそのまま返す
     *
     * clone などでそのまま返す関数が欲しいことがまれによくあるはず。
     *
     * Example:
     * <code>
     * $object = new \stdClass();
     * assert(returns($object) === $object);
     * </code>
     *
     * @package Syntax
     *
     * @param mixed $v return する値
     * @return mixed $v を返す
     */
    public static function returns($v)
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
     * <code>
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
     *
     * // $expected を与えるとその型以外は NullObject を返す（\ArrayObject はオブジェクトだが stdClass ではない）
     * assert(optional(new \ArrayObject([1]), 'stdClass')->count() === null);
     * </code>
     *
     * @package Syntax
     *
     * @param object|null $object オブジェクト
     * @param string $expected 期待するクラス名。指定した場合は is_a される
     * @return mixed $object がオブジェクトならそのまま返し、違うなら NullObject を返す
     */
    public static function optional($object, $expected = null)
    {
        if (is_object($object)) {
            if ($expected === null || is_a($object, $expected)) {
                return $object;
            }
        }

        static $nullobject = null;
        if ($nullobject === null) {
            // @formatter:off
            $declare = <<<'NO'
            class NULLObject implements \ArrayAccess, \IteratorAggregate
            {
                public function __isset($name) { return false; }
                public function __get($name) { return null; }
                public function __set($name, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __unset($name) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __call($name, $arguments) { return null; }
                public function __invoke() { return null; }
                public function __toString() { return ''; }
                public function offsetExists($offset) { return false; }
                public function offsetGet($offset) { return null; }
                public function offsetSet($offset, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function offsetUnset($offset) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function getIterator() { return new \ArrayIterator([]); }
            }
            return new NULLObject();
NO;

            $nullobject = eval("$declare;");
            // @formatter:on
        }
        return $nullobject;
    }

    /**
     * throw の関数版
     *
     * hoge() or throw などしたいことがまれによくあるはず。
     *
     * Example:
     * <code>
     * try {
     *     throws(new \Exception('throws'));
     * }
     * catch (\Exception $ex) {
     *     assert($ex->getMessage() === 'throws');
     * }
     * </code>
     *
     * @package Syntax
     *
     * @param \Exception $ex 投げる例外
     */
    public static function throws($ex)
    {
        throw $ex;
    }

    /**
     * if ～ else 構文の関数版
     *
     * 一言で言えば `$actual === $expected ? $then : $else` という動作になる。
     * ただし、 $expected が callable の場合は呼び出した結果を緩い bool 判定する。
     * つまり `ifelse('hoge', 'is_string', true, false)` は常に true を返すので注意。
     *
     * ?? 演算子があれば大抵の状況で不要だが、=== null 限定ではなく 他の値で判定したい場合などには使える。
     *
     * Example:
     * <code>
     * // とても処理が遅い関数。これの返り値が「false ならばデフォルト値、でなければ自身値」という処理が下記のように書ける（一時変数が不要）
     * $heavyfunc = function($v){return $v;};
     * // $heavyfunc(1) ?? 'default' とほぼ同義
     * assert(ifelse($heavyfunc(1), false, 'default')     === $heavyfunc(1));
     * // $heavyfunc(null) ?? 'default' とほぼ同義…ではない。厳密な比較で false ではないので第1引数を返す
     * assert(ifelse($heavyfunc(null), false, 'default')  === $heavyfunc(null));
     * // $heavyfunc(false) ?? 'default' とほぼ同義…ではない。厳密な比較で false なので 'default' を返す
     * assert(ifelse($heavyfunc(false), false, 'default') === 'default');
     * </code>
     *
     * @package Syntax
     *
     * @param mixed $actual 調べる値（左辺値）
     * @param mixed $expected 比較する値（右辺値）
     * @param mixed $then 真の場合の値
     * @param mixed $else 偽の場合の値。省略時は $actual
     * @return mixed $then or $else
     */
    public static function ifelse($actual, $expected, $then, $else = null)
    {
        // $else 省略時は $actual を返す
        if (func_num_args() === 3) {
            $else = $actual;
        }

        if (is_callable($expected)) {
            return $expected($actual) ? $then : $else;
        }
        return $expected === $actual ? $then : $else;
    }

    /**
     * try ～ catch 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * <code>
     * $ex = new \Exception('try_catch');
     * assert(try_catch(function() use ($ex) { throw $ex; }) === $ex);
     * </code>
     *
     * @package Syntax
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    public static function try_catch($try, $catch = null)
    {
        return call_user_func(try_catch_finally, $try, $catch, null);
    }

    /**
     * try ～ catch ～ finally 構文の関数版
     *
     * php < 5.5 にはないし、例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * <code>
     * $ex = new \Exception('try_catch');
     * assert(try_catch(function() use ($ex) { throw $ex; }) === $ex);
     * </code>
     *
     * @package Syntax
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @param callable $finally finally ブロッククロージャ
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    public static function try_catch_finally($try, $catch = null, $finally = null)
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
}