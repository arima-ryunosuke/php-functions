<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * array_fill_keys のコールバック版のようなもの
 *
 * 指定したキー配列をそれらのマップしたもので配列を生成する。
 * `array_combine($keys, array_map($callback, $keys))` とほぼ等価。
 *
 * Example:
 * ```php
 * $abc = ['a', 'b', 'c'];
 * // [a, b, c] から [a => A, b => B, c => C] を作る
 * that(array_fill_callback($abc, 'strtoupper'))->isSame([
 *     'a' => 'A',
 *     'b' => 'B',
 *     'c' => 'C',
 * ]);
 * // [a, b, c] からその sha1 配列を作って大文字化する
 * that(array_fill_callback($abc, fn($v) => strtoupper(sha1($v))))->isSame([
 *     'a' => '86F7E437FAA5A7FCE15D1DDCB9EAEAEA377667B8',
 *     'b' => 'E9D71F5EE7C92D6DC9E92FFDAD17B8BD49418F98',
 *     'c' => '84A516841BA77A5B4648DE2CD0DFCB30EA46DBB4',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $keys キーとなる配列
 * @param callable $callback 要素のコールバック（引数でキーが渡ってくる）
 * @return array 新しい配列
 */
function array_fill_callback($keys, $callback)
{
    $keys = arrayval($keys, false);
    return array_combine($keys, array_map(func_user_func_array($callback), $keys));
}
