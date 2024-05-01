<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_flatten.php';
require_once __DIR__ . '/../var/stringify.php';
// @codeCoverageIgnoreEnd

/**
 * 引数の最頻値を返す
 *
 * - 等価比較は文字列で行う。小数時は注意。おそらく php.ini の precision に従うはず
 * - 等価値が複数ある場合の返り値は不定
 * - 配列は個数ではなくフラット展開した要素を対象にする
 * - 候補がない場合はエラーではなく例外を投げる
 *
 * Example:
 * ```php
 * that(mode(0, 1, 2, 2, 3, 3, 3))->isSame(3);
 * ```
 *
 * @package ryunosuke\Functions\Package\math
 *
 * @param mixed ...$variadic 対象の変数・配列・リスト
 * @return mixed 最頻値
 */
function mode(...$variadic)
{
    $args = array_flatten($variadic) or throw new \LengthException("argument's length is 0.");
    $vals = array_map(function ($v) {
        if (is_object($v)) {
            // ここに特別扱いのオブジェクトを列挙していく
            if ($v instanceof \DateTimeInterface) {
                return $v->getTimestamp();
            }
            // それ以外は stringify へ移譲（__toString もここに含まれている）
            return stringify($v);
        }
        return (string) $v;
    }, $args);
    $args = array_combine($vals, $args);
    $counts = array_count_values($vals);
    arsort($counts);
    reset($counts);
    return $args[key($counts)];
}
