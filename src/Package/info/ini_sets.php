<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../info/finalize.php';
// @codeCoverageIgnoreEnd

/**
 * 複数の php.ini の設定をまとめて設定する
 *
 * 返り値として「もとに戻すためのクロージャ」を返すので、復元するためにはそのクロージャを呼ぶだけで良い。
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param array $values ini のエントリ名と値の配列
 * @return callable ini を元に戻す callable
 */
function ini_sets($values)
{
    $main = static function ($values) {
        $currents = [];
        foreach ($values as $name => $value) {
            $current = ini_set($name, $value);
            if ($current !== false) {
                $currents[$name] = $current;
            }
        }
        return $currents;
    };
    $currents = $main($values);
    return finalize(fn() => $main($currents));
}
