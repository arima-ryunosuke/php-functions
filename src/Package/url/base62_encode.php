<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../math/base_convert_array.php';
// @codeCoverageIgnoreEnd

/**
 * 数値とアルファベットで base62 エンコードする
 *
 * あくまでエンコードであって引数は文字列として扱う。つまり数値の基数変換ではない。
 *
 * base64 と違い、下記の特徴がある。
 * - =パディングなし
 * - 記号が入らない（完全に URL セーフ）
 * - ASCII 順（元の推移律が維持される）
 *
 * 変換効率もあまり変わらないため、文字列が小さい間はほぼ base64_encode の上位互換に近い。
 * ただし gmp が入っていないと猛烈に遅い。
 *
 * Example:
 * ```php
 * that(base62_encode('abcdefg'))->isSame('21XiSSifQN');
 * that(base62_decode('21XiSSifQN'))->isSame('abcdefg');
 * ```
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param string $string 変換元文字列
 * @return string base62 文字列
 */
function base62_encode($string)
{
    // あくまで数値として扱うので先頭の 0 は吹き飛んでしまう
    $zeropos = strspn($string, "\0");
    $zeroprefix = str_repeat("0", $zeropos);
    $string = substr($string, $zeropos);

    // php<8.2 の str_split は [""] を返すし gmp が扱うのはあくまで数値なので空文字は特別扱いとする
    if (!strlen($string)) {
        return $zeroprefix;
    }

    // 隠し第2引数が false の場合は gmp を使わない（ロジックのテスト用なので実運用で渡してはならない）
    if (extension_loaded('gmp') && !(func_num_args() === 2 && func_get_arg(1) === false)) {
        return $zeroprefix . gmp_strval(gmp_import($string), 62);
    }

    static $basechars_index = null;
    $basechars_index ??= str_split('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');

    $chars = str_split($string);
    $bytes = array_map('ord', $chars);
    $base62 = base_convert_array($bytes, 256, 62);
    return $zeroprefix . implode('', array_map(fn($v) => $basechars_index[$v], $base62));
}
