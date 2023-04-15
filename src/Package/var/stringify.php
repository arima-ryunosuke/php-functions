<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/var_export2.php';
// @codeCoverageIgnoreEnd

/**
 * 値を何とかして文字列化する
 *
 * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 文字列化する値
 * @return string $var を文字列化したもの
 */
function stringify($var)
{
    $type = gettype($var);
    switch ($type) {
        case 'NULL':
            return 'null';
        case 'boolean':
            return $var ? 'true' : 'false';
        case 'array':
            return var_export2($var, true);
        case 'object':
            if (method_exists($var, '__toString')) {
                return (string) $var;
            }
            if (method_exists($var, '__serialize') || $var instanceof \Serializable) {
                return serialize($var);
            }
            if ($var instanceof \JsonSerializable) {
                return get_class($var) . ':' . json_encode($var, JSON_UNESCAPED_UNICODE);
            }
            return get_class($var);

        default:
            return (string) $var;
    }
}
