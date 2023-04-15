<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../utility/cache.php';
// @codeCoverageIgnoreEnd

/**
 * 接続元となる IP を返す
 *
 * IP を指定してそこへ接続する際の SourceIP を返す（省略すると最初のエントリを返す）。
 * 複数のネットワークにマッチした場合の結果は不定（最長が無難だろうがそもそも SourceIP がどうなるかが不定）。
 *
 * Example:
 * ```php
 * // 何らかの IP アドレスが返ってくる
 * that(getipaddress())->isValidIpv4();
 * // 自分への接続元は自分なので 127.0.0.1 を返す
 * that(getipaddress('127.0.0.9'))->isSame('127.0.0.1');
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 *
 * @param string|int|null $target 接続先
 * @return ?string IP アドレス
 */
function getipaddress($target = null)
{
    $net_get_interfaces = cache("net_get_interfaces", fn() => net_get_interfaces(), __FUNCTION__);

    // int, null 時は最初のエントリを返す（ループバックは除く）
    if ($target === null || is_int($target)) {
        $target ??= AF_INET;
        unset($net_get_interfaces['lo']);
        foreach ($net_get_interfaces as $interface) {
            foreach ($interface['unicast'] as $unicast) {
                if ($unicast['family'] === $target) {
                    return $unicast['address'];
                }
            }
        }
        return null;
    }

    if (filter_var($target, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
        $family = AF_INET;
    }
    elseif (filter_var($target, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
        $family = AF_INET6;
    }
    else {
        throw new \InvalidArgumentException("$target is invalid ip address");
    }

    $targetBytes = unpack('C*', inet_pton($target));

    foreach ($net_get_interfaces as $interface) {
        foreach ($interface['unicast'] as $unicast) {
            if ($unicast['family'] === $family) {
                $addressBytes = unpack('C*', inet_pton($unicast['address']));
                $netmaskBytes = unpack('C*', inet_pton($unicast['netmask']));
                foreach ($netmaskBytes as $i => $netmaskByte) {
                    if (($addressBytes[$i] & $netmaskByte) !== ($targetBytes[$i] & $netmaskByte)) {
                        continue 2;
                    }
                }
                return $unicast['address'];
            }
        }
    }
    return null;
}
