<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../strings/str_quote.php';
// @codeCoverageIgnoreEnd

/**
 * 連想配列を paml 的文字列に変換する
 *
 * paml で出力することはまずないのでおまけ（import との対称性のために定義している）。
 *
 * Example:
 * ```php
 * that(paml_export([
 *     'n' => null,
 *     'f' => false,
 *     'i' => 123,
 *     'd' => 3.14,
 *     's' => 'this is string',
 * ]))->isSame('n: null, f: false, i: 123, d: 3.14, s: "this is string"');
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param array $pamlarray 配列
 * @param array $options オプション配列
 * @return string PAML 的文字列
 */
function paml_export($pamlarray, $options = [])
{
    $options += [
        'trailing-comma' => false,
        'pretty-space'   => true,
    ];

    $space = $options['pretty-space'] ? ' ' : '';

    $result = [];
    $n = 0;
    foreach ($pamlarray as $k => $v) {
        if (is_array($v)) {
            $inner = paml_export($v, $options);
            if (is_hasharray($v)) {
                $v = '{' . $inner . '}';
            }
            else {
                $v = '[' . $inner . ']';
            }
        }
        elseif ($v === null) {
            $v = 'null';
        }
        elseif ($v === false) {
            $v = 'false';
        }
        elseif ($v === true) {
            $v = 'true';
        }
        elseif (is_string($v)) {
            $v = str_quote($v);
        }

        if ($k === $n++) {
            $result[] = "$v";
        }
        else {
            $result[] = "$k:{$space}$v";
        }
    }
    return implode(",$space", $result) . ($options['trailing-comma'] ? ',' : '');
}
