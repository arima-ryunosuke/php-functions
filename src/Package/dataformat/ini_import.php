<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * INI 的文字列を連想配列に変換する
 *
 * Example:
 * ```php
 * that(ini_import("
 * a = 1
 * b = 'B'
 * c = PHP_VERSION
 * "))->is(['a' => 1, 'b' => 'B', 'c' => PHP_VERSION]);
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param string $inistring ini 文字列
 * @param array $options オプション配列
 * @return array 配列
 */
function ini_import($inistring, $options = [])
{
    $options += [
        'process_sections' => false,
        'scanner_mode'     => INI_SCANNER_TYPED,
    ];

    return parse_ini_string($inistring, $options['process_sections'], $options['scanner_mode']);
}
