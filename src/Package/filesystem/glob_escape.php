<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * glob パターンのエスケープ
 *
 * preg_quote のようにメタ文字を含む文字列自体を glob にマッチさせたい場合に使用する。
 * ただし、現在手抜き実装である（glob は環境差異が激しすぎて正確な実装ができない）。
 *
 * @package ryunosuke\Functions\Package\filesystem
 */
function glob_escape(string $pattern, int $flags = 0): string
{
    $GLOB_BRACE = $flags & GLOB_BRACE;
    $GLOB_NOESCAPE = $flags & GLOB_NOESCAPE;

    // glob のエスケープは []
    $charactors = [
        '?' => '[?]',
        '*' => '[*]',
        '[' => '[[]',
        ']' => '[]]',
    ];

    // ただし BRACE だけはバックスラッシュ（posix のみ）
    if ($GLOB_BRACE) {
        $charactors = array_replace($charactors, [
            '{' => '\\{',
            '}' => '\\}',
        ]);
    }

    // 手抜きポイント（GLOB_BRACE+GLOB_NOESCAPE の組み合わせが考慮されていない）
    if (!$GLOB_NOESCAPE) {
        $charactors = array_replace($charactors, [
            '\\' => '\\\\',
        ]);
    }

    return strtr($pattern, $charactors);
}
