<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../outcontrol/ob_include.php';
require_once __DIR__ . '/../stream/memory_stream.php';
// @codeCoverageIgnoreEnd

/**
 * 変数を extract して include する（文字列指定）
 *
 * @package ryunosuke\Functions\Package\strings
 * @see ob_include()
 *
 * @param string $template テンプレート文字列
 * @param array $array extract される連想変数
 * @return string レンダリングされた文字列
 */
function include_string($template, $array = [])
{
    // opcache が効かない気がする
    $path = memory_stream(__FUNCTION__);
    file_put_contents($path, $template);
    $result = ob_include($path, $array);
    unlink($path);
    return $result;
}
