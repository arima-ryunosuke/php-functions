<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * instanceof 構文の関数版
 *
 * ただし、bool ではなく ?object を返す。
 * つまり「instanceof が true ならそのまま、false なら null」を返す。
 * これは ?-> との親和性を考慮している。
 *
 * Example:
 * ```php
 *  // 実質的に下記は同じ
 * $object = new \Exception('message');
 * that(($object instanceof \Exception ? $object : null)?->getMessage())->is('message');
 * that(instance_of($object, \Exception::class)?->getMessage())->is('message');
 *
 * $object = new \stdClass();
 * that(($object instanceof \Exception ? $object : null)?->getMessage())->isNull();
 * that(instance_of($object, \Exception::class)?->getMessage())->isNull();
 * // Exception ではないが null でもないので下記のようにはできない
 * // $object?->getMessage();
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @template T of object
 * @param T $object 調べるオブジェクト
 * @param string|object $class クラス名
 * @return ?T $object が $class のインスタンスなら $object, そうでなければ null
 */
function instance_of($object, $class)
{
    return $object instanceof $class ? $object : null;
}
