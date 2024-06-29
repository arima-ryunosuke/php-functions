<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/mb_monospace.php';
// @codeCoverageIgnoreEnd

/**
 * 文字列を指定文字幅で改行を挟み込む
 *
 * 基本的に wordwrap のマルチバイト対応版だと思って良い。
 * ただし下記の点が異なる。
 *
 * - マルチバイトは一律2文字換算
 *   - これ系の関数の「幅」はいわゆる半角/全角として扱ったほうが都合が良い
 * - $cut_long_words 引数はない
 *   - 用途的に true がデフォだろうし、マルチバイトが絡んでくると「単語」の定義がそもそも曖昧なので実装しない
 *   - 実装するにしても禁則処理の方が用途は多いだろう
 * - $break に null を与えると配列で返す
 *
 * Example:
 * ```php
 * that(mb_wordwrap("todayは晴天なり", 10, null))->is([
 *     'todayは晴',
 *     '天なり',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 分割する文字列
 * @param int $width 分割する最大幅
 * @param ?string $break 分割文字
 * @return string|array 指定幅で改行が差し込まれた文字列
 */
function mb_wordwrap(?string $string, $width, $break = "\n")
{
    $lines = mb_split('\\R', $string);

    $result = [];
    foreach ($lines as $line) {
        $chars = mb_str_split($line);
        $widths = array_map(fn($c) => mb_monospace($c), $chars);

        $sum = 0;
        $buffer = '';
        foreach ($widths as $n => $charwidth) {
            if ($sum + $charwidth > $width) {
                $result[] = $buffer;
                $sum = 0;
                $buffer = '';
            }

            $sum += $charwidth;
            $buffer .= $chars[$n];
        }
        $result[] = $buffer;
    }

    if ($break !== null) {
        $result = implode($break, $result);
    }

    return $result;
}
