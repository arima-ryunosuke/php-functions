<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * cidr を分割する
 *
 * ※ 内部向け
 *
 * @package ryunosuke\Functions\Package\network
 *
 * @param string $cidr
 * @return array [$address, $networkBit, $localBit]
 */
function cidr_parse($cidr)
{
    [$address, $subnet] = explode('/', trim($cidr), 2) + [1 => 32];

    if (!filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        throw new \InvalidArgumentException("subnet addr '$address' is invalid.");
    }
    if (!(ctype_digit("$subnet") && (0 <= $subnet && $subnet <= 32))) {
        throw new \InvalidArgumentException("subnet mask '$subnet' is invalid.");
    }

    $subnet = (int) $subnet;
    return [$address, $subnet, 32 - $subnet];
}
