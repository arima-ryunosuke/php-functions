<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ASCII 文字を1, それ以外を2で計算した文字幅を返す
 *
 * mb_strwidth は記号も1で返すので若干使いづらい（仕様的にしょうがない）。
 * 日本語圏内であれば記号や絵文字も2バイト換算の方が便利なことが多いのでそのようにしたもの。
 *
 * オプションでコードポイント配列を渡すとそれに従って幅を加算する。
 * コードポイントの指定は Example を参照。
 *
 * Example:
 * ```php
 * that(mb_monospace("※★▼…"))->is(8);     // 記号類も2バイト換算で8
 * that(mb_monospace("123456７8８"))->is(11); // 比較用（フォントに依存するが）
 * that(mb_monospace("Σ(ﾟДﾟ)え!！"))->is(15); // 半角全角の判定ではなく ASCII 判定なので 15
 * that(mb_monospace("Σ(ﾟДﾟ)え!！", [         // コードポイントを指定すれば合わせることが可能
 *     "Σ"    => 1, // 単体指定（シグマ）
 *     "Ѐ-ӿ"  => 1, // 範囲指定（キリル文字）
 *     0xFF9F => 1, // 直指定（半角半濁点）
 * ]))->is(11);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param array $codepoints コードポイント配列
 * @return int 等幅の文字幅
 */
function mb_monospace($string, $codepoints = [])
{
    $widthmap = [];
    foreach ($codepoints as $codepoint => $width) {
        // 数値あるいは数値に準ずる値（intval がややこしくなるのでコードポイント 0 は考慮しない）
        if (is_int($codepoint) || intval($codepoint, 0) !== 0) {
            $widthmap[mb_chr(intval($codepoint, 0))] = $width;
        }
        // 文字列あるいは - による範囲指定
        else {
            // mb_ereg_search_regs が使いにくすぎるので callback で代用している
            $pairs = [];
            $codepoint = mb_ereg_replace_callback('([^-])\-([^-])', function ($m) use (&$pairs) {
                $pairs[] = [mb_ord($m[1]), mb_ord($m[2])];
                return '';
            }, $codepoint);
            foreach ($pairs as [$s, $e]) {
                for ($i = $s; $i <= $e; $i++) {
                    $widthmap[mb_chr($i)] = $width;
                }
            }
            foreach (mb_str_split($codepoint) as $char) {
                $widthmap[$char] = $width;
            }
        }
    }

    $width = 0;
    foreach (mb_str_split($string) as $char) {
        if (isset($widthmap[$char])) {
            $width += $widthmap[$char];
        }
        elseif (strlen($char) === 1) {
            $width += 1;
        }
        else {
            $width += 2;
        }
    }
    return $width;
}
