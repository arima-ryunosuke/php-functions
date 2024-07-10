<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * クラスが use しているトレイトを再帰的に取得する
 *
 * トレイトが use しているトレイトが use しているトレイトが use している・・・のような場合もすべて返す。
 *
 * Example:
 * ```php
 * trait T1{}
 * trait T2{use T1;}
 * trait T3{use T2;}
 * that(class_uses_all(new class{use T3;}))->isSame([
 *     'Example\\T3' => 'Example\\T3', // クラスが直接 use している
 *     'Example\\T2' => 'Example\\T2', // T3 が use している
 *     'Example\\T1' => 'Example\\T1', // T2 が use している
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param string|object $class
 * @param bool $autoload オートロードを呼ぶか
 * @return array トレイト名の配列
 */
function class_uses_all($class, $autoload = true)
{
    static $cache = [];

    $cachekey = ltrim(is_object($class) ? get_class($class) : $class, '\\');

    if (isset($cache[$cachekey])) {
        return $cache[$cachekey];
    }

    // まずはクラス階層から取得
    $traits = [];
    do {
        $traits += array_fill_keys(class_uses($class, $autoload), false);
    } while ($class = get_parent_class($class));

    // そのそれぞれのトレイトに対してさらに再帰的に探す
    // 見つかったトレイトがさらに use している可能性もあるので「増えなくなるまで」 while ループして探す必要がある
    // （まずないと思うが）再帰的に use していることもあるかもしれないのでムダを省くためにチェック済みフラグを設けてある（ただ多分不要）
    $count = count($traits);
    while (true) {
        foreach ($traits as $trait => $checked) {
            if (!$checked) {
                $traits[$trait] = true;
                $traits += array_fill_keys(class_uses($trait, $autoload), false);
            }
        }
        if ($count === count($traits)) {
            break;
        }
        $count = count($traits);
    }

    $names = array_keys($traits);
    return $cache[$cachekey] = array_combine($names, $names);
}
