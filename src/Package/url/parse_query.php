<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * parse_str の返り値版
 *
 * 標準の parse_str は参照で受ける謎シグネチャなのでそれを返り値に変更したもの。
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param string $query クエリ文字列
 * @return array クエリのパース結果配列
 */
function parse_query($query)
{
    parse_str($query, $result);
    return $result;
}
