<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * stdClass を生成して返す
 *
 * object キャストとほとんど同じだが、名前付き可変引数を採用しているので JSON ライクに宣言することができる。
 * その代わり数値キー等の php の識別子として不正なキーを生やすことはできない。
 * （厳密に言えば名前付き引数を使わなければ数値キーは生成できるが…そんなことをするなら普通に object キャストをすればよい）。
 *
 * Example:
 * ```php
 * // 名前付き可変引数でコールできる
 * that(stdclass(a: 1, b: 2))->isInstanceOf(\stdClass::class);
 * // iterable も渡せる（この場合は実質的に object キャストと同義）
 * that(stdclass(...['a' => 1, 'b' => 2]))->isInstanceOf(\stdClass::class);
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param mixed ...$fields メンバー配列
 * @return \stdClass stdClass
 */
function stdclass(...$fields): \stdClass
{
    return (object) $fields;
}
