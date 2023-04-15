<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/attr_exists.php';
require_once __DIR__ . '/../var/var_type.php';
// @codeCoverageIgnoreEnd

/**
 * 配列・ArrayAccess にキーがあるか調べる
 *
 * 配列が与えられた場合は array_key_exists と同じ。
 * ArrayAccess は一旦 isset で確認した後 null の場合は実際にアクセスして試みる。
 *
 * Example:
 * ```php
 * $array = [
 *     'k' => 'v',
 *     'n' => null,
 * ];
 * // 配列は array_key_exists と同じ
 * that(arrayable_key_exists('k', $array))->isTrue();  // もちろん存在する
 * that(arrayable_key_exists('n', $array))->isTrue();  // isset ではないので null も true
 * that(arrayable_key_exists('x', $array))->isFalse(); // 存在しないので false
 * that(isset($array['n']))->isFalse();                // isset だと null が false になる（参考）
 *
 * $object = new \ArrayObject($array);
 * // ArrayAccess は isset + 実際に取得を試みる
 * that(arrayable_key_exists('k', $object))->isTrue();  // もちろん存在する
 * that(arrayable_key_exists('n', $object))->isTrue();  // isset ではないので null も true
 * that(arrayable_key_exists('x', $object))->isFalse(); // 存在しないので false
 * that(isset($object['n']))->isFalse();                // isset だと null が false になる（参考）
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param string|int $key キー
 * @param array|\ArrayAccess $arrayable 調べる値
 * @return bool キーが存在するなら true
 */
function arrayable_key_exists($key, $arrayable)
{
    if (is_array($arrayable) || $arrayable instanceof \ArrayAccess) {
        return attr_exists($key, $arrayable);
    }

    throw new \InvalidArgumentException(sprintf('%s must be array or ArrayAccess (%s).', '$arrayable', var_type($arrayable)));
}
