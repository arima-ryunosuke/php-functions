<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * php-cli のパスを返す
 *
 * 見つからない場合は null を返す。
 * 実質的には PHP_BINARY と同じと考えてよい。
 * ただ PHP_BINARY は SAPI によって異なるので fpm 時にはこの関数を用いて php-cli のパスを得る必要がある。
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @return string|null php-cli のパス
 */
function php_binary()
{
    if (PHP_SAPI === 'cli' && !defined('PHPUNIT')) {
        return PHP_BINARY; // @codeCoverageIgnore
    }

    $phpdir = dirname(PHP_BINARY);
    $targets = ['php', 'php.exe', 'php.bat'];
    foreach ($targets as $target) {
        if (file_exists($bin = $phpdir . DIRECTORY_SEPARATOR . $target)) {
            return $bin;
        }
    }

    return null; // @codeCoverageIgnore
}
