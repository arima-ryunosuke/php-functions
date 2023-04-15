<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/cidr_parse.php';
// @codeCoverageIgnoreEnd

/**
 * cidr 内の IP アドレスを返す
 *
 * すべての IP アドレスを返すため、`/1` のような極端な値を投げてはならない。
 * （Generator の方がいいかもしれない）。
 *
 * ipv6 は今のところ未対応。
 *
 * Example:
 * ```php
 * that(cidr2ip('192.168.0.0/30'))->isSame(['192.168.0.0', '192.168.0.1', '192.168.0.2', '192.168.0.3']);
 * that(cidr2ip('192.168.0.255/30'))->isSame(['192.168.0.252', '192.168.0.253', '192.168.0.254', '192.168.0.255']);
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 *
 * @param string $cidr cidr
 * @return array IP アドレス
 */
function cidr2ip($cidr)
{
    [$prefix, , $mask] = cidr_parse($cidr);

    $prefix = ip2long($prefix) >> $mask << $mask;

    $result = [];
    for ($i = 0, $l = 1 << $mask; $i < $l; $i++) {
        $result[] = long2ip($prefix + $i);
    }
    return $result;
}
