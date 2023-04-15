<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 条件付き throw
 *
 * 第1引数が true 相当のときに例外を投げる。
 *
 * Example:
 * ```php
 * // 投げない
 * throw_if(false, new \Exception());
 * // 投げる
 * try{throw_if(true, new \Exception());}catch(\Exception $ex){}
 * // クラス指定で投げる
 * try{throw_if(true, \Exception::class, 'message', 123);}catch(\Exception $ex){}
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param bool|mixed $flag true 相当値を与えると例外を投げる
 * @param \Exception|string $ex 投げる例外。クラス名の場合は中で new する
 * @param array $ex_args $ex にクラス名を与えたときの引数（可変引数）
 */
function throw_if($flag, $ex, ...$ex_args)
{
    if ($flag) {
        if (is_string($ex)) {
            $ex = new $ex(...$ex_args);
        }
        throw $ex;
    }
}
