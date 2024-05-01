<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_flatten.php';
// @codeCoverageIgnoreEnd

/**
 * 引数の中央値を返す
 *
 * - 要素数が奇数の場合は完全な中央値/偶数の場合は中2つの平均。「平均」という概念が存在しない値なら中2つの後の値
 * - 配列は個数ではなくフラット展開した要素を対象にする
 * - 候補がない場合はエラーではなく例外を投げる
 *
 * Example:
 * ```php
 * // 偶数個なので中2つの平均
 * that(median(1, 2, 3, 4, 5, 6))->isSame(3.5);
 * // 奇数個なのでど真ん中
 * that(median(1, 2, 3, 4, 5))->isSame(3);
 * // 偶数個だが文字列なので中2つの後
 * that(median('a', 'b', 'c', 'd'))->isSame('c');
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @param mixed ...$variadic 対象の変数・配列・リスト
 * @return mixed 中央値
 */
function median(...$variadic)
{
    $args = array_flatten($variadic) or throw new \LengthException("argument's length is 0.");
    $count = count($args);
    $center = (int) ($count / 2);
    sort($args);
    // 偶数で共に数値なら平均値
    if ($count % 2 === 0 && (is_numeric($args[$center - 1]) && is_numeric($args[$center]))) {
        return ($args[$center - 1] + $args[$center]) / 2;
    }
    // 奇数なら単純に中央値
    else {
        return $args[$center];
    }
}
