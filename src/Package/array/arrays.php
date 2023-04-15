<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 配列をシーケンシャルに走査するジェネレータを返す
 *
 * 「シーケンシャルに」とは要するに数値連番が得られるように走査するということ。
 * 0ベースの連番を作ってインクリメントしながら foreach するのと全く変わらない。
 *
 * キーは連番、値は [$key, $value] で返す。
 * つまり、 Example のように foreach の list 構文を使えば「連番、キー、値」でループを回すことが可能になる。
 * 「foreach で回したいんだけど連番も欲しい」という状況はまれによくあるはず。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * $nkv = [];
 * foreach (arrays($array) as $n => [$k, $v]) {
 *     $nkv[] = "$n,$k,$v";
 * }
 * that($nkv)->isSame(['0,a,A', '1,b,B', '2,c,C']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @return \Generator [$seq => [$key, $value]] を返すジェネレータ
 */
function arrays($array)
{
    $n = 0;
    foreach ($array as $k => $v) {
        yield $n++ => [$k, $v];
    }
}
