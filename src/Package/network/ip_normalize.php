<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/strdec.php';
// @codeCoverageIgnoreEnd

/**
 * IP アドレスを正規化する
 *
 * IPv4 は（あまり有名ではないが）4 オクテット未満や 16,8 進数表記を標準的な 1.2.3.4 形式に正規化する。
 * IPv6 は 0 の省略や :: 短縮表記を完全表記の 1111:2222:3333:4444:5555:6666:7777:8888 形式に正規化する。
 * 完全におかしな形式については例外を投げる。
 *
 * Example:
 * ```php
 * // v4（RFC はないがこのような記法が許されている）
 * that(ip_normalize('0xff.077.500'))->isSame('255.63.1.244');
 * // v6（RFC 5952 の短縮表記を完全表記にする）
 * that(ip_normalize('a::f'))->isSame('000a:0000:0000:0000:0000:0000:0000:000f');
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 */
function ip_normalize(string $ipaddr)
{
    // v6 の RFC 5952 短縮表記は filter_var を通るので分岐できる
    if (filter_var($ipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        $colon = substr_count($ipaddr, ':');
        $ipaddr = strtr($ipaddr, ['::' => ':' . implode(':', array_pad([], 8 - $colon, '0000')) . ':']);
        $segments = explode(':', $ipaddr);
        foreach ($segments as $n => $segment) {
            $segment = strtolower($segment);
            $segment = str_pad($segment, 4, '0', STR_PAD_LEFT);
            $segments[$n] = $segment;
        }
        return implode(':', $segments);
    }

    $divmod = function (&$n, $d) {
        $div = intdiv($n, $d);
        $n = $n % $d;
        return $div;
    };

    // 通らない場合は v4 試行だが、様々な形式があるので最後にチェックする
    $octets = explode('.', $ipaddr);
    $length = count($octets);
    // が、1オクテットの場合は完全に処理が異なる
    if ($length === 1) {
        $int = strdec($octets[0]);
        if (0 > $int || $int > 0xFFFFFFFF) {
            throw new \InvalidArgumentException("$ipaddr is invalid ip address(too large)");
        }
        return long2ip($int);
    }
    elseif ($length === 2) {
        $int = strdec($octets[1]);
        $octets[1] = $divmod($int, 0x10000);
        $octets[2] = $divmod($int, 0x00100);
        $octets[3] = $divmod($int, 0x00001);
    }
    elseif ($length === 3) {
        $int = strdec($octets[2]);
        $octets[2] = $divmod($int, 0x00100);
        $octets[3] = $divmod($int, 0x00001);
    }
    elseif ($length === 4) {
        // do nothing
    }
    else {
        throw new \InvalidArgumentException("$ipaddr is invalid ip address(many octet)");
    }

    $octets = array_map(fn($v) => strdec($v), $octets);

    $ipaddr = implode('.', $octets);
    if (!filter_var($ipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        throw new \InvalidArgumentException("$ipaddr is invalid ip address");
    }
    return $ipaddr;
}
