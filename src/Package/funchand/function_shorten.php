<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 関数の名前空間部分を除いた短い名前を取得する
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param string $function 短くする関数名
 * @return string 短い関数名
 */
function function_shorten($function)
{
    $parts = explode('\\', $function);
    return array_pop($parts);
}
