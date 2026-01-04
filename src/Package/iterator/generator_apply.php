<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * generator 専用の iterator_apply
 *
 * iterator_apply は正直言って意味が分からない。
 * - true を返さなければならない（仮に打ち切りのためだとしても普通は false 返しでは…？ これのせいでアロー関数がほぼ使えない）
 * - 引数に渡ってこない（第3引数で自身を渡しながら中で $it->current する必要がある）
 * - 返り値が要素数（と、マニュアルは言っているが実際は処理数）
 *
 * ので iterator_apply は多分使うことはないが、こと generator に関しては明確に返り値を持つため、回し切りつつ返り値が欲しい、という限定的な状況がある。
 * その時、count や蓄積配列も得られると便利ではある（generator は一度回すともう回せないため）。
 * この関数はそんなときに使う。
 *
 * 特筆すべき挙動して、回しきった generator を渡してもエラーにはならず、単に返り値を返すのみとなる（$receiver, $count も空）。
 * この関数は「generator の返り値を雑に得たい」が初期の目的だったためそのようになっている。
 * （回っている・回っていないを意識せず返り値が得たかった）。
 * この挙動は将来的に変更される可能性がある。
 *
 * $callback が非 null を返すと $receiver に蓄積される。
 * これは無条件で蓄積したら generator の旨味がなくなってしまうため（全部蓄積するならもう iterator_to_array した方が手っ取り早い）。
 * キーは格納されないため注意（generator のキーは連想配列のキーになれるとは限らないため）。
 *
 * $callback の返り値に関わらず $count には処理数が格納される。
 *
 * 要するに
 * - generator を回しつつ
 * - 必要ならば蓄積して
 * - 数も数えて
 * - generator の返り値を返す
 * ということを同時に行う。
 *
 * Example:
 * ```php
 * $g = (function () {
 *     yield 1;
 *     yield 2;
 *     yield 3;
 *     yield 4;
 *     yield 5;
 *     yield 6;
 *     yield 7;
 *     yield 8;
 *     yield 9;
 *     return 99;
 * })();
 *
 * $return = generator_apply($g, fn ($v) => $v % 2 == 0 ? $v : null, $receiver, $count);
 *
 * // generator の返り値を返す
 * that($return)->isSame(99);
 * // 偶数のみが格納される
 * that($receiver)->isSame([2, 4, 6, 8]);
 * // ループ数が格納される
 * that($count)->isSame(9);
 *
 * // もう一回読んでもエラーにはならない
 * $return = generator_apply($g, fn ($v) => $v % 2 == 0 ? $v : null, $receiver, $count);
 * // 返り値は正常に得られる
 * that($return)->isSame(99);
 * // receiver は格納されない（もう回せないため）
 * that($receiver)->isSame(null);
 * // count は格納されない（もう回せないため）
 * that($count)->isSame(null);
 * ```
 *
 * @package ryunosuke\Functions\Package\iterator
 */
function generator_apply(
    /** 対象 Generator */ \Generator $generator,
    /** 実行コールバック */ callable $callback,
    /** 蓄積配列 */ ?array &$receiver = null,
    /** ループ数 */ ?int &$count = null,
) {
    $receiver = null;
    $count = null;
    if ($generator->valid()) {
        $receiver = [];
        $count = 0;
        foreach ($generator as $k => $v) {
            $return = $callback($v, $k, $count++);
            if ($return !== null) {
                $receiver[] = $return;
            }
        }
    }
    return $generator->getReturn();
}
