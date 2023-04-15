<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * キャプチャを主軸においた preg_match
 *
 * $pattern で $subject をマッチングして $default で埋めて返す。$default はフィルタも兼ねる。
 * 空文字マッチは「マッチしていない」とみなすので注意（$default が使用される）。
 *
 * キャプチャを主軸においているので「マッチしなかった」は検出不可能。
 * $default がそのまま返ってくる。
 *
 * Example:
 * ```php
 * $pattern = '#(\d{4})/(\d{1,2})(/(\d{1,2}))?#';
 * $default = [1 => '2000', 2 => '1', 4 => '1'];
 * // 完全にマッチするのでそれぞれ返ってくる
 * that(preg_capture($pattern, '2014/12/24', $default))->isSame([1 => '2014', 2 => '12', 4 => '24']);
 * // 最後の \d{1,2} はマッチしないのでデフォルト値が使われる
 * that(preg_capture($pattern, '2014/12', $default))->isSame([1 => '2014', 2 => '12', 4 => '1']);
 * // 一切マッチしないので全てデフォルト値が使われる
 * that(preg_capture($pattern, 'hoge', $default))->isSame([1 => '2000', 2 => '1', 4 => '1']);
 * ```
 *
 * @package ryunosuke\Functions\Package\pcre
 *
 * @param string $pattern 正規表現
 * @param string $subject 対象文字列
 * @param array $default デフォルト値
 * @return array キャプチャした配列
 */
function preg_capture($pattern, $subject, $default)
{
    preg_match($pattern, $subject, $matches);

    foreach ($matches as $n => $match) {
        if (array_key_exists($n, $default) && strlen($match)) {
            $default[$n] = $match;
        }
    }

    return $default;
}
