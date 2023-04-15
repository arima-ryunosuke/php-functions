<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列にコールバックを適用する
 *
 * 配列であれば `$callback($var)` と全く同じ。
 * この関数は「$var がスカラー値だったら配列化して適用してスカラーで返す」という点で上記とは異なる。
 *
 * 「配列を受け取って配列を返す関数があるが、手元にスカラー値しか無い」という状況はまれによくあるはず。
 *
 * Example:
 * ```php
 * // 配列を受け取って中身を大文字化して返すクロージャ
 * $upper = fn($array) => array_map('strtoupper', $array);
 * // 普通はこうやって使うが・・・
 * that($upper(['a', 'b', 'c']))->isSame(['A', 'B', 'C']);
 * // 手元に配列ではなくスカラー値しか無いときはこうせざるをえない
 * that($upper(['a'])[0])->isSame('A');
 * // var_applys を使うと配列でもスカラーでも統一的に記述することができる
 * that(var_applys(['a', 'b', 'c'], $upper))->isSame(['A', 'B', 'C']);
 * that(var_applys('a', $upper))->isSame('A');
 * # 要するに「大文字化したい」だけなわけだが、$upper が配列を前提としているので、「大文字化」部分を得るには配列化しなければならなくなっている
 * # 「strtoupper だけ切り出せばよいのでは？」と思うかもしれないが、「（外部ライブラリなどで）手元に配列しか受け取ってくれない処理しかない」状況がまれによくある
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var $callback を適用する値
 * @param callable $callback 値変換コールバック
 * @param mixed ...$args $callback の残り引数（可変引数）
 * @return mixed|array $callback が適用された値。元が配列なら配列で返す
 */
function var_applys($var, $callback, ...$args)
{
    $iterable = is_iterable($var);
    if (!$iterable) {
        $var = [$var];
    }
    $var = $callback($var, ...$args);
    return $iterable ? $var : $var[0];
}
