<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * IP アドレスを含みうる cidr を返す
 *
 * from, to の大小関係には言及しないので、from > to を与えると空配列を返す。
 *
 * ipv6 は今のところ未対応。
 *
 * Example:
 * ```php
 * that(ip2cidr('192.168.1.1', '192.168.2.64'))->isSame([
 *     '192.168.1.1/32',
 *     '192.168.1.2/31',
 *     '192.168.1.4/30',
 *     '192.168.1.8/29',
 *     '192.168.1.16/28',
 *     '192.168.1.32/27',
 *     '192.168.1.64/26',
 *     '192.168.1.128/25',
 *     '192.168.2.0/26',
 *     '192.168.2.64/32',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 *
 * @param string $fromipaddr ipaddrs
 * @param string $toipaddr ipaddrs
 * @return array cidr
 */
function ip2cidr($fromipaddr, $toipaddr)
{
    if (!filter_var($fromipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        throw new \InvalidArgumentException("ipaddr '$fromipaddr' is invalid.");
    }
    if (!filter_var($toipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        throw new \InvalidArgumentException("ipaddr '$toipaddr' is invalid.");
    }
    $minlong = ip2long($fromipaddr);
    $maxlong = ip2long($toipaddr);

    $bit_length = fn($number) => strlen(ltrim(sprintf('%032b', $number), '0'));

    $result = [];
    for ($long = $minlong; $long <= $maxlong; $long += 1 << $nbits) {
        $current_bits = $bit_length(~$long & ($long - 1));
        $target_bits = $bit_length($maxlong - $long + 1) - 1;
        $nbits = min($current_bits, $target_bits);

        $result[] = long2ip($long) . '/' . (32 - $nbits);
    }
    return $result;
}
