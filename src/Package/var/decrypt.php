<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../url/base64url_decode.php';
require_once __DIR__ . '/../var/cipher_metadata.php';
// @codeCoverageIgnoreEnd

/**
 * 指定されたパスワードで復号化する
 *
 * $password は配列で複数与えることができる。
 * 複数与えた場合、順に試みて複合できた段階でその値を返す。
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
 * @param string|array $password パスワード
 * @param string|array $ciphers 暗号化方式（openssl_get_cipher_methods で得られるもの）
 * @param string $tag 認証タグ
 * @return mixed 復号化されたデータ
 */
function decrypt($cipherdata, $password, $ciphers = 'aes-256-cbc', $tag = '')
{
    $version = $cipherdata[-1] ?? '';
    $cipherdata = base64url_decode(substr($cipherdata, 0, -1));

    if ($version === "4") {
        $cipher = 'aes-256-gcm';
        $metadata = cipher_metadata($cipher);
        $payload = substr($cipherdata, 0, -($metadata['taglen'] + $metadata['ivlen']));
        $tag = substr($cipherdata, strlen($payload), $metadata['taglen']);
        $iv = substr($cipherdata, -$metadata['ivlen']);
        foreach ((array) $password as $pass) {
            $pass = hash_hkdf('sha256', $pass, $metadata['keylen']);
            $decryptdata = openssl_decrypt($payload, $cipher, $pass, OPENSSL_RAW_DATA, str_pad($iv, $metadata['ivlen'], "\0"), $tag);
            if ($decryptdata !== false) {
                return json_decode(gzinflate($decryptdata), true);
            }
        }
        return null;
    }

    if ($version === "3") {
        $cp = strrpos($cipherdata, ':');
        $ivtagpayload = substr($cipherdata, 0, $cp);
        $cipher = substr($cipherdata, $cp + 1);
        $metadata = cipher_metadata($cipher);
        if (!$metadata) {
            return null;
        }
        $tag = substr($ivtagpayload, 0, $metadata['taglen']);
        $iv = substr($ivtagpayload, $metadata['taglen'], $metadata['ivlen']);
        $payload = substr($ivtagpayload, $metadata['ivlen'] + $metadata['taglen']);
        foreach ((array) $password as $pass) {
            $decryptdata = openssl_decrypt($payload, $cipher, $pass, OPENSSL_RAW_DATA, $iv, $tag);
            if ($decryptdata !== false) {
                return json_decode(gzinflate($decryptdata), true);
            }
        }
        return null;
    }

    if ($version === "2") {
        [$cipher, $ivtagpayload] = explode(':', $cipherdata, 2) + [1 => null];
        $metadata = cipher_metadata($cipher);
        if (!$metadata) {
            return null;
        }
        $iv = substr($ivtagpayload, 0, $metadata['ivlen']);
        $tag = substr($ivtagpayload, $metadata['ivlen'], $metadata['taglen']);
        $payload = substr($ivtagpayload, $metadata['ivlen'] + $metadata['taglen']);
        $tags = array_merge([$tag], (array) $ciphers);
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

    if ($version === "1") {
        foreach ((array) $ciphers as $c) {
            $ivlen = openssl_cipher_iv_length($c);
            if (strlen($cipherdata) <= $ivlen) {
                continue;
            }
            $iv = substr($cipherdata, 0, $ivlen);
            $payload = substr($cipherdata, $ivlen);

            $decryptdata = openssl_decrypt($payload, $c, $password, OPENSSL_RAW_DATA, $iv, $tag);
            if ($decryptdata !== false) {
                $decryptdata = gzinflate($decryptdata);
                return json_decode($decryptdata, true);
            }
        }
    }
    return null;
}
