<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_flatten.php';
require_once __DIR__ . '/../syntax/throws.php';
// @codeCoverageIgnoreEnd

/**
 * 引数の合計値を返す
 *
 * - is_numeric でない値は除外される（計算結果に影響しない）
 * - 配列は個数ではなくフラット展開した要素を対象にする
 * - 候補がない場合はエラーではなく例外を投げる
 *
 * Example:
 * ```php
 * that(sum(1, 2, 3, 4, 5, 6))->isSame(21);
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @param mixed ...$variadic 対象の変数・配列・リスト
 * @return mixed 合計値
 */
function sum(...$variadic)
{
    $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
    $args = array_filter($args, 'is_numeric') or throws(new \LengthException("argument's must be contain munber."));
    return array_sum($args);
}
