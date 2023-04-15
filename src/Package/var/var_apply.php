<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 値にコールバックを適用する
 *
 * 普通のスカラー値であれば `$callback($var)` と全く同じ。
 * この関数は「$var が配列だったら中身に適用して返す（再帰）」という点で上記とは異なる。
 *
 * 「配列が与えられたら要素に適用して配列で返す、配列じゃないなら直に適用してそれを返す」という状況はまれによくあるはず。
 *
 * Example:
 * ```php
 * // 素の値は素の呼び出しと同じ
 * that(var_apply(' x ', 'trim'))->isSame('x');
 * // 配列は中身に適用して配列で返す（再帰）
 * that(var_apply([' x ', ' y ', [' z ']], 'trim'))->isSame(['x', 'y', ['z']]);
 * // 第3引数以降は残り引数を意味する
 * that(var_apply(['!x!', '!y!'], 'trim', '!'))->isSame(['x', 'y']);
 * // 「まれによくある」の具体例
 * that(var_apply(['<x>', ['<y>']], 'htmlspecialchars', ENT_QUOTES, 'utf-8'))->isSame(['&lt;x&gt;', ['&lt;y&gt;']]);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var $callback を適用する値
 * @param callable $callback 値変換コールバック
 * @param mixed ...$args $callback の残り引数（可変引数）
 * @return mixed|array $callback が適用された値。元が配列なら配列で返す
 */
function var_apply($var, $callback, ...$args)
{
    $iterable = is_iterable($var);
    if ($iterable) {
        $result = [];
        foreach ($var as $k => $v) {
            $result[$k] = var_apply($v, $callback, ...$args);
        }
        return $result;
    }

    return $callback($var, ...$args);
}
