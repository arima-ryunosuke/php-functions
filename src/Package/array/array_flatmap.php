<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * スタンダードな flatMap
 *
 * 同じことは array_kvmap でもできる。
 * ただあちらは仕様が独自なので、こちらは癖のない万人が想起する flatmap になる。
 *
 * コールバック引数:
 * - array_kvmap: ($k, $v, $callback) # $k が第一で、再帰を意識していたので $callback も渡ってくる
 * - array_flatmap: ($v, $k, $array)  # シンプルに js に合わせる
 * null の扱い
 * - array_kvmap: 変更なしとして扱う
 * - array_flatmap: 値として扱う
 * !array & iterable の扱い
 * - array_kvmap: 配列として扱う
 * - array_flatmap: 値として扱う
 *
 * @package ryunosuke\Functions\Package\array
 */
function array_flatmap(iterable $array, $callback): array
{
    $result = [];
    foreach ($array as $k => $v) {
        $kv = $callback($v, $k, $array);
        if (!is_array($kv)) {
            $kv = [$kv];
        }
        // $result = array_merge($result, $kv); // 遅すぎる
        foreach ($kv as $k2 => $v2) {
            if (is_int($k2)) {
                $result[] = $v2;
            }
            else {
                $result[$k2] = $v2;
            }
        }
    }
    return $result;
}
