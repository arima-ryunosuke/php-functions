<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/last_key.php';
// @codeCoverageIgnoreEnd

/**
 * キー指定の配列値設定
 *
 * 第3引数を省略すると（null を与えると）言語機構を使用して配列の最後に設定する（$array[] = $value）。
 * 第3引数に配列を指定すると潜って設定する。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'B'];
 * // 第3引数省略（最後に連番キーで設定）
 * that(array_set($array, 'Z'))->isSame(1);
 * that($array)->isSame(['a' => 'A', 'B', 'Z']);
 * // 第3引数でキーを指定
 * that(array_set($array, 'Z', 'z'))->isSame('z');
 * that($array)->isSame(['a' => 'A', 'B', 'Z', 'z' => 'Z']);
 * that(array_set($array, 'Z', 'z'))->isSame('z');
 * // 第3引数で配列を指定
 * that(array_set($array, 'Z', ['x', 'y', 'z']))->isSame('z');
 * that($array)->isSame(['a' => 'A', 'B', 'Z', 'z' => 'Z', 'x' => ['y' => ['z' => 'Z']]]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array $array 配列
 * @param mixed $value 設定する値
 * @param array|string|int|null $key 設定するキー
 * @param bool $require_return 返り値が不要なら false を渡す
 * @return string|int 設定したキー
 */
function array_set(&$array, $value, $key = null, $require_return = true)
{
    if (is_array($key)) {
        $k = array_shift($key);
        if ($key) {
            if (is_array($array) && array_key_exists($k, $array) && !is_array($array[$k])) {
                throw new \InvalidArgumentException('$array[$k] is not array.');
            }
            return array_set(...[&$array[$k], $value, $key, $require_return]);
        }
        else {
            return array_set(...[&$array, $value, $k, $require_return]);
        }
    }

    if ($key === null) {
        $array[] = $value;
        if ($require_return === true) {
            $key = last_key($array);
        }
    }
    else {
        $array[$key] = $value;
    }
    return $key;
}
