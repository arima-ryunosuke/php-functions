<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * 条件を満たしたときにコールバックを実行する
 *
 * `if ($condition) $callable(...$arguments);` と（$condition はクロージャを受け入れるけど）ほぼ同じ。
 * ただし、 $condition に数値を与えると「指定回数呼ばれたあとに実行する」という意味になる。
 * 主に「ループ内でデバッグ出力したいけど、毎回だと少しうざい」というデバッグ用途。
 *
 * $condition が正数だと「指定回数呼ばれた次のみ」負数だと「指定回数呼ばれた次以降」実行される。
 * 0 のときは無条件で実行される。
 *
 * Example:
 * ```php
 * $output = [];
 * $debug_print = function ($debug) use (&$output) { $output[] = $debug; };
 * for ($i=0; $i<4; $i++) {
 *     call_if($i == 1, $debug_print, '$i == 1のとき呼ばれた');
 *     call_if(2, $debug_print, '2回呼ばれた');
 *     call_if(-2, $debug_print, '2回以上呼ばれた');
 * }
 * that($output)->isSame([
 *     '$i == 1のとき呼ばれた',
 *     '2回呼ばれた',
 *     '2回以上呼ばれた',
 *     '2回以上呼ばれた',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param mixed $condition 呼ばれる条件
 * @param callable $callable 呼ばれる処理
 * @param mixed ...$arguments $callable の引数（可変引数）
 * @return mixed 呼ばれた場合は $callable の返り値
 */
function call_if($condition, $callable, ...$arguments)
{
    // 数値の場合はかなり特殊な動きになる
    if (is_int($condition)) {
        static $counts = [];
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $caller = $trace['file'] . '#' . $trace['line'];
        $counts[$caller] ??= 0;
        if ($condition === 0) {
            $condition = true;
        }
        elseif ($condition > 0) {
            $condition = $condition === $counts[$caller]++;
        }
        else {
            $condition = -$condition <= $counts[$caller]++;
        }
    }
    elseif (is_callable($condition)) {
        $condition = (func_user_func_array($condition))();
    }

    if ($condition) {
        return $callable(...$arguments);
    }
    return null;
}
