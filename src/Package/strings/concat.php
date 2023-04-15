<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * strcat の空文字回避版
 *
 * 基本は strcat と同じ。ただし、**引数の内1つでも空文字を含むなら空文字を返す**。
 *
 * 「プレフィックスやサフィックスを付けたいんだけど、空文字の場合はそのままで居て欲しい」という状況はまれによくあるはず。
 * コードで言えば `strlen($string) ? 'prefix-' . $string : '';` のようなもの。
 * 可変引数なので 端的に言えば mysql の CONCAT みたいな動作になる（あっちは NULL だが）。
 *
 * ```php
 * that(concat('prefix-', 'middle', '-suffix'))->isSame('prefix-middle-suffix');
 * that(concat('prefix-', '', '-suffix'))->isSame('');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param mixed ...$variadic 結合する文字列（可変引数）
 * @return string 結合した文字列
 */
function concat(...$variadic)
{
    $result = '';
    foreach ($variadic as $s) {
        if (strlen($s = (string) $s) === 0) {
            return '';
        }
        $result .= $s;
    }
    return $result;
}
