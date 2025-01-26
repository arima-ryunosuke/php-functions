<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 本ライブラリの関数名を解決する
 *
 * ※ 内部向け
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param string $funcname 関数名
 * @return ?string FQSEN 名
 */
function function_resolve(string $funcname): ?string
{
    if (false
        // for class
        || (is_callable([__CLASS__, $funcname], false, $result))
        // for namespace
        || (is_callable(__NAMESPACE__ . "\\$funcname", false, $result))
        // for global
        || (is_callable($funcname, false, $result))
    ) {
        return $result;
    }
    return null;
}
