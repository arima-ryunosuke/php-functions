<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/auto_loader.php';
// @codeCoverageIgnoreEnd

/**
 * composer のクラスローダを返す
 *
 * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
 *
 * Example:
 * ```php
 * that(class_loader())->isInstanceOf(\Composer\Autoload\ClassLoader::class);
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param ?string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
 * @return \Composer\Autoload\ClassLoader クラスローダ
 */
function class_loader($startdir = null)
{
    return require auto_loader($startdir);
}
