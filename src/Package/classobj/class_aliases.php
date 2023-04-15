<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 遅延ロードする class_alias
 *
 * class_alias は即座にオートロードされるが、この関数は必要とされるまでオートロードしない。
 *
 * Example:
 * ```php
 * class_aliases([
 *     'TestCase' => \PHPUnit\Framework\TestCase::class,
 * ]);
 * that(class_exists('TestCase', false))->isFalse(); // オートロードを走らせなければまだ定義されていない
 * that(class_exists('TestCase', true))->isTrue();   // オートロードを走らせなければ定義されている
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param array $aliases
 * @return array エイリアス配列
 */
function class_aliases($aliases)
{
    static $alias_map = [];

    foreach ($aliases as $alias => $class) {
        $alias_map[trim($alias, '\\')] = $class;
    }

    static $registered = false;
    if (!$registered) {
        $registered = true;
        spl_autoload_register(function ($class) use (&$alias_map) {
            if (isset($alias_map[$class])) {
                class_alias($alias_map[$class], $class);
            }
        }, true, true);
    }

    return $alias_map;
}
