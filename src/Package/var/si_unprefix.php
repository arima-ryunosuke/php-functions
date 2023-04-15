<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/numval.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * SI 接頭辞が付与された文字列を数値化する
 *
 * 典型的な用途は ini_get で得られた値を数値化したいとき。
 * ただし、 ini は 1m のように小文字で指定することもあるので大文字化する必要はある。
 *
 * Example:
 * ```php
 * // 1k = 1000
 * that(si_unprefix('1k'))->isSame(1000);
 * // 1k = 1024
 * that(si_unprefix('1k', 1024))->isSame(1024);
 * // m はメガではなくミリ
 * that(si_unprefix('1m'))->isSame(0.001);
 * // M がメガ
 * that(si_unprefix('1M'))->isSame(1000000);
 * // K だけは特別扱いで大文字小文字のどちらでもキロになる
 * that(si_unprefix('1K'))->isSame(1000);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 数値化する値
 * @param int $unit 桁単位。実用上は 1000, 1024 の2値しか指定することはないはず
 * @return int|float SI 接頭辞を取り払った実際の数値
 */
function si_unprefix($var, $unit = 1000)
{
    assert($unit > 0);

    $var = trim($var);

    foreach (SI_UNITS as $exp => $sis) {
        foreach ($sis as $si) {
            if (strpos($var, $si) === (strlen($var) - strlen($si))) {
                return numval($var) * pow($unit, $exp);
            }
        }
    }

    return numval($var);
}
