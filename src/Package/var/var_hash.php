<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../url/base64url_encode.php';
// @codeCoverageIgnoreEnd

/**
 * 値に複数のハッシュアルゴリズムを適用させて結合して返す
 *
 * $data は何らかの方法で文字列化される（この「何らかの方法」は互換性を担保しない）。
 * 文字長がかなり増えるため、 $base64 に true を与えるとバイナリ変換してその結果を base64（url セーフ）して返す。
 * さらに false を与えると 16進数文字列で返し、 null を与えるとバイナリ文字列で返す。
 *
 * Example:
 * ```php
 * // 配列をハッシュ化する
 * that(var_hash(['a', 'b', 'c']))->isSame('7BDgx6NE2hkXAKtKzhpeJm6-mheMOQWNgrCe7768OiFeoWgA');
 * // オブジェクトをハッシュ化する
 * that(var_hash(new \ArrayObject(['a', 'b', 'c'])))->isSame('-zR2rZ58CzuYhhdHn1Oq90zkYSaxMS-dHUbmb0MTRM4gBpj2');
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var ハッシュ化する値
 * @param string[] $algos ハッシュアルゴリズム
 * @param ?bool $base64 結果を base64 化するか
 * @return string ハッシュ文字列
 */
function var_hash($var, $algos = ['md5', 'sha1'], $base64 = true)
{
    if (!is_string($var)) {
        $var = serialize($var);
    }

    $algos = arrayize($algos);
    assert($algos);

    $hash = '';
    foreach ($algos as $algo) {
        $hash .= hash($algo, "$var", $base64 !== false);
    }

    if ($base64 !== true) {
        return $hash;
    }

    return base64url_encode($hash);
}
