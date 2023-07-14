<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/cipher_metadata.php';
// @codeCoverageIgnoreEnd

/**
 * 指定されたパスワードで復号化する
 *
 * $ciphers は配列で複数与えることができる。
 * 複数与えた場合、順に試みて複合できた段階でその値を返す。
 * v2 以降は生成文字列に $cipher が含まれているため指定不要（今後指定してはならない）。
 *
 * 復号に失敗すると null を返す。
 * 単体で使うことはないと思うので詳細は encrypt を参照。
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param string $cipherdata 復号化するデータ
 * @param string $password パスワード
 * @param string|array $ciphers 暗号化方式（openssl_get_cipher_methods で得られるもの）
 * @param string $tag 認証タグ
 * @return mixed 復号化されたデータ
 */
function decrypt($cipherdata, $password, $ciphers = 'aes-256-cbc', $tag = '')
{
    [$cipherdata, $version] = explode('=', $cipherdata, 2) + [1 => 0];
    $cipherdata = base64_decode(strtr($cipherdata, ['-' => '+', '_' => '/']));
    $version = (int) $version;

    if ($version === 2) {
        [$cipher, $ivtagpayload] = explode(':', $cipherdata, 2) + [1 => null];
        $metadata = cipher_metadata($cipher);
        if (!$metadata) {
            return null;
        }
        $iv = substr($ivtagpayload, 0, $metadata['ivlen']);
        $tag = substr($ivtagpayload, $metadata['ivlen'], $metadata['taglen']);
        $payload = substr($ivtagpayload, $metadata['ivlen'] + $metadata['taglen']);
        $tags = array_merge([$tag], (array) $ciphers); // for compatible
        foreach ($tags as $tag) {
            if ($metadata['taglen'] === strlen($tag)) {
                $decryptdata = openssl_decrypt($payload, $cipher, $password, OPENSSL_RAW_DATA, $iv, ...$metadata['taglen'] ? [$tag] : []);
                if ($decryptdata !== false) {
                    return json_decode(gzinflate($decryptdata), true);
                }
            }
        }
        return null;
    }

    foreach ((array) $ciphers as $c) {
        $ivlen = openssl_cipher_iv_length($c);
        if (strlen($cipherdata) <= $ivlen) {
            continue;
        }
        $iv = substr($cipherdata, 0, $ivlen);
        $payload = substr($cipherdata, $ivlen);

        $decryptdata = openssl_decrypt($payload, $c, $password, OPENSSL_RAW_DATA, $iv, $tag);
        if ($decryptdata !== false) {
            if ($version === 1) {
                $decryptdata = gzinflate($decryptdata);
            }
            return json_decode($decryptdata, true);
        }
    }
    return null;
}