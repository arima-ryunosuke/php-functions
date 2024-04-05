<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/unique_id.php';
require_once __DIR__ . '/../var/cipher_metadata.php';
// @codeCoverageIgnoreEnd

/**
 * 指定されたパスワードで暗号化する
 *
 * データは json を経由して base64（URL セーフ） して返す。
 *
 * $tag を与えると認証タグが設定される（非推奨）。
 * $cipher で暗号化メソッドを指定できる（非推奨）。
 * v4 から $cipher は aes-256-gcm 決め打ち、結果に $tag が含まれるようになったので引数は2つだけを推奨。
 * 要するに sodium_crypto_aead_aes256gcm_encrypt+iv と等しくなった。
 *
 * $password は配列で複数与えることができる。
 * 複数与えた場合、先頭の要素が使用される。
 * これは decrypt との親和性のため（password の変更・移行期間は複数を扱いたいことがある）であり、決して「複数のパスワード対応」ではない。
 *
 * データ末尾には v が付与される。
 * これによって処理が変わり、バージョン違いの暗号化文字列を与えたとしても複合することができる。
 *
 * - v0: バージョンのない無印。json -> encrypt -> base64
 * - v1: 上記に圧縮処理を加えたもの。json -> deflate -> encrypt -> base64
 * - v2: 生成文字列に $cipher, $iv, $tag を加えたもの。json -> deflate -> cipher+iv+tag+encrypt -> base64
 * - v3: 生成文字列に $iv, $tag, $cipher を加えたもの。json -> deflate -> encrypt+cipher+iv+tag -> base64
 * - v4: 生成文字列に $tag, $iv を加えたもの。json -> deflate -> encrypt+tag+iv -> base64
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
 * @param string|array $password パスワード。十分な長さでなければならない
 * @param string $cipher 暗号化方式（openssl_get_cipher_methods で得られるもの）
 * @param string $tag 認証タグ
 * @return string 暗号化された文字列
 */
function encrypt($plaindata, $password, $cipher = null, &$tag = '')
{
    $original_cipher = $cipher;
    $cipher ??= 'aes-256-gcm';
    $metadata = cipher_metadata($cipher);
    if (!$metadata) {
        throw new \InvalidArgumentException("undefined cipher algorithm('$cipher')");
    }

    $jsondata = json_encode($plaindata, JSON_UNESCAPED_UNICODE);
    $zlibdata = gzdeflate($jsondata, 9);

    $iv = '';
    if ($metadata['ivlen']) {
        $iv = unique_id();
        $rest = $metadata['ivlen'] - strlen($iv);
        if ($rest) {
            $iv = random_bytes($rest) . $iv;
        }
    }
    if ($original_cipher === null) {
        $password = hash_hkdf('sha256', is_array($password) ? reset($password) : $password, $metadata['keylen']);
    }
    $payload = openssl_encrypt($zlibdata, $cipher, $password, OPENSSL_RAW_DATA, $iv, ...$metadata['taglen'] ? [&$tag] : []);

    if ($original_cipher === null) {
        return rtrim(strtr(base64_encode($payload . $tag . $iv), ['+' => '-', '/' => '_']), '=') . '4';
    }
    else {
        return rtrim(strtr(base64_encode($tag . $iv . $payload . ':' . $cipher), ['+' => '-', '/' => '_']), '=') . '3';
    }
}
