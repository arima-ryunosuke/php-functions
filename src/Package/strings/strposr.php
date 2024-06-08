<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * デフォで左探索な strrpos
 *
 * 個人的に strrpos の offset の挙動が分かりにくい。
 * - offset>=0: 先頭から offset スキップ＋**右探索**
 * - offset< 0: 末尾から -offset スキップ＋**左探索**
 *
 * r と銘打っているんだから offset に依らずにデフォで左探索して欲しい。
 * 特に offset 未指定だと 0 なので「先頭から末尾まで読んで最後に見つかった場所を返す」という非常に非効率的なことになっている（実際の実装は違うようだけど）。
 * さらに「単純に50文字目から左探索したい」だけなのに offset が気持ち悪いことになる（50 - strlen($string)）。
 * 要するに https://www.php.net/manual/ja/function.strrpos.php#76447 これ。
 *
 * offset で検索文字列の途中に飛び込んだ場合は見つからないとみなす（strrpos は見つかったとみなす）。
 * この挙動は説明しにくいので Example を参照。
 *
 * Example:
 * ```php
 * //        +0123456789A1234567
 * //        -7654321A9876543210
 * $string = 'hello hello hello';
 *
 * // offset を省略すると末尾から左探索になる
 * that(strposr($string, 'hello'))->isSame(12);
 * // 標準の文字列関数のように負数で後ろからの探索になる
 * that(strposr($string, 'hello', -1))->isSame(6);
 * // 0文字目から左探索しても見つからない
 * that(strposr($string, 'hello', 0))->isSame(false);
 * // 5文字目から左探索すれば0文字目が引っかかる
 * that(strposr($string, 'hello', 5))->isSame(0);
 * // 13文字目から左探索すれば6文字目が引っかかる（13文字目は3個目の hello の途中なので2個目の hello から引っかかる）
 * that(strposr($string, 'hello', 13))->isSame(6);
 * // この動作は strrpos だと異なる（途中文字列も拾ってしまう）
 * that(strrpos($string, 'hello', -4))->isSame(12);
 * // そもそも strrpos は負数指定しないと右探索なので使いにくくてしょうがない
 * that(strrpos($string, 'hello', 5))->isSame(12);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $haystack 対象文字列
 * @param string $needle 位置を取得したい文字列
 * @param ?int $offset 開始位置。 null を渡すと末尾からの探索になる
 * @return int|false 見つかった位置
 */
function strposr(string $haystack, string $needle, ?int $offset = null): int|false
{
    $offset ??= strlen($haystack);

    if ($offset < 0) {
        $offset += strlen($haystack);
    }

    if (strlen($haystack) < $offset) {
        throw new \ValueError('strposr(): Argument #3 ($offset) must be contained in argument #1 ($haystack)');
    }

    $result = strrpos($haystack, $needle, $offset - strlen($haystack));
    // 仮に見つかってもオフセットを跨いでる場合は -1 して再検索
    if ($result !== false && $result + strlen($needle) > $offset) {
        // が、先頭文字の場合は -1 する意味もない（そもそもエラーになる）ので false で返してしまってよい
        if ($result === 0) {
            return false;
        }
        return strrpos($haystack, $needle, $result - 1 - strlen($haystack));
    }
    return $result;
}
