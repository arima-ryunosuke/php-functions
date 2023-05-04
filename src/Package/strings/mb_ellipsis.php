<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/mb_monospace.php';
// @codeCoverageIgnoreEnd

/**
 * 文字列を指定幅に丸める
 *
 * mb_strimwidth と機能的には同じだが、省略文字の差し込み位置を $pos で指定できる。
 * $pos は負数が指定できる。負数の場合後ろから数えられる。
 * 省略した場合は真ん中となる。
 *
 * Example:
 * ```php
 * // 10文字幅に丸める（$pos 省略なので真ん中が省略される）
 * that(mb_ellipsis('あいうえお1234567890', 10, '...'))->isSame('あい...890');
 * // 10文字幅に丸める（$pos=1 なので1幅目から省略される…が、1文字は「あ」なので前方に切られる）
 * that(mb_ellipsis('あいうえお1234567890', 10, '...', 1))->isSame('...567890');
 * // 10文字幅に丸める（$pos=2 なので2幅目から省略される）
 * that(mb_ellipsis('あいうえお1234567890', 10, '...', 2))->isSame('あ...67890');
 * // 10文字幅に丸める（$pos=-1 なので後ろから1幅目から省略される）
 * that(mb_ellipsis('あいうえお1234567890', 10, '...', -1))->isSame('あいう...0');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param int $width 丸める幅
 * @param string $trimmarker 省略文字列
 * @param int|null $pos 省略記号の差し込み位置
 * @return string 丸められた文字列
 */
function mb_ellipsis($string, $width, $trimmarker = '...', $pos = null)
{
    $string = (string) $string;

    $strwidth = mb_monospace($string);
    if ($strwidth <= $width) {
        return $string;
    }

    $markerwidth = mb_monospace($trimmarker);
    if ($markerwidth >= $width) {
        return $trimmarker;
    }

    $maxwidth = $width - $markerwidth;
    $pos ??= $maxwidth / 2;
    if ($pos < 0) {
        $pos += $maxwidth;
    }
    $pos = ceil(max(0, min($pos, $maxwidth)));
    $end = $pos + $strwidth - $maxwidth;

    $widths = array_map(fn($s) => mb_monospace($s), mb_str_split($string));
    $s = $e = null;
    $sum = 0;
    foreach ($widths as $n => $w) {
        $sum += $w;
        if (!isset($s) && $sum > $pos) {
            $s = $n;
        }
        if (!isset($e) && $sum >= $end) {
            $e = $n + 1;
        }
    }

    return mb_substr($string, 0, $s) . $trimmarker . mb_substr($string, $e);
}
