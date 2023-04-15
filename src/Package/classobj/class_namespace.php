<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * クラスの名前空間部分を取得する
 *
 * Example:
 * ```php
 * that(class_namespace('vendor\\namespace\\ClassName'))->isSame('vendor\\namespace');
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param string|object $class 対象クラス・オブジェクト
 * @return string クラスの名前空間
 */
function class_namespace($class)
{
    if (is_object($class)) {
        $class = get_class($class);
    }

    $parts = explode('\\', $class);
    array_pop($parts);
    return ltrim(implode('\\', $parts), '\\');
}
