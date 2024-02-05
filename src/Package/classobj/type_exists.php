<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 型が存在するか返す
 *
 * class/interface/trait/enum exists の合せ技。
 * trait/enum のように今後型的なものがさらに増えるかもしれないし、class_exists だけして interface/trait が抜けているコードを何度も見てきた。
 * それを一元管理するような関数となる。
 *
 * Example:
 * ```php
 * that(class_exists(\Throwable::class))->isFalse();     // class_exists は class にしか反応しない
 * that(interface_exists(\Exception::class))->isFalse(); // interface_exists は interface にしか反応しない
 * that(trait_exists(\Error::class))->isFalse();         // trait_exists は trait にしか反応しない
 * // type_exists であれば全てに反応する
 * that(type_exists(\Throwable::class))->isTrue();
 * that(type_exists(\Exception::class))->isTrue();
 * that(type_exists(\Error::class))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param string $typename 調べる型名
 * @param bool $autoload オートロードを行うか
 * @return bool 型が存在するなら true
 */
function type_exists($typename, $autoload = true)
{
    if (class_exists($typename, $autoload)) {
        return true;
    }
    if (interface_exists($typename, $autoload)) {
        return true;
    }
    if (trait_exists($typename, $autoload)) {
        return true;
    }
    // enum は class で実装されているので enum_exists は不要
    return false;
}
