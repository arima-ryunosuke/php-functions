<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/dirname_r.php';
require_once __DIR__ . '/../utility/cacheobject.php';
// @codeCoverageIgnoreEnd

/**
 * vendor/autoload.php を返す
 *
 * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
 *
 * Example:
 * ```php
 * that(auto_loader())->contains('autoload.php');
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param ?string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
 * @return string autoload.php のフルパス
 */
function auto_loader($startdir = null)
{
    return cacheobject(__FUNCTION__)->hash($startdir, function () use ($startdir) {
        $cache = dirname_r($startdir ?: __DIR__, function ($dir) {
            if (file_exists($file = "$dir/autoload.php") || file_exists($file = "$dir/vendor/autoload.php")) {
                return $file;
            }
        });
        if (!$cache) {
            throw new \DomainException('autoloader is not found.');
        }
        return $cache;
    });
}
