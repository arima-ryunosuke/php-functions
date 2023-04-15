<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_insert.php';
require_once __DIR__ . '/../array/first_keyvalue.php';
// @codeCoverageIgnoreEnd

/**
 * 要素値を $callback の n 番目(0ベース)に適用して array_map する
 *
 * 引数 $n に配列を与えると [キー番目 => 値番目] とみなしてキー・値も渡される（Example 参照）。
 * その際、「挿入後の番目」ではなく、単純に「元の引数の番目」であることに留意。キー・値が同じ位置を指定している場合はキーが先にくる。
 *
 * Example:
 * ```php
 * // 1番目に値を渡して map
 * $sprintf = fn() => vsprintf('%s%s%s', func_get_args());
 * that(array_nmap(['a', 'b'], $sprintf, 1, 'prefix-', '-suffix'))->isSame(['prefix-a-suffix', 'prefix-b-suffix']);
 * // 1番目にキー、2番目に値を渡して map
 * $sprintf = fn() => vsprintf('%s %s %s %s %s', func_get_args());
 * that(array_nmap(['k' => 'v'], $sprintf, [1 => 2], 'a', 'b', 'c'))->isSame(['k' => 'a k b v c']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 評価クロージャ
 * @param int|array $n 要素値を入れる引数番目。配列を渡すとキー・値の両方を指定でき、両方が渡ってくる
 * @param mixed ...$variadic $callback に渡され、改変される引数（可変引数）
 * @return array 評価クロージャを通した新しい配列
 */
function array_nmap($array, $callback, $n, ...$variadic)
{
    /** @var $kn */
    /** @var $vn */

    $is_array = is_array($n);
    $args = $variadic;

    // 配列が来たら [キー番目 => 値番目] とみなす
    if ($is_array) {
        if (empty($n)) {
            throw new \InvalidArgumentException('array $n is empty.');
        }
        [$kn, $vn] = first_keyvalue($n);

        // array_insert は負数も受け入れられるが、それを考慮しだすともう収拾がつかない
        if ($kn < 0 || $vn < 0) {
            throw new \InvalidArgumentException('$kn, $vn must be positive.');
        }

        // どちらが大きいかで順番がズレるので分岐しなければならない
        if ($kn <= $vn) {
            $args = array_insert($args, null, $kn);
            $args = array_insert($args, null, ++$vn);// ↑で挿入してるので+1
        }
        else {
            $args = array_insert($args, null, $vn);
            $args = array_insert($args, null, ++$kn);// ↑で挿入してるので+1
        }
    }
    else {
        $args = array_insert($args, null, $n);
    }

    $result = [];
    foreach ($array as $k => $v) {
        // キー値モードなら両方埋める
        if ($is_array) {
            $args[$kn] = $k;
            $args[$vn] = $v;
        }
        // 値のみなら値だけ
        else {
            $args[$n] = $v;
        }
        $result[$k] = $callback(...$args);
    }
    return $result;
}
