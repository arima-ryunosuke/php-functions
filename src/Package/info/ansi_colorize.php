<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列に ANSI Color エスケープシーケンスを埋め込む
 *
 * - "blue" のような小文字色名は文字色
 * - "BLUE" のような大文字色名は背景色
 * - "bold" のようなスタイル名は装飾
 *
 * となる。その区切り文字は現在のところ厳密に定めていない（`fore+back|bold` のような形式で定めることも考えたけどメリットがない）。
 * つまり、アルファベット以外で分割するので、
 *
 * - `blue|WHITE@bold`: 文字青・背景白・太字
 * - `blue WHITE bold underscore`: 文字青・背景白・太字・下線
 * - `italic|bold,blue+WHITE  `: 文字青・背景白・太字・斜体
 *
 * という動作になる（記号で区切られていれば形式はどうでも良いということ）。
 * ただ、この指定方法は変更が入る可能性が高いのでスペースあたりで区切っておくのがもっとも無難。
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param string $string 対象文字列
 * @param string $color 色とスタイル文字列
 * @return string エスケープシーケンス付きの文字列
 */
function ansi_colorize($string, $color)
{
    // see https://en.wikipedia.org/wiki/ANSI_escape_code#SGR_parameters
    // see https://misc.flogisoft.com/bash/tip_colors_and_formatting
    $ansicodes = [
        // forecolor
        'default'    => [39, 39],
        'black'      => [30, 39],
        'red'        => [31, 39],
        'green'      => [32, 39],
        'yellow'     => [33, 39],
        'blue'       => [34, 39],
        'magenta'    => [35, 39],
        'cyan'       => [36, 39],
        'white'      => [97, 39],
        'gray'       => [90, 39],
        // backcolor
        'DEFAULT'    => [49, 49],
        'BLACK'      => [40, 49],
        'RED'        => [41, 49],
        'GREEN'      => [42, 49],
        'YELLOW'     => [43, 49],
        'BLUE'       => [44, 49],
        'MAGENTA'    => [45, 49],
        'CYAN'       => [46, 49],
        'WHITE'      => [47, 49],
        'GRAY'       => [100, 49],
        // style
        'bold'       => [1, 22],
        'faint'      => [2, 22], // not working ?
        'italic'     => [3, 23],
        'underscore' => [4, 24],
        'blink'      => [5, 25],
        'reverse'    => [7, 27],
        'conceal'    => [8, 28],
    ];

    $names = array_flip(preg_split('#[^a-z]#i', $color));
    $styles = array_intersect_key($ansicodes, $names);
    $setters = implode(';', array_column($styles, 0));
    $unsetters = implode(';', array_column($styles, 1));
    return "\033[{$setters}m{$string}\033[{$unsetters}m";
}
