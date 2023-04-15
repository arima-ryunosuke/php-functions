<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 複数の php.ini の設定をまとめて設定する
 *
 * 返り値として「もとに戻すためのクロージャ」を返すので、復元するためにはそのクロージャを呼ぶだけで良い。
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param array $values ini のエントリ名と値の配列
 * @return callable ini を元に戻すクロージャ
 */
function ini_sets($values)
{
    $currents = [];
    foreach ($values as $name => $value) {
        $current = ini_set($name, $value);
        if ($current !== false) {
            $currents[$name] = $current;
        }
    }
    return static function () use ($currents) {
        ini_sets($currents);
        return $currents;
    };
}
