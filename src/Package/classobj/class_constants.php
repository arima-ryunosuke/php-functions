<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * クラス定数を配列で返す
 *
 * `(new \ReflectionClass($class))->getConstants()` とほぼ同じだが、可視性でフィルタができる。
 * さらに「自分自身の定義か？」でもフィルタできる。
 *
 * Example:
 * ```php
 * $class = new class extends \ArrayObject
 * {
 *     private   const C_PRIVATE   = 'private';
 *     protected const C_PROTECTED = 'protected';
 *     public    const C_PUBLIC    = 'public';
 * };
 * // 普通に全定数を返す
 * that(class_constants($class))->isSame([
 *     'C_PRIVATE'      => 'private',
 *     'C_PROTECTED'    => 'protected',
 *     'C_PUBLIC'       => 'public',
 *     'STD_PROP_LIST'  => \ArrayObject::STD_PROP_LIST,
 *     'ARRAY_AS_PROPS' => \ArrayObject::ARRAY_AS_PROPS,
 * ]);
 * // public のみを返す
 * that(class_constants($class, IS_PUBLIC))->isSame([
 *     'C_PUBLIC'       => 'public',
 *     'STD_PROP_LIST'  => \ArrayObject::STD_PROP_LIST,
 *     'ARRAY_AS_PROPS' => \ArrayObject::ARRAY_AS_PROPS,
 * ]);
 * // 自身定義でかつ public のみを返す
 * that(class_constants($class, IS_OWNSELF | IS_PUBLIC))->isSame([
 *     'C_PUBLIC'       => 'public',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param string|object $class クラス名 or オブジェクト
 * @param ?int $filter アクセスレベル定数
 * @return array クラス定数の配列
 */
function class_constants($class, $filter = null)
{
    $class = ltrim(is_object($class) ? get_class($class) : $class, '\\');
    $filter ??= (IS_PUBLIC | IS_PROTECTED | IS_PRIVATE);

    $result = [];
    foreach ((new \ReflectionClass($class))->getReflectionConstants() as $constant) {
        if (($filter & IS_OWNSELF) && $constant->getDeclaringClass()->name !== $class) {
            continue;
        }
        $modifiers = $constant->getModifiers();
        $modifiers2 = 0;
        $modifiers2 |= ($modifiers & \ReflectionProperty::IS_PUBLIC) ? IS_PUBLIC : 0;
        $modifiers2 |= ($modifiers & \ReflectionProperty::IS_PROTECTED) ? IS_PROTECTED : 0;
        $modifiers2 |= ($modifiers & \ReflectionProperty::IS_PRIVATE) ? IS_PRIVATE : 0;
        if ($modifiers2 & $filter) {
            $result[$constant->name] = $constant->getValue();
        }
    }
    return $result;
}
