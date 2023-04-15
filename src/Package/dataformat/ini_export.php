<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_sprintf.php';
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../var/var_export2.php';
// @codeCoverageIgnoreEnd

/**
 * 連想配列を INI 的文字列に変換する
 *
 * Example:
 * ```php
 * that(ini_export(['a' => 1, 'b' => 'B', 'c' => PHP_SAPI]))->is('a = 1
 * b = "B"
 * c = "cli"
 * ');
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param array $iniarray ini 化する配列
 * @param array $options オプション配列
 * @return string ini 文字列
 */
function ini_export($iniarray, $options = [])
{
    $options += [
        'process_sections' => false,
        'alignment'        => true,
    ];

    $generate = function ($array, $key = null) use (&$generate, $options) {
        $ishasharray = is_array($array) && is_hasharray($array);
        return array_sprintf($array, function ($v, $k) use ($generate, $key, $ishasharray) {
            if (is_iterable($v)) {
                return $generate($v, $k);
            }

            if ($key === null) {
                return $k . ' = ' . var_export2($v, true);
            }
            return ($ishasharray ? "{$key}[$k]" : "{$key}[]") . ' = ' . var_export2($v, true);
        }, "\n");
    };

    if ($options['process_sections']) {
        return array_sprintf($iniarray, fn($v, $k) => "[$k]\n{$generate($v)}\n", "\n");
    }

    return $generate($iniarray) . "\n";
}
