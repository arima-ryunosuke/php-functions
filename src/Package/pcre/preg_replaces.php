<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_arrayable.php';
// @codeCoverageIgnoreEnd

/**
 * パターン番号を指定して preg_replace する
 *
 * パターン番号を指定してそれのみを置換する。
 * 名前付きキャプチャを使用している場合はキーに文字列も使える。
 * 値にクロージャを渡した場合はコールバックされて置換される。
 *
 * $replacements に単一文字列を渡した場合、 `[1 => $replacements]` と等しくなる（第1キャプチャを置換）。
 *
 * Example:
 * ```php
 * // a と z に囲まれた数字を XXX に置換する
 * that(preg_replaces('#a(\d+)z#', [1 => 'XXX'], 'a123z'))->isSame('aXXXz');
 * // 名前付きキャプチャも指定できる
 * that(preg_replaces('#a(?<digit>\d+)z#', ['digit' => 'XXX'], 'a123z'))->isSame('aXXXz');
 * // クロージャを渡すと元文字列を引数としてコールバックされる
 * that(preg_replaces('#a(?<digit>\d+)z#', ['digit' => fn($src) => $src * 2], 'a123z'))->isSame('a246z');
 * // 複合的なサンプル（a タグの href と target 属性を書き換える）
 * that(preg_replaces('#<a\s+href="(?<href>.*)"\s+target="(?<target>.*)">#', [
 *     'href'   => fn($href) => strtoupper($href),
 *     'target' => fn($target) => strtoupper($target),
 * ], '<a href="hoge" target="fuga">inner text</a>'))->isSame('<a href="HOGE" target="FUGA">inner text</a>');
 * ```
 *
 * @package ryunosuke\Functions\Package\pcre
 *
 * @param string $pattern 正規表現
 * @param array|string|callable $replacements 置換文字列
 * @param string $subject 対象文字列
 * @param int $limit 置換回数
 * @param null $count 置換回数格納変数
 * @return string 置換された文字列
 */
function preg_replaces($pattern, $replacements, $subject, $limit = -1, &$count = null)
{
    $offset = 0;
    $count = 0;
    if (!is_arrayable($replacements)) {
        $replacements = [1 => $replacements];
    }

    preg_match_all($pattern, $subject, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
    foreach ($matches as $match) {
        if ($limit-- === 0) {
            break;
        }
        $count++;

        foreach ($match as $index => $m) {
            if ($m[1] >= 0 && $index !== 0 && isset($replacements[$index])) {
                $src = $m[0];
                $dst = $replacements[$index];
                if ($dst instanceof \Closure) {
                    $dst = $dst($src);
                }

                $srclen = strlen($src);
                $dstlen = strlen($dst);

                $subject = substr_replace($subject, $dst, $offset + $m[1], $srclen);
                $offset += $dstlen - $srclen;
            }
        }
    }
    return $subject;
}
