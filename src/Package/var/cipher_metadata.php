<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 暗号化アルゴリズムのメタデータを返す
 *
 * ※ 内部向け
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param string $cipher 暗号化方式（openssl_get_cipher_methods で得られるもの）
 * @return array 暗号化アルゴリズムのメタデータ
 */
function cipher_metadata($cipher)
{
    static $cache = [];

    $cipher = strtolower($cipher);

    if (!in_array($cipher, openssl_get_cipher_methods())) {
        return [];
    }

    if (isset($cache[$cipher])) {
        return $cache[$cipher];
    }

    $ivlen = openssl_cipher_iv_length($cipher);
    @openssl_encrypt('dummy', $cipher, 'password', 0, str_repeat('x', $ivlen), $tag);
    return $cache[$cipher] = [
        'ivlen'  => $ivlen,
        'taglen' => strlen($tag ?? ''),
    ];
}
