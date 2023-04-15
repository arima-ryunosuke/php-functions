<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列のキー・要素に文字列を付加する
 *
 * $key_prefix, $val_prefix でそれぞれ「キーに付与する文字列」「値に付与する文字列」が指定できる。
 * 配列を与えると [サフィックス, プレフィックス] という意味になる。
 * デフォルト（ただの文字列）はプレフィックス（値だけに付与したいなら array_map で十分なので）。
 *
 * Example:
 * ```php
 * $array = ['key1' => 'val1', 'key2' => 'val2'];
 * // キーにプレフィックス付与
 * that(array_strpad($array, 'prefix-'))->isSame(['prefix-key1' => 'val1', 'prefix-key2' => 'val2']);
 * // 値にサフィックス付与
 * that(array_strpad($array, '', ['-suffix']))->isSame(['key1' => 'val1-suffix', 'key2' => 'val2-suffix']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string|array $key_prefix キー側の付加文字列
 * @param string|array $val_prefix 値側の付加文字列
 * @return array 文字列付与された配列
 */
function array_strpad($array, $key_prefix, $val_prefix = '')
{
    $key_suffix = '';
    if (is_array($key_prefix)) {
        [$key_suffix, $key_prefix] = $key_prefix + [1 => ''];
    }
    $val_suffix = '';
    if (is_array($val_prefix)) {
        [$val_suffix, $val_prefix] = $val_prefix + [1 => ''];
    }

    $enable_key = strlen($key_prefix) || strlen($key_suffix);
    $enable_val = strlen($val_prefix) || strlen($val_suffix);

    $result = [];
    foreach ($array as $key => $val) {
        if ($enable_key) {
            $key = $key_prefix . $key . $key_suffix;
        }
        if ($enable_val) {
            $val = $val_prefix . $val . $val_suffix;
        }
        $result[$key] = $val;
    }
    return $result;
}
