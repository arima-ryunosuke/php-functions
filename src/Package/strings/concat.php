<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * strcat の空文字回避版
 *
 * 基本は strcat と同じ。ただし、**引数の内1つでも空文字を含むなら空文字を返す**。
 * さらに*引数の内1つでも null を含むなら null を返す**。
 *
 * 「プレフィックスやサフィックスを付けたいんだけど、空文字の場合はそのままで居て欲しい」という状況はまれによくあるはず。
 * コードで言えば `strlen($string) ? 'prefix-' . $string : '';` のようなもの。
 * 可変引数なので 端的に言えば mysql の CONCAT みたいな動作になる。
 *
 * ```php
 * that(concat('prefix-', 'middle', '-suffix'))->isSame('prefix-middle-suffix');
 * that(concat('prefix-', '', '-suffix'))->isSame('');
 * that(concat('prefix-', null, '-suffix'))->isSame(null);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param ?string ...$variadic 結合する文字列（可変引数）
 * @return ?string 結合した文字列
 */
function concat(...$variadic)
{
    if (count(array_filter($variadic, 'is_null')) > 0) {
        return null;
    }
    $result = '';
    foreach ($variadic as $s) {
        if (strlen($s) === 0) {
            return '';
        }
        $result .= $s;
    }
    return $result;
}
