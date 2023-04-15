<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * 数値に SI 接頭辞を付与する
 *
 * 値は 1 <= $var < 1000(1024) の範囲内に収められる。
 * ヨクト（10^24）～ヨタ（1024）まで。整数だとしても 64bit の範囲を超えるような値の精度は保証しない。
 *
 * Example:
 * ```php
 * // シンプルに k をつける
 * that(si_prefix(12345))->isSame('12.345 k');
 * // シンプルに m をつける
 * that(si_prefix(0.012345))->isSame('12.345 m');
 * // 書式フォーマットを指定できる
 * that(si_prefix(12345, 1000, '%d%s'))->isSame('12k');
 * that(si_prefix(0.012345, 1000, '%d%s'))->isSame('12m');
 * // ファイルサイズを byte で表示する
 * that(si_prefix(12345, 1000, '%d %sbyte'))->isSame('12 kbyte');
 * // ファイルサイズを byte で表示する（1024）
 * that(si_prefix(10240, 1024, '%.3f %sbyte'))->isSame('10.000 kbyte');
 * // フォーマットに null を与えると sprintf せずに配列で返す
 * that(si_prefix(12345, 1000, null))->isSame([12.345, 'k']);
 * // フォーマットにクロージャを与えると実行して返す
 * that(si_prefix(12345, 1000, fn($v, $u) => number_format($v, 2) . $u))->isSame('12.35k');
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 丸める値
 * @param int $unit 桁単位。実用上は 1000, 1024 の2値しか指定することはないはず
 * @param string|\Closure $format 書式フォーマット。 null を与えると sprintf せずに配列で返す
 * @return string|array 丸めた数値と SI 接頭辞で sprintf した文字列（$format が null の場合は配列）
 */
function si_prefix($var, $unit = 1000, $format = '%.3f %s')
{
    assert($unit > 0);

    $result = function ($format, $var, $unit) {
        if ($format instanceof \Closure) {
            return $format($var, $unit);
        }
        if ($format === null) {
            return [$var, $unit];
        }
        return sprintf($format, $var, $unit);
    };

    if ($var == 0) {
        return $result($format, $var, '');
    }

    $original = $var;
    $var = abs($var);
    $n = 0;
    while (!(1 <= $var && $var < $unit)) {
        if ($var < 1) {
            $n--;
            $var *= $unit;
        }
        else {
            $n++;
            $var /= $unit;
        }
    }
    if (!isset(SI_UNITS[$n])) {
        throw new \InvalidArgumentException("$original is too large or small ($n).");
    }
    return $result($format, ($original > 0 ? 1 : -1) * $var, SI_UNITS[$n][0] ?? '');
}
