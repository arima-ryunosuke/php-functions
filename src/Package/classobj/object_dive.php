<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * パス形式でプロパティ値を取得
 *
 * 存在しない場合は $default を返す。
 *
 * Example:
 * ```php
 * $class = (object) [
 *     'a' => (object) [
 *         'b' => (object) [
 *             'c' => 'vvv'
 *         ]
 *     ]
 * ];
 * that(object_dive($class, 'a.b.c'))->isSame('vvv');
 * that(object_dive($class, 'a.b.x', 9))->isSame(9);
 * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
 * that(object_dive($class, ['a', 'b', 'c']))->isSame('vvv');
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param object $object 調べるオブジェクト
 * @param string|array $path パス文字列。配列も与えられる
 * @param mixed $default 無かった場合のデフォルト値
 * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
 * @return mixed パスが示すプロパティ値
 */
function object_dive($object, $path, $default = null, $delimiter = '.')
{
    $keys = is_array($path) ? $path : explode($delimiter, $path);
    foreach ($keys as $key) {
        if (!isset($object->$key)) {
            return $default;
        }
        $object = $object->$key;
    }
    return $object;
}
