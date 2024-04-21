<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 指定確率で配列のキーを返す
 *
 * 確率の合計が 100% を超えている場合は例外を投げる。
 * 100% に満たない場合は残り確率で null を返す。
 *
 * 分母の 100% は $divisor 引数で指定可能（1000 を指定すればパーミルになる）。
 * null を与えると確率の合計値が設定される（いわゆる重み付け乱数になる）。
 *
 * Example:
 * ```php
 * srand(123);
 * // a:10%, b:20%, c:30%, d:40% の確率で返す
 * that(probability_array([
 *     'a' => 10,
 *     'b' => 20,
 *     'c' => 30,
 *     'd' => 40,
 * ]))->isSame('b');
 *
 * // a:16.6%, b:32.3%, c:50% の確率で返す（いわゆる重み付け）
 * that(probability_array([
 *     'a' => 1,
 *     'b' => 2,
 *     'c' => 3,
 * ], null))->isSame('c');
 * ```
 *
 * @package ryunosuke\Functions\Package\random
 *
 * @param array $array 配列
 * @param ?int $divisor 分母
 * @return mixed $array のどれか1つ
 */
function probability_array($array, $divisor = 100)
{
    $array = arrayval($array, false);
    if (empty($array)) {
        throw new \InvalidArgumentException("array is empty");
    }

    assert(array_reduce($array, fn($carry, $item) => $carry && ctype_digit("$item"), true));

    $weights = array_sum($array);
    $divisor ??= $weights;

    if ($weights > $divisor) {
        throw new \InvalidArgumentException("The sum of probabilities exceeds $divisor");
    }
    if ($divisor <= 0) {
        throw new \InvalidArgumentException("divisor <= 0");
    }

    $probability = mt_rand(1, $divisor);

    foreach ($array as $key => $per) {
        if (($divisor -= $per) < $probability) {
            return $key;
        }
    }

    return null;
}
