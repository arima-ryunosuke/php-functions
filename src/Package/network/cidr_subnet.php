<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * cidr をサブネットに分割する
 *
 *  ipv6 は今のところ未対応。
 *
 * Example:
 * ```php
 * // 192.168.0.0/24 を /26 に分割
 * that(cidr_subnet('192.168.0.0/24', 26))->isSame(['192.168.0.0/26', '192.168.0.64/26', '192.168.0.128/26', '192.168.0.192/26']);
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 */
function cidr_subnet(string $cidr, int $mask): array
{
    [$address, $subnet] = explode('/', trim($cidr), 2) + [1 => 32];

    assert(filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
    assert($subnet <= $mask && $mask <= 32);

    $ip_int = ip2long($address);
    $hosts = 1 << (32 - $mask);
    $subnets = 1 << ($mask - $subnet);

    $results = [];
    for ($i = 0; $i < $subnets; $i++) {
        $network_int = $ip_int + ($i * $hosts);
        $network_str = long2ip($network_int);

        $results[] = "{$network_str}/{$mask}";
    }
    return $results;
}
