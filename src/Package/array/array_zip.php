<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_put.php';
require_once __DIR__ . '/../array/is_hasharray.php';
// @codeCoverageIgnoreEnd

/**
 * 配列の各要素値で順番に配列を作る
 *
 * `array_map(null, ...$arrays)` とほぼ同義。ただし
 *
 * - 文字キーは保存される（数値キーは再割り振りされる）
 * - 一つだけ配列を与えても構造は壊れない（array_map(null) は壊れる）
 *
 * Example:
 * ```php
 * // 普通の zip
 * that(array_zip(
 *     [1, 2, 3],
 *     ['hoge', 'fuga', 'piyo']
 * ))->is([[1, 'hoge'], [2, 'fuga'], [3, 'piyo']]);
 * // キーが維持される
 * that(array_zip(
 *     ['a' => 1, 2, 3],
 *     ['hoge', 'b' => 'fuga', 'piyo']
 * ))->is([['a' => 1, 'hoge'], [2, 'b' => 'fuga'], [3, 'piyo']]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array ...$arrays 対象配列（可変引数）
 * @return array 各要素値の配列
 */
function array_zip(...$arrays)
{
    $count = count($arrays);
    if ($count === 0) {
        throw new \InvalidArgumentException('$arrays is empty.');
    }

    // キー保持処理がかなり遅いので純粋な配列しかないのなら array_map(null) の方が（チェックを加味しても）速くなる
    foreach ($arrays as $a) {
        if (is_hasharray($a)) {
            $yielders = array_map(function ($array) { yield from $array; }, $arrays);

            $result = [];
            for ($i = 0, $limit = max(array_map('count', $arrays)); $i < $limit; $i++) {
                $e = [];
                foreach ($yielders as $yielder) {
                    array_put($e, $yielder->current(), $yielder->key());
                    $yielder->next();
                }
                $result[] = $e;
            }
            return $result;
        }
    }

    // array_map(null) は1つだけ与えると構造がぶっ壊れる
    if ($count === 1) {
        return array_map(fn($v) => [$v], $arrays[0]);
    }
    return array_map(null, ...$arrays);

    /* MultipleIterator を使った実装。かなり遅かったので採用しなかったが、一応コメントとして残す
    $mi = new \MultipleIterator(\MultipleIterator::MIT_NEED_ANY | \MultipleIterator::MIT_KEYS_NUMERIC);
    foreach ($arrays as $array) {
        $mi->attachIterator((function ($array) { yield from $array; })($array));
    }

    $result = [];
    foreach ($mi as $k => $v) {
        $e = [];
        for ($i = 0; $i < $count; $i++) {
            Arrays::array_put($e, $v[$i], $k[$i]);
        }
        $result[] = $e;
    }
    return $result;
    */
}
