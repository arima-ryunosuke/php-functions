<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 値が空か検査する
 *
 * `empty` とほぼ同じ。ただし
 *
 * - string: "0"
 * - countable でない object
 * - countable である object で count() > 0
 *
 * は false 判定する。
 * ただし、 $empty_stcClass に true を指定すると「フィールドのない stdClass」も true を返すようになる。
 * これは stdClass の立ち位置はかなり特殊で「フィールドアクセスできる組み込み配列」のような扱いをされることが多いため。
 * （例えば `json_decode('{}')` は stdClass を返すが、このような状況は空判定したいことが多いだろう）。
 *
 * なお、関数の仕様上、未定義変数を true 判定することはできない。
 * 未定義変数をチェックしたい状況は大抵の場合コードが悪いが `$array['key1']['key2']` を調べたいことはある。
 * そういう時には使えない（?? する必要がある）。
 *
 * 「 `if ($var) {}` で十分なんだけど "0" が…」という状況はまれによくあるはず。
 *
 * Example:
 * ```php
 * // この辺は empty と全く同じ
 * that(is_empty(null))->isTrue();
 * that(is_empty(false))->isTrue();
 * that(is_empty(0))->isTrue();
 * that(is_empty(''))->isTrue();
 * // この辺だけが異なる
 * that(is_empty('0'))->isFalse();
 * // 第2引数に true を渡すと空の stdClass も empty 判定される
 * $stdclass = new \stdClass();
 * that(is_empty($stdclass, true))->isTrue();
 * // フィールドがあれば empty ではない
 * $stdclass->hoge = 123;
 * that(is_empty($stdclass, true))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 判定する値
 * @param bool $empty_stdClass 空の stdClass を空とみなすか
 * @return bool 空なら true
 */
function is_empty($var, $empty_stdClass = false)
{
    // object は is_countable 次第
    if (is_object($var)) {
        // が、 stdClass だけは特別扱い（stdClass は継承もできるので、クラス名で判定する（継承していたらそれはもう stdClass ではないと思う））
        if ($empty_stdClass && get_class($var) === 'stdClass') {
            return !(array) $var;
        }
        if (is_countable($var)) {
            return !count($var);
        }
        return false;
    }

    // "0" は false
    if ($var === '0') {
        return false;
    }

    // 上記以外は empty に任せる
    return empty($var);
}
