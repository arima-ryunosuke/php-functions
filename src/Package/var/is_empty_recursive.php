<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * 値が空か再帰的に検査する
 *
 * `is_empty` の再帰版。
 *
 * クエリパラメータやオプション配列等で「実質値を持っていない」を判定したいことが稀によくある。
 * Example を参照。
 *
 * Example:
 * ```php
 * // このような値を空判定したい
 * that(is_empty_recursive([
 *     'query' => [
 *         'param1' => '',
 *         'param2' => '',
 *     ],
 *     'opt' => [
 *         'key1' => '',
 *         'key2' => null,
 *     ],
 * ]))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 判定する値
 * @param bool $empty_stdClass 空の stdClass を空とみなすか
 * @return bool 空なら true
 */
function is_empty_recursive($var, $empty_stdClass = false)
{
    // 見つかった時点で大域脱出するため例外を用いている
    $ex = new \Exception();
    try {
        $var = [$var];
        array_walk_recursive($var, function ($v) use ($ex, $empty_stdClass) {
            if ($empty_stdClass && is_object($v) && get_class($v) === 'stdClass') {
                if (!is_empty_recursive((array) $v, $empty_stdClass)) {
                    throw $ex;
                }
            }
            elseif (!is_empty($v, $empty_stdClass)) {
                throw $ex;
            }
        });
    }
    catch (\Exception $ex2) {
        if ($ex !== $ex2) {
            throw $ex2;
        }
        return false;
    }
    return true;
}
