<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * 値を何とかして数値化する
 *
 * - 配列は要素数
 * - int/float はそのまま（ただし $decimal に応じた型にキャストされる）
 * - resource はリソースID（php 標準の int キャスト）
 * - null/bool はその int 値（php 標準の int キャストだが $decimal を見る）
 * - それ以外（文字列・オブジェクト）は文字列表現から数値以外を取り除いたもの
 *
 * 文字列・オブジェクト以外の変換は互換性を考慮しない。頻繁に変更される可能性がある（特に配列）。
 *
 * -記号は受け入れるが+記号は受け入れない。
 *
 * Example:
 * ```php
 * // 配列は要素数となる
 * that(numberify([1, 2, 3]))->isSame(3);
 * // int/float は基本的にそのまま
 * that(numberify(123))->isSame(123);
 * that(numberify(123.45))->isSame(123);
 * that(numberify(123.45, true))->isSame(123.45);
 * // 文字列は数値抽出
 * that(numberify('a1b2c3'))->isSame(123);
 * that(numberify('a1b2.c3', true))->isSame(12.3);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 対象の値
 * @param bool $decimal 小数として扱うか
 * @return int|float 数値化した値
 */
function numberify($var, $decimal = false)
{
    // resource はその int 値を返す
    if (is_resourcable($var)) {
        return (int) $var;
    }

    // 配列は要素数を返す・・・が、$decimal を見るので後段へフォールスルー
    if (is_array($var)) {
        $var = count($var);
    }
    // null/bool はその int 値を返す・・・が、$decimal を見るので後段へフォールスルー
    if ($var === null || $var === false || $var === true) {
        $var = (int) $var;
    }

    // int はそのまま返す・・・と言いたいところだが $decimal をみてキャストして返す
    if (is_int($var)) {
        if ($decimal) {
            $var = (float) $var;
        }
        return $var;
    }
    // float はそのまま返す・・・と言いたいところだが $decimal をみてキャストして返す
    if (is_float($var)) {
        if (!$decimal) {
            $var = (int) $var;
        }
        return $var;
    }

    // 上記以外は文字列として扱い、数値のみでフィルタする（__toString 未実装は標準に任せる。多分 fatal error）
    $number = preg_replace("#[^-.0-9]#u", '', $var);

    // 正規表現レベルでチェックもできそうだけど大変な匂いがするので is_numeric に日和る
    if (!is_numeric($number)) {
        throw new \UnexpectedValueException("$var to $number, this is not numeric.");
    }

    if ($decimal) {
        return (float) $number;
    }
    return (int) $number;
}
