<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 特定条件までのバックトレースを取得する
 *
 * 第2引数 $options を満たすトレース以降を返す。
 * $options は ['$trace の key' => "条件"] を渡す。
 * 条件は文字列かクロージャで、文字列の場合は緩い一致、クロージャの場合は true を返した場合にそれ以降を返す。
 *
 * Example:
 * ```php
 * function f001 () {return backtrace(0, ['function' => __NAMESPACE__ . '\\f002', 'limit' => 2]);}
 * function f002 () {return f001();}
 * function f003 () {return f002();}
 * $traces = f003();
 * // limit 指定してるので2個
 * that($traces)->count(2);
 * // 「function が f002 以降」を返す
 * that($traces[0])->subsetEquals([
 *     'function' => __NAMESPACE__ . '\\f002'
 * ]);
 * that($traces[1])->subsetEquals([
 *     'function' => __NAMESPACE__ . '\\f003'
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\errorfunc
 *
 * @param int $flags debug_backtrace の引数
 * @param array $options フィルタ条件
 * @return array バックトレース
 */
function backtrace($flags = \DEBUG_BACKTRACE_PROVIDE_OBJECT, $options = [])
{
    $result = [];
    $traces = debug_backtrace($flags);
    foreach ($traces as $n => $trace) {
        foreach ($options as $key => $val) {
            if (!isset($trace[$key])) {
                continue;
            }

            if ($val instanceof \Closure) {
                $break = $val($trace[$key]);
            }
            else {
                $break = $trace[$key] == $val;
            }
            if ($break) {
                $result = array_slice($traces, $n);
                break 2;
            }
        }
    }

    // offset, limit は特別扱いで千切り指定
    if (isset($options['offset']) || isset($options['limit'])) {
        $result = array_slice($result, $options['offset'] ?? 0, $options['limit'] ?? count($result));
    }

    return $result;
}
