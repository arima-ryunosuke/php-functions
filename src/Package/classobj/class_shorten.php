<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * クラスの名前空間部分を除いた短い名前を取得する
 *
 * Example:
 * ```php
 * that(class_shorten('vendor\\namespace\\ClassName'))->isSame('ClassName');
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param string|object $class 対象クラス・オブジェクト
 * @return string クラスの短い名前
 */
function class_shorten($class)
{
    if (is_object($class)) {
        $class = get_class($class);
    }

    $parts = explode('\\', $class);
    return array_pop($parts);
}
