<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../reflection/reflect_types.php';
// @codeCoverageIgnoreEnd

/**
 * 配列を $orders に従って並べ替える
 *
 * データベースからフェッチしたような連想配列の配列を想定しているが、スカラー配列(['key' => 'value'])にも対応している。
 * その場合 $orders に配列ではなく直値を渡せば良い。
 *
 * $orders には下記のような配列を渡す。
 * キーに空文字を渡すとそれは「キー自体」を意味する。
 *
 * ```php
 * $orders = [
 *     'col1' => true,                              // true: 昇順, false: 降順。照合は型に依存
 *     'col2' => SORT_NATURAL,                      // SORT_NATURAL, SORT_REGULAR などで照合。正数で昇順、負数で降順
 *     'col3' => ['sort', 'this', 'order'],         // 指定した配列順で昇順
 *     'col4' => fn($v) => $v,                      // 引数1個: クロージャを通した値で昇順。照合は返り値の型に依存
 *     // 'col4' => fn($v, $o = SORT_DESC) => $v,   // ↑の亜種（第2引数のデフォルト値がオーダーを表す）
 *     'col5' => fn($av, $bv) => $av - $bv,         // 引数2個: クロージャで比較して値昇順（いわゆる比較関数を渡す）
 *     'col6' => fn($ak, $bk, $array) => $ak - $bk, // 引数3個: クロージャで比較してキー昇順（いわゆる比較関数を渡す）
 * ];
 * ```
 *
 * Example:
 * ```php
 * $v1 = ['id' => '1', 'no' => 'a03', 'name' => 'yyy'];
 * $v2 = ['id' => '2', 'no' => 'a4',  'name' => 'yyy'];
 * $v3 = ['id' => '3', 'no' => 'a12', 'name' => 'xxx'];
 * // name 昇順, no 自然降順
 * that(array_order([$v1, $v2, $v3], ['name' => true, 'no' => -SORT_NATURAL]))->isSame([$v3, $v2, $v1]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 対象配列
 * @param mixed $orders ソート順
 * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
 * @return array 並び替えられた配列
 */
function array_order(array $array, $orders, $preserve_keys = false)
{
    if (count($array) <= 1) {
        return $array;
    }

    if (!is_array($orders) || !is_hasharray($orders)) {
        $orders = [$orders];
    }

    // 配列内の位置をマップして返すクロージャ
    $position = fn($columns, $order) => array_map(function ($v) use ($order) {
        $ndx = array_search($v, $order, true);
        return $ndx === false ? count($order) : $ndx;
    }, $columns);

    // 全要素は舐めてられないので最初の要素を代表選手としてピックアップ
    $first = reset($array);
    $is_scalar = is_scalar($first) || is_null($first);

    // array_multisort 用の配列を生成
    $args = [];
    foreach ($orders as $key => $order) {
        if ($is_scalar) {
            $firstval = reset($array);
            $columns = $array;
        }
        else {
            if ($key !== '' && !array_key_exists($key, $first)) {
                throw new \InvalidArgumentException("$key is undefined.");
            }
            if ($key === '') {
                $columns = array_keys($array);
                $firstval = reset($columns);
            }
            else {
                $firstval = $first[$key];
                $columns = array_column($array, $key);
            }
        }

        // bool は ASC, DESC
        if (is_bool($order)) {
            $args[] = $columns;
            $args[] = $order ? SORT_ASC : SORT_DESC;
            $args[] = is_string($firstval) ? SORT_STRING : SORT_NUMERIC;
        }
        // int は SORT_*****
        elseif (is_int($order)) {
            $args[] = $columns;
            $args[] = $order > 0 ? SORT_ASC : SORT_DESC;
            $args[] = abs($order);
        }
        // 配列はその並び
        elseif (is_array($order)) {
            $args[] = $position($columns, $order);
            $args[] = SORT_ASC;
            $args[] = SORT_NUMERIC;
        }
        // クロージャは色々
        elseif ($order instanceof \Closure) {
            $ref = new \ReflectionFunction($order);
            // 引数2個なら値比較関数
            if ($ref->getNumberOfRequiredParameters() === 2) {
                $map = $columns;
                usort($map, $order);
                $args[] = $position($columns, $map);
                $args[] = SORT_ASC;
                $args[] = SORT_NUMERIC;
            }
            // 引数3個はキー比較関数
            elseif ($ref->getNumberOfRequiredParameters() === 3) {
                $map = $columns;
                usort($map, fn($a, $b) => $order($a, $b, $array));
                $args[] = $map;
                $args[] = SORT_ASC;
                $args[] = SORT_NUMERIC;
            }
            // でないなら通した値で比較
            else {
                $arg = array_map($order, $columns);
                $type = reflect_types($ref->getReturnType())->allows('string') ? 'string' : gettype(reset($arg));
                $args[] = $arg;
                $args[] = ($ref->getParameters()[1] ?? null)?->getDefaultValue() ?? SORT_ASC;
                $args[] = $type === 'string' ? SORT_STRING : SORT_NUMERIC;
            }
        }
        else {
            throw new \DomainException('$order is invalid.');
        }
    }

    // array_multisort はキーを保持しないので、ソートされる配列にキー配列を加えて後で combine する
    if ($preserve_keys) {
        $keys = array_keys($array);
        $args[] = &$array;
        $args[] = &$keys;
        array_multisort(...$args);
        return array_combine($keys, $array);
    }
    // キーを保持しないなら単純呼び出しで OK
    else {
        $args[] = &$array;
        array_multisort(...$args);
        return $array;
    }
}
