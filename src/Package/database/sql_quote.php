<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * ものすごく雑に値をクオートする
 *
 * 非常に荒くアドホックに実装しているのでこの関数で得られた値で**実際に実行してはならない**。
 * あくまでログ出力やデバッグ用途で視認性を高める目的である。
 *
 * - null は NULL になる
 * - 数字はそのまま数字になる
 * - bool は 0 or 1 になる
 * - 配列は再帰的にカンマ区切りになる
 *   - この実装はエラー回避の意味合いが強く、実装は変更される可能性がある
 * - それ以外は addcslashes される
 *
 * Example:
 * ```php
 * that(sql_quote(null))->isSame('NULL');
 * that(sql_quote(123))->isSame(123);
 * that(sql_quote(true))->isSame(1);
 * that(sql_quote("hoge"))->isSame("'hoge'");
 * that(sql_quote([1, 2, 3]))->isSame("1,2,3");
 * ```
 *
 * @package ryunosuke\Functions\Package\database
 *
 * @param mixed $value クオートする値
 * @return mixed クオートされた値
 */
function sql_quote($value)
{
    if ($value === null) {
        return 'NULL';
    }
    if (is_numeric($value)) {
        return $value;
    }
    if (is_bool($value)) {
        return (int) $value;
    }
    if (is_iterable($value) && !is_stringable($value)) {
        return implode(',', array_map(fn($v) => sql_quote($v), arrayval($value)));
    }
    return "'" . addcslashes((string) $value, "\0\e\f\n\r\t\v'\\") . "'";
}
