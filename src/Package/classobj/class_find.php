<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/class_map.php';
require_once __DIR__ . '/../classobj/class_namespace.php';
require_once __DIR__ . '/../classobj/type_exists.php';
// @codeCoverageIgnoreEnd

/**
 * 指定パターンに一致したクラス配列を返す
 *
 * 正味はただの class_map のラッパー。
 * クラス FQSEN をファイルシステムとみなして $pattern は glob パターンを指定する。
 * その際クラス名を渡すとその兄弟要素を返す。
 *
 * $filter には4種のタイプ名を bool で指定し、true にしたもののみ返される。
 * ただし enum は明示的に指定しない限り class とは見なされないので注意。
 *
 * @package ryunosuke\Functions\Package\classobj
 */
function class_find(
    /** @var string glob パターン */
    string         $pattern,
    /** @var \Closure|array フィルタ条件 */
    \Closure|array $filter = [
        'class'     => true,
        'interface' => true,
        'trait'     => true,
        'enum'      => true,
    ],
    /** キャッシュを使用するか */
    bool           $cache = true,
): /** [class] の配列 */ array
{
    $enum_support = function_exists('enum_exists');

    if (type_exists($pattern)) {
        $pattern = class_namespace($pattern) . "\\*";
    }
    $pattern = ltrim($pattern, '\\');

    $result = [];
    foreach (class_map(null, null, $cache) as $class => $file) {
        if (fnmatch($pattern, $class, FNM_NOESCAPE | FNM_CASEFOLD)) {
            if (is_array($filter)) {
                if (false
                    || ($filter['class'] ?? false) && class_exists($class) && (!$enum_support || !enum_exists($class))
                    || ($filter['interface'] ?? false) && interface_exists($class)
                    || ($filter['trait'] ?? false) && trait_exists($class)
                    || $enum_support && ($filter['enum'] ?? false) && enum_exists($class) // @codeCoverageIgnore for php<8.1
                ) {
                    $result[] = $class;
                }
            }
            else {
                if ($filter($class, $file)) {
                    $result[] = $class;
                }
            }
        }
    }
    return $result;
}
