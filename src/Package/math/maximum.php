<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_flatten.php';
// @codeCoverageIgnoreEnd

/**
 * 引数の最大値を返す
 *
 * - 配列は個数ではなくフラット展開した要素を対象にする
 * - 候補がない場合はエラーではなく例外を投げる
 *
 * Example:
 * ```php
 * that(maximum(-1, 0, 1))->isSame(1);
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @param mixed ...$variadic 対象の変数・配列・リスト
 * @return mixed 最大値
 */
function maximum(...$variadic)
{
    $args = array_flatten($variadic) or throw new \LengthException("argument's length is 0.");
    return max($args);
}
