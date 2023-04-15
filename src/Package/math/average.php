<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 引数の意味平均値を返す
 *
 * - 3座標の重心座標とか日付の平均とかそういうもの
 * - 配列は個数ではなくフラット展開した要素を対象にする
 * - 候補がない場合はエラーではなく例外を投げる
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @param mixed ...$variadic 対象の変数・配列・リスト
 * @return mixed 意味平均値
 */
function average(...$variadic)
{
    // 用意したはいいが統一的なうまい実装が思いつかない（関数ベースじゃ無理だと思う）
    // average は意味平均、mean は相加平均を明示するために定義は残しておく
    assert(is_array($variadic));
    throw new \DomainException('not implement yet.');
}
