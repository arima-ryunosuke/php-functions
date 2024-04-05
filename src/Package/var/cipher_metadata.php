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

    // var_export(array_reduce(openssl_get_cipher_methods(), fn($carry, $item) => $carry + [$item => @openssl_cipher_key_length($item)], []));
    $keylens = [
        'aes-128-cbc'             => 16,
        'aes-128-cbc-cts'         => false,
        'aes-128-cbc-hmac-sha1'   => 16,
        'aes-128-cbc-hmac-sha256' => 16,
        'aes-128-ccm'             => 16,
        'aes-128-cfb'             => 16,
        'aes-128-cfb1'            => 16,
        'aes-128-cfb8'            => 16,
        'aes-128-ctr'             => 16,
        'aes-128-ecb'             => 16,
        'aes-128-gcm'             => 16,
        'aes-128-ocb'             => 16,
        'aes-128-ofb'             => 16,
        'aes-128-siv'             => false,
        'aes-128-wrap'            => 16,
        'aes-128-wrap-inv'        => false,
        'aes-128-wrap-pad'        => 16,
        'aes-128-wrap-pad-inv'    => false,
        'aes-128-xts'             => 32,
        'aes-192-cbc'             => 24,
        'aes-192-cbc-cts'         => false,
        'aes-192-ccm'             => 24,
        'aes-192-cfb'             => 24,
        'aes-192-cfb1'            => 24,
        'aes-192-cfb8'            => 24,
        'aes-192-ctr'             => 24,
        'aes-192-ecb'             => 24,
        'aes-192-gcm'             => 24,
        'aes-192-ocb'             => 24,
        'aes-192-ofb'             => 24,
        'aes-192-siv'             => false,
        'aes-192-wrap'            => 24,
        'aes-192-wrap-inv'        => false,
        'aes-192-wrap-pad'        => 24,
        'aes-192-wrap-pad-inv'    => false,
        'aes-256-cbc'             => 32,
        'aes-256-cbc-cts'         => false,
        'aes-256-cbc-hmac-sha1'   => 32,
        'aes-256-cbc-hmac-sha256' => 32,
        'aes-256-ccm'             => 32,
        'aes-256-cfb'             => 32,
        'aes-256-cfb1'            => 32,
        'aes-256-cfb8'            => 32,
        'aes-256-ctr'             => 32,
        'aes-256-ecb'             => 32,
        'aes-256-gcm'             => 32,
        'aes-256-ocb'             => 32,
        'aes-256-ofb'             => 32,
        'aes-256-siv'             => false,
        'aes-256-wrap'            => 32,
        'aes-256-wrap-inv'        => false,
        'aes-256-wrap-pad'        => 32,
        'aes-256-wrap-pad-inv'    => false,
        'aes-256-xts'             => 64,
        'aria-128-cbc'            => 16,
        'aria-128-ccm'            => 16,
        'aria-128-cfb'            => 16,
        'aria-128-cfb1'           => 16,
        'aria-128-cfb8'           => 16,
        'aria-128-ctr'            => 16,
        'aria-128-ecb'            => 16,
        'aria-128-gcm'            => 16,
        'aria-128-ofb'            => 16,
        'aria-192-cbc'            => 24,
        'aria-192-ccm'            => 24,
        'aria-192-cfb'            => 24,
        'aria-192-cfb1'           => 24,
        'aria-192-cfb8'           => 24,
        'aria-192-ctr'            => 24,
        'aria-192-ecb'            => 24,
        'aria-192-gcm'            => 24,
        'aria-192-ofb'            => 24,
        'aria-256-cbc'            => 32,
        'aria-256-ccm'            => 32,
        'aria-256-cfb'            => 32,
        'aria-256-cfb1'           => 32,
        'aria-256-cfb8'           => 32,
        'aria-256-ctr'            => 32,
        'aria-256-ecb'            => 32,
        'aria-256-gcm'            => 32,
        'aria-256-ofb'            => 32,
        'camellia-128-cbc'        => 16,
        'camellia-128-cbc-cts'    => false,
        'camellia-128-cfb'        => 16,
        'camellia-128-cfb1'       => 16,
        'camellia-128-cfb8'       => 16,
        'camellia-128-ctr'        => 16,
        'camellia-128-ecb'        => 16,
        'camellia-128-ofb'        => 16,
        'camellia-192-cbc'        => 24,
        'camellia-192-cbc-cts'    => false,
        'camellia-192-cfb'        => 24,
        'camellia-192-cfb1'       => 24,
        'camellia-192-cfb8'       => 24,
        'camellia-192-ctr'        => 24,
        'camellia-192-ecb'        => 24,
        'camellia-192-ofb'        => 24,
        'camellia-256-cbc'        => 32,
        'camellia-256-cbc-cts'    => false,
        'camellia-256-cfb'        => 32,
        'camellia-256-cfb1'       => 32,
        'camellia-256-cfb8'       => 32,
        'camellia-256-ctr'        => 32,
        'camellia-256-ecb'        => 32,
        'camellia-256-ofb'        => 32,
        'chacha20'                => 32,
        'chacha20-poly1305'       => 32,
        'des-ede-cbc'             => 16,
        'des-ede-cfb'             => 16,
        'des-ede-ecb'             => 16,
        'des-ede-ofb'             => 16,
        'des-ede3-cbc'            => 24,
        'des-ede3-cfb'            => 24,
        'des-ede3-cfb1'           => 24,
        'des-ede3-cfb8'           => 24,
        'des-ede3-ecb'            => 24,
        'des-ede3-ofb'            => 24,
        'des3-wrap'               => 24,
        'null'                    => false,
    ];

    $ivlen = openssl_cipher_iv_length($cipher);
    @openssl_encrypt('dummy', $cipher, 'password', 0, str_repeat('x', $ivlen), $tag);
    return $cache[$cipher] = [
        'keylen' => intval($keylens[$cipher] ?? 0),
        'ivlen'  => $ivlen,
        'taglen' => strlen($tag ?? ''),
    ];
}
