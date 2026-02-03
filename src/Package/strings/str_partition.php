<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/multiexplode.php';
// @codeCoverageIgnoreEnd

/**
 * 文字列をトークンで分割して後ろ優先で詰めて返す
 *
 * 非常にしばしば下記のような必要性に出くわす。
 * - "namespace\\classname" => ["namespace", "classname"]
 * - "classname"            => ["", "classname"]
 * - "table.column"         => ["table", "column"]
 * - "column"               => ["", "column"]
 *
 * つまり「修飾子的なものがあってもなくてもよい（あるなら修飾子も得たい）」ケース。
 * explode+array_pad で一発で書けるんだが、ややややこしいし煩雑なので関数化した。
 *
 * それだけだとつまらないので $require_count の負数の特殊化も加えてある。
 * 負数を与えると要素が $require_count に一致しなかったときの挙動が前詰めになる。
 *
 * 分かりづらいが、端的に
 * - 必ず $require_count 個の配列を返す。その上で・・・
 *   - 正数の場合は「必要そうなもの」が右に来る
 *   - 負数の場合は「必要そうなもの」が左に来る
 * というだけ。
 *
 * Example:
 * ```php
 * // 0 の場合は常に空配列を返す
 * that(str_partition('a.b.c.d', '.', 0))->isSame([]);
 *
 * // 正数は右に必要そうなものが来る（不必要≒溢れた null や足りなかったので分割されなかった文字）
 * that(str_partition('a.b.c.d', '.', 1))->isSame(["a.b.c.d"]);
 * that(str_partition('a.b.c.d', '.', 2))->isSame(["a.b.c", "d"]);
 * that(str_partition('a.b.c.d', '.', 3))->isSame(["a.b", "c", "d"]);
 * that(str_partition('a.b.c.d', '.', 4))->isSame(["a", "b", "c", "d"]);
 * that(str_partition('a.b.c.d', '.', 5))->isSame([null, "a", "b", "c", "d"]);
 *
 * // 負数は左に必要そうなものが来る（不必要≒溢れた null や足りなかったので分割されなかった文字）
 * that(str_partition('a.b.c.d', '.', -1))->isSame(["a.b.c.d"]);
 * that(str_partition('a.b.c.d', '.', -2))->isSame(["a", "b.c.d"]);
 * that(str_partition('a.b.c.d', '.', -3))->isSame(["a", "b", "c.d"]);
 * that(str_partition('a.b.c.d', '.', -4))->isSame(["a", "b", "c", "d"]);
 * that(str_partition('a.b.c.d', '.', -5))->isSame(["a", "b", "c", "d", null]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 */
function str_partition(
    /** 対象文字列 */ string                $string,
    /** セパレータ */ string                $separator,
    /** 最終的に欲しい数 */ int             $require_count,
    /** 満たない場合のデフォルト値 */ mixed $default = null,
): array {
    // 0 で呼ばれることはほぼないが、仕様としては「何があろうと $require_count 個の配列を返す」としているので 0 の時は空配列を返さないと整合性が取れない
    if ($require_count === 0) {
        return [];
    }

    return array_pad(multiexplode($separator, $string, -$require_count), -$require_count, $default);
}
