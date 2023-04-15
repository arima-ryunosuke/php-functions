<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * キー指定の配列値設定
 *
 * array_set とほとんど同じ。
 * 第3引数を省略すると（null を与えると）言語機構を使用して配列の最後に設定する（$array[] = $value）。
 * また、**int を与えても同様の動作**となる。
 * 第3引数に配列を指定すると潜って設定する。
 *
 * 第4引数で追加する条件クロージャを指定できる。
 * クロージャには `(追加する要素, 追加するキー, 追加される元配列)` が渡ってくる。
 * このクロージャが false 相当を返した時は追加されないようになる。
 *
 * array_set における $require_return は廃止している。
 * これはもともと end や last_key が遅かったのでオプショナルにしていたが、もう改善しているし、7.3 から array_key_last があるので、呼び元で適宜使えば良い。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'B'];
 * // 第3引数 int
 * that(array_put($array, 'Z', 999))->isSame(1);
 * that($array)->isSame(['a' => 'A', 'B', 'Z']);
 * // 第3引数省略（最後に連番キーで設定）
 * that(array_put($array, 'Z'))->isSame(2);
 * that($array)->isSame(['a' => 'A', 'B', 'Z', 'Z']);
 * // 第3引数でキーを指定
 * that(array_put($array, 'Z', 'z'))->isSame('z');
 * that($array)->isSame(['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z']);
 * that(array_put($array, 'Z', 'z'))->isSame('z');
 * // 第3引数で配列を指定
 * that(array_put($array, 'Z', ['x', 'y', 'z']))->isSame('z');
 * that($array)->isSame(['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z', 'x' => ['y' => ['z' => 'Z']]]);
 * // 第4引数で条件を指定（キーが存在するなら追加しない）
 * that(array_put($array, 'Z', 'z', fn($v, $k, $array) => !isset($array[$k])))->isSame(false);
 * // 第4引数で条件を指定（値が存在するなら追加しない）
 * that(array_put($array, 'Z', null, fn($v, $k, $array) => !in_array($v, $array)))->isSame(false);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 配列
 * @param mixed $value 設定する値
 * @param array|string|int|null $key 設定するキー
 * @param callable|null $condition 追加する条件
 * @return string|int|false 設定したキー
 */
function array_put(&$array, $value, $key = null, $condition = null)
{
    if (is_array($key)) {
        $k = array_shift($key);
        if ($key) {
            if (is_array($array) && array_key_exists($k, $array) && !is_array($array[$k])) {
                throw new \InvalidArgumentException('$array[$k] is not array.');
            }
            return array_put(...[&$array[$k], $value, $key, $condition]);
        }
        else {
            return array_put(...[&$array, $value, $k, $condition]);
        }
    }

    if ($condition !== null) {
        if (!$condition($value, $key, $array)) {
            return false;
        }
    }

    if ($key === null || is_int($key)) {
        $array[] = $value;
        $key = array_key_last($array);
    }
    else {
        $array[$key] = $value;
    }
    return $key;
}
