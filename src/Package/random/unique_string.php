<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * 文字列に含まれない文字列を生成する
 *
 * 例えば http のマルチパートバウンダリのような、「競合しない文字列」を生成する。
 * 実装は愚直に文字列を調べて存在しなければそれを返すようになっている。
 * 一応初期値や文字セットは指定可能。
 *
 * $initial に int を与えると初期値としてその文字数分 $charlist から確保する。
 * 例えば生成後の変更が前提で、ある程度の長さを担保したいときに指定すれば最低でもその長さ以上は保証される。
 * $initial に string を与えるとそれがそのまま初期値として使用される。
 * 例えば「ほぼ存在しない文字列」が予測できるのであればそれを指定すれば無駄な処理が省ける。
 *
 * Example:
 * ```php
 * // 単純に呼ぶと生成1,2文字程度の文字列になる
 * that(unique_string('hello, world'))->stringLengthEqualsAny([1, 2]);
 * // 数値を含んでいないので候補文字に数値のみを指定すれば1文字で「存在しない文字列」となる
 * that(unique_string('hello, world', null, range(0, 9)))->stringLengthEquals(1);
 * // int を渡すと最低でもそれ以上は保証される
 * that(unique_string('hello, world', 5))->stringLengthEqualsAny([5, 6]);
 * // string を渡すとそれが初期値となる
 * that(unique_string('hello, world', 'prefix-'))->stringStartsWith('prefix');
 * ```
 *
 * @package ryunosuke\Functions\Package\random
 *
 * @param string $source 元文字列
 * @param string|int $initial 初期文字列あるいは文字数
 * @param string|array $charlist 使用する文字セット
 * @return string 一意な文字列
 */
function unique_string($source, $initial = null, $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    assert(is_stringable($initial) || is_int($initial) || is_null($initial));

    if (is_stringable($charlist)) {
        $charlist = preg_split('//', $charlist, -1, PREG_SPLIT_NO_EMPTY);
    }

    $charlength = count($charlist);
    if ($charlength === 0) {
        throw new \InvalidArgumentException('charlist is empty.');
    }

    $result = '';
    if (is_int($initial)) {
        shuffle($charlist);
        $result = implode('', array_slice($charlist, 0, $initial));
    }
    elseif (is_null($initial)) {
        $result .= $charlist[mt_rand(0, $charlength - 1)];
    }
    else {
        $result = $initial;
    }

    while ((($p = strpos($source, $result, $p ?? 0)) !== false)) {
        $result .= $charlist[mt_rand(0, $charlength - 1)];
    }

    return $result;
}
