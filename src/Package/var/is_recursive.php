<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_primitive.php';
// @codeCoverageIgnoreEnd

/**
 * 変数が再帰参照を含むか調べる
 *
 * Example:
 * ```php
 * // 配列の再帰
 * $array = [];
 * $array['recursive'] = &$array;
 * that(is_recursive($array))->isTrue();
 * // オブジェクトの再帰
 * $object = new \stdClass();
 * $object->recursive = $object;
 * that(is_recursive($object))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 調べる値
 * @return bool 再帰参照を含むなら true
 */
function is_recursive($var)
{
    $core = function ($var, $parents) use (&$core) {
        // 複合型でないなら間違いなく false
        if (is_primitive($var)) {
            return false;
        }

        // 「親と同じ子」は再帰以外あり得ない。よって === で良い（オブジェクトに関してはそもそも等値比較で絶対に一致しない）
        // sql_object_hash とか serialize でキーに保持して isset の方が速いか？
        // → ベンチ取ったところ in_array の方が10倍くらい速い。多分生成コストに起因
        // raw な比較であれば瞬時に比較できるが、isset だと文字列化が必要でかなり無駄が生じていると考えられる
        foreach ($parents as $parent) {
            if ($parent === $var) {
                return true;
            }
        }

        // 全要素を再帰的にチェック
        $parents[] = $var;
        foreach ($var as $v) {
            if ($core($v, $parents)) {
                return true;
            }
        }
        return false;
    };
    return $core($var, []);
}
