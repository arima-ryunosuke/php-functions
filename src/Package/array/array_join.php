<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_pickup.php';
// @codeCoverageIgnoreEnd

/**
 * 配列の SQL 的な JOIN を行う
 *
 * $from に対して $on を満たす $join の行を結合する。
 * $from,$join は共にいわゆる「配列の配列」でなければならない。
 *
 * $on は各レコードが渡ってくるので、true を返せば結合、false を返せば結合されない。
 * $on には配列も渡すことができ、配列を渡した場合は USING 的な動作になる。
 * - キーが駆動表のカラム名、値が結合表のカラム名を表す
 * - キーの値同士を json で判定する（厳密に言えば値を json キーにした一時配列で逆引きされる）
 * - 複数指定時は AND になる
 * 上記の前提・制約が許容できるなら配列指定の方が高速に動作する。
 *
 * join 後のキーは各キーを "+" で連結したものになるが、このキーは暫定的なもの。
 *
 * Example:
 * ```php
 * // t_article と t_comment の JOIN（のイメージ）
 * $articles = [
 *     2 => ['article_id' => 2, 'article_name' => 'hoge'],
 *     4 => ['article_id' => 4, 'article_name' => 'fuga'],
 *     5 => ['article_id' => 5, 'article_name' => 'piyo'],
 * ];
 * $comments = [
 *     4 => ['comment_id' => 4, 'article_id' => 2, 'comment' => 'foo'],
 *     6 => ['comment_id' => 6, 'article_id' => 4, 'comment' => 'bar'],
 *     7 => ['comment_id' => 7, 'article_id' => 4, 'comment' => 'baz'],
 *     9 => ['comment_id' => 9, 'article_id' => 9, 'comment' => 'dmy'],
 * ];
 * // INNER っぽい動き
 * that(array_join($articles, $comments, fn($article, $comment) => $article['article_id'] === $comment['article_id'], false))->isSame([
 *     '2+4' => ['article_id' => 2, 'article_name' => 'hoge', 'comment_id' => 4, 'comment' => 'foo'],
 *     '4+6' => ['article_id' => 4, 'article_name' => 'fuga', 'comment_id' => 6, 'comment' => 'bar'],
 *     '4+7' => ['article_id' => 4, 'article_name' => 'fuga', 'comment_id' => 7, 'comment' => 'baz'],
 * ]);
 * // LEFT っぽい動き
 * that(array_join($articles, $comments, fn($article, $comment) => $article['article_id'] === $comment['article_id'], true))->isSame([
 *     '2+4'    => ['article_id' => 2, 'article_name' => 'hoge', 'comment_id' => 4, 'comment' => 'foo'],
 *     '4+6'    => ['article_id' => 4, 'article_name' => 'fuga', 'comment_id' => 6, 'comment' => 'bar'],
 *     '4+7'    => ['article_id' => 4, 'article_name' => 'fuga', 'comment_id' => 7, 'comment' => 'baz'],
 *     '5+null' => ['article_id' => 5, 'article_name' => 'piyo', 'comment_id' => null, 'comment' => null],
 * ]);
 * // ↑のような単純比較クロージャなら配列でも指定できる（そしてこの方がはるかに速い）
 * that(array_join($articles, $comments, ['article_id' => 'article_id'], false))->isSame([
 *     '2+4' => ['article_id' => 2, 'article_name' => 'hoge', 'comment_id' => 4, 'comment' => 'foo'],
 *     '4+6' => ['article_id' => 4, 'article_name' => 'fuga', 'comment_id' => 6, 'comment' => 'bar'],
 *     '4+7' => ['article_id' => 4, 'article_name' => 'fuga', 'comment_id' => 7, 'comment' => 'baz'],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param array|iterable&\ArrayAccess<\ArrayAccess> $from 駆動表
 * @param array|iterable&\ArrayAccess<\ArrayAccess> $join 結合表
 * @param array|callable $on 結合条件。原則として callable で、ある程度の前提制約が置けるときのみ配列を指定する
 * @param bool $outer true だと OUTER, false だと INNER 的挙動になる
 * @return array JOIN された配列
 */
function array_join($from, $join, $on, bool $outer = false): array
{
    $arraymode = $on && is_array($on) && !is_callable($on);

    if ($arraymode) {
        // なぜ json でキーにするのか？ 個別インデックスや文字結合ではダメなのか？
        // ダメ。null と空文字が区別できない

        $left_cols = array_flip(array_keys($on));
        $right_cols = array_flip(array_values($on));

        // カラム値をキー、元キーを値としたいわゆるインデックスを作成しておく
        $index = [];
        foreach ($join as $j => $right) {
            $rcols = array_pickup($right, $right_cols);
            // 一つでも存在しないならマッチさせない
            if (count($rcols) === count($right_cols)) {
                $index[json_encode($rcols)][] = $j;
            }
        }
    }
    else {
        // 空配列（無条件結合）はこっちに流れてくる
        $on = $on ?: fn() => true;
    }

    // $outer で未結合の時のデフォルト行をあらかじめ作っておく
    if ($outer) {
        $cols = [];
        foreach ($join as $right) {
            $cols += $right;
        }
        $nullrow = array_map(fn() => null, $cols);
    }

    $result = [];
    foreach ($from as $i => $left) {
        $matched_rows = [];

        if ($arraymode) {
            foreach ($index[json_encode(array_pickup($left, $left_cols))] ?? [] as $j) {
                $matched_rows["$i+$j"] = $left + $join[$j];
            }
        }
        else {
            foreach ($join as $j => $right) {
                if ($on($left, $right)) {
                    $matched_rows["$i+$j"] = $left + $right;
                }
            }
        }

        if ($outer && !$matched_rows) {
            $matched_rows["$i+null"] = $left + $nullrow;
        }
        $result += $matched_rows;
    }
    return $result;
}
