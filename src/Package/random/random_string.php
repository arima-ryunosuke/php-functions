<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 安全な乱数文字列を生成する
 *
 * @package ryunosuke\Functions\Package\random
 *
 * @param int $length 生成文字列長
 * @param string $charlist 使用する文字セット
 * @return string 乱数文字列
 */
function random_string($length = 8, $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    if ($length <= 0) {
        throw new \InvalidArgumentException('$length must be positive number.');
    }

    $charlength = strlen($charlist);
    if ($charlength === 0) {
        throw new \InvalidArgumentException('charlist is empty.');
    }

    $bytes = random_bytes($length);

    // 1文字1バイト使う。文字種によっては出現率に差が出るがう～ん
    $string = '';
    foreach (str_split($bytes) as $byte) {
        $string .= $charlist[ord($byte) % $charlength];
    }
    return $string;
}
