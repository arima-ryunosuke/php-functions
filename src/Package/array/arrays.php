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
 * キーは連番、値は [$key, $value, $array, $first, $last] で返す。
 * つまり、 Example のように foreach の list 構文を使えば「連番、キー、値」でループを回すことが可能になる。
 * 「foreach で回したいんだけど連番も欲しい」という状況や $first,$last が欲しい状況はまれによくあるはず。
 *
 * Example:
 * ```php
 * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
 * $nkv = [];
 * foreach (arrays($array) as $n => [$k, $v]) {
 *     $nkv[] = "$n,$k,$v";
 * }
 * that($nkv)->isSame(['0,a,A', '1,b,B', '2,c,C']);
 *
 * // iterator でも first/last は使用できる
 * $iterable = (function () {
 *     yield 'a';
 *     yield 'b';
 *     yield 'c';
 * })();
 * $nkv = [];
 * foreach (arrays($iterable) as $n => [$k, $v,, $first, $last]) {
 *     $nkv[] = json_encode([$k, $v, $first, $last]);
 * }
 * that($nkv)->isSame(['[0,"a",true,false]', '[1,"b",false,false]', '[2,"c",false,true]']);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @return \Generator [$seq => [$key, $value, $array, $first, $last]] を返すジェネレータ
 */
function arrays($array)
{
    $n = 0;

    // iterator ではない object の iteration は良くも悪くも特殊なので array として扱う
    if (is_object($array) && !$array instanceof \Iterator) {
        $object = $array;
        /** @noinspection PhpParamsInspection */
        $array = get_object_vars($object);
        $last = array_key_last($array);
        foreach ($array as $k => $v) {
            yield $n => [$k, $v, $object, $n === 0, $k === $last];
            $n++;
        }
    }
    elseif (is_array($array)) {
        $last = array_key_last($array);
        foreach ($array as $k => $v) {
            yield $n => [$k, $v, $array, $n === 0, $k === $last];
            $n++;
        }
    }
    // もっとシンプルに書けるが、valid で何してるか分からないので呼び出しは最小限にする
    else {
        // $array->rewind();
        $valid = $array->valid();
        while ($valid) {
            $k = $array->key();
            $v = $array->current();
            $array->next();
            $valid = $array->valid();
            yield $n => [$k, $v, $array, $n === 0, !$valid];
            $n++;
        }
    }
}
