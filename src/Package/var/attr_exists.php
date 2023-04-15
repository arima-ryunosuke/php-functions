<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/attr_get.php';
// @codeCoverageIgnoreEnd

/**
 * 配列・オブジェクトを問わずキーやプロパティの存在を確認する
 *
 * 配列が与えられた場合は array_key_exists と同じ。
 * オブジェクトは一旦 isset で確認した後 null の場合は実際にアクセスして試みる。
 *
 * Example:
 * ```php
 * $array = [
 *     'k' => 'v',
 *     'n' => null,
 * ];
 * // 配列は array_key_exists と同じ
 * that(attr_exists('k', $array))->isTrue();  // もちろん存在する
 * that(attr_exists('n', $array))->isTrue();  // isset ではないので null も true
 * that(attr_exists('x', $array))->isFalse(); // 存在しないので false
 *
 * $object = (object) $array;
 * // オブジェクトでも使える
 * that(attr_exists('k', $object))->isTrue();  // もちろん存在する
 * that(attr_exists('n', $object))->isTrue();  // isset ではないので null も true
 * that(attr_exists('x', $object))->isFalse(); // 存在しないので false
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param int|string $key 調べるキー
 * @param array|object $value 調べられる配列・オブジェクト
 * @return bool $key が存在するなら true
 */
function attr_exists($key, $value)
{
    return attr_get($key, $value, $dummy = new \stdClass()) !== $dummy;
}
