<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/type_exists.php';
// @codeCoverageIgnoreEnd

/**
 * ReflectionType の型に \\ を付与する
 *
 * php8.0 で ReflectionType の __toString が解放されたけど、それをそのまま埋め込んだりすると \\ がないのでエラーになったりする。
 * この関数を通してから埋め込めば \\ が付くので回避できる、という非常にニッチな関数。
 *
 * 型 exists で判定するため、付与するクラスは存在している必要がある（オプション引数で対応するかもしれない）。
 *
 * Example:
 * ```php
 * // このような DNF 型も形式を保ったまま \\ を付与できる
 * that(reflect_type_resolve('(Countable&Traversable)|object'))->is('(\\Countable&\\Traversable)|object');
 * ```
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param ?string $type string だが実用上は getType 等で得られるインスタンスでよい
 * @return ?string 解決された文字列
 */
function reflect_type_resolve(?string $type): ?string
{
    if ($type === null) {
        return null;
    }

    // 拡張関数が string|null ではなく ?string で返すことがあるので ? を含める
    // 8.1以上では交差型もあり得るので (&) も含める
    // そして PREG_SPLIT_DELIM_CAPTURE で分割して再結合すれば元の形式のまま得られる
    $types = preg_split('#([?()|&])#', $type, -1, PREG_SPLIT_DELIM_CAPTURE);
    $types = array_map(fn($v) => type_exists($v) ? "\\" . ltrim($v, '\\') : $v, $types);
    return implode('', $types);
}
