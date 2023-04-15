<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * 本ライブラリで使用するキャッシュディレクトリを設定する
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @deprecated use function_configure
 */
function cachedir($dirname = null)
{
    return function_configure(['cachedir' => $dirname])['cachedir'];
}
