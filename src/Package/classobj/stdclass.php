<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 初期フィールド値を与えて stdClass を生成する
 *
 * 手元にある配列でサクッと stdClass を作りたいことがまれによくあるはず。
 *
 * object キャストでもいいんだが、 Iterator/Traversable とかも stdClass 化したいかもしれない。
 * それにキャストだとコールバックで呼べなかったり、数値キーが死んだりして微妙に使いづらいところがある。
 *
 * Example:
 * ```php
 * // 基本的には object キャストと同じ
 * $fields = ['a' => 'A', 'b' => 'B'];
 * that(stdclass($fields))->is((object) $fields);
 * // ただしこういうことはキャストでは出来ない
 * that(array_map('stdclass', [$fields]))->is([(object) $fields]); // コールバックとして利用する
 * that(property_exists(stdclass(['a', 'b']), '0'))->isTrue();     // 数値キー付きオブジェクトにする
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param iterable $fields フィールド配列
 * @return \stdClass 生成した stdClass インスタンス
 */
function stdclass(iterable $fields = [])
{
    $stdclass = new \stdClass();
    foreach ($fields as $key => $value) {
        $stdclass->$key = $value;
    }
    return $stdclass;
}
