<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * in_array の複数版（AND）
 *
 * 配列 $haystack が $needle の「すべてを含む」ときに true を返す。
 *
 * $needle が非配列の場合は配列化される。
 * $needle が空の場合は常に false を返す。
 *
 * Example:
 * ```php
 * that(in_array_and([1], [1, 2, 3]))->isTrue();
 * that(in_array_and([9], [1, 2, 3]))->isFalse();
 * that(in_array_and([1, 9], [1, 2, 3]))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array|mixed $needle 調べる値
 * @param array $haystack 調べる配列
 * @param bool $strict 厳密フラグ
 * @return bool $needle のすべてが含まれているなら true
 */
function in_array_and($needle, $haystack, $strict = false)
{
    $needle = is_iterable($needle) ? $needle : [$needle];
    if (is_empty($needle)) {
        return false;
    }

    foreach ($needle as $v) {
        if (!in_array($v, $haystack, $strict)) {
            return false;
        }
    }
    return true;
}
