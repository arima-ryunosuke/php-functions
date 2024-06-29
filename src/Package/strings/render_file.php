<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/render_string.php';
// @codeCoverageIgnoreEnd

/**
 * "hoge {$hoge}" 形式のレンダリングのファイル版
 *
 * @package ryunosuke\Functions\Package\strings
 * @see render_string()
 *
 * @param string $template_file レンダリングするファイル名
 * @param array $array レンダリング変数
 * @return string レンダリングされた文字列
 */
function render_file(?string $template_file, $array)
{
    return render_string(file_get_contents($template_file), $array);
}
