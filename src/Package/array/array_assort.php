<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * 配列をコールバックに従って分類する
 *
 * コールバックは配列で複数与える。そのキーが結果配列のキーになるが、一切マッチしなくてもキー自体は作られる。
 * 複数のコールバックにマッチしたらその分代入されるし、どれにもマッチしなければ代入されない。
 * つまり5個の配列を分類したからと言って、全要素数が5個になるとは限らない（多い場合も少ない場合もある）。
 *
 * $rule が要求するならキーも渡ってくる。
 *
 * Example:
 * ```php
 * // lt2(2より小さい)で分類
 * $lt2 = fn($v) => $v < 2;
 * that(array_assort([1, 2, 3], [
 *     'lt2' => $lt2,
 * ]))->isSame([
 *     'lt2' => [1],
 * ]);
 * // lt3(3より小さい)、ctd(ctype_digit)で分類（両方に属する要素が存在する）
 * $lt3 = fn($v) => $v < 3;
 * that(array_assort(['1', '2', '3'], [
 *     'lt3' => $lt3,
 *     'ctd' => 'ctype_digit',
 * ]))->isSame([
 *     'lt3' => ['1', '2'],
 *     'ctd' => ['1', '2', '3'],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable[] $rules 分類ルール。[key => callable] 形式
 * @return array 分類された新しい配列
 */
function array_assort($array, $rules)
{
    $result = array_fill_keys(array_keys($rules), []);
    foreach ($rules as $name => $rule) {
        $rule = func_user_func_array($rule);
        $n = 0;
        foreach ($array as $k => $v) {
            if ($rule($v, $k, $n++)) {
                $result[$name][$k] = $v;
            }
        }
    }
    return $result;
}
