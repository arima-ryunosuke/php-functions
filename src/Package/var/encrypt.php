<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/cipher_metadata.php';
// @codeCoverageIgnoreEnd

/**
 * 指定されたパスワードで暗号化する
 *
 * データは json を経由して base64（URL セーフ） して返す。
 * $tag を与えると認証タグが設定される。
 *
 * データ末尾には =v が付与される。
 * これによって処理が変わり、バージョン違いの暗号化文字列を与えたとしても複合することができる。
 *
 * - v0: バージョンのない無印。json -> encrypt -> base64
 * - v1: 上記に圧縮処理を加えたもの。json -> deflate -> encrypt -> base64
 * - v2: 生成文字列に $cipher, $iv, $tag を加えたもの。json -> deflate -> cipher+iv+tag+encrypt -> base64
 *
 * Example:
 * ```php
 * $plaindata = ['a', 'b', 'c'];
 * $encrypted = encrypt($plaindata, 'password');
 * $decrypted = decrypt($encrypted, 'password');
 * // 暗号化されて base64 の文字列になる
 * that($encrypted)->isString();
 * // 復号化されて元の配列になる
 * that($decrypted)->isSame(['a', 'b', 'c']);
 * // password が異なれば失敗して null を返す
 * that(decrypt($encrypted, 'invalid'))->isSame(null);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $plaindata 暗号化するデータ
 * @param string $password パスワード。十分な長さ、あるいは鍵導出関数を通した文字列でなければならない
 * @param string $cipher 暗号化方式（openssl_get_cipher_methods で得られるもの）
 * @param string $tag 認証タグ
 * @return string 暗号化された文字列
 */
function encrypt($plaindata, $password, $cipher = 'aes-256-gcm', &$tag = '')
{
    $jsondata = json_encode($plaindata, JSON_UNESCAPED_UNICODE);
    $zlibdata = gzdeflate($jsondata, 9);

    $metadata = cipher_metadata($cipher);
    if (!$metadata) {
        throw new \InvalidArgumentException("undefined cipher algorithm('$cipher')");
    }
    $iv = $metadata['ivlen'] ? random_bytes($metadata['ivlen']) : '';
    $payload = openssl_encrypt($zlibdata, $cipher, $password, OPENSSL_RAW_DATA, $iv, ...$metadata['taglen'] ? [&$tag] : []);

    return rtrim(strtr(base64_encode($cipher . ':' . $iv . $tag . $payload), ['+' => '-', '/' => '_']), '=') . '=2';
}
