<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/tmpname.php';
// @codeCoverageIgnoreEnd

/**
 * 文字列をリソース化する
 *
 * resource で統一的に扱いたいシチュエーションはまれによくある。
 *
 * Example:
 * ```php
 * // 文字列からリソースを作る
 * $resource = str_resource('hoge');
 * that(stream_get_contents($resource))->is('hoge');
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 */
function str_resource(
    /** 対象文字列 */ string $string,
    /** 最大メモリ */ ?int $maxmemory = null,
    /** 自動削除 */ bool $volatile = true,
) {
    // stream_get_meta_data でファイル情報が得られると便利なことが多いので 0 は maxmemory:0 ではなく tmpfile とする
    // さらに自動削除も制御したいので $volatile で分岐する
    $fp = match ($maxmemory) {
        0       => $volatile ? tmpfile() : fopen(tmpname('tmp', sys_get_temp_dir()), 'rb+'),
        null    => fopen("php://memory", 'rb+'),
        default => fopen("php://temp/maxmemory:$maxmemory", 'rb+'),
    };

    if ($fp === false) {
        throw new \UnexpectedValueException('fopen returned false'); // @codeCoverageIgnore
    }

    if (strlen($string)) {
        fwrite($fp, $string);
        rewind($fp);
    }

    return $fp;
}
