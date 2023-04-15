<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * キャプチャも行える preg_replace
 *
 * 「置換を行いつつ、キャプチャ文字列が欲しい」状況はまれによくあるはず。
 *
 * $replacement に callable を渡すと preg_replace_callback がコールされる。
 * callable とはいっても単純文字列 callble （"strtoupper" など）は callable とはみなされない。
 * 配列形式の callable や クロージャのみ preg_replace_callback になる。
 *
 * Example:
 * ```php
 * // 数字を除去しつつその除去された数字を得る
 * that(preg_splice('#\\d+#', '', 'abc123', $m))->isSame('abc');
 * that($m)->isSame(['123']);
 *
 * // callable だと preg_replace_callback が呼ばれる
 * that(preg_splice('#[a-z]+#', fn($m) => strtoupper($m[0]), 'abc123', $m))->isSame('ABC123');
 * that($m)->isSame(['abc']);
 *
 * // ただし、 文字列 callable は文字列として扱う
 * that(preg_splice('#[a-z]+#', 'strtoupper', 'abc123', $m))->isSame('strtoupper123');
 * that($m)->isSame(['abc']);
 * ```
 *
 * @package ryunosuke\Functions\Package\pcre
 *
 * @param string $pattern 正規表現
 * @param string|callable $replacement 置換文字列
 * @param string $subject 対象文字列
 * @param array $matches キャプチャ配列が格納される
 * @return string 置換された文字列
 */
function preg_splice($pattern, $replacement, $subject, &$matches = [])
{
    if (preg_match($pattern, $subject, $matches)) {
        if (!is_string($replacement) && is_callable($replacement)) {
            $subject = preg_replace_callback($pattern, $replacement, $subject);
        }
        else {
            $subject = preg_replace($pattern, $replacement, $subject);
        }
    }
    return $subject;
}
