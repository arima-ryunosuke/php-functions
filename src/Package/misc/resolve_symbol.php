<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/parse_namespace.php';
// @codeCoverageIgnoreEnd

/**
 * エイリアス名を完全修飾名に解決する
 *
 * 例えばあるファイルのある名前空間で `use Hoge\Fuga\Piyo;` してるときの `Piyo` を `Hoge\Fuga\Piyo` に解決する。
 *
 * Example:
 * ```php
 * // このような php ファイルがあるとして・・・
 * file_set_contents(sys_get_temp_dir() . '/symbol.php', '
 * <?php
 * namespace vendor\NS;
 *
 * use ArrayObject as AO;
 * use function strlen as SL;
 *
 * function InnerFunc(){}
 * class InnerClass{}
 * ');
 * // 下記のように解決される
 * that(resolve_symbol('AO', sys_get_temp_dir() . '/symbol.php'))->isSame('ArrayObject');
 * that(resolve_symbol('SL', sys_get_temp_dir() . '/symbol.php'))->isSame('strlen');
 * that(resolve_symbol('InnerFunc', sys_get_temp_dir() . '/symbol.php'))->isSame('vendor\\NS\\InnerFunc');
 * that(resolve_symbol('InnerClass', sys_get_temp_dir() . '/symbol.php'))->isSame('vendor\\NS\\InnerClass');
 * ```
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string $shortname エイリアス名
 * @param string|array $nsfiles ファイル名 or [ファイル名 => 名前空間名]
 * @param array $targets エイリアスタイプ（'const', 'function', 'alias' のいずれか）
 * @return string|null 完全修飾名。解決できなかった場合は null
 */
function resolve_symbol(string $shortname, $nsfiles, $targets = ['const', 'function', 'alias'])
{
    // 既に完全修飾されている場合は何もしない
    if (($shortname[0] ?? null) === '\\') {
        return $shortname;
    }

    // use Inner\Space のような名前空間の use の場合を考慮する
    $parts = explode('\\', $shortname, 2);
    $prefix = isset($parts[1]) ? array_shift($parts) : null;

    if (is_string($nsfiles)) {
        $nsfiles = [$nsfiles => []];
    }

    $targets = (array) $targets;
    foreach ($nsfiles as $filename => $namespaces) {
        $namespaces = array_flip(array_map(fn($n) => trim($n, '\\'), (array) $namespaces));
        foreach (parse_namespace($filename) as $namespace => $ns) {
            /** @noinspection PhpIllegalArrayKeyTypeInspection */
            if (!$namespaces || isset($namespaces[$namespace])) {
                if (isset($ns['alias'][$prefix])) {
                    return $ns['alias'][$prefix] . '\\' . implode('\\', $parts);
                }
                foreach ($targets as $target) {
                    if (isset($ns[$target][$shortname])) {
                        return $ns[$target][$shortname];
                    }
                }
            }
        }
    }
    return null;
}
