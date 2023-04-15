<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_stringable.php';
// @codeCoverageIgnoreEnd

/**
 * 値が空なら null を返す
 *
 * `is_empty($value) ? $value : null` とほぼ同じ。
 * 言ってしまえば「falsy な値を null に変換する」とも言える。
 *
 * ここでいう falsy とは php 標準の `empty` ではなく本ライブラリの `is_empty` であることに留意（"0" は空ではない）。
 * さらに利便性のため 0, 0.0 も空ではない判定をする（strpos や array_search などで「0 は意味のある値」という事が多いので）。
 * 乱暴に言えば「仮に文字列化したとき、情報量がゼロ」が falsy になる。
 *
 * - 「 `$var ?: 'default'` で十分なんだけど "0" が…」
 * - 「 `$var ?? 'default'` で十分なんだけど false が…」
 *
 * という状況はまれによくあるはず。
 *
 * ?? との親和性のため null を返す動作がデフォルトだが、そのデフォルト値は引数で渡すこともできる。
 * 用途は Example を参照。
 *
 * Example:
 * ```php
 * // falsy な値は null を返すので null 合体演算子でデフォルト値が得られる
 * that(blank_if(null) ?? 'default')->isSame('default');
 * that(blank_if('')   ?? 'default')->isSame('default');
 * // falsy じゃない値の場合は引数をそのまま返すので null 合体演算子には反応しない
 * that(blank_if(0)   ?? 'default')->isSame(0);   // 0 は空ではない
 * that(blank_if('0') ?? 'default')->isSame('0'); // "0" は空ではない
 * that(blank_if(1)   ?? 'default')->isSame(1);
 * that(blank_if('X') ?? 'default')->isSame('X');
 * // 第2引数で返る値を指定できるので下記も等価となる。ただし、php の仕様上第2引数が必ず評価されるため、関数呼び出しなどだと無駄な処理となる
 * that(blank_if(null, 'default'))->isSame('default');
 * that(blank_if('',   'default'))->isSame('default');
 * that(blank_if(0,    'default'))->isSame(0);
 * that(blank_if('0',  'default'))->isSame('0');
 * that(blank_if(1,    'default'))->isSame(1);
 * that(blank_if('X',  'default'))->isSame('X');
 * // 第2引数の用途は少し短く書けることと演算子の優先順位のつらみの回避程度（`??` は結構優先順位が低い。下記を参照）
 * that(0 < blank_if(null) ?? 1)->isFalse();  // (0 < null) ?? 1 となるので false
 * that(0 < blank_if(null, 1))->isTrue();     // 0 < 1 となるので true
 * that(0 < (blank_if(null) ?? 1))->isTrue(); // ?? で同じことしたいならこのように括弧が必要
 *
 * # ここから下は既存言語機構との比較（愚痴っぽいので読まなくてもよい）
 *
 * // エルビス演算子は "0" にも反応するので正直言って使いづらい（php における falsy の定義は広すぎる）
 * that(null ?: 'default')->isSame('default');
 * that(''   ?: 'default')->isSame('default');
 * that(1    ?: 'default')->isSame(1);
 * that('0'  ?: 'default')->isSame('default'); // こいつが反応してしまう
 * that('X'  ?: 'default')->isSame('X');
 * // 逆に null 合体演算子は null にしか反応しないので微妙に使い勝手が悪い（php の標準関数が false を返したりするし）
 * that(null ?? 'default')->isSame('default'); // こいつしか反応しない
 * that(''   ?? 'default')->isSame('');
 * that(1    ?? 'default')->isSame(1);
 * that('0'  ?? 'default')->isSame('0');
 * that('X'  ?? 'default')->isSame('X');
 * // 恣意的な例だが、 array_search は false も 0 も返し得るので ?: は使えない。 null を返すこともないので ?? も使えない（エラーも吐かない）
 * that(array_search('a', ['a', 'b', 'c']) ?: 'default')->isSame('default'); // 見つかったのに 0 に反応するので 'default' になってしまう
 * that(array_search('x', ['a', 'b', 'c']) ?? 'default')->isSame(false);     // 見つからないので 'default' としたいが false になってしまう
 * // 要するに単に「見つからなかった場合に 'default' としたい」だけなんだが、下記のようにめんどくさいことをせざるを得ない
 * that(array_search('x', ['a', 'b', 'c']) === false ? 'default' : array_search('x', ['a', 'b', 'c']))->isSame('default'); // 3項演算子で2回呼ぶ
 * that(($tmp = array_search('x', ['a', 'b', 'c']) === false) ? 'default' : $tmp)->isSame('default');                      // 一時変数を使用する（あるいは if 文）
 * // このように書きたかった
 * that(blank_if(array_search('x', ['a', 'b', 'c'])) ?? 'default')->isSame('default'); // null 合体演算子版
 * that(blank_if(array_search('x', ['a', 'b', 'c']), 'default'))->isSame('default');   // 第2引数版
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param mixed $var 判定する値
 * @param mixed $default 空だった場合のデフォルト値
 * @return mixed 空なら $default, 空じゃないなら $var をそのまま返す
 */
function blank_if($var, $default = null)
{
    if (is_object($var)) {
        // 文字列化できるかが優先
        if (is_stringable($var)) {
            return strlen($var) ? $var : $default;
        }
        // 次点で countable
        if (is_countable($var)) {
            return count($var) ? $var : $default;
        }
        return $var;
    }

    // 0, 0.0, "0" は false
    if ($var === 0 || $var === 0.0 || $var === '0') {
        return $var;
    }

    // 上記以外は empty に任せる
    return empty($var) ? $default : $var;
}
