<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * N-gram 化して配列で返す
 *
 * 素朴な実装であり特記事項はない。
 * 末端要素や除去フィルタくらいは実装するかもしれない。
 *
 * Example:
 * ```php
 * that(ngram("あいうえお", 1))->isSame(["あ", "い", "う", "え", "お"]);
 * that(ngram("あいうえお", 2))->isSame(["あい", "いう", "うえ", "えお", "お"]);
 * that(ngram("あいうえお", 3))->isSame(["あいう", "いうえ", "うえお", "えお", "お"]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param int $N N-gram の N
 * @param string $encoding マルチバイトエンコーディング
 * @return array N-gram 配列
 */
function ngram($string, $N, $encoding = 'UTF-8')
{
    if (func_num_args() < 3) {
        $encoding = mb_internal_encoding();
    }

    $chars = mb_str_split($string, 1, $encoding);

    $result = [];
    foreach ($chars as $i => $char) {
        $result[] = implode('', array_slice($chars, $i, $N));
    }
    return $result;
}
