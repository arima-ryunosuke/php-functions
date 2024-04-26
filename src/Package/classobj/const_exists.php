<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * クラス定数が存在するか調べる
 *
 * グローバル定数も調べられる。ので実質的には defined とほぼ同じで違いは下記。
 *
 * - defined は単一引数しか与えられないが、この関数は2つの引数も受け入れる
 * - defined は private const で即死するが、この関数はきちんと調べることができる
 * - ClassName::class は常に true を返す
 *
 * あくまで存在を調べるだけで実際にアクセスできるかは分からないので注意（`property_exists` と同じ）。
 *
 * Example:
 * ```php
 * // クラス定数が調べられる（1引数、2引数どちらでも良い）
 * that(const_exists('ArrayObject::STD_PROP_LIST'))->isTrue();
 * that(const_exists('ArrayObject', 'STD_PROP_LIST'))->isTrue();
 * that(const_exists('ArrayObject::UNDEFINED'))->isFalse();
 * that(const_exists('ArrayObject', 'UNDEFINED'))->isFalse();
 * // グローバル（名前空間）もいける
 * that(const_exists('PHP_VERSION'))->isTrue();
 * that(const_exists('UNDEFINED'))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param string|object $classname 調べるクラス
 * @param string $constname 調べるクラス定数
 * @return bool 定数が存在するなら true
 */
function const_exists($classname, $constname = '')
{
    $colonp = strpos($classname, '::');
    if ($colonp === false && strlen($constname) === 0) {
        return defined($classname);
    }
    if (strlen($constname) === 0) {
        $constname = substr($classname, $colonp + 2);
        $classname = substr($classname, 0, $colonp);
    }

    try {
        $refclass = new \ReflectionClass($classname);
        if (strcasecmp($constname, 'class') === 0) {
            return true;
        }
        return $refclass->hasConstant($constname);
    }
    catch (\Throwable) {
        return false;
    }
}
