<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../math/base_convert_array.php';
require_once __DIR__ . '/../syntax/throws.php';
// @codeCoverageIgnoreEnd

/**
 * 数値とアルファベットで base62 デコードする
 *
 * 対で使うと思うので base62_encode を参照。
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param string $string base62 文字列
 * @return string 変換元文字列
 */
function base62_decode($string)
{
    // あくまで数値として扱うので先頭の 0 は吹き飛んでしまう
    $zeropos = strspn($string, "0");
    $zeroprefix = str_repeat("\0", $zeropos);
    $string = substr($string, $zeropos);

    // php<8.2 の str_split は [""] を返すし gmp が扱うのはあくまで数値なので空文字は特別扱いとする
    if (!strlen($string)) {
        return $zeroprefix;
    }

    // 隠し第2引数が false の場合は gmp を使わない（ロジックのテスト用なので実運用で渡してはならない）
    if (extension_loaded('gmp') && !(func_num_args() === 2 && func_get_arg(1) === false)) {
        return $zeroprefix . gmp_export(gmp_init($string, 62));
    }

    static $basechars_assoc = null;
    $basechars_assoc ??= array_flip(str_split('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'));

    $chars = str_split($string);
    $base62 = array_map(fn($c) => $basechars_assoc[$c] ?? throws(new \InvalidArgumentException("string is not an base62")), $chars);
    $bytes = base_convert_array($base62, 62, 256);
    return $zeroprefix . implode('', array_map('chr', $bytes));
}
