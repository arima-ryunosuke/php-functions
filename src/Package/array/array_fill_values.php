<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/is_callback.php';
require_once __DIR__ . '/../utility/function_configure.php';
require_once __DIR__ . '/../var/arrayval.php';
require_once __DIR__ . '/../var/is_arrayable.php';
// @codeCoverageIgnoreEnd

/**
 * 既存配列のキーを埋める
 *
 * キーベースの array_combine のようなもの。
 * array_combine を呼ぶときは手元に連想配列があることが多く、array_combine(array_keys($array), ['some', 'thing']) という使い方が多い。
 * ならばいっそキーベースで値を埋められた方が便利なことがある。
 *
 * $values が非配列の場合、単純にその値で埋められる（array_fill_keys 相当の動きになる）。
 * $values が配列の場合、読み替えはキー・連番の両方で行われる（連想配列を渡した場合は array_shrink_key 相当の動きになる）。
 * さらに $values の数は一致していなくてもよい。
 * $values の方が大きい場合は array_combine と同様に例外を投げるが、少ない場合は足りない分はフィルタされる。
 *
 * $values はコールバックを受け付けるので、与えられた場合は各要素のコールバック結果が値となる（array_fill_callback 相当の動きになる）。
 *
 * Example:
 * ```php
 * $array = [
 *     'a' => 'A',
 *     'b' => 'B',
 * ];
 * # array_fill_keys のような使い方
 * that(array_fill_values($array, 'hogera'))->isSame(['a' => 'hogera', 'b' => 'hogera']);
 * # array_combine のような使い方
 * that(array_fill_values($array, ['hoge', 'fuga']))->isSame(['a' => 'hoge', 'b' => 'fuga']);
 * # array_shrink_key のような使い方
 * that(array_fill_values($array, ['b' => 'hoge', 'a' => 'fuga']))->isSame(['a' => 'fuga', 'b' => 'hoge']);
 * # array_fill_callback のような使い方
 * that(array_fill_values($array, fn($v, $k, $n) => "$v-$k-$n"))->isSame(['a' => "A-a-0", 'b' => "B-b-1"]);
 * # 数が少なくてもエラーにはならないが数が多いと例外
 * that(array_fill_values($array, ['X']))->isSame(['a' => "X"]);
 * try {
 *     array_fill_values($array, ['X', 'Y', 'Z']);
 *     $this->fail();
 * } catch (\Throwable) {}
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @template T of iterable&\ArrayAccess
 * @param T $array
 * @return T
 */
function array_fill_values(iterable $array, mixed $values)
{
    // Iterator だが ArrayAccess ではないオブジェクト（Generator とか）は unset できないので配列として扱わざるを得ない
    if (!(function_configure('array.variant') && is_arrayable($array))) {
        $array = arrayval($array, false);
    }

    $array2 = arrayval($array, false);

    $n = 0;
    $settled = [];
    foreach ($array2 as $k => $v) {
        if (is_array($values)) {
            if (array_key_exists($key = $k, $values) || array_key_exists($key = $n, $values)) {
                $array[$k] = $values[$key];
                unset($values[$k]);
                unset($values[$n]);
                $settled[$k] = true;
            }
        }
        elseif (is_callback($values)) {
            $array[$k] = $values($v, $k, $n);
            $settled[$k] = true;
        }
        else {
            $array[$k] = $values;
            $settled[$k] = true;
        }

        $n++;
    }

    if (is_array($values) && count(array_filter($values, 'is_int', ARRAY_FILTER_USE_KEY))) {
        throw new \ValueError('array_fill_values(): Argument #2 ($values) must less then number of array');
    }

    foreach ($array2 as $k => $v) {
        if (!isset($settled[$k])) {
            unset($array[$k]);
        }
    }

    return $array;
}
