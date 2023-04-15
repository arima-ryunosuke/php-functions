<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../network/cidr_parse.php';
// @codeCoverageIgnoreEnd

/**
 * ipv4 の cidr チェック
 *
 * $ipaddr が $cidr のレンジ内なら true を返す。
 * $cidr は複数与えることができ、どれかに合致したら true を返す。
 *
 * ipv6 は今のところ未対応。
 *
 * Example:
 * ```php
 * // 範囲内なので true
 * that(incidr('192.168.1.1', '192.168.1.0/24'))->isTrue();
 * // 範囲外なので false
 * that(incidr('192.168.1.1', '192.168.2.0/24'))->isFalse();
 * // 1つでも範囲内なら true
 * that(incidr('192.168.1.1', ['192.168.1.0/24', '192.168.2.0/24']))->isTrue();
 * // 全部範囲外なら false
 * that(incidr('192.168.1.1', ['192.168.2.0/24', '192.168.3.0/24']))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 *
 * @param string $ipaddr 調べられる IP/cidr アドレス
 * @param string|array $cidr 調べる cidr アドレス
 * @return bool $ipaddr が $cidr 内なら true
 */
function incidr($ipaddr, $cidr)
{
    [$ipaddr, , $ipmask] = cidr_parse($ipaddr);

    $iplong = ip2long($ipaddr);

    foreach (arrayize($cidr) as $cidr) {
        [$netaddress, , $netmask] = cidr_parse($cidr);

        if ($ipmask > $netmask) {
            continue;
        }

        if ((ip2long($netaddress) >> $netmask) == ($iplong >> $netmask)) {
            return true;
        }
    }
    return false;
}
